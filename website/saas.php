<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'SaaS Product Engineering & Rapid MVP Development',
    'description' => 'Turn your software vision into a revenue-generating, scalable SaaS platform in 4 to 8 weeks. Multi-tenant architecture, automated subscription billing, and 100% IP ownership.',
    'canonical' => url('saas.php'),
    'keywords' => 'SaaS product development, MVP development, multi-tenant SaaS architecture, subscription billing Stripe Razorpay, B2B SaaS engineering, rapid MVP launch'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="section" style="padding-top: calc(var(--nav-height) + 3rem); padding-bottom: 3.5rem;">
    <div class="container">
        <div class="section-header" style="max-width: 860px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Venture & Cloud Product Engineering</span>
            </div>
            <h1 class="section-title" style="font-size: clamp(2.25rem, 4vw, 3.25rem); line-height: 1.15; margin-bottom: 1.25rem;">
                From Vision to Scalable <span class="gradient-text">Recurring-Revenue SaaS</span>
            </h1>
            <p class="section-subtitle" style="font-size: 1.1rem; line-height: 1.7; color: var(--slate); max-width: 740px; margin: 0 auto;">
                We partner with ambitious founders and forward-thinking enterprises to design, engineer, and launch production-ready Software-as-a-Service products in 4 to 8 weeks — built with multi-tenant security, automated billing, and 100% IP ownership.
            </p>
        </div>

        <!-- 6 Core SaaS Capability Cards -->
        <div class="grid grid-cols-3" style="gap: 2rem;">
            <!-- 1. Rapid MVP Framework -->
            <div class="card">
                <div class="card-icon">⚡</div>
                <h2 class="card-title" style="font-size: 1.3rem;">4 to 8 Week MVP Framework</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Launch a production-grade Minimum Viable Product quickly to validate market demand with real paying customers. We ruthlessly prune non-essential feature bloat to focus entirely on core value.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Rapid Go-to-Market</span>
                    <span class="tag-chip">Validated Core</span>
                    <span class="tag-chip">Zero Feature Creep</span>
                    <span class="tag-chip">Investor Ready</span>
                </div>
            </div>

            <!-- 2. Multi-Tenant Architecture -->
            <div class="card">
                <div class="card-icon">🏢</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Multi-Tenant Data Isolation</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Engineered with rigorous tenant segregation models (Row-Level Security or schema-per-tenant). Guarantees zero cross-customer data leakage and effortless horizontal scaling as user counts soar.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Row-Level Security</span>
                    <span class="tag-chip">Custom Subdomains</span>
                    <span class="tag-chip">Zero Cross-Bleed</span>
                    <span class="tag-chip">PostgreSQL / MySQL</span>
                </div>
            </div>

            <!-- 3. Automated Subscription Billing -->
            <div class="card">
                <div class="card-icon">💳</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Subscription Billing & Monetization</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Turnkey integration with Stripe Billing or Razorpay Subscriptions. Supports recurring monthly/annual tiers, usage-based metering, self-serve upgrade/downgrade portals, and automatic dunning recovery.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Stripe & Razorpay</span>
                    <span class="tag-chip">Usage Metering</span>
                    <span class="tag-chip">Self-Serve Invoicing</span>
                    <span class="tag-chip">Prorated Upgrades</span>
                </div>
            </div>

            <!-- 4. Granular RBAC & Teams -->
            <div class="card">
                <div class="card-icon">👥</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Team Management & RBAC</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Enable tenant administrators to invite colleagues, assign fine-grained roles (Owner, Admin, Member, Read-Only), revoke access instantly, and enforce corporate security standards.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Team Invites</span>
                    <span class="tag-chip">Granular Permissions</span>
                    <span class="tag-chip">Audit Trails</span>
                    <span class="tag-chip">OAuth & Magic Links</span>
                </div>
            </div>

            <!-- 5. Superadmin Control Plane -->
            <div class="card">
                <div class="card-icon">📊</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Superadmin Control Plane</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Equip your founding team with a powerful back-office control center to monitor Monthly Recurring Revenue (MRR), churn indicators, active user sessions, account impersonation, and tenant health.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">MRR & Churn Telemetry</span>
                    <span class="tag-chip">Account Impersonation</span>
                    <span class="tag-chip">Tenant Health Status</span>
                    <span class="tag-chip">Feature Flags</span>
                </div>
            </div>

            <!-- 6. Embedded AI Differentiators -->
            <div class="card">
                <div class="card-icon">🤖</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Embedded AI & Defensible Moats</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Elevate your SaaS platform above competitors by embedding proprietary AI copilots, automated document summarization, or smart recommendation engines directly into tenant workflows.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Smart Copilots</span>
                    <span class="tag-chip">Usage Token Metering</span>
                    <span class="tag-chip">Defensible IP Moat</span>
                    <span class="tag-chip">Private Embeddings</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRODUCTION SCALE INFRASTRUCTURE CHECKLIST -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>The Production Baseline</span>
            </div>
            <h2 class="section-title">Built for Real Enterprise Scale From Day One</h2>
            <p class="section-subtitle">
                We handle the critical infrastructure scaffolding so you can direct 100% of your energy toward customer acquisition and growth.
            </p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card" style="padding: 2rem;">
                <h3 style="color: var(--cyan); margin-bottom: 0.75rem; font-size: 1.15rem;">Auth & Identity</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    Passwordless magic links, Google/GitHub OAuth, Two-Factor Authentication (2FA), encrypted sessions, and automatic token expiry.
                </p>
            </div>

            <div class="card" style="padding: 2rem;">
                <h3 style="color: var(--cyan); margin-bottom: 0.75rem; font-size: 1.15rem;">Rate Limiting & DDOS</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    Per-tier rate limiting to defend database resources, prevent API abuse, and preserve server operational margins under heavy traffic spikes.
                </p>
            </div>

            <div class="card" style="padding: 2rem;">
                <h3 style="color: var(--cyan); margin-bottom: 0.75rem; font-size: 1.15rem;">Transactional Email</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    Reliable delivery pipelines for account confirmations, password resets, payment notifications, and automated dunning alerts.
                </p>
            </div>

            <div class="card" style="padding: 2rem;">
                <h3 style="color: var(--cyan); margin-bottom: 0.75rem; font-size: 1.15rem;">Zero-Downtime CI/CD</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    Automated GitHub Actions pipelines with linting, unit test suites, and atomic deployments with rollback capabilities on every pull request.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- FULL IP OWNERSHIP COMMITMENT -->
<section class="section">
    <div class="container">
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 3rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 2rem;">
            <div style="max-width: 620px;">
                <span class="tag-chip" style="margin-bottom: 0.75rem; color: #34D399; border-color: rgba(52, 211, 153, 0.4);">100% Intellectual Property Handover</span>
                <h3 style="font-size: 1.85rem; color: var(--white); margin-bottom: 0.75rem;">You Own Every Single Line of Code</h3>
                <p style="font-size: 0.95rem; line-height: 1.6; color: var(--slate);">
                    Unlike agencies that try to lock you into proprietary platforms or retain repository ownership, we transfer 100% of code, design files, deployment configurations, and credentials to your company Git organization upon delivery.
                </p>
            </div>
            <div>
                <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary" style="padding: 0.9rem 2rem;">Book SaaS Discovery Session ⚡</a>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Turn Your SaaS Idea Into a Live Product?";
$ctaSubtitle = "Schedule a technical scoping session with our lead architects to review your product roadmap and calculate a concrete 4-8 week MVP delivery plan.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
