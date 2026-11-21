# CodeX404 Business OS — Security and Privacy Specification

| Property | Value |
|---|---|
| Security model | Defence in depth, least privilege, default deny, auditability |
| Primary application | Dolibarr ERP/CRM + CodeX404 modules |
| External attack surfaces | Website webhook, REST APIs, provider connectors, website crawler, file uploads, AI integrations |
| Data scope | Company, client, prospect, financial, employee, and international business-contact data |
| Version | 2.0 |
| Status | Mandatory security baseline; implementation must be tested before production |

---

## 1. Security objectives

1. Protect confidentiality, integrity, and availability of CodeX404 business records.
2. Prevent unauthorised access between roles, teams, records, projects, countries, and future entities.
3. Protect the existing public website and its current production deployment.
4. Prevent forged/replayed lead submissions and duplicate integrations.
5. Protect third-party/provider credentials and prevent uncontrolled data collection.
6. Prevent website auditing from reaching private/internal network resources.
7. Treat retrieved website content, documents, provider responses, and AI input as untrusted data.
8. Preserve financial and approval audit trails.
9. Apply privacy and communication controls appropriate to each jurisdiction and provider.
10. Make security failures visible and recoverable without exposing secrets or unnecessary personal data.

## 2. Security principles

- Default deny for users, APIs, exports, records, documents, dashboards, and tools.
- Authorise on the server for every read and write; hiding a button is not access control.
- Use supported Dolibarr permission and module mechanisms.
- Keep production, staging, website, ERP, and integration credentials separate.
- Do not expose credentials in browser JavaScript, HTML, URLs, logs, source maps, Git, or screenshots.
- Validate data at trust boundaries and encode output for its destination context.
- Use idempotency for create/update integrations and replay protection for signed requests.
- Minimise personal data and define retention before collecting it.
- Human approval is required for commercial commitments and external outreach.
- Security controls must be demonstrated by tests, not just described in documentation.

## 3. Threat model

| Threat | Example | Required mitigation |
|---|---|---|
| Account compromise | Stolen password/API token | Strong authentication, secure sessions, least privilege, rotation, logging |
| Privilege escalation | Sales user accesses finance/HR data | Server-side rights and record-scope tests |
| IDOR | User changes an object ID in URL/API | Object-level authorization on every request |
| Forged website lead | Attacker posts arbitrary webhook JSON | HMAC, timestamp, idempotency, schema validation, rate limits |
| Replay/duplicate | Re-send a valid signed request | Timestamp window and unique idempotency key |
| SSRF | Website audit targets cloud metadata or internal server | DNS/IP checks, redirect checks, blocked ranges, network egress limits |
| Malicious provider data | HTML/script/prompt injection in company website | Treat all content as data; sanitise, constrain, isolate |
| Credential leakage | Provider key committed in repository | Secret manager/configuration, scanning, rotation |
| Data over-collection | Store unnecessary named-person contact records | Data minimisation, source, purpose, retention, suppression |
| Unlawful outreach | Contact a person contrary to applicable rules/preferences | Jurisdiction review, suppression, approval, audit |
| Chart leakage | Dashboard totals expose restricted team/finance data | Permission-filtered aggregation and drill-down |
| File disclosure | Predictable private document URL | Authenticated download controller and object permission check |
| Supply-chain attack | Vulnerable library/module | Dependency inventory, updates, integrity review |
| AI tool misuse | Prompt injection leads to unauthorised write action | Allowlisted tools, user permissions, approval gate, tool audit |
| Backup exposure | Public SQL dump | Private storage, encryption, access restriction, retention |

## 4. Authentication and sessions

- Use Dolibarr's supported authentication/session mechanisms for the ERP application.
- Do not reuse the website admin session, cookie, password table, or database credential without an explicit SSO architecture and security review.
- Enforce HTTPS across all authenticated routes.
- Use secure, HttpOnly, SameSite cookie attributes as supported by the selected runtime.
- Regenerate session identifiers after authentication and privilege changes.
- Apply idle and absolute session timeouts based on risk and operational needs.
- Rate-limit authentication attempts and use account lockout or progressive delays without enabling trivial denial of service.
- Require multi-factor authentication where supported and operationally available, especially for privileged users.
- Disable stale or departed-user accounts promptly.
- Integration identities must be distinct service accounts, not shared administrator credentials.

## 5. Authorization and record-level security

- Use native Dolibarr rights first; verify exact behaviour in the selected version.
- A custom module must declare its permissions and enforce them in controllers/services, not only in menus.
- Check access for every record before rendering, exporting, downloading, or mutating it.
- Apply scope restrictions consistently to list, search, dashboard, API, batch job, and export queries.
- Test users with multiple roles and users whose access is removed after a session starts.
- Avoid hard-coded role-name checks. Use explicit permission capabilities and documented scopes.
- Restrict sensitive financial and HR views separately.
- Background jobs must execute with a narrowly scoped service identity and must not bypass entity/record rules.

