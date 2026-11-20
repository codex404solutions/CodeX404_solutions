<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/app/Controllers/LeadController.php';

use App\Controllers\LeadController;
use App\Validators\FormValidator;

$divisionServiceOptions = FormValidator::serviceOptions();
$requestedDivision = is_string($_GET['division'] ?? null) ? strtoupper(trim($_GET['division'])) : '';
$selectedDivision = isset($divisionServiceOptions[$requestedDivision]) ? $requestedDivision : '';

$leadResult = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new LeadController();
    $leadResult = $controller->handleDiscovery();

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($leadResult);
        exit;
    }
}

$pageMeta = [
    'title' => 'Request a Technical Discovery Call — CodeX404 Solutions',
    'description' => 'Request a discovery call about software, digital growth, or workflow automation. Share the project context so the team can review suitable next steps.',
    'canonical' => url('discovery-call.php'),
    'keywords' => 'book discovery call, software consultation, AI architecture session, software scoping'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container container-narrow">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Project Discovery Request</span>
            </div>
            <h1 class="section-title">Schedule a Technical Discovery Call</h1>
            <p class="section-subtitle">
                Discuss your system requirements, architecture, and timeline directly with our founding engineers. No sales reps, no fluff—just actionable engineering insights.
            </p>
        </div>

        <div class="form-card">
            <div class="form-alert-container">
                <?php if ($leadResult): ?>
                    <div class="alert-box <?= $leadResult['status'] === 'success' ? 'alert-success' : 'alert-danger' ?>" role="alert">
                        <?= htmlspecialchars($leadResult['message'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>
            </div>

            <form action="<?= url('discovery-call.php') ?>" method="POST" class="ajax-form" id="discoveryForm" novalidate>
                <?= csrf_input_field() ?>

                <!-- Honeypot -->
                <div style="display: none;" aria-hidden="true">
                    <label for="_gotcha">Leave this empty</label>
                    <input type="text" name="_gotcha" id="_gotcha" tabindex="-1" autocomplete="off">
                </div>

                <div class="grid grid-cols-2" style="gap: 1.25rem;">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="e.g. David Vance" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Work Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="david@company.com" required>
                    </div>
                </div>

                <div class="grid grid-cols-3" style="gap: 1.25rem;">
                    <div class="form-group">
                        <label for="company" class="form-label">Company Name (optional)</label>
                        <input type="text" id="company" name="company" class="form-control" placeholder="Acme Logistics">
                    </div>

                    <div class="form-group">
                        <label for="country" class="form-label">Country / Region</label>
                        <input type="text" id="country" name="country" class="form-control" placeholder="e.g. United States, UK, UAE">
                    </div>

                    <div class="form-group">
                        <label for="job_title" class="form-label">Your Role / Title</label>
                        <input type="text" id="job_title" name="job_title" class="form-control" placeholder="Founder, COO, CTO">
                    </div>
                </div>

                    <div class="form-group">
                        <label for="division" class="form-label">Division <span class="required">*</span></label>
                        <select id="division" name="division" class="form-select" required>
                            <option value="">Choose a division...</option>
                            <?php foreach ($divisionServiceOptions as $code => $_services): ?>
                                <option value="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>" <?= $selectedDivision === $code ? 'selected' : '' ?>><?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?> — <?= htmlspecialchars(match ($code) {
                                    'BUILD' => 'Software and digital products',
                                    'GROW' => 'Digital marketing and discoverability',
                                    default => 'Workflows, integrations, and AI',
                                }, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>

                <div class="grid grid-cols-3" style="gap: 1.25rem;">
                    <div class="form-group">
                        <label for="service_interest" class="form-label">Primary Solution Area <span class="required">*</span></label>
                        <select id="service_interest" name="service_interest" class="form-select" required>
                            <option value="">Select a service area...</option>
                            <?php foreach ($divisionServiceOptions as $code => $services): ?>
                                <optgroup label="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>" data-division="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>">
                                    <?php foreach ($services as $serviceCode => $serviceLabel): ?>
                                        <option value="<?= htmlspecialchars($serviceCode, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($serviceLabel, ENT_QUOTES, 'UTF-8') ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="budget" class="form-label">Estimated Budget</label>
                        <select id="budget" name="budget" class="form-select">
                            <option value="">Prefer not to say</option>
                            <option value="under_5k">Under $5,000</option>
                            <option value="5k_15k">$5,000–$15,000</option>
                            <option value="15k_50k">$15,000–$50,000</option>
                            <option value="50k_plus">$50,000+</option>
                            <option value="flexible">Flexible / need guidance</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="timeline" class="form-label">Target Timeline</label>
                        <select id="timeline" name="timeline" class="form-select">
                            <option value="">Not decided</option>
                            <option value="under_1_month">Under 1 month</option>
                            <option value="1_3_months">1–3 months</option>
                            <option value="3_6_months">3–6 months</option>
                            <option value="exploratory">Exploratory / planning</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="website" class="form-label">Business Website (optional)</label>
                    <input type="url" id="website" name="website" class="form-control" maxlength="255" placeholder="https://example.com">
                </div>

                <div class="form-group">
                    <label for="problem_description" class="form-label">Business Problem or Project Vision <span class="required">*</span></label>
                    <textarea id="problem_description" name="problem_description" class="form-textarea" rows="4" placeholder="Describe the operational friction you are solving, existing systems in place, or what your target software needs to do..." required></textarea>
                </div>

                <!-- GDPR Consent -->
                <div class="form-group">
                    <label class="form-checkbox-label">
                        <input type="checkbox" name="privacy_consent" value="1" required>
                        <span>I consent to CodeX404 Solutions processing my contact and project details to review this request and follow up under the <a href="<?= url('privacy.php') ?>" target="_blank" style="color: var(--cyan); text-decoration: underline;">Privacy Policy</a>.</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                    Send Discovery Call Request
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </button>
            </form>

            <div style="margin-top: 1.75rem; text-align: center; font-size: 0.85rem; color: var(--slate-dark);">
                Protected by CSRF and rate-limiting safeguards. Your project specifications are kept strictly confidential under mutual NDA standards.
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
