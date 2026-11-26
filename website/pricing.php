<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';

$pageMeta = [
    'title' => 'Project Pricing and Estimates | CodeX404 Solutions',
    'description' => 'Project estimates depend on requirements, integrations, delivery constraints, and support needs. Discuss scope with CodeX404 Solutions.',
    'canonical' => url('pricing.php'),
    'keywords' => 'custom software pricing, booking system cost, dental appointment system pricing, salon booking software, restaurant reservation system, web development rates'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Pricing & Scope'],
];
$heroTag = 'Milestone Estimates & Scoping';
$heroTitleHtml = 'Transparent Scope for <span class="text-gradient gradient-text-animated">Practical Software Systems</span>';
$heroSubtitle = 'Project estimates depend directly on workflow requirements, integrations, and delivery constraints. We agree on clear milestones before build starts—no hidden licensing fees or lock-in.';
$heroActions = [
    ['label' => 'Book a Discovery Call', 'url' => url('discovery-call.php'), 'variant' => 'primary'],
    ['label' => 'Let\'s Discuss Your Project', 'url' => url('contact.php'), 'variant' => 'secondary'],
];
require __DIR__ . '/includes/subpage-hero.php';
?>

<!-- ==========================================================================
     ENGAGEMENT PRINCIPLES
     ========================================================================== -->
<section class="section" style="padding-top: 2rem; padding-bottom: 2rem;">
    <div class="container">
        <div class="pricing-guarantee-strip">
            <div class="guarantee-item">
                <span class="guarantee-icon inline-icon-box"><?= codex_icon('shield', 20) ?></span>
                <div>
                    <h3 class="guarantee-title">Written Milestone Scope</h3>
                    <p class="guarantee-desc">Agreed deliverables and milestone estimates documented before coding begins.</p>
                </div>
            </div>
            <div class="guarantee-item">
                <span class="guarantee-icon inline-icon-box"><?= codex_icon('target', 20) ?></span>
                <div>
                    <h3 class="guarantee-title">Staging Previews</h3>
                    <p class="guarantee-desc">Review working, testable deployments incrementally throughout development.</p>
                </div>
            </div>
            <div class="guarantee-item">
                <span class="guarantee-icon inline-icon-box is-amber"><?= codex_icon('zap', 20) ?></span>
                <div>
                    <h3 class="guarantee-title">Clean Architecture</h3>
                    <p class="guarantee-desc">Lean queries, responsive interfaces, and security checks integrated from day one.</p>
                </div>
            </div>
            <div class="guarantee-item">
                <span class="guarantee-icon inline-icon-box"><?= codex_icon('code', 20) ?></span>
                <div>
                    <h3 class="guarantee-title">Code &amp; Asset Ownership</h3>
                    <p class="guarantee-desc">Repository transfer, database schemas, and ownership terms confirmed in writing.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     PRICING TIERS GRID
     ========================================================================== -->
