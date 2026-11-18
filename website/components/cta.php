<?php
declare(strict_types=1);
$ctaHeading = $ctaHeading ?? 'Have a business problem software can solve?';
$ctaSubtitle = $ctaSubtitle ?? 'Let’s discuss your operational challenges, software requirements, or product ideas and identify a practical next step.';
$ctaPrimaryText = $ctaPrimaryText ?? 'Book a Discovery Call';
$ctaPrimaryUrl = $ctaPrimaryUrl ?? url('discovery-call.php');
$ctaSecondaryText = $ctaSecondaryText ?? 'Get a Technology Audit';
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

            <div class="cta-section-wrap" style="padding: 1.5rem; text-align: center;">
                <a href="<?= $ctaPrimaryUrl ?>" class="btn btn-primary btn-sm">Book a Discovery Call</a>
            </div>

            <div style="margin-top: 2rem; font-size: 0.85rem; color: var(--slate-dark);">
                ✓ Discuss the project with our team &nbsp;·&nbsp; ✓ Scope before implementation &nbsp;·&nbsp; ✓ Agree on delivery terms in writing
            </div>
        </div>
    </div>
</section>
