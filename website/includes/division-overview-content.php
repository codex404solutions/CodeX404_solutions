<?php
declare(strict_types=1);

require_once __DIR__ . '/header.php';
$escape = static fn (string $value): string => htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
render_json_ld_faq($division['faqs']);
$divisionContactUrl = url('contact.php') . '?division=' . rawurlencode($division['code']);
$divisionDiscoveryUrl = url('discovery-call.php') . '?division=' . rawurlencode($division['code']);
?>
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag"><span class="dot"></span><span><?= $escape($division['eyebrow']) ?></span></div>
            <h1 class="section-title"><?= $escape($division['title']) ?></h1>
            <p class="section-subtitle"><?= $escape($division['intro']) ?></p>
        </div>

        <div class="grid grid-cols-3">
            <?php foreach ($division['services'] as $idx => $service): ?>
                <article class="card card-tilt reveal-on-scroll reveal-delay-<?= ($idx % 3) ?>">
                    <div class="card-icon" aria-hidden="true"><?= $escape($service['icon']) ?></div>
                    <h2><?= $escape($service['title']) ?></h2>
                    <p><?= $escape($service['description']) ?></p>
                    <?php if (!empty($service['url'])): ?>
                        <a class="btn btn-secondary btn-sm" href="<?= $escape(url($service['url'])) ?>">Explore this service <span aria-hidden="true">→</span></a>
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
            <h2 class="section-title">Examples of work that can be scoped</h2>
            <p class="section-subtitle">These are general examples to make the service areas concrete. They are not client case studies or claims about live integrations.</p>
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
            <h2 class="section-title">Tell us what you need to move forward</h2>
            <p class="section-subtitle">Share your goals, current setup, and constraints. We can discuss a practical next step and define scope before work begins.</p>
            <div class="hero-actions" style="justify-content: center;">
                <a class="btn btn-primary" href="<?= $escape($divisionContactUrl) ?>">Contact the team <span aria-hidden="true">→</span></a>
                <a class="btn btn-secondary" href="<?= $escape($divisionDiscoveryUrl) ?>">Request a Discovery Call</a>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/footer.php'; ?>
