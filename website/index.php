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
    <div class="container hero-container-flex">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="hero-pill" role="status" aria-label="Where Bugs Meet Their Match">
                    <span class="hero-pill-radar" aria-hidden="true">
                        <span class="hero-pill-ping"></span>
                        <span class="hero-pill-core"></span>
                    </span>
                    <span class="hero-pill-text">Where Bugs Meet Their Match</span>
                    <span class="hero-pill-target" aria-hidden="true" title="Precision Engineering">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="22" y1="12" x2="18" y2="12"></line>
                            <line x1="6" y1="12" x2="2" y2="12"></line>
                            <line x1="12" y1="6" x2="12" y2="2"></line>
                            <line x1="12" y1="22" x2="12" y2="18"></line>
                        </svg>
                    </span>
                </div>

                <h1 class="hero-headline">
                    We Build, Grow & Automate Systems That <span class="text-gradient gradient-text-animated">Scale Your Business</span>
                </h1>

                <!-- Brand Divisions Emblem (BUILD · GROW · AUTOMATE) -->
                <div class="bga-hero-pill-wrap">
                    <div class="bga-hero-pill" role="region" aria-label="Core Agency Divisions">
                        <div class="bga-hero-pill-inner">
                            <a href="#division-build" class="bga-pill-segment bga-build" title="Explore BUILD Division">
                                <svg class="bga-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.7" stroke-linecap="round" stroke-linejoin="round"
                                    aria-hidden="true">
                                    <polyline points="16 18 22 12 16 6"></polyline>
                                    <polyline points="8 6 2 12 8 18"></polyline>
                                    <line x1="14" y1="4" x2="10" y2="20"></line>
                                </svg>
                                <span class="bga-label">BUILD</span>
                            </a>
                            <span class="bga-divider" aria-hidden="true"></span>
                            <a href="#division-grow" class="bga-pill-segment bga-grow" title="Explore GROW Division">
                                <svg class="bga-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <rect x="3" y="14" width="4" height="8" rx="1"></rect>
                                    <rect x="10" y="8" width="4" height="14" rx="1"></rect>
                                    <rect x="17" y="3" width="4" height="19" rx="1"></rect>
                                </svg>
                                <span class="bga-label">GROW</span>
                            </a>
                            <span class="bga-divider" aria-hidden="true"></span>
                            <a href="#division-automate" class="bga-pill-segment bga-automate"
                                title="Explore AUTOMATE Division">
                                <svg class="bga-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path
                                        d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z" />
                                </svg>
                                <span class="bga-label">AUTOMATE</span>
                            </a>
                        </div>
                    </div>
                </div>

                <p class="hero-description">
                    From custom web applications and CRM/ERP systems to high-ROI digital marketing and AI workflow
                    automations — CodeX404 engineers solutions that drive measurable revenue and eliminate operational
                    friction.
                </p>

                <div class="hero-cta-group">
                    <a href="#what-we-offer" class="btn btn-primary btn-lg">
                        <span>Explore Services & Solutions</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <polyline points="19 12 12 19 5 12"></polyline>
                        </svg>
                    </a>
                    <a href="#contact-section" class="btn btn-secondary btn-lg">
                        <span>Book a Discovery Call 🚀</span>
                    </a>
                </div>
            </div>

            <!-- Interactive Multi-Tab Hero Terminal (Business & Tech Showcase) -->
            <div class="hero-visual">
                <div class="tech-frame">
                    <div class="tech-frame-header">
                        <div class="window-dots">
                            <span class="dot-red"></span>
                            <span class="dot-yellow"></span>
                            <span class="dot-green"></span>
                        </div>

                        <!-- Interactive Terminal Tabs matching BUILD · GROW · AUTOMATE -->
                        <div class="terminal-tabs" role="tablist" aria-label="Solutions Showcase">
                            <button class="terminal-tab-btn active" role="tab" aria-selected="true" data-tab="build">
                                🛠️ BUILD
                            </button>
                            <button class="terminal-tab-btn" role="tab" aria-selected="false" data-tab="grow">
                                📈 GROW
                            </button>
                            <button class="terminal-tab-btn" role="tab" aria-selected="false" data-tab="automate">
                                ⚡ AUTOMATE
                            </button>
                        </div>

                        <div class="terminal-live-badge" title="Live Solutions Showcase">
                            <span class="live-dot-wrap">
                                <span class="live-dot-ping"></span>
                                <span class="live-dot-core"></span>
                            </span>
                            <span>LIVE PREVIEW</span>
                        </div>
                    </div>

                    <div class="tech-frame-body">
                        <!-- Pane 1: BUILD -->
                        <div class="terminal-pane active" id="pane-build">
                            <div class="showcase-content">
                                <div class="showcase-header">
                                    <span class="showcase-pill showcase-pill-build">
                                        <span class="showcase-dot"></span>
                                        DIVISION 01 &bull; BUILD
                                    </span>
                                    <h3 class="showcase-title">Custom Software &amp; Business Portals</h3>
                                    <p class="showcase-desc">Bespoke platforms engineered around your exact operations &bull; No recurring SaaS rent.</p>
                                </div>

                                <div class="showcase-features">
                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-build">💻</span>
                                        <div class="showcase-feature-body">
                                            <strong>Custom Portals:</strong> Client dashboards, booking &amp; CRM built for your team.
                                        </div>
                                    </div>

                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-build">🔒</span>
                                        <div class="showcase-feature-body">
                                            <strong>Enterprise Reliability:</strong> Sub-second speeds, bank-grade encryption &amp; zero crashes.
                                        </div>
                                    </div>

                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-build">📦</span>
                                        <div class="showcase-feature-body">
                                            <strong>100% IP Ownership:</strong> Full source code handed over &bull; Zero vendor lock-in.
                                        </div>
                                    </div>
                                </div>

                                <div class="showcase-footer footer-build">
                                    <div class="showcase-outcome">
                                        <span class="showcase-check">✓</span>
                                        <span>Zero SaaS Rent &bull; 100% Code Ownership</span>
                                    </div>
                                    <a href="#division-build" class="showcase-link link-build">
                                        Explore BUILD <span>&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Pane 2: GROW -->
                        <div class="terminal-pane" id="pane-grow">
                            <div class="showcase-content">
                                <div class="showcase-header">
                                    <span class="showcase-pill showcase-pill-grow">
                                        <span class="showcase-dot"></span>
                                        DIVISION 02 &bull; GROW
                                    </span>
                                    <h3 class="showcase-title">Search Visibility &amp; Customer Acquisition</h3>
                                    <p class="showcase-desc">Attract ready-to-buy clients and turn online traffic into confirmed bookings.</p>
                                </div>

                                <div class="showcase-features">
                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-grow">🎯</span>
                                        <div class="showcase-feature-body">
                                            <strong>Google &amp; AI Search:</strong> Rank top where ready-to-buy clients actively search.
                                        </div>
                                    </div>

                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-grow">📈</span>
                                        <div class="showcase-feature-body">
                                            <strong>High-Converting Funnels:</strong> Fast pages engineered to turn clicks into booked calls.
                                        </div>
                                    </div>

                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-grow">💰</span>
                                        <div class="showcase-feature-body">
                                            <strong>High-ROI Ad Campaigns:</strong> Laser-targeted Google &amp; Meta ads with 0 wasted spend.
                                        </div>
                                    </div>
                                </div>

                                <div class="showcase-footer footer-grow">
                                    <div class="showcase-outcome">
                                        <span class="showcase-check">✓</span>
                                        <span>+240% Inbound Leads &bull; 3.8x Target ROAS</span>
                                    </div>
                                    <a href="#division-grow" class="showcase-link link-grow">
                                        Explore GROW <span>&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Pane 3: AUTOMATE -->
                        <div class="terminal-pane" id="pane-automate">
                            <div class="showcase-content">
                                <div class="showcase-header">
                                    <span class="showcase-pill showcase-pill-automate">
                                        <span class="showcase-dot"></span>
                                        DIVISION 03 &bull; AUTOMATE
                                    </span>
                                    <h3 class="showcase-title">24/7 Smart AI Agents &amp; Workflows</h3>
                                    <p class="showcase-desc">Put repetitive chores on autopilot and deploy 24/7 instant client assistants.</p>
                                </div>

                                <div class="showcase-features">
                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-automate">🤖</span>
                                        <div class="showcase-feature-body">
                                            <strong>24/7 AI Assistants:</strong> Instant replies, lead qualification &amp; automatic scheduling.
                                        </div>
                                    </div>

                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-automate">⚡</span>
                                        <div class="showcase-feature-body">
                                            <strong>Zero-Manual Data Sync:</strong> Invoices, WhatsApp &amp; CRM records update with 0 error.
                                        </div>
                                    </div>

                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-automate">⏱️</span>
                                        <div class="showcase-feature-body">
                                            <strong>Reclaim 20+ Hours:</strong> Stop wasting staff hours on manual spreadsheets &amp; forms.
                                        </div>
                                    </div>
                                </div>

                                <div class="showcase-footer footer-automate">
                                    <div class="showcase-outcome">
                                        <span class="showcase-check">✓</span>
                                        <span>20+ Hours Saved Weekly &bull; 99.9% Accuracy</span>
                                    </div>
                                    <a href="#division-automate" class="showcase-link link-automate">
                                        Explore AUTOMATE <span>&rarr;</span>
                                    </a>
                                </div>
                            </div>
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
     WHAT WE OFFER — BUILD · GROW · AUTOMATE
     ========================================================================== -->
