<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Autonomous AI Agents & Tool-Calling Systems — Enterprise AI',
    'description' => 'Build production-ready autonomous AI agents that interact with APIs, databases, and enterprise software to execute multi-step operational workflows with safety guardrails.',
    'canonical' => url('ai-agents.php'),
    'keywords' => 'autonomous AI agents, tool-calling AI, multi-agent systems, AI workflow execution, function calling AI, enterprise AI agents'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="section" style="padding-top: calc(var(--nav-height) + 3rem); padding-bottom: 3.5rem;">
    <div class="container">
        <div class="section-header" style="max-width: 860px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Autonomous Systems & Tool Calling</span>
            </div>
            <h1 class="section-title" style="font-size: clamp(2.25rem, 4vw, 3.25rem); line-height: 1.15; margin-bottom: 1.25rem;">
                Autonomous AI Agents Engineered for <span class="gradient-text">Real Operational Work</span>
            </h1>
            <p class="section-subtitle" style="font-size: 1.1rem; line-height: 1.7; color: var(--slate); max-width: 740px; margin: 0 auto;">
                Move beyond passive chatbots that merely answer questions. We build deterministic, goal-driven agents that plan actions, query databases, invoke external APIs, and execute complex business workflows with complete auditing and human safety controls.
            </p>
        </div>

        <!-- Capability Grid -->
        <div class="grid grid-cols-3" style="gap: 2rem;">
            <!-- 1. Tool & API Calling -->
            <div class="card card-tilt reveal-on-scroll">
                <div class="card-icon">⚙️</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Function & API Tool Calling</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Equip agents with real operational tools. Agents can read inventory records, create CRM contacts, trigger webhook events, or fetch live pricing using strict, type-safe JSON schemas.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Type-Safe Tools</span>
                    <span class="tag-chip">REST & GraphQL</span>
                    <span class="tag-chip">Deterministic I/O</span>
                    <span class="tag-chip">Database Hooks</span>
                </div>
            </div>

            <!-- 2. Multi-Agent Orchestration -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon">👥</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Multi-Agent Orchestrations</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Deconstruct complex operations into specialized roles: a Supervisor Agent plans the tasks, Worker Agents gather intelligence and execute steps, and a Critic Agent validates quality before completion.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Supervisor Pattern</span>
                    <span class="tag-chip">State Sharing</span>
                    <span class="tag-chip">Role Specialization</span>
                    <span class="tag-chip">Self-Correction</span>
                </div>
            </div>

            <!-- 3. Human-in-the-Loop Safety -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon">🛡️</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Human-in-the-Loop Safeguards</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Critical actions — issuing financial refunds, updating sensitive records, or dispatching external client contracts — pause automatically at verification gates until an authorized manager approves.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Approval Gates</span>
                    <span class="tag-chip">Slack & Webhook Alerts</span>
                    <span class="tag-chip">Granular Authority</span>
                    <span class="tag-chip">Zero Runaway Risk</span>
                </div>
            </div>

            <!-- 4. Long-Term State & Memory -->
            <div class="card card-tilt reveal-on-scroll">
                <div class="card-icon">💾</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Long-Term Context & Memory</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Enable agents to retain context across long-running conversations and business cycles. Uses semantic vector memory and structured session checkpoints without unbounded token cost growth.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Vector Episodic Memory</span>
                    <span class="tag-chip">Session Serialization</span>
                    <span class="tag-chip">Token Optimization</span>
                    <span class="tag-chip">Cross-Session State</span>
                </div>
            </div>

            <!-- 5. Self-Healing & Dynamic Retries -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon">🔄</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Self-Healing Workflows</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    When a third-party API returns an unexpected error or times out, the agent inspects the response status, adjusts its request arguments intelligently, and retries gracefully without failing the entire workflow.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Dynamic Retries</span>
                    <span class="tag-chip">Error Classification</span>
                    <span class="tag-chip">Fallback Chains</span>
                    <span class="tag-chip">Fault Tolerance</span>
                </div>
            </div>

            <!-- 6. Complete Audit & Observability -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon">📜</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Immutable Action Audit Logs</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Every single decision, reasoning trace, tool invocation, and token consumption metric is permanently recorded in tamper-resistant audit logs for total enterprise compliance and debugging.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Step-by-Step Traces</span>
                    <span class="tag-chip">Cost Telemetry</span>
                    <span class="tag-chip">Audit Compliance</span>
                    <span class="tag-chip">GDPR Friendly</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ANATOMY OF AN AGENT RUN -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Agent Execution Lifecycle</span>
            </div>
            <h2 class="section-title">From Natural Language Prompt to Verified Business Outcome</h2>
            <p class="section-subtitle">
                How our autonomous agents systematically parse, plan, verify, and execute operational tasks with zero guesswork.
            </p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card card-tilt reveal-on-scroll" style="padding: 2rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 1.25rem; display: block; margin-bottom: 0.5rem;">01</span>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.75rem;">Intent & Constraint Parsing</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    The agent deconstructs the business request, identifying required variables, authorized tool boundaries, and output formatting rules.
                </p>
            </div>

            <div class="card card-tilt reveal-on-scroll reveal-delay-1" style="padding: 2rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 1.25rem; display: block; margin-bottom: 0.5rem;">02</span>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.75rem;">Dynamic Tool Planning</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    The agent plans the sequence of required internal database queries, webhook calls, and calculations needed to satisfy the goal.
                </p>
            </div>

            <div class="card card-tilt reveal-on-scroll reveal-delay-2" style="padding: 2rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 1.25rem; display: block; margin-bottom: 0.5rem;">03</span>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.75rem;">Sandboxed Tool Execution</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    APIs execute in an isolated environment with input validation. High-privilege mutations wait for human manager approval before committing.
                </p>
            </div>

            <div class="card card-tilt reveal-on-scroll reveal-delay-3" style="padding: 2rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 1.25rem; display: block; margin-bottom: 0.5rem;">04</span>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.75rem;">Verification & Audit Commit</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    The Critic Agent validates output schema against success criteria, delivers formatted results to the stakeholder, and writes immutable logs.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- REAL ENTERPRISE USE CASES -->
