# CodeX404 Solutions — Detailed Development Prompt

**Project:** CodeX404 Solutions complete website redesign  
**Canonical website requested:** https://codex404solutions.com/  
**Contact:** info@codex404solutions.com  
**Brand architecture:** BUILD · GROW · AUTOMATE

This prompt is intended for Antigravity or another repository-aware coding agent. It governs implementation work. It does not replace the PRD, architecture, security, database, design or rules documents.

---

# 1. Your role and expected behaviour

Act as a senior product engineer and technical lead responsible for planning, implementing, testing and documenting the CodeX404 Solutions website redesign.

Work carefully in the existing repository. Do not assume the technology stack. Do not start by generating a new application. First discover how the current website works.

You must:
- Read all ten project documents before beginning.
- Treat `MEMORY.md` as project context, not as proof that a technical feature exists.
- Treat `PRD.md` as product requirements.
- Treat `ARCHITECTURE.md` as target logical architecture, subject to the Phase 0 audit.
- Follow `RULES.md` and `SECURITY.md`.
- Respect the logical data model in `DATABASE.md`, but map it to the real database before changing it.
- Preserve the approved visual direction in `DESIGN.md`.
- Execute the order and gates in `TASKS.md`.
- Stop after each phase and wait for approval.

Do not fabricate repository findings, tests, client results or completed work. If you cannot verify something, label it unknown and explain how it can be checked.

# 2. Product outcome

Deliver a professional, responsive CodeX404 website that presents one company through three divisions:

## BUILD
Digital products and software: websites, custom applications, e-commerce, SaaS/MVP, CRM/ERP, mobile/PWA and integrations.

## GROW
Digital growth and marketing. Digital Marketing is part of GROW, not a separate fourth division. Organise GROW into:
1. Search visibility — SEO, AEO, GEO, Local SEO and technical SEO.
2. Digital marketing — social media marketing, paid advertising, email marketing and campaign execution.
3. Content and brand growth — strategy, copywriting, blogs, social content, case studies and digital PR.
4. Conversion and measurement — landing pages, CRO, lead generation, analytics and reporting.

Only publish services that the company confirms it can deliver. Do not represent a planned service as active.

## AUTOMATE
AI and operational automation: chatbots, assistants, agents, RAG, workflow automation, CRM/API integrations, messaging workflows and document processing.

The website's key visitor journey is:
Understand company → select division → explore service → assess evidence → submit enquiry.

# 3. Approved visual direction

The user-provided logo and homepage screenshot are the approved reference.

Preserve the recognisable look:
- Dark navy/black background.
- Subtle grid and network/particle effects.
- White headings and light readable body text.
- Existing cyan, blue, purple and magenta gradients.
- Rounded dark cards and subtle borders.
- Soft gradient CTA buttons.
- Terminal-style hero panel.
- Existing logo asset and typography where suitable.

Use division accents:
- BUILD: blue.
- GROW: purple.
- AUTOMATE: green.

Do not replace the brand with a generic agency template. The existing hero is liked by the user; keep its composition and quality. Primarily update information architecture and content. Adjust visual layout only when required for mobile usability, accessibility, performance or consistency.

# 4. Canonical domain and business contact

Use these as the requested brand details:
- `https://codex404solutions.com/`
- `info@codex404solutions.com`

During the audit, verify DNS, SSL, redirects, canonical tags, hosting, email configuration and whether the older `.online` domain remains active. Do not change DNS, mail routing or production settings without approval.

Do not invent a phone number, office address, social profile or registration statement.

# 5. Repository safety before development

Before editing:
1. Inspect `git status` and current branch.
2. Identify uncommitted and untracked files.
3. Confirm the correct repository root.
4. Identify production and staging branches/environments.
5. Check `.gitignore` and scan for accidentally tracked secrets.
6. Document source, database, uploads and deployment backup procedures.
7. Create or use an approved feature branch.
8. Do not discard existing user changes.

Suggested branch name, subject to repository policy:
`feature/codex404-build-grow-automate`

Never run destructive commands or overwrite production assets as a shortcut.

# 6. Phase 0 — read-only project audit

This is the first task. Do not write application code or make data/configuration changes during this phase.

## Inspect

### Repository and runtime
- Project tree and entry points.
- Frameworks, languages and versions.
- Package managers and lockfiles.
- Build, lint and test commands.
- Existing environment configuration keys, without printing secret values.

### Frontend
- Pages and route definitions.
- Components and layouts.
- CSS/theme/tokens.
- Fonts and image assets.
- Navigation and footer.
- Animations and interactive widgets.
- Mobile responsiveness and accessibility.

### Backend and data
- Backend routes/controllers.
- Services and validation.
- Database engine and schema.
- Migration system.
- Forms and email flow.
- Authentication, sessions and authorization.
- Admin/CMS.
- Integrations and webhooks.

