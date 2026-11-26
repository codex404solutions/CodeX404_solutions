<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/app/Services/ProjectService.php';

use App\Services\ProjectService;

$pageMeta = [
    'title' => 'SaaS Product Engineering & Digital Platforms | CodeX404 Solutions',
    'description' => 'Plan and build SaaS products around your users, business model, and data boundaries—plus explore live platforms and interactive product concepts built by CodeX404.',
    'canonical' => url('saas.php'),
    'keywords' => 'SaaS product development, MVP development, multi-tenant SaaS architecture, subscription billing Stripe Razorpay, CodeX404 products'
];

$allProjects = ProjectService::getActive();
$internalPlatforms = array_values(array_filter($allProjects, fn($p) => ($p['project_type'] ?? '') === 'internal'));
$productConcepts = array_values(array_filter($allProjects, fn($p) => ($p['project_type'] ?? '') === 'concept'));

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Services', 'url' => url('solutions.php')],
    ['label' => 'SaaS & Products'],
];
$heroTag = 'BUILD · SaaS Products & Digital Platforms';
$heroTitleHtml = 'From Product Concept to <span class="text-gradient">Production-Ready SaaS</span>';
$heroSubtitle = 'We design and build multi-tenant SaaS applications and internal platforms—handling data isolation, recurring billing, role-based access, and maintainable deployment pipelines.';
$heroActions = [
    ['label' => 'Discuss a SaaS Build', 'url' => url('discovery-call.php') . '?division=BUILD', 'variant' => 'primary'],
    ['label' => 'Explore Product Catalog', 'url' => '#codex-platforms', 'variant' => 'secondary'],
];
require __DIR__ . '/includes/subpage-hero.php';
?>

