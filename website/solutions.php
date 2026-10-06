<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Technology Solutions & Engineering Capabilities',
    'description' => 'Explore CodeX404 Solutions full-spectrum software and AI engineering services: custom web apps, autonomous AI agents, workflow automation, and SaaS products.',
    'canonical' => url('solutions.php'),
    'keywords' => 'software solutions, AI development, automation engineering, SaaS development, business systems'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Complete Capabilities</span>
            </div>
            <h1 class="section-title">Software & AI Solutions Engineered for Growth</h1>
            <p class="section-subtitle">
                We deliver tailored digital products, intelligent automations, and scalable cloud systems that eliminate operational bottlenecks and drive measurable business impact.
            </p>
        </div>

        <!-- Filter Controls -->
        <div style="display: flex; justify-content: center; gap: 0.75rem; margin-bottom: 3rem; flex-wrap: wrap;">
            <button type="button" class="btn btn-secondary btn-sm filter-btn active" data-filter="all">All Solutions</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="software">Custom Software</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="ai">AI & Intelligence</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="automation">Automation</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="saas">SaaS & Products</button>
        </div>

        <!-- Solutions Grid -->
        <div class="grid grid-cols-3">
            <!-- 1. Custom Web Applications -->
            <div class="card" data-category="software">
                <div class="card-icon">💻</div>
                <h2 class="card-title">Custom Web Applications</h2>
                <p class="card-description">
                    Tailor-made web applications designed around your specific operational workflows. Eliminate off-the-shelf software compromises with scalable, proprietary code.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Modern PHP</span>
                    <span class="tag-chip">JavaScript</span>
                    <span class="tag-chip">Cloud Ready</span>
                </div>
                <a href="<?= url('software-development.php') ?>" class="card-arrow-link">View Details →</a>
            </div>

            <!-- 2. AI Solutions & RAG -->
            <div class="card" data-category="ai">
                <div class="card-icon">🤖</div>
                <h2 class="card-title">Enterprise AI & RAG</h2>
                <p class="card-description">
                    Retrieval-Augmented Generation (RAG) and private knowledge assistants that allow teams to converse with company documentation, manuals, and internal databases securely.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">RAG Systems</span>
                    <span class="tag-chip">Vector Embeddings</span>
                    <span class="tag-chip">Document Intelligence</span>
                </div>
                <a href="<?= url('ai-solutions.php') ?>" class="card-arrow-link">View Details →</a>
            </div>

            <!-- 3. Autonomous AI Agents -->
            <div class="card" data-category="ai">
                <div class="card-icon">🧠</div>
                <h2 class="card-title">Autonomous AI Agents</h2>
                <p class="card-description">
                    Multi-step agents that execute complex workflows across your existing software stack, featuring tool use, structured inputs, and rigorous human-in-the-loop safeguards.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Tool Integration</span>
                    <span class="tag-chip">Autonomous Workflows</span>
                    <span class="tag-chip">Auditability</span>
                </div>
                <a href="<?= url('ai-agents.php') ?>" class="card-arrow-link">View Details →</a>
            </div>

            <!-- 4. Workflow Automation -->
            <div class="card" data-category="automation">
                <div class="card-icon">⚡</div>
                <h2 class="card-title">Business Automation Pipelines</h2>
                <p class="card-description">
                    Connect disconnected tools. Seamlessly pass customer inquiries from WhatsApp and web forms into CRM and accounting software without human data entry.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">WhatsApp API</span>
                    <span class="tag-chip">CRM Sync</span>
                    <span class="tag-chip">Automated Invoicing</span>
                </div>
                <a href="<?= url('automation.php') ?>" class="card-arrow-link">View Details →</a>
            </div>

            <!-- 5. Cross-Platform Mobile Apps -->
            <div class="card" data-category="software">
                <div class="card-icon">📱</div>
                <h2 class="card-title">Mobile App Development</h2>
                <p class="card-description">
                    Native-feel iOS and Android mobile applications built for field staff, customer interactions, or consumer distribution with offline caching and background synchronization.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">iOS / Android</span>
                    <span class="tag-chip">Offline Sync</span>
                    <span class="tag-chip">REST APIs</span>
                </div>
                <a href="<?= url('mobile-apps.php') ?>" class="card-arrow-link">View Details →</a>
            </div>

            <!-- 6. SaaS & MVP Development -->
            <div class="card" data-category="saas">
                <div class="card-icon">🚀</div>
                <h2 class="card-title">SaaS & MVP Engineering</h2>
                <p class="card-description">
                    Turn your product vision into a validated cloud application with multi-tenant data isolation, self-serve subscription billing, and rich analytics telemetry.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Multi-Tenancy</span>
                    <span class="tag-chip">Payment Gateways</span>
                    <span class="tag-chip">Admin Dashboards</span>
                </div>
                <a href="<?= url('saas.php') ?>" class="card-arrow-link">View Details →</a>
            </div>
        </div>
    </div>
</section>

<!-- Solution Architecture Overview -->
<section class="section" style="background: rgba(11, 31, 58, 0.3);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Engineering Standards</span>
            </div>
            <h2 class="section-title">How We Build Every Solution</h2>
            <p class="section-subtitle">
                Our core architectural tenets guarantee that every line of code is resilient, maintainable, and aligned with international standards.
            </p>
        </div>

        <div class="grid grid-cols-4">
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.5rem; font-size: 1.15rem;">Defensive Security</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Zero-trust authentication, parameterized queries, CSRF validation, and strict data encryption.</p>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.5rem; font-size: 1.15rem;">Modular Architecture</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Loosely coupled components, clear separation of concerns, and well-documented API contracts.</p>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.5rem; font-size: 1.15rem;">High Velocity</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Rapid prototyping followed by disciplined test-driven deployment cycles to minimize time to value.</p>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.5rem; font-size: 1.15rem;">Full IP Ownership</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">All repositories, architecture diagrams, and intellectual property belong 100% to your company.</p>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Unsure which technical path matches your goal?";
$ctaSubtitle = "Schedule a technical discovery session with our lead architects to evaluate stack, scope, and implementation strategy.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
