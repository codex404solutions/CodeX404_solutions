<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Security and Data Protection',
    'description' => 'Discuss application security, privacy, access, and recovery requirements for your software project with CodeX404 Solutions.',
    'canonical' => url('security.php'),
    'keywords' => 'software security, data protection, application security, secure engineering'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Project security considerations</span>
            </div>
            <h1 class="section-title">Plan security and data protection for your system</h1>
            <p class="section-subtitle">
                Controls depend on the application, data, hosting, and applicable requirements. We discuss these constraints during scoping and document the agreed responsibilities and controls for each engagement.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- 1. Application Layer Security -->
            <div class="card card-tilt reveal-on-scroll">
                <div class="card-icon">🛡️</div>
                <h2 class="card-title">Application Layer Defenses</h2>
                <p class="card-description">
                    The public enquiry workflow validates input, checks a CSRF token, and uses rate limits and a honeypot. Other application endpoints require a separate implementation review.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Form validation</span>
                    <span class="tag-chip">CSRF validation</span>
                    <span class="tag-chip">Rate limits</span>
                </div>
            </div>

            <!-- 2. Encryption Everywhere -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon">🔒</div>
                <h2 class="card-title">Transport and data storage</h2>
                <p class="card-description">
                    Transport security, encryption, backup, and secret handling depend on the selected hosting and services. Confirm the required controls and their owners before implementation.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Hosting review</span>
                    <span class="tag-chip">Data classification</span>
                    <span class="tag-chip">Secret handling</span>
                </div>
            </div>

            <!-- 3. Authentication & RBAC -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon">🔑</div>
                <h2 class="card-title">Identity & Access Control</h2>
                <p class="card-description">
                    Authentication and authorization should match user roles and the sensitivity of the system. Identify administrative accounts, access boundaries, and recovery needs in the design.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Access boundaries</span>
                    <span class="tag-chip">Role requirements</span>
                    <span class="tag-chip">Account recovery</span>
                </div>
            </div>

            <!-- 4. GDPR & EU Data Protection -->
            <div class="card card-tilt reveal-on-scroll">
                <div class="card-icon">🇪🇺</div>
                <h2 class="card-title">Privacy and data protection</h2>
                <p class="card-description">
                    Data protection requirements depend on the project, jurisdiction, and systems involved. We discuss applicable handling, access, retention, and deletion requirements during scoping.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Data minimization</span>
                    <span class="tag-chip">Retention needs</span>
                    <span class="tag-chip">Access and deletion</span>
                </div>
            </div>

            <!-- 5. Rate Limiting & Abuse Defense -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon">⏱️</div>
                <h2 class="card-title">Rate Limiting & Anti-Abuse</h2>
                <p class="card-description">
                    Contact and discovery submissions use request validation, rate limiting, CSRF checks, and a honeypot. Review other public endpoints separately for their own abuse controls.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Form protections</span>
                    <span class="tag-chip">Abuse monitoring</span>
                    <span class="tag-chip">Endpoint review</span>
                </div>
            </div>

            <!-- 6. Automated Backups & Disaster Recovery -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon">💾</div>
                <h2 class="card-title">Resilience & Backups</h2>
                <p class="card-description">Backup and recovery requirements are defined for each system based on its hosting, data, and availability needs. Confirm the operational owner and restore process before launch.</p>
                <div class="card-tags">
                    <span class="tag-chip">Backup ownership</span>
                    <span class="tag-chip">Restore procedure</span>
                    <span class="tag-chip">Recovery objectives</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Security Vulnerability Reporting -->
<section class="section" style="background: rgba(11, 31, 58, 0.3);">
    <div class="container container-narrow" style="text-align: center;">
        <h2 style="font-size: 1.75rem; margin-bottom: 1rem;">Responsible Vulnerability Disclosure</h2>
        <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1.5rem;">
            If you believe you have identified a security vulnerability in a CodeX404 system, please email our security team with enough detail to reproduce the issue. We will review the report and follow up.
        </p>
        <div style="font-size: 1rem; color: var(--cyan); font-family: var(--font-mono);">
            security@codex404solutions.com
        </div>
    </div>
</section>

<?php
$ctaHeading = "Have specific compliance or infosec requirements?";
$ctaSubtitle = "We are happy to sign custom NDAs, complete security questionnaires, and review architecture perimeters.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
