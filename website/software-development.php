<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Custom Software Development & Web Platforms | CodeX404 Solutions',
    'description' => 'Plan and build bespoke web applications, internal tools, customer portals, CRM/ERP systems, and APIs around your business requirements.',
    'canonical' => url('software-development.php'),
    'keywords' => 'custom software development, web applications, internal ERP, custom CRM systems, partner portals, PHP, Python FastAPI'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Services', 'url' => url('solutions.php')],
    ['label' => 'Custom Software'],
];
$heroTag = 'BUILD · Custom Software & Portals';
$heroTitleHtml = 'Custom Software Built Around Your <span class="text-amber">Operational Workflow</span>';
$heroSubtitle = 'Off-the-shelf software forces your business into rigid templates while charging per-seat fees. We design and engineer web platforms, internal ERPs, CRMs, and customer portals tailored to how your team operates.';
$heroActions = [
    ['label' => 'Book a Discovery Call', 'url' => url('discovery-call.php') . '?division=BUILD', 'variant' => 'primary'],
    ['label' => 'View Case Studies', 'url' => url('case-studies.php'), 'variant' => 'secondary'],
];
require __DIR__ . '/includes/subpage-hero.php';
?>

<!-- PROBLEM / SOLUTION & CAPABILITIES -->
<section class="section">
    <div class="container">
        <div class="grid grid-cols-2" style="gap: 2rem; margin-bottom: 3.5rem;">
            <article class="card card-tilt reveal-on-scroll"
                style="border-left: 4px solid #F87171; background: rgba(239, 68, 68, 0.03);">
                <span
                    style="font-size: 0.82rem; font-weight: 700; color: #F87171; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.65rem;">The
                    Operational Bottleneck</span>
                <h2 style="font-size: 1.25rem; color: var(--white); margin-bottom: 0.75rem;">The Fragile Spreadsheet
                    Trap</h2>
                <p style="font-size: 0.94rem; line-height: 1.65; color: var(--slate); margin: 0;">
                    Growing businesses frequently rely on multi-tab spreadsheets to track orders, inventory, staff
                    assignments, and billing. As volume increases, files conflict, formulas break, access control
                    disappears, and teams spend hours manually reconciling duplicate rows.
                </p>
            </article>
            <article class="card card-tilt reveal-on-scroll reveal-delay-1"
                style="border-left: 4px solid var(--cyan); background: rgba(34, 211, 238, 0.03);">
                <span
                    style="font-size: 0.82rem; font-weight: 700; color: var(--cyan); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.65rem;">The
                    CodeX404 Solution</span>
                <h2 style="font-size: 1.25rem; color: var(--white); margin-bottom: 0.75rem;">Centralized Web Control
                    Plane</h2>
                <p style="font-size: 0.94rem; line-height: 1.65; color: var(--slate); margin: 0;">
                    We migrate fragmented spreadsheets into a normalized relational database (MySQL or PostgreSQL)
                    paired with a role-based web interface. Inputs are validated on entry, invoices generate
                    consistently, and teams work concurrently without collisions.
                </p>
            </article>
        </div>

        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-build"><?= codex_icon('code', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Full-Stack Web Applications</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Responsive web platforms with clean architectural boundaries, indexed relational schemas, and
                    lightweight frontend assets tuned for daily team usage.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">PHP 8.2+</span>
                    <span class="tag-chip">Python FastAPI</span>
                    <span class="tag-chip">Modular JS</span>
                    <span class="tag-chip">REST APIs</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-build"><?= codex_icon('shield', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Client &amp; Partner Portals</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Give clients and vendors branded self-service access to invoices, project milestones, shared
                    documents, and order tracking with granular role permissions.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Role-Based Access (RBAC)</span>
                    <span class="tag-chip">Document Vault</span>
                    <span class="tag-chip">Audit Trails</span>
                    <span class="tag-chip">Branded UX</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-build"><?= codex_icon('chart', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Custom CRM Systems</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Tailored relationship platforms without per-seat pricing traps—featuring custom pipeline stages,
                    inquiry routing, activity logs, and lead attribution.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">No Per-Seat Fees</span>
                    <span class="tag-chip">Custom Pipelines</span>
                    <span class="tag-chip">Lead Attribution</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-build"><?= codex_icon('building', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Internal ERP &amp; Operations Engines</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Consolidate procurement, fee reconciliation, dispatch scheduling, staff rosters, and financial
                    records inside one unified operational dashboard.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Inventory &amp; Stock</span>
                    <span class="tag-chip">Automated Billing</span>
                    <span class="tag-chip">Staff Permissions</span>
                    <span class="tag-chip">PDF Reports</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-build"><?= codex_icon('cart', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">B2B Wholesale Commerce</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Account-based ordering portals with negotiated volume pricing tiers, credit rules, purchase order
                    reconciliation, and database-locked stock reservations.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Volume Pricing</span>
                    <span class="tag-chip">Atomic Stock Locks</span>
                    <span class="tag-chip">Stripe / Razorpay</span>
                    <span class="tag-chip">GST Invoicing</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-build"><?= codex_icon('link', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">APIs &amp; System Integrations</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Reliable RESTful APIs and webhook services with clear request contracts, HMAC verification, rate
                    limiting, and background processing queues.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">OpenAPI Contracts</span>
                    <span class="tag-chip">Redis Queues</span>
                    <span class="tag-chip">HMAC Webhooks</span>
                    <span class="tag-chip">Rate Limiting</span>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- TECHNOLOGY STACK MATRIX -->
