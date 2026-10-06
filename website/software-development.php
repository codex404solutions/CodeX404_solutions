<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Custom Software & Enterprise Web Application Engineering',
    'description' => 'Bespoke web applications, customer portals, custom CRM/ERP platforms, and enterprise software built with clean code and zero technical debt.',
    'canonical' => url('software-development.php'),
    'keywords' => 'custom software development, bespoke web applications, enterprise software, custom CRM, custom ERP, customer portals'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Product Engineering</span>
            </div>
            <h1 class="section-title">Custom Software Built Exactly for Your Workflow</h1>
            <p class="section-subtitle">
                Off-the-shelf software forces your business into someone else's rigid mold. We engineer bespoke web applications, administrative control planes, and enterprise systems that adapt precisely to your operational needs.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- 1. Web Applications -->
            <div class="card">
                <div class="card-icon">💻</div>
                <h2 class="card-title">Full-Stack Web Applications</h2>
                <p class="card-description">
                    Responsive, high-speed web apps with clean architecture, strict database integrity, and modern user experiences designed for everyday operational comfort.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Modern PHP / Python</span>
                    <span class="tag-chip">Clean JS</span>
                    <span class="tag-chip">Tailored UX</span>
                </div>
            </div>

            <!-- 2. Customer & Partner Portals -->
            <div class="card">
                <div class="card-icon">🛡️</div>
                <h2 class="card-title">Client & Partner Portals</h2>
                <p class="card-description">
                    Provide your clients and stakeholders with secure, self-serve access to invoices, project milestones, file sharing, and ticket status with granular permissions.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Role-Based Access</span>
                    <span class="tag-chip">Secure Document Vault</span>
                    <span class="tag-chip">Activity Logs</span>
                </div>
            </div>

            <!-- 3. Custom CRM Systems -->
            <div class="card">
                <div class="card-icon">📊</div>
                <h2 class="card-title">Bespoke CRM Systems</h2>
                <p class="card-description">
                    Tailored customer relationship platforms built without seat-based pricing traps. Custom lead stages, multi-touch communications, and proprietary scoring models.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Unlimited Users</span>
                    <span class="tag-chip">Custom Pipeline</span>
                    <span class="tag-chip">Zero Recurring Seat Fees</span>
                </div>
            </div>

            <!-- 4. ERP & Operations Systems -->
            <div class="card">
                <div class="card-icon">🏢</div>
                <h2 class="card-title">Internal ERP & Operations Engines</h2>
                <p class="card-description">
                    Consolidate procurement, inventory, job scheduling, dispatch, and finance into an integrated control room with live operational telemetry.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Inventory Management</span>
                    <span class="tag-chip">Dispatch Scheduling</span>
                    <span class="tag-chip">Audit Trails</span>
                </div>
            </div>

            <!-- 5. E-Commerce Platforms -->
            <div class="card">
                <div class="card-icon">🛍️</div>
                <h2 class="card-title">Specialized E-Commerce Engines</h2>
                <p class="card-description">
                    B2B and high-volume direct-to-consumer commerce platforms featuring custom pricing tiers, bulk order processing, and payment gateway integrations.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">B2B Wholesale</span>
                    <span class="tag-chip">Stripe / Razorpay</span>
                    <span class="tag-chip">Live Inventory Sync</span>
                </div>
            </div>

            <!-- 6. API & Microservices -->
            <div class="card">
                <div class="card-icon">⚡</div>
                <h2 class="card-title">High-Throughput APIs</h2>
                <p class="card-description">
                    Design and deploy resilient RESTful and webhook services with sub-second response times, OpenAPI documentation, and automated rate limiting.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">OpenAPI Specs</span>
                    <span class="tag-chip">Token Authentication</span>
                    <span class="tag-chip">Caching Layers</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Technology Stack Highlight -->
<section class="section" style="background: rgba(11, 31, 58, 0.3);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>The Engineering Foundation</span>
            </div>
            <h2 class="section-title">Battle-Tested Technologies</h2>
            <p class="section-subtitle">
                We select pragmatic, maintainable, and high-performance stacks that keep hosting costs low and developer velocity high.
            </p>
        </div>

        <div class="grid grid-cols-4">
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.5rem; font-size: 1.15rem;">Backend Systems</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">PHP 8.2+, Python FastAPI, Node.js. Clean OOP patterns, dependency injection, defensive error bounds.</p>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.5rem; font-size: 1.15rem;">Database Architecture</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">MySQL 8, PostgreSQL, SQLite, Redis. Parameterized prepared queries, indexing, and strict relational schemas.</p>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.5rem; font-size: 1.15rem;">Frontend Architecture</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">Semantic HTML5, Vanilla CSS / Tailwind, modern modular JavaScript, responsive mobile UX.</p>
            </div>
            <div class="card">
                <h3 style="color: var(--cyan); margin-bottom: 0.5rem; font-size: 1.15rem;">Security & Ops</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">Docker, GitHub Actions CI/CD, SSL/TLS, CSRF protection, OWASP Top 10 mitigation.</p>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to build software that gives you an unfair advantage?";
$ctaSubtitle = "Let's review your product specifications and develop a concrete engineering roadmap with timelines and milestones.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
