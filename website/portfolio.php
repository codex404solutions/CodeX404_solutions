<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/app/Services/ProjectService.php';

use App\Services\ProjectService;

$pageMeta = [
    'title' => 'Engineering Portfolio & Project Deliverables | CodeX404 Solutions',
    'description' => 'Browse CodeX404 Solutions deliverables by domain and classification—client systems, internal platforms, and interactive booking or AI sandboxes.',
    'canonical' => url('portfolio.php'),
    'keywords' => 'software engineering portfolio, live software demos, custom ERP, AI RAG demo, WhatsApp automation demo, B2B e-commerce platform'
];

$projectTypes = ProjectService::getProjectTypes();
$showcaseStatuses = ProjectService::getShowcaseStatuses();

$portfolioProjects = ProjectService::getActive();
$countAll = count($portfolioProjects);
$countSoftware = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'software'));
$countBooking = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'booking'));
$countCommerce = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'commerce'));
$countMobile = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'mobile'));
$countAi = count(array_filter($portfolioProjects, fn($p) => ($p['category'] ?? '') === 'ai'));

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Our Work', 'url' => url('our-work.php')],
    ['label' => 'Portfolio Specs'],
];
$heroTag = 'Verified Deliverables & Interactive Sandboxes';
$heroTitleHtml = 'Engineered Deliverables &amp; <span class="text-amber">Interactive Systems</span>';
$heroSubtitle = 'Inspect production client websites, proprietary CodeX404 platforms, and interactive domain prototypes with transparent features and technical stacks.';
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div class="project-filter-bar" role="tablist" aria-label="Project Categories"
            style="display: flex; justify-content: center; gap: 0.6rem; margin-bottom: 2.75rem; flex-wrap: wrap;">
            <button type="button" class="project-filter-btn active" data-filter="all">All Deliverables
                (<?= $countAll ?>)</button>
            <button type="button" class="project-filter-btn" data-filter="booking">Booking &amp; Reservation
                (<?= $countBooking ?>)</button>
            <button type="button" class="project-filter-btn" data-filter="software">School &amp; Institutional
                (<?= $countSoftware ?>)</button>
            <button type="button" class="project-filter-btn" data-filter="commerce">E-Commerce &amp; Wholesale
                (<?= $countCommerce ?>)</button>
            <button type="button" class="project-filter-btn" data-filter="mobile">Mobile &amp; PWA
                (<?= $countMobile ?>)</button>
            <?php if ($countAi > 0): ?>
                <button type="button" class="project-filter-btn" data-filter="ai">AI &amp; Automation
                    (<?= $countAi ?>)</button>
            <?php endif; ?>
        </div>

        <div class="project-showcase-grid">
            <?php foreach ($portfolioProjects as $p): ?>
                <?php
                $typeKey = $p['project_type'] ?? 'client';
                $typeLabel = match ($typeKey) {
                    'internal' => 'Internal Platform',
                    'concept' => 'Interactive Concept',
                    'open_source' => 'Open Source',
                    default => 'Client Project',
                };
                $typeClass = match ($typeKey) {
                    'internal' => 'status-pill-dev',
                    'concept' => 'status-pill-soon',
                    default => 'status-pill-live',
                };
                $cat = $p['category'] ?? 'software';
                $artClass = match ($cat) {
                    'booking' => 'cpc-art-booking',
                    'commerce' => 'cpc-art-commerce',
                    'mobile' => 'cpc-art-mobile',
                    'ai' => 'cpc-art-ai',
                    default => 'cpc-art-software'
                };
                $stageIconKey = match ($cat) {
                    'booking' => 'calendar',
                    'commerce' => 'cart',
                    'mobile' => 'smartphone',
                    'ai' => 'bot',
                    default => 'code'
                };
                $detailUrl = url('project.php?id=' . urlencode((string) $p['id']));
                $hasLive = !empty($p['live_url']);
                ?>
                <article class="project-card clean-project-card card-tilt"
                    data-category="<?= htmlspecialchars((string) $cat, ENT_QUOTES, 'UTF-8') ?>"
                    data-type="<?= htmlspecialchars((string) $typeKey, ENT_QUOTES, 'UTF-8') ?>"
                    id="project-<?= htmlspecialchars((string) $p['id'], ENT_QUOTES, 'UTF-8') ?>">

                    <div>
                        <a href="<?= $detailUrl ?>" class="cpc-media-wrap"
                            title="Inspect architecture and overview for <?= htmlspecialchars((string) $p['title'], ENT_QUOTES, 'UTF-8') ?>">
                            <div class="cpc-media-browser-bar">
                                <div class="cpc-window-dots">
                                    <span class="cpc-dot-item dot-red"></span>
                                    <span class="cpc-dot-item dot-yellow"></span>
                                    <span class="cpc-dot-item dot-green"></span>
                                </div>
                                <div class="cpc-media-url font-mono">
                                    <?= htmlspecialchars((string) ($p['mockup_host'] ?? 'app.codex404solutions.online'), ENT_QUOTES, 'UTF-8') ?>
                                </div>
                            </div>
                            <div class="cpc-media-viewport">
                                <?php if (!empty($p['cover_image'])): ?>
                                    <img src="<?= asset((string) $p['cover_image']) ?>"
                                        alt="Preview of <?= htmlspecialchars((string) $p['title'], ENT_QUOTES, 'UTF-8') ?>"
                                        class="cpc-screenshot-img" loading="lazy">
                                <?php else: ?>
                                    <div class="cpc-screenshot-placeholder <?= $artClass ?>">
                                        <span class="inline-icon-box"
                                            style="margin-bottom: 0.5rem;"><?= codex_icon($stageIconKey, 22) ?></span>
                                        <span
                                            class="cpc-placeholder-sub"><?= htmlspecialchars((string) ($p['category_label'] ?? 'Software Platform'), ENT_QUOTES, 'UTF-8') ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </a>

                        <div
                            style="display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; margin-bottom: 0.45rem;">
                            <span
                                class="status-pill <?= $typeClass ?>"><?= htmlspecialchars($typeLabel, ENT_QUOTES, 'UTF-8') ?></span>
                            <span
                                style="font-size: 0.74rem; color: var(--slate-dark);"><?= htmlspecialchars((string) ($p['category_label'] ?? ''), ENT_QUOTES, 'UTF-8') ?></span>
                        </div>

                        <h3 class="cpc-minimal-title">
                            <a href="<?= $detailUrl ?>"
                                title="<?= htmlspecialchars((string) $p['title'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars((string) $p['title'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </h3>

                        <div class="cpc-minimal-url-row">
                            <?php if ($hasLive): ?>
                                <a href="<?= htmlspecialchars((string) $p['live_url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank"
                                    rel="noopener noreferrer" class="cpc-minimal-url-link" title="Visit Live Production Domain">
                                    <span class="url-protocol">https://</span><span
                                        class="url-domain"><?= htmlspecialchars((string) ($p['mockup_host'] ?? parse_url((string) $p['live_url'], PHP_URL_HOST)), ENT_QUOTES, 'UTF-8') ?></span>
                                    <?= codex_icon('arrow-up-right', 12) ?>
                                </a>
                            <?php else: ?>
                                <span class="cpc-minimal-url-link disabled">
                                    <span class="url-protocol">sandbox://</span><span
                                        class="url-domain"><?= htmlspecialchars((string) ($p['mockup_host'] ?? 'interactive-demo'), ENT_QUOTES, 'UTF-8') ?></span>
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($p['features']) && is_array($p['features'])): ?>
                            <ul class="cpc-minimal-features-list">
                                <?php foreach (array_slice($p['features'], 0, 3) as $feat): ?>
                                    <li>
                                        <span class="cpc-feat-dot" aria-hidden="true">&bull;</span>
                                        <span><?= htmlspecialchars((string) $feat, ENT_QUOTES, 'UTF-8') ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <div class="cpc-footer" style="display: flex; gap: 0.5rem;">
                        <a href="<?= $detailUrl ?>" class="cpc-btn cpc-btn-secondary" style="flex: 1;">Specs &amp; Story</a>
                        <?php if ($typeKey === 'concept' && !empty($p['demo_key'])): ?>
                            <button type="button" class="cpc-btn cpc-btn-primary btn-demo-trigger"
                                data-demo="<?= htmlspecialchars((string) $p['demo_key'], ENT_QUOTES, 'UTF-8') ?>"
                                style="flex: 1;">Launch Demo</button>
                        <?php elseif ($hasLive): ?>
                            <a href="<?= htmlspecialchars((string) $p['live_url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank"
                                rel="noopener noreferrer" class="cpc-btn cpc-btn-primary" style="flex: 1;">Live Site &nearr;</a>
                        <?php else: ?>
                            <a href="<?= $detailUrl ?>" class="cpc-btn cpc-btn-primary" style="flex: 1;">View Details &rarr;</a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section"
    style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container" style="text-align: center;">
        <div style="max-width: 680px; margin: 0 auto;">
            <span class="tag-chip"
                style="margin-bottom: 1rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Case
                Studies</span>
            <h3 style="font-size: 1.75rem; color: var(--white); margin-bottom: 0.85rem;">Dive Deeper Into Architectural
                Decisions</h3>
            <p style="font-size: 0.98rem; color: var(--slate); line-height: 1.65; margin-bottom: 1.75rem;">
                Read problem-solution breakdowns across institutional ERPs, clinical scheduling, B2B wholesale ordering,
                and automated lead intake.
            </p>
            <a href="<?= url('case-studies.php') ?>" class="btn btn-primary">Read Case Studies &rarr;</a>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Scope Your Custom Software Project?";
$ctaSubtitle = "Schedule a discovery session to discuss architecture, features, and practical milestone planning.";
include __DIR__ . '/components/cta.php';
include __DIR__ . '/components/demo-modal.php';
require_once __DIR__ . '/includes/footer.php';
