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
 * Strictly enforces client privacy, NDA restrictions, and sanitization for public views.
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
     * Get dictionary of supported Project Types.
     * @return array<string, array<string, string>>
     */
    public static function getProjectTypes(): array
    {
        return [
            'client' => [
                'label' => 'Client Project',
                'badge' => 'badge-type-client',
                'color' => '#818CF8',
                'icon' => 'bi-briefcase-fill',
                'desc' => 'Commercial client platform engineered for production operations.'
            ],
            'internal' => [
                'label' => 'Internal Product',
                'badge' => 'badge-type-internal',
                'color' => '#22D3EE',
                'icon' => 'bi-building-fill-gear',
                'desc' => 'Proprietary platform built, operated, and maintained by CodeX404.'
            ],
            'concept' => [
                'label' => 'Concept / Prototype',
                'badge' => 'badge-type-concept',
                'color' => '#FBBF24',
                'icon' => 'bi-lightbulb-fill',
                'desc' => 'High-fidelity proof of concept and working technical architecture simulator.'
            ],
            'open_source' => [
                'label' => 'Open Source',
                'badge' => 'badge-type-oss',
                'color' => '#34D399',
                'icon' => 'bi-github',
                'desc' => 'Open-source software, developer utility, or architectural starter kit.'
            ]
        ];
    }

    /**
     * Get dictionary of supported Showcase Statuses.
     * @return array<string, array<string, string>>
     */
    public static function getShowcaseStatuses(): array
    {
        return [
            'live_website' => [
                'label' => 'Live Website',
                'badge' => 'badge-status-live',
                'icon' => 'bi-globe-americas',
                'color' => '#10B981'
            ],
            'interactive_demo' => [
                'label' => 'Interactive Demo',
                'badge' => 'badge-status-demo',
                'icon' => 'bi-lightning-charge-fill',
                'color' => '#06B6D4'
            ],
            'video_walkthrough' => [
                'label' => 'Video Walkthrough',
                'badge' => 'badge-status-video',
                'icon' => 'bi-camera-video-fill',
                'color' => '#8B5CF6'
            ],
            'case_study' => [
                'label' => 'Case Study',
                'badge' => 'badge-status-case',
                'icon' => 'bi-journal-richtext',
                'color' => '#F59E0B'
            ]
        ];
    }

    /**
     * Get dictionary of supported Client Permission Statuses.
     * @return array<string, array<string, string>>
     */
    public static function getPermissionStatuses(): array
    {
        return [
            'approved' => [
                'label' => 'Approved',
                'badge' => 'bg-success-subtle text-success border border-success-subtle',
                'icon' => 'bi-check-circle-fill'
            ],
            'approved_with_restrictions' => [
                'label' => 'Approved (Restricted)',
                'badge' => 'bg-info-subtle text-info border border-info-subtle',
                'icon' => 'bi-shield-check'
            ],
            'pending' => [
                'label' => 'Pending Approval',
                'badge' => 'bg-warning-subtle text-warning border border-warning-subtle',
                'icon' => 'bi-clock-history'
            ],
            'review_required' => [
                'label' => 'Review Required',
                'badge' => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                'icon' => 'bi-exclamation-circle'
            ],
            'denied' => [
                'label' => 'Denied / NDA',
                'badge' => 'bg-danger-subtle text-danger border border-danger-subtle',
                'icon' => 'bi-slash-circle'
            ]
        ];
    }

    /**
     * Normalizes a raw database or json record into full consistent shape.
     * @param array<string, mixed> $r
     * @return array<string, mixed>
     */
    private static function normalizeRecord(array $r): array
    {
        $r['order'] = (int)($r['order_num'] ?? $r['order'] ?? 0);
        $r['active'] = !empty($r['active']);
        $r['is_featured'] = !empty($r['is_featured']);
        $r['status'] = (string)($r['status'] ?? ($r['active'] ? 'published' : 'draft'));

        // Project taxonomy
        $r['project_type'] = (string)($r['project_type'] ?? 'client');
        $r['showcase_status'] = (string)($r['showcase_status'] ?? (!empty($r['live_url']) ? 'live_website' : 'interactive_demo'));

        // Client info & permissions
        $r['client_name'] = trim((string)($r['client_name'] ?? ''));
        $r['client_logo'] = trim((string)($r['client_logo'] ?? ''));
        $r['anonymized_name'] = trim((string)($r['anonymized_name'] ?? ''));
        $r['client_permission_status'] = (string)($r['client_permission_status'] ?? 'approved');
        $r['internal_notes'] = (string)($r['internal_notes'] ?? '');

        // Media & content
        $r['cover_image'] = trim((string)($r['cover_image'] ?? ''));
        $r['team_role'] = (string)($r['team_role'] ?? '');
        $r['verified_results'] = (string)($r['verified_results'] ?? '');
        $r['demo_url'] = trim((string)($r['demo_url'] ?? ''));
        $r['video_url'] = trim((string)($r['video_url'] ?? ''));
        $r['case_study_content'] = (string)($r['case_study_content'] ?? '');

        // JSON fields decoding
        if (isset($r['tags'])) {
            if (is_string($r['tags'])) {
                $r['tags'] = json_decode($r['tags'], true) ?: [];
            }
        } else {
            $r['tags'] = [];
        }

        if (isset($r['gallery'])) {
            if (is_string($r['gallery'])) {
                $r['gallery'] = json_decode($r['gallery'], true) ?: [];
            }
        } else {
            $r['gallery'] = [];
        }

        if (isset($r['features'])) {
            if (is_string($r['features'])) {
                $r['features'] = json_decode($r['features'], true) ?: [];
            }
        } else {
            $r['features'] = [];
        }

        if (isset($r['client_permission_restrictions'])) {
            if (is_string($r['client_permission_restrictions'])) {
                $r['client_permission_restrictions'] = json_decode($r['client_permission_restrictions'], true) ?: [];
            }
        } else {
            $r['client_permission_restrictions'] = [];
        }

        return $r;
    }

    /**
     * Enforce client privacy & NDA permission boundaries before exposing to public frontends.
     * @param array<string, mixed> $project
     * @return array<string, mixed>
     */
    public static function filterForPublic(array $project): array
    {
        $safe = $project;

        // 1. Strictly remove admin-only private notes and internal audit logs
        unset($safe['internal_notes']);

        // 2. Client permission rules
        $permStatus = $safe['client_permission_status'] ?? 'approved';
        $restrictions = is_array($safe['client_permission_restrictions'] ?? null)
            ? $safe['client_permission_restrictions']
            : [];

        $isClientProject = ($safe['project_type'] ?? 'client') === 'client';

        if ($isClientProject) {
            $allowName = false;
            $allowLogo = false;
            $allowLiveLink = true;
            $allowCaseStudy = true;
            $allowMetrics = true;
            $allowScreenshots = true;

            if ($permStatus === 'approved') {
                $allowName = true;
                $allowLogo = true;
                $allowLiveLink = true;
                $allowCaseStudy = true;
                $allowMetrics = true;
                $allowScreenshots = true;
            } elseif ($permStatus === 'approved_with_restrictions') {
                $allowName = !empty($restrictions['allow_client_name']);
                $allowLogo = !empty($restrictions['allow_client_logo']);
                $allowLiveLink = !empty($restrictions['allow_live_link']);
                $allowCaseStudy = !empty($restrictions['allow_case_study']);
                $allowMetrics = !empty($restrictions['allow_metrics']);
                $allowScreenshots = !empty($restrictions['allow_screenshots']);
            } else {
                // 'denied', 'pending', or 'review_required'
                $allowName = false;
                $allowLogo = false;
                $allowLiveLink = false;
                $allowCaseStudy = ($permStatus === 'pending'); // permit anonymized overview only if requested
                $allowMetrics = false;
                $allowScreenshots = false;
            }

            // Apply restrictions
            if (!$allowName) {
                $safe['is_anonymized'] = true;
                $categoryLabel = $safe['category_label'] ?? 'Enterprise';
                $safe['public_client_name'] = !empty($safe['anonymized_name'])
                    ? $safe['anonymized_name']
                    : "Confidential Client ({$categoryLabel})";
            } else {
                $safe['is_anonymized'] = false;
                $safe['public_client_name'] = !empty($safe['client_name'])
                    ? $safe['client_name']
                    : ($safe['anonymized_name'] ?: 'Verified Commercial Client');
            }

            if (!$allowLogo) {
                $safe['client_logo'] = '';
            }

            if (!$allowLiveLink) {
                $safe['live_url'] = '';
            }

            if (!$allowScreenshots) {
                $safe['gallery'] = [];
            }

            if (!$allowMetrics) {
                $safe['metric'] = '';
                $safe['verified_results'] = '';
            }

            if (!$allowCaseStudy) {
                $safe['case_study_content'] = '';
                $safe['case_study_url'] = '';
            }
        } else {
            // Internal, concept, or open source
            $safe['is_anonymized'] = false;
            $safe['public_client_name'] = !empty($safe['client_name'])
                ? $safe['client_name']
                : 'CodeX404 Engineering Lab';
        }

        return $safe;
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
                    $result = [];
                    foreach ($rows as $r) {
                        $result[] = self::normalizeRecord($r);
                    }
                    self::$memoized = $result;
                    return $result;
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

        $result = [];
        foreach ($data as $r) {
            $result[] = self::normalizeRecord($r);
        }

        usort($result, fn($a, $b) => ($a['order'] ?? 99) <=> ($b['order'] ?? 99));
        self::$memoized = $result;
        return $result;
    }

    /**
     * Get only active & published projects for public display, fully sanitized.
     * @return array<int, array<string, mixed>>
     */
    public static function getActive(): array
    {
        $all = self::getAll();
        $active = array_filter($all, function ($item) {
            $isPublished = ($item['status'] ?? 'published') === 'published';
            $isActive = !empty($item['active']);
            return $isActive && $isPublished;
        });

        $public = [];
        foreach ($active as $p) {
            $public[] = self::filterForPublic($p);
        }

        return array_values($public);
    }

    /**
     * Find a project by ID or slug.
     * @param string $id
     * @param bool $forAdmin Whether to preserve raw un-sanitized data for admin editing.
     * @return array<string, mixed>|null
     */
    public static function getById(string $id, bool $forAdmin = false): ?array
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
                    $normalized = self::normalizeRecord($r);
                    return $forAdmin ? $normalized : self::filterForPublic($normalized);
                }
            } catch (\Throwable $e) {
                // Fall through
            }
        }

        $all = self::getAll();
        foreach ($all as $item) {
            if (($item['id'] ?? '') === $cleanId) {
                return $forAdmin ? $item : self::filterForPublic($item);
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

        // Process array inputs
        $tags = $input['tags'] ?? [];
        if (is_string($tags)) {
            $tags = array_values(array_filter(array_map('trim', explode(',', $tags))));
        }

        $features = $input['features'] ?? [];
        if (is_string($features)) {
            $features = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $features)))));
        }

        $gallery = $input['gallery'] ?? [];
        if (is_string($gallery)) {
            $decoded = json_decode($gallery, true);
            if (is_array($decoded)) {
                $gallery = $decoded;
            } else {
                $gallery = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $gallery)))));
            }
        }

        $restrictions = $input['client_permission_restrictions'] ?? [];
        if (is_string($restrictions)) {
            $decoded = json_decode($restrictions, true);
            $restrictions = is_array($decoded) ? $decoded : [];
        }

        $now = date('Y-m-d H:i:s');
        $existing = self::getById($id, true);

        $status = trim((string)($input['status'] ?? (!empty($input['active']) ? 'published' : 'draft')));
        $active = ($status === 'published' || !empty($input['active']));

        $record = [
            'id' => $id,
            'title' => trim((string)($input['title'] ?? 'Untitled Project')),
            'category' => trim((string)($input['category'] ?? 'software')),
            'category_label' => trim((string)($input['category_label'] ?? 'Custom Software')),
            'project_type' => trim((string)($input['project_type'] ?? 'client')),
            'showcase_status' => trim((string)($input['showcase_status'] ?? 'live_website')),
            'badge_text' => trim((string)($input['badge_text'] ?? 'Production Live')),
            'badge_type' => trim((string)($input['badge_type'] ?? 'live')),
            'cover_image' => trim((string)($input['cover_image'] ?? '')),
            'gallery' => is_array($gallery) ? $gallery : [],
            'client_name' => trim((string)($input['client_name'] ?? '')),
            'client_logo' => trim((string)($input['client_logo'] ?? '')),
            'anonymized_name' => trim((string)($input['anonymized_name'] ?? '')),
            'client_permission_status' => trim((string)($input['client_permission_status'] ?? 'approved')),
            'client_permission_restrictions' => is_array($restrictions) ? $restrictions : [],
            'internal_notes' => trim((string)($input['internal_notes'] ?? '')),
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
            'features' => is_array($features) ? $features : [],
            'team_role' => trim((string)($input['team_role'] ?? '')),
            'metric' => trim((string)($input['metric'] ?? '')),
            'verified_results' => trim((string)($input['verified_results'] ?? '')),
            'tags' => is_array($tags) ? $tags : [],
            'demo_key' => trim((string)($input['demo_key'] ?? 'erp')),
            'demo_url' => trim((string)($input['demo_url'] ?? '')),
            'video_url' => trim((string)($input['video_url'] ?? '')),
            'live_url' => trim((string)($input['live_url'] ?? '')),
            'case_study_url' => trim((string)($input['case_study_url'] ?? 'case-studies')),
            'case_study_content' => trim((string)($input['case_study_content'] ?? '')),
            'order' => (int)($input['order'] ?? ($existing ? $existing['order'] : count($all) + 1)),
            'order_num' => (int)($input['order'] ?? ($existing ? $existing['order'] : count($all) + 1)),
            'status' => $status,
            'is_featured' => !empty($input['is_featured']),
            'active' => $active,
            'created_at' => $existing ? ($existing['created_at'] ?? $now) : $now,
            'updated_at' => $now,
        ];

        // 1. Save to MySQL
        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO `portfolio_projects` (
                        `id`, `title`, `category`, `category_label`, `project_type`, `showcase_status`,
                        `badge_text`, `badge_type`, `cover_image`, `gallery`,
                        `client_name`, `client_logo`, `anonymized_name`, `client_permission_status`,
                        `client_permission_restrictions`, `internal_notes`,
                        `mockup_host`, `mockup_tag1`, `mockup_tag2`,
                        `stat_1_val`, `stat_1_lbl`, `stat_2_val`, `stat_2_lbl`, `stat_3_val`, `stat_3_lbl`,
                        `problem`, `solution`, `features`, `team_role`, `metric`, `verified_results`,
                        `tags`, `demo_key`, `demo_url`, `video_url`, `live_url`,
                        `case_study_url`, `case_study_content`,
                        `order_num`, `status`, `is_featured`, `active`, `created_at`, `updated_at`
                    ) VALUES (
                        :id, :title, :category, :category_label, :project_type, :showcase_status,
                        :badge_text, :badge_type, :cover_image, :gallery,
                        :client_name, :client_logo, :anonymized_name, :client_permission_status,
                        :client_permission_restrictions, :internal_notes,
                        :mockup_host, :mockup_tag1, :mockup_tag2,
                        :stat_1_val, :stat_1_lbl, :stat_2_val, :stat_2_lbl, :stat_3_val, :stat_3_lbl,
                        :problem, :solution, :features, :team_role, :metric, :verified_results,
                        :tags, :demo_key, :demo_url, :video_url, :live_url,
                        :case_study_url, :case_study_content,
                        :order_num, :status, :is_featured, :active, :created_at, :updated_at
                    ) ON DUPLICATE KEY UPDATE
                        `title` = VALUES(`title`),
                        `category` = VALUES(`category`),
                        `category_label` = VALUES(`category_label`),
                        `project_type` = VALUES(`project_type`),
                        `showcase_status` = VALUES(`showcase_status`),
                        `badge_text` = VALUES(`badge_text`),
                        `badge_type` = VALUES(`badge_type`),
                        `cover_image` = VALUES(`cover_image`),
                        `gallery` = VALUES(`gallery`),
                        `client_name` = VALUES(`client_name`),
                        `client_logo` = VALUES(`client_logo`),
                        `anonymized_name` = VALUES(`anonymized_name`),
                        `client_permission_status` = VALUES(`client_permission_status`),
                        `client_permission_restrictions` = VALUES(`client_permission_restrictions`),
                        `internal_notes` = VALUES(`internal_notes`),
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
                        `features` = VALUES(`features`),
                        `team_role` = VALUES(`team_role`),
                        `metric` = VALUES(`metric`),
                        `verified_results` = VALUES(`verified_results`),
                        `tags` = VALUES(`tags`),
                        `demo_key` = VALUES(`demo_key`),
                        `demo_url` = VALUES(`demo_url`),
                        `video_url` = VALUES(`video_url`),
                        `live_url` = VALUES(`live_url`),
                        `case_study_url` = VALUES(`case_study_url`),
                        `case_study_content` = VALUES(`case_study_content`),
                        `order_num` = VALUES(`order_num`),
                        `status` = VALUES(`status`),
                        `is_featured` = VALUES(`is_featured`),
                        `active` = VALUES(`active`),
                        `updated_at` = VALUES(`updated_at`)
                ");

                $stmt->execute([
                    ':id' => $record['id'],
                    ':title' => $record['title'],
                    ':category' => $record['category'],
                    ':category_label' => $record['category_label'],
                    ':project_type' => $record['project_type'],
                    ':showcase_status' => $record['showcase_status'],
                    ':badge_text' => $record['badge_text'],
                    ':badge_type' => $record['badge_type'],
                    ':cover_image' => $record['cover_image'],
                    ':gallery' => json_encode($record['gallery']),
                    ':client_name' => $record['client_name'],
                    ':client_logo' => $record['client_logo'],
                    ':anonymized_name' => $record['anonymized_name'],
                    ':client_permission_status' => $record['client_permission_status'],
                    ':client_permission_restrictions' => json_encode($record['client_permission_restrictions']),
                    ':internal_notes' => $record['internal_notes'],
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
                    ':features' => json_encode($record['features']),
                    ':team_role' => $record['team_role'],
                    ':metric' => $record['metric'],
                    ':verified_results' => $record['verified_results'],
                    ':tags' => json_encode($record['tags']),
                    ':demo_key' => $record['demo_key'],
                    ':demo_url' => $record['demo_url'],
                    ':video_url' => $record['video_url'],
                    ':live_url' => $record['live_url'],
                    ':case_study_url' => $record['case_study_url'],
                    ':case_study_content' => $record['case_study_content'],
                    ':order_num' => $record['order_num'],
                    ':status' => $record['status'],
                    ':is_featured' => $record['is_featured'] ? 1 : 0,
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
     * Toggle active / publication status.
     */
    public static function toggleStatus(string $id): bool
    {
        $project = self::getById($id, true);
        if (!$project) {
            return false;
        }

        $wasActive = !empty($project['active']);
        $newActive = !$wasActive;
        $project['active'] = $newActive;
        $project['status'] = $newActive ? 'published' : 'draft';

        self::save($project);
        return true;
    }

    /**
     * Secure image upload helper for project media, covers, client logos, and screenshots.
     * @param array<string, mixed> $file PHP $_FILES entry
     * @param string $prefix Subfolder/filename prefix
     * @return array{success: bool, path?: string, error?: string}
     */
    public static function handleImageUpload(array $file, string $prefix = 'project'): array
    {
        if (empty($file['tmp_name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'No file was uploaded or an upload error occurred.'];
        }

        // 8MB limit
        if (($file['size'] ?? 0) > 8 * 1024 * 1024) {
            return ['success' => false, 'error' => 'Image file exceeds maximum allowed size of 8MB.'];
        }

        $allowedMimes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/svg+xml' => 'svg',
            'image/gif' => 'gif'
        ];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $detectedMime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!isset($allowedMimes[$detectedMime])) {
            return ['success' => false, 'error' => 'Invalid image format. Allowed formats: JPG, PNG, WEBP, SVG, GIF.'];
        }

        $ext = $allowedMimes[$detectedMime];
        $filename = $prefix . '-' . bin2hex(random_bytes(8)) . '.' . $ext;

        $targetDir = dirname(__DIR__, 2) . '/assets/images/projects';
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0755, true);
        }

        $targetPath = $targetDir . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['success' => false, 'error' => 'Failed to store uploaded image on server.'];
        }

        return [
            'success' => true,
            'path' => 'assets/images/projects/' . $filename
        ];
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
