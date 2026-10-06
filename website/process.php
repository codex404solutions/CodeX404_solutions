<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Our 7-Stage Engineering & Delivery Process',
    'description' => 'Discover how CodeX404 Solutions delivers software: a rigorous 7-stage process covering discovery, architecture, design, agile build, QA, and launch.',
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
                Software projects fail from ambiguity, not code. Our structured delivery process provides complete transparency, guaranteed milestone delivery, and zero surprise costs.
            </p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 2.5rem; max-width: 980px; margin: 0 auto;">
            <!-- Step 1 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">01</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Discover & Unpack Friction</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We dive into your existing operations: interviews with your team, auditing spreadsheets, analyzing legacy systems, and identifying manual choke-points. We define non-negotiable business outcomes before writing a single line of architecture.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Key Deliverable:</strong> Technical Requirements Document (TRD) & Scope Alignment Matrix.
                </div>
            </div>

            <!-- Step 2 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">02</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Strategize & Architect</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We design the database schemas, API contracts, third-party integrations, and security perimeters. We choose the right stack based on long-term maintainability, hosting efficiency, and performance rather than short-lived hype.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Key Deliverable:</strong> System Architecture Blueprints, Data Schema, and API Specification.
                </div>
            </div>

            <!-- Step 3 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">03</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">UI/UX & Interactive Design</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We build intuitive interfaces with high visual polish, logical user journeys, and zero cognitive load. Every interactive element, form state, and mobile breakpoint is tested for real-world ergonomics.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Key Deliverable:</strong> Responsive Screen Mockups & Interactive User Flow Prototypes.
                </div>
            </div>

            <!-- Step 4 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">04</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Agile Build & Iteration</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    Development runs in focused 1-2 week sprints. You receive staging environment access to inspect working features as they are committed, with continuous status updates and code review standards.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Key Deliverable:</strong> Production-grade source code, Git commit trail, and Staging Demos.
                </div>
            </div>

            <!-- Step 5 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">05</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Rigorous Testing & Hardening</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    Comprehensive quality assurance covering SQL injection prevention, cross-site scripting (XSS), CSRF validation, responsive layout testing across 10+ devices, and stress-testing network drops.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Key Deliverable:</strong> Security Audit Report, QA Matrix, and Verified Edge Case Fixes.
                </div>
            </div>

            <!-- Step 6 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">06</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Zero-Downtime Launch</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We handle production infrastructure provisioning, SSL certificate installation, domain DNS routing, database seeding, automated backup schedules, and live smoke testing.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Key Deliverable:</strong> Live Production Release, DNS/SSL Verification, and Deployment Sign-off.
                </div>
            </div>

            <!-- Step 7 -->
            <div class="card" style="padding: 2.25rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <div class="step-num" style="margin: 0;">07</div>
                    <h2 style="font-size: 1.5rem; color: var(--white); margin: 0;">Scale & Continuous Improvement</h2>
                </div>
                <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1rem;">
                    We monitor production uptime, error logs, user feedback, and database query latency. We iterate with ongoing feature expansions, automation enhancements, and performance optimizations.
                </p>
                <div style="font-size: 0.85rem; color: var(--cyan);">
                    <strong>Key Deliverable:</strong> Post-launch warranty support, telemetry dashboards, and feature roadmap.
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Ready to experience disciplined software engineering?";
$ctaSubtitle = "Start with a 30-minute Discovery Call to discuss your requirements and project milestones.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
