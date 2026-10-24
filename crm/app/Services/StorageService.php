<?php
declare(strict_types=1);

namespace CRM\Services;

use PDO;
use PDOException;
use CRMEnv;

require_once dirname(__DIR__, 2) . '/config/config.php';

/**
 * StorageService
 * Primary storage: MySQL Database (codex404_db).
 * Thread-safe with request-scoped memory caching.
 * Gracefully falls back to local JSON store if MySQL is ever offline.
 */
class StorageService
{
    private static string $dataDir = '';
    private static ?PDO $pdo = null;
    private static bool $pdoTested = false;
    private static array $cache = [];

    private static array $tableMap = [
        'leads' => 'leads',
        'opportunities' => 'opportunities',
        'projects' => 'crm_projects',
        'approvals' => 'approvals',
        'paperclip_tasks' => 'paperclip_tasks',
        'currency_rates' => 'currency_rates',
        'rates_cache' => 'currency_rates',
        'users' => 'users',
        'roles' => 'roles',
        'permissions' => 'permissions',
        'approval_rules' => 'approval_rules',
        'audit_logs' => 'audit_logs'
    ];

    public static function init(string $storagePath): void
    {
        self::$dataDir = $storagePath . '/data';
        if (!is_dir(self::$dataDir)) {
            @mkdir(self::$dataDir, 0755, true);
        }
    }

