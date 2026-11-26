<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/config/Env.php';
Env::load(__DIR__ . '/.env');

use App\Careers\ApplicationService;
use App\Careers\FormBuilderService;
use App\Careers\FormValidationException;
use App\Careers\RecruitmentSettingsService;
use App\Careers\VacancyService;

$categories = VacancyService::listCategories();
$selectedCategory = trim((string) ($_GET['category'] ?? 'all'));
$searchTerm = trim((string) ($_GET['q'] ?? ''));

$vacancies = VacancyService::listPublicVacancies($selectedCategory === 'all' ? '' : $selectedCategory, $searchTerm);
$allowGeneral = RecruitmentSettingsService::getBool('allow_general_applications', true);
$generalFields = $allowGeneral ? FormBuilderService::getEffectiveFields(null) : [];

$generalSuccess = null;
$generalError = null;
$generalFieldErrors = [];
$oldGeneral = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['form_mode'] ?? '') === 'general_talent_pool') {
    if (!$allowGeneral) {
        $generalError = 'General Talent Pool applications are currently closed.';
    } elseif (!check_rate_limit('careers_general_apply', 6, 300)) {
        $generalError = 'Too many submission attempts. Please wait a few minutes before trying again.';
    } elseif (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $generalError = 'Security session expired. Please refresh and submit again.';
    } else {
        $oldGeneral = is_array($_POST['fields'] ?? null) ? $_POST['fields'] : [];
        try {
            $res = ApplicationService::submitApplication(null, $_POST, $_FILES);
            $generalSuccess = $res;
            $oldGeneral = [];
        } catch (FormValidationException $e) {
            $generalFieldErrors = $e->getFieldErrors();
            $generalError = $e->getMessage();
        } catch (\Throwable $e) {
            $generalError = $e->getMessage();
        }
    }
}

$pageMeta = [
    'title' => 'Careers — Build Your Career at CodeX404 Solutions',
    'description' => 'Join CodeX404 Solutions to build custom software, AI-powered solutions, intelligent automation and digital products.',
    'canonical' => url('careers'),
    'keywords' => 'CodeX404 Solutions careers, software engineering jobs, marketing jobs, internships, fellowships',
];

require_once __DIR__ . '/includes/header.php';
?>

<?php
$heroTag = 'Careers at CodeX404 Solutions';
$heroTitleHtml = 'Build Your Career. <span class="text-amber">Create What&rsquo;s Next.</span>';
$heroSubtitle = 'Join CodeX404 Solutions and work with a team building custom software, AI-powered solutions, intelligent automation, and digital products.';
$heroActions = [
    ['label' => 'Explore Opportunities ↓', 'url' => '#open-positions', 'variant' => 'primary'],
    ['label' => 'Join Our Team', 'url' => '#general-application', 'variant' => 'secondary'],
];
$heroExtraHtml = '<div class="careers-portal-strip"><span>Already applied?</span><a href="' . htmlspecialchars(url('careers/application-status'), ENT_QUOTES, 'UTF-8') . '">Track Application Status &amp; Applicant Portal &rarr;</a></div>';
require __DIR__ . '/includes/subpage-hero.php';
?>

<!-- SECTION B: WHY JOIN US -->
<section class="section" style="padding-top:2.5rem;padding-bottom:4rem;">
    <div class="container">
        <div class="section-header" style="text-align:center;max-width:760px;margin:0 auto 2.5rem;">
            <div class="section-tag" style="margin:0 auto 1rem;">
                <span class="dot"></span>
                <span>Why Join CodeX404</span>
            </div>
            <h2 class="section-title subpage-section-title">Practical Craft, Real Systems &amp; <span
                    class="text-amber">Direct Ownership</span></h2>
            <p class="section-subtitle">
                We focus on clean software engineering, disciplined execution, and continuous learning alongside senior
                practitioners.
            </p>
        </div>

        <div class="careers-values-grid">
            <div class="careers-card">
                <div class="careers-card-icon"><?= codex_icon('users', 20) ?></div>
                <h3 style="color:#fff;font-size:1.1rem;margin-bottom:0.5rem;">Direct Team Collaboration</h3>
                <p style="color:#CBD5E1;font-size:0.92rem;line-height:1.65;margin:0;">
                    Work alongside engineering, product, and growth leads on real client and internal projects rather
                    than sitting behind layers of bureaucracy.
                </p>
            </div>
            <div class="careers-card">
                <div class="careers-card-icon"><?= codex_icon('code', 20) ?></div>
                <h3 style="color:#fff;font-size:1.1rem;margin-bottom:0.5rem;">BUILD · GROW · AUTOMATE Exposure</h3>
                <p style="color:#CBD5E1;font-size:0.92rem;line-height:1.65;margin:0;">
                    Contribute across custom web applications, digital marketing and client growth, business
                    development, or applied AI workflows.
                </p>
            </div>
            <div class="careers-card">
                <div class="careers-card-icon"><?= codex_icon('chart', 20) ?></div>
                <h3 style="color:#fff;font-size:1.1rem;margin-bottom:0.5rem;">Clear Expectations &amp; Transparency</h3>
                <p style="color:#CBD5E1;font-size:0.92rem;line-height:1.65;margin:0;">
                    Each role lists its work arrangement, duration, responsibilities, and compensation model
                    upfront—whether salaried, stipend-based, commission-linked, or unpaid learning.
                </p>
            </div>
            <div class="careers-card">
                <div class="careers-card-icon"><?= codex_icon('globe', 20) ?></div>
                <h3 style="color:#fff;font-size:1.1rem;margin-bottom:0.5rem;">Focused Remote Collaboration</h3>
                <p style="color:#CBD5E1;font-size:0.92rem;line-height:1.65;margin:0;">
                    Structured asynchronous documentation paired with scheduled overlap windows so distributed teammates
                    collaborate smoothly.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- SECTION C: OPEN POSITIONS -->
