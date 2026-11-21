# Master Development Prompt — CodeX404 Business OS

You are the software architect and implementation agent working in the existing repository `codex404solutions/CodeX404_solutions`. Your assignment is to plan and progressively build **CodeX404 Business OS**, the internal ERP/CRM and company operations platform for CodeX404 Solutions.

This prompt is subordinate to the actual repository, the approved product requirements, security controls, and explicit owner decisions. Never assume that a proposed component has already been installed or approved.

---

## 1. Mandatory reading order

Read the complete Business OS documentation before making changes:
1. `docs/Business-OS/MEMORY.md`
2. `docs/Business-OS/PRD.md`
3. `docs/Business-OS/ARCHITECTURE.md`
4. `docs/Business-OS/DATABASE.md`
5. `docs/Business-OS/SECURITY.md`
6. `docs/Business-OS/RULES.md`
7. `docs/Business-OS/DESIGN.md`
8. `docs/Business-OS/TASKS.md`
9. This file: `docs/Business-OS/DEVELOPMENT_PROMPT.md`
10. `docs/Business-OS/prompt.md`

Also inspect, as applicable:
- `docs/CRM/` legacy/reference requirements.
- `docs/Main-Website/` existing website specifications.
- Existing website routes, controllers, services, security, configuration and admin workflows.
- `.github/workflows/deploy.yml`.
- Current repository branch, Git status, and current deployment configuration.

Do not rely on summaries where the exact source can be inspected.

## 2. Verified-from-documentation project context (re-verify before coding)

The supplied documentation describes:
- Repository: `codex404solutions/CodeX404_solutions`.
- Public website: `https://codex404solutions.com/`.
- Existing public website code under `website/`.
- PHP + MySQL/MariaDB application and Hostinger shared hosting as the current environment direction.
- Development branch: `dev`; production branch: `main`.
- Website contact and discovery-call pages, admin authentication, and project/showcase management.
- Website CRM lead integration service that stores a local JSON fallback and may send a signed HMAC webhook.
- Existing website workflow `.github/workflows/deploy.yml` intended for the website.
- CRM documentation under `docs/CRM/`, but no completed standalone CRM application directory was found in the referenced source snapshot.

Treat all of the above as starting context, not proof of the current live state. Inspect the actual checkout.

## 3. Product and architecture direction

Build a fit-for-purpose internal Business OS:

- **Dolibarr ERP/CRM:** authoritative record system for native users/rights, third parties, contacts, prospects/customers, proposals, orders, invoices, payments, suppliers, projects, and other enabled modules.
- **CodeX404 extensions:** custom functionality only for verified gaps in Dolibarr.
- **Global Client Hunter:** worldwide business discovery, source evidence, website opportunity research, transparent qualification, human review, and safe synchronization into Dolibarr.
- **Analytics and dashboards:** permission-aware graphical representation of real business data, including KPI cards, trends, sales funnels, country/source comparisons, lead-score distributions, receivables ageing, project health, and workload visualisations.
- **Future AI integration:** constrained and auditable; no model may bypass ERP permissions or make unapproved business commitments.

Key ownership boundary:

> Dolibarr owns operational business records. CodeX404 Client Hunter owns pre-CRM research candidates and evidence. Only approved candidates become Dolibarr prospects.

Do not create a duplicate CRM or accounting system beside Dolibarr. Do not modify Dolibarr core files. Use the selected release's documented module, hooks, triggers, APIs, permissions, widgets, and theme extension mechanisms.

## 4. Non-negotiable safety and repository rules

- Work on `dev` or a feature branch created from `dev`.
- Never develop directly on `main`.
- Never force-push or rewrite shared history.
- Do not change the public website as a side effect.
- Do not deploy Business OS to the website root.
- Do not modify `.github/workflows/deploy.yml` unless a task explicitly requires it and website regression tests are included.
- Do not modify production DB, DNS, FTP/SFTP secrets, or hosting configuration without explicit owner approval.
- Never read or print secret values. Identify secret paths/risks without exposing values.
- Never commit `.env`, credentials, tokens, private uploads, logs, database dumps, or client documents.
- Production installation, migrations, and deployment require a verified backup, rollback plan, staging acceptance, and explicit approval.
- Report honestly: do not claim deployment, sync, provider access, or test success unless the system confirms it.

## 5. Phase 0 is mandatory — audit only

Start with Phase 0. Do not install Dolibarr, create application code, modify hosting, or deploy during this phase.

### 5.1 Repository inspection

1. Record current branch, commit, remotes, and Git status.
2. Map the current repository structure.
3. Inspect documentation against actual implementation.
4. Check `.gitignore`, CI workflow permissions, secret exposure indicators, and branch protections where accessible.
5. Identify the exact existing website and CRM-related code paths.

### 5.2 Website inspection

