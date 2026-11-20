<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$pageMeta = [
    'title' => 'Software & AI Engineering Solutions — Enterprise Capabilities',
    'description' => 'Explore CodeX404 Solutions full-spectrum engineering capabilities: bespoke web applications, autonomous AI agents, enterprise RAG, WhatsApp automation, and scalable SaaS platforms.',
    'canonical' => url('solutions.php'),
    'keywords' => 'software engineering solutions, custom web applications, autonomous AI agents, enterprise RAG, business process automation, SaaS product engineering'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- HERO SECTION -->
<section class="section" style="padding-top: calc(var(--nav-height) + 3rem); padding-bottom: 3rem;">
    <div class="container">
        <div class="section-header" style="max-width: 840px; margin: 0 auto 3rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Full-Stack Engineering Capabilities</span>
            </div>
            <h1 class="section-title"
                style="font-size: clamp(2.25rem, 4vw, 3.25rem); line-height: 1.15; margin-bottom: 1.25rem;">
                Software, AI & Automation Engineered for <span class="gradient-text">Measurable Scale</span>
            </h1>
            <p class="section-subtitle"
                style="font-size: 1.1rem; line-height: 1.7; color: var(--slate); max-width: 720px; margin: 0 auto;">
                We partner with growing enterprises and visionary founders to eliminate operational bottlenecks,
                automate manual friction, and build proprietary digital assets that deliver lasting competitive
                advantages.
            </p>
        </div>

        <!-- Capability Filter Bar -->
        <div style="display: flex; justify-content: center; gap: 0.75rem; margin-bottom: 3.5rem; flex-wrap: wrap;">
            <button type="button" class="btn btn-secondary btn-sm filter-btn active" data-filter="all">All
                Capabilities</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="software">Custom Software &
                ERP</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="ai">AI Systems &
                Agents</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="automation">Workflow
                Automation</button>
            <button type="button" class="btn btn-secondary btn-sm filter-btn" data-filter="saas">SaaS & Cloud
                MVPs</button>
        </div>

        <!-- Solutions Grid (6 Core Pillars) -->
        <div class="grid grid-cols-3" style="gap: 2rem;">
            <!-- 1. Custom Web Applications & Internal Portals -->
            <div class="card card-tilt reveal-on-scroll" data-category="software"
                style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div class="card-icon">💻</div>
                    <h2 class="card-title" style="font-size: 1.35rem; margin-bottom: 0.75rem;">Bespoke Web Applications
                        & Portals</h2>
                    <p class="card-description" style="font-size: 0.925rem; line-height: 1.6; margin-bottom: 1.25rem;">
                        Replace fragmented spreadsheets and rigid off-the-shelf software with tailor-made web platforms.
                        Custom administrative control rooms, customer self-serve portals, and vendor workflows built
                        precisely around your operational rules.
                    </p>
                    <div class="card-tags" style="margin-bottom: 1.5rem;">
                        <span class="tag-chip">Modern PHP 8.2+ / Python</span>
                        <span class="tag-chip">Strict RBAC</span>
                        <span class="tag-chip">Audit Trails</span>
                        <span class="tag-chip">Relational Schemas</span>
                    </div>
                </div>
                <div
                    style="padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= url('software-development.php') ?>" class="card-arrow-link"
                        style="font-weight: 600; color: var(--cyan);">Explore Architecture →</a>
                    <span style="font-size: 0.8rem; color: var(--slate-dark);">Zero Seat Fees</span>
                </div>
            </div>

            <!-- 2. Applied AI & Private Enterprise RAG -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1" data-category="ai"
                style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div class="card-icon">🧠</div>
                    <h2 class="card-title" style="font-size: 1.35rem; margin-bottom: 0.75rem;">Enterprise AI & Private
                        RAG</h2>
                    <p class="card-description" style="font-size: 0.925rem; line-height: 1.6; margin-bottom: 1.25rem;">
                        Build domain-specific assistants that retrieve relevant material from approved company sources.
                        Model data use, access controls, hosting, and answer validation depend on the selected services
                        and implementation.
                    </p>
                    <div class="card-tags" style="margin-bottom: 1.5rem;">
                        <span class="tag-chip">Vector Search (Qdrant)</span>
                        <span class="tag-chip">Grounded Retrieval</span>
                        <span class="tag-chip">Strict Schema Outputs</span>
                        <span class="tag-chip">Self-Hosted VPC</span>
                    </div>
                </div>
                <div
                    style="padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= url('ai-solutions.php') ?>" class="card-arrow-link"
                        style="font-weight: 600; color: var(--cyan);">Explore AI RAG →</a>
                    <span style="font-size: 0.8rem; color: var(--slate-dark);">Private & Isolated</span>
                </div>
            </div>

            <!-- 3. Autonomous AI Agents -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2" data-category="ai"
                style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div class="card-icon">⚡</div>
                    <h2 class="card-title" style="font-size: 1.35rem; margin-bottom: 0.75rem;">Autonomous AI Agents</h2>
                    <p class="card-description" style="font-size: 0.925rem; line-height: 1.6; margin-bottom: 1.25rem;">
                        Move beyond passive Q&A chatbots. We engineer autonomous agents capable of querying internal
                        databases, calling external REST APIs, planning execution paths, and completing multi-step
                        operations with rigorous human approval gates.
                    </p>
                    <div class="card-tags" style="margin-bottom: 1.5rem;">
                        <span class="tag-chip">Function Tool Calling</span>
                        <span class="tag-chip">Approval Gates</span>
                        <span class="tag-chip">Episodic Memory</span>
                        <span class="tag-chip">Deterministic I/O</span>
                    </div>
                </div>
                <div
                    style="padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= url('ai-agents.php') ?>" class="card-arrow-link"
                        style="font-weight: 600; color: var(--cyan);">Explore Agent Systems →</a>
                    <span style="font-size: 0.8rem; color: var(--slate-dark);">Audited Execution</span>
                </div>
            </div>

            <!-- 4. Workflow & Process Automation -->
            <div class="card card-tilt reveal-on-scroll" data-category="automation"
                style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div class="card-icon">🔄</div>
                    <h2 class="card-title" style="font-size: 1.35rem; margin-bottom: 0.75rem;">Workflow & Process
                        Automation</h2>
                    <p class="card-description" style="font-size: 0.925rem; line-height: 1.6; margin-bottom: 1.25rem;">
                        Connect disconnected business tools. Automate lead intake, route customer requests over WhatsApp
                        Cloud API, trigger instant billing receipts, and eliminate hours of manual copy-pasting between
                        systems.
                    </p>
                    <div class="card-tags" style="margin-bottom: 1.5rem;">
                        <span class="tag-chip">WhatsApp Cloud API</span>
                        <span class="tag-chip">Idempotent Webhooks</span>
                        <span class="tag-chip">Automated Billing</span>
                        <span class="tag-chip">Queue Retries</span>
                    </div>
                </div>
                <div
                    style="padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= url('automation.php') ?>" class="card-arrow-link"
                        style="font-weight: 600; color: var(--cyan);">Explore Automation →</a>
                    <span style="font-size: 0.8rem; color: var(--slate-dark);">Direct Routing</span>
                </div>
            </div>

            <!-- 5. Cross-Platform Mobile Applications -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1" data-category="software"
                style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div class="card-icon">📱</div>
                    <h2 class="card-title" style="font-size: 1.35rem; margin-bottom: 0.75rem;">Mobile Applications &
                        PWAs</h2>
                    <p class="card-description" style="font-size: 0.925rem; line-height: 1.6; margin-bottom: 1.25rem;">
                        High-performance mobile solutions built for field teams, customer engagement, and distribution.
                        Engineered with offline-first local storage, biometric security, push notifications, and
                        background synchronization.
                    </p>
                    <div class="card-tags" style="margin-bottom: 1.5rem;">
                        <span class="tag-chip">iOS & Android</span>
                        <span class="tag-chip">Offline SQLite Sync</span>
                        <span class="tag-chip">Push Notifications</span>
                        <span class="tag-chip">Biometric Auth</span>
                    </div>
                </div>
                <div
                    style="padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= url('mobile-apps.php') ?>" class="card-arrow-link"
                        style="font-weight: 600; color: var(--cyan);">Explore Mobile Apps →</a>
                    <span style="font-size: 0.8rem; color: var(--slate-dark);">Offline-First</span>
                </div>
            </div>

            <!-- 6. SaaS & Rapid MVP Development -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2" data-category="saas"
                style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div class="card-icon">🚀</div>
                    <h2 class="card-title" style="font-size: 1.35rem; margin-bottom: 0.75rem;">SaaS Product Engineering
                        & MVPs</h2>
                    <p class="card-description" style="font-size: 0.925rem; line-height: 1.6; margin-bottom: 1.25rem;">
                        Scope and develop SaaS products around the intended users, business model, data boundaries, and
                        operational needs. Integrations and delivery milestones are agreed for each engagement.
                    </p>
                    <div class="card-tags" style="margin-bottom: 1.5rem;">
                        <span class="tag-chip">Scoped Delivery Plan</span>
                        <span class="tag-chip">Multi-Tenancy RLS</span>
                        <span class="tag-chip">Recurring Billing</span>
                        <span class="tag-chip">Written Ownership Terms</span>
                    </div>
                </div>
                <div
                    style="padding-top: 1rem; border-top: 1px solid var(--border-subtle); display: flex; justify-content: space-between; align-items: center;">
                    <a href="<?= url('saas.php') ?>" class="card-arrow-link"
                        style="font-weight: 600; color: var(--cyan);">Explore SaaS Delivery →</a>
                    <span style="font-size: 0.8rem; color: var(--slate-dark);">Fast Time-to-Market</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- COMPARISON SECTION: OFF-THE-SHELF VS CODEX404 BESPOKE ENGINEERING -->
<section class="section"
    style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle);">
    <div class="container">
        <div class="section-header" style="max-width: 780px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Strategic Advantage</span>
            </div>
            <h2 class="section-title">Why Global Companies Choose Bespoke Engineering</h2>
            <p class="section-subtitle">
                Compare the hidden operational friction of generic subscriptions against custom software built to your
                exact specifications.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2rem;">
            <!-- Off-the-Shelf Compromise -->
            <div class="card" style="border-color: rgba(239, 68, 68, 0.3); background: rgba(239, 68, 68, 0.03);">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <span style="font-size: 1.5rem;">❌</span>
                    <h3 style="color: #F87171; font-size: 1.35rem; margin: 0;">Generic Off-The-Shelf SaaS</h3>
                </div>
                <ul
                    style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1rem; font-size: 0.925rem; color: var(--slate);">
                    <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <span style="color: #F87171; font-weight: bold;">✕</span>
                        <span><strong>Expensive Seat-Based Penalties:</strong> Costs multiply each time you hire staff,
                            disincentivizing company growth.</span>
                    </li>
                    <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <span style="color: #F87171; font-weight: bold;">✕</span>
                        <span><strong>Rigid Workflows:</strong> Forces your unique operational process into someone
                            else's rigid cookie-cutter software model.</span>
                    </li>
                    <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <span style="color: #F87171; font-weight: bold;">✕</span>
                        <span><strong>Ownership terms:</strong> Confirm licenses, source code handoff, and ownership in
                            the project agreement.</span>
                    </li>
                    <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <span style="color: #F87171; font-weight: bold;">✕</span>
                        <span><strong>Vendor Lock-In:</strong> Your proprietary customer records and workflows are
                            trapped behind closed third-party databases.</span>
                    </li>
                </ul>
            </div>

            <!-- CodeX404 Bespoke Engineering -->
            <div class="card"
                style="border-color: rgba(34, 211, 238, 0.4); background: rgba(34, 211, 238, 0.04); box-shadow: 0 10px 30px -10px rgba(34, 211, 238, 0.15);">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <span style="font-size: 1.5rem;">✨</span>
                    <h3 style="color: var(--cyan); font-size: 1.35rem; margin: 0;">CodeX404 Tailored Architecture</h3>
                </div>
                <ul
                    style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1rem; font-size: 0.925rem; color: var(--slate);">
                    <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <span style="color: #34D399; font-weight: bold;">✓</span>
                        <span><strong>Zero Recurring Per-User Tax:</strong> Unlimited employees, contractors, and
                            clients without paying a cent extra.</span>
                    </li>
                    <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <span style="color: #34D399; font-weight: bold;">✓</span>
                        <span><strong>Built Around Your Workflow:</strong> Define user workflows and training needs
                            during discovery and reflect them in the agreed scope.</span>
                    </li>
                    <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <span style="color: #34D399; font-weight: bold;">✓</span>
                        <span><strong>Written ownership terms:</strong> Agree on source code, assets, licenses, and
                            handoff responsibilities in the project agreement.</span>
                    </li>
                    <li style="display: flex; gap: 0.75rem; align-items: flex-start;">
                        <span style="color: #34D399; font-weight: bold;">✓</span>
                        <span><strong>Full Sovereignty & Security:</strong> Host in your own private cloud (AWS,
                            DigitalOcean, Hetzner) under strict compliance.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ARCHITECTURE STANDARDS -->
