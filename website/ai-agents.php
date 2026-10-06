<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Autonomous AI Agents & Tool-Calling Systems',
    'description' => 'Build production-ready autonomous AI agents that interact with APIs, databases, and enterprise software to execute multi-step operational workflows with safety guardrails.',
    'canonical' => url('ai-agents.php'),
    'keywords' => 'autonomous AI agents, tool-calling AI, multi-agent systems, AI workflow execution, enterprise agents'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Next-Gen Autonomy</span>
            </div>
            <h1 class="section-title">Autonomous AI Agents Built for Real Operations</h1>
            <p class="section-subtitle">
                Move beyond passive chatbots. We engineer intelligent agents that plan, invoke tools, query databases, and execute multi-step operational tasks with robust auditing and human approval controls.
            </p>
        </div>

        <!-- Capability Grid -->
        <div class="grid grid-cols-3">
            <!-- 1. Tool Integration -->
            <div class="card">
                <div class="card-icon">⚙️</div>
                <h2 class="card-title">Function & API Tool Calling</h2>
                <p class="card-description">
                    Agents equipped with dedicated APIs to inspect CRM contacts, query inventory status, generate invoices, or dispatch notifications autonomously based on structured logic.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Structured Schema</span>
                    <span class="tag-chip">REST APIs</span>
                    <span class="tag-chip">Deterministic I/O</span>
                </div>
            </div>

            <!-- 2. Multi-Agent Collaboration -->
            <div class="card">
                <div class="card-icon">👥</div>
                <h2 class="card-title">Multi-Agent Orchestrations</h2>
                <p class="card-description">
                    Deconstruct complex projects into specialized agent roles: a researcher agent gathers intelligence, a coder agent formats the logic, and a review agent audits for errors.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Supervisor Pattern</span>
                    <span class="tag-chip">Shared State</span>
                    <span class="tag-chip">Error Correction</span>
                </div>
            </div>

            <!-- 3. Human-in-the-Loop -->
            <div class="card">
                <div class="card-icon">🛡️</div>
                <h2 class="card-title">Human-in-the-Loop Safety</h2>
                <p class="card-description">
                    Crucial operational actions (such as committing transactions, altering sensitive databases, or emailing clients) require explicit user approval via Slack, email, or web UI.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Approval Gates</span>
                    <span class="tag-chip">Webhook Callbacks</span>
                    <span class="tag-chip">Zero Runaway Risk</span>
                </div>
            </div>

            <!-- 4. Persistent Memory -->
            <div class="card">
                <div class="card-icon">💾</div>
                <h2 class="card-title">Long-Term Agent Memory</h2>
                <p class="card-description">
                    Equip agents with semantic vector memory and episodic session history so they remember client preferences, prior interactions, and business rules across sessions.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Semantic Memory</span>
                    <span class="tag-chip">State Serialization</span>
                    <span class="tag-chip">Context Compaction</span>
                </div>
            </div>

            <!-- 5. Self-Healing Pipelines -->
            <div class="card">
                <div class="card-icon">🔄</div>
                <h2 class="card-title">Self-Healing Workflows</h2>
                <p class="card-description">
                    When an API fails or returns unexpected data, the agent inspects the stack trace, adjusts its parameters, and retries gracefully without stalling execution.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Dynamic Retries</span>
                    <span class="tag-chip">Trace Telemetry</span>
                    <span class="tag-chip">Graceful Degradation</span>
                </div>
            </div>

            <!-- 6. Audit & Traceability -->
            <div class="card">
                <div class="card-icon">📜</div>
                <h2 class="card-title">Full Audit & Action Logs</h2>
                <p class="card-description">
                    Every step taken by an agent is permanently logged with timestamps, prompts, tool outputs, and token costs for compliance, debugging, and continuous improvement.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Immutable Logs</span>
                    <span class="tag-chip">Cost Telemetry</span>
                    <span class="tag-chip">GDPR Compliance</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Agent Execution Architecture Example -->
<section class="section" style="background: rgba(11, 31, 58, 0.3);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Anatomy of an Agent Flow</span>
            </div>
            <h2 class="section-title">From Request to Verified Result</h2>
            <p class="section-subtitle">
                How our autonomous agents systematically parse, plan, verify, and execute tasks safely.
            </p>
        </div>

        <div class="process-grid">
            <div class="process-step">
                <div class="step-num">1</div>
                <h3>Intent Analysis</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">The agent parses the incoming request, identifying goals, entities, and constraints.</p>
            </div>
            <div class="process-step">
                <div class="step-num">2</div>
                <h3>Tool Planning</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">The agent selects the exact sequence of internal APIs or database queries needed.</p>
            </div>
            <div class="process-step">
                <div class="step-num">3</div>
                <h3>Execution & Eval</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Tools run in isolated sandboxes; outputs are evaluated against success criteria.</p>
            </div>
            <div class="process-step">
                <div class="step-num">4</div>
                <h3>Delivery & Log</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Results are formatted, delivered to the user or system, and logged for auditing.</p>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to deploy autonomous AI agents in your business?";
$ctaSubtitle = "Let's explore high-ROI use cases where AI agents can eliminate 10+ hours of weekly manual operations.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
