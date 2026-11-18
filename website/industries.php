<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Industry-Specific Technology & Automation Solutions',
    'description' => 'Explore how CodeX404 Solutions engineering capabilities map to specific operational challenges across Education, B2B Commerce, Logistics, Legal, and Healthcare.',
    'canonical' => url('industries.php'),
    'keywords' => 'industries software, logistics automation, education ERP, professional services software, e-commerce engineering, healthcare patient portals'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="section" style="padding-top: calc(var(--nav-height) + 3rem); padding-bottom: 3.5rem;">
    <div class="container">
        <div class="section-header" style="max-width: 860px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Vertical Engineering Capabilities</span>
            </div>
            <h1 class="section-title" style="font-size: clamp(2.25rem, 4vw, 3.25rem); line-height: 1.15; margin-bottom: 1.25rem;">
                Engineered for Your Industry's <span class="gradient-text gradient-text-animated">Operational Realities</span>
            </h1>
            <p class="section-subtitle" style="font-size: 1.1rem; line-height: 1.7; color: var(--slate); max-width: 740px; margin: 0 auto;">
                While business models vary across sectors, the fundamental operational friction — manual spreadsheet transcription, disconnected software, and lost lead revenue — is universal. Here is how we apply our defensive engineering to specific verticals.
            </p>
        </div>

        <div class="grid grid-cols-3" style="gap: 2rem;">
            <!-- 1. Education & Institutions -->
            <div class="card card-tilt reveal-on-scroll" id="industry-education">
                <div class="card-icon">🎓</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Education & EdTech</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Replace fragile paper registers and disconnected spreadsheets with custom institutional ERPs, digital student archives, fee collection pipelines, and automated WhatsApp parent alerts.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">School ERP Systems</span>
                    <span class="tag-chip">Automated Fee Invoicing</span>
                    <span class="tag-chip">Granular RBAC</span>
                    <span class="tag-chip">Attendance & Grades</span>
                </div>
            </div>

            <!-- 2. B2B Commerce & Wholesale Distribution -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1" id="industry-commerce">
                <div class="card-icon">🛒</div>
                <h2 class="card-title">B2B Commerce & Wholesale</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Synchronize multi-warehouse inventories with atomic row-locking, automate bulk tier-discount pricing, and eliminate order disputes with instant GST invoice generation.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Tiered Volume Pricing</span>
                    <span class="tag-chip">Atomic Inventory Locks</span>
                    <span class="tag-chip">GST Invoicing</span>
                    <span class="tag-chip">Stripe / Razorpay</span>
                </div>
            </div>

            <!-- 3. Professional & Legal Services -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2" id="industry-legal">
                <div class="card-icon">⚖️</div>
                <h2 class="card-title">Legal & Professional Services</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Explore document search and review workflows with access, hosting, and data handling requirements defined for the systems and information involved.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Confidential Document RAG</span>
                    <span class="tag-chip">Qdrant Vector DB</span>
                    <span class="tag-chip">Client Portals</span>
                    <span class="tag-chip">Audit Trails</span>
                </div>
            </div>

            <!-- 4. Logistics & Supply Chain -->
            <div class="card card-tilt reveal-on-scroll" id="industry-logistics">
                <div class="card-icon">🚚</div>
                <h2 class="card-title">Logistics & Field Dispatch</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Empower drivers, dispatchers, and warehouse teams with offline-first mobile apps, real-time shipment status webhooks, barcode scanning, and electronic proof-of-delivery receipts.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Offline SQLite Apps</span>
                    <span class="tag-chip">Dispatch Scheduling</span>
                    <span class="tag-chip">Barcode / QR Scanning</span>
                    <span class="tag-chip">Live Geolocation</span>
                </div>
            </div>

            <!-- 5. Real Estate & Property Management -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1" id="industry-realestate">
                <div class="card-icon">🏢</div>
                <h2 class="card-title">Real Estate & Property Portals</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Streamline tenant applications, rent collection reminders, maintenance ticketing queues, and multi-channel lead follow-ups over WhatsApp and SMS automatically.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Tenant Portals</span>
                    <span class="tag-chip">Automated Rent Alerts</span>
                    <span class="tag-chip">Maintenance Queues</span>
                    <span class="tag-chip">WhatsApp Ingestion</span>
                </div>
            </div>

            <!-- 6. Healthcare & Clinical Operations -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2" id="industry-healthcare">
                <div class="card-icon">🩺</div>
                <h2 class="card-title">Healthcare & Clinic Operations</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Deploy privacy-first patient booking portals, automated appointment reminder pipelines, and encrypted medical record systems compliant with international data privacy standards.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Encrypted Booking</span>
                    <span class="tag-chip">Appointment Reminders</span>
                    <span class="tag-chip">Data protection scoped to requirements</span>
                    <span class="tag-chip">GDPR / HIPAA Alignment</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LIVE DEMO SANDBOX BANNER -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container" style="text-align: center;">
        <div style="max-width: 680px; margin: 0 auto;">
            <span class="tag-chip" style="margin-bottom: 1rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">In-Browser Testing</span>
            <h3 style="font-size: 1.85rem; color: var(--white); margin-bottom: 1rem;">Test Real Industry Systems in Our Sandbox</h3>
            <p style="font-size: 1rem; color: var(--slate); line-height: 1.6; margin-bottom: 2rem;">
                Explore working demonstrations of our School ERP management console, B2B wholesale ordering portal, and WhatsApp Cloud API lead pipeline directly in your browser.
            </p>
            <a href="<?= url('index.php#projects') ?>" class="btn btn-primary" style="padding: 0.9rem 2.25rem;">Explore Live Project Demos ⚡</a>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Have a Specific Vertical Challenge to Solve?";
$ctaSubtitle = "Let's review your exact operational workflows, regulatory compliance, and system requirements during a structured discovery session.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
