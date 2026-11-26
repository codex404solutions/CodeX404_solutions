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

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($controllerResult);
        exit;
    }
}

$pageMeta = [
    'title' => 'Contact CodeX404 Solutions — Start a Project Discussion',
    'description' => 'Contact CodeX404 Solutions for project discussions, service inquiries across BUILD, GROW, and AUTOMATE, business partnerships, general inquiries, or careers.',
    'canonical' => url('contact.php'),
    'keywords' => 'contact CodeX404 Solutions, software project inquiry, AI automation consultation, business partnerships'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Contact'],
];
$heroTag = 'Direct Engineering Communication';
$heroTitleHtml = 'Let&rsquo;s Discuss <span class="text-gradient">Your Project</span>';
$heroSubtitle = 'Reach out about custom software, search and conversion growth, workflow automation, business partnerships, or careers.';
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div class="grid grid-cols-2" style="gap: 3rem; align-items: start;">
            <!-- Left Column: Inquiry Pathways & Collaboration Terms -->
            <div>
                <h2 style="font-size: 1.65rem; color: var(--white); margin-bottom: 1rem;">How Can We Help?</h2>
                <p style="font-size: 1rem; line-height: 1.7; color: var(--slate); margin-bottom: 1.75rem;">
                    Share your business goal, existing setup, or technical bottleneck. Every inquiry is reviewed directly by our engineering and delivery leads—never routed through scripted call centers.
                </p>

                <!-- 5 Explicit Inquiry Options -->
                <div style="display: grid; gap: 0.85rem; margin-bottom: 2rem;">
                    <div class="card" style="padding: 1rem 1.2rem; display: flex; align-items: flex-start; gap: 0.9rem;">
                        <span class="inline-icon-box"><?= codex_icon('code', 18) ?></span>
                        <div>
                            <strong style="color: var(--white); display: block; font-size: 0.95rem;">Project Discussions &amp; Service Inquiries</strong>
                            <span style="font-size: 0.86rem; color: var(--slate);">Scope BUILD (software/SaaS/CRM), GROW (SEO/marketing), or AUTOMATE (AI/workflows) initiatives using the inquiry form.</span>
                        </div>
                    </div>

                    <div class="card" style="padding: 1rem 1.2rem; display: flex; align-items: flex-start; gap: 0.9rem;">
                        <span class="inline-icon-box"><?= codex_icon('users', 18) ?></span>
                        <div>
                            <strong style="color: var(--white); display: block; font-size: 0.95rem;">Business Partnerships &amp; General Inquiries</strong>
                            <span style="font-size: 0.86rem; color: var(--slate);">Reach us directly via <a href="mailto:<?= COMPANY_EMAIL ?>" style="color: var(--cyan);"><?= COMPANY_EMAIL ?></a> or note your partnership context in the message.</span>
                        </div>
                    </div>

                    <div class="card" style="padding: 1rem 1.2rem; display: flex; align-items: flex-start; gap: 0.9rem;">
                        <span class="inline-icon-box is-amber"><?= codex_icon('rocket', 18) ?></span>
                        <div>
                            <strong style="color: var(--white); display: block; font-size: 0.95rem;">Careers &amp; Recruitment</strong>
                            <span style="font-size: 0.86rem; color: var(--slate);">Explore open roles, internships, and fellowships on our <a href="<?= url('careers') ?>" style="color: var(--amber); font-weight: 600;">Careers Portal &rarr;</a></span>
                        </div>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 2rem;">
                    <div style="display: flex; align-items: flex-start; gap: 0.9rem;">
                        <span class="inline-icon-box"><?= codex_icon('mail', 18) ?></span>
                        <div>
                            <strong style="color: var(--white); display: block;">Direct Email</strong>
                            <a href="mailto:<?= COMPANY_EMAIL ?>" style="color: var(--cyan);"><?= COMPANY_EMAIL ?></a>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 0.9rem;">
                        <span class="inline-icon-box"><?= codex_icon('calendar', 18) ?></span>
                        <div>
                            <strong style="color: var(--white); display: block;">Prefer a Structured Call?</strong>
                            <a href="<?= url('discovery-call.php') ?>" style="color: var(--cyan); font-weight: 600;">Book a Discovery Call &rarr;</a>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 0.9rem;">
                        <span class="inline-icon-box"><?= codex_icon('globe', 18) ?></span>
                        <div>
                            <strong style="color: var(--white); display: block;">Collaboration Windows</strong>
                            <span style="font-size: 0.9rem; color: var(--slate);">Scheduled timezone overlap across India/APAC, GCC, UK/Europe, and North America.</span>
                        </div>
                    </div>
                </div>

                <div class="trust-badge-list">
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon"><?= codex_icon('check', 14) ?></div>
                        <span><strong>Clear Milestone Planning:</strong> Scopes, timelines, and deliverables agreed before build starts.</span>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon"><?= codex_icon('check', 14) ?></div>
                        <span><strong>Confidentiality &amp; NDA Ready:</strong> Mutual NDAs available prior to sharing sensitive specifications.</span>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon"><?= codex_icon('check', 14) ?></div>
                        <span><strong>Code &amp; Asset Handoff:</strong> Ownership terms confirmed cleanly in writing.</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Form Card -->
            <div class="form-card" style="border: 1px solid rgba(59, 130, 246, 0.35);">
                <div style="margin-bottom: 1.35rem;">
                    <h2 style="font-size: 1.35rem; color: var(--white); margin-bottom: 0.3rem;">Start a Conversation</h2>
                    <p style="font-size: 0.88rem; color: var(--slate-dark); margin: 0;">Complete the form below and our team will review your requirements directly.</p>
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

                    <div style="display: none;" aria-hidden="true">
                        <label for="_gotcha">Leave this empty</label>
                        <input type="text" name="_gotcha" id="_gotcha" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Sarah Jenkins" required>
                    </div>

                    <div class="form-group">
                        <label for="division" class="form-label">Primary Pillar / Inquiry Area <span class="required">*</span></label>
                        <select id="division" name="division" class="form-control" required>
                            <option value="">Choose a division</option>
                            <?php foreach ($divisionServiceOptions as $code => $_services): ?>
                                <option value="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>" <?= $selectedDivision === $code ? 'selected' : '' ?>><?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?> — <?= htmlspecialchars(match ($code) {
                                    'BUILD' => 'Software, Web Apps, CRM/ERP & SaaS',
                                    'GROW' => 'Digital Marketing, SEO & Growth',
                                    default => 'AI Systems, Agents & Automation',
                                }, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="email" class="form-label">Work Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="name@company.com" required>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone / WhatsApp</label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                        </div>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="company" class="form-label">Company / Organization</label>
                            <input type="text" id="company" name="company" class="form-control" placeholder="e.g. Acme Operations">
                        </div>
                        <div class="form-group">
                            <label for="country" class="form-label">Country / Region (optional)</label>
                            <input type="text" id="country" name="country" class="form-control" maxlength="100" autocomplete="country-name" placeholder="e.g. India">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="service" class="form-label">Specific Solution (optional)</label>
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
                        <label for="message" class="form-label">Project Details, Partnership Context, or Questions <span class="required">*</span></label>
                        <textarea id="message" name="message" class="form-textarea" rows="4" placeholder="Describe your business problem, current tools, or what you want to build, grow, or automate..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="checkbox" name="privacy_consent" value="1" required>
                            <span>I agree to the <a href="<?= url('privacy.php') ?>" target="_blank" style="color: var(--cyan); text-decoration: underline;">Privacy Policy</a> and consent to CodeX404 Solutions reviewing my contact details to respond to this inquiry.</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <span>Let&rsquo;s Discuss Your Project</span>
                        <?= codex_icon('arrow-right', 18) ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
