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
                <span class="typewriter-text" id="typewriter">Enterprise AI & RAG Architectures</span>
                <span class="typewriter-cursor"></span>
            </div>

            <p class="hero-description">
                We design, build, and automate high-performance software systems — zero bugs, production-grade cloud
                architectures, autonomous multi-tool AI pipelines, and 100% client IP ownership.
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

            <!-- Value / Capability Stats Strip -->
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
                    <div class="terminal-tabs" role="tablist" aria-label="Terminal Environments">
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

                    <div style="font-size: 0.725rem; color: #34D399; font-family: var(--font-mono); font-weight: 600;">●
                        LIVE SYSTEM</div>
                </div>

                <div class="tech-frame-body">
                    <!-- Pane 1: Deploy -->
                    <div class="terminal-pane active" id="pane-deploy">
                        <div class="code-comment">// Production Zero-Downtime Deployment</div>
                        <div><span class="code-keyword">$</span> <span class="code-accent">codex404</span> deploy --env
                            production --fast</div>
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
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Production Pipeline: 99.99% Availability
                        </div>
                    </div>

                    <!-- Pane 2: Audit & Zero Bugs -->
                    <div class="terminal-pane" id="pane-audit">
                        <div class="code-comment">// Deep Security & Bug Elimination Scan</div>
                        <div><span class="code-keyword">$</span> <span class="code-accent">codex404</span> audit --deep
                            --zero-bugs</div>
                        <div style="color: var(--slate); margin-top: 0.35rem;">
                            &rarr; Scanning 48,200 lines across backend & UI...<br>
                            &rarr; Memory leaks: <span style="color: #34D399; font-weight: bold;">0 detected</span><br>
                            &rarr; OWASP Top 10 vulnerabilities: <span style="color: #34D399; font-weight: bold;">0
                                found</span>
                        </div>
                        <div style="color: #38BDF8; margin-top: 0.5rem; font-weight: 600;">
                            🎯 Where Bugs Meet Their Match — 100% Quality Assurance<br>
                            ✔ Strict type-safety & automated idempotency checks
                        </div>
                        <div class="pipeline-badge"
                            style="background: rgba(56, 189, 248, 0.12); color: #38BDF8; border-color: rgba(56, 189, 248, 0.25);">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 14 14"></polyline>
                            </svg>
                            Deterministic Zero-Defect Guarantee
                        </div>
                    </div>

                    <!-- Pane 3: AI Agent Workflow -->
                    <div class="terminal-pane" id="pane-agent">
                        <div class="code-comment">// Autonomous Enterprise AI & RAG Pipeline</div>
                        <div><span class="code-keyword">$</span> <span class="code-accent">codex404</span> agent
                            --pipeline rag-sync --stream</div>
                        <div style="color: var(--slate); margin-top: 0.35rem;">
                            &rarr; Connecting private Qdrant vector index...<br>
                            &rarr; Synchronizing 14,000 corporate policy files...<br>
                            &rarr; Executing multi-tool agentic resolution loop...
                        </div>
                        <div style="color: #F472B6; margin-top: 0.5rem; font-weight: 500;">
                            ✔ Inbound inquiry auto-resolved in 1.8s<br>
                            ✔ Webhook sync dispatched to CRM & WhatsApp API
                        </div>
                        <div class="pipeline-badge"
                            style="background: rgba(236, 72, 153, 0.12); color: #F472B6; border-color: rgba(236, 72, 153, 0.25);">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                            Autonomous Execution with Audit Trail
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
            <div class="tech-pill-item"><span class="tech-pill-icon">🛡️</span> OWASP Zero-Defect Hardening</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">💼</span> 7+ Yrs Enterprise TCS Pedigree</div>
            <!-- Seamless Duplicate Loop -->
            <div class="tech-pill-item"><span class="tech-pill-icon">☁️</span> AWS Cloud Architecture</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">⚡</span> Redis Distributed Cache</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🤖</span> Autonomous Multi-Agent AI</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📊</span> LangChain & Qdrant RAG</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">📱</span> Progressive Web Apps (PWA)</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">💳</span> Stripe & Payment Gateways</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🔄</span> CI/CD GitHub Actions</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">🛡️</span> OWASP Zero-Defect Hardening</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">💼</span> 7+ Yrs Enterprise TCS Pedigree</div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     INTERACTIVE SVG ARCHITECTURE & FLOW BANNER
     ========================================================================== -->