Required scenarios include: Founder, CTO, Sales, Marketing, Project Manager, Developer, Finance, HR, Support, read-only auditor, disabled user, no-role user, multi-role user, and user whose permission has just been revoked.

## 6. Website-to-Business-OS webhook security

Preserve the current website contract unless a coordinated, reviewed version change is approved:
- `CRM_WEBHOOK_URL`
- `CRM_WEBHOOK_SECRET`
- `X-CodeX404-Signature`
- `X-CodeX404-Timestamp`
- `X-Idempotency-Key`

### 6.1 Required verification sequence

1. Require HTTPS and an allowed HTTP method/content type.
2. Enforce a strict request-body size limit before parsing.
3. Read the exact raw request bytes.
4. Parse and validate timestamp format and freshness against a configured skew window.
5. Compute the expected HMAC using the documented algorithm and secret.
6. Compare signatures using a constant-time comparison.
7. Reject missing, malformed, stale, or invalid signatures.
8. Validate the idempotency key and enforce a unique database constraint.
9. Decode JSON only after signature verification; validate schema, field lengths, data types, and allowlisted values.
10. Ignore/reject client-controlled owner, role, status, price, payment state, or privilege fields.
11. Process under a least-privilege integration account.
12. Return a structured response with request/correlation ID and created/existing record reference.
13. Record outcome without logging the secret, full signature, or unnecessary PII.

### 6.2 Replay and duplicate handling

The timestamp window limits replay duration; the unique idempotency key prevents repeat processing within the retention window. Define how long idempotency keys are retained and what happens when a key is replayed after expiry. An already processed key must return a safe duplicate result, not create a second prospect.

### 6.3 Website fallback

The website currently stores a local JSON copy before optional webhook delivery. Preserve this behaviour until end-to-end tests prove the Business OS receiver and retry path. The UI must distinguish `saved locally`, `sync pending`, `synced`, and `sync failed`; it must not claim successful ERP synchronization without acknowledgement.

## 7. Global Client Hunter security

### 7.1 Provider and source governance

- Maintain an inventory of enabled data providers, source URLs, provider terms, permitted fields, purpose, quotas, geographic scope, and review date.
- Prefer official APIs, licensed datasets, approved public directories, and user-authorised imports.
- Do not bypass logins, paywalls, CAPTCHA, technical access controls, robots controls, rate limits, or provider terms.
- Disable a connector if its terms or permitted use cannot be established.
- Store source provenance and collection timestamp for every material data point.
- Apply rate limits, backoff, concurrency caps, and a kill switch per provider.
- Avoid collecting sensitive personal attributes or private contact details unrelated to the business purpose.

### 7.2 Website crawler / SSRF protection

The crawler must be treated as a hostile-network client:
- Accept only syntactically valid HTTP/HTTPS URLs.
- Resolve hostnames and block private, loopback, link-local, multicast, reserved, and metadata-service addresses for IPv4 and IPv6.
- Re-check DNS results and every redirect target to reduce DNS rebinding and redirect abuse.
- Restrict ports to approved web ports.
- Limit response bytes, headers, redirects, crawl depth, URL count, concurrency, and total time.
- Reject unsupported content types and do not execute downloaded code.
- Use isolated workers and restricted outbound networking where possible.
- Do not crawl authenticated, private, internal, or user-supplied intranet URLs unless a separate authorised security-audit feature is designed.
- Store only the minimum evidence needed to explain a finding.

### 7.3 Evidence and AI safety

- Treat website text, metadata, documents, and source responses as untrusted content, not instructions.
- Prompt injection in a target website must never grant access to tools, secrets, other candidates, or ERP records.
- AI may summarise evidence but must cite the stored evidence references and mark uncertainty.
- AI must not invent email addresses, employee names, budget, technology stack, buying intent, or business problems.
- Keep deterministic rule-based scores separate from AI narrative explanations.
- AI write actions must be allowlisted, permission-checked, approved, idempotent, and audited.
- Never expose hidden reasoning traces or send unrestricted ERP records to a model.

## 8. Privacy and international communication governance

This platform may process business contact information from multiple countries. The legal basis, privacy notice, direct-marketing rules, retention requirements, and data-subject rights can differ by jurisdiction and channel. This document is an engineering control specification, not legal advice.

Before activating a country/channel combination:
1. Identify the relevant controller/entity and intended purpose.
2. Review the applicable privacy and direct-marketing requirements with qualified counsel or a responsible compliance owner.
3. Record source, purpose, lawful-use review, collection date, and relevant notice/consent state where required.
4. Define whether the contact is a generic business channel or identifiable personal work contact.
5. Define retention and deletion/suppression behaviour.
6. Provide a reliable unsubscribe/opt-out or do-not-contact process where applicable.
7. Prevent suppressed contacts from re-entering campaigns through imports, new sources, or duplicate matching.
8. Respect provider terms, platform policies, and recipient preferences.
9. Do not enable mass outreach until the applicable country/channel policy is approved.

