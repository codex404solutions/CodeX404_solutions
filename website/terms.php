<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Terms of Service & Engineering Agreement',
    'description' => 'CodeX404 Solutions Terms of Service governing website usage, project engagements, intellectual property rights, warranties, and mutual obligations.',
    'canonical' => url('terms.php'),
    'keywords' => 'terms of service, software contract terms, IP ownership agreement'
];

require_once __DIR__ . '/includes/header.php';
?>

<?php
$heroTag = 'Legal Terms';
$heroTitleHtml = 'Terms of <span class="text-amber">Service</span>';
$heroSubtitle = 'Last updated: October 6, 2026 — Website usage terms, project Statements of Work, intellectual property ownership, and mutual obligations.';
require __DIR__ . '/includes/subpage-hero.php';
?>

<section class="section">
    <div class="container container-narrow">
        <div class="obsidian-lit-panel is-subtle"
            style="background: var(--bg-surface); padding: clamp(1.35rem, 3.5vw, 3rem); border-radius: var(--radius-lg); border: 1px solid var(--border-subtle); line-height: 1.8;">
            <h2 style="font-size: 1.5rem; color: var(--white); margin-bottom: 1rem;">1. Acceptance of Terms</h2>
            <p>
                By accessing this website (<a href="https://codex404solutions.com">codex404solutions.com</a>) or
                commissioning engineering services from <strong>CodeX404 Solutions</strong>, you agree to be bound by
                these Terms of Service and all applicable laws and regulations.
            </p>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">2. Scope of Services</h2>
            <p>
                CodeX404 Solutions provides digital software engineering, artificial intelligence integration, workflow
                automation, and technical consultancy services. Specific deliverables, delivery milestones, budgets, and
                technical requirements are governed by an individual Statement of Work (SOW) executed between the
                parties.
            </p>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">3. Intellectual Property (IP)
                Rights</h2>
            <p>
                <strong>Client Ownership:</strong> Upon full settlement of invoices for a given project milestone or
                deliverable, all custom software, bespoke source code repositories, visual designs, database
                architectures, and documentation developed specifically for the client become the exclusive intellectual
                property of the client.
            </p>
            <p>
                <strong>Pre-existing Tools & Libraries:</strong> Any open-source libraries or pre-existing developer
                utilities utilized remain governed by their respective standard open-source licenses (e.g., MIT, Apache
                2.0).
            </p>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">4. Confidentiality & Non-Disclosure
            </h2>
            <p>
                Both parties agree that all proprietary business information, source code, client records, and
                non-public strategies exchanged during discussions or project execution shall be held in strict
                confidence and protected with the same degree of care as their own confidential assets.
            </p>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">5. Warranty & Defect Remediation
            </h2>
            <p>
                CodeX404 Solutions warrants that all custom deliverables will substantially conform to the approved
                technical specification for a period of thirty (30) calendar days following production deployment. We
                will correct any reproducible software defects discovered during this warranty period at zero additional
                cost.
            </p>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">6. Limitation of Liability</h2>
            <p>
                Except in cases of gross negligence or willful misconduct, neither party shall be liable for indirect,
                incidental, special, or consequential damages (including loss of profits, data, or business
                interruption) arising out of the performance of services.
            </p>

            <h2 style="font-size: 1.5rem; color: var(--white); margin: 2rem 0 1rem;">7. Governing Law</h2>
            <p>
                These Terms shall be governed by and construed in accordance with the laws of India, without regard to
                its conflict of law provisions, or as explicitly stipulated in an executed Master Services Agreement.
            </p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>