<?php
declare(strict_types=1);

namespace App\Careers;

use PDO;

/**
 * Manages persisted recruitment configuration key/value pairs in MySQL.
 */
final class RecruitmentSettingsService
{
    /** @var array<string,string>|null */
    private static ?array $cache = null;

    /**
     * @return array<string, array{setting_key:string, setting_value:string, setting_group:string, description:string}>
     */
    public static function getAllDetailed(): array
    {
        $pdo = CareersDB::pdo();
        $rows = $pdo->query("SELECT `setting_key`, `setting_value`, `setting_group`, `description` FROM `recruitment_settings` ORDER BY `setting_group`, `setting_key`")->fetchAll(PDO::FETCH_ASSOC);
        $out = [];
        foreach ($rows as $row) {
            $out[$row['setting_key']] = $row;
        }
        return $out;
    }

    /**
     * @return array<string, string>
     */
    public static function getAll(bool $refresh = false): array
    {
        if (self::$cache !== null && !$refresh) {
            return self::$cache;
        }
        $pdo = CareersDB::pdo();
        $rows = $pdo->query("SELECT `setting_key`, `setting_value` FROM `recruitment_settings`")->fetchAll(PDO::FETCH_ASSOC);
        $map = [];
        foreach ($rows as $row) {
            $map[(string)$row['setting_key']] = (string)($row['setting_value'] ?? '');
        }
        self::$cache = $map;
        return $map;
    }

    public static function getString(string $key, string $default = ''): string
    {
        $all = self::getAll();
        return $all[$key] ?? $default;
    }

    public static function getInt(string $key, int $default = 0): int
    {
        $all = self::getAll();
        return isset($all[$key]) && is_numeric($all[$key]) ? (int)$all[$key] : $default;
    }

    public static function getBool(string $key, bool $default = false): bool
    {
        $all = self::getAll();
        if (!isset($all[$key])) {
            return $default;
        }
        return in_array(strtolower(trim($all[$key])), ['1', 'true', 'yes', 'on'], true);
    }

    /**
     * @param array<string, string> $values
     */
    public static function updateMany(array $values): void
    {
        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("
            INSERT INTO `recruitment_settings` (`setting_key`, `setting_value`, `setting_group`)
            VALUES (:k, :v, 'general')
            ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`)
        ");
        foreach ($values as $key => $val) {
            $cleanKey = preg_replace('/[^a-z0-9_]/', '', strtolower((string)$key));
            if ($cleanKey === '') {
                continue;
            }
            $stmt->execute([
                ':k' => $cleanKey,
                ':v' => trim((string)$val),
            ]);
        }
        self::$cache = null;
    }
}
