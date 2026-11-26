<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/config/Env.php';
Env::load(__DIR__ . '/.env');

use App\Careers\ApplicationService;
use App\Careers\FormBuilderService;
use App\Careers\FormValidationException;
use App\Careers\VacancyService;

$slug = trim((string)($_GET['slug'] ?? ''));
$isAdminPreview = !empty($_GET['preview']);

// Allow non-published preview ONLY when authenticated admin explicitly visits ?preview=1
$canPreview = false;
if ($isAdminPreview) {
    require_once __DIR__ . '/admin/auth.php';
    $canPreview = is_admin_logged_in();
}

$job = $slug !== '' ? VacancyService::getBySlug($slug, $canPreview) : null;
if (!$job) {
    http_response_code(404);
    $pageMeta = ['title' => 'Vacancy Not Found — CodeX404 Careers'];
    require_once __DIR__ . '/includes/header.php';
    ?>
    <section class="section" style="padding-top:calc(var(--nav-height,78px) + 5rem);padding-bottom:5rem;text-align:center;">
        <div class="container" style="max-width:680px;">
            <div class="careers-card">
                <h1 style="color:#fff;margin-bottom:0.75rem;">Position No Longer Available</h1>
                <p style="color:#CBD5E1;margin-bottom:1.5rem;">This vacancy may have been filled, closed, or its deadline has passed.</p>
                <div style="display:flex;justify-content:center;gap:0.75rem;flex-wrap:wrap;">
                    <a href="<?= url('careers') ?>" class="btn btn-primary" style="background:#0B5ED7;border-color:#0B5ED7;">View Open Positions</a>
                    <a href="<?= url('careers/application-status') ?>" class="btn btn-secondary">Applicant Portal</a>
                </div>
            </div>
        </div>
    </section>
    <?php
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

$fields = FormBuilderService::getEffectiveFields($job);
$appSuccess = null;
$appError = null;
$fieldErrors = [];
$oldValues = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($job['status'] !== 'published') {
        $appError = 'This preview vacancy is not currently accepting applications.';
    } elseif (!check_rate_limit('careers_vacancy_apply', 6, 300)) {
        $appError = 'Too many submission attempts. Please wait a few minutes and try again.';
    } elseif (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $appError = 'Security session expired. Please refresh the page and submit again.';
    } else {
        $oldValues = is_array($_POST['fields'] ?? null) ? $_POST['fields'] : [];
        try {
            $appSuccess = ApplicationService::submitApplication($job, $_POST, $_FILES);
            $oldValues = [];
        } catch (FormValidationException $e) {
            $fieldErrors = $e->getFieldErrors();
            $appError = $e->getMessage();
        } catch (\Throwable $e) {
            $appError = $e->getMessage();
        }
    }
}

