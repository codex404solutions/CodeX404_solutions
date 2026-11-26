<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Services & Engineering Solutions | CodeX404 Solutions',
    'description' => 'Explore CodeX404 Solutions services across BUILD (web development, SaaS, CRM/ERP, APIs), GROW (SEO, digital marketing, optimization), and AUTOMATE (AI automation, RAG, agents).',
    'canonical' => url('solutions.php'),
    'keywords' => 'software development services, SaaS development, CRM ERP systems, SEO digital marketing, AI automation, RAG applications, AI agents'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Services & Solutions'],
];
$heroTag = 'BUILD · GROW · AUTOMATE';
$heroTitleHtml = 'Practical Software, Growth &amp; <span class="text-gradient gradient-text-animated">AI Automation Services</span>';
$heroSubtitle = 'Every service solves a concrete operational problem—helping you ship reliable software, earn qualified search and web demand, and automate repetitive manual processes.';
$heroActions = [
    ['label' => 'Book a Discovery Call', 'url' => url('discovery-call.php'), 'variant' => 'primary'],
    ['label' => 'View Selected Work', 'url' => url('our-work.php'), 'variant' => 'secondary'],
];
require __DIR__ . '/includes/subpage-hero.php';
?>

<!-- SERVICES BY PILLAR -->
<section class="section">
    <div class="container">
        <!-- Capability Filter Bar -->
        <div style="display: flex; justify-content: center; gap: 0.75rem; margin-bottom: 3rem; flex-wrap: wrap;"
            role="tablist" aria-label="Filter services by pillar">
            <button type="button" class="btn btn-secondary btn-sm filter-btn active" data-filter="all">All
                Services</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="software">BUILD: Software
                &amp; Systems</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="saas">BUILD: SaaS &amp;
                Mobile</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="growth">GROW: Marketing &amp;
                SEO</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="ai">AUTOMATE: AI &amp;
                Agents</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="automation">AUTOMATE:
                Workflows</button>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <!-- 1. BUILD: Custom Software, Web & CRM/ERP -->
            <article id="build" class="card card-tilt reveal-on-scroll" data-category="software"
                style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div
                        style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <div class="card-icon is-build" style="margin-bottom: 0;"><?= codex_icon('code', 24) ?></div>
                        <span class="tag-chip"
                            style="color: #60A5FA; border-color: rgba(11, 94, 215, 0.4);">BUILD</span>
                    </div>
                    <h2 class="card-title" style="font-size: 1.3rem; margin-bottom: 0.7rem;">Custom Software, Portals
                        &amp; CRM/ERP</h2>
                    <p class="card-description" style="font-size: 0.92rem; line-height: 1.65; margin-bottom: 1.2rem;">
                        <strong>Problem solved:</strong> Disconnected spreadsheets and rigid seat-licensed tools slow
                        operations. We engineer tailored web portals, custom CRMs, internal ERPs, and REST APIs aligned
                        with your exact workflows and role permissions.
                    </p>
                    <div class="card-tags" style="margin-bottom: 1.4rem;">
                        <span class="tag-chip">PHP 8.2+ / Python</span>
                        <span class="tag-chip">MySQL &amp; PostgreSQL</span>
                        <span class="tag-chip">Role-Based Access</span>
                        <span class="tag-chip">API Integrations</span>
                    </div>
                </div>
                <div
                    style="padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                    <a href="<?= url('software-development.php') ?>" class="card-arrow-link"
                        style="font-weight: 600; color: var(--cyan);">Explore Software &rarr;</a>
                    <span style="font-size: 0.78rem; color: var(--slate-dark);">Full source handoff</span>
                </div>
            </article>

            <!-- 2. BUILD: SaaS Product Engineering -->
            <article class="card card-tilt reveal-on-scroll reveal-delay-1" data-category="saas"
                style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div
                        style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <div class="card-icon is-build" style="margin-bottom: 0;"><?= codex_icon('layers', 24) ?></div>
                        <span class="tag-chip"
                            style="color: #60A5FA; border-color: rgba(11, 94, 215, 0.4);">BUILD</span>
                    </div>
                    <h2 class="card-title" style="font-size: 1.3rem; margin-bottom: 0.7rem;">SaaS Product &amp; MVP
                        Development</h2>
                    <p class="card-description" style="font-size: 0.92rem; line-height: 1.65; margin-bottom: 1.2rem;">
                        <strong>Problem solved:</strong> Product ideas stall when over-scoped or built on brittle
                        prototypes. We architect focused MVPs and multi-tenant SaaS systems with tenant isolation,
                        billing integration, and modular code ready to iterate.
                    </p>
                    <div class="card-tags" style="margin-bottom: 1.4rem;">
                        <span class="tag-chip">React / Next.js</span>
                        <span class="tag-chip">Tenant Isolation</span>
                        <span class="tag-chip">Stripe / Razorpay</span>
                        <span class="tag-chip">Admin Controls</span>
                    </div>
                </div>
                <div
                    style="padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                    <a href="<?= url('saas.php') ?>" class="card-arrow-link"
                        style="font-weight: 600; color: var(--cyan);">Explore SaaS &amp; Products &rarr;</a>
                    <span style="font-size: 0.78rem; color: var(--slate-dark);">Milestone-scoped MVP</span>
                </div>
            </article>

            <!-- 3. BUILD: Mobile Apps & PWAs -->
            <article class="card card-tilt reveal-on-scroll reveal-delay-2" data-category="saas"
                style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div
                        style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <div class="card-icon is-build" style="margin-bottom: 0;"><?= codex_icon('smartphone', 24) ?>
                        </div>
                        <span class="tag-chip"
                            style="color: #60A5FA; border-color: rgba(11, 94, 215, 0.4);">BUILD</span>
                    </div>
                    <h2 class="card-title" style="font-size: 1.3rem; margin-bottom: 0.7rem;">Mobile Apps &amp;
                        Offline-First PWAs</h2>
                    <p class="card-description" style="font-size: 0.92rem; line-height: 1.65; margin-bottom: 1.2rem;">
                        <strong>Problem solved:</strong> Field staff and on-the-go customers lose productivity on
                        unreliable networks. We build cross-platform apps and progressive web tools with offline queues,
                        notifications, and reliable server sync.
                    </p>
                    <div class="card-tags" style="margin-bottom: 1.4rem;">
                        <span class="tag-chip">iOS &amp; Android</span>
                        <span class="tag-chip">Offline Local Sync</span>
                        <span class="tag-chip">Push Alerts</span>
                        <span class="tag-chip">Secure Auth</span>
                    </div>
                </div>
                <div
                    style="padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                    <a href="<?= url('mobile-apps.php') ?>" class="card-arrow-link"
                        style="font-weight: 600; color: var(--cyan);">Explore Mobile Apps &rarr;</a>
                    <span style="font-size: 0.78rem; color: var(--slate-dark);">Field &amp; customer ready</span>
                </div>
            </article>

            <!-- 4. GROW: Digital Marketing, SEO & Website Optimization -->
            <article id="grow" class="card card-tilt reveal-on-scroll" data-category="growth"
                style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div
                        style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <div class="card-icon is-grow" style="margin-bottom: 0;"><?= codex_icon('search', 24) ?></div>
                        <span class="tag-chip"
                            style="color: #34D399; border-color: rgba(16, 185, 129, 0.4);">GROW</span>
                    </div>
                    <h2 class="card-title" style="font-size: 1.3rem; margin-bottom: 0.7rem;">SEO, AEO &amp; Digital
                        Growth Solutions</h2>
                    <p class="card-description" style="font-size: 0.92rem; line-height: 1.65; margin-bottom: 1.2rem;">
                        <strong>Problem solved:</strong> Strong products still lose pipeline when search engines, AI
                        answer engines, and visitors cannot understand your offer quickly. We improve technical SEO,
                        Core Web Vitals, landing page conversion paths, and campaign tracking.
                    </p>
                    <div class="card-tags" style="margin-bottom: 1.4rem;">
                        <span class="tag-chip">Technical SEO &amp; Schema</span>
                        <span class="tag-chip">AEO / AI Search</span>
                        <span class="tag-chip">Conversion UX</span>
                        <span class="tag-chip">Marketing Analytics</span>
                    </div>
                </div>
                <div
                    style="padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                    <a href="<?= url('grow.php') ?>" class="card-arrow-link"
                        style="font-weight: 600; color: var(--teal);">Explore GROW Division &rarr;</a>
                    <span style="font-size: 0.78rem; color: var(--slate-dark);">Qualified demand focus</span>
                </div>
            </article>

            <!-- 5. AUTOMATE: Applied AI & Private RAG -->
            <article id="automate" class="card card-tilt reveal-on-scroll reveal-delay-1" data-category="ai"
                style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div
                        style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <div class="card-icon is-automate" style="margin-bottom: 0;"><?= codex_icon('cpu', 24) ?></div>
                        <span class="tag-chip"
                            style="color: #FF8C00; border-color: rgba(255, 140, 0, 0.4);">AUTOMATE</span>
                    </div>
                    <h2 class="card-title" style="font-size: 1.3rem; margin-bottom: 0.7rem;">Generative AI &amp; Private
                        RAG Systems</h2>
                    <p class="card-description" style="font-size: 0.92rem; line-height: 1.65; margin-bottom: 1.2rem;">
                        <strong>Problem solved:</strong> Teams waste hours hunting across PDFs, policies, and SOPs—or
                        risk unreliable answers from generic chatbots. We build grounded RAG search and document
                        extraction pipelines tied to approved sources.
                    </p>
                    <div class="card-tags" style="margin-bottom: 1.4rem;">
                        <span class="tag-chip">RAG Retrieval</span>
                        <span class="tag-chip">OCR &amp; Parsing</span>
                        <span class="tag-chip">Source Citations</span>
                        <span class="tag-chip">Access Controls</span>
                    </div>
                </div>
                <div
                    style="padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                    <a href="<?= url('ai-solutions.php') ?>" class="card-arrow-link"
                        style="font-weight: 600; color: var(--amber);">Explore AI Systems &rarr;</a>
                    <span style="font-size: 0.78rem; color: var(--slate-dark);">Grounded &amp; scoped</span>
                </div>
            </article>

            <!-- 6. AUTOMATE: AI Agents & Business Workflow Automation -->
            <article class="card card-tilt reveal-on-scroll reveal-delay-2" data-category="ai automation"
                style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div
                        style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                        <div class="card-icon is-automate" style="margin-bottom: 0;"><?= codex_icon('workflow', 24) ?>
                        </div>
                        <span class="tag-chip"
                            style="color: #FF8C00; border-color: rgba(255, 140, 0, 0.4);">AUTOMATE</span>
                    </div>
                    <h2 class="card-title" style="font-size: 1.3rem; margin-bottom: 0.7rem;">AI Agents &amp; Workflow
                        Automation</h2>
                    <p class="card-description" style="font-size: 0.92rem; line-height: 1.65; margin-bottom: 1.2rem;">
                        <strong>Problem solved:</strong> Repetitive lead routing, WhatsApp updates, invoice generation,
                        and cross-tool data entry drain staff time. We wire deterministic automations and guarded AI
                        agents with audit logs and approval gates.
                    </p>
                    <div class="card-tags" style="margin-bottom: 1.4rem;">
                        <span class="tag-chip">AI Tool Calling</span>
                        <span class="tag-chip">WhatsApp Cloud API</span>
                        <span class="tag-chip">Webhooks &amp; Queues</span>
                        <span class="tag-chip">Approval Gates</span>
                    </div>
                </div>
                <div
                    style="padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                    <a href="<?= url('automation.php') ?>" class="card-arrow-link"
                        style="font-weight: 600; color: var(--amber);">Explore Automation &rarr;</a>
                    <a href="<?= url('ai-agents.php') ?>"
                        style="font-size: 0.78rem; color: var(--cyan); font-weight: 600;">AI Agents &rarr;</a>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- COMPARISON SECTION: OFF-THE-SHELF VS BESPOKE ARCHITECTURE -->
