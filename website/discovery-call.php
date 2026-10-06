<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/app/Controllers/LeadController.php';

use App\Controllers\LeadController;

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
    'title' => 'Book a Technical Discovery Call — Architecture & Strategy',
    'description' => 'Schedule a 30-minute discovery consultation with a CodeX404 Solutions Architect. Review feasibility, system architecture, timelines, and budgets.',
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
                <span>Direct Technical Scoping</span>
            </div>
            <h1 class="section-title">Book a 30-Minute Technical Discovery Call</h1>
            <p class="section-subtitle">
                Meet directly with a Solutions Architect. We will deconstruct your business problem, evaluate technical feasibility, and sketch out an actionable engineering roadmap.
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
                        <label for="company" class="form-label">Company Name <span class="required">*</span></label>
                        <input type="text" id="company" name="company" class="form-control" placeholder="Acme Logistics" required>
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

                <div class="grid grid-cols-3" style="gap: 1.25rem;">
                    <div class="form-group">
                        <label for="service_interest" class="form-label">Primary Solution Area <span class="required">*</span></label>
                        <select id="service_interest" name="service_interest" class="form-select" required>
                            <option value="">Select an area...</option>
                            <option value="Custom Software">Custom Software / Web Application</option>
                            <option value="Enterprise AI">Enterprise AI / RAG Knowledge Base</option>
                            <option value="AI Agents">Autonomous AI Agents</option>
                            <option value="Workflow Automation">Workflow / CRM Automation</option>
                            <option value="Mobile Applications">Cross-Platform Mobile App</option>
                            <option value="SaaS MVP">SaaS MVP Engineering</option>
                            <option value="Other">Other / Full Digital Transformation</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="budget" class="form-label">Estimated Budget</label>
                        <select id="budget" name="budget" class="form-select">
                            <option value="Under $5k">Under $5,000</option>
                            <option value="$5k - $15k" selected>$5,000 – $15,000</option>
                            <option value="$15k - $50k">$15,000 – $50,000</option>
                            <option value="$50k+">$50,000+</option>
                            <option value="Flexible / Need Guidance">Flexible / Need Architecture Guidance</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="timeline" class="form-label">Target Timeline</label>
                        <select id="timeline" name="timeline" class="form-select">
                            <option value="Immediately (< 1 month)">Immediately (&lt; 1 month)</option>
                            <option value="1 - 3 months" selected>1 – 3 months</option>
                            <option value="3 - 6 months">3 – 6 months</option>
                            <option value="Exploratory">Exploratory / Roadmap Phase</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="problem_description" class="form-label">Business Problem or Project Vision <span class="required">*</span></label>
                    <textarea id="problem_description" name="problem_description" class="form-textarea" rows="4" placeholder="Describe the operational friction you are solving, existing systems in place, or what your target software needs to do..." required></textarea>
                </div>

                <!-- GDPR Consent -->
                <div class="form-group">
                    <label class="form-checkbox-label">
                        <input type="checkbox" name="privacy_consent" value="1" required>
                        <span>I consent to CodeX404 Solutions storing this information for the purpose of scheduling and conducting this discovery consultation under the <a href="<?= url('privacy.php') ?>" target="_blank" style="color: var(--cyan); text-decoration: underline;">Privacy Policy</a>.</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                    Confirm Discovery Call Request
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </button>
            </form>

            <div style="margin-top: 1.75rem; text-align: center; font-size: 0.85rem; color: var(--slate-dark);">
                🔒 Zero spam guarantee. We never share, sell, or disclose your contact information to third parties.
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
