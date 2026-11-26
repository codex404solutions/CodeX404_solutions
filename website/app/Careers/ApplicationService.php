<?php
declare(strict_types=1);

namespace App\Careers;

use PDO;

/**
 * Full recruitment pipeline, candidate lifecycle, interviews, messaging, CSV export, and Applicant Portal operations.
 */
final class ApplicationService
{
    /**
     * Submit a vacancy application or General Talent Pool submission.
     *
     * @return array{application_id:int, reference_code:string, candidate_id:int, application_type:string}
     */
    public static function submitApplication(?array $job, array $postData, array $filesData): array
    {
        $pdo = CareersDB::pdo();

        // Honeypot spam defense
        if (trim((string)($postData['website_hp'] ?? '')) !== '') {
            throw new \RuntimeException('Spam filter triggered.');
        }

        $fields = FormBuilderService::getEffectiveFields($job);
        $validation = FormBuilderService::validateSubmission($fields, $postData, $filesData);
        if (!$validation['ok']) {
            $firstErr = (string)reset($validation['errors']);
            throw new FormValidationException($validation['errors'], $firstErr !== '' ? $firstErr : 'Please review the highlighted fields.');
        }

        $answers = $validation['answers'];
        $storedFiles = $validation['files'];

        $email = strtolower(trim((string)($answers['email'] ?? ($postData['fields']['email'] ?? ''))));
        $fullName = trim((string)($answers['full_name'] ?? ($postData['fields']['full_name'] ?? 'Candidate')));
        $phone = trim((string)($answers['phone'] ?? ($postData['fields']['phone'] ?? '')));
        $country = trim((string)($answers['country'] ?? ''));
        $city = trim((string)($answers['city'] ?? ''));
        $empStatus = trim((string)($answers['current_employment_status'] ?? ''));
        $yoe = is_numeric($answers['years_of_experience'] ?? null) ? (float)$answers['years_of_experience'] : null;
        $linkedin = trim((string)($answers['linkedin_url'] ?? ''));
        $portfolio = trim((string)($answers['portfolio_github_url'] ?? ''));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('A valid email address is required.');
        }

        $jobId = $job ? (int)$job['id'] : null;
        $isGeneral = $jobId === null;
        $appType = $isGeneral ? 'general_talent_pool' : 'vacancy';

