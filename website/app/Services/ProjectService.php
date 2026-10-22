<?php
declare(strict_types=1);

namespace App\Services;

/**
 * ProjectService
 * High-performance file-backed data service for CodeX404 portfolio projects.
 * Thread-safe with atomic locking and strict typing.
 */
class ProjectService
{
    private static string $filePath = '';

    private static function getStoragePath(): string
    {
        if (empty(self::$filePath)) {
            self::$filePath = dirname(__DIR__, 2) . '/data/projects.json';
        }
        return self::$filePath;
    }

    /**
     * Get all projects sorted by order.
     * @return array<int, array<string, mixed>>
     */
    public static function getAll(): array
    {
        $file = self::getStoragePath();
        if (!file_exists($file)) {
            return [];
        }

        $fp = fopen($file, 'rb');
        if (!$fp) {
            return [];
        }

        flock($fp, LOCK_SH);
        $contents = stream_get_contents($fp);
        flock($fp, LOCK_UN);
        fclose($fp);

        if (!$contents) {
            return [];
        }

        $data = json_decode($contents, true);
        if (!is_array($data)) {
            return [];
        }

        usort($data, fn($a, $b) => ($a['order'] ?? 99) <=> ($b['order'] ?? 99));
        return $data;
    }

    /**
     * Get only active projects for public display.
     * @return array<int, array<string, mixed>>
     */
    public static function getActive(): array
    {
        $all = self::getAll();
        return array_values(array_filter($all, fn($item) => !empty($item['active'])));
    }

    /**
     * Find a project by ID.
     */
    public static function getById(string $id): ?array
    {
        $cleanId = trim($id);
        if ($cleanId === '') {
            return null;
        }

        $all = self::getAll();
        foreach ($all as $item) {
            if (($item['id'] ?? '') === $cleanId) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Save (create or update) a project.
     * @param array<string, mixed> $input
     * @return array<string, mixed> The saved project record
     */
    public static function save(array $input): array
    {
        $all = self::getAll();
        $id = trim((string)($input['id'] ?? ''));

        // Generate ID if missing or new
        if ($id === '') {
            $id = self::slugify((string)($input['title'] ?? 'project-' . time()));
            // Ensure unique
            $baseId = $id;
            $counter = 1;
            while (self::idExists($id, $all)) {
                $id = $baseId . '-' . $counter;
                $counter++;
            }
        }

        // Process tags
        $tags = $input['tags'] ?? [];
        if (is_string($tags)) {
            $tags = array_values(array_filter(array_map('trim', explode(',', $tags))));
        }

        $now = date('Y-m-d H:i:s');
        $existingIndex = -1;
        foreach ($all as $idx => $p) {
            if (($p['id'] ?? '') === $id) {
                $existingIndex = $idx;
                break;
            }
        }

        $record = [
            'id' => $id,
            'title' => trim((string)($input['title'] ?? 'Untitled Project')),
            'category' => trim((string)($input['category'] ?? 'software')),
            'category_label' => trim((string)($input['category_label'] ?? 'Custom Software')),
            'badge_text' => trim((string)($input['badge_text'] ?? 'Production Live')),
            'badge_type' => trim((string)($input['badge_type'] ?? 'live')),
            'mockup_host' => trim((string)($input['mockup_host'] ?? 'app.internal.system')),
            'mockup_tag1' => trim((string)($input['mockup_tag1'] ?? '')),
            'mockup_tag2' => trim((string)($input['mockup_tag2'] ?? '')),
            'stat_1_val' => trim((string)($input['stat_1_val'] ?? '')),
            'stat_1_lbl' => trim((string)($input['stat_1_lbl'] ?? '')),
            'stat_2_val' => trim((string)($input['stat_2_val'] ?? '')),
            'stat_2_lbl' => trim((string)($input['stat_2_lbl'] ?? '')),
            'stat_3_val' => trim((string)($input['stat_3_val'] ?? '')),
            'stat_3_lbl' => trim((string)($input['stat_3_lbl'] ?? '')),
            'problem' => trim((string)($input['problem'] ?? '')),
            'solution' => trim((string)($input['solution'] ?? '')),
            'metric' => trim((string)($input['metric'] ?? '')),
            'tags' => is_array($tags) ? $tags : [],
            'demo_key' => trim((string)($input['demo_key'] ?? 'erp')),
            'live_url' => trim((string)($input['live_url'] ?? '')),
            'case_study_url' => trim((string)($input['case_study_url'] ?? 'case-studies')),
            'order' => (int)($input['order'] ?? (count($all) + 1)),
            'active' => !empty($input['active']),
            'created_at' => $existingIndex >= 0 ? ($all[$existingIndex]['created_at'] ?? $now) : $now,
            'updated_at' => $now,
        ];

        if ($existingIndex >= 0) {
            $all[$existingIndex] = $record;
        } else {
            $all[] = $record;
        }

        self::writeAll($all);
        return $record;
    }

    /**
     * Delete a project by ID.
     */
    public static function delete(string $id): bool
    {
        $all = self::getAll();
        $new = [];
        $found = false;

        foreach ($all as $item) {
            if (($item['id'] ?? '') === $id) {
                $found = true;
                continue;
            }
            $new[] = $item;
        }

        if ($found) {
            self::writeAll($new);
            return true;
        }

        return false;
    }

    /**
     * Toggle active status.
     */
    public static function toggleStatus(string $id): bool
    {
        $project = self::getById($id);
        if (!$project) {
            return false;
        }

        $project['active'] = !empty($project['active']) ? false : true;
        self::save($project);
        return true;
    }

    /**
     * Atomic write to file.
     * @param array<int, array<string, mixed>> $data
     */
    private static function writeAll(array $data): void
    {
        $file = self::getStoragePath();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        usort($data, fn($a, $b) => ($a['order'] ?? 99) <=> ($b['order'] ?? 99));

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            return;
        }

        $fp = fopen($file, 'c+b');
        if (!$fp) {
            file_put_contents($file, $json, LOCK_EX);
            return;
        }

        if (flock($fp, LOCK_EX)) {
            ftruncate($fp, 0);
            fwrite($fp, $json);
            fflush($fp);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }

    private static function slugify(string $text): string
    {
        $slug = strtolower(trim($text));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim((string)$slug, '-');
        return $slug ?: 'project-' . time();
    }

    private static function idExists(string $id, array $list): bool
    {
        foreach ($list as $item) {
            if (($item['id'] ?? '') === $id) {
                return true;
            }
        }
        return false;
    }
}