<section class="arch-flow-section" aria-label="System Architecture Flow">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>The CodeX404 Engineering Flow</span>
            </div>
            <h2 class="section-title">
                From Complex Constraints to <span class="text-gradient gradient-text-animated">Flawless
                    Production</span>
            </h2>
            <p class="section-subtitle">
                A deterministic pipeline built on senior engineering, automated type-safety, and enterprise AI
                orchestration.
            </p>
        </div>

        <div class="arch-svg-banner">
            <svg viewBox="0 0 1000 240" fill="none" xmlns="http://www.w3.org/2000/svg" role="img"
                aria-label="CodeX404 Architecture Diagram">
                <defs>
                    <linearGradient id="gradPath" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#00F0FF" />
                        <stop offset="50%" stop-color="#8B5CF6" />
                        <stop offset="100%" stop-color="#34D399" />
                    </linearGradient>
                    <linearGradient id="cardGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#111D3A" />
                        <stop offset="100%" stop-color="#0A1628" />
                    </linearGradient>
                    <filter id="glowFilter" x="-20%" y="-20%" width="140%" height="140%">
                        <feGaussianBlur stdDeviation="6" result="blur" />
                        <feComposite in="SourceGraphic" in2="blur" operator="over" />
                    </filter>
                </defs>

                <!-- Connecting Flow Lines -->
                <path d="M 200 120 L 330 120" stroke="url(#gradPath)" stroke-width="3" stroke-dasharray="6 4">
                    <animate attributeName="stroke-dashoffset" from="20" to="0" dur="1.5s" repeatCount="indefinite" />
                </path>
                <path d="M 470 120 L 600 120" stroke="url(#gradPath)" stroke-width="3" stroke-dasharray="6 4">
                    <animate attributeName="stroke-dashoffset" from="20" to="0" dur="1.5s" repeatCount="indefinite" />
                </path>
                <path d="M 740 120 L 870 120" stroke="url(#gradPath)" stroke-width="3" stroke-dasharray="6 4">
                    <animate attributeName="stroke-dashoffset" from="20" to="0" dur="1.5s" repeatCount="indefinite" />
                </path>

                <!-- Flow Step 1: Input -->
                <g transform="translate(40, 50)">
                    <rect width="180" height="140" rx="14" fill="url(#cardGrad1)" stroke="#00F0FF" stroke-width="1.5" />
                    <circle cx="90" cy="45" r="24" fill="rgba(0, 240, 255, 0.15)" stroke="#00F0FF" stroke-width="1.5" />
                    <text x="90" y="52" fill="#00F0FF" font-family="'Plus Jakarta Sans', sans-serif" font-size="20"
                        text-anchor="middle">🎯</text>
                    <text x="90" y="100" fill="#FFFFFF" font-family="'Plus Jakarta Sans', sans-serif" font-size="14"
                        font-weight="700" text-anchor="middle">1. Client Objective</text>
                    <text x="90" y="122" fill="#94A3B8" font-family="'JetBrains Mono', monospace" font-size="11"
                        text-anchor="middle">Scope & Bottleneck</text>
                </g>

                <!-- Flow Step 2: AI & Agentic RAG -->
                <g transform="translate(310, 50)">
                    <rect width="180" height="140" rx="14" fill="url(#cardGrad1)" stroke="#8B5CF6" stroke-width="1.5" />
                    <circle cx="90" cy="45" r="24" fill="rgba(139, 92, 246, 0.15)" stroke="#8B5CF6"
                        stroke-width="1.5" />
                    <text x="90" y="52" fill="#A78BFA" font-family="'Plus Jakarta Sans', sans-serif" font-size="20"
                        text-anchor="middle">🧠</text>
                    <text x="90" y="100" fill="#FFFFFF" font-family="'Plus Jakarta Sans', sans-serif" font-size="14"
                        font-weight="700" text-anchor="middle">2. AI & Architecture</text>
                    <text x="90" y="122" fill="#94A3B8" font-family="'JetBrains Mono', monospace" font-size="11"
                        text-anchor="middle">Multi-Agent & Vector</text>
                </g>

                <!-- Flow Step 3: Hardened Build -->
                <g transform="translate(580, 50)">
                    <rect width="180" height="140" rx="14" fill="url(#cardGrad1)" stroke="#EC4899" stroke-width="1.5" />
                    <circle cx="90" cy="45" r="24" fill="rgba(236, 72, 153, 0.15)" stroke="#EC4899"
                        stroke-width="1.5" />
                    <text x="90" y="52" fill="#F472B6" font-family="'Plus Jakarta Sans', sans-serif" font-size="20"
                        text-anchor="middle">🛡️</text>
                    <text x="90" y="100" fill="#FFFFFF" font-family="'Plus Jakarta Sans', sans-serif" font-size="14"
                        font-weight="700" text-anchor="middle">3. Zero-Bug Build</text>
                    <text x="90" y="122" fill="#94A3B8" font-family="'JetBrains Mono', monospace" font-size="11"
                        text-anchor="middle">Type-Safe & Scaled</text>
                </g>

                <!-- Flow Step 4: Production -->
                <g transform="translate(850, 50)">
                    <rect width="140" height="140" rx="14" fill="url(#cardGrad1)" stroke="#34D399" stroke-width="1.5" />
                    <circle cx="70" cy="45" r="24" fill="rgba(52, 211, 153, 0.15)" stroke="#34D399"
                        stroke-width="1.5" />
                    <text x="70" y="52" fill="#34D399" font-family="'Plus Jakarta Sans', sans-serif" font-size="20"
                        text-anchor="middle">🚀</text>
                    <text x="70" y="100" fill="#FFFFFF" font-family="'Plus Jakarta Sans', sans-serif" font-size="14"
                        font-weight="700" text-anchor="middle">4. Live Asset</text>
                    <text x="70" y="122" fill="#34D399" font-family="'JetBrains Mono', monospace" font-size="11"
                        text-anchor="middle">100% Owned IP</text>
                </g>
            </svg>
        </div>
    </div>
