<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Privacy Policy & GDPR Data Protection Notice',
    'description' => 'CodeX404 Solutions GDPR-compliant Privacy Policy detailing our data collection, lawful processing bases, retention policies, and user rights.',
    'canonical' => url('privacy.php'),
    'keywords' => 'privacy policy, GDPR compliance, data retention, user rights, CodeX404 privacy'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container container-narrow">
        <div class="section-header" style="text-align: left; margin-bottom: 2.5rem;">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Compliance & Trust</span>
            </div>
            <h1 class="section-title">Privacy Policy & Data Protection</h1>
            <p style="font-size: 0.9rem; color: var(--slate-dark);">Last updated: October 6, 2026 · Effective immediately</p>
        </div>

        <div style="background: var(--bg-surface); padding: 3rem; border-radius: var(--radius-lg); border: 1px solid var(--border-subtle); line-height: 1.8;">
            <h2 style="font-size: 1.5rem; color: var(--white); margin-bottom: 1rem;">1. Document Scope & Data Controller</h2>
            <p>
                This Privacy Policy outlines how <strong>CodeX404 Solutions</strong> ("we", "us", "our") collects, uses, protects, and handles personal data when you interact with our website (<a href="https://codex404solutions.com">codex404solutions.com</a>) or communicate with our engineering team.
            </p>
            <p>
                For data protection inquiries or to exercise your statutory privacy rights, our designated Data Protection Officer can be reached directly at <a href="mailto:<?= PRIVACY_EMAIL ?>"><?= PRIVACY_EMAIL ?></a>.
            </p>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">2. What Information We Collect</h2>
            <p>In accordance with data minimization principles, we only collect information necessary to respond to your inquiries and evaluate prospective project scopes:</p>
            <ul style="padding-left: 1.5rem; margin-bottom: 1.5rem;">
                <li><strong>Contact Information:</strong> Full name, professional work email address, telephone number, job title, and company name.</li>
                <li><strong>Project Scoping Details:</strong> Business problem summaries, target service areas, estimated budget ranges, and project timelines.</li>
                <li><strong>Technical Telemetry:</strong> IP address (masked for analytics), user-agent string, timestamp, and standard server log headers for security defense.</li>
            </ul>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">3. Lawful Basis for Processing (GDPR)</h2>
            <p>If you reside within the European Union or United Kingdom, we process your personal data under the following legal bases:</p>
            <ul style="padding-left: 1.5rem; margin-bottom: 1.5rem;">
                <li><strong>Consent (Article 6(1)(a)):</strong> You have given clear consent via explicit form checkboxes for us to process your information to respond to an inquiry.</li>
                <li><strong>Contractual Necessity (Article 6(1)(b)):</strong> Processing necessary to take steps at your request prior to entering into a master software development agreement.</li>
                <li><strong>Legitimate Interests (Article 6(1)(f)):</strong> Defending our digital infrastructure against brute-force attacks, spam bots, and security vulnerabilities.</li>
            </ul>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">4. Strict No-Sale & Sharing Policy</h2>
            <p>
                <strong>We do not sell, rent, lease, or monetize your personal information to third parties. Under any circumstances.</strong>
            </p>
            <p>
                Data is shared strictly with trusted operational infrastructure sub-processors necessary to run our service (such as encrypted cloud hosting and transactional email dispatch) under compliant data processing agreements.
            </p>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">5. Data Retention Schedule</h2>
            <ul style="padding-left: 1.5rem; margin-bottom: 1.5rem;">
                <li><strong>Active Inquiries & Client Leads:</strong> Retained for the duration of the commercial relationship.</li>
                <li><strong>Inactive Discovery Leads:</strong> Retained for a maximum of 2 years from last contact, then cryptographically anonymized or deleted.</li>
                <li><strong>Financial & Contractual Records:</strong> Retained for 7 years to fulfill statutory accounting and tax compliance regulations.</li>
                <li><strong>Security & Access Logs:</strong> Retained for 90 days before automated rotation.</li>
            </ul>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">6. Cookie Policy</h2>
            <p>Our website utilizes a limited number of cookies:</p>
            <ul style="padding-left: 1.5rem; margin-bottom: 1.5rem;">
                <li><code>PHPSESSID</code> (Essential): Standard session identifier for CSRF protection and form continuity. Expired upon browser close.</li>
                <li><code>csrf_token</code> (Essential): Cryptographic defense token guarding form submissions against unauthorized third-party requests.</li>
                <li><code>codex404_cookie_consent</code> (Essential): Remembers your cookie preference choice.</li>
            </ul>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">7. Your Statutory Rights</h2>
            <p>You possess the following rights regarding your personal information:</p>
            <ul style="padding-left: 1.5rem; margin-bottom: 1.5rem;">
                <li><strong>Right to Access:</strong> Request a full copy of the personal information we hold about you.</li>
                <li><strong>Right to Rectification:</strong> Request correction of inaccurate or incomplete contact data.</li>
                <li><strong>Right to Erasure ("Right to be Forgotten"):</strong> Request immediate permanent deletion of your contact records.</li>
                <li><strong>Right to Data Portability:</strong> Obtain your data in a structured, machine-readable JSON format.</li>
                <li><strong>Right to Object:</strong> Withdraw consent or object to any non-essential communication at any time.</li>
            </ul>
            <p>
                To exercise any statutory right, email <a href="mailto:<?= PRIVACY_EMAIL ?>"><?= PRIVACY_EMAIL ?></a>. We respond to all verified requests within 30 days free of charge.
            </p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
