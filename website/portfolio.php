<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/app/Services/ProjectService.php';

use App\Services\ProjectService;

$pageMeta = [
    'title' => 'Engineering Portfolio & Live Interactive Project Showcases',
    'description' => 'Explore production deliverables engineered by CodeX404 Solutions: School ERPs, WhatsApp lead ingestion pipelines, B2B wholesale engines, and private AI RAG systems with interactive in-browser demos.',
    'canonical' => url('portfolio.php'),
    'keywords' => 'software engineering portfolio, live software demos, custom ERP demo, AI RAG demo, WhatsApp automation demo, B2B e-commerce platform'
];

$projectTypes = ProjectService::getProjectTypes();
$showcaseStatuses = ProjectService::getShowcaseStatuses();

$portfolioProjects = ProjectService::getActive();
$countAll = count($portfolioProjects);
$countClient = count(array_filter($portfolioProjects, fn($p) => ($p['project_type'] ?? 'client') === 'client'));
$countInternal = count(array_filter($portfolioProjects, fn($p) => ($p['project_type'] ?? '') === 'internal'));
$countConcept = count(array_filter($portfolioProjects, fn($p) => ($p['project_type'] ?? '') === 'concept'));
$countOss = count(array_filter($portfolioProjects, fn($p) => ($p['project_type'] ?? '') === 'open_source'));

$countSoftware = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'software'));
$countBooking = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'booking'));
$countCommerce = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'commerce'));
$countMobile = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'mobile'));
$countAi = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'ai'));

