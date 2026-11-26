<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Business Process & Workflow Automation | CodeX404 Solutions',
    'description' => 'Plan workflow automations and integrations across business tools, CRM, messaging, billing, and APIs with reliable data handling controls.',
    'canonical' => url('automation.php'),
    'keywords' => 'workflow automation, CRM automation, WhatsApp Business API automation, business process automation, API integrations'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Services', 'url' => url('solutions.php')],
    ['label' => 'Workflow Automation'],
];
$heroTag = 'AUTOMATE · Workflow & App Sync';
$heroTitleHtml = 'Automate Repetitive Tasks Across <span class="text-amber">Your Business Tools</span>';
$heroSubtitle = 'Stop copying and pasting data between website forms, spreadsheets, WhatsApp, and invoicing software. We connect your apps cleanly so routine updates run reliably in the background.';
$heroActions = [
    ['label' => 'Book an Automation Audit', 'url' => url('discovery-call.php') . '?division=AUTOMATE', 'variant' => 'primary'],
    ['label' => 'Explore AI Agents', 'url' => url('ai-agents.php'), 'variant' => 'secondary'],
];
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-automate"><?= codex_icon('zap', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Automatic Lead Capture &amp; Alerts</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Collect inquiries from website forms, ads, and messages cleanly—check details, prevent duplicates, and notify the right team member right away.
                </p>
                <div class="card-tags"><span class="tag-chip">Instant Alerts</span><span class="tag-chip">No Duplicates</span><span class="tag-chip">CRM Updates</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-automate"><?= codex_icon('message', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">WhatsApp Business Messaging</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Send official WhatsApp appointment confirmations, order updates, and payment reminders automatically while letting staff jump in whenever needed.
                </p>
                <div class="card-tags"><span class="tag-chip">Official WhatsApp API</span><span class="tag-chip">Booking Alerts</span><span class="tag-chip">Team Handoff</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-automate"><?= codex_icon('card', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Automatic Invoices &amp; Payments</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Create PDF invoices, send Stripe or Razorpay payment links automatically, and mark orders paid across your accounts right on time.
                </p>
                <div class="card-tags"><span class="tag-chip">PDF Invoices</span><span class="tag-chip">Stripe / Razorpay</span><span class="tag-chip">Auto Receipts</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-automate"><?= codex_icon('link', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Connect Your Existing Apps</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Link your website, accounting tools, CRM, and email systems together safely so data stays in sync without manual copying.
                </p>
                <div class="card-tags"><span class="tag-chip">App Connections</span><span class="tag-chip">Background Sync</span><span class="tag-chip">Reliable Retries</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-automate"><?= codex_icon('chart', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Daily &amp; Weekly Summary Reports</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Replace manual Friday spreadsheet work with automatic sales, inquiry, and status summaries sent directly to email or Slack.
                </p>
                <div class="card-tags"><span class="tag-chip">Scheduled Reports</span><span class="tag-chip">Email / Slack</span><span class="tag-chip">Early Warnings</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-automate"><?= codex_icon('database', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Move Off Messy Spreadsheets</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Clean up scattered Excel sheets, import records safely into a proper database, and give your team clean forms that prevent typos.
                </p>
                <div class="card-tags"><span class="tag-chip">Data Cleanup</span><span class="tag-chip">MySQL / Postgres</span><span class="tag-chip">Safe Forms</span></div>
            </article>
        </div>
    </div>
</section>

<!-- PRACTICAL OUTCOMES (NO INVENTED PERCENTAGES) -->
<section class="section"
    style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;"><span class="dot"></span><span>Operational
                    Benefits</span></div>
            <h2 class="section-title subpage-section-title">What Reliable Workflow Automation <span
                    class="text-amber">Improves</span></h2>
            <p class="section-subtitle">Automation matters most where speed, data consistency, and accountability
                directly impact customer follow-through.</p>
        </div>

        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <div class="card" style="padding: 2rem;">
                <div style="margin-bottom: 0.9rem;" class="inline-icon-box is-amber"><?= codex_icon('clock', 22) ?>
                </div>
                <h3 style="font-size: 1.18rem; margin-bottom: 0.65rem; color: var(--white);">Faster Lead Response</h3>
                <p style="font-size: 0.9rem; line-height: 1.65; color: var(--slate); margin: 0;">Incoming web and
                    messaging inquiries reach the right team member immediately rather than waiting in shared inboxes.
                </p>
            </div>
            <div class="card" style="padding: 2rem;">
                <div style="margin-bottom: 0.9rem;" class="inline-icon-box"><?= codex_icon('workflow', 22) ?></div>
                <h3 style="font-size: 1.18rem; margin-bottom: 0.65rem; color: var(--white);">Fewer Transcription Errors
                </h3>
                <p style="font-size: 0.9rem; line-height: 1.65; color: var(--slate); margin: 0;">Validated two-way
                    synchronization between forms, billing, and CRMs eliminates manual copy-paste mismatches.</p>
            </div>
            <div class="card" style="padding: 2rem;">
                <div style="margin-bottom: 0.9rem;" class="inline-icon-box"><?= codex_icon('shield', 22) ?></div>
                <h3 style="font-size: 1.18rem; margin-bottom: 0.65rem; color: var(--white);">Inspectable Run History
                </h3>
                <p style="font-size: 0.9rem; line-height: 1.65; color: var(--slate); margin: 0;">Every webhook event,
                    retry, and failure state is logged cleanly so operators stay in control.</p>
            </div>
        </div>
    </div>
</section>

<!-- LIVE SIMULATOR BANNER -->
<section class="section">
    <div class="container">
        <div class="obsidian-lit-panel"
            style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 2.5rem; text-align: center;">
            <span class="tag-chip"
                style="margin-bottom: 0.85rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Interactive
                Sandbox</span>
            <h3 style="font-size: 1.65rem; color: var(--white); margin-bottom: 0.75rem;">Inspect Our Lead Webhook
                Pipeline Simulator</h3>
            <p
                style="font-size: 0.98rem; color: var(--slate); max-width: 620px; margin: 0 auto 1.5rem auto; line-height: 1.6;">
                See how structured webhook payloads validate inputs, score intent, and sync across dashboards in real
                time.</p>
            <a href="<?= url('portfolio.php') ?>" class="btn btn-primary">Explore Interactive Portfolio &rarr;</a>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Automate Repetitive Manual Workflows?";
$ctaSubtitle = "Share the tools you currently connect manually and let's map out a clean integration plan.";
include __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