<section class="section" id="open-positions" style="padding-top:1.5rem;padding-bottom:4.5rem;">
    <div class="container">
        <div class="section-header" style="margin-bottom:2rem;">
            <div class="section-tag"><span class="dot"></span><span>Open Positions</span></div>
            <h2 class="section-title subpage-section-title">Current <span class="text-amber">Vacancies</span></h2>
            <p class="section-subtitle">Browse active roles across departments, internships, and fellowships.</p>
        </div>

        <div class="careers-filter-bar">
            <div class="careers-filter-tabs" role="tablist" aria-label="Filter vacancies by category">
                <a href="<?= url('careers') ?>#open-positions"
                    class="careers-filter-btn <?= $selectedCategory === 'all' ? 'active' : '' ?>"
                    data-cat-filter="all">All Positions</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="<?= url('careers?category=' . urlencode((string) $cat['slug'])) ?>#open-positions"
                        class="careers-filter-btn <?= $selectedCategory === $cat['slug'] ? 'active' : '' ?>"
                        data-cat-filter="<?= htmlspecialchars((string) $cat['slug']) ?>">
                        <?= htmlspecialchars((string) $cat['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <form method="GET" action="<?= url('careers') ?>#open-positions" class="careers-search-box">
                <?php if ($selectedCategory !== 'all'): ?>
                    <input type="hidden" name="category" value="<?= htmlspecialchars($selectedCategory) ?>">
                <?php endif; ?>
                <input type="search" name="q" id="careersSearchInput" class="careers-input"
                    value="<?= htmlspecialchars($searchTerm) ?>" placeholder="Search title, skills, location...">
            </form>
        </div>

        <?php if (empty($vacancies)): ?>
            <div class="careers-card" style="text-align:center;padding:3rem 1.5rem;">
                <h3 style="color:#fff;margin-bottom:0.5rem;">No Open Roles Match This Filter Right Now</h3>
                <p style="color:#94A3B8;max-width:560px;margin:0 auto 1.25rem;">
                    Try switching to "All Positions" or submit a General Application below so our team can keep your profile
                    on file for future openings.
                </p>
                <a href="<?= url('careers') ?>#general-application" class="btn btn-primary"
                    style="background:#0B5ED7;border-color:#0B5ED7;">Submit General Application</a>
            </div>
        <?php else: ?>
            <div class="careers-jobs-grid" id="careersJobsGrid">
                <?php foreach ($vacancies as $job): ?>
                    <article class="careers-job-card" data-category="<?= htmlspecialchars((string) $job['category_slug']) ?>"
                        data-search="<?= htmlspecialchars(strtolower($job['title'] . ' ' . $job['department'] . ' ' . $job['location'] . ' ' . $job['skills'])) ?>">
                        <div>
                            <div class="careers-job-meta-row">
                                <span
                                    class="careers-badge careers-badge-dept"><?= htmlspecialchars((string) $job['department']) ?></span>
                                <span
                                    class="careers-badge careers-badge-cyan"><?= htmlspecialchars((string) $job['employment_type']) ?></span>
                                <span class="careers-badge"><?= htmlspecialchars((string) $job['work_mode']) ?></span>
                                <?php if ((int) ($job['vacancies_count'] ?? 0) > 1): ?>
                                    <span class="careers-badge careers-badge-amber"><?= (int) $job['vacancies_count'] ?>
                                        Openings</span>
                                <?php endif; ?>
                            </div>

                            <h3 style="font-size:1.22rem;font-weight:700;color:#fff;margin-bottom:0.55rem;">
                                <a href="<?= url('careers/' . urlencode((string) $job['slug'])) ?>"
                                    style="color:inherit;text-decoration:none;">
                                    <?= htmlspecialchars((string) $job['title']) ?>
                                </a>
                            </h3>

                            <p style="color:#CBD5E1;font-size:0.9rem;line-height:1.6;margin-bottom:1rem;">
                                <?= htmlspecialchars((string) $job['overview']) ?>
                            </p>
                        </div>

                        <div>
                            <div class="careers-job-specs">
                                <div><span>Location</span><strong><?= htmlspecialchars((string) $job['location']) ?></strong>
                                </div>
                                <div>
                                    <span>Experience</span><strong><?= htmlspecialchars((string) $job['experience_level']) ?></strong>
                                </div>
                                <div>
                                    <span>Compensation
                                        (<?= htmlspecialchars((string) ($job['compensation_type'] ?: 'Specified')) ?>)</span><strong><?= htmlspecialchars((string) ($job['salary_display'] ?: $job['compensation_type'])) ?></strong>
                                </div>
                                <div>
                                    <span>Deadline</span><strong><?= !empty($job['application_deadline']) ? date('M j, Y', strtotime((string) $job['application_deadline'])) : 'Rolling' ?></strong>
                                </div>
                            </div>

                            <div
                                style="margin-top:1rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.75rem;">
                                <span
                                    style="font-size:0.78rem;color:#94A3B8;"><?= htmlspecialchars((string) $job['category_name']) ?></span>
                                <a href="<?= url('careers/' . urlencode((string) $job['slug'])) ?>"
                                    class="btn btn-primary btn-sm" style="background:#0B5ED7;border-color:#0B5ED7;">
                                    Apply Now &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- SECTION E: GENERAL APPLICATION (TALENT POOL) -->
<?php if ($allowGeneral): ?>
    <section class="section" id="general-application" style="padding-top:1rem;padding-bottom:5rem;">
        <div class="container" style="max-width:880px;">
            <div class="careers-form-panel">
                <div class="section-tag" style="margin-bottom:0.9rem;"><span class="dot"></span><span>General Talent
                        Pool</span></div>
                <h2 style="color:#fff;font-size:1.75rem;margin-bottom:0.6rem;">Don't See Your Role Yet? <span
                        class="careers-amber-accent">Join Our Talent Pool</span></h2>
                <p style="color:#CBD5E1;font-size:0.94rem;line-height:1.65;margin-bottom:1rem;">
                    Submit your profile cleanly into our talent pool for future openings matching your background.
                    <strong style="color:#FF8C00;">Please note:</strong> A general application does not guarantee an
                    interview or a specific job offer; our recruitment team reaches out when an aligned vacancy opens.
                </p>

                <?php if ($generalSuccess): ?>
                    <div class="careers-alert careers-alert-success">
                        <strong>General Application Received!</strong> Your Talent Pool Reference ID is
                        <code
                            style="color:#fff;font-weight:700;"><?= htmlspecialchars((string) $generalSuccess['reference_code']) ?></code>.
                        A confirmation email has been queued. You can monitor updates anytime inside our
                        <a href="<?= url('careers/application-status') ?>" style="color:#22D3EE;font-weight:700;">Applicant
                            Portal</a>.
                    </div>
                <?php endif; ?>

                <?php if ($generalError): ?>
                    <div class="careers-alert careers-alert-error"><?= htmlspecialchars($generalError) ?></div>
                <?php endif; ?>

                <form method="POST" action="<?= url('careers') ?>#general-application" enctype="multipart/form-data">
                    <?= csrf_input_field() ?>
                    <input type="hidden" name="form_mode" value="general_talent_pool">
                    <!-- Honeypot Anti-Spam -->
                    <div style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
                        <label>Website<input type="text" name="website_hp" tabindex="-1" autocomplete="off"></label>
                    </div>

                    <?= FormBuilderService::renderFormSectionsHtml($generalFields, $oldGeneral, $generalFieldErrors) ?>

                    <div style="display:flex;justify-content:flex-end;gap:1rem;align-items:center;margin-top:1.5rem;">
                        <button type="submit" class="btn btn-primary btn-lg"
                            style="background:#0B5ED7;border-color:#0B5ED7;">
                            Submit General Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php endif; ?>

<script>
    // Live search filtering alongside server-side filtering
    document.getElementById('careersSearchInput')?.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        document.querySelectorAll('#careersJobsGrid .careers-job-card').forEach(card => {
            const hay = card.dataset.search || '';
            card.style.display = (!q || hay.includes(q)) ? 'flex' : 'none';
        });
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>