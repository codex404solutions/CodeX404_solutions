<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Our 7-Stage Project Delivery Process',
    'description' => 'See the project stages CodeX404 may use for discovery, planning, design, implementation, testing, launch preparation, and ongoing support.',
    'canonical' => url('process.php'),
    'keywords' => 'software development process, agile engineering, software delivery lifecycle, QA testing process'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Engineering Discipline</span>
            </div>
            <h1 class="section-title">The 7-Stage Delivery Framework</h1>
            <p class="section-subtitle">
                Disciplined, transparent software engineering from initial concept to high-scale production. Every milestone is defined, measured, and verified on live staging environments.
            </p>
        </div>

        <!-- Enterprise Compliance & Methodology Badges -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; max-width: 980px; margin: 0 auto 3.5rem auto;">
            <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 0.85rem;">
                <span style="font-size: 1.5rem;">⏱️</span>
                <div>
                    <strong style="color: var(--white); font-size: 0.9rem; display: block;">Bi-Weekly Scrum</strong>
                    <span style="font-size: 0.8rem; color: var(--slate);">Live demo every 14 days</span>
                </div>
            </div>
            <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 0.85rem;">
                <span style="font-size: 1.5rem;">🛡️</span>
                <div>
                    <strong style="color: var(--white); font-size: 0.9rem; display: block;">OWASP Top 10</strong>
                    <span style="font-size: 0.8rem; color: var(--slate);">Defensive vulnerability guard</span>
                </div>
            </div>
            <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 0.85rem;">
                <span style="font-size: 1.5rem;">🇪🇺</span>
                <div>
                    <strong style="color: var(--white); font-size: 0.9rem; display: block;">GDPR Aligned</strong>
                    <span style="font-size: 0.8rem; color: var(--slate);">Data privacy &amp; audit trails</span>
                </div>
            </div>
            <div style="background: var(--bg-surface); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.25rem 1.5rem; display: flex; align-items: center; gap: 0.85rem;">
                <span style="font-size: 1.5rem;">🌿</span>
                <div>
                    <strong style="color: var(--white); font-size: 0.9rem; display: block;">Atomic CI/CD</strong>
                    <span style="font-size: 0.8rem; color: var(--slate);">Zero-downtime Git releases</span>
                </div>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 2.5rem; max-width: 980px; margin: 0 auto;">
            <!-- Step 1 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">01</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Discover & Unpack Friction</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We audit your operational workflows, user journeys, existing data models, and business objectives to define explicit project boundaries and eliminate ambiguity before writing code.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Core Deliverables:</strong> Technical Requirements Document (TRD), feature roadmap, and fixed-milestone schedule.
                </div>
            </div>

            <!-- Step 2 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">02</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Strategize & Architect</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We design relational database schemas, REST/GraphQL API contracts, security perimeters, and hosting topology to guarantee long-term performance and maintainability.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Core Deliverables:</strong> Database ER diagrams, API specifications, and cloud infrastructure blueprint.
                </div>
            </div>

            <!-- Step 3 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">03</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">UI/UX & Interactive Design</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We craft intuitive, conversion-focused interfaces with accessible contrast, fluid responsive layouts, and interactive wireframes reviewed directly with stakeholders.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Core Deliverables:</strong> High-fidelity component designs, interactive user flow prototypes, and design tokens.
                </div>
            </div>

            <!-- Step 4 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">04</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Agile Sprints & Bi-Weekly Demos</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We engineer your application in focused two-week sprints. Working code is deployed to private staging environments so you can test functioning software throughout the build.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Core Deliverables:</strong> Live staging deployment every two weeks, sprint changelog, and direct video walkthrough.
                </div>
            </div>

            <!-- Step 5 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">05</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Rigorous Testing & Hardening</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We subject all code to end-to-end functional testing, cross-browser validation, SQL injection hardening, CSRF validation, and sub-second load time optimization.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Core Deliverables:</strong> Automated test suites, security audit checklist, and 95+ Lighthouse performance audit.
                </div>
            </div>

            <!-- Step 6 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">06</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Production Launch & Verification</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We execute zero-downtime production deployment, configure DNS records, enforce automated SSL certificate renewals, and establish real-time error logging.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Core Deliverables:</strong> Production deployment, active SSL/TLS, automated database backup routine, and monitoring.
                </div>
            </div>

            <!-- Step 7 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">07</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Handoff, Warranty & Scaling</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    You receive full intellectual property transfer, structured Git repositories, and a 30-day post-launch warranty with dedicated SLA scaling options.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Core Deliverables:</strong> 100% source code ownership, administrative documentation, and 30-day bug warranty.
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to experience disciplined software engineering?";
$ctaSubtitle = "Start with a Discovery Call to discuss your requirements, constraints, and possible next steps.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
