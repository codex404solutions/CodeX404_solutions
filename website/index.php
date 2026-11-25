<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';

$bodyClass = 'has-hero-3d';
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
    <canvas id="hero3dCanvas" aria-hidden="true"></canvas>
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
                        <span>Book a Discovery Call</span>
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
                                <svg class="icon-svg-inline" viewBox="0 0 24 24" aria-hidden="true"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>
                                <span>BUILD</span>
                            </button>
                            <button class="terminal-tab-btn" role="tab" aria-selected="false" data-tab="grow">
                                <svg class="icon-svg-inline" viewBox="0 0 24 24" aria-hidden="true"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                                <span>GROW</span>
                            </button>
                            <button class="terminal-tab-btn" role="tab" aria-selected="false" data-tab="automate">
                                <svg class="icon-svg-inline" viewBox="0 0 24 24" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                <span>AUTOMATE</span>
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
                                        <span class="showcase-feature-icon icon-build" aria-hidden="true"><svg class="icon-svg-inline" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg></span>
                                        <div class="showcase-feature-body">
                                            <strong>Custom Portals:</strong> Client dashboards, booking &amp; CRM built for your team.
                                        </div>
                                    </div>

                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-build" aria-hidden="true"><svg class="icon-svg-inline" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg></span>
                                        <div class="showcase-feature-body">
                                            <strong>Enterprise Reliability:</strong> Sub-second speeds, bank-grade encryption &amp; zero crashes.
                                        </div>
                                    </div>

                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-build" aria-hidden="true"><svg class="icon-svg-inline" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg></span>
                                        <div class="showcase-feature-body">
                                            <strong>100% IP Ownership:</strong> Full source code handed over &bull; Zero vendor lock-in.
                                        </div>
                                    </div>
                                </div>

                                <div class="showcase-footer footer-build">
                                    <div class="showcase-outcome">
                                        <span class="showcase-check">&#10003;</span>
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
                                        <span class="showcase-feature-icon icon-grow" aria-hidden="true"><svg class="icon-svg-inline" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg></span>
                                        <div class="showcase-feature-body">
                                            <strong>Google &amp; AI Search:</strong> Rank top where ready-to-buy clients actively search.
                                        </div>
                                    </div>

                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-grow" aria-hidden="true"><svg class="icon-svg-inline" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg></span>
                                        <div class="showcase-feature-body">
                                            <strong>High-Converting Funnels:</strong> Fast pages engineered to turn clicks into booked calls.
                                        </div>
                                    </div>

                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-grow" aria-hidden="true"><svg class="icon-svg-inline" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></span>
                                        <div class="showcase-feature-body">
                                            <strong>High-ROI Ad Campaigns:</strong> Laser-targeted Google &amp; Meta ads with 0 wasted spend.
                                        </div>
                                    </div>
                                </div>

                                <div class="showcase-footer footer-grow">
                                    <div class="showcase-outcome">
                                        <span class="showcase-check">&#10003;</span>
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
                                        <span class="showcase-feature-icon icon-automate" aria-hidden="true"><svg class="icon-svg-inline" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="10" rx="2"></rect><circle cx="12" cy="5" r="2"></circle><path d="M12 7v4"></path></svg></span>
                                        <div class="showcase-feature-body">
                                            <strong>24/7 AI Assistants:</strong> Instant replies, lead qualification &amp; automatic scheduling.
                                        </div>
                                    </div>

                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-automate" aria-hidden="true"><svg class="icon-svg-inline" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg></span>
                                        <div class="showcase-feature-body">
                                            <strong>Zero-Manual Data Sync:</strong> Invoices, WhatsApp &amp; CRM records update with 0 error.
                                        </div>
                                    </div>

                                    <div class="showcase-feature-item">
                                        <span class="showcase-feature-icon icon-automate" aria-hidden="true"><svg class="icon-svg-inline" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></span>
                                        <div class="showcase-feature-body">
                                            <strong>Reclaim 20+ Hours:</strong> Stop wasting staff hours on manual spreadsheets &amp; forms.
                                        </div>
                                    </div>
                                </div>

                                <div class="showcase-footer footer-automate">
                                    <div class="showcase-outcome">
                                        <span class="showcase-check">&#10003;</span>
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
            <div class="tech-pill-item"><span class="tech-pill-icon">PY</span> Python 3.12 Architecture</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">PHP</span> PHP 8.4 &amp; MySQL</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">UI</span> React &amp; Next.js</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">AI</span> Azure OpenAI &amp; LLMs</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">TS</span> TypeScript &amp; Node.js</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">DK</span> Docker Containers</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">API</span> FastAPI Microservices</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">CV</span> YOLOv8 Computer Vision</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">GQL</span> REST &amp; GraphQL APIs</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">404</span> CodeX404 Solutions</div>
            <!-- Seamless Duplicate Loop -->
            <div class="tech-pill-item"><span class="tech-pill-icon">PY</span> Python 3.12 Architecture</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">PHP</span> PHP 8.4 &amp; MySQL</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">UI</span> React &amp; Next.js</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">AI</span> Azure OpenAI &amp; LLMs</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">TS</span> TypeScript &amp; Node.js</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">DK</span> Docker Containers</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">API</span> FastAPI Microservices</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">CV</span> YOLOv8 Computer Vision</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">GQL</span> REST &amp; GraphQL APIs</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">404</span> CodeX404 Solutions</div>
        </div>

        <!-- Row 2: Reverse Infinite Scroll -->
        <div class="tech-marquee-track reverse">
            <div class="tech-pill-item"><span class="tech-pill-icon">AWS</span> AWS Cloud Architecture</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">MEM</span> Redis Distributed Cache</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">MAS</span> Autonomous Multi-Agent AI</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">RAG</span> LangChain &amp; Qdrant RAG</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">PWA</span> Progressive Web Apps</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">PAY</span> Stripe &amp; Payment Gateways</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">CI</span> CI/CD GitHub Actions</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">SEC</span> OWASP Security Hardening</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">SLA</span> Enterprise Engineering Pedigree</div>
            <!-- Seamless Duplicate Loop -->
            <div class="tech-pill-item"><span class="tech-pill-icon">AWS</span> AWS Cloud Architecture</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">MEM</span> Redis Distributed Cache</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">MAS</span> Autonomous Multi-Agent AI</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">RAG</span> LangChain &amp; Qdrant RAG</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">PWA</span> Progressive Web Apps</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">PAY</span> Stripe &amp; Payment Gateways</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">CI</span> CI/CD GitHub Actions</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">SEC</span> OWASP Security Hardening</div>
            <div class="tech-pill-item"><span class="tech-pill-icon">SLA</span> Enterprise Engineering Pedigree</div>
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
                        <span>DIVISION 01 · BUILD — Engineering &amp; Apps</span>
                    </div>
                    <h3 class="service-row-title">
                        <svg class="icon-svg-inline" style="width:20px;height:20px;color:#60A5FA;" viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        <span>Build Software That Scales</span>
                    </h3>
                    <p class="service-row-desc">
                        Turn core workflows and product visions into reliable web platforms, SaaS architectures, mobile
                        applications, and high-load backend APIs. Built cleanly with zero template bloat.
                    </p>
                    <div class="service-row-tags">
                        <span class="service-row-tag">Custom Web Applications</span>
                        <span class="service-row-tag">SaaS MVP Engineering</span>
                        <span class="service-row-tag">Cross-Platform Mobile</span>
                        <span class="service-row-tag">Payment Gateways &amp; APIs</span>
                    </div>
                </div>
                <div class="service-row-right">
                    <div class="service-row-metric">
                        <div class="metric-highlight" style="color: #60A5FA;">99/100</div>
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
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #38BDF8;"></span>
                        <span>DIVISION 02 · GROW — Visibility &amp; Reach</span>
                    </div>
                    <h3 class="service-row-title">
                        <svg class="icon-svg-inline" style="width:20px;height:20px;color:#38BDF8;" viewBox="0 0 24 24" aria-hidden="true"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        <span>Grow Reach &amp; Discovery</span>
                    </h3>
                    <p class="service-row-desc">
                        Help audiences discover and trust your platform through search engine optimization,
                        answer-engine readiness (AEO/GEO), digital marketing, and conversion design.
                    </p>
                    <div class="service-row-tags">
                        <span class="service-row-tag">Technical SEO &amp; Audits</span>
                        <span class="service-row-tag">Generative AEO &amp; GEO</span>
                        <span class="service-row-tag">High-Intent Paid Campaigns</span>
                        <span class="service-row-tag">Conversion Rate Optimization</span>
                    </div>
                </div>
                <div class="service-row-right">
                    <div class="service-row-metric">
                        <div class="metric-highlight" style="color: #38BDF8;">Top 3</div>
                        <div class="metric-caption">Search &amp; AI Discovery</div>
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
                        <span>DIVISION 03 · AUTOMATE — AI &amp; Operations</span>
                    </div>
                    <h3 class="service-row-title">
                        <svg class="icon-svg-inline" style="width:20px;height:20px;color:#34D399;" viewBox="0 0 24 24" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>Automate Manual Toil</span>
                    </h3>
                    <p class="service-row-desc">
                        Connect disjointed systems and streamline operations using autonomous multi-tool AI agents,
                        private RAG knowledge bases, and real-time messaging pipelines.
                    </p>
                    <div class="service-row-tags">
                        <span class="service-row-tag">Multi-Tool AI Agents</span>
                        <span class="service-row-tag">Enterprise RAG Knowledge</span>
                        <span class="service-row-tag">WhatsApp &amp; CRM Sync</span>
                        <span class="service-row-tag">Zero-Touch Automation</span>
                    </div>
                </div>
                <div class="service-row-right">
                    <div class="service-row-metric">
                        <div class="metric-highlight" style="color: #34D399;">24/7/365</div>
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

        <div class="process-card-container">
            <!-- Process Steps Grid (4 Columns with Dividers) -->
            <div class="process-steps-row">
                <!-- Step 01 -->
                <div class="process-col">
                    <div class="process-step-item">
                        <span class="step-badge">STEP 01</span>
                        <p class="step-desc">
                            STRATEGIC RESEARCH, AUDIENCE ANALYSIS, AND KEYWORD PLANNING FOR SCALABLE DIGITAL GROWTH.
                        </p>
                        <div class="process-pill-box">
                            <div class="pill-icon-glow">
                                <div class="icon-circle">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        <path d="M11 8v6"></path>
                                        <path d="M8 11h6"></path>
                                    </svg>
                                </div>
                            </div>
                            <h4 class="pill-title">PROBE &amp; PLAN</h4>
                        </div>
                    </div>
                </div>

                <!-- Step 02 -->
                <div class="process-col">
                    <div class="process-step-item">
                        <span class="step-badge">STEP 02</span>
                        <p class="step-desc">
                            HIGH-PERFORMANCE WEBSITES BUILT WITH OPTIMIZED DESIGN, SPEED, SEO, AND USABILITY.
                        </p>
                        <div class="process-pill-box">
                            <div class="pill-icon-glow">
                                <div class="icon-circle">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M9 18h6"></path>
                                        <path d="M10 22h4"></path>
                                        <path
                                            d="M12 2a7 7 0 0 0-7 7c0 2.4 1.2 4.5 3 5.7V17h8v-2.3c1.8-1.2 3-3.3 3-5.7a7 7 0 0 0-7-7z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <h4 class="pill-title">BUILD &amp; OPTIMIZE</h4>
                        </div>
                    </div>
                </div>

                <!-- Step 03 -->
                <div class="process-col">
                    <div class="process-step-item">
                        <span class="step-badge">STEP 03</span>
                        <p class="step-desc">
                            LAUNCH, SEO, AND DIGITAL MARKETING STRATEGIES TO MAXIMIZE ONLINE VISIBILITY.
                        </p>
                        <div class="process-pill-box">
                            <div class="pill-icon-glow">
                                <div class="icon-circle">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <path
                                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <h4 class="pill-title">PUBLISH &amp; PROMOTE</h4>
                        </div>
                    </div>
                </div>

                <!-- Step 04 -->
                <div class="process-col">
                    <div class="process-step-item">
                        <span class="step-badge">STEP 04</span>
                        <p class="step-desc">
                            MONITOR PERFORMANCE, ANALYZE DATA, AND CONTINUOUSLY IMPROVE DIGITAL RESULTS.
                        </p>
                        <div class="process-pill-box">
                            <div class="pill-icon-glow">
                                <div class="icon-circle">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <h4 class="pill-title">TRACK &amp; REFINE</h4>
                        </div>
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
            <div class="section-tag">
                <span class="dot"></span>
                <span>Featured Portfolio</span>
            </div>
            <h2 class="section-title exclusive-case-title">
                OUR <span class="text-gradient gradient-text-animated">LATEST WORK</span>
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
                    'booking' => 'HC',
                    'commerce' => 'B2B',
                    'mobile' => 'APP',
                    'ai' => 'AI',
                    default => 'SYS'
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
                                            <?= htmlspecialchars($p['mockup_host'] ?? 'app.codex404solutions.online') ?>
                                        </div>
                                    </div>
                                    <div class="case-fallback-center">
                                        <span class="case-fallback-icon font-mono" style="font-size:1.5rem;font-weight:700;color:#38BDF8;"><?= $stageIcon ?></span>
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
                                            <?= htmlspecialchars($p['mockup_host'] ?? 'app.codex404solutions.online') ?>
                                        </div>
                                    </div>
                                    <div class="case-fallback-center">
                                        <span class="case-fallback-icon font-mono" style="font-size:1.5rem;font-weight:700;color:#38BDF8;"><?= $stageIcon ?></span>
                                        <span class="case-fallback-text"><?= htmlspecialchars($p['category_label'] ?? 'Software Platform') ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Card Bottom Overlay with Title & Action Button -->
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

    <div class="case-slider-meta-bar">
        <span class="case-slide-counter" id="caseSlideCounter">02 / 06</span>
    </div>

    <!-- Centered Bottom CTA: VIEW ALL PROJECTS -->
    <div class="projects-bottom-cta text-center mt-4">
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
                High-performance custom software, direct founder leadership, and zero vendor lock-in.
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
                <h3 class="why-card-title">Proven Multi-Industry Experience</h3>
                <p class="why-card-desc">
                    Battle-tested platforms delivered across higher education, clinical healthcare, e-commerce, and enterprise operations.
                </p>
            </div>

            <!-- Card 02 -->
            <div class="why-dark-card card-tilt">
                <span class="why-card-number">02</span>
                <div class="why-card-icon-wrap" style="color: #60A5FA;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                </div>
                <h3 class="why-card-title">Scalable &amp; Secure Web Architecture</h3>
                <p class="why-card-desc">
                    Engineered for sub-second page loads, bank-grade data security, and seamless stability under high-traffic surges.
                </p>
            </div>

            <!-- Card 03 -->
            <div class="why-dark-card card-tilt">
                <span class="why-card-number">03</span>
                <div class="why-card-icon-wrap" style="color: #F97316;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                </div>
                <h3 class="why-card-title">Transparent Delivery &amp; Timely Milestones</h3>
                <p class="why-card-desc">
                    Direct collaboration with technical leads, fixed milestone roadmaps, and working staging previews every two weeks.
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
                <h3 class="why-card-title">Data-Driven Growth &amp; Automations</h3>
                <p class="why-card-desc">
                    Search-optimized architectures, conversion-focused user journeys, and automated pipelines designed to scale your business.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     INTERACTIVE ARCHITECTURAL SIMULATORS (SIMULATION ONLY)
     ========================================================================== -->
