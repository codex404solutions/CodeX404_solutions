<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/app/Services/ProjectService.php';

use App\Services\ProjectService;

$pageMeta = [
    'title' => 'Our Work — Client Systems, Platforms & Interactive Concepts | CodeX404 Solutions',
    'description' => 'Explore shipped client websites and portals, CodeX404 internal platforms, and interactive software concepts across custom ERPs, commerce, and booking systems.',
    'canonical' => url('our-work.php'),
    'keywords' => 'CodeX404 portfolio, web development projects, custom software deliverables, institutional ERPs, interactive demos'
];

$projects = ProjectService::getActive();
$totalCount = count($projects);

$countClient = count(array_filter($projects, fn($p) => ($p['project_type'] ?? 'client') === 'client'));
$countInternal = count(array_filter($projects, fn($p) => ($p['project_type'] ?? '') === 'internal'));
$countConcept = count(array_filter($projects, fn($p) => ($p['project_type'] ?? '') === 'concept'));

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Our Work'],
];
$heroTag = 'Completed Projects · Internal Platforms · Concepts';
$heroTitleHtml = 'Selected Work &amp; <span class="text-gradient gradient-text-animated">Software Systems</span>';
$heroSubtitle = 'A transparent catalog distinguishing live client builds, internal platforms operated by CodeX404, and interactive concepts built to demonstrate domain workflows.';
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="our-work-grid-section" style="padding-top: 2.5rem;">
    <div class="container">
        <!-- Clear Project Classification Filter Tabs -->
        <div class="our-work-filters" role="tablist" aria-label="Filter projects by classification" style="margin-bottom: 2.5rem;">
            <button type="button" class="our-work-filter-btn active" data-type-filter="all">All Work (<?= $totalCount ?>)</button>
            <button type="button" class="our-work-filter-btn" data-type-filter="client">Completed Client Projects (<?= $countClient ?>)</button>
            <button type="button" class="our-work-filter-btn" data-type-filter="internal">Internal Platforms (<?= $countInternal ?>)</button>
            <button type="button" class="our-work-filter-btn" data-type-filter="concept">Interactive Concepts (<?= $countConcept ?>)</button>
        </div>

        <div class="our-work-grid" id="portfolioGrid">
            <?php foreach ($projects as $index => $p): ?>
                <?php
                $typeKey = $p['project_type'] ?? 'client';
                $typeLabel = match ($typeKey) {
                    'internal' => 'Internal Platform',
                    'concept' => 'Interactive Concept',
                    'open_source' => 'Open Source',
                    default => 'Client Project',
                };
                $typeStatusClass = match ($typeKey) {
                    'internal' => 'status-pill-dev',
                    'concept' => 'status-pill-soon',
                    default => 'status-pill-live',
                };
                $cat = htmlspecialchars((string)($p['category'] ?? 'software'), ENT_QUOTES, 'UTF-8');
                $title = htmlspecialchars((string)($p['title'] ?? 'Platform Deliverable'), ENT_QUOTES, 'UTF-8');
                $liveUrl = trim((string)($p['live_url'] ?? ''));
                $detailUrl = url('project.php?id=' . urlencode((string)$p['id']));
                $targetUrl = $liveUrl !== '' ? htmlspecialchars($liveUrl, ENT_QUOTES, 'UTF-8') : $detailUrl;
                $isExternal = ($liveUrl !== '');
                $mockupHost = htmlspecialchars((string)($p['mockup_host'] ?? ($isExternal ? parse_url($liveUrl, PHP_URL_HOST) : 'app.codex404solutions.online')), ENT_QUOTES, 'UTF-8');
                $isHidden = ($index >= 9);

                $artClass = match ($cat) {
                    'booking' => 'art-booking',
                    'commerce' => 'art-commerce',
                    'mobile', 'ai' => 'art-enterprise',
                    default => 'art-education'
                };
                $iconKey = match ($cat) {
                    'booking' => 'calendar',
                    'commerce' => 'cart',
                    'mobile' => 'smartphone',
                    'ai' => 'bot',
                    default => 'code'
                };
                $categoryBadge = htmlspecialchars((string)($p['category_label'] ?? ucfirst($cat)), ENT_QUOTES, 'UTF-8');
                $screenshotUrl = \App\Services\ProjectService::getScreenshotUrl($p);
                ?>
                <article class="work-card <?= $isHidden ? 'is-hidden' : '' ?>" data-category="<?= $cat ?>" data-type="<?= htmlspecialchars($typeKey, ENT_QUOTES, 'UTF-8') ?>">
                    <a href="<?= $detailUrl ?>" class="work-card-media" aria-label="View details for <?= $title ?>">
                        <?php if (!empty($screenshotUrl)): ?>
                            <img src="<?= htmlspecialchars($screenshotUrl, ENT_QUOTES, 'UTF-8') ?>" alt="<?= $title ?>" class="work-card-img" loading="lazy"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="work-card-placeholder <?= $artClass ?>" style="display: none;">
                                <div class="work-preview-bar">
                                    <div class="work-preview-dots"><span class="dot-red"></span><span class="dot-yellow"></span><span class="dot-green"></span></div>
                                    <span class="work-preview-host font-mono"><?= $mockupHost ?></span>
                                </div>
                                <div class="work-preview-center">
                                    <span class="inline-icon-box" style="margin-bottom: 0.4rem;"><?= codex_icon($iconKey, 20) ?></span>
                                    <span class="work-preview-title"><?= $title ?></span>
                                    <span class="work-preview-chip"><?= $categoryBadge ?></span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="work-card-placeholder <?= $artClass ?>">
                                <div class="work-preview-bar">
                                    <div class="work-preview-dots"><span class="dot-red"></span><span class="dot-yellow"></span><span class="dot-green"></span></div>
                                    <span class="work-preview-host font-mono"><?= $mockupHost ?></span>
                                </div>
                                <div class="work-preview-center">
                                    <span class="inline-icon-box" style="margin-bottom: 0.4rem;"><?= codex_icon($iconKey, 20) ?></span>
                                    <span class="work-preview-title"><?= $title ?></span>
                                    <span class="work-preview-chip"><?= $categoryBadge ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="work-card-overlay">
                            <span class="work-card-view-btn">
                                <span>View Project Details</span>
                                <?= codex_icon('arrow-right', 13) ?>
                            </span>
                        </div>
                    </a>

                    <div class="work-card-content">
                        <div style="margin-bottom: 0.5rem;">
                            <span class="status-pill <?= $typeStatusClass ?>"><?= htmlspecialchars($typeLabel, ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                        <div class="work-card-title-row">
                            <h2 class="work-card-title">
                                <a href="<?= $detailUrl ?>"><?= $title ?></a>
                            </h2>
                            <a href="<?= $targetUrl ?>" <?= $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' ?> class="work-card-arrow-icon" aria-label="<?= $isExternal ? 'Visit live site for ' . $title : 'Open details for ' . $title ?>">
                                <?= codex_icon($isExternal ? 'arrow-up-right' : 'arrow-right', 14) ?>
                            </a>
                        </div>
                        <div class="work-card-tags">
                            <span class="work-tag-badge"><?= $categoryBadge ?></span>
                            <?php if (!empty($p['tags']) && is_array($p['tags'])): ?>
                                <?php foreach (array_slice($p['tags'], 0, 2) as $extraTag): ?>
                                    <span class="work-tag-badge"><?= htmlspecialchars((string)$extraTag, ENT_QUOTES, 'UTF-8') ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php if ($totalCount > 9): ?>
        <div class="our-work-loadmore-wrap" id="loadMoreWrap">
            <button type="button" class="btn btn-primary our-work-loadmore-btn" id="loadMoreBtn">
                <span>Load More Work</span>
            </button>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php
$ctaHeading = "Ready to Discuss a Similar Build for Your Business?";
$ctaSubtitle = "Review deliverables, scope options, and timelines directly with our engineering team.";
$ctaSecondaryText = "Explore Interactive Portfolio";
$ctaSecondaryUrl = url('portfolio.php');
include __DIR__ . '/components/cta.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterBtns = document.querySelectorAll('.our-work-filter-btn[data-type-filter]');
    const cards = document.querySelectorAll('#portfolioGrid .work-card');
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const loadMoreWrap = document.getElementById('loadMoreWrap');

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const filterValue = this.getAttribute('data-type-filter');

            cards.forEach((card, idx) => {
                const cardType = card.getAttribute('data-type');
                if (filterValue === 'all') {
                    card.classList.toggle('is-hidden', idx >= 9 && loadMoreWrap && !loadMoreWrap.classList.contains('is-done'));
                } else if (cardType === filterValue) {
                    card.classList.remove('is-hidden');
                } else {
                    card.classList.add('is-hidden');
                }
            });

            if (loadMoreWrap && !loadMoreWrap.classList.contains('is-done')) {
                loadMoreWrap.classList.toggle('is-hidden', filterValue !== 'all');
            }
        });
    });

    if (loadMoreBtn && loadMoreWrap) {
        loadMoreBtn.addEventListener('click', function () {
            document.querySelectorAll('#portfolioGrid .work-card.is-hidden').forEach(c => c.classList.remove('is-hidden'));
            loadMoreWrap.classList.add('is-hidden', 'is-done');
        });
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
