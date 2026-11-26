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
                Let&rsquo;s Discuss <span class="text-gradient gradient-text-animated">Your Project</span>
            </h1>
            <p class="subpage-subtitle">
                Tell us what workflow, product, or growth bottleneck you are working on. Every inquiry goes straight to our engineering team for a thoughtful technical review.
            </p>
            <div class="contact-hero-trust">
                <span class="contact-hero-trust-item"><?= codex_icon('check', 15) ?> Direct Founder &amp; Engineer Review</span>
                <span class="contact-hero-trust-item"><?= codex_icon('shield', 15) ?> Confidentiality &amp; NDA Ready</span>
                <span class="contact-hero-trust-item"><?= codex_icon('layers', 15) ?> BUILD &middot; GROW &middot; AUTOMATE</span>
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
                            <button type="button" class="contact-copy-btn" id="copyEmailBtn" data-email="<?= htmlspecialchars(COMPANY_EMAIL, ENT_QUOTES, 'UTF-8') ?>">
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
                    <div class="contact-topic-grid">
                        <button type="button" class="contact-topic-btn is-active" data-topic="Project Discussion">
                            <span>Project Discussion</span>
                            <?= codex_icon('arrow-right', 14) ?>
                        </button>
                        <button type="button" class="contact-topic-btn" data-topic="Service Inquiry">
                            <span>Service Inquiry</span>
                            <?= codex_icon('arrow-right', 14) ?>
                        </button>
                        <button type="button" class="contact-topic-btn" data-topic="Business Partnership">
                            <span>Business Partnership</span>
                            <?= codex_icon('arrow-right', 14) ?>
                        </button>
                        <button type="button" class="contact-topic-btn" data-topic="General Inquiry">
                            <span>General Inquiry</span>
                            <?= codex_icon('arrow-right', 14) ?>
                        </button>
                    </div>
                    <a href="<?= url('careers') ?>" class="contact-topic-btn" style="margin-top: 0.6rem; border-color: rgba(255, 140, 0, 0.3);">
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
                                <span>A developer or architect reviews your goals, existing tools, and constraints directly.</span>
                            </div>
                        </li>
                        <li class="contact-step-item">
                            <span class="contact-step-num">02</span>
                            <div>
                                <strong>Practical Fit &amp; Clarifications</strong>
                                <span>We reply with targeted questions or architecture notes tailored to your budget and timeline.</span>
                            </div>
                        </li>
                        <li class="contact-step-item">
                            <span class="contact-step-num">03</span>
                            <div>
                                <strong>Clear Milestone Plan</strong>
                                <span>Once scope fits, we schedule a call and confirm deliverables cleanly in writing.</span>
                            </div>
                        </li>
                    </ul>
                </div>

            </aside>

            <!-- RIGHT COLUMN: INTERACTIVE PROJECT BRIEF STUDIO -->
            <div class="contact-form-shell">
                <div class="contact-form-top">
                    <div>
                        <h2 style="font-size: 1.45rem; color: var(--white); margin: 0 0 0.25rem;">Send Your Project or Inquiry Brief</h2>
                        <p style="font-size: 0.88rem; color: var(--slate-dark); margin: 0;">Complete the essential fields below&mdash;detailed tech specs are optional.</p>
                    </div>
                    <span class="contact-live-badge">
                        <span style="width: 7px; height: 7px; border-radius: 50%; background: #34D399; display: inline-block;"></span>
                        Direct Intake
                    </span>
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

                    <!-- Interactive BGA Pillar Selector (Synced with #division) -->
                    <div class="form-group">
                        <label for="division" class="form-label">1. Which CodeX404 Pillar Fits Best? <span class="required">*</span></label>
                        <div class="contact-pillar-picker" role="group" aria-label="Choose CodeX404 division pillar">
                            <button type="button" class="contact-pillar-btn <?= $selectedDivision === 'BUILD' ? 'is-selected' : '' ?>" data-pillar="BUILD">
                                <strong><span class="pillar-dot-build"></span>BUILD</strong>
                                <span>Web, SaaS, CRM/ERP &amp; APIs</span>
                            </button>
                            <button type="button" class="contact-pillar-btn <?= $selectedDivision === 'GROW' ? 'is-selected' : '' ?>" data-pillar="GROW">
                                <strong><span class="pillar-dot-grow"></span>GROW</strong>
                                <span>SEO, Conversion &amp; Digital Growth</span>
                            </button>
                            <button type="button" class="contact-pillar-btn <?= $selectedDivision === 'AUTOMATE' ? 'is-selected' : '' ?>" data-pillar="AUTOMATE">
                                <strong><span class="pillar-dot-automate"></span>AUTOMATE</strong>
                                <span>AI, RAG, Agents &amp; Workflows</span>
                            </button>
                        </div>

                        <select id="division" name="division" class="form-select" required>
                            <option value="">Choose a division (BUILD, GROW, or AUTOMATE)...</option>
                            <?php foreach ($divisionServiceOptions as $code => $_services): ?>
                                <option value="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>" <?= $selectedDivision === $code ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?> &mdash; <?= htmlspecialchars(match ($code) {
                                        'BUILD' => 'Software, Web Apps, CRM/ERP & SaaS',
                                        'GROW' => 'Digital Marketing, SEO & Growth',
                                        default => 'AI Systems, Agents & Automation',
                                    }, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="subject" class="form-label">2. Inquiry Topic</label>
                            <input type="text" id="subject" name="subject" class="form-control" maxlength="150" value="Project Discussion" placeholder="e.g. Project Discussion, Partnership">
                        </div>

                        <div class="form-group">
                            <label for="service" class="form-label">Specific Solution (optional)</label>
                            <select id="service" name="service" class="form-select">
                                <option value="">Choose a specific service (optional)</option>
                                <?php foreach ($divisionServiceOptions as $code => $services): ?>
                                    <optgroup label="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>" data-division="<?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>">
                                        <?php foreach ($services as $serviceCode => $serviceLabel): ?>
                                            <option value="<?= htmlspecialchars($serviceCode, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($serviceLabel, ENT_QUOTES, 'UTF-8') ?></option>
                                        <?php endforeach; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="e.g. Sarah Jenkins" required>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Work Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="name@company.com" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone / WhatsApp (optional)</label>
                            <input type="tel" id="phone" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                        </div>
                        <div class="form-group">
                            <label for="company" class="form-label">Company / Organization (optional)</label>
                            <input type="text" id="company" name="company" class="form-control" placeholder="e.g. Acme Operations">
                        </div>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="website" class="form-label">Current Website (optional)</label>
                            <input type="url" id="website" name="website" class="form-control" maxlength="255" placeholder="https://example.com">
                        </div>
                        <div class="form-group">
                            <label for="country" class="form-label">Country / Region (optional)</label>
                            <input type="text" id="country" name="country" class="form-control" maxlength="100" autocomplete="country-name" placeholder="e.g. India, UAE, UK, USA">
                        </div>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
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
                        <label for="message" class="form-label">Project Context, Bottleneck, or Inquiry Details <span class="required">*</span></label>
                        <textarea id="message" name="message" class="form-textarea" rows="4" placeholder="Briefly describe what problem you want to solve, the users involved, or what you want to discuss..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="checkbox" name="privacy_consent" value="1" required>
                            <span>I agree to the <a href="<?= url('privacy.php') ?>" target="_blank" style="color: var(--cyan); text-decoration: underline;">Privacy Policy</a> and consent to CodeX404 Solutions reviewing my details to respond to this inquiry.</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; justify-content: center;">
                        <span>Let&rsquo;s Discuss Your Project</span>
                        <?= codex_icon('arrow-right', 18) ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const divisionSelect = document.getElementById('division');
    const pillarBtns = document.querySelectorAll('.contact-pillar-btn');
    const topicBtns = document.querySelectorAll('.contact-topic-btn[data-topic]');
    const subjectInput = document.getElementById('subject');
    const copyBtn = document.getElementById('copyEmailBtn');

    const syncPillarButtons = (val) => {
        const upper = (val || '').toUpperCase();
        pillarBtns.forEach(btn => {
            btn.classList.toggle('is-selected', btn.dataset.pillar === upper);
        });
    };

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
            topicBtns.forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');
            if (subjectInput) {
                subjectInput.value = btn.dataset.topic || 'Project Discussion';
                subjectInput.focus();
            }
        });
    });

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
