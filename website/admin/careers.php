<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Portal: Careers & Recruitment Management Center (/admin/careers)
 */

require_once __DIR__ . '/auth.php';
require_admin_auth();

use App\Careers\ActivityLogService;
use App\Careers\ApplicationService;
use App\Careers\CareersDB;
use App\Careers\FileStorageService;
use App\Careers\FormBuilderService;
use App\Careers\RecruitmentAuthService;
use App\Careers\RecruitmentEmailService;
use App\Careers\RecruitmentSettingsService;
use App\Careers\VacancyService;

$tab = trim((string)($_GET['tab'] ?? 'overview'));
$allowedTabs = [
    'overview', 'jobs', 'applications', 'candidate-detail',
    'form-builder', 'emails', 'recruiters', 'settings', 'logs',
    'export', 'resume',
];
if (!in_array($tab, $allowedTabs, true)) {
    $tab = 'overview';
}

$adminProfile = current_admin_profile();
$actorId = (string)($adminProfile['id'] ?? 'admin');
$actorName = (string)($adminProfile['name'] ?? $adminProfile['username'] ?? 'Admin');

// Require baseline recruitment view permission for all Recruitment admin tabs
RecruitmentAuthService::requirePermission('careers.view');

// =========================================================================
// STREAMING ENDPOINTS (Resume Download & CSV Export BEFORE HTML output)
// =========================================================================
if ($tab === 'resume') {
    RecruitmentAuthService::requirePermission('careers.candidates.export');
    $appId = (int)($_GET['app_id'] ?? 0);
    $ansId = (int)($_GET['answer_id'] ?? 0);
    $app = $appId > 0 ? ApplicationService::getApplicationDetail($appId) : null;
    if (!$app) {
        http_response_code(404);
        exit('Application not found.');
    }

    if ($ansId > 0) {
        foreach ($app['answers'] ?? [] as $ans) {
            if ((int)$ans['id'] === $ansId && !empty($ans['file_path'])) {
                FileStorageService::streamProtectedFile((string)$ans['file_path'], (string)($ans['file_original_name'] ?: 'attachment'));
            }
        }
        http_response_code(404);
        exit('Attachment not found.');
    }

    if (empty($app['resume_path'])) {
        http_response_code(404);
        exit('No resume attached to this application.');
    }
    ActivityLogService::log('admin', $actorId, $actorName, 'resume.downloaded', 'application', (string)$appId, "Downloaded resume for {$app['reference_code']}");
    FileStorageService::streamProtectedFile((string)$app['resume_path'], (string)($app['resume_original_name'] ?: $app['reference_code'] . '_CV.pdf'), $app['resume_mime'] ?? null);
}

if ($tab === 'export') {
    RecruitmentAuthService::requirePermission('careers.candidates.export');
    $filters = [
        'status' => trim((string)($_GET['status'] ?? '')),
        'job_id' => trim((string)($_GET['job_id'] ?? '')),
        'type'   => trim((string)($_GET['type'] ?? '')),
        'search' => trim((string)($_GET['search'] ?? '')),
    ];
    $rows = ApplicationService::buildCsvExportRows($filters);
    ActivityLogService::log('admin', $actorId, $actorName, 'applications.exported_csv', 'application', null, 'Exported applications CSV (' . (count($rows) - 1) . ' records)');

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="codex404_applications_' . date('Ymd_His') . '.csv"');
    header('X-Content-Type-Options: nosniff');
    $out = fopen('php://output', 'wb');
    if ($out) {
        foreach ($rows as $row) {
            fputcsv($out, $row);
        }
        fclose($out);
    }
    exit;
}

