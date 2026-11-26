<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Mobile Application Development — iOS, Android & PWAs | CodeX404 Solutions',
    'description' => 'Cross-platform mobile applications and Progressive Web Apps built for field teams and customers with offline resilience, secure auth, and reliable cloud sync.',
    'canonical' => url('mobile-apps.php'),
    'keywords' => 'mobile app development, cross-platform mobile apps, offline-first apps, field service mobile apps, iOS Android development, progressive web apps'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Services', 'url' => url('solutions.php')],
    ['label' => 'Mobile Applications'],
];
$heroTag = 'BUILD · Mobile & Field Operations';
$heroTitleHtml = 'Practical Mobile Apps for <span class="text-gradient">Teams, Field Staff &amp; Customers</span>';
$heroSubtitle = 'Put reliable mobile tools into the hands of customers and field operators—supporting cross-platform iOS/Android deployment, offline queuing, and synchronized backend APIs.';
$heroActions = [
    ['label' => 'Discuss a Mobile App', 'url' => url('discovery-call.php') . '?division=BUILD', 'variant' => 'primary'],
    ['label' => 'Explore Custom Software', 'url' => url('software-development.php'), 'variant' => 'secondary'],
];
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-build"><?= codex_icon('smartphone', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Cross-Platform Delivery</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Target both iOS and Android from a maintainable shared codebase without sacrificing smooth interaction or device compatibility.
                </p>
                <div class="card-tags"><span class="tag-chip">iOS &amp; Android</span><span class="tag-chip">Shared Codebase</span><span class="tag-chip">PWAs</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-build"><?= codex_icon('wifi', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Offline-Resilient Sync</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Field technicians and delivery teams can capture checklists, scan codes, and record status offline, reconciling safely once connectivity returns.
                </p>
                <div class="card-tags"><span class="tag-chip">Local SQLite / Storage</span><span class="tag-chip">Background Sync</span><span class="tag-chip">Conflict Guards</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-build"><?= codex_icon('bell', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Transactional Notifications</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Keep users and operators informed with order updates, booking reminders, and deep-linked alerts via Firebase Cloud Messaging and Apple APNs.
                </p>
                <div class="card-tags"><span class="tag-chip">FCM &amp; APNs</span><span class="tag-chip">Deep Linking</span><span class="tag-chip">Topic Alerts</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-build"><?= codex_icon('lock', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Device &amp; Session Security</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Implement biometric sign-in, encrypted local token storage, and scoped API sessions aligned with your application threat model.
                </p>
                <div class="card-tags"><span class="tag-chip">Biometric Auth</span><span class="tag-chip">Secure Keychain</span><span class="tag-chip">Token Expiry</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-build"><?= codex_icon('target', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Camera &amp; Field Workflows</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Integrate barcode/QR scanning, photo proof capture, location tagging, and document uploads cleanly into daily mobile operations.
                </p>
                <div class="card-tags"><span class="tag-chip">QR / Barcode</span><span class="tag-chip">Location Hooks</span><span class="tag-chip">Photo Uploads</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-build"><?= codex_icon('rocket', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Store Packaging &amp; Releases</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Structured release builds, Apple App Store and Google Play submission preparation, privacy disclosures, and post-launch updates.
                </p>
                <div class="card-tags"><span class="tag-chip">App Store Prep</span><span class="tag-chip">Play Store Release</span><span class="tag-chip">Crash Logging</span></div>
            </article>
        </div>
    </div>
</section>

<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;"><span class="dot"></span><span>Mobile Engineering Focus</span></div>
            <h2 class="section-title">Designed for Real Cellular Networks &amp; Daily Use</h2>
            <p class="section-subtitle">Mobile reliability comes down to lean payloads, responsive states, and forgiving offline behavior.</p>
        </div>

        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <div class="card" style="padding: 2rem;">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">Responsive Feedback</h3>
                <p style="font-size: 0.9rem; line-height: 1.65; color: var(--slate);">Immediate UI feedback with graceful retry queues when cellular signal drops mid-task.</p>
            </div>
            <div class="card" style="padding: 2rem;">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">Battery-Mindful Sync</h3>
                <p style="font-size: 0.9rem; line-height: 1.65; color: var(--slate);">Sensible polling intervals and batched uploads so field devices last through working shifts.</p>
            </div>
            <div class="card" style="padding: 2rem;">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">Lean JSON Payloads</h3>
                <p style="font-size: 0.9rem; line-height: 1.65; color: var(--slate);">Paginated, compressed API responses built specifically around mobile bandwidth constraints.</p>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Have a Mobile App or Field Tool to Scope?";
$ctaSubtitle = "Let's review your target platforms, offline sync needs, and backend APIs in a discovery call.";
include __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
