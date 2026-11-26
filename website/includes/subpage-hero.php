<?php
declare(strict_types=1);

/**
 * Shared Sub-Page Header Component
 * Mirrors the homepage's dark navy constellation backdrop, .section-tag pill,
 * uppercase bold headline with .text-amber highlight, and center-lit divider
 * without altering or cloning the homepage 3D terminal hero.
 *
 * Expected optional variables before include:
 * - string $heroTag         Pill tag text
 * - string $heroTitleHtml   Pre-escaped HTML for H1 (allows <span class="text-amber"> accents)
 * - string $heroSubtitle    Plain text subtitle
 * - array  $heroActions     Optional buttons [['label' => ..., 'url' => ..., 'variant' => 'primary'|'secondary'|'outline']]
 * - string $heroExtraHtml   Optional trusted HTML rendered below actions inside .subpage-hero-inner
 * - string $heroClass       Optional extra class(es) on section.subpage-hero
 */
$heroBreadcrumbs = $heroBreadcrumbs ?? [];
$heroTag = $heroTag ?? '';
$heroTitleHtml = $heroTitleHtml ?? '';
$heroSubtitle = $heroSubtitle ?? '';
$heroActions = $heroActions ?? [];
$heroExtraHtml = $heroExtraHtml ?? '';
$heroClass = trim((string) ($heroClass ?? ''));
?>
<section class="subpage-hero<?= $heroClass !== '' ? ' ' . htmlspecialchars($heroClass, ENT_QUOTES, 'UTF-8') : '' ?>">
    <div class="container">
        <div class="subpage-hero-inner">
            <?php if ($heroTag !== ''): ?>
                <div class="section-tag subpage-tag">
                    <span class="dot"></span>
                    <span><?= htmlspecialchars($heroTag, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            <?php endif; ?>

            <?php if ($heroTitleHtml !== ''): ?>
                <h1 class="subpage-title"><?= $heroTitleHtml ?></h1>
            <?php endif; ?>

            <?php if ($heroSubtitle !== ''): ?>
                <p class="subpage-subtitle"><?= htmlspecialchars($heroSubtitle, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>

            <?php if (!empty($heroActions)): ?>
                <div class="subpage-hero-actions">
                    <?php foreach ($heroActions as $act): ?>
                        <?php $variant = htmlspecialchars((string) ($act['variant'] ?? 'primary'), ENT_QUOTES, 'UTF-8'); ?>
                        <a href="<?= htmlspecialchars((string) $act['url'], ENT_QUOTES, 'UTF-8') ?>"
                            class="btn btn-<?= $variant ?> btn-lg">
                            <span><?= htmlspecialchars((string) $act['label'], ENT_QUOTES, 'UTF-8') ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($heroExtraHtml !== ''): ?>
                <?= $heroExtraHtml ?>
            <?php endif; ?>
        </div>
    </div>
</section>