<section class="section">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Practical Implementations</span>
            </div>
            <h2 class="section-title">High-Leverage Workflows Ideal for AI Agents</h2>
            <p class="section-subtitle">
                Where autonomous agent engineering delivers immediate operational time savings and reduces costly administrative delays.
            </p>
        </div>

        <div class="grid grid-cols-3" style="gap: 2rem;">
            <div class="card card-tilt reveal-on-scroll">
                <h3 style="color: var(--cyan); font-size: 1.2rem; margin-bottom: 0.75rem;">Autonomous Lead Triage Agent</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate); margin-bottom: 1rem;">
                    Monitors website inquiries and WhatsApp messages 24/7. Validates company domain, extracts estimated budget and requirements, enriches contact details via LinkedIn, and routes qualified leads directly onto account executive calendars.
                </p>
                <span class="tag-chip" style="color: #34D399; border-color: rgba(52, 211, 153, 0.3);">Automated Ingestion &amp; Triage</span>
            </div>

            <div class="card card-tilt reveal-on-scroll reveal-delay-1">
                <h3 style="color: var(--cyan); font-size: 1.2rem; margin-bottom: 0.75rem;">Invoice Reconciliation Agent</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate); margin-bottom: 1rem;">
                    Extracts line items from incoming vendor PDF invoices, cross-references purchase orders in the ERP, flags mathematical or price discrepancies, and queues valid invoices for accountant sign-off in one click.
                </p>
                <span class="tag-chip" style="color: #34D399; border-color: rgba(52, 211, 153, 0.3);">Human review where needed</span>
            </div>

            <div class="card card-tilt reveal-on-scroll reveal-delay-2">
                <h3 style="color: var(--cyan); font-size: 1.2rem; margin-bottom: 0.75rem;">Technical Support Escalation Agent</h3>
                <p style="font-size: 0.9rem; line-height: 1.6; color: var(--slate); margin-bottom: 1rem;">
                    Answers customer bug reports by querying error logs, reproducing test cases from documentation, drafting precise patch recommendations for engineers, and notifying the client once resolved.
                </p>
                <span class="tag-chip" style="color: #34D399; border-color: rgba(52, 211, 153, 0.3);">Structured Escalation</span>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Deploy Autonomous AI Agents in Your Business?";
$ctaSubtitle = "Schedule a technical scoping session to identify manual operations ripe for immediate agentic automation.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