<section class="section" id="simulators"
    style="border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle); position: relative;">
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
                Explore real architectural prototypes running directly in your browser. Query our grounded AI vector
                retrieval assistant or simulate synchronous WhatsApp CRM webhook ingestion.
            </p>
        </div>

        <div class="grid grid-cols-2" style="gap: 2rem; align-items: stretch;">
            <!-- Simulator 1: Enterprise AI RAG Assistant -->
            <div class="card card-tilt"
                style="display: flex; flex-direction: column;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.25rem; gap: 0.75rem;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.55rem; margin-bottom: 0.25rem;">
                            <svg class="icon-svg-inline" style="width:19px;height:19px;color:#38BDF8;" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="11" width="18" height="10" rx="2"></rect><circle cx="12" cy="5" r="2"></circle><path d="M12 7v4"></path></svg>
                            <h3 style="font-size: 1.25rem; color: #FFFFFF; font-weight: 700; margin: 0;">Enterprise AI RAG Assistant</h3>
                        </div>
                        <p style="font-size: 0.85rem; color: var(--slate); margin: 0;">Multi-source grounded vector search with source citations</p>
                    </div>
                    <span class="live-tag-pill green" style="flex-shrink: 0;">Vector DB Online</span>
                </div>

                <!-- Quick Prompt Chips -->
                <div class="rag-prompt-chips-bar" style="margin-bottom: 1rem;">
                    <span class="chips-label">Try Asking:</span>
                    <button type="button" class="rag-chip onpage-rag-chip" data-prompt="Who owns the source code and IP after completion?">IP Ownership Terms</button>
                    <button type="button" class="rag-chip onpage-rag-chip" data-prompt="How does the WhatsApp lead pipeline automate CRM?">WhatsApp Pipeline</button>
                    <button type="button" class="rag-chip onpage-rag-chip" data-prompt="Explain how patient appointment double-booking is prevented.">Concurrency Locks</button>
                    <button type="button" class="rag-chip onpage-rag-chip" data-prompt="Tell me about the School ERP architecture">Campus ERP</button>
                </div>

                <!-- Chat Stream Viewport -->
                <div class="rag-chat-stream" id="onpageRagChatBox" style="height: 275px; flex: 1;">
                    <div class="rag-message-row ai">
                        <div class="rag-avatar font-mono" style="font-size:0.72rem;font-weight:700;">RAG</div>
                        <div class="rag-msg-bubble">
                            <div class="rag-msg-meta">CodeX404 Grounded RAG Agent &bull; Isolated Context</div>
                            <p>Welcome to the CodeX404 Architecture Demonstrator. Ask any question regarding our software engineering standards, relational schemas, or deployment pipelines.</p>
                        </div>
                    </div>
                </div>

                <!-- Input Bar -->
                <div class="rag-input-bar" style="margin-top: 1rem;">
                    <input type="text" id="onpageRagInput" placeholder="Ask a technical or architectural question..." autocomplete="off">
                    <button type="button" id="onpageRagSendBtn" class="btn btn-primary btn-sm">
                        <span>Query &rarr;</span>
                    </button>
                </div>
            </div>

            <!-- Simulator 2: WhatsApp CRM Automation -->
            <div class="card card-tilt"
                style="display: flex; flex-direction: column;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.25rem; gap: 0.75rem;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.55rem; margin-bottom: 0.25rem;">
                            <svg class="icon-svg-inline" style="width:19px;height:19px;color:#34D399;" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            <h3 style="font-size: 1.25rem; color: #FFFFFF; font-weight: 700; margin: 0;">WhatsApp Cloud &amp; CRM Pipeline</h3>
                        </div>
                        <p style="font-size: 0.85rem; color: var(--slate); margin: 0;">Synchronous webhook ingestion with automated qualification</p>
                    </div>
                    <span class="live-tag-pill green" style="flex-shrink: 0;">HMAC Webhook Active</span>
                </div>

                <!-- Dual-Column Interactive Frame -->
                <div class="onpage-wa-grid" style="flex: 1;">
                    <!-- Left: Smartphone WhatsApp Frame -->
                    <div class="phone-simulator-frame">
                        <div class="phone-notch">
                            <span class="phone-speaker"></span>
                            <span class="phone-camera"></span>
                        </div>

                        <div class="wa-header">
                            <div class="wa-avatar">404</div>
                            <div class="wa-contact-info">
                                <strong>CodeX404 Solutions</strong>
                                <span class="wa-verified">Verified Business Account</span>
                            </div>
                        </div>

                        <div class="wa-chat-canvas" id="onpageWaChatLog" style="height: 195px;">
                            <div class="wa-msg inbound">
                                <p>Hi CodeX404, we are planning a custom B2B wholesale platform for 100+ dealers. Can we discuss technical feasibility?</p>
                                <span class="wa-time">10:42 AM</span>
                            </div>
                            <div class="wa-msg outbound">
                                <p>Hello. Thank you for reaching out to CodeX404. We specialize in B2B commerce and custom enterprise platforms.</p>
                                <p style="margin-top: 4px;">Ticket: <strong>#CX-8842</strong>.</p>
                                <span class="wa-time">10:42 AM</span>
                            </div>
                        </div>

                        <div class="wa-action-bar">
                            <button type="button" id="onpageWaSimulateBtn" class="btn btn-primary btn-sm" style="width: 100%;">
                                <span>Trigger Next Simulated Message</span>
                            </button>
                        </div>
                    </div>

                    <!-- Right: Real-Time Webhook JSON Payload -->
                    <div class="demo-card-box" style="padding: 1rem;">
                        <div class="demo-box-header" style="margin-bottom: 0.5rem; padding-bottom: 0.4rem;">
                            <div style="display: flex; align-items: center; gap: 0.4rem;">
                                <svg class="icon-svg-inline" style="width:14px;height:14px;color:#38BDF8;" viewBox="0 0 24 24" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                <h4 style="font-size: 0.82rem; margin: 0;">Ingestion Telemetry</h4>
                            </div>
                            <span class="live-tag-pill green" style="font-size: 0.65rem;">200 OK</span>
                        </div>

                        <div class="webhook-telemetry-feed" id="onpageCrmLeadList" style="max-height: 245px;">
                            <div class="webhook-payload-item">
                                <div class="wp-top">
                                    <span class="wp-endpoint">POST /api/webhooks/whatsapp/inbound</span>
                                    <span class="wp-status font-mono">18ms</span>
                                </div>
                                <pre class="wp-code font-mono"><code>{
  "event": "messages.received",
  "ticket_id": "CX-8842",
  "sender": "+91 98201-XXXXX",
  "intent": "b2b_wholesale_inquiry",
  "crm_status": "LEAD_INGESTED",
  "routing": "Enterprise Architecture Desk",
  "timestamp": "2026-11-20T10:42:00Z"
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Engineering Sandbox Disclaimer -->
        <div style="margin-top: 2rem; background: rgba(11, 18, 32, 0.72); border: 1px solid rgba(148, 163, 184, 0.14); border-radius: 10px; padding: 0.85rem 1.25rem; display: flex; align-items: center; justify-content: center; gap: 0.75rem; text-align: center;">
            <svg class="icon-svg-inline" style="width:17px;height:17px;color:#38BDF8;" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            <p style="margin: 0; font-size: 0.825rem; color: var(--slate-dark); line-height: 1.5;">
                <strong style="color: var(--slate);">Interactive Architectural Demonstrators:</strong> These panels run client-side vector search matching and webhook ingestion simulations. In production, our systems connect directly with Qdrant Vector DB, Meta Cloud API, and secure MySQL CRM tables.
            </p>
        </div>
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
                    <span class="testimonial-metric-chip">100% On-Time</span>
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
                    <div class="testimonial-avatar" style="background: linear-gradient(135deg, #0284C7, #38BDF8);">MV
                    </div>
                    <div class="testimonial-info">
                        <h4>Marcus Vance</h4>
                        <span>Operations Lead, Luxe Wellness</span>
                    </div>
                    <span class="testimonial-metric-chip"
                        style="color: #38BDF8; background: rgba(14, 165, 233, 0.12); border-color: rgba(56, 189, 248, 0.25);">
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
                        style="color: #34D399; background: rgba(16, 185, 129, 0.12); border-color: rgba(16, 185, 129, 0.25);">
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
                        <div class="trust-badge-icon">&#10003;</div>
                        <div>Direct access to Senior Architects (No sales runaround)</div>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">&#10003;</div>
                        <div>Fixed-scope milestone estimates with clear acceptance criteria</div>
                    </div>
                    <div class="trust-badge-item">
                        <div class="trust-badge-icon">&#10003;</div>
                        <div>Clear contractual IP assignment upon milestone delivery</div>
                    </div>
                </div>

                <div style="margin-top: 2.5rem; display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary">
                        <span>Book Discovery Call</span>
                    </a>
                    <a href="mailto:<?= COMPANY_EMAIL ?>" class="btn btn-secondary">
                        <span>Email: <?= COMPANY_EMAIL ?></span>
                    </a>
                </div>
            </div>

            <!-- Inbound Form Card -->
            <div class="card form-card">
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
                        Confidential &bull; Zero spam &bull; Prompt review during business hours
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Interactive Live Demo Modal Overlay (For Trigger Buttons) -->
<?php include __DIR__ . '/components/demo-modal.php'; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>