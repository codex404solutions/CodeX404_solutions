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
                <span>Security & Compliance</span>
            </div>
            <h1 class="section-title">Enterprise Security & Data Protection Standards</h1>
            <p class="section-subtitle">
                Security is engineered into our architecture from day one. We enforce OWASP Top 10 hardening, zero-trust access controls, end-to-end encryption, and rigorous data protection across all client platforms.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- 1. Application Layer Security -->
            <div class="card card-tilt reveal-on-scroll">
                <div class="card-icon">🛡️</div>
                <h2 class="card-title">Application Layer Defenses</h2>
                <p class="card-description">
                    OWASP Top 10 hardening, strictly parameterized PDO SQL queries, rigorous CSRF token checks, automated XSS escaping, and strict input sanitization.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">PDO Prepared Stmts</span>
                    <span class="tag-chip">CSRF Protection</span>
                    <span class="tag-chip">XSS Sanitization</span>
                </div>
            </div>

            <!-- 2. Encryption Everywhere -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon">🔒</div>
                <h2 class="card-title">Transport & At-Rest Encryption</h2>
                <p class="card-description">
                    Enforced TLS 1.3 in transit, AES-256 encryption for sensitive database fields, secure environment secret isolation, and strict credential hygiene.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">TLS 1.3 Everywhere</span>
                    <span class="tag-chip">AES-256 Storage</span>
                    <span class="tag-chip">Zero Plaintext Secrets</span>
                </div>
            </div>

            <!-- 3. Authentication & RBAC -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon">🔑</div>
                <h2 class="card-title">Identity & Role-Based Access</h2>
                <p class="card-description">
                    Granular Role-Based Access Control (RBAC), multi-factor authentication (MFA) readiness, secure Argon2id/Bcrypt password hashing, and instant session revocation.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Argon2id Hashing</span>
                    <span class="tag-chip">Granular RBAC</span>
                    <span class="tag-chip">Session Isolation</span>
                </div>
            </div>

            <!-- 4. GDPR & EU Data Protection -->
            <div class="card card-tilt reveal-on-scroll">
                <div class="card-icon">🇪🇺</div>
                <h2 class="card-title">Privacy & GDPR Compliance</h2>
                <p class="card-description">
                    Engineered to meet GDPR and international data sovereignty standards. Includes automated data retention schedules, audit trails, and right-to-be-forgotten handling.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">GDPR Aligned</span>
                    <span class="tag-chip">Data Minimization</span>
                    <span class="tag-chip">Audit Trails</span>
                </div>
            </div>

            <!-- 5. Rate Limiting & Abuse Defense -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon">⏱️</div>
                <h2 class="card-title">Rate Limiting & Abuse Defense</h2>
                <p class="card-description">
                    Multi-tier DDoS mitigation, sliding-window rate limiters, automated bot honeypots, and IP reputation filtering to prevent brute-force and credential stuffing.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Sliding Window Limits</span>
                    <span class="tag-chip">Bot Honeypots</span>
                    <span class="tag-chip">Brute-Force Guard</span>
                </div>
            </div>

            <!-- 6. Automated Backups & Disaster Recovery -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon">💾</div>
                <h2 class="card-title">Resilience & Disaster Recovery</h2>
                <p class="card-description">
                    Automated offsite database snapshots, point-in-time recovery, containerized failover procedures, and verified disaster recovery playbooks for 99.9% uptime.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Automated Snapshots</span>
                    <span class="tag-chip">Point-in-Time Recovery</span>
                    <span class="tag-chip">99.9% Uptime Goal</span>
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
