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
        'rates_cache' => 'currency_rates'
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
                        INSERT INTO `approvals` (`id`, `type`, `title`, `status`, `requested_by`, `payload`, `created_at`, `updated_at`)
                        VALUES (:id, :type, :title, :status, :requested_by, :payload, :created_at, NOW())
                    ");
                    $stmt->execute([
                        ':id' => $record['id'],
                        ':type' => $record['type'] ?? 'email_draft',
                        ':title' => $record['title'] ?? '',
                        ':status' => $record['status'] ?? 'pending',
                        ':requested_by' => $record['requested_by'] ?? 'Agent',
                        ':payload' => json_encode($record['payload'] ?? []),
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