No assumption should be made that public availability means unrestricted marketing use.

## 9. File and document security

- Store sensitive documents outside public web access where possible.
- Use authenticated download routes with record-level checks.
- Validate extension, MIME type, actual file signature, size, and allowed file types.
- Rename stored files using generated identifiers; do not trust user-provided paths.
- Prevent path traversal and executable upload types.
- Scan uploaded files where a supported scanner is available.
- Apply access restrictions to contracts, HR files, invoices, client deliverables, and proposal drafts.
- Avoid sharing public links to confidential documents.
- Log access/export for high-risk document classes where feasible.

## 10. Database and secret security

- Use separate least-privilege database users for website, Dolibarr, and future services.
- Do not expose database ports publicly unless required and protected.
- Use parameterized database access through platform conventions.
- Protect backups with encryption and restricted access.
- Keep secrets in hosting environment settings or a supported secret manager.
- Maintain separate development, staging, and production secrets.
- Rotate any credential suspected to have been exposed.
- Never print secret values during audit or support.
- Run secret scanning on commits and deployment artifacts.

## 11. Financial and commercial security

- Financial records are changed only by authorised roles.
- Do not hard-code tax rates, statutory deductions, exchange rates, or payment provider assumptions.
- Require approval for discounts, refunds, write-offs, unusual payment terms, and manual adjustments.
- Preserve financial history using reversal/credit-note/adjustment mechanisms where supported.
- Verify payment webhooks using provider signatures and idempotency.
- AI-generated proposals are drafts; humans approve scope, price, tax, timeline, legal wording, and terms.
- Do not store card security data or payment credentials unless the approved payment provider and compliance design explicitly require it.

## 12. Audit logging and monitoring

Log security-relevant events:
- login success/failure and account state changes;
- role/permission changes;
- record creation/update/deletion for critical entities;
- financial approval, invoice state, payment, refund, adjustment;
- export/download of sensitive data;
- webhook verification and idempotency outcome;
- provider connector activation, failure, and quota events;
- candidate approval/rejection/suppression;
- AI tool invocation and approval outcome;
- deployment and configuration changes.

Logs should contain actor, action, target type/ID, timestamp, result, and correlation ID. Avoid secrets, raw authentication tokens, unnecessary personal data, and full request bodies. Protect logs from ordinary users and define retention/rotation.

## 13. Hosting and deployment security

- Separate public website and Business OS document roots, databases, credentials, and deployment workflows.
- Confirm TLS, PHP/database versions, writable directories, private storage, cron, and backup capabilities.
- Disable installation/setup access after provisioning according to the selected Dolibarr release's guidance.
- Apply supported security updates in staging before production.
- Restrict file/directory permissions to the minimum needed.
- Use FTPS/SFTP with certificate validation where supported; never disable host-key/certificate checks just to make deployment pass.
- Protect CI/CD secrets and limit workflow permissions.
- Use a feature branch from `dev`; never deploy from an unreviewed working tree.
- Keep a tested rollback and recovery procedure.

## 14. Incident response

For suspected compromise or data exposure:
1. Stop the affected integration, connector, scheduled campaign, or account where safe.
2. Preserve relevant logs and timestamps without spreading sensitive data.
3. Rotate affected credentials and revoke tokens.
4. Identify affected systems, records, users, jurisdictions, and data categories.
5. Restore service from a clean state only after containment.
6. Assess notification and legal obligations with the responsible compliance owner.
7. Document root cause, remediation, and follow-up tests.
8. Re-enable only after explicit approval.

## 15. Security test matrix

| Test | Expected result |
|---|---|
| Unauthenticated access to private page/API | Denied |
| User requests another user's restricted record ID | Denied |
| User loses permission mid-session | Subsequent request denied |
| Invalid/stale HMAC request | Rejected; no record created |
| Valid HMAC repeated with same idempotency key | One business effect only |
| Oversized/malformed request | Rejected safely |
| Crawler URL resolves to private IP | Blocked |
| Redirect to metadata/private address | Blocked |
| Provider rate limit response | Backoff; no uncontrolled retry loop |
| Suppressed contact re-imported | Suppression remains effective |
| Dashboard with restricted role | No restricted totals or drill-down |
| Unauthorized export/download | Denied and logged where appropriate |
| Prompt injection in website text | No tool privilege or secret access |
| AI write action without approval | Blocked |
| Backup restore | Data and permissions verified in isolated environment |

## 16. Production release blockers

Production release is blocked if any of these remain unresolved:
- unauthenticated or unscoped record access;
- public exposure of configuration, backups, logs, or private documents;
- missing secret handling or suspected credential leak;
- unverified webhook signature/idempotency;
- unmitigated crawler SSRF risk;
- unapproved source collection or outreach practice;
- cross-user/cross-entity data leakage;
- untested backup restoration and rollback;
- financial or AI write actions without approval controls;
- production deployment path overlapping with the public website.
