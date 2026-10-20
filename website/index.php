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
                <a href="#work" class="btn btn-primary btn-lg">
                    Explore Our Work & Live Demos ↓
                </a>
                <a href="#contact-section" class="btn btn-secondary btn-lg">
                    🚀 Start Your Project
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
     OUR WORK — PRODUCTION SYSTEMS & INTERACTIVE DEMOS (CLEAN & PROMINENT)
     ========================================================================== -->
<section class="section" id="work" style="position: relative; padding-top: 4rem;">
    <!-- Also alias anchor id="projects" for backward compatibility -->
    <div id="projects" style="position: absolute; top: -80px; left: 0;"></div>
    
    <div class="container">
        <div class="section-header" style="max-width: 840px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Verified Deliverables & Live Working Demos</span>
            </div>
            <h2 class="section-title" style="font-size: clamp(2rem, 3.5vw, 3rem);">
                Our Work — Systems Built for <span class="gradient-text">Real Business Impact</span>
            </h2>
            <p class="section-subtitle" style="font-size: 1.05rem; line-height: 1.7; color: var(--slate); max-width: 720px; margin: 0 auto;">
                Explore real software platforms, automation pipelines, and AI systems engineered by CodeX404 Solutions. Clean, fast, and easy to understand — test live working simulators directly in your browser.
            </p>
        </div>

        <?php
        $homepageProjects = \App\Services\ProjectService::getActive();
        $countAll = count($homepageProjects);
        $countSoftware = count(array_filter($homepageProjects, fn($p) => ($p['category'] ?? '') === 'software'));
        $countAi = count(array_filter($homepageProjects, fn($p) => ($p['category'] ?? '') === 'ai'));
        $countCommerce = count(array_filter($homepageProjects, fn($p) => ($p['category'] ?? '') === 'commerce'));
        $countMobile = count(array_filter($homepageProjects, fn($p) => ($p['category'] ?? '') === 'mobile'));
        ?>
        <!-- Category Filter Tabs -->
        <div class="project-filter-bar" role="tablist" aria-label="Project Categories" style="display: flex; justify-content: center; gap: 0.75rem; margin-bottom: 3.5rem; flex-wrap: wrap;">
            <button type="button" class="project-filter-btn active" data-filter="all">
                <span>✦</span> All Work (<?= $countAll ?>)
            </button>
            <button type="button" class="project-filter-btn" data-filter="software">
                <span>🏫</span> School ERP & Software (<?= $countSoftware ?>)
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

        <!-- Project Cards Grid -->
        <div class="project-showcase-grid">
            <?php foreach ($homepageProjects as $p): ?>
                <article class="project-card clean-project-card" data-category="<?= htmlspecialchars($p['category']) ?>" id="project-<?= htmlspecialchars($p['id']) ?>">
                    <div>
                        <!-- Header with meta & verified live domain -->
                        <div class="cpc-header">
                            <div class="cpc-meta">
                                <span class="cpc-category"><?= htmlspecialchars($p['category_label'] ?? 'Custom Software') ?></span>
                                <span class="cpc-badge">
                                    <span class="cpc-dot"></span>
                                    <?= htmlspecialchars($p['badge_text'] ?? 'Production Live') ?>
                                </span>
                            </div>
                            <?php if (!empty($p['live_url'])): ?>
                                <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-domain-pill" title="Visit Live Website">
                                    <span><?= htmlspecialchars($p['mockup_host'] ?? '') ?></span>
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
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
                                    <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" title="Visit <?= htmlspecialchars($p['title']) ?>"><?= htmlspecialchars($p['title']) ?></a>
                                <?php else: ?>
                                    <?= htmlspecialchars($p['title']) ?>
                                <?php endif; ?>
                            </h3>
                            <p class="cpc-description"><?= htmlspecialchars($p['solution'] ?? $p['description'] ?? '') ?></p>
                            
                            <?php if (!empty($p['metric'])): ?>
                                <div class="cpc-metric">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span><?= htmlspecialchars($p['metric']) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($p['tags'])): ?>
                                <div class="cpc-tags">
                                    <?php foreach (array_slice($p['tags'], 0, 5) as $tag): ?>
                                        <span class="cpc-tag"><?= htmlspecialchars($tag) ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Clean Actions -->
                    <div class="cpc-actions">
                        <?php if (!empty($p['live_url'])): ?>
                            <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="cpc-btn cpc-btn-primary" title="Visit Live Site">
                                Visit Live Site
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                            </a>
                        <?php endif; ?>
                        <button type="button" class="cpc-btn cpc-btn-secondary btn-demo-trigger" data-demo="<?= htmlspecialchars($p['demo_key'] ?? 'erp') ?>">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            Interactive Demo
                        </button>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div style="text-align: center; margin-top: 3.5rem;">
            <a href="<?= url('case-studies.php') ?>" class="btn btn-secondary btn-lg">
                View All Deliverables & Architecture Notes →
            </a>
        </div>
    </div>
</section>

<!-- ==========================================================================
     WHAT WE BUILD — CORE CAPABILITIES (CLEAN & CONCISE)
     ========================================================================== -->