<section class="section" style="padding-top: 1rem; padding-bottom: 4rem;">
    <div class="container">
        <div class="section-header" style="text-align: center; max-width: 800px; margin: 0 auto 3rem auto;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Select Your Engineering Tier</span>
            </div>
            <h2 class="section-title">
                Engineered for High-Velocity <span class="text-gradient gradient-text-animated">ROI & Performance</span>
            </h2>
            <p class="section-subtitle">
                Whether you need a dedicated turnkey booking engine, a high-converting digital portal, or a full enterprise platform.
            </p>
        </div>

        <div class="pricing-grid-modern">

            <!-- Tier 1: Diagnostic & Architecture -->
            <article class="price-card-modern card-tilt reveal-on-scroll">
                <div class="price-card-top">
                    <span class="price-category-tag">Assessment</span>
                    <h3 class="price-card-title">System Diagnostic</h3>
                    <p class="price-card-desc">Find performance bottlenecks, UX drop-offs, and security gaps before committing to a full rebuild.</p>
                </div>

                <div class="price-amount-box">
                    <span class="price-amount-val price-amount-custom">By project scope</span>
                </div>

                <ul class="price-feature-list">
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Core Web Vitals &amp; performance audit</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Conversion friction &amp; mobile UX breakdown</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Prioritized code &amp; database fix roadmap</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Executive architecture action brief</span>
                    </li>
                </ul>

                <div class="price-card-footer">
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-secondary" style="width: 100%; text-align: center;">
                        <span>Book Diagnostic</span>
                    </a>
                </div>
            </article>

            <!-- Tier 2: Turnkey Booking Systems (FEATURED) -->
            <article class="price-card-modern featured card-tilt reveal-on-scroll reveal-delay-1">
                <span class="price-pill-badge">Popular Scope</span>
                <div class="price-card-top">
                    <span class="price-category-tag">Booking Systems</span>
                    <h3 class="price-card-title">Booking &amp; Reservation Suite</h3>
                    <p class="price-card-desc">Appointment &amp; reservation systems tailored for Clinics, Salons, Spas &amp; Restaurants.</p>
                </div>

                <div class="price-amount-box">
                    <span class="price-amount-val price-amount-custom">By project scope</span>
                    <span class="price-amount-period">/ scoped delivery</span>
                </div>

                <ul class="price-feature-list">
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Clinics:</strong> Practitioner slot allocation &amp; intake queues</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Salons &amp; Spas:</strong> Chair scheduling &amp; service menus</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Packages:</strong> Custom treatments &amp; booking deposits</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Restaurants:</strong> Table reservation flow &amp; pre-orders</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Automated WhatsApp &amp; SMS appointment notifications</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Booking and concurrency controls defined for the agreed scope</span>
                    </li>
                </ul>

                <div class="price-card-footer">
                    <a href="<?= url('contact.php?division=BUILD') ?>" class="btn btn-primary" style="width: 100%; text-align: center;">
                        <span>Discuss a Booking System &rarr;</span>
                    </a>
                </div>
            </article>

            <!-- Tier 3: Conversion Sprint / Custom Portal -->
            <article class="price-card-modern card-tilt reveal-on-scroll reveal-delay-2">
                <div class="price-card-top">
                    <span class="price-category-tag">GROW &amp; UX</span>
                    <h3 class="price-card-title">Conversion &amp; Growth Sprint</h3>
                    <p class="price-card-desc">Rebuild a key customer journey or launch a responsive, search-optimized business website.</p>
                </div>

                <div class="price-amount-box">
                    <span class="price-amount-val price-amount-custom">By project scope</span>
                    <span class="price-amount-period">/ scoped sprint</span>
                </div>

                <ul class="price-feature-list">
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Brand-aligned UI/UX with responsive mobile craft</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Technical SEO, schema markup &amp; Core Web Vitals tuning</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Lead routing, CRM hooks &amp; analytics instrumentation</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>HTTPS deployment &amp; clean handoff documentation</span>
                    </li>
                </ul>

                <div class="price-card-footer">
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-secondary" style="width: 100%; text-align: center;">
                        <span>Plan a Sprint</span>
                    </a>
                </div>
            </article>

            <!-- Tier 4: Custom Platform / SaaS Build -->
            <article class="price-card-modern card-tilt reveal-on-scroll">
                <div class="price-card-top">
                    <span class="price-category-tag">Custom Architecture</span>
                    <h3 class="price-card-title">Custom Platform &amp; SaaS Build</h3>
                    <p class="price-card-desc">Custom application architecture, multi-role access, normalized databases, and AI/automation integrations.</p>
                </div>

                <div class="price-amount-box">
                    <span class="price-amount-val price-amount-custom">By project scope</span>
                    <span class="price-amount-period">/ milestone schedule</span>
                </div>

                <ul class="price-feature-list">
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Clean backend architecture (PHP 8.2+, Python, Node.js)</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Role-based access control (RBAC) &amp; tenant isolation</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Integrated AI pipelines (RAG, WhatsApp webhooks, OCR)</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>CI/CD deployment, staging previews &amp; repository handoff</span>
                    </li>
                </ul>

                <div class="price-card-footer">
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-secondary" style="width: 100%; text-align: center;">
                        <span>Scope Custom Build</span>
                    </a>
                </div>
            </article>

        </div>
    </div>
