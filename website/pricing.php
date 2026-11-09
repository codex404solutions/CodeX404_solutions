<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/security.php';

$pageMeta = [
    'title' => 'Transparent Engineering & Booking System Pricing | CodeX404 Solutions',
    'description' => 'Clear, milestone-based investment tiers for custom software, turnkey booking & appointment platforms (Dental, Salon, Beauty, Restaurant), and enterprise AI systems.',
    'canonical' => url('pricing.php'),
    'keywords' => 'custom software pricing, booking system cost, dental appointment system pricing, salon booking software, restaurant reservation system, web development rates'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- ==========================================================================
     HERO SECTION
     ========================================================================== -->
<section class="page-hero-section" style="padding-top: calc(var(--nav-height) + 3.5rem); padding-bottom: 3rem; text-align: center;">
    <div class="container" style="max-width: 900px; margin: 0 auto;">
        <div class="hero-pill" style="margin: 0 auto 1.5rem auto;">
            <span class="dot"></span>
            <span>Transparent Investment • Zero Hidden Hourly Fees</span>
        </div>

        <h1 class="hero-headline" style="font-size: clamp(2.25rem, 4.2vw, 3.5rem); margin-bottom: 1.25rem;">
            Transparent Investment for <span class="text-gradient gradient-text-animated">Production Systems</span>
        </h1>

        <p class="hero-description" style="margin: 0 auto 2.25rem auto; font-size: 1.15rem; color: var(--slate); max-width: 720px; line-height: 1.7;">
            Milestone-based delivery, 100% intellectual property ownership, and direct senior engineering pedigree. No surprise billable hours, no junior handoffs.
        </p>

        <div class="hero-cta-group" style="justify-content: center; gap: 1rem;">
            <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-lg">
                <span>📅 Book a Discovery Call</span>
            </a>
            <a href="<?= url('contact.php') ?>" class="btn btn-secondary btn-lg">
                <span>Request Custom Quote &rarr;</span>
            </a>
        </div>
    </div>
</section>

<!-- ==========================================================================
     CORE GUARANTEES STRIP
     ========================================================================== -->
<section class="section" style="padding-top: 0; padding-bottom: 2rem;">
    <div class="container">
        <div class="pricing-guarantee-strip">
            <div class="guarantee-item">
                <span class="guarantee-icon">🛡️</span>
                <div>
                    <h3 class="guarantee-title">100% Client IP Ownership</h3>
                    <p class="guarantee-desc">All source code, Docker configs, databases, and schemas belong entirely to you from day one.</p>
                </div>
            </div>
            <div class="guarantee-item">
                <span class="guarantee-icon">🎯</span>
                <div>
                    <h3 class="guarantee-title">Zero Hidden Hourly Bills</h3>
                    <p class="guarantee-desc">Milestone-based fixed quotes tied to concrete functional deliverables, not open-ended clock ticking.</p>
                </div>
            </div>
            <div class="guarantee-item">
                <span class="guarantee-icon">⚡</span>
                <div>
                    <h3 class="guarantee-title">Where Bugs Meet Their Match</h3>
                    <p class="guarantee-desc">Automated CI/CD pipelines, strict type-checking, and enterprise-grade performance optimization.</p>
                </div>
            </div>
            <div class="guarantee-item">
                <span class="guarantee-icon">📱</span>
                <div>
                    <h3 class="guarantee-title">Fluid Mobile Responsiveness</h3>
                    <p class="guarantee-desc">Every view tested across modern phones, tablets, and desktops with zero horizontal scroll.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     PRICING TIERS GRID
     ========================================================================== -->
<section class="section" style="padding-top: 1rem; padding-bottom: 4rem;">
    <div class="container">
        <div class="section-header" style="text-align: center; max-width: 800px; margin: 0 auto 3rem auto;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Select Your Engineering Tier</span>
            </div>
            <h2 class="section-title">
                Engineered for High-Velocity <span class="text-gradient gradient-text-animated">ROI & Performance</span>
            </h2>
            <p class="section-subtitle">
                Whether you need a dedicated turnkey booking engine, a high-converting digital portal, or a full enterprise platform.
            </p>
        </div>

        <div class="pricing-grid-modern">

            <!-- Tier 1: Diagnostic & Architecture -->
            <article class="price-card-modern">
                <div class="price-card-top">
                    <span class="price-category-tag">🔍 Assessment</span>
                    <h3 class="price-card-title">System Diagnostic</h3>
                    <p class="price-card-desc">Find performance bottlenecks, UX drop-offs, and security vulnerabilities before committing to a full rebuild.</p>
                </div>

                <div class="price-amount-box">
                    <span class="price-amount-val">$750</span>
                    <span class="price-amount-period">/ fixed audit</span>
                </div>

                <ul class="price-feature-list">
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Full Core Web Vitals & performance audit</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Conversion friction & mobile UX breakdown</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Prioritized code & database fix roadmap</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Executive architecture action brief</span>
                    </li>
                </ul>

                <div class="price-card-footer">
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-secondary" style="width: 100%; text-align: center;">
                        <span>Book Diagnostic</span>
                    </a>
                </div>
            </article>

            <!-- Tier 2: Turnkey Booking Systems (FEATURED) -->
            <article class="price-card-modern featured">
                <span class="price-pill-badge">Most In-Demand</span>
                <div class="price-card-top">
                    <span class="price-category-tag">📅 Turnkey Booking</span>
                    <h3 class="price-card-title">Booking & Reservation Suite</h3>
                    <p class="price-card-desc">Full-featured appointment & reservation systems engineered for Dental Clinics, Hair Salons, Spas & Restaurants.</p>
                </div>

                <div class="price-amount-box">
                    <span class="price-amount-val">$2,500 – $6,500</span>
                    <span class="price-amount-period">/ 2–4 weeks turnkey</span>
                </div>

                <ul class="price-feature-list">
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Dental Clinic:</strong> Doctor slot allocation & treatment token engine</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Hair Salon & Spa:</strong> Stylist chair selection & real-time calendar sync</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Beauty Parlour:</strong> Custom treatment packages & deposit gate</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span><strong>Restaurant:</strong> Interactive table floor plan & menu pre-ordering</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Automated WhatsApp & SMS appointment notifications</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Zero double-booking guarantee via transactional DB locks</span>
                    </li>
                </ul>

                <div class="price-card-footer">
                    <a href="<?= url('contact.php?interest=booking-system') ?>" class="btn btn-primary" style="width: 100%; text-align: center;">
                        <span>Launch Your Booking System 🚀</span>
                    </a>
                </div>
            </article>

            <!-- Tier 3: Conversion Sprint / Custom Portal -->
            <article class="price-card-modern">
                <div class="price-card-top">
                    <span class="price-category-tag">⚡ High Velocity</span>
                    <h3 class="price-card-title">Conversion Sprint</h3>
                    <p class="price-card-desc">Rebuild one mission-critical customer journey or launch a high-impact responsive business platform.</p>
                </div>

                <div class="price-amount-box">
                    <span class="price-amount-val">$5k – $12k</span>
                    <span class="price-amount-period">/ 3–5 weeks</span>
                </div>

                <ul class="price-feature-list">
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Custom UI/UX with neon accents & smooth animations</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>100% mobile responsive & sub-second load times</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Lead routing, CRM hooks & analytics instrumentation</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>End-to-end deployment with Docker & SSL</span>
                    </li>
                </ul>

                <div class="price-card-footer">
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-secondary" style="width: 100%; text-align: center;">
                        <span>Plan a Sprint</span>
                    </a>
                </div>
            </article>

            <!-- Tier 4: Enterprise Platform / SaaS Build -->
            <article class="price-card-modern">
                <div class="price-card-top">
                    <span class="price-category-tag">🏢 Custom Architecture</span>
                    <h3 class="price-card-title">Full Enterprise SaaS</h3>
                    <p class="price-card-desc">End-to-end custom application architecture, multi-role access, database design, and autonomous AI pipelines.</p>
                </div>

                <div class="price-amount-box">
                    <span class="price-amount-val">$15k – $45k</span>
                    <span class="price-amount-period">/ 6–12 weeks</span>
                </div>

                <ul class="price-feature-list">
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Custom backend architecture (PHP 8.4, Python, Node)</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Role-based access control (RBAC) & tenant isolation</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Integrated AI pipelines (RAG, WhatsApp webhooks, OCR)</span>
                    </li>
                    <li class="price-feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        <span>Continuous CI/CD pipeline, staging & production servers</span>
                    </li>
                </ul>

                <div class="price-card-footer">
                    <a href="<?= url('discovery-call.php') ?>" class="btn btn-secondary" style="width: 100%; text-align: center;">
                        <span>Scope Enterprise Build</span>
                    </a>
                </div>
            </article>

        </div>
    </div>
</section>

<!-- ==========================================================================
     DIRECT CALL TO ACTION BANNER
     ========================================================================== -->
<section class="section" style="padding-top: 0; padding-bottom: 4rem;">
    <div class="container">
        <div style="background: linear-gradient(135deg, rgba(16, 29, 58, 0.9) 0%, rgba(10, 22, 40, 0.95) 100%); border: 1px solid rgba(0, 240, 255, 0.3); border-radius: var(--radius-xl); padding: 3rem 2.5rem; text-align: center; position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 220px; height: 220px; background: radial-gradient(circle, rgba(0, 240, 255, 0.15) 0%, transparent 70%); pointer-events: none;"></div>
            
            <span class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Fast Decision Channel</span>
            </span>

            <h2 style="font-size: clamp(1.8rem, 3.2vw, 2.5rem); font-weight: 800; color: #FFFFFF; margin-bottom: 1rem;">
                Have a Booking System or Custom App in Mind?
            </h2>

            <p style="font-size: 1.1rem; color: var(--slate); max-width: 650px; margin: 0 auto 2rem auto; line-height: 1.6;">
                Message senior lead engineer Muhammad Noukhez directly. We will review your workflow, clarify timelines, and provide an honest architectural estimate within 24 hours.
            </p>

            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <a href="<?= url('discovery-call.php') ?>" class="btn btn-primary btn-lg">
                    <span>📅 Book Discovery Call</span>
                </a>
                <a href="<?= url('contact.php') ?>" class="btn btn-secondary btn-lg">
                    <span>✉️ Send Direct Inquiry</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
     FREQUENTLY ASKED QUESTIONS
     ========================================================================== -->
<section class="section" style="padding-top: 0; padding-bottom: 5rem;">
    <div class="container" style="max-width: 860px;">
        <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Clarity First</span>
            </div>
            <h2 class="section-title">
                Frequently Asked <span class="text-gradient gradient-text-animated">Questions</span>
            </h2>
        </div>

        <div class="faq-accordion-box" style="display: flex; flex-direction: column; gap: 1.25rem;">
            <details style="background: rgba(10, 22, 40, 0.7); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.5rem 1.75rem;">
                <summary style="font-weight: 700; color: #FFFFFF; cursor: pointer; font-size: 1.1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                    <span>How do your Turnkey Booking Systems work for clinics, salons, and restaurants?</span>
                    <span style="color: var(--cyan); font-size: 1.25rem;">+</span>
                </summary>
                <p style="color: var(--slate); margin-top: 1rem; line-height: 1.7; font-size: 0.95rem;">
                    Each booking system is customized around your actual service constraints: slot duration, staff/chair allocation, treatment packages, deposit payments, and automated WhatsApp/SMS booking confirmations. Clients can book directly from mobile in under 30 seconds with zero double-booking risk.
                </p>
            </details>

            <details style="background: rgba(10, 22, 40, 0.7); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.5rem 1.75rem;">
                <summary style="font-weight: 700; color: #FFFFFF; cursor: pointer; font-size: 1.1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                    <span>Who owns the source code and infrastructure?</span>
                    <span style="color: var(--cyan); font-size: 1.25rem;">+</span>
                </summary>
                <p style="color: var(--slate); margin-top: 1rem; line-height: 1.7; font-size: 0.95rem;">
                    You do — 100%. Upon completion and milestone settlement, you receive complete access to the Git repository, Docker containers, database dumps, and deployment configs. There is zero vendor lock-in.
                </p>
            </details>

            <details style="background: rgba(10, 22, 40, 0.7); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.5rem 1.75rem;">
                <summary style="font-weight: 700; color: #FFFFFF; cursor: pointer; font-size: 1.1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                    <span>How do you handle milestone payments?</span>
                    <span style="color: var(--cyan); font-size: 1.25rem;">+</span>
                </summary>
                <p style="color: var(--slate); margin-top: 1rem; line-height: 1.7; font-size: 0.95rem;">
                    We work on transparent, milestone-based installments (typically 30% upfront deposit to commence architecture, 40% upon staging demo deployment, and 30% upon final acceptance, QA sign-off, and production launch).
                </p>
            </details>

            <details style="background: rgba(10, 22, 40, 0.7); border: 1px solid var(--border-subtle); border-radius: var(--radius-md); padding: 1.5rem 1.75rem;">
                <summary style="font-weight: 700; color: #FFFFFF; cursor: pointer; font-size: 1.1rem; list-style: none; display: flex; justify-content: space-between; align-items: center;">
                    <span>Can you integrate with our existing WhatsApp and SMS providers?</span>
                    <span style="color: var(--cyan); font-size: 1.25rem;">+</span>
                </summary>
                <p style="color: var(--slate); margin-top: 1rem; line-height: 1.7; font-size: 0.95rem;">
                    Yes. We natively integrate with Twilio, WhatsApp Business Cloud API, Gupshup, Fast2SMS, and custom webhooks for instant appointment confirmation, reminder pings, and cancellation rescheduling.
                </p>
            </details>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