// =========================================================================
// HANDLE POST MUTATIONS WITH STRICT CSRF & BACKEND RBAC
// =========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        set_admin_flash('error', 'Security session expired. Please refresh and try again.');
        header('Location: ' . admin_url('careers?tab=' . urlencode($tab)));
        exit;
    }

    $action = trim((string)($_POST['action'] ?? ''));
    $redirectUrl = admin_url('careers?tab=' . urlencode($tab));

    try {
        switch ($action) {
            case 'save_vacancy':
                RecruitmentAuthService::requirePermission('careers.jobs.manage');
                $savedId = VacancyService::saveVacancy($_POST, $actorId, $actorName);
                set_admin_flash('success', 'Vacancy saved successfully.');
                $redirectUrl = admin_url('careers?tab=jobs&edit=' . $savedId);
                break;

            case 'job_status':
                RecruitmentAuthService::requirePermission('careers.jobs.manage');
                VacancyService::updateStatus((int)($_POST['job_id'] ?? 0), (string)($_POST['new_status'] ?? 'draft'), $actorId, $actorName);
                set_admin_flash('success', 'Vacancy status updated.');
                $redirectUrl = admin_url('careers?tab=jobs');
                break;

            case 'duplicate_vacancy':
                RecruitmentAuthService::requirePermission('careers.jobs.manage');
                $dupId = VacancyService::duplicateVacancy((int)($_POST['job_id'] ?? 0), $actorId, $actorName);
                set_admin_flash('success', 'Vacancy duplicated as draft.');
                $redirectUrl = admin_url('careers?tab=jobs&edit=' . $dupId);
                break;

            case 'create_category':
                RecruitmentAuthService::requirePermission('careers.jobs.manage');
                $catName = trim((string)($_POST['category_name'] ?? ''));
                if ($catName === '') {
                    throw new \InvalidArgumentException('Category name is required.');
                }
                $pdo = CareersDB::pdo();
                $pdo->prepare("INSERT INTO `job_categories` (`slug`, `name`, `description`, `sort_order`, `is_active`) VALUES (?, ?, ?, 50, 1)")
                    ->execute([CareersDB::slugify($catName), $catName, trim((string)($_POST['category_description'] ?? ''))]);
                set_admin_flash('success', "Category '{$catName}' created.");
                $redirectUrl = admin_url('careers?tab=jobs');
                break;

            case 'update_application_status':
                RecruitmentAuthService::requirePermission('careers.applications.manage');
                $appId = (int)($_POST['application_id'] ?? 0);
                ApplicationService::updateStatus(
                    $appId,
                    (string)($_POST['status'] ?? 'under_review'),
                    $actorId,
                    $actorName,
                    (string)($_POST['public_note'] ?? ''),
                    (string)($_POST['internal_note'] ?? ''),
                    !empty($_POST['send_email'])
                );
                set_admin_flash('success', 'Application status updated.');
                $redirectUrl = admin_url('careers?tab=candidate-detail&id=' . $appId);
                break;

            case 'bulk_application_status':
                RecruitmentAuthService::requirePermission('careers.applications.manage');
                $ids = is_array($_POST['selected_ids'] ?? null) ? $_POST['selected_ids'] : [];
                $newSt = trim((string)($_POST['bulk_status'] ?? ''));
                $cnt = ApplicationService::bulkUpdateStatus($ids, $newSt, $actorId, $actorName);
                set_admin_flash('success', "Updated {$cnt} selected application(s).");
                $redirectUrl = admin_url('careers?tab=applications');
                break;

            case 'assign_recruiter':
                RecruitmentAuthService::requirePermission('careers.applications.manage');
                $appId = (int)($_POST['application_id'] ?? 0);
                ApplicationService::assignRecruiter($appId, trim((string)($_POST['recruiter_user_id'] ?? '')), $actorId, $actorName);
                set_admin_flash('success', 'Assigned recruiter updated.');
                $redirectUrl = admin_url('careers?tab=candidate-detail&id=' . $appId);
                break;

            case 'add_recruiter_note':
                RecruitmentAuthService::requirePermission('careers.applications.manage');
                $appId = (int)($_POST['application_id'] ?? 0);
                $candId = (int)($_POST['candidate_id'] ?? 0);
                ApplicationService::addRecruiterNote($appId, $candId, (string)($_POST['note_text'] ?? ''), $actorId, $actorName, !empty($_POST['is_pinned']));
                set_admin_flash('success', 'Internal recruiter note added.');
                $redirectUrl = admin_url('careers?tab=candidate-detail&id=' . $appId);
                break;

            case 'update_candidate_tags':
                RecruitmentAuthService::requirePermission('careers.applications.manage');
                $appId = (int)($_POST['application_id'] ?? 0);
                $candId = (int)($_POST['candidate_id'] ?? 0);
                ApplicationService::updateCandidateTagsAndFlag($candId, (string)($_POST['tags_csv'] ?? ''), (string)($_POST['status_flag'] ?? 'active'), $actorId, $actorName);
                set_admin_flash('success', 'Candidate tags and pool flag updated.');
                $redirectUrl = admin_url('careers?tab=candidate-detail&id=' . $appId);
                break;

            case 'send_candidate_message':
                RecruitmentAuthService::requirePermission('careers.applications.manage');
                $appId = (int)($_POST['application_id'] ?? 0);
                ApplicationService::sendMessageToCandidate($appId, (string)($_POST['subject'] ?? ''), (string)($_POST['message_body'] ?? ''), $actorId, $actorName);
                set_admin_flash('success', 'Message posted to Applicant Portal and email triggered.');
                $redirectUrl = admin_url('careers?tab=candidate-detail&id=' . $appId);
                break;

            case 'schedule_interview':
                RecruitmentAuthService::requirePermission('careers.interviews.manage');
                $appId = (int)($_POST['application_id'] ?? 0);
                ApplicationService::scheduleInterview($appId, $_POST, $actorId, $actorName);
                set_admin_flash('success', 'Interview scheduled and candidate notified.');
                $redirectUrl = admin_url('careers?tab=candidate-detail&id=' . $appId);
                break;

            case 'update_interview_status':
                RecruitmentAuthService::requirePermission('careers.interviews.manage');
                $appId = (int)($_POST['application_id'] ?? 0);
                ApplicationService::updateInterviewStatus((int)($_POST['interview_id'] ?? 0), (string)($_POST['interview_status'] ?? 'completed'), $actorId, $actorName);
                set_admin_flash('success', 'Interview record updated.');
                $redirectUrl = admin_url('careers?tab=candidate-detail&id=' . $appId);
                break;

            case 'create_form_template':
                RecruitmentAuthService::requirePermission('careers.forms.manage');
                $newTplId = FormBuilderService::createTemplate(
                    (string)($_POST['template_name'] ?? ''),
                    (string)($_POST['template_type'] ?? 'custom'),
                    (string)($_POST['template_description'] ?? ''),
                    $actorId,
                    $actorName,
                    !empty($_POST['clone_from_id']) ? (int)$_POST['clone_from_id'] : null
                );
                set_admin_flash('success', 'Form template created.');
                $redirectUrl = admin_url('careers?tab=form-builder&template_id=' . $newTplId);
                break;

            case 'save_form_field':
                RecruitmentAuthService::requirePermission('careers.forms.manage');
                FormBuilderService::saveField($_POST, $actorId, $actorName);
                set_admin_flash('success', 'Form field configuration saved.');
                if (!empty($_POST['job_opening_id'])) {
                    $redirectUrl = admin_url('careers?tab=form-builder&job_id=' . (int)$_POST['job_opening_id']);
                } else {
                    $redirectUrl = admin_url('careers?tab=form-builder&template_id=' . (int)($_POST['template_id'] ?? 1));
                }
                break;

            case 'delete_form_field':
                RecruitmentAuthService::requirePermission('careers.forms.manage');
                FormBuilderService::deleteField((int)($_POST['field_id'] ?? 0), $actorId, $actorName);
                set_admin_flash('success', 'Custom field removed.');
                if (!empty($_POST['job_opening_id'])) {
                    $redirectUrl = admin_url('careers?tab=form-builder&job_id=' . (int)$_POST['job_opening_id']);
                } else {
                    $redirectUrl = admin_url('careers?tab=form-builder&template_id=' . (int)($_POST['template_id'] ?? 1));
                }
                break;

            case 'update_email_template':
                RecruitmentAuthService::requirePermission('careers.emails.manage');
                RecruitmentEmailService::updateTemplate(
                    (int)($_POST['template_id'] ?? 0),
                    (string)($_POST['subject'] ?? ''),
                    (string)($_POST['body_html'] ?? ''),
                    (string)($_POST['body_text'] ?? ''),
                    !empty($_POST['is_active']),
                    $actorName
                );
                set_admin_flash('success', 'Email template updated.');
                $redirectUrl = admin_url('careers?tab=emails');
                break;

            case 'assign_recruitment_role':
                RecruitmentAuthService::requirePermission('careers.settings.manage');
                RecruitmentAuthService::assignRecruitmentRole((string)($_POST['user_id'] ?? ''), (string)($_POST['role_slug'] ?? 'viewer'), $actorName);
                set_admin_flash('success', 'Recruitment role assignment updated.');
                $redirectUrl = admin_url('careers?tab=recruiters');
                break;

            case 'save_recruitment_settings':
                RecruitmentAuthService::requirePermission('careers.settings.manage');
                $settingsInput = is_array($_POST['settings'] ?? null) ? $_POST['settings'] : [];
                $settingsInput['allow_general_applications'] = !empty($settingsInput['allow_general_applications']) ? '1' : '0';
                $settingsInput['enable_applicant_portal'] = !empty($settingsInput['enable_applicant_portal']) ? '1' : '0';
                RecruitmentSettingsService::updateMany($settingsInput);
                ActivityLogService::log('admin', $actorId, $actorName, 'settings.updated', 'settings', null, 'Updated recruitment platform settings');
                set_admin_flash('success', 'Recruitment settings saved.');
                $redirectUrl = admin_url('careers?tab=settings');
                break;

            default:
                set_admin_flash('error', 'Unknown recruitment action.');
                break;
        }
    } catch (\Throwable $e) {
        set_admin_flash('error', $e->getMessage());
    }

    header('Location: ' . $redirectUrl);
    exit;
}