</section>

<!-- ==========================================================================
     INTERACTIVE PROJECT SCOPE & MILESTONE ESTIMATOR
     ========================================================================== -->
<section class="section" id="estimator" style="background: rgba(11, 31, 58, 0.4); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle); padding: 5rem 0;">
    <div class="container">
        <div class="section-header" style="text-align: center; max-width: 800px; margin: 0 auto 3.5rem auto;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Self-Serve Architecture Planning</span>
            </div>
            <h2 class="section-title">
                Interactive Project <span class="text-gradient gradient-text-animated">Scope &amp; Estimator</span>
            </h2>
            <p class="section-subtitle">
                Select your system requirements, target modules, and delivery cadence for an instant milestone roadmap calculation.
            </p>
        </div>

        <div class="grid grid-cols-2" style="gap: 3rem; align-items: start; max-width: 1100px; margin: 0 auto;">
            <!-- Controls Column -->
            <div class="obsidian-lit-panel is-subtle" style="background: var(--bg-surface); padding: 2.5rem; border-radius: var(--radius-lg); border: 1px solid var(--border-subtle);">
                <form id="scopeEstimatorForm">
                    <!-- Step 1: System Type -->
                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; color: var(--white); font-weight: 700; margin-bottom: 0.75rem; font-size: 1.05rem;">
                            1. Select System Type
                        </label>
                        <select id="estimatorSystemType" class="form-select" style="width: 100%; padding: 0.85rem; background: var(--bg-surface-elevated); color: var(--white); border: 1px solid var(--border-subtle); border-radius: var(--radius-md);">
                            <option value="custom_erp" data-sprints="3" data-name="Custom Web Platform / ERP">Custom Web Platform / Institutional ERP</option>
                            <option value="saas_mvp" data-sprints="4" data-name="Multi-Tenant SaaS MVP">Multi-Tenant SaaS MVP</option>
                            <option value="ai_rag" data-sprints="3" data-name="Enterprise AI RAG Knowledge System">Enterprise AI RAG Knowledge System</option>
                            <option value="booking_engine" data-sprints="2" data-name="Turnkey Booking &amp; Reservation Engine">Turnkey Booking &amp; Reservation Engine</option>
                            <option value="automation_pipeline" data-sprints="2" data-name="WhatsApp &amp; Workflow Automation Pipeline">WhatsApp &amp; Workflow Automation Pipeline</option>
                        </select>
                    </div>

                    <!-- Step 2: Key Modules -->
                    <div style="margin-bottom: 2rem;">
                        <label style="display: block; color: var(--white); font-weight: 700; margin-bottom: 0.75rem; font-size: 1.05rem;">
                            2. Core Functional Modules
                        </label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.85rem;">
                            <label style="display: flex; gap: 0.6rem; align-items: center; font-size: 0.875rem; color: var(--slate); cursor: pointer;">
                                <input type="checkbox" class="estimator-module" value="rbac" data-weight="0.5" checked>
                                <span>Granular RBAC &amp; Auth</span>
                            </label>
                            <label style="display: flex; gap: 0.6rem; align-items: center; font-size: 0.875rem; color: var(--slate); cursor: pointer;">
                                <input type="checkbox" class="estimator-module" value="payment" data-weight="0.5" checked>
                                <span>Stripe / Razorpay Payments</span>
                            </label>
                            <label style="display: flex; gap: 0.6rem; align-items: center; font-size: 0.875rem; color: var(--slate); cursor: pointer;">
                                <input type="checkbox" class="estimator-module" value="whatsapp" data-weight="0.5">
                                <span>WhatsApp Cloud API</span>
                            </label>
                            <label style="display: flex; gap: 0.6rem; align-items: center; font-size: 0.875rem; color: var(--slate); cursor: pointer;">
                                <input type="checkbox" class="estimator-module" value="pdf" data-weight="0.5">
                                <span>Automated PDF Invoices</span>
                            </label>
                            <label style="display: flex; gap: 0.6rem; align-items: center; font-size: 0.875rem; color: var(--slate); cursor: pointer;">
                                <input type="checkbox" class="estimator-module" value="analytics" data-weight="0.5">
                                <span>Admin KPI Dashboard</span>
                            </label>
                            <label style="display: flex; gap: 0.6rem; align-items: center; font-size: 0.875rem; color: var(--slate); cursor: pointer;">
                                <input type="checkbox" class="estimator-module" value="rag" data-weight="1">
                                <span>Private Vector Search (RAG)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Step 3: Delivery Cadence -->
                    <div>
                        <label style="display: block; color: var(--white); font-weight: 700; margin-bottom: 0.75rem; font-size: 1.05rem;">
                            3. Target Delivery Cadence
                        </label>
                        <div style="display: flex; gap: 1rem;">
                            <label style="flex: 1; display: flex; align-items: center; gap: 0.5rem; background: var(--bg-surface-elevated); padding: 0.85rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); cursor: pointer; font-size: 0.875rem; color: var(--slate);">
                                <input type="radio" name="estimatorCadence" value="standard" checked>
                                <span>Standard Agile Sprints</span>
                            </label>
                            <label style="flex: 1; display: flex; align-items: center; gap: 0.5rem; background: var(--bg-surface-elevated); padding: 0.85rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); cursor: pointer; font-size: 0.875rem; color: var(--slate);">
                                <input type="radio" name="estimatorCadence" value="accelerated">
                                <span>Fast-Track Sprint Focus</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Dynamic Output Column -->
            <div class="obsidian-lit-panel is-subtle" style="background: linear-gradient(135deg, rgba(16, 29, 58, 0.95) 0%, rgba(10, 22, 40, 0.98) 100%); padding: 2.75rem; border-radius: var(--radius-lg); border: 1px solid rgba(34, 211, 238, 0.35); box-shadow: 0 0 35px rgba(34, 211, 238, 0.08);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--border-subtle); padding-bottom: 1rem;">
                    <div>
                        <span class="tag-chip" style="color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Estimated Delivery Blueprint</span>
                    </div>
                    <span id="outputSprintBadge" style="font-size: 0.8rem; font-weight: 700; color: #34D399; font-family: var(--font-mono);">
                        2-WEEK SPRINT CADENCE
                    </span>
                </div>

                <h3 id="outputSystemName" style="font-size: 1.45rem; color: var(--white); margin-bottom: 1.25rem;">
                    Custom Web Platform / Institutional ERP
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 2rem;">
                    <div style="background: rgba(7, 17, 31, 0.6); padding: 1.25rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                        <span style="font-size: 0.8rem; color: var(--slate-dark); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.25rem;">Estimated Timeline</span>
                        <strong id="outputTimeline" style="font-size: 1.35rem; color: var(--cyan); font-family: var(--font-mono);">4–6 Weeks</strong>
                    </div>

                    <div style="background: rgba(7, 17, 31, 0.6); padding: 1.25rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                        <span style="font-size: 0.8rem; color: var(--slate-dark); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.25rem;">Live Staging Demos</span>
                        <strong id="outputDemos" style="font-size: 1.35rem; color: #34D399; font-family: var(--font-mono);">2 Working Demos</strong>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <span style="font-size: 0.85rem; color: var(--slate); display: block; margin-bottom: 0.75rem; font-weight: 600;">Included Delivery Practices:</span>
                    <ul class="transform-list" style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.875rem; color: var(--slate);">
                        <li><span style="color: #34D399;">✓</span> Written milestone scope &amp; transparent schedules</li>
                        <li><span style="color: #34D399;">✓</span> Code &amp; repository handoff agreed upfront</li>
                        <li><span style="color: #34D399;">✓</span> 30-day post-launch defect resolution support</li>
                        <li><span style="color: #34D399;">✓</span> Direct communication with engineering leads</li>
                    </ul>
                </div>

                <a id="estimatorCtaLink" href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-lg" style="width: 100%; text-align: center;">
                    <span>Schedule Discovery Call with this Scope &rarr;</span>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const systemSelect = document.getElementById('estimatorSystemType');
    const moduleCheckboxes = document.querySelectorAll('.estimator-module');
    const cadenceRadios = document.querySelectorAll('input[name="estimatorCadence"]');
    
    const outputSystemName = document.getElementById('outputSystemName');
    const outputTimeline = document.getElementById('outputTimeline');
    const outputDemos = document.getElementById('outputDemos');
    const ctaLink = document.getElementById('estimatorCtaLink');

    function calculateEstimate() {
        if (!systemSelect) return;
        const selectedOption = systemSelect.options[systemSelect.selectedIndex];
        const baseSprints = parseFloat(selectedOption.getAttribute('data-sprints') || 3);
        const systemName = selectedOption.getAttribute('data-name');

        let moduleWeight = 0;
        moduleCheckboxes.forEach(cb => {
            if (cb.checked) {
                moduleWeight += parseFloat(cb.getAttribute('data-weight') || 0.5);
            }
        });

        let isAccelerated = false;
        cadenceRadios.forEach(radio => {
            if (radio.checked && radio.value === 'accelerated') isAccelerated = true;
        });

        const totalWeeks = Math.max(3, Math.round(baseSprints * 1.5 + moduleWeight * 1.2));
        const minWeeks = Math.max(3, totalWeeks - 1);
        const maxWeeks = totalWeeks + 2;
        const totalDemos = Math.max(2, Math.floor(totalWeeks / 2));

        if (outputSystemName) outputSystemName.textContent = systemName;
        if (outputTimeline) outputTimeline.textContent = `${minWeeks}–${maxWeeks} Weeks`;
        if (outputDemos) outputDemos.textContent = `${totalDemos} Staging Demos`;

        if (ctaLink) {
            const encodedSystem = encodeURIComponent(systemName);
            ctaLink.href = `<?= url('discovery-call.php') ?>?scope=${encodedSystem}&timeline=${minWeeks}-${maxWeeks}w`;
        }
    }

    if (systemSelect) systemSelect.addEventListener('change', calculateEstimate);
    moduleCheckboxes.forEach(cb => cb.addEventListener('change', calculateEstimate));
    cadenceRadios.forEach(r => r.addEventListener('change', calculateEstimate));
    calculateEstimate();
});
</script>

