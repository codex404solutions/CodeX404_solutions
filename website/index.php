<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Software & AI that moves your business forward',
    'description' => 'CodeX404 Solutions designs, builds and automates digital systems helping growing businesses operate smarter, move faster and scale with confidence.',
    'canonical' => BASE_URL,
    'keywords' => 'custom software development, business AI solutions, AI agents, workflow automation, SaaS MVP development, enterprise systems'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- ==========================================================================
     HERO SECTION
     ========================================================================== -->
<section class="hero-section">
    <div class="container hero-grid">
        <div class="hero-content">
            <div class="hero-pill">
                <span class="dot"></span>
                <span>AI & Software Engineering Partner</span>
            </div>

            <h1 class="hero-headline">
                Software & AI that moves your business <span class="text-gradient">forward.</span>
            </h1>

            <p class="hero-description">
                We design, build and automate digital systems that help growing businesses operate smarter, move faster and scale with confidence.
            </p>

            <div class="hero-cta-group">
                <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-lg">
                    Book a Discovery Call
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
                <a href="<?= url('solutions.php') ?>" class="btn btn-secondary btn-lg">
                    Explore Solutions
                </a>
            </div>

            <!-- Value / Capability Strip -->
            <div class="hero-stats-strip">
                <div class="stat-item">
                    <strong>100%</strong>
                    <span>Direct Senior Engineering</span>
                </div>
                <div class="stat-item">
                    <strong>Production</strong>
                    <span>Resilient & Secure Code</span>
                </div>
                <div class="stat-item">
                    <strong>Zero Lock-in</strong>
                    <span>Full IP Ownership</span>
                </div>
            </div>
        </div>

        <!-- Abstract Interactive Technical Frame -->
        <div class="hero-visual">
            <div class="tech-frame">
                <div class="tech-frame-header">
                    <div class="window-dots">
                        <span class="dot-red"></span>
                        <span class="dot-yellow"></span>
                        <span class="dot-green"></span>
                    </div>
                    <div class="frame-title">codex404.pipeline.architecture // v2.6</div>
                    <div style="font-size: 0.75rem; color: #34D399;">● READY</div>
                </div>
                <div class="tech-frame-body">
                    <div class="code-comment">// Operational transformation pipeline</div>
                    <div><span class="code-keyword">const</span> system = <span class="code-accent">new</span> CodeX404Architecture({</div>
                    <div style="padding-left: 1.25rem;">client: <span class="code-string">"Growing Enterprise"</span>,</div>
                    <div style="padding-left: 1.25rem;">core: [<span class="code-string">"Build"</span>, <span class="code-string">"Automate"</span>, <span class="code-string">"Scale"</span>],</div>
                    <div style="padding-left: 1.25rem;">stack: [<span class="code-string">"Cloud APIs"</span>, <span class="code-string">"RAG Agents"</span>, <span class="code-string">"Microservices"</span>],</div>
                    <div style="padding-left: 1.25rem;">security: <span class="code-accent">ZeroTrust_GDPR_Compliant</span></div>
                    <div>});</div>
                    <br>
                    <div class="code-comment">// Deploy autonomous execution flow</div>
                    <div><span class="code-keyword">await</span> system.<span class="code-accent">optimizeWorkflows</span>();</div>
                    <div style="color: #34D399; margin-top: 0.5rem;">
                        ✔ Manual bottlenecks eliminated (-68% latency)<br>
                        ✔ Real-time sync across ERP, CRM & AI models<br>
                        ✔ Production deployment: healthy
                    </div>
                    <div class="pipeline-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        Continuous High-Availability Pipeline
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     PROBLEM TO SOLUTION TRANSFORMATION SECTION
     ========================================================================== -->