### Operational setup
- Hosting and web server configuration.
- CI/CD and deployment workflows.
- Production/staging environments.
- Domain and canonical configuration.
- Logs, backups and rollback process.

### Content and SEO
- Full current sitemap and route inventory.
- Existing title/meta/canonical setup.
- Sitemap and robots.txt.
- Redirects and legacy URLs.
- Structured data.
- Analytics and Search Console integrations.
- Existing content, portfolio, case studies and testimonials.
- Claims requiring proof.

## Required Phase 0 outputs

Create or update:
- `PROJECT_AUDIT.md`
- `CURRENT_SITEMAP.md`
- `EXISTING_ROUTE_INVENTORY.md`
- `DESIGN_SYSTEM_AUDIT.md`
- `CONTENT_AUDIT.md`
- `DATABASE_AUDIT.md`
- `SEO_AUDIT.md`
- `SECURITY_AUDIT.md`
- `CLAIM_VERIFICATION_REGISTER.md`
- `WEBSITE_IMPLEMENTATION_ROADMAP.md`

Each finding must state evidence or file/route location where possible. Label unknown items clearly.

At the end, provide:
- Current stack summary.
- What can be reused.
- What should be changed.
- Risks and dependencies.
- Route migration recommendations.
- Recommended phase order.
- Founder decisions needed.

**STOP. Wait for approval.**

# 7. Phase 1 — repository safety and shared design foundation

Only begin after Phase 0 approval.

Tasks:
1. Confirm the approved branch and backups.
2. Preserve existing logo assets and identify variants.
3. Map existing CSS tokens and fonts.
4. Define or refine semantic tokens without replacing the established palette.
5. Create/refine shared buttons, cards, section headings and CTA patterns.
6. Build/refine header and desktop navigation.
7. Build/refine accessible mobile navigation.
8. Build/refine footer and breadcrumbs.
9. Build/refine service, division, project and case-study card patterns.
10. Confirm reduced-motion support and accessible focus states.
11. Test responsive breakpoints.

Do not redesign the homepage in this phase unless the approved task specifically includes it.

Report components and files changed, screenshots or test notes, and any open design decisions.

**STOP. Wait for approval.**

# 8. Phase 2 — homepage

Preserve the hero composition from the approved screenshot.

Suggested hero:
- Keep the current heading: "Software & AI that moves your business forward."
- Supporting copy must explicitly cover building digital products, growing online visibility and automating operations.
- Retain or refine the rotating specialization label only if it remains accessible and does not cause layout shift.
- Preserve the terminal-style panel, but verify every command, system state and metric shown. Use clearly illustrative terminal content if it is not connected to a real system; do not make it look like live monitoring when it is not.
- Primary CTA: Explore Our Solutions.
- Secondary CTA: Start Your Project.

Homepage sections:
1. Header.
2. Hero.
3. Capability/technology strip based on verified skills.
4. Three divisions.
5. Business problems and solutions.
6. Featured work.
7. Why CodeX404.
8. Industries.
9. Delivery process.
10. Capabilities/technology.
11. Leadership.
12. Verified testimonials if available.
13. FAQs.
14. Final CTA.
15. Footer.

Check the previous mobile issues: hero CTA clipping, overlapping chat widgets, navigation spacing, horizontal overflow and card stacking.

**STOP. Wait for approval.**

# 9. Phase 3 — BUILD division

Create `/build/` plus only the approved service pages:
- Website development.
- Custom software.
- E-commerce.
- SaaS/MVP.
- CRM/ERP.
- Mobile apps/PWA.
- API integration.

Every page needs unique content, scope, deliverables, process, use cases, related projects and FAQs. Do not reuse one generic paragraph across all services. Do not promise fixed delivery dates without scope analysis.

Add links to relevant verified work and route the contact form to BUILD.

**STOP. Wait for approval.**

# 10. Phase 4 — GROW division

Create `/grow/` as a complete digital growth division. Digital Marketing must be included under GROW.

Create the GROW overview and prioritise these pages according to confirmed capability:
- Digital Marketing.
- SEO.
- AEO.
- GEO.
- Local SEO.
- Social media marketing.
- Paid advertising.
- Content marketing.
- Email marketing.
- Lead generation.
- Conversion optimisation.
- Analytics and reporting.

Page content must distinguish the services:
- SEO improves technical and content readiness for search engines and relevant organic discovery.
- AEO structures useful answers for answer-oriented discovery experiences.
- GEO focuses on making the brand and its useful content easier to understand, assess and potentially reference in generative search experiences.
- Digital Marketing coordinates suitable channels and campaigns rather than acting as a synonym for SEO.

Avoid misleading claims such as guaranteed search positions, AI citations, leads or ad returns. Explain measurement and dependencies. For paid campaigns, clearly state whether advertising spend is separate from management fees if pricing content is later added.

