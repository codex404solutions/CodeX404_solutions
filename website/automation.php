<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Business Process & Workflow Automation Engineering',
    'description' => 'Eliminate manual operational friction. Custom automations across CRM, Meta WhatsApp Business API, automated billing, and cross-platform API integrations with zero data leakage.',
    'canonical' => url('automation.php'),
    'keywords' => 'workflow automation, CRM automation, WhatsApp Business API automation, business process automation, API integrations, spreadsheet migration'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="section" style="padding-top: calc(var(--nav-height) + 3rem); padding-bottom: 3.5rem;">
    <div class="container">
        <div class="section-header" style="max-width: 860px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Operational Velocity & Automation</span>
            </div>
            <h1 class="section-title" style="font-size: clamp(2.25rem, 4vw, 3.25rem); line-height: 1.15; margin-bottom: 1.25rem;">
                Automate the Repetitive. <span class="gradient-text">Accelerate Your Enterprise.</span>
            </h1>
            <p class="section-subtitle" style="font-size: 1.1rem; line-height: 1.7; color: var(--slate); max-width: 740px; margin: 0 auto;">
                Stop losing valuable hours to spreadsheet copy-pasting, disconnected SaaS tools, and slow manual follow-ups. We engineer custom automation pipelines that keep your business running smoothly, accurately, and 24/7.
            </p>
        </div>

        <!-- Automation Capabilities Grid -->
        <div class="grid grid-cols-3" style="gap: 2rem;">
            <!-- 1. Zero-Leakage Lead Capture -->
            <div class="card">
                <div class="card-icon">⚡</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Zero-Leakage Lead Ingestion</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Instantly capture high-intent inquiries from landing pages, Facebook ads, LinkedIn forms, and WhatsApp. Validates phone/email, enriches contact details, and assigns leads to available reps dynamically.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Real-Time Routing</span>
                    <span class="tag-chip">Duplicate Deduplication</span>
                    <span class="tag-chip">CRM Instant Sync</span>
                    <span class="tag-chip">SMS & Email Alerts</span>
                </div>
            </div>

            <!-- 2. WhatsApp Business Cloud API Pipelines -->
            <div class="card">
                <div class="card-icon">💬</div>
                <h2 class="card-title" style="font-size: 1.3rem;">WhatsApp Business Cloud API</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Connect directly to Meta's official WhatsApp Business Cloud API. Automate verified appointment reminders, invoice payment links, order tracking, and two-way interactive customer support.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Meta Cloud API</span>
                    <span class="tag-chip">Interactive Quick Replies</span>
                    <span class="tag-chip">Media Attachments</span>
                    <span class="tag-chip">Green Tick Ready</span>
                </div>
            </div>

            <!-- 3. Automated Invoicing & Payment Reconciliation -->
            <div class="card">
                <div class="card-icon">💳</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Automated Invoicing & Payments</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Generate branded PDF invoices, calculate GST/sales taxes dynamically, dispatch Razorpay/Stripe checkout links, and automatically reconcile paid transactions with accounting databases.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">PDF Invoice Generation</span>
                    <span class="tag-chip">Stripe / Razorpay</span>
                    <span class="tag-chip">Automatic Reconciliation</span>
                    <span class="tag-chip">Payment Reminders</span>
                </div>
            </div>

            <!-- 4. Custom API Orchestration Middleware -->
            <div class="card">
                <div class="card-icon">🔗</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Multi-System API Orchestration</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Bridge legacy databases and modern cloud apps that do not communicate out of the box. Robust middleware pipelines featuring asynchronous message queues and automatic exponential retry policies.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">REST & Webhooks</span>
                    <span class="tag-chip">Redis Queues</span>
                    <span class="tag-chip">Dead-Letter Audits</span>
                    <span class="tag-chip">HMAC Verification</span>
                </div>
            </div>

            <!-- 5. Automated Executive Reporting & Alerts -->
            <div class="card">
                <div class="card-icon">📈</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Scheduled Telemetry & Reports</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Automate the manual compilation of weekly sales summaries, operational bottlenecks, and financial KPI reports. Dispatches structured summaries straight to executive Slack channels or inboxes.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Automated Summaries</span>
                    <span class="tag-chip">Slack Bot Integration</span>
                    <span class="tag-chip">PDF Digest Dispatch</span>
                    <span class="tag-chip">Real-Time Alarms</span>
                </div>
            </div>

            <!-- 6. Spreadsheet to Relational Migrations -->
            <div class="card">
                <div class="card-icon">🛠️</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Spreadsheet-to-System Modernization</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Graduate your operations away from fragile, multi-tab Excel files. We clean historical data, architect normalized relational schemas, and build role-restricted web portals with zero formulas to break.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Data Sanitation</span>
                    <span class="tag-chip">Relational PostgreSQL/MySQL</span>
                    <span class="tag-chip">Field-Level Validation</span>
                    <span class="tag-chip">Historical Integrity</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MEASURABLE BUSINESS ROI STRIP -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>The Automation Impact</span>
            </div>
            <h2 class="section-title">Measurable Gains in Operational Speed & Accuracy</h2>
            <p class="section-subtitle">
                Automation isn't just about saving hours — it's about eliminating costly human data entry mistakes and responding to customer demand instantaneously.
            </p>
        </div>

        <div class="grid grid-cols-3" style="gap: 2rem;">
            <div class="card" style="text-align: center; padding: 2.5rem;">
                <div style="font-size: 3.25rem; font-weight: 800; color: var(--cyan); margin-bottom: 0.5rem; line-height: 1;">&lt; 3 mins</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; color: var(--white);">Lead Response Time</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate);">
                    Leads receive immediate, personalized validation over WhatsApp and email, converting prospects while purchase intent is at its absolute peak.
                </p>
            </div>

            <div class="card" style="text-align: center; padding: 2.5rem;">
                <div style="font-size: 3.25rem; font-weight: 800; color: var(--cyan); margin-bottom: 0.5rem; line-height: 1;">15+ hrs</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; color: var(--white);">Saved Weekly Per Team</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate);">
                    Staff completely stop manually transcribing data across accounting, CRM, and inventory portals, redirecting attention to revenue-generating activities.
                </p>
            </div>

            <div class="card" style="text-align: center; padding: 2.5rem;">
                <div style="font-size: 3.25rem; font-weight: 800; color: var(--cyan); margin-bottom: 0.5rem; line-height: 1;">99.9%</div>
                <h3 style="font-size: 1.25rem; margin-bottom: 0.75rem; color: var(--white);">Data Accuracy Guarantee</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate);">
                    Rigorous server-side schema validation permanently eliminates typos, duplicate invoicing records, and corrupted client details.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- LIVE DEMO SANDBOX BANNER -->
<section class="section">
    <div class="container">
        <div style="background: radial-gradient(circle at 50% 50%, rgba(34, 211, 238, 0.08) 0%, var(--bg-surface) 100%); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 3rem; text-align: center;">
            <span class="tag-chip" style="margin-bottom: 1rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Interactive Simulator</span>
            <h3 style="font-size: 1.85rem; color: var(--white); margin-bottom: 1rem;">Test Our WhatsApp Lead Ingestion Pipeline</h3>
            <p style="font-size: 1rem; color: var(--slate); max-width: 650px; margin: 0 auto 2rem auto; line-height: 1.6;">
                Trigger a simulated webhook payload to watch how our pipeline captures contact details, calculates priority scores, and generates instant confirmations in real time.
            </p>
            <a href="<?= url('index.php#projects') ?>" class="btn btn-primary" style="padding: 0.9rem 2.25rem;">Launch Pipeline Simulator ⚡</a>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Eliminate Repetitive Manual Friction?";
$ctaSubtitle = "Request a complimentary Technology & Automation Audit to identify high-leverage workflows ready for immediate automation.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
