<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Enterprise AI Solutions & Knowledge Systems',
    'description' => 'Practical enterprise AI solutions: private RAG applications, vector search, document intelligence, and AI customer support assistants with strict data privacy.',
    'canonical' => url('ai-solutions.php'),
    'keywords' => 'enterprise AI, RAG applications, AI knowledge base, AI document processing, vector search, bespoke AI integration'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Applied Artificial Intelligence</span>
            </div>
            <h1 class="section-title">Enterprise AI Engineered for Practical Business Outcomes</h1>
            <p class="section-subtitle">
                We build secure, domain-specific AI applications that solve concrete business challenges — without speculative hype, hallucination risks, or privacy compromises.
            </p>
        </div>

        <!-- Capability Cards Grid -->
        <div class="grid grid-cols-3">
            <!-- 1. RAG -->
            <div class="card">
                <div class="card-icon">📚</div>
                <h2 class="card-title">Retrieval-Augmented Generation (RAG)</h2>
                <p class="card-description">
                    Connect Large Language Models directly to your proprietary company knowledge, policy manuals, product catalogs, and databases. Accurate citations with zero model retraining required.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Hybrid Search</span>
                    <span class="tag-chip">Vector Stores</span>
                    <span class="tag-chip">Hallucination Guardrails</span>
                </div>
            </div>

            <!-- 2. Document Intelligence -->
            <div class="card">
                <div class="card-icon">📄</div>
                <h2 class="card-title">Document & Data Intelligence</h2>
                <p class="card-description">
                    Automatically extract structured data, invoices, legal clauses, and line items from complex PDFs, scans, and spreadsheets into your database with human-in-the-loop review.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">OCR Parsing</span>
                    <span class="tag-chip">Entity Extraction</span>
                    <span class="tag-chip">Schema Validation</span>
                </div>
            </div>

            <!-- 3. AI Support & Sales Assistants -->
            <div class="card">
                <div class="card-icon">💬</div>
                <h2 class="card-title">AI Customer & Sales Assistants</h2>
                <p class="card-description">
                    Deploy 24/7 intelligent conversational agents across your website and WhatsApp that answer technical questions, qualify leads, and smoothly escalate complex inquiries to human reps.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Omnichannel</span>
                    <span class="tag-chip">Lead Qualification</span>
                    <span class="tag-chip">CRM Hand-off</span>
                </div>
            </div>

            <!-- 4. Domain Knowledge Bases -->
            <div class="card">
                <div class="card-icon">🔍</div>
                <h2 class="card-title">Internal Employee Assistants</h2>
                <p class="card-description">
                    Empower your workforce with an internal AI expert that searches across internal Confluence, Notion, Google Drive, and code repositories to deliver instant answers.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Role-Based Access</span>
                    <span class="tag-chip">Permission Filtering</span>
                    <span class="tag-chip">Zero Data Leakage</span>
                </div>
            </div>

            <!-- 5. AI Analytics & Predictive Insights -->
            <div class="card">
                <div class="card-icon">📊</div>
                <h2 class="card-title">Natural Language Data Analytics</h2>
                <p class="card-description">
                    Allow executives and operators to query complex SQL databases and business dashboards in natural plain English, generating instant charts and structured insights.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Text-to-SQL</span>
                    <span class="tag-chip">Read-only Guardrails</span>
                    <span class="tag-chip">Automated Summaries</span>
                </div>
            </div>

            <!-- 6. Private Model Deployment -->
            <div class="card">
                <div class="card-icon">🔒</div>
                <h2 class="card-title">Data Privacy & Self-Hosted AI</h2>
                <p class="card-description">
                    For sensitive healthcare, legal, or financial contexts, we deploy open-weight models (Llama 3, Mistral) on dedicated virtual private cloud (VPC) hardware with zero external data sharing.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">VPC Isolated</span>
                    <span class="tag-chip">GDPR Compliant</span>
                    <span class="tag-chip">No Third-party Training</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Practical AI Engineering Architecture -->
<section class="section" style="background: rgba(11, 31, 58, 0.3);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Our AI Architecture</span>
            </div>
            <h2 class="section-title">How We Prevent AI Hallucinations</h2>
            <p class="section-subtitle">
                Enterprise AI requires deterministic boundaries. We implement production guardrails at every layer of the inference pipeline.
            </p>
        </div>

        <div class="transformation-container" style="grid-template-columns: 1fr 1fr 1fr;">
            <div class="card">
                <div style="color: var(--cyan); font-weight: 700; margin-bottom: 0.5rem;">Layer 1: Context Grounding</div>
                <p style="font-size: 0.9rem; color: var(--slate);">The AI model is fed only verified, retrieved documents with semantic similarity thresholds, preventing speculation.</p>
            </div>
            <div class="card">
                <div style="color: var(--cyan); font-weight: 700; margin-bottom: 0.5rem;">Layer 2: Schema Output Guardrails</div>
                <p style="font-size: 0.9rem; color: var(--slate);">Outputs are forced into strictly validated JSON schemas with runtime type validation before reaching user interfaces.</p>
            </div>
            <div class="card">
                <div style="color: var(--cyan); font-weight: 700; margin-bottom: 0.5rem;">Layer 3: Human Verification Loop</div>
                <p style="font-size: 0.9rem; color: var(--slate);">High-impact actions (e.g. issuing refunds, deleting records, sending external contracts) require explicit human sign-off.</p>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to build practical AI for your operations?";
$ctaSubtitle = "Schedule a discovery call to review your data sources, feasibility, and architecture with our engineering team.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
