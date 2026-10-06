# CodeX404 Solutions — CRM Mandatory Rules

## 1. Multi-Role Is Mandatory
One person may hold multiple roles simultaneously.

Example:
CEO + CTO.

Do not force separate accounts.

Effective permissions:
```text
User Permissions =
Union of permissions from active roles
```

If an explicit deny policy is introduced later:
```text
Deny > Allow
```

## 2. Roles Are Not Permissions
Do not write:
```text
if role == "CEO"
```
throughout the application.

Instead:
```text
if user.can("deal.view")
```

Role names map to permissions.

## 3. Record-Level Security
Authorization must verify:
- user
- permission
- record
- scope

Never trust:
- hidden inputs
- URL IDs
- client-side permissions
- JavaScript-only restrictions.

## 4. CEO
CEO can be configured for broad business visibility, but this must come from permissions, not hard-coded bypasses.

## 5. CTO
CTO can have technical/project permissions and may also have CEO permissions if assigned both roles.

## 6. Sales
Sales should access:
- assigned leads
- assigned opportunities
- activities
- proposals

unless broader permissions are granted.

## 7. Marketing
Marketing should access:
- campaigns
- attribution
- permitted leads

Do not automatically expose sensitive financial data.

## 8. Developer
Developer should normally access:
- assigned projects
- assigned tasks
- technical documentation

Do not automatically expose:
- private sales notes
- financial records
- HR data

## 9. Finance
Finance can access:
- invoices
- payments
- expenses

unless permissions explicitly provide other access.

## 10. Data Integrity
- Transactions for multi-step changes.
- DECIMAL for money.
- Immutable historical payment records.
- Refund/adjustment instead of destructive rewriting.
- Unique invoice/receipt numbers.
- Audit critical changes.

## 11. Leads
- Deduplicate.
- Preserve source.
- Preserve campaign attribution.
- Preserve history.
- Require ownership rules.
- Do not silently delete.

## 12. Opportunities
- Pipeline required.
- Stage required.
- Amount must have currency.
- Lost reason required for Lost status.
- Stage history audited.

## 13. Proposals
- Every sent proposal is versioned.
- Accepted version is immutable.
- New changes create a new version.

## 14. Projects
Only authorized users can access project records.

Project technical and financial permissions should be separable.

## 15. Automation
Every automation must have:
- active state
- trigger
- conditions
- actions
- execution log
- failure status
- retry limit
- loop prevention

## 16. API
All machine-to-machine APIs require:
- authentication
- validation
- rate limiting
- idempotency where relevant
- auditability

## 17. Documents
Never expose private documents through predictable URLs.

## 18. Privacy
Collect only necessary personal data.
Limit exports.
Provide retention/archive controls.

## 19. Security
- Password hashing.
- Secure cookies.
- Session regeneration.
- CSRF.
- XSS prevention.
- SQL injection prevention.
- Rate limiting.
- Security headers.
- Secret management.

## 20. UI
- Do not show unauthorized actions.
- But also enforce authorization server-side.
- Show clear status.
- Confirm destructive actions.
- Provide loading/error/empty states.

## 21. Development
No production feature is complete if it is only a frontend mockup.
Database, API/service, permissions, validation, UI, audit and tests must exist where applicable.

---

## 22. Data Privacy & GDPR Compliance

### GDPR Requirements
CodeX404 CRM stores personal data of leads and clients from EU/UK countries. Full GDPR compliance is mandatory.

#### Data Subject Rights Implementation

**Right to Access (Subject Access Request)**
```sql
-- Endpoint: GET /api/profile/data-export
-- Generate complete export of user's data
SELECT * FROM leads WHERE email = ?
UNION
SELECT * FROM contacts WHERE email = ?
UNION
SELECT * FROM activities WHERE contact_email = ?
-- etc.

-- Return as JSON or PDF within 30 days
```

**Right to Rectification**
```php
// Allow users to update their information
// Audit log: who changed what and when
UPDATE leads SET 
    name = ?, 
    phone = ?, 
    updated_by = ?, 
    updated_at = NOW() 
WHERE email = ?;

// Log in audit_logs table
```

