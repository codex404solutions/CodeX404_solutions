<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Selected Engineering Portfolio & Systems',
    'description' => 'Explore selected software development, business systems, web applications, and AI automation projects engineered by CodeX404 Solutions.',
    'canonical' => url('portfolio.php'),
    'keywords' => 'software portfolio, web development projects, custom software deliverables, AI projects'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Selected Deliverables</span>
            </div>
            <h1 class="section-title">Engineered Deliverables & Practical Systems</h1>
            <p class="section-subtitle">
                A selection of digital products, operational software, and automation engines delivered by CodeX404 Solutions with precision and clean architecture.
            </p>
        </div>

        <!-- Filter Buttons -->
        <div style="display: flex; justify-content: center; gap: 0.75rem; margin-bottom: 3rem; flex-wrap: wrap;">
            <button type="button" class="btn btn-secondary btn-sm filter-btn active" data-filter="all">All Projects</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="software">Business Software</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="web">Web Platforms</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="ai">AI & Automation</button>
        </div>

        <div class="grid grid-cols-3">
            <!-- Project 1 -->
            <div class="card" data-category="software">
                <div class="card-icon">🏫</div>
                <h2 class="card-title">School ERP & Admin System</h2>
                <p class="card-description">
                    End-to-end institutional management suite with multi-role access for administrators, accountants, teachers, and guardians. Handles fee schedules, ledger audits, and student history.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">PHP 8</span>
                    <span class="tag-chip">MySQL</span>
                    <span class="tag-chip">Admin Telemetry</span>
                </div>
            </div>

            <!-- Project 2 -->
            <div class="card" data-category="ai">
                <div class="card-icon">⚡</div>
                <h2 class="card-title">AI Multi-Channel Pipeline</h2>
                <p class="card-description">
                    Automated lead ingestion and qualification tool syncing WhatsApp Cloud API conversations, email inquiries, and CRM leads with zero manual data entry.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">WhatsApp API</span>
                    <span class="tag-chip">Webhooks</span>
                    <span class="tag-chip">Idempotent Queue</span>
                </div>
            </div>

            <!-- Project 3 -->
            <div class="card" data-category="web">
                <div class="card-icon">🛍️</div>
                <h2 class="card-title">B2B E-Commerce Platform</h2>
                <p class="card-description">
                    Custom wholesale ordering engine featuring volume tier discounts, real-time inventory locking at checkout, automated GST receipts, and payment gateway integration.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Payment Gateway</span>
                    <span class="tag-chip">Secure Cart</span>
                    <span class="tag-chip">Invoicing Engine</span>
                </div>
            </div>

            <!-- Project 4 -->
            <div class="card" data-category="software">
                <div class="card-icon">📊</div>
                <h2 class="card-title">Custom CRM System</h2>
                <p class="card-description">
                    Tailored lead pipeline and account tracking software built with bespoke deal stages, activity timelines, and webhook synchronization to accounting tools.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Pipeline Views</span>
                    <span class="tag-chip">Activity Stream</span>
                    <span class="tag-chip">Zero Seat Fees</span>
                </div>
            </div>

            <!-- Project 5 -->
            <div class="card" data-category="web">
                <div class="card-icon">🌐</div>
                <h2 class="card-title">High-Speed Corporate Web Platform</h2>
                <p class="card-description">
                    Corporate web presence built for high conversion velocity, featuring sub-second load times, structured schema markup, and responsive dark-mode aesthetics.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Vanilla CSS</span>
                    <span class="tag-chip">Core Web Vitals 99+</span>
                    <span class="tag-chip">Clean Architecture</span>
                </div>
            </div>

            <!-- Project 6 -->
            <div class="card" data-category="ai">
                <div class="card-icon">📄</div>
                <h2 class="card-title">Document Intelligence Assistant</h2>
                <p class="card-description">
                    Domain-specific RAG application allowing teams to query complex technical manuals, policy PDFs, and operational schemas in natural language with source citations.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">RAG Assistant</span>
                    <span class="tag-chip">Vector Embeddings</span>
                    <span class="tag-chip">Zero Leakage</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to build your next software deliverable?";
$ctaSubtitle = "Discuss requirements, technical specifications, and milestones directly with our solutions architects.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
