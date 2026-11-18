# CodeX404 Solutions — Engineering and Antigravity Rules

These rules apply to all implementation phases.

---

## 1. Non-negotiable project rules

1. Read the project documentation before editing code.
2. Audit the existing codebase before making architectural changes.
3. Do not assume the current framework, database or hosting setup.
4. Do not rewrite working features just to use a preferred technology.
5. Do not delete files, routes, tables or integrations without documenting the impact and obtaining approval.
6. Do not deploy to production without explicit approval.
7. Do not modify production data directly.
8. Never expose credentials, tokens, private keys or customer information.
9. Do not invent business claims, client results, testimonials or certifications.
10. Preserve the approved CodeX404 visual identity.

## 2. Brand rules

Company architecture:
- BUILD — blue accent.
- GROW — purple accent.
- AUTOMATE — green accent.

Shared brand:
- Dark navy/black technology background.
- White and light readable text.
- Existing cyan/blue/purple/magenta gradients.
- Existing logo asset.
- Subtle network/grid/particle effects.
- Rounded cards and restrained glow.
- Existing typography wherever suitable.

Do not recreate or distort the logo. Do not introduce unrelated theme colors.

## 3. Content rules

- Write in clear, direct English.
- Explain technical terms in plain language.
- Write for the customer, not search engines alone.
- Make each service page genuinely different.
- State what is included and what depends on scope.
- Distinguish capabilities from services currently available.
- Do not guarantee search rankings, AI citations, leads, revenue or uptime.
- Use case studies only with verified facts and publication permission.
- Mark demo, internal, experimental and client projects accurately.
- Do not fabricate reviews or testimonials.
- Do not publish placeholder text.

## 4. GROW rules

GROW is the digital growth division and includes Digital Marketing.

Service groups:
1. Search visibility: SEO, AEO, GEO, Local SEO.
2. Digital marketing: social media, paid campaigns, email marketing and campaign management.
3. Content and brand growth: content strategy, copywriting, blogs, digital PR.
4. Conversion and measurement: CRO, landing pages, lead generation, analytics and reporting.

Only publish services that the business can actually deliver. If a service is planned but not currently staffed or operational, keep it out of public claims or clearly label it as a planned capability.

Never guarantee:
- Google ranking positions.
- Featured snippets.
- AI assistant citations.
- A fixed number of leads.
- Advertising return on investment.
- Viral reach.

## 5. Coding rules

- Follow existing repository conventions.
- Use the existing formatter and linter.
- Use clear names and small, focused functions.
- Avoid duplicated logic.
- Keep UI components reusable.
- Keep business logic out of presentation components where practical.
- Validate external and user input.
- Handle errors explicitly.
- Avoid swallowing exceptions.
- Use parameterized database queries or the framework's safe ORM.
- Avoid unsafe HTML rendering.
- Do not add dependencies without explaining why.
- Pin or lock dependencies using the existing package manager.
- Update documentation when behavior changes.

## 6. Frontend rules

- Mobile-first responsive behavior.
- Semantic HTML.
- Accessible labels and controls.
- Keyboard-accessible navigation and dialogs.
- Visible focus states.
- Respect reduced-motion settings.
- Prevent horizontal overflow.
- Avoid layout shift.
- Keep buttons and links visually distinct.
- Ensure forms show useful validation messages.
- Do not rely on color alone to communicate state.

## 7. Backend rules

- Validate on the server.
- Authorize every protected action.
- Use least privilege.
- Use safe session and cookie settings.
- Apply rate limits to public forms and sensitive endpoints.
- Avoid returning stack traces to visitors.
- Do not expose internal IDs or private records unnecessarily.
- Use transactions for multi-step data changes where appropriate.
- Make migrations reversible where feasible.
- Log security events without recording secrets.

## 8. Database rules

- Inspect schema before modifying it.
- Use migrations, never ad hoc production edits.
- Back up before structural changes.
- Define indexes based on real query patterns.
- Use foreign keys where supported and appropriate.
- Define deletion and retention behavior.
- Avoid storing data that is not needed.
- Never store plaintext passwords.
- Do not put credentials in database seed files.
- Test migrations on a copy or staging environment.

## 9. Security rules

Follow SECURITY.md. Security review is required for:
- Authentication.
- Admin roles.
- File uploads.
- Contact forms.
- Email sending.
- External API integrations.
- CMS publishing.
- Database migrations.
- Deployment configuration.

## 10. SEO and content rules

- One clear primary heading per page where appropriate.
- Unique title and description.
- Canonical URL.
- Useful internal links.
- Correct image alt text.
- Crawlable service content.
- Redirect old URLs when changed.
- No keyword stuffing.
- No doorway pages.
- No fake structured data.
- Use schema only when content meets the relevant guidelines.
- Keep noindex rules for private or utility pages.

## 11. Git rules

- Check `git status` before changes.
- Work on a feature branch.
- Make small, meaningful commits.
- Never force-push shared branches without approval.
- Never commit `.env`, private keys, database dumps or customer exports.
- Review diffs before committing.
- Keep production branch protected according to repository policy.

Suggested branch:
`feature/codex404-build-grow-automate`

## 12. Antigravity execution protocol

For each task:
1. Read the relevant MD files.
2. Inspect the affected code.
3. State the implementation plan.
4. Identify affected routes, components, tables and integrations.
5. Implement only the approved scope.
6. Run relevant tests and checks.
7. Inspect the diff.
8. Update documentation.
9. Report completed work and remaining risks.
10. Stop and wait for approval before the next phase.

Do not interpret a phase prompt as permission to skip prerequisites.

## 13. Completion definition

A task is not complete merely because code was generated. It is complete only when:
- Requirements are implemented.
- Relevant tests pass.
- Responsive behavior is checked.
- Security impact is reviewed.
- SEO impact is reviewed where applicable.
- Documentation is updated.
- No known critical regression remains.
- The implementation report is provided.
