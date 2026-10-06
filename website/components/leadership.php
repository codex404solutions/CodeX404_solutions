<?php
declare(strict_types=1);
?>
<section class="section" id="leadership" style="background: rgba(11, 31, 58, 0.4); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Leadership</span>
            </div>
            <h2 class="section-title">Engineers & Operators at the Helm</h2>
            <p class="section-subtitle">
                Direct access to seasoned technical leadership who design, review, and deliver production systems.
            </p>
        </div>

        <div class="leadership-grid">
            <!-- FOUNDER -->
            <div class="leader-card">
                <div class="leader-img-wrap">
                    <img src="<?= FOUNDER_IMAGE ?>" alt="<?= FOUNDER_NAME ?> — <?= FOUNDER_ROLE ?>" loading="lazy" width="400" height="280">
                </div>
                <div class="leader-info">
                    <h3 class="leader-name">
                        <a href="<?= FOUNDER_PORTFOLIO ?>" target="_blank" rel="noopener noreferrer">
                            <?= FOUNDER_NAME ?>
                        </a>
                    </h3>
                    <div class="leader-role">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10H12V2z"></path><path d="M12 12L2.1 12a10 10 0 0 0 9.9 10"></path></svg>
                        <?= FOUNDER_ROLE ?>
                    </div>
                    <p class="leader-bio"><?= FOUNDER_BIO ?></p>
                    <div class="leader-links">
                        <a href="<?= FOUNDER_LINKEDIN ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" aria-label="Muhammad Noukhez on LinkedIn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            LinkedIn
                        </a>
                        <a href="<?= FOUNDER_PORTFOLIO ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline btn-sm">
                            Portfolio
                        </a>
                    </div>
                </div>
            </div>

            <!-- CO-FOUNDER -->
            <div class="leader-card">
                <div class="leader-img-wrap">
                    <img src="<?= COFOUNDER_IMAGE ?>" alt="<?= COFOUNDER_NAME ?> — <?= COFOUNDER_ROLE ?>" loading="lazy" width="400" height="280">
                </div>
                <div class="leader-info">
                    <h3 class="leader-name">
                        <a href="<?= COFOUNDER_LINKEDIN ?>" target="_blank" rel="noopener noreferrer">
                            <?= COFOUNDER_NAME ?>
                        </a>
                    </h3>
                    <div class="leader-role">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <?= COFOUNDER_ROLE ?>
                    </div>
                    <p class="leader-bio"><?= COFOUNDER_BIO ?></p>
                    <div class="leader-links">
                        <a href="<?= COFOUNDER_LINKEDIN ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary btn-sm" aria-label="Yousuf Ansari on LinkedIn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            LinkedIn
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
