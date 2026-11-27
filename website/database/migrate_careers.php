<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Idempotent Migration & Seed Runner for Careers & Recruitment System
 */

$root = dirname(__DIR__, 2);
require_once $root . '/website/config/Env.php';
Env::load($root . '/website/.env');
require_once $root . '/website/config/database.php';

$pdo = Database::getConnection();
if (!$pdo) {
    fwrite(STDERR, "ERROR: Unable to connect to MySQL database.\n");
    exit(1);
}

$migrationName = '007_careers_recruitment_system.sql';
$sqlPath = __DIR__ . '/migrations/' . $migrationName;
if (!is_file($sqlPath)) {
    fwrite(STDERR, "ERROR: Missing SQL file: {$sqlPath}\n");
    exit(1);
}

$rawSql = (string)file_get_contents($sqlPath);
$cleanLines = [];
foreach (preg_split('/\R/', $rawSql) ?: [] as $line) {
    $trimmed = ltrim($line);
    if (str_starts_with($trimmed, '--')) {
        continue;
    }
    $cleanLines[] = $line;
}
$sql = implode("\n", $cleanLines);
$statements = array_filter(
    array_map('trim', explode(';', $sql)),
    fn(string $stmt): bool => $stmt !== ''
);

foreach ($statements as $stmt) {
    $pdo->exec($stmt);
}

require_once $root . '/website/app/Careers/CareersSeeder.php';
\App\Careers\CareersSeeder::seed($pdo);

// Record Migration in `migrations` table (if not present)
$chkMig = $pdo->prepare("SELECT COUNT(*) FROM `migrations` WHERE `migration` = ?");
$chkMig->execute([$migrationName]);
if ((int)$chkMig->fetchColumn() === 0) {
    $maxBatch = (int)$pdo->query("SELECT COALESCE(MAX(batch), 0) FROM `migrations`")->fetchColumn();
    $insMig = $pdo->prepare("INSERT INTO `migrations` (`migration`, `batch`) VALUES (?, ?)");
    $insMig->execute([$migrationName, $maxBatch + 1]);
}

echo "OK: Migration {$migrationName} and seeds applied cleanly.\n";