<section class="section" id="divisions" aria-label="Company Divisions">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Core Capabilities</span>
            </div>
            <h2 class="section-title">
                WHAT WE <span class="text-gradient gradient-text-animated">OFFER</span>
            </h2>
            <p class="section-subtitle">
                Three focused engineering and growth divisions delivering custom platforms, search visibility, and
                autonomous AI.
            </p>
        </div>

        <div class="services-stack">
            <!-- Division 1: BUILD -->
            <article class="service-row-card build card-tilt reveal-on-scroll" id="division-build">
                <span class="service-row-watermark" aria-hidden="true">01</span>
                <div class="service-row-left">
                    <div class="service-row-badge badge-build">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #3B82F6;"></span>
                        <span>DIVISION 01 · BUILD — Engineering & Apps</span>
                    </div>
                    <h3 class="service-row-title">
                        <span>💻</span> Build Software That Scales
                    </h3>
                    <p class="service-row-desc">
                        Turn core workflows and product visions into reliable web platforms, SaaS architectures, mobile
                        applications, and high-load backend APIs. Built cleanly with zero template bloat.
                    </p>
                    <div class="service-row-tags">
                        <span class="service-row-tag">Custom Web Applications</span>
                        <span class="service-row-tag">SaaS MVP Engineering</span>
                        <span class="service-row-tag">Cross-Platform Mobile</span>
                        <span class="service-row-tag">Payment Gateways & APIs</span>
                    </div>
                </div>
                <div class="service-row-right">
                    <div class="service-row-metric">
                        <div class="metric-highlight" style="color: #60A5FA;">⚡ 99/100</div>
                        <div class="metric-caption">Core Vitals Performance</div>
                    </div>
                    <a href="<?= url('solutions.php#build') ?>" class="service-row-btn btn-build"
                        aria-label="Explore BUILD Capabilities">
                        <span>Explore BUILD</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2">
                            <line x1="7" y1="17" x2="17" y2="7"></line>
                            <polyline points="7 7 17 7 17 17"></polyline>
                        </svg>
                    </a>
                </div>
            </article>

            <!-- Division 2: GROW -->
            <article class="service-row-card grow card-tilt reveal-on-scroll reveal-delay-1" id="division-grow">
                <span class="service-row-watermark" aria-hidden="true">02</span>
                <div class="service-row-left">
                    <div class="service-row-badge badge-grow">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #8B5CF6;"></span>
                        <span>DIVISION 02 · GROW — Visibility & Reach</span>
                    </div>
                    <h3 class="service-row-title">
                        <span>📈</span> Grow Reach & Discovery
                    </h3>
                    <p class="service-row-desc">
                        Help audiences discover and trust your platform through search engine optimization,
                        answer-engine readiness (AEO/GEO), digital marketing, and conversion design.
                    </p>
                    <div class="service-row-tags">
                        <span class="service-row-tag">Technical SEO & Audits</span>
                        <span class="service-row-tag">Generative AEO & GEO</span>
                        <span class="service-row-tag">High-Intent Paid Campaigns</span>
                        <span class="service-row-tag">Conversion Rate Optimization</span>
                    </div>
                </div>
                <div class="service-row-right">
                    <div class="service-row-metric">
                        <div class="metric-highlight" style="color: #C084FC;">🎯 Top 3</div>
                        <div class="metric-caption">Search & AI Discovery</div>
                    </div>
                    <a href="<?= url('solutions.php#grow') ?>" class="service-row-btn btn-grow"
                        aria-label="Explore GROW Capabilities">
                        <span>Explore GROW</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2">
                            <line x1="7" y1="17" x2="17" y2="7"></line>
                            <polyline points="7 7 17 7 17 17"></polyline>
                        </svg>
                    </a>
                </div>
            </article>

            <!-- Division 3: AUTOMATE -->
            <article class="service-row-card automate card-tilt reveal-on-scroll reveal-delay-2" id="division-automate">
                <span class="service-row-watermark" aria-hidden="true">03</span>
                <div class="service-row-left">
                    <div class="service-row-badge badge-automate">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #10B981;"></span>
                        <span>DIVISION 03 · AUTOMATE — AI & Operations</span>
                    </div>
                    <h3 class="service-row-title">
                        <span>⚡</span> Automate Manual Toil
                    </h3>
                    <p class="service-row-desc">
                        Connect disjointed systems and streamline operations using autonomous multi-tool AI agents,
                        private RAG knowledge bases, and real-time messaging pipelines.
                    </p>
                    <div class="service-row-tags">
                        <span class="service-row-tag">Multi-Tool AI Agents</span>
                        <span class="service-row-tag">Enterprise RAG Knowledge</span>
                        <span class="service-row-tag">WhatsApp & CRM Sync</span>
                        <span class="service-row-tag">Zero-Touch Automation</span>
                    </div>
                </div>
                <div class="service-row-right">
                    <div class="service-row-metric">
                        <div class="metric-highlight" style="color: #34D399;">🌙 24/7/365</div>
                        <div class="metric-caption">Autonomous Availability</div>
                    </div>
                    <a href="<?= url('solutions.php#automate') ?>" class="service-row-btn btn-automate"
                        aria-label="Explore AUTOMATE Capabilities">
                        <span>Explore AUTOMATE</span>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2">
                            <line x1="7" y1="17" x2="17" y2="7"></line>
                            <polyline points="7 7 17 7 17 17"></polyline>
                        </svg>
                    </a>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- ==========================================================================
     OUR WORK PROCESS — 4-STEP DETERMINISTIC DELIVERY
     ========================================================================== -->
