<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$faqs = [
    [
        'q' => 'Who owns the intellectual property (IP) and source code created during a project?',
        'a' => 'You own 100% of all intellectual property, source code, database schemas, and design assets upon milestone completion. We provide clean Git repository transfers and deployment documentation with zero licensing fees or vendor lock-in.'
    ],
    [
        'q' => 'How does CodeX404 collaborate across international timezones?',
        'a' => 'We guarantee 4 to 5 hours of daily overlap with North American (EST/PST) and European (GMT/CET) business hours. We use asynchronous daily standups, recorded video walkthroughs, and Slack/Teams collaboration so progress never stalls.'
    ],
    [
        'q' => 'What is the typical timeline for an MVP or custom software deliverable?',
        'a' => 'Production-ready MVPs typically launch within 6 to 10 weeks, structured into two-week agile sprints. You receive working staging preview deployments every two weeks to test functioning software throughout development.'
    ],
    [
        'q' => 'Do you sign Non-Disclosure Agreements (NDAs) before discussing project details?',
        'a' => 'Yes, absolutely. We execute mutual Non-Disclosure Agreements (NDAs) prior to discussing any sensitive technical specifications, proprietary architectures, or commercial data.'
    ],
    [
        'q' => 'How do you handle post-launch maintenance, bug fixes, and system scaling?',
        'a' => 'Every deliverable includes a 30-day post-launch warranty with zero defect guarantee. Following launch, we offer flexible SLA retainers or dedicated engineering squads for continuous feature expansion and cloud infrastructure scaling.'
    ],
    [
        'q' => 'How do you prevent hallucinations and data leaks when implementing enterprise AI?',
        'a' => 'We employ Retrieval-Augmented Generation (RAG) which binds model answers strictly to verified enterprise context documents. Furthermore, we enforce deterministic JSON output schemas, strict semantic similarity thresholds, and human-in-the-loop gates for high-impact actions.'
    ]
];

$pageMeta = [
    'title' => 'Frequently Asked Questions (FAQ) — Engineering & Partnerships',
    'description' => 'Get clear answers to common questions regarding CodeX404 Solutions: intellectual property ownership, international timezones, pricing, AI safeguards, and engagement models.',
    'canonical' => url('faq.php'),
    'keywords' => 'software development FAQ, IP ownership, AI security FAQ, dedicated team questions',
    'faq' => $faqs
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container container-narrow">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Clarity First</span>
            </div>
            <h1 class="section-title">Frequently Asked Questions</h1>
            <p class="section-subtitle">
                Clear, transparent answers about our engineering process, pricing structures, IP ownership, and operational standards.
            </p>
        </div>

        <div class="faq-list">
            <?php foreach ($faqs as $faq): ?>
                <div class="faq-item">
                    <button type="button" class="faq-question" aria-expanded="false">
                        <span><?= htmlspecialchars($faq['q'], ENT_QUOTES, 'UTF-8') ?></span>
                        <span class="faq-icon">↓</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">
                            <?= htmlspecialchars($faq['a'], ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align: center; margin-top: 3.5rem; background: var(--bg-surface); padding: 2rem; border-radius: var(--radius-lg); border: 1px solid var(--border-subtle);">
            <h3 style="margin-bottom: 0.5rem;">Have a question not listed here?</h3>
            <p style="font-size: 0.95rem; margin-bottom: 1.25rem;">Our solutions architects are available to answer any technical or operational questions directly.</p>
            <a href="<?= url('contact.php') ?>" class="btn btn-secondary btn-sm">
                Ask Our Team Directly →
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