**Right to Erasure**
```php
// Soft delete, not hard delete
// Keep audit trail that deletion occurred
UPDATE leads SET 
    deleted_at = NOW(),
    deleted_by = ?,
    deletion_reason = 'user_request',
    -- Anonymize PII
    name = 'DELETED',
    email = CONCAT('deleted_', id, '@anonymized.local'),
    phone = NULL,
    company = 'DELETED',
    notes = 'DELETED'
WHERE id = ?;

// Log deletion in audit_logs (permanent record)
```

**Right to Data Portability**
```php
// Export endpoint returns JSON/CSV
{
  "personal_data": {
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1-555-1234",
    "company": "Acme Corp",
    "created_at": "2026-05-15T10:30:00Z"
  },
  "activities": [...],
  "communications": [...],
  "proposals": [...]
}
```

**Right to Object**
```php
// Marketing opt-out
UPDATE leads SET 
    marketing_consent = FALSE,
    consent_withdrawn_at = NOW()
WHERE email = ?;

// Stop all automated marketing emails
// Manual outreach only with explicit permission
```

### Consent Management

#### Track Consent
```sql
CREATE TABLE consent_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    consent_type ENUM('marketing', 'data_processing', 'third_party') NOT NULL,
    consented BOOLEAN NOT NULL,
    consent_method VARCHAR(50), -- 'website_form', 'email_signup', 'manual'
    ip_address VARCHAR(45),
    user_agent TEXT,
    consented_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
);
```

#### Consent Types
- **Data Processing:** Required for CRM storage (captured on website form)
- **Marketing:** Optional for newsletters/campaigns
- **Third-party:** If sharing with partners (not currently applicable)

### Data Retention in CRM

#### Automatic Deletion Rules
```php
// Cron job runs daily
// Delete leads inactive for 2+ years
DELETE FROM leads 
WHERE status = 'disqualified' 
AND last_activity < NOW() - INTERVAL 2 YEAR
AND deleted_at IS NULL;

// Archive before deletion
INSERT INTO archived_leads SELECT * FROM leads WHERE ...;

// Keep aggregated statistics only
INSERT INTO lead_statistics (month, source, count) 
SELECT DATE_FORMAT(created_at, '%Y-%m'), source, COUNT(*) 
FROM leads 
WHERE ...
GROUP BY ...;
```

#### Retention Periods (Configurable)
- Active leads: Indefinite
- Inactive leads (no response): 2 years → archive
- Lost deals: 1 year → archive  
- Won deals → Clients: 7 years (financial records)
- Archived data: Anonymize after retention period
- Audit logs: 3 years
- Consent logs: Permanent (proof of compliance)

### Data Minimization

#### Only Collect Necessary Fields
```php
// Required for business relationship
✅ name, email, company, service_interest, problem

// Optional but useful
✅ phone (if user provides)
✅ job_title (for qualification)
✅ country (for market analysis)

// Do NOT collect
❌ date_of_birth
❌ personal address (B2B, not needed)
❌ national ID numbers
❌ race, religion, political affiliation
❌ health information
❌ sexual orientation
❌ biometric data
```

### Data Security Measures

#### Encryption
- ✅ Data in transit: HTTPS/TLS 1.3
- ✅ Passwords: bcrypt with cost factor 12+
- ✅ API secrets: 256-bit random keys
- ✅ Session tokens: cryptographically random
- 🔲 Data at rest: Consider if storing sensitive financial data (future)

#### Access Controls
- ✅ Role-based access (RBAC)
- ✅ Record-level permissions (scope)
- ✅ Two-factor authentication (admin accounts)
- ✅ Password complexity requirements
- ✅ Session timeout (8 hours)
- ✅ IP allowlisting (optional for admin)

