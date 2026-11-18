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
                A clear process can reduce ambiguity. Scope, milestones, dependencies, and costs vary by project; we document the applicable assumptions and acceptance criteria before work begins.
            </p>
        </div>
        <div class="container-narrow" style="margin: 0 auto 2rem; text-align: center; color: var(--slate);">
            The stages below describe a typical project path. Specific activities, deliverables, testing, staging, launch support, and timelines depend on the agreed scope.
        </div>

        <div style="display: flex; flex-direction: column; gap: 2.5rem; max-width: 980px; margin: 0 auto;">
            <!-- Step 1 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">01</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Discover & Unpack Friction</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We discuss goals, users, current systems, constraints, and operational needs. Interviews, document reviews, and process mapping can be included when they help clarify the problem.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Possible output:</strong> A problem summary, requirements, and agreed scope.
                </div>
            </div>

            <!-- Step 2 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">02</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Strategize & Architect</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We identify the architecture, data, integration, hosting, and security considerations relevant to the requirements. Design detail and technology choices depend on the project.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Possible output:</strong> Architecture notes or diagrams, data considerations, and integration specifications where needed.
                </div>
            </div>

            <!-- Step 3 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">03</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">UI/UX & Interactive Design</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We plan key screens and interactions for the intended users and devices. Prototypes, accessibility checks, and usability testing are included when agreed in scope.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Possible output:</strong> Screen designs, interaction notes, or a prototype where included.
                </div>
            </div>

            <!-- Step 4 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">04</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Agile Build & Iteration</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    Implementation may be organized into reviewable increments. Iteration length, progress updates, repository access, and any staging environment are agreed for the project.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Possible output:</strong> Working software and implementation notes, with review access as agreed.
                </div>
            </div>

            <!-- Step 5 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">05</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Rigorous Testing & Hardening</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    Testing is selected according to the system, risks, supported platforms, and scope. Functional, security, responsive, and integration checks may be included where relevant; this stage does not imply a certification or exhaustive audit.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Possible output:</strong> Test results, identified issues, and remediation notes for the agreed checks.
                </div>
            </div>

            <!-- Step 6 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">06</div>
                <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Launch Preparation and Release</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    A production release is handled only when included in the agreement and approved. Hosting, DNS, SSL, data migration, backups, and release checks depend on the target environment and assigned responsibilities.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Possible output:</strong> A release checklist, handoff notes, or deployment support when included.
                </div>
            </div>

            <!-- Step 7 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">07</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Scale & Continuous Improvement</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    Post-launch monitoring, maintenance, and further development depend on the support arrangement. Ownership of alerts, logs, backups, and response responsibilities should be agreed.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Possible output:</strong> A support plan or prioritized next-step list where included.
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