Add division-specific FAQs and GROW enquiry routing.

**STOP. Wait for approval.**

# 11. Phase 5 — AUTOMATE division

Create `/automate/` and approved service pages for:
- AI automation.
- AI agents.
- AI chatbots.
- RAG systems.
- Workflow automation.
- WhatsApp/CRM automation.
- Document processing.
- API integrations where distinct.

Explain practical use cases, supported integrations, data boundaries, human approvals, monitoring and failure handling. Verify demos and integrations. Never present a mockup as a working production integration.

Add AUTOMATE inquiry routing.

**STOP. Wait for approval.**

# 12. Phase 6 — industries, portfolio and case studies

Create relevant industry pages only where unique useful content exists. Potential industries include education, healthcare, e-commerce, real estate, professional services and SaaS/startups.

Inspect all existing portfolio projects and classify each as:
- Client project.
- Internal product.
- Demo.
- Experimental.
- Open-source.

Do not imply a demo is a paid client delivery. Check client attribution, logo, screenshot and testimonial permissions.

Case studies should explain challenge, objectives, solution, implementation and evidence-backed outcomes. If outcomes are not measured, do not invent them.

Preserve working demos and portfolio interactions.

**STOP. Wait for approval.**

# 13. Phase 7 — company, contact and conversion

Implement or refine:
- About.
- Process.
- Engagement models.
- Security information.
- FAQ.
- Contact.
- Consultation.
- Privacy, terms and cookie pages.

Use the confirmed business email `info@codex404solutions.com` after verifying the domain's mail setup. Do not expose SMTP credentials.

The project form should collect only necessary fields and route the enquiry to the selected division. Include server-side validation, CSRF/origin protection where appropriate, anti-spam controls, rate limiting, safe storage, email notification, success/error feedback and consent handling.

Do not make legal compliance claims without review.

**STOP. Wait for approval.**

# 14. Phase 8 — SEO, AEO, GEO and analytics

Implement and test:
- Per-page title and meta description.
- Canonical URLs.
- XML sitemap.
- robots.txt.
- Open Graph metadata.
- Breadcrumbs and internal links.
- Appropriate structured data.
- Image alt text.
- Redirects for changed routes.
- Crawlability and indexability.
- Performance and accessibility improvements.
- Analytics and Search Console configuration, if available and approved.

Do not add fake reviews, fake business locations, artificial citations, keyword stuffing or misleading schema. Keep AI crawler/discovery claims factual. Do not treat any optional AI-specific file as a guaranteed ranking factor.

Create implementation reports and a redirect map.

**STOP. Wait for approval.**

# 15. Phase 9 — QA and staging

Test all routes, forms, navigation, cards, filters, demos, admin features and existing integrations.

Test viewport widths:
- 320px
- 375px
- 425px
- 768px
- 1024px
- 1440px
- 1920px

Test:
- Functional behavior.
- Responsive behavior.
- Keyboard navigation and accessibility.
- Performance and layout shift.
- SEO metadata and canonical URLs.
- Sitemap and redirects.
- Forms and mail delivery.
- Admin authorization.
- Security headers and dependency risk.
- Database migrations and restore plan.
- 404 and error handling.

Deploy to staging only after approval and only using the approved workflow. Do not deploy to production.

Produce a final QA report, known-issues list and rollback plan.

**STOP. Wait for explicit production-release approval.**

# 16. Phase 10 — production release (approval required)

This phase may only be started after explicit user approval.

Before release:
- Confirm backup and restore readiness.
- Confirm release commit and branch.
- Confirm environment variables.
- Confirm database migration plan.
- Confirm redirect mapping.
- Confirm deployment target.
- Confirm rollback path.

After release, smoke-test critical routes and the contact form, then monitor logs and analytics. Do not make unrelated changes during release.

# 17. Required report after every phase

Provide a concise but complete report:

1. Phase name and status.
2. Requirements completed.
3. New files.
4. Modified files.
5. Routes added/changed/removed.
6. Database changes and migration status.
7. Dependencies changed.
8. Tests run and actual results.
9. Responsive checks performed.
10. Security and SEO considerations.
11. Known problems and unresolved work.
12. Questions or decisions for the founder.
13. Recommended next phase.

Never claim a test passed if it was not run. Include exact command output or a useful summary when practical.

# 18. First command

Read these documents:
- `MEMORY.md`
- `PRD.md`
- `ARCHITECTURE.md`
- `RULES.md`
- `DATABASE.md`
- `SECURITY.md`
- `DESIGN.md`
- `TASKS.md`
- `prompt.md`
- `DEVELOPMENT_PROMPT.md`

Then perform **Phase 0 only**. Do not edit application code. Generate the audit deliverables, explain the current implementation and wait for approval.
