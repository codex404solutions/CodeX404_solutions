<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Engineering Portfolio & Live Interactive Project Showcases',
    'description' => 'Explore production deliverables engineered by CodeX404 Solutions: School ERPs, WhatsApp lead ingestion pipelines, B2B wholesale engines, and private AI RAG systems with interactive in-browser demos.',
    'canonical' => url('portfolio.php'),
    'keywords' => 'software engineering portfolio, live software demos, custom ERP demo, AI RAG demo, WhatsApp automation demo, B2B e-commerce platform'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="section" style="padding-top: calc(var(--nav-height) + 3rem); padding-bottom: 3.5rem;">
    <div class="container">
        <div class="section-header" style="max-width: 860px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Verified Deliverables & Live Demos</span>
            </div>
            <h1 class="section-title" style="font-size: clamp(2.25rem, 4vw, 3.25rem); line-height: 1.15; margin-bottom: 1.25rem;">
                Engineered Deliverables & <span class="gradient-text">Interactive Systems</span>
            </h1>
            <p class="section-subtitle" style="font-size: 1.1rem; line-height: 1.7; color: var(--slate); max-width: 740px; margin: 0 auto;">
                Explore real software platforms, operational engines, and AI automations engineered by CodeX404 Solutions. Test working interactive simulators directly inside your browser right now.
            </p>
        </div>

        <?php
        $portfolioProjects = \App\Services\ProjectService::getActive();
        $countAll = count($portfolioProjects);
        $countSoftware = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'software'));
        $countBooking = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'booking'));
        $countCommerce = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'commerce'));
        $countMobile = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'mobile'));
        $countAi = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'ai'));
        ?>
        <!-- Filter Controls -->
        <div class="project-filter-bar" role="tablist" aria-label="Project Categories"
            style="display: flex; justify-content: center; gap: 0.6rem; margin-bottom: 2.75rem; flex-wrap: wrap;">
            <button type="button" class="project-filter-btn active" data-filter="all">
                <span>✦</span> All (<?= $countAll ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="booking">
                <span>📅</span> Booking Systems (<?= $countBooking ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="software">
                <span>🏫</span> School & Institutional (<?= $countSoftware ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="commerce">
                <span>🛍️</span> E-Commerce (<?= $countCommerce ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="mobile">
                <span>📱</span> Mobile & PWA (<?= $countMobile ?>)
            </button>
            <?php if ($countAi > 0): ?>
            <button type="button" class="project-filter-btn" data-filter="ai">
                <span>🤖</span> AI & Automation (<?= $countAi ?>)
            </button>
            <?php endif; ?>
        </div>

        <!-- Portfolio Projects Grid (Compact & Sleek) -->
        <div class="project-showcase-grid">
            <?php foreach ($portfolioProjects as $p): ?>
                <article class="project-card clean-project-card card-tilt" data-category="<?= htmlspecialchars($p['category']) ?>" id="project-<?= htmlspecialchars($p['id']) ?>">
                    <div>
                        <!-- Header with meta & verified live domain -->
                        <div class="cpc-header">
                            <div class="cpc-meta">
                                <span class="cpc-category"><?= htmlspecialchars($p['category_label'] ?? 'Custom Software') ?></span>
                                <span class="cpc-badge">
                                    <span class="cpc-dot"></span>
                                    <?= htmlspecialchars($p['badge_text'] ?? 'Live') ?>
                                </span>
                            </div>
                            <?php if (!empty($p['live_url'])): ?>
                                <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-domain-pill" title="Visit Live Website">
                                    <span><?= htmlspecialchars($p['mockup_host'] ?? '') ?></span>
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                </a>
                            <?php else: ?>
                                <span class="cpc-domain-pill">
                                    <span><?= htmlspecialchars($p['mockup_host'] ?? '') ?></span>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Card Body -->
                        <div class="cpc-body">
                            <h3 class="cpc-title">
                                <?php if (!empty($p['live_url'])): ?>
                                    <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" title="Visit <?= htmlspecialchars($p['title']) ?>"><?= htmlspecialchars($p['title']) ?></a>
                                <?php else: ?>
                                    <?= htmlspecialchars($p['title']) ?>
                                <?php endif; ?>
                            </h3>
                            <p class="cpc-description"><?= htmlspecialchars($p['solution'] ?? $p['description'] ?? '') ?></p>
                            
                            <?php if (!empty($p['metric'])): ?>
                                <div class="cpc-metric">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span><?= htmlspecialchars($p['metric']) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($p['tags'])): ?>
                                <div class="cpc-tags">
                                    <?php foreach (array_slice($p['tags'], 0, 3) as $tag): ?>
                                        <span class="cpc-tag"><?= htmlspecialchars($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Clean Actions -->
                    <div class="cpc-footer">
                        <?php if (!empty($p['live_url'])): ?>
                            <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-btn cpc-btn-primary" title="Visit Live Site">
                                <span>Live Site ↗</span>
                            </a>
                        <?php endif; ?>
                        <a href="<?= url('index.php#project-' . urlencode($p['id'])) ?>" class="cpc-btn cpc-btn-secondary btn-demo-trigger" data-demo="<?= htmlspecialchars($p['demo_key'] ?? 'wa') ?>" title="Interactive Sandbox">
                            <span>⚡ Demo</span>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- LIVE DEMO SANDBOX BANNER -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container" style="text-align: center;">
        <div style="max-width: 680px; margin: 0 auto;">
            <span class="tag-chip" style="margin-bottom: 1rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">In-Browser Sandbox</span>
            <h3 style="font-size: 1.85rem; color: var(--white); margin-bottom: 1rem;">Experience Live Demos in Real Time</h3>
            <p style="font-size: 1rem; color: var(--slate); line-height: 1.6; margin-bottom: 2rem;">
                Launch our interactive modal sandboxes on the homepage to test live AI RAG question answering, simulate WhatsApp lead webhook payloads, and preview real dashboard actions.
            </p>
            <a href="<?= url('index.php#projects') ?>" class="btn btn-primary" style="padding: 0.9rem 2.25rem;">Open Live Demo Sandbox ⚡</a>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Engineer Your Next Proprietary Digital Asset?";
$ctaSubtitle = "Schedule a technical scoping session to review your requirements, specifications, and architecture directly with our founding engineers.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