    public static function getPdo(): ?PDO
    {
        if (self::$pdoTested) {
            return self::$pdo;
        }
        self::$pdoTested = true;

        $host = CRMEnv::get('DB_HOST', 'localhost');
        $port = (int)CRMEnv::get('DB_PORT', '3306');
        $dbName = CRMEnv::get('DB_NAME', 'codex404_db');
        $user = CRMEnv::get('DB_USER', 'admin');
        $pass = CRMEnv::get('DB_PASS', 'admin@1234');

        try {
            self::$pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbName};charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_TIMEOUT => 2
            ]);
        } catch (PDOException $e) {
            // Try root fallback if admin user hasn't connected
            try {
                self::$pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbName};charset=utf8mb4", 'root', '', [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_TIMEOUT => 2
                ]);
            } catch (PDOException $e2) {
                self::$pdo = null;
            }
        }

        return self::$pdo;
    }

    private static function getTableName(string $collection): ?string
    {
        $clean = str_replace('.json', '', $collection);
        return self::$tableMap[$clean] ?? null;
    }

    public static function read(string $collection): array
    {
        $clean = str_replace('.json', '', $collection);
        if (isset(self::$cache[$clean])) {
            return self::$cache[$clean];
        }

        $pdo = self::getPdo();
        $table = self::getTableName($clean);

        if ($pdo && $table) {
            try {
                $stmt = $pdo->query("SELECT * FROM `{$table}`");
                $rows = $stmt->fetchAll();
                
                // Post-process JSON fields
                foreach ($rows as &$row) {
                    if (isset($row['milestones']) && is_string($row['milestones'])) {
                        $row['milestones'] = json_decode($row['milestones'], true) ?: [];
                    }
                    if (isset($row['payload']) && is_string($row['payload'])) {
                        $row['payload'] = json_decode($row['payload'], true) ?: [];
                    }
                    if (isset($row['input_data']) && is_string($row['input_data'])) {
                        $row['input_data'] = json_decode($row['input_data'], true) ?: [];
                        $row['input'] = $row['input_data'];
                    }
                    if (isset($row['output_data']) && is_string($row['output_data'])) {
                        $row['output_data'] = json_decode($row['output_data'], true) ?: [];
                        $row['output'] = $row['output_data'];
                    }
                    if (isset($row['rates']) && is_string($row['rates'])) {
                        $row['rates'] = json_decode($row['rates'], true) ?: [];
                    }
                    if (isset($row['custom_permissions']) && is_string($row['custom_permissions'])) {
                        $row['custom_permissions'] = json_decode($row['custom_permissions'], true) ?: ['granted' => [], 'denied' => []];
                    }
                    if (isset($row['roles']) && is_string($row['roles'])) {
                        $row['roles'] = json_decode($row['roles'], true) ?: [];
                    }
                }
                unset($row);

                if ($table === 'currency_rates' && !empty($rows)) {
                    $first = $rows[0];
                    self::$cache[$clean] = $first;
                    return $first;
                }

                self::$cache[$clean] = $rows;
                return $rows;
            } catch (\Throwable $e) {
                // Fall through to JSON fallback
            }
        }

        // File-backed fallback
        $file = self::$dataDir . '/' . $clean . '.json';
        if (!file_exists($file)) {
            return [];
        }
        $content = @file_get_contents($file);
        if (!$content) {
            return [];
        }
        $data = json_decode($content, true);
        $result = is_array($data) ? $data : [];
        self::$cache[$clean] = $result;
        return $result;
    }

    public static function write(string $collection, array $records): bool
    {
        $clean = str_replace('.json', '', $collection);
        self::$cache[$clean] = $records;

        $pdo = self::getPdo();
        $table = self::getTableName($clean);

        if ($pdo && $table) {
            try {
                if ($table === 'currency_rates') {
                    $stmt = $pdo->prepare("
                        INSERT INTO `currency_rates` (`id`, `rates`, `updated_at`)
                        VALUES ('rates', :rates, :updated_at)
                        ON DUPLICATE KEY UPDATE `rates` = VALUES(`rates`), `updated_at` = VALUES(`updated_at`)
                    ");
                    $stmt->execute([
                        ':rates' => json_encode($records['rates'] ?? $records),
                        ':updated_at' => (int)($records['updated_at'] ?? time())
                    ]);
                    return true;
                } elseif ($table === 'users' && is_array($records)) {
                    $stmt = $pdo->prepare("
                        INSERT INTO `users` (
                            `id`, `username`, `email`, `password_hash`, `name`, `phone`, `title`, 
                            `department`, `bio`, `avatar`, `role`, `roles`, `custom_permissions`, 
                            `status`, `access_scope`, `approval_status`, `pending_payload`, 
                            `timezone`, `currency`, `last_login`, `last_ip`, `created_at`, `updated_at`
                        ) VALUES (
                            :id, :username, :email, :password_hash, :name, :phone, :title, 
                            :department, :bio, :avatar, :role, :roles, :custom_permissions, 
                            :status, :access_scope, :approval_status, :pending_payload, 
                            :timezone, :currency, :last_login, :last_ip, :created_at, NOW()
                        ) ON DUPLICATE KEY UPDATE 
                            `username` = VALUES(`username`),
                            `email` = VALUES(`email`),
                            `password_hash` = VALUES(`password_hash`),
                            `name` = VALUES(`name`),
                            `phone` = VALUES(`phone`),
                            `title` = VALUES(`title`),
                            `department` = VALUES(`department`),
                            `bio` = VALUES(`bio`),
                            `avatar` = VALUES(`avatar`),
                            `role` = VALUES(`role`),
                            `roles` = VALUES(`roles`),
                            `custom_permissions` = VALUES(`custom_permissions`),
                            `status` = VALUES(`status`),
                            `access_scope` = VALUES(`access_scope`),
                            `approval_status` = VALUES(`approval_status`),
                            `pending_payload` = VALUES(`pending_payload`),
                            `timezone` = VALUES(`timezone`),
                            `currency` = VALUES(`currency`),
                            `last_login` = VALUES(`last_login`),
                            `last_ip` = VALUES(`last_ip`),
                            `updated_at` = NOW()
                    ");
                    foreach ($records as $u) {
                        if (!is_array($u) || empty($u['id'])) continue;
                        $stmt->execute([
                            ':id' => $u['id'],
                            ':username' => strtolower(trim((string)($u['username'] ?? ''))),
                            ':email' => strtolower(trim((string)($u['email'] ?? ''))),
                            ':password_hash' => (string)($u['password_hash'] ?? ''),
                            ':name' => (string)($u['name'] ?? 'User'),
                            ':phone' => $u['phone'] ?? null,
                            ':title' => $u['title'] ?? 'Staff Member',
                            ':department' => $u['department'] ?? 'Operations',
                            ':bio' => $u['bio'] ?? null,
                            ':avatar' => $u['avatar'] ?? null,
                            ':role' => (string)($u['role'] ?? 'viewer'),
                            ':roles' => json_encode($u['roles'] ?? ['viewer']),
                            ':custom_permissions' => json_encode($u['custom_permissions'] ?? ['granted' => [], 'denied' => []]),
                            ':status' => (string)($u['status'] ?? 'active'),
                            ':access_scope' => (string)($u['access_scope'] ?? 'crm_only'),
                            ':approval_status' => (string)($u['approval_status'] ?? 'approved'),
                            ':pending_payload' => !empty($u['pending_payload']) ? json_encode($u['pending_payload']) : null,
                            ':timezone' => (string)($u['timezone'] ?? 'America/New_York'),
                            ':currency' => (string)($u['currency'] ?? 'USD'),
                            ':last_login' => !empty($u['last_login']) ? date('Y-m-d H:i:s', strtotime($u['last_login'])) : null,
                            ':last_ip' => $u['last_ip'] ?? null,
                            ':created_at' => !empty($u['created_at']) ? date('Y-m-d H:i:s', strtotime($u['created_at'])) : date('Y-m-d H:i:s')
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                // Ignore DB error, proceed to file sync
            }
        }

        // Keep local JSON synchronized for offline redundancy
        $file = self::$dataDir . '/' . $clean . '.json';
        $json = json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        return (bool) @file_put_contents($file, $json, LOCK_EX);
    }

    public static function insert(string $collection, array $record): array
    {
        $clean = str_replace('.json', '', $collection);
        if (empty($record['id'])) {
            $record['id'] = 'rec_' . bin2hex(random_bytes(10));
        }
        if (empty($record['created_at'])) {
            $record['created_at'] = date('Y-m-d H:i:s');
        }

        $pdo = self::getPdo();
        $table = self::getTableName($clean);

        if ($pdo && $table) {
            try {
                if ($table === 'leads') {
                    $stmt = $pdo->prepare("
                        INSERT INTO `leads` (`id`, `name`, `email`, `company_name`, `phone`, `country`, `budget`, `timeline`, `needs`, `lead_score`, `status`, `created_at`, `updated_at`)
                        VALUES (:id, :name, :email, :company_name, :phone, :country, :budget, :timeline, :needs, :lead_score, :status, :created_at, NOW())
                    ");
                    $stmt->execute([
                        ':id' => $record['id'],
                        ':name' => $record['name'] ?? '',
                        ':email' => $record['email'] ?? '',
                        ':company_name' => $record['company_name'] ?? '',
                        ':phone' => $record['phone'] ?? '',
                        ':country' => $record['country'] ?? 'United States',
                        ':budget' => $record['budget'] ?? '',
                        ':timeline' => $record['timeline'] ?? '',
                        ':needs' => $record['needs'] ?? $record['problem_description'] ?? '',
                        ':lead_score' => (int)($record['lead_score'] ?? 75),
                        ':status' => $record['status'] ?? 'new',
                        ':created_at' => date('Y-m-d H:i:s', strtotime($record['created_at']))
                    ]);
                } elseif ($table === 'opportunities') {
                    $stmt = $pdo->prepare("
                        INSERT INTO `opportunities` (`id`, `lead_id`, `title`, `company`, `value`, `stage`, `assigned_to`, `probability`, `close_date`, `notes`, `created_at`, `updated_at`)
                        VALUES (:id, :lead_id, :title, :company, :value, :stage, :assigned_to, :probability, :close_date, :notes, :created_at, NOW())
                    ");
                    $stmt->execute([
                        ':id' => $record['id'],
                        ':lead_id' => $record['lead_id'] ?? null,
                        ':title' => $record['title'] ?? '',
                        ':company' => $record['company'] ?? '',
                        ':value' => (float)($record['value'] ?? 0),
                        ':stage' => $record['stage'] ?? 'discovery',
                        ':assigned_to' => $record['assigned_to'] ?? 'Founder',
                        ':probability' => (int)($record['probability'] ?? 50),
                        ':close_date' => !empty($record['close_date']) ? date('Y-m-d', strtotime($record['close_date'])) : null,
                        ':notes' => $record['notes'] ?? '',
                        ':created_at' => date('Y-m-d H:i:s', strtotime($record['created_at']))
                    ]);
                } elseif ($table === 'crm_projects') {
                    $stmt = $pdo->prepare("
                        INSERT INTO `crm_projects` (`id`, `name`, `client`, `budget`, `status`, `progress`, `lead_agent`, `deadline`, `milestones`, `created_at`, `updated_at`)
                        VALUES (:id, :name, :client, :budget, :status, :progress, :lead_agent, :deadline, :milestones, :created_at, NOW())
                    ");
                    $stmt->execute([
                        ':id' => $record['id'],
                        ':name' => $record['name'] ?? '',
                        ':client' => $record['client'] ?? $record['client_name'] ?? 'Client',
                        ':budget' => (float)($record['budget'] ?? 15000),
                        ':status' => $record['status'] ?? 'in_progress',
                        ':progress' => (int)($record['progress'] ?? 0),
                        ':lead_agent' => $record['lead_agent'] ?? $record['lead_engineer'] ?? 'Delivery Lead',
                        ':deadline' => !empty($record['deadline']) ? date('Y-m-d', strtotime($record['deadline'])) : null,
                        ':milestones' => json_encode($record['milestones'] ?? []),
                        ':created_at' => date('Y-m-d H:i:s', strtotime($record['created_at']))
                    ]);
                } elseif ($table === 'approvals') {
                    $stmt = $pdo->prepare("
                        INSERT INTO `approvals` (`id`, `type`, `title`, `amount`, `status`, `requested_by`, `requested_user_id`, `payload`, `rule_id`, `required_role`, `created_at`, `updated_at`)
                        VALUES (:id, :type, :title, :amount, :status, :requested_by, :requested_user_id, :payload, :rule_id, :required_role, :created_at, NOW())
                    ");
                    $stmt->execute([
                        ':id' => $record['id'],
                        ':type' => $record['type'] ?? 'email_draft',
                        ':title' => $record['title'] ?? '',
                        ':amount' => (float)($record['amount'] ?? 0.00),
                        ':status' => $record['status'] ?? 'pending',
                        ':requested_by' => $record['requested_by'] ?? 'Agent',
                        ':requested_user_id' => $record['requested_user_id'] ?? null,
                        ':payload' => json_encode($record['payload'] ?? []),
                        ':rule_id' => $record['rule_id'] ?? null,
                        ':required_role' => $record['required_role'] ?? null,
                        ':created_at' => date('Y-m-d H:i:s', strtotime($record['created_at']))
                    ]);
                } elseif ($table === 'approval_rules') {
                    $stmt = $pdo->prepare("
                        INSERT INTO `approval_rules` (`id`, `rule_name`, `type`, `threshold`, `required_role`, `description`, `is_active`, `created_by`, `created_at`, `updated_at`)
                        VALUES (:id, :rule_name, :type, :threshold, :required_role, :description, :is_active, :created_by, :created_at, NOW())
                        ON DUPLICATE KEY UPDATE 
                            `rule_name` = VALUES(`rule_name`),
                            `type` = VALUES(`type`),
                            `threshold` = VALUES(`threshold`),
                            `required_role` = VALUES(`required_role`),
                            `description` = VALUES(`description`),
                            `is_active` = VALUES(`is_active`),
                            `updated_at` = NOW()
                    ");
                    $stmt->execute([
                        ':id' => $record['id'],
                        ':rule_name' => (string)($record['rule_name'] ?? 'Custom Rule'),
                        ':type' => (string)($record['type'] ?? 'proposal_discount'),
                        ':threshold' => (float)($record['threshold'] ?? 0.00),
                        ':required_role' => (string)($record['required_role'] ?? 'superadmin'),
                        ':description' => $record['description'] ?? null,
                        ':is_active' => isset($record['is_active']) ? (int)$record['is_active'] : 1,
                        ':created_by' => $record['created_by'] ?? null,
                        ':created_at' => date('Y-m-d H:i:s', strtotime($record['created_at']))
                    ]);
                } elseif ($table === 'audit_logs') {
                    $stmt = $pdo->prepare("
                        INSERT INTO `audit_logs` (`user_id`, `username`, `action`, `resource_type`, `resource_id`, `details`, `changes`, `ip_address`, `user_agent`, `created_at`)
                        VALUES (:user_id, :username, :action, :resource_type, :resource_id, :details, :changes, :ip_address, :user_agent, :created_at)
                    ");
                    $stmt->execute([
                        ':user_id' => $record['user_id'] ?? null,
                        ':username' => $record['username'] ?? null,
                        ':action' => (string)($record['action'] ?? 'action'),
                        ':resource_type' => (string)($record['resource_type'] ?? 'system'),
                        ':resource_id' => $record['resource_id'] ?? null,
                        ':details' => $record['details'] ?? null,
                        ':changes' => !empty($record['changes']) ? json_encode($record['changes']) : null,
                        ':ip_address' => $record['ip_address'] ?? null,
                        ':user_agent' => $record['user_agent'] ?? null,
                        ':created_at' => date('Y-m-d H:i:s', strtotime($record['created_at']))
                    ]);
                } elseif ($table === 'paperclip_tasks') {
                    $stmt = $pdo->prepare("
                        INSERT INTO `paperclip_tasks` (`id`, `agent`, `agent_title`, `task_type`, `title`, `status`, `priority`, `input_data`, `output_data`, `created_at`, `completed_at`)
                        VALUES (:id, :agent, :agent_title, :task_type, :title, :status, :priority, :input_data, :output_data, :created_at, NOW())
                    ");
                    $stmt->execute([
                        ':id' => $record['id'],
                        ':agent' => $record['agent'] ?? 'lead-researcher',
                        ':agent_title' => $record['agent_title'] ?? 'Lead Researcher',
                        ':task_type' => $record['task_type'] ?? 'general',
                        ':title' => $record['title'] ?? 'Task',
                        ':status' => $record['status'] ?? 'completed',
                        ':priority' => $record['priority'] ?? 'medium',
                        ':input_data' => json_encode($record['input'] ?? $record['input_data'] ?? []),
                        ':output_data' => json_encode($record['output'] ?? $record['output_data'] ?? []),
                        ':created_at' => date('Y-m-d H:i:s', strtotime($record['created_at']))
                    ]);
                } elseif ($table === 'users') {
                    $rolesArray = (array)($record['roles'] ?? (empty($record['role']) ? ['viewer'] : [(string)$record['role']]));
                    $customPerms = isset($record['custom_permissions']) && is_array($record['custom_permissions']) 
                        ? $record['custom_permissions'] 
                        : ['granted' => [], 'denied' => []];

                    $stmt = $pdo->prepare("
                        INSERT INTO `users` (
                            `id`, `username`, `email`, `password_hash`, `name`, `phone`, `title`, 
                            `department`, `reports_to`, `authority_tier`, `approval_limit`, `bio`, `avatar`, `role`, `roles`, `custom_permissions`, 
                            `status`, `access_scope`, `approval_status`, `pending_payload`, 
                            `timezone`, `currency`, `last_login`, `last_ip`, `created_at`, `updated_at`
                        ) VALUES (
                            :id, :username, :email, :password_hash, :name, :phone, :title, 
                            :department, :reports_to, :authority_tier, :approval_limit, :bio, :avatar, :role, :roles, :custom_permissions, 
                            :status, :access_scope, :approval_status, :pending_payload, 
                            :timezone, :currency, :last_login, :last_ip, :created_at, NOW()
                        ) ON DUPLICATE KEY UPDATE 
                            `username` = VALUES(`username`),
                            `email` = VALUES(`email`),
                            `name` = VALUES(`name`),
                            `phone` = VALUES(`phone`),
                            `title` = VALUES(`title`),
                            `department` = VALUES(`department`),
                            `reports_to` = VALUES(`reports_to`),
                            `authority_tier` = VALUES(`authority_tier`),
                            `approval_limit` = VALUES(`approval_limit`),
                            `bio` = VALUES(`bio`),
                            `avatar` = VALUES(`avatar`),
                            `role` = VALUES(`role`),
                            `roles` = VALUES(`roles`),
                            `custom_permissions` = VALUES(`custom_permissions`),
                            `status` = VALUES(`status`),
                            `access_scope` = VALUES(`access_scope`),
                            `approval_status` = VALUES(`approval_status`),
                            `timezone` = VALUES(`timezone`),
                            `currency` = VALUES(`currency`),
                            `updated_at` = NOW()
                    ");
                    $stmt->execute([
                        ':id' => $record['id'],
                        ':username' => strtolower(trim((string)($record['username'] ?? 'user_' . bin2hex(random_bytes(3))))),
                        ':email' => strtolower(trim((string)($record['email'] ?? ''))),
                        ':password_hash' => (string)($record['password_hash'] ?? password_hash('admin@1234', PASSWORD_DEFAULT)),
                        ':name' => (string)($record['name'] ?? 'User'),
                        ':phone' => $record['phone'] ?? null,
                        ':title' => $record['title'] ?? 'Staff Member',
                        ':department' => $record['department'] ?? 'Operations',
                        ':reports_to' => !empty($record['reports_to']) ? (string)$record['reports_to'] : null,
                        ':authority_tier' => isset($record['authority_tier']) ? (int)$record['authority_tier'] : 3,
                        ':approval_limit' => isset($record['approval_limit']) ? (float)$record['approval_limit'] : 0.00,
                        ':bio' => $record['bio'] ?? null,
                        ':avatar' => $record['avatar'] ?? null,
                        ':role' => (string)($record['role'] ?? ($rolesArray[0] ?? 'viewer')),
                        ':roles' => json_encode($rolesArray),
                        ':custom_permissions' => json_encode($customPerms),
                        ':status' => (string)($record['status'] ?? 'active'),
                        ':access_scope' => (string)($record['access_scope'] ?? 'crm_only'),
                        ':approval_status' => (string)($record['approval_status'] ?? 'approved'),
                        ':pending_payload' => !empty($record['pending_payload']) ? json_encode($record['pending_payload']) : null,
                        ':timezone' => (string)($record['timezone'] ?? 'America/New_York'),
                        ':currency' => (string)($record['currency'] ?? 'USD'),
                        ':last_login' => !empty($record['last_login']) ? date('Y-m-d H:i:s', strtotime($record['last_login'])) : null,
                        ':last_ip' => $record['last_ip'] ?? null,
                        ':created_at' => date('Y-m-d H:i:s', strtotime($record['created_at']))
                    ]);

                    // Sync user_roles junction table
                    $roleStmt = $pdo->prepare("INSERT IGNORE INTO `user_roles` (`user_id`, `role_id`) VALUES (:user_id, :role_id)");
                    $roleLookup = $pdo->prepare("SELECT `id` FROM `roles` WHERE `slug` = :slug LIMIT 1");
                    foreach ($rolesArray as $rSlug) {
                        $roleLookup->execute([':slug' => strtolower(trim($rSlug))]);
                        $rRow = $roleLookup->fetch();
                        if ($rRow) {
                            $roleStmt->execute([':user_id' => $record['id'], ':role_id' => $rRow['id']]);
                        }
                    }
                }

                unset(self::$cache[$clean]);
                return $record;
            } catch (\Throwable $e) {
                // Fallback to JSON
            }
        }

        // Fallback to JSON file
        unset(self::$cache[$clean]);
        $records = self::read($collection);
        $records[] = $record;
        self::write($collection, $records);
        return $record;
    }

    public static function findById(string $collection, string $id): ?array
    {
        return self::findByField($collection, 'id', $id);
    }

    public static function findByField(string $collection, string $field, string $value): ?array
    {
        $records = self::read($collection);
        foreach ($records as $record) {
            if (($record[$field] ?? null) === $value) {
                return $record;
            }
        }
        return null;
    }

    public static function update(string $collection, string $id, array $updates): ?array
    {
        $clean = str_replace('.json', '', $collection);
        $pdo = self::getPdo();
        $table = self::getTableName($clean);

        if ($pdo && $table) {
            try {
                if ($table === 'approvals') {
                    $stmt = $pdo->prepare("
                        UPDATE `approvals`
                        SET `status` = :status, `approved_by` = :approved_by, `decision_notes` = :notes, `resolved_at` = NOW()
                        WHERE `id` = :id
                    ");
                    $stmt->execute([
                        ':id' => $id,
                        ':status' => $updates['status'] ?? 'approved',
                        ':approved_by' => $updates['approved_by'] ?? null,
                        ':notes' => $updates['decision_notes'] ?? null
                    ]);
                } elseif ($table === 'crm_projects' && isset($updates['milestones'])) {
                    $stmt = $pdo->prepare("
                        UPDATE `crm_projects`
                        SET `progress` = :progress, `milestones` = :milestones, `status` = :status
                        WHERE `id` = :id
                    ");
                    $stmt->execute([
                        ':id' => $id,
                        ':progress' => (int)($updates['progress'] ?? 0),
                        ':milestones' => json_encode($updates['milestones']),
                        ':status' => $updates['status'] ?? 'in_progress'
                    ]);
                } elseif ($table === 'opportunities') {
                    $sets = [];
                    $params = [':id' => $id];
                    foreach ($updates as $k => $v) {
                        if (in_array($k, ['stage', 'probability', 'value', 'notes', 'close_date'], true)) {
                            $sets[] = "`{$k}` = :{$k}";
                            $params[":{$k}"] = $v;
                        }
                    }
                    if (!empty($sets)) {
                        $sql = "UPDATE `opportunities` SET " . implode(', ', $sets) . " WHERE `id` = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($params);
                    }
                } elseif ($table === 'approval_rules') {
                    $sets = [];
                    $params = [':id' => $id];
                    foreach ($updates as $k => $v) {
                        if (in_array($k, ['rule_name', 'type', 'threshold', 'required_role', 'description', 'is_active'], true)) {
                            $sets[] = "`{$k}` = :{$k}";
                            $params[":{$k}"] = $v;
                        }
                    }
                    if (!empty($sets)) {
                        $sets[] = "`updated_at` = NOW()";
                        $sql = "UPDATE `approval_rules` SET " . implode(', ', $sets) . " WHERE `id` = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($params);
                    }
                } elseif ($table === 'leads') {
                    $sets = [];
                    $params = [':id' => $id];
                    foreach ($updates as $k => $v) {
                        if (in_array($k, ['status', 'lead_score', 'notes'], true)) {
                            $sets[] = "`{$k}` = :{$k}";
                            $params[":{$k}"] = $v;
                        }
                    }
                    if (!empty($sets)) {
                        $sql = "UPDATE `leads` SET " . implode(', ', $sets) . " WHERE `id` = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($params);
                    }
                } elseif ($table === 'users') {
                    $sets = [];
                    $params = [':id' => $id];
                    $allowedCols = [
                        'username', 'email', 'name', 'phone', 'title', 'department', 'reports_to',
                        'authority_tier', 'approval_limit', 'bio', 
                        'avatar', 'role', 'status', 'access_scope', 'approval_status', 
                        'timezone', 'currency', 'last_ip', 'password_hash'
                    ];
                    foreach ($updates as $k => $v) {
                        if (in_array($k, $allowedCols, true)) {
                            $sets[] = "`{$k}` = :{$k}";
                            $params[":{$k}"] = $v;
                        } elseif ($k === 'last_login') {
                            $sets[] = "`last_login` = :last_login";
                            $params[':last_login'] = !empty($v) ? date('Y-m-d H:i:s', strtotime($v)) : null;
                        } elseif ($k === 'roles') {
                            $rolesJson = json_encode((array)$v);
                            $sets[] = "`roles` = :roles";
                            $params[':roles'] = $rolesJson;

                            // Sync user_roles junction table
                            $delStmt = $pdo->prepare("DELETE FROM `user_roles` WHERE `user_id` = :uid");
                            $delStmt->execute([':uid' => $id]);
                            $roleStmt = $pdo->prepare("INSERT IGNORE INTO `user_roles` (`user_id`, `role_id`) VALUES (:user_id, :role_id)");
                            $roleLookup = $pdo->prepare("SELECT `id` FROM `roles` WHERE `slug` = :slug LIMIT 1");
                            foreach ((array)$v as $rSlug) {
                                $roleLookup->execute([':slug' => strtolower(trim($rSlug))]);
                                $rRow = $roleLookup->fetch();
                                if ($rRow) {
                                    $roleStmt->execute([':user_id' => $id, ':role_id' => $rRow['id']]);
                                }
                            }
                        } elseif ($k === 'custom_permissions') {
                            $sets[] = "`custom_permissions` = :custom_permissions";
                            $params[':custom_permissions'] = json_encode($v);
                        } elseif ($k === 'pending_payload') {
                            $sets[] = "`pending_payload` = :pending_payload";
                            $params[':pending_payload'] = !empty($v) ? json_encode($v) : null;
                        }
                    }
                    if (!empty($sets)) {
                        $sets[] = "`updated_at` = NOW()";
                        $sql = "UPDATE `users` SET " . implode(', ', $sets) . " WHERE `id` = :id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute($params);
                    }
                }

                unset(self::$cache[$clean]);
                return self::findById($collection, $id);
            } catch (\Throwable $e) {
                // Fallback to JSON
            }
        }

        // Fallback to JSON file
        unset(self::$cache[$clean]);
        $records = self::read($collection);
        foreach ($records as $index => $record) {
            if (($record['id'] ?? '') === $id) {
                $updated = array_merge($record, $updates, ['updated_at' => date('c')]);
                $records[$index] = $updated;
                self::write($collection, $records);
                return $updated;
            }
        }
        return null;
    }

    public static function delete(string $collection, string $id): bool
    {
        $clean = str_replace('.json', '', $collection);
        unset(self::$cache[$clean]);

        $pdo = self::getPdo();
        $table = self::getTableName($clean);

        if ($pdo && $table) {
            try {
                $stmt = $pdo->prepare("DELETE FROM `{$table}` WHERE `id` = :id");
                return $stmt->execute([':id' => $id]);
            } catch (\Throwable $e) {
                // Fallback
            }
        }

        $records = self::read($collection);
        $initialCount = count($records);
        $records = array_values(array_filter($records, fn($r) => ($r['id'] ?? '') !== $id));
        if (count($records) !== $initialCount) {
            self::write($collection, $records);
            return true;
        }
        return false;
    }
}