<section class="section" id="process" style="background: rgba(10, 22, 40, 0.3);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Deterministic Delivery</span>
            </div>
            <h2 class="section-title">
                OUR WORK <span class="text-gradient gradient-text-animated">PROCESS</span>
            </h2>
            <p class="section-subtitle">
                A predictable, transparent 4-stage pipeline with zero guesswork, fixed milestones, and continuous
                verification.
            </p>
        </div>

        <div class="process-pipeline-ribbon">
            <div class="process-pipeline-grid">
                <!-- Step 01 -->
                <div class="process-step-col card-tilt">
                    <span class="process-step-watermark" aria-hidden="true">01</span>
                    <div class="process-step-top">
                        <div class="process-icon-circle"
                            style="color: #38BDF8; box-shadow: 0 0 15px rgba(56, 189, 248, 0.25);">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                <line x1="11" y1="8" x2="11" y2="14"></line>
                                <line x1="8" y1="11" x2="14" y2="11"></line>
                            </svg>
                        </div>
                        <span class="process-step-badge">STEP 01</span>
                    </div>
                    <h3 class="process-step-title">Probe &amp; Scope</h3>
                    <p class="process-step-desc">
                        Identify bottlenecks, map technical requirements, and define clear, transparent milestones
                        before quoting.
                    </p>
                    <div class="process-step-guarantee">
                        <span>✓</span>
                        <span>Fixed Scope · Zero Surprise Fees</span>
                    </div>
                </div>

                <!-- Step 02 -->
                <div class="process-step-col card-tilt">
                    <span class="process-step-watermark" aria-hidden="true">02</span>
                    <div class="process-step-top">
                        <div class="process-icon-circle"
                            style="color: #60A5FA; box-shadow: 0 0 15px rgba(59, 130, 246, 0.25);">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="16 18 22 12 16 6"></polyline>
                                <polyline points="8 6 2 12 8 18"></polyline>
                                <line x1="14" y1="4" x2="10" y2="20"></line>
                            </svg>
                        </div>
                        <span class="process-step-badge"
                            style="color: #60A5FA; background: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.25);">STEP
                            02</span>
                    </div>
                    <h3 class="process-step-title">Architect &amp; Build</h3>
                    <p class="process-step-desc">
                        Engineered with clean, type-safe code, custom relational databases, and fast, responsive
                        interfaces.
                    </p>
                    <div class="process-step-guarantee"
                        style="color: #60A5FA; background: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.2);">
                        <span>✓</span>
                        <span>Staging Preview Every 2 Weeks</span>
                    </div>
                </div>

                <!-- Step 03 -->
                <div class="process-step-col card-tilt">
                    <span class="process-step-watermark" aria-hidden="true">03</span>
                    <div class="process-step-top">
                        <div class="process-icon-circle"
                            style="color: #C084FC; box-shadow: 0 0 15px rgba(192, 132, 252, 0.25);">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                <polyline points="9 12 11 14 15 10"></polyline>
                            </svg>
                        </div>
                        <span class="process-step-badge"
                            style="color: #C084FC; background: rgba(192, 132, 252, 0.1); border-color: rgba(192, 132, 252, 0.25);">STEP
                            03</span>
                    </div>
                    <h3 class="process-step-title">Test &amp; Secure</h3>
                    <p class="process-step-desc">
                        Automated regression test suites, bank-grade encryption checks, and sub-second speed
                        optimization.
                    </p>
                    <div class="process-step-guarantee"
                        style="color: #C084FC; background: rgba(192, 132, 252, 0.1); border-color: rgba(192, 132, 252, 0.2);">
                        <span>✓</span>
                        <span>100% Quality &amp; Bug-Free Shield</span>
                    </div>
                </div>

                <!-- Step 04 -->
                <div class="process-step-col card-tilt">
                    <span class="process-step-watermark" aria-hidden="true">04</span>
                    <div class="process-step-top">
                        <div class="process-icon-circle"
                            style="color: #34D399; box-shadow: 0 0 15px rgba(52, 211, 153, 0.25);">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                                </path>
                                <path
                                    d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                                </path>
                                <path d="M9 12H4s.55-3.03 2-4.5c1.62-1.63 5-2 5-2"></path>
                                <path d="M12 15v5s3.03-.55 4.5-2c1.63-1.62 2-5 2-5"></path>
                            </svg>
                        </div>
                        <span class="process-step-badge"
                            style="color: #34D399; background: rgba(52, 211, 153, 0.1); border-color: rgba(52, 211, 153, 0.25);">STEP
                            04</span>
                    </div>
                    <h3 class="process-step-title">Launch &amp; Handover</h3>
                    <p class="process-step-desc">
                        Zero-downtime production cloud deployment with 100% intellectual property, code, and
                        documentation ownership.
                    </p>
                    <div class="process-step-guarantee"
                        style="color: #34D399; background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.2);">
                        <span>✓</span>
                        <span>Complete IP &amp; Code Ownership</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     OUR LATEST WORK — NETNOVAZ-STYLE CENTER-MODE CAROUSEL SLIDER
     ========================================================================== -->