<!-- ==========================================================================
     DIRECT CALL TO ACTION BANNER
     ========================================================================== -->
<section class="section" style="padding-top: 0; padding-bottom: 4rem;">
    <div class="container">
        <div class="obsidian-lit-panel" style="background: linear-gradient(135deg, rgba(16, 29, 58, 0.9) 0%, rgba(10, 22, 40, 0.95) 100%); border: 1px solid rgba(0, 240, 255, 0.3); border-radius: var(--radius-xl); padding: 3rem 2.5rem; text-align: center; position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 220px; height: 220px; background: radial-gradient(circle, rgba(0, 240, 255, 0.15) 0%, transparent 70%); pointer-events: none;"></div>
            
            <span class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Fast Decision Channel</span>
            </span>

            <h2 style="font-size: clamp(1.8rem, 3.2vw, 2.5rem); font-weight: 800; color: #FFFFFF; margin-bottom: 1rem;">
                Have a Booking System or Custom App in Mind?
            </h2>

            <p style="font-size: 1.1rem; color: var(--slate); max-width: 650px; margin: 0 auto 2rem auto; line-height: 1.6;">
                Share your requirements and constraints. We’ll review the information and follow up to discuss scope, timelines, and an estimate.
            </p>

            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-lg">
                    <span>Book a Discovery Call</span>
                </a>
                <a href="<?= url('contact.php') ?>" class="btn btn-secondary btn-lg">
                    <span>Let&rsquo;s Discuss Your Project &rarr;</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     FREQUENTLY ASKED QUESTIONS
     ========================================================================== -->
