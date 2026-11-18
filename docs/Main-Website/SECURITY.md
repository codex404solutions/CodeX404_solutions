# CodeX404 Solutions — Security Requirements

**Scope:** Public website, enquiry forms, admin/CMS, database, integrations, hosting and deployment.

---

## 1. Security objectives

- Protect visitors and customer information.
- Prevent unauthorised administrative access.
- Prevent abuse of public forms and endpoints.
- Protect application secrets.
- Preserve integrity and availability.
- Reduce accidental data exposure.
- Provide a practical recovery process.

This document is an implementation baseline, not a certification or legal compliance statement.

## 2. Threat model

Consider at minimum:
- Spam and automated form abuse.
- SQL injection.
- Cross-site scripting (XSS).
- Cross-site request forgery (CSRF).
- Broken access control.
- Credential stuffing and brute force.
- Session theft or fixation.
- Malicious file uploads.
- Email header injection.
- Open redirects.
- API abuse.
- Dependency vulnerabilities.
- Secret leakage.
- Database exposure.
- Misconfigured storage or backups.
- Deployment and supply-chain compromise.
- Information leakage through logs and error messages.

## 3. Authentication

If an admin area exists:
- Reuse the existing secure authentication system if suitable.
- Require strong passwords.
- Store passwords using a modern password hashing algorithm supported by the framework.
- Apply login rate limiting.
- Use secure password reset tokens with expiry and single use.
- Avoid account enumeration in login and reset responses.
- Consider MFA for privileged accounts.
- Invalidate sessions after password changes and account compromise.
- Protect admin routes server-side.

Never implement authentication only through frontend route hiding.

## 4. Authorization

- Deny by default.
- Check permissions on every protected server action.
- Separate content editor, administrator and other roles where needed.
- Public visitors must not read enquiries or admin records.
- Enforce object-level authorization, not just page-level access.
- Log sensitive administrative actions safely.

## 5. Session and cookie security

Where applicable:
- HTTPS only.
- Secure cookie flag.
- HttpOnly flag for session cookies.
- Appropriate SameSite setting.
- Session rotation after login and privilege changes.
- Idle and absolute session expiry.
- Server-side invalidation on logout.
- Avoid storing session tokens in localStorage where safer cookie-based sessions are supported.

## 6. Input validation and output encoding

- Validate all input on the server.
- Use allowlists for structured values.
- Apply length limits.
- Normalize data carefully.
- Use parameterized queries or safe ORM methods.
- Escape output according to HTML, attribute, URL and JavaScript context.
- Avoid unsafe HTML injection.
- Sanitize rich text using a trusted allowlist sanitizer if rich text is required.
- Never trust hidden form fields.

## 7. Contact form protection

- CSRF/origin protections where applicable.
- Rate limiting by suitable signals.
- Honeypot or challenge mechanism as appropriate.
- Server-side validation.
- Email address and field length checks.
- Prevent email header injection.
- Prevent arbitrary recipient selection.
- Avoid public access to stored submissions.
- Return generic error messages.
- Record safe operational logs.
- Apply retention and deletion rules.
- Ensure consent text matches the actual data use.

## 8. File uploads

If uploads are supported:
- Define allowed file types.
- Validate extension and actual content/MIME.
- Limit file size and count.
- Generate storage names; do not trust user filenames.
- Store outside executable/public paths where possible.
- Scan files where infrastructure supports it.
- Prevent path traversal.
- Prevent direct public access to private uploads.
- Apply authorization before download.
- Do not accept executable files unless there is a specific, reviewed need.

## 9. API and integration security

- Keep API keys on the server.
- Use least-privilege credentials.
- Set timeouts and handle failures.
- Validate webhook signatures where supported.
- Prevent replay where applicable.
- Restrict outbound destinations to reduce SSRF risk.
- Do not expose internal error details.
- Rotate compromised credentials.
- Use separate credentials for staging and production.
- Never hardcode secrets in source, frontend bundles or documentation.

## 10. Database security

- Use a dedicated least-privilege database account.
- Do not expose the database port publicly unless necessary and protected.
- Encrypt connections where supported.
- Restrict database network access.
- Use parameterized queries.
- Back up securely.
- Test restore procedures.
- Limit production data access.
- Do not use production personal data in development unless properly protected and authorised.

## 11. Security headers

Review and configure appropriate headers for the actual application:
- Content-Security-Policy.
- Strict-Transport-Security (after HTTPS and subdomain readiness are confirmed).
- X-Content-Type-Options.
- Referrer-Policy.
- Permissions-Policy.
- Frame restrictions through CSP frame-ancestors or compatible configuration.

Do not copy a restrictive CSP blindly; test legitimate scripts, fonts, analytics and integrations.

## 12. Dependencies and deployment

- Use lockfiles.
- Review dependency updates.
- Scan for known vulnerabilities.
- Remove unused packages.
- Restrict deployment credentials.
- Protect production branch.
- Use CI checks.
- Do not print secrets in build logs.
- Back up before release.
- Test staging.
- Maintain rollback instructions.
- Limit SSH and hosting access to authorised people.

## 13. Privacy and data handling

- Collect only necessary enquiry data.
- Explain purpose and contact method in the privacy notice.
- Restrict internal access.
- Define retention and deletion process.
- Avoid sending personal data to analytics.
- Do not include form message contents in tracking events.
- Review third-party processors and cross-border transfers as applicable.
- Do not claim legal compliance without a proper review.

## 14. Logging and monitoring

Log:
- Authentication failures and suspicious activity.
- Privileged changes.
- Form delivery errors.
- Application failures.
- Security-relevant configuration changes.

Do not log:
- Passwords.
- Session tokens.
- API keys.
- Full payment data.
- Unnecessary personal information.
- Complete confidential project briefs unless there is a justified, protected operational need.

## 15. Incident response

Document:
1. Who receives security alerts.
2. How to disable compromised credentials.
3. How to restrict affected endpoints.
4. How to preserve relevant logs.
5. How to restore from clean backups.
6. How to assess affected data.
7. Who approves customer communication.
8. How to record lessons learned.

## 16. Security testing checklist

- Authentication and password reset.
- Admin authorization.
- CSRF.
- XSS.
- SQL injection.
- Rate limits.
- Form spam.
- File upload checks.
- Session handling.
- Security headers.
- Dependency audit.
- Secret scanning.
- Backup restore.
- Error page information leakage.
- Public/private data separation.

## 17. Release gate

Do not release if there is:
- A known critical or high-risk vulnerability without an approved mitigation.
- Public exposure of enquiries or admin endpoints.
- Secret leakage.
- Broken authentication or authorization.
- Unverified destructive database migration.
- No usable backup or rollback plan.
