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
                <span>Where Bugs Meet Their Match • Senior Engineering Studio</span>
            </div>

            <h1 class="hero-headline">
                Software & AI that moves your business <span class="text-gradient">forward.</span>
            </h1>

            <p class="hero-description">
                We design, build, and automate high-performance software systems — zero bugs, production-grade cloud architectures, and full IP ownership.
            </p>

            <div class="hero-cta-group">
                <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-lg">
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
                Explore real software systems, AI pipelines, and enterprise automation platforms delivered for high-growth operations.
            </p>
        </div>

        <!-- Interactive Case Studies Slider (Carousel) -->
        <div class="slider-container" data-slider="case-studies">
            <div class="slider-wrapper">
                <div class="slider-track">
                    <!-- Case Study 1 -->
                    <div class="slider-card" style="border-top: 3px solid #3B82F6;">
                        <div style="font-size: 0.8rem; color: #38BDF8; text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Education & Enterprise</div>
                        <h3 class="card-title">School ERP & Administrative Portal</h3>
                        <p class="card-description">
                            Consolidated student records, fee collection, staff attendance, and parent communication into a unified role-based management web platform.
                        </p>
                        <div class="card-tags">
                            <span class="tag-chip">PHP 8</span>
                            <span class="tag-chip">MySQL</span>
                            <span class="tag-chip">RBAC Security</span>
                            <span class="tag-chip">Fee Automation</span>
                        </div>
                        <div style="margin-top: auto; padding-top: 1.25rem; font-size: 0.85rem; color: #34D399; font-weight: 600;">
                            ✓ Replaced paper registers across 4 departments
                        </div>
                    </div>

                    <!-- Case Study 2 -->
                    <div class="slider-card" style="border-top: 3px solid #06D6A0;">
                        <div style="font-size: 0.8rem; color: #34D399; text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Sales Automation</div>
                        <h3 class="card-title">Multi-Channel Lead Ingestion Pipeline</h3>
                        <p class="card-description">
                            Built an automated inbound lead ingestion engine connecting website forms, WhatsApp Business API, and email inquiries into a structured CRM.
                        </p>
                        <div class="card-tags">
                            <span class="tag-chip">Webhook Ingestion</span>
                            <span class="tag-chip">WhatsApp Business API</span>
                            <span class="tag-chip">Idempotent Worker</span>
                        </div>
                        <div style="margin-top: auto; padding-top: 1.25rem; font-size: 0.85rem; color: #34D399; font-weight: 600;">
                            ✓ Lead response time: 4 hours → under 3 minutes
                        </div>
                    </div>

                    <!-- Case Study 3 -->
                    <div class="slider-card" style="border-top: 3px solid #EC4899;">
                        <div style="font-size: 0.8rem; color: #F472B6; text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Retail & Commerce</div>
                        <h3 class="card-title">B2B E-Commerce & Checkout Engine</h3>
                        <p class="card-description">
                            Developed a robust custom ordering portal featuring live inventory sync, payment gateway integration, automated invoice generation, and order tracking.
                        </p>
                        <div class="card-tags">
                            <span class="tag-chip">Payment Gateway</span>
                            <span class="tag-chip">Live Inventory</span>
                            <span class="tag-chip">PDF Invoice Engine</span>
                        </div>
                        <div style="margin-top: auto; padding-top: 1.25rem; font-size: 0.85rem; color: #34D399; font-weight: 600;">
                            ✓ Zero inventory reconciliation errors post-launch
                        </div>
                    </div>

                    <!-- Case Study 4 -->
                    <div class="slider-card" style="border-top: 3px solid #8B5CF6;">
                        <div style="font-size: 0.8rem; color: #A78BFA; text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Applied AI Systems</div>
                        <h3 class="card-title">Enterprise RAG Knowledge Assistant</h3>
                        <p class="card-description">
                            Deployed a private retrieval-augmented generation engine indexing 14,000+ proprietary manuals and technical specs with strict role isolation.
                        </p>
                        <div class="card-tags">
                            <span class="tag-chip">Vector Embeddings</span>
                            <span class="tag-chip">Python</span>
                            <span class="tag-chip">Hybrid Search</span>
                        </div>
                        <div style="margin-top: auto; padding-top: 1.25rem; font-size: 0.85rem; color: #34D399; font-weight: 600;">
                            ✓ Sub-second semantic search with 0 hallucination leaks
                        </div>
                    </div>

                    <!-- Case Study 5 -->
                    <div class="slider-card" style="border-top: 3px solid #F97316;">
                        <div style="font-size: 0.8rem; color: #FB923C; text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Mobile & PWA</div>
                        <h3 class="card-title">Imaan360 — Community & Lifestyle PWA</h3>
                        <p class="card-description">
                            High-concurrency mobile progressive web application featuring offline prayer synchronization, localized timing APIs, and instant caching.
                        </p>
                        <div class="card-tags">
                            <span class="tag-chip">Service Workers</span>
                            <span class="tag-chip">IndexedDB</span>
                            <span class="tag-chip">PWA Offline</span>
                        </div>
                        <div style="margin-top: auto; padding-top: 1.25rem; font-size: 0.85rem; color: #34D399; font-weight: 600;">
                            ✓ 50,000+ active installs with 99.99% reliability
                        </div>
                    </div>

                    <!-- Case Study 6 -->
                    <div class="slider-card" style="border-top: 3px solid #14B8A6;">
                        <div style="font-size: 0.8rem; color: #2DD4BF; text-transform: uppercase; font-weight: 700; margin-bottom: 0.5rem; letter-spacing: 0.05em;">Healthcare & Booking</div>
                        <h3 class="card-title">Central Medical Clinic OPD Portal</h3>
                        <p class="card-description">
                            Custom multi-specialty clinical scheduling system managing 26+ specialist doctors, real-time slot locking, and automated patient SMS updates.
                        </p>
                        <div class="card-tags">
                            <span class="tag-chip">Real-time Locking</span>
                            <span class="tag-chip">MySQL Transactions</span>
                            <span class="tag-chip">SMS Alerts</span>
                        </div>
                        <div style="margin-top: auto; padding-top: 1.25rem; font-size: 0.85rem; color: #34D399; font-weight: 600;">
                            ✓ Zero appointment double-bookings across 18 months
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slider Controls -->
            <div class="slider-controls">
                <div class="slider-dots" role="tablist" aria-label="Case studies slides"></div>
                <div class="slider-btn-group">
                    <button class="slider-nav-btn slider-prev-btn" aria-label="Previous slide" title="Previous Project">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                    <button class="slider-nav-btn slider-next-btn" aria-label="Next slide" title="Next Project">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2.5rem;">
            <a href="<?= url('case-studies.php') ?>" class="btn btn-secondary">
                View All Deliverables & Architecture Notes →
            </a>
        </div>
    </div>
</section>

<!-- ==========================================================================
     CLIENT TESTIMONIALS & TRUST CAROUSEL
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