<section class="section" style="background: rgba(11, 31, 58, 0.2);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>The Operational Reality</span>
            </div>
            <h2 class="section-title">Turning Friction into Velocity</h2>
            <p class="section-subtitle">
                Most growing businesses are held back by fragmented tools, repetitive spreadsheet operations, and disconnected workflows. Here is how we bridge the gap.
            </p>
        </div>

        <div class="transformation-container">
            <!-- Manual Inefficient Reality -->
            <div class="transform-box problem">
                <span class="transform-badge">Typical Bottlenecks</span>
                <h3 style="margin-bottom: 1rem; color: #FCA5A5;">Fragmented Manual Work</h3>
                <ul class="transform-list">
                    <li>
                        <span style="color: #EF4444; font-weight: bold;">✕</span>
                        <span>Key customer and financial data trapped across multiple spreadsheets.</span>
                    </li>
                    <li>
                        <span style="color: #EF4444; font-weight: bold;">✕</span>
                        <span>Hours wasted copying inquiries between WhatsApp, Gmail, and CRM tools.</span>
                    </li>
                    <li>
                        <span style="color: #EF4444; font-weight: bold;">✕</span>
                        <span>Slow response times leading to qualified lead leakage and missed revenue.</span>
                    </li>
                    <li>
                        <span style="color: #EF4444; font-weight: bold;">✕</span>
                        <span>Legacy off-the-shelf software with rigid limitations and escalating SaaS costs.</span>
                    </li>
                </ul>
            </div>

            <!-- Transformation Node -->
            <div class="transform-arrow-center" title="CodeX404 Engineering Shift">
                ⚡
            </div>

            <!-- CodeX404 Solution -->
            <div class="transform-box solution">
                <span class="transform-badge">The CodeX404 System</span>
                <h3 style="margin-bottom: 1rem; color: var(--cyan);">Bespoke Software + AI</h3>
                <ul class="transform-list">
                    <li>
                        <span style="color: #10B981; font-weight: bold;">✓</span>
                        <span>Centralized database architecture with real-time role-based access.</span>
                    </li>
                    <li>
                        <span style="color: #10B981; font-weight: bold;">✓</span>
                        <span>Autonomous multi-channel pipelines syncing orders, leads, and documents.</span>
                    </li>
                    <li>
                        <span style="color: #10B981; font-weight: bold;">✓</span>
                        <span>Instant AI-driven customer and employee knowledge assistants answering queries in seconds.</span>
                    </li>
                    <li>
                        <span style="color: #10B981; font-weight: bold;">✓</span>
                        <span>Custom-built proprietary software tailored precisely to your operational workflow.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     CORE CAPABILITIES / SOLUTIONS GRID
     ========================================================================== -->
