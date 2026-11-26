<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Applied AI Solutions & Private RAG Systems | CodeX404 Solutions',
    'description' => 'Build grounded business AI systems: private RAG knowledge assistants, document extraction pipelines, workforce copilots, and access-controlled AI integrations.',
    'canonical' => url('ai-solutions.php'),
    'keywords' => 'applied AI solutions, private RAG applications, vector search, Qdrant AI, document OCR intelligence, bespoke AI assistants, self-hosted LLM'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Services', 'url' => url('solutions.php')],
    ['label' => 'AI Solutions & RAG'],
];
$heroTag = 'AUTOMATE · Applied AI & Knowledge Systems';
$heroTitleHtml = 'Applied AI Systems Built for <span class="text-gradient">Grounded Business Value</span>';
$heroSubtitle = 'We engineer domain-specific AI assistants and document pipelines anchored directly to your approved internal documentation and databases—with source citations, schema validation, and explicit access boundaries.';
$heroActions = [
    ['label' => 'Discuss an AI Use Case', 'url' => url('discovery-call.php') . '?division=AUTOMATE', 'variant' => 'primary'],
    ['label' => 'Explore AI Agents', 'url' => url('ai-agents.php'), 'variant' => 'secondary'],
];
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container">
        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-automate"><?= codex_icon('book', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Private Knowledge RAG Systems</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Connect language models to internal SOPs, manuals, and policies using retrieval-augmented generation that cites source passages and refuses ungrounded answers.
                </p>
                <div class="card-tags"><span class="tag-chip">Hybrid Vector Search</span><span class="tag-chip">Qdrant / pgvector</span><span class="tag-chip">Source Citations</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-automate"><?= codex_icon('file', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Document Intelligence &amp; Extraction</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Extract line items, dates, and structured fields from PDFs, forms, and invoices into validated database records with human review checkpoints.
                </p>
                <div class="card-tags"><span class="tag-chip">OCR Parsing</span><span class="tag-chip">Schema Validation</span><span class="tag-chip">Human Review</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-automate"><?= codex_icon('message', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Customer &amp; Inquiry Assistants</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Deploy structured web and WhatsApp assistants that answer product questions from verified documentation, capture lead context, and escalate to staff cleanly.
                </p>
                <div class="card-tags"><span class="tag-chip">WhatsApp Cloud API</span><span class="tag-chip">Lead Qualification</span><span class="tag-chip">Staff Handoff</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll">
                <div class="card-icon is-automate"><?= codex_icon('search', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Internal Team Copilots</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Give staff fast natural-language search across approved knowledge bases while enforcing role-based permission filters on retrieved records.
                </p>
                <div class="card-tags"><span class="tag-chip">Role Filtering</span><span class="tag-chip">Data Segregation</span><span class="tag-chip">Fast Retrieval</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon is-automate"><?= codex_icon('chart', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Guided Reporting &amp; Querying</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Translate approved reporting questions into strictly read-only, allowlisted queries so managers inspect operational metrics without writing SQL.
                </p>
                <div class="card-tags"><span class="tag-chip">Read-Only Guardrails</span><span class="tag-chip">Allowlisted Views</span><span class="tag-chip">Audit Logs</span></div>
            </article>

            <article class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon is-automate"><?= codex_icon('lock', 24) ?></div>
                <h2 class="card-title" style="font-size: 1.28rem;">Private &amp; Scoped Hosting</h2>
                <p class="card-description" style="font-size: 0.92rem; line-height: 1.65;">
                    Select API-backed or dedicated self-hosted open-weight models according to your data sensitivity, budget, and compliance requirements.
                </p>
                <div class="card-tags"><span class="tag-chip">Isolated Hosting</span><span class="tag-chip">Data Boundaries</span><span class="tag-chip">Zero Training Policies</span></div>
            </article>
        </div>
    </div>
</section>

<!-- 4-LAYER GROUNDED PIPELINE -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;"><span class="dot"></span><span>Reliability Controls</span></div>
            <h2 class="section-title">How We Keep Business AI Grounded</h2>
            <p class="section-subtitle">Practical guardrails that keep outputs verifiable and safe for operational use.</p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card" style="padding: 1.75rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 0.95rem; display: block; margin-bottom: 0.5rem;">LAYER 01</span>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.65rem;">Thresholded Retrieval</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Queries retrieve relevant chunks first; when confidence falls short, the assistant states what is missing instead of guessing.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 0.95rem; display: block; margin-bottom: 0.5rem;">LAYER 02</span>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.65rem;">Validated Schemas</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Structured JSON outputs are checked by runtime parsers before touching downstream databases or APIs.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 0.95rem; display: block; margin-bottom: 0.5rem;">LAYER 03</span>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.65rem;">Source Citations</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Responses reference the indexed document section so team members can inspect source context quickly.</p>
            </div>
            <div class="card" style="padding: 1.75rem;">
                <span style="color: var(--cyan); font-weight: 800; font-size: 0.95rem; display: block; margin-bottom: 0.5rem;">LAYER 04</span>
                <h3 style="color: var(--white); font-size: 1.12rem; margin-bottom: 0.65rem;">Human Approval</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">Sensitive updates, billing triggers, or outbound messages require explicit human review gates.</p>
            </div>
        </div>
    </div>
</section>

<!-- LIVE DEMO BANNER -->
<section class="section">
    <div class="container">
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 2.5rem; text-align: center;">
            <span class="tag-chip" style="margin-bottom: 0.85rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Interactive Sandbox</span>
            <h3 style="font-size: 1.65rem; color: var(--white); margin-bottom: 0.75rem;">Test Our AI RAG &amp; Agent Sandboxes</h3>
            <p style="font-size: 0.98rem; color: var(--slate); max-width: 620px; margin: 0 auto 1.5rem auto; line-height: 1.6;">Try interactive in-browser simulators showing retrieved citations and webhook routing.</p>
            <a href="<?= url('portfolio.php') ?>" class="btn btn-primary">Explore Interactive Deliverables &rarr;</a>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Apply Practical AI to Your Operations?";
$ctaSubtitle = "Book a feasibility call to review your data sources, privacy rules, and realistic automation goals.";
include __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
