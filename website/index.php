<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';

$pageMeta = [
    'title' => 'Software & AI that moves your business forward | CodeX404 Solutions',
    'description' => 'CodeX404 Solutions designs, builds, and automates custom software, enterprise AI, autonomous agents, and workflow systems for growing businesses globally.',
    'canonical' => BASE_URL,
    'keywords' => 'custom software development, business AI solutions, AI agents, workflow automation, SaaS MVP development, enterprise systems'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- ==========================================================================
     HERO SECTION (High-Impact Motions, Typewriter & Interactive Terminal)
     ========================================================================== -->
<section class="hero-section">
    <div class="container hero-grid">
        <div class="hero-content">
            <div class="hero-pill">
                <span class="dot"></span>
                <span>Where Bugs Meet Their Match • Senior Engineering Studio</span>
            </div>

            <h1 class="hero-headline">
                Software & AI that moves your business <span
                    class="text-gradient gradient-text-animated">forward.</span>
            </h1>

            <!-- Dynamic Rotating Typewriter Headline -->
            <div class="hero-typewriter-box" aria-live="polite">
                <span class="type-prefix">Specialized in:</span>
                <span class="typewriter-text" id="typewriter">BUILD · GROW · AUTOMATE</span>
                <span class="typewriter-cursor"></span>
            </div>

            <p class="hero-description">
                We architect, build, and automate high-performance software systems — disciplined engineering standards,
                cloud-native architectures, autonomous AI pipelines, and clear IP assignment upon milestone delivery.
            </p>

            <div class="hero-cta-group">
                <a href="#work" class="btn btn-primary btn-lg">
                    <span>Explore Deliverables & Demos</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <polyline points="19 12 12 19 5 12"></polyline>
                    </svg>
                </a>
                <a href="#contact-section" class="btn btn-secondary btn-lg">
                    <span>Start Your Project 🚀</span>
                </a>
            </div>

            <!-- Value / Capability Stats Strip (Progressive Enhancement) -->
            <div class="hero-stats-strip">
                <div class="stat-item">
                    <strong data-counter-target="7" data-counter-suffix="+ Yrs">7+ Yrs</strong>
                    <span>Enterprise Leadership</span>
                </div>
                <div class="stat-item">
                    <strong data-counter-target="3" data-counter-suffix=" Divisions">3 Divisions</strong>
                    <span>BUILD · GROW · AUTOMATE</span>
                </div>
                <div class="stat-item">
                    <strong>Transparent IP</strong>
                    <span>Milestone-Based Assignment</span>
                </div>
            </div>
        </div>

        <!-- Interactive Multi-Tab Hero Terminal (Architectural Simulation) -->
        <div class="hero-visual">
            <div class="tech-frame">
                <div class="tech-frame-header">
                    <div class="window-dots">
                        <span class="dot-red"></span>
                        <span class="dot-yellow"></span>
                        <span class="dot-green"></span>
                    </div>

                    <!-- Interactive Terminal Tabs -->
                    <div class="terminal-tabs" role="tablist" aria-label="Terminal Environments">
                        <button class="terminal-tab-btn active" role="tab" aria-selected="true" data-tab="deploy">
                            🚀 deploy
                        </button>
                        <button class="terminal-tab-btn" role="tab" aria-selected="false" data-tab="audit">
                            🧪 quality-check
                        </button>
                        <button class="terminal-tab-btn" role="tab" aria-selected="false" data-tab="agent">
                            🤖 ai-agent
                        </button>
                    </div>

                    <div style="font-size: 0.725rem; color: #FBBF24; font-family: var(--font-mono); font-weight: 600;">
                        ● ARCHITECTURE SIMULATION
                    </div>
                </div>

                <div class="tech-frame-body">
                    <!-- Pane 1: Deploy -->
                    <div class="terminal-pane active" id="pane-deploy">
                        <div class="code-comment">// Continuous Integration Pipeline Simulation</div>
                        <div><span class="code-keyword">$</span> <span class="code-accent">codex404</span> build --env
                            staging --verify</div>
                        <div style="color: var(--slate); margin-top: 0.35rem;">
                            &rarr; Running automated regression test suite...<br>
                            &rarr; Compiling containerized production package...<br>
                            &rarr; Verifying TLS configuration & rate-limiting policies...
                        </div>
                        <div style="color: #34D399; margin-top: 0.5rem; font-weight: 500;">
                            ✔ Static analysis checks satisfied<br>
                            ✔ Automated test assertions completed<br>
                            ✔ Staging deployment package verified
                        </div>
                        <div class="pipeline-badge">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Continuous Integration Workflow
                        </div>
                    </div>

                    <!-- Pane 2: Audit & Quality -->
                    <div class="terminal-pane" id="pane-audit">
                        <div class="code-comment">// Defensive Architecture & Type-Safety Scan</div>
                        <div><span class="code-keyword">$</span> <span class="code-accent">codex404</span> test
                            --type-safety
                            --audit</div>
                        <div style="color: var(--slate); margin-top: 0.35rem;">
                            &rarr; Type-checking codebase with strict compilation standards...<br>
                            &rarr; Auditing route authorization and CSRF protections...<br>
                            &rarr; Scanning dependencies for security advisories...
                        </div>
                        <div style="color: #38BDF8; margin-top: 0.5rem; font-weight: 600;">
                            🎯 Where Bugs Meet Their Match — Defensive Code Architecture<br>
                            ✔ Automated parameter validation and error logging enforced
                        </div>
                        <div class="pipeline-badge"
                            style="background: rgba(56, 189, 248, 0.12); color: #38BDF8; border-color: rgba(56, 189, 248, 0.25);">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 14 14"></polyline>
                            </svg>
                            Automated Quality Assurance
                        </div>
                    </div>

                    <!-- Pane 3: AI Agent Workflow -->
                    <div class="terminal-pane" id="pane-agent">
                        <div class="code-comment">// Autonomous Enterprise AI & RAG Pipeline Simulation</div>
                        <div><span class="code-keyword">$</span> <span class="code-accent">codex404</span> agent
                            --pipeline rag-workflow --simulate</div>
                        <div style="color: var(--slate); margin-top: 0.35rem;">
                            &rarr; Initializing grounded vector index simulator...<br>
                            &rarr; Parsing enterprise document schemas...<br>
                            &rarr; Evaluating multi-tool agent resolution logic...
                        </div>
                        <div style="color: #F472B6; margin-top: 0.5rem; font-weight: 500;">
                            ✔ Simulated query routed with audit logging<br>
                            ✔ Dispatch event prepared for webhook pipeline
                        </div>
                        <div class="pipeline-badge"
                            style="background: rgba(236, 72, 153, 0.12); color: #F472B6; border-color: rgba(236, 72, 153, 0.25);">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                            Simulated Agentic Workflow
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     INFINITE DUAL-SPEED TECH STACK MARQUEE SCROLLER
     ========================================================================== -->
<section class="tech-marquee-section" aria-label="Supported Engineering Technologies">
    <div class="tech-marquee-wrapper">
        <!-- Row 1: Forward Infinite Scroll -->
        <div class="tech-marquee-track">
            <div class="tech-pill-item"><span class="tech-pill-icon">🐍</span> Python 3.12 Architecture</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🐘</span> PHP 8.4 & MySQL</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚛️</span> React & Next.js</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🧠</span> Azure OpenAI & LLMs</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📘</span> TypeScript & Node.js</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🐳</span> Docker Containers</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚡</span> FastAPI Microservices</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">👁️</span> YOLOv8 Computer Vision</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🔌</span> REST & GraphQL APIs</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🚀</span> CodeX404 Solutions</div>
            <!-- Seamless Duplicate Loop -->
            <div class="tech-pill-item"><span class="tech-pill-icon">🐍</span> Python 3.12 Architecture</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🐘</span> PHP 8.4 & MySQL</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚛️</span> React & Next.js</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🧠</span> Azure OpenAI & LLMs</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📘</span> TypeScript & Node.js</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🐳</span> Docker Containers</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚡</span> FastAPI Microservices</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">👁️</span> YOLOv8 Computer Vision</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🔌</span> REST & GraphQL APIs</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🚀</span> CodeX404 Solutions</div>
        </div>

        <!-- Row 2: Reverse Infinite Scroll -->
        <div class="tech-marquee-track reverse">
            <div class="tech-pill-item"><span class="tech-pill-icon">☁️</span> AWS Cloud Architecture</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚡</span> Redis Distributed Cache</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🤖</span> Autonomous Multi-Agent AI</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📊</span> LangChain & Qdrant RAG</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📱</span> Progressive Web Apps (PWA)</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">💳</span> Stripe & Payment Gateways</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🔄</span> CI/CD GitHub Actions</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🛡️</span> OWASP Security Hardening</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">💼</span> Enterprise Engineering Pedigree</div>
            <!-- Seamless Duplicate Loop -->
            <div class="tech-pill-item"><span class="tech-pill-icon">☁️</span> AWS Cloud Architecture</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚡</span> Redis Distributed Cache</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🤖</span> Autonomous Multi-Agent AI</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📊</span> LangChain & Qdrant RAG</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📱</span> Progressive Web Apps (PWA)</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">💳</span> Stripe & Payment Gateways</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🔄</span> CI/CD GitHub Actions</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🛡️</span> OWASP Security Hardening</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">💼</span> Enterprise Engineering Pedigree</div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     THE THREE DIVISIONS — BUILD · GROW · AUTOMATE
     ========================================================================== -->
<section class="section" id="divisions" aria-label="Company Divisions">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>One Unified Engineering & Growth Partner</span>
            </div>
            <h2 class="section-title">
                Three Focused Divisions. <span class="text-gradient gradient-text-animated">One High-Standard
                    Team.</span>
            </h2>
            <p class="section-subtitle">
                Whether you need to engineer custom platforms, expand search and audience discovery, or automate manual
                workflows, CodeX404 provides direct technical leadership.
            </p>
        </div>

        <div class="divisions-grid">
            <!-- Division 1: BUILD -->
            <article class="division-card build card-tilt reveal-on-scroll">
                <article class="division-card build card-tilt reveal-on-scroll" id="division-build">
                    <div>
                        <div class="division-badge-pill badge-build">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #3B82F6;"></span>
                            <span>BUILD — Engineering & Apps</span>
                        </div>
                        <h3 class="division-title">
                            <span>💻</span> Build Software That Scales
                        </h3>
                        <p class="division-desc">
                            Turn core workflows and product visions into reliable web platforms, SaaS architectures,
                            mobile
                            applications, and high-load backend APIs.
                        </p>
                        <ul class="division-feature-list">
                            <li class="division-feature-item">
                                <span class="division-feature-bullet" style="color: #60A5FA;">✓</span>
                                <span>Custom Web Applications & Enterprise Dashboards</span>
                            </li>
                            <li class="division-feature-item">
                                <span class="division-feature-bullet" style="color: #60A5FA;">✓</span>
                                <span>SaaS MVP Engineering & Multi-Tenant Setup</span>
                            </li>
                            <li class="division-feature-item">
                                <span class="division-feature-bullet" style="color: #60A5FA;">✓</span>
                                <span>Cross-Platform Mobile & Progressive Web Apps</span>
                            </li>
                            <li class="division-feature-item">
                                <span class="division-feature-bullet" style="color: #60A5FA;">✓</span>
                                <span>Payment Gateways & REST/GraphQL API Integration</span>
                            </li>
                        </ul>
                    </div>
                    <a href="<?= url('solutions.php#build') ?>" class="division-cta-link text-build">
                        <span>Explore BUILD Capabilities</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </article>

                <!-- Division 2: GROW -->
                <article class="division-card grow card-tilt reveal-on-scroll reveal-delay-1">
                    <article class="division-card grow card-tilt reveal-on-scroll reveal-delay-1" id="division-grow">
                        <div>
                            <div class="division-badge-pill badge-grow">
                                <span style="width: 6px; height: 6px; border-radius: 50%; background: #8B5CF6;"></span>
                                <span>GROW — Visibility & Growth</span>
                            </div>
                            <h3 class="division-title">
                                <span>📈</span> Grow Reach & Discovery
                            </h3>
                            <p class="division-desc">
                                Help audiences discover and trust your platform through search engine optimization,
                                answer-engine readiness (AEO/GEO), digital marketing, and conversion design.
                            </p>
                            <ul class="division-feature-list">
                                <li class="division-feature-item">
                                    <span class="division-feature-bullet" style="color: #C084FC;">✓</span>
                                    <span>Search Engine Optimization (SEO & Technical Audits)</span>
                                </li>
                                <li class="division-feature-item">
                                    <span class="division-feature-bullet" style="color: #C084FC;">✓</span>
                                    <span>Answer Engine & Generative Discovery (AEO & GEO)</span>
                                </li>
                                <li class="division-feature-item">
                                    <span class="division-feature-bullet" style="color: #C084FC;">✓</span>
                                    <span>Digital Marketing Campaigns & Paid Traffic Guidance</span>
                                </li>
                                <li class="division-feature-item">
                                    <span class="division-feature-bullet" style="color: #C084FC;">✓</span>
                                    <span>Conversion Rate Optimization (CRO) & Funnel Analytics</span>
                                </li>
                            </ul>
                        </div>
                        <a href="<?= url('solutions.php#grow') ?>" class="division-cta-link text-grow">
                            <span>Explore GROW Capabilities</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                    </article>

                    <!-- Division 3: AUTOMATE -->
                    <article class="division-card automate card-tilt reveal-on-scroll reveal-delay-2">
                        <article class="division-card automate card-tilt reveal-on-scroll reveal-delay-2"
                            id="division-automate">
                            <div>
                                <div class="division-badge-pill badge-automate">
                                    <span
                                        style="width: 6px; height: 6px; border-radius: 50%; background: #10B981;"></span>
                                    <span>AUTOMATE — AI & Operations</span>
                                </div>
                                <h3 class="division-title">
                                    <span>⚡</span> Automate Manual Toil
                                </h3>
                                <p class="division-desc">
                                    Connect disjointed systems and streamline operations using autonomous multi-tool AI
                                    agents,
                                    private RAG knowledge bases, and real-time messaging pipelines.
                                </p>
                                <ul class="division-feature-list">
                                    <li class="division-feature-item">
                                        <span class="division-feature-bullet" style="color: #34D399;">✓</span>
                                        <span>Autonomous Multi-Tool Agentic Resolution Loops</span>
                                    </li>
                                    <li class="division-feature-item">
                                        <span class="division-feature-bullet" style="color: #34D399;">✓</span>
                                        <span>Enterprise RAG & Grounded Vector Documentation Search</span>
                                    </li>
                                    <li class="division-feature-item">
                                        <span class="division-feature-bullet" style="color: #34D399;">✓</span>
                                        <span>WhatsApp Cloud API & Real-time CRM Sync Webhooks</span>
                                    </li>
                                    <li class="division-feature-item">
                                        <span class="division-feature-bullet" style="color: #34D399;">✓</span>
                                        <span>Document Extraction & Event-Driven Process Automation</span>
                                    </li>
                                </ul>
                            </div>
                            <a href="<?= url('solutions.php#automate') ?>" class="division-cta-link text-automate">
                                <span>Explore AUTOMATE Capabilities</span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </article>
        </div>
    </div>
</section>

<!-- ==========================================================================
     INTERACTIVE INDUSTRY & USE-CASE TOUCH SLIDER
     ========================================================================== -->
<section class="section industry-slider-section" aria-label="Industries and Use Cases">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Contextual Industry Workflows</span>
            </div>
            <h2 class="section-title">
                Engineered for <span class="text-gradient gradient-text-animated">Real Operational Demands</span>
            </h2>
            <p class="section-subtitle">
                Explore how our modular systems adapt to different sector requirements — with responsive swipe controls
                and auto-scrolling.
            </p>
        </div>

        <div class="industry-slider-wrap">
            <div class="industry-slider-track" tabindex="0" aria-label="Industry solutions carousel">
                <!-- Slide 1: Healthcare -->
                <div class="industry-slider-card">
                    <div>
                        <div style="font-size: 2rem; margin-bottom: 0.75rem;">🏥</div>
                        <h3 style="font-size: 1.15rem; color: #FFFFFF; margin-bottom: 0.5rem;">Healthcare & Clinics</h3>
                        <p style="font-size: 0.85rem; color: var(--slate); line-height: 1.5; margin-bottom: 1rem;">
                            Patient booking portals, clinic schedule coordination, automated visit notifications, and
                            structured medical intake.
                        </p>
                    </div>
                    <div style="font-size: 0.75rem; color: #60A5FA; font-weight: 600;">
                        Focus: Privacy & Automated Scheduling &rarr;
                    </div>
                </div>

                <!-- Slide 2: Education -->
                <div class="industry-slider-card">
                    <div>
                        <div style="font-size: 2rem; margin-bottom: 0.75rem;">🏫</div>
                        <h3 style="font-size: 1.15rem; color: #FFFFFF; margin-bottom: 0.5rem;">Schools & Institutions
                        </h3>
                        <p style="font-size: 0.85rem; color: var(--slate); line-height: 1.5; margin-bottom: 1rem;">
                            Institutional web portals, fee voucher processing, admission workflows, and role-based
                            faculty record systems.
                        </p>
                    </div>
                    <div style="font-size: 0.75rem; color: #38BDF8; font-weight: 600;">
                        Focus: High-Concurrency Portals &rarr;
                    </div>
                </div>

                <!-- Slide 3: E-Commerce -->
                <div class="industry-slider-card">
                    <div>
                        <div style="font-size: 2rem; margin-bottom: 0.75rem;">🛍️</div>
                        <h3 style="font-size: 1.15rem; color: #FFFFFF; margin-bottom: 0.5rem;">E-Commerce & Retail</h3>
                        <p style="font-size: 0.85rem; color: var(--slate); line-height: 1.5; margin-bottom: 1rem;">
                            Fast product catalog browsing, checkout integrations, real-time inventory updates, and
                            abandoned cart automations.
                        </p>
                    </div>
                    <div style="font-size: 0.75rem; color: #C084FC; font-weight: 600;">
                        Focus: Sub-Second TTFB & Checkout &rarr;
                    </div>
                </div>

                <!-- Slide 4: Appointments -->
                <div class="industry-slider-card">
                    <div>
                        <div style="font-size: 2rem; margin-bottom: 0.75rem;">📅</div>
                        <h3 style="font-size: 1.15rem; color: #FFFFFF; margin-bottom: 0.5rem;">Appointment Workflows
                        </h3>
                        <p style="font-size: 0.85rem; color: var(--slate); line-height: 1.5; margin-bottom: 1rem;">
                            Direct reservation engines for salons, spas, dental offices, and dining without marketplace
                            middleman fees.
                        </p>
                    </div>
                    <div style="font-size: 0.75rem; color: #34D399; font-weight: 600;">
                        Focus: Direct Client Ownership &rarr;
                    </div>
                </div>

                <!-- Slide 5: Real Estate -->
                <div class="industry-slider-card">
                    <div>
                        <div style="font-size: 2rem; margin-bottom: 0.75rem;">🏢</div>
                        <h3 style="font-size: 1.15rem; color: #FFFFFF; margin-bottom: 0.5rem;">Real Estate & Agencies
                        </h3>
                        <p style="font-size: 0.85rem; color: var(--slate); line-height: 1.5; margin-bottom: 1rem;">
                            Dynamic property search, interactive floor plans, broker inquiry funnels, and CRM automated
                            assignment.
                        </p>
                    </div>
                    <div style="font-size: 0.75rem; color: #FBBF24; font-weight: 600;">
                        Focus: High-Intent Lead Routing &rarr;
                    </div>
                </div>

                <!-- Slide 6: SaaS MVPs -->
                <div class="industry-slider-card">
                    <div>
                        <div style="font-size: 2rem; margin-bottom: 0.75rem;">🚀</div>
                        <h3 style="font-size: 1.15rem; color: #FFFFFF; margin-bottom: 0.5rem;">SaaS & Early Founders
                        </h3>
                        <p style="font-size: 0.85rem; color: var(--slate); line-height: 1.5; margin-bottom: 1rem;">
                            Multi-tenant architecture, Stripe customer portals, user authentication, and maintainable
                            cloud deployments.
                        </p>
                    </div>
                    <div style="font-size: 0.75rem; color: #F472B6; font-weight: 600;">
                        Focus: Rapid Milestone Validation &rarr;
                    </div>
                </div>
            </div>

            <!-- Slider Controls (Navigation Arrows & Pagination Dots) -->
            <div class="slider-controls-row">
                <div class="slider-nav-btns">
                    <button type="button" class="slider-nav-btn slider-nav-prev" aria-label="Previous industry slide">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>
                    <button type="button" class="slider-nav-btn slider-nav-next" aria-label="Next industry slide">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>
                <div class="slider-pagination-dots" role="tablist" aria-label="Slider pagination"></div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     OUR WORK — PRODUCTION SYSTEMS & DELIVERABLES SHOWCASE
     ========================================================================== -->
<section class="section" id="work">
    <div id="projects" style="position: absolute; top: -80px; left: 0;"></div>

    <div class="container container-wide">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Verified Deliverables & Live Working Demos</span>
            </div>
            <h2 class="section-title">
                Our Work — Systems Built for <span class="text-gradient gradient-text-animated">Real Business
                    Impact</span>
            </h2>
            <p class="section-subtitle">
                Explore real software platforms, institutional web portals, automation pipelines, and AI systems
                engineered by CodeX404 Solutions. Clean, fast, and easy to evaluate.
            </p>
        </div>

        <?php
        $homepageProjects = \App\Services\ProjectService::getActive();
        $projectTypes = \App\Services\ProjectService::getProjectTypes();
        $showcaseStatuses = \App\Services\ProjectService::getShowcaseStatuses();
        $countAll = count($homepageProjects);
        $countSoftware = count(array_filter($homepageProjects, fn($p) => ($p['category'] ?? '') === 'software'));
        $countBooking = count(array_filter($homepageProjects, fn($p) => ($p['category'] ?? '') === 'booking'));
        $countCommerce = count(array_filter($homepageProjects, fn($p) => ($p['category'] ?? '') === 'commerce'));
        $countMobile = count(array_filter($homepageProjects, fn($p) => ($p['category'] ?? '') === 'mobile'));
        $countAi = count(array_filter($homepageProjects, fn($p) => ($p['category'] ?? '') === 'ai'));
        ?>
        <!-- Category Filter Tabs -->
        <div class="project-filter-bar" role="tablist" aria-label="Project Categories"
            style="display: flex; justify-content: center; gap: 0.75rem; margin-bottom: 3.5rem; flex-wrap: wrap;">
            <button type="button" class="project-filter-btn active" data-filter="all">
                <span>✦</span> All Work (<?= $countAll ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="booking">
                <span>📅</span> Booking & Appointments (<?= $countBooking ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="software">
                <span>🏫</span> School & Institutional (<?= $countSoftware ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="commerce">
                <span>🛍️</span> E-Commerce & Catalogs (<?= $countCommerce ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="mobile">
                <span>📱</span> Mobile & PWA (<?= $countMobile ?>)
            </button>
            <?php if ($countAi > 0): ?>
                <button type="button" class="project-filter-btn" data-filter="ai">
                    <span>🤖</span> AI & Automation (<?= $countAi ?>)
                </button>
            <?php endif; ?>
        </div>

        <!-- Project Cards Grid with 3D Tilt -->
        <div class="project-showcase-grid">
            <?php foreach ($homepageProjects as $idx => $p): ?>
                <?php
                $typeKey = $p['project_type'] ?? 'client';
                $type = $projectTypes[$typeKey] ?? $projectTypes['client'];
                $statusKey = $p['showcase_status'] ?? 'live_website';
                $status = $showcaseStatuses[$statusKey] ?? $showcaseStatuses['live_website'];
                $isClient = ($typeKey === 'client');
                $isAnonymized = !empty($p['is_anonymized']);
                $clientName = $p['public_client_name'] ?? 'Verified Commercial Client';
                $cat = $p['category'] ?? 'software';
                $demoKey = $p['demo_key'] ?? 'erp';
                $artClass = match($cat) {
                    'booking' => 'cpc-art-booking',
                    'commerce' => 'cpc-art-commerce',
                    'mobile' => 'cpc-art-mobile',
                    'ai' => 'cpc-art-ai',
                    default => 'cpc-art-software'
                };
                $stageIcon = match($cat) {
                    'booking' => '🏥',
                    'commerce' => '🛒',
                    'mobile' => '📱',
                    'ai' => '🤖',
                    default => '💻'
                };
                ?>
                <article class="project-card clean-project-card card-tilt<?= $idx >= 6 ? ' is-overflow-hidden' : '' ?>"
                    data-index="<?= $idx ?>" data-category="<?= htmlspecialchars($p['category']) ?>"
                    data-type="<?= htmlspecialchars($typeKey) ?>" id="project-<?= htmlspecialchars($p['id']) ?>">
                    <div>
                        <!-- 1. Screenshot (Uploaded via Admin Panel or Sleek Dynamic Fallback) -->
                        <?php if (!empty($p['live_url'])): ?>
                            <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-media-wrap" title="Visit Live Website for <?= htmlspecialchars($p['title']) ?>">
                        <?php else: ?>
                            <div class="cpc-media-wrap" title="<?= htmlspecialchars($p['title']) ?>">
                        <?php endif; ?>
                            <div class="cpc-media-browser-bar">
                                <div class="cpc-window-dots">
                                    <span class="cpc-dot-item dot-red"></span>
                                    <span class="cpc-dot-item dot-yellow"></span>
                                    <span class="cpc-dot-item dot-green"></span>
                                </div>
                                <div class="cpc-media-url font-mono">
                                    <span>🔒</span> <?= htmlspecialchars($p['mockup_host'] ?? 'app.codex404solutions.online') ?>
                                </div>
                            </div>
                            <div class="cpc-media-viewport">
                                <?php if (!empty($p['cover_image'])): ?>
                                    <img src="<?= asset($p['cover_image']) ?>" alt="Screenshot of <?= htmlspecialchars($p['title']) ?>" class="cpc-screenshot-img" loading="lazy">
                                <?php else: ?>
                                    <div class="cpc-screenshot-placeholder <?= $artClass ?>">
                                        <span class="cpc-placeholder-icon"><?= $stageIcon ?></span>
                                        <span class="cpc-placeholder-sub"><?= htmlspecialchars($p['category_label'] ?? 'Software Platform') ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?= !empty($p['live_url']) ? '</a>' : '</div>' ?>

                        <!-- 2. Project Name (Title) -->
                        <h3 class="cpc-minimal-title">
                            <?php if (!empty($p['live_url'])): ?>
                                <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" title="<?= htmlspecialchars($p['title']) ?>">
                                    <?= htmlspecialchars($p['title']) ?>
                                </a>
                            <?php else: ?>
                                <a href="<?= url('project.php?id=' . urlencode($p['id'])) ?>" title="<?= htmlspecialchars($p['title']) ?>">
                                    <?= htmlspecialchars($p['title']) ?>
                                </a>
                            <?php endif; ?>
                        </h3>

                        <!-- 3. Clean URL Link -->
                        <div class="cpc-minimal-url-row">
                            <?php if (!empty($p['live_url'])): ?>
                                <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-minimal-url-link" title="Visit Live Production Domain">
                                    <span class="url-protocol">https://</span><span class="url-domain"><?= htmlspecialchars($p['mockup_host'] ?? parse_url($p['live_url'], PHP_URL_HOST)) ?></span>
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                </a>
                            <?php else: ?>
                                <span class="cpc-minimal-url-link disabled">
                                    <span class="url-protocol">internal://</span><span class="url-domain"><?= htmlspecialchars($p['mockup_host'] ?? 'app.codex404solutions.online') ?></span>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- 4. Main Features (Top 3 Bullet Points) -->
                        <?php if (!empty($p['features']) && is_array($p['features'])): ?>
                            <ul class="cpc-minimal-features-list">
                                <?php foreach (array_slice($p['features'], 0, 3) as $feat): ?>
                                    <li>
                                        <span class="cpc-feat-dot">✦</span>
                                        <span><?= htmlspecialchars($feat) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <!-- Card Actions: Only Live Site -->
                    <div class="cpc-footer">
                        <?php if (!empty($p['live_url'])): ?>
                            <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer"
                                class="cpc-btn cpc-btn-primary cpc-btn-full" title="Visit Live Website">
                                <span>Live Site ↗</span>
                            </a>
                        <?php else: ?>
                            <a href="<?= url('project.php?id=' . urlencode($p['id'])) ?>" class="cpc-btn cpc-btn-primary cpc-btn-full" title="View Project Specs">
                                <span>Live Site ↗</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <!-- More Projects Toggle Control -->
        <div class="projects-load-more-wrap" id="projectsLoadMoreWrap">
            <button type="button" class="projects-more-btn" id="btnToggleMoreProjects"
                aria-label="Toggle more projects">
                <span class="btn-more-text">View More Projects</span>
                <span class="btn-more-badge">+<?= max(0, $countAll - 6) ?> More</span>
                <svg class="btn-more-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- ==========================================================================
     INTERACTIVE ARCHITECTURAL SIMULATORS (SIMULATION ONLY)
     ========================================================================== -->
<section class="section" id="simulators"
    style="background: rgba(10, 22, 40, 0.4); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Interactive Architectural Simulators</span>
            </div>
            <h2 class="section-title">
                Experience System Workflows <span class="text-gradient gradient-text-animated">In Action</span>
            </h2>
            <p class="section-subtitle">
                Interactive prototypes demonstrating vector retrieval logic and webhook ingestion flows directly in your
                browser.
            </p>
        </div>

        <div class="grid grid-cols-2" style="gap: 2rem;">
            <!-- Simulator 1: Enterprise AI RAG Assistant -->
            <div class="card card-tilt"
                style="background: rgba(17, 29, 58, 0.8); border: 1px solid rgba(59, 130, 246, 0.35);">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                    <div>
                        <h3 style="font-size: 1.2rem; color: #FFFFFF; display: flex; align-items: center; gap: 0.5rem;">
                            <span>🤖</span> Enterprise AI RAG Assistant
                        </h3>
                        <p style="font-size: 0.825rem; color: var(--slate-dark); margin: 0;">Multi-source grounded
                            vector search simulation with sample citations</p>
                    </div>
                    <span class="sim-badge">Simulated Sandbox</span>
                </div>

                <!-- Prompt Chips -->
                <div style="display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1rem;">
                    <button type="button" class="rag-chip" data-prompt="What is CodeX404 client IP ownership policy?"
                        style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); color: var(--slate); font-size: 0.75rem; padding: 4px 10px; border-radius: 999px; cursor: pointer;">💡
                        IP Ownership?</button>
                    <button type="button" class="rag-chip"
                        data-prompt="How does the WhatsApp lead pipeline automate CRM?"
                        style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); color: var(--slate); font-size: 0.75rem; padding: 4px 10px; border-radius: 999px; cursor: pointer;">⚡
                        WhatsApp Pipeline?</button>
                    <button type="button" class="rag-chip" data-prompt="Tell me about the School ERP architecture"
                        style="background: rgba(255, 255, 255, 0.06); border: 1px solid rgba(255, 255, 255, 0.12); color: var(--slate); font-size: 0.75rem; padding: 4px 10px; border-radius: 999px; cursor: pointer;">🏫
                        School ERP?</button>
                </div>

                <!-- Simulated Chat Box -->
                <div id="ragChatBox"
                    style="background: #060B18; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: var(--radius-md); padding: 1rem; height: 220px; overflow-y: auto; font-size: 0.85rem; display: flex; flex-direction: column; gap: 0.75rem;">
                    <div
                        style="background: rgba(59, 130, 246, 0.12); border-left: 3px solid #38BDF8; padding: 8px 12px; border-radius: 4px; color: var(--slate);">
                        <strong style="color: #38BDF8;">CodeX404 AI Agent:</strong> Welcome! Ask any technical question
                        about our software architecture, engineering standards, or technology stack.
                    </div>
                </div>

                <!-- Input Box -->
                <div style="display: flex; gap: 0.5rem; margin-top: 1rem;">
                    <input type="text" id="ragInput" placeholder="Type a technical question or click a chip..."
                        style="flex: 1; background: #060B18; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 8px 12px; color: #FFFFFF; font-size: 0.85rem;">
                    <button type="button" id="ragSendBtn" class="btn btn-primary btn-sm">Ask</button>
                </div>
            </div>

            <!-- Simulator 2: WhatsApp CRM Automation -->
            <div class="card card-tilt"
                style="background: rgba(17, 29, 58, 0.8); border: 1px solid rgba(16, 185, 129, 0.35);">
                <div
                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                    <div>
                        <h3 style="font-size: 1.2rem; color: #FFFFFF; display: flex; align-items: center; gap: 0.5rem;">
                            <span>💬</span> WhatsApp Cloud & CRM Pipeline
                        </h3>
                        <p style="font-size: 0.825rem; color: var(--slate-dark); margin: 0;">Architectural webhook
                            simulation with mock event qualification</p>
                    </div>
                    <button type="button" id="waSimulateBtn" class="btn btn-secondary btn-sm"
                        style="font-size: 0.75rem; border-color: #10B981; color: #34D399;">
                        Simulate Inbound Lead ⚡
                    </button>
                </div>

                <div class="wa-simulator-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <!-- Phone View -->
                    <div style="background: #0B141B; border: 1px solid rgba(37, 211, 102, 0.3); border-radius: 8px; padding: 0.75rem; height: 260px; overflow-y: auto;"
                        id="waChatLog">
                        <div style="font-size: 0.72rem; color: #8696A0; text-align: center; margin-bottom: 0.5rem;">
                            WhatsApp Cloud API Simulator Stream</div>
                        <div
                            style="background: #005C4B; color: #E9EDEF; padding: 8px 12px; border-radius: 8px; font-size: 0.8rem; margin-left: auto; max-width: 90%;">
                            Simulator listening for sample inbound events.
                        </div>
                    </div>

                    <!-- CRM Board View -->
                    <div style="background: #060B18; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; padding: 0.75rem; height: 260px; overflow-y: auto;"
                        id="crmLeadList">
                        <div
                            style="font-size: 0.72rem; color: var(--slate-dark); text-transform: uppercase; margin-bottom: 0.5rem; font-weight: 700;">
                            Simulated Ingestion Flow</div>
                        <div
                            style="background: rgba(11, 20, 38, 0.9); border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 6px; padding: 8px; font-size: 0.78rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <strong style="color: #38BDF8;">Enterprise Portal Lead</strong>
                                <span
                                    style="background: rgba(16, 185, 129, 0.2); color: #34D399; font-size: 0.65rem; padding: 2px 5px; border-radius: 4px;">SYNCED</span>
                            </div>
                            <div style="color: var(--slate); font-size: 0.72rem; margin-top: 4px;">Source: Ingestion
                                Simulator • Status: Mock Stream</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p class="sim-disclaimer" style="text-align: center; margin-top: 1.25rem;">
            * Note: The panels above are interactive architectural simulations demonstrating vector retrieval logic and
            webhook event dispatching. They are not connected to active production databases or live third-party cloud
            messaging endpoints.
        </p>
    </div>
</section>


<!-- ==========================================================================
     FOUNDER & LEADERSHIP SECTION
     ========================================================================== -->
<?php include __DIR__ . '/components/leadership.php'; ?>


<!-- ==========================================================================
     ENGINEERING DELIVERY PROCESS (NOTE: DO NOT EDIT process.php)
     ========================================================================== -->
<section class="section" id="process" style="background: rgba(10, 22, 40, 0.3);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Deterministic Delivery</span>
            </div>
            <h2 class="section-title">
                Clarity Before Velocity. <span class="text-gradient gradient-text-animated">Scope Before Build.</span>
            </h2>
            <p class="section-subtitle">
                We eliminate guesswork through transparent technical milestones and continuous verification.
            </p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card card-tilt" style="background: rgba(17, 29, 58, 0.7); position: relative;">
                <div
                    style="color: var(--cyan); font-family: var(--font-mono); font-size: 1.8rem; font-weight: 800; margin-bottom: 0.75rem;">
                    01</div>
                <h3 style="font-size: 1.15rem; color: #FFFFFF; margin-bottom: 0.5rem;">Constraint Diagnosis</h3>
                <p style="font-size: 0.875rem; color: var(--slate);">Identify current bottlenecks, data structures, and
                    user friction points before quoting.</p>
            </div>

            <div class="card card-tilt" style="background: rgba(17, 29, 58, 0.7); position: relative;">
                <div
                    style="color: #38BDF8; font-family: var(--font-mono); font-size: 1.8rem; font-weight: 800; margin-bottom: 0.75rem;">
                    02</div>
                <h3 style="font-size: 1.15rem; color: #FFFFFF; margin-bottom: 0.5rem;">Milestone Scoping</h3>
                <p style="font-size: 0.875rem; color: var(--slate);">Define explicit deliverables, acceptance criteria,
                    test suites, and budget boundaries.</p>
            </div>

            <div class="card card-tilt" style="background: rgba(17, 29, 58, 0.7); position: relative;">
                <div
                    style="color: var(--soft-violet); font-family: var(--font-mono); font-size: 1.8rem; font-weight: 800; margin-bottom: 0.75rem;">
                    03</div>
                <h3 style="font-size: 1.15rem; color: #FFFFFF; margin-bottom: 0.5rem;">Hardened Build</h3>
                <p style="font-size: 0.875rem; color: var(--slate);">Ship verified code every 2 weeks with live preview
                    staging and automated regression tests.</p>
            </div>

            <div class="card card-tilt" style="background: rgba(17, 29, 58, 0.7); position: relative;">
                <div
                    style="color: #34D399; font-family: var(--font-mono); font-size: 1.8rem; font-weight: 800; margin-bottom: 0.75rem;">
                    04</div>
                <h3 style="font-size: 1.15rem; color: #FFFFFF; margin-bottom: 0.5rem;">Handoff & IP Assignment</h3>
                <p style="font-size: 0.875rem; color: var(--slate);">Contracted repository transfer, operating
                    documentation, and production environment ownership.</p>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     FREQUENTLY ASKED QUESTIONS (ACCORDION)
     ========================================================================== -->
<section class="section" id="faq">
    <div class="container" style="max-width: 860px;">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Frequently Asked Questions</span>
            </div>
            <h2 class="section-title">
                Everything You Need to Know <span class="text-gradient gradient-text-animated">Before Starting</span>
            </h2>
        </div>

        <div class="faq-list">
            <div class="faq-item">
                <button type="button" class="faq-question" id="faq-1" aria-expanded="false">
                    <span>Who owns the source code and IP?</span>
                    <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer" id="faq-1-answer">
                    <p>Upon milestone completion, accepted deliverables, and full payment per contract terms, the
                        developed code, project configurations, and documentation are transferred to your business with
                        no proprietary vendor lock-in.</p>
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question" id="faq-2" aria-expanded="false">
                    <span>What does "Where Bugs Meet Their Match" mean in practice?</span>
                    <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer" id="faq-2-answer">
                    <p>It represents our senior-led engineering discipline. We build with strict type-safety, automated
                        test coverage, defensive parameter validation, and pre-deployment code reviews to identify and
                        address issues early in the development lifecycle.</p>
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question" id="faq-3" aria-expanded="false">
                    <span>How quickly can you deliver an initial production MVP?</span>
                    <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer" id="faq-3-answer">
                    <p>Timeline depends on scope and technical complexity. Focused MVPs and automations are structured
                        into clear two-week milestone sprints, with sprint goals and deliverables agreed upon before
                        work begins.</p>
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question" id="faq-4" aria-expanded="false">
                    <span>Do you offer post-launch support and retainers?</span>
                    <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer" id="faq-4-answer">
                    <p>Yes. Projects include a post-launch stabilization window for critical defect remediation and
                        monitoring. We also provide scheduled retainer packages for ongoing feature development,
                        infrastructure maintenance, and system enhancements.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     START YOUR PROJECT — INQUIRY & CONTACT SECTION
     ========================================================================== -->
<section class="home-contact-section" id="contact-section">
    <div class="container">
        <div class="home-contact-grid">
            <div>
                <div class="section-tag" style="margin-bottom: 1rem;">
                    <span class="dot"></span>
                    <span>Start Your Project</span>
                </div>
                <h2 style="font-size: clamp(2rem, 3.5vw, 2.75rem); line-height: 1.2; margin-bottom: 1.25rem;">
                    Ready to build software that <span class="text-gradient gradient-text-animated">actually
                        delivers?</span>
                </h2>
                <p style="font-size: 1.05rem; line-height: 1.7; color: var(--slate); margin-bottom: 2rem;">
                    Tell us what your current digital system or workflow cannot do. Our engineering leads will review
                    your requirements and follow up promptly with initial technical scoping.
                </p>

                <div class="trust-badge-list">
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">✓</div>
                        <div>Direct access to Senior Architects (No sales runaround)</div>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">✓</div>
                        <div>Fixed-scope milestone estimates with clear acceptance criteria</div>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">✓</div>
                        <div>Clear contractual IP assignment upon milestone delivery</div>
                    </div>
                </div>

                <div style="margin-top: 2.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary">
                        <span>📅 Book Discovery Call</span>
                    </a>
                    <a href="mailto:<?= COMPANY_EMAIL ?>" class="btn btn-secondary">
                        <span>Email: <?= COMPANY_EMAIL ?></span>
                    </a>
                </div>
            </div>

            <!-- Inbound Form Card -->
            <div class="card form-card"
                style="background: rgba(17, 29, 58, 0.9); border: 1px solid rgba(59, 130, 246, 0.35);">
                <form id="projectInquiryForm" action="<?= url('contact.php') ?>" method="POST" class="ajax-form"
                    novalidate>
                    <?= csrf_input_field() ?>

                    <!-- Honeypot -->
                    <div style="display: none;" aria-hidden="true">
                        <label for="inquiry_gotcha">Leave this empty</label>
                        <input type="text" name="_gotcha" id="inquiry_gotcha" tabindex="-1" autocomplete="off">
                    </div>

                    <h3 style="font-size: 1.3rem; margin-bottom: 1.25rem; color: #FFFFFF;">Project Discovery Inquiry
                    </h3>

                    <div class="form-alert-container"></div>

                    <div style="margin-bottom: 1.25rem;">
                        <label for="contact_name"
                            style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--slate);">Your
                            Name *</label>
                        <input type="text" id="contact_name" name="name" required class="form-control"
                            placeholder="e.g. Sarah Jenkins"
                            style="width: 100%; background: #060B18; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 10px 14px; color: #FFFFFF;">
                    </div>

                    <div style="margin-bottom: 1.25rem;">
                        <label for="contact_email"
                            style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--slate);">Work
                            Email *</label>
                        <input type="email" id="contact_email" name="email" required class="form-control"
                            placeholder="sarah@company.com"
                            style="width: 100%; background: #060B18; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 10px 14px; color: #FFFFFF;">
                    </div>

                    <div style="margin-bottom: 1.25rem;">
                        <label for="division_select"
                            style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--slate);">Primary
                            Division *</label>
                        <select id="division_select" name="division" class="form-control"
                            style="width: 100%; background: #060B18; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 10px 14px; color: #FFFFFF;">
                            <option value="build">BUILD — Software, Web Platforms, SaaS, Mobile Apps</option>
                            <option value="grow">GROW — Search Visibility, AEO/GEO, Digital Marketing</option>
                            <option value="automate">AUTOMATE — AI Agents, RAG Knowledge, Workflow Pipelines</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 1.25rem;">
                        <label for="service_interest"
                            style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--slate);">Area
                            of Specific Interest</label>
                        <select id="service_interest" name="service" class="form-control"
                            style="width: 100%; background: #060B18; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 10px 14px; color: #FFFFFF;">
                            <option value="custom_software">Custom Web Platform / Internal Portal (BUILD)</option>
                            <option value="saas_mvp">SaaS MVP Engineering (BUILD)</option>
                            <option value="mobile_app">Mobile Application (BUILD)</option>
                            <option value="search_visibility">Search Engine Visibility & AEO/GEO (GROW)</option>
                            <option value="digital_marketing">Digital Marketing Campaigns (GROW)</option>
                            <option value="enterprise_ai">Enterprise AI & Knowledge RAG (AUTOMATE)</option>
                            <option value="ai_agents">Autonomous AI Agents (AUTOMATE)</option>
                            <option value="workflow_automation">Workflow Automation & WhatsApp API (AUTOMATE)</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 1.25rem;">
                        <label for="contact_details"
                            style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--slate);">Project
                            Context & Current Bottleneck *</label>
                        <textarea id="contact_details" name="message" rows="4" required class="form-control"
                            placeholder="Describe the business bottleneck, key user workflows, or integrations required..."
                            style="width: 100%; background: #060B18; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 10px 14px; color: #FFFFFF; font-family: inherit; resize: vertical;"></textarea>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label
                            style="display: flex; align-items: flex-start; gap: 0.6rem; font-size: 0.82rem; color: var(--slate); cursor: pointer;">
                            <input type="checkbox" name="privacy_consent" value="1" checked required
                                style="margin-top: 3px; accent-color: var(--cyan);">
                            <span>I agree to the <a href="<?= url('privacy.php') ?>" target="_blank"
                                    style="color: var(--cyan); text-decoration: underline;">Privacy Policy</a> and
                                consent to have CodeX404 Solutions review my project details.</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg" style="width: 100%;">
                        <span>Request Technical Scoping Review &rarr;</span>
                    </button>
                    <div style="font-size: 0.75rem; color: var(--slate-dark); text-align: center; margin-top: 0.75rem;">
                        🔒 Confidential • Zero spam • Prompt review during business hours
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Interactive Live Demo Modal Overlay (For Trigger Buttons) -->
<?php include __DIR__ . '/components/demo-modal.php'; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>