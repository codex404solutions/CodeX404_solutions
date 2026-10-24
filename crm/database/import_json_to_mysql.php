<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — One-Time JSON to MySQL Importer
 * Safely imports all records from crm/storage/data/*.json into MySQL database (codex404_db).
 * Retains existing JSON files intact as persistent backup.
 */

namespace CRM\Database;

use PDO;
use PDOException;
use CRMEnv;

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/app/Services/StorageService.php';

echo "===============================================================\n";
echo " CodeX404 Solutions — JSON to MySQL Data Migration Script\n";
echo "===============================================================\n\n";

$dataDir = dirname(__DIR__) . '/storage/data';
if (!is_dir($dataDir)) {
    die("❌ Error: Storage directory not found at: {$dataDir}\n");
}

// 1. Establish PDO Connection
$host = CRMEnv::get('DB_HOST', 'localhost');
$port = (int)CRMEnv::get('DB_PORT', '3306');
$dbName = CRMEnv::get('DB_NAME', 'codex404_db');
$user = CRMEnv::get('DB_USER', 'admin');
$pass = CRMEnv::get('DB_PASS', 'admin@1234');

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbName};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 5
    ]);
    echo "✅ Connected to MySQL database [{$dbName}] on {$host}:{$port} as user [{$user}].\n\n";
} catch (PDOException $e) {
    die("❌ Fatal PDO connection failure: " . $e->getMessage() . "\n");
}

$summary = [];

// -------------------------------------------------------------
// 1. IMPORT USERS
// -------------------------------------------------------------
echo "--> 1. Importing Users (users.json)...\n";
$usersFile = $dataDir . '/users.json';
if (file_exists($usersFile)) {
    $raw = json_decode((string)file_get_contents($usersFile), true) ?: [];
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
            :timezone, :currency, :last_login, :last_ip, :created_at, :updated_at
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
            `updated_at` = VALUES(`updated_at`)
    ");

    $roleStmt = $pdo->prepare("INSERT IGNORE INTO `user_roles` (`user_id`, `role_id`) VALUES (:user_id, :role_id)");
    $roleLookupStmt = $pdo->prepare("SELECT `id` FROM `roles` WHERE `slug` = :slug LIMIT 1");

    $uCount = 0;
    foreach ($raw as $u) {
        $rolesArray = (array)($u['roles'] ?? (empty($u['role']) ? ['viewer'] : [(string)$u['role']]));
        $customPerms = isset($u['custom_permissions']) && is_array($u['custom_permissions']) 
            ? $u['custom_permissions'] 
            : ['granted' => [], 'denied' => []];

        $stmt->execute([
            ':id' => $u['id'] ?? ('usr_' . bin2hex(random_bytes(6))),
            ':username' => strtolower(trim((string)($u['username'] ?? 'user_' . bin2hex(random_bytes(3))))),
            ':email' => strtolower(trim((string)($u['email'] ?? ''))),
            ':password_hash' => (string)($u['password_hash'] ?? password_hash('admin@1234', PASSWORD_DEFAULT)),
            ':name' => (string)($u['name'] ?? 'User'),
            ':phone' => $u['phone'] ?? null,
            ':title' => $u['title'] ?? 'Staff Member',
            ':department' => $u['department'] ?? 'Operations',
            ':bio' => $u['bio'] ?? null,
            ':avatar' => $u['avatar'] ?? null,
            ':role' => (string)($u['role'] ?? ($rolesArray[0] ?? 'viewer')),
            ':roles' => json_encode($rolesArray),
            ':custom_permissions' => json_encode($customPerms),
            ':status' => (string)($u['status'] ?? 'active'),
            ':access_scope' => (string)($u['access_scope'] ?? 'crm_only'),
            ':approval_status' => (string)($u['approval_status'] ?? 'approved'),
            ':pending_payload' => !empty($u['pending_payload']) ? json_encode($u['pending_payload']) : null,
            ':timezone' => (string)($u['timezone'] ?? 'America/New_York'),
            ':currency' => (string)($u['currency'] ?? 'USD'),
            ':last_login' => !empty($u['last_login']) ? date('Y-m-d H:i:s', strtotime($u['last_login'])) : null,
            ':last_ip' => $u['last_ip'] ?? null,
            ':created_at' => !empty($u['created_at']) ? date('Y-m-d H:i:s', strtotime($u['created_at'])) : date('Y-m-d H:i:s'),
            ':updated_at' => !empty($u['updated_at']) ? date('Y-m-d H:i:s', strtotime($u['updated_at'])) : date('Y-m-d H:i:s')
        ]);

        // Sync to normalized user_roles table
        foreach ($rolesArray as $rSlug) {
            $roleLookupStmt->execute([':slug' => strtolower(trim($rSlug))]);
            $roleRow = $roleLookupStmt->fetch();
            if ($roleRow) {
                $roleStmt->execute([
                    ':user_id' => $u['id'],
                    ':role_id' => $roleRow['id']
                ]);
            }
        }
        $uCount++;
    }
    echo "   -> Successfully migrated {$uCount} users into MySQL `users` & `user_roles`.\n";
    $summary['users'] = $uCount;
} else {
    echo "   -> No users.json file found.\n";
}