<section class="section">
    <div class="container">
        <div class="section-header" style="max-width: 800px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Engineering Philosophy</span>
            </div>
            <h2 class="section-title">The Four Non-Negotiable Standards of Every CodeX404 System</h2>
            <p class="section-subtitle">
                We believe software should be defensive, maintainable, and built to withstand real production loads from
                day one.
            </p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <div class="card" style="padding: 2rem;">
                <div style="font-size: 1.75rem; color: var(--cyan); font-weight: 800; margin-bottom: 0.75rem;">01</div>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.5rem;">Defensive Security</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    Strict input sanitization, parameterized SQL queries, CSRF validation tokens, and OWASP Top 10
                    mitigation standard on every endpoint.
                </p>
            </div>

            <div class="card" style="padding: 2rem;">
                <div style="font-size: 1.75rem; color: var(--cyan); font-weight: 800; margin-bottom: 0.75rem;">02</div>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.5rem;">Modular Architecture</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    Separation of concerns, clean interfaces, and isolated database layers ensure your application can
                    scale horizontally without architectural rewrites.
                </p>
            </div>

            <div class="card" style="padding: 2rem;">
                <div style="font-size: 1.75rem; color: var(--cyan); font-weight: 800; margin-bottom: 0.75rem;">03</div>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.5rem;">Deterministic Speed</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    Optimized database indexing, minimal script overhead, and caching strategies designed to minimize
                    page latency and maximize Core Web Vitals.
                </p>
            </div>

            <div class="card" style="padding: 2rem;">
                <div style="font-size: 1.75rem; color: var(--cyan); font-weight: 800; margin-bottom: 0.75rem;">04</div>
                <h3 style="color: var(--white); font-size: 1.15rem; margin-bottom: 0.5rem;">Full Asset Handover</h3>
                <p style="font-size: 0.875rem; line-height: 1.6; color: var(--slate);">
                    Comprehensive architecture documentation, automated deployment scripts, and complete Git repository
                    transfer upon project milestone delivery.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ENTERPRISE CLOUD & TECH STACK ECOSYSTEM -->
