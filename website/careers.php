<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';

$pageMeta = [
    'title' => 'Careers & Engineering Culture — CodeX404 Solutions',
    'description' => 'Join our high-ownership engineering team. We build custom web applications, SaaS platforms, and enterprise AI systems with zero bureaucracy and clean, defensive code.',
    'canonical' => url('careers.php'),
    'keywords' => 'engineering careers, software developer jobs, remote developer India, full-stack PHP developer, AI engineer jobs'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- ==========================================================================
     HERO SECTION
     ========================================================================== -->
<section class="page-hero-section" style="padding-top: calc(var(--nav-height) + 3.5rem); padding-bottom: 3.5rem; text-align: center;">
    <div class="container" style="max-width: 900px; margin: 0 auto;">
        <div class="hero-pill" style="margin: 0 auto 1.5rem auto;">
            <span class="dot"></span>
            <span>High-Ownership Engineering Culture</span>
        </div>

        <h1 class="hero-headline" style="font-size: clamp(2.25rem, 4.2vw, 3.5rem); margin-bottom: 1.25rem;">
            Build Software That Matters. <span class="text-gradient gradient-text-animated">No Bureaucracy.</span>
        </h1>

        <p class="hero-description" style="margin: 0 auto 2.25rem auto; font-size: 1.15rem; color: var(--slate); max-width: 720px; line-height: 1.7;">
            We are a practitioner-led engineering collective. No non-technical middle managers playing telephone, no bloated corporate theater—just talented software architects building production systems for global enterprises.
        </p>

        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="#open-roles" class="btn btn-primary btn-lg">
                <span>View Open Positions &darr;</span>
            </a>
            <a href="<?= url('about.php') ?>" class="btn btn-secondary btn-lg">
                <span>Our Engineering Philosophy &rarr;</span>
            </a>
        </div>
    </div>
</section>

<!-- ==========================================================================
     ENGINEERING CULTURE & VALUES
     ========================================================================== -->
<section class="section" style="padding-top: 0; padding-bottom: 4rem;">
    <div class="container">
        <div class="section-header" style="text-align: center; max-width: 800px; margin: 0 auto 3rem auto;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>How We Build</span>
            </div>
            <h2 class="section-title">What It Means to Build at CodeX404</h2>
            <p class="section-subtitle">
                Our culture is designed for engineers who take pride in craftsmanship, speed, and real-world impact.
            </p>
        </div>

        <div class="grid grid-cols-3" style="gap: 2rem;">
            <div class="card card-tilt reveal-on-scroll">
                <div class="card-icon">⚡</div>
                <h3 class="card-title" style="font-size: 1.3rem;">Clean, Defensive Code</h3>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    We write strictly typed, well-commented code with zero tolerance for unparameterized queries, fragile workarounds, or bloated dependencies.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Strict Types</span>
                    <span class="tag-chip">PDO Prepared</span>
                    <span class="tag-chip">Sub-Second Speed</span>
                </div>
            </div>

            <div class="card card-tilt reveal-on-scroll reveal-delay-1">
                <div class="card-icon">🎯</div>
                <h3 class="card-title" style="font-size: 1.3rem;">Direct Founder &amp; Client Access</h3>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    You collaborate directly with founders and senior client stakeholders. Your architectural decisions shape real products deployed to thousands of users.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Flat Hierarchy</span>
                    <span class="tag-chip">Zero Middlemen</span>
                    <span class="tag-chip">High Agency</span>
                </div>
            </div>

            <div class="card card-tilt reveal-on-scroll reveal-delay-2">
                <div class="card-icon">🚀</div>
                <h3 class="card-title" style="font-size: 1.3rem;">Bi-Weekly Staging Shipping</h3>
                <p class="card-description" style="font-size: 0.925rem; line-height: 1.6;">
                    We don't get trapped in multi-month theoretical planning. We deploy functioning staging previews every two weeks so real software is continually tested.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Agile Sprints</span>
                    <span class="tag-chip">Live Staging</span>
                    <span class="tag-chip">Continuous CI/CD</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     OPEN POSITIONS
     ========================================================================== -->
<section class="section" id="open-roles" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle); padding: 5rem 0;">
    <div class="container">
        <div class="section-header" style="text-align: center; max-width: 800px; margin: 0 auto 3.5rem auto;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Join The Team</span>
            </div>
            <h2 class="section-title">Open Engineering Positions</h2>
            <p class="section-subtitle">
                We hire builders who value engineering rigor, autonomy, and delivering measurable results.
            </p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.75rem; max-width: 960px; margin: 0 auto;">
            
            <!-- Role 1 -->
            <article class="card card-tilt" style="padding: 2.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
                <div style="max-width: 600px;">
                    <div style="display: flex; gap: 0.75rem; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap;">
                        <span class="tag-chip" style="color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Full-Time • Remote (India)</span>
                        <span style="font-size: 0.8rem; color: var(--slate-dark);">Engineering Division</span>
                    </div>
                    <h3 style="font-size: 1.45rem; color: var(--white); margin-bottom: 0.5rem;">Senior Full-Stack PHP &amp; MySQL Architect</h3>
                    <p style="font-size: 0.925rem; color: var(--slate); line-height: 1.6; margin: 0;">
                        Architect high-throughput web applications, institutional ERPs, and custom CRM engines using modern PHP 8.2+, strictly typed models, and optimized relational schemas.
                    </p>
                </div>
                <div>
                    <a href="mailto:careers@codex404solutions.com?subject=Application:%20Senior%20Full-Stack%20PHP%20Architect" class="btn btn-primary btn-sm">
                        Apply Now &rarr;
                    </a>
                </div>
            </article>

            <!-- Role 2 -->
            <article class="card card-tilt" style="padding: 2.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
                <div style="max-width: 600px;">
                    <div style="display: flex; gap: 0.75rem; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap;">
                        <span class="tag-chip" style="color: #34D399; border-color: rgba(52, 211, 153, 0.4);">Full-Time • Remote</span>
                        <span style="font-size: 0.8rem; color: var(--slate-dark);">AI &amp; Automation</span>
                    </div>
                    <h3 style="font-size: 1.45rem; color: var(--white); margin-bottom: 0.5rem;">Python AI &amp; RAG Systems Engineer</h3>
                    <p style="font-size: 0.925rem; color: var(--slate); line-height: 1.6; margin: 0;">
                        Build private enterprise RAG pipelines, autonomous tool-calling agents, and webhook ingestion engines using FastAPI, Qdrant/pgvector, and official cloud LLM APIs.
                    </p>
                </div>
                <div>
                    <a href="mailto:careers@codex404solutions.com?subject=Application:%20Python%20AI%20Engineer" class="btn btn-primary btn-sm">
                        Apply Now &rarr;
                    </a>
                </div>
            </article>

            <!-- Role 3 -->
            <article class="card card-tilt" style="padding: 2.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
                <div style="max-width: 600px;">
                    <div style="display: flex; gap: 0.75rem; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap;">
                        <span class="tag-chip" style="color: #A78BFA; border-color: rgba(167, 139, 250, 0.4);">Contract / Full-Time</span>
                        <span style="font-size: 0.8rem; color: var(--slate-dark);">Frontend &amp; UX</span>
                    </div>
                    <h3 style="font-size: 1.45rem; color: var(--white); margin-bottom: 0.5rem;">Frontend Systems &amp; Performance Engineer</h3>
                    <p style="font-size: 0.925rem; color: var(--slate); line-height: 1.6; margin: 0;">
                        Create sub-second, accessible user interfaces with vanilla CSS tokens, responsive micro-interactions, and modern reactive client frameworks.
                    </p>
                </div>
                <div>
                    <a href="mailto:careers@codex404solutions.com?subject=Application:%20Frontend%20Systems%20Engineer" class="btn btn-primary btn-sm">
                        Apply Now &rarr;
                    </a>
                </div>
            </article>

        </div>
    </div>
