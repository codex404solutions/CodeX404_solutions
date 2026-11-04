<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Security, Data Privacy & GDPR Compliance',
    'description' => 'Our comprehensive engineering security standards: zero-trust architecture, parameterized queries, CSRF validation, encryption at rest and in transit, and GDPR compliance.',
    'canonical' => url('security.php'),
    'keywords' => 'software security, GDPR compliance, data privacy, secure engineering, OWASP security'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Defense in Depth</span>
            </div>
            <h1 class="section-title">Security & Data Privacy Engineered into Every Layer</h1>
            <p class="section-subtitle">
                We believe security cannot be an afterthought bolted on before launch. Our software engineering practices adhere strictly to OWASP guidelines, zero-trust network boundaries, and international data protection laws.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- 1. Application Layer Security -->
            <div class="card">
                <div class="card-icon">🛡️</div>
                <h2 class="card-title">Application Layer Defenses</h2>
                <p class="card-description">
                    All database interactions utilize PDO prepared statements with strict parameterization to eliminate SQL injection risks. Outputs are contextual HTML escaped to neutralize Cross-Site Scripting (XSS).
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Prepared Queries</span>
                    <span class="tag-chip">CSRF Tokens</span>
                    <span class="tag-chip">Contextual Escaping</span>
                </div>
            </div>

            <!-- 2. Encryption Everywhere -->
            <div class="card">
                <div class="card-icon">🔒</div>
                <h2 class="card-title">End-to-End Encryption</h2>
                <p class="card-description">
                    All data in transit is encrypted using TLS 1.3 with strict HTTP Strict Transport Security (HSTS) headers. Sensitive database columns, API tokens, and credentials are encrypted at rest using AES-256.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">TLS 1.3 Only</span>
                    <span class="tag-chip">AES-256 At Rest</span>
                    <span class="tag-chip">HSTS Preload</span>
                </div>
            </div>

            <!-- 3. Authentication & RBAC -->
            <div class="card">
                <div class="card-icon">🔑</div>
                <h2 class="card-title">Identity & Access Control</h2>
                <p class="card-description">
                    Passwords are systematically hashed using industry-standard bcrypt / Argon2id with high work factors. Granular Role-Based Access Control (RBAC) ensures users can only access their authorized scope.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Bcrypt / Argon2id</span>
                    <span class="tag-chip">Granular RBAC</span>
                    <span class="tag-chip">Session Invalidation</span>
                </div>
            </div>

            <!-- 4. GDPR & EU Data Protection -->
            <div class="card">
                <div class="card-icon">🇪🇺</div>
                <h2 class="card-title">GDPR & UK DPA Compliance</h2>
                <p class="card-description">
                    Engineered for clients serving European and UK customers. We implement explicit cookie consent mechanisms, data minimization, automated data export, and cryptographic erasure workflows.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Consent Logs</span>
                    <span class="tag-chip">Right to Erasure</span>
                    <span class="tag-chip">Data Portability</span>
                </div>
            </div>

            <!-- 5. Rate Limiting & Abuse Defense -->
            <div class="card">
                <div class="card-icon">⏱️</div>
                <h2 class="card-title">Rate Limiting & Anti-Abuse</h2>
                <p class="card-description">
                    Public endpoints and login forms are protected with IP and session-based rate limits, cryptographic honeypots, and token validation to thwart credential stuffing and automated bot scraping.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Leaky Bucket Limits</span>
                    <span class="tag-chip">Honeypot Traps</span>
                    <span class="tag-chip">Bot Mitigation</span>
                </div>
            </div>

            <!-- 6. Automated Backups & Disaster Recovery -->
            <div class="card">
                <div class="card-icon">💾</div>
                <h2 class="card-title">Resilience & Backups</h2>
                <p class="card-description">
                    Automated off-site database snapshots, transaction write-ahead logs, and tested disaster recovery failover procedures guarantee minimal Recovery Point (RPO) and Recovery Time (RTO) objectives.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Automated Snapshots</span>
                    <span class="tag-chip">Off-Site Storage</span>
                    <span class="tag-chip">Tested Restores</span>
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
            We take application security seriously. If you believe you have identified a security vulnerability in any CodeX404 system, please notify our security team directly. We commit to acknowledging receipt within 24 hours.
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