<section class="section" id="solutions">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Our Capabilities</span>
            </div>
            <h2 class="section-title">Built for Performance. Engineered to Scale.</h2>
            <p class="section-subtitle">
                Comprehensive digital engineering across full-stack applications, enterprise AI, intelligent automations, and scalable cloud platforms.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- 1. Software Development -->
            <div class="card">
                <div class="card-icon">💻</div>
                <h3 class="card-title">Custom Software & Web Apps</h3>
                <p class="card-description">
                    High-performance business applications, customer portals, custom CRMs, and internal ERP systems tailored to your workflows.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">PHP / Python</span>
                    <span class="tag-chip">Modern JavaScript</span>
                    <span class="tag-chip">MySQL / PostgreSQL</span>
                    <span class="tag-chip">REST APIs</span>
                </div>
                <a href="<?= url('software-development.php') ?>" class="card-arrow-link">
                    Explore Software Development →
                </a>
            </div>

            <!-- 2. AI Solutions -->
            <div class="card">
                <div class="card-icon">🤖</div>
                <h3 class="card-title">Enterprise AI & Knowledge Systems</h3>
                <p class="card-description">
                    Retrieval-Augmented Generation (RAG), private enterprise knowledge bases, document intelligence, and conversational assistants.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">RAG Systems</span>
                    <span class="tag-chip">Vector Databases</span>
                    <span class="tag-chip">Document OCR</span>
                    <span class="tag-chip">Domain Assistants</span>
                </div>
                <a href="<?= url('ai-solutions.php') ?>" class="card-arrow-link">
                    Explore AI Solutions →
                </a>
            </div>

            <!-- 3. AI Agents -->
            <div class="card">
                <div class="card-icon">🧠</div>
                <h3 class="card-title">Autonomous AI Agents</h3>
                <p class="card-description">
                    Goal-oriented agents that interact with external APIs, databases, and software tools to execute multi-step operational tasks with human oversight.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Tool Calling</span>
                    <span class="tag-chip">Workflow Execution</span>
                    <span class="tag-chip">Human-in-the-Loop</span>
                    <span class="tag-chip">Audit Trails</span>
                </div>
                <a href="<?= url('ai-agents.php') ?>" class="card-arrow-link">
                    Explore AI Agents →
                </a>
            </div>

            <!-- 4. Automation -->
            <div class="card">
                <div class="card-icon">⚡</div>
                <h3 class="card-title">Workflow & Process Automation</h3>
                <p class="card-description">
                    Connect disconnected systems. End-to-end CRM synchronization, WhatsApp/Email notification pipelines, and automated reporting.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">CRM Automation</span>
                    <span class="tag-chip">WhatsApp API</span>
                    <span class="tag-chip">Webhooks</span>
                    <span class="tag-chip">Scheduled Jobs</span>
                </div>
                <a href="<?= url('automation.php') ?>" class="card-arrow-link">
                    Explore Automation →
                </a>
            </div>

            <!-- 5. Mobile Applications -->
            <div class="card">
                <div class="card-icon">📱</div>
                <h3 class="card-title">Cross-Platform Mobile Apps</h3>
                <p class="card-description">
                    Intuitive, responsive iOS and Android applications built for high performance, offline resilience, and seamless API synchronization.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">iOS & Android</span>
                    <span class="tag-chip">Cross-Platform</span>
                    <span class="tag-chip">Offline Sync</span>
                    <span class="tag-chip">Secure Auth</span>
                </div>
                <a href="<?= url('mobile-apps.php') ?>" class="card-arrow-link">
                    Explore Mobile Apps →
                </a>
            </div>

            <!-- 6. SaaS Development -->
            <div class="card">
                <div class="card-icon">🚀</div>
                <h3 class="card-title">SaaS & MVP Engineering</h3>
                <p class="card-description">
                    Turn software concepts into scalable cloud products with multi-tenant data architecture, subscription billing, and administrative dashboards.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Rapid MVP</span>
                    <span class="tag-chip">Multi-Tenant</span>
                    <span class="tag-chip">Razorpay / Stripe</span>
                    <span class="tag-chip">Admin Telemetry</span>
                </div>
                <a href="<?= url('saas.php') ?>" class="card-arrow-link">
                    Explore SaaS Development →
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     PROVEN DELIVERY PROCESS (7 STEPS)
     ========================================================================== -->
<section class="section" style="background: rgba(11, 31, 58, 0.3);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Our Methodology</span>
            </div>
            <h2 class="section-title">The 7-Stage Engineering Framework</h2>
            <p class="section-subtitle">
                A disciplined, transparent delivery cadence engineered to eliminate ambiguity and guarantee production readiness.
            </p>
        </div>

        <div class="process-grid">
            <div class="process-step">
                <div class="step-num">01</div>
                <h3>Discover</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Deconstruct operational friction, user requirements, data sources, and target business outcomes.</p>
            </div>
            <div class="process-step">
                <div class="step-num">02</div>
                <h3>Strategize</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Define system architecture, database schema, security boundaries, and technical stack selection.</p>
            </div>
            <div class="process-step">
                <div class="step-num">03</div>
                <h3>Design</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Create wireframes, intuitive user flows, responsive UI layouts, and interactive prototypes.</p>
            </div>
            <div class="process-step">
                <div class="step-num">04</div>
                <h3>Build</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Write clean, modular code with strict typing, API contracts, and defensive error handling.</p>
            </div>
            <div class="process-step">
                <div class="step-num">05</div>
                <h3>Test</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Rigorous automated and manual QA covering security vulnerabilities, mobile UX, and edge cases.</p>
            </div>
            <div class="process-step">
                <div class="step-num">06</div>
                <h3>Launch</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Zero-downtime deployment, DNS provisioning, SSL encryption, and smoke validation in production.</p>
            </div>
            <div class="process-step">
                <div class="step-num">07</div>
                <h3>Scale</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Continuous telemetry, performance tuning, automation expansion, and iterative feature sprints.</p>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2.5rem;">
            <a href="<?= url('process.php') ?>" class="btn btn-secondary">
                View Full Process Details →
            </a>
        </div>
    </div>
