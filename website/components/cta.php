<?php
declare(strict_types=1);
$ctaHeading = $ctaHeading ?? 'Have a business problem software can solve?';
$ctaSubtitle = $ctaSubtitle ?? 'Let’s discuss your operational challenges, software requirements, or product ideas and identify a practical next step.';
$ctaPrimaryText = $ctaPrimaryText ?? 'Book a Discovery Call';
$ctaPrimaryUrl = $ctaPrimaryUrl ?? url('discovery-call.php');
$ctaSecondaryText = $ctaSecondaryText ?? null;
$ctaSecondaryUrl = $ctaSecondaryUrl ?? url('contact.php');
?>
<section class="section" style="position: relative; overflow: hidden;">
    <div class="container">
        <div class="cta-section-wrap">
            
            <div class="section-tag" style="margin-bottom: 1.5rem;">
                <span class="dot"></span>
                <span>Ready to Execute</span>
            </div>

            <h2 style="font-size: clamp(2rem, 4vw, 3rem); max-width: 780px; margin: 0 auto 1.25rem; font-weight: 800;">
                <?= htmlspecialchars($ctaHeading, ENT_QUOTES, 'UTF-8') ?>
            </h2>

            <p style="font-size: 1.15rem; max-width: 640px; margin: 0 auto 2.25rem; color: var(--slate); line-height: 1.6;">
                <?= htmlspecialchars($ctaSubtitle, ENT_QUOTES, 'UTF-8') ?>
            </p>

            <div style="display: flex; gap: 1rem; justify-content: center; align-items: center; flex-wrap: wrap; margin-bottom: 2rem;">
                <a href="<?= $ctaPrimaryUrl ?>" class="btn btn-primary btn-lg">
                    <span><?= htmlspecialchars($ctaPrimaryText, ENT_QUOTES, 'UTF-8') ?></span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 0.5rem; vertical-align: middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
                <?php if (!empty($ctaSecondaryText) && !empty($ctaSecondaryUrl)): ?>
                <a href="<?= $ctaSecondaryUrl ?>" class="btn btn-secondary btn-lg">
                    <span><?= htmlspecialchars($ctaSecondaryText, ENT_QUOTES, 'UTF-8') ?></span>
                </a>
                <?php endif; ?>
            </div>

            <div style="font-size: 0.85rem; color: var(--slate-dark);">
                ✓ Discuss the project with our team &nbsp;·&nbsp; ✓ Scope before implementation &nbsp;·&nbsp; ✓ Agree on delivery terms in writing
            </div>
        </div>
    </div>
</section>
