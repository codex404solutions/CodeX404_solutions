<?php

declare(strict_types=1);

$currentScript = basename($_SERVER['SCRIPT_NAME'] ?? '');

$isHomeActive = ($currentScript === 'index.php');
$isBuildActive = in_array($currentScript, ['build.php', 'software-development.php', 'saas.php', 'mobile-apps.php']);
$isGrowActive = in_array($currentScript, ['grow.php', 'solutions.php']);
$isAutomateActive = in_array($currentScript, ['automate.php', 'ai-solutions.php', 'ai-agents.php', 'automation.php']);
$isIndustriesActive = ($currentScript === 'industries.php');
$isWorkActive = in_array($currentScript, ['case-studies.php', 'portfolio.php', 'project.php']);
$isCompanyActive = in_array($currentScript, ['about.php', 'process.php', 'engagement-models.php', 'security.php', 'faq.php']);
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

                <!-- 2. BUILD Division -->
                <li class="nav-item nav-item-dropdown">
                    <div class="nav-link-group">
                        <a href="<?= url('build.php') ?>" class="nav-link <?= $isBuildActive ? 'active' : '' ?>">BUILD</a>
                        <button type="button" class="nav-dropdown-toggle" aria-label="Toggle BUILD division menu" aria-expanded="false" aria-controls="buildMenu">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </button>
                    </div>
                    <ul class="nav-dropdown" id="buildMenu" style="min-width: 285px;">
                        <li style="padding: 0.4rem 0.85rem 0.2rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #60A5FA; display: flex; align-items: center; gap: 6px;">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #3B82F6;"></span>
                            <span>BUILD — Engineering & Apps</span>
                        </li>
                        <li>
                            <a href="<?= url('build.php') ?>" class="dropdown-link">
                                <strong>BUILD Division Overview</strong>
                                <span>Digital products, SaaS & software engineering</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('software-development.php') ?>" class="dropdown-link">
                                <strong>Custom Software & Web</strong>
                                <span>Business platforms, web apps & portals</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('saas.php') ?>" class="dropdown-link">
                                <strong>SaaS MVP Engineering</strong>
                                <span>Multi-tenant platforms & subscription billing</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('mobile-apps.php') ?>" class="dropdown-link">
                                <strong>Mobile Applications</strong>
                                <span>iOS, Android & Progressive Web Apps</span>
                            </a>
                        </li>
                        <li style="border-top: 1px solid rgba(255, 255, 255, 0.06); margin-top: 0.35rem; padding-top: 0.35rem;">
                            <a href="<?= url('index.php#division-build') ?>" class="dropdown-link" style="color: #60A5FA;">
                                <strong>Homepage Section Jump &rarr;</strong>
                                <span>Featured BUILD specifications & tech stack</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 3. GROW Division -->
                <li class="nav-item nav-item-dropdown">
                    <div class="nav-link-group">
                        <a href="<?= url('grow.php') ?>" class="nav-link <?= $isGrowActive ? 'active' : '' ?>">GROW</a>
                        <button type="button" class="nav-dropdown-toggle" aria-label="Toggle GROW division menu" aria-expanded="false" aria-controls="growMenu">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </button>
                    </div>
                    <ul class="nav-dropdown" id="growMenu" style="min-width: 285px;">
                        <li style="padding: 0.4rem 0.85rem 0.2rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #C084FC; display: flex; align-items: center; gap: 6px;">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #8B5CF6;"></span>
                            <span>GROW — Visibility & Growth</span>
                        </li>
                        <li>
                            <a href="<?= url('grow.php') ?>" class="dropdown-link">
                                <strong>GROW Division Overview</strong>
                                <span>Digital marketing, search & conversion</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('solutions.php') ?>" class="dropdown-link">
                                <strong>Search Visibility & SEO/AEO</strong>
                                <span>Structured discovery & content positioning</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('contact.php?division=grow') ?>" class="dropdown-link">
                                <strong>Digital Marketing & Campaigns</strong>
                                <span>Audience-focused growth & acquisition</span>
                            </a>
                        </li>
                        <li style="border-top: 1px solid rgba(255, 255, 255, 0.06); margin-top: 0.35rem; padding-top: 0.35rem;">
                            <a href="<?= url('index.php#division-grow') ?>" class="dropdown-link" style="color: #C084FC;">
                                <strong>Homepage Section Jump &rarr;</strong>
                                <span>Featured GROW capabilities & proof</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 4. AUTOMATE Division -->
                <li class="nav-item nav-item-dropdown">
                    <div class="nav-link-group">
                        <a href="<?= url('automate.php') ?>" class="nav-link <?= $isAutomateActive ? 'active' : '' ?>">AUTOMATE</a>
                        <button type="button" class="nav-dropdown-toggle" aria-label="Toggle AUTOMATE division menu" aria-expanded="false" aria-controls="automateMenu">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </button>
                    </div>
                    <ul class="nav-dropdown" id="automateMenu" style="min-width: 295px;">
                        <li style="padding: 0.4rem 0.85rem 0.2rem; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #34D399; display: flex; align-items: center; gap: 6px;">
                            <span style="width: 6px; height: 6px; border-radius: 50%; background: #10B981;"></span>
                            <span>AUTOMATE — AI & Workflows</span>
                        </li>
                        <li>
                            <a href="<?= url('automate.php') ?>" class="dropdown-link">
                                <strong>AUTOMATE Division Overview</strong>
                                <span>Integrations, workflows & practical AI</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('ai-solutions.php') ?>" class="dropdown-link">
                                <strong>Enterprise AI & Knowledge RAG</strong>
                                <span>Private documentation retrieval & search</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('ai-agents.php') ?>" class="dropdown-link">
                                <strong>Autonomous AI Agents</strong>
                                <span>Multi-tool agentic resolution workflows</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('automation.php') ?>" class="dropdown-link">
                                <strong>Workflow & API Pipelines</strong>
                                <span>WhatsApp Cloud, CRM sync & API automations</span>
                            </a>
                        </li>
                        <li style="border-top: 1px solid rgba(255, 255, 255, 0.06); margin-top: 0.35rem; padding-top: 0.35rem;">
                            <a href="<?= url('index.php#division-automate') ?>" class="dropdown-link" style="color: #34D399;">
                                <strong>Homepage Section Jump &rarr;</strong>
                                <span>Featured AUTOMATE pipelines & simulations</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 5. Industries Dropdown -->
                <li class="nav-item nav-item-dropdown">
                    <div class="nav-link-group">
                        <a href="<?= url('industries.php') ?>" class="nav-link <?= $isIndustriesActive ? 'active' : '' ?>">Industries</a>
                        <button type="button" class="nav-dropdown-toggle" aria-label="Toggle Industries menu" aria-expanded="false" aria-controls="industriesMenu">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </button>
                    </div>
                    <ul class="nav-dropdown" id="industriesMenu" style="min-width: 275px;">
                        <li>
                            <a href="<?= url('industries.php') ?>" class="dropdown-link">
                                <strong>All Industries Overview</strong>
                                <span>Vertical engineering capabilities</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('industries.php#industry-education') ?>" class="dropdown-link">
                                <strong>Education & EdTech</strong>
                                <span>School ERPs, student portals & fees</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('industries.php#industry-healthcare') ?>" class="dropdown-link">
                                <strong>Healthcare & Clinics</strong>
                                <span>Patient portals & booking systems</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('industries.php#industry-commerce') ?>" class="dropdown-link">
                                <strong>B2B Commerce & Retail</strong>
                                <span>Inventory sync & wholesale portals</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('industries.php#industry-realestate') ?>" class="dropdown-link">
                                <strong>Real Estate & Property</strong>
                                <span>Tenant portals & lead routing</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('industries.php#industry-logistics') ?>" class="dropdown-link">
                                <strong>Logistics & Dispatch</strong>
                                <span>Field dispatch & tracking workflows</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('industries.php#industry-legal') ?>" class="dropdown-link">
                                <strong>Professional & Legal Services</strong>
                                <span>Confidential document RAG & portals</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 6. Our Work Dropdown -->
                <li class="nav-item nav-item-dropdown">
                    <div class="nav-link-group">
                        <a href="<?= url('case-studies.php') ?>" class="nav-link <?= $isWorkActive ? 'active' : '' ?>">Our Work</a>
                        <button type="button" class="nav-dropdown-toggle" aria-label="Toggle Our Work menu" aria-expanded="false" aria-controls="workMenu">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </button>
                    </div>
                    <ul class="nav-dropdown" id="workMenu" style="min-width: 260px;">
                        <li>
                            <a href="<?= url('case-studies.php') ?>" class="dropdown-link">
                                <strong>Case Studies</strong>
                                <span>In-depth business problems solved</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('portfolio.php') ?>" class="dropdown-link">
                                <strong>Portfolio</strong>
                                <span>Selected engineering deliverables & systems</span>
                            </a>
                        </li>
                        <li style="border-top: 1px solid rgba(255, 255, 255, 0.06); margin-top: 0.35rem; padding-top: 0.35rem;">
                            <a href="<?= url('index.php#projects') ?>" class="dropdown-link" style="color: var(--cyan);">
                                <strong>Featured Project Demos &rarr;</strong>
                                <span>Interactive sandbox modules & mockups</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 7. Company Dropdown (About, Process, Engagement Models, Security, FAQ) -->
                <li class="nav-item nav-item-dropdown">
                    <div class="nav-link-group">
                        <a href="<?= url('about.php') ?>" class="nav-link <?= $isCompanyActive ? 'active' : '' ?>">Company</a>
                        <button type="button" class="nav-dropdown-toggle" aria-label="Toggle Company menu" aria-expanded="false" aria-controls="companyMenu">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </button>
                    </div>
                    <ul class="nav-dropdown" id="companyMenu" style="min-width: 275px;">
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

                <!-- 8. Contact -->
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
