<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Industry-Specific Technology & Automation Solutions',
    'description' => 'Explore how CodeX404 Solutions engineering capabilities map to specific operational challenges across Education, Commerce, Logistics, and Professional Services.',
    'canonical' => url('industries.php'),
    'keywords' => 'industries software, logistics automation, education ERP, professional services software, e-commerce engineering'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Vertical Expertise</span>
            </div>
            <h1 class="section-title">Engineered for Your Industry's Operational Realities</h1>
            <p class="section-subtitle">
                While business models differ, the fundamental bottlenecks — manual data entry, disconnected legacy software, and delayed communication — are universal. Here is how we apply our engineering capabilities to solve industry-specific challenges.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- 1. Education & Institutions -->
            <div class="card">
                <div class="card-icon">🎓</div>
                <h2 class="card-title">Education & EdTech</h2>
                <p class="card-description">
                    Replace paper registers and fragmented communication with custom institutional ERPs, digital student records, fee collection portals, and automated parent communication channels.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Student Information Portals</span>
                    <span class="tag-chip">Fee Reconciliations</span>
                    <span class="tag-chip">Attendance & Grading</span>
                </div>
            </div>

            <!-- 2. B2B Commerce & Retail -->
            <div class="card">
                <div class="card-icon">🛒</div>
                <h2 class="card-title">Commerce & Wholesale Distribution</h2>
                <p class="card-description">
                    Synchronize high-volume inventory across warehouses, automate bulk wholesale order workflows, and integrate secure payment gateways with custom pricing tiers.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">B2B Wholesale Portals</span>
                    <span class="tag-chip">Live Inventory Sync</span>
                    <span class="tag-chip">Automated Invoicing</span>
                </div>
            </div>

            <!-- 3. Professional & Legal Services -->
            <div class="card">
                <div class="card-icon">⚖️</div>
                <h2 class="card-title">Professional & Legal Services</h2>
                <p class="card-description">
                    Equip attorneys, consultants, and accounting firms with secure document vaults, automated contract review pipelines, and client intake assistants with zero external data sharing.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Confidential Document RAG</span>
                    <span class="tag-chip">Client Onboarding</span>
                    <span class="tag-chip">Audit Trails</span>
                </div>
            </div>

            <!-- 4. Logistics & Supply Chain -->
            <div class="card">
                <div class="card-icon">🚚</div>
                <h2 class="card-title">Logistics & Field Operations</h2>
                <p class="card-description">
                    Empower drivers, dispatchers, and warehouse teams with offline-first mobile apps, real-time shipment status webhooks, and automated proof-of-delivery receipts.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Dispatch Scheduling</span>
                    <span class="tag-chip">Offline Mobile Apps</span>
                    <span class="tag-chip">Status Notifications</span>
                </div>
            </div>

            <!-- 5. Real Estate & Property Management -->
            <div class="card">
                <div class="card-icon">🏢</div>
                <h2 class="card-title">Real Estate & Property Management</h2>
                <p class="card-description">
                    Streamline tenant applications, rent collection, maintenance ticketing, and multi-channel lead follow-ups over WhatsApp and SMS automatically.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Tenant Portals</span>
                    <span class="tag-chip">Automated Follow-ups</span>
                    <span class="tag-chip">Maintenance Queues</span>
                </div>
            </div>

            <!-- 6. Healthcare & Clinical Operations -->
            <div class="card">
                <div class="card-icon">🩺</div>
                <h2 class="card-title">Healthcare & Clinic Operations</h2>
                <p class="card-description">
                    Deploy privacy-first patient booking portals, automated appointment reminder pipelines, and encrypted medical record systems compliant with data privacy frameworks.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Secure Booking</span>
                    <span class="tag-chip">Appointment Alerts</span>
                    <span class="tag-chip">Data Encryption</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Have a specific industry requirement?";
$ctaSubtitle = "Let's review your exact operational workflows and compliance prerequisites during a structured technical discovery call.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
