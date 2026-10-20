<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'About CodeX404 Solutions — Global Software & AI Engineering Partner',
    'description' => 'Learn about CodeX404 Solutions: an India-based engineering partner serving growing enterprises across the US, UK, UAE, and India with senior-level accountability, zero technical debt, and 100% IP ownership.',
    'canonical' => url('about.php'),
    'keywords' => 'about CodeX404 Solutions, software engineering company, Muhammad Noukhez, Yousuf Ansari, engineering partner, global software development'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="section" style="padding-top: calc(var(--nav-height) + 3rem); padding-bottom: 3.5rem;">
    <div class="container">
        <div class="section-header" style="max-width: 860px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Our Engineering Identity</span>
            </div>
            <h1 class="section-title" style="font-size: clamp(2.25rem, 4vw, 3.25rem); line-height: 1.15; margin-bottom: 1.25rem;">
                An Engineering Partner That Treats <span class="gradient-text">Your Code Like Our Own</span>
            </h1>
            <p class="section-subtitle" style="font-size: 1.1rem; line-height: 1.7; color: var(--slate); max-width: 740px; margin: 0 auto;">
                CodeX404 Solutions was founded on a simple principle: growing businesses deserve world-class software engineering, transparent communication, and senior-level technical accountability without bloated agency bureaucracy or freelance fragility.
            </p>
        </div>

        <!-- Why We Exist & Operating Principles -->
        <div class="grid grid-cols-2" style="margin-bottom: 4rem; gap: 3rem; align-items: center;">
            <div>
                <span class="tag-chip" style="margin-bottom: 1rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">The Founding Mission</span>
                <h2 style="font-size: 2.15rem; margin-bottom: 1.25rem; color: var(--white); line-height: 1.25;">Bridging the Gap in Global Software Engineering</h2>
                <p style="font-size: 1.05rem; line-height: 1.7; margin-bottom: 1.25rem; color: var(--slate);">
                    Too many growing businesses get burned by one of two extremes: overpriced agencies that bill enterprise rates while secretly handing off work to junior trainees, or low-cost freelancers who write brittle, unmaintainable code that breaks under real production loads.
                </p>
                <p style="font-size: 1.05rem; line-height: 1.7; color: var(--slate);">
                    CodeX404 bridges this gap. Based in India with a global engineering mindset, we partner directly with ambitious companies across the US, UK, UAE, Europe, and India to build, automate, and scale mission-critical software systems that last for years.
                </p>
            </div>

            <div style="background: var(--bg-surface); padding: 2.75rem; border-radius: var(--radius-lg); border: 1px solid var(--border-subtle);">
                <h3 style="color: var(--cyan); margin-bottom: 1.5rem; font-size: 1.35rem;">Our Core Operating Principles</h3>
                <ul class="transform-list" style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <span style="color: var(--cyan); font-weight: 800; font-size: 1.25rem; line-height: 1;">01</span>
                        <div>
                            <strong style="color: var(--white); display: block; font-size: 1.05rem; margin-bottom: 0.25rem;">Clean, Defensive Code</strong>
                            <span style="font-size: 0.9rem; color: var(--slate); line-height: 1.5;">We write strictly typed, well-commented code with zero tolerance for security compromises, unparameterized queries, or fragile workarounds.</span>
                        </div>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <span style="color: var(--cyan); font-weight: 800; font-size: 1.25rem; line-height: 1;">02</span>
                        <div>
                            <strong style="color: var(--white); display: block; font-size: 1.05rem; margin-bottom: 0.25rem;">Direct Senior Engineering Access</strong>
                            <span style="font-size: 0.9rem; color: var(--slate); line-height: 1.5;">No layers of non-technical account managers playing telephone. You communicate directly with senior software architects who design and write your code.</span>
                        </div>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <span style="color: var(--cyan); font-weight: 800; font-size: 1.25rem; line-height: 1;">03</span>
                        <div>
                            <strong style="color: var(--white); display: block; font-size: 1.05rem; margin-bottom: 0.25rem;">100% Intellectual Property Ownership</strong>
                            <span style="font-size: 0.9rem; color: var(--slate); line-height: 1.5;">From day one, you own all Git repositories, cloud deployment keys, architecture diagrams, and design assets. Absolutely zero vendor lock-in.</span>
                        </div>
                    </li>
                    <li style="display: flex; gap: 1rem; align-items: flex-start;">
                        <span style="color: var(--cyan); font-weight: 800; font-size: 1.25rem; line-height: 1;">04</span>
                        <div>
                            <strong style="color: var(--white); display: block; font-size: 1.05rem; margin-bottom: 0.25rem;">Milestone-Based Transparency</strong>
                            <span style="font-size: 0.9rem; color: var(--slate); line-height: 1.5;">Clear sprint deliverables, weekly staging previews, and automated test coverage ensure there are no surprises or missed deadlines.</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- LEADERSHIP COMPONENT -->
<?php include __DIR__ . '/components/leadership.php'; ?>

<!-- GLOBAL PRESENCE STRIP -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Global Reach</span>
            </div>
            <h2 class="section-title">Engineered in India. Trusted Across Timezones.</h2>
            <p class="section-subtitle">
                We deliver software for international clients spanning multiple continents with asynchronous daily standups and dedicated overlapping communication hours.
            </p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card" style="text-align: center; padding: 2.25rem;">
                <h3 style="color: var(--cyan); font-size: 1.2rem; margin-bottom: 0.75rem;">North America</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6;">
                    United States & Canada. Overlapping EST / PST check-in hours, weekly sprint demonstrations, and contract compliance.
                </p>
            </div>

            <div class="card" style="text-align: center; padding: 2.25rem;">
                <h3 style="color: var(--cyan); font-size: 1.2rem; margin-bottom: 0.75rem;">United Kingdom & Europe</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6;">
                    UK, Germany, Netherlands, Ireland. Full GDPR compliance, clean data privacy agreements, and European working hours alignment.
                </p>
            </div>

            <div class="card" style="text-align: center; padding: 2.25rem;">
                <h3 style="color: var(--cyan); font-size: 1.2rem; margin-bottom: 0.75rem;">Middle East & GCC</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6;">
                    UAE, Saudi Arabia, Qatar, Oman. Seamless Gulf timezone overlap, rapid turnarounds, and localized payment options.
                </p>
            </div>

            <div class="card" style="text-align: center; padding: 2.25rem;">
                <h3 style="color: var(--cyan); font-size: 1.2rem; margin-bottom: 0.75rem;">India & APAC</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6;">
                    India, Singapore, Australia. High-velocity development cycles, on-demand architectural reviews, and localized business systems.
                </p>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Partner With an Engineering Team Focused on Your Business Outcomes";
$ctaSubtitle = "Book a technical discovery session to discuss your architecture, specifications, and delivery milestones directly with our founding architects.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