<section class="section case-studies-section" id="work">
    <div id="projects" style="position: absolute; top: -80px; left: 0;"></div>

    <div class="container position-relative" style="z-index: 3;">
        <div class="section-header text-center mb-5 pb-2">
            <h2 class="exclusive-case-title">
                OUR LATEST <span class="highlight-accent">WORK</span>
            </h2>
            <p class="section-subtitle mt-3" style="max-width: 680px; margin-left: auto; margin-right: auto; opacity: 0.85;">
                Explore real software platforms, institutional web portals, automation pipelines, and AI systems
                engineered by CodeX404 Solutions. Clean, fast, and easy to evaluate.
            </p>
        </div>
    </div>

    <?php
    $allActiveProjects = \App\Services\ProjectService::getActive();
    
    // Exact 6 websites specified by user:
    // 1. First Alphabet, 2. Insan Degree College, 3. Central Medical,
    // 4. Wheelcraft, 5. Ali Public School, 6. V3A Enterprise.
    // Ordered so that item 1 (First Alphabet) is in the center on first load (index 1),
    // with item 6 (V3A) on the left (index 0) and item 2 (Insan) on the right (index 2).
    $targetSixIds = [
        'v3a-enterprise',
        'first-alphabet',
        'insan-degree-college-web',
        'central-medical',
        'wheelcraft',
        'ali-public-school'
    ];
    $projectMap = [];
    foreach ($allActiveProjects as $p) {
        $projectMap[$p['id']] = $p;
    }
    $homepageProjects = [];
    foreach ($targetSixIds as $tid) {
        if (isset($projectMap[$tid])) {
            $homepageProjects[] = $projectMap[$tid];
        }
    }
    ?>

    <!-- Multi-card center-mode carousel slider -->
    <div class="case-slider-wrapper position-relative w-100" id="caseSliderWrapper" style="z-index: 3;">
        <!-- Floating Navigation Arrows -->
        <button class="case-arrow-btn prev-btn case-arrow-left" id="caseSliderPrev" type="button" aria-label="Previous slide">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <button class="case-arrow-btn next-btn case-arrow-right" id="caseSliderNext" type="button" aria-label="Next slide">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>

        <!-- Floating Mouse "View" Badge Follower -->
        <div class="case-view-badge" id="caseViewBadge">View</div>

        <!-- Slider Track -->
        <div class="case-slider-track" id="caseSliderTrack">
            <?php foreach ($homepageProjects as $idx => $p): ?>
                <?php
                $cat = $p['category'] ?? 'software';
                $artClass = match ($cat) {
                    'booking' => 'cpc-art-booking',
                    'commerce' => 'cpc-art-commerce',
                    'mobile' => 'cpc-art-mobile',
                    'ai' => 'cpc-art-ai',
                    default => 'cpc-art-software'
                };
                $stageIcon = match ($cat) {
                    'booking' => '🏥',
                    'commerce' => '🛒',
                    'mobile' => '📱',
                    'ai' => '🤖',
                    default => '💻'
                };
                $targetUrl = !empty($p['live_url']) ? $p['live_url'] : url('our-work.php#project-' . urlencode($p['id']));
                $isExternal = !empty($p['live_url']);
                $screenshotUrl = \App\Services\ProjectService::getScreenshotUrl($p);
                ?>
                <div class="case-slide-item<?= $idx === 1 ? ' is-active-center' : '' ?>" data-index="<?= $idx ?>">
                    <a href="<?= htmlspecialchars($targetUrl) ?>"
                       <?= $isExternal ? 'target="_blank" rel="noopener noreferrer"' : '' ?>
                       class="case-study-visual-card"
                       title="<?= htmlspecialchars($p['title']) ?>">
                        <div class="case-card-img-wrap">
                            <?php if (!empty($screenshotUrl)): ?>
                                <img src="<?= htmlspecialchars($screenshotUrl) ?>" 
                                     alt="<?= htmlspecialchars($p['title']) ?>" 
                                     class="case-card-img" 
                                     loading="<?= $idx <= 2 ? 'eager' : 'lazy' ?>"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="case-card-fallback-art <?= $artClass ?>" style="display: none;">
                                    <div class="case-fallback-browser-bar">
                                        <div class="case-dots">
                                            <span></span><span></span><span></span>
                                        </div>
                                        <div class="case-mockup-url">
                                            🔒 <?= htmlspecialchars($p['mockup_host'] ?? 'app.codex404solutions.online') ?>
                                        </div>
                                    </div>
                                    <div class="case-fallback-center">
                                        <span class="case-fallback-icon"><?= $stageIcon ?></span>
                                        <span class="case-fallback-text"><?= htmlspecialchars($p['category_label'] ?? 'Software Platform') ?></span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="case-card-fallback-art <?= $artClass ?>">
                                    <div class="case-fallback-browser-bar">
                                        <div class="case-dots">
                                            <span></span><span></span><span></span>
                                        </div>
                                        <div class="case-mockup-url">
                                            🔒 <?= htmlspecialchars($p['mockup_host'] ?? 'app.codex404solutions.online') ?>
                                        </div>
                                    </div>
                                    <div class="case-fallback-center">
                                        <span class="case-fallback-icon"><?= $stageIcon ?></span>
                                        <span class="case-fallback-text"><?= htmlspecialchars($p['category_label'] ?? 'Software Platform') ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Card Bottom Overlay with Title & Glass Action Button -->
                        <div class="case-card-overlay">
                            <h3 class="case-name"><?= htmlspecialchars($p['title']) ?></h3>
                            <span class="case-overlay-btn" aria-hidden="true">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <line x1="7" y1="17" x2="17" y2="7"></line>
                                    <polyline points="7 7 17 7 17 17"></polyline>
                                </svg>
                            </span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Centered Bottom Pill CTA: VIEW ALL PROJECTS ↗ -->
    <div class="projects-bottom-cta text-center mt-5">
        <a href="<?= url('our-work.php') ?>" class="btn btn-view-all-projects">
            <span>VIEW ALL PROJECTS</span>
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="7" y1="17" x2="17" y2="7"></line>
                <polyline points="7 7 17 7 17 17"></polyline>
            </svg>
        </a>
    </div>
