<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$faqs = [
    [
        'q' => 'Who owns the intellectual property (IP) and source code created during a project?',
        'a' => 'You do — 100%. Upon settlement of project milestones, all intellectual property, source code repositories, design assets, and database architecture belong exclusively to your company. We never retain proprietary rights, license back doors, or vendor lock-in.'
    ],
    [
        'q' => 'How does CodeX404 collaborate across international timezones?',
        'a' => 'While headquartered in India, our engineers operate on overlapping schedules with North American (EST/PST), UK/European (GMT/CET), and Middle Eastern (GST/AST) business hours. We combine clear daily asynchronous progress summaries with scheduled video sprint syncs.'
    ],
    [
        'q' => 'What is the typical timeline for an MVP or custom software deliverable?',
        'a' => 'A focused Minimum Viable Product (MVP) or custom internal portal is typically delivered within 4 to 8 weeks. Larger enterprise systems or multi-module ERP platforms are structured into two-week agile release sprints with working software deployed to staging at every step.'
    ],
    [
        'q' => 'Do you sign Non-Disclosure Agreements (NDAs) before discussing project details?',
        'a' => 'Yes, absolutely. We routinely sign bilateral NDAs before reviewing proprietary workflows, product designs, or customer datasets. Your business concepts and operational models remain strictly confidential.'
    ],
    [
        'q' => 'How do you handle post-launch maintenance, bug fixes, and system scaling?',
        'a' => 'Every deliverable includes a 30-day post-launch warranty covering any bugs or discrepancies against approved specifications. Afterwards, we offer flexible dedicated support retainers or on-demand feature development sprints.'
    ],
    [
        'q' => 'How do you prevent hallucinations and data leaks when implementing enterprise AI?',
        'a' => 'We employ Retrieval-Augmented Generation (RAG) which binds model answers strictly to verified context documents. Furthermore, we enforce deterministic JSON output schemas, strict semantic similarity thresholds, and human-in-the-loop gates for high-impact actions.'
    ]
];

$pageMeta = [
    'title' => 'Frequently Asked Questions (FAQ) — Engineering & Partnerships',
    'description' => 'Get clear answers to common questions regarding CodeX404 Solutions: intellectual property ownership, international timezones, pricing, AI safeguards, and SLAs.',
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
