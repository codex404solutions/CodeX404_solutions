<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'SaaS Product Engineering & Rapid MVP Development',
    'description' => 'Turn your software vision into a scalable, revenue-generating SaaS application. Multi-tenant architecture, subscription billing, and rapid MVP delivery.',
    'canonical' => url('saas.php'),
    'keywords' => 'SaaS development, MVP development, multi-tenant architecture, subscription billing, B2B SaaS'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Venture & Product Engineering</span>
            </div>
            <h1 class="section-title">From Concept to Recurring Revenue SaaS</h1>
            <p class="section-subtitle">
                We partner with founders and forward-thinking enterprises to build resilient, multi-tenant Software-as-a-Service products built for rapid market validation and effortless horizontal scaling.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- 1. Rapid MVP -->
            <div class="card">
                <div class="card-icon">⚡</div>
                <h2 class="card-title">Rapid MVP Development</h2>
                <p class="card-description">
                    Launch a production-grade Minimum Viable Product in weeks, not months. Focus on core high-value features that solve customer pain points without bloat.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">4-8 Week Delivery</span>
                    <span class="tag-chip">Validated Core</span>
                    <span class="tag-chip">Investor Ready</span>
                </div>
            </div>

            <!-- 2. Multi-Tenant Architecture -->
            <div class="card">
                <div class="card-icon">🏢</div>
                <h2 class="card-title">Multi-Tenant Isolation</h2>
                <p class="card-description">
                    Architected with tenant isolation models (shared schema with tenant IDs or schema-per-tenant) ensuring customer data security and seamless horizontal scaling.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Data Isolation</span>
                    <span class="tag-chip">Custom Subdomains</span>
                    <span class="tag-chip">Zero Cross-Bleed</span>
                </div>
            </div>

            <!-- 3. Subscription Billing & Monetization -->
            <div class="card">
                <div class="card-icon">💳</div>
                <h2 class="card-title">Automated Subscription Billing</h2>
                <p class="card-description">
                    Turnkey integration with Razorpay Subscriptions, Stripe Billing, or paddle. Handles recurring tiers, free trials, prorated upgrades, and automated invoice receipts.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Razorpay / Stripe</span>
                    <span class="tag-chip">Usage-Based Tiers</span>
                    <span class="tag-chip">Self-Serve Portal</span>
                </div>
            </div>

            <!-- 4. Granular RBAC & Teams -->
            <div class="card">
                <div class="card-icon">👥</div>
                <h2 class="card-title">Teams & Role-Based Permissions</h2>
                <p class="card-description">
                    Allow tenant admins to invite teammates, manage access levels (Owner, Admin, Member, Viewer), and enforce company-wide security policies.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Team Invites</span>
                    <span class="tag-chip">Granular RBAC</span>
                    <span class="tag-chip">Audit Trails</span>
                </div>
            </div>

            <!-- 5. Executive & Admin Dashboards -->
            <div class="card">
                <div class="card-icon">📊</div>
                <h2 class="card-title">Internal Superadmin Control Plane</h2>
                <p class="card-description">
                    Equip your operational team with a powerful back-office dashboard to monitor MRR, active tenants, usage spikes, account impersonation, and churn signals.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">MRR / Churn Telemetry</span>
                    <span class="tag-chip">Impersonation Mode</span>
                    <span class="tag-chip">Tenant Health</span>
                </div>
            </div>

            <!-- 6. AI-Powered SaaS Features -->
            <div class="card">
                <div class="card-icon">🤖</div>
                <h2 class="card-title">Native AI Integration</h2>
                <p class="card-description">
                    Differentiate your SaaS offering by embedding proprietary AI agents, automated summarizers, or smart analytics directly into user workflows.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Smart Copilots</span>
                    <span class="tag-chip">Usage-based Metering</span>
                    <span class="tag-chip">Defensible Moats</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SaaS Engineering Checklist -->
<section class="section" style="background: rgba(11, 31, 58, 0.3);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>The Foundation</span>
            </div>
            <h2 class="section-title">Built for Production Scale From Day One</h2>
            <p class="section-subtitle">
                We handle the unglamorous infrastructure so you can focus entirely on customer acquisition and distribution.
            </p>
        </div>

        <div class="grid grid-cols-4">
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.5rem; font-size: 1.15rem;">Auth & Identity</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">Passwordless magic links, OAuth (Google/GitHub), 2FA, session invalidation, and secure cookies.</p>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.5rem; font-size: 1.15rem;">Rate Limiting & DDOS</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">Per-tier rate limiting to prevent API abuse, protect database threads, and defend margins.</p>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.5rem; font-size: 1.15rem;">Automated Emailing</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">Transactional email pipelines for account verification, password resets, and dunning notifications.</p>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.5rem; font-size: 1.15rem;">Continuous Delivery</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">Automated GitHub Actions deployment pipeline for zero-downtime releases on every pull request.</p>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to validate your SaaS idea?";
$ctaSubtitle = "Book a discovery call with our product engineers to scope an MVP architecture and rapid release timeline.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
