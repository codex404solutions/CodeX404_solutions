<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Ads & Social Media Campaigns | CodeX404 Solutions',
    'description' => 'Focused Google Ads, social media marketing, and clear ad messaging built to bring qualified customer leads without wasting budget.',
    'canonical' => url('digital-ads.php'),
    'keywords' => 'Google ads management, social media marketing, lead generation ads, business marketing campaigns'
];

require_once __DIR__ . '/includes/header.php';

$heroTag = 'GROW · Ads & Social Media';
$heroTitleHtml = 'Targeted Ads &amp; Social Media That <span class="text-amber">Bring Real Leads</span>';
$heroSubtitle = 'Stop paying for empty clicks or confusing social posts. We set up focused search and social campaigns paired with clear landing messages so your budget goes toward genuine customer inquiries.';
$heroActions = [
    ['label' => 'Plan a Campaign', 'url' => url('discovery-call.php') . '?division=GROW', 'variant' => 'primary'],
    ['label' => 'Improve Website Conversion', 'url' => url('conversion-optimization.php'), 'variant' => 'secondary'],
];
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-grow"><?= codex_icon('target', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Google Search Ads</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Show your business right when customers are actively searching for your service, with tight location and keyword controls to stop wasted spend.
                </p>
                <div class="card-tags"><span class="tag-chip">High-Intent Searches</span><span class="tag-chip">Budget Control</span><span class="tag-chip">Lead Tracking</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-grow"><?= codex_icon('users', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Social Media Marketing</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Consistent Instagram, Facebook, and LinkedIn posts and paid ads that showcase your real work and build familiarity with your ideal audience.
                </p>
                <div class="card-tags"><span class="tag-chip">Instagram &amp; Meta</span><span class="tag-chip">LinkedIn B2B</span><span class="tag-chip">Consistent Posting</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-grow"><?= codex_icon('file', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Clear Ad &amp; Offer Copy</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Simple, honest headlines and descriptions that explain your service in seconds—written for everyday buyers, not marketing buzzwords.
                </p>
                <div class="card-tags"><span class="tag-chip">Plain English</span><span class="tag-chip">Strong Headlines</span><span class="tag-chip">Clear Calls to Action</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-grow"><?= codex_icon('layers', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Dedicated Ad Landing Pages</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Instead of sending paid clicks to a generic homepage, we build focused landing pages matching the exact promise of your ad.
                </p>
                <div class="card-tags"><span class="tag-chip">Message Match</span><span class="tag-chip">Quick Inquiry Form</span><span class="tag-chip">Mobile First</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-grow"><?= codex_icon('message', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Direct WhatsApp &amp; Form Leads</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Route ad responses directly into WhatsApp, email, or your CRM so your team replies quickly before prospects move on.
                </p>
                <div class="card-tags"><span class="tag-chip">Instant Alerts</span><span class="tag-chip">WhatsApp Intake</span><span class="tag-chip">CRM Sync</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-grow"><?= codex_icon('chart', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Honest Cost-Per-Lead Reports</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    See clearly what you spent, how many real inquiries arrived, and which campaigns deserve more or less budget each month.
                </p>
                <div class="card-tags"><span class="tag-chip">Cost Per Inquiry</span><span class="tag-chip">Transparent Data</span><span class="tag-chip">No Hidden Fees</span></div>
            </article>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Attract Better Customer Inquiries?";
$ctaSubtitle = "Tell us what services you want to promote and your monthly target. We will map a practical ad and content plan.";
$ctaPrimaryText = "Book a Discovery Call";
$ctaPrimaryUrl = url('discovery-call.php') . '?division=GROW';
$ctaSecondaryText = "Explore SEO & Visibility";
$ctaSecondaryUrl = url('seo-visibility.php');
require __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
?>
