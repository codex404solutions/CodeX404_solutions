<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Case Studies & Production Engineering Deliverables',
    'description' => 'Real-world case studies detailing how CodeX404 Solutions solved concrete business challenges across custom ERPs, WhatsApp lead automation, B2B commerce, and private AI RAG systems.',
    'canonical' => url('case-studies.php'),
    'keywords' => 'software case studies, ERP case study, WhatsApp automation case study, B2B commerce case study, enterprise AI RAG results'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="section" style="padding-top: calc(var(--nav-height) + 3rem); padding-bottom: 3.5rem;">
    <div class="container">
        <div class="section-header" style="max-width: 860px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Verifiable Evidence of Execution</span>
            </div>
            <h1 class="section-title" style="font-size: clamp(2.25rem, 4vw, 3.25rem); line-height: 1.15; margin-bottom: 1.25rem;">
                Real Systems. Real Constraints. <span class="gradient-text">Measurable Impact.</span>
            </h1>
            <p class="section-subtitle" style="font-size: 1.1rem; line-height: 1.7; color: var(--slate); max-width: 740px; margin: 0 auto;">
                We believe in verifiable engineering facts over inflated claims. Below are detailed breakdowns of actual production systems designed, engineered, and deployed by our senior team.
            </p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 3rem;">
            <!-- CASE STUDY 1: INSAN DEGREE COLLEGE ERP -->
            <div class="card" style="padding: 2.75rem; border-color: rgba(34, 211, 238, 0.25);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <span class="tag-chip" style="color: var(--cyan); border-color: rgba(34, 211, 238, 0.3);">Higher Education & Institutional Operations</span>
                        <h2 style="font-size: 1.85rem; margin-top: 0.5rem; color: var(--white);">Insan Degree College — Institutional ERP & Fee Portal</h2>
                        <a href="https://erpinsandegreeclg.codex404solutions.online" target="_blank" rel="noopener noreferrer" style="font-size: 0.85rem; color: var(--cyan); text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; margin-top: 0.35rem; font-family: var(--font-mono);">
                            <span>erpinsandegreeclg.codex404solutions.online</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.85rem; color: var(--slate-dark); display: block;">Tech Stack: PHP 8.2 • MySQL 8 • Granular RBAC • DomPDF</span>
                        <a href="https://insandegreeclg.codex404solutions.online" target="_blank" rel="noopener noreferrer" style="font-size: 0.8rem; color: #94A3B8; text-decoration: none; margin-top: 0.35rem; display: inline-flex; align-items: center; gap: 0.25rem;">
                            <span>insandegreeclg.codex404solutions.online</span> ↗
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2" style="margin-bottom: 1.75rem; gap: 2rem;">
                    <div style="background: rgba(239, 68, 68, 0.03); padding: 1.5rem; border-radius: var(--radius-md); border-left: 3px solid #F87171;">
                        <h4 style="color: #F87171; margin-bottom: 0.5rem; font-size: 1.1rem;">The Operational Bottleneck</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6; color: var(--slate);">
                            College administrative staff managed degree student enrollments, exam records, and fee collections across disjointed physical ledgers and fragmented spreadsheets. Generating term-end fee reconciliation reports required over 10 days of clerical work, leading to payment disputes and delayed auditing.
                        </p>
                    </div>
                    <div style="background: rgba(52, 211, 153, 0.03); padding: 1.5rem; border-radius: var(--radius-md); border-left: 3px solid #34D399;">
                        <h4 style="color: #34D399; margin-bottom: 0.5rem; font-size: 1.1rem;">The Engineering Solution</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6; color: var(--slate);">
                            Engineered a centralized, web-based College ERP platform with granular Role-Based Access Control (SuperAdmin, Accountant, Teacher, Student). Automated fee receipts generation, real-time pending dues tracking, and secure CSV/PDF export pipelines with atomic database transactions.
                        </p>
                    </div>
                </div>

                <div style="background: rgba(7, 17, 31, 0.6); padding: 1.25rem 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div class="card-tags" style="border: none; padding: 0; margin: 0;">
                        <span class="tag-chip">Fee Reconciliation</span>
                        <span class="tag-chip">Granular RBAC</span>
                        <span class="tag-chip">PDF Generation</span>
                        <span class="tag-chip">Zero Data Collision</span>
                    </div>
                    <div style="color: #34D399; font-weight: 700; font-size: 0.95rem;">
                        ✓ Reconciliation time dropped from 10 days to under 15 minutes
                    </div>
                </div>
            </div>

            <!-- CASE STUDY 2: CENTRAL MEDICAL CLINIC -->
            <div class="card" style="padding: 2.75rem; border-color: rgba(34, 211, 238, 0.25);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <span class="tag-chip" style="color: var(--cyan); border-color: rgba(34, 211, 238, 0.3);">Healthcare Systems & Clinical Operations</span>
                        <h2 style="font-size: 1.85rem; margin-top: 0.5rem; color: var(--white);">Central Medical — Clinical OPD & Healthcare Management</h2>
                        <a href="https://centralmedicall.com" target="_blank" rel="noopener noreferrer" style="font-size: 0.85rem; color: var(--cyan); text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; margin-top: 0.35rem; font-family: var(--font-mono);">
                            <span>centralmedicall.com</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.85rem; color: var(--slate-dark); display: block;">Tech Stack: PHP 8.2 • MySQL 8 • Atomic Slot Locks • SMS Alerts</span>
                    </div>
                </div>

                <div class="grid grid-cols-2" style="margin-bottom: 1.75rem; gap: 2rem;">
                    <div style="background: rgba(239, 68, 68, 0.03); padding: 1.5rem; border-radius: var(--radius-md); border-left: 3px solid #F87171;">
                        <h4 style="color: #F87171; margin-bottom: 0.5rem; font-size: 1.1rem;">The Operational Bottleneck</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6; color: var(--slate);">
                            Front-desk staff handling telephone bookings suffered daily double-booked consultation slots across specialist doctors, creating patient queues, long waiting room delays, and dissatisfied patients.
                        </p>
                    </div>
                    <div style="background: rgba(52, 211, 153, 0.03); padding: 1.5rem; border-radius: var(--radius-md); border-left: 3px solid #34D399;">
                        <h4 style="color: #34D399; margin-bottom: 0.5rem; font-size: 1.1rem;">The Engineering Solution</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6; color: var(--slate);">
                            Architected a multi-specialist clinical OPD booking engine with atomic reservation locks, doctor duty calendars, automated SMS appointment confirmations, and digital prescription history lookup.
                        </p>
                    </div>
                </div>

                <div style="background: rgba(7, 17, 31, 0.6); padding: 1.25rem 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div class="card-tags" style="border: none; padding: 0; margin: 0;">
                        <span class="tag-chip">OPD Booking Engine</span>
                        <span class="tag-chip">Atomic Slot Locking</span>
                        <span class="tag-chip">Doctor Portals</span>
                        <span class="tag-chip">SMS Automation</span>
                    </div>
                    <div style="color: #34D399; font-weight: 700; font-size: 0.95rem;">
                        ✓ Zero appointment collisions; front-desk wait times reduced by 50%
                    </div>
                </div>
            </div>

            <!-- CASE STUDY 3: TENDER APPLIANCES -->
            <div class="card" style="padding: 2.75rem; border-color: rgba(34, 211, 238, 0.25);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <span class="tag-chip" style="color: var(--cyan); border-color: rgba(34, 211, 238, 0.3);">Commerce & Wholesale Engine</span>
                        <h2 style="font-size: 1.85rem; margin-top: 0.5rem; color: var(--white);">Tender Appliances — Home & Kitchen Commercial Commerce</h2>
                        <a href="https://tenderappliances.in" target="_blank" rel="noopener noreferrer" style="font-size: 0.85rem; color: var(--cyan); text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; margin-top: 0.35rem; font-family: var(--font-mono);">
                            <span>tenderappliances.in</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.85rem; color: var(--slate-dark); display: block;">Tech Stack: PHP 8.2 • MySQL 8 • Automated GST • Fast Checkout</span>
                    </div>
                </div>

                <div class="grid grid-cols-2" style="margin-bottom: 1.75rem; gap: 2rem;">
                    <div style="background: rgba(239, 68, 68, 0.03); padding: 1.5rem; border-radius: var(--radius-md); border-left: 3px solid #F87171;">
                        <h4 style="color: #F87171; margin-bottom: 0.5rem; font-size: 1.1rem;">The Operational Bottleneck</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6; color: var(--slate);">
                            Wholesale buyers and retail customers faced checkout delays, slow catalog searches, and disconnected manual invoicing workflows that slowed fulfillment and led to abandoned orders.
                        </p>
                    </div>
                    <div style="background: rgba(52, 211, 153, 0.03); padding: 1.5rem; border-radius: var(--radius-md); border-left: 3px solid #34D399;">
                        <h4 style="color: #34D399; margin-bottom: 0.5rem; font-size: 1.1rem;">The Engineering Solution</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6; color: var(--slate);">
                            Built a fast, modern digital commerce platform with tiered volume discounts, real-time inventory validation, automated GST invoice generation, and seamless payment workflows.
                        </p>
                    </div>
                </div>

                <div style="background: rgba(7, 17, 31, 0.6); padding: 1.25rem 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div class="card-tags" style="border: none; padding: 0; margin: 0;">
                        <span class="tag-chip">Automated GST Invoicing</span>
                        <span class="tag-chip">Atomic Inventory Locking</span>
                        <span class="tag-chip">Payment Gateway</span>
                        <span class="tag-chip">Mobile First</span>
                    </div>
                    <div style="color: #34D399; font-weight: 700; font-size: 0.95rem;">
                        ✓ Zero stock discrepancies; order checkout turnaround reduced by 75%
                    </div>
                </div>
            </div>

            <!-- CASE STUDY 4: WHEELCRAFT AUTOMOTIVE -->
            <div class="card" style="padding: 2.75rem; border-color: rgba(34, 211, 238, 0.25);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <span class="tag-chip" style="color: var(--cyan); border-color: rgba(34, 211, 238, 0.3);">Automotive Products & Wholesale Catalog</span>
                        <h2 style="font-size: 1.85rem; margin-top: 0.5rem; color: var(--white);">Wheelcraft — Automotive Products & Wheel Fitment Engine</h2>
                        <a href="https://wheelcraft.codex404solutions.online" target="_blank" rel="noopener noreferrer" style="font-size: 0.85rem; color: var(--cyan); text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; margin-top: 0.35rem; font-family: var(--font-mono);">
                            <span>wheelcraft.codex404solutions.online</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.85rem; color: var(--slate-dark); display: block;">Tech Stack: PHP 8.2 • Vehicle Fitment Matrix • Instant WhatsApp Ingestion</span>
                    </div>
                </div>

                <div class="grid grid-cols-2" style="margin-bottom: 1.75rem; gap: 2rem;">
                    <div style="background: rgba(239, 68, 68, 0.03); padding: 1.5rem; border-radius: var(--radius-md); border-left: 3px solid #F87171;">
                        <h4 style="color: #F87171; margin-bottom: 0.5rem; font-size: 1.1rem;">The Operational Bottleneck</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6; color: var(--slate);">
                            Automotive wheel distributors struggled to explain complex rim PCD, offset, and vehicle compatibility specs over phone calls, causing incorrect wheel orders and high return rates.
                        </p>
                    </div>
                    <div style="background: rgba(52, 211, 153, 0.03); padding: 1.5rem; border-radius: var(--radius-md); border-left: 3px solid #34D399;">
                        <h4 style="color: #34D399; margin-bottom: 0.5rem; font-size: 1.1rem;">The Engineering Solution</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6; color: var(--slate);">
                            Engineered an interactive vehicle-fitment matrix where customers and dealers filter alloy wheels by exact car make and model, view high-res specs, and dispatch instant purchase inquiries.
                        </p>
                    </div>
                </div>

                <div style="background: rgba(7, 17, 31, 0.6); padding: 1.25rem 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div class="card-tags" style="border: none; padding: 0; margin: 0;">
                        <span class="tag-chip">Vehicle Fitment Engine</span>
                        <span class="tag-chip">Alloy Catalog</span>
                        <span class="tag-chip">Wholesale Inquiries</span>
                        <span class="tag-chip">Sub-150ms Response</span>
                    </div>
                    <div style="color: #34D399; font-weight: 700; font-size: 0.95rem;">
                        ✓ 100% fitment accuracy; inquiry conversions increased by 85%
                    </div>
                </div>
            </div>

            <!-- CASE STUDY 5: TURNKEY BOOKING & APPOINTMENT SYSTEMS -->
            <div class="card" style="padding: 2.75rem; border-color: rgba(6, 214, 160, 0.35); box-shadow: 0 10px 30px rgba(6, 214, 160, 0.08);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                    <div>
                        <span class="tag-chip" style="color: #06D6A0; border-color: rgba(6, 214, 160, 0.4);">Healthcare, Wellness & Hospitality Automation</span>
                        <h2 style="font-size: 1.85rem; margin-top: 0.5rem; color: var(--white);">Turnkey Appointment & Booking Platforms (Dental, Salon, Parlour & Restaurant)</h2>
                        <a href="https://smiledental.codex404solutions.online" target="_blank" rel="noopener noreferrer" style="font-size: 0.85rem; color: var(--cyan); text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; margin-top: 0.35rem; font-family: var(--font-mono);">
                            <span>smiledental.codex404solutions.online</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                        </a>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.85rem; color: var(--slate-dark); display: block;">Tech Stack: PHP 8.4 • MySQL Transactions • WhatsApp Webhooks • Redis Slot Locks</span>
                        <span style="font-size: 0.8rem; color: #94A3B8; display: block; margin-top: 0.25rem;">Multi-Tenant & Mobile Responsive</span>
                    </div>
                </div>

                <div class="grid grid-cols-2" style="margin-bottom: 1.75rem; gap: 2rem;">
                    <div style="background: rgba(239, 68, 68, 0.03); padding: 1.5rem; border-radius: var(--radius-md); border-left: 3px solid #F87171;">
                        <h4 style="color: #F87171; margin-bottom: 0.5rem; font-size: 1.1rem;">The Operational Bottleneck</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6; color: var(--slate);">
                            Dental practices, hair styling salons, luxury beauty parlours, and high-volume dining restaurants struggled with manual phone-desk booking bottlenecks, chair collisions, late cancellations, and idle staff hours that drained 20–30% of potential revenue.
                        </p>
                    </div>
                    <div style="background: rgba(52, 211, 153, 0.03); padding: 1.5rem; border-radius: var(--radius-md); border-left: 3px solid #34D399;">
                        <h4 style="color: #34D399; margin-bottom: 0.5rem; font-size: 1.1rem;">The Engineering Solution</h4>
                        <p style="font-size: 0.925rem; line-height: 1.6; color: var(--slate);">
                            Engineered high-concurrency booking architectures featuring atomic database slot locking, doctor/stylist allocation, treatment package menus, table floor plan maps, deposit checkout protection, and instant multi-channel WhatsApp/SMS appointment confirmations.
                        </p>
                    </div>
                </div>

                <div style="background: rgba(7, 17, 31, 0.6); padding: 1.25rem 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div class="card-tags" style="border: none; padding: 0; margin: 0;">
                        <span class="tag-chip">Slot-Lock Guard</span>
                        <span class="tag-chip">Doctor / Chair Allocation</span>
                        <span class="tag-chip">Interactive Floor Plan</span>
                        <span class="tag-chip">WhatsApp Alerts</span>
                        <span class="tag-chip">Sub-30s Booking Flow</span>
                    </div>
                    <div style="color: #34D399; font-weight: 700; font-size: 0.95rem;">
                        ✓ Zero double-bookings; 98.7% verified customer arrival rate
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LIVE DEMO SANDBOX BANNER -->
<section class="section" style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container" style="text-align: center;">
        <div style="max-width: 680px; margin: 0 auto;">
            <span class="tag-chip" style="margin-bottom: 1rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">In-Browser Sandbox</span>
            <h3 style="font-size: 1.85rem; color: var(--white); margin-bottom: 1rem;">Test These Systems Live Right Now</h3>
            <p style="font-size: 1rem; color: var(--slate); line-height: 1.6; margin-bottom: 2rem;">
                Don't just take our word for it. Launch our interactive in-browser simulators to test our AI RAG knowledge retrieval, WhatsApp webhook automation pipeline, and School ERP dashboard live.
            </p>
            <a href="<?= url('index.php#projects') ?>" class="btn btn-primary" style="padding: 0.9rem 2.25rem;">Launch Interactive Demos ⚡</a>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Have a Business Bottleneck Ready for a Tailored Engineering Solution?";
$ctaSubtitle = "Let's review your current workflow challenges and design a custom software or automation solution with clear milestones and budget.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