$currentPage = 'careers';
$pageTitle = 'Careers & Recruitment Command Center';
$pageSubtitle = 'Publish dynamic vacancies, build custom application forms, track candidates, schedule interviews, and manage automated notifications';

require_once __DIR__ . '/includes/header.php';

$careersAdminError = null;
try {
    $stats = ApplicationService::getOverviewStats();
} catch (\Throwable $e) {
    CareersDB::logError($e, 'admin/careers');
    $careersAdminError = 'Careers database tables are unavailable or pending migration. Open Platform Telemetry to apply pending SQL migrations.';
    $stats = [
        'total_jobs' => 0,
        'published_jobs' => 0,
        'total_applications' => 0,
        'new_applications' => 0,
        'shortlisted_count' => 0,
        'hired_count' => 0,
        'upcoming_interviews' => 0,
        'unread_del_requests' => 0,
    ];
}
$navTabs = [
    'overview'     => ['label' => 'Overview',        'icon' => 'bi-speedometer2',          'perm' => 'careers.view'],
    'jobs'         => ['label' => 'Jobs (' . $stats['total_jobs'] . ')', 'icon' => 'bi-briefcase', 'perm' => 'careers.view'],
    'applications' => ['label' => 'Applications (' . $stats['total_applications'] . ')', 'icon' => 'bi-inbox', 'perm' => 'careers.applications.view'],
    'form-builder' => ['label' => 'Form Builder',    'icon' => 'bi-ui-checks-grid',        'perm' => 'careers.forms.manage'],
    'emails'       => ['label' => 'Emails & Logs',   'icon' => 'bi-envelope-paper',        'perm' => 'careers.emails.manage'],
    'recruiters'   => ['label' => 'RBAC & Team',     'icon' => 'bi-shield-check',          'perm' => 'careers.view'],
    'settings'     => ['label' => 'Settings',        'icon' => 'bi-sliders',               'perm' => 'careers.settings.manage'],
    'logs'         => ['label' => 'Activity Logs',   'icon' => 'bi-journal-text',          'perm' => 'careers.logs.view'],
];
?>

