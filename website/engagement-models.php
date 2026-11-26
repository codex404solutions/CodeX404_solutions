<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Engagement Models — Partnership Structures | CodeX404 Solutions',
    'description' => 'Explore CodeX404 Solutions collaboration models: Fixed-Scope Milestone Builds, Dedicated Engineering Capacity, and Technical & AI Architecture Advisory.',
    'canonical' => url('engagement-models.php'),
    'keywords' => 'engagement models, fixed scope software development, dedicated engineering capacity, technical architecture advisory'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Trust & Pricing'],
    ['label' => 'Engagement Models'],
];
$heroTag = 'Collaboration Frameworks';
$heroTitleHtml = 'Structured <span class="text-gradient">Engagement Models</span> Fit for Your Stage';
$heroSubtitle = 'Whether you need a well-defined milestone build, recurring development capacity for a product roadmap, or senior architectural guidance—choose the model that fits your budget and team.';
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll" style="border-top: 4px solid var(--electric-blue); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <span class="tag-chip" style="margin-bottom: 1rem; width: fit-content; color: var(--cyan);">Turnkey Delivery</span>
                    <h2 class="card-title">Fixed-Scope Milestone Project</h2>
                    <p class="card-description">Ideal for focused MVPs, custom business portals, website builds, and well-defined automation pipelines.</p>
                    <div style="margin: 1.35rem 0; border-top: 1px solid var(--border-subtle); padding-top: 1.15rem;">
                        <ul class="transform-list">
                            <li>Written scope &amp; transparent milestone estimates</li>
                            <li>Reviewable staging builds throughout development</li>
                            <li>30-day post-launch defect resolution support</li>
                            <li>Source code &amp; deployment handoff agreed in writing</li>
                        </ul>
                    </div>
                </div>
                <a href="<?= url('discovery-call.php') ?>" class="btn btn-secondary btn-sm" style="width: 100%;">Scope a Project &rarr;</a>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1" style="border-top: 4px solid var(--cyan); background: var(--bg-surface-elevated); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <span class="tag-chip" style="color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Ongoing Delivery</span>
                        <span style="font-size: 0.72rem; color: #34D399; font-weight: 700; letter-spacing: 0.04em;">ITERATIVE ROADMAP</span>
                    </div>
                    <h2 class="card-title">Ongoing Product &amp; Growth Retainer</h2>
                    <p class="card-description">Best for businesses continuously shipping features, SEO/conversion improvements, and operational automations.</p>
                    <div style="margin: 1.35rem 0; border-top: 1px solid var(--border-subtle); padding-top: 1.15rem;">
                        <ul class="transform-list">
                            <li>Combined BUILD, GROW &amp; AUTOMATE execution</li>
                            <li>Direct communication with the engineers building your stack</li>
                            <li>Prioritized sprint backlog &amp; regular progress demos</li>
                            <li>Flexible monthly commitment without long-term lock-in</li>
                        </ul>
                    </div>
                </div>
                <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-sm" style="width: 100%;">Discuss Ongoing Support &rarr;</a>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2" style="border-top: 4px solid var(--amber); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <span class="tag-chip" style="margin-bottom: 1rem; width: fit-content; color: var(--amber); border-color: rgba(255, 140, 0, 0.4);">Technical Advisory</span>
                    <h2 class="card-title">Architecture &amp; AI Advisory</h2>
                    <p class="card-description">Designed for teams validating database design, AI feasibility, codebase audits, or third-party build planning.</p>
                    <div style="margin: 1.35rem 0; border-top: 1px solid var(--border-subtle); padding-top: 1.15rem;">
                        <ul class="transform-list">
                            <li>System architecture &amp; security review</li>
                            <li>AI / RAG feasibility &amp; data-boundary planning</li>
                            <li>Build-vs-buy scoping &amp; estimation review</li>
                            <li>Structured technical specification handoff</li>
                        </ul>
                    </div>
                </div>
                <a href="<?= url('discovery-call.php') ?>" class="btn btn-secondary btn-sm" style="width: 100%;">Book an Advisory Session &rarr;</a>
            </article>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Not Sure Which Engagement Structure Fits Best?";
$ctaSubtitle = "Share your goals and timeline constraints so we can recommend the simplest practical path.";
include __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