        // Duplicate submission protection
        if ($jobId !== null) {
            $dup = $pdo->prepare("
                SELECT a.reference_code
                FROM `applications` a
                INNER JOIN `candidate_profiles` cp ON cp.id = a.candidate_id
                WHERE LOWER(cp.email) = ? AND a.job_opening_id = ?
                  AND a.status NOT IN ('rejected', 'withdrawn')
                LIMIT 1
            ");
            $dup->execute([$email, $jobId]);
            $existingRef = $dup->fetchColumn();
            if ($existingRef) {
                throw new \RuntimeException("You already have an active application ({$existingRef}) for this position. Track or manage it inside the Applicant Portal.");
            }
        } else {
            $dupGen = $pdo->prepare("
                SELECT a.reference_code
                FROM `applications` a
                INNER JOIN `candidate_profiles` cp ON cp.id = a.candidate_id
                WHERE LOWER(cp.email) = ? AND a.application_type = 'general_talent_pool'
                  AND a.submitted_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                  AND a.status != 'withdrawn'
                LIMIT 1
            ");
            $dupGen->execute([$email]);
            $existingRef = $dupGen->fetchColumn();
            if ($existingRef) {
                throw new \RuntimeException("A General Talent Pool profile ({$existingRef}) was recently submitted for this email.");
            }
        }

        $primaryResume = $storedFiles['resume_cv'] ?? (!empty($storedFiles) ? reset($storedFiles) : null);

        $pdo->beginTransaction();
        try {
            // Upsert candidate profile
            $cStmt = $pdo->prepare("SELECT * FROM `candidate_profiles` WHERE LOWER(`email`) = ? LIMIT 1");
            $cStmt->execute([$email]);
            $existingCandidate = $cStmt->fetch(PDO::FETCH_ASSOC);

            if ($existingCandidate) {
                $candidateId = (int)$existingCandidate['id'];
                $updC = $pdo->prepare("
                    UPDATE `candidate_profiles`
                    SET `full_name` = ?, `phone` = COALESCE(NULLIF(?, ''), `phone`),
                        `country` = COALESCE(NULLIF(?, ''), `country`),
                        `city` = COALESCE(NULLIF(?, ''), `city`),
                        `employment_status` = COALESCE(NULLIF(?, ''), `employment_status`),
                        `years_of_experience` = COALESCE(?, `years_of_experience`),
                        `linkedin_url` = COALESCE(NULLIF(?, ''), `linkedin_url`),
                        `portfolio_url` = COALESCE(NULLIF(?, ''), `portfolio_url`),
                        `primary_resume_path` = COALESCE(?, `primary_resume_path`)
                    WHERE `id` = ?
                ");
                $updC->execute([
                    $fullName,
                    $phone,
                    $country,
                    $city,
                    $empStatus,
                    $yoe,
                    $linkedin,
                    $portfolio,
                    $primaryResume['relative_path'] ?? null,
                    $candidateId,
                ]);
            } else {
                $insC = $pdo->prepare("
                    INSERT INTO `candidate_profiles`
                        (`full_name`, `email`, `phone`, `country`, `city`, `employment_status`, `years_of_experience`, `linkedin_url`, `portfolio_url`, `primary_resume_path`, `status_flag`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $insC->execute([
                    $fullName,
                    $email,
                    $phone ?: null,
                    $country ?: null,
                    $city ?: null,
                    $empStatus ?: null,
                    $yoe,
                    $linkedin ?: null,
                    $portfolio ?: null,
                    $primaryResume['relative_path'] ?? null,
                    $isGeneral ? 'talent_pool' : 'active',
                ]);
                $candidateId = (int)$pdo->lastInsertId();
            }

            $refCode = CareersDB::generateReferenceCode($pdo, $isGeneral);
            $coverSummary = trim((string)($answers['why_join_codex404'] ?? ($answers['relevant_experience_summary'] ?? '')));

            $insApp = $pdo->prepare("
                INSERT INTO `applications`
                    (`reference_code`, `job_opening_id`, `candidate_id`, `application_type`, `status`, `resume_path`, `resume_original_name`, `resume_mime`, `resume_size_bytes`, `cover_summary`, `answers_snapshot_json`, `consent_privacy`, `consent_accuracy`, `source_ip_hash`)
                VALUES (?, ?, ?, ?, 'new', ?, ?, ?, ?, ?, ?, 1, 1, ?)
            ");
            $insApp->execute([
                $refCode,
                $jobId,
                $candidateId,
                $appType,
                $primaryResume['relative_path'] ?? null,
                $primaryResume['original_name'] ?? null,
                $primaryResume['mime'] ?? null,
                $primaryResume['size_bytes'] ?? null,
                $coverSummary !== '' ? mb_substr($coverSummary, 0, 2000) : null,
                json_encode($answers, JSON_UNESCAPED_UNICODE),
                CareersDB::hashIp(),
            ]);
            $appId = (int)$pdo->lastInsertId();

            // Persist normalized answers per field
            $insAns = $pdo->prepare("
                INSERT INTO `application_answers`
                    (`application_id`, `field_id`, `field_key`, `field_label`, `field_type`, `answer_text`, `answer_json`, `file_path`, `file_original_name`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            foreach ($fields as $f) {
                $k = (string)$f['field_key'];
                $val = $answers[$k] ?? null;
                $fileInfo = $storedFiles[$k] ?? null;
                $isArr = is_array($val);
                $insAns->execute([
                    $appId,
                    (int)$f['id'],
                    $k,
                    (string)$f['label'],
                    (string)$f['field_type'],
                    $isArr ? implode(', ', $val) : (string)($val ?? ''),
                    $isArr ? json_encode($val, JSON_UNESCAPED_UNICODE) : null,
                    $fileInfo['relative_path'] ?? null,
                    $fileInfo['original_name'] ?? null,
                ]);
            }

            // Initial timeline entry
            $pdo->prepare("
                INSERT INTO `application_status_history`
                    (`application_id`, `from_status`, `to_status`, `changed_by_type`, `changed_by_id`, `changed_by_name`, `public_note`)
                VALUES (?, NULL, 'new', 'applicant', ?, ?, ?)
            ")->execute([
                $appId,
                (string)$candidateId,
                $fullName,
                $isGeneral ? 'General Talent Pool profile received by CodeX404 Recruitment.' : 'Application submitted and queued for review.',
            ]);

            $pdo->commit();
        } catch (\Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }

        $jobTitle = $job ? (string)$job['title'] : 'General Talent Pool';
        ActivityLogService::notifyApplicant(
            $candidateId,
            $appId,
            'application_submitted',
            "Application Received ({$refCode})",
            "Your application for {$jobTitle} was submitted successfully."
        );
        ActivityLogService::log('applicant', (string)$candidateId, $fullName, 'application.submitted', 'application', (string)$appId, "Submitted application {$refCode} for {$jobTitle}");

        // Send Candidate confirmation & Admin alert emails
        $vars = [
            'candidate_name' => $fullName,
            'job_title'      => $jobTitle,
            'application_id' => $refCode,
            'portal_url'     => function_exists('url') ? url('careers/candidate-portal') : '/careers/candidate-portal',
        ];
        RecruitmentEmailService::sendTemplate('application_confirmation', $email, $fullName, $vars, $appId, $candidateId, 'system');

        $hrEmail = RecruitmentSettingsService::getString('hr_notification_email', 'info@codex404solutions.com');
        $adminVars = $vars;
        $adminVars['portal_url'] = function_exists('admin_url') ? admin_url('careers?tab=applications&view=' . $appId) : '/admin/careers';
        RecruitmentEmailService::sendTemplate('admin_new_application_alert', $hrEmail, 'Recruitment Admin', $adminVars, $appId, $candidateId, 'system');

        return [
            'application_id'   => $appId,
            'reference_code'   => $refCode,
            'candidate_id'     => $candidateId,
            'application_type' => $appType,
        ];
    }

    /**
     * Dashboard KPI summary queried live from MySQL.
     */
    public static function getOverviewStats(): array
    {
        VacancyService::syncScheduledVacancies();
        $pdo = CareersDB::pdo();
        return [
            'total_jobs'          => (int)$pdo->query("SELECT COUNT(*) FROM `job_openings`")->fetchColumn(),
            'published_jobs'      => (int)$pdo->query("SELECT COUNT(*) FROM `job_openings` WHERE `status` = 'published'")->fetchColumn(),
            'total_applications'  => (int)$pdo->query("SELECT COUNT(*) FROM `applications`")->fetchColumn(),
            'new_applications'    => (int)$pdo->query("SELECT COUNT(*) FROM `applications` WHERE `status` = 'new'")->fetchColumn(),
            'shortlisted_count'   => (int)$pdo->query("SELECT COUNT(*) FROM `applications` WHERE `status` IN ('shortlisted','interview_scheduled','selected','offer_sent')")->fetchColumn(),
            'hired_count'         => (int)$pdo->query("SELECT COUNT(*) FROM `applications` WHERE `status` = 'hired'")->fetchColumn(),
            'talent_pool_count'   => (int)$pdo->query("SELECT COUNT(*) FROM `applications` WHERE `application_type` = 'general_talent_pool'")->fetchColumn(),
            'upcoming_interviews' => (int)$pdo->query("SELECT COUNT(*) FROM `interview_schedules` WHERE `status` IN ('scheduled','rescheduled') AND `scheduled_at` >= NOW()")->fetchColumn(),
            'unread_del_requests' => (int)$pdo->query("SELECT COUNT(*) FROM `candidate_profiles` WHERE `deletion_requested_at` IS NOT NULL")->fetchColumn(),
        ];
    }

    /**
     * Admin applications query with search, filtering, sorting, and pagination.
     */
    public static function listApplications(array $filters = [], int $page = 1, int $perPage = 20): array
    {
        $pdo = CareersDB::pdo();
        $where = ['1=1'];
        $params = [];

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $where[] = 'a.status = :status';
            $params[':status'] = $filters['status'];
        }
        if (!empty($filters['job_id'])) {
            if ($filters['job_id'] === 'general') {
                $where[] = "a.application_type = 'general_talent_pool'";
            } elseif (is_numeric($filters['job_id'])) {
                $where[] = 'a.job_opening_id = :job_id';
                $params[':job_id'] = (int)$filters['job_id'];
            }
        }
        if (!empty($filters['type']) && in_array($filters['type'], ['vacancy', 'general_talent_pool'], true)) {
            $where[] = 'a.application_type = :atype';
            $params[':atype'] = $filters['type'];
        }
        if (!empty($filters['search'])) {
            $where[] = '(cp.full_name LIKE :q1 OR cp.email LIKE :q2 OR a.reference_code LIKE :q3 OR COALESCE(j.title, "") LIKE :q4)';
            $like = '%' . trim((string)$filters['search']) . '%';
            $params[':q1'] = $like;
            $params[':q2'] = $like;
            $params[':q3'] = $like;
            $params[':q4'] = $like;
        }
        if (!empty($filters['recruiter_id'])) {
            $where[] = 'a.assigned_recruiter_id = :rec';
            $params[':rec'] = $filters['recruiter_id'];
        }

        $whereSql = implode(' AND ', $where);
        $countStmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM `applications` a
            INNER JOIN `candidate_profiles` cp ON cp.id = a.candidate_id
            LEFT JOIN `job_openings` j ON j.id = a.job_opening_id
            WHERE {$whereSql}
        ");
        $countStmt->execute($params);
        $total = (int)$countStmt->fetchColumn();

        $sortMap = [
            'newest' => 'a.submitted_at DESC',
            'oldest' => 'a.submitted_at ASC',
            'name'   => 'cp.full_name ASC',
            'status' => 'a.status ASC, a.submitted_at DESC',
        ];
        $orderBy = $sortMap[$filters['sort'] ?? 'newest'] ?? 'a.submitted_at DESC';

        $page = max(1, $page);
        $perPage = max(1, min(100, $perPage));
        $offset = ($page - 1) * $perPage;

        $sql = "
            SELECT a.*, cp.full_name, cp.email, cp.phone, cp.city, cp.country, cp.years_of_experience, cp.tags_json,
                   COALESCE(j.title, 'General Talent Pool') AS job_title, j.slug AS job_slug, j.department,
                   u.name AS assigned_recruiter_name
            FROM `applications` a
            INNER JOIN `candidate_profiles` cp ON cp.id = a.candidate_id
            LEFT JOIN `job_openings` j ON j.id = a.job_opening_id
            LEFT JOIN `users` u ON u.id = a.assigned_recruiter_id
            WHERE {$whereSql}
            ORDER BY {$orderBy}
            LIMIT {$perPage} OFFSET {$offset}
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return [
            'items'       => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total'       => $total,
            'page'        => $page,
            'per_page'    => $perPage,
            'total_pages' => max(1, (int)ceil($total / $perPage)),
        ];
    }

    public static function getApplicationDetail(int $applicationId): ?array
    {
        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("
            SELECT a.*, cp.full_name, cp.email, cp.phone, cp.country, cp.city, cp.employment_status,
                   cp.years_of_experience, cp.linkedin_url, cp.portfolio_url, cp.tags_json,
                   cp.notify_status_updates, cp.notify_interview_updates, cp.deletion_requested_at, cp.deletion_request_reason,
                   COALESCE(j.title, 'General Talent Pool') AS job_title, j.slug AS job_slug, j.department,
                   j.employment_type, j.work_mode, j.location AS job_location,
                   u.name AS assigned_recruiter_name
            FROM `applications` a
            INNER JOIN `candidate_profiles` cp ON cp.id = a.candidate_id
            LEFT JOIN `job_openings` j ON j.id = a.job_opening_id
            LEFT JOIN `users` u ON u.id = a.assigned_recruiter_id
            WHERE a.id = ? LIMIT 1
        ");
        $stmt->execute([$applicationId]);
        $app = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$app) {
            return null;
        }

        $ans = $pdo->prepare("SELECT * FROM `application_answers` WHERE `application_id` = ? ORDER BY `id` ASC");
        $ans->execute([$applicationId]);
        $app['answers'] = $ans->fetchAll(PDO::FETCH_ASSOC);

        $hist = $pdo->prepare("SELECT * FROM `application_status_history` WHERE `application_id` = ? ORDER BY `created_at` DESC, `id` DESC");
        $hist->execute([$applicationId]);
        $app['history'] = $hist->fetchAll(PDO::FETCH_ASSOC);

        $notes = $pdo->prepare("SELECT * FROM `recruiter_notes` WHERE `application_id` = ? OR (`application_id` IS NULL AND `candidate_id` = ?) ORDER BY `is_pinned` DESC, `id` DESC");
        $notes->execute([$applicationId, $app['candidate_id']]);
        $app['notes'] = $notes->fetchAll(PDO::FETCH_ASSOC);

        $msgs = $pdo->prepare("SELECT * FROM `candidate_messages` WHERE `application_id` = ? ORDER BY `created_at` ASC, `id` ASC");
        $msgs->execute([$applicationId]);
        $app['messages'] = $msgs->fetchAll(PDO::FETCH_ASSOC);

        $ints = $pdo->prepare("SELECT * FROM `interview_schedules` WHERE `application_id` = ? ORDER BY `scheduled_at` DESC, `id` DESC");
        $ints->execute([$applicationId]);
        $app['interviews'] = $ints->fetchAll(PDO::FETCH_ASSOC);

        return $app;
    }

    public static function updateStatus(
        int $applicationId,
        string $newStatus,
        string $actorId,
        string $actorName,
        string $publicNote = '',
        string $internalNote = '',
        bool $sendEmail = true
    ): void {
        if (!isset(CareersDB::PIPELINE_STATUSES[$newStatus])) {
            throw new \InvalidArgumentException('Invalid pipeline status: ' . $newStatus);
        }

        $app = self::getApplicationDetail($applicationId);
        if (!$app) {
            throw new \RuntimeException('Application not found.');
        }

        $fromStatus = (string)$app['status'];
        $pdo = CareersDB::pdo();

        $pdo->prepare("UPDATE `applications` SET `status` = ? WHERE `id` = ?")->execute([$newStatus, $applicationId]);
        $pdo->prepare("
            INSERT INTO `application_status_history`
                (`application_id`, `from_status`, `to_status`, `changed_by_type`, `changed_by_id`, `changed_by_name`, `public_note`, `internal_note`)
            VALUES (?, ?, ?, 'admin', ?, ?, ?, ?)
        ")->execute([
            $applicationId,
            $fromStatus,
            $newStatus,
            $actorId,
            $actorName,
            trim($publicNote) ?: null,
            trim($internalNote) ?: null,
        ]);

        $statusLabel = CareersDB::PIPELINE_STATUSES[$newStatus]['label'];
        ActivityLogService::notifyApplicant(
            (int)$app['candidate_id'],
            $applicationId,
            'status_update',
            "Status Updated: {$statusLabel}",
            "Your application {$app['reference_code']} ({$app['job_title']}) moved to {$statusLabel}." . ($publicNote !== '' ? " Note: {$publicNote}" : '')
        );
        ActivityLogService::log('admin', $actorId, $actorName, 'application.status_changed', 'application', (string)$applicationId, "Changed {$app['reference_code']} status {$fromStatus} -> {$newStatus}");

        if ($sendEmail && !empty($app['notify_status_updates'])) {
            $tplKey = match ($newStatus) {
                'selected', 'offer_sent', 'hired' => 'offer_selected',
                'rejected' => 'application_rejected',
                'interview_scheduled' => 'interview_scheduled',
                default => 'status_under_review',
            };
            RecruitmentEmailService::sendTemplate($tplKey, (string)$app['email'], (string)$app['full_name'], [
                'candidate_name' => (string)$app['full_name'],
                'job_title'      => (string)$app['job_title'],
                'application_id' => (string)$app['reference_code'],
                'recruiter_name' => $actorName,
                'portal_url'     => function_exists('url') ? url('careers/candidate-portal/applications/' . $app['reference_code']) : '/careers/candidate-portal',
            ], $applicationId, (int)$app['candidate_id'], $actorId);
        }
    }

    public static function bulkUpdateStatus(array $ids, string $newStatus, string $actorId, string $actorName): int
    {
        $count = 0;
        foreach ($ids as $rawId) {
            $id = (int)$rawId;
            if ($id > 0) {
                self::updateStatus($id, $newStatus, $actorId, $actorName, '', 'Bulk pipeline update', false);
                $count++;
            }
        }
        return $count;
    }

    public static function assignRecruiter(int $applicationId, string $recruiterUserId, string $actorId, string $actorName): void
    {
        $pdo = CareersDB::pdo();
        $pdo->prepare("UPDATE `applications` SET `assigned_recruiter_id` = ? WHERE `id` = ?")->execute([$recruiterUserId ?: null, $applicationId]);
        if ($recruiterUserId !== '') {
            $pdo->prepare("
                INSERT INTO `recruiter_assignments` (`application_id`, `recruiter_user_id`, `assigned_by`, `is_primary`)
                VALUES (?, ?, ?, 1)
                ON DUPLICATE KEY UPDATE `assigned_by` = VALUES(`assigned_by`), `assigned_at` = NOW()
            ")->execute([$applicationId, $recruiterUserId, $actorId]);
        }
        ActivityLogService::log('admin', $actorId, $actorName, 'application.assigned', 'application', (string)$applicationId, "Assigned recruiter '{$recruiterUserId}' to application #{$applicationId}");
    }

    public static function addRecruiterNote(int $applicationId, int $candidateId, string $noteText, string $actorId, string $actorName, bool $isPinned = false): void
    {
        $clean = trim($noteText);
        if ($clean === '') {
            throw new \InvalidArgumentException('Note content cannot be empty.');
        }
        $pdo = CareersDB::pdo();
        $pdo->prepare("
            INSERT INTO `recruiter_notes` (`application_id`, `candidate_id`, `author_user_id`, `author_name`, `note_text`, `is_pinned`)
            VALUES (?, ?, ?, ?, ?, ?)
        ")->execute([$applicationId > 0 ? $applicationId : null, $candidateId, $actorId, $actorName, $clean, $isPinned ? 1 : 0]);
        ActivityLogService::log('admin', $actorId, $actorName, 'candidate.note_added', 'application', (string)$applicationId, 'Added internal private recruiter note');
    }

    public static function updateCandidateTagsAndFlag(int $candidateId, string $tagsCsv, string $statusFlag, string $actorId, string $actorName): void
    {
        $tags = array_values(array_unique(array_filter(array_map('trim', explode(',', $tagsCsv)))));
        $allowedFlag = in_array($statusFlag, ['active', 'talent_pool', 'blacklisted'], true) ? $statusFlag : 'active';
        $pdo = CareersDB::pdo();
        $pdo->prepare("UPDATE `candidate_profiles` SET `tags_json` = ?, `status_flag` = ? WHERE `id` = ?")
            ->execute([json_encode($tags, JSON_UNESCAPED_UNICODE), $allowedFlag, $candidateId]);
        ActivityLogService::log('admin', $actorId, $actorName, 'candidate.updated', 'candidate', (string)$candidateId, "Updated tags & flag ({$allowedFlag}) on candidate #{$candidateId}");
    }

    public static function sendMessageToCandidate(int $applicationId, string $subject, string $body, string $actorId, string $actorName): void
    {
        $cleanBody = trim($body);
        if ($cleanBody === '') {
            throw new \InvalidArgumentException('Message text cannot be empty.');
        }
        $app = self::getApplicationDetail($applicationId);
        if (!$app) {
            throw new \RuntimeException('Application not found.');
        }
        $pdo = CareersDB::pdo();
        $pdo->prepare("
            INSERT INTO `candidate_messages` (`application_id`, `candidate_id`, `sender_type`, `sender_id`, `sender_name`, `subject`, `message_body`, `is_read_by_recruiter`)
            VALUES (?, ?, 'recruiter', ?, ?, ?, ?, 1)
        ")->execute([$applicationId, $app['candidate_id'], $actorId, $actorName, trim($subject) ?: 'Update from CodeX404 Recruitment', $cleanBody]);

        ActivityLogService::notifyApplicant(
            (int)$app['candidate_id'],
            $applicationId,
            'message',
            'New Message on ' . $app['reference_code'],
            mb_substr($cleanBody, 0, 220)
        );
        RecruitmentEmailService::sendTemplate('recruiter_candidate_message', (string)$app['email'], (string)$app['full_name'], [
            'candidate_name' => (string)$app['full_name'],
            'job_title'      => (string)$app['job_title'],
            'application_id' => (string)$app['reference_code'],
            'recruiter_name' => $actorName,
            'portal_url'     => function_exists('url') ? url('careers/candidate-portal/applications/' . $app['reference_code']) : '/careers/candidate-portal',
        ], $applicationId, (int)$app['candidate_id'], $actorId);
    }

    public static function scheduleInterview(int $applicationId, array $input, string $actorId, string $actorName): int
    {
        $app = self::getApplicationDetail($applicationId);
        if (!$app) {
            throw new \RuntimeException('Application not found.');
        }

        $scheduledAtRaw = trim((string)($input['scheduled_at'] ?? ''));
        $ts = strtotime($scheduledAtRaw);
        if ($ts === false) {
            throw new \InvalidArgumentException('Please provide a valid interview date and time.');
        }
        $scheduledAt = date('Y-m-d H:i:s', $ts);
        $interviewerName = trim((string)($input['interviewer_name'] ?? $actorName));
        $round = trim((string)($input['interview_round'] ?? 'Technical & Culture Interview'));
        $mode = in_array($input['interview_mode'] ?? 'video', ['video', 'phone', 'onsite', 'technical_panel'], true) ? $input['interview_mode'] : 'video';
        $duration = max(15, min(240, (int)($input['duration_minutes'] ?? 45)));
        $tz = trim((string)($input['timezone'] ?? 'Asia/Kolkata')) ?: 'Asia/Kolkata';
        $meetingLink = trim((string)($input['meeting_link'] ?? ''));
        $locationAddr = trim((string)($input['location_address'] ?? ''));
        $instructions = trim((string)($input['instructions'] ?? ''));

        $pdo = CareersDB::pdo();
        $ins = $pdo->prepare("
            INSERT INTO `interview_schedules`
                (`application_id`, `candidate_id`, `scheduled_by`, `interviewer_name`, `interviewer_email`, `interview_round`, `interview_mode`, `scheduled_at`, `duration_minutes`, `timezone`, `meeting_link`, `location_address`, `instructions`, `status`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'scheduled')
        ");
        $ins->execute([
            $applicationId,
            $app['candidate_id'],
            $actorId,
            $interviewerName,
            trim((string)($input['interviewer_email'] ?? '')) ?: null,
            $round,
            $mode,
            $scheduledAt,
            $duration,
            $tz,
            $meetingLink ?: null,
            $locationAddr ?: null,
            $instructions ?: null,
        ]);
        $interviewId = (int)$pdo->lastInsertId();

        // Advance pipeline status smoothly without sending duplicate generic status email
        self::updateStatus($applicationId, 'interview_scheduled', $actorId, $actorName, "Scheduled {$round} on {$scheduledAt} ({$tz}).", '', false);

        ActivityLogService::notifyApplicant(
            (int)$app['candidate_id'],
            $applicationId,
            'interview_scheduled',
            "Interview Scheduled: {$round}",
            "Scheduled for {$scheduledAt} ({$tz}) with {$interviewerName}."
        );

        if (!empty($app['notify_interview_updates'])) {
            RecruitmentEmailService::sendTemplate('interview_scheduled', (string)$app['email'], (string)$app['full_name'], [
                'candidate_name' => (string)$app['full_name'],
                'job_title'      => (string)$app['job_title'],
                'application_id' => (string)$app['reference_code'],
                'interview_date' => "{$scheduledAt} ({$tz})",
                'recruiter_name' => $interviewerName,
                'interview_link' => $meetingLink,
                'portal_url'     => function_exists('url') ? url('careers/candidate-portal/applications/' . $app['reference_code']) : '/careers/candidate-portal',
            ], $applicationId, (int)$app['candidate_id'], $actorId);
        }

        ActivityLogService::log('admin', $actorId, $actorName, 'interview.scheduled', 'interview', (string)$interviewId, "Scheduled {$round} for {$app['reference_code']}");
        return $interviewId;
    }

    public static function updateInterviewStatus(int $interviewId, string $status, string $actorId, string $actorName): void
    {
        if (!in_array($status, ['scheduled', 'rescheduled', 'completed', 'cancelled'], true)) {
            throw new \InvalidArgumentException('Invalid interview status.');
        }
        $pdo = CareersDB::pdo();
        $pdo->prepare("UPDATE `interview_schedules` SET `status` = ? WHERE `id` = ?")->execute([$status, $interviewId]);
        ActivityLogService::log('admin', $actorId, $actorName, 'interview.status_updated', 'interview', (string)$interviewId, "Updated interview #{$interviewId} to {$status}");
    }

    /**
     * Build filtered CSV rows safely sanitized against spreadsheet formula injection.
     *
     * @return array<int, array<int, string>>
     */
    public static function buildCsvExportRows(array $filters = []): array
    {
        $res = self::listApplications($filters, 1, 5000);
        $rows = [[
            'Reference ID', 'Candidate Name', 'Email', 'Phone', 'Country', 'City',
            'Position Applied', 'Type', 'Pipeline Status', 'Experience (Years)',
            'Assigned Recruiter', 'Submitted At',
        ]];
        foreach ($res['items'] as $item) {
            $rows[] = [
                CareersDB::csvCell((string)$item['reference_code']),
                CareersDB::csvCell((string)$item['full_name']),
                CareersDB::csvCell((string)$item['email']),
                CareersDB::csvCell((string)($item['phone'] ?? '')),
                CareersDB::csvCell((string)($item['country'] ?? '')),
                CareersDB::csvCell((string)($item['city'] ?? '')),
                CareersDB::csvCell((string)$item['job_title']),
                CareersDB::csvCell((string)$item['application_type']),
                CareersDB::csvCell((string)(CareersDB::PIPELINE_STATUSES[$item['status']]['label'] ?? $item['status'])),
                CareersDB::csvCell((string)($item['years_of_experience'] ?? '')),
                CareersDB::csvCell((string)($item['assigned_recruiter_name'] ?? 'Unassigned')),
                CareersDB::csvCell((string)$item['submitted_at']),
            ];
        }
        return $rows;
    }

    /* =====================================================================
     * APPLICANT PORTAL OPERATIONS (Strictly scoped by $candidateId)
     * ===================================================================== */

    public static function getApplicantDashboardData(int $candidateId): array
    {
        $pdo = CareersDB::pdo();
        $appsStmt = $pdo->prepare("
            SELECT a.*, COALESCE(j.title, 'General Talent Pool') AS job_title, j.slug AS job_slug,
                   j.department, j.employment_type, j.work_mode, j.location AS job_location
            FROM `applications` a
            LEFT JOIN `job_openings` j ON j.id = a.job_opening_id
            WHERE a.candidate_id = ?
            ORDER BY a.submitted_at DESC, a.id DESC
        ");
        $appsStmt->execute([$candidateId]);
        $apps = $appsStmt->fetchAll(PDO::FETCH_ASSOC);

        $intStmt = $pdo->prepare("
            SELECT i.*, a.reference_code, COALESCE(j.title, 'General Talent Pool') AS job_title
            FROM `interview_schedules` i
            INNER JOIN `applications` a ON a.id = i.application_id
            LEFT JOIN `job_openings` j ON j.id = a.job_opening_id
            WHERE i.candidate_id = ? AND i.status IN ('scheduled','rescheduled') AND i.scheduled_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)
            ORDER BY i.scheduled_at ASC
        ");
        $intStmt->execute([$candidateId]);
        $interviews = $intStmt->fetchAll(PDO::FETCH_ASSOC);

        $notifStmt = $pdo->prepare("SELECT * FROM `applicant_notifications` WHERE `candidate_id` = ? ORDER BY `id` DESC LIMIT 20");
        $notifStmt->execute([$candidateId]);
        $notifications = $notifStmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'applications'  => $apps,
            'interviews'    => $interviews,
            'notifications' => $notifications,
            'unread_count'  => count(array_filter($notifications, fn($n) => empty($n['is_read']))),
        ];
    }

    /**
     * Load a single application strictly owned by $candidateId (never exposes private recruiter notes!).
     */
    public static function getApplicantApplicationByRef(int $candidateId, string $referenceOrId): ?array
    {
        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("
            SELECT a.*, COALESCE(j.title, 'General Talent Pool') AS job_title, j.slug AS job_slug,
                   j.department, j.employment_type, j.work_mode, j.location AS job_location
            FROM `applications` a
            LEFT JOIN `job_openings` j ON j.id = a.job_opening_id
            WHERE a.candidate_id = ? AND (a.reference_code = ? OR a.id = ?)
            LIMIT 1
        ");
        $stmt->execute([$candidateId, trim($referenceOrId), is_numeric($referenceOrId) ? (int)$referenceOrId : 0]);
        $app = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$app) {
            return null;
        }

        $appId = (int)$app['id'];
        $ans = $pdo->prepare("SELECT `field_key`, `field_label`, `field_type`, `answer_text`, `file_original_name` FROM `application_answers` WHERE `application_id` = ? ORDER BY `id` ASC");
        $ans->execute([$appId]);
        $app['answers'] = $ans->fetchAll(PDO::FETCH_ASSOC);

        // Public status timeline only (exclude internal_note)
        $hist = $pdo->prepare("SELECT `id`, `from_status`, `to_status`, `changed_by_type`, `public_note`, `created_at` FROM `application_status_history` WHERE `application_id` = ? ORDER BY `created_at` ASC, `id` ASC");
        $hist->execute([$appId]);
        $app['history'] = $hist->fetchAll(PDO::FETCH_ASSOC);

        $ints = $pdo->prepare("SELECT * FROM `interview_schedules` WHERE `application_id` = ? ORDER BY `scheduled_at` DESC");
        $ints->execute([$appId]);
        $app['interviews'] = $ints->fetchAll(PDO::FETCH_ASSOC);

        $msgs = $pdo->prepare("SELECT * FROM `candidate_messages` WHERE `application_id` = ? ORDER BY `created_at` ASC");
        $msgs->execute([$appId]);
        $app['messages'] = $msgs->fetchAll(PDO::FETCH_ASSOC);

        // Mark recruiter messages read when candidate opens application detail
        $pdo->prepare("UPDATE `candidate_messages` SET `is_read_by_candidate` = 1 WHERE `application_id` = ? AND `sender_type` = 'recruiter'")
            ->execute([$appId]);
        $pdo->prepare("UPDATE `applicant_notifications` SET `is_read` = 1, `read_at` = NOW() WHERE `candidate_id` = ? AND `application_id` = ? AND `is_read` = 0")
            ->execute([$candidateId, $appId]);

        return $app;
    }

    public static function withdrawApplication(int $candidateId, string $candidateName, string $candidateEmail, int $applicationId, string $reason = ''): void
    {
        $pdo = CareersDB::pdo();
        $stmt = $pdo->prepare("
            SELECT a.*, COALESCE(j.title, 'General Talent Pool') AS job_title
            FROM `applications` a
            LEFT JOIN `job_openings` j ON j.id = a.job_opening_id
            WHERE a.id = ? AND a.candidate_id = ? LIMIT 1
        ");
        $stmt->execute([$applicationId, $candidateId]);
        $app = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$app) {
            throw new \RuntimeException('Application not found for your account.');
        }
        if (in_array($app['status'], ['hired', 'withdrawn'], true)) {
            throw new \RuntimeException('This application can no longer be withdrawn.');
        }

        $cleanReason = trim($reason) ?: 'Withdrawn by applicant via portal.';
        $pdo->prepare("UPDATE `applications` SET `status` = 'withdrawn', `withdrawn_at` = NOW(), `withdrawal_reason` = ? WHERE `id` = ? AND `candidate_id` = ?")
            ->execute([$cleanReason, $applicationId, $candidateId]);

        $pdo->prepare("
            INSERT INTO `application_status_history`
                (`application_id`, `from_status`, `to_status`, `changed_by_type`, `changed_by_id`, `changed_by_name`, `public_note`)
            VALUES (?, ?, 'withdrawn', 'applicant', ?, ?, ?)
        ")->execute([$applicationId, $app['status'], (string)$candidateId, $candidateName, $cleanReason]);

        ActivityLogService::notifyApplicant($candidateId, $applicationId, 'withdrawn', 'Application Withdrawn', "Application {$app['reference_code']} has been marked as withdrawn.");
        ActivityLogService::log('applicant', (string)$candidateId, $candidateName, 'application.withdrawn', 'application', (string)$applicationId, "Applicant withdrew application {$app['reference_code']}");

        RecruitmentEmailService::sendTemplate('application_withdrawn', $candidateEmail, $candidateName, [
            'candidate_name' => $candidateName,
            'job_title'      => (string)$app['job_title'],
            'application_id' => (string)$app['reference_code'],
        ], $applicationId, $candidateId, 'applicant');
    }

    public static function addApplicantReplyMessage(int $candidateId, string $candidateName, int $applicationId, string $messageBody): void
    {
        $clean = trim($messageBody);
        if ($clean === '') {
            throw new \InvalidArgumentException('Please write a message before sending.');
        }
        $pdo = CareersDB::pdo();
        $chk = $pdo->prepare("SELECT `id` FROM `applications` WHERE `id` = ? AND `candidate_id` = ? LIMIT 1");
        $chk->execute([$applicationId, $candidateId]);
        if (!$chk->fetchColumn()) {
            throw new \RuntimeException('Unauthorized application reference.');
        }
        $pdo->prepare("
            INSERT INTO `candidate_messages` (`application_id`, `candidate_id`, `sender_type`, `sender_id`, `sender_name`, `subject`, `message_body`, `is_read_by_candidate`)
            VALUES (?, ?, 'candidate', ?, ?, 'Applicant Reply', ?, 1)
        ")->execute([$applicationId, $candidateId, (string)$candidateId, $candidateName, $clean]);

        ActivityLogService::log('applicant', (string)$candidateId, $candidateName, 'message.sent', 'application', (string)$applicationId, 'Applicant sent reply via portal');
    }

    public static function updateApplicantPreferences(int $candidateId, string $candidateName, array $input): void
    {
        $phone = trim((string)($input['phone'] ?? ''));
        $city = trim((string)($input['city'] ?? ''));
        $country = trim((string)($input['country'] ?? ''));
        $notifyStatus = !empty($input['notify_status_updates']) ? 1 : 0;
        $notifyInterviews = !empty($input['notify_interview_updates']) ? 1 : 0;

        $pdo = CareersDB::pdo();
        $pdo->prepare("
            UPDATE `candidate_profiles`
            SET `phone` = COALESCE(NULLIF(?, ''), `phone`),
                `city` = COALESCE(NULLIF(?, ''), `city`),
                `country` = COALESCE(NULLIF(?, ''), `country`),
                `notify_status_updates` = ?,
                `notify_interview_updates` = ?
            WHERE `id` = ?
        ")->execute([$phone, $city, $country, $notifyStatus, $notifyInterviews, $candidateId]);

        ActivityLogService::log('applicant', (string)$candidateId, $candidateName, 'portal.preferences_updated', 'candidate', (string)$candidateId, 'Updated candidate contact details & notification preferences');
    }

    public static function requestDataDeletion(int $candidateId, string $candidateName, string $reason): void
    {
        $pdo = CareersDB::pdo();
        $pdo->prepare("UPDATE `candidate_profiles` SET `deletion_requested_at` = NOW(), `deletion_request_reason` = ? WHERE `id` = ?")
            ->execute([trim($reason) ?: 'Requested by candidate via Applicant Portal', $candidateId]);
        $pdo->prepare("UPDATE `applicant_accounts` SET `status` = 'deletion_requested' WHERE `candidate_id` = ?")
            ->execute([$candidateId]);
        ActivityLogService::log('applicant', (string)$candidateId, $candidateName, 'privacy.deletion_requested', 'candidate', (string)$candidateId, 'Candidate submitted personal data deletion request');
    }

    public static function markAllNotificationsRead(int $candidateId): void
    {
        $pdo = CareersDB::pdo();
        $pdo->prepare("UPDATE `applicant_notifications` SET `is_read` = 1, `read_at` = NOW() WHERE `candidate_id` = ? AND `is_read` = 0")
            ->execute([$candidateId]);
    }
}
