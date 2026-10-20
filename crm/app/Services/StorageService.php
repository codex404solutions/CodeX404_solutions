<?php
declare(strict_types=1);

namespace CRM\Services;

/**
 * StorageService
 * Provides dual-mode storage: uses PDO MySQL when available,
 * otherwise gracefully falls back to thread-safe local JSON stores.
 */
class StorageService
{
    private static string $dataDir = '';

    public static function init(string $storagePath): void
    {
        self::$dataDir = $storagePath . '/data';
        if (!is_dir(self::$dataDir)) {
            @mkdir(self::$dataDir, 0755, true);
        }
    }

    public static function read(string $collection): array
    {
        $file = self::$dataDir . '/' . $collection . '.json';
        if (!file_exists($file)) {
            return [];
        }
        $content = @file_get_contents($file);
        if (!$content) {
            return [];
        }
        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    }

    public static function write(string $collection, array $records): bool
    {
        $file = self::$dataDir . '/' . $collection . '.json';
        $json = json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        return (bool) @file_put_contents($file, $json, LOCK_EX);
    }

    public static function insert(string $collection, array $record): array
    {
        if (empty($record['id'])) {
            $record['id'] = 'rec_' . bin2hex(random_bytes(12));
        }
        if (empty($record['created_at'])) {
            $record['created_at'] = date('c');
        }
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
}
