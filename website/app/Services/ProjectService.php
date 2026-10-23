<?php
declare(strict_types=1);

namespace App\Services;

use Database;
use PDO;

require_once dirname(__DIR__, 2) . '/config/database.php';

/**
 * ProjectService
 * High-performance data service for CodeX404 portfolio projects.
 * Primary storage: MySQL Database (codex404_db -> portfolio_projects).
 * Request-scoped memory caching with graceful JSON store fallback.
 */
class ProjectService
{
    private static string $filePath = '';
    private static ?array $memoized = null;

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
        if (self::$memoized !== null) {
            return self::$memoized;
        }

        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT * FROM `portfolio_projects` ORDER BY `order_num` ASC, `created_at` DESC");
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (is_array($rows)) {
                    foreach ($rows as &$r) {
                        $r['order'] = (int)($r['order_num'] ?? 0);
                        $r['active'] = !empty($r['active']);
                        if (isset($r['tags']) && is_string($r['tags'])) {
                            $r['tags'] = json_decode($r['tags'], true) ?: [];
                        }
                    }
                    unset($r);
                    self::$memoized = $rows;
                    return $rows;
                }
            } catch (\Throwable $e) {
                // Fall through to JSON fallback
            }
        }

        // File-backed fallback
        $file = self::getStoragePath();
        if (!file_exists($file)) {
            self::$memoized = [];
            return [];
        }

        $contents = @file_get_contents($file);
        if (!$contents) {
            self::$memoized = [];
            return [];
        }

        $data = json_decode($contents, true);
        if (!is_array($data)) {
            self::$memoized = [];
            return [];
        }

        usort($data, fn($a, $b) => ($a['order'] ?? 99) <=> ($b['order'] ?? 99));
        self::$memoized = $data;
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

        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM `portfolio_projects` WHERE `id` = :id LIMIT 1");
                $stmt->execute([':id' => $cleanId]);
                $r = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($r) {
                    $r['order'] = (int)($r['order_num'] ?? 0);
                    $r['active'] = !empty($r['active']);
                    if (isset($r['tags']) && is_string($r['tags'])) {
                        $r['tags'] = json_decode($r['tags'], true) ?: [];
                    }
                    return $r;
                }
            } catch (\Throwable $e) {
                // Fall through
            }
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
        $existing = self::getById($id);

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
            'order' => (int)($input['order'] ?? ($existing ? $existing['order'] : count($all) + 1)),
            'active' => !empty($input['active']),
            'created_at' => $existing ? ($existing['created_at'] ?? $now) : $now,
            'updated_at' => $now,
        ];

        // 1. Save to MySQL
        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO `portfolio_projects` (
                        `id`, `title`, `category`, `category_label`, `badge_text`, `badge_type`,
                        `mockup_host`, `mockup_tag1`, `mockup_tag2`,
                        `stat_1_val`, `stat_1_lbl`, `stat_2_val`, `stat_2_lbl`, `stat_3_val`, `stat_3_lbl`,
                        `problem`, `solution`, `metric`, `tags`, `demo_key`, `live_url`, `case_study_url`,
                        `order_num`, `active`, `created_at`, `updated_at`
                    ) VALUES (
                        :id, :title, :category, :category_label, :badge_text, :badge_type,
                        :mockup_host, :mockup_tag1, :mockup_tag2,
                        :stat_1_val, :stat_1_lbl, :stat_2_val, :stat_2_lbl, :stat_3_val, :stat_3_lbl,
                        :problem, :solution, :metric, :tags, :demo_key, :live_url, :case_study_url,
                        :order_num, :active, :created_at, :updated_at
                    ) ON DUPLICATE KEY UPDATE
                        `title` = VALUES(`title`),
                        `category` = VALUES(`category`),
                        `category_label` = VALUES(`category_label`),
                        `badge_text` = VALUES(`badge_text`),
                        `badge_type` = VALUES(`badge_type`),
                        `mockup_host` = VALUES(`mockup_host`),
                        `mockup_tag1` = VALUES(`mockup_tag1`),
                        `mockup_tag2` = VALUES(`mockup_tag2`),
                        `stat_1_val` = VALUES(`stat_1_val`),
                        `stat_1_lbl` = VALUES(`stat_1_lbl`),
                        `stat_2_val` = VALUES(`stat_2_val`),
                        `stat_2_lbl` = VALUES(`stat_2_lbl`),
                        `stat_3_val` = VALUES(`stat_3_val`),
                        `stat_3_lbl` = VALUES(`stat_3_lbl`),
                        `problem` = VALUES(`problem`),
                        `solution` = VALUES(`solution`),
                        `metric` = VALUES(`metric`),
                        `tags` = VALUES(`tags`),
                        `demo_key` = VALUES(`demo_key`),
                        `live_url` = VALUES(`live_url`),
                        `case_study_url` = VALUES(`case_study_url`),
                        `order_num` = VALUES(`order_num`),
                        `active` = VALUES(`active`),
                        `updated_at` = VALUES(`updated_at`)
                ");
                $stmt->execute([
                    ':id' => $record['id'],
                    ':title' => $record['title'],
                    ':category' => $record['category'],
                    ':category_label' => $record['category_label'],
                    ':badge_text' => $record['badge_text'],
                    ':badge_type' => $record['badge_type'],
                    ':mockup_host' => $record['mockup_host'],
                    ':mockup_tag1' => $record['mockup_tag1'],
                    ':mockup_tag2' => $record['mockup_tag2'],
                    ':stat_1_val' => $record['stat_1_val'],
                    ':stat_1_lbl' => $record['stat_1_lbl'],
                    ':stat_2_val' => $record['stat_2_val'],
                    ':stat_2_lbl' => $record['stat_2_lbl'],
                    ':stat_3_val' => $record['stat_3_val'],
                    ':stat_3_lbl' => $record['stat_3_lbl'],
                    ':problem' => $record['problem'],
                    ':solution' => $record['solution'],
                    ':metric' => $record['metric'],
                    ':tags' => json_encode($record['tags']),
                    ':demo_key' => $record['demo_key'],
                    ':live_url' => $record['live_url'],
                    ':case_study_url' => $record['case_study_url'],
                    ':order_num' => $record['order'],
                    ':active' => $record['active'] ? 1 : 0,
                    ':created_at' => $record['created_at'],
                    ':updated_at' => $record['updated_at']
                ]);
            } catch (\Throwable $e) {
                // Fallback to file write
            }
        }

        // 2. Synchronize memory & backup JSON file
        self::$memoized = null;
        $updatedAll = [];
        $replaced = false;
        foreach ($all as $item) {
            if (($item['id'] ?? '') === $id) {
                $updatedAll[] = $record;
                $replaced = true;
            } else {
                $updatedAll[] = $item;
            }
        }
        if (!$replaced) {
            $updatedAll[] = $record;
        }

        self::writeAll($updatedAll);
        return $record;
    }

    /**
     * Delete a project by ID.
     */
    public static function delete(string $id): bool
    {
        $cleanId = trim($id);
        self::$memoized = null;

        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("DELETE FROM `portfolio_projects` WHERE `id` = :id");
                $stmt->execute([':id' => $cleanId]);
            } catch (\Throwable $e) {
                // Continue
            }
        }

        $all = self::getAll();
        $new = [];
        $found = false;

        foreach ($all as $item) {
            if (($item['id'] ?? '') === $cleanId) {
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
     * Atomic write to file backup.
     * @param array<int, array<string, mixed>> $data
     */
    private static function writeAll(array $data): void
    {
        $file = self::getStoragePath();
        $dir = dirname($file);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }

        usort($data, fn($a, $b) => ($a['order'] ?? 99) <=> ($b['order'] ?? 99));

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            return;
        }

        @file_put_contents($file, $json, LOCK_EX);
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
