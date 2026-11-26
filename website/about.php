<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'About CodeX404 Solutions — Build, Grow, Automate',
    'description' => 'Learn about CodeX404 Solutions, a technology and digital solutions company helping businesses build software, grow their digital presence, and automate workflows.',
    'canonical' => url('about.php'),
    'keywords' => 'about CodeX404 Solutions, software engineering company, Muhammad Noukhez, Yousuf Ansari, technology partner'
];

require_once __DIR__ . '/includes/header.php';

$heroBreadcrumbs = [
    ['label' => 'Home', 'url' => url('index.php')],
    ['label' => 'About Us'],
];
$heroTag = 'Who We Are';
$heroTitleHtml = 'A Practical Technology Partner <span class="text-amber">Focused on Business Outcomes</span>';
$heroSubtitle = 'CodeX404 Solutions builds custom software, strengthens digital presence, and automates repetitive workflows so businesses operate with clarity and speed.';
require __DIR__ . '/includes/subpage-hero.php';
?>

<!-- WHO WE ARE, VISION & MISSION -->
<section class="section">
    <div class="container">
        <div class="grid grid-cols-2" style="gap: 2.5rem; align-items: start; margin-bottom: 4rem;">
            <div>
                <div class="section-tag"><span class="dot"></span><span>About CodeX404</span></div>
                <h2
                    style="font-size: clamp(1.75rem, 3vw, 2.25rem); margin-bottom: 1.15rem; color: var(--white); line-height: 1.25;">
                    Solving Real Business Bottlenecks With Maintainable Technology
                </h2>
                <p style="font-size: 1.02rem; line-height: 1.75; margin-bottom: 1.15rem; color: var(--slate);">
                    Businesses rarely stall because they lack another subscription tool. They stall when core workflows
                    run across disconnected spreadsheets, slow portals, manual follow-ups, and fragmented software that
                    refuses to adapt to how the company works.
                </p>
                <p style="font-size: 1.02rem; line-height: 1.75; color: var(--slate);">
                    CodeX404 Solutions works directly with founders and operations teams to understand business
                    requirements first, then design clear, secure systems with transparent milestones and direct
                    engineering accountability.
                </p>
            </div>

            <div style="display: grid; gap: 1.35rem;">
                <article class="card" style="padding: 1.75rem; border-left: 3px solid var(--electric-blue);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.65rem;">
                        <span class="inline-icon-box"><?= codex_icon('compass', 20) ?></span>
                        <h3 style="color: var(--white); font-size: 1.2rem; margin: 0;">Our Vision</h3>
                    </div>
                    <p style="font-size: 0.95rem; color: var(--slate); line-height: 1.65; margin: 0;">
                        To be a trusted long-term technology partner for growing businesses—delivering dependable
                        software, search discoverability, and practical automation without agency bloat or lock-in.
                    </p>
                </article>

                <article class="card" style="padding: 1.75rem; border-left: 3px solid var(--amber);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.65rem;">
                        <span class="inline-icon-box is-amber"><?= codex_icon('target', 20) ?></span>
                        <h3 style="color: var(--white); font-size: 1.2rem; margin: 0;">Our Mission</h3>
                    </div>
                    <p style="font-size: 0.95rem; color: var(--slate); line-height: 1.65; margin: 0;">
                        Turn operational friction into measurable efficiency by combining clean custom software
                        development, conversion-ready digital execution, and responsible AI workflows.
                    </p>
                </article>
            </div>
        </div>

        <!-- WHAT WE DO: BUILD · GROW · AUTOMATE -->
        <div class="section-header" style="margin-bottom: 2.25rem;">
            <div class="section-tag"><span class="dot"></span><span>What We Do</span></div>
            <h2 class="section-title subpage-section-title">BUILD &middot; GROW &middot; <span
                    class="text-amber">AUTOMATE</span></h2>
            <p class="section-subtitle">Three connected capabilities designed to carry a business from product
                foundation to sustainable growth and operational leverage.</p>
        </div>

        <div class="grid grid-cols-3" style="margin-bottom: 4rem;">
            <article class="card card-tilt">
                <div class="card-icon is-build"><?= codex_icon('code', 24) ?></div>
                <h3 class="card-title">BUILD &mdash; Digital Products &amp; Software</h3>
                <p class="card-description">Custom web development, SaaS platforms, CRM and ERP workflows, REST APIs,
                    and internal business applications built around your exact operations.</p>
                <a href="<?= url('build.php') ?>" class="card-arrow-link"
                    style="color: var(--cyan); font-weight: 600;">Explore BUILD &rarr;</a>
            </article>

            <article class="card card-tilt">
                <div class="card-icon is-grow"><?= codex_icon('chart', 24) ?></div>
                <h3 class="card-title">GROW &mdash; Digital Presence &amp; Reach</h3>
                <p class="card-description">SEO, answer engine optimization, conversion-focused websites, performance
                    tuning, and digital marketing foundations that attract and convert real demand.</p>
                <a href="<?= url('grow.php') ?>" class="card-arrow-link"
                    style="color: var(--teal); font-weight: 600;">Explore GROW &rarr;</a>
            </article>

            <article class="card card-tilt">
                <div class="card-icon is-automate"><?= codex_icon('workflow', 24) ?></div>
                <h3 class="card-title">AUTOMATE &mdash; AI &amp; Process Automation</h3>
                <p class="card-description">Applied generative AI, LLM and RAG knowledge tools, AI agents, and
                    cross-system workflow automation that eliminate manual busywork safely.</p>
                <a href="<?= url('automate.php') ?>" class="card-arrow-link"
                    style="color: var(--amber); font-weight: 600;">Explore AUTOMATE &rarr;</a>
            </article>
        </div>

        <!-- OUR APPROACH & ENGINEERING PHILOSOPHY -->
        <div class="grid grid-cols-2" style="gap: 2.5rem; align-items: stretch;">
            <div class="card" style="padding: 2.25rem;">
                <span class="tag-chip"
                    style="margin-bottom: 1rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.35);">Our
                    Approach</span>
                <h3 style="color: var(--white); font-size: 1.35rem; margin-bottom: 1rem;">How We Work With Clients</h3>
                <p style="font-size: 0.95rem; color: var(--slate); line-height: 1.7; margin-bottom: 1rem;">
                    Every project starts with a direct technical conversation to clarify goals, constraints, data
                    structure, and user roles before committing to code.
                </p>
                <p style="font-size: 0.95rem; color: var(--slate); line-height: 1.7; margin: 0;">
                    We deliver work in structured sprint milestones on testable staging environments so stakeholders
                    review real progress continuously rather than waiting until launch day.
                </p>
            </div>

            <div class="card" style="padding: 2.25rem;">
                <span class="tag-chip"
                    style="margin-bottom: 1rem; color: var(--amber); border-color: rgba(255, 140, 0, 0.35);">Engineering
                    Philosophy</span>
                <h3 style="color: var(--white); font-size: 1.35rem; margin-bottom: 1.25rem;">Principles Behind Every
                    System</h3>
                <ul class="transform-list" style="display: flex; flex-direction: column; gap: 1rem;">
                    <li style="display: flex; gap: 0.85rem; align-items: flex-start;">
                        <span style="color: var(--cyan); font-weight: 800;">01</span>
                        <span><strong style="color: var(--white);">Clean, Defensive Code:</strong> Parameterized
                            queries, strict input validation, and clear maintainable structure over brittle
                            shortcuts.</span>
                    </li>
                    <li style="display: flex; gap: 0.85rem; align-items: flex-start;">
                        <span style="color: var(--cyan); font-weight: 800;">02</span>
                        <span><strong style="color: var(--white);">Direct Engineer Access:</strong> Collaborate directly
                            with the engineers scoping and writing your software—no game of telephone.</span>
                    </li>
                    <li style="display: flex; gap: 0.85rem; align-items: flex-start;">
                        <span style="color: var(--cyan); font-weight: 800;">03</span>
                        <span><strong style="color: var(--white);">Written Ownership Terms:</strong> Source code,
                            schemas, and project handoff terms agreed transparently before delivery.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- LEADERSHIP COMPONENT -->
