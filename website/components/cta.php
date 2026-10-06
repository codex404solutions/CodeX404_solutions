<?php
declare(strict_types=1);
$ctaHeading = $ctaHeading ?? 'Have a business problem software can solve?';
$ctaSubtitle = $ctaSubtitle ?? 'Let’s turn operational friction, manual workflows, or unvalidated SaaS ideas into resilient, production-ready software.';
$ctaPrimaryText = $ctaPrimaryText ?? 'Book a Discovery Call';
$ctaPrimaryUrl = $ctaPrimaryUrl ?? url('discovery-call.php');
$ctaSecondaryText = $ctaSecondaryText ?? 'Get a Technology Audit';
$ctaSecondaryUrl = $ctaSecondaryUrl ?? url('contact.php');
?>
<section class="section" style="position: relative; overflow: hidden;">
    <div class="container">
        <div style="background: radial-gradient(ellipse 100% 100% at 50% -20%, rgba(37, 99, 235, 0.25), rgba(11, 31, 58, 0.95)), var(--bg-surface); border: 1px solid var(--border-highlight); border-radius: var(--radius-lg); padding: clamp(2.5rem, 5vw, 4.5rem) clamp(1.5rem, 4vw, 3.5rem); text-align: center; box-shadow: var(--shadow-lg), 0 0 60px rgba(37, 99, 235, 0.2); position: relative;">
            
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

            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="<?= $ctaPrimaryUrl ?>" class="btn btn-primary btn-lg">
                    <?= htmlspecialchars($ctaPrimaryText, ENT_QUOTES, 'UTF-8') ?>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
                <a href="<?= $ctaSecondaryUrl ?>" class="btn btn-secondary btn-lg">
                    <?= htmlspecialchars($ctaSecondaryText, ENT_QUOTES, 'UTF-8') ?>
                </a>
            </div>

            <div style="margin-top: 2rem; font-size: 0.85rem; color: var(--slate-dark);">
                ✓ Direct consultation with Solutions Architect &nbsp;·&nbsp; ✓ Zero pushy sales tactics &nbsp;·&nbsp; ✓ Response within 24 business hours
            </div>
        </div>
    </div>
</section>
