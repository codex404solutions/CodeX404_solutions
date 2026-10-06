# CodeX404 Solutions — Main Website Architecture

## 1. Architectural Goal
The public website should remain lightweight, fast, secure and easy to maintain while leaving clean integration points for future CRM and product systems.

## 2. Recommended Stack
- PHP 8.2+
- Apache/Linux
- HTML5
- CSS3
- JavaScript
- Bootstrap only when it provides real value
- MySQL for CMS/lead-related dynamic data if required
- Hostinger compatible deployment

Do not force React/FastAPI/PostgreSQL into a simple marketing site merely because they are useful for future products.

## 3. Application Layers
```text
Browser
  ↓
Page / Controller
  ↓
Validation
  ↓
Service
  ↓
Repository
  ↓
Database
```

Static pages may skip unnecessary layers.

## 4. Directory Structure
```text
codex404/
├── index.php
├── solutions.php
├── ai-solutions.php
├── ai-agents.php
├── automation.php
├── software-development.php
├── mobile-apps.php
├── saas.php
├── industries.php
├── case-studies.php
├── portfolio.php
├── process.php
├── about.php
├── engagement-models.php
├── security.php
├── faq.php
├── contact.php
├── discovery-call.php
├── privacy.php
├── terms.php
├── includes/
│   ├── header.php
│   ├── footer.php
│   ├── navigation.php
│   └── seo.php
├── components/
├── config/
├── app/
│   ├── Controllers/
│   ├── Services/
│   ├── Repositories/
│   └── Validators/
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│   ├── icons/
│   └── fonts/
├── storage/
├── admin/
└── .env
```

## 5. Configuration
Keep:
- database credentials
- mail credentials
- API keys
- webhook secrets
- environment flags

outside version-controlled source.

## 6. URL Strategy
Prefer clean URLs where the hosting configuration supports them.

Examples:
```text
/
 /solutions
 /ai-solutions
 /automation
 /industries
 /case-studies
 /about
 /contact
 /book-a-call
```

If PHP files are used directly, configure canonical URLs consistently.

## 7. Component Architecture
Reusable components:
- header
- footer
- button
- CTA
- service card
- industry card
- case-study card
- testimonial
- FAQ
- form field
- badge
- section heading
- logo strip
- process step

Do not copy/paste large blocks between pages.

## 8. Content Architecture
Separate content from presentation where practical.

For a growing site, consider:
```text
content/
├── services/
├── industries/
├── case-studies/
├── faq/
└── pages/
```

A small CMS may be introduced later.

## 9. CRM Integration Architecture
Future:
```text
Public Website
     ↓
POST /lead endpoint
     ↓
Validation
     ↓
Signed API request
     ↓
CRM API
```

Requirements:
- idempotency key
- rate limiting
- server-side request
- timeout
- safe retry
- structured response
- logging without secrets

## 10. Analytics
Track meaningful events:
- discovery call click
- contact submission
- audit CTA
- case-study view
- service page view
- outbound click
- phone/email click

Do not add invasive tracking unnecessarily.

## 11. SEO Architecture
Create:
- sitemap.xml
- robots.txt
- canonical URLs
- schema markup
- Open Graph
- clean internal linking

## 12. Security Architecture
- HTTPS
- security headers
- secure cookies if sessions exist
- CSRF for state-changing session requests
- output escaping
- input validation
- rate limiting
- secure upload rules
- no secrets in repository
- production error handling

## 13. Deployment
Recommended:
```text
Local development
    ↓
Git
    ↓
Testing
    ↓
Production deployment
    ↓
Smoke test
```

Keep production debug disabled.

## 14. Scalability
The marketing website should remain independent from future:
- CRM
- SaaS products
- client applications
- ERP systems

Use APIs rather than tightly coupling separate applications.
