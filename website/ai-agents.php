<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'AI Agents & Tool-Using Workflows | CodeX404 Solutions',
    'description' => 'Build accountable AI agents that interact with approved APIs and databases to execute multi-step operational workflows with human approval gates and audit trails.',
    'canonical' => url('ai-agents.php'),
    'keywords' => 'AI agents, tool-calling AI, multi-step workflows, AI workflow automation, function calling AI'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Services', 'url' => url('solutions.php')],
    ['label' => 'AI Agents'],
];
$heroTag = 'AUTOMATE · AI Support & Task Agents';
$heroTitleHtml = 'Helpful AI Agents With <span class="text-amber">Clear Safety Rules</span>';
$heroSubtitle = 'Go beyond basic chatbots. We build smart task assistants that look up customer orders, prepare updates across your tools, and pause for human approval before taking important actions.';
$heroActions = [
    ['label' => 'Discuss an Agent Workflow', 'url' => url('discovery-call.php') . '?division=AUTOMATE', 'variant' => 'primary'],
    ['label' => 'Explore Workflow Automation', 'url' => url('automation.php'), 'variant' => 'secondary'],
];
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-automate"><?= codex_icon('cpu', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Smart App &amp; Tool Actions</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Let your assistant safely check inventory, look up customer records, or update approved tools using strict input checks.
                </p>
                <div class="card-tags"><span class="tag-chip">Safe Tool Access</span><span class="tag-chip">Real-Time Lookup</span><span class="tag-chip">Checked Inputs</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-automate"><?= codex_icon('users', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Step-by-Step Task Routing</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Break work into clear steps—reading requests, checking facts, preparing replies, and passing tricky issues to staff cleanly.
                </p>
                <div class="card-tags"><span class="tag-chip">Clear Steps</span><span class="tag-chip">Status Tracking</span><span class="tag-chip">Team Handoff</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-automate"><?= codex_icon('shield', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Human Approval Before Action</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Important steps like refunds, sensitive record edits, or outbound messages always wait for a team member to approve before running.
                </p>
                <div class="card-tags"><span class="tag-chip">Human Checkpoints</span><span class="tag-chip">Clear Limits</span><span class="tag-chip">Safe Actions</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-automate"><?= codex_icon('database', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Organized Task Memory</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Remember active conversations and order context cleanly across follow-up messages without losing track of what was already answered.
                </p>
                <div class="card-tags"><span class="tag-chip">Session History</span><span class="tag-chip">Clean Context</span><span class="tag-chip">Cost Limits</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-automate"><?= codex_icon('workflow', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Safe Error Recovery</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    When another app slows down or misses a message, the task safely retries or sends an alert to your team instead of silently failing.
                </p>
                <div class="card-tags"><span class="tag-chip">Safe Retries</span><span class="tag-chip">Backup Paths</span><span class="tag-chip">Team Alerts</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-automate"><?= codex_icon('file', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Clear Activity Logs</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    See every question handled, every check made, and every team approval in one easy-to-read activity log for full peace of mind.
                </p>
                <div class="card-tags"><span class="tag-chip">Full Traceability</span><span class="tag-chip">Usage Clarity</span><span class="tag-chip">Easy Audits</span></div>
            </article>
        </div>
    </div>
</section>

<!-- EXECUTION LIFECYCLE -->
<section class="section"
    style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;"><span class="dot"></span><span>Execution
                    Lifecycle</span></div>
            <h2 class="section-title subpage-section-title">How an Accountable Agent <span class="text-amber">Run
                    Executes</span></h2>
            <p class="section-subtitle">Structured stages keep autonomous workflows predictable, debuggable, and safe.
            </p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card" style="padding: 1.75rem;">
                <span
                    style="color: var(--cyan); font-weight: 800; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">01</span>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.65rem;">Intent Parsing</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Extract request variables,
                    required permissions, and boundary constraints upfront.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <span
                    style="color: var(--cyan); font-weight: 800; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">02</span>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.65rem;">Tool Selection</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Map approved internal lookups and
                    calculations before mutating any state.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <span
                    style="color: var(--cyan); font-weight: 800; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">03</span>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.65rem;">Guarded Execution</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Run validated tool requests;
                    pause sensitive write actions for human confirmation.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <span
                    style="color: var(--cyan); font-weight: 800; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">04</span>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.65rem;">Audit &amp; Delivery</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Verify output formatting, return
                    clear status updates, and store the execution trace.</p>
            </div>
        </div>
    </div>
</section>

<!-- PRACTICAL USE CASES -->
<section class="section">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;"><span class="dot"></span><span>Practical Use
                    Cases</span></div>
            <h2 class="section-title subpage-section-title">Workflows Well-Suited to <span class="text-amber">Guarded AI
                    Agents</span></h2>
        </div>

        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <div class="card">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">Inbound Inquiry Triage</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate); margin-bottom: 1rem;">Classify
                    incoming web and WhatsApp requests continuously, extract scope details, and route clean briefs to
                    team members.</p>
                <span class="tag-chip" style="color: #34D399; border-color: rgba(52, 211, 153, 0.3);">Automated
                    Triage</span>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">Document &amp; Invoice
                    Checking</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate); margin-bottom: 1rem;">Extract vendor
                    invoice lines, cross-check purchase orders, flag discrepancies, and queue clean entries for finance
                    sign-off.</p>
                <span class="tag-chip" style="color: #34D399; border-color: rgba(52, 211, 153, 0.3);">Human
                    Sign-Off</span>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">Support Context Assembly
                </h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate); margin-bottom: 1rem;">Gather ticket
                    history, look up relevant help documentation, and draft suggested responses for human support
                    review.</p>
                <span class="tag-chip" style="color: #34D399; border-color: rgba(52, 211, 153, 0.3);">Structured
                    Escalation</span>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Scope an AI Agent Workflow?";
$ctaSubtitle = "Book a technical discovery session to review tools, approval boundaries, and implementation fit.";
include __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