<section class="section"
    style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 780px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;">
                <span class="dot"></span>
                <span>Practical Comparison</span>
            </div>
            <h2 class="section-title">When Custom Software Outperforms Off-the-Shelf Tools</h2>
            <p class="section-subtitle">
                Generic subscriptions work well for standard tasks—until workflow workarounds and recurring seat costs
                hold your team back.
            </p>
        </div>

        <div class="grid grid-cols-2" style="gap: 2rem;">
            <div class="card" style="border-color: rgba(239, 68, 68, 0.3); background: rgba(239, 68, 68, 0.03);">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                    <span class="inline-icon-box"
                        style="background: rgba(239, 68, 68, 0.12); border-color: rgba(239, 68, 68, 0.32); color: #F87171;"><?= codex_icon('lock', 20) ?></span>
                    <h3 style="color: #F87171; font-size: 1.28rem; margin: 0;">Rigid Off-The-Shelf Tools</h3>
                </div>
                <ul
                    style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.9rem; font-size: 0.92rem; color: var(--slate);">
                    <li><strong style="color: var(--white);">Per-Seat Scaling Friction:</strong> Licensing fees rise
                        whenever additional staff, partners, or portals are onboarded.</li>
                    <li><strong style="color: var(--white);">Forced Workarounds:</strong> Teams revert to spreadsheets
                        to cover approval steps or rules generic SaaS omits.</li>
                    <li><strong style="color: var(--white);">Fragmented Data:</strong> Critical customer, billing, and
                        operational history stays locked across disconnected vendors.</li>
                </ul>
            </div>

            <div class="card" style="border-color: rgba(34, 211, 238, 0.38); background: rgba(34, 211, 238, 0.04);">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.25rem;">
                    <span class="inline-icon-box"><?= codex_icon('check', 20) ?></span>
                    <h3 style="color: var(--cyan); font-size: 1.28rem; margin: 0;">CodeX404 Tailored Architecture</h3>
                </div>
                <ul
                    style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.9rem; font-size: 0.92rem; color: var(--slate);">
                    <li><strong style="color: var(--white);">Role-Based Access Without Seat Penalties:</strong> Support
                        staff and external portals under your own infrastructure.</li>
                    <li><strong style="color: var(--white);">Built Around Your Process:</strong> User permissions,
                        pricing rules, and approvals mirror how your business operates.</li>
                    <li><strong style="color: var(--white);">Clear Ownership &amp; Portability:</strong> Source code,
                        schemas, and hosting handoff agreed transparently in writing.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ARCHITECTURE STANDARDS -->