</section>

<!-- ==========================================================================
     WHY CHOOSE CODEX404 SOLUTIONS? (NETNOVAZ-STYLE BENTO GRID)
     ========================================================================== -->
<section class="section why-choose-section" id="why-choose">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>The CodeX404 Standard</span>
            </div>
            <h2 class="section-title">
                WHY CHOOSE <span class="text-gradient gradient-text-animated">CodeX404 Solutions?</span>
            </h2>
            <p class="section-subtitle">
                Built on engineering integrity, direct founder accountability, and business-focused software delivery.
            </p>
        </div>

        <div class="why-choose-grid">
            <!-- Card 01 -->
            <div class="why-dark-card card-tilt">
                <span class="why-card-number">01</span>
                <div class="why-card-icon-wrap" style="color: #38BDF8;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <h3 class="why-card-title">Direct Founder Leadership</h3>
                <p class="why-card-desc">
                    You work directly with senior architects and developers—no account managers, no offshore
                    outsourcing, and no handoff communication breakdown.
                </p>
            </div>

            <!-- Card 02 -->
            <div class="why-dark-card card-tilt">
                <span class="why-card-number">02</span>
                <div class="why-card-icon-wrap" style="color: #60A5FA;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="16 18 22 12 16 6"></polyline>
                        <polyline points="8 6 2 12 8 18"></polyline>
                        <line x1="14" y1="4" x2="10" y2="20"></line>
                    </svg>
                </div>
                <h3 class="why-card-title">Clean Type-Safe Code</h3>
                <p class="why-card-desc">
                    Engineered from the ground up using PHP 8.4, Next.js, and relational database schemas. Zero bloated
                    templates, zero fragile page builders.
                </p>
            </div>

            <!-- Card 03 -->
            <div class="why-dark-card card-tilt">
                <span class="why-card-number">03</span>
                <div class="why-card-icon-wrap" style="color: #C084FC;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 14 14"></polyline>
                    </svg>
                </div>
                <h3 class="why-card-title">Fixed Milestones &amp; Speed</h3>
                <p class="why-card-desc">
                    Explicit scope boundaries with working staging previews delivered every two weeks. You always know
                    what is being built, when, and for what cost.
                </p>
            </div>

            <!-- Card 04 -->
            <div class="why-dark-card card-tilt">
                <span class="why-card-number">04</span>
                <div class="why-card-icon-wrap" style="color: #34D399;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <h3 class="why-card-title">100% Code &amp; IP Ownership</h3>
                <p class="why-card-desc">
                    Complete intellectual property handover, structured repository transfer, and deployment
                    documentation. Your platform is completely yours.
                </p>
            </div>
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
                <span>Interactive Technology Demonstrator</span>
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
     CLIENT TESTIMONIALS
     ========================================================================== -->
