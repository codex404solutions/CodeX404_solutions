<?php

declare(strict_types=1);

$currentScript = basename($_SERVER['SCRIPT_NAME'] ?? '');
?>
<header class="site-header">
    <div class="container nav-container">
        <!-- Logo (Clean brand mark without extra text or background) -->
        <a href="<?= url('index.php') ?>" class="brand-logo" aria-label="CodeX404 Solutions Home">
            <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" class="site-logo-img" width="160" height="44">
        </a>

        <!-- Main Navigation Links -->
        <nav aria-label="Primary navigation">
            <ul class="nav-menu" id="navMenu">
                <li class="nav-item">
                    <a href="<?= url('index.php') ?>" class="nav-link <?= $currentScript === 'index.php' ? 'active' : '' ?>">Home</a>
                </li>

                <!-- Solutions Dropdown -->
                <li class="nav-item nav-item-dropdown">
                    <div class="nav-link-group">
                        <a href="<?= url('solutions.php') ?>" class="nav-link <?= in_array($currentScript, ['solutions.php', 'ai-solutions.php', 'ai-agents.php', 'automation.php', 'software-development.php', 'mobile-apps.php', 'saas.php']) ? 'active' : '' ?>">Solutions</a>
                        <button type="button" class="nav-dropdown-toggle" aria-label="Toggle Solutions menu" aria-expanded="false" aria-controls="solutionsMenu">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </button>
                    </div>
                    <ul class="nav-dropdown" id="solutionsMenu">
                        <li>
                            <a href="<?= url('software-development.php') ?>" class="dropdown-link">
                                <strong>Custom Software</strong>
                                <span>Web apps, cloud systems & portals</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('ai-solutions.php') ?>" class="dropdown-link">
                                <strong>Enterprise AI</strong>
                                <span>RAG, knowledge bases & smart search</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('ai-agents.php') ?>" class="dropdown-link">
                                <strong>AI Agents</strong>
                                <span>Autonomous, multi-tool agentic workflows</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('automation.php') ?>" class="dropdown-link">
                                <strong>Workflow Automation</strong>
                                <span>CRM, WhatsApp, Email & API pipelines</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('mobile-apps.php') ?>" class="dropdown-link">
                                <strong>Mobile Applications</strong>
                                <span>Cross-platform iOS & Android apps</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('saas.php') ?>" class="dropdown-link">
                                <strong>SaaS Development</strong>
                                <span>MVP delivery, multi-tenancy & billing</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?= url('industries.php') ?>" class="nav-link <?= $currentScript === 'industries.php' ? 'active' : '' ?>">Industries</a>
                </li>

                <!-- Work Dropdown -->
                <li class="nav-item nav-item-dropdown">
                    <div class="nav-link-group">
                        <a href="<?= url('case-studies.php') ?>" class="nav-link <?= in_array($currentScript, ['case-studies.php', 'portfolio.php']) ? 'active' : '' ?>">Work</a>
                        <button type="button" class="nav-dropdown-toggle" aria-label="Toggle Work menu" aria-expanded="false" aria-controls="workMenu">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" focusable="false">
                                <path d="M6 9l6 6 6-6" />
                            </svg>
                        </button>
                    </div>
                    <ul class="nav-dropdown" id="workMenu">
                        <li>
                            <a href="<?= url('case-studies.php') ?>" class="dropdown-link">
                                <strong>Case Studies</strong>
                                <span>Real business problems solved</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('portfolio.php') ?>" class="dropdown-link">
                                <strong>Portfolio</strong>
                                <span>Selected engineering deliverables</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?= url('process.php') ?>" class="nav-link <?= $currentScript === 'process.php' ? 'active' : '' ?>">Process</a>
                </li>

                <li class="nav-item">
                    <a href="<?= url('about.php') ?>" class="nav-link <?= in_array($currentScript, ['about.php', 'engagement-models.php', 'security.php']) ? 'active' : '' ?>">About</a>
                </li>

                <li class="nav-item">
                    <a href="<?= url('contact.php') ?>" class="nav-link <?= $currentScript === 'contact.php' ? 'active' : '' ?>">Contact</a>
                </li>

                <!-- Mobile Only CTA -->
                <li class="mobile-cta">
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-block">
                        Book a Discovery Call
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Actions -->
        <!-- <div class="nav-actions">
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
        </div> -->
    </div>
</header>