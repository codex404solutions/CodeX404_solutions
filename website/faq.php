<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$faqs = [
    [
        'q' => 'Who owns the intellectual property (IP) and source code created during a project?',
        'a' => 'Ownership, repository access, and licensing terms are confirmed in writing for every project so you retain control of custom deliverables upon agreed milestone completion without hidden platform rent.'
    ],
    [
        'q' => 'How does CodeX404 collaborate across international timezones?',
        'a' => 'Operating from India, we align scheduled communication windows with clients across APAC, the Middle East, UK/Europe, and North America—paired with written sprint updates and reviewable staging deployments.'
    ],
    [
        'q' => 'What is a realistic timeline for an MVP or custom software build?',
        'a' => 'Timeline depends directly on functional scope, integrations, and approval speed. Most focused portals and MVPs are structured into iterative milestone sprints with working staging previews throughout development.'
    ],
    [
        'q' => 'Do you sign Non-Disclosure Agreements (NDAs) before reviewing specifications?',
        'a' => 'Yes. We execute mutual confidentiality agreements prior to reviewing sensitive commercial requirements, internal data samples, or proprietary workflows.'
    ],
    [
        'q' => 'How do you handle post-launch fixes and ongoing updates?',
        'a' => 'Production launches include a 30-day post-launch defect support window covering bugs within agreed scope, plus optional retainers for ongoing features, SEO improvements, and automation expansion.'
    ],
    [
        'q' => 'How do you keep business AI and RAG systems accurate and controlled?',
        'a' => 'We bind responses to indexed approved documents, apply similarity thresholds so missing context is acknowledged honestly, validate structured schemas, and keep sensitive write actions behind human review gates.'
    ]
];

$pageMeta = [
    'title' => 'Frequently Asked Questions (FAQ) | CodeX404 Solutions',
    'description' => 'Answers about CodeX404 Solutions engineering workflow, IP ownership, timezone collaboration, pricing scopes, post-launch support, and AI safeguards.',
    'canonical' => url('faq.php'),
    'keywords' => 'software development FAQ, IP ownership, AI security FAQ, CodeX404 process',
    'faq' => $faqs
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'Support'],
    ['label' => 'FAQ'],
];
$heroTag = 'Clarity First';
$heroTitleHtml = 'Frequently Asked <span class="text-gradient">Questions</span>';
$heroSubtitle = 'Direct answers regarding project scoping, code ownership, communication rhythm, security boundaries, and post-launch support.';
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container container-narrow">
        <div class="faq-list">
            <?php foreach ($faqs as $faq): ?>
                <div class="faq-item">
                    <button type="button" class="faq-question" aria-expanded="false">
                        <span><?= htmlspecialchars($faq['q'], ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="faq-icon" aria-hidden="true">&darr;</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <?= htmlspecialchars($faq['a'], ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="card" style="text-align: center; margin-top: 3rem; padding: 2rem;">
            <h2 style="font-size: 1.35rem; color: var(--white); margin-bottom: 0.5rem;">Have a Question Not Covered Here?</h2>
            <p style="font-size: 0.95rem; color: var(--slate); margin-bottom: 1.25rem;">Reach out directly to discuss your technical requirements, timeline, or partnership inquiry.</p>
            <a href="<?= url('contact.php') ?>" class="btn btn-primary btn-sm">Let's Discuss Your Project &rarr;</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