<section class="section"
    style="background: rgba(11, 31, 58, 0.35); border-top: 1px solid var(--border-subtle); border-bottom: 1px solid var(--border-subtle); padding: 5rem 0;">
    <div class="container">
        <div class="section-header" style="max-width: 820px; margin: 0 auto 3.5rem auto; text-align: center;">
            <div class="section-tag" style="margin: 0 auto 1.25rem auto;">
                <span class="dot"></span>
                <span>Production Technology Stack</span>
            </div>
            <h2 class="section-title">
                Enterprise Cloud &amp; <span class="gradient-text">Engineering Ecosystem</span>
            </h2>
            <p class="section-subtitle">
                We build on battle-tested, type-safe technologies engineered for 99.9% uptime, zero vendor lock-in, and
                horizontal cloud scalability.
            </p>
        </div>

        <div class="grid grid-cols-4" style="gap: 1.5rem;">
            <!-- Category 1: Cloud & Edge -->
            <div class="card card-tilt reveal-on-scroll" style="padding: 2.25rem;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">☁️</div>
                <h3 style="color: var(--white); font-size: 1.2rem; margin-bottom: 0.75rem;">Cloud &amp; Edge Compute
                </h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6; margin-bottom: 1.25rem;">
                    Resilient cloud topologies with automated containerization, edge routing, and zero-downtime
                    rollouts.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Microsoft Azure</span>
                    <span class="tag-chip">AWS Cloud</span>
                    <span class="tag-chip">Cloudflare Edge</span>
                    <span class="tag-chip">Docker</span>
                    <span class="tag-chip">DigitalOcean</span>
                </div>
            </div>

            <!-- Category 2: Databases -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-1" style="padding: 2.25rem;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🗄️</div>
                <h3 style="color: var(--white); font-size: 1.2rem; margin-bottom: 0.75rem;">Data &amp; Persistence</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6; margin-bottom: 1.25rem;">
                    ACID-compliant relational schemas with sub-millisecond in-memory caching and zero concurrency
                    collisions.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">MySQL 8 InnoDB</span>
                    <span class="tag-chip">PostgreSQL</span>
                    <span class="tag-chip">Redis Caching</span>
                    <span class="tag-chip">PDO Prepared</span>
                    <span class="tag-chip">Row-Level Locks</span>
                </div>
            </div>

            <!-- Category 3: AI & Vector -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-2" style="padding: 2.25rem;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">🤖</div>
                <h3 style="color: var(--white); font-size: 1.2rem; margin-bottom: 0.75rem;">Enterprise AI &amp; RAG</h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6; margin-bottom: 1.25rem;">
                    Private Retrieval-Augmented Generation with strict semantic grounding thresholds and zero data
                    training leaks.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Azure OpenAI</span>
                    <span class="tag-chip">Qdrant Vector DB</span>
                    <span class="tag-chip">pgvector</span>
                    <span class="tag-chip">LangChain</span>
                    <span class="tag-chip">Gemini / Claude</span>
                </div>
            </div>

            <!-- Category 4: APIs & Integrations -->
            <div class="card card-tilt reveal-on-scroll reveal-delay-3" style="padding: 2.25rem;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">⚡</div>
                <h3 style="color: var(--white); font-size: 1.2rem; margin-bottom: 0.75rem;">APIs &amp; Orchestration
                </h3>
                <p style="font-size: 0.875rem; color: var(--slate); line-height: 1.6; margin-bottom: 1.25rem;">
                    Mission-critical enterprise integrations for billing, omnichannel communications, and automated
                    event queues.
                </p>
                <div class="card-tags">
                    <span class="tag-chip">Meta WhatsApp API</span>
                    <span class="tag-chip">Stripe Billing</span>
                    <span class="tag-chip">Razorpay</span>
                    <span class="tag-chip">REST / GraphQL</span>
                    <span class="tag-chip">n8n Workflows</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- LIVE DEMO SANDBOX CALLOUT -->
