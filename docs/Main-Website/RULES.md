# CodeX404 Solutions — Main Website Rules

## Brand
1. Position as a professional technology partner.
2. Never compete primarily on cheap pricing.
3. Do not call the company an outsourcing provider unless specifically intended.
4. Explain business value before technical implementation.
5. Maintain a premium global tone.

## Claims
Never invent:
- clients
- testimonials
- awards
- certifications
- revenue
- number of projects
- ROI
- team size
- years of experience
- partnerships

If a claim is not verified, either remove it or write it as a capability rather than a historical claim.

## UX
- Mobile first.
- Fast navigation.
- Clear CTA.
- Consistent spacing.
- Accessible forms.
- No dark-pattern UX.
- No forced popups that block the visitor immediately.
- No excessive animation.

## Technical
- Validate server-side.
- Escape output.
- Prepared SQL.
- CSRF where applicable.
- Rate-limit public forms.
- Never expose secrets.
- Never expose PHP errors publicly.
- Use secure upload handling.

## SEO
- One clear H1.
- Human-readable content.
- No keyword stuffing.
- No hidden SEO text.
- No fake location pages.
- No duplicate service pages with superficial changes.

## Content
Prefer:
- business problem
- solution
- implementation
- outcome
- proof

Avoid:
- empty buzzwords
- excessive jargon
- vague “cutting-edge” claims
- generic AI promises.

## Design
Use the defined CodeX404 palette consistently.
Do not turn every section into a gradient.
Use motion to communicate hierarchy, not decoration.

## Future CRM
Do not implement the full CRM in the main website repository.
Only create clean lead-capture integration points.

---

## Data Privacy & GDPR Compliance

### GDPR Requirements (EU/UK Customers)
Since CodeX404 targets UK, Germany, Netherlands, and Ireland, GDPR compliance is mandatory.

#### Cookie Consent
- Display cookie consent banner on first visit
- Must appear before any non-essential cookies load
- Allow users to accept/reject non-essential cookies
- Essential cookies (session) don't require consent
- Log consent decisions with timestamp

#### Privacy Policy (Required)
Must clearly explain:
- What data we collect (name, email, phone, company, IP, UTM parameters)
- Why we collect it (lead qualification, service delivery, communication)
- How long we keep it (see retention policy below)
- Who has access (internal team, no third-party sales)
- User rights (access, correction, deletion, export)
- How to exercise rights (email: privacy@codex404solutions.online)
- Data transfer information (if using US services)
- Last updated date

#### User Rights
**Right to Access**
- Users can request all data we have about them
- Respond within 30 days
- Provide in readable format (PDF or JSON)

**Right to Rectification**
- Users can request correction of incorrect data
- Update within 30 days

**Right to Erasure ("Right to be Forgotten")**
- Users can request deletion of their data
- Exceptions: legal obligations, contract fulfillment
- Soft delete (mark as deleted, anonymize) rather than hard delete
- Retain deletion audit log

**Right to Data Portability**
- Users can request their data in machine-readable format
- Provide JSON or CSV export

**Right to Object**
- Users can object to marketing communications
- Unsubscribe link in every marketing email
- Honor opt-out immediately

#### Implementation
```php
// Contact form consent checkbox (required)
☑ I agree to the Privacy Policy and consent to CodeX404 Solutions 
  storing my information for the purpose of responding to my inquiry.

// Newsletter consent checkbox (optional)
☐ I would like to receive updates about AI, automation, and 
  software development insights. (You can unsubscribe anytime)
```

### Data Retention Policy

#### Leads & Contacts
- **Active leads:** Retain while relationship is active
- **Inactive leads (no response):** 2 years, then archive
- **Lost deals:** 1 year, then archive
- **Archived data:** Anonymize after retention period (keep only aggregated stats)

#### Clients & Projects
- **Active clients:** Retain indefinitely
- **Completed projects:** 7 years (financial/legal compliance)
- **Invoices/payments:** 7 years (tax requirements in India/international)