#### Audit Logging
```sql
-- Log all access to sensitive data
CREATE TABLE audit_logs (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(50), -- 'view', 'edit', 'delete', 'export'
    resource_type VARCHAR(50), -- 'lead', 'invoice', 'proposal'
    resource_id VARCHAR(36),
    changes JSON, -- old_value → new_value
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_action (user_id, action),
    INDEX idx_resource (resource_type, resource_id),
    INDEX idx_created (created_at)
);
```

### Third-Party Data Processors

#### Current Processors
- **Hostinger:** Hosting/data storage (EU/US servers)
- **Razorpay:** Payment processing (India, ISO 27001 certified)
- **Email SMTP:** Hostinger email or Gmail (if used)

#### Data Processing Agreements (DPA)
- Ensure each processor has GDPR-compliant terms
- Review annually
- Document data flows

#### Data Transfers Outside EU
- India is not GDPR-adequate country
- But transfers allowed with safeguards:
  - Standard Contractual Clauses (SCC)
  - Encryption in transit
  - Access controls
  - Client awareness (disclose in Privacy Policy)

### Marketing Compliance

#### Email Marketing Rules
```php
// Check consent before sending marketing email
if (!$lead->marketing_consent) {
    throw new Exception('No marketing consent');
}

// Every email must have unsubscribe link
$unsubscribeUrl = "https://crm.codex404solutions.online/unsubscribe?token={$token}";

// Honor unsubscribe immediately
// Update within 24 hours maximum
```

#### B2B Legitimate Interest
- Cold email to business contacts allowed under "legitimate interest"
- Must still provide opt-out in first email
- Must honor opt-out immediately
- No purchased email lists
- Explain how you got their contact

### Data Breach Protocol

#### If Breach Occurs

**Immediate (0-24 hours):**
1. Identify what data was compromised
2. Contain the breach (disable access)
3. Preserve evidence (logs, screenshots)
4. Notify CEO/CTO immediately

**Within 72 hours:**
5. Notify supervisory authority (if EU residents affected)
   - Authority: Depends on client location (ICO for UK, etc.)
   - Use authority's breach notification portal
6. Document incident thoroughly

**If high risk to individuals:**
7. Notify affected individuals directly
8. Explain: what happened, what data, what we're doing
9. Provide support: dedicated email, monitoring services if appropriate

#### Breach Prevention
- Regular security audits
- Penetration testing (annual)
- Dependency updates (monthly)
- Employee training (quarterly)
- Incident response drills (annual)

### CRM User Training

#### All Team Members Must Know
- What personal data we collect and why
- How to handle data securely
- How to recognize phishing/social engineering
- Who to contact if breach suspected
- Data retention policies
- User rights (access, deletion, etc.)

#### Sales Team Specific
- Get consent before adding to marketing lists
- Don't share prospect data externally
- Use secure channels for sensitive info (no WhatsApp screenshots)
- Delete prospects who request removal

### Privacy by Design

#### When Building New Features
1. **Data Minimization:** Do we really need this field?
2. **Purpose Limitation:** Only use data for stated purpose
3. **Storage Limitation:** Set retention period upfront
4. **Accuracy:** Provide way to update incorrect data
5. **Security:** Encrypt if sensitive, access control
6. **Transparency:** Document in Privacy Policy
7. **Accountability:** Audit logs for sensitive operations

### International Considerations

#### By Country

**EU/UK (GDPR)**
- Strict compliance required
- 30-day response to rights requests
- 72-hour breach notification
- Fines up to 4% of global revenue

**USA (No federal privacy law yet, but states)**
- California CCPA: Similar to GDPR
- Virginia VCDPA: Similar to GDPR  
- Follow GDPR-level standards to be safe

**India (DPDP Act 2023)**
- India's own privacy law coming
- Similar to GDPR principles
- Consent requirements
- Right to erasure

**UAE/Saudi Arabia/GCC**
- Varies by country
- Generally business-friendly
- Some data localization requirements
- Follow GDPR standards as best practice

### Privacy Settings in CRM

#### User-Facing Privacy Controls
```php
// Settings → Privacy
- Download my data (JSON export)
- Update my information
- Delete my account
- Marketing preferences
- Consent history
- Data retention preferences
```