require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="section" style="padding-top: calc(var(--nav-height) + 3rem); padding-bottom: 3.5rem;">
    <div class="container">
        <div class="section-header" style="max-width: 860px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Verified Deliverables &amp; Live Systems</span>
            </div>
            <h1 class="section-title" style="font-size: clamp(2.25rem, 4vw, 3.25rem); line-height: 1.15; margin-bottom: 1.25rem;">
                Engineered Deliverables &amp; <span class="gradient-text">Interactive Systems</span>
            </h1>
            <p class="section-subtitle" style="font-size: 1.1rem; line-height: 1.7; color: var(--slate); max-width: 740px; margin: 0 auto;">
                Explore production platforms, commercial client systems, proprietary internal engines, and working architectural concepts engineered by CodeX404 Solutions.
            </p>
        </div>

        <!-- Filter Controls (Category Tabs) -->
        <div class="project-filter-bar" role="tablist" aria-label="Project Categories"
            style="display: flex; justify-content: center; gap: 0.6rem; margin-bottom: 2.75rem; flex-wrap: wrap;">
            <button type="button" class="project-filter-btn active" data-filter="all">
                <span>✦</span> All Deliverables (<?= $countAll ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="booking">
                <span>📅</span> Booking &amp; Reservation (<?= $countBooking ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="software">
                <span>🏫</span> School &amp; Institutional (<?= $countSoftware ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="commerce">
                <span>🛍️</span> E-Commerce &amp; Wholesale (<?= $countCommerce ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="mobile">
                <span>📱</span> Mobile &amp; PWA (<?= $countMobile ?>)
            </button>
            <?php if ($countAi > 0): ?>
            <button type="button" class="project-filter-btn" data-filter="ai">
                <span>🤖</span> AI &amp; Automation (<?= $countAi ?>)
            </button>
            <?php endif; ?>
        </div>

        <!-- Portfolio Projects Grid -->
        <div class="project-showcase-grid">
            <?php foreach ($portfolioProjects as $p): ?>
                <?php
                $typeKey = $p['project_type'] ?? 'client';
                $type = $projectTypes[$typeKey] ?? $projectTypes['client'];
                $statusKey = $p['showcase_status'] ?? 'live_website';
                $status = $showcaseStatuses[$statusKey] ?? $showcaseStatuses['live_website'];
                $isClient = ($typeKey === 'client');
                $isAnonymized = !empty($p['is_anonymized']);
                $clientName = $p['public_client_name'] ?? 'Verified Commercial Client';
                ?>
                <article class="project-card clean-project-card card-tilt"
                    data-category="<?= htmlspecialchars($p['category']) ?>"
                    data-type="<?= htmlspecialchars($typeKey) ?>"
                    id="project-<?= htmlspecialchars($p['id']) ?>">
                    
                    <div>
                        <!-- Header with Project Type, Status, & Domain -->
                        <div class="cpc-header" style="margin-bottom: 0.85rem;">
                            <div class="cpc-meta" style="gap: 0.4rem; flex-wrap: wrap;">
                                <!-- Project Type Visual Label -->
                                <span class="cpc-type-pill <?= htmlspecialchars($type['badge']) ?>" title="<?= htmlspecialchars($type['desc']) ?>">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: currentColor;"></span>
                                    <span><?= htmlspecialchars($type['label']) ?></span>
                                </span>

                                <!-- Showcase Status Label -->
                                <span class="cpc-status-pill">
                                    <span><?= htmlspecialchars($status['label']) ?></span>
                                </span>
                            </div>

                            <!-- Live Host Domain Pill -->
                            <?php if (!empty($p['live_url'])): ?>
                                <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-domain-pill" title="Visit Live Production Domain">
                                    <span><?= htmlspecialchars($p['mockup_host'] ?? '') ?></span>
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                </a>
                            <?php elseif (!empty($p['mockup_host'])): ?>
                                <span class="cpc-domain-pill">
                                    <span><?= htmlspecialchars($p['mockup_host'] ?? '') ?></span>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Card Body -->
                        <div class="cpc-body">
                            <!-- Title (Linked to detail view) -->
                            <h3 class="cpc-title">
                                <a href="<?= url('project.php?id=' . urlencode($p['id'])) ?>" title="View Architecture &amp; Case Study for <?= htmlspecialchars($p['title']) ?>">
                                    <?= htmlspecialchars($p['title']) ?>
                                </a>
                            </h3>

                            <!-- Client Attribution Row (Only when authorized / non-confidential) -->
                            <div class="cpc-client-row">
                                <?php if (!empty($p['client_logo'])): ?>
                                    <img src="<?= asset($p['client_logo']) ?>" alt="<?= htmlspecialchars($clientName) ?>" style="height: 16px; max-width: 60px; object-fit: contain; vertical-align: middle;">
                                <?php endif; ?>
                                
                                <?php if ($isClient): ?>
                                    <?php if ($isAnonymized): ?>
                                        <span class="cpc-client-anon" title="Client name protected under NDA">🔒 <?= htmlspecialchars($clientName) ?></span>
                                    <?php else: ?>
                                        <span class="cpc-client-name">🏢 <?= htmlspecialchars($clientName) ?></span>
                                    <?php endif; ?>
                                <?php elseif ($typeKey === 'internal'): ?>
                                    <span class="cpc-client-name" style="color: var(--cyan);">💡 CodeX404 Proprietary</span>
                                <?php else: ?>
                                    <span class="cpc-client-name" style="color: #FBBF24;">⚡ Architectural Prototype</span>
                                <?php endif; ?>
                            </div>

                            <!-- Description -->
                            <p class="cpc-description">
                                <?= htmlspecialchars(!empty($p['solution']) ? $p['solution'] : ($p['problem'] ?? '')) ?>
                            </p>
                            
                            <!-- Key Features Preview (Top 2 Bullets) -->
                            <?php if (!empty($p['features'])): ?>
                                <div class="cpc-features-preview">
                                    <?php foreach (array_slice($p['features'], 0, 2) as $feat): ?>
                                        <div class="cpc-feature-bullet">
                                            <span class="dot">✦</span>
                                            <span class="text-truncate"><?= htmlspecialchars($feat) ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Verified Business Outcome Metric (Only if verified) -->
                            <?php if (!empty($p['metric'])): ?>
                                <div class="cpc-metric" title="Verified Quantitative Performance Outcome">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span class="text-truncate"><?= htmlspecialchars($p['metric']) ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Tech Stack Tags -->
                            <?php if (!empty($p['tags'])): ?>
                                <div class="cpc-tags">
                                    <?php foreach (array_slice($p['tags'], 0, 3) as $tag): ?>
                                        <span class="cpc-tag"><?= htmlspecialchars($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Actions Footer (Buttons rendered only if respective link/demo exists) -->
                    <div class="cpc-footer">
                        <?php if (!empty($p['live_url'])): ?>
                            <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-btn cpc-btn-primary" title="Visit Live Production Website">
                                <span>Live Site ↗</span>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($p['demo_url'])): ?>
                            <a href="<?= htmlspecialchars($p['demo_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-btn cpc-btn-secondary" title="Interactive Simulator">
                                <span>⚡ Demo</span>
                            </a>
                        <?php elseif (!empty($p['demo_key'])): ?>
                            <a href="<?= url('index.php#project-' . urlencode($p['id'])) ?>" class="cpc-btn cpc-btn-secondary btn-demo-trigger" data-demo="<?= htmlspecialchars($p['demo_key']) ?>" title="Launch In-Browser Simulator">
                                <span>⚡ Demo</span>
                            </a>
                        <?php endif; ?>

                        <a href="<?= url('project.php?id=' . urlencode($p['id'])) ?>" class="cpc-btn cpc-btn-outline" title="View Full Architecture &amp; Case Study">
                            <span>Details →</span>
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
