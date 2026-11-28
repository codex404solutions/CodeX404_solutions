<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CLI Production Database User & Password Provisioner
 *
 * Usage:
 *   php website/database/create_user.php --username=admin --email=info@codex404solutions.com --name="CodeX404 Admin" --roles=superadmin --generate-password
 *   PROVISION_PASS="StrongPass!123" php website/database/create_user.php --username=admin --email=info@codex404solutions.com --update-if-exists
 *
 * Security:
 * - CLI-only (HTTP 403).
 * - Never accepts plaintext passwords on CLI flags (reads PROVISION_PASS env, interactive prompt, or --generate-password).
 * - Uses UserService with bcrypt PASSWORD_DEFAULT hashing and PDO prepared statements.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('CLI only.');
}

require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/app/Services/AuditLogService.php';
require_once dirname(__DIR__) . '/app/Services/RBACService.php';
require_once dirname(__DIR__) . '/app/Services/UserService.php';
require_once dirname(__DIR__) . '/app/Services/MigrationService.php';

use App\Services\AuditLogService;
use App\Services\MigrationService;
use App\Services\UserService;

/**
 * Generate a strong random password satisfying UserService::assertStrongPassword().
 */
function generateStrongPassword(int $length = 20): string
{
    $upper = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    $lower = 'abcdefghijkmnopqrstuvwxyz';
    $digits = '23456789';
    $symbols = '!@#$%^&*()-_=+';
    $all = $upper . $lower . $digits . $symbols;

    $chars = [
        $upper[random_int(0, strlen($upper) - 1)],
        $lower[random_int(0, strlen($lower) - 1)],
        $digits[random_int(0, strlen($digits) - 1)],
        $symbols[random_int(0, strlen($symbols) - 1)],
    ];
    for ($i = count($chars); $i < $length; $i++) {
        $chars[] = $all[random_int(0, strlen($all) - 1)];
    }
    for ($i = count($chars) - 1; $i > 0; $i--) {
        $j = random_int(0, $i);
        [$chars[$i], $chars[$j]] = [$chars[$j], $chars[$i]];
    }
    return implode('', $chars);
}

$opts = getopt('', [
    'username:',
    'email:',
    'name:',
    'roles::',
    'scope::',
    'generate-password',
    'update-if-exists',
    'skip-migrate',
    'help',
]);

if (isset($opts['help'])) {
    echo "Usage: php website/database/create_user.php --username=<user> --email=<email> [--name=<name>] [--roles=superadmin] [--scope=both] [--generate-password] [--update-if-exists]\n";
    echo "Pass password via PROVISION_PASS environment variable, --generate-password, or interactive prompt.\n";
    exit(0);
}

$username = strtolower(trim((string) ($opts['username'] ?? getenv('PROVISION_USER') ?: '')));
$email = strtolower(trim((string) ($opts['email'] ?? getenv('PROVISION_EMAIL') ?: '')));
$name = trim((string) ($opts['name'] ?? getenv('PROVISION_NAME') ?: 'CodeX404 Administrator'));
$rolesRaw = (string) ($opts['roles'] ?? getenv('PROVISION_ROLES') ?: 'superadmin');
$roles = array_values(array_filter(array_map('trim', explode(',', $rolesRaw)), static fn(string $r): bool => $r !== ''));
$scope = trim((string) ($opts['scope'] ?? 'both'));
$generatePassword = isset($opts['generate-password']);
$updateIfExists = isset($opts['update-if-exists']);
$skipMigrate = isset($opts['skip-migrate']);

if ($username === '' || $email === '') {
    fwrite(STDERR, "ERROR: --username and --email (or PROVISION_USER / PROVISION_EMAIL) are required.\n");
    exit(1);
}

$pdo = Database::getConnection();
if (!$pdo) {
    fwrite(STDERR, "ERROR: MySQL database connection unavailable. Check website/.env DB_* credentials.\n");
    exit(1);
}

if (!$skipMigrate) {
    $migResult = MigrationService::applyPending('cli', 'cli');
    if (!$migResult['ok']) {
        fwrite(STDERR, "ERROR: Migration failed: {$migResult['message']}\n");
        exit(1);
    }
    if (!empty($migResult['applied'])) {
        echo "OK: Applied migrations: " . implode(', ', $migResult['applied']) . PHP_EOL;
    }
}

$password = (string) (getenv('PROVISION_PASS') ?: '');
$wasGenerated = false;
if ($generatePassword) {
    $password = generateStrongPassword(20);
    $wasGenerated = true;
} elseif ($password === '' && function_exists('stream_isatty') && @stream_isatty(STDIN)) {
    fwrite(STDOUT, 'Enter strong password (min 12 chars, upper/lower/number/symbol): ');
    $password = rtrim((string) fgets(STDIN), "\r\n");
}

if ($password === '') {
    fwrite(STDERR, "ERROR: Provide password via --generate-password, PROVISION_PASS env var, or interactive prompt.\n");
    exit(1);
}

try {
    $existing = UserService::getByUsernameOrEmail($username) ?? UserService::getByUsernameOrEmail($email);
    if ($existing) {
        if (!$updateIfExists) {
            fwrite(STDERR, "ERROR: User '{$existing['username']}' ({$existing['email']}) already exists. Pass --update-if-exists to update password and roles.\n");
            exit(1);
        }
        UserService::update((string) $existing['id'], [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'roles' => $roles,
            'access_scope' => $scope,
            'status' => 'active',
        ], null);
        UserService::updatePassword((string) $existing['id'], $password);
        AuditLogService::record('cli', 'cli', 'user.cli_updated', 'user', (string) $existing['id'], "Updated production admin user '{$username}' via CLI");
        $actionLabel = 'Updated';
        $userId = (string) $existing['id'];
    } else {
        $created = UserService::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'roles' => $roles,
            'access_scope' => $scope,
            'status' => 'active',
            'title' => 'Administrator',
            'department' => 'Executive Leadership',
            'timezone' => 'Asia/Kolkata',
            'currency' => 'INR',
        ], null);
        $userId = (string) ($created['id'] ?? '');
        AuditLogService::record('cli', 'cli', 'user.cli_created', 'user', $userId, "Provisioned production admin user '{$username}' via CLI");
        $actionLabel = 'Created';
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "OK: {$actionLabel} user '{$username}' (id={$userId}, email={$email}, roles=" . implode(',', $roles) . ", scope={$scope})\n";
    if ($wasGenerated) {
        echo "GENERATED_PASSWORD={$password}\n";
    }
    echo "ENV_ADMIN_USER={$username}\n";
    echo "ENV_ADMIN_PASS_HASH='{$hash}'\n";
    exit(0);
} catch (\Throwable $e) {
    fwrite(STDERR, 'ERROR: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}
