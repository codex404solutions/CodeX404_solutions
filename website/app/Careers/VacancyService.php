<?php
declare(strict_types=1);

namespace App\Careers;

use PDO;

/**
 * Job categories and vacancy lifecycle management.
 */
final class VacancyService
{
    /**
     * Promote scheduled jobs whose publish timestamp has arrived, and optionally report due items.
     */
    public static function syncScheduledVacancies(): void
    {
        $pdo = CareersDB::pdo();
        $pdo->exec("
            UPDATE `job_openings`
            SET `status` = 'published', `published_at` = COALESCE(`published_at`, `scheduled_publish_at`, NOW())
            WHERE `status` = 'scheduled' AND `scheduled_publish_at` IS NOT NULL AND `scheduled_publish_at` <= NOW()
        ");
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function listCategories(): array
    {
        $pdo = CareersDB::pdo();
        return $pdo->query("SELECT * FROM `job_categories` WHERE `is_active` = 1 ORDER BY `sort_order` ASC, `name` ASC")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Public-facing open positions (ONLY published and not past deadline).
     *
     * @return array<int, array<string, mixed>>
     */
    public static function listPublicVacancies(string $categorySlug = '', string $search = ''): array
    {
        self::syncScheduledVacancies();
        $pdo = CareersDB::pdo();

        $sql = "
            SELECT j.*, c.slug AS category_slug, c.name AS category_name
            FROM `job_openings` j
            INNER JOIN `job_categories` c ON c.id = j.category_id
            WHERE j.status = 'published'
              AND (j.application_deadline IS NULL OR j.application_deadline >= CURDATE())
        ";
        $params = [];

        if ($categorySlug !== '' && $categorySlug !== 'all') {
            $sql .= " AND c.slug = :cat";
            $params[':cat'] = $categorySlug;
        }
        if ($search !== '') {
            $sql .= " AND (j.title LIKE :q1 OR j.department LIKE :q2 OR j.location LIKE :q3 OR j.skills LIKE :q4)";
            $like = '%' . $search . '%';
            $params[':q1'] = $like;
            $params[':q2'] = $like;
            $params[':q3'] = $like;
            $params[':q4'] = $like;
        }

        $sql .= " ORDER BY j.featured DESC, j.published_at DESC, j.id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lookup a vacancy by URL slug. Set $includeNonPublished=true ONLY for authenticated admin preview.
     */
    public static function getBySlug(string $slug, bool $includeNonPublished = false): ?array
    {
        self::syncScheduledVacancies();
        $pdo = CareersDB::pdo();
        $sql = "
            SELECT j.*, c.slug AS category_slug, c.name AS category_name, t.name AS form_template_name
            FROM `job_openings` j
            INNER JOIN `job_categories` c ON c.id = j.category_id
            LEFT JOIN `application_form_templates` t ON t.id = j.form_template_id
            WHERE j.slug = :slug
        ";
        if (!$includeNonPublished) {
            $sql .= " AND j.status = 'published' AND (j.application_deadline IS NULL OR j.application_deadline >= CURDATE())";
        }
        $sql .= " LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':slug' => trim($slug)]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public static function getById(int $id): ?array
    {
        self::syncScheduledVacancies();
        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("
            SELECT j.*, c.slug AS category_slug, c.name AS category_name
            FROM `job_openings` j
            INNER JOIN `job_categories` c ON c.id = j.category_id
            WHERE j.id = ? LIMIT 1
        ");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function listAdminVacancies(string $statusFilter = '', int $categoryId = 0, string $search = ''): array
    {
        self::syncScheduledVacancies();
        $pdo = CareersDB::pdo();
        $sql = "
            SELECT j.*, c.name AS category_name, c.slug AS category_slug,
                   t.name AS form_template_name,
                   (SELECT COUNT(*) FROM `applications` a WHERE a.job_opening_id = j.id) AS applications_count
            FROM `job_openings` j
            INNER JOIN `job_categories` c ON c.id = j.category_id
            LEFT JOIN `application_form_templates` t ON t.id = j.form_template_id
            WHERE 1=1
        ";
        $params = [];
        if ($statusFilter !== '' && $statusFilter !== 'all') {
            $sql .= " AND j.status = :st";
            $params[':st'] = $statusFilter;
        }
        if ($categoryId > 0) {
            $sql .= " AND j.category_id = :cid";
            $params[':cid'] = $categoryId;
        }
        if ($search !== '') {
            $sql .= " AND (j.title LIKE :q1 OR j.slug LIKE :q2 OR j.department LIKE :q3)";
            $like = '%' . $search . '%';
            $params[':q1'] = $like;
            $params[':q2'] = $like;
            $params[':q3'] = $like;
        }
        $sql .= " ORDER BY j.updated_at DESC, j.id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create or update a job vacancy.
     */
    public static function saveVacancy(array $input, string $actorId, string $actorName): int
    {
        $pdo = CareersDB::pdo();
        $id = (int)($input['id'] ?? 0);
        $title = trim((string)($input['title'] ?? ''));
        if ($title === '') {
            throw new \InvalidArgumentException('Job title is required.');
        }

        $rawSlug = trim((string)($input['slug'] ?? ''));
        $slug = CareersDB::slugify($rawSlug !== '' ? $rawSlug : $title);

        // Ensure unique slug
        $baseSlug = $slug;
        $counter = 2;
        while (true) {
            $chk = $pdo->prepare("SELECT id FROM `job_openings` WHERE `slug` = ? AND `id` != ? LIMIT 1");
            $chk->execute([$slug, $id]);
            if (!$chk->fetchColumn()) {
                break;
            }
            $slug = $baseSlug . '-' . $counter++;
        }

        $status = strtolower(trim((string)($input['status'] ?? 'draft')));
        if (!isset(CareersDB::JOB_STATUSES[$status])) {
            $status = 'draft';
        }

        $scheduledAt = trim((string)($input['scheduled_publish_at'] ?? ''));
        $scheduledVal = ($status === 'scheduled' && $scheduledAt !== '') ? date('Y-m-d H:i:s', strtotime($scheduledAt)) : null;

        $deadline = trim((string)($input['application_deadline'] ?? ''));
        $deadlineVal = $deadline !== '' ? date('Y-m-d', strtotime($deadline)) : null;

        $formTemplateId = !empty($input['form_template_id']) ? (int)$input['form_template_id'] : null;
        $useCustomForm = !empty($input['use_custom_form']) ? 1 : 0;

        $data = [
            ':slug'      => $slug,
            ':title'     => $title,
            ':cat_id'    => max(1, (int)($input['category_id'] ?? 1)),
            ':dept'      => trim((string)($input['department'] ?? 'Operations')),
            ':emp_type'  => trim((string)($input['employment_type'] ?? 'Full-Time')),
            ':work_mode' => in_array($input['work_mode'] ?? 'Remote', ['Remote', 'Hybrid', 'On-Site'], true) ? $input['work_mode'] : 'Remote',
            ':location'  => trim((string)($input['location'] ?? 'Remote')),
            ':exp_lvl'   => trim((string)($input['experience_level'] ?? 'Mid-Level')),
            ':exp_min'   => is_numeric($input['experience_min_years'] ?? null) ? (float)$input['experience_min_years'] : 0.0,
            ':comp_type' => trim((string)($input['compensation_type'] ?? 'Salary')),
            ':sal_disp'  => trim((string)($input['salary_display'] ?? '')) ?: null,
            ':vacancies' => max(1, (int)($input['vacancies_count'] ?? 1)),
            ':hours'     => trim((string)($input['working_hours'] ?? '')) ?: null,
            ':overview'  => trim((string)($input['overview'] ?? '')),
            ':about'     => trim((string)($input['about_position'] ?? '')),
            ':resp'      => trim((string)($input['responsibilities'] ?? '')),
            ':qual'      => trim((string)($input['qualifications'] ?? '')),
            ':skills'    => trim((string)($input['skills'] ?? '')),
            ':cond'      => trim((string)($input['employment_conditions'] ?? '')) ?: null,
            ':status'    => $status,
            ':sched_at'  => $scheduledVal,
            ':deadline'  => $deadlineVal,
            ':tpl_id'    => $formTemplateId,
            ':custom'    => $useCustomForm,
            ':featured'  => !empty($input['featured']) ? 1 : 0,
            ':seo_title' => trim((string)($input['seo_title'] ?? '')) ?: null,
            ':seo_desc'  => trim((string)($input['seo_description'] ?? '')) ?: null,
            ':actor'     => $actorId,
        ];

        if ($id > 0) {
            $existing = self::getById($id);
            $pubAt = $existing['published_at'] ?? null;
            if ($status === 'published' && empty($pubAt)) {
                $pubAt = date('Y-m-d H:i:s');
            }
            $data[':pub_at'] = $pubAt;
            $data[':id'] = $id;

            $stmt = $pdo->prepare("
                UPDATE `job_openings` SET
                    `slug` = :slug, `title` = :title, `category_id` = :cat_id, `department` = :dept,
                    `employment_type` = :emp_type, `work_mode` = :work_mode, `location` = :location,
                    `experience_level` = :exp_lvl, `experience_min_years` = :exp_min,
                    `compensation_type` = :comp_type, `salary_display` = :sal_disp,
                    `vacancies_count` = :vacancies, `working_hours` = :hours,
                    `overview` = :overview, `about_position` = :about,
                    `responsibilities` = :resp, `qualifications` = :qual, `skills` = :skills,
                    `employment_conditions` = :cond, `status` = :status,
                    `scheduled_publish_at` = :sched_at, `published_at` = :pub_at,
                    `application_deadline` = :deadline, `form_template_id` = :tpl_id,
                    `use_custom_form` = :custom, `featured` = :featured,
                    `seo_title` = :seo_title, `seo_description` = :seo_desc, `updated_by` = :actor
                WHERE `id` = :id
            ");
            $stmt->execute($data);
            ActivityLogService::log('admin', $actorId, $actorName, 'job.updated', 'job_opening', (string)$id, "Updated vacancy '{$title}' ({$status})");
        } else {
            $data[':pub_at'] = $status === 'published' ? date('Y-m-d H:i:s') : null;
            $data[':created_by'] = $actorId;
            $data[':updated_by'] = $actorId;
            unset($data[':actor']);
            $stmt = $pdo->prepare("
                INSERT INTO `job_openings` (
                    `slug`, `title`, `category_id`, `department`, `employment_type`, `work_mode`, `location`,
                    `experience_level`, `experience_min_years`, `compensation_type`, `salary_display`,
                    `vacancies_count`, `working_hours`, `overview`, `about_position`, `responsibilities`,
                    `qualifications`, `skills`, `employment_conditions`, `status`, `scheduled_publish_at`,
                    `published_at`, `application_deadline`, `form_template_id`, `use_custom_form`, `featured`,
                    `seo_title`, `seo_description`, `created_by`, `updated_by`
                ) VALUES (
                    :slug, :title, :cat_id, :dept, :emp_type, :work_mode, :location,
                    :exp_lvl, :exp_min, :comp_type, :sal_disp,
                    :vacancies, :hours, :overview, :about, :resp,
                    :qual, :skills, :cond, :status, :sched_at,
                    :pub_at, :deadline, :tpl_id, :custom, :featured,
                    :seo_title, :seo_desc, :created_by, :updated_by
                )
            ");
            $stmt->execute($data);
            $id = (int)$pdo->lastInsertId();
            ActivityLogService::log('admin', $actorId, $actorName, 'job.created', 'job_opening', (string)$id, "Created vacancy '{$title}' ({$status})");
        }

        if ($useCustomForm && $formTemplateId) {
            FormBuilderService::ensureJobHasCustomFieldsFromTemplate($id, $formTemplateId);
        }

        return $id;
    }

    public static function updateStatus(int $id, string $newStatus, string $actorId, string $actorName): void
    {
        if (!isset(CareersDB::JOB_STATUSES[$newStatus])) {
            throw new \InvalidArgumentException('Invalid job status.');
        }
        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("
            UPDATE `job_openings`
            SET `status` = ?,
                `published_at` = CASE WHEN ? = 'published' AND `published_at` IS NULL THEN NOW() ELSE `published_at` END,
                `updated_by` = ?
            WHERE `id` = ?
        ");
        $stmt->execute([$newStatus, $newStatus, $actorId, $id]);
        ActivityLogService::log('admin', $actorId, $actorName, 'job.status_changed', 'job_opening', (string)$id, "Set vacancy #{$id} status to {$newStatus}");
    }

    public static function duplicateVacancy(int $id, string $actorId, string $actorName): int
    {
        $job = self::getById($id);
        if (!$job) {
            throw new \RuntimeException('Vacancy not found.');
        }

        $copyInput = $job;
        unset($copyInput['id']);
        $copyInput['title'] = $job['title'] . ' (Copy)';
        $copyInput['slug'] = $job['slug'] . '-copy';
        $copyInput['status'] = 'draft';
        $copyInput['scheduled_publish_at'] = null;
        $newId = self::saveVacancy($copyInput, $actorId, $actorName);

        if (!empty($job['use_custom_form'])) {
            FormBuilderService::copyJobFields($id, $newId);
        }

        ActivityLogService::log('admin', $actorId, $actorName, 'job.duplicated', 'job_opening', (string)$newId, "Duplicated vacancy #{$id} to #{$newId}");
        return $newId;
    }
}