<!-- Top Recruitment Sub-Navigation -->
<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4 pb-2 border-bottom" style="border-color: rgba(255,255,255,0.08) !important;">
    <ul class="nav nav-pills gap-1 flex-wrap">
        <?php foreach ($navTabs as $slug => $meta): ?>
            <?php if (!current_admin_can($meta['perm'])) { continue; } ?>
            <?php $isActive = ($tab === $slug) || ($tab === 'candidate-detail' && $slug === 'applications'); ?>
            <li class="nav-item">
                <a class="nav-link btn-sm d-inline-flex align-items-center gap-2 px-3 py-2 <?= $isActive ? 'active fw-semibold' : 'text-light-emphasis' ?>"
                   style="<?= $isActive ? 'background:#0B5ED7;color:#fff;' : 'background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.08);' ?>"
                   href="<?= admin_url('careers?tab=' . $slug) ?>">
                    <i class="bi <?= $meta['icon'] ?>"></i>
                    <span><?= htmlspecialchars($meta['label']) ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="d-flex align-items-center gap-2">
        <a href="<?= url('careers') ?>" target="_blank" class="btn btn-outline-info btn-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Public Careers Page
        </a>
        <?php if (current_admin_can('careers.jobs.manage')): ?>
            <a href="<?= admin_url('careers?tab=jobs&new=1') ?>" class="btn btn-primary btn-sm" style="background:#0B5ED7;border-color:#0B5ED7;">
                <i class="bi bi-plus-lg me-1"></i> Post Vacancy
            </a>
        <?php endif; ?>
    </div>
