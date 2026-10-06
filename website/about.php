<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'About CodeX404 Solutions — Leadership, Mission & Engineering Values',
    'description' => 'Learn about CodeX404 Solutions: an India-based software and AI engineering partner serving growing businesses across the globe with transparent, production-ready code.',
    'canonical' => url('about.php'),
    'keywords' => 'about CodeX404 Solutions, software engineering company, Muhammad Noukhez, Yousuf Ansari, engineering partner'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Our Identity</span>
            </div>
            <h1 class="section-title">An Engineering Partner That Treats Your Code Like Our Own</h1>
            <p class="section-subtitle">
                CodeX404 Solutions was founded on a simple principle: growing businesses deserve world-class software engineering, transparent communication, and senior-level accountability without bloated agency bureaucracy.
            </p>
        </div>

        <div class="grid grid-cols-2" style="margin-bottom: 4rem; gap: 3rem; align-items: center;">
            <div>
                <h2 style="font-size: 2rem; margin-bottom: 1.25rem;">Why We Exist</h2>
                <p style="font-size: 1.05rem; line-height: 1.7; margin-bottom: 1.25rem;">
                    Too many businesses get burned by either overpriced agencies that hand off work to junior trainees or low-cost freelancers that deliver brittle, unmaintainable code that breaks in production.
                </p>
                <p style="font-size: 1.05rem; line-height: 1.7;">
                    CodeX404 bridges this gap. Based in India with a global engineering mindset, we partner directly with ambitious companies in the US, UK, Europe, UAE, and India to build, automate, and scale mission-critical software systems that last.
                </p>
            </div>
            <div style="background: var(--bg-surface); padding: 2.5rem; border-radius: var(--radius-lg); border: 1px solid var(--border-subtle);">
                <h3 style="color: var(--cyan); margin-bottom: 1.25rem;">Our Core Operating Principles</h3>
                <ul class="transform-list">
                    <li>
                        <span style="color: var(--cyan); font-weight: bold;">01</span>
                        <div>
                            <strong style="color: var(--white); display: block;">Clean, Defensive Code</strong>
                            <span style="font-size: 0.9rem;">We write strictly typed, well-commented code with zero tolerance for security compromises or hacky workarounds.</span>
                        </div>
                    </li>
                    <li style="margin-top: 1rem;">
                        <span style="color: var(--cyan); font-weight: bold;">02</span>
                        <div>
                            <strong style="color: var(--white); display: block;">Direct Access to Senior Engineers</strong>
                            <span style="font-size: 0.9rem;">No layers of non-technical account managers playing telephone. You speak directly with architects who write your software.</span>
                        </div>
                    </li>
                    <li style="margin-top: 1rem;">
                        <span style="color: var(--cyan); font-weight: bold;">03</span>
                        <div>
                            <strong style="color: var(--white); display: block;">100% IP Ownership</strong>
                            <span style="font-size: 0.9rem;">From day one, you own all repositories, credentials, documentation, and design assets. Zero vendor lock-in.</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- LEADERSHIP SECTION -->
<?php include __DIR__ . '/components/leadership.php'; ?>

<!-- Global Presence Strip -->
<section class="section" style="background: rgba(11, 31, 58, 0.3);">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Global Reach</span>
            </div>
            <h2 class="section-title">Engineered in India. Trusted Globally.</h2>
            <p class="section-subtitle">
                We deliver software for clients spanning multiple timezones with asynchronous updates and overlapping communication hours.
            </p>
        </div>

        <div class="grid grid-cols-4">
            <div class="card" style="text-align: center;">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.5rem;">North America</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">United States & Canada. Overlapping EST / PST check-in hours and dedicated sprint reviews.</p>
            </div>
            <div class="card" style="text-align: center;">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.5rem;">United Kingdom & Europe</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">UK, Germany, Netherlands, Ireland. Full GDPR compliance and European working hours alignment.</p>
            </div>
            <div class="card" style="text-align: center;">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.5rem;">Middle East</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">UAE, Saudi Arabia, Qatar, Oman. Seamless Gulf timezone overlap and regional payment options.</p>
            </div>
            <div class="card" style="text-align: center;">
                <h3 style="color: var(--cyan); font-size: 1.15rem; margin-bottom: 0.5rem;">India & APAC</h3>
                <p style="font-size: 0.85rem; color: var(--slate);">India, Singapore, Australia, New Zealand. Localized operational systems and real-time collaboration.</p>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Partner with an engineering team focused on your outcomes";
$ctaSubtitle = "Book a technical discovery session to discuss your architecture, requirements, and delivery milestones.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
