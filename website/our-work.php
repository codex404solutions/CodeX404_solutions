<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/app/Services/ProjectService.php';

use App\Services\ProjectService;

$pageMeta = [
    'title' => 'Our Work | Web Development & Digital Projects | CodeX404 Solutions',
    'description' => 'Explore our portfolio of custom web platforms, institutional ERPs, high-converting e-commerce engines, and AI systems delivered for clients and enterprises.',
    'canonical' => url('our-work.php'),
    'keywords' => 'our work, portfolio, web development projects, custom software portfolio, client case studies, CodeX404 deliverables'
];

$projects = ProjectService::getActive();
$totalCount = count($projects);

// Category count computations
$countAll = $totalCount;
$countEducation = count(array_filter($projects, fn($p) => ($p['category'] ?? '') === 'software'));
$countBooking = count(array_filter($projects, fn($p) => ($p['category'] ?? '') === 'booking'));
$countCommerce = count(array_filter($projects, fn($p) => ($p['category'] ?? '') === 'commerce'));
$countMobile = count(array_filter($projects, fn($p) => ($p['category'] ?? '') === 'mobile'));
$countAi = count(array_filter($projects, fn($p) => ($p['category'] ?? '') === 'ai'));

require_once __DIR__ . '/includes/header.php';
?>

<!-- ==========================================================================
     OUR WORK HERO / HEADER SECTION (NetNovaz-Inspired)
     ========================================================================== -->
<section class="our-work-hero-section">
    <div class="container">
        <div class="our-work-hero-inner">
            <nav class="our-work-breadcrumb" aria-label="breadcrumb">
                <a href="<?= url('index.php') ?>">Home</a>
                <span style="color: rgba(255, 255, 255, 0.25);">/</span>
                <span>Our Work</span>
            </nav>
            <h1 class="our-work-hero-title">OUR WORK</h1>
            <p class="our-work-hero-subtitle">
                Explore our portfolio of custom web platforms, institutional portals, high-speed commerce engines, and intelligent systems engineered for startups, institutions, and growing businesses.
            </p>

            <!-- Category Filter Tabs -->
            <div class="our-work-filters" role="tablist" aria-label="Portfolio Categories">
                <button type="button" class="our-work-filter-btn active" data-filter="all">
                    All Work (<?= $countAll ?>)
                </button>
                <button type="button" class="our-work-filter-btn" data-filter="software">
                    Institutional &amp; ERP (<?= $countEducation ?>)
                </button>
                <button type="button" class="our-work-filter-btn" data-filter="booking">
                    Booking &amp; Healthcare (<?= $countBooking ?>)
                </button>
                <button type="button" class="our-work-filter-btn" data-filter="commerce">
                    E-Commerce &amp; Retail (<?= $countCommerce ?>)
                </button>
                <?php if ($countMobile > 0): ?>
                <button type="button" class="our-work-filter-btn" data-filter="mobile">
                    Mobile &amp; PWA (<?= $countMobile ?>)
                </button>
                <?php endif; ?>
                <?php if ($countAi > 0): ?>
                <button type="button" class="our-work-filter-btn" data-filter="ai">
                    AI &amp; Automation (<?= $countAi ?>)
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     PORTFOLIO GRID SHOWCASE SECTION
     ========================================================================== -->
