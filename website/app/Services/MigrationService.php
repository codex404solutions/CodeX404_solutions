<?php
declare(strict_types=1);

namespace App\Services;

use Database;
use PDO;
use PDOException;

/**
 * Idempotent SQL Migration Runner & Status Service.
 * Discovers numbered migrations in website/database/migrations/ (excluding *_down.sql),
 * tracks applied batches in the `migrations` table, and executes pending SQL safely.
 */
final class MigrationService
{
    private const IDEMPOTENT_MYSQL_CODES = [
        1050, // Table already exists
        1060, // Duplicate column name
        1061, // Duplicate key name
        1091, // Can't DROP column/index; check that it exists
    ];

    public static function migrationsDir(): string
    {
        return dirname(__DIR__, 2) . '/database/migrations';
    }

    public static function ensureMigrationsTable(PDO $pdo): void
    {
        $pdo->exec('
            CREATE TABLE IF NOT EXISTS `migrations` (
                `id` INT NOT NULL AUTO_INCREMENT,
                `migration` VARCHAR(255) NOT NULL,
                `batch` INT NOT NULL,
                `applied_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `migration` (`migration`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ');
    }

    /**
     * Discover all forward numbered migration files sorted chronologically.
     *
     * @return array<int, string>
     */
    public static function discoverFiles(): array
    {
        $dir = self::migrationsDir();
        if (!is_dir($dir)) {
            return [];
        }

        $files = [];
        foreach (scandir($dir) ?: [] as $entry) {
            if (preg_match('/^\d{3}_[a-zA-Z0-9_]+\.sql$/', $entry) && !str_ends_with(strtolower($entry), '_down.sql')) {
                $files[] = $entry;
            }
        }
        sort($files, SORT_STRING);
        return $files;
    }

    /**
     * Inspect current database migration status.
     *
     * @return array{
     *   connected: bool,
     *   database: string,
     *   applied_count: int,
     *   pending_count: int,
     *   applied: array<int, array{filename: string, batch: int, applied_at: string}>,
     *   pending: array<int, string>,
     *   timeline: array<int, array{filename: string, batch: ?int, applied_at: ?string, status: string, in_repo: bool}>
     * }
     */
    public static function status(): array
    {
        $result = [
            'connected'     => false,
            'database'      => '',
            'applied_count' => 0,
            'pending_count' => 0,
            'applied'       => [],
            'pending'       => [],
            'timeline'      => [],
        ];

        $pdo = Database::getConnection();
        if (!$pdo) {
            return $result;
        }

        try {
            $result['connected'] = true;
            $result['database'] = (string) ($pdo->query('SELECT DATABASE()')->fetchColumn() ?: '');
            self::ensureMigrationsTable($pdo);

            $rows = $pdo->query('SELECT `migration`, `batch`, `applied_at` FROM `migrations` ORDER BY `id` ASC')->fetchAll(PDO::FETCH_ASSOC) ?: [];
            $appliedMap = [];
            foreach ($rows as $r) {
                $name = (string) $r['migration'];
                $appliedMap[$name] = [
                    'filename'   => $name,
                    'batch'      => (int) $r['batch'],
                    'applied_at' => (string) $r['applied_at'],
                ];
            }

            $diskFiles = self::discoverFiles();
            $diskSet = array_flip($diskFiles);

            foreach ($appliedMap as $name => $info) {
                $result['applied'][] = $info;
                if (!isset($diskSet[$name])) {
                    $result['timeline'][] = [
                        'filename'   => $name,
                        'batch'      => $info['batch'],
                        'applied_at' => $info['applied_at'],
                        'status'     => 'applied',
                        'in_repo'    => false,
                    ];
                }
            }

            foreach ($diskFiles as $file) {
                if (isset($appliedMap[$file])) {
                    $info = $appliedMap[$file];
                    $result['timeline'][] = [
                        'filename'   => $file,
                        'batch'      => $info['batch'],
                        'applied_at' => $info['applied_at'],
                        'status'     => 'applied',
                        'in_repo'    => true,
                    ];
                } else {
                    $result['pending'][] = $file;
                    $result['timeline'][] = [
                        'filename'   => $file,
                        'batch'      => null,
                        'applied_at' => null,
                        'status'     => 'pending',
                        'in_repo'    => true,
                    ];
                }
            }

            $result['applied_count'] = count($result['applied']);
            $result['pending_count'] = count($result['pending']);
        } catch (\Throwable $e) {
            // Leave safe status payload on error
        }

        return $result;
    }

    public static function pendingCount(): int
    {
        $status = self::status();
        return $status['pending_count'];
    }

    /**
     * Apply all pending numbered SQL migrations in order.
     *
     * @return array{ok: bool, applied: array<int, string>, message: string}
     */
    public static function applyPending(?string $actorId = null, ?string $actorUsername = null): array
    {
        $pdo = Database::getConnection();
        if (!$pdo) {
            return ['ok' => false, 'applied' => [], 'message' => 'Database connection unavailable.'];
        }

        $status = self::status();
        if (empty($status['pending'])) {
            return ['ok' => true, 'applied' => [], 'message' => 'Database schema is already up to date.'];
        }

        $maxBatch = (int) ($pdo->query('SELECT COALESCE(MAX(`batch`), 0) FROM `migrations`')->fetchColumn() ?: 0);
        $nextBatch = $maxBatch + 1;
        $appliedNow = [];

        foreach ($status['pending'] as $filename) {
            $fullPath = realpath(self::migrationsDir() . '/' . $filename);
            $baseDir = realpath(self::migrationsDir());
            if ($fullPath === false || $baseDir === false || !str_starts_with($fullPath, $baseDir)) {
                return ['ok' => false, 'applied' => $appliedNow, 'message' => "Invalid migration path: {$filename}"];
            }

            $sql = (string) file_get_contents($fullPath);
            $statements = self::splitStatements($sql);

            foreach ($statements as $stmtSql) {
                try {
                    $pdo->exec($stmtSql);
                } catch (PDOException $e) {
                    $driverCode = (int) ($e->errorInfo[1] ?? 0);
                    if (in_array($driverCode, self::IDEMPOTENT_MYSQL_CODES, true)) {
                        continue;
                    }
                    return [
                        'ok'      => false,
                        'applied' => $appliedNow,
                        'message' => "Migration '{$filename}' failed (SQL code {$driverCode}).",
                    ];
                }
            }

            $rec = $pdo->prepare('INSERT INTO `migrations` (`migration`, `batch`) VALUES (?, ?)');
            $rec->execute([$filename, $nextBatch]);
            $appliedNow[] = $filename;

            if (class_exists('\\App\\Services\\AuditLogService')) {
                AuditLogService::record(
                    $actorId,
                    $actorUsername,
                    'database.migration_applied',
                    'database',
                    $filename,
                    "Applied database migration {$filename} (batch {$nextBatch})"
                );
            }
        }

        return [
            'ok'      => true,
            'applied' => $appliedNow,
            'message' => 'Applied ' . count($appliedNow) . ' migration(s): ' . implode(', ', $appliedNow) . '.',
        ];
    }

    /**
     * Strip SQL line comments outside strings and split into individual statements.
     *
     * @return array<int, string>
     */
    private static function splitStatements(string $sql): array
    {
        $lines = preg_split('/\r?\n/', $sql) ?: [];
        $cleanLines = array_filter($lines, static fn(string $line): bool => !str_starts_with(ltrim($line), '--'));
        $cleaned = implode("\n", $cleanLines);
        $parts = preg_split('/;\s*(?:\r?\n|$)/', $cleaned) ?: [];
        return array_values(array_filter(array_map('trim', $parts), static fn(string $s): bool => $s !== ''));
    }
}
