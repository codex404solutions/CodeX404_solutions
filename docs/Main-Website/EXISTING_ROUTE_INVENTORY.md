# CodeX404 Solutions — Existing Route Inventory

**Document:** EXISTING_ROUTE_INVENTORY.md  
**Project:** CodeX404 Solutions Main Website Redesign  
**Audit Date:** 2026-11-18; route status updated 2026-11-19  

> This is a baseline inventory. The implementation adds `/build`, `/grow`, and `/automate` as division overview routes. Existing extensionless URLs remain supported by the root `.htaccess` rules.

---

## 1. Public Frontend Routes

| Relative URL | Physical File | HTTP Methods | Authentication | Description | Migration Action |
|---|---|---|---|---|---|
| `/` or `/index.php` | `website/index.php` | GET | Public | Primary Homepage with Hero, Marquee, SVG Flow, Simulators | Upgrade in Phase 2 with BUILD/GROW/AUTOMATE & Sliders |
| `/build` | `website/build.php` | GET | Public | BUILD division overview | Added 2026-11-19; existing service routes remain canonical |
| `/grow` | `website/grow.php` | GET | Public | GROW division overview | Added 2026-11-19; further specialist pages require confirmed scope |
| `/automate` | `website/automate.php` | GET | Public | AUTOMATE division overview | Added 2026-11-19; existing AI and workflow routes remain canonical |
| `/about.php` | `website/about.php` | GET | Public | Company background, leadership & engineering credentials | Preserve & align division narratives |
| `/solutions.php` | `website/solutions.php` | GET | Public | Solutions umbrella overview | Transition into division portals (BUILD/GROW/AUTOMATE) |
| `/software-development.php` | `website/software-development.php` | GET | Public | Custom software engineering | Map to `/build/custom-software/` |
| `/ai-solutions.php` | `website/ai-solutions.php` | GET | Public | Enterprise AI & RAG systems | Map to `/automate/ai-automation/` |
| `/ai-agents.php` | `website/ai-agents.php` | GET | Public | Autonomous multi-tool agents | Map to `/automate/ai-agents/` |
| `/automation.php` | `website/automation.php` | GET | Public | Workflow & API automation pipelines | Map to `/automate/workflow-automation/` |
| `/mobile-apps.php` | `website/mobile-apps.php` | GET | Public | Mobile & Progressive Web Apps | Map to `/build/mobile-apps/` |
| `/saas.php` | `website/saas.php` | GET | Public | SaaS MVP product engineering | Map to `/build/saas-development/` |
| `/industries.php` | `website/industries.php` | GET | Public | Sector-specific solutions overview | Retain and enhance with interactive industry slider |
| `/case-studies.php` | `website/case-studies.php` | GET | Public | Case studies repository | Enhance with verified deliverables and filter tabs |
| `/portfolio.php` | `website/portfolio.php` | GET | Public | Selected engineering deliverables | Retain and synchronize with MySQL database |
| `/project.php` | `website/project.php` | GET | Public | Dynamic project architecture deep dive (`?id=...`) | Retain; sanitize ID parameter rigorously |
| `/process.php` | `website/process.php` | GET | Public | 4-step engineering delivery process | Retain; incorporate into shared design system |
| `/engagement-models.php` | `website/engagement-models.php` | GET | Public | Sprint retainers & milestone terms | Retain |
| `/pricing.php` | `website/pricing.php` | GET | Public | Investment tiers and milestone rates | Retain; review marketing claims |
| `/discovery-call.php` | `website/discovery-call.php` | GET | Public | Direct architect consultation booking | Retain; ensure calendar integration is verified |
| `/contact.php` | `website/contact.php` | GET, POST | Public (CSRF protected) | Blueprint inquiry form and submission handler | Enhance with division routing (BUILD/GROW/AUTOMATE) |
| `/faq.php` | `website/faq.php` | GET | Public | FAQ repository with JSON-LD schema | Retain |
| `/security.php` | `website/security.php` | GET | Public | Security and data protection overview | Reframed to describe project-specific controls without compliance guarantees |
| `/privacy.php` | `website/privacy.php` | GET | Public | Privacy policy and data handling statement | Retain |
| `/terms.php` | `website/terms.php` | GET | Public | Terms of service and IP ownership | Retain |
| `/blog.php` | `website/blog.php` | GET | Public | Technical engineering insights | Retain |
| `/404.php` | `website/404.php` | GET | Public | Custom 404 handler | Retain |

---

## 2. Admin & CMS Routes (`website/admin/`)

| Relative URL | Physical File | HTTP Methods | Auth / Role | Description |
|---|---|---|---|---|
| `/admin/login.php` | `website/admin/login.php` | GET, POST | Public (Rate-limited) | Secure administrative login screen |
| `/admin/auth.php` | `website/admin/auth.php` | POST | Public | Authentication verification endpoint with PDO prepared statement |
| `/admin/logout.php` | `website/admin/logout.php` | GET, POST | Admin Session | Session invalidation and destruction |
| `/admin/index.php` | `website/admin/index.php` | GET | Admin Session | Admin overview dashboard and status |
| `/admin/deliverables.php`| `website/admin/deliverables.php`| GET | Admin Session | Deliverables & portfolio project management |
| `/admin/project-form.php` | `website/admin/project-form.php` | GET, POST | Admin Session | Add/edit portfolio projects with MySQL persistence |
| `/admin/showcase.php` | `website/admin/showcase.php` | GET | Admin Session | Showcase status toggles |
| `/admin/telemetry.php` | `website/admin/telemetry.php` | GET | Admin Session | App and CRM error log monitor |
| `/admin/toggle.php` | `website/admin/toggle.php` | POST | Admin Session | Fast status toggle for portfolio items |
| `/admin/delete.php` | `website/admin/delete.php` | POST | Admin Session | Project soft/hard deletion with CSRF check |
| `/admin/users.php` | `website/admin/users.php` | GET, POST | Superadmin Role | User and RBAC management |

---

## 3. API & Webhook Endpoints

| Endpoint | Handler | Method | Purpose |
|---|---|---|---|
| `/contact.php` (AJAX) | `ContactController::handle()` | POST | Validates and stores contact inquiries |
| Configured CRM webhook | `CRMIntegrationService::dispatchLead()` | Outbound POST | Optional HTTPS/HMAC-signed delivery to a configured CRM endpoint |
