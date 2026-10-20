<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Custom Software Development & Enterprise Web Engineering',
    'description' => 'Bespoke web applications, internal operational control planes, customer portals, custom CRM/ERP engines, and high-throughput APIs engineered for zero technical debt and full IP ownership.',
    'canonical' => url('software-development.php'),
    'keywords' => 'custom software development, bespoke web applications, enterprise ERP, custom CRM systems, partner portals, PHP enterprise engineering, Python FastAPI'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="section" style="padding-top: calc(var(--nav-height) + 3rem); padding-bottom: 3.5rem;">
    <div class="container">
        <div class="section-header" style="max-width: 860px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Product Engineering & Internal Systems</span>
            </div>
            <h1 class="section-title" style="font-size: clamp(2.25rem, 4vw, 3.25rem); line-height: 1.15; margin-bottom: 1.25rem;">
                Custom Software Built Exactly for Your <span class="gradient-text">Operational Workflow</span>
            </h1>
            <p class="section-subtitle" style="font-size: 1.1rem; line-height: 1.7; color: var(--slate); max-width: 740px; margin: 0 auto;">
                Off-the-shelf software forces your business into someone else’s rigid constraints while charging you monthly per-seat penalties. We engineer bespoke web platforms, administrative engines, and customer portals that adapt 100% to how you work.
            </p>
        </div>

        <!-- Problem / Solution Callout Cards -->
        <div class="grid grid-cols-2" style="gap: 2rem; margin-bottom: 4rem;">
            <div class="card" style="border-left: 4px solid #F87171; background: rgba(239, 68, 68, 0.03);">
                <span style="font-size: 0.85rem; font-weight: 700; color: #F87171; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.75rem;">The Operational Bottleneck</span>
                <h3 style="font-size: 1.25rem; color: var(--white); margin-bottom: 0.75rem;">The Fragile Spreadsheet Trap</h3>
                <p style="font-size: 0.925rem; line-height: 1.6; color: var(--slate);">
                    Growing companies often rely on multi-tab Google Sheets or Excel files to manage orders, inventory, staff assignments, and billing. As order volume increases, files corrupt, formulas break, permissions fail, and staff spend hours manually reconciling duplicate rows.
                </p>
            </div>
            <div class="card" style="border-left: 4px solid var(--cyan); background: rgba(34, 211, 238, 0.03);">
                <span style="font-size: 0.85rem; font-weight: 700; color: var(--cyan); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.75rem;">The CodeX404 Solution</span>
                <h3 style="font-size: 1.25rem; color: var(--white); margin-bottom: 0.75rem;">Centralized Web Control Plane</h3>
                <p style="font-size: 0.925rem; line-height: 1.6; color: var(--slate);">
                    We migrate your spreadsheets into a secure relational database (MySQL/PostgreSQL) wrapped in an intuitive, role-based web interface. Data is validated on entry, invoices generate automatically, and teams work concurrently without collision.
                </p>
            </div>
        </div>

        <!-- Capabilities Grid -->
        <div class="grid grid-cols-3" style="gap: 2rem;">
            <!-- 1. Enterprise Web Apps -->
            <div class="card">
                <div class="card-icon">💻</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Full-Stack Web Applications</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Responsive, high-throughput cloud applications with clean architectural patterns, strict relational database design, and sub-200ms page response times for demanding operational environments.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Modern PHP 8.2+</span>
                    <span class="tag-chip">Python FastAPI</span>
                    <span class="tag-chip">Vanilla JS</span>
                    <span class="tag-chip">REST APIs</span>
                </div>
            </div>

            <!-- 2. Client & Partner Portals -->
            <div class="card">
                <div class="card-icon">🛡️</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Secure Client & Vendor Portals</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Provide your high-value clients and suppliers with branded, 24/7 self-service access to invoices, project milestones, file vaults, and order status with granular permission controls.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Role-Based Access (RBAC)</span>
                    <span class="tag-chip">Document Vault</span>
                    <span class="tag-chip">Audit Trails</span>
                    <span class="tag-chip">Branded UX</span>
                </div>
            </div>

            <!-- 3. Bespoke CRM Engines -->
            <div class="card">
                <div class="card-icon">📊</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Proprietary CRM Systems</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Tailored relationship platforms built without seat-based pricing traps. Custom pipeline stages, multi-channel communication logs (WhatsApp, email, phone), and proprietary scoring models.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Unlimited Users</span>
                    <span class="tag-chip">Zero Recurring Seat Fees</span>
                    <span class="tag-chip">Custom Pipeline Stages</span>
                    <span class="tag-chip">Lead Attribution</span>
                </div>
            </div>

            <!-- 4. Operational ERP Platforms -->
            <div class="card">
                <div class="card-icon">🏢</div>
                <h2 class="card-title" style="font-size: 1.3rem;">Internal ERP & Operations Engines</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Consolidate procurement, inventory, dispatch scheduling, staff rosters, and financial accounts into a unified operational dashboard with real-time analytics.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Inventory Tracking</span>
                    <span class="tag-chip">Automated Billing</span>
                    <span class="tag-chip">Staff Roster Sync</span>
                    <span class="tag-chip">PDF Reports</span>
                </div>
            </div>

            <!-- 5. Specialized B2B Commerce Engines -->
            <div class="card">
                <div class="card-icon">🛍️</div>
                <h2 class="card-title" style="font-size: 1.3rem;">B2B Wholesale Commerce</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Password-protected ordering portals with client-specific negotiated pricing tiers, bulk CSV uploads, credit limits, purchase order reconciliation, and live inventory reservations.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Tiered Volume Pricing</span>
                    <span class="tag-chip">Atomic Inventory Locking</span>
                    <span class="tag-chip">Stripe / Razorpay</span>
                    <span class="tag-chip">GST Invoicing</span>
                </div>
            </div>

            <!-- 6. High-Throughput Microservices & APIs -->
            <div class="card">
                <div class="card-icon">⚡</div>
                <h2 class="card-title" style="font-size: 1.3rem;">High-Speed APIs & Microservices</h2>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    Design and deploy resilient RESTful and webhook services with comprehensive OpenAPI documentation, automated rate limiting, token authentication, and background queuing.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">OpenAPI 3.0</span>
                    <span class="tag-chip">Redis Caching</span>
                    <span class="tag-chip">HMAC Signatures</span>
                    <span class="tag-chip">Rate Limiting</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TECHNOLOGY STACK MATRIX -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>The Engineering Foundation</span>
            </div>
            <h2 class="section-title">Battle-Tested Technologies, Zero Experimental Bloat</h2>
            <p class="section-subtitle">
                We select pragmatic, maintainable, and high-performance stacks that keep server overhead low, performance blistering, and developer maintenance effortless.
            </p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.75rem; font-size: 1.2rem;">Backend Systems</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6; margin-bottom: 1rem;">
                    Strictly-typed PHP 8.2+, Python FastAPI, Node.js. Clean object-oriented patterns, dependency injection, and defensive error boundaries.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">PHP 8.2+</span>
                    <span class="tag-chip">FastAPI</span>
                    <span class="tag-chip">Node.js</span>
                </div>
            </div>

            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.75rem; font-size: 1.2rem;">Database & State</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6; margin-bottom: 1rem;">
                    MySQL 8, PostgreSQL, Redis, Qdrant Vector DB. Parameterized prepared queries, composite indexing, and transactional ACID guarantees.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">MySQL 8</span>
                    <span class="tag-chip">PostgreSQL</span>
                    <span class="tag-chip">Redis</span>
                    <span class="tag-chip">Qdrant</span>
                </div>
            </div>

            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.75rem; font-size: 1.2rem;">Frontend & Interface</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6; margin-bottom: 1rem;">
                    Semantic HTML5, Vanilla CSS / Tailwind, modern modular JavaScript, responsive mobile UX, and accessibility-first design systems.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Semantic HTML5</span>
                    <span class="tag-chip">Modern JS</span>
                    <span class="tag-chip">Responsive UX</span>
                </div>
            </div>

            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.75rem; font-size: 1.2rem;">Security & DevOps</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6; margin-bottom: 1rem;">
                    Docker containerization, GitHub Actions CI/CD pipelines, SSL/TLS encryption, CSRF validation, and OWASP Top 10 mitigation.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Docker</span>
                    <span class="tag-chip">CI / CD</span>
                    <span class="tag-chip">OWASP Top 10</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LIVE DEMO & PROOF SECTION -->
<section class="section">
    <div class="container">
        <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-lg); padding: 3rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 2rem;">
            <div style="max-width: 600px;">
                <span class="tag-chip" style="margin-bottom: 0.75rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Verified Deliverables</span>
                <h3 style="font-size: 1.85rem; color: var(--white); margin-bottom: 0.75rem;">Experience Our Deployed Systems in Real Time</h3>
                <p style="font-size: 0.95rem; line-height: 1.6; color: var(--slate);">
                    Test our School ERP management console, B2B wholesale ordering portal, and live AI RAG knowledge system directly in the browser sandbox.
                </p>
            </div>
            <div>
                <a href="<?= url('index.php#projects') ?>" class="btn btn-primary" style="padding: 0.9rem 2rem;">Explore Live Demos ⚡</a>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to Build Software That Gives You an Unfair Operational Advantage?";
$ctaSubtitle = "Let's review your exact operational requirements and deliver a detailed engineering specification, timeline, and milestone budget.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
