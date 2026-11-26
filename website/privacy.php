<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Privacy Policy & Data Protection',
    'description' => 'Information about the contact details and project information submitted through the CodeX404 Solutions website, optional analytics, and privacy requests.',
    'canonical' => url('privacy.php'),
    'keywords' => 'privacy policy, data protection, analytics preferences, CodeX404 privacy'
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
            <p style="font-size: 0.9rem; color: var(--slate-dark);">Last updated: November 19, 2026</p>
        </div>

        <div class="obsidian-lit-panel is-subtle"
            style="background: var(--bg-surface); padding: clamp(1.35rem, 3.5vw, 3rem); border-radius: var(--radius-lg); border: 1px solid var(--border-subtle); line-height: 1.8;">
            <h2 style="font-size: 1.5rem; color: var(--white); margin-bottom: 1rem;">1. Document Scope & Data Controller
            </h2>
            <p>
                This Privacy Policy outlines how <strong>CodeX404 Solutions</strong> ("we", "us", "our") collects, uses,
                protects, and handles personal data when you interact with our website (<a
                    href="https://codex404solutions.com">codex404solutions.com</a>) or communicate with our engineering
                team.
            </p>
            <p>
                For privacy questions or requests, contact us at <a
                    href="mailto:<?= PRIVACY_EMAIL ?>"><?= PRIVACY_EMAIL ?></a>. Requests are handled under the privacy
                laws applicable to your location.
            </p>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">2. What Information We Collect</h2>
            <p>Information submitted through our forms may include:</p>
            <ul style="padding-left: 1.5rem; margin-bottom: 1.5rem;">
                <li><strong>Contact Information:</strong> Full name, email address, telephone number, job title, company
                    name, and country or region when supplied.</li>
                <li><strong>Project Scoping Details:</strong> Business problem summaries, target service areas, business
                    website, estimated budget ranges, and project timelines.</li>
                <li><strong>Technical and security information:</strong> Session and request information used to protect
                    forms from abuse. Web server logs may also be handled by the hosting provider under its
                    configuration.</li>
            </ul>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">3. How information is used</h2>
            <p>We use submitted contact and project details to review and respond to enquiries, discuss possible work,
                and protect the website from abuse. We do not use contact form details for marketing subscriptions
                unless you separately opt in.</p>
            <ul style="padding-left: 1.5rem; margin-bottom: 1.5rem;">
                <li>Contact details and the message you submit are used to respond to that enquiry.</li>
                <li>Security-related request information may be used to detect and limit abusive submissions.</li>
                <li>Optional analytics is enabled only after you choose “Accept Cookies” in the site banner.</li>
            </ul>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">4. Strict No-Sale & Sharing Policy
            </h2>
            <p>
                <strong>We do not sell personal information submitted through this website.</strong>
            </p>
            <p>
                Information may be handled by the website host, configured CRM endpoint, email transport, or Google
                Analytics when analytics is enabled. The services used depend on the active website configuration.
            </p>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">5. Data Retention Schedule</h2>
            <p>Enquiry information is retained while it is needed to respond, manage a potential or active business
                relationship, and meet applicable recordkeeping requirements. Contact us if you want to request access,
                correction, or deletion. Web server log retention is controlled by the hosting configuration.</p>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">6. Cookie Policy</h2>
            <p>Essential session storage supports form security. The site stores your analytics choice in browser local
                storage. Google Analytics loads only after you accept; choosing “Essential Only” keeps it disabled.
                Browser storage and any analytics cookies can also be cleared through your browser settings.</p>
            <ul style="padding-left: 1.5rem; margin-bottom: 1.5rem;">
                <li><code>PHPSESSID</code> (Essential, when a form session is used): Supports server-side form security.
                </li>
                <li><code>codex404_cookie_consent</code> (Browser local storage): Remembers whether optional analytics
                    was accepted or declined.</li>
            </ul>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">7. Your Statutory Rights</h2>
            <p>Depending on your location and applicable law, you may have rights to:</p>
            <ul style="padding-left: 1.5rem; margin-bottom: 1.5rem;">
                <li><strong>Right to Access:</strong> Request a full copy of the personal information we hold about you.
                </li>
                <li><strong>Right to Rectification:</strong> Request correction of inaccurate or incomplete contact
                    data.</li>
                <li><strong>Deletion:</strong> Request deletion of personal information, subject to applicable legal
                    exceptions.</li>
                <li><strong>Right to Data Portability:</strong> Obtain your data in a structured, machine-readable JSON
                    format.</li>
                <li><strong>Right to Object:</strong> Withdraw consent or object to any non-essential communication at
                    any time.</li>
            </ul>
            <p>
                To make a privacy request, email <a href="mailto:<?= PRIVACY_EMAIL ?>"><?= PRIVACY_EMAIL ?></a>. We may
                ask for information needed to verify and process the request.
            </p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>