</section>

<!-- ==========================================================================
     FEATURED CASE STUDIES
     ========================================================================== -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Verified Deliverables</span>
            </div>
            <h2 class="section-title">Practical Engineering Case Studies</h2>
            <p class="section-subtitle">
                Real software and automation projects built to solve tangible business operations.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- Case Study 1 -->
            <div class="card">
                <div style="font-size: 0.8rem; color: var(--cyan); text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem;">Education & Enterprise</div>
                <h3 class="card-title">School ERP & Administrative Portal</h3>
                <p class="card-description">
                    Consolidated student records, fee collection, staff attendance, and parent communication into a unified role-based management web platform.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">PHP</span>
                    <span class="tag-chip">MySQL</span>
                    <span class="tag-chip">RBAC Security</span>
                    <span class="tag-chip">Fee Automation</span>
                </div>
                <div style="margin-top: 1.25rem; font-size: 0.85rem; color: #34D399;">
                    ✓ Replaced paper registers across 4 departments
                </div>
            </div>

            <!-- Case Study 2 -->
            <div class="card">
                <div style="font-size: 0.8rem; color: var(--cyan); text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem;">Sales Automation</div>
                <h3 class="card-title">Multi-Channel Lead Capture & CRM Pipeline</h3>
                <p class="card-description">
                    Built an automated inbound lead ingestion engine connecting website forms, WhatsApp messages, and email inquiries into a structured pipeline.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Webhook Ingestion</span>
                    <span class="tag-chip">WhatsApp Business API</span>
                    <span class="tag-chip">Idempotent Delivery</span>
                </div>
                <div style="margin-top: 1.25rem; font-size: 0.85rem; color: #34D399;">
                    ✓ Lead response time reduced from 4 hours to under 3 minutes
                </div>
            </div>

            <!-- Case Study 3 -->
            <div class="card">
                <div style="font-size: 0.8rem; color: var(--cyan); text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem;">Retail & Commerce</div>
                <h3 class="card-title">B2B E-Commerce & Secure Checkout Engine</h3>
                <p class="card-description">
                    Developed a robust custom ordering portal featuring live inventory sync, payment gateway integration, automated invoice generation, and order tracking.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Payment Gateway</span>
                    <span class="tag-chip">Real-time Inventory</span>
                    <span class="tag-chip">PDF Invoice Engine</span>
                </div>
                <div style="margin-top: 1.25rem; font-size: 0.85rem; color: #34D399;">
                    ✓ Zero inventory reconciliation errors post-launch
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2.5rem;">
            <a href="<?= url('case-studies.php') ?>" class="btn btn-secondary">
                Read All Case Studies →
            </a>
        </div>
    </div>
</section>

<!-- ==========================================================================
     LEADERSHIP SECTION
     ========================================================================== -->
<?php include __DIR__ . '/components/leadership.php'; ?>

<!-- ==========================================================================
     CONVERSION CTA SECTION
     ========================================================================== -->
<?php
$ctaHeading = "Ready to elevate your technology capabilities?";
$ctaSubtitle = "Whether you need to build custom software from scratch, automate high-friction workflows, or explore applied AI — we are ready to partner.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
