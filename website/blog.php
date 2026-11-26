<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';

$articles = [
    'booking-concurrency' => [
        'slug' => 'booking-concurrency',
        'category' => 'Software Development',
        'pillar' => 'BUILD',
        'read_time' => '7 min read',
        'title' => 'Engineering Booking Engines Without Double-Booking Collisions',
        'excerpt' => 'How database transactions, slot locking, and clean validation rules prevent appointment collisions across clinics, salons, and hospitality teams.',
        'tags' => ['Booking Architecture', 'MySQL Transactions', 'Concurrency'],
        'body' => [
            'Appointment-heavy businesses lose trust immediately when two clients reserve the exact same chair, practitioner, or table slot at the same moment.',
            'Checking availability with a naive SELECT query before running an INSERT fails under concurrent traffic. Two requests read the same free slot simultaneously and both succeed.',
            'Practical prevention relies on atomic uniqueness constraints combined with transactional row locking—ensuring the database itself arbitrates slot ownership cleanly.',
        ],
        'takeaways' => [
            'Back UI slot pickers with database-level uniqueness constraints or locked transactions.',
            'Separate pending payment holds from confirmed reservations with clear expiry timers.',
            'Log cancellation and reschedule events cleanly for front-desk staff auditing.',
        ],
    ],
    'mvp-core-loop' => [
        'slug' => 'mvp-core-loop',
        'category' => 'SaaS & Product',
        'pillar' => 'BUILD',
        'read_time' => '6 min read',
        'title' => 'Scoping SaaS MVPs Without Creating Maintainability Debt',
        'excerpt' => 'How to prioritize the single operational feedback loop that proves user value before adding secondary dashboards and preferences.',
        'tags' => ['SaaS MVPs', 'Scope Control', 'Modular Design'],
        'body' => [
            'Most stalled software launches share one root cause: trying to build an administrative swiss-army knife before validating the primary user workflow.',
            'Scoping around a single core loop lets teams validate real customer onboarding, role boundaries, and data integrity early while leaving clean seams for v2 features.',
            'Good MVP engineering is not disposable code—it is disciplined scope paired with normalized schemas and clean access controls.',
        ],
        'takeaways' => [
            'Identify the single repeatable action that drives primary user value first.',
            'Invest upfront in clean data models and authentication rather than UI embellishments.',
            'Release testable milestones in staging every sprint to surface assumptions early.',
        ],
    ],
    'whatsapp-lead-routing' => [
        'slug' => 'whatsapp-lead-routing',
        'category' => 'AI & Automation',
        'pillar' => 'AUTOMATE',
        'read_time' => '8 min read',
        'title' => 'Connecting Web Forms & WhatsApp Webhooks With Human Oversight',
        'excerpt' => 'Designing lead capture and messaging pipelines that respond quickly, avoid duplicate entries, and preserve transparent audit logs.',
        'tags' => ['WhatsApp Cloud API', 'Webhooks', 'Workflow Automation'],
        'body' => [
            'Lead response delays cost real deals, yet brittle automation scripts frequently drop payloads silently or spam prospects when webhooks retry.',
            'Using official webhook APIs paired with idempotency keys, server-side validation, and explicit escalation checkpoints makes automated outreach predictable.',
            'High-value or ambiguous customer messages should route cleanly to human staff with full context rather than trapping prospects in endless bot loops.',
        ],
        'takeaways' => [
            'Use official Meta WhatsApp Cloud API webhooks rather than fragile browser scraping.',
            'Store inbound payloads idempotently so network retries never create duplicate tickets.',
            'Always keep a clear path to hand conversations directly to human team members.',
        ],
    ],
    'private-rag-systems' => [
        'slug' => 'private-rag-systems',
        'category' => 'Business Technology',
        'pillar' => 'AUTOMATE',
        'read_time' => '9 min read',
        'title' => 'Practical Retrieval-Augmented Generation (RAG) for Internal Docs',
        'excerpt' => 'Structuring chunking, vector search, similarity thresholds, and source citations so business AI stays anchored to approved material.',
        'tags' => ['RAG Systems', 'Vector Search', 'Qdrant / pgvector'],
        'body' => [
            'Out-of-the-box language models sound confident even when guessing about internal company policies, product rules, or client contracts.',
            'Effective business RAG pairs structured document ingestion and hybrid lexical/vector retrieval with minimum similarity thresholds and mandatory source citations.',
            'When approved documentation does not contain the answer, a well-engineered assistant states that gap honestly instead of inventing details.',
        ],
        'takeaways' => [
            'Enforce permission filtering during retrieval—not merely after generation.',
            'Require linked citations so staff verify source text in one click.',
            'Use structured output schemas whenever downstream workflows parse model results.',
        ],
    ],
    'search-and-conversion' => [
        'slug' => 'search-and-conversion',
        'category' => 'Digital Transformation',
        'pillar' => 'GROW',
        'read_time' => '6 min read',
        'title' => 'Turning Static Company Websites Into Clear Conversion Engines',
        'excerpt' => 'How technical SEO, clear positioning, page performance, and purposeful CTAs work together across B2B service and product sites.',
        'tags' => ['SEO & AEO', 'Conversion UX', 'Web Performance'],
        'body' => [
            'Traffic without clarity rarely produces qualified inquiries. Visitors decide within seconds whether your site explains what you build, who benefits, and how to start.',
            'Clean semantic headings, structured Schema.org metadata, fast mobile layouts, and honest problem-solution framing align search engines and real buyers simultaneously.',
            'Connecting landing pages cleanly into CRM tracking closes the loop between discovery clicks and real project conversations.',
        ],
        'takeaways' => [
            'Answer what you offer, who it helps, and the next action clearly above the fold.',
            'Pair technical SEO hygiene with structured FAQ and service metadata.',
            'Keep mobile layouts light, readable, and effortless to submit inquiries from.',
        ],
    ],
];

