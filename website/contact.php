<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/app/Controllers/ContactController.php';

use App\Controllers\ContactController;
use App\Validators\FormValidator;

$divisionServiceOptions = FormValidator::serviceOptions();
$requestedDivision = is_string($_GET['division'] ?? null) ? strtoupper(trim($_GET['division'])) : '';
$selectedDivision = isset($divisionServiceOptions[$requestedDivision]) ? $requestedDivision : '';

$controllerResult = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ContactController();
    $controllerResult = $controller->handle();

    // If submitted via AJAX, return clean JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($controllerResult);
        exit;
    }
}

$pageMeta = [
    'title' => 'Contact CodeX404 Solutions — Start a Conversation',
    'description' => 'Contact CodeX404 Solutions about software, digital growth, or workflow automation. Share your goals and constraints so the team can review your enquiry.',
    'canonical' => url('contact.php'),
    'keywords' => 'contact CodeX404 Solutions, software development inquiry, AI consultation contact'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Direct Engineering Communication</span>
            </div>
            <h1 class="section-title">Tell us what you’re working on</h1>
            <p class="section-subtitle">
                Share the business goal, current setup, or workflow you want to improve. Choose the closest division, and we’ll review your enquiry.
            </p>
        </div>

        <div class="grid grid-cols-2" style="gap: 3.5rem; align-items: start;">
            <!-- Left Column: Contact details and project terms -->
            <div>
                <h2 style="font-size: 1.75rem; color: var(--white); margin-bottom: 1.25rem;">Direct Technical Access</h2>
                <p style="font-size: 1.05rem; line-height: 1.7; color: var(--slate); margin-bottom: 2rem;">
                    Tell us whether your enquiry is about BUILD, GROW, or AUTOMATE. Scope, next steps, and the people involved are confirmed for each project.
                </p>

                <div style="display: flex; flex-direction: column; gap: 1.5rem; margin-bottom: 2.5rem;">
                    <div style="display: flex; align-items: flex-start; gap: 1rem;">
                        <div class="card-icon" style="width: 44px; height: 44px; font-size: 1.25rem; margin: 0;">✉️</div>
                        <div>
                            <strong style="color: var(--white); display: block;">Primary Email</strong>
                            <a href="mailto:<?= COMPANY_EMAIL ?>" style="color: var(--cyan);"><?= COMPANY_EMAIL ?></a>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 1rem;">
                        <div class="card-icon" style="width: 44px; height: 44px; font-size: 1.25rem; margin: 0;">📅</div>
                        <div>
                            <strong style="color: var(--white); display: block;">Technical Discovery Call</strong>
                            <a href="<?= url('discovery-call.php') ?>" style="color: var(--cyan); font-weight: 600;">
                                Request a Discovery Call &rarr;
                            </a>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 1rem;">
                        <div class="card-icon" style="width: 44px; height: 44px; font-size: 1.25rem; margin: 0;">🌐</div>
                        <div>
                            <strong style="color: var(--white); display: block;">Serving</strong>
                            <span>Organizations in India and other markets by arrangement.</span>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 1rem;">
                        <div class="card-icon" style="width: 44px; height: 44px; font-size: 1.25rem; margin: 0;">⏱️</div>
                        <div>
                            <strong style="color: var(--white); display: block;">Response</strong>
                            <span>We’ll review your message and follow up by email.</span>
                        </div>
                    </div>
                </div>

                <!-- Project terms -->
                <div class="trust-badge-list" style="margin-bottom: 2rem;">
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">✓</div>
                        <span><strong>Clear project terms:</strong> Scope, deliverables, and ownership are agreed in writing for each engagement.</span>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">✓</div>
                        <span><strong>Confidentiality:</strong> Raise any NDA requirements before sharing sensitive project information.</span>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">✓</div>
                        <span><strong>Project handoff:</strong> Agree documentation, access, and handoff requirements as part of the scope.</span>
                    </div>
                </div>

                <div style="background: rgba(11, 31, 58, 0.4); padding: 1.75rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                    <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem; color: var(--cyan);">Prefer to discuss the project?</h3>
                    <p style="font-size: 0.9rem; margin-bottom: 1rem; color: var(--slate);">Send a discovery request and we’ll follow up by email about suitable next steps.</p>
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-secondary btn-sm">
                        Book a Discovery Call Instead &rarr;
                    </a>
                </div>
            </div>

            <!-- Right Column: Form Card -->
            <div class="form-card" style="border: 1px solid rgba(59, 130, 246, 0.35); box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5), 0 0 35px rgba(59, 130, 246, 0.15);">
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.35rem; color: var(--white); margin-bottom: 0.35rem;">Send Us a Message</h3>
                    <p style="font-size: 0.875rem; color: var(--slate-dark);">Fill out this form to connect directly with our engineering team.</p>
                </div>

                <div class="form-alert-container">
                    <?php if ($controllerResult): ?>
                        <div class="alert-box <?= $controllerResult['status'] === 'success' ? 'alert-success' : 'alert-danger' ?>" role="alert">
                            <?= htmlspecialchars($controllerResult['message'], ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <form action="<?= url('contact.php') ?>" method="POST" class="ajax-form" id="contactForm" novalidate>
                    <?= csrf_input_field() ?>

                    <!-- Bot Honeypot (hidden from human view) -->
                    <div style="display: none;" aria-hidden="true">
                        <label for="_gotcha">Leave this empty</label>
                        <input type="text" name="_gotcha" id="_gotcha" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Sarah Jenkins" required>
                    </div>

                    <div class="form-group">
                        <label for="division" class="form-label">Area of help <span class="required">*</span></label>
                        <select id="division" name="division" class="form-control" required>
                            <option value="">Choose a division</option>
                            <?php foreach ($divisionServiceOptions as $code => $_services): ?>
                                <option value="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>" <?= $selectedDivision === $code ? 'selected' : '' ?>><?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?> — <?= htmlspecialchars(match ($code) {
                                    'BUILD' => 'Software and digital products',
                                    'GROW' => 'Digital marketing and discoverability',
                                    default => 'Workflows, integrations, and AI',
                                }, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="email" class="form-label">Work Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="sarah@company.com" required>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone / WhatsApp</label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                        </div>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="company" class="form-label">Company / Organization</label>
                            <input type="text" id="company" name="company" class="form-control" placeholder="e.g. Acme Corp">
                        </div>
                        <div class="form-group">
                            <label for="country" class="form-label">Country / Region (optional)</label>
                            <input type="text" id="country" name="country" class="form-control" maxlength="100" autocomplete="country-name" placeholder="e.g. India">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="service" class="form-label">Primary Solution Needed (optional)</label>
                        <select id="service" name="service" class="form-control" style="background: rgba(11, 20, 38, 0.9); color: var(--white);">
                            <option value="">Choose a service (optional)</option>
                            <?php foreach ($divisionServiceOptions as $code => $services): ?>
                                <optgroup label="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>" data-division="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>">
                                    <?php foreach ($services as $serviceCode => $serviceLabel): ?>
                                        <option value="<?= htmlspecialchars($serviceCode, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($serviceLabel, ENT_QUOTES, 'UTF-8') ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="website" class="form-label">Business Website (optional)</label>
                            <input type="url" id="website" name="website" class="form-control" maxlength="255" placeholder="https://example.com">
                        </div>
                        <div class="form-group">
                            <label for="budget" class="form-label">Estimated Budget (optional)</label>
                            <select id="budget" name="budget" class="form-control">
                                <option value="">Prefer not to say</option>
                                <option value="under_5k">Under $5,000</option>
                                <option value="5k_15k">$5,000–$15,000</option>
                                <option value="15k_50k">$15,000–$50,000</option>
                                <option value="50k_plus">$50,000+</option>
                                <option value="flexible">Flexible / need guidance</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="timeline" class="form-label">Target Timeline (optional)</label>
                        <select id="timeline" name="timeline" class="form-control">
                            <option value="">Not decided</option>
                            <option value="under_1_month">Under 1 month</option>
                            <option value="1_3_months">1–3 months</option>
                            <option value="3_6_months">3–6 months</option>
                            <option value="exploratory">Exploratory / planning</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">Message Details & Challenge <span class="required">*</span></label>
                        <textarea id="message" name="message" class="form-textarea" rows="4" placeholder="Briefly describe the operational friction, manual workflows, or technical idea you want to build..." required></textarea>
                    </div>

                    <!-- GDPR Consent Checkbox -->
                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="checkbox" name="privacy_consent" value="1" required>
                            <span>I agree to the <a href="<?= url('privacy.php') ?>" target="_blank" style="color: var(--cyan); text-decoration: underline;">Privacy Policy</a> and consent to CodeX404 Solutions processing my contact and project details to reply to this inquiry.</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        Send Inquiry
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
