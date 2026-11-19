<?php

declare(strict_types=1);

$currentScript = basename($_SERVER['SCRIPT_NAME'] ?? '');

$isHomeActive = ($currentScript === 'index.php');
$isBuildActive = in_array($currentScript, ['build.php', 'software-development.php', 'saas.php', 'mobile-apps.php']);
$isGrowActive = in_array($currentScript, ['grow.php', 'solutions.php']);
$isAutomateActive = in_array($currentScript, ['automate.php', 'ai-solutions.php', 'ai-agents.php', 'automation.php']);
$isServicesActive = ($isBuildActive || $isGrowActive || $isAutomateActive || $currentScript === 'solutions.php');
$isWorkActive = in_array($currentScript, ['our-work.php', 'case-studies.php', 'portfolio.php', 'project.php']);
$isAboutActive = in_array($currentScript, ['about.php', 'process.php', 'engagement-models.php', 'security.php', 'faq.php']);
$isCompanyActive = $isAboutActive;
$isContactActive = ($currentScript === 'contact.php');
?>
<header class="site-header">
    <div class="container nav-container">
        <!-- Brand Logo -->
        <a href="<?= url('index.php') ?>" class="brand-logo" aria-label="CodeX404 Solutions Home">
            <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" class="site-logo-img" width="160" height="44">
        </a>

        <!-- Main Navigation Links (PRD §7 Taxonomy) -->
        <nav aria-label="Primary navigation">
            <ul class="nav-menu" id="navMenu">
                <!-- 1. Home -->
                <li class="nav-item">
                    <a href="<?= url('index.php') ?>" class="nav-link <?= $isHomeActive ? 'active' : '' ?>">Home</a>
                </li>

                <!-- 2. Services Dropdown (BUILD · GROW · AUTOMATE 3-Column Mega Menu) -->
                <li class="nav-item nav-item-dropdown nav-item-mega">
                    <div class="nav-link-group">
                        <a href="<?= url('build.php') ?>" class="nav-link <?= $isServicesActive ? 'active' : '' ?>">Services</a>
                        <button type="button" class="nav-dropdown-toggle" aria-label="Toggle Services menu" aria-expanded="false" aria-controls="servicesMenu">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </button>
                    </div>
                    <div class="nav-dropdown nav-dropdown-mega" id="servicesMenu" role="region" aria-label="Services Mega Menu">
                        <div class="mega-grid">
                            <!-- Column 1: BUILD -->
                            <div class="mega-col col-build">
                                <a href="<?= url('build.php') ?>" class="mega-col-header text-build">
                                    <div class="mega-col-header-left">
                                        <span class="mega-dot dot-build"></span>
                                        <strong class="mega-col-title">BUILD</strong>
                                    </div>
                                    <span class="mega-header-sub">/build &rarr;</span>
                                </a>
                                <ul class="mega-links-list">
                                    <li><a href="<?= url('build.php') ?>#custom-web-apps" class="mega-link">Custom Web Application Development</a></li>
                                    <li><a href="<?= url('build.php') ?>#school-erp" class="mega-link">School ERP &amp; Institutional Portals</a></li>
                                    <li><a href="<?= url('build.php') ?>#custom-crm" class="mega-link">Custom CRM Development</a></li>
                                    <li><a href="<?= url('build.php') ?>#ecommerce" class="mega-link">E-Commerce &amp; Checkout Platforms</a></li>
                                    <li><a href="<?= url('build.php') ?>#saas-mvp" class="mega-link">SaaS MVP &amp; Multi-Tenant Setup</a></li>
                                    <li><a href="<?= url('build.php') ?>#mobile-apps" class="mega-link">Cross-Platform Mobile &amp; PWA</a></li>
                                    <li><a href="<?= url('build.php') ?>#api-development" class="mega-link">API Development &amp; Integrations</a></li>
                                    <li><a href="<?= url('build.php') ?>#website-redesign" class="mega-link">Website Redesign &amp; Modernization</a></li>
                                </ul>
                            </div>

                            <!-- Column 2: GROW -->
                            <div class="mega-col col-grow">
                                <a href="<?= url('grow.php') ?>" class="mega-col-header text-grow">
                                    <div class="mega-col-header-left">
                                        <span class="mega-dot dot-grow"></span>
                                        <strong class="mega-col-title">GROW</strong>
                                    </div>
                                    <span class="mega-header-sub">/grow &rarr;</span>
                                </a>
                                <ul class="mega-links-list">
                                    <li><a href="<?= url('grow.php') ?>#seo" class="mega-link">Search Engine Optimization (SEO)</a></li>
                                    <li><a href="<?= url('grow.php') ?>#aeo-geo" class="mega-link">Answer Engine &amp; AI Search (AEO/GEO)</a></li>
                                    <li><a href="<?= url('grow.php') ?>#ppc-ads" class="mega-link">PPC Advertising &amp; Google Ads</a></li>
                                    <li><a href="<?= url('grow.php') ?>#social-media" class="mega-link">Social Media Management &amp; Marketing</a></li>
                                    <li><a href="<?= url('grow.php') ?>#conversion-rate" class="mega-link">Conversion Rate Optimization (CRO)</a></li>
                                    <li><a href="<?= url('grow.php') ?>#content-writing" class="mega-link">Content Writing &amp; Copywriting</a></li>
                                    <li><a href="<?= url('grow.php') ?>#maintenance" class="mega-link">Website Maintenance &amp; Support</a></li>
                                    <li><a href="<?= url('grow.php') ?>#growth-audits" class="mega-link">SEO &amp; Digital Growth Audits</a></li>
                                </ul>
                            </div>

                            <!-- Column 3: AUTOMATE -->
                            <div class="mega-col col-automate">
                                <a href="<?= url('automate.php') ?>" class="mega-col-header text-automate">
                                    <div class="mega-col-header-left">
                                        <span class="mega-dot dot-automate"></span>
                                        <strong class="mega-col-title">AUTOMATE</strong>
                                    </div>
                                    <span class="mega-header-sub">/automate &rarr;</span>
                                </a>
                                <ul class="mega-links-list">
                                    <li><a href="<?= url('automate.php') ?>#ai-agents" class="mega-link">24/7 AI Customer Support Agents</a></li>
                                    <li><a href="<?= url('automate.php') ?>#whatsapp-crm" class="mega-link">WhatsApp Cloud API &amp; CRM Pipelines</a></li>
                                    <li><a href="<?= url('automate.php') ?>#enterprise-rag" class="mega-link">Enterprise RAG &amp; Knowledge Bases</a></li>
                                    <li><a href="<?= url('automate.php') ?>#workflow-automation" class="mega-link">Automated Invoicing &amp; Workflows</a></li>
                                    <li><a href="<?= url('automate.php') ?>#event-webhooks" class="mega-link">Event-Driven Webhooks &amp; Sync</a></li>
                                    <li><a href="<?= url('automate.php') ?>#document-extraction" class="mega-link">Document Data Extraction &amp; OCR</a></li>
                                    <li><a href="<?= url('automate.php') ?>#multi-agent" class="mega-link">Multi-Agent Autonomous Systems</a></li>
                                    <li><a href="<?= url('automate.php') ?>#lead-capture" class="mega-link">Real-Time Lead Capture &amp; Routing</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Mega Menu Footer Bar -->
                        <div class="mega-footer-bar">
                            <div class="mega-footer-text">
                                <span>⚡ Need a custom architecture tailored to your business?</span>
                            </div>
                            <div class="mega-footer-links">
                                <a href="<?= url('discovery-call.php') ?>" class="mega-footer-cta">
                                    <span>Book a Discovery Call &rarr;</span>
                                </a>
                                <a href="<?= url('index.php#divisions') ?>" class="mega-footer-sublink">
                                    <span>Compare All Offerings &rarr;</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- 3. Our Work -->
                <li class="nav-item">
                    <a href="<?= url('our-work.php') ?>" class="nav-link <?= $isWorkActive ? 'active' : '' ?>">Our Work</a>
                </li>

                <!-- 4. About Dropdown (About, Process, Engagement Models, Security, FAQ) -->
                <li class="nav-item nav-item-dropdown">
                    <div class="nav-link-group">
                        <a href="<?= url('about.php') ?>" class="nav-link <?= $isAboutActive ? 'active' : '' ?>">About</a>
                        <button type="button" class="nav-dropdown-toggle" aria-label="Toggle About menu" aria-expanded="false" aria-controls="aboutMenu">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </button>
                    </div>
                    <ul class="nav-dropdown" id="aboutMenu" style="min-width: 275px;">
                        <li>
                            <a href="<?= url('about.php') ?>" class="dropdown-link">
                                <strong>About CodeX404</strong>
                                <span>Engineering philosophy & leadership</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('process.php') ?>" class="dropdown-link">
                                <strong>Engineering Process</strong>
                                <span>Step-by-step verified development</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('engagement-models.php') ?>" class="dropdown-link">
                                <strong>Engagement Models</strong>
                                <span>Milestone, dedicated & advisory</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('security.php') ?>" class="dropdown-link">
                                <strong>Security & Compliance</strong>
                                <span>Data isolation & access governance</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('faq.php') ?>" class="dropdown-link">
                                <strong>Technical FAQ</strong>
                                <span>Common architecture & delivery questions</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 5. Contact -->
                <li class="nav-item">
                    <a href="<?= url('contact.php') ?>" class="nav-link <?= $isContactActive ? 'active' : '' ?>">Contact</a>
                </li>

                <!-- Mobile Only CTA -->
                <li class="mobile-cta">
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-block">
                        Book a Discovery Call
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Desktop CTA Actions -->
        <div class="nav-actions">
            <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-sm">
                Book a Discovery Call
            </a>
            <button type="button" class="nav-toggle-btn" id="navToggleBtn" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="navMenu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
</header>