<section class="section" id="solutions" style="background: rgba(11, 31, 58, 0.25); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Our Capabilities</span>
            </div>
            <h2 class="section-title">Full-Spectrum Engineering Capabilities</h2>
            <p class="section-subtitle">
                We engineer proprietary software, applied AI, and automated workflows designed specifically around how your business operates.
            </p>
        </div>

        <div class="grid grid-cols-3" style="gap: 2rem;">
            <!-- 1. Custom Software -->
            <div class="card">
                <div class="card-icon">💻</div>
                <h3 class="card-title">Custom Software & Web Apps</h3>
                <p class="card-description">
                    Tailored operational control rooms, administrative ERPs, bespoke CRMs, and client portals built to eliminate spreadsheets and per-seat license fees permanently.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Modern PHP 8.2+</span>
                    <span class="tag-chip">Python FastAPI</span>
                    <span class="tag-chip">Strict RBAC</span>
                    <span class="tag-chip">Relational Schemas</span>
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
                    Retrieval-Augmented Generation (RAG) engines, private document intelligence, and domain-trained assistants that search company documents with zero hallucinations.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Private RAG</span>
                    <span class="tag-chip">Qdrant Vector DB</span>
                    <span class="tag-chip">Exact Citations</span>
                    <span class="tag-chip">100% Private VPC</span>
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
                    <span class="tag-chip">Approval Gates</span>
                    <span class="tag-chip">Episodic Memory</span>
                    <span class="tag-chip">Audit Trails</span>
                </div>
                <a href="<?= url('ai-agents.php') ?>" class="card-arrow-link">
                    Explore AI Agents →
                </a>
            </div>

            <!-- 4. Automation -->
            <div class="card">
                <div class="card-icon">⚡</div>
                <h3 class="card-title">Workflow & WhatsApp Automation</h3>
                <p class="card-description">
                    Eliminate repetitive manual coordination. Seamless Meta WhatsApp Business API integrations, instant CRM sync, automated invoicing, and asynchronous webhooks.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">WhatsApp Cloud API</span>
                    <span class="tag-chip">Idempotent Webhooks</span>
                    <span class="tag-chip">Automated Invoicing</span>
                    <span class="tag-chip">&lt; 3 Min SLA</span>
                </div>
                <a href="<?= url('automation.php') ?>" class="card-arrow-link">
                    Explore Automation →
                </a>
            </div>

            <!-- 5. Mobile Applications -->
            <div class="card">
                <div class="card-icon">📱</div>
                <h3 class="card-title">Mobile Apps & Offline PWAs</h3>
                <p class="card-description">
                    Performant cross-platform iOS and Android mobile apps and Progressive Web Apps featuring offline synchronization, biometric auth, and native hardware sensor hooks.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">iOS & Android</span>
                    <span class="tag-chip">Offline SQLite Sync</span>
                    <span class="tag-chip">Push Alerts</span>
                    <span class="tag-chip">Single Codebase</span>
                </div>
                <a href="<?= url('mobile-apps.php') ?>" class="card-arrow-link">
                    Explore Mobile Apps →
                </a>
            </div>

            <!-- 6. SaaS Development -->
            <div class="card">
                <div class="card-icon">🚀</div>
                <h3 class="card-title">SaaS Product & Rapid MVPs</h3>
                <p class="card-description">
                    Turn your product vision into a scalable cloud software with multi-tenant data isolation, turnkey Stripe/Razorpay subscription billing, and founder admin telemetry in 4-8 weeks.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">4-8 Week Delivery</span>
                    <span class="tag-chip">Multi-Tenancy RLS</span>
                    <span class="tag-chip">Subscription Billing</span>
                    <span class="tag-chip">100% IP Handover</span>
                </div>
                <a href="<?= url('saas.php') ?>" class="card-arrow-link">
                    Explore SaaS Development →
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     WHY CLIENTS PARTNER WITH CODEX404 (CLEAN TRUST STANDARDS)
     ========================================================================== -->
<section class="section">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>The CodeX404 Standard</span>
            </div>
            <h2 class="section-title">Built for Founders Who Value Reliability</h2>
            <p class="section-subtitle">
                We remove the agency bloat and deliver rock-solid software systems with full transparency and senior accountability.
            </p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card" style="padding: 2rem;">
                <div style="font-size: 1.75rem; color: var(--cyan); font-weight: 800; margin-bottom: 0.5rem;">100%</div>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.5rem;">Full IP Ownership</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    All source code, database architecture, and credentials belong entirely to your company. Zero vendor lock-in.
                </p>
            </div>

            <div class="card" style="padding: 2rem;">
                <div style="font-size: 1.75rem; color: var(--cyan); font-weight: 800; margin-bottom: 0.5rem;">Direct</div>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.5rem;">Senior Engineers</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    No middleman account managers playing telephone. You speak directly with architects who write your code.
                </p>
            </div>

            <div class="card" style="padding: 2rem;">
                <div style="font-size: 1.75rem; color: var(--cyan); font-weight: 800; margin-bottom: 0.5rem;">Zero</div>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.5rem;">Bugs Philosophy</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    Defensive type-safety, parameterized queries, and rigorous QA ensure code is production-ready from day one.
                </p>
            </div>

            <div class="card" style="padding: 2rem;">
                <div style="font-size: 1.75rem; color: var(--cyan); font-weight: 800; margin-bottom: 0.5rem;">Clear</div>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.5rem;">Milestone Pricing</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    Predictable sprint milestones, regular staging demos, and guaranteed scopes with zero surprise invoice fees.
                </p>
            </div>
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