$requestedSlug = trim((string)($_GET['brief'] ?? ''));
$activeArticle = $requestedSlug !== '' && isset($articles[$requestedSlug]) ? $articles[$requestedSlug] : null;

if ($activeArticle) {
    $pageMeta = [
        'title' => $activeArticle['title'] . ' | CodeX404 Solutions Insights',
        'description' => $activeArticle['excerpt'],
        'canonical' => url('blog.php?brief=' . urlencode($activeArticle['slug'])),
    ];
} else {
    $pageMeta = [
        'title' => 'Engineering Insights & Resources | CodeX404 Solutions',
        'description' => 'Practical notes on software development, SaaS architecture, AI automation, digital transformation, and business technology by CodeX404 Solutions.',
        'canonical' => url('blog.php'),
        'keywords' => 'software engineering insights, AI automation notes, SaaS architecture, business technology'
    ];
}

require_once __DIR__ . '/includes/header.php';
?>

<?php if ($activeArticle): ?>
    <?php
    $heroBreadcrumbs = [
        ['label' => 'Home', 'url' => url('index.php')],
        ['label' => 'Insights', 'url' => url('blog.php')],
        ['label' => $activeArticle['category']],
    ];
    $heroTag = $activeArticle['pillar'] . ' · ' . $activeArticle['category'] . ' · ' . $activeArticle['read_time'];
    $heroTitleHtml = htmlspecialchars($activeArticle['title'], ENT_QUOTES, 'UTF-8');
    $heroSubtitle = $activeArticle['excerpt'];
    require __DIR__ . '/includes/subpage-hero.php';
    ?>

    <section class="section">
        <div class="container">
            <article class="article-reader-shell">
                <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; padding-bottom: 1.25rem; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.08); font-size: 0.85rem; color: var(--slate-dark);">
                    <span>Published by <strong style="color: var(--white);">CodeX404 Solutions Engineering</strong></span>
                    <span>Focus: <strong style="color: var(--cyan);"><?= htmlspecialchars($activeArticle['pillar'] . ' · ' . $activeArticle['read_time'], ENT_QUOTES, 'UTF-8') ?></strong></span>
                </div>

                <?php foreach ($activeArticle['body'] as $para): ?>
                    <p><?= htmlspecialchars($para, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endforeach; ?>

                <h2>Key Engineering Takeaways</h2>
                <ul>
                    <?php foreach ($activeArticle['takeaways'] as $point): ?>
                        <li><?= htmlspecialchars($point, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>

                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.08);">
                    <?php foreach ($activeArticle['tags'] as $tag): ?>
                        <span class="tag-chip"><?= htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') ?></span>
                    <?php endforeach; ?>
                </div>
            </article>

            <!-- Related Articles -->
            <div style="max-width: 980px; margin: 3.5rem auto 0;">
                <h3 style="color: var(--white); font-size: 1.3rem; margin-bottom: 1.25rem;">More Engineering Insights</h3>
                <div class="grid grid-cols-2" style="gap: 1.5rem;">
                    <?php
                    $related = array_slice(array_filter($articles, fn($a) => $a['slug'] !== $activeArticle['slug']), 0, 2);
                    foreach ($related as $rel): ?>
                        <a href="<?= url('blog.php?brief=' . urlencode($rel['slug'])) ?>" class="card" style="text-decoration: none; display: block;">
                            <span style="font-size: 0.78rem; color: var(--cyan); font-weight: 700; display: block; margin-bottom: 0.4rem;"><?= htmlspecialchars($rel['pillar'] . ' · ' . $rel['read_time'], ENT_QUOTES, 'UTF-8') ?></span>
                            <h4 style="color: var(--white); font-size: 1.1rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($rel['title'], ENT_QUOTES, 'UTF-8') ?></h4>
                            <p style="font-size: 0.88rem; color: var(--slate); margin: 0;"><?= htmlspecialchars($rel['excerpt'], ENT_QUOTES, 'UTF-8') ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

<?php else: ?>
    <?php
    $heroBreadcrumbs = [
        ['label' => 'Home', 'url' => url('index.php')],
        ['label' => 'Resources'],
        ['label' => 'Engineering Insights'],
    ];
    $heroTag = 'AI · Software · SaaS · Business Tech';
    $heroTitleHtml = 'Engineering &amp; Strategy <span class="text-gradient gradient-text-animated">Insights</span>';
    $heroSubtitle = 'Practical architectural notes from CodeX404 Solutions on software reliability, SaaS scoping, grounded AI workflows, and digital conversion.';
    require __DIR__ . '/includes/subpage-hero.php';
    ?>

    <section class="section">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 320px), 1fr)); gap: 1.75rem;">
                <?php foreach ($articles as $art): ?>
                    <article class="clean-project-card card-tilt" style="padding: 2rem; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div class="cpc-header" style="margin-bottom: 1rem;">
                                <span class="cpc-category"><?= htmlspecialchars($art['category'], ENT_QUOTES, 'UTF-8') ?></span>
                                <span class="cpc-badge"><span class="cpc-dot"></span><?= htmlspecialchars($art['read_time'], ENT_QUOTES, 'UTF-8') ?></span>
                            </div>
                            <h2 style="font-size: 1.28rem; font-weight: 800; color: #FFFFFF; margin-bottom: 0.8rem; line-height: 1.35;">
                                <a href="<?= url('blog.php?brief=' . urlencode($art['slug'])) ?>" style="color: inherit; text-decoration: none;">
                                    <?= htmlspecialchars($art['title'], ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </h2>
                            <p style="color: var(--slate); font-size: 0.93rem; line-height: 1.65; margin-bottom: 1.35rem;">
                                <?= htmlspecialchars($art['excerpt'], ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>
                        <div>
                            <div class="cpc-tags" style="margin-bottom: 1.15rem;">
                                <?php foreach ($art['tags'] as $tag): ?>
                                    <span class="cpc-tag"><?= htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') ?></span>
                                <?php endforeach; ?>
                            </div>
                            <a href="<?= url('blog.php?brief=' . urlencode($art['slug'])) ?>" style="color: var(--cyan); font-size: 0.88rem; font-weight: 600; text-decoration: none;">
                                Read Brief &rarr;
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php
$ctaHeading = "Need Architectural Feedback Before Building?";
$ctaSubtitle = "Book a discovery call to discuss your system design, integration risks, and realistic milestones.";
include __DIR__ . '/components/cta.php';
require_once __DIR__ . '/includes/footer.php';