<?php include __DIR__ . '/components/leadership.php'; ?>

<!-- WHY WORK WITH US / COLLABORATION REGIONS -->
<section class="section"
    style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.15rem auto;">
                <span class="dot"></span>
                <span>Why Work With Us</span>
            </div>
            <h2 class="section-title subpage-section-title">Clear Timezone Overlap &amp; <span
                    class="text-amber">Asynchronous Discipline</span></h2>
            <p class="section-subtitle">
                Engineered in India for clients across timezones, using structured written updates, staging previews,
                and scheduled overlap hours.
            </p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card" style="text-align: center; padding: 2rem;">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">North America</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6;">Scheduled EST/PST overlap windows
                    supported by clear sprint notes and staging previews.</p>
            </div>
            <div class="card" style="text-align: center; padding: 2rem;">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">UK &amp; Europe</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6;">Afternoon GMT/CET overlap for
                    sprint reviews, privacy-conscious design, and direct founder access.</p>
            </div>
            <div class="card" style="text-align: center; padding: 2rem;">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">Middle East &amp; GCC</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6;">Close GST/AST business-hour
                    alignment for rapid feedback cycles and iterative releases.</p>
            </div>
            <div class="card" style="text-align: center; padding: 2rem;">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.65rem;">India &amp; APAC</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6;">Same-day collaboration across
                    regional teams for custom applications, growth, and automation.</p>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Let's Build Something Practical Together";
$ctaSubtitle = "Share your operational workflow, product idea, or growth goals and let's map out a realistic next step.";
$ctaSecondaryText = "Explore Services";
$ctaSecondaryUrl = url('solutions.php');
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>