</div>

<?php
$partialMap = [
    'overview'         => __DIR__ . '/careers_views/overview.php',
    'jobs'             => __DIR__ . '/careers_views/jobs.php',
    'applications'     => __DIR__ . '/careers_views/applications.php',
    'candidate-detail' => __DIR__ . '/careers_views/candidate-detail.php',
    'form-builder'     => __DIR__ . '/careers_views/form-builder.php',
    'emails'           => __DIR__ . '/careers_views/emails.php',
    'recruiters'       => __DIR__ . '/careers_views/recruiters.php',
    'settings'         => __DIR__ . '/careers_views/settings.php',
    'logs'             => __DIR__ . '/careers_views/logs.php',
];

$partial = $partialMap[$tab] ?? $partialMap['overview'];
if ($careersAdminError !== null): ?>
    <div class="alert alert-warning d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div><i class="bi bi-database-exclamation me-2"></i><?= htmlspecialchars($careersAdminError) ?></div>
        <a href="<?= admin_url('telemetry') ?>#migrations" class="btn btn-sm btn-warning">Open Telemetry &amp; Migrations</a>
    </div>
<?php elseif (is_file($partial)):
    try {
        include $partial;
    } catch (\Throwable $e) {
        CareersDB::logError($e, 'admin/careers:' . $tab);
        echo '<div class="alert alert-warning">Unable to load this recruitment section until database migrations are applied. <a href="' . htmlspecialchars(admin_url('telemetry') . '#migrations') . '" class="alert-link">Open Migrations</a></div>';
    }
else:
    echo '<div class="alert alert-warning">Recruitment module view not found.</div>';
endif;

require_once __DIR__ . '/includes/footer.php';
