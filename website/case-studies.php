<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Case Studies & Practical Engineering Deliverables',
    'description' => 'Real-world case studies detailing how CodeX404 Solutions solved concrete business challenges across custom software, ERPs, lead pipelines, and automation.',
    'canonical' => url('case-studies.php'),
    'keywords' => 'software case studies, ERP case study, automation case study, practical engineering results'
];

require_once __DIR__ . '/includes/header.php';
?>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-tag">
                <span class="dot"></span>
                <span>Evidence of Execution</span>
            </div>
            <h1 class="section-title">Practical Case Studies in Software & Automation</h1>
            <p class="section-subtitle">
                We believe in verifiable engineering facts over inflated claims. Below are detailed breakdowns of actual systems designed, built, and deployed by our team.
            </p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 3rem;">
            <!-- Case Study 1 -->
            <div class="card" style="padding: 2.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: gap; margin-bottom: 1.25rem;">
                    <div>
                        <span class="tag-chip" style="color: var(--cyan); border-color: rgba(34, 211, 238, 0.3);">Education & Institutional Management</span>
                        <h2 style="font-size: 1.85rem; margin-top: 0.5rem; color: var(--white);">School ERP & Administrative Portal</h2>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.85rem; color: var(--slate-dark);">Sector: Institutional Operations</span>
                    </div>
                </div>

                <div class="grid grid-cols-2" style="margin-bottom: 1.5rem; gap: 2rem;">
                    <div>
                        <h4 style="color: #F87171; margin-bottom: 0.5rem;">The Challenge & Prior Process</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6;">
                            Student admissions, tuition billing records, teacher logs, and attendance were maintained on manual paper ledgers and fragmented offline spreadsheets. Generating term-end fee reconciliation reports required over 10 days of clerical work, leading to payment delays and bookkeeping errors.
                        </p>
                    </div>
                    <div>
                        <h4 style="color: #34D399; margin-bottom: 0.5rem;">The Engineering Solution</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6;">
                            Engineered a centralized, web-based School ERP platform featuring granular Role-Based Access Control (Admin, Accountant, Teacher, Student). Automated fee receipts generation, real-time pending dues tracking, and secure CSV/PDF export pipelines.
                        </p>
                    </div>
                </div>

                <div style="background: rgba(7, 17, 31, 0.6); padding: 1.25rem 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div class="card-tags" style="border: none; padding: 0; margin: 0;">
                        <span class="tag-chip">PHP 8.2</span>
                        <span class="tag-chip">MySQL Relational Schema</span>
                        <span class="tag-chip">RBAC Security</span>
                        <span class="tag-chip">PDF Generation</span>
                    </div>
                    <div style="color: #34D399; font-weight: 600; font-size: 0.9rem;">
                        ✓ Fee reconciliation time dropped from 10 days to under 15 minutes
                    </div>
                </div>
            </div>

            <!-- Case Study 2 -->
            <div class="card" style="padding: 2.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: gap; margin-bottom: 1.25rem;">
                    <div>
                        <span class="tag-chip" style="color: var(--cyan); border-color: rgba(34, 211, 238, 0.3);">Business Systems & Sales Ops</span>
                        <h2 style="font-size: 1.85rem; margin-top: 0.5rem; color: var(--white);">Multi-Channel Lead Ingestion & CRM Pipeline</h2>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.85rem; color: var(--slate-dark);">Sector: B2B Services</span>
                    </div>
                </div>

                <div class="grid grid-cols-2" style="margin-bottom: 1.5rem; gap: 2rem;">
                    <div>
                        <h4 style="color: #F87171; margin-bottom: 0.5rem;">The Challenge & Prior Process</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6;">
                            Customer inquiries were scattered across email inboxes, WhatsApp web chats, and landing page form submissions. Sales reps routinely failed to respond within the golden 1-hour window, leading to qualified lead leakage and zero audit trail of sales interactions.
                        </p>
                    </div>
                    <div>
                        <h4 style="color: #34D399; margin-bottom: 0.5rem;">The Engineering Solution</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6;">
                            Built a unified webhook-driven ingestion server connecting Meta WhatsApp Cloud API and website contact forms to an internal CRM. Included idempotency keys to eliminate duplicate inquiries, automated instant WhatsApp confirmations, and assigned reps dynamically.
                        </p>
                    </div>
                </div>

                <div style="background: rgba(7, 17, 31, 0.6); padding: 1.25rem 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div class="card-tags" style="border: none; padding: 0; margin: 0;">
                        <span class="tag-chip">Webhook Pipelines</span>
                        <span class="tag-chip">WhatsApp Cloud API</span>
                        <span class="tag-chip">Idempotent Queue</span>
                        <span class="tag-chip">HMAC Verification</span>
                    </div>
                    <div style="color: #34D399; font-weight: 600; font-size: 0.9rem;">
                        ✓ Average first contact latency decreased from 4.2 hours to &lt; 3 minutes
                    </div>
                </div>
            </div>

            <!-- Case Study 3 -->
            <div class="card" style="padding: 2.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: gap; margin-bottom: 1.25rem;">
                    <div>
                        <span class="tag-chip" style="color: var(--cyan); border-color: rgba(34, 211, 238, 0.3);">Commerce & Wholesale</span>
                        <h2 style="font-size: 1.85rem; margin-top: 0.5rem; color: var(--white);">B2B Ordering & Live Inventory Engine</h2>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.85rem; color: var(--slate-dark);">Sector: Wholesale & Distribution</span>
                    </div>
                </div>

                <div class="grid grid-cols-2" style="margin-bottom: 1.5rem; gap: 2rem;">
                    <div>
                        <h4 style="color: #F87171; margin-bottom: 0.5rem;">The Challenge & Prior Process</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6;">
                            Wholesale buyers submitted bulk purchase orders via phone calls and PDF attachments. Stock inventory levels were verified manually by warehouse managers, causing overselling, backorders, and billing disputes.
                        </p>
                    </div>
                    <div>
                        <h4 style="color: #34D399; margin-bottom: 0.5rem;">The Engineering Solution</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6;">
                            Developed a password-protected B2B ordering portal with volume-based tiered discounts, live inventory validation at checkout, automated GST invoice generation, and integrated payment gateway options.
                        </p>
                    </div>
                </div>

                <div style="background: rgba(7, 17, 31, 0.6); padding: 1.25rem 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div class="card-tags" style="border: none; padding: 0; margin: 0;">
                        <span class="tag-chip">PHP & MySQL</span>
                        <span class="tag-chip">Payment Gateway</span>
                        <span class="tag-chip">Atomic Inventory Locking</span>
                        <span class="tag-chip">Automated Invoicing</span>
                    </div>
                    <div style="color: #34D399; font-weight: 600; font-size: 0.9rem;">
                        ✓ Zero stock discrepancies; order processing turnaround reduced by 75%
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Have a business bottleneck ready for a solution?";
$ctaSubtitle = "Let's explore your current workflow challenges and design a tailored software or automation solution.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
