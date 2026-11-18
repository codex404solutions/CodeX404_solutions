<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Enterprise AI Solutions & Private RAG Knowledge Systems',
    'description' => 'Secure, domain-specific enterprise AI systems: private RAG applications, vector search, document intelligence, and omnichannel AI assistants with strict data privacy and grounded citation thresholds.',
    'canonical' => url('ai-solutions.php'),
    'keywords' => 'enterprise AI solutions, private RAG applications, vector search, Qdrant AI, document OCR intelligence, bespoke AI assistants, self-hosted LLM'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="section" style="padding-top: calc(var(--nav-height) + 3rem); padding-bottom: 3.5rem;">
    <div class="container">
        <div class="section-header" style="max-width: 860px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Applied Enterprise Artificial Intelligence</span>
            </div>
            <h1 class="section-title" style="font-size: clamp(2.25rem, 4vw, 3.25rem); line-height: 1.15; margin-bottom: 1.25rem;">
                Enterprise AI Engineered for <span class="gradient-text">Deterministic Business Value</span>
            </h1>
            <p class="section-subtitle" style="font-size: 1.1rem; line-height: 1.7; color: var(--slate); max-width: 740px; margin: 0 auto;">
                We build secure, domain-specific AI systems that connect directly to your proprietary company documentation, databases, and operational tools — engineered without speculative hype, hallucination risks, or privacy leaks.
            </p>
        </div>

        <!-- 6 Core AI Capability Cards -->
        <div class="grid grid-cols-3" style="gap: 2rem;">
            <!-- 1. Retrieval-Augmented Generation (RAG) -->
            <div class="card card-tilt reveal-on-scroll">
                <div class="card-icon">📚</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Private Knowledge RAG Systems</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Connect Large Language Models directly to internal SOPs, product documentation, HR policies, and technical manuals. Generates precise answers with exact source citations and zero retraining costs.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Hybrid Vector Search</span>
                    <span class="tag-chip">Qdrant / pgvector</span>
                    <span class="tag-chip">Direct Citations</span>
                    <span class="tag-chip">Grounded Citations</span>
                </div>
            </div>

            <!-- 2. Document & OCR Intelligence -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon">📄</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Document Intelligence & OCR</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Automatically extract line items, totals, dates, and contractual clauses from unstructured PDFs, receipts, invoices, and physical scans into validated relational database tables.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">OCR Parsing</span>
                    <span class="tag-chip">Schema Validation</span>
                    <span class="tag-chip">Invoice Ingestion</span>
                    <span class="tag-chip">Human Review Gates</span>
                </div>
            </div>

            <!-- 3. Omnichannel AI Customer & Sales Assistants -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon">💬</div>
                <h2 class="card-title" style="font-size: 1.3rem;">24/7 AI Sales & Support Assistants</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Deploy intelligent conversational assistants across your website and WhatsApp that qualify prospect intent, answer technical inquiries accurately, and smoothly route high-ticket leads to reps.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">WhatsApp Cloud API</span>
                    <span class="tag-chip">Lead Qualification</span>
                    <span class="tag-chip">Live Agent Handoff</span>
                    <span class="tag-chip">CRM Sync</span>
                </div>
            </div>

            <!-- 4. Internal Operational Search & Copilots -->
            <div class="card card-tilt reveal-on-scroll">
                <div class="card-icon">🔍</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Internal Workforce Copilots</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Empower your employees with an internal operational assistant that indexes Notion, Google Drive, Jira, and internal databases. Enforces role-based permissions so sensitive data stays isolated.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Role-Based Filtering</span>
                    <span class="tag-chip">Data Segregation</span>
                    <span class="tag-chip">Instant Retrieval</span>
                    <span class="tag-chip">Zero Leakage</span>
                </div>
            </div>

            <!-- 5. Natural Language Data Analytics -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon">📊</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Natural Language SQL Analytics</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Enable business executives and non-technical managers to query operational databases in natural English. Automatically translates questions into verified read-only SQL queries with visual summaries.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Text-to-SQL</span>
                    <span class="tag-chip">Read-Only Enforced</span>
                    <span class="tag-chip">Automated Graphs</span>
                    <span class="tag-chip">Audit Trails</span>
                </div>
            </div>

            <!-- 6. Private & Self-Hosted AI Infrastructure -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon">🔒</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Self-Hosted VPC Deployments</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    For legal, healthcare, and enterprise clients bound by strict confidentiality: we deploy open-weight foundation models (Llama 3, Mistral) on your dedicated cloud hardware with zero external API calls.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Isolated VPC</span>
                    <span class="tag-chip">GDPR & HIPAA Ready</span>
                    <span class="tag-chip">Zero Model Training</span>
                    <span class="tag-chip">Air-Gapped Options</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- GROUNDED ARCHITECTURAL RETRIEVAL BREAKDOWN -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Deterministic Safeguards</span>
            </div>
            <h2 class="section-title">The 4-Layer Grounded Retrieval Pipeline</h2>
            <p class="section-subtitle">
                How CodeX404 engineers AI systems that business operators can trust with mission-critical customer and financial workflows.
            </p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card" style="padding: 2rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">LAYER 1</span>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.75rem;">Semantic Grounding</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    Queries retrieve verified context chunks from high-dimension vector stores (Qdrant). If semantic similarity falls below threshold, the model gracefully admits missing context rather than fabricating.
                </p>
            </div>

            <div class="card" style="padding: 2rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">LAYER 2</span>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.75rem;">Strict Schema Outputs</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    All LLM responses are enforced through rigid JSON schemas validated by runtime type parsers (Pydantic). Malformed responses trigger automated sub-second re-generation before reaching the user.
                </p>
            </div>

            <div class="card" style="padding: 2rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">LAYER 3</span>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.75rem;">Source Citation Audit</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    A retrieval system can include references to source documents so people can review supporting material. Citation accuracy depends on document quality, parsing, retrieval, and implementation choices.
                </p>
            </div>

            <div class="card" style="padding: 2rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 1.1rem; display: block; margin-bottom: 0.5rem;">LAYER 4</span>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.75rem;">Human Approval Gates</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    High-impact business actions — issuing customer refunds, triggering external emails, or updating financial records — are paused at dedicated human verification gates awaiting manager sign-off.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- LIVE DEMO SANDBOX BANNER -->
<section class="section">
    <div class="container">
        <div style="background: radial-gradient(circle at 50% 50%, rgba(34, 211, 238, 0.08) 0%, var(--bg-surface) 100%); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 3rem; text-align: center;">
            <span class="tag-chip" style="margin-bottom: 1rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Interactive Sandbox</span>
            <h3 style="font-size: 1.85rem; color: var(--white); margin-bottom: 1rem;">Test Our AI RAG Knowledge Retrieval System</h3>
            <p style="font-size: 1rem; color: var(--slate); max-width: 650px; margin: 0 auto 2rem auto; line-height: 1.6;">
                Ask questions against our pre-indexed product catalog and documentation in real time to see grounded semantic retrieval and citation matching in action.
            </p>
            <a href="<?= url('index.php#projects') ?>" class="btn btn-primary" style="padding: 0.9rem 2.25rem;">Launch AI RAG Simulator ⚡</a>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Put Practical AI to Work in Your Business?";
$ctaSubtitle = "Schedule a technical feasibility session to review your company data sources, security requirements, and implementation roadmap.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
