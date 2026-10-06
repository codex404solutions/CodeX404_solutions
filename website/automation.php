<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Business Process & Workflow Automation',
    'description' => 'Eliminate manual repetitive workflows. Custom automations across CRM, WhatsApp Business API, automated billing, and cross-platform API integrations.',
    'canonical' => url('automation.php'),
    'keywords' => 'workflow automation, CRM automation, WhatsApp automation, business automation, API integrations'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Operational Velocity</span>
            </div>
            <h1 class="section-title">Automate the Repetitive. Accelerate Your Business.</h1>
            <p class="section-subtitle">
                Stop losing valuable hours to spreadsheet copy-pasting, disconnected apps, and manual follow-ups. We engineer custom automation pipelines that keep your business running smoothly 24/7.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- 1. CRM & Lead Automation -->
            <div class="card">
                <div class="card-icon">⚡</div>
                <h2 class="card-title">CRM & Lead Automation</h2>
                <p class="card-description">
                    Instantly capture leads from websites, Facebook ads, LinkedIn, and WhatsApp. Validate contact info, calculate lead scores, and assign to reps in real time.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Zero Lead Leakage</span>
                    <span class="tag-chip">Auto Assignment</span>
                    <span class="tag-chip">Instant Notifications</span>
                </div>
            </div>

            <!-- 2. WhatsApp Business Pipelines -->
            <div class="card">
                <div class="card-icon">💬</div>
                <h2 class="card-title">WhatsApp Business API Pipelines</h2>
                <p class="card-description">
                    Automate order confirmations, meeting reminders, customer support tickets, and renewal alerts directly over official WhatsApp Business API channels.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Meta Cloud API</span>
                    <span class="tag-chip">Template Messages</span>
                    <span class="tag-chip">Interactive Buttons</span>
                </div>
            </div>

            <!-- 3. Billing & Invoicing Automation -->
            <div class="card">
                <div class="card-icon">💳</div>
                <h2 class="card-title">Billing & Document Workflows</h2>
                <p class="card-description">
                    Generate branded PDF invoices, calculate GST/tax rates, trigger Razorpay/Stripe payment links, and reconcile paid accounts automatically.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Automated Invoicing</span>
                    <span class="tag-chip">Payment Webhooks</span>
                    <span class="tag-chip">QuickBooks / Zoho Sync</span>
                </div>
            </div>

            <!-- 4. Multi-System API Integrations -->
            <div class="card">
                <div class="card-icon">🔗</div>
                <h2 class="card-title">Custom API Orchestrations</h2>
                <p class="card-description">
                    Bridge software platforms that do not naturally talk to each other. Robust middleware with queuing, automatic exponential backoff retries, and error alerting.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">REST & GraphQL</span>
                    <span class="tag-chip">Reliable Queues</span>
                    <span class="tag-chip">Dead-Letter Audits</span>
                </div>
            </div>

            <!-- 5. Automated Reporting -->
            <div class="card">
                <div class="card-icon">📈</div>
                <h2 class="card-title">Scheduled Reports & Telemetry</h2>
                <p class="card-description">
                    Automate the compilation of weekly and monthly business metrics. Deliver crisp executive summaries straight to management inboxes or Slack channels every Monday.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Cron Schedules</span>
                    <span class="tag-chip">Data Aggregation</span>
                    <span class="tag-chip">Slack / Email Alerts</span>
                </div>
            </div>

            <!-- 6. Legacy Modernization -->
            <div class="card">
                <div class="card-icon">🛠️</div>
                <h2 class="card-title">Spreadsheet to System Migrations</h2>
                <p class="card-description">
                    Graduate from fragile Excel workbooks and Google Sheets to secure, validated relational databases with automated data cleanup and role-based permissions.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Data Sanitation</span>
                    <span class="tag-chip">Relational Models</span>
                    <span class="tag-chip">Historical Integrity</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Automation ROI Strip -->
<section class="section" style="background: rgba(11, 31, 58, 0.3);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>The Automation Impact</span>
            </div>
            <h2 class="section-title">Measurable Gains in Operational Efficiency</h2>
            <p class="section-subtitle">
                Automation isn't just about saving time — it's about eliminating human data entry errors and providing lightning-fast customer responsiveness.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <div class="card" style="text-align: center;">
                <div style="font-size: 2.75rem; font-weight: 800; color: var(--cyan); margin-bottom: 0.5rem;">&lt; 3 mins</div>
                <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem;">Average Lead Response Time</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">Leads receive instant personalized acknowledgment across WhatsApp and email, dramatically increasing conversions.</p>
            </div>
            <div class="card" style="text-align: center;">
                <div style="font-size: 2.75rem; font-weight: 800; color: var(--cyan); margin-bottom: 0.5rem;">15+ hrs</div>
                <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem;">Weekly Saved Per Team</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">Staff stop manually copying data across accounting, CRM, and inventory portals, freeing them for high-value client work.</p>
            </div>
            <div class="card" style="text-align: center;">
                <div style="font-size: 2.75rem; font-weight: 800; color: var(--cyan); margin-bottom: 0.5rem;">99.9%</div>
                <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem;">Data Accuracy Rate</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">Server-side schema validation eliminates typos, double-invoicing, and missing record entries permanently.</p>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to automate your team's repetitive tasks?";
$ctaSubtitle = "Request a Technology & Automation Audit to identify high-leverage workflows ripe for immediate automation.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
