<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Industries Served — Domain Software & Automation | CodeX404 Solutions',
    'description' => 'Explore how CodeX404 Solutions builds custom software, booking platforms, portals, and workflow automations for Education, B2B Commerce, Legal, Logistics, Real Estate, and Healthcare.',
    'canonical' => url('industries.php'),
    'keywords' => 'industries software, logistics automation, education ERP, professional services software, B2B commerce, clinic booking systems'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'About', 'url' => url('about.php')],
    ['label' => 'Industries'],
];
$heroTag = 'Sector Solutions';
$heroTitleHtml = 'Engineered for Your Industry&rsquo;s <span class="text-gradient">Operational Realities</span>';
$heroSubtitle = 'While business rules vary by sector, operational bottlenecks share common roots: disconnected spreadsheets, double-booked schedules, and manual follow-ups. We adapt architecture directly to your domain.';
$heroActions = [
    ['label' => 'Discuss Your Industry Workflow', 'url' => url('discovery-call.php'), 'variant' => 'primary'],
    ['label' => 'Explore Selected Work', 'url' => url('our-work.php'), 'variant' => 'secondary'],
];
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll" id="industry-education">
                <div class="card-icon is-build"><?= codex_icon('book', 24) ?></div>
                <h2 class="card-title">Education &amp; Institutions</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Replace manual fee registers and scattered spreadsheets with role-based school ERPs, student portals, attendance tracking, and fee reconciliation workflows.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">School ERPs</span>
                    <span class="tag-chip">Fee Reconciliation</span>
                    <span class="tag-chip">Role Permissions</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1" id="industry-commerce">
                <div class="card-icon is-build"><?= codex_icon('cart', 24) ?></div>
                <h2 class="card-title">B2B Commerce &amp; Retail</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Synchronize multi-warehouse inventory with transactional stock locks, support volume pricing tiers, and automate clean invoice generation.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Volume Pricing</span>
                    <span class="tag-chip">Stock Integrity</span>
                    <span class="tag-chip">Payment Gateways</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2" id="industry-legal">
                <div class="card-icon is-automate"><?= codex_icon('file', 24) ?></div>
                <h2 class="card-title">Legal &amp; Advisory Firms</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Build confidential client document portals, intake screening forms, and cited internal knowledge retrieval tailored to strict data boundaries.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Document Search</span>
                    <span class="tag-chip">Client Portals</span>
                    <span class="tag-chip">Audit Trails</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll" id="industry-logistics">
                <div class="card-icon is-build"><?= codex_icon('truck', 24) ?></div>
                <h2 class="card-title">Logistics &amp; Field Dispatch</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Equip drivers and dispatch coordinators with offline-capable mobile checklists, barcode scans, status webhooks, and digital delivery proofs.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Offline Sync</span>
                    <span class="tag-chip">Dispatch Queues</span>
                    <span class="tag-chip">Proof of Delivery</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1" id="industry-realestate">
                <div class="card-icon is-grow"><?= codex_icon('building', 24) ?></div>
                <h2 class="card-title">Real Estate &amp; Property Ops</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Coordinate tenant onboarding, maintenance ticket routing, rent reminders, and multi-channel inquiry capture across web and messaging.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Tenant Portals</span>
                    <span class="tag-chip">Ticket Routing</span>
                    <span class="tag-chip">Lead Follow-Up</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2" id="industry-healthcare">
                <div class="card-icon is-build"><?= codex_icon('heart', 24) ?></div>
                <h2 class="card-title">Clinics &amp; Service Booking</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Run conflict-free appointment scheduling with patient/client intake, automated WhatsApp reminders, and structured privacy access controls.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Slot Locking</span>
                    <span class="tag-chip">Appointment Alerts</span>
                    <span class="tag-chip">Privacy Scoped</span>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container" style="text-align: center;">
        <div style="max-width: 680px; margin: 0 auto;">
            <span class="tag-chip" style="margin-bottom: 1rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">In-Browser Preview</span>
            <h3 style="font-size: 1.75rem; color: var(--white); margin-bottom: 0.85rem;">Test Domain Workflows in Interactive Sandboxes</h3>
            <p style="font-size: 0.98rem; color: var(--slate); line-height: 1.65; margin-bottom: 1.75rem;">
                Inspect working demonstrations across institutional ERPs, clinic scheduling, and webhook lead pipelines directly in your browser.
            </p>
            <a href="<?= url('portfolio.php') ?>" class="btn btn-primary">Explore Interactive Portfolio &rarr;</a>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Have a Sector-Specific Operational Bottleneck?";
$ctaSubtitle = "Share your workflow constraints, compliance rules, and target users during a practical discovery call.";
include __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