<section class="our-work-grid-section">
    <div class="container">
        <div class="our-work-grid" id="portfolioGrid">
            <?php foreach ($projects as $index => $p): ?>
                <?php
                $cat = htmlspecialchars($p['category'] ?? 'software');
                $title = htmlspecialchars($p['title'] ?? 'Platform Deliverable');
                $liveUrl = htmlspecialchars($p['live_url'] ?? '');
                $targetUrl = !empty($liveUrl) ? $liveUrl : url('portfolio.php#project-' . urlencode($p['id']));
                $isExternal = !empty($liveUrl);
                $mockupHost = htmlspecialchars($p['mockup_host'] ?? (!empty($liveUrl) ? parse_url($liveUrl, PHP_URL_HOST) : 'app.codex404solutions.online'));
                $isHidden = ($index >= 9); // Initial 9 visible, remaining revealed via Load More

                $artClass = match($cat) {
                    'booking' => 'art-booking',
                    'commerce' => 'art-commerce',
                    'mobile' => 'art-enterprise',
                    'ai' => 'art-enterprise',
                    default => 'art-education'
                };

                $catIcon = match($cat) {
                    'booking' => '🏥',
                    'commerce' => '🛍️',
                    'mobile' => '📱',
                    'ai' => '🤖',
                    default => '🎓'
                };

                $categoryBadge = htmlspecialchars($p['category_label'] ?? ucfirst($cat));
                $screenshotUrl = \App\Services\ProjectService::getScreenshotUrl($p);
                ?>
                <article class="work-card <?= $isHidden ? 'is-hidden' : '' ?>" data-category="<?= $cat ?>">
                    <a href="<?= $targetUrl ?>" <?= $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' ?> class="work-card-media" aria-label="Visit <?= $title ?> project">
                        <?php if (!empty($screenshotUrl)): ?>
                            <img src="<?= htmlspecialchars($screenshotUrl) ?>" alt="<?= $title ?>" class="work-card-img" loading="lazy"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="work-card-placeholder <?= $artClass ?>" style="display: none;">
                                <div class="work-preview-bar">
                                    <div class="work-preview-dots">
                                        <span class="dot-red"></span>
                                        <span class="dot-yellow"></span>
                                        <span class="dot-green"></span>
                                    </div>
                                    <span class="work-preview-host font-mono">🔒 <?= $mockupHost ?></span>
                                </div>
                                <div class="work-preview-center">
                                    <span class="work-preview-icon"><?= $catIcon ?></span>
                                    <span class="work-preview-title"><?= $title ?></span>
                                    <span class="work-preview-chip"><?= $categoryBadge ?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.68rem; color: #64748B;">
                                    <span>Production Live</span>
                                    <span>Sub-0.8s TTFB</span>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Dynamic High-Fidelity Browser Mockup Preview -->
                            <div class="work-card-placeholder <?= $artClass ?>">
                                <div class="work-preview-bar">
                                    <div class="work-preview-dots">
                                        <span class="dot-red"></span>
                                        <span class="dot-yellow"></span>
                                        <span class="dot-green"></span>
                                    </div>
                                    <span class="work-preview-host font-mono">🔒 <?= $mockupHost ?></span>
                                </div>
                                <div class="work-preview-center">
                                    <span class="work-preview-icon"><?= $catIcon ?></span>
                                    <span class="work-preview-title"><?= $title ?></span>
                                    <span class="work-preview-chip"><?= $categoryBadge ?></span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.68rem; color: #64748B;">
                                    <span>Production Live</span>
                                    <span>Sub-0.8s TTFB</span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="work-card-overlay">
                            <span class="work-card-view-btn">
                                <span>Visit Live Site</span>
                                <svg width="12" height="12" viewBox="0 0 16 16" fill="currentColor">
                                    <path fill-rule="evenodd" d="M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0v-6z"/>
                                </svg>
                            </span>
                        </div>
                    </a>

                    <div class="work-card-content">
                        <div class="work-card-title-row">
                            <h2 class="work-card-title">
                                <a href="<?= $targetUrl ?>" <?= $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>
                                    <?= $title ?>
                                </a>
                            </h2>
                            <a href="<?= $targetUrl ?>" <?= $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' ?> class="work-card-arrow-icon" aria-label="Open <?= $title ?> link">
                                <svg width="12" height="12" viewBox="0 0 16 16" fill="currentColor">
                                    <path fill-rule="evenodd" d="M14 2.5a.5.5 0 0 0-.5-.5h-6a.5.5 0 0 0 0 1h4.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V8.5a.5.5 0 0 0 1 0v-6z"/>
                                </svg>
                            </a>
                        </div>
                        <div class="work-card-tags">
                            <span class="work-tag-badge">Development</span>
                            <span class="work-tag-badge"><?= $categoryBadge ?></span>
                            <?php if (!empty($p['tags']) && is_array($p['tags'])): ?>
                                <?php foreach (array_slice($p['tags'], 0, 1) as $extraTag): ?>
                                    <span class="work-tag-badge"><?= htmlspecialchars($extraTag) ?></span>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php if ($totalCount > 9): ?>
        <!-- Load More Controller -->
        <div class="our-work-loadmore-wrap" id="loadMoreWrap">
            <button type="button" class="btn btn-primary our-work-loadmore-btn" id="loadMoreBtn">
                <span>Load More Work ↓</span>
            </button>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ==========================================================================
     START YOUR PROJECT CTA
     ========================================================================== -->
<section class="section" style="background: rgba(10, 22, 40, 0.6); border-top: 1px solid var(--border-subtle); padding: 5rem 0; text-align: center;">
    <div class="container" style="max-width: 800px;">
        <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
            <span class="dot"></span>
            <span>Let's Build Together</span>
        </div>
        <h2 style="font-size: clamp(2rem, 3.5vw, 2.75rem); line-height: 1.25; margin-bottom: 1.25rem;">
            Ready to engineer software that <span class="text-gradient gradient-text-animated">actually scales?</span>
        </h2>
        <p style="font-size: 1.05rem; line-height: 1.7; color: var(--slate); margin-bottom: 2rem;">
            Direct access to senior architects. Fixed-scope estimates with no hidden licensing fees or vendor lock-in.
        </p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-lg">
                <span>Book a Discovery Call 📅</span>
            </a>
            <a href="<?= url('contact.php') ?>" class="btn btn-secondary btn-lg">
                <span>Start a Project Inquiry &rarr;</span>
            </a>
        </div>
    </div>
</section>

<!-- Interactive Script for Category Filtering & Load More -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterBtns = document.querySelectorAll('.our-work-filter-btn');
    const cards = document.querySelectorAll('#portfolioGrid .work-card');
    const loadMoreBtn = document.getElementById('loadMoreBtn');
    const loadMoreWrap = document.getElementById('loadMoreWrap');

    // 1. Filter handler
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filterValue = this.getAttribute('data-filter');

            cards.forEach(card => {
                const cardCat = card.getAttribute('data-category');
                if (filterValue === 'all' || cardCat === filterValue) {
                    card.classList.remove('is-hidden');
                    card.classList.add('card-revealing');
                } else {
                    card.classList.add('is-hidden');
                }
            });

            // When a category filter is active, hide the general load more button
            if (loadMoreWrap) {
                if (filterValue === 'all') {
                    // Check if any card has is-hidden naturally
                    loadMoreWrap.classList.remove('is-hidden');
                } else {
                    loadMoreWrap.classList.add('is-hidden');
                }
            }
        });
    });

    // 2. Load More handler
    if (loadMoreBtn && loadMoreWrap) {
        loadMoreBtn.addEventListener('click', function () {
            const hiddenCards = document.querySelectorAll('#portfolioGrid .work-card.is-hidden');
            hiddenCards.forEach((card, idx) => {
                setTimeout(() => {
                    card.classList.remove('is-hidden');
                    card.classList.add('card-revealing');
                }, idx * 60);
            });

            loadMoreWrap.classList.add('is-hidden');
        });
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