#### Admin Privacy Controls
```php
// Admin → Privacy Settings
- Data retention periods (configurable)
- Automatic deletion rules
- Export compliance reports
- Consent audit log
- Breach notification templates
- Privacy notice templates
```

### Compliance Checklist

#### Before CRM Launch
- [ ] Privacy Policy created and linked
- [ ] Cookie Policy created (if CRM uses cookies)
- [ ] Consent tracking implemented
- [ ] Data retention rules configured
- [ ] User rights endpoints implemented (access, deletion, export)
- [ ] Audit logging active
- [ ] Data breach response plan documented
- [ ] Team trained on privacy obligations
- [ ] DPAs with third-party processors reviewed
- [ ] Security measures documented
- [ ] Backup encryption configured
- [ ] Access controls tested

#### Quarterly Review
- [ ] Review data retention (delete old data)
- [ ] Audit third-party processors
- [ ] Update Privacy Policy if practices changed
- [ ] Review and test breach response plan
- [ ] Train new team members
- [ ] Review high-privilege user access
- [ ] Check for unpatched vulnerabilities

### CRM Privacy Contact
- **Email:** privacy@codex404solutions.online
- **Data Protection Officer (DPO):** If required (companies with >250 employees processing sensitive data systematically)
- **Response Time:** 7 business days for inquiries, 30 days for rights requests

### Records of Processing Activities (ROPA)

Document what personal data we process:

| Data Category | Purpose | Legal Basis | Retention | Recipients |
|---------------|---------|-------------|-----------|------------|
| Lead contact info | Sales qualification | Legitimate interest | 2 years | Internal team only |
| Client info | Service delivery | Contract | 7 years | Internal + payment processor |
| Marketing lists | Email campaigns | Consent | Until unsubscribe | Internal + email service |
| Payment data | Invoicing | Contract + legal obligation | 7 years | Razorpay |
| Audit logs | Security | Legitimate interest | 3 years | Internal security team |

### Anonymization vs Pseudonymization

**Anonymization (Irreversible):**
```sql
-- After retention period
UPDATE archived_leads SET
    name = 'ANON_' || MD5(RANDOM()),
    email = 'anon_' || id || '@deleted.local',
    phone = NULL,
    company = 'ANONYMIZED',
    notes = NULL;
-- Cannot be re-identified
```

**Pseudonymization (Reversible with key):**
```sql
-- For analytics while preserving privacy
UPDATE leads SET
    email_hash = SHA256(email || secret_salt);
-- Can still track unique users without storing email
```

### Children's Data
- **Policy:** Do not knowingly process data of anyone under 16
- **Verification:** B2B service assumes business contacts are adults
- **If discovered:** Delete immediately, notify guardian

### Legal Disclaimer
This section provides privacy implementation guidance. It is NOT legal advice. Consult a qualified data protection lawyer for your specific use case and jurisdictions before processing EU/UK personal data.

---

## 23. Payment Data Security (Razorpay)

### PCI DSS Compliance
- ✅ Never store credit card numbers in CRM database
- ✅ Never log credit card numbers
- ✅ Use Razorpay Checkout (handles card data)
- ✅ Store only: Razorpay payment_id, order_id, status
- ✅ Verify webhook signatures
- ✅ Use HTTPS for payment pages

### Payment Data Retention
```sql
-- Store only non-sensitive payment metadata
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT NOT NULL,
    razorpay_payment_id VARCHAR(100) UNIQUE, -- e.g., pay_xxxxx
    razorpay_order_id VARCHAR(100),
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'INR',
    status ENUM('pending', 'success', 'failed', 'refunded'),
    payment_method VARCHAR(20), -- 'card', 'upi', 'netbanking'
    -- DO NOT STORE: card number, CVV, card holder name
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Refund Handling
```php
// Create refund record, don't delete payment
INSERT INTO refunds (
    payment_id,
    amount,
    reason,
    razorpay_refund_id,
    status
) VALUES (?, ?, ?, ?, 'success');

// Update invoice status
UPDATE invoices SET status = 'refunded' WHERE id = ?;
```
