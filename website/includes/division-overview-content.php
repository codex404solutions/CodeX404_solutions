<?php
declare(strict_types=1);

require_once __DIR__ . '/header.php';
$escape = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
render_json_ld_faq($division['faqs']);
$divisionContactUrl = url('contact.php') . '?division=' . rawurlencode($division['code']);
$divisionDiscoveryUrl = url('discovery-call.php') . '?division=' . rawurlencode($division['code']);
?>
$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Services', 'url' => url('solutions.php')],
    ['label' => $division['code']],
];
$heroTag = $division['eyebrow'];
$heroTitleHtml = $escape($division['title']);
$heroSubtitle = $division['intro'];
$heroActions = [
    ['label' => 'Discuss Your ' . $division['code'] . ' Project', 'url' => $divisionDiscoveryUrl, 'variant' => 'primary'],
    ['label' => 'Contact Our Team', 'url' => $divisionContactUrl, 'variant' => 'secondary'],
];
require __DIR__ . '/subpage-hero.php';
?>
<section class="section">
    <div class="container">
        <div class="grid grid-cols-3">
            <?php
            $iconMap = [
                'BUILD' => ['code', 'layers', 'smartphone'],
                'GROW' => ['search', 'target', 'chart'],
                'AUTOMATE' => ['cpu', 'bot', 'workflow'],
            ];
            $toneClass = match ($division['code']) {
                'GROW' => 'is-grow',
                'AUTOMATE' => 'is-automate',
                default => 'is-build',
            };
            ?>
            <?php foreach ($division['services'] as $idx => $service): ?>
                <?php $iconKey = $iconMap[$division['code']][$idx % 3] ?? 'layers'; ?>
                <article class="card card-tilt reveal-on-scroll reveal-delay-<?= ($idx % 3) ?>">
                    <div class="card-icon <?= $toneClass ?>"><?= codex_icon($iconKey, 24) ?></div>
                    <h2><?= $escape($service['title']) ?></h2>
                    <p><?= $escape($service['description']) ?></p>
                    <?php if (!empty($service['url'])): ?>
                        <a class="btn btn-secondary btn-sm" href="<?= $escape(url($service['url'])) ?>">Explore this service <span aria-hidden="true">&rarr;</span></a>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container grid grid-cols-2 division-context-grid">
        <article class="card division-context-card">
            <h2>Who this is for</h2>
            <p><?= $escape($division['audience']) ?></p>
        </article>
        <article class="card division-context-card">
            <h2>Problems we can explore</h2>
            <ul class="division-bullet-list">
                <?php foreach ($division['problems'] as $problem): ?>
                    <li><?= $escape($problem) ?></li>
                <?php endforeach; ?>
            </ul>
        </article>
    </div>
</section>

<section class="section section-alt">
    <div class="container grid grid-cols-2" style="align-items: start; gap: 3rem;">
        <div>
            <div class="section-tag"><span class="dot"></span><span>How we work</span></div>
            <h2 class="section-title" style="text-align: left;">A clear path from brief to delivery</h2>
            <p class="section-subtitle" style="text-align: left; margin-left: 0;">We define the problem and scope together, agree on deliverables, then share progress through reviewable work.</p>
        </div>
        <ol class="division-steps">
            <?php foreach ($division['steps'] as $index => $step): ?>
                <li><span class="division-step-number"><?= (int)$index + 1 ?></span><div><h3><?= $escape($step['title']) ?></h3><p><?= $escape($step['description']) ?></p></div></li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag"><span class="dot"></span><span>Illustrative applications</span></div>
            <h2 class="section-title">Architectural Patterns &amp; Deliverables</h2>
            <p class="section-subtitle">Practical architectural patterns and production deliverables engineered across this division.</p>
        </div>
        <div class="grid grid-cols-3">
            <?php foreach ($division['examples'] as $idx => $example): ?>
                <article class="card division-example-card card-tilt reveal-on-scroll reveal-delay-<?= ($idx % 3) ?>">
                    <h3><?= $escape($example['title']) ?></h3>
                    <p><?= $escape($example['description']) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container container-narrow">
        <div class="section-header">
            <div class="section-tag"><span class="dot"></span><span>Frequently asked questions</span></div>
            <h2 class="section-title">Questions about <?= $escape($division['code']) ?></h2>
        </div>
        <div class="division-faq-list">
            <?php foreach ($division['faqs'] as $faq): ?>
                <details class="division-faq-item">
                    <summary><?= $escape($faq['q']) ?></summary>
                    <p><?= $escape($faq['a']) ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container container-narrow">
        <div class="section-header">
            <div class="section-tag"><span class="dot"></span><span>Start a conversation</span></div>
            <h2 class="section-title">Ready to Architect Your Solution?</h2>
            <p class="section-subtitle">Share your project requirements, tech stack, and goals. We will provide architectural recommendations and a clear milestone roadmap.</p>
            <div class="hero-actions" style="justify-content: center;">
                <a class="btn btn-primary" href="<?= $escape($divisionContactUrl) ?>">Contact the team <span aria-hidden="true">→</span></a>
                <a class="btn btn-secondary" href="<?= $escape($divisionDiscoveryUrl) ?>">Request a Discovery Call</a>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/footer.php'; ?>
