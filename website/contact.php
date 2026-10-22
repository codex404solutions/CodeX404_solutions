<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/app/Controllers/ContactController.php';

use App\Controllers\ContactController;

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
    'description' => 'Get in touch with CodeX404 Solutions. Direct access to our solutions engineering team for inquiries regarding custom software, AI, or business automation.',
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
            <h1 class="section-title">Let's Discuss Your System Architecture</h1>
            <p class="section-subtitle">
                Have a question, technical specification, or operational bottleneck to solve? Send us a message and our lead solutions architect will review and reply within 24 business hours.
            </p>
        </div>

        <div class="grid grid-cols-2" style="gap: 3.5rem; align-items: start;">
            <!-- Left Column: Direct Access & Trust Guarantees -->
            <div>
                <h2 style="font-size: 1.75rem; color: var(--white); margin-bottom: 1.25rem;">Direct Technical Access</h2>
                <p style="font-size: 1.05rem; line-height: 1.7; color: var(--slate); margin-bottom: 2rem;">
                    We skip the aggressive sales pitches and account manager layers. When you reach out to CodeX404 Solutions, you discuss your challenges directly with technical practitioners who build software.
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
                        <div class="card-icon" style="width: 44px; height: 44px; font-size: 1.25rem; margin: 0;">💬</div>
                        <div>
                            <strong style="color: var(--white); display: block;">Instant WhatsApp Discussion</strong>
                            <a href="<?= COMPANY_WHATSAPP_URL ?>" target="_blank" rel="noopener noreferrer" style="color: #25D366; font-weight: 600;">
                                Chat on WhatsApp (<?= COMPANY_WHATSAPP_NUMBER ?>) &rarr;
                            </a>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 1rem;">
                        <div class="card-icon" style="width: 44px; height: 44px; font-size: 1.25rem; margin: 0;">🌐</div>
                        <div>
                            <strong style="color: var(--white); display: block;">Operating Hub</strong>
                            <span><?= COMPANY_LOCATION ?></span>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 1rem;">
                        <div class="card-icon" style="width: 44px; height: 44px; font-size: 1.25rem; margin: 0;">⏱️</div>
                        <div>
                            <strong style="color: var(--white); display: block;">Turnaround Commitment</strong>
                            <span>Direct technical response within 24 business hours</span>
                        </div>
                    </div>
                </div>

                <!-- Trust Guarantees -->
                <div class="trust-badge-list" style="margin-bottom: 2rem;">
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">✓</div>
                        <span><strong>100% IP & Code Ownership:</strong> Complete source code and database ownership upon delivery.</span>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">✓</div>
                        <span><strong>Mutual NDA Protection:</strong> Strict confidentiality before technical scoping.</span>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">✓</div>
                        <span><strong>Zero Vendor Lock-in:</strong> Clean, portable, documented code running on open standards.</span>
                    </div>
                </div>

                <div style="background: rgba(11, 31, 58, 0.4); padding: 1.75rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                    <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem; color: var(--cyan);">Looking for a dedicated video strategy session?</h3>
                    <p style="font-size: 0.9rem; margin-bottom: 1rem; color: var(--slate);">For complex architectures, complete our Discovery Questionnaire to schedule a video roadmap call.</p>
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
                            <label for="subject" class="form-label">Primary Solution Needed</label>
                            <select id="subject" name="subject" class="form-control" style="background: rgba(11, 20, 38, 0.9); color: var(--white);">
                                <option value="Turnkey Booking & Appointment System">Turnkey Booking System (Dental / Salon / Spa / Restaurant)</option>
                                <option value="Custom Software Development">Custom Software / Web Platform</option>
                                <option value="Enterprise AI & RAG">Enterprise AI & Knowledge Base (RAG)</option>
                                <option value="Autonomous AI Agents">Autonomous AI Agents</option>
                                <option value="Workflow & WhatsApp Automation">Workflow & WhatsApp Automation</option>
                                <option value="Mobile App Development">Mobile App (iOS/Android/PWA)</option>
                                <option value="SaaS & MVP Engineering">SaaS MVP Development</option>
                                <option value="General Architecture Consultation">Other / General Consultation</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">Message Details & Challenge <span class="required">*</span></label>
                        <textarea id="message" name="message" class="form-textarea" rows="4" placeholder="Briefly describe the operational friction, manual workflows, or technical idea you want to build..." required></textarea>
                    </div>

                    <!-- GDPR Consent Checkbox -->
                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="checkbox" name="privacy_consent" value="1" required>
                            <span>I agree to the <a href="<?= url('privacy.php') ?>" target="_blank" style="color: var(--cyan); text-decoration: underline;">Privacy Policy</a> and consent to CodeX404 Solutions processing my contact details to reply to this inquiry.</span>
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