// -------------------------------------------------------------
// 2. IMPORT LEADS
// -------------------------------------------------------------
echo "--> 2. Importing Leads (leads.json)...\n";
$leadsFile = $dataDir . '/leads.json';
if (file_exists($leadsFile)) {
    $raw = json_decode((string)file_get_contents($leadsFile), true) ?: [];
    $stmt = $pdo->prepare("
        INSERT INTO `leads` (
            `id`, `name`, `email`, `company_name`, `phone`, `country`, `budget`, 
            `timeline`, `needs`, `lead_score`, `status`, `notes`, `created_at`, `updated_at`
        ) VALUES (
            :id, :name, :email, :company_name, :phone, :country, :budget, 
            :timeline, :needs, :lead_score, :status, :notes, :created_at, :updated_at
        ) ON DUPLICATE KEY UPDATE 
            `name` = VALUES(`name`),
            `email` = VALUES(`email`),
            `company_name` = VALUES(`company_name`),
            `phone` = VALUES(`phone`),
            `country` = VALUES(`country`),
            `budget` = VALUES(`budget`),
            `timeline` = VALUES(`timeline`),
            `needs` = VALUES(`needs`),
            `lead_score` = VALUES(`lead_score`),
            `status` = VALUES(`status`),
            `notes` = VALUES(`notes`),
            `updated_at` = VALUES(`updated_at`)
    ");

    $lCount = 0;
    foreach ($raw as $l) {
        $stmt->execute([
            ':id' => $l['id'] ?? ('lead_' . bin2hex(random_bytes(6))),
            ':name' => (string)($l['name'] ?? 'Prospect'),
            ':email' => strtolower(trim((string)($l['email'] ?? ''))),
            ':company_name' => $l['company_name'] ?? ($l['company'] ?? null),
            ':phone' => $l['phone'] ?? null,
            ':country' => $l['country'] ?? 'United States',
            ':budget' => $l['budget'] ?? null,
            ':timeline' => $l['timeline'] ?? null,
            ':needs' => $l['needs'] ?? ($l['problem_description'] ?? null),
            ':lead_score' => (int)($l['lead_score'] ?? 75),
            ':status' => (string)($l['status'] ?? 'new'),
            ':notes' => $l['notes'] ?? null,
            ':created_at' => !empty($l['created_at']) ? date('Y-m-d H:i:s', strtotime($l['created_at'])) : date('Y-m-d H:i:s'),
            ':updated_at' => !empty($l['updated_at']) ? date('Y-m-d H:i:s', strtotime($l['updated_at'])) : date('Y-m-d H:i:s')
        ]);
        $lCount++;
    }
    echo "   -> Successfully migrated {$lCount} leads into MySQL `leads`.\n";
    $summary['leads'] = $lCount;
}

// -------------------------------------------------------------
// 3. IMPORT OPPORTUNITIES
// -------------------------------------------------------------
echo "--> 3. Importing Sales Opportunities (opportunities.json)...\n";
$oppsFile = $dataDir . '/opportunities.json';
if (file_exists($oppsFile)) {
    $raw = json_decode((string)file_get_contents($oppsFile), true) ?: [];
    $stmt = $pdo->prepare("
        INSERT INTO `opportunities` (
            `id`, `lead_id`, `title`, `company`, `value`, `stage`, `assigned_to`, 
            `probability`, `close_date`, `notes`, `created_at`, `updated_at`
        ) VALUES (
            :id, :lead_id, :title, :company, :value, :stage, :assigned_to, 
            :probability, :close_date, :notes, :created_at, :updated_at
        ) ON DUPLICATE KEY UPDATE 
            `lead_id` = VALUES(`lead_id`),
            `title` = VALUES(`title`),
            `company` = VALUES(`company`),
            `value` = VALUES(`value`),
            `stage` = VALUES(`stage`),
            `assigned_to` = VALUES(`assigned_to`),
            `probability` = VALUES(`probability`),
            `close_date` = VALUES(`close_date`),
            `notes` = VALUES(`notes`),
            `updated_at` = VALUES(`updated_at`)
    ");

    $oCount = 0;
    foreach ($raw as $o) {
        $stmt->execute([
            ':id' => $o['id'] ?? ('opp_' . bin2hex(random_bytes(6))),
            ':lead_id' => !empty($o['lead_id']) ? $o['lead_id'] : null,
            ':title' => (string)($o['title'] ?? 'Custom Project'),
            ':company' => (string)($o['company'] ?? ($o['client_name'] ?? 'Client')),
            ':value' => (float)($o['value'] ?? 0),
            ':stage' => (string)($o['stage'] ?? 'discovery'),
            ':assigned_to' => (string)($o['assigned_to'] ?? 'Founder'),
            ':probability' => (int)($o['probability'] ?? 50),
            ':close_date' => !empty($o['close_date']) ? date('Y-m-d', strtotime($o['close_date'])) : (!empty($o['expected_close_date']) ? date('Y-m-d', strtotime($o['expected_close_date'])) : null),
            ':notes' => $o['notes'] ?? null,
            ':created_at' => !empty($o['created_at']) ? date('Y-m-d H:i:s', strtotime($o['created_at'])) : date('Y-m-d H:i:s'),
            ':updated_at' => !empty($o['updated_at']) ? date('Y-m-d H:i:s', strtotime($o['updated_at'])) : date('Y-m-d H:i:s')
        ]);
        $oCount++;
    }
    echo "   -> Successfully migrated {$oCount} opportunities into MySQL `opportunities`.\n";
    $summary['opportunities'] = $oCount;
}

// -------------------------------------------------------------
// 4. IMPORT CRM PROJECTS
// -------------------------------------------------------------
echo "--> 4. Importing Client Projects (projects.json)...\n";
$projsFile = $dataDir . '/projects.json';
if (file_exists($projsFile)) {
    $raw = json_decode((string)file_get_contents($projsFile), true) ?: [];
    $stmt = $pdo->prepare("
        INSERT INTO `crm_projects` (
            `id`, `name`, `client`, `budget`, `status`, `progress`, `lead_agent`, 
            `deadline`, `milestones`, `created_at`, `updated_at`
        ) VALUES (
            :id, :name, :client, :budget, :status, :progress, :lead_agent, 
            :deadline, :milestones, :created_at, :updated_at
        ) ON DUPLICATE KEY UPDATE 
            `name` = VALUES(`name`),
            `client` = VALUES(`client`),
            `budget` = VALUES(`budget`),
            `status` = VALUES(`status`),
            `progress` = VALUES(`progress`),
            `lead_agent` = VALUES(`lead_agent`),
            `deadline` = VALUES(`deadline`),
            `milestones` = VALUES(`milestones`),
            `updated_at` = VALUES(`updated_at`)
    ");

    $pCount = 0;
    foreach ($raw as $p) {
        $stmt->execute([
            ':id' => $p['id'] ?? ('proj_' . bin2hex(random_bytes(6))),
            ':name' => (string)($p['name'] ?? 'Project'),
            ':client' => (string)($p['client'] ?? ($p['client_name'] ?? 'Client')),
            ':budget' => (float)($p['budget'] ?? 0),
            ':status' => (string)($p['status'] ?? 'in_progress'),
            ':progress' => (int)($p['progress'] ?? 0),
            ':lead_agent' => (string)($p['lead_agent'] ?? ($p['lead_engineer'] ?? 'Delivery Lead')),
            ':deadline' => !empty($p['deadline']) ? date('Y-m-d', strtotime($p['deadline'])) : null,
            ':milestones' => json_encode($p['milestones'] ?? []),
            ':created_at' => !empty($p['created_at']) ? date('Y-m-d H:i:s', strtotime($p['created_at'])) : date('Y-m-d H:i:s'),
            ':updated_at' => !empty($p['updated_at']) ? date('Y-m-d H:i:s', strtotime($p['updated_at'])) : date('Y-m-d H:i:s')
        ]);
        $pCount++;
    }
    echo "   -> Successfully migrated {$pCount} projects into MySQL `crm_projects`.\n";
    $summary['crm_projects'] = $pCount;
}

// -------------------------------------------------------------
// 5. IMPORT APPROVALS
// -------------------------------------------------------------
echo "--> 5. Importing HITL Approvals (approvals.json)...\n";
$apprFile = $dataDir . '/approvals.json';
if (file_exists($apprFile)) {
    $raw = json_decode((string)file_get_contents($apprFile), true) ?: [];
    $stmt = $pdo->prepare("
        INSERT INTO `approvals` (
            `id`, `type`, `title`, `status`, `requested_by`, `approved_by`, 
            `payload`, `decision_notes`, `resolved_at`, `created_at`, `updated_at`
        ) VALUES (
            :id, :type, :title, :status, :requested_by, :approved_by, 
            :payload, :decision_notes, :resolved_at, :created_at, :updated_at
        ) ON DUPLICATE KEY UPDATE 
            `type` = VALUES(`type`),
            `title` = VALUES(`title`),
            `status` = VALUES(`status`),
            `requested_by` = VALUES(`requested_by`),
            `approved_by` = VALUES(`approved_by`),
            `payload` = VALUES(`payload`),
            `decision_notes` = VALUES(`decision_notes`),
            `resolved_at` = VALUES(`resolved_at`),
            `updated_at` = VALUES(`updated_at`)
    ");

    $aCount = 0;
    foreach ($raw as $a) {
        $stmt->execute([
            ':id' => $a['id'] ?? ('appr_' . bin2hex(random_bytes(6))),
            ':type' => (string)($a['type'] ?? 'email_draft'),
            ':title' => (string)($a['title'] ?? 'Ticket'),
            ':status' => (string)($a['status'] ?? 'pending'),
            ':requested_by' => (string)($a['requested_by'] ?? 'Agent'),
            ':approved_by' => $a['approved_by'] ?? null,
            ':payload' => json_encode($a['payload'] ?? []),
            ':decision_notes' => $a['decision_notes'] ?? null,
            ':resolved_at' => !empty($a['resolved_at']) ? date('Y-m-d H:i:s', strtotime($a['resolved_at'])) : null,
            ':created_at' => !empty($a['created_at']) ? date('Y-m-d H:i:s', strtotime($a['created_at'])) : date('Y-m-d H:i:s'),
            ':updated_at' => !empty($a['updated_at']) ? date('Y-m-d H:i:s', strtotime($a['updated_at'])) : date('Y-m-d H:i:s')
        ]);
        $aCount++;
    }
    echo "   -> Successfully migrated {$aCount} approvals into MySQL `approvals`.\n";
    $summary['approvals'] = $aCount;
}

// -------------------------------------------------------------
// 6. IMPORT PAPERCLIP TASKS
// -------------------------------------------------------------
echo "--> 6. Importing Autonomous Tasks (paperclip_tasks.json)...\n";
$tasksFile = $dataDir . '/paperclip_tasks.json';
if (file_exists($tasksFile)) {
    $raw = json_decode((string)file_get_contents($tasksFile), true) ?: [];
    $stmt = $pdo->prepare("
        INSERT INTO `paperclip_tasks` (
            `id`, `agent`, `agent_title`, `task_type`, `title`, `status`, 
            `priority`, `input_data`, `output_data`, `created_at`, `completed_at`
        ) VALUES (
            :id, :agent, :agent_title, :task_type, :title, :status, 
            :priority, :input_data, :output_data, :created_at, :completed_at
        ) ON DUPLICATE KEY UPDATE 
            `agent` = VALUES(`agent`),
            `agent_title` = VALUES(`agent_title`),
            `task_type` = VALUES(`task_type`),
            `title` = VALUES(`title`),
            `status` = VALUES(`status`),
            `priority` = VALUES(`priority`),
            `input_data` = VALUES(`input_data`),
            `output_data` = VALUES(`output_data`),
            `completed_at` = VALUES(`completed_at`)
    ");

    $tCount = 0;
    foreach ($raw as $t) {
        $stmt->execute([
            ':id' => $t['id'] ?? ('task_' . bin2hex(random_bytes(6))),
            ':agent' => (string)($t['agent'] ?? 'lead-researcher'),
            ':agent_title' => $t['agent_title'] ?? null,
            ':task_type' => $t['task_type'] ?? 'general',
            ':title' => (string)($t['title'] ?? 'Task'),
            ':status' => (string)($t['status'] ?? 'completed'),
            ':priority' => (string)($t['priority'] ?? 'medium'),
            ':input_data' => json_encode($t['input'] ?? $t['input_data'] ?? []),
            ':output_data' => json_encode($t['output'] ?? $t['output_data'] ?? []),
            ':created_at' => !empty($t['created_at']) ? date('Y-m-d H:i:s', strtotime($t['created_at'])) : date('Y-m-d H:i:s'),
            ':completed_at' => !empty($t['completed_at']) ? date('Y-m-d H:i:s', strtotime($t['completed_at'])) : null
        ]);
        $tCount++;
    }
    echo "   -> Successfully migrated {$tCount} autonomous tasks into MySQL `paperclip_tasks`.\n";
    $summary['paperclip_tasks'] = $tCount;
}

// -------------------------------------------------------------
// 7. IMPORT CURRENCY RATES CACHE
// -------------------------------------------------------------
echo "--> 7. Importing Currency Rates Cache (rates_cache.json.json)...\n";
$ratesFile = $dataDir . '/rates_cache.json.json';
if (file_exists($ratesFile)) {
    $raw = json_decode((string)file_get_contents($ratesFile), true) ?: [];
    $stmt = $pdo->prepare("
        INSERT INTO `currency_rates` (`id`, `rates`, `updated_at`)
        VALUES ('rates', :rates, :updated_at)
        ON DUPLICATE KEY UPDATE `rates` = VALUES(`rates`), `updated_at` = VALUES(`updated_at`)
    ");
    $stmt->execute([
        ':rates' => json_encode($raw['rates'] ?? $raw),
        ':updated_at' => (int)($raw['updated_at'] ?? time())
    ]);
    echo "   -> Successfully migrated currency exchange rates into MySQL `currency_rates`.\n";
    $summary['currency_rates'] = 1;
}

echo "\n===============================================================\n";
echo " 🎉 Migration Complete! Total Records Migrated:\n";
foreach ($summary as $tbl => $cnt) {
    echo "   - {$tbl}: {$cnt} rows\n";
}
echo " JSON files remain fully preserved in crm/storage/data/ as backup.\n";
echo "===============================================================\n";
