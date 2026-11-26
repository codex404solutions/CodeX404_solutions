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
$heroTag = 'AUTOMATE · AI Agents & Tool Calling';
$heroTitleHtml = 'Accountable AI Agents Built for <span class="text-gradient">Real Operational Workflows</span>';
$heroSubtitle = 'Move beyond standalone chat boxes. We design tool-using agents that inspect requests, look up approved records, invoke typed APIs, and route consequential actions through human approval gates.';
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
                <h2 class="card-title" style="font-size: 1.28rem;">Typed Function &amp; API Tools</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Provide agents with constrained tools to check stock, look up CRM records, or dispatch structured webhooks using schema-checked JSON inputs.
                </p>
                <div class="card-tags"><span class="tag-chip">Type-Safe Tools</span><span class="tag-chip">REST / Webhooks</span><span class="tag-chip">Schema Guarded</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-automate"><?= codex_icon('users', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Coordinated Task Routing</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Separate triage, extraction, validation, and escalation into distinct accountable steps rather than relying on one opaque prompt.
                </p>
                <div class="card-tags"><span class="tag-chip">Role Separation</span><span class="tag-chip">State Tracking</span><span class="tag-chip">Validation Step</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-automate"><?= codex_icon('shield', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Human-in-the-Loop Gates</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Refunds, sensitive record changes, or outbound client messages pause at clear verification checkpoints until an authorized person approves.
                </p>
                <div class="card-tags"><span class="tag-chip">Approval Gates</span><span class="tag-chip">Scoped Permissions</span><span class="tag-chip">Controlled Actions</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-automate"><?= codex_icon('database', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Structured Session State</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Persist conversation and task context cleanly across multi-step workflows with clear token budgets and expiration rules.
                </p>
                <div class="card-tags"><span class="tag-chip">Session Persistence</span><span class="tag-chip">Context Indexing</span><span class="tag-chip">Token Limits</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-automate"><?= codex_icon('workflow', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Error Handling &amp; Fallbacks</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Handle external API timeouts, rate limits, and validation rejections gracefully with bounded retries and clear escalation alerts.
                </p>
                <div class="card-tags"><span class="tag-chip">Bounded Retries</span><span class="tag-chip">Fallback Paths</span><span class="tag-chip">Dead-Letter Logs</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-automate"><?= codex_icon('file', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Action Audit Logs</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Record every tool call, payload, outcome, and human sign-off step in structured logs for troubleshooting and accountability.
                </p>
                <div class="card-tags"><span class="tag-chip">Traceable Runs</span><span class="tag-chip">Cost Visibility</span><span class="tag-chip">Debuggable State</span></div>
            </article>
        </div>
    </div>
</section>

<!-- EXECUTION LIFECYCLE -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;"><span class="dot"></span><span>Execution Lifecycle</span></div>
            <h2 class="section-title">How an Accountable Agent Run Executes</h2>
            <p class="section-subtitle">Structured stages keep autonomous workflows predictable, debuggable, and safe.</p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card" style="padding: 1.75rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">01</span>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.65rem;">Intent Parsing</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Extract request variables, required permissions, and boundary constraints upfront.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">02</span>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.65rem;">Tool Selection</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Map approved internal lookups and calculations before mutating any state.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">03</span>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.65rem;">Guarded Execution</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Run validated tool requests; pause sensitive write actions for human confirmation.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">04</span>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.65rem;">Audit &amp; Delivery</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Verify output formatting, return clear status updates, and store the execution trace.</p>
            </div>
        </div>
    </div>
</section>

<!-- PRACTICAL USE CASES -->
<section class="section">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;"><span class="dot"></span><span>Practical Use Cases</span></div>
            <h2 class="section-title">Workflows Well-Suited to Guarded AI Agents</h2>
        </div>

        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <div class="card">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">Inbound Inquiry Triage</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate); margin-bottom: 1rem;">Classify incoming web and WhatsApp requests continuously, extract scope details, and route clean briefs to team members.</p>
                <span class="tag-chip" style="color: #34D399; border-color: rgba(52, 211, 153, 0.3);">Automated Triage</span>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">Document &amp; Invoice Checking</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate); margin-bottom: 1rem;">Extract vendor invoice lines, cross-check purchase orders, flag discrepancies, and queue clean entries for finance sign-off.</p>
                <span class="tag-chip" style="color: #34D399; border-color: rgba(52, 211, 153, 0.3);">Human Sign-Off</span>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">Support Context Assembly</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate); margin-bottom: 1rem;">Gather ticket history, look up relevant help documentation, and draft suggested responses for human support review.</p>
                <span class="tag-chip" style="color: #34D399; border-color: rgba(52, 211, 153, 0.3);">Structured Escalation</span>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Scope an AI Agent Workflow?";
$ctaSubtitle = "Book a technical discovery session to review tools, approval boundaries, and implementation fit.";
include __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
