<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Mobile Application Development — iOS & Android',
    'description' => 'Cross-platform mobile apps for businesses and enterprises. Offline-first architectures, push notifications, native performance, and seamless API sync.',
    'canonical' => url('mobile-apps.php'),
    'keywords' => 'mobile app development, iOS apps, Android apps, cross-platform apps, enterprise mobile apps'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Mobile Engineering</span>
            </div>
            <h1 class="section-title">Performant Mobile Apps for Field, Team & Customers</h1>
            <p class="section-subtitle">
                Put your business in your customers' and team's hands with cross-platform iOS and Android applications engineered for speed, offline resilience, and delightful UX.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- 1. Cross Platform -->
            <div class="card">
                <div class="card-icon">📱</div>
                <h2 class="card-title">Cross-Platform Efficiency</h2>
                <p class="card-description">
                    Ship to both Apple App Store and Google Play from a single shared codebase without sacrificing smooth 60fps animations or native device features.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">iOS & Android</span>
                    <span class="tag-chip">Single Codebase</span>
                    <span class="tag-chip">50% Lower TCO</span>
                </div>
            </div>

            <!-- 2. Offline-First Architecture -->
            <div class="card">
                <div class="card-icon">📶</div>
                <h2 class="card-title">Offline-First Resilience</h2>
                <p class="card-description">
                    Field workers and drivers can log status updates, scan barcodes, and capture signatures even without an internet connection. Data automatically reconciles when back online.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Local SQLite</span>
                    <span class="tag-chip">Background Sync</span>
                    <span class="tag-chip">Conflict Resolution</span>
                </div>
            </div>

            <!-- 3. Push Notifications & Alerts -->
            <div class="card">
                <div class="card-icon">🔔</div>
                <h2 class="card-title">Targeted Push Notifications</h2>
                <p class="card-description">
                    Engage users with transactional order updates, urgent operational alerts, and location-aware reminders delivered reliably with Firebase Cloud Messaging.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">FCM / APNs</span>
                    <span class="tag-chip">Deep Linking</span>
                    <span class="tag-chip">Segmentation</span>
                </div>
            </div>

            <!-- 4. Enterprise Security -->
            <div class="card">
                <div class="card-icon">🔒</div>
                <h2 class="card-title">Biometric & Token Security</h2>
                <p class="card-description">
                    Protect sensitive corporate data using FaceID / TouchID authentication, encrypted local storage, certificate pinning, and short-lived JWT authorization tokens.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Biometrics</span>
                    <span class="tag-chip">Encrypted Keychain</span>
                    <span class="tag-chip">Remote Wipe Ready</span>
                </div>
            </div>

            <!-- 5. Camera & Hardware Integration -->
            <div class="card">
                <div class="card-icon">📷</div>
                <h2 class="card-title">Hardware & Sensor Hooks</h2>
                <p class="card-description">
                    Leverage on-device hardware including GPS location tracking, barcode/QR scanning, Bluetooth peripherals, thermal printers, and live camera feeds.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Camera & OCR</span>
                    <span class="tag-chip">Geolocation</span>
                    <span class="tag-chip">Bluetooth / NFC</span>
                </div>
            </div>

            <!-- 6. Store Submission & Maintenance -->
            <div class="card">
                <div class="card-icon">🚀</div>
                <h2 class="card-title">End-to-End Store Publishing</h2>
                <p class="card-description">
                    We manage the entire submission lifecycle: developer accounts, App Store Review guidelines compliance, privacy declarations, screenshot generation, and post-launch updates.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">App Store Review</span>
                    <span class="tag-chip">Play Console</span>
                    <span class="tag-chip">Crash Reporting</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Have a mobile app concept ready to build?";
$ctaSubtitle = "Let's review your target users, features, and release timeline to build a lean, high-performance mobile application.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
