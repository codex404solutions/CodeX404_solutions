# 📁 Code X404 Solutions

**AI & Software Engineering Partner for Growing Businesses**

[![Deploy to Production](https://github.com/mnoukhej/CodeX404_solutions/actions/workflows/deploy.yml/badge.svg?branch=main)](https://github.com/mnoukhej/CodeX404_solutions/actions/workflows/deploy.yml)

---

## 🌐 Live Websites

- **Production:** [codex404solutions.online](https://codex404solutions.online)
- **Development:** [dev.codex404solutions.online](https://dev.codex404solutions.online)
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
--midnight: #07111F;           /* Dark backgrounds */
--deep-navy: #0B1F3A;          /* Dark sections */
--electric-blue: #2563EB;      /* Primary brand */
--cyan: #22D3EE;               /* Accents */
--violet: #7C3AED;             /* Secondary brand */
--soft-violet: #A78BFA;        /* Light accents */
--white: #FFFFFF;              /* Text on dark */
--slate: #94A3B8;              /* Secondary text */
--light: #F8FAFC;              /* Light backgrounds */
--dark-text: #0F172A;          /* Text on light */
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

#### **Managing Director (MD)** *(If different from CEO)*
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

**Muhammad Noukhez** *(Confirmed Details)*
- 💼 [LinkedIn](https://www.linkedin.com/in/mnoukhej/)
- 🐙 [GitHub](https://github.com/mnoukhej)
- 📧 [Email](mailto:mnoukhej@gmail.com)

*Additional leadership details and professional assets needed as outlined above.*

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
- 🌐 **Website:** [codex404solutions.online](https://codex404solutions.online)
- 📧 **Email:** hello@codex404solutions.online
- 💼 **LinkedIn:** [CodeX404 Solutions](#)

### Technical Support
- 📧 **Email:** support@codex404solutions.online
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
  <a href="https://codex404solutions.online">Visit Website</a> •
  <a href="https://www.linkedin.com/in/mnoukhej/">Connect on LinkedIn</a> •
  <a href="mailto:hello@codex404solutions.online">Get in Touch</a>
</p>

<!-- TREE_START -->
```
├── README.md
├── docs
│   ├── API_CONTRACT.md
│   ├── CRM
│   │   ├── ARCHITECTURE.md
│   │   ├── DESIGN.md
│   │   ├── DEVELOPMENT_PROMPT.md
│   │   ├── MEMORY.md
│   │   ├── PRD.md
│   │   ├── RULES.md
│   │   └── TASKS.md
│   ├── DEPLOYMENT.md
│   ├── MONOREPO_STRUCTURE.md
│   ├── Main-Website
│   │   ├── ARCHITECTURE.md
│   │   ├── DESIGN.md
│   │   ├── DEVELOPMENT_PROMPT.md
│   │   ├── MEMORY.md
│   │   ├── PRD.md
│   │   ├── RULES.md
│   │   └── TASKS.md
│   ├── QUICK_START_GUIDE.md
│   ├── RAZORPAY_INTEGRATION.md
│   └── STACK.md
├── founder-section.php
├── images
│   ├── cofounder.jpg
│   └── founder.jpg
├── logo
│   ├── favicon.ico
│   ├── logo.jpg
│   └── logo.png
├── setup.bat
├── update_tree.py
└── website
    ├── 404.php
    ├── about.php
    ├── ai-agents.php
    ├── ai-solutions.php
    ├── app
    │   ├── Controllers
    │   │   ├── ContactController.php
    │   │   └── LeadController.php
    │   ├── Helpers
    │   │   └── Sanitizer.php
    │   ├── Services
    │   │   ├── CRMIntegrationService.php
    │   │   └── EmailService.php
    │   └── Validators
    │       └── FormValidator.php
    ├── assets
    │   ├── css
    │   │   ├── components.css
    │   │   ├── main.css
    │   │   └── responsive.css
    │   ├── images
    │   │   ├── logo
    │   │   │   ├── favicon.ico
    │   │   │   ├── logo.jpg
    │   │   │   └── logo.png
    │   │   └── team
    │   │       ├── cofounder.jpg
    │   │       └── founder.jpg
    │   └── js
    │       ├── forms.js
    │       └── main.js
    ├── automation.php
    ├── case-studies.php
    ├── components
    │   ├── cookie-banner.php
    │   ├── cta.php
    │   ├── floating-social.php
    │   └── leadership.php
    ├── config
    │   └── database.php
    ├── contact.php
    ├── discovery-call.php
    ├── engagement-models.php
    ├── faq.php
    ├── includes
    │   ├── config.php
    │   ├── footer.php
    │   ├── header.php
    │   ├── navigation.php
    │   ├── security.php
    │   └── seo.php
    ├── index.php
    ├── industries.php
    ├── mobile-apps.php
    ├── portfolio.php
    ├── privacy.php
    ├── process.php
    ├── robots.txt
    ├── saas.php
    ├── security.php
    ├── sitemap.xml
    ├── software-development.php
    ├── solutions.php
    └── terms.php
```
<!-- TREE_END -->