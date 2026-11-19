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
                Engineered Deliverables &amp; <span class="gradient-text gradient-text-animated">Interactive Systems</span>
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
                $cat = $p['category'] ?? 'software';
                $demoKey = $p['demo_key'] ?? 'erp';
                $artClass = match($cat) {
                    'booking' => 'cpc-art-booking',
                    'commerce' => 'cpc-art-commerce',
                    'mobile' => 'cpc-art-mobile',
                    'ai' => 'cpc-art-ai',
                    default => 'cpc-art-software'
                };
                $stageIcon = match($cat) {
                    'booking' => '🏥',
                    'commerce' => '🛒',
                    'mobile' => '📱',
                    'ai' => '🤖',
                    default => '💻'
                };
                ?>
                <article class="project-card clean-project-card card-tilt"
                    data-category="<?= htmlspecialchars($p['category']) ?>"
                    data-type="<?= htmlspecialchars($typeKey) ?>"
                    id="project-<?= htmlspecialchars($p['id']) ?>">
                    
                    <div>
                        <!-- 1. Screenshot (Uploaded via Admin Panel or Sleek Dynamic Fallback) -->
                        <?php if (!empty($p['live_url'])): ?>
                            <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-media-wrap" title="Visit Live Website for <?= htmlspecialchars($p['title']) ?>">
                        <?php else: ?>
                            <div class="cpc-media-wrap" title="<?= htmlspecialchars($p['title']) ?>">
                        <?php endif; ?>
                            <div class="cpc-media-browser-bar">
                                <div class="cpc-window-dots">
                                    <span class="cpc-dot-item dot-red"></span>
                                    <span class="cpc-dot-item dot-yellow"></span>
                                    <span class="cpc-dot-item dot-green"></span>
                                </div>
                                <div class="cpc-media-url font-mono">
                                    <span>🔒</span> <?= htmlspecialchars($p['mockup_host'] ?? 'app.codex404solutions.online') ?>
                                </div>
                            </div>
                            <div class="cpc-media-viewport">
                                <?php if (!empty($p['cover_image'])): ?>
                                    <img src="<?= asset($p['cover_image']) ?>" alt="Screenshot of <?= htmlspecialchars($p['title']) ?>" class="cpc-screenshot-img" loading="lazy">
                                <?php else: ?>
                                    <div class="cpc-screenshot-placeholder <?= $artClass ?>">
                                        <span class="cpc-placeholder-icon"><?= $stageIcon ?></span>
                                        <span class="cpc-placeholder-sub"><?= htmlspecialchars($p['category_label'] ?? 'Software Platform') ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?= !empty($p['live_url']) ? '</a>' : '</div>' ?>

                        <!-- 2. Project Name (Title) -->
                        <h3 class="cpc-minimal-title">
                            <?php if (!empty($p['live_url'])): ?>
                                <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" title="<?= htmlspecialchars($p['title']) ?>">
                                    <?= htmlspecialchars($p['title']) ?>
                                </a>
                            <?php else: ?>
                                <a href="<?= url('project.php?id=' . urlencode($p['id'])) ?>" title="<?= htmlspecialchars($p['title']) ?>">
                                    <?= htmlspecialchars($p['title']) ?>
                                </a>
                            <?php endif; ?>
                        </h3>

                        <!-- 3. Clean URL Link -->
                        <div class="cpc-minimal-url-row">
                            <?php if (!empty($p['live_url'])): ?>
                                <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-minimal-url-link" title="Visit Live Production Domain">
                                    <span class="url-protocol">https://</span><span class="url-domain"><?= htmlspecialchars($p['mockup_host'] ?? parse_url($p['live_url'], PHP_URL_HOST)) ?></span>
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                </a>
                            <?php else: ?>
                                <span class="cpc-minimal-url-link disabled">
                                    <span class="url-protocol">internal://</span><span class="url-domain"><?= htmlspecialchars($p['mockup_host'] ?? 'app.codex404solutions.online') ?></span>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- 4. Main Features (Top 3 Bullet Points) -->
                        <?php if (!empty($p['features']) && is_array($p['features'])): ?>
                            <ul class="cpc-minimal-features-list">
                                <?php foreach (array_slice($p['features'], 0, 3) as $feat): ?>
                                    <li>
                                        <span class="cpc-feat-dot">✦</span>
                                        <span><?= htmlspecialchars($feat) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <!-- Actions Footer: Only Live Site -->
                    <div class="cpc-footer">
                        <?php if (!empty($p['live_url'])): ?>
                            <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-btn cpc-btn-primary cpc-btn-full" title="Visit Live Production Website">
                                <span>Live Site ↗</span>
                            </a>
                        <?php else: ?>
                            <a href="<?= url('project.php?id=' . urlencode($p['id'])) ?>" class="cpc-btn cpc-btn-primary cpc-btn-full" title="View Project Specs">
                                <span>Live Site ↗</span>
                            </a>
                        <?php endif; ?>
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

<!-- Interactive Live Demo Modal Overlay (For Trigger Buttons) -->
<?php include __DIR__ . '/components/demo-modal.php'; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