<section class="section"
    style="background: radial-gradient(circle at 50% 50%, rgba(34, 211, 238, 0.08) 0%, transparent 70%); padding: 3rem 0; border-top: 1px solid var(--border-subtle);">
    <div class="container" style="text-align: center;">
        <div style="max-width: 680px; margin: 0 auto;">
            <span class="tag-chip"
                style="margin-bottom: 1rem; color: var(--cyan); border-color: rgba(34, 211, 238, 0.4);">Try Before You
                Build</span>
            <h3 style="font-size: 1.85rem; color: var(--white); margin-bottom: 1rem;">Experience Our Live Interactive
                Engineering Demos</h3>
            <p style="font-size: 1rem; color: var(--slate); line-height: 1.6; margin-bottom: 2rem;">
                Test our live AI RAG knowledge retrieval, WhatsApp webhook automation pipeline, School ERP portal, and
                B2B ordering engine directly inside your browser right now.
            </p>
            <div style="display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap;">
                <a href="<?= url('index.php#simulators') ?>" class="btn btn-primary">Launch Interactive Demos ⚡</a>
                <a href="<?= url('contact.php') ?>" class="btn btn-secondary">Request Custom Scope &amp; Estimate</a>
            </div>
        </div>
    </div>
</section>

<?php
$ctaHeading = "Unsure Which Architectural Path Fits Your Roadmap?";
$ctaSubtitle = "Schedule a direct technical discovery call with our founding engineers to evaluate feasibility, timelines, and implementation strategy.";
include __DIR__ . '/components/cta.php';
?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>