<section class="section testimonials-section" id="testimonials">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Verified Client Endorsements</span>
            </div>
            <h2 class="section-title">
                CLIENT <span class="text-gradient gradient-text-animated">TESTIMONIALS</span>
            </h2>
            <p class="section-subtitle">
                Hear directly from business owners, institution leaders, and founders who build with CodeX404.
            </p>
        </div>

        <div class="grid grid-cols-3" style="gap: 1.75rem; margin-top: 2.75rem;">
            <!-- Testimonial 1 -->
            <div class="testimonial-card card-tilt">
                <div class="testimonial-stars" aria-label="5 out of 5 stars">★★★★★</div>
                <p class="testimonial-quote">
                    “CodeX404 completely modernized our institutional fee voucher collection and student records. The
                    system handles thousands of concurrent parents and students with zero slowdowns.”
                </p>
                <div class="testimonial-author-box">
                    <div class="testimonial-avatar" style="background: linear-gradient(135deg, #3B82F6, #60A5FA);">RS
                    </div>
                    <div class="testimonial-info">
                        <h4>Dr. R. K. Sharma</h4>
                        <span>Director of Academic Administration</span>
                    </div>
                    <span class="testimonial-metric-chip">⚡ 100% On-Time</span>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="testimonial-card card-tilt">
                <div class="testimonial-stars" aria-label="5 out of 5 stars">★★★★★</div>
                <p class="testimonial-quote">
                    “We eliminated over $400/month in SaaS middleman fees. Our custom reservation engine syncs directly
                    with our staff schedules and WhatsApp without dropping a single customer lead.”
                </p>
                <div class="testimonial-author-box">
                    <div class="testimonial-avatar" style="background: linear-gradient(135deg, #8B5CF6, #C084FC);">MV
                    </div>
                    <div class="testimonial-info">
                        <h4>Marcus Vance</h4>
                        <span>Operations Lead, Luxe Wellness</span>
                    </div>
                    <span class="testimonial-metric-chip"
                        style="color: #C084FC; background: rgba(139, 92, 246, 0.12); border-color: rgba(139, 92, 246, 0.25);">📈
                        +45% Bookings</span>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="testimonial-card card-tilt">
                <div class="testimonial-stars" aria-label="5 out of 5 stars">★★★★★</div>
                <p class="testimonial-quote">
                    “The engineering speed and code quality are unmatched. Having direct communication with the
                    architect rather than junior managers meant we shipped our MVP 3 weeks ahead of schedule.”
                </p>
                <div class="testimonial-author-box">
                    <div class="testimonial-avatar" style="background: linear-gradient(135deg, #10B981, #34D399);">ER
                    </div>
                    <div class="testimonial-info">
                        <h4>Elena Rostova</h4>
                        <span>Founder & Product Head, CloudSphere</span>
                    </div>
                    <span class="testimonial-metric-chip"
                        style="color: #34D399; background: rgba(16, 185, 129, 0.12); border-color: rgba(16, 185, 129, 0.25);">🚀
                        3 Wks Early</span>
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