<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CLI Idempotent Database Migration Runner
 * Usage: php website/database/migrate.php
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/app/Services/AuditLogService.php';
require_once dirname(__DIR__) . '/app/Services/MigrationService.php';

use App\Services\MigrationService;

$result = MigrationService::applyPending('cli', 'cli');
echo ($result['ok'] ? 'OK: ' : 'ERROR: ') . $result['message'] . PHP_EOL;
exit($result['ok'] ? 0 : 1);
