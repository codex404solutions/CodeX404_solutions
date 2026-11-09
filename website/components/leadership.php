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
                <span>Leadership & Technical Pedigree</span>
            </div>
            <h2 class="section-title">
                Senior Engineering Led by <span class="text-gradient gradient-text-animated">Real Practitioners</span>
            </h2>
            <p class="section-subtitle">
                No intermediate account-managers. You communicate directly with systems architects who have engineered
                solutions for enterprise giants.
            </p>
        </div>

        <div class="grid grid-cols-2" style="max-width: 980px; margin: 0 auto; gap: 2rem;">
            <!-- Founder: Muhammad Noukhez -->
            <article class="card card-tilt"
                style="background: rgba(17, 29, 58, 0.85); border: 1px solid rgba(59, 130, 246, 0.35); text-align: center; padding: 2.5rem; border-radius: var(--radius-lg, 16px);">
                <div style="position: relative; width: 120px; height: 120px; margin: 0 auto 1.5rem auto;">
                    <img src="<?= FOUNDER_IMAGE ?>" alt="<?= FOUNDER_NAME ?>"
                        style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid var(--cyan); box-shadow: 0 0 20px rgba(6, 214, 160, 0.4);">
                    <span
                        style="position: absolute; bottom: 4px; right: 4px; width: 18px; height: 18px; background: #10B981; border: 3px solid #060B18; border-radius: 50%; box-shadow: 0 0 8px #10B981;"></span>
                </div>
                <h3 style="font-size: 1.4rem; color: #FFFFFF; margin-bottom: 0.35rem;">
                    <a href="https://mnoukhej.github.io/portfolio/" target="_blank" rel="noopener"
                        class="top-founder-link"><?= FOUNDER_NAME ?></a>
                </h3>
                <div
                    style="font-size: 0.85rem; color: #38BDF8; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">
                    <?= FOUNDER_ROLE ?> • 7+ Yrs TCS Enterprise Specialist
                </div>
                <p style="font-size: 0.9rem; color: var(--slate); line-height: 1.6; margin-bottom: 1.5rem;">
                    <?= FOUNDER_BIO ?> Specialized in high-throughput Python architecture, Azure OpenAI & RAG systems,
                    and resilient cloud web platforms.
                </p>
                <div style="display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="https://mnoukhej.github.io/portfolio/" target="_blank" rel="noopener"
                        class="btn btn-primary btn-sm">
                        <span>View Portfolio ↗</span>
                    </a>
                    <a href="<?= FOUNDER_LINKEDIN ?>" target="_blank" rel="noopener noreferrer"
                        class="btn btn-secondary btn-sm">
                        <span>LinkedIn</span>
                    </a>
                </div>
            </article>

            <!-- Co-Founder: Yousuf Ansari -->
            <article class="card card-tilt"
                style="background: rgba(17, 29, 58, 0.85); border: 1px solid rgba(139, 92, 246, 0.35); text-align: center; padding: 2.5rem; border-radius: var(--radius-lg, 16px);">
                <div style="position: relative; width: 120px; height: 120px; margin: 0 auto 1.5rem auto;">
                    <img src="<?= COFOUNDER_IMAGE ?>" alt="<?= COFOUNDER_NAME ?>"
                        style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 3px solid var(--violet, #8B5CF6); box-shadow: 0 0 20px rgba(139, 92, 246, 0.4);">
                    <span
                        style="position: absolute; bottom: 4px; right: 4px; width: 18px; height: 18px; background: #10B981; border: 3px solid #060B18; border-radius: 50%; box-shadow: 0 0 8px #10B981;"></span>
                </div>
                <h3 style="font-size: 1.4rem; color: #FFFFFF; margin-bottom: 0.35rem;"><?= COFOUNDER_NAME ?></h3>
                <div
                    style="font-size: 0.85rem; color: #A78BFA; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">
                    <?= COFOUNDER_ROLE ?>
                </div>
                <p style="font-size: 0.9rem; color: var(--slate); line-height: 1.6; margin-bottom: 1.5rem;">
                    <?= COFOUNDER_BIO ?>
                </p>
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