</section>

<!-- ==========================================================================
     OUR WORK — PRODUCTION SYSTEMS & DELIVERABLES SHOWCASE
     ========================================================================== -->
<section class="section" id="work">
    <div id="projects" style="position: absolute; top: -80px; left: 0;"></div>

    <div class="container">
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
            <?php foreach ($homepageProjects as $p): ?>
                <article class="project-card clean-project-card card-tilt"
                    data-category="<?= htmlspecialchars($p['category']) ?>" id="project-<?= htmlspecialchars($p['id']) ?>">
                    <div>
                        <!-- Header with meta & verified live domain -->
                        <div class="cpc-header">
                            <div class="cpc-meta">
                                <span
                                    class="cpc-category"><?= htmlspecialchars($p['category_label'] ?? 'Custom Software') ?></span>
                                <span class="cpc-badge">
                                    <span class="cpc-dot"></span>
                                    <?= htmlspecialchars($p['badge_text'] ?? 'Production Live') ?>
                                </span>
                            </div>
                            <?php if (!empty($p['live_url'])): ?>
                                <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer"
                                    class="cpc-domain-pill" title="Visit Live Website">
                                    <span><?= htmlspecialchars($p['mockup_host'] ?? '') ?></span>
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                        <polyline points="15 3 21 3 21 9"></polyline>
                                        <line x1="10" y1="14" x2="21" y2="3"></line>
                                    </svg>
                                </a>
                            <?php else: ?>
                                <span class="cpc-domain-pill">
                                    <span><?= htmlspecialchars($p['mockup_host'] ?? '') ?></span>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Card Body -->
                        <div class="cpc-body">
                            <h3 class="cpc-title">
                                <?php if (!empty($p['live_url'])): ?>
                                    <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer"
                                        title="Visit <?= htmlspecialchars($p['title']) ?>"><?= htmlspecialchars($p['title']) ?></a>
                                <?php else: ?>
                                    <?= htmlspecialchars($p['title']) ?>
                                <?php endif; ?>
                            </h3>
                            <p class="cpc-description"><?= htmlspecialchars($p['solution'] ?? $p['description'] ?? '') ?>
                            </p>

                            <?php if (!empty($p['metric'])): ?>
                                <div class="cpc-metric">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                    <span><?= htmlspecialchars($p['metric']) ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Tags -->
                            <?php if (!empty($p['tags']) && is_array($p['tags'])): ?>
                                <div class="cpc-tags">
                                    <?php foreach (array_slice($p['tags'], 0, 3) as $tag): ?>
                                        <span class="cpc-tag"><?= htmlspecialchars($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="cpc-footer">
                        <?php if (!empty($p['live_url'])): ?>
                            <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer"
                                class="cpc-btn cpc-btn-primary">
                                <span>Live Site ↗</span>
                            </a>
                        <?php else: ?>
                            <a href="<?= url('discovery-call.php') ?>" class="cpc-btn cpc-btn-primary">
                                <span>Request Spec</span>
                            </a>
                        <?php endif; ?>
                        <button type="button" class="cpc-btn cpc-btn-secondary btn-demo-trigger"
                            data-demo="<?= htmlspecialchars($p['demo_key'] ?? 'rag') ?>">
                            <span>⚡ Demo</span>
                        </button>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==========================================================================
     INTERACTIVE LIVE DEMO SIMULATORS
     ========================================================================== -->
<section class="section" id="simulators"
    style="background: rgba(10, 22, 40, 0.4); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Live In-Browser Simulators</span>
            </div>
            <h2 class="section-title">
                Experience Our Software & AI <span class="text-gradient gradient-text-animated">In Action</span>
            </h2>
            <p class="section-subtitle">
                Don't take our word for it. Test real working interactive prototypes of our Enterprise AI RAG assistant
                and WhatsApp CRM automation directly in your browser.
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
                            vector search with audit citations</p>
                    </div>
                    <span
                        style="background: rgba(16, 185, 129, 0.15); color: #34D399; font-size: 0.72rem; padding: 3px 8px; border-radius: 999px; font-weight: 700;">LIVE
                        SIMULATOR</span>
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
                        about our software architecture, zero-bug policy, or IP ownership.
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
                        <p style="font-size: 0.825rem; color: var(--slate-dark); margin: 0;">Sub-second webhook
                            ingestion with auto-qualification</p>
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
                            WhatsApp Cloud API Stream</div>
                        <div
                            style="background: #005C4B; color: #E9EDEF; padding: 8px 12px; border-radius: 8px; font-size: 0.8rem; margin-left: auto; max-width: 90%;">
                            System live and listening for inbound inquiries.
                        </div>
                    </div>

                    <!-- CRM Board View -->
                    <div style="background: #060B18; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; padding: 0.75rem; height: 260px; overflow-y: auto;"
                        id="crmLeadList">
                        <div
                            style="font-size: 0.72rem; color: var(--slate-dark); text-transform: uppercase; margin-bottom: 0.5rem; font-weight: 700;">
                            Live CRM Ingestion</div>
                        <div
                            style="background: rgba(11, 20, 38, 0.9); border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 6px; padding: 8px; font-size: 0.78rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <strong style="color: #38BDF8;">Enterprise Portal Lead</strong>
                                <span
                                    style="background: rgba(16, 185, 129, 0.2); color: #34D399; font-size: 0.65rem; padding: 2px 5px; border-radius: 4px;">SYNCED</span>
                            </div>
                            <div style="color: var(--slate); font-size: 0.72rem; margin-top: 4px;">Source: Webhook •
                                Latency: 42ms</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     CORE SOLUTIONS & CAPABILITIES GRID
     ========================================================================== -->
<section class="section" id="solutions">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Our Core Capabilities</span>
            </div>
            <h2 class="section-title">
                One Senior Partner from <span class="text-gradient gradient-text-animated">Architecture to Scale</span>
            </h2>
            <p class="section-subtitle">
                Engineered for speed, strict security standards, and zero vendor lock-in.
            </p>
        </div>

        <div class="grid grid-cols-3" style="gap: 1.75rem;">
            <!-- Capability 1 -->
            <article class="card card-tilt" style="background: rgba(17, 29, 58, 0.75);">
                <div style="font-size: 2rem; margin-bottom: 1rem;">💻</div>
                <h3 style="margin-bottom: 0.5rem; color: #FFFFFF;">Custom Web Applications</h3>
                <p style="font-size: 0.925rem; color: var(--slate);">
                    Internal business portals, customer dashboards, and high-load web systems shaped around your
                    specific team workflows.
                </p>
                <a href="<?= url('software-development.php') ?>" class="text-cyan"
                    style="font-weight: 600; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 4px; margin-top: 1rem;">
                    Learn about Web Platforms &rarr;
                </a>
            </article>

            <!-- Capability 2 -->
            <article class="card card-tilt" style="background: rgba(17, 29, 58, 0.75);">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🧠</div>
                <h3 style="margin-bottom: 0.5rem; color: #FFFFFF;">Enterprise AI & RAG</h3>
                <p style="font-size: 0.925rem; color: var(--slate);">
                    Connect private company documents, policies, and SQL databases to intelligent LLMs with verified
                    vector citations.
                </p>
                <a href="<?= url('ai-solutions.php') ?>" class="text-violet"
                    style="font-weight: 600; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 4px; margin-top: 1rem;">
                    Explore Enterprise AI &rarr;
                </a>
            </article>

            <!-- Capability 3 -->
            <article class="card card-tilt" style="background: rgba(17, 29, 58, 0.75);">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🤖</div>
                <h3 style="margin-bottom: 0.5rem; color: #FFFFFF;">Autonomous AI Agents</h3>
                <p style="font-size: 0.925rem; color: var(--slate);">
                    Multi-tool autonomous agents that read email threads, resolve customer support inquiries, and
                    trigger CRM updates.
                </p>
                <a href="<?= url('ai-agents.php') ?>" class="text-pink"
                    style="font-weight: 600; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 4px; margin-top: 1rem;">
                    Discover AI Agents &rarr;
                </a>
            </article>

            <!-- Capability 4 -->
            <article class="card card-tilt" style="background: rgba(17, 29, 58, 0.75);">
                <div style="font-size: 2rem; margin-bottom: 1rem;">⚡</div>
                <h3 style="margin-bottom: 0.5rem; color: #FFFFFF;">Workflow & API Automation</h3>
                <p style="font-size: 0.925rem; color: var(--slate);">
                    Eliminate repetitive manual data entry. Synchronize WhatsApp Cloud API, Stripe billing, and CRM
                    databases in real-time.
                </p>
                <a href="<?= url('automation.php') ?>" class="text-blue"
                    style="font-weight: 600; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 4px; margin-top: 1rem;">
                    See Automation Pipelines &rarr;
                </a>
            </article>

            <!-- Capability 5 -->
            <article class="card card-tilt" style="background: rgba(17, 29, 58, 0.75);">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🚀</div>
                <h3 style="margin-bottom: 0.5rem; color: #FFFFFF;">SaaS MVP Development</h3>
                <p style="font-size: 0.925rem; color: var(--slate);">
                    Launch your SaaS product in weeks with multi-tenant security, Stripe subscription billing, and a
                    clean maintainable foundation.
                </p>
                <a href="<?= url('saas.php') ?>" class="text-emerald"
                    style="font-weight: 600; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 4px; margin-top: 1rem;">
                    Explore SaaS Roadmaps &rarr;
                </a>
            </article>

            <!-- Capability 6 -->
            <article class="card card-tilt" style="background: rgba(17, 29, 58, 0.75);">
                <div style="font-size: 2rem; margin-bottom: 1rem;">📱</div>
                <h3 style="margin-bottom: 0.5rem; color: #FFFFFF;">Mobile & PWA Apps</h3>
                <p style="font-size: 0.925rem; color: var(--slate);">
                    Fast, responsive mobile applications that install natively on iOS and Android devices with offline
                    caching and push notifications.
                </p>
                <a href="<?= url('mobile-apps.php') ?>" class="text-amber"
                    style="font-weight: 600; font-size: 0.88rem; display: inline-flex; align-items: center; gap: 4px; margin-top: 1rem;">
                    Learn about Mobile Apps &rarr;
                </a>
            </article>
        </div>
    </div>
</section>

<!-- ==========================================================================
     INTERACTIVE ROI & SYSTEM EFFICIENCY CALCULATOR
     ========================================================================== -->
<section class="section" style="background: rgba(6, 11, 24, 0.6);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>System Efficiency Calculator</span>
            </div>
            <h2 class="section-title">
                Quantify Your <span class="text-gradient gradient-text-animated">Automation & Software ROI</span>
            </h2>
            <p class="section-subtitle">
                Calculate how much operational budget and engineering bandwidth your business recovers by replacing
                manual bottlenecks.
            </p>
        </div>

        <div class="roi-calculator-card">
            <!-- Slider 1: Team Size -->
            <div class="roi-slider-group">
                <div class="roi-slider-header">
                    <label for="roiTeamSlider">Your Current Team / Operations Size</label>
                    <span class="roi-slider-badge" id="roiTeamVal">12 Engineers / Staff</span>
                </div>
                <input type="range" id="roiTeamSlider" class="roi-slider" min="3" max="100" value="12" step="1">
            </div>

            <!-- Slider 2: Hours wasted per person -->
            <div class="roi-slider-group">
                <div class="roi-slider-header">
                    <label for="roiHoursSlider">Hours Wasted Weekly on Repetitive Work (per person)</label>
                    <span class="roi-slider-badge" id="roiHoursVal">10 hrs / week / person</span>
                </div>
                <input type="range" id="roiHoursSlider" class="roi-slider" min="2" max="25" value="10" step="1">
            </div>

            <!-- Computed Outcomes Grid -->
            <div class="roi-results-grid">
                <div class="roi-result-item">
                    <div class="label">Hours Recovered Annually</div>
                    <div class="val" id="roiHoursSavedVal">4,500 hrs / yr</div>
                </div>
                <div class="roi-result-item">
                    <div class="label">Estimated Annual Capital Saved</div>
                    <div class="val" id="roiSavingsVal">$202,500</div>
                </div>
                <div class="roi-result-item">
                    <div class="label">Estimated Time-to-Delivery</div>
                    <div class="val" id="roiTimelineVal" style="color: #38BDF8;">2 - 3 Sprints</div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 2rem;">
                <a href="#contact-section" class="btn btn-primary btn-lg">
                    <span>Discuss Custom Automation Architecture &rarr;</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     FOUNDER & LEADERSHIP SECTION
     ========================================================================== -->
<section class="section" id="leadership" style="border-top: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Leadership & Technical Pedigree</span>
            </div>
            <h2 class="section-title">
                Senior Engineering Led by <span class="text-gradient gradient-text-animated">Real Practitioners</span>
            </h2>
            <p class="section-subtitle">
                No intermediate account-managers. You communicate directly with systems architects who have engineered
                solutions for enterprise giants.
            </p>
        </div>

        <div class="grid grid-cols-2" style="max-width: 980px; margin: 0 auto; gap: 2rem;">
            <!-- Founder: Muhammad Noukhez -->
            <article class="card card-tilt"
                style="background: rgba(17, 29, 58, 0.85); border: 1px solid rgba(59, 130, 246, 0.35); text-align: center; padding: 2.5rem;">
                <div style="position: relative; width: 120px; height: 120px; margin: 0 auto 1.5rem auto;">
                    <img src="<?= FOUNDER_IMAGE ?>" alt="<?= FOUNDER_NAME ?>"
                        style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid var(--cyan); box-shadow: 0 0 20px rgba(6, 214, 160, 0.4);">
                    <span
                        style="position: absolute; bottom: 4px; right: 4px; width: 18px; height: 18px; background: #10B981; border: 3px solid #060B18; border-radius: 50%; box-shadow: 0 0 8px #10B981;"></span>
                </div>
                <h3 style="font-size: 1.4rem; color: #FFFFFF; margin-bottom: 0.35rem;">
                    <a href="https://mnoukhej.github.io/portfolio/" target="_blank" rel="noopener"
                        class="top-founder-link"><?= FOUNDER_NAME ?></a>
                </h3>
                <div
                    style="font-size: 0.85rem; color: #38BDF8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">
                    <?= FOUNDER_ROLE ?> • 7+ Yrs TCS Enterprise Specialist
                </div>
                <p style="font-size: 0.9rem; color: var(--slate); line-height: 1.6; margin-bottom: 1.5rem;">
                    <?= FOUNDER_BIO ?> Specialized in high-throughput Python architecture, Azure OpenAI & RAG systems,
                    and resilient cloud web platforms.
                </p>
                <div style="display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="https://mnoukhej.github.io/portfolio/" target="_blank" rel="noopener"
                        class="btn btn-primary btn-sm">
                        <span>View Portfolio ↗</span>
                    </a>
                    <a href="<?= FOUNDER_LINKEDIN ?>" target="_blank" rel="noopener noreferrer"
                        class="btn btn-secondary btn-sm">
                        <span>LinkedIn</span>
                    </a>
                </div>
            </article>

            <!-- Co-Founder: Yousuf Ansari -->
            <article class="card card-tilt"
                style="background: rgba(17, 29, 58, 0.85); border: 1px solid rgba(139, 92, 246, 0.35); text-align: center; padding: 2.5rem;">
                <div style="position: relative; width: 120px; height: 120px; margin: 0 auto 1.5rem auto;">
                    <img src="<?= COFOUNDER_IMAGE ?>" alt="<?= COFOUNDER_NAME ?>"
                        style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid var(--violet); box-shadow: 0 0 20px rgba(139, 92, 246, 0.4);">
                    <span
                        style="position: absolute; bottom: 4px; right: 4px; width: 18px; height: 18px; background: #10B981; border: 3px solid #060B18; border-radius: 50%; box-shadow: 0 0 8px #10B981;"></span>
                </div>
                <h3 style="font-size: 1.4rem; color: #FFFFFF; margin-bottom: 0.35rem;"><?= COFOUNDER_NAME ?></h3>
                <div
                    style="font-size: 0.85rem; color: #A78BFA; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">
                    <?= COFOUNDER_ROLE ?>
                </div>
                <p style="font-size: 0.9rem; color: var(--slate); line-height: 1.6; margin-bottom: 1.5rem;">
                    <?= COFOUNDER_BIO ?>
                </p>
                <div style="display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="<?= COFOUNDER_LINKEDIN ?>" target="_blank" rel="noopener noreferrer"
                        class="btn btn-secondary btn-sm">
                        <span>LinkedIn</span>
                    </a>
                    <a href="<?= COMPANY_WHATSAPP_URL ?>" target="_blank" rel="noopener" class="btn btn-outline btn-sm">
                        <span>Direct Chat</span>
                    </a>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- ==========================================================================
     ENGINEERING DELIVERY PROCESS
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
                <h3 style="font-size: 1.15rem; color: #FFFFFF; margin-bottom: 0.5rem;">Handoff & 100% IP</h3>
                <p style="font-size: 0.875rem; color: var(--slate);">Complete repository transfer, operating manuals,
                    and production credentials ownership.</p>
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
                    <p>You do — 100%. Upon project milestone completion and delivery, all source code, database
                        architectures, documentation, and cloud configurations belong exclusively to your business. We
                        enforce zero vendor lock-in.</p>
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
                        unit & integration test coverage, idempotency checks, and pre-deployment vulnerability scans so
                        issues are eliminated before production.</p>
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
                    <p>Focused MVPs and automation systems typically launch in 2 to 4 weeks. Because our leadership
                        writes and reviews the architecture directly without management bloat, decision velocity is
                        exceptionally fast.</p>
                </div>
            </div>

            <div class="faq-item">
                <button type="button" class="faq-question" id="faq-4" aria-expanded="false">
                    <span>Do you offer post-launch support and SLA guarantees?</span>
                    <svg class="faq-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="faq-answer" id="faq-4-answer">
                    <p>Yes. Every launch includes a 30-day warranty period for bug fixes and stability monitoring. We
                        also provide ongoing sprint retainers with guaranteed SLA uptime for scaling businesses.</p>
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
                    Tell us what your current digital system or workflow cannot do. We will review your requirements and
                    provide an architectural blueprint within 24 business hours.
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
                        <div>Guaranteed 100% intellectual property ownership</div>
                    </div>
                </div>

                <div style="margin-top: 2.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="<?= COMPANY_WHATSAPP_URL ?>" target="_blank" rel="noopener" class="btn btn-primary">
                        <span>Direct WhatsApp: <?= COMPANY_WHATSAPP_NUMBER ?></span>
                    </a>
                    <a href="mailto:<?= COMPANY_EMAIL ?>" class="btn btn-secondary">
                        <span>Email: <?= COMPANY_EMAIL ?></span>
                    </a>
                </div>
            </div>

            <!-- Inbound Form Card -->
            <div class="card form-card"
                style="background: rgba(17, 29, 58, 0.9); border: 1px solid rgba(59, 130, 246, 0.35);">
                <form id="projectInquiryForm" action="<?= url('api/contact.php') ?>" method="POST">
                    <input type="hidden" name="csrf_token"
                        value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                    <h3 style="font-size: 1.3rem; margin-bottom: 1.25rem; color: #FFFFFF;">Project Discovery Inquiry
                    </h3>

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
                        <label for="service_interest"
                            style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--slate);">Primary
                            Area of Interest</label>
                        <select id="service_interest" name="service" class="form-control"
                            style="width: 100%; background: #060B18; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 10px 14px; color: #FFFFFF;">
                            <option value="booking_system">Turnkey Booking System (Dental / Salon / Spa / Restaurant)</option>
                            <option value="custom_software">Custom Web Platform / Internal Portal</option>
                            <option value="enterprise_ai">Enterprise AI & RAG Pipeline</option>
                            <option value="ai_agents">Autonomous AI Agents</option>
                            <option value="workflow_automation">Workflow Automation (WhatsApp/CRM/APIs)</option>
                            <option value="saas_mvp">SaaS MVP Engineering</option>
                            <option value="mobile_app">Mobile Application (iOS / Android)</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="contact_details"
                            style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 0.4rem; color: var(--slate);">Project
                            Context & Current Friction *</label>
                        <textarea id="contact_details" name="message" rows="4" required class="form-control"
                            placeholder="Describe the business bottleneck, key user workflows, or integrations required..."
                            style="width: 100%; background: #060B18; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; padding: 10px 14px; color: #FFFFFF; font-family: inherit; resize: vertical;"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg" style="width: 100%;">
                        <span>Request Architecture Blueprint & Estimate &rarr;</span>
                    </button>
                    <div style="font-size: 0.75rem; color: var(--slate-dark); text-align: center; margin-top: 0.75rem;">
                        🔒 Confidential • Zero spam • Response within 24 business hours
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Interactive Live Demo Modal Overlay (For Trigger Buttons) -->
<div class="demo-modal-overlay" id="projectDemoModal" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="demo-modal-container">
        <div class="demo-modal-header">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="font-size: 1.4rem;">⚡</span>
                <div>
                    <h3 style="font-size: 1.15rem; margin: 0; color: #FFFFFF;">Interactive Systems Sandbox</h3>
                    <div style="font-size: 0.75rem; color: var(--slate-dark);">Test real CodeX404 modules live</div>
                </div>
            </div>
            <button type="button" class="demo-close-btn" aria-label="Close demo simulator">&times;</button>
        </div>

        <div class="demo-modal-body">
            <div class="demo-nav-tabs">
                <button type="button" class="demo-nav-tab active" data-demo-target="rag">🤖 AI RAG Assistant</button>
                <button type="button" class="demo-nav-tab" data-demo-target="erp">🏫 School Portal & ERP</button>
            </div>

            <!-- Pane 1: RAG -->
            <div class="demo-simulator-pane active" id="demo-pane-rag">
                <p style="font-size: 0.85rem; color: var(--slate); margin-bottom: 1rem;">
                    This sandbox runs our grounded multi-source vector pipeline. Try asking about data encryption,
                    client IP ownership, or API latency.
                </p>
                <div
                    style="background: #060B18; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 1rem; color: var(--slate); font-size: 0.85rem;">
                    <div style="color: #34D399; font-weight: 700; margin-bottom: 0.5rem;">✔ Vector Store Connected:
                        Qdrant Index</div>
                    <div>Grounded with 14,000 corporate spec tokens. Strict zero-hallucination threshold applied.</div>
                </div>
            </div>

            <!-- Pane 2: ERP -->
            <div class="demo-simulator-pane" id="demo-pane-erp">
                <p style="font-size: 0.85rem; color: var(--slate); margin-bottom: 1rem;">
                    Institutional grade school management portal. Process student admissions, fee voucher generation,
                    and faculty circulars.
                </p>
                <div
                    style="background: #060B18; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 1rem; color: var(--slate); font-size: 0.85rem;">
                    <div style="color: #38BDF8; font-weight: 700; margin-bottom: 0.5rem;">🏫 Live Production Reference:
                        Ali Public School & Insan Degree College</div>
                    <div>Processes thousands of daily active queries with sub-200ms TTFB response.</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>