<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/app/Controllers/ContactController.php';

use App\Controllers\ContactController;
use App\Validators\FormValidator;

$divisionServiceOptions = FormValidator::serviceOptions();
$contactCategories = FormValidator::contactCategories();
$partnershipTypes = FormValidator::partnershipTypes();
$engagementModels = FormValidator::engagementModels();
$generalAreas = FormValidator::generalInquiryAreas();

$requestedDivision = is_string($_GET['division'] ?? null) ? strtoupper(trim($_GET['division'])) : '';
$selectedDivision = isset($divisionServiceOptions[$requestedDivision]) ? $requestedDivision : '';

$requestedTopic = is_string($_GET['topic'] ?? ($_GET['category'] ?? null))
    ? strtolower(trim((string) ($_GET['topic'] ?? $_GET['category'])))
    : '';
$selectedCategory = array_key_exists($requestedTopic, $contactCategories) ? $requestedTopic : 'project';

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
    'title' => 'Contact CodeX404 Solutions — Let\'s Discuss Your Project',
    'description' => 'Start a conversation with CodeX404 Solutions regarding custom software development, SaaS builds, SEO & digital growth, AI automation, partnerships, or careers.',
    'canonical' => url('contact.php'),
    'keywords' => 'contact CodeX404 Solutions, software project inquiry, AI automation consultation, business partnerships'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="subpage-hero">
    <div class="container">
        <div class="subpage-hero-inner">
            <div class="section-tag subpage-tag">
                <span class="dot"></span>
                <span>Direct Engineering Communication</span>
            </div>
            <h1 class="subpage-title">
                Let&rsquo;s Discuss <span class="text-amber">Your Project</span>
            </h1>
            <p class="subpage-subtitle">
                Tell us what workflow, product, or growth bottleneck you are working on. Every inquiry goes straight to
                our engineering team for a thoughtful technical review.
            </p>
            <div class="contact-hero-trust">
                <span class="contact-hero-trust-item"><?= codex_icon('check', 15) ?> Direct Founder &amp; Engineer
                    Review</span>
                <span class="contact-hero-trust-item"><?= codex_icon('shield', 15) ?> Confidentiality &amp; NDA
                    Ready</span>
                <span class="contact-hero-trust-item"><?= codex_icon('layers', 15) ?> BUILD &middot; GROW &middot;
                    AUTOMATE</span>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top: clamp(2rem, 4vw, 3.25rem);">
    <div class="container">
        <div class="contact-studio-grid">

            <!-- LEFT RAIL: CHANNELS, INQUIRY TYPES & WHAT HAPPENS NEXT -->
            <aside class="contact-rail-stack">

                <!-- 1. Direct Access Panel -->
                <div class="contact-panel">
                    <span class="contact-panel-label">Direct Contact Channels</span>
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div class="contact-direct-row">
                            <div class="contact-direct-meta">
                                <span class="inline-icon-box"><?= codex_icon('mail', 18) ?></span>
                                <div>
                                    <strong>Email Engineering Team</strong>
                                    <a href="mailto:<?= COMPANY_EMAIL ?>"><?= COMPANY_EMAIL ?></a>
                                </div>
                            </div>
                            <button type="button" class="contact-copy-btn" id="copyEmailBtn"
                                data-email="<?= htmlspecialchars(COMPANY_EMAIL, ENT_QUOTES, 'UTF-8') ?>">
                                Copy
                            </button>
                        </div>

                        <div class="contact-direct-row">
                            <div class="contact-direct-meta">
                                <span class="inline-icon-box is-amber"><?= codex_icon('calendar', 18) ?></span>
                                <div>
                                    <strong>Discovery Call</strong>
                                    <a href="<?= url('discovery-call.php') ?>">Schedule a Structured Call &rarr;</a>
                                </div>
                            </div>
                        </div>

                        <div class="contact-direct-row">
                            <div class="contact-direct-meta">
                                <span class="inline-icon-box"><?= codex_icon('globe', 18) ?></span>
                                <div>
                                    <strong>Timezone Coverage</strong>
                                    <span class="val">India/APAC &middot; GCC &middot; UK/EU &middot; US Overlap</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Inquiry Focus Shortcuts -->
                <div class="contact-panel">
                    <span class="contact-panel-label">Select What Brings You Here</span>
                    <div class="contact-topic-grid" role="tablist" aria-label="Select inquiry category">
                        <button type="button"
                            class="contact-topic-btn <?= $selectedCategory === 'project' ? 'is-active' : '' ?>"
                            data-category="project" data-topic="Project Discussion"
                            aria-pressed="<?= $selectedCategory === 'project' ? 'true' : 'false' ?>">
                            <span>Project Discussion</span>
                            <?= codex_icon('arrow-right', 14) ?>
                        </button>
                        <button type="button"
                            class="contact-topic-btn <?= $selectedCategory === 'service' ? 'is-active' : '' ?>"
                            data-category="service" data-topic="Service Inquiry"
                            aria-pressed="<?= $selectedCategory === 'service' ? 'true' : 'false' ?>">
                            <span>Service Inquiry</span>
                            <?= codex_icon('arrow-right', 14) ?>
                        </button>
                        <button type="button"
                            class="contact-topic-btn <?= $selectedCategory === 'partnership' ? 'is-active' : '' ?>"
                            data-category="partnership" data-topic="Business Partnership"
                            aria-pressed="<?= $selectedCategory === 'partnership' ? 'true' : 'false' ?>">
                            <span>Business Partnership</span>
                            <?= codex_icon('arrow-right', 14) ?>
                        </button>
                        <button type="button"
                            class="contact-topic-btn <?= $selectedCategory === 'general' ? 'is-active' : '' ?>"
                            data-category="general" data-topic="General Inquiry"
                            aria-pressed="<?= $selectedCategory === 'general' ? 'true' : 'false' ?>">
                            <span>General Inquiry</span>
                            <?= codex_icon('arrow-right', 14) ?>
                        </button>
                    </div>
                    <a href="<?= url('careers') ?>" class="contact-topic-btn"
                        style="margin-top: 0.6rem; border-color: rgba(255, 140, 0, 0.3);">
                        <span>Careers, Internships &amp; Fellowships</span>
                        <span style="color: var(--amber); font-size: 0.78rem;">Open Roles &rarr;</span>
                    </a>
                </div>

                <!-- 3. What Happens Next -->
                <div class="contact-panel">
                    <span class="contact-panel-label">What Happens After You Submit</span>
                    <ul class="contact-step-list">
                        <li class="contact-step-item">
                            <span class="contact-step-num">01</span>
                            <div>
                                <strong>Engineering Review</strong>
                                <span>A developer or architect reviews your goals, existing tools, and constraints
                                    directly.</span>
                            </div>
                        </li>
                        <li class="contact-step-item">
                            <span class="contact-step-num">02</span>
                            <div>
                                <strong>Practical Fit &amp; Clarifications</strong>
                                <span>We reply with targeted questions or architecture notes tailored to your budget and
                                    timeline.</span>
                            </div>
                        </li>
                        <li class="contact-step-item">
                            <span class="contact-step-num">03</span>
                            <div>
                                <strong>Clear Milestone Plan</strong>
                                <span>Once scope fits, we schedule a call and confirm deliverables cleanly in
                                    writing.</span>
                            </div>
                        </li>
                    </ul>
                </div>

            </aside>

            <!-- RIGHT COLUMN: INTERACTIVE PROJECT BRIEF STUDIO -->
            <div class="contact-form-shell">
                <div class="contact-form-top">
                    <div>
                        <h2 id="contactFormHeading"
                            style="font-size: 1.45rem; color: var(--white); margin: 0 0 0.25rem;">Send Your Project
                            Brief</h2>
                        <p id="contactFormSubheading" style="font-size: 0.88rem; color: var(--slate-dark); margin: 0;">
                            Complete the essential fields below&mdash;detailed tech specs are optional.</p>
                    </div>
                    <span class="contact-live-badge">
                        <span
                            style="width: 7px; height: 7px; border-radius: 50%; background: #34D399; display: inline-block;"></span>
                        <span id="contactCategoryBadge">Project Intake</span>
                    </span>
                </div>

                <div class="form-alert-container">
                    <?php if ($controllerResult): ?>
                        <div class="alert-box <?= $controllerResult['status'] === 'success' ? 'alert-success' : 'alert-danger' ?>"
                            role="alert">
                            <?= htmlspecialchars($controllerResult['message'], ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <form action="<?= url('contact.php') ?>" method="POST" class="ajax-form" id="contactForm"
                    data-active-category="<?= htmlspecialchars($selectedCategory, ENT_QUOTES, 'UTF-8') ?>" novalidate>
                    <?= csrf_input_field() ?>
                    <input type="hidden" id="inquiry_category" name="inquiry_category"
                        value="<?= htmlspecialchars($selectedCategory, ENT_QUOTES, 'UTF-8') ?>">

                    <div style="display: none;" aria-hidden="true">
                        <label for="_gotcha">Leave this empty</label>
                        <input type="text" name="_gotcha" id="_gotcha" tabindex="-1" autocomplete="off">
                    </div>

                    <!-- Interactive BGA Pillar Selector (Shown for Project Discussion & Service Inquiry) -->
                    <div class="form-group contact-cat-section" data-cat-for="project,service" id="pillarGroup">
                        <label for="division" class="form-label">Which CodeX404 Pillar Fits Best? <span
                                class="required">*</span></label>
                        <div class="contact-pillar-picker" role="group" aria-label="Choose CodeX404 division pillar">
                            <button type="button"
                                class="contact-pillar-btn <?= $selectedDivision === 'BUILD' ? 'is-selected' : '' ?>"
                                data-pillar="BUILD">
                                <strong><span class="pillar-dot-build"></span>BUILD</strong>
                                <span>Web, SaaS, CRM/ERP &amp; APIs</span>
                            </button>
                            <button type="button"
                                class="contact-pillar-btn <?= $selectedDivision === 'GROW' ? 'is-selected' : '' ?>"
                                data-pillar="GROW">
                                <strong><span class="pillar-dot-grow"></span>GROW</strong>
                                <span>SEO, Conversion &amp; Digital Growth</span>
                            </button>
                            <button type="button"
                                class="contact-pillar-btn <?= $selectedDivision === 'AUTOMATE' ? 'is-selected' : '' ?>"
                                data-pillar="AUTOMATE">
                                <strong><span class="pillar-dot-automate"></span>AUTOMATE</strong>
                                <span>AI, RAG, Agents &amp; Workflows</span>
                            </button>
                        </div>

                        <select id="division" name="division" class="form-select" required>
                            <option value="">Select division (BUILD, GROW, or AUTOMATE)...</option>
                            <?php foreach ($divisionServiceOptions as $code => $_services): ?>
                                <option value="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>"
                                    <?= $selectedDivision === $code ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?> &mdash; <?= htmlspecialchars(match ($code) {
                                             'BUILD' => 'Software, Web Apps, CRM/ERP & SaaS',
                                             'GROW' => 'Digital Marketing, SEO & Growth',
                                             default => 'AI Systems, Agents & Automation',
                                         }, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Row: Inquiry Topic + Category-Specific Primary Selector -->
                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="subject" class="form-label">Inquiry Topic</label>
                            <input type="text" id="subject" name="subject" class="form-control" maxlength="150"
                                value="<?= htmlspecialchars($contactCategories[$selectedCategory] ?? 'Project Discussion', ENT_QUOTES, 'UTF-8') ?>"
                                placeholder="e.g. Project Discussion, Partnership">
                        </div>

                        <div class="form-group contact-cat-section" data-cat-for="project,service"
                            id="serviceSelectGroup">
                            <label for="service" class="form-label" id="serviceSelectLabel">Specific Solution
                                (optional)</label>
                            <select id="service" name="service" class="form-select">
                                <option value="">Select a service (optional)</option>
                                <?php foreach ($divisionServiceOptions as $code => $services): ?>
                                    <optgroup label="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>"
                                        data-division="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>">
                                        <?php foreach ($services as $serviceCode => $serviceLabel): ?>
                                            <option value="<?= htmlspecialchars($serviceCode, ENT_QUOTES, 'UTF-8') ?>">
                                                <?= htmlspecialchars($serviceLabel, ENT_QUOTES, 'UTF-8') ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group contact-cat-section" data-cat-for="partnership" id="partnershipTypeGroup"
                            hidden>
                            <label for="partnership_type" class="form-label">Partnership Type <span
                                    class="required">*</span></label>
                            <select id="partnership_type" name="partnership_type" class="form-select" disabled>
                                <option value="">Select partnership model...</option>
                                <?php foreach ($partnershipTypes as $pKey => $pLabel): ?>
                                    <option value="<?= htmlspecialchars($pKey, ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars($pLabel, ENT_QUOTES, 'UTF-8') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group contact-cat-section" data-cat-for="general" id="generalAreaGroup" hidden>
                            <label for="inquiry_area" class="form-label">Department / Routing (optional)</label>
                            <select id="inquiry_area" name="inquiry_area" class="form-select" disabled>
                                <option value="">General Routing</option>
                                <?php foreach ($generalAreas as $aKey => $aLabel): ?>
                                    <option value="<?= htmlspecialchars($aKey, ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars($aLabel, ENT_QUOTES, 'UTF-8') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Service-Specific Engagement Model -->
                    <div class="form-group contact-cat-section" data-cat-for="service" id="engagementGroup" hidden>
                        <label for="engagement_model" class="form-label">Preferred Engagement Model (optional)</label>
                        <select id="engagement_model" name="engagement_model" class="form-select" disabled>
                            <option value="">Not decided / open to recommendation</option>
                            <?php foreach ($engagementModels as $eKey => $eLabel): ?>
                                <option value="<?= htmlspecialchars($eKey, ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($eLabel, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="e.g. Sarah Jenkins" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Work Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="name@company.com" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone / WhatsApp (optional)</label>
                            <input type="tel" id="phone" name="phone" class="form-control"
                                placeholder="+1 (555) 000-0000">
                        </div>
                        <div class="form-group">
                            <label for="company" class="form-label" id="companyLabel">Company / Organization
                                (optional)</label>
                            <input type="text" id="company" name="company" class="form-control"
                                placeholder="e.g. Acme Operations">
                        </div>
                    </div>

                    <!-- Partnership Role + Website -->
                    <div class="form-group contact-cat-section" data-cat-for="partnership" id="partnerRoleGroup" hidden>
                        <label for="partner_role" class="form-label">Your Role / Title (optional)</label>
                        <input type="text" id="partner_role" name="partner_role" class="form-control" maxlength="100"
                            placeholder="e.g. Managing Partner, Agency Director, Alliances Lead" disabled>
                    </div>

                    <div class="grid grid-cols-2 contact-cat-section" data-cat-for="project,service,partnership"
                        id="webCountryGroup" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="website" class="form-label" id="websiteLabel">Current Website (optional)</label>
                            <input type="url" id="website" name="website" class="form-control" maxlength="255"
                                placeholder="https://example.com">
                        </div>
                        <div class="form-group">
                            <label for="country" class="form-label">Country / Region (optional)</label>
                            <input type="text" id="country" name="country" class="form-control" maxlength="100"
                                autocomplete="country-name" placeholder="e.g. India, UAE, UK, USA">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 contact-cat-section" data-cat-for="project,service" id="scopingGroup"
                        style="gap: 1rem;">
                        <div class="form-group">
                            <label for="budget" class="form-label">Estimated Budget (optional)</label>
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
                            <label for="timeline" class="form-label">Target Timeline (optional)</label>
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
                        <label for="message" class="form-label" id="messageLabel">Project Context, Bottleneck, or
                            Inquiry Details <span class="required">*</span></label>
                        <textarea id="message" name="message" class="form-textarea" rows="4"
                            placeholder="Briefly describe what problem you want to solve, the users involved, or what you want to discuss..."
                            required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="checkbox" name="privacy_consent" value="1" required>
                            <span>I agree to the <a href="<?= url('privacy.php') ?>" target="_blank"
                                    style="color: var(--cyan); text-decoration: underline;">Privacy Policy</a> and
                                consent to CodeX404 Solutions reviewing my details to respond to this inquiry.</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; justify-content: center;">
                        <span id="contactSubmitLabel">Let&rsquo;s Discuss Your Project</span>
                        <?= codex_icon('arrow-right', 18) ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contactForm = document.getElementById('contactForm');
        const categoryInput = document.getElementById('inquiry_category');
        const divisionSelect = document.getElementById('division');
        const serviceSelect = document.getElementById('service');
        const serviceSelectLabel = document.getElementById('serviceSelectLabel');
        const partnershipTypeSelect = document.getElementById('partnership_type');
        const pillarBtns = document.querySelectorAll('.contact-pillar-btn');
        const topicBtns = document.querySelectorAll('.contact-topic-btn[data-category]');
        const categorySections = document.querySelectorAll('.contact-cat-section[data-cat-for]');
        const subjectInput = document.getElementById('subject');
        const companyLabel = document.getElementById('companyLabel');
        const companyInput = document.getElementById('company');
        const websiteLabel = document.getElementById('websiteLabel');
        const messageLabel = document.getElementById('messageLabel');
        const messageTextarea = document.getElementById('message');
        const formHeading = document.getElementById('contactFormHeading');
        const formSubheading = document.getElementById('contactFormSubheading');
        const categoryBadge = document.getElementById('contactCategoryBadge');
        const submitLabel = document.getElementById('contactSubmitLabel');
        const copyBtn = document.getElementById('copyEmailBtn');

        const CATEGORY_CONFIG = {
            project: {
                topic: 'Project Discussion',
                heading: 'Send Your Project Brief',
                subheading: 'Scope your custom software, growth sprint, or AI system\u2014detailed specs are optional.',
                badge: 'Project Intake',
                companyLabel: 'Company / Organization (optional)',
                companyPlaceholder: 'e.g. Acme Operations',
                websiteLabel: 'Current Website (optional)',
                messageLabel: 'Project Context, Bottleneck, or Inquiry Details <span class="required">*</span>',
                messagePlaceholder: 'Describe what problem you want to solve, the users involved, or existing systems to integrate...',
                submitText: 'Let\u2019s Discuss Your Project',
                serviceRequired: false
            },
            service: {
                topic: 'Service Inquiry',
                heading: 'Inquire About a Specific Service',
                subheading: 'Choose the pillar and capability you are evaluating so an engineer can respond with relevant details.',
                badge: 'Service Desk',
                companyLabel: 'Company / Organization (optional)',
                companyPlaceholder: 'e.g. Acme Operations',
                websiteLabel: 'Current Website (optional)',
                messageLabel: 'Service Questions & Requirements <span class="required">*</span>',
                messagePlaceholder: 'Share the service scope, technical stack, integration requirements, or delivery questions...',
                submitText: 'Send Service Inquiry',
                serviceRequired: true
            },
            partnership: {
                topic: 'Business Partnership',
                heading: 'Propose a Business or Technical Partnership',
                subheading: 'White-label engineering, agency alliances, referral channels, or technology co-delivery.',
                badge: 'Partnership Desk',
                companyLabel: 'Agency / Partner Organization (optional)',
                companyPlaceholder: 'e.g. Northstar Digital Agency',
                websiteLabel: 'Organization Website (optional)',
                messageLabel: 'Partnership Proposal & Collaboration Model <span class="required">*</span>',
                messagePlaceholder: 'Tell us about your organization, client vertical, collaboration structure, and expected project volume...',
                submitText: 'Submit Partnership Proposal',
                serviceRequired: false
            },
            general: {
                topic: 'General Inquiry',
                heading: 'Send a General Inquiry',
                subheading: 'Questions about CodeX404 Solutions, media, security, or anything else\u2014straight to our team.',
                badge: 'General Desk',
                companyLabel: 'Company / Organization (optional)',
                companyPlaceholder: 'e.g. Acme Operations',
                websiteLabel: 'Current Website (optional)',
                messageLabel: 'How Can We Help? <span class="required">*</span>',
                messagePlaceholder: 'Write your question or message here and our team will reply directly by email...',
                submitText: 'Send General Inquiry',
                serviceRequired: false
            }
        };

        const presetTopics = new Set(Object.values(CATEGORY_CONFIG).map(c => c.topic));
        let activeCategory = (categoryInput && CATEGORY_CONFIG[categoryInput.value]) ? categoryInput.value : 'project';

        const syncPillarButtons = (val) => {
            const upper = (val || '').toUpperCase();
            pillarBtns.forEach(btn => {
                btn.classList.toggle('is-selected', btn.dataset.pillar === upper);
            });
        };

        const applyCategory = (catKey, { focusSubject = false } = {}) => {
            const cfg = CATEGORY_CONFIG[catKey] || CATEGORY_CONFIG.project;
            activeCategory = catKey in CATEGORY_CONFIG ? catKey : 'project';

            if (categoryInput) categoryInput.value = activeCategory;
            if (contactForm) contactForm.dataset.activeCategory = activeCategory;

            topicBtns.forEach(btn => {
                const isMatch = btn.dataset.category === activeCategory;
                btn.classList.toggle('is-active', isMatch);
                btn.setAttribute('aria-pressed', isMatch ? 'true' : 'false');
            });

            categorySections.forEach(section => {
                const allowed = (section.dataset.catFor || '').split(',').map(s => s.trim());
                const isVisible = allowed.includes(activeCategory);
                section.hidden = !isVisible;
                section.querySelectorAll('input, select, textarea').forEach(el => {
                    el.disabled = !isVisible;
                    if (!isVisible) {
                        el.classList.remove('is-invalid');
                        el.removeAttribute('aria-invalid');
                    }
                });
            });

            // Update conditional required attributes cleanly
            const needsPillar = activeCategory === 'project' || activeCategory === 'service';
            if (divisionSelect) divisionSelect.required = needsPillar;
            if (serviceSelect) {
                serviceSelect.required = cfg.serviceRequired;
                if (serviceSelectLabel) {
                    serviceSelectLabel.innerHTML = cfg.serviceRequired
                        ? 'Specific Solution <span class="required">*</span>'
                        : 'Specific Solution (optional)';
                }
                const firstOpt = serviceSelect.querySelector('option[value=""]');
                if (firstOpt) {
                    firstOpt.textContent = cfg.serviceRequired
                        ? 'Select a service...'
                        : 'Select a service (optional)';
                }
            }
            if (partnershipTypeSelect) {
                partnershipTypeSelectSelectRequired(activeCategory === 'partnership');
            }

            // Update copy, placeholders, and submit CTA
            if (formHeading) formHeading.textContent = cfg.heading;
            if (formSubheading) formSubheading.textContent = cfg.subheading;
            if (categoryBadge) categoryBadge.textContent = cfg.badge;
            if (companyLabel) companyLabel.textContent = cfg.companyLabel;
            if (companyInput) companyInput.placeholder = cfg.companyPlaceholder;
            if (websiteLabel) websiteLabel.textContent = cfg.websiteLabel;
            if (messageLabel) messageLabel.innerHTML = cfg.messageLabel;
            if (messageTextarea) messageTextarea.placeholder = cfg.messagePlaceholder;
            if (submitLabel) submitLabel.textContent = cfg.submitText;

            if (subjectInput && (subjectInput.value.trim() === '' || presetTopics.has(subjectInput.value.trim()))) {
                subjectInput.value = cfg.topic;
            }
            if (focusSubject && subjectInput) {
                subjectInput.focus({ preventScroll: true });
            }
        };

        function partnershipTypeSelectSelectRequired(isReq) {
            if (partnershipTypeSelect) partnershipTypeSelect.required = isReq;
        }

        pillarBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                if (!divisionSelect) return;
                divisionSelect.value = btn.dataset.pillar || '';
                syncPillarButtons(divisionSelect.value);
                divisionSelect.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });

        if (divisionSelect) {
            divisionSelect.addEventListener('change', () => syncPillarButtons(divisionSelect.value));
        }

        topicBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const cat = btn.dataset.category || 'project';
                applyCategory(cat, { focusSubject: false });
            });
        });

        if (contactForm) {
            contactForm.addEventListener('reset', () => {
                requestAnimationFrame(() => {
                    applyCategory(activeCategory);
                    syncPillarButtons(divisionSelect ? divisionSelect.value : '');
                });
            });
        }

        // Initialize state on load
        applyCategory(activeCategory);
        syncPillarButtons(divisionSelect ? divisionSelect.value : '');

        if (copyBtn) {
            copyBtn.addEventListener('click', () => {
                const email = copyBtn.dataset.email || '';
                if (!email) return;
                navigator.clipboard?.writeText(email).then(() => {
                    const orig = copyBtn.textContent;
                    copyBtn.textContent = 'Copied!';
                    setTimeout(() => { copyBtn.textContent = orig; }, 1600);
                });
            });
        }
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>