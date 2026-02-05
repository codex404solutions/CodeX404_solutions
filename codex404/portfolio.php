<?php include 'includes/header.php'; ?>

<section class="portfolio-hero">
    <div class="container">
        <h1>Our Work</h1>
        <p>Projects where bugs met their match.</p>
    </div>
</section>

<section class="portfolio">
    <div class="container">

        <!-- FILTERS -->
        <div class="portfolio-filters">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="web">Web</button>
            <button class="filter-btn" data-filter="software">Software</button>
            <button class="filter-btn" data-filter="ai">AI / Automation</button>
        </div>

        <!-- PROJECT GRID -->
        <div class="portfolio-grid">

            <div class="portfolio-card web">
                <div class="portfolio-content">
                    <h3>Corporate Website</h3>
                    <p>Modern responsive business website.</p>
                    <span>PHP · MySQL · UI/UX</span>
                </div>
            </div>

            <div class="portfolio-card software">
                <div class="portfolio-content">
                    <h3>School ERP System</h3>
                    <p>Student, teacher & admin management.</p>
                    <span>PHP · MySQL · Admin Panel</span>
                </div>
            </div>

            <div class="portfolio-card ai">
                <div class="portfolio-content">
                    <h3>AI Automation Tool</h3>
                    <p>Workflow automation for businesses.</p>
                    <span>AI · Automation · APIs</span>
                </div>
            </div>

            <div class="portfolio-card web">
                <div class="portfolio-content">
                    <h3>E-Commerce Platform</h3>
                    <p>Secure & scalable online store.</p>
                    <span>PHP · Payment · Security</span>
                </div>
            </div>

            <div class="portfolio-card software">
                <div class="portfolio-content">
                    <h3>Custom CRM</h3>
                    <p>Lead & client management system.</p>
                    <span>Backend · Dashboard</span>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
