<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Engagement Models — Flexible Partnership Structures',
    'description' => 'Explore CodeX404 Solutions engagement models: Dedicated Engineering Squads, Fixed-Scope Sprint Deliverables, and Fractional CTO & AI Architecture.',
    'canonical' => url('engagement-models.php'),
    'keywords' => 'engagement models, dedicated engineering team, fixed scope software development, fractional CTO'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Collaboration Frameworks</span>
            </div>
            <h1 class="section-title">Transparent, Flexible Engagement Models</h1>
            <p class="section-subtitle">
                Whether you need a full turnkey product delivered to specification, dedicated engineering capacity for your roadmap, or high-level architecture leadership — we have a partnership structure tailored to your needs.
            </p>
        </div>

        <div class="grid grid-cols-3">
            <!-- Model 1 -->
            <div class="card card-tilt reveal-on-scroll" style="border-top: 4px solid var(--electric-blue);">
                <span class="tag-chip" style="margin-bottom: 1rem; width: fit-content; color: var(--cyan);">Turnkey Delivery</span>
                <h2 class="card-title">Fixed-Scope Milestone Project</h2>
                <p class="card-description">
                    Best for clearly defined projects, MVPs, automation builds, or specific modules with unambiguous requirements.
                </p>
                <div style="margin: 1.5rem 0; border-top: 1px solid var(--border-subtle); padding-top: 1.25rem;">
                    <ul class="transform-list">
                        <li><span style="color: #34D399;">✓</span> Fixed pricing & guaranteed milestone roadmaps</li>
                        <li><span style="color: #34D399;">✓</span> Working staging demo deployed every two weeks</li>
                        <li><span style="color: #34D399;">✓</span> 30-day post-launch warranty with zero defect guarantee</li>
                        <li><span style="color: #34D399;">✓</span> 100% intellectual property & source code ownership</li>
                    </ul>
                </div>
                <a href="<?= url('discovery-call.php') ?>" class="btn btn-secondary btn-sm" style="width: 100%; margin-top: auto;">
                    Scope a Project
                </a>
            </div>

            <!-- Model 2 -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1" style="border-top: 4px solid var(--cyan); background: var(--bg-surface-elevated); box-shadow: var(--shadow-md);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <span class="tag-chip" style="color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Most Popular</span>
                    <span style="font-size: 0.75rem; color: #34D399; font-weight: 700;">HIGH VELOCITY</span>
                </div>
                <h2 class="card-title">Dedicated Agile Squad</h2>
                <p class="card-description">
                    Best for growing companies and funded startups needing continuous development velocity and feature delivery without hiring overhead.
                </p>
                <div style="margin: 1.5rem 0; border-top: 1px solid var(--border-subtle); padding-top: 1.25rem;">
                    <ul class="transform-list">
                        <li><span style="color: #34D399;">✓</span> Full-stack developers, QA & architect</li>
                        <li><span style="color: #34D399;">✓</span> Direct Slack / Teams daily integration</li>
                        <li><span style="color: #34D399;">✓</span> Bi-weekly sprint demos & planning</li>
                        <li><span style="color: #34D399;">✓</span> Flexible monthly capacity with zero long-term lock-in</li>
                    </ul>
                </div>
                <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-sm" style="width: 100%; margin-top: auto;">
                    Hire an Agile Squad
                </a>
            </div>

            <!-- Model 3 -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2" style="border-top: 4px solid var(--violet);">
                <span class="tag-chip" style="margin-bottom: 1rem; width: fit-content; color: var(--soft-violet);">Strategic Leadership</span>
                <h2 class="card-title">Fractional CTO & AI Architect</h2>
                <p class="card-description">
                    Best for non-technical founders or executives needing strategic architectural validation, vendor audits, and AI feasibility assessments.
                </p>
                <div style="margin: 1.5rem 0; border-top: 1px solid var(--border-subtle); padding-top: 1.25rem;">
                    <ul class="transform-list">
                        <li><span style="color: #34D399;">✓</span> Architecture review & code audits</li>
                        <li><span style="color: #34D399;">✓</span> AI / LLM feasibility & cost modeling</li>
                        <li><span style="color: #34D399;">✓</span> Technical hiring & vendor evaluation</li>
                        <li><span style="color: #34D399;">✓</span> Flexible monthly retainer hours</li>
                    </ul>
                </div>
                <a href="<?= url('discovery-call.php') ?>" class="btn btn-secondary btn-sm" style="width: 100%; margin-top: auto;">
                    Consult an Architect
                </a>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to choose the right engagement model?";
$ctaSubtitle = "Let's review your product roadmap and recommend the most cost-effective structure for your stage.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