$shareUrl = url('careers/' . urlencode((string)$job['slug']));
$pageMeta = [
    'title'       => htmlspecialchars((string)($job['seo_title'] ?: $job['title'] . ' — Careers at CodeX404 Solutions')),
    'description' => (string)($job['seo_description'] ?: $job['overview']),
    'canonical'   => $shareUrl,
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section" style="padding-top:calc(var(--nav-height,78px) + 3rem);padding-bottom:5rem;">
    <div class="container">
        <?php if ($job['status'] !== 'published'): ?>
            <div class="careers-alert careers-alert-info">
                <strong>Admin Preview Mode:</strong> Status is currently <code><?= htmlspecialchars((string)$job['status']) ?></code>. This page is not visible to public visitors.
            </div>
        <?php endif; ?>

        <div style="margin-bottom:1.5rem;">
            <a href="<?= url('careers') ?>#open-positions" style="color:#22D3EE;text-decoration:none;font-size:0.9rem;font-weight:600;">
                &larr; All Open Positions
            </a>
        </div>

        <div class="careers-detail-layout">
            <!-- LEFT: FULL VACANCY SPECIFICATION -->
            <div class="careers-detail-panel">
                <div class="careers-job-meta-row">
                    <span class="careers-badge careers-badge-dept"><?= htmlspecialchars((string)$job['category_name']) ?></span>
                    <span class="careers-badge careers-badge-cyan"><?= htmlspecialchars((string)$job['employment_type']) ?></span>
                    <span class="careers-badge"><?= htmlspecialchars((string)$job['work_mode']) ?></span>
                    <?php if (!empty($job['vacancies_count'])): ?>
                        <span class="careers-badge careers-badge-amber"><?= (int)$job['vacancies_count'] ?> Vacancy(ies)</span>
                    <?php endif; ?>
                </div>

                <h1 style="font-size:clamp(1.75rem,3.2vw,2.45rem);color:#fff;font-weight:800;line-height:1.2;margin-bottom:0.85rem;">
                    <?= htmlspecialchars((string)$job['title']) ?>
                </h1>

                <p style="color:#CBD5E1;font-size:1rem;line-height:1.7;margin-bottom:1.25rem;">
                    <?= htmlspecialchars((string)$job['overview']) ?>
                </p>

                <div class="careers-job-specs" style="margin-bottom:1.5rem;">
                    <div><span>Department</span><strong><?= htmlspecialchars((string)$job['department']) ?></strong></div>
                    <div><span>Work Location</span><strong><?= htmlspecialchars((string)$job['location']) ?></strong></div>
                    <div><span>Experience</span><strong><?= htmlspecialchars((string)$job['experience_level']) ?></strong></div>
                    <div><span>Compensation</span><strong><?= htmlspecialchars((string)($job['salary_display'] ?: $job['compensation_type'])) ?></strong></div>
                    <div><span>Working Hours</span><strong><?= htmlspecialchars((string)($job['working_hours'] ?: 'Standard Business Hours')) ?></strong></div>
                    <div><span>Application Deadline</span><strong><?= !empty($job['application_deadline']) ? date('M j, Y', strtotime((string)$job['application_deadline'])) : 'Open until filled' ?></strong></div>
                </div>

                <div class="careers-detail-block">
                    <h3>About the Position</h3>
                    <div style="white-space:pre-line;color:#CBD5E1;line-height:1.7;"><?= htmlspecialchars((string)$job['about_position']) ?></div>
                </div>

                <div class="careers-detail-block">
                    <h3>Key Responsibilities</h3>
                    <div style="white-space:pre-line;color:#CBD5E1;line-height:1.75;"><?= htmlspecialchars((string)$job['responsibilities']) ?></div>
                </div>

                <div class="careers-detail-block">
                    <h3>Required Qualifications</h3>
                    <div style="white-space:pre-line;color:#CBD5E1;line-height:1.75;"><?= htmlspecialchars((string)$job['qualifications']) ?></div>
                </div>

                <?php if (!empty($job['skills'])): ?>
                    <div class="careers-detail-block">
                        <h3>Required Skills</h3>
                        <div style="display:flex;flex-wrap:wrap;gap:0.45rem;">
                            <?php foreach (array_filter(array_map('trim', explode(',', (string)$job['skills']))) as $sk): ?>
                                <span class="careers-badge careers-badge-cyan"><?= htmlspecialchars($sk) ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($job['employment_conditions'])): ?>
                    <div class="careers-detail-block">
                        <h3>Employment Conditions</h3>
                        <p><?= nl2br(htmlspecialchars((string)$job['employment_conditions'])) ?></p>
                    </div>
                <?php endif; ?>

                <div class="careers-share-row">
                    <span style="font-size:0.82rem;color:#94A3B8;font-weight:600;">Share Vacancy:</span>
                    <button type="button" class="careers-share-btn" id="copyVacancyLinkBtn" data-url="<?= htmlspecialchars($shareUrl) ?>">Copy Link</button>
                    <a class="careers-share-btn" target="_blank" rel="noopener noreferrer"
                       href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($shareUrl) ?>">LinkedIn</a>
                    <a class="careers-share-btn" target="_blank" rel="noopener noreferrer"
                       href="https://twitter.com/intent/tweet?text=<?= urlencode('Open role at CodeX404 Solutions: ' . $job['title']) ?>&url=<?= urlencode($shareUrl) ?>">X / Twitter</a>
                    <a class="careers-share-btn" target="_blank" rel="noopener noreferrer"
                       href="https://wa.me/?text=<?= urlencode($job['title'] . ' — CodeX404 Solutions: ' . $shareUrl) ?>">WhatsApp</a>
                </div>
            </div>

            <!-- RIGHT: DYNAMIC APPLICATION ENGINE -->
            <div class="careers-form-panel" id="apply-form">
                <h2 style="font-size:1.45rem;color:#fff;font-weight:700;margin-bottom:0.35rem;">
                    Apply for <span class="careers-amber-accent"><?= htmlspecialchars((string)$job['title']) ?></span>
                </h2>
                <p style="font-size:0.88rem;color:#94A3B8;margin-bottom:1.25rem;">
                    Fields marked with <span class="req-star">*</span> are required. Uploaded resumes are stored privately for recruitment review.
                </p>

                <?php if ($appSuccess): ?>
                    <div class="careers-alert careers-alert-success">
                        <strong style="display:block;font-size:1.05rem;margin-bottom:0.35rem;">Application Submitted Successfully!</strong>
                        Your unique Application Reference ID is:
                        <code style="display:inline-block;padding:0.2rem 0.55rem;background:rgba(0,0,0,0.35);border-radius:6px;color:#FF8C00;font-weight:700;"><?= htmlspecialchars((string)$appSuccess['reference_code']) ?></code>
                        <p style="margin:0.65rem 0 0;">
                            Track live status updates, interviews, and recruiter messages anytime via the
                            <a href="<?= url('careers/application-status') ?>" style="color:#22D3EE;font-weight:700;">Applicant Portal &rarr;</a>
                        </p>
                    </div>
                <?php else: ?>
                    <?php if ($appError): ?>
                        <div class="careers-alert careers-alert-error"><?= htmlspecialchars($appError) ?></div>
                    <?php endif; ?>

                    <form method="POST" action="<?= htmlspecialchars($shareUrl) ?>#apply-form" enctype="multipart/form-data">
                        <?= csrf_input_field() ?>
                        <div style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
                            <label>Company Website<input type="text" name="website_hp" tabindex="-1" autocomplete="off"></label>
                        </div>

                        <?= FormBuilderService::renderFormSectionsHtml($fields, $oldValues, $fieldErrors) ?>

                        <button type="submit" class="btn btn-primary btn-lg" style="width:100%;background:#0B5ED7;border-color:#0B5ED7;">
                            Submit Application
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('copyVacancyLinkBtn')?.addEventListener('click', function () {
    const url = this.dataset.url;
    navigator.clipboard?.writeText(url).then(() => {
        const orig = this.textContent;
        this.textContent = 'Copied!';
        setTimeout(() => { this.textContent = orig; }, 1800);
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