<section class="section"
    style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;"><span class="dot"></span><span>Technology
                    Stack</span></div>
            <h2 class="section-title subpage-section-title">Pragmatic Stacks Chosen for <span
                    class="text-amber">Maintainability</span></h2>
            <p class="section-subtitle">Proven technologies that keep infrastructure lean, security auditable, and
                long-term maintenance straightforward.</p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.65rem; font-size: 1.15rem;">Backend Systems</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6; margin-bottom: 1rem;">Strictly
                    typed PHP 8.2+, Python FastAPI, and Node.js services with clean separation of validation and domain
                    logic.</p>
                <div class="card-tags"><span class="tag-chip">PHP 8.2+</span><span class="tag-chip">FastAPI</span><span
                        class="tag-chip">Node.js</span></div>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.65rem; font-size: 1.15rem;">Database &amp; State</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6; margin-bottom: 1rem;">MySQL 8,
                    PostgreSQL, Redis, and Qdrant with prepared queries, migrations, and transactional integrity.</p>
                <div class="card-tags"><span class="tag-chip">MySQL 8</span><span
                        class="tag-chip">PostgreSQL</span><span class="tag-chip">Redis</span></div>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.65rem; font-size: 1.15rem;">Frontend UX</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6; margin-bottom: 1rem;">Semantic
                    HTML5, responsive CSS, React / Next.js / TypeScript, and accessible form-driven operational views.
                </p>
                <div class="card-tags"><span class="tag-chip">React / Next.js</span><span
                        class="tag-chip">TypeScript</span><span class="tag-chip">Responsive CSS</span></div>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.65rem; font-size: 1.15rem;">Security &amp; CI/CD</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6; margin-bottom: 1rem;">Docker
                    containers, GitHub Actions automation, TLS encryption, CSRF protection, and OWASP security
                    practices.</p>
                <div class="card-tags"><span class="tag-chip">Docker</span><span class="tag-chip">GitHub
                        Actions</span><span class="tag-chip">OWASP</span></div>
            </div>
        </div>
    </div>
</section>

<!-- LIVE WORK & INTERACTIVE SIMULATOR CALLOUT -->
<section class="section">
    <div class="container">
        <div class="obsidian-lit-panel"
            style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 2.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
            <div style="max-width: 600px;">
                <span class="tag-chip"
                    style="margin-bottom: 0.75rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Delivered
                    Systems</span>
                <h3 style="font-size: 1.65rem; color: var(--white); margin-bottom: 0.65rem;">See Deployed Platforms
                    &amp; Interactive Demos</h3>
                <p style="font-size: 0.95rem; line-height: 1.6; color: var(--slate); margin: 0;">Explore shipped web
                    platforms and launch our in-browser ERP, B2B ordering, and AI RAG sandboxes.</p>
            </div>
            <div style="display: flex; gap: 0.85rem; flex-wrap: wrap;">
                <a href="<?= url('portfolio.php') ?>" class="btn btn-primary">Explore Portfolio &rarr;</a>
                <a href="<?= url('our-work.php') ?>" class="btn btn-secondary">Selected Work</a>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Replace Manual Workarounds With Custom Software?";
$ctaSubtitle = "Let's review your operational workflow, technical constraints, and practical milestone scope together.";
include __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
