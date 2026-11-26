<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Website Speed & Conversion Optimization (CRO) | CodeX404 Solutions',
    'description' => 'Make your website faster, easier to use, and more persuasive so more visitors become calls, inquiries, and customers.',
    'canonical' => url('conversion-optimization.php'),
    'keywords' => 'conversion rate optimization, website speed optimization, improve website leads, landing page optimization'
];

require_once __DIR__ . '/includes/header.php';

$heroTag = 'GROW · Speed & Customer Conversion';
$heroTitleHtml = 'Turn More Website Visitors Into <span class="text-amber">Real Calls &amp; Sales</span>';
$heroSubtitle = 'Traffic alone does not grow revenue if visitors leave confused or stuck on slow pages. We simplify navigation, speed up mobile loading, and make taking the next step effortless.';
$heroActions = [
    ['label' => 'Review Your Website Flow', 'url' => url('discovery-call.php') . '?division=GROW', 'variant' => 'primary'],
    ['label' => 'View Selected Work', 'url' => url('our-work.php'), 'variant' => 'secondary'],
];
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-grow"><?= codex_icon('zap', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Faster Page Loading</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Slow websites lose impatient mobile visitors in seconds. We trim heavy files and optimize images so every page opens smoothly.
                </p>
                <div class="card-tags"><span class="tag-chip">Quick Load Times</span><span class="tag-chip">Image Compression</span><span class="tag-chip">Smooth Scrolling</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-grow"><?= codex_icon('target', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Clear Headlines &amp; Next Steps</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Within 5 seconds of landing, visitors should immediately understand what you offer, who it helps, and how to contact or book with you.
                </p>
                <div class="card-tags"><span class="tag-chip">Simple Messaging</span><span class="tag-chip">Visible Buttons</span><span class="tag-chip">Zero Confusion</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-grow"><?= codex_icon('check', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Shorter, Easier Forms</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Long complicated forms cause visitors to quit halfway. We simplify inquiry and booking steps so finishing takes under a minute on any phone.
                </p>
                <div class="card-tags"><span class="tag-chip">Short Forms</span><span class="tag-chip">Phone Friendly</span><span class="tag-chip">Higher Completion</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-grow"><?= codex_icon('shield', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Trust &amp; Proof Placement</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Place real project examples, process clarity, and clear contact options right beside key decisions so hesitant visitors feel confident reaching out.
                </p>
                <div class="card-tags"><span class="tag-chip">Real Examples</span><span class="tag-chip">Clear Process</span><span class="tag-chip">Buyer Confidence</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-grow"><?= codex_icon('smartphone', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Mobile Layout Fixes</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Fix cramped buttons, awkward text wrapping, and sideways scrolling on phones—where most customers see your business first.
                </p>
                <div class="card-tags"><span class="tag-chip">All Phone Sizes</span><span class="tag-chip">Easy Tap Targets</span><span class="tag-chip">Clean Typography</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-grow"><?= codex_icon('workflow', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Ongoing Maintenance &amp; Care</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Keep your website updated, backed up, and bug-free month after month as your offers, pricing, and team grow.
                </p>
                <div class="card-tags"><span class="tag-chip">Regular Updates</span><span class="tag-chip">Uptime Care</span><span class="tag-chip">Fast Fixes</span></div>
            </article>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Want Your Existing Website to Convert More Leads?";
$ctaSubtitle = "Send us your current site link and we will point out the fastest improvements to boost clarity, speed, and inquiries.";
$ctaPrimaryText = "Book a Discovery Call";
$ctaPrimaryUrl = url('discovery-call.php') . '?division=GROW';
$ctaSecondaryText = "Contact Our Team";
$ctaSecondaryUrl = url('contact.php') . '?division=GROW';
require __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
?>
