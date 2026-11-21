# CodeX404 Business OS — Durable Project Memory

This file contains durable project facts, approved direction, and unresolved decisions for future development sessions. It is not a substitute for inspecting the live repository, current host, or selected Dolibarr release.

| Property | Value |
|---|---|
| Product | CodeX404 Business OS |
| Organisation | CodeX404 Solutions |
| Repository identified in source documentation | `codex404solutions/CodeX404_solutions` |
| Primary public website | `https://codex404solutions.com/` |
| Version | 2.0 |
| Last reviewed | 2026-11-21 |

---

## 1. Product identity and purpose

CodeX404 Business OS is intended to be the internal operating platform for CodeX404 Solutions. It should connect client acquisition, CRM, sales, project delivery, finance, people, operations, and management analytics.

The architecture direction is:
- Dolibarr ERP/CRM is the authoritative system for native business records.
- CodeX404 builds separate custom modules for verified business gaps.
- Global Client Hunter is the lead-discovery and opportunity-intelligence capability.
- A candidate discovered by Client Hunter is not automatically a Dolibarr prospect. A human review and idempotent sync step is required.
- The initial scope is one internal CodeX404 organisation, not an external multi-tenant SaaS.

## 2. Existing repository and website facts from the supplied project documentation

The original documentation describes:
- Public PHP website source under `website/`.
- Main public URL supplied by the owner: `https://codex404solutions.com/`.
- Hostinger shared hosting and PHP + MySQL/MariaDB as the current hosting direction; actual plan capabilities must be verified.
- Existing public lead pages: `website/contact.php` and `website/discovery-call.php`.
- Existing controllers/services including `ContactController.php`, `LeadController.php`, `CRMIntegrationService.php`, `EmailService.php`, and `FormValidator.php`.
- Existing website-admin authentication and project/showcase functions.
- Existing `.github/workflows/deploy.yml` intended for the website.
- Existing CRM requirements in `docs/CRM/`; the source documentation reports that a complete `crm/` application directory was not present in the inspected snapshot.

These are source-documentation facts and must be rechecked against the current repository before implementation.

## 3. Existing website integration behaviour to preserve

The source documentation states that `CRMIntegrationService.php`:
1. Generates an idempotency identifier.
2. Persists a local JSON copy of a lead payload.
3. Optionally posts the lead to `CRM_WEBHOOK_URL`.
4. Signs the raw JSON body with HMAC-SHA256 using `CRM_WEBHOOK_SECRET`.
5. Sends `X-CodeX404-Signature`, `X-CodeX404-Timestamp`, and `X-Idempotency-Key` headers.
6. Uses HTTPS verification and short request/connection timeouts.
7. Retains a local fallback when the remote receiver is not configured or fails.

Preserve this behaviour until the new Business OS receiver is verified with end-to-end tests. Never claim that a lead has synced to Dolibarr simply because the website saved a local copy.

## 4. Existing website project and publication privacy

The source documentation describes project types such as client, internal, concept, and open source; showcase states such as live website, interactive demo, video walkthrough, and case study; and client permission states such as approved, approved with restrictions, pending, review required, and denied.

Keep internal delivery records separate from public portfolio content. Require explicit client permission and publication approval before exporting project details or assets to the public website.

## 5. Brand and UI direction

The original Business OS design specification documents:
- Midnight: `#07111F`
- Deep Navy: `#0B1F3A`
- Electric Blue: `#2563EB`
- Cyan: `#22D3EE`
- Violet: `#7C3AED`
- Soft Violet: `#A78BFA`
- White: `#FFFFFF`
- Slate: `#94A3B8`
- Light: `#F8FAFC`
- Dark Text: `#0F172A`
- BUILD accent: blue; GROW: violet; AUTOMATE: green.

Preserve the actual CodeX404 logo asset and its original colours/proportions. Verify the correct asset in the repository; do not recreate it from memory.

The interface should feel like a clean, professional operations console. Graphs and charts are expected where they answer defined business questions: sales funnel, lead trends, campaign/source/country comparisons, Client Hunter score distribution, receivables ageing, project health, and task workload. Production visualisations must use real records, permission-aware aggregates, documented formulas, and no demo metrics.

## 6. Architecture decisions and constraints

1. Dolibarr is the candidate ERP/CRM foundation, subject to Phase 0 technical and license verification.
2. Do not modify Dolibarr core files. Use supported module, hook, trigger, permission, API, and theme extension mechanisms for the selected release.
3. Do not create duplicate company/contact/invoice/project/customer databases beside Dolibarr.
4. Use `business-os/custom/codex404/` as the proposed source boundary for CodeX404 Dolibarr modules; confirm packaging against the selected release.
5. Keep Business OS in its own application/document root and database.
6. Keep the public website's existing deployment workflow separate and unchanged.
7. Build Client Hunter candidates in a separate discovery workspace and sync only reviewed candidates into Dolibarr.
8. Prefer approved official APIs, licensed data, permitted public directories, and authorised imports; do not bypass source terms or technical controls.
9. Start with a PHP-compatible deployment if the actual host supports it. Do not assume Docker, Python, Node, Redis, workers, or root access on shared hosting.
10. A separate Python/FastAPI discovery/AI service is a future option when suitable infrastructure is available.

## 7. International capability direction

Client Hunter should be designed for worldwide targeting from the first data-model design. It should support country, region, city, industry, language, service fit, and provider filters.

Canonical metadata should use ISO country and currency codes, IANA time-zone identifiers, and language tags where possible. Do not assume country determines a contact's language, time zone, or business currency. Currency reporting must keep original amount/currency and record any exchange-rate source/date used for conversion.

Country-specific privacy and direct-marketing review is required before enabling outreach. Publicly accessible information is not automatically unrestricted for marketing.

## 8. Development workflow rules

- `dev` and feature branches from `dev` are development/integration.
- `main` is production; never develop directly on it.
- Do not change the public website or its deployment workflow as a side effect.
- Do not read or print secret values.
- Never commit `.env`, credentials, uploads, private documents, logs, or production database dumps.
- Production install, migration, DNS change, or deployment requires explicit approval and tested backup/rollback.
- Work one phase/task at a time and report tests honestly.

## 9. Open decisions requiring fresh verification

- Current repository structure and branch state.
- Current Hostinger plan, PHP version/extensions, DB version, cron, private storage, and document-root capabilities.
- Exact Dolibarr release candidate and its compatibility with the host.
- Dolibarr native coverage for pipeline, role scopes, tasks, HR, multicurrency, dashboards, and multi-entity needs.
- Business OS development and production hostnames.
- Website payload and current HMAC implementation details.
- Provider list, source terms, usage quotas, API costs, and allowed geography.
- Privacy/direct-marketing policy for each country and channel.
- Accounting, tax, statutory, and payroll requirements.
- Whether and when a VPS/external Python worker is needed.

Earlier project discussions/documents have also referenced `.online` domains. The owner-supplied primary website in the current source specification is `.com`; inspect DNS, certificates, links, and environment configuration before removing or redirecting any legacy domain.

No item in this list should be treated as resolved without a new audit or explicit owner decision.

## 10. Memory maintenance

Update this file only when a durable fact or approved decision changes. Include the date and evidence source. Do not place passwords, API keys, private customer data, or temporary troubleshooting output here.
