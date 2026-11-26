<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Google Search & SEO — Get Found Online | CodeX404 Solutions',
    'description' => 'Practical search engine optimization (SEO) that helps customers find your business easily on Google and AI search tools.',
    'canonical' => url('seo-visibility.php'),
    'keywords' => 'SEO services, Google search ranking, local business SEO, website visibility, technical SEO made simple'
];

require_once __DIR__ . '/includes/header.php';

$heroTag = 'GROW · Search & Visibility';
$heroTitleHtml = 'Help Customers Find You First <span class="text-amber">on Google Search</span>';
$heroSubtitle = 'Even a great website struggles if buyers cannot find it. We fix speed issues, organize your pages clearly, and target real customer searches so more ready-to-buy visitors reach your site naturally.';
$heroActions = [
    ['label' => 'Request a Website Checkup', 'url' => url('discovery-call.php') . '?division=GROW', 'variant' => 'primary'],
    ['label' => 'Explore Digital Ads', 'url' => url('digital-ads.php'), 'variant' => 'secondary'],
];
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-grow"><?= codex_icon('search', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Clear Service Keywords</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    We match your pages with the exact words your real customers type when looking to buy, instead of guessing jargon nobody searches for.
                </p>
                <div class="card-tags"><span class="tag-chip">Buyer Keywords</span><span class="tag-chip">Service Pages</span><span class="tag-chip">Clear Topics</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-grow"><?= codex_icon('zap', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Clean Website Health</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    We fix slow loading, broken links, missing page titles, and mobile layout glitches so Google and visitors both trust your website.
                </p>
                <div class="card-tags"><span class="tag-chip">Fast Pages</span><span class="tag-chip">Mobile Friendly</span><span class="tag-chip">Zero Broken Links</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-grow"><?= codex_icon('globe', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Local &amp; Map Visibility</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Show up when nearby customers search in your city by aligning your website location details, schema tags, and Google Business profile.
                </p>
                <div class="card-tags"><span class="tag-chip">Local Search</span><span class="tag-chip">Google Business</span><span class="tag-chip">Structured Info</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-grow"><?= codex_icon('file', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Helpful Buying Guides</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    We organize clear answers to common customer questions so both Google Search and AI assistants recommend your business as a trusted source.
                </p>
                <div class="card-tags"><span class="tag-chip">Clear FAQs</span><span class="tag-chip">AI Search Ready</span><span class="tag-chip">Plain Language</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-grow"><?= codex_icon('link', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Clean Page Structure</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Logical menus, short descriptive web addresses, and helpful internal links make it effortless for customers and search engines to explore your site.
                </p>
                <div class="card-tags"><span class="tag-chip">Simple Menus</span><span class="tag-chip">Clean URLs</span><span class="tag-chip">Site Maps</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-grow"><?= codex_icon('chart', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Simple Progress Tracking</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Track real inquiries, calls, and top-performing search pages in plain monthly summaries—no confusing vanity spreadsheets.
                </p>
                <div class="card-tags"><span class="tag-chip">Search Console</span><span class="tag-chip">Lead Tracking</span><span class="tag-chip">Clear Reports</span></div>
            </article>
        </div>
    </div>
</section>

<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 780px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;"><span class="dot"></span><span>What Improves First</span></div>
            <h2 class="section-title subpage-section-title">How Better Search Visibility <span class="text-amber">Helps Your Business</span></h2>
            <p class="section-subtitle">Steady, lasting customer inquiries without relying solely on paying for every single click.</p>
        </div>

        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll">
                <h3 style="font-size: 1.12rem; color: var(--white); margin-bottom: 0.6rem;">Lower Ad Reliance</h3>
                <p style="font-size: 0.9rem; color: var(--slate); line-height: 1.65; margin: 0;">Free organic search clicks keep bringing leads long after each page improvement is published.</p>
            </article>
            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <h3 style="font-size: 1.12rem; color: var(--white); margin-bottom: 0.6rem;">Better-Fit Visitors</h3>
                <p style="font-size: 0.9rem; color: var(--slate); line-height: 1.65; margin: 0;">People searching specifically for your exact service are already looking to solve a real problem.</p>
            </article>
            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <h3 style="font-size: 1.12rem; color: var(--white); margin-bottom: 0.6rem;">Stronger Credibility</h3>
                <p style="font-size: 0.9rem; color: var(--slate); line-height: 1.65; margin: 0;">Fast, well-organized websites earn higher buyer confidence from the very first click.</p>
            </article>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Want More Customers Finding You on Google?";
$ctaSubtitle = "Share your website address and target services. We will show you the clearest opportunities to grow organic traffic.";
$ctaPrimaryText = "Book a Discovery Call";
$ctaPrimaryUrl = url('discovery-call.php') . '?division=GROW';
$ctaSecondaryText = "Explore All GROW Services";
$ctaSecondaryUrl = url('grow.php');
require __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
?>
