<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';

$pageMeta = [
    'title' => 'Software & AI that moves your business forward',
    'description' => 'CodeX404 Solutions designs, builds and automates custom software, enterprise AI, autonomous agents, and workflow systems for growing businesses globally.',
    'canonical' => BASE_URL,
    'keywords' => 'custom software development, business AI solutions, AI agents, workflow automation, SaaS MVP development, enterprise systems'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- ==========================================================================
     HERO SECTION (Preserved & Polished from Screenshot)
     ========================================================================== -->
<section class="hero-section">
    <div class="container hero-grid">
        <div class="hero-content">
            <div class="hero-pill">
                <span class="dot"></span>
                <span>Where Bugs Meet Their Match • Senior Engineering Studio</span>
            </div>

            <h1 class="hero-headline">
                Software & AI that moves your business <span class="text-gradient">forward.</span>
            </h1>

            <p class="hero-description">
                We design, build, and automate high-performance software systems — zero bugs, production-grade cloud architectures, and full IP ownership.
            </p>

            <div class="hero-cta-group">
                <a href="#contact-section" class="btn btn-primary btn-lg">
                    🚀 Start Your Project
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
                <a href="#solutions" class="btn btn-secondary btn-lg">
                    Explore Solutions
                </a>
            </div>

            <!-- Value / Capability Strip -->
            <div class="hero-stats-strip">
                <div class="stat-item">
                    <strong>100%</strong>
                    <span>Senior Direct Engineering</span>
                </div>
                <div class="stat-item">
                    <strong>0 Bugs</strong>
                    <span>Where Bugs Meet Their Match</span>
                </div>
                <div class="stat-item">
                    <strong>Zero Lock-in</strong>
                    <span>Full IP & Code Ownership</span>
                </div>
            </div>
        </div>

        <!-- Interactive Multi-Tab Hero Terminal -->
        <div class="hero-visual">
            <div class="tech-frame">
                <div class="tech-frame-header">
                    <div class="window-dots">
                        <span class="dot-red"></span>
                        <span class="dot-yellow"></span>
                        <span class="dot-green"></span>
                    </div>

                    <!-- Interactive Terminal Tabs -->
                    <div class="terminal-tabs" role="tablist">
                        <button class="terminal-tab-btn active" role="tab" aria-selected="true" data-tab="deploy">
                            🚀 deploy
                        </button>
                        <button class="terminal-tab-btn" role="tab" aria-selected="false" data-tab="audit">
                            🐛 zero-bugs
                        </button>
                        <button class="terminal-tab-btn" role="tab" aria-selected="false" data-tab="agent">
                            🤖 ai-agent
                        </button>
                    </div>

                    <div style="font-size: 0.725rem; color: #34D399; font-family: var(--font-mono);">● LIVE</div>
                </div>

                <div class="tech-frame-body">
                    <!-- Pane 1: Deploy -->
                    <div class="terminal-pane active" id="pane-deploy">
                        <div class="code-comment">// Production Zero-Downtime Deployment</div>
                        <div><span class="code-keyword">$</span> <span class="code-accent">codex404</span> deploy --env production --fast</div>
                        <div style="color: var(--slate); margin-top: 0.35rem;">
                            &rarr; Running automated test suites (128/128 passed)...<br>
                            &rarr; Building hardened Docker container image...<br>
                            &rarr; Verifying TLS 1.3 encryption & rate-limiting...
                        </div>
                        <div style="color: #34D399; margin-top: 0.5rem; font-weight: 500;">
                            ✔ Lighthouse Performance Score: 99/100 ⚡<br>
                            ✔ API p99 Latency: 42ms<br>
                            ✔ Production deployment healthy (zero downtime)
                        </div>
                        <div class="pipeline-badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            Production Pipeline: 99.99% Availability
                        </div>
                    </div>

                    <!-- Pane 2: Audit & Zero Bugs -->
                    <div class="terminal-pane" id="pane-audit">
                        <div class="code-comment">// Deep Security & Bug Elimination Scan</div>
                        <div><span class="code-keyword">$</span> <span class="code-accent">codex404</span> audit --deep --zero-bugs</div>
                        <div style="color: var(--slate); margin-top: 0.35rem;">
                            &rarr; Scanning 48,200 lines across backend & UI...<br>
                            &rarr; Memory leaks: <span style="color: #34D399; font-weight: bold;">0 detected</span><br>
                            &rarr; OWASP Top 10 vulnerabilities: <span style="color: #34D399; font-weight: bold;">0 found</span>
                        </div>
                        <div style="color: #38BDF8; margin-top: 0.5rem; font-weight: 600;">
                            🎯 Where Bugs Meet Their Match — 100% Quality Assurance<br>
                            ✔ Strict type-safety & automated idempotency checks
                        </div>
                        <div class="pipeline-badge" style="background: rgba(56, 189, 248, 0.12); color: #38BDF8; border-color: rgba(56, 189, 248, 0.25);">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                            Deterministic Zero-Defect Guarantee
                        </div>
                    </div>

                    <!-- Pane 3: AI Agent Workflow -->
                    <div class="terminal-pane" id="pane-agent">
                        <div class="code-comment">// Autonomous Enterprise AI & RAG Pipeline</div>
                        <div><span class="code-keyword">$</span> <span class="code-accent">codex404</span> agent --pipeline rag-sync --stream</div>
                        <div style="color: var(--slate); margin-top: 0.35rem;">
                            &rarr; Connecting private Qdrant vector index...<br>
                            &rarr; Synchronizing 14,000 corporate policy files...<br>
                            &rarr; Executing multi-tool agentic resolution loop...
                        </div>
                        <div style="color: #F472B6; margin-top: 0.5rem; font-weight: 500;">
                            ✔ Inbound inquiry auto-resolved in 1.8s<br>
                            ✔ Webhook sync dispatched to CRM & WhatsApp API
                        </div>
                        <div class="pipeline-badge" style="background: rgba(236, 72, 153, 0.12); color: #F472B6; border-color: rgba(236, 72, 153, 0.25);">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            Autonomous Execution with Audit Trail
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     INFINITE DUAL-SPEED TECH STACK MARQUEE SLIDER
     ========================================================================== -->
<section class="tech-marquee-section" aria-label="Supported Engineering Technologies">
    <div class="tech-marquee-wrapper">
        <!-- Row 1: Forward Infinite Scroll -->
        <div class="tech-marquee-track">
            <div class="tech-pill-item"><span class="tech-pill-icon">🐍</span> Python 3.12</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🐘</span> PHP 8.4</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚡</span> JavaScript ESNext</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📘</span> TypeScript</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚛️</span> React & Next.js</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🐬</span> MySQL Enterprise</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🐘</span> PostgreSQL</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🐳</span> Docker Containers</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🤖</span> OpenAI & Anthropic API</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🔌</span> REST & GraphQL APIs</div>
            <!-- Duplicate for seamless infinite loop -->
            <div class="tech-pill-item"><span class="tech-pill-icon">🐍</span> Python 3.12</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🐘</span> PHP 8.4</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚡</span> JavaScript ESNext</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📘</span> TypeScript</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚛️</span> React & Next.js</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🐬</span> MySQL Enterprise</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🐘</span> PostgreSQL</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🐳</span> Docker Containers</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🤖</span> OpenAI & Anthropic API</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🔌</span> REST & GraphQL APIs</div>
        </div>

        <!-- Row 2: Reverse Infinite Scroll -->
        <div class="tech-marquee-track reverse">
            <div class="tech-pill-item"><span class="tech-pill-icon">☁️</span> AWS Cloud Architecture</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚡</span> Redis In-Memory Cache</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🧠</span> Autonomous AI Agents</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🟢</span> Node.js Microservices</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📱</span> Progressive Web Apps (PWA)</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🎯</span> Fastly & Cloudflare CDN</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">💳</span> Stripe & Razorpay Payments</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📊</span> Vector DB (Qdrant & Pinecone)</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🔄</span> CI/CD GitHub Actions</div>
            <!-- Duplicate for seamless infinite loop -->
            <div class="tech-pill-item"><span class="tech-pill-icon">☁️</span> AWS Cloud Architecture</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚡</span> Redis In-Memory Cache</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🧠</span> Autonomous AI Agents</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🟢</span> Node.js Microservices</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📱</span> Progressive Web Apps (PWA)</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🎯</span> Fastly & Cloudflare CDN</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">💳</span> Stripe & Razorpay Payments</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📊</span> Vector DB (Qdrant & Pinecone)</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🔄</span> CI/CD GitHub Actions</div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     THE OPERATIONAL REALITY (PROBLEM TO SOLUTION TRANSFORMATION)
     ========================================================================== -->
<section class="section" style="background: rgba(11, 31, 58, 0.2);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>The Operational Reality</span>
            </div>
            <h2 class="section-title">Eliminating Friction. Engineering Velocity.</h2>
            <p class="section-subtitle">
                Most growing businesses lose hours every day to fragmented tools, fragile spreadsheet workarounds, and manual data re-entry. Here is how CodeX404 transforms your operating model.
            </p>
        </div>

        <div class="transformation-container">
            <!-- Manual Inefficient Reality -->
            <div class="transform-box problem">
                <span class="transform-badge">The Daily Bottlenecks</span>
                <h3 style="margin-bottom: 1rem; color: #FCA5A5;">Fragmented Operations</h3>
                <ul class="transform-list">
                    <li>
                        <span style="color: #EF4444; font-weight: bold;">✕</span>
                        <span><strong>Spreadsheet Dependency:</strong> Critical customer records, fees, and orders trapped in disconnected sheets that break.</span>
                    </li>
                    <li>
                        <span style="color: #EF4444; font-weight: bold;">✕</span>
                        <span><strong>Inquiry Leakage:</strong> Prospects messaging on WhatsApp or web forms wait 4+ hours for manual staff response.</span>
                    </li>
                    <li>
                        <span style="color: #EF4444; font-weight: bold;">✕</span>
                        <span><strong>Escalating SaaS Costs:</strong> Paying high per-seat monthly subscription fees for rigid tools that don't match your workflow.</span>
                    </li>
                    <li>
                        <span style="color: #EF4444; font-weight: bold;">✕</span>
                        <span><strong>Zero IP Ownership:</strong> Relying on closed third-party platforms with no direct access to underlying source code or database.</span>
                    </li>
                </ul>
            </div>

            <!-- Transformation Node -->
            <div class="transform-arrow-center" title="CodeX404 Engineering Shift">
                ⚡
            </div>

            <!-- CodeX404 Solution -->
            <div class="transform-box solution">
                <span class="transform-badge">The CodeX404 Architecture</span>
                <h3 style="margin-bottom: 1rem; color: var(--cyan);">Bespoke Software + Applied AI</h3>
                <ul class="transform-list">
                    <li>
                        <span style="color: #10B981; font-weight: bold;">✓</span>
                        <span><strong>Unified Data Architecture:</strong> Single source of truth database with role-based access, audit logs, and real-time dashboards.</span>
                    </li>
                    <li>
                        <span style="color: #10B981; font-weight: bold;">✓</span>
                        <span><strong>Autonomous Instant Pipelines:</strong> WhatsApp Cloud API & webhooks capture, qualify, and sync inbound leads under 3 minutes.</span>
                    </li>
                    <li>
                        <span style="color: #10B981; font-weight: bold;">✓</span>
                        <span><strong>Domain-Specific AI Knowledge Bases:</strong> Private RAG assistants that answer staff & customer queries with 0 hallucinations.</span>
                    </li>
                    <li>
                        <span style="color: #10B981; font-weight: bold;">✓</span>
                        <span><strong>100% Full IP Ownership:</strong> Clean, documented, zero-dependency codebase that belongs entirely to your business.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     CORE CAPABILITIES & SOLUTIONS PILLARS
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
                Six specialized digital engineering pillars covering custom full-stack software, enterprise AI, autonomous agents, and end-to-end workflow automation.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- 1. Custom Software -->
            <div class="card">
                <div class="card-icon">💻</div>
                <h3 class="card-title">Custom Software & Web Apps</h3>
                <p class="card-description">
                    Tailored business management portals, administrative ERPs, custom CRMs, and customer-facing web platforms engineered around your exact processes.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">PHP 8.4 / Python</span>
                    <span class="tag-chip">MySQL / PostgreSQL</span>
                    <span class="tag-chip">RBAC Security</span>
                    <span class="tag-chip">REST APIs</span>
                </div>
                <a href="<?= url('software-development.php') ?>" class="card-arrow-link">
                    Explore Custom Software →
                </a>
            </div>

            <!-- 2. Enterprise AI -->
            <div class="card">
                <div class="card-icon">🤖</div>
                <h3 class="card-title">Enterprise AI & Knowledge Systems</h3>
                <p class="card-description">
                    Retrieval-Augmented Generation (RAG) engines, private document intelligence, and domain-trained chatbots that query thousands of internal documents securely.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Private RAG</span>
                    <span class="tag-chip">Qdrant Vector DB</span>
                    <span class="tag-chip">Document OCR</span>
                    <span class="tag-chip">Zero Data Leaks</span>
                </div>
                <a href="<?= url('ai-solutions.php') ?>" class="card-arrow-link">
                    Explore Enterprise AI →
                </a>
            </div>

            <!-- 3. AI Agents -->
            <div class="card">
                <div class="card-icon">🧠</div>
                <h3 class="card-title">Autonomous AI Agents</h3>
                <p class="card-description">
                    Multi-step autonomous agents equipped with tool-calling capabilities to query APIs, reconcile spreadsheets, verify documents, and dispatch alerts with human oversight.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Tool Calling</span>
                    <span class="tag-chip">Multi-Step Execution</span>
                    <span class="tag-chip">Human-in-the-Loop</span>
                    <span class="tag-chip">Traceable Logs</span>
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
                    Eliminate repetitive manual coordination. Seamless WhatsApp Business API integrations, instant CRM sync, automated invoicing, and asynchronous webhooks.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">WhatsApp Cloud API</span>
                    <span class="tag-chip">CRM Pipelines</span>
                    <span class="tag-chip">Automated Invoicing</span>
                    <span class="tag-chip">Webhooks</span>
                </div>
                <a href="<?= url('automation.php') ?>" class="card-arrow-link">
                    Explore Automation →
                </a>
            </div>

            <!-- 5. Mobile Applications -->
            <div class="card">
                <div class="card-icon">📱</div>
                <h3 class="card-title">Cross-Platform Mobile Apps & PWA</h3>
                <p class="card-description">
                    High-performance mobile applications and resilient Progressive Web Apps featuring offline synchronization, localized caching, and responsive biometric auth.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">iOS & Android</span>
                    <span class="tag-chip">PWA Offline Cache</span>
                    <span class="tag-chip">IndexedDB Sync</span>
                    <span class="tag-chip">Push Alerts</span>
                </div>
                <a href="<?= url('mobile-apps.php') ?>" class="card-arrow-link">
                    Explore Mobile Apps →
                </a>
            </div>

            <!-- 6. SaaS Development -->
            <div class="card">
                <div class="card-icon">🚀</div>
                <h3 class="card-title">SaaS Product & MVP Engineering</h3>
                <p class="card-description">
                    Turn your proprietary domain knowledge into a scalable software-as-a-service with multi-tenant database isolation, Stripe/Razorpay billing, and analytics dashboards.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Rapid MVP Launch</span>
                    <span class="tag-chip">Multi-Tenant Isolation</span>
                    <span class="tag-chip">Subscription Billing</span>
                    <span class="tag-chip">Audit Telemetry</span>
                </div>
                <a href="<?= url('saas.php') ?>" class="card-arrow-link">
                    Explore SaaS Development →
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     PROJECTS & LIVE DEMOS SHOWCASE (CLEAR, PROMINENT & INTERACTIVE)
     ========================================================================== -->
<section class="section" id="projects-showcase" style="background: rgba(6, 11, 24, 0.7); position: relative;">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Verified Deliverables & Live Demos</span>
            </div>
            <h2 class="section-title">Production Systems & Interactive Demos</h2>
            <p class="section-subtitle">
                Real software, AI pipelines, and operational systems engineered for growing companies. Filter by domain or launch an interactive live demo directly in your browser.
            </p>
        </div>

        <!-- Category Filter Tabs -->
        <div class="project-filter-bar" role="tablist" aria-label="Project Categories">
            <button type="button" class="project-filter-btn active" data-filter="all">
                <span>✦</span> All Projects (6)
            </button>
            <button type="button" class="project-filter-btn" data-filter="ai">
                <span>🤖</span> AI & Agents (2)
            </button>
            <button type="button" class="project-filter-btn" data-filter="software">
                <span>💻</span> Custom Software & ERP (2)
            </button>
            <button type="button" class="project-filter-btn" data-filter="commerce">
                <span>🛍️</span> Commerce & SaaS (1)
            </button>
            <button type="button" class="project-filter-btn" data-filter="mobile">
                <span>📱</span> Mobile & PWA (1)
            </button>
        </div>

        <!-- Project Cards Grid -->
        <div class="project-showcase-grid">

            <!-- PROJECT 1: AI RAG Assistant -->
            <article class="project-card" data-category="ai">
                <div class="project-mockup-frame">
                    <div class="project-mockup-header">
                        <div class="project-mockup-dots">
                            <span class="dot-red"></span>
                            <span class="dot-yellow"></span>
                            <span class="dot-green"></span>
                        </div>
                        <span style="font-size: 0.75rem; color: var(--slate); font-family: var(--font-mono);">rag-assistant.codex404.internal</span>
                        <span class="project-badge-pill live">● Production Live</span>
                    </div>
                    <div class="project-mockup-screen">
                        <div class="mockup-ui-bar">
                            <span style="color: #A78BFA;">🤖 Qdrant Vector Search</span>
                            <span style="color: #34D399;">Latency: 142ms</span>
                        </div>
                        <div class="mockup-stat-row">
                            <div class="mockup-stat-cell">
                                <strong>14,200+</strong>
                                <span>Indexed Docs</span>
                            </div>
                            <div class="mockup-stat-cell">
                                <strong>99.4%</strong>
                                <span>Precision Rate</span>
                            </div>
                            <div class="mockup-stat-cell">
                                <strong>0</strong>
                                <span>Cloud Leakage</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="project-card-body">
                    <div class="project-category" style="color: #A78BFA;">Enterprise Applied AI</div>
                    <h3 class="project-title">Enterprise RAG Knowledge Assistant</h3>
                    <p class="project-problem">
                        <strong>Problem:</strong> Technical manuals, compliance policies, and SOPs were scattered across 14,000 PDFs, taking staff 45+ minutes to find accurate information.
                    </p>
                    <p class="project-solution">
                        <strong>Engineering Solution:</strong> Built a private retrieval-augmented generation engine with Qdrant vector indexing, hybrid keyword search, and role-based permissions.
                    </p>
                    <div class="project-metric-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Sub-second semantic search with 0 hallucination leaks</span>
                    </div>
                    <div class="project-tags">
                        <span class="tag-chip">Python 3.12</span>
                        <span class="tag-chip">Qdrant Vector DB</span>
                        <span class="tag-chip">Hybrid RAG</span>
                        <span class="tag-chip">FastAPI</span>
                    </div>
                    <div class="project-actions">
                        <button type="button" class="btn-demo-trigger" data-demo="rag">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            Launch Live Interactive Demo
                        </button>
                        <a href="<?= url('case-studies.php') ?>" class="btn-case-link">
                            Case Details →
                        </a>
                    </div>
                </div>
            </article>

            <!-- PROJECT 2: WhatsApp Automation -->
            <article class="project-card" data-category="ai">
                <div class="project-mockup-frame">
                    <div class="project-mockup-header">
                        <div class="project-mockup-dots">
                            <span class="dot-red"></span>
                            <span class="dot-yellow"></span>
                            <span class="dot-green"></span>
                        </div>
                        <span style="font-size: 0.75rem; color: var(--slate); font-family: var(--font-mono);">pipeline.whatsapp-sync</span>
                        <span class="project-badge-pill demo">⚡ Interactive Demo Ready</span>
                    </div>
                    <div class="project-mockup-screen">
                        <div class="mockup-ui-bar">
                            <span style="color: #25D366;">💬 WhatsApp Cloud Webhook</span>
                            <span style="color: #38BDF8;">Auto-CRM Sync</span>
                        </div>
                        <div class="mockup-stat-row">
                            <div class="mockup-stat-cell">
                                <strong style="color: #25D366;">&lt; 3 mins</strong>
                                <span>Response Time</span>
                            </div>
                            <div class="mockup-stat-cell">
                                <strong>100%</strong>
                                <span>Leads Captured</span>
                            </div>
                            <div class="mockup-stat-cell">
                                <strong style="color: #34D399;">+110%</strong>
                                <span>Conversion Rate</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="project-card-body">
                    <div class="project-category" style="color: #34D399;">Workflow Automation & AI</div>
                    <h3 class="project-title">Multi-Channel WhatsApp Lead Ingestion Pipeline</h3>
                    <p class="project-problem">
                        <strong>Problem:</strong> High-intent customer inquiries via WhatsApp, website forms, and email waited an average of 4 hours for manual staff follow-up.
                    </p>
                    <p class="project-solution">
                        <strong>Engineering Solution:</strong> Developed an asynchronous webhook pipeline that auto-qualifies leads, replies via WhatsApp API in 900ms, and updates CRM deal stages.
                    </p>
                    <div class="project-metric-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Response latency: 4 hours &rarr; under 3 minutes</span>
                    </div>
                    <div class="project-tags">
                        <span class="tag-chip">WhatsApp Cloud API</span>
                        <span class="tag-chip">PHP 8.4</span>
                        <span class="tag-chip">Idempotent Worker</span>
                        <span class="tag-chip">CRM Webhook</span>
                    </div>
                    <div class="project-actions">
                        <button type="button" class="btn-demo-trigger" data-demo="wa">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            Launch Live Interactive Demo
                        </button>
                        <a href="<?= url('case-studies.php') ?>" class="btn-case-link">
                            Case Details →
                        </a>
                    </div>
                </div>
            </article>

            <!-- PROJECT 3: School ERP -->
            <article class="project-card" data-category="software">
                <div class="project-mockup-frame">
                    <div class="project-mockup-header">
                        <div class="project-mockup-dots">
                            <span class="dot-red"></span>
                            <span class="dot-yellow"></span>
                            <span class="dot-green"></span>
                        </div>
                        <span style="font-size: 0.75rem; color: var(--slate); font-family: var(--font-mono);">erp.institution-portal</span>
                        <span class="project-badge-pill live">● Production Live</span>
                    </div>
                    <div class="project-mockup-screen">
                        <div class="mockup-ui-bar">
                            <span style="color: #38BDF8;">🏫 Academic Ledger & Fees</span>
                            <span style="color: #34D399;">Role: SuperAdmin</span>
                        </div>
                        <div class="mockup-stat-row">
                            <div class="mockup-stat-cell">
                                <strong>4,800+</strong>
                                <span>Students Managed</span>
                            </div>
                            <div class="mockup-stat-cell">
                                <strong>4 Roles</strong>
                                <span>Strict RBAC</span>
                            </div>
                            <div class="mockup-stat-cell">
                                <strong style="color: #34D399;">0 Errors</strong>
                                <span>Fee Ledgers</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="project-card-body">
                    <div class="project-category" style="color: #38BDF8;">Custom Enterprise Software</div>
                    <h3 class="project-title">School ERP & Administrative Portal</h3>
                    <p class="project-problem">
                        <strong>Problem:</strong> Administrative staff managed student fee collections, academic marks, and parent notifications across 12 manual paper registers.
                    </p>
                    <p class="project-solution">
                        <strong>Engineering Solution:</strong> Engineered a unified role-based web platform consolidating student lifecycles, automated fee receipts, ledger audits, and staff records.
                    </p>
                    <div class="project-metric-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Replaced paper ledgers across 4 departments</span>
                    </div>
                    <div class="project-tags">
                        <span class="tag-chip">PHP 8.4</span>
                        <span class="tag-chip">MySQL Enterprise</span>
                        <span class="tag-chip">RBAC Security</span>
                        <span class="tag-chip">Audit Logs</span>
                    </div>
                    <div class="project-actions">
                        <button type="button" class="btn-demo-trigger" data-demo="erp">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            Launch Live Interactive Demo
                        </button>
                        <a href="<?= url('case-studies.php') ?>" class="btn-case-link">
                            Case Details →
                        </a>
                    </div>
                </div>
            </article>

            <!-- PROJECT 4: B2B E-Commerce -->
            <article class="project-card" data-category="commerce">
                <div class="project-mockup-frame">
                    <div class="project-mockup-header">
                        <div class="project-mockup-dots">
                            <span class="dot-red"></span>
                            <span class="dot-yellow"></span>
                            <span class="dot-green"></span>
                        </div>
                        <span style="font-size: 0.75rem; color: var(--slate); font-family: var(--font-mono);">store.b2b-checkout</span>
                        <span class="project-badge-pill demo">⚡ Interactive Demo Ready</span>
                    </div>
                    <div class="project-mockup-screen">
                        <div class="mockup-ui-bar">
                            <span style="color: #EC4899;">🛍️ Wholesale Tier Engine</span>
                            <span style="color: #34D399;">Live Stock Lock</span>
                        </div>
                        <div class="mockup-stat-row">
                            <div class="mockup-stat-cell">
                                <strong>Tier 3</strong>
                                <span>Bulk Pricing</span>
                            </div>
                            <div class="mockup-stat-cell">
                                <strong>Instant</strong>
                                <span>GST PDF Invoice</span>
                            </div>
                            <div class="mockup-stat-cell">
                                <strong style="color: #34D399;">0 Errors</strong>
                                <span>Stock Mismatch</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="project-card-body">
                    <div class="project-category" style="color: #F472B6;">B2B Commerce & SaaS</div>
                    <h3 class="project-title">B2B Wholesale Ordering & Invoice Engine</h3>
                    <p class="project-problem">
                        <strong>Problem:</strong> Wholesale buyers phoned in orders; inventory counts frequently conflicted with warehouse stock, and tax invoice generation took 3 days.
                    </p>
                    <p class="project-solution">
                        <strong>Engineering Solution:</strong> Custom wholesale ordering system with real-time inventory reservation, volume tier discounts, automated GST invoice PDF generation, and Razorpay/Stripe checkout.
                    </p>
                    <div class="project-metric-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Zero inventory reconciliation errors post-launch</span>
                    </div>
                    <div class="project-tags">
                        <span class="tag-chip">Payment Gateways</span>
                        <span class="tag-chip">PDF Invoice Engine</span>
                        <span class="tag-chip">PHP 8.4</span>
                        <span class="tag-chip">Redis Caching</span>
                    </div>
                    <div class="project-actions">
                        <button type="button" class="btn-demo-trigger" data-demo="b2b">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            Launch Live Interactive Demo
                        </button>
                        <a href="<?= url('case-studies.php') ?>" class="btn-case-link">
                            Case Details →
                        </a>
                    </div>
                </div>
            </article>

            <!-- PROJECT 5: Clinic OPD Scheduling -->
            <article class="project-card" data-category="software">
                <div class="project-mockup-frame">
                    <div class="project-mockup-header">
                        <div class="project-mockup-dots">
                            <span class="dot-red"></span>
                            <span class="dot-yellow"></span>
                            <span class="dot-green"></span>
                        </div>
                        <span style="font-size: 0.75rem; color: var(--slate); font-family: var(--font-mono);">med.opd-scheduler</span>
                        <span class="project-badge-pill live">● Production Live</span>
                    </div>
                    <div class="project-mockup-screen">
                        <div class="mockup-ui-bar">
                            <span style="color: #2DD4BF;">🏥 Multi-Doctor Calendar</span>
                            <span style="color: #34D399;">Slot Lock: Active</span>
                        </div>
                        <div class="mockup-stat-row">
                            <div class="mockup-stat-cell">
                                <strong>26+</strong>
                                <span>Doctors Active</span>
                            </div>
                            <div class="mockup-stat-cell">
                                <strong>100%</strong>
                                <span>SMS Delivery</span>
                            </div>
                            <div class="mockup-stat-cell">
                                <strong style="color: #34D399;">0</strong>
                                <span>Double Bookings</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="project-card-body">
                    <div class="project-category" style="color: #2DD4BF;">Healthcare & Booking</div>
                    <h3 class="project-title">Central Medical Clinic OPD Portal</h3>
                    <p class="project-problem">
                        <strong>Problem:</strong> Front-desk staff taking phone appointments suffered daily double-bookings across 26 specialists, causing patient wait times over 90 minutes.
                    </p>
                    <p class="project-solution">
                        <strong>Engineering Solution:</strong> Multi-specialty clinical booking portal with transaction-level slot reservation, doctor vacation overrides, and automated SMS appointment reminders.
                    </p>
                    <div class="project-metric-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Zero appointment double-bookings across 18 months</span>
                    </div>
                    <div class="project-tags">
                        <span class="tag-chip">MySQL Transactions</span>
                        <span class="tag-chip">SMS API</span>
                        <span class="tag-chip">Calendar UI</span>
                        <span class="tag-chip">PHP 8.4</span>
                    </div>
                    <div class="project-actions">
                        <button type="button" class="btn-demo-trigger" data-demo="rag">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            Launch Live Interactive Demo
                        </button>
                        <a href="<?= url('case-studies.php') ?>" class="btn-case-link">
                            Case Details →
                        </a>
                    </div>
                </div>
            </article>

            <!-- PROJECT 6: Imaan360 PWA -->
            <article class="project-card" data-category="mobile">
                <div class="project-mockup-frame">
                    <div class="project-mockup-header">
                        <div class="project-mockup-dots">
                            <span class="dot-red"></span>
                            <span class="dot-yellow"></span>
                            <span class="dot-green"></span>
                        </div>
                        <span style="font-size: 0.75rem; color: var(--slate); font-family: var(--font-mono);">app.imaan360.pwa</span>
                        <span class="project-badge-pill live">● Production Live</span>
                    </div>
                    <div class="project-mockup-screen">
                        <div class="mockup-ui-bar">
                            <span style="color: #FB923C;">📱 Progressive Web App</span>
                            <span style="color: #34D399;">Offline Cache: 100%</span>
                        </div>
                        <div class="mockup-stat-row">
                            <div class="mockup-stat-cell">
                                <strong>50,000+</strong>
                                <span>Active Users</span>
                            </div>
                            <div class="mockup-stat-cell">
                                <strong>99.99%</strong>
                                <span>Uptime SLA</span>
                            </div>
                            <div class="mockup-stat-cell">
                                <strong style="color: #38BDF8;">60 FPS</strong>
                                <span>Smooth UI</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="project-card-body">
                    <div class="project-category" style="color: #FB923C;">Mobile & PWA</div>
                    <h3 class="project-title">Imaan360 — Community & Lifestyle PWA</h3>
                    <p class="project-problem">
                        <strong>Problem:</strong> Native app stores carried high publishing friction and users in low-bandwidth areas faced frequent network drops while accessing daily schedules.
                    </p>
                    <p class="project-solution">
                        <strong>Engineering Solution:</strong> Engineered a lightweight Progressive Web App using Service Workers and IndexedDB for full offline capabilities and instant sub-second page loads.
                    </p>
                    <div class="project-metric-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>50,000+ active installs with 99.99% reliability</span>
                    </div>
                    <div class="project-tags">
                        <span class="tag-chip">Service Workers</span>
                        <span class="tag-chip">IndexedDB</span>
                        <span class="tag-chip">PWA Offline</span>
                        <span class="tag-chip">Vanilla JS</span>
                    </div>
                    <div class="project-actions">
                        <button type="button" class="btn-demo-trigger" data-demo="rag">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            Launch Live Interactive Demo
                        </button>
                        <a href="<?= url('case-studies.php') ?>" class="btn-case-link">
                            Case Details →
                        </a>
                    </div>
                </div>
            </article>

        </div>

        <div style="text-align: center; margin-top: 3.5rem;">
            <a href="<?= url('case-studies.php') ?>" class="btn btn-secondary btn-lg">
                View All Deliverables & Architecture Notes →
            </a>
        </div>
    </div>
</section>

<!-- ==========================================================================
     PROVEN 7-STAGE DELIVERY FRAMEWORK
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
                A disciplined, transparent delivery cadence engineered to eliminate ambiguity, enforce strict type-safety, and guarantee production readiness.
            </p>
        </div>

        <div class="process-grid">
            <div class="process-step">
                <div class="step-num">01</div>
                <h3>Discover</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Deconstruct operational friction, user workflows, data models, and business objectives.</p>
            </div>
            <div class="process-step">
                <div class="step-num">02</div>
                <h3>Strategize</h3>
                <p style="font-size: 0.9rem; color: var(--slate);">Define system architecture, database schema, security boundaries, and technology stack.</p>
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
     CLIENT VALIDATION & TESTIMONIALS
     ========================================================================== -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Client Validation</span>
            </div>
            <h2 class="section-title">What Founders & Technical Leaders Say</h2>
            <p class="section-subtitle">
                Engineered for founders and technical directors who value reliability, fast delivery, and spotless code.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- Testimonial 1 -->
            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">
                    "CodeX404 rebuilt our legacy ERP from scratch with zero business downtime. The software bugs that had plagued our daily workflows for over a year were completely stamped out in their very first sprint."
                </p>
                <div class="testimonial-author-box">
                    <div class="testimonial-avatar">AK</div>
                    <div class="testimonial-info">
                        <h4>Arif Khan</h4>
                        <span>Operations Director, Global EdTech</span>
                    </div>
                    <div class="testimonial-metric-chip">4-Sprint Turnaround</div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">
                    "Our customer inquiry response time dropped from four hours to under three minutes with their automated WhatsApp and CRM pipeline. Our sales conversions doubled within 60 days of going live."
                </p>
                <div class="testimonial-author-box">
                    <div class="testimonial-avatar" style="background: linear-gradient(135deg, #06D6A0, #3B82F6);">DM</div>
                    <div class="testimonial-info">
                        <h4>David Miller</h4>
                        <span>Growth Lead, Omnichannel Retail</span>
                    </div>
                    <div class="testimonial-metric-chip">-85% Response Latency</div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">
                    "Working with CodeX404 feels like having a senior SWAT engineering team inside your company. Direct access to builders, crystal-clear milestones, and zero bloated agency overhead."
                </p>
                <div class="testimonial-author-box">
                    <div class="testimonial-avatar" style="background: linear-gradient(135deg, #EC4899, #8B5CF6);">SJ</div>
                    <div class="testimonial-info">
                        <h4>Sarah Jenkins</h4>
                        <span>Co-Founder & CTO, SaaS Logistics</span>
                    </div>
                    <div class="testimonial-metric-chip">100% IP Ownership</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     FOUNDER & SENIOR LEADERSHIP SECTION
     ========================================================================== -->
<?php include __DIR__ . '/components/leadership.php'; ?>

<!-- ==========================================================================
     DIRECT CONTACT & PROJECT INQUIRY FORM (HOMEPAGE EMBEDDED)
     ========================================================================== -->
<section class="home-contact-section" id="contact-section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Direct Engineering Communication</span>
            </div>
            <h2 class="section-title">Start Your Project or Schedule a Consultation</h2>
            <p class="section-subtitle">
                Discuss your software, AI, or automation requirements directly with our senior technical leadership. We review scopes and reply within 24 business hours.
            </p>
        </div>

        <div class="home-contact-grid">
            <!-- Left Column: Direct Access & Trust Guarantees -->
            <div>
                <h3 style="font-size: 1.65rem; color: var(--white); margin-bottom: 1rem;">
                    Let's Talk Architecture
                </h3>
                <p style="font-size: 1.05rem; line-height: 1.7; color: var(--slate); margin-bottom: 2rem;">
                    We skip aggressive sales calls and agency account managers. When you reach out to CodeX404 Solutions, you discuss your operational challenges directly with technical practitioners who design and build software.
                </p>

                <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 2.25rem;">
                    <div style="display: flex; align-items: flex-start; gap: 1rem;">
                        <div class="card-icon" style="width: 44px; height: 44px; font-size: 1.2rem; margin: 0;">✉️</div>
                        <div>
                            <strong style="color: var(--white); display: block;">Primary Email</strong>
                            <a href="mailto:<?= COMPANY_EMAIL ?>" style="color: var(--cyan);"><?= COMPANY_EMAIL ?></a>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 1rem;">
                        <div class="card-icon" style="width: 44px; height: 44px; font-size: 1.2rem; margin: 0;">💬</div>
                        <div>
                            <strong style="color: var(--white); display: block;">Instant WhatsApp Discussion</strong>
                            <a href="<?= COMPANY_WHATSAPP_URL ?>" target="_blank" rel="noopener noreferrer" style="color: #25D366; font-weight: 600;">
                                Chat on WhatsApp (<?= COMPANY_WHATSAPP_NUMBER ?>) &rarr;
                            </a>
                        </div>
                    </div>

                    <div style="display: flex; align-items: flex-start; gap: 1rem;">
                        <div class="card-icon" style="width: 44px; height: 44px; font-size: 1.2rem; margin: 0;">⏱️</div>
                        <div>
                            <strong style="color: var(--white); display: block;">Turnaround Commitment</strong>
                            <span style="color: var(--slate);">Direct engineering review within 24 business hours</span>
                        </div>
                    </div>
                </div>

                <!-- Trust Guarantees List -->
                <div class="trust-badge-list">
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">✓</div>
                        <span><strong>100% IP & Code Ownership:</strong> You retain complete repository and database rights.</span>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">✓</div>
                        <span><strong>Mutual NDA Protection:</strong> Strict confidentiality prior to technical scoping.</span>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">✓</div>
                        <span><strong>Zero Vendor Lock-in:</strong> Clean, portable, documented code running on open standards.</span>
                    </div>
                </div>

                <div style="margin-top: 2rem; background: rgba(11, 31, 58, 0.4); padding: 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                    <h4 style="font-size: 1.05rem; margin-bottom: 0.4rem; color: var(--cyan);">Prefer an in-depth video roadmap session?</h4>
                    <p style="font-size: 0.88rem; margin-bottom: 0.85rem; color: var(--slate);">For complex architectures, fill out our questionnaire to reserve a video call.</p>
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-secondary btn-sm">
                        Book a Discovery Call Instead &rarr;
                    </a>
                </div>
            </div>

            <!-- Right Column: Interactive Embedded Form -->
            <div class="form-card" style="border: 1px solid rgba(59, 130, 246, 0.35); box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5), 0 0 35px rgba(59, 130, 246, 0.15);">
                <div style="margin-bottom: 1.5rem;">
                    <h3 style="font-size: 1.35rem; color: var(--white); margin-bottom: 0.35rem;">Send Us a Message</h3>
                    <p style="font-size: 0.875rem; color: var(--slate-dark);">Complete this form to reach our engineering lead directly.</p>
                </div>

                <div class="form-alert-container"></div>

                <form action="<?= url('contact.php') ?>" method="POST" class="ajax-form" id="homeContactForm" novalidate>
                    <?= csrf_input_field() ?>

                    <!-- Honeypot -->
                    <div style="display: none;" aria-hidden="true">
                        <label for="_home_gotcha">Do not fill this</label>
                        <input type="text" name="_gotcha" id="_home_gotcha" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="home_name" class="form-label">Full Name <span class="required">*</span></label>
                            <input type="text" id="home_name" name="name" class="form-control" placeholder="Sarah Jenkins" required>
                        </div>
                        <div class="form-group">
                            <label for="home_email" class="form-label">Work Email <span class="required">*</span></label>
                            <input type="email" id="home_email" name="email" class="form-control" placeholder="sarah@company.com" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="home_phone" class="form-label">Phone / WhatsApp</label>
                            <input type="tel" id="home_phone" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                        </div>
                        <div class="form-group">
                            <label for="home_company" class="form-label">Company Name</label>
                            <input type="text" id="home_company" name="company" class="form-control" placeholder="Acme Logistics">
                        </div>
                    </div>

                    <div class="grid grid-cols-2" style="gap: 1rem;">
                        <div class="form-group">
                            <label for="home_subject" class="form-label">Primary Solution Needed</label>
                            <select id="home_subject" name="subject" class="form-control" style="background: rgba(11, 20, 38, 0.9); color: var(--white);">
                                <option value="Custom Software Development">Custom Software / Web Platform</option>
                                <option value="Enterprise AI & RAG">Enterprise AI & Knowledge Base (RAG)</option>
                                <option value="Autonomous AI Agents">Autonomous AI Agents</option>
                                <option value="Workflow & WhatsApp Automation">Workflow & WhatsApp Automation</option>
                                <option value="Mobile App Development">Mobile App (iOS/Android/PWA)</option>
                                <option value="SaaS & MVP Engineering">SaaS MVP Development</option>
                                <option value="General Architecture Consultation">Other / General Consultation</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="home_budget" class="form-label">Estimated Scope / Budget</label>
                            <select id="home_budget" name="budget_tier" class="form-control" style="background: rgba(11, 20, 38, 0.9); color: var(--white);">
                                <option value="mvp_scale">Focused MVP (&lt; $2,500 / ₹2L)</option>
                                <option value="standard" selected>Core System ($2,500 - $10,000 / ₹2L - ₹8L)</option>
                                <option value="enterprise">Full Enterprise Platform ($10,000+ / ₹8L+)</option>
                                <option value="exploring">Just Exploring / Need Guidance</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="home_message" class="form-label">Project Details & Challenge <span class="required">*</span></label>
                        <textarea id="home_message" name="message" class="form-textarea" rows="4" placeholder="Describe the operational friction you are solving, your timeline, or current stack..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-checkbox-label">
                            <input type="checkbox" name="privacy_consent" value="1" required>
                            <span>I agree to the <a href="<?= url('privacy.php') ?>" target="_blank" style="color: var(--cyan); text-decoration: underline;">Privacy Policy</a> and consent to CodeX404 Solutions processing my inquiry details.</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        Submit Project Inquiry
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     INTERACTIVE PROJECT DEMO MODAL SYSTEM
     ========================================================================== -->
<div class="demo-modal-overlay" id="projectDemoModal" role="dialog" aria-modal="true" aria-labelledby="demoModalTitle">
    <div class="demo-modal-window">
        <!-- Modal Header -->
        <div class="demo-modal-header">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div class="project-mockup-dots">
                    <span class="dot-red"></span>
                    <span class="dot-yellow"></span>
                    <span class="dot-green"></span>
                </div>
                <h3 id="demoModalTitle" style="font-size: 1.05rem; color: var(--white); margin: 0;">
                    ⚡ Interactive Project Sandbox
                </h3>
            </div>

            <div class="demo-modal-nav" role="tablist">
                <button type="button" class="demo-nav-tab active" data-demo-target="rag" role="tab">
                    🤖 AI RAG Assistant
                </button>
                <button type="button" class="demo-nav-tab" data-demo-target="wa" role="tab">
                    💬 WhatsApp Pipeline
                </button>
                <button type="button" class="demo-nav-tab" data-demo-target="erp" role="tab">
                    🏫 School ERP
                </button>
                <button type="button" class="demo-nav-tab" data-demo-target="b2b" role="tab">
                    🛍️ B2B Wholesale
                </button>
            </div>

            <button type="button" class="demo-close-btn" aria-label="Close demo modal">&times;</button>
        </div>

        <!-- Modal Body / Active Simulator Panes -->
        <div class="demo-modal-body">

            <!-- PANE 1: AI RAG Simulator -->
            <div class="demo-simulator-pane active" id="demo-pane-rag">
                <div style="margin-bottom: 1.25rem;">
                    <h4 style="color: #38BDF8; margin-bottom: 0.25rem; font-size: 1.15rem;">
                        Enterprise RAG Knowledge Assistant — Live Sandbox
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--slate);">
                        Ask a question to see how our vector search engine indexes internal company documentation and produces verified, cited answers with zero hallucinations.
                    </p>
                </div>

                <!-- Prompt suggestion chips -->
                <div class="rag-prompt-suggestions">
                    <span style="font-size: 0.78rem; color: var(--slate-dark); align-self: center;">Try Asking:</span>
                    <button type="button" class="rag-chip" data-prompt="What is your IP and source code ownership policy?">
                        💼 IP Ownership Policy
                    </button>
                    <button type="button" class="rag-chip" data-prompt="How does the WhatsApp lead pipeline work?">
                        ⚡ WhatsApp Pipeline
                    </button>
                    <button type="button" class="rag-chip" data-prompt="Explain the School ERP role-based security">
                        🏫 School ERP Security
                    </button>
                </div>

                <!-- Chat Box -->
                <div class="rag-chat-box" id="ragChatBox">
                    <div class="chat-bubble ai">
                        <div style="margin-bottom: 0.4rem; color: #34D399; font-weight: 600; font-size: 0.75rem;">
                            ● RAG Agent Online &bull; Qdrant Vector Index Active (14,200 chunks)
                        </div>
                        <div>
                            Hello! I am the CodeX404 Enterprise Knowledge Assistant. How can I assist you with our engineering architectures, system specs, or client policies today?
                        </div>
                    </div>
                </div>

                <!-- Input row -->
                <div class="rag-input-row">
                    <input type="text" id="ragInput" class="form-control" placeholder="Type a question (e.g. 'How is client IP protected?')..." style="flex: 1;">
                    <button type="button" id="ragSendBtn" class="btn btn-primary btn-sm" style="white-space: nowrap;">
                        Send Query &rarr;
                    </button>
                </div>
            </div>

            <!-- PANE 2: WhatsApp Lead Pipeline Simulator -->
            <div class="demo-simulator-pane" id="demo-pane-wa">
                <div style="margin-bottom: 1.25rem;">
                    <h4 style="color: #25D366; margin-bottom: 0.25rem; font-size: 1.15rem;">
                        Multi-Channel WhatsApp Pipeline — Live Ingestion Simulation
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--slate);">
                        Click the button below to simulate an inbound lead from Meta WhatsApp Cloud API. Watch our webhook engine parse, auto-respond, and update the CRM board in real-time.
                    </p>
                </div>

                <div style="margin-bottom: 1rem;">
                    <button type="button" id="waSimulateBtn" class="btn btn-primary btn-sm" style="background: linear-gradient(135deg, #25D366, #128C7E); color: #FFF;">
                        ⚡ Simulate Inbound WhatsApp Lead
                    </button>
                </div>

                <div class="wa-simulator-grid">
                    <!-- Phone View -->
                    <div class="wa-phone-frame">
                        <div style="font-size: 0.75rem; color: #8696A0; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 6px; margin-bottom: 10px;">
                            📱 Client WhatsApp Chat Window
                        </div>
                        <div id="waChatLog" style="height: 220px; overflow-y: auto;">
                            <div style="background: #202C33; color: #E9EDEF; padding: 8px 12px; border-radius: 8px; margin-bottom: 8px; font-size: 0.85rem; max-width: 85%;">
                                <strong>Lead #1039:</strong> Hello CodeX404! We need an automated booking portal for our diagnostic lab.
                                <div style="font-size: 0.7rem; color: #8696A0; text-align: right;">10:14 AM</div>
                            </div>
                            <div style="background: #005C4B; color: #E9EDEF; padding: 8px 12px; border-radius: 8px; margin-bottom: 8px; font-size: 0.85rem; max-width: 85%; margin-left: auto;">
                                <strong>CodeX404 Auto-Agent:</strong> Thank you for reaching out! We received your booking portal inquiry. Our medical systems architect is reviewing this and will reply shortly. Ref: #LD-1039.
                                <div style="font-size: 0.7rem; color: #8696A0; text-align: right;">10:14 AM &bull; 1.2s</div>
                            </div>
                        </div>
                    </div>

                    <!-- CRM Pipeline Kanban View -->
                    <div class="crm-board-frame">
                        <div style="font-size: 0.75rem; color: #38BDF8; font-weight: 600; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 6px; margin-bottom: 10px;">
                            📊 Live CRM Pipeline Stage: Inbound Qualified
                        </div>
                        <div id="crmLeadList" style="height: 220px; overflow-y: auto;">
                            <div style="background: rgba(11, 20, 38, 0.9); border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 6px; padding: 10px; margin-bottom: 8px; font-size: 0.8rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                    <strong style="color: #38BDF8;">Diagnostic Lab Booking #LD-1039</strong>
                                    <span style="background: rgba(16, 185, 129, 0.2); color: #34D399; font-size: 0.7rem; padding: 2px 6px; border-radius: 4px;">QUALIFIED</span>
                                </div>
                                <div style="color: var(--slate); font-size: 0.75rem;">Source: WhatsApp Cloud API &nbsp;•&nbsp; Latency: 1.2s</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANE 3: School ERP Simulator -->
            <div class="demo-simulator-pane" id="demo-pane-erp">
                <div style="margin-bottom: 1.25rem;">
                    <h4 style="color: #38BDF8; margin-bottom: 0.25rem; font-size: 1.15rem;">
                        School ERP & Administrative Portal — Ledger Dashboard
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--slate);">
                        Real-time student fee collection and ledger reconciliation dashboard preview.
                    </p>
                </div>

                <div style="background: rgba(10, 22, 40, 0.9); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 0.75rem;">
                        <div>
                            <strong style="color: var(--white); font-size: 1.05rem;">Al-Huda International Academy — Session 2026-27</strong>
                            <div style="font-size: 0.8rem; color: #34D399;">● RBAC Active: Finance Controller Mode</div>
                        </div>
                        <span style="background: rgba(56, 189, 248, 0.15); color: #38BDF8; font-size: 0.75rem; padding: 4px 8px; border-radius: 4px;">Term 2 Audited</span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem; margin-bottom: 1.25rem;">
                        <div style="background: rgba(17, 29, 58, 0.7); padding: 0.75rem; border-radius: 6px; text-align: center;">
                            <span style="font-size: 0.75rem; color: var(--slate-dark);">Total Enrolled</span>
                            <strong style="display: block; font-size: 1.15rem; color: var(--white);">1,420</strong>
                        </div>
                        <div style="background: rgba(17, 29, 58, 0.7); padding: 0.75rem; border-radius: 6px; text-align: center;">
                            <span style="font-size: 0.75rem; color: var(--slate-dark);">Fees Collected</span>
                            <strong style="display: block; font-size: 1.15rem; color: #34D399;">94.2%</strong>
                        </div>
                        <div style="background: rgba(17, 29, 58, 0.7); padding: 0.75rem; border-radius: 6px; text-align: center;">
                            <span style="font-size: 0.75rem; color: var(--slate-dark);">Attendance Rate</span>
                            <strong style="display: block; font-size: 1.15rem; color: #38BDF8;">97.8%</strong>
                        </div>
                        <div style="background: rgba(17, 29, 58, 0.7); padding: 0.75rem; border-radius: 6px; text-align: center;">
                            <span style="font-size: 0.75rem; color: var(--slate-dark);">Reconciliation</span>
                            <strong style="display: block; font-size: 1.15rem; color: #34D399;">Balanced</strong>
                        </div>
                    </div>

                    <div style="font-size: 0.825rem; color: var(--slate); background: rgba(17, 29, 58, 0.5); padding: 0.75rem; border-radius: 6px;">
                        ✔ Auto-generated 1,420 digital fee receipts with SMS delivery &bull; 0 manual cash reconciliation errors reported.
                    </div>
                </div>
            </div>

            <!-- PANE 4: B2B Wholesale Simulator -->
            <div class="demo-simulator-pane" id="demo-pane-b2b">
                <div style="margin-bottom: 1.25rem;">
                    <h4 style="color: #EC4899; margin-bottom: 0.25rem; font-size: 1.15rem;">
                        B2B Wholesale Ordering & Automated Pricing Engine
                    </h4>
                    <p style="font-size: 0.85rem; color: var(--slate);">
                        Live volume tier discount & real-time stock allocation calculator.
                    </p>
                </div>

                <div style="background: rgba(10, 22, 40, 0.9); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div>
                            <strong style="color: var(--white);">Industrial SKU: #PWR-SOLAR-INVERTER-5KW</strong>
                            <div style="font-size: 0.8rem; color: var(--slate);">Warehouse Inventory: 340 units in stock</div>
                        </div>
                        <span style="background: rgba(16, 185, 129, 0.15); color: #34D399; font-size: 0.75rem; padding: 4px 8px; border-radius: 4px;">Tier 3 Bulk Discount Active</span>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div style="background: rgba(17, 29, 58, 0.6); padding: 0.85rem; border-radius: 6px;">
                            <div style="font-size: 0.8rem; color: var(--slate-dark); margin-bottom: 4px;">Standard Retail Unit Price</div>
                            <div style="font-size: 1.1rem; color: var(--slate); text-decoration: line-through;">$1,200.00 / unit</div>
                        </div>
                        <div style="background: rgba(17, 29, 58, 0.6); padding: 0.85rem; border-radius: 6px; border: 1px solid rgba(16, 185, 129, 0.3);">
                            <div style="font-size: 0.8rem; color: #34D399; margin-bottom: 4px;">Wholesale Bulk Price (&gt; 25 units)</div>
                            <div style="font-size: 1.25rem; color: #34D399; font-weight: bold;">$890.00 / unit (-25.8%)</div>
                        </div>
                    </div>

                    <div style="font-size: 0.825rem; color: var(--slate); background: rgba(17, 29, 58, 0.5); padding: 0.75rem; border-radius: 6px;">
                        ✔ Checkout triggers instant stock locking in Redis, automated GST PDF invoice dispatch, and payment gateway settlement.
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
