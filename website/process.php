<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Our 7-Stage Project Delivery Process | CodeX404 Solutions',
    'description' => 'See the structured 7-stage process CodeX404 Solutions uses for discovery, architecture planning, UI design, iterative sprint demos, testing, launch, and handoff.',
    'canonical' => url('process.php'),
    'keywords' => 'software development process, agile engineering, software delivery lifecycle, QA testing process'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'About', 'url' => url('about.php')],
    ['label' => 'Delivery Process'],
];
$heroTag = 'Engineering Discipline';
$heroTitleHtml = 'The <span class="text-gradient">7-Stage Delivery</span> Framework';
$heroSubtitle = 'Disciplined, transparent software delivery from initial problem framing through production deployment—verified at every stage on reviewable staging builds.';
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; max-width: 980px; margin: 0 auto 3.5rem auto;">
            <div class="card" style="padding: 1.2rem 1.4rem; display: flex; align-items: center; gap: 0.85rem;">
                <span class="inline-icon-box"><?= codex_icon('clock', 20) ?></span>
                <div>
                    <strong style="color: var(--white); font-size: 0.9rem; display: block;">Iterative Sprints</strong>
                    <span style="font-size: 0.8rem; color: var(--slate);">Regular staging previews</span>
                </div>
            </div>
            <div class="card" style="padding: 1.2rem 1.4rem; display: flex; align-items: center; gap: 0.85rem;">
                <span class="inline-icon-box"><?= codex_icon('shield', 20) ?></span>
                <div>
                    <strong style="color: var(--white); font-size: 0.9rem; display: block;">OWASP Practices</strong>
                    <span style="font-size: 0.8rem; color: var(--slate);">Defensive input &amp; auth controls</span>
                </div>
            </div>
            <div class="card" style="padding: 1.2rem 1.4rem; display: flex; align-items: center; gap: 0.85rem;">
                <span class="inline-icon-box"><?= codex_icon('lock', 20) ?></span>
                <div>
                    <strong style="color: var(--white); font-size: 0.9rem; display: block;">Privacy-Mindful Data</strong>
                    <span style="font-size: 0.8rem; color: var(--slate);">Scoped storage &amp; audit logs</span>
                </div>
            </div>
            <div class="card" style="padding: 1.2rem 1.4rem; display: flex; align-items: center; gap: 0.85rem;">
                <span class="inline-icon-box is-amber"><?= codex_icon('rocket', 20) ?></span>
                <div>
                    <strong style="color: var(--white); font-size: 0.9rem; display: block;">Clean Releases</strong>
                    <span style="font-size: 0.8rem; color: var(--slate);">Versioned Git &amp; SQL migrations</span>
                </div>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 2rem; max-width: 980px; margin: 0 auto;">
            <?php
            $stages = [
                ['01', 'Discover &amp; Unpack Friction', 'We audit your current workflows, user roles, existing spreadsheets or tools, and business constraints to define explicit boundaries before coding begins.', 'Written scope brief, risk notes, and agreed milestone schedule.'],
                ['02', 'Strategize &amp; Architect', 'We design normalized MySQL or PostgreSQL schemas, API contracts, permission rules, and hosting layout around long-term maintainability.', 'Database schema plan, API endpoints, and infrastructure blueprint.'],
                ['03', 'UI/UX &amp; Interactive Structure', 'We shape clear, accessible, mobile-responsive interfaces aligned with your brand and validated directly with stakeholders.', 'Screen layouts, responsive rules, and user flow walkthroughs.'],
                ['04', 'Iterative Sprints &amp; Staging Demos', 'Working functionality is built in focused milestones and deployed to private staging environments so you test real features continuously.', 'Testable staging builds, sprint updates, and review feedback loops.'],
                ['05', 'Testing &amp; Hardening', 'We verify responsive layouts, form validation, CSRF and SQL-injection defenses, error handling, and page performance prior to sign-off.', 'Cross-viewport QA checks, security checklist, and defect resolution.'],
                ['06', 'Production Launch &amp; Verification', 'We coordinate DNS, TLS certificates, environment secrets, backups, and smoke verification on live infrastructure.', 'Verified production release, active HTTPS, and backup configuration.'],
                ['07', 'Handoff, Support &amp; Growth', 'We deliver agreed source repositories, setup documentation, post-launch defect support, and optional ongoing optimization across GROW or AUTOMATE.', 'Clean repository transfer, admin docs, and 30-day post-launch support.'],
            ];
            foreach ($stages as $st): ?>
                <article class="card" style="padding: 2.15rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.85rem;">
                        <div class="step-num" style="margin: 0;"><?= $st[0] ?></div>
                        <h2 style="font-size: 1.42rem; color: var(--white); margin: 0;"><?= $st[1] ?></h2>
                    </div>
                    <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 0.9rem; color: var(--slate);"><?= $st[2] ?></p>
                    <div style="font-size: 0.85rem; color: var(--cyan);">
                        <strong>Stage Deliverables:</strong> <?= htmlspecialchars($st[3], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Walk Through Your Project Roadmap?";
$ctaSubtitle = "Start with a Discovery Call to review your goals, technical constraints, and practical milestone steps.";
include __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
