<?php
declare(strict_types=1);
?>
</main>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Col 1: Brand Info -->
            <div class="footer-col footer-brand-col">
                <a href="<?= url('index.php') ?>" class="brand-logo footer-brand-logo">
                    <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" class="site-logo-img"
                        width="160" height="44">
                </a>
                <div class="footer-brand-tagline">
                    <span class="footer-tagline-dot" aria-hidden="true"></span>
                    <span>Where Bugs Meet Their Match</span>
                </div>
                <p class="footer-brand-desc">
                    Custom software &amp; CRM/ERP systems, performance-driven digital growth, and 24/7 AI workflow automation engineered to scale your business.
                </p>
                <div class="footer-bga-pill" role="navigation" aria-label="Core Divisions">
                    <a href="<?= url('build.php') ?>" class="footer-bga-item is-build">BUILD</a>
                    <span class="footer-bga-sep" aria-hidden="true"></span>
                    <a href="<?= url('grow.php') ?>" class="footer-bga-item is-grow">GROW</a>
                    <span class="footer-bga-sep" aria-hidden="true"></span>
                    <a href="<?= url('automate.php') ?>" class="footer-bga-item is-automate">AUTOMATE</a>
                </div>

                <!-- Official Social Media Channels (Non-floating) -->
                <div class="footer-social-bar" aria-label="Official Social Channels">
                    <a href="<?= COMPANY_LINKEDIN ?>" target="_blank" rel="noopener noreferrer"
                        class="footer-social-link" title="LinkedIn" aria-label="LinkedIn">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                    </a>
                    <a href="<?= COMPANY_GITHUB ?>" target="_blank" rel="noopener noreferrer" class="footer-social-link"
                        title="GitHub" aria-label="GitHub">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                        </svg>
                    </a>
                    <a href="<?= COMPANY_TWITTER ?>" target="_blank" rel="noopener noreferrer"
                        class="footer-social-link" title="Twitter / X" aria-label="Twitter / X">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                    </a>
                    <a href="<?= COMPANY_INSTAGRAM ?>" target="_blank" rel="noopener noreferrer"
                        class="footer-social-link" title="Instagram" aria-label="Instagram">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                    <a href="<?= COMPANY_FACEBOOK ?>" target="_blank" rel="noopener noreferrer"
                        class="footer-social-link" title="Facebook" aria-label="Facebook">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="<?= COMPANY_YOUTUBE ?>" target="_blank" rel="noopener noreferrer"
                        class="footer-social-link" title="YouTube" aria-label="YouTube">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Col 2: Solutions -->
            <div class="footer-col">
                <h4>Solutions</h4>
                <ul class="footer-links">
                    <li><a href="<?= url('build.php') ?>">BUILD Overview</a></li>
                    <li><a href="<?= url('grow.php') ?>">GROW Overview</a></li>
                    <li><a href="<?= url('automate.php') ?>">AUTOMATE Overview</a></li>
                    <li><a href="<?= url('software-development.php') ?>">Custom Software</a></li>
                    <li><a href="<?= url('ai-solutions.php') ?>">Enterprise AI</a></li>
                </ul>
            </div>

            <!-- Col 3: Company -->
            <div class="footer-col">
                <h4>Company</h4>
                <ul class="footer-links">
                    <li><a href="<?= url('about.php') ?>">About Us</a></li>
                    <li><a href="<?= url('our-work.php') ?>">Our Work</a></li>
                    <li><a href="<?= url('process.php') ?>">Engineering Process</a></li>
                    <li><a href="<?= url('industries.php') ?>">Industries Served</a></li>
                    <li><a href="<?= url('careers.php') ?>">Careers</a></li>
                </ul>
            </div>

            <!-- Col 4: Trust & Legal -->
            <div class="footer-col">
                <h4>Trust &amp; Legal</h4>
                <ul class="footer-links">
                    <li><a href="<?= url('security.php') ?>">Security &amp; Compliance</a></li>
                    <li><a href="<?= url('engagement-models.php') ?>">Engagement Models</a></li>
                    <li><a href="<?= url('faq.php') ?>">FAQ</a></li>
                    <li><a href="<?= url('privacy.php') ?>">Privacy Policy</a></li>
                    <li><a href="<?= url('terms.php') ?>">Terms of Service</a></li>
                </ul>
            </div>

            <!-- Col 5: Direct Contact -->
            <div class="footer-col">
                <div class="footer-cta-card">
                    <div class="footer-cta-header">
                        <h4>Start Your Project</h4>
                        <span class="footer-availability-badge">
                            <span class="footer-avail-dot" aria-hidden="true"></span>
                            Direct Lead
                        </span>
                    </div>
                    <p class="footer-cta-copy">
                        Book a free 30-min engineering call to scope your custom platform, growth funnel, or AI workflow.
                    </p>
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-sm footer-cta-primary">
                        Book a Discovery Call &rarr;
                    </a>
                    <div class="footer-contact-meta">
                        <a href="mailto:<?= COMPANY_EMAIL ?>" class="footer-meta-link">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <span><?= COMPANY_EMAIL ?></span>
                        </a>
                        <a href="<?= url('contact.php') ?>" class="footer-meta-link is-inquiry">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                            </svg>
                            <span>Send Project Inquiry &rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div>
                &copy; <?= date('Y') ?> <?= APP_NAME ?>. All rights reserved. • Developed by <a
                    href="https://codex404solutions.com" target="_blank" rel="noopener noreferrer"
                    style="display: inline-flex; align-items: center; vertical-align: middle; margin-left: 0.25rem;"><img
                        src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions"
                        style="height: 18px; width: auto; vertical-align: middle;"></a>
            </div>
            <div style="display: flex; gap: 1.5rem; align-items: center; flex-wrap: wrap;">
                <a href="<?= admin_url('index.php') ?>"
                    style="opacity: 0.75; display: inline-flex; align-items: center; gap: 0.25rem;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    Admin
                </a>
            </div>
        </div>
    </div>
</footer>

<?php include __DIR__ . '/../components/cookie-banner.php'; ?>
<?php include __DIR__ . '/../components/chatbot.php'; ?>

<!-- Floating Back-to-Top Button -->
<button type="button" id="backToTopBtn" class="back-to-top-btn" aria-label="Back to top" title="Back to top">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
        <polyline points="18 15 12 9 6 15"></polyline>
    </svg>
</button>

<!-- Client-side Scripts -->
<script
    src="<?= asset('js/main.js') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/js/main.js') ? filemtime(dirname(__DIR__) . '/assets/js/main.js') : '1.0' ?>"
    defer></script>
<script
    src="<?= asset('js/scene3d.js') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/js/scene3d.js') ? filemtime(dirname(__DIR__) . '/assets/js/scene3d.js') : '1.0' ?>"
    defer></script>
<script
    src="<?= asset('js/scroll-engine.js') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/js/scroll-engine.js') ? filemtime(dirname(__DIR__) . '/assets/js/scroll-engine.js') : '1.0' ?>"
    defer></script>
<script
    src="<?= asset('js/forms.js') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/js/forms.js') ? filemtime(dirname(__DIR__) . '/assets/js/forms.js') : '1.0' ?>"
    defer></script>
<script
    src="<?= asset('js/chatbot.js') ?>?v=<?= file_exists(dirname(__DIR__) . '/assets/js/chatbot.js') ? filemtime(dirname(__DIR__) . '/assets/js/chatbot.js') : '1.0' ?>"
    defer></script>

</body>

</html>