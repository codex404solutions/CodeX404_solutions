<?php
declare(strict_types=1);
?>
<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Col 1: Brand Info -->
            <div class="footer-col">
                <a href="<?= url('index.php') ?>" class="brand-logo" style="margin-bottom: 1.25rem;">
                    <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" class="site-logo-img" width="160" height="44">
                </a>
                <p style="font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.25rem;">
                    <strong style="color: var(--white); display: block; margin-bottom: 0.25rem;">Where Bugs Meet Their Match.</strong>
                    High-performance software, custom enterprise platforms, and intelligent AI automation systems engineered for growth.
                </p>
                <div class="system-status-indicator">
                    <span class="status-pulse"></span>
                    <span>All client systems operational</span>
                </div>
            </div>

            <!-- Col 2: Solutions -->
            <div class="footer-col">
                <h4>Solutions</h4>
                <ul class="footer-links">
                    <li><a href="<?= url('software-development.php') ?>">Custom Software</a></li>
                    <li><a href="<?= url('ai-solutions.php') ?>">Enterprise AI</a></li>
                    <li><a href="<?= url('ai-agents.php') ?>">AI Agents</a></li>
                    <li><a href="<?= url('automation.php') ?>">Workflow Automation</a></li>
                    <li><a href="<?= url('mobile-apps.php') ?>">Mobile Apps</a></li>
                    <li><a href="<?= url('saas.php') ?>">SaaS Development</a></li>
                </ul>
            </div>

            <!-- Col 3: Company -->
            <div class="footer-col">
                <h4>Company</h4>
                <ul class="footer-links">
                    <li><a href="<?= url('about.php') ?>">About Us</a></li>
                    <li><a href="<?= url('process.php') ?>">Engineering Process</a></li>
                    <li><a href="<?= url('engagement-models.php') ?>">Engagement Models</a></li>
                    <li><a href="<?= url('case-studies.php') ?>">Case Studies</a></li>
                    <li><a href="<?= url('portfolio.php') ?>">Portfolio</a></li>
                    <li><a href="<?= url('security.php') ?>">Security & Compliance</a></li>
                    <li><a href="<?= url('faq.php') ?>">FAQ</a></li>
                </ul>
            </div>

            <!-- Col 4: Trust & Legal -->
            <div class="footer-col">
                <h4>Trust & Legal</h4>
                <ul class="footer-links">
                    <li><a href="<?= url('privacy.php') ?>">Privacy Policy (GDPR)</a></li>
                    <li><a href="<?= url('terms.php') ?>">Terms of Service</a></li>
                    <li><a href="<?= FOUNDER_LINKEDIN ?>" target="_blank" rel="noopener noreferrer">Founder LinkedIn</a></li>
                    <li><a href="<?= COFOUNDER_LINKEDIN ?>" target="_blank" rel="noopener noreferrer">Co-Founder LinkedIn</a></li>
                    <li><a href="<?= COMPANY_LINKEDIN ?>" target="_blank" rel="noopener noreferrer">Company LinkedIn</a></li>
                </ul>
            </div>

            <!-- Col 5: Direct Contact -->
            <div class="footer-col">
                <h4>Start a Project</h4>
                <p style="font-size: 0.85rem; margin-bottom: 1rem;">
                    Discuss architecture, automation blueprints, or MVP roadmaps with our engineers.
                </p>
                <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-sm" style="width: 100%; margin-bottom: 0.85rem;">
                    Book Discovery Call
                </a>
                <p style="font-size: 0.8rem; color: var(--slate-dark);">
                    Direct: <a href="mailto:<?= COMPANY_EMAIL ?>"><?= COMPANY_EMAIL ?></a>
                </p>
            </div>
        </div>

        <div class="footer-bottom">
            <div>
                &copy; <?= date('Y') ?> <?= APP_NAME ?>. All rights reserved.
            </div>
            <div style="display: flex; gap: 1.5rem;">
                <a href="<?= url('privacy.php') ?>">Privacy</a>
                <a href="<?= url('terms.php') ?>">Terms</a>
                <a href="<?= url('security.php') ?>">Security</a>
                <a href="<?= url('contact.php') ?>">Contact</a>
            </div>
        </div>
    </div>
</footer>

<?php include __DIR__ . '/../components/cookie-banner.php'; ?>

<!-- Client-side Scripts -->
<script src="<?= asset('js/main.js') ?>" defer></script>
<script src="<?= asset('js/forms.js') ?>" defer></script>

</body>
</html>
