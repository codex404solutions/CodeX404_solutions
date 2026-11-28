# 📁 Code X404 Solutions

**AI & Software Engineering Partner for Growing Businesses**

[![Deploy to Production](https://github.com/mnoukhej/CodeX404_solutions/actions/workflows/deploy.yml/badge.svg?branch=main)](https://github.com/mnoukhej/CodeX404_solutions/actions/workflows/deploy.yml)

---

## 🌐 Live Websites

- **Production:** [codex404solutions.com](https://codex404solutions.com)
- **Development:** [dev.codex404solutions.com](https://dev.codex404solutions.com)
- **LinkedIn:** [Muhammad Noukhez](https://www.linkedin.com/in/mnoukhej/)

---

## 📋 Project Overview

**CodeX404 Solutions** is a modern software and AI company that helps growing businesses operate smarter, move faster, and scale with confidence. We specialize in custom software development, AI automation, and business systems.

### **Our Services**

#### 💻 Digital Products

- Business Websites
- E-commerce Platforms
- Customer Portals
- Web Applications
- Mobile Applications

#### 🤖 AI Solutions

- AI Chatbots
- RAG Applications
- AI Knowledge Bases
- AI Customer Support
- AI Sales Assistants
- AI Voice Agents
- AI Document Intelligence
- AI Analytics
- AI Agents

#### ⚡ Business Automation

- CRM Automation
- Email Automation
- WhatsApp Automation
- Lead Automation
- Document Automation
- Reporting Automation
- Workflow Automation
- API Integrations

#### 🏢 Business Software

- Custom CRM Systems
- ERP Solutions
- Inventory Management
- HR Systems
- Booking Systems
- Billing & Invoicing
- Reporting & Dashboards

#### 🚀 SaaS Development

- MVP Development
- Full SaaS Development
- Multi-tenant Architecture
- Subscription Billing
- Admin Panels
- Analytics Integration

---

## 🏗️ Repository Structure (Monorepo)

```text
CodeX404_solutions/
├── website/                         # Main Website
│   ├── index.php
│   ├── components/
│   │   └── leadership.php          # Leadership section
│   ├── includes/
│   │   ├── header.php
│   │   └── footer.php
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   ├── app/
│   │   ├── Controllers/
│   │   ├── Services/
│   │   └── Validators/
│   ├── config/
│   ├── storage/
│   │   └── logs/
│   └── .env.example
│
├── crm/                             # CRM System (Future)
│   └── [CRM files will be added here]
│
├── docs/                            # Complete Documentation
│   ├── Main-Website/
│   │   ├── PRD.md
│   │   ├── ARCHITECTURE.md
│   │   ├── RULES.md
│   │   ├── DESIGN.md
│   │   ├── TASKS.md
│   │   └── DEVELOPMENT_PROMPT.md
│   ├── CRM/
│   │   └── [CRM documentation]
│   ├── STACK.md
│   ├── API_CONTRACT.md
│   ├── DEPLOYMENT.md
│   ├── RAZORPAY_INTEGRATION.md
│   ├── MONOREPO_STRUCTURE.md
│   └── QUICK_START_GUIDE.md
│
├── .github/
│   └── workflows/
│       └── deploy.yml               # Automated deployment
│
└── README.md                        # This file
```

---

## 🚀 Quick Start

### Prerequisites

- **PHP 8.2+**
- **MySQL 8.0+**
- **Composer**
- **XAMPP** (for local development)

### Installation

**1. Clone Repository**

```bash
git clone https://github.com/codex404solutions/CodeX404_solutions.git
cd CodeX404_solutions
```

**2. Install Dependencies**

```bash
composer install
```

**3. Setup Website**

```bash
cd CodeX404_solutions
cp .env.example .env
# Edit .env with your database credentials
```

**4. Create Database**

```bash
mysql -u root -p
CREATE DATABASE codex404_website;
exit;
```

**5. Start Local Server**

```bash
# From website directory
php -S localhost:8000
```

**6. Access Website**

```
http://localhost:8000
```

---

## 🔧 Technology Stack

### Frontend

- HTML5, CSS3, JavaScript
- Responsive Design
- Modern UI/UX

### Backend

- PHP 8.2+
- MySQL 8.0+
- RESTful APIs

### Deployment

- GitHub Actions (CI/CD)
- Hostinger (Production & Dev)
- Automated FTP deployment

### Future (CRM)

- PHP 8.2+
- MySQL 8.0+
- Razorpay Integration
- Multi-role RBAC

---

## 📖 Documentation

Comprehensive documentation is available in the `docs/` directory:

### Getting Started

- 📘 **[Quick Start Guide](docs/QUICK_START_GUIDE.md)** - Start here
- 🔧 **[Technology Stack](docs/STACK.md)** - Tech decisions
- 🚀 **[Deployment Guide](docs/DEPLOYMENT.md)** - Production deployment

### Website Development

- 📋 **[Website PRD](docs/Main-Website/PRD.md)** - Product requirements
- 🏗️ **[Website Architecture](docs/Main-Website/ARCHITECTURE.md)** - Technical structure
- 🎨 **[Design System](docs/Main-Website/DESIGN.md)** - Colors, typography, components
- ✅ **[Tasks Checklist](docs/Main-Website/TASKS.md)** - Phase-by-phase tasks
- 📏 **[Development Rules](docs/Main-Website/RULES.md)** - Coding standards & GDPR

### CRM Development (Future)

- 📋 **[CRM PRD](docs/CRM/PRD.md)** - CRM features & requirements
- 🏗️ **[CRM Architecture](docs/CRM/ARCHITECTURE.md)** - Database & structure
- 🔐 **[CRM Rules](docs/CRM/RULES.md)** - Multi-role security & permissions

### Integration & Payments

- 🔗 **[API Contract](docs/API_CONTRACT.md)** - Website ↔ CRM integration
- 💳 **[Razorpay Integration](docs/RAZORPAY_INTEGRATION.md)** - Payment system
- 📦 **[Monorepo Structure](docs/MONOREPO_STRUCTURE.md)** - Repository organization

---

## 🔄 CI/CD Pipeline

### Automated Deployment

- **Push to `dev` branch** → Deploys to `dev.codex404solutions.online`
- **Push to `main` branch** → Deploys to `codex404solutions.online`

### Workflow Features

- ✅ Automatic deployment on push
- ✅ Separate dev/production environments
- ✅ Excludes sensitive files (.env, logs)
- ✅ Fast FTP deployment
- ✅ Deployment status badges

### Branch Strategy

```text
main     → Production (codex404solutions.online)
  ↑
  |
dev      → Development (dev.codex404solutions.online)
  ↑
  |
feature/* → Feature branches (local testing)
```

---

## 🎨 Design System

### Brand Colors

```css
--midnight: #07111f; /* Dark backgrounds */
--deep-navy: #0b1f3a; /* Dark sections */
--electric-blue: #2563eb; /* Primary brand */
--cyan: #22d3ee; /* Accents */
--violet: #7c3aed; /* Secondary brand */
--soft-violet: #a78bfa; /* Light accents */
--white: #ffffff; /* Text on dark */
--slate: #94a3b8; /* Secondary text */
--light: #f8fafc; /* Light backgrounds */
--dark-text: #0f172a; /* Text on light */
```

### Typography

- **Headings:** Bold, 700 weight
- **Body:** 16px, 1.6-1.75 line-height
- **Buttons:** 600 weight, 14-16px

### Key Components

- Leadership Section ✅ (Created with profile, stats, values)
- Hero Section
- Service Cards
- Case Study Cards
- Testimonials
- Contact Forms

---

## 👨‍💻 Leadership Team

### CEO & Managing Director Details Required

**📝 Action Required:** Please provide the following leadership details to complete the website:

#### **Chief Executive Officer (CEO)**

- **Full Name:** [To be provided]
- **Professional Title:** CEO & Founder / Chief Executive Officer
- **Professional Photo:** [High-resolution headshot needed]
- **Bio/Description:** [Professional background, expertise, vision]
- **Education:** [Degrees, certifications, institutions]
- **Experience:** [Years of experience, key achievements]
- **Specializations:** [AI, Software Development, Business Strategy, etc.]
- **Contact Information:**
  - LinkedIn: [Professional LinkedIn URL]
  - Email: [Professional email]
  - Other social profiles: [Twitter, GitHub, etc.]

#### **Managing Director (MD)** _(If different from CEO)_

- **Full Name:** [To be provided]
- **Professional Title:** Managing Director / Chief Operating Officer
- **Professional Photo:** [High-resolution headshot needed]
- **Bio/Description:** [Professional background, expertise, role]
- **Education:** [Degrees, certifications, institutions]
- **Experience:** [Years of experience, key achievements]
- **Specializations:** [Operations, Technology, Business Development, etc.]
- **Contact Information:**
  - LinkedIn: [Professional LinkedIn URL]
  - Email: [Professional email]

### 🎨 Brand Assets Required

**📁 Copy the following files to your project folder:**

#### **Company Logos**

Copy to: `website/assets/images/logo/`

- [ ] `logo.svg` - Primary logo (scalable vector)
- [ ] `logo-horizontal.svg` - Horizontal layout logo
- [ ] `logo-vertical.svg` - Vertical layout logo
- [ ] `logo-dark.svg` - Logo for dark backgrounds
- [ ] `logo-white.svg` - White version for colored backgrounds
- [ ] `logo-icon.svg` - Icon/symbol only
- [ ] `favicon.svg` - Favicon (square format)
- [ ] `favicon.ico` - Favicon (32x32 px)
- [ ] `favicon-16x16.png` - Small favicon
- [ ] `favicon-32x32.png` - Standard favicon

#### **Leadership Photos**

Copy to: `website/assets/images/team/`

- [ ] `ceo-photo.jpg` - CEO professional headshot (minimum 800x800px)
- [ ] `md-photo.jpg` - MD professional headshot (minimum 800x800px)
- [ ] `team-photo.jpg` - Group photo (if available)

#### **Company Images**

Copy to: `website/assets/images/company/`

- [ ] `office-exterior.jpg` - Office building/workspace exterior
- [ ] `office-interior.jpg` - Modern office interior shots
- [ ] `team-working.jpg` - Team collaboration photos
- [ ] `technology-setup.jpg` - Development environment/tech setup

#### **Marketing Images**

Copy to: `website/assets/images/marketing/`

- [ ] `og-image.jpg` - Social media sharing image (1200x630px)
- [ ] `hero-background.jpg` - Website hero section background
- [ ] `about-background.jpg` - About page background image
- [ ] `services-illustration.jpg` - Services section visual

### 📝 Content Guidelines

#### **Professional Photo Requirements:**

- **Format:** JPG or PNG
- **Resolution:** Minimum 800x800px (square format preferred)
- **Quality:** Professional headshots with good lighting
- **Background:** Clean, professional background (solid color or subtle)
- **Attire:** Business professional or business casual
- **Expression:** Confident, approachable, professional smile

#### **Logo Requirements:**

- **SVG Format:** Scalable vector graphics for crisp display at any size
- **Multiple Variants:** Different versions for various use cases
- **Color Consistency:** Maintain brand colors across all variants
- **Clear Space:** Ensure adequate padding around logo elements
- **Versatility:** Readable at small sizes (favicon) and large displays

### 🔄 Implementation Notes

Once you provide the above information and copy the assets:

1. **Leadership Details** will be added to:
   - `docs/Main-Website/MEMORY.md`
   - `website/components/leadership.php`
   - Website about page content

2. **Brand Assets** will be integrated into:
   - Website header/footer
   - Social media meta tags
   - Leadership sections
   - Marketing materials

3. **File Paths** are already configured in the code to automatically use these assets once copied to the specified directories.

### 📞 Current Contact Information

**Muhammad Noukhez** _(Confirmed Details)_

- 💼 [LinkedIn](https://www.linkedin.com/in/mnoukhej/)
- 🐙 [GitHub](https://github.com/mnoukhej)
- 📧 [Email](mailto:mnoukhej@gmail.com)

_Additional leadership details and professional assets needed as outlined above._

---

## 🛡️ Security & Compliance

### Security Practices

- ✅ HTTPS encryption
- ✅ SQL injection prevention (prepared statements)
- ✅ XSS protection (output escaping)
- ✅ CSRF protection
- ✅ Input validation (server-side)
- ✅ Secure password hashing (bcrypt)
- ✅ Rate limiting
- ✅ Audit logging

### GDPR Compliance

- ✅ Cookie consent
- ✅ Privacy policy
- ✅ Data retention policies
- ✅ User rights (access, deletion, export)
- ✅ Consent management
- ✅ Data minimization

See [RULES.md](docs/Main-Website/RULES.md) for complete security guidelines.

---

## 📊 Development Progress

### Phase 1: Website (Current)

- [x] Documentation (20 files) ✅
- [x] Monorepo structure ✅
- [x] Leadership component ✅
- [x] CI/CD pipeline ✅
- [ ] Homepage
- [ ] Core pages
- [ ] Contact form
- [ ] SEO optimization
- [ ] Production deployment

### Phase 2: CRM (Future)

- [ ] Authentication & RBAC
- [ ] Lead management
- [ ] Sales pipeline
- [ ] Proposals & contracts
- [ ] Client & project management
- [ ] Invoicing & payments (Razorpay)
- [ ] Website integration

### Phase 3: SaaS Products (Future)

- [ ] Productized services
- [ ] SaaS validation
- [ ] Multi-tenant architecture
- [ ] Subscription billing

---

## 🤝 Contributing

While this is primarily a business project, we follow best practices:

1. Create feature branch: `git checkout -b feature/your-feature`
2. Make changes and test locally
3. Commit: `git commit -m "feat: add feature"`
4. Push to dev: `git push origin feature/your-feature`
5. Create PR to `dev` branch
6. Test on dev environment
7. Merge to `main` for production

### Conventional Commits

```text
feat:     New feature
fix:      Bug fix
docs:     Documentation
style:    Formatting
refactor: Code restructuring
test:     Tests
chore:    Maintenance
```

---

## 🎯 Business Goals

### Short Term (3 Months)

- ✅ Launch professional website
- ✅ Establish brand identity
- 🔄 Acquire first 10 clients
- 🔄 Generate ₹1 lakh/month revenue

### Medium Term (6 Months)

- 🔄 Launch CRM system
- 🔄 Integrate Razorpay payments
- 🔄 Reach ₹5 lakh/month revenue
- 🔄 Expand to 3 international markets

### Long Term (12 Months)

- 🔄 Launch first SaaS product
- 🔄 Achieve ₹10 lakh/month revenue
- 🔄 Build team (2-5 developers)
- 🔄 30% recurring revenue

---

## 📞 Contact

### Business Inquiries

- 🌐 **Website:** [codex404solutions.com](https://codex404solutions.com)
- 📧 **Email:** info@codex404solutions.com
- 💼 **LinkedIn:** [CodeX404 Solutions](#)

### Technical Support

- 📧 **Email:** support@codex404solutions.com
- 🐛 **Issues:** [GitHub Issues](https://github.com/mnoukhej/CodeX404_solutions/issues)

### Founder

- **Muhammad Noukhez**
- 📧 mnoukhej@gmail.com
- 💼 [LinkedIn](https://www.linkedin.com/in/mnoukhej/)
- 🐙 [GitHub](https://github.com/mnoukhej)

---

## 📝 License

© 2026 CodeX404 Solutions. All rights reserved.

This is proprietary business software. Unauthorized copying, distribution, or modification is prohibited.

---

## 🙏 Acknowledgments

- **Hostinger** - Reliable hosting partner
- **Razorpay** - Payment gateway solution
- **GitHub Actions** - CI/CD automation
- **Open Source Community** - Amazing tools and libraries

---

## 📈 Stats

![GitHub last commit](https://img.shields.io/github/last-commit/mnoukhej/CodeX404_solutions)
![GitHub repo size](https://img.shields.io/github/repo-size/mnoukhej/CodeX404_solutions)
![GitHub language count](https://img.shields.io/github/languages/count/mnoukhej/CodeX404_solutions)

---

**Built with ❤️ in India | Serving clients globally 🌍**

---

<p align="center">
  <strong>Transform Your Business with Software & AI</strong>
  <br>
  <a href="https://codex404solutions.com">Visit Website</a> •
  <a href="https://www.linkedin.com/in/mnoukhej/">Connect on LinkedIn</a> •
  <a href="mailto:info@codex404solutions.com">Get in Touch</a>
</p>

<!-- TREE_START -->
```
├── PROJECT-DOCS
│   └── PROJECT-OVERVIEW.md
├── README.md
├── docs
│   ├── API_CONTRACT.md
│   ├── CAREERS_API.md
│   ├── CAREERS_ARCHITECTURE.md
│   ├── CAREERS_DATABASE.md
│   ├── CAREERS_PRD.md
│   ├── CAREERS_SECURITY.md
│   ├── CAREERS_TESTING.md
│   ├── DEPLOYMENT.md
│   ├── MONOREPO_STRUCTURE.md
│   ├── Main-Website
│   │   ├── ANTIGRAVITY_HANDOFF.md
│   │   ├── ARCHITECTURE.md
│   │   ├── CLAIM_VERIFICATION_REGISTER.md
│   │   ├── CONTENT_AUDIT.md
│   │   ├── CURRENT_SITEMAP.md
│   │   ├── DATABASE.md
│   │   ├── DATABASE_AUDIT.md
│   │   ├── DESIGN.md
│   │   ├── DESIGN_SYSTEM_AUDIT.md
│   │   ├── DEVELOPMENT_PROMPT.md
│   │   ├── EXISTING_ROUTE_INVENTORY.md
│   │   ├── MEMORY.md
│   │   ├── PRD.md
│   │   ├── PROJECT_AUDIT.md
│   │   ├── README.md
│   │   ├── RULES.md
│   │   ├── SECURITY.md
│   │   ├── SECURITY_AUDIT.md
│   │   ├── SEO_AUDIT.md
│   │   ├── TASKS.md
│   │   ├── WEBSITE_IMPLEMENTATION_ROADMAP.md
│   │   └── prompt.md
│   ├── QUICK_START_GUIDE.md
│   ├── RAZORPAY_INTEGRATION.md
│   └── STACK.md
├── images
│   ├── cofounder.jpg
│   └── founder.jpg
├── logo
│   ├── favicon-16x16.png
│   ├── favicon-32x32.png
│   ├── favicon.ico
│   ├── logo.jpg
│   └── logo.png
├── setup.bat
├── setup.sh
├── sync-db.bat
├── sync-db.sh
├── update_tree.py
└── website
    ├── 404.php
    ├── DEPLOYMENT-ROLLBACK.md
    ├── about.php
    ├── admin
    │   ├── auth.php
    │   ├── careers.php
    │   ├── careers_views
    │   │   ├── applications.php
    │   │   ├── candidate-detail.php
    │   │   ├── emails.php
    │   │   ├── form-builder.php
    │   │   ├── jobs.php
    │   │   ├── logs.php
    │   │   ├── overview.php
    │   │   ├── recruiters.php
    │   │   └── settings.php
    │   ├── delete.php
    │   ├── deliverables.php
    │   ├── includes
    │   │   ├── footer.php
    │   │   └── header.php
    │   ├── index.php
    │   ├── inquiries.php
    │   ├── login.php
    │   ├── logout.php
    │   ├── logs.php
    │   ├── overview.php
    │   ├── profile.php
    │   ├── project-form.php
    │   ├── showcase.php
    │   ├── telemetry.php
    │   ├── toggle.php
    │   └── users.php
    ├── ai-agents.php
    ├── ai-solutions.php
    ├── app
    │   ├── Careers
    │   │   ├── ActivityLogService.php
    │   │   ├── ApplicationService.php
    │   │   ├── CareersDB.php
    │   │   ├── CareersSeeder.php
    │   │   ├── FileStorageService.php
    │   │   ├── FormBuilderService.php
    │   │   ├── FormValidationException.php
    │   │   ├── RecruitmentAuthService.php
    │   │   ├── RecruitmentEmailService.php
    │   │   ├── RecruitmentSettingsService.php
    │   │   └── VacancyService.php
    │   ├── Controllers
    │   │   ├── ContactController.php
    │   │   └── LeadController.php
    │   ├── Helpers
    │   │   └── Sanitizer.php
    │   ├── Services
    │   │   ├── AuditLogService.php
    │   │   ├── CRMIntegrationService.php
    │   │   ├── EmailService.php
    │   │   ├── MigrationService.php
    │   │   ├── ProjectService.php
    │   │   ├── RBACService.php
    │   │   └── UserService.php
    │   └── Validators
    │       └── FormValidator.php
    ├── assets
    │   ├── css
    │   │   ├── admin.css
    │   │   ├── animations.css
    │   │   ├── careers.css
    │   │   ├── components.css
    │   │   ├── depth3d.css
    │   │   ├── main.css
    │   │   ├── responsive.css
    │   │   └── v2-tokens.css
    │   ├── images
    │   │   ├── avatars
    │   │   │   ├── alex-rivera.svg
    │   │   │   ├── elena-rostova.svg
    │   │   │   ├── marcus-vance.svg
    │   │   │   ├── sophia-chen.svg
    │   │   │   └── uploads
    │   │   │       ├── dp_admin_1792810726.jpg
    │   │   │       └── dp_admin_1792812336.jpg
    │   │   ├── case-wave-bg.webp
    │   │   ├── logo
    │   │   │   ├── build-grow-automate-pill.png
    │   │   │   ├── favicon-16x16.png
    │   │   │   ├── favicon-32x32.png
    │   │   │   ├── favicon.ico
    │   │   │   ├── logo.jpg
    │   │   │   ├── logo.png
    │   │   │   ├── og-preview.jpg
    │   │   │   └── og-preview.png
    │   │   ├── projects
    │   │   │   ├── ali-public-school-b769ae89.jpg
    │   │   │   ├── ali-public-school.jpg
    │   │   │   ├── ata-publications.jpg
    │   │   │   ├── central-medical.jpg
    │   │   │   ├── dental-appointment-system.jpg
    │   │   │   ├── first-alphabet-e51c897d.jpg
    │   │   │   ├── first-alphabet.jpg
    │   │   │   ├── glamour-beauty-parlour-booking.jpg
    │   │   │   ├── gourmet-restaurant-table-booking.jpg
    │   │   │   ├── imaan360-online.jpg
    │   │   │   ├── insan-degree-college-web-b4251da4.jpg
    │   │   │   ├── insan-degree-college-web.jpg
    │   │   │   ├── luxe-hair-salon-scheduling.jpg
    │   │   │   ├── tender-appliances.jpg
    │   │   │   ├── v3a-enterprise.jpg
    │   │   │   └── wheelcraft.jpg
    │   │   └── team
    │   │       ├── cofounder.jpg
    │   │       └── founder.jpg
    │   └── js
    │       ├── admin.js
    │       ├── chatbot.js
    │       ├── forms.js
    │       ├── main.js
    │       ├── scene3d.js
    │       └── scroll-engine.js
    ├── automate.php
    ├── automation.php
    ├── blog.php
    ├── build.php
    ├── candidate-portal.php
    ├── career-detail.php
    ├── career-resume.php
    ├── career-status.php
    ├── careers.php
    ├── case-studies.php
    ├── components
    │   ├── chatbot.php
    │   ├── cookie-banner.php
    │   ├── cta.php
    │   ├── demo-modal.php
    │   ├── floating-social.php
    │   └── leadership.php
    ├── config
    │   ├── Env.php
    │   └── database.php
    ├── contact.php
    ├── conversion-optimization.php
    ├── data
    │   └── projects.json
    ├── database
    │   ├── migrate.php
    │   ├── migrate_careers.php
    │   └── migrations
    │       ├── 007_careers_recruitment_system.sql
    │       ├── 007_careers_recruitment_system_down.sql
    │       ├── 008_admin_audit_logs.sql
    │       ├── 009_website_schema_alignment.sql
    │       └── 009_website_schema_alignment_down.sql
    ├── digital-ads.php
    ├── discovery-call.php
    ├── engagement-models.php
    ├── faq.php
    ├── grow.php
    ├── includes
    │   ├── config.php
    │   ├── division-overview-content.php
    │   ├── footer.php
    │   ├── header.php
    │   ├── icons.php
    │   ├── navigation.php
    │   ├── security.php
    │   ├── seo.php
    │   └── subpage-hero.php
    ├── index.php
    ├── industries.php
    ├── mobile-apps.php
    ├── our-work.php
    ├── portfolio.php
    ├── pricing.php
    ├── privacy.php
    ├── process.php
    ├── project.php
    ├── robots.txt
    ├── saas.php
    ├── security.php
    ├── seo-visibility.php
    ├── sitemap.xml
    ├── software-development.php
    ├── solutions.php
    └── terms.php
```
<!-- TREE_END -->