</section>

<!-- ==========================================================================
     HIRING PROCESS
     ========================================================================== -->
<section class="section">
    <div class="container container-narrow">
        <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Transparent Process</span>
            </div>
            <h2 class="section-title">Our 4-Step Hiring Process</h2>
            <p class="section-subtitle">
                We respect your time. No multi-month interview loops or endless whiteboard trivia.
            </p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="background: var(--bg-surface); padding: 1.75rem 2rem; border-radius: var(--radius-md); border-left: 3px solid var(--cyan); display: flex; gap: 1.25rem; align-items: flex-start;">
                <span style="font-weight: 800; color: var(--cyan); font-size: 1.25rem;">01</span>
                <div>
                    <strong style="color: var(--white); font-size: 1.1rem; display: block; margin-bottom: 0.25rem;">Initial Architecture Review (30 mins)</strong>
                    <span style="font-size: 0.9rem; color: var(--slate); line-height: 1.5;">A casual technical chat with a founder discussing projects you've shipped and your architectural philosophy.</span>
                </div>
            </div>

            <div style="background: var(--bg-surface); padding: 1.75rem 2rem; border-radius: var(--radius-md); border-left: 3px solid #34D399; display: flex; gap: 1.25rem; align-items: flex-start;">
                <span style="font-weight: 800; color: #34D399; font-size: 1.25rem;">02</span>
                <div>
                    <strong style="color: var(--white); font-size: 1.1rem; display: block; margin-bottom: 0.25rem;">Practical Coding Challenge</strong>
                    <span style="font-size: 0.9rem; color: var(--slate); line-height: 1.5;">A focused, real-world task (e.g. building an API endpoint with SQL query optimization or a RAG context parser).</span>
                </div>
            </div>

            <div style="background: var(--bg-surface); padding: 1.75rem 2rem; border-radius: var(--radius-md); border-left: 3px solid #A78BFA; display: flex; gap: 1.25rem; align-items: flex-start;">
                <span style="font-weight: 800; color: #A78BFA; font-size: 1.25rem;">03</span>
                <div>
                    <strong style="color: var(--white); font-size: 1.1rem; display: block; margin-bottom: 0.25rem;">System Deep Dive &amp; Culture Alignment</strong>
                    <span style="font-size: 0.9rem; color: var(--slate); line-height: 1.5;">Walk through your code submission, discuss trade-offs, and align on communication cadences.</span>
                </div>
            </div>

            <div style="background: var(--bg-surface); padding: 1.75rem 2rem; border-radius: var(--radius-md); border-left: 3px solid var(--electric-blue); display: flex; gap: 1.25rem; align-items: flex-start;">
                <span style="font-weight: 800; color: var(--electric-blue); font-size: 1.25rem;">04</span>
                <div>
                    <strong style="color: var(--white); font-size: 1.1rem; display: block; margin-bottom: 0.25rem;">Written Offer &amp; Day 1 Onboarding</strong>
                    <span style="font-size: 0.9rem; color: var(--slate); line-height: 1.5;">Competitive compensation, clear scope expectations, and immediate deployment access on Day 1.</span>
                </div>
            </div>
        </div>

        <div style="margin-top: 3.5rem; text-align: center; background: rgba(11, 31, 58, 0.4); padding: 2.5rem; border-radius: var(--radius-lg); border: 1px solid var(--border-subtle);">
            <h3 style="font-size: 1.4rem; color: var(--white); margin-bottom: 0.75rem;">Don't see a role that fits?</h3>
            <p style="font-size: 0.95rem; color: var(--slate); margin-bottom: 1.5rem; max-width: 580px; margin-left: auto; margin-right: auto;">
                We are always eager to talk with exceptional engineers. Email your GitHub profile, portfolio, and a note about what you like building to <a href="mailto:careers@codex404solutions.com" style="color: var(--cyan); text-decoration: underline;">careers@codex404solutions.com</a>.
            </p>
            <a href="mailto:careers@codex404solutions.com" class="btn btn-secondary">
                Send Speculative Application &rarr;
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