<section class="section">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;">
                <span class="dot"></span>
                <span>Engineering Standards</span>
            </div>
            <h2 class="section-title">How Every CodeX404 System Is Built</h2>
            <p class="section-subtitle">Reliable engineering favors clarity, defensive data handling, and maintainable
                architecture over unnecessary complexity.</p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card" style="padding: 1.75rem;">
                <div style="font-size: 1.5rem; color: var(--cyan); font-weight: 800; margin-bottom: 0.65rem;">01</div>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.5rem;">Defensive Security</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Parameterized SQL queries, strict
                    input validation, CSRF tokens, and OWASP security practices across endpoints.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <div style="font-size: 1.5rem; color: var(--cyan); font-weight: 800; margin-bottom: 0.65rem;">02</div>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.5rem;">Modular Structure</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Clean separation of business
                    logic, validation, and data persistence so new features stay straightforward to ship.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <div style="font-size: 1.5rem; color: var(--cyan); font-weight: 800; margin-bottom: 0.65rem;">03</div>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.5rem;">Practical Performance</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Indexed database queries, lean
                    frontend assets, and responsive interfaces built for mobile and desktop users alike.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <div style="font-size: 1.5rem; color: var(--cyan); font-weight: 800; margin-bottom: 0.65rem;">04</div>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.5rem;">Clean Handoff</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Documentation, migration files,
                    and repository access structured so your team never hits a black box.</p>
            </div>
        </div>
    </div>
</section>

<!-- LIVE DEMO SANDBOX CALLOUT -->
<section class="section"
    style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle); padding: 3rem 0;">
    <div class="container" style="text-align: center;">
        <div style="max-width: 680px; margin: 0 auto;">
            <span class="tag-chip"
                style="margin-bottom: 1rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Interactive
                Preview</span>
            <h3 style="font-size: 1.75rem; color: var(--white); margin-bottom: 0.85rem;">Explore Live Systems &amp;
                Interactive Demos</h3>
            <p style="font-size: 0.98rem; color: var(--slate); line-height: 1.65; margin-bottom: 1.75rem;">
                Inspect shipped client systems alongside interactive sandboxes showcasing our ERP workflows, AI RAG
                retrieval, and automation patterns.
            </p>
            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <a href="<?= url('our-work.php') ?>" class="btn btn-primary">Explore Our Work &rarr;</a>
                <a href="<?= url('portfolio.php') ?>" class="btn btn-secondary">Interactive Deliverables</a>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Have a System or Workflow Ready to Improve?";
$ctaSubtitle = "Book a discovery call to discuss your business problem, priorities, and practical architecture options.";
$ctaSecondaryText = "Let's Discuss Your Project";
$ctaSecondaryUrl = url('contact.php');
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>