<section class="section" style="padding-top: 0; padding-bottom: 5rem;">
    <div class="container" style="max-width: 860px;">
        <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Clarity First</span>
            </div>
            <h2 class="section-title">
                Frequently Asked <span class="text-gradient gradient-text-animated">Questions</span>
            </h2>
        </div>

        <div class="faq-accordion-box" style="display: flex; flex-direction: column; gap: 1.25rem;">
            <details style="background: rgba(10, 22, 40, 0.7); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.5rem 1.75rem;">
                <summary style="font-weight: 700; color: #FFFFFF; cursor: pointer; font-size: 1.1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                    <span>How do your Turnkey Booking Systems work for clinics, salons, and restaurants?</span>
                    <span style="color: var(--cyan); font-size: 1.25rem;">+</span>
                </summary>
                <p style="color: var(--slate); margin-top: 1rem; line-height: 1.7; font-size: 0.95rem;">
                    Each booking system is customized around your actual service constraints: slot duration, staff/chair allocation, treatment packages, deposit payments, and automated WhatsApp/SMS booking confirmations. Clients can book directly from mobile in under 30 seconds with zero double-booking risk.
                </p>
            </details>

            <details style="background: rgba(10, 22, 40, 0.7); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.5rem 1.75rem;">
                <summary style="font-weight: 700; color: #FFFFFF; cursor: pointer; font-size: 1.1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                    <span>Who owns the source code and infrastructure?</span>
                    <span style="color: var(--cyan); font-size: 1.25rem;">+</span>
                </summary>
                <p style="color: var(--slate); margin-top: 1rem; line-height: 1.7; font-size: 0.95rem;">
                    Ownership, licensing, and access to repositories, deployment materials, and data exports are governed by the written agreement for each project.
                </p>
            </details>

            <details style="background: rgba(10, 22, 40, 0.7); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.5rem 1.75rem;">
                <summary style="font-weight: 700; color: #FFFFFF; cursor: pointer; font-size: 1.1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                    <span>How do you handle milestone payments?</span>
                    <span style="color: var(--cyan); font-size: 1.25rem;">+</span>
                </summary>
                <p style="color: var(--slate); margin-top: 1rem; line-height: 1.7; font-size: 0.95rem;">
                    We work on transparent, milestone-based installments (typically 30% upfront deposit to commence architecture, 40% upon staging demo deployment, and 30% upon final acceptance, QA sign-off, and production launch).
                </p>
            </details>

            <details style="background: rgba(10, 22, 40, 0.7); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.5rem 1.75rem;">
                <summary style="font-weight: 700; color: #FFFFFF; cursor: pointer; font-size: 1.1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                    <span>Can you integrate with our existing WhatsApp and SMS providers?</span>
                    <span style="color: var(--cyan); font-size: 1.25rem;">+</span>
                </summary>
                <p style="color: var(--slate); margin-top: 1rem; line-height: 1.7; font-size: 0.95rem;">
                    Yes. We natively integrate with Twilio, WhatsApp Business Cloud API, Gupshup, Fast2SMS, and custom webhooks for instant appointment confirmation, reminder pings, and cancellation rescheduling.
                </p>
            </details>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
