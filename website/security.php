<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Security & Data Protection Practices | CodeX404 Solutions',
    'description' => 'Learn how CodeX404 Solutions approaches application security, prepared database queries, role-based access control, secret isolation, and responsible vulnerability reporting.',
    'canonical' => url('security.php'),
    'keywords' => 'software security, data protection, application security, secure engineering, OWASP practices'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Trust & Legal'],
    ['label' => 'Security'],
];
$heroTag = 'Security & Data Protection';
$heroTitleHtml = 'Security &amp; Data Protection <span class="text-amber">Engineered Into Every Layer</span>';
$heroSubtitle = 'Security is integrated from initial database design through deployment—enforcing prepared SQL queries, credential hygiene, least-privilege roles, and encrypted transport.';
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-build"><?= codex_icon('shield', 24) ?></div>
                <h2 class="card-title">Application Layer Defenses</h2>
                <p class="card-description">OWASP-informed hardening with parameterized PDO SQL queries, CSRF tokens on
                    state changes, output escaping, and server-side validation.</p>
                <div class="card-tags"><span class="tag-chip">PDO Prepared Queries</span><span class="tag-chip">CSRF
                        Protection</span><span class="tag-chip">Output Escaping</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-build"><?= codex_icon('lock', 24) ?></div>
                <h2 class="card-title">Transport &amp; Secret Hygiene</h2>
                <p class="card-description">HTTPS/TLS transport enforcement, environment-isolated `.env` credentials
                    excluded from version control, and zero plaintext password storage.</p>
                <div class="card-tags"><span class="tag-chip">HTTPS / TLS</span><span class="tag-chip">Env
                        Isolation</span><span class="tag-chip">Hashed Passwords</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-build"><?= codex_icon('key', 24) ?></div>
                <h2 class="card-title">Identity &amp; Role Access</h2>
                <p class="card-description">Least-privilege Role-Based Access Control (RBAC), secure session cookies,
                    bcrypt/Argon2 password hashing, and explicit authorization checks.</p>
                <div class="card-tags"><span class="tag-chip">RBAC Boundaries</span><span class="tag-chip">Password
                        Hashing</span><span class="tag-chip">Session Security</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-grow"><?= codex_icon('file', 24) ?></div>
                <h2 class="card-title">Privacy-Conscious Data Handling</h2>
                <p class="card-description">Minimal collection of form and applicant data, clear consent checkpoints,
                    and configurable retention workflows scoped to client needs.</p>
                <div class="card-tags"><span class="tag-chip">Data Minimization</span><span class="tag-chip">Consent
                        Checkpoints</span><span class="tag-chip">Audit Trails</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-automate"><?= codex_icon('clock', 24) ?></div>
                <h2 class="card-title">Rate Limiting &amp; Abuse Guards</h2>
                <p class="card-description">Request throttling on authentication and form endpoints, honeypot bot
                    filters, and lockout thresholds to deter credential stuffing.</p>
                <div class="card-tags"><span class="tag-chip">Rate Limiters</span><span class="tag-chip">Honeypot
                        Filters</span><span class="tag-chip">Lockout Guards</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-build"><?= codex_icon('database', 24) ?></div>
                <h2 class="card-title">Backups &amp; Recovery Planning</h2>
                <p class="card-description">Versioned SQL migrations, scheduled backup routines, and documented
                    restoration checks matched to project criticality.</p>
                <div class="card-tags"><span class="tag-chip">Scheduled Backups</span><span class="tag-chip">SQL
                        Migrations</span><span class="tag-chip">Recovery Checks</span></div>
            </article>
        </div>
    </div>
</section>

<section class="section"
    style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container container-narrow" style="text-align: center;">
        <h2 style="font-size: 1.7rem; color: var(--white); margin-bottom: 0.85rem;">Responsible Vulnerability Disclosure
        </h2>
        <p style="font-size: 0.96rem; line-height: 1.7; color: var(--slate); margin-bottom: 1.25rem;">
            If you believe you have identified a security issue in a CodeX404 Solutions property, please share
            reproduction details directly with our engineering team so we can investigate promptly.
        </p>
        <a href="mailto:<?= COMPANY_EMAIL ?>"
            style="font-size: 1rem; color: var(--cyan); font-family: var(--font-mono); text-decoration: underline;">
            <?= COMPANY_EMAIL ?>
        </a>
    </div>
</section>

<?php
$ctaHeading = "Need to Review Security & Data Boundaries for Your Project?";
$ctaSubtitle = "We review access requirements, NDA terms, and deployment environments during discovery scoping.";
include __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