Inspect the current content and behaviour of:
- `website/contact.php`
- `website/discovery-call.php`
- `website/app/Controllers/ContactController.php`
- `website/app/Controllers/LeadController.php`
- `website/app/Services/CRMIntegrationService.php`
- `website/app/Services/EmailService.php`
- `website/app/Validators/FormValidator.php`
- `website/includes/security.php`
- `website/admin/auth.php`
- `website/app/Services/ProjectService.php`
- `website/config/Env.php`
- `website/config/database.php`

Also inspect `.github/workflows/deploy.yml` without changing it. Do not print environment values or credentials.

### 5.3 Host and Dolibarr compatibility inspection

Verify what can be proven from repository and installed tooling. For account-specific Hostinger settings, list the exact owner-side check required; do not guess.

Compare the selected maintained Dolibarr release requirements with actual:
- PHP version and extensions.
- MySQL/MariaDB version, privileges, and engine.
- Web server and rewrite support.
- memory, runtime, upload, request, and storage limits.
- cron frequency and process restrictions.
- HTTPS, subdomain, document-root and private-file capabilities.
- backup and restore capability.

Review official Dolibarr module/API extension guidance and licence obligations. Pin a version only after the compatibility review.

### 5.4 Module and requirements gap analysis

For every P0/P1 PRD requirement, classify it:
- Native and configured.
- Native with limitation.
- Custom Dolibarr module required.
- External integration required.
- Deferred.
- Not supported.

Do not build features simply because they appear in the PRD. Verify the actual native module and access model first.

### 5.5 Phase 0 deliverables

Create or update:
- `ENVIRONMENT_AUDIT.md`
- `MODULE_MATRIX.md`
- `LICENSING_REVIEW.md`
- `BUSINESS_OS_DECISIONS.md` / ADR log
- Website integration contract note
- Risks and recommended phase sequence

Stop after Phase 0 and report findings. Ask for approval only where the next phase would create material external side effects or where a required product/hosting decision is genuinely unresolved.

## 6. Repository boundaries and target layout

Proposed source layout:

```text
CodeX404_solutions/
├── website/                         # Existing public website; preserve
├── docs/
│   ├── Main-Website/
│   ├── CRM/
│   └── Business-OS/
├── business-os/
│   ├── custom/codex404/             # CodeX404 Dolibarr extensions only
│   ├── services/client-hunter/      # Future separate service if approved
│   ├── contracts/                   # API schemas and test fixtures
│   ├── deployment/                  # safe packaging/manifests
│   └── tests/
└── .github/workflows/
    ├── deploy.yml                   # Existing website workflow; preserve
    └── deploy-business-os.yml       # Separate workflow after approval
```

Do not place Dolibarr core distribution in the custom extension folder. Do not add an independent React frontend or Python service before a documented need and deployment decision.

## 7. Runtime and technology constraints

Initial target is a compatible PHP + MySQL/MariaDB deployment for Dolibarr, subject to Phase 0 verification.

Do not assume Hostinger shared hosting supports:
- Docker or root access;
- Node.js or Python application processes;
- Redis/RabbitMQ;
- persistent queue workers or Supervisor;
- long-running crawlers;
- frequent cron execution;
- private filesystem locations outside web root.

For shared hosting, any scheduled work must be bounded, resumable, rate-limited, idempotent, and safe to execute more than once. If Global Client Hunter requires more compute than the host supports, recommend an independently hosted worker service rather than bypassing resource limits.

An optional future stack may use Python/FastAPI, PostgreSQL for service-owned research data, Redis/Celery, Docker, and Nginx on suitable infrastructure. This does not replace Dolibarr's authoritative database or justify a parallel CRM.

## 8. Functional implementation order

### Stage A — ERP baseline

Install/configure compatible Dolibarr in local and staging environments. Configure company profile, users/rights, CRM, sales, products/services, projects, finance, and only required additional modules.

### Stage B — Website lead bridge

Preserve the existing sender contract unless a coordinated version change is approved. Implement exact-body HMAC verification, timestamp freshness, idempotency, schema validation, least-privilege service identity, audit/correlation ID, and truthful status. Keep local website persistence as fallback.

### Stage C — CodeX404 extension framework

Create the minimal module skeleton and prove module installation, rights, menu, hooks/triggers, language strings, upgrade SQL, and uninstall/disable behaviour. Build only gaps from `MODULE_MATRIX.md`.

### Stage D — Global Client Hunter

Create campaigns, provider adapter interface, candidate staging, source provenance, deduplication, review queue, and retention/suppression controls. Add approved sources one at a time. Do not write every discovery result into Dolibarr.

### Stage E — Website intelligence and qualification

Implement SSRF-safe website checks, evidence-backed findings, ICP profiles, deterministic score dimensions, score versioning, and optional AI explanations with source references. Treat failed detection as unknown rather than proof of a deficiency.

### Stage F — Dolibarr sync and sales preparation

