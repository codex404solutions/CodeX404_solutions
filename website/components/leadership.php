<?php
declare(strict_types=1);
?>
<!-- ==========================================================================
     FOUNDER & LEADERSHIP SECTION
     ========================================================================== -->
<section class="section" id="leadership" style="border-top: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Founder-Led Engineering</span>
            </div>
            <h2 class="section-title">
                DIRECT ACCESS TO <span class="text-amber">SENIOR LEADERSHIP</span>
            </h2>
            <p class="section-subtitle">
                Every architecture decision, delivery milestone, and production launch is led directly by our technical founders — zero account-manager handoffs.
            </p>
        </div>

        <div class="grid grid-cols-2 leadership-cards-grid" style="max-width: 980px; margin: 0 auto; gap: 2rem; align-items: stretch;">
            <!-- Founder: Muhammad Noukhez -->
            <article class="card card-tilt leader-dossier-card" style="text-align: center; padding: 2.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div class="leader-portrait-ring">
                        <img src="<?= FOUNDER_IMAGE ?>" alt="<?= FOUNDER_NAME ?>">
                    </div>
                    <h3 style="font-size: 1.4rem; color: #FFFFFF; margin-bottom: 0.35rem;"><?= FOUNDER_NAME ?></h3>
                    <div style="font-size: 0.85rem; color: #FFB547; font-weight: 600; margin-bottom: 1rem;">
                        <?= FOUNDER_ROLE ?>
                    </div>
                    <p style="font-size: 0.9rem; color: var(--slate); line-height: 1.6; margin-bottom: 1.5rem;">
                        <?= FOUNDER_BIO ?> Specialized in high-throughput Python architecture, Azure OpenAI &amp; RAG systems,
                        and resilient cloud web platforms.
                    </p>
                </div>
                <div style="display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="https://mnoukhej.github.io/portfolio/" target="_blank" rel="noopener"
                        class="btn btn-primary btn-sm">
                        <span>View Portfolio</span>
                    </a>
                    <a href="<?= FOUNDER_LINKEDIN ?>" target="_blank" rel="noopener noreferrer"
                        class="btn btn-secondary btn-sm">
                        <span>LinkedIn</span>
                    </a>
                </div>
            </article>

            <!-- Co-Founder: Yousuf Ansari -->
            <article class="card card-tilt leader-dossier-card" style="text-align: center; padding: 2.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div class="leader-portrait-ring">
                        <img src="<?= COFOUNDER_IMAGE ?>" alt="<?= COFOUNDER_NAME ?>">
                    </div>
                    <h3 style="font-size: 1.4rem; color: #FFFFFF; margin-bottom: 0.35rem;"><?= COFOUNDER_NAME ?></h3>
                    <div style="font-size: 0.85rem; color: #22D3EE; font-weight: 600; margin-bottom: 1rem;">
                        <?= COFOUNDER_ROLE ?>
                    </div>
                    <p style="font-size: 0.9rem; color: var(--slate); line-height: 1.6; margin-bottom: 1.5rem;">
                        <?= COFOUNDER_BIO ?>
                    </p>
                </div>
                <div style="display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="<?= COFOUNDER_LINKEDIN ?>" target="_blank" rel="noopener noreferrer"
                        class="btn btn-secondary btn-sm">
                        <span>LinkedIn</span>
                    </a>
                    <a href="mailto:<?= COMPANY_EMAIL ?>" class="btn btn-outline btn-sm">
                        <span>Contact</span>
                    </a>
                </div>
            </article>
        </div>
    </div>
</section>
