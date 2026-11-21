# Antigravity Bootstrap Prompt — CodeX404 Business OS

You are working in the existing repository `codex404solutions/CodeX404_solutions`.

Your assignment is to plan and progressively implement **CodeX404 Business OS**, the internal ERP/CRM and company operations platform for CodeX404 Solutions.

## Read all project specifications first

Read every file in `docs/Business-OS/`:

1. `MEMORY.md`
2. `PRD.md`
3. `ARCHITECTURE.md`
4. `DATABASE.md`
5. `SECURITY.md`
6. `RULES.md`
7. `DESIGN.md`
8. `TASKS.md`
9. `DEVELOPMENT_PROMPT.md`

Also inspect the current repository, `docs/CRM/`, `docs/Main-Website/`, the existing website lead flow, admin/authentication, project showcase workflow, and `.github/workflows/deploy.yml`.

## Product direction

- Dolibarr is the proposed ERP/CRM system of record, subject to Phase 0 compatibility and licence review.
- Configure Dolibarr native modules first.
- Build CodeX404 extensions only for verified gaps.
- Do not modify Dolibarr core files.
- Do not create a parallel CRM for companies, contacts, invoices, customers, projects, or suppliers.
- Build Global Client Hunter as a separate candidate discovery/intelligence domain. A candidate becomes a Dolibarr prospect only after review and approval.
- Support international campaigns by country, region, city, industry, niche, service, and language from the first data-model design.
- Use source provenance, deduplication, contact/suppression controls, evidence-backed website audits, transparent lead scoring, and idempotent Dolibarr synchronization.
- Add real, permission-aware graphs and charts at appropriate dashboard/report locations. Every visualisation must have a defined metric, formula, currency/timezone basis, refresh timestamp, accessible table alternative, and secure drill-down. Do not put mock numbers in production.
- A future Python/FastAPI AI/discovery worker is optional and must run only on verified suitable infrastructure.

## Existing-project constraints (re-verify before acting)

- Public website: `https://codex404solutions.com/`.
- Existing website source: `website/`.
- Current hosting direction: Hostinger shared hosting with PHP + MySQL/MariaDB; account capabilities are not yet verified.
- Development occurs on `dev` or feature branches from `dev`; `main` is production.
- Existing website deploy workflow: `.github/workflows/deploy.yml`; preserve it.
- Website and Business OS must have separate application roots, databases, credentials, and deployment workflows.
- Website lead sender has a local JSON fallback and an optional HMAC-signed webhook. Preserve the contract and fallback until a new receiver passes end-to-end tests.
- Existing project showcase publication requires explicit client permission/review. Never publish internal projects automatically.

## Non-negotiable safety

- Never develop directly on `main`.
- Never deploy Business OS into the public website root.
- Never modify production DB, DNS, FTP secrets, or hosting configuration without explicit approval.
- Never read or print `.env` or credential values.
- Never commit secrets, private files, logs, uploads, or production data.
- Do not assume Docker, Node, Python, Redis, queue workers, root access, or frequent cron on shared hosting.
- Do not scrape sources in a way that bypasses access controls, CAPTCHAs, paywalls, rate limits, robots controls, or provider terms.
- Do not send autonomous mass outreach. Keep external messages as drafts until an authorised human approves them.
- Follow `SECURITY.md` for SSRF, privacy, retention, suppression, webhook, AI, and record-level permission controls.

## Start now — Phase 0 only

1. Inspect Git status, branch, commit, and repository structure.
2. Inspect current website routes, admin/authentication, project showcase, lead persistence, and webhook behaviour.
3. Inspect `.github/workflows/deploy.yml` without changing it.
4. Review secret exposure indicators without displaying secret values.
5. Verify which host/runtime facts can be established and list owner-side checks for unknown Hostinger settings.
6. Select a candidate maintained Dolibarr release and compare its requirements with the verified host.
7. Review Dolibarr licence and official extension/API development guidance.
8. Map PRD requirements to native/config/custom/external/deferred in `MODULE_MATRIX.md`.
9. Review international source-provider, privacy, and outreach requirements before enabling any connector.
10. Document blockers and a proposed implementation sequence.

Create/update `ENVIRONMENT_AUDIT.md`, `MODULE_MATRIX.md`, `LICENSING_REVIEW.md`, and `BUSINESS_OS_DECISIONS.md` as audit deliverables.

**Do not create application code, install Dolibarr, run migrations, create DNS records, change production credentials, alter the public website, or deploy during Phase 0.** Report findings and stop for the owner's approval before Phase 1.