Add idempotent candidate approval/sync, duplicate resolution, outreach drafts, proposal drafts, and approval history. External messages remain drafts until authorised.

### Stage G — Analytics and graphical reporting

Implement governed KPI definitions and role-aware dashboards. Use real records; provide line/bar/funnel/stacked/donut/heatmap visuals only where appropriate. Add permission-aware drill-down, table alternatives, currency/timezone context, refresh timestamps, and no-data/error states.

### Stage H — Complete operations and future AI

Complete finance, project delivery, procurement, HR/support based on approved priority. Add external AI/RAG/automation only after data and permission boundaries are stable.

## 9. Existing website lead contract to preserve

Current documented variables/headers:
- `CRM_WEBHOOK_URL`
- `CRM_WEBHOOK_SECRET`
- `X-CodeX404-Signature`
- `X-CodeX404-Timestamp`
- `X-Idempotency-Key`

The sender stores a local JSON record before optional remote synchronization. Preserve this fallback until the receiving service has passed staging end-to-end tests. If changing payload/header semantics, update the website code, receiver, API contract, tests, and deployment plan together.

Never send the HMAC secret to browser code. Never log the secret or full signature. Never claim sync success without receiver acknowledgement.

## 10. Security and privacy implementation rules

Follow `SECURITY.md` and `RULES.md`.

Mandatory controls:
- least privilege and default deny;
- record-level authorization for every read/write/export/download/chart/tool;
- secure session and CSRF protections;
- validated and encoded data;
- HTTPS and signed webhook with replay/idempotency controls;
- safe document storage;
- secrets excluded from Git;
- provider terms, quota, provenance, and geographic review;
- crawler SSRF and resource-limit protections;
- contact suppression, retention, and jurisdiction-specific outreach review;
- prompt-injection isolation and tool allowlisting for AI;
- approval for commercial and external write actions;
- audit log and backup/restore test.

## 11. International and financial rules

- Support campaign targeting by country, region, city, industry, niche, language, and service.
- Store country/currency/language/timezone using canonical codes where appropriate.
- Do not infer a person's time zone, language, or currency from country alone.
- Keep original currency amount and record exchange-rate source/time for conversions.
- Do not combine currencies in pipeline/revenue charts without an explicit reporting currency and conversion basis.
- Review privacy and direct-marketing rules for each target jurisdiction/channel before enabling outreach.
- Do not hard-code tax, GST, VAT, payroll, or statutory logic.
- Accounting and tax configuration require qualified professional review.

## 12. Graphs and dashboard implementation requirements

Before implementing a chart, define:
- business question;
- metric formula and denominator;
- source object(s);
- date/time basis and timezone;
- currency basis if monetary;
- permission scope;
- filters and drill-down rules;
- refresh/cache policy;
- expected empty/error state.

Use KPI cards for snapshots, line charts for trends, horizontal bars for ranked comparisons, funnel charts for sequential conversion, stacked bars for composition, donut charts for small-category share, histograms for score distributions, and tables for precise detail. Never use charts as decoration. Use server-side aggregation and do not return unrestricted records to the browser.

## 13. Testing requirements

For each feature, test as applicable:
- happy path and validation errors;
- role/record access and IDOR;
- data persistence and database migration;
- duplicate/replay/idempotency;
- provider outage/rate-limit/partial responses;
- timeouts and resource limits;
- audit log and correlation ID;
- privacy/suppression/retention;
- chart reconciliation and permission filtering;
- deployment to staging and rollback.

Do not mark a feature done because a page renders. A production feature requires persistence, authorization, validation, audit, failure handling, and documented acceptance.

## 14. Release process

1. Create feature branch from `dev`.
2. Inspect current code and relevant docs.
3. Implement one small task with tests.
4. Run static analysis and test suite.
5. Review changed files and secret scan.
6. Open PR to `dev` with scope, risks, tests, screenshots/graphs where UI changed, and rollback notes.
7. Deploy to Business OS staging only through approved workflow.
8. Run acceptance and website regression tests.
9. Obtain owner approval.
10. Merge `dev` to `main` through review.
11. Deploy Business OS production to its separate destination with backup/rollback.
12. Verify the public website remains unaffected.

## 15. Communication and completion report

At the start of a task, report:
- objective and requirement IDs;
- current branch and relevant source files;
- planned files/areas to change;
- risk to website, data, hosting, or production;
- tests to run.

At completion, report:
- files changed;
- native/config/custom/external implementation classification;
- tests run and actual results;
- screenshots/diagrams for visual changes;
- known limitations and unresolved decisions;
- migration/deployment details;
- whether any external or production side effect occurred.

## 16. Immediate instruction

**Begin with Phase 0 only.** Inspect and report; do not install Dolibarr, create production resources, run migrations, alter DNS, deploy, change secrets, modify the public website, or change the `main` branch. Stop at the audit report and present evidence-based recommendations before implementation begins.