<!-- CODEX404 PLATFORMS & CONCEPTS (VERIFIED PROJECT DATA) -->
<?php if (!empty($internalPlatforms) || !empty($productConcepts)): ?>
<section class="section" id="codex-platforms" style="background: rgba(11, 31, 58, 0.3); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 820px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;"><span class="dot"></span><span>Products &amp; Platform Showcase</span></div>
            <h2 class="section-title">Internal Platforms &amp; Interactive Product Concepts</h2>
            <p class="section-subtitle">Real internal products operated by CodeX404 alongside interactive functional prototypes built to demonstrate domain workflows.</p>
        </div>

        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <?php foreach (array_merge($internalPlatforms, $productConcepts) as $prod): ?>
                <?php
                $isLive = (($prod['project_type'] ?? '') === 'internal' && !empty($prod['live_url']));
                $statusLabel = $isLive ? 'Live' : 'Interactive Sandbox';
                $statusClass = $isLive ? 'status-pill-live' : 'status-pill-dev';
                $title = htmlspecialchars((string)($prod['title'] ?? 'Platform'), ENT_QUOTES, 'UTF-8');
                $desc = htmlspecialchars((string)($prod['problem'] ?: ($prod['solution'] ?: ($prod['description'] ?? ''))), ENT_QUOTES, 'UTF-8');
                $audience = htmlspecialchars((string)($prod['category_label'] ?? 'Businesses & Teams'), ENT_QUOTES, 'UTF-8');
                ?>
                <article class="card card-tilt" style="display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                            <span style="font-size: 0.78rem; color: var(--slate-dark); font-weight: 600;"><?= $audience ?></span>
                            <span class="status-pill <?= $statusClass ?>"><?= htmlspecialchars($statusLabel, ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <h3 style="font-size: 1.28rem; color: var(--white); margin-bottom: 0.65rem;"><?= $title ?></h3>
                        <p style="font-size: 0.9rem; color: var(--slate); line-height: 1.65; margin-bottom: 1.15rem;"><?= $desc ?></p>
                        <?php if (!empty($prod['tags']) && is_array($prod['tags'])): ?>
                            <div class="card-tags" style="margin-bottom: 1.25rem;">
                                <?php foreach (array_slice($prod['tags'], 0, 4) as $tag): ?>
                                    <span class="tag-chip"><?= htmlspecialchars((string)$tag, ENT_QUOTES, 'UTF-8') ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div style="padding-top: 0.9rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
                        <a href="<?= url('project.php?id=' . urlencode((string)$prod['id'])) ?>" class="card-arrow-link" style="color: var(--cyan); font-weight: 600;">View Architecture &rarr;</a>
                        <?php if ($isLive): ?>
                            <a href="<?= htmlspecialchars((string)$prod['live_url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer" style="font-size: 0.8rem; color: var(--teal); font-weight: 600;">Visit Live Site &nearr;</a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- SAAS ENGINEERING CAPABILITIES -->
<section class="section">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;"><span class="dot"></span><span>SaaS Engineering Capabilities</span></div>
            <h2 class="section-title">How We Build Scalable Multi-Tenant Software</h2>
            <p class="section-subtitle">Focused scope control paired with clean tenant isolation, recurring billing, and maintainable back-office tooling.</p>
        </div>

        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-build"><?= codex_icon('zap', 24) ?></div>
                <h3 class="card-title" style="font-size: 1.25rem;">Focused MVP Scope</h3>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Launch a working Minimum Viable Product focused tightly on your primary customer workflow instead of burying time in low-value extras.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Validated Core</span>
                    <span class="tag-chip">Iterative Releases</span>
                    <span class="tag-chip">Scope Discipline</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-build"><?= codex_icon('database', 24) ?></div>
                <h3 class="card-title" style="font-size: 1.25rem;">Multi-Tenant Data Isolation</h3>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Design tenant boundaries matched to your data model and security risk—using row-level scoping, subdomain routing, and tested access checks.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Tenant Scoping</span>
                    <span class="tag-chip">Custom Subdomains</span>
                    <span class="tag-chip">PostgreSQL / MySQL</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-build"><?= codex_icon('card', 24) ?></div>
                <h3 class="card-title" style="font-size: 1.25rem;">Subscription Billing</h3>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Stripe or Razorpay billing integration supporting monthly and annual plans, webhook verification, self-serve receipts, and tier upgrades.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Stripe &amp; Razorpay</span>
                    <span class="tag-chip">Webhook Sync</span>
                    <span class="tag-chip">Plan Upgrades</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-build"><?= codex_icon('users', 24) ?></div>
                <h3 class="card-title" style="font-size: 1.25rem;">Team Management &amp; RBAC</h3>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Allow customer accounts to invite team members, assign roles (Owner, Admin, Member, Viewer), and revoke sessions securely.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Team Invites</span>
                    <span class="tag-chip">Granular Roles</span>
                    <span class="tag-chip">Audit Trails</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-build"><?= codex_icon('chart', 24) ?></div>
                <h3 class="card-title" style="font-size: 1.25rem;">Operations Control Plane</h3>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Equip internal operators with dashboards to inspect tenant status, billing events, support flags, and system configuration safely.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Tenant Health</span>
                    <span class="tag-chip">Feature Flags</span>
                    <span class="tag-chip">Admin Reporting</span>
                </div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-automate"><?= codex_icon('bot', 24) ?></div>
                <h3 class="card-title" style="font-size: 1.25rem;">Embedded AI Workflows</h3>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Integrate grounded document search, summarization, or workflow assistants directly inside tenant workspaces with clear quota controls.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">RAG Integration</span>
                    <span class="tag-chip">Usage Quotas</span>
                    <span class="tag-chip">Private Context</span>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- PRODUCTION BASELINE -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;"><span class="dot"></span><span>The Production Baseline</span></div>
            <h2 class="section-title">Foundations Included in Serious SaaS Builds</h2>
            <p class="section-subtitle">Essential security, deployment, and messaging foundations configured cleanly so your team focuses on customers.</p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card" style="padding: 1.75rem;">
                <h3 style="color: var(--cyan); margin-bottom: 0.65rem; font-size: 1.12rem;">Auth &amp; Identity</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Session hardening, hashed credentials, OAuth/magic-link flows, and MFA options tailored to risk.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <h3 style="color: var(--cyan); margin-bottom: 0.65rem; font-size: 1.12rem;">Rate Limiting</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Endpoint throttling and abuse safeguards protecting database capacity and API quotas.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <h3 style="color: var(--cyan); margin-bottom: 0.65rem; font-size: 1.12rem;">Transactional Email</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Reliable SMTP/API templates for verification codes, password resets, and billing receipts.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <h3 style="color: var(--cyan); margin-bottom: 0.65rem; font-size: 1.12rem;">Automated Deploys</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Version-controlled SQL migrations, GitHub Actions checks, and clean staging-to-production releases.</p>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Scope Your SaaS Product or MVP?";
$ctaSubtitle = "Book a technical discovery session to review product scope, data isolation, billing requirements, and milestone steps.";
$ctaSecondaryText = "Explore Our Work";
$ctaSecondaryUrl = url('our-work.php');
include __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
