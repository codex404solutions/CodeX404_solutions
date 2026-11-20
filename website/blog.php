<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';

$pageMeta = [
    'title' => 'Engineering Insights & Architectural Briefs | CodeX404 Solutions',
    'description' => 'Practical engineering notes on custom software systems, booking engines, performance optimization, and AI automation by CodeX404 Solutions.',
    'canonical' => url('blog.php'),
    'keywords' => 'software engineering blog, booking system architecture, high performance web, AI workflow automation'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- ==========================================================================
     HERO SECTION
     ========================================================================== -->
<section class="page-hero-section" style="padding-top: calc(var(--nav-height) + 3.5rem); padding-bottom: 3rem; text-align: center;">
    <div class="container" style="max-width: 900px; margin: 0 auto;">
        <div class="hero-pill" style="margin: 0 auto 1.5rem auto;">
            <span class="dot"></span>
            <span>Senior Architectural Insights • Practical Engineering</span>
        </div>

        <h1 class="hero-headline" style="font-size: clamp(2.25rem, 4.2vw, 3.5rem); margin-bottom: 1.25rem;">
            Engineering & Strategy <span class="text-gradient gradient-text-animated">Before the Build</span>
        </h1>

        <p class="hero-description" style="margin: 0 auto 2.25rem auto; font-size: 1.15rem; color: var(--slate); max-width: 720px; line-height: 1.7;">
            Architectural decisions that make software systems resilient: what to build, what to measure, and how to avoid costly rework.
        </p>
    </div>
</section>

<!-- ==========================================================================
     ARTICLES GRID
     ========================================================================== -->
<section class="section" style="padding-top: 0; padding-bottom: 4rem;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
            
            <article class="clean-project-card card-tilt" style="padding: 2.25rem;">
                <div class="cpc-header" style="margin-bottom: 1rem;">
                    <span class="cpc-category">Architecture Brief</span>
                    <span class="cpc-badge"><span class="cpc-dot"></span>7 min read</span>
                </div>
                <h3 style="font-size: 1.35rem; font-weight: 800; color: #FFFFFF; margin-bottom: 0.85rem; line-height: 1.35;">
                    Engineering High-Traffic Booking Engines: Zero Double-Booking Architecture
                </h3>
                <p style="color: var(--slate); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                    How transactional database isolation, Redis slot locks, and optimistic concurrency guards prevent appointment collisions in dental clinics and busy restaurants.
                </p>
                <div class="cpc-tags" style="margin-top: auto;">
                    <span class="cpc-tag">Booking Architecture</span>
                    <span class="cpc-tag">Concurrency</span>
                    <span class="cpc-tag">MySQL & Redis</span>
                </div>
            </article>

            <article class="clean-project-card card-tilt" style="padding: 2.25rem;">
                <div class="cpc-header" style="margin-bottom: 1rem;">
                    <span class="cpc-category">Product Strategy</span>
                    <span class="cpc-badge"><span class="cpc-dot"></span>6 min read</span>
                </div>
                <h3 style="font-size: 1.35rem; font-weight: 800; color: #FFFFFF; margin-bottom: 0.85rem; line-height: 1.35;">
                    Scoping MVPs Without Creating Technical Debt: The Single Core Loop
                </h3>
                <p style="color: var(--slate); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                    A rigorous filter for choosing the one primary feedback loop that delivers 80% of client business value before expanding into peripheral features.
                </p>
                <div class="cpc-tags" style="margin-top: auto;">
                    <span class="cpc-tag">MVP Engineering</span>
                    <span class="cpc-tag">Scope Control</span>
                    <span class="cpc-tag">Product Velocity</span>
                </div>
            </article>

            <article class="clean-project-card card-tilt" style="padding: 2.25rem;">
                <div class="cpc-header" style="margin-bottom: 1rem;">
                    <span class="cpc-category">Automation</span>
                    <span class="cpc-badge"><span class="cpc-dot"></span>8 min read</span>
                </div>
                <h3 style="font-size: 1.35rem; font-weight: 800; color: #FFFFFF; margin-bottom: 0.85rem; line-height: 1.35;">
                    From Lead Intake to Accountable Action via WhatsApp Webhooks
                </h3>
                <p style="color: var(--slate); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                    How inbound customer leads should transition from webhook capture to qualification and human approval without turning into an unmonitored automation black box.
                </p>
                <div class="cpc-tags" style="margin-top: auto;">
                    <span class="cpc-tag">WhatsApp API</span>
                    <span class="cpc-tag">Webhooks</span>
                    <span class="cpc-tag">Audit Trail</span>
                </div>
            </article>

            <article class="clean-project-card card-tilt" style="padding: 2.25rem;">
                <div class="cpc-header" style="margin-bottom: 1rem;">
                    <span class="cpc-category">Enterprise AI</span>
                    <span class="cpc-badge"><span class="cpc-dot"></span>9 min read</span>
                </div>
                <h3 style="font-size: 1.35rem; font-weight: 800; color: #FFFFFF; margin-bottom: 0.85rem; line-height: 1.35;">
                    Enterprise RAG: Benchmarking Vector Stores (Qdrant vs pgvector) for Sovereign AI
                </h3>
                <p style="color: var(--slate); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                    A deep dive into high-dimension vector indexing, hybrid lexical search, semantic distance thresholds, and memory budgeting when connecting LLMs to private corporate manuals.
                </p>
                <div class="cpc-tags" style="margin-top: auto;">
                    <span class="cpc-tag">Qdrant Vector DB</span>
                    <span class="cpc-tag">pgvector</span>
                    <span class="cpc-tag">Hybrid Search</span>
                </div>
            </article>

            <article class="clean-project-card card-tilt" style="padding: 2.25rem;">
                <div class="cpc-header" style="margin-bottom: 1rem;">
                    <span class="cpc-category">API Engineering</span>
                    <span class="cpc-badge"><span class="cpc-dot"></span>6 min read</span>
                </div>
                <h3 style="font-size: 1.35rem; font-weight: 800; color: #FFFFFF; margin-bottom: 0.85rem; line-height: 1.35;">
                    Official Meta WhatsApp Cloud API vs Unofficial Scrapers: Enterprise Reliability
                </h3>
                <p style="color: var(--slate); font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                    Why third-party browser automation scripts inevitably get banned, and how official Meta Cloud webhooks guarantee end-to-end encryption, 99.9% deliverability, and Green Tick compliance.
                </p>
                <div class="cpc-tags" style="margin-top: auto;">
                    <span class="cpc-tag">Meta Cloud API</span>
                    <span class="cpc-tag">Webhooks</span>
                    <span class="cpc-tag">Security</span>
                </div>
            </article>

        </div>
    </div>
</section>

<!-- ==========================================================================
     DIRECT CALL TO ACTION
     ========================================================================== -->
<section class="section" style="padding-top: 0; padding-bottom: 5rem;">
    <div class="container">
        <div style="background: rgba(10, 22, 40, 0.7); border: 1px solid var(--border-subtle); border-radius: var(--radius-xl); padding: 3rem; text-align: center;">
            <h2 style="font-size: 1.85rem; color: #FFFFFF; font-weight: 800; margin-bottom: 1rem;">
                Need Architectural Guidance for Your System?
            </h2>
            <p style="color: var(--slate); font-size: 1.05rem; max-width: 620px; margin: 0 auto 2rem auto; line-height: 1.6;">
                Schedule a 30-minute discovery call with senior engineer Muhammad Noukhez for practical system design feedback.
            </p>
            <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-lg">
                <span>📅 Book a Discovery Call</span>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