#### Marketing Data
- **Email subscribers:** Until unsubscribe + 30 days
- **UTM/analytics data:** 3 years
- **IP addresses:** 90 days (security logs)

#### Audit Logs
- **Security events:** 3 years
- **Data access logs:** 1 year
- **Consent logs:** Permanent (proof of consent)

### Data Minimization
Only collect necessary data:
- ✅ Name, email, company (required for service)
- ✅ Phone (optional, for communication preference)
- ✅ Job title (helpful for qualification)
- ✅ Problem description (necessary to understand needs)
- ❌ Date of birth (not needed)
- ❌ Personal address (not needed for B2B)
- ❌ Race, religion, political views (illegal to collect)

### Third-Party Data Sharing
**Current policy: NO THIRD-PARTY SALES OR SHARING**

Exceptions (must disclose in Privacy Policy):
- Email service provider (for sending emails)
- Analytics (Google Analytics - anonymize IP)
- Payment processor (Razorpay - only for transactions)
- Hosting provider (Hostinger - data storage)

All third-party processors must have GDPR-compliant data processing agreements.

### International Data Transfers
**India → EU transfers:**
- Not currently restricted (India not deemed adequate by EU, but transfers allowed with safeguards)
- Use standard contractual clauses with service providers
- Encrypt data in transit (HTTPS)
- Encrypt sensitive data at rest

### Marketing Compliance

#### Email Marketing
- **Opt-in required:** Explicit consent for marketing emails
- **Unsubscribe:** Clear unsubscribe link in every email
- **Sender identification:** Clear "From" name (CodeX404 Solutions)
- **Physical address:** Include in email footer
- **Honor opt-outs:** Process within 24 hours

#### Cold Outreach (B2B)
- Legitimate interest basis (business to business)
- Must still provide opt-out
- Must explain how you got their contact
- No purchased email lists

### Data Security Measures
- ✅ HTTPS/TLS encryption
- ✅ Secure password hashing (bcrypt)
- ✅ SQL injection prevention (prepared statements)
- ✅ XSS prevention (output escaping)
- ✅ CSRF protection
- ✅ Access controls (CRM role-based permissions)
- ✅ Audit logging
- ✅ Regular backups
- ✅ Incident response plan

### Data Breach Protocol
If personal data breach occurs:

**Within 72 hours:**
1. Identify scope of breach
2. Contain the breach
3. Notify supervisory authority (if EU residents affected)
4. Document incident

**If high risk to individuals:**
5. Notify affected individuals directly
6. Explain what happened
7. Explain remediation steps
8. Provide support contact

### Cookies Used

#### Essential Cookies (No consent needed)
```
PHPSESSID - Session management
csrf_token - Security
```

#### Analytics Cookies (Consent required)
```
_ga, _gid - Google Analytics (anonymized IP)
```

#### Marketing Cookies (Consent required)
```
utm_* - Campaign tracking (stored server-side, not cookie)
```

### Children's Privacy
- We do not knowingly collect data from anyone under 16
- B2B service only
- If discovered, delete immediately

### Privacy Contact
- **Email:** privacy@codex404solutions.online
- **Response time:** Within 7 business days
- **Escalation:** CEO (for serious complaints)

### Compliance Checklist
Before launch:
- [ ] Privacy Policy page created
- [ ] Cookie consent banner implemented
- [ ] Consent checkboxes on forms
- [ ] Unsubscribe mechanism in emails
- [ ] Data retention policy configured in CRM
- [ ] User rights request workflow documented
- [ ] Data breach response plan documented
- [ ] Team trained on privacy obligations
- [ ] Third-party processor agreements reviewed

### Annual Review
- Review privacy policy (update if practices change)
- Audit data retention (delete old data)
- Review third-party processors
- Update cookie list if changed
- Train new team members

---

## Legal Disclaimer
This is guidance for implementing privacy-friendly practices. It is NOT legal advice. Consult a lawyer specializing in data protection law for your specific jurisdiction and business model before processing EU/UK resident data.
