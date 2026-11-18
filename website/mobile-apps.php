<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Mobile Application Development — iOS, Android & Offline-First PWAs',
    'description' => 'Cross-platform mobile applications engineered for field teams, customer engagement, and distribution. Offline-first architectures, native hardware sensors, biometric auth, and seamless cloud sync.',
    'canonical' => url('mobile-apps.php'),
    'keywords' => 'mobile app development, cross-platform mobile apps, offline-first apps, field service mobile apps, iOS Android development, progressive web apps'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="section" style="padding-top: calc(var(--nav-height) + 3rem); padding-bottom: 3.5rem;">
    <div class="container">
        <div class="section-header" style="max-width: 860px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Mobile Engineering & Field Operations</span>
            </div>
            <h1 class="section-title" style="font-size: clamp(2.25rem, 4vw, 3.25rem); line-height: 1.15; margin-bottom: 1.25rem;">
                Performant Mobile Applications for <span class="gradient-text">Teams, Field & Customers</span>
            </h1>
            <p class="section-subtitle" style="font-size: 1.1rem; line-height: 1.7; color: var(--slate); max-width: 740px; margin: 0 auto;">
                Put your business in your customers' and team's hands with cross-platform iOS and Android applications engineered for silky-smooth 60fps responsiveness, offline-first resilience, and reliable cloud synchronization.
            </p>
        </div>

        <!-- Mobile Capabilities Grid -->
        <div class="grid grid-cols-3" style="gap: 2rem;">
            <!-- 1. Cross-Platform Single Codebase -->
            <div class="card card-tilt reveal-on-scroll">
                <div class="card-icon">📱</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Cross-Platform Efficiency</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Deploy to both Apple App Store and Google Play from a single shared codebase without sacrificing smooth animations or native device platform features, streamlining long-term maintenance.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">iOS & Android</span>
                    <span class="tag-chip">Single Codebase</span>
                    <span class="tag-chip">Native Experience</span>
                    <span class="tag-chip">Unified Maintenance</span>
                </div>
            </div>

            <!-- 2. Offline-First Resilience -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon">📶</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Offline-First Architecture</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Field technicians, inspectors, and delivery drivers can log status updates, scan barcodes, and capture digital signatures even with zero internet. Changes reconcile automatically when connectivity resumes.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Local SQLite / IndexedDB</span>
                    <span class="tag-chip">Background Sync</span>
                    <span class="tag-chip">Conflict Resolution</span>
                    <span class="tag-chip">Data handling requirements</span>
                </div>
            </div>

            <!-- 3. Push Notifications & Alerts -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon">🔔</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Transactional Push Notifications</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Engage users and drivers with real-time transactional order updates, critical operational alerts, and location-aware reminders delivered reliably with Firebase Cloud Messaging (FCM) and Apple APNs.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">FCM & Apple APNs</span>
                    <span class="tag-chip">Deep Linking</span>
                    <span class="tag-chip">User Segmentation</span>
                    <span class="tag-chip">Delivery Telemetry</span>
                </div>
            </div>

            <!-- 4. Biometric & Secure Storage -->
            <div class="card card-tilt reveal-on-scroll">
                <div class="card-icon">🔒</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Biometric & Vault Security</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Mobile security controls such as biometric authentication, encrypted local storage, certificate validation, and short-lived sessions should be selected for the target platform and reviewed against the application threat model.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">FaceID & TouchID</span>
                    <span class="tag-chip">Encrypted Keychain</span>
                    <span class="tag-chip">Certificate Pinning</span>
                    <span class="tag-chip">Remote Wipe Ready</span>
                </div>
            </div>

            <!-- 5. Hardware Sensors & Camera Integration -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon">📷</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Hardware & Sensor Hooks</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Leverage native mobile hardware including GPS live tracking, camera OCR document scanning, barcode & QR readers, Bluetooth Low Energy (BLE) thermal printers, and NFC tags.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">QR & Barcode Scanner</span>
                    <span class="tag-chip">GPS Geolocation</span>
                    <span class="tag-chip">Bluetooth Peripherals</span>
                    <span class="tag-chip">Camera OCR</span>
                </div>
            </div>

            <!-- 6. Store Submission & Maintenance -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon">🚀</div>
                <h2 class="card-title" style="font-size: 1.3rem;">App Store Launch & Governance</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    We manage the entire submission lifecycle: Apple Developer and Google Play account setup, App Store Review guidelines compliance, privacy declarations, screenshot assets, and post-launch updates.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">App Store Review</span>
                    <span class="tag-chip">Play Store Publishing</span>
                    <span class="tag-chip">Privacy Compliance</span>
                    <span class="tag-chip">Crash Telemetry</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MOBILE ARCHITECTURAL EXCELLENCE -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Engineering Standards</span>
            </div>
            <h2 class="section-title">Why Our Mobile Applications Outperform Generic Builds</h2>
            <p class="section-subtitle">
                Mobile engineering demands strict discipline around memory footprint, battery consumption, and unpredictable cellular network conditions.
            </p>
        </div>

        <div class="grid grid-cols-3" style="gap: 2rem;">
            <div class="card card-tilt reveal-on-scroll" style="padding: 2.25rem;">
                <h3 style="color: var(--cyan); font-size: 1.2rem; margin-bottom: 0.75rem;">Optimistic UI Updates</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate);">
                    Interfaces update instantly upon user interaction before network roundtrips complete. If a network packet fails, background workers reconcile state smoothly without freezing the UI.
                </p>
            </div>

            <div class="card card-tilt reveal-on-scroll reveal-delay-1" style="padding: 2.25rem;">
                <h3 style="color: var(--cyan); font-size: 1.2rem; margin-bottom: 0.75rem;">Battery-Conscious Sync</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate);">
                    Geolocation tracking and data polling adapt intelligently to device battery state, Wi-Fi connectivity, and user motion to prevent rapid phone battery drain in the field.
                </p>
            </div>

            <div class="card card-tilt reveal-on-scroll reveal-delay-2" style="padding: 2.25rem;">
                <h3 style="color: var(--cyan); font-size: 1.2rem; margin-bottom: 0.75rem;">Compressed Payload APIs</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate);">
                    Mobile APIs return lightweight, gzip-compressed JSON payloads tailored specifically for mobile viewports, saving cellular data and ensuring fast loading on 3G/4G connections.
                </p>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Have a Mobile Application Concept Ready to Engineer?";
$ctaSubtitle = "Let's review your target user personas, offline requirements, and delivery milestones with our lead mobile architects.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
