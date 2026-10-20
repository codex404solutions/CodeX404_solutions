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
├── crm
│   ├── api
│   │   └── v1
│   │       └── leads.php
│   ├── app
│   │   ├── Controllers
│   │   ├── Helpers
│   │   ├── Middleware
│   │   ├── Models
│   │   ├── Repositories
│   │   └── Services
│   │       ├── ApprovalService.php
│   │       ├── AuthService.php
│   │       ├── CrmSecurity.php
│   │       ├── LeadService.php
│   │       ├── OpportunityService.php
│   │       ├── PaperclipService.php
│   │       ├── ProjectService.php
│   │       ├── RBACService.php
│   │       └── StorageService.php
│   ├── config
│   │   ├── Env.php
│   │   └── config.php
│   ├── database
│   │   ├── migrations
│   │   │   └── 001_initial_schema.sql
│   │   └── seed_approvals.php
│   ├── index.php
│   ├── public
│   │   ├── css
│   │   ├── images
│   │   ├── index.php
│   │   ├── js
│   │   ├── login.php
│   │   └── logout.php
│   ├── seed.php
│   ├── storage
│   │   ├── data
│   │   │   ├── approvals.json
│   │   │   ├── leads.json
│   │   │   ├── opportunities.json
│   │   │   ├── paperclip_tasks.json
│   │   │   └── projects.json
│   │   └── logs
│   └── views
│       ├── approvals
│       ├── auth
│       ├── dashboard
│       ├── layouts
│       ├── leads
│       ├── opportunities
│       ├── projects
│       └── settings
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
├── graphify-out
│   ├── 2026-10-20
│   │   ├── GRAPH_REPORT.md
│   │   ├── graph.json
│   │   └── manifest.json
│   ├── GRAPH_REPORT.md
│   ├── GRAPH_TREE.html
│   ├── cache
│   │   ├── ast
│   │   │   └── v0.9.92-s17-g7154a062ba57
│   │   │       ├── 021e7b51a2f500c8313b40bd42f26016fb0100562e2e850be4d87a0d4dd17ee2.json
│   │   │       ├── 0360e79a5850587a03277f8756c093af51ee9fb0342d2d105c6df55b2405fa52.json
│   │   │       ├── 0394e84cff79fee987b4ac559c2b502517d000947851cb50fa95886124d42d1f.json
│   │   │       ├── 0722cdcfd4fbe6b18e856c30b77fa6f30f12302b8ea64f74504fb4ae25268633.json
│   │   │       ├── 076421ab3d2288c3589c6a909b4aaeeeced7a63cbcb02ca6cc3b6a1366b579fd.json
│   │   │       ├── 0a42ceac3faa90350f2a2505d8e4d0dde97d1d7badf0b994fbe421a04c43b079.json
│   │   │       ├── 0c41e818af886f09b713884e0352513294bbc89ecc34effb20a573b325d23919.json
│   │   │       ├── 0c9abbc81e1864d1fbdf7034ea1dd77cc1825458ca35e911fcf29ec5ea8d0ef1.json
│   │   │       ├── 0cd59dcc25a92aaee09f5ef60d9eccea61bb081e7df0183713291b950c409df8.json
│   │   │       ├── 0cec993c467f26bc76df7c0a17df3f08634eaf0cada8244f1dd019890c5a3593.json
│   │   │       ├── 0dc89d831da1845ef2fedcb89469303028128bae189c49b429e78bde5667a4f6.json
│   │   │       ├── 0ec8fcd06f45b51043057062ddb7c0bd229c91bd0a1545b19ca87533a78733d4.json
│   │   │       ├── 1144eaeb271666252627510c2de0771f6955f3da1313759882c313c9bb0d9386.json
│   │   │       ├── 11fcc416c8baf8c5531a70a30e23413aeaadd59934e205bd5a79eeef81bb71b0.json
│   │   │       ├── 132fb6a4f9e19683402206d7ad203cfaf3f324b9503ec5df51bdea8df40405b0.json
│   │   │       ├── 139f66bd6da8de3d2a6260f2f0a92b4c25c2c86be327de20e50af2acf3dd0c29.json
│   │   │       ├── 13ad6644c1cbfcf47b9ec4396df1185c24350f9393a881320077aa47a642f3b4.json
│   │   │       ├── 153b9a84eff8bafd07c03277b77efb7d4762a10b75a67b3f57b6ff441d5c11bb.json
│   │   │       ├── 15b47e2c40bd4d56aef19b930a2ea1b4d0025ef73f98472e0e86eec29909193c.json
│   │   │       ├── 17cf10bdccb55e359cb5816d136676ce966ccfccfc033b247f1e48c5e88b1ad8.json
│   │   │       ├── 1c6055d963896fd73e145f56a00e3378710e0598e067a2fc67633900540c3549.json
│   │   │       ├── 1d58e9a8ee0348a1a7c2ca309a55b3a1cf375732c9ca244f7cd7ca6b36a8a5fc.json
│   │   │       ├── 1d91d966a45a0de6f72cde59a4f11b21ee81e4cd54af2c03f06227d9c0fdd967.json
│   │   │       ├── 1e21a7c677e67629759b274fd703e4007b6e2320cd8d52fb4c8bbf6166637f4c.json
│   │   │       ├── 25b74de0f519e3cc9053c67c55920ccf067308134f61f52256e59a9cc4826502.json
│   │   │       ├── 25ba040f73a9f3bbe059f33a1f080159818b4a4dd7f4bb742199c57988af969a.json
│   │   │       ├── 269428309dbd1c0ca43f2e3f6ebf19a8745ce36971b4f63b333f3fb6e35c1494.json
│   │   │       ├── 26bc44efc7be87639acbf60c8076d9c417effc3c743b6b088ef388860499e1f7.json
│   │   │       ├── 270de5d9cef0214e695a0a2462fa1ab12a12e391ac63d5afa2001e00f8242590.json
│   │   │       ├── 2dc983806fb70b0bceb5f44de80f2f4598c50f2ccc3a46d6a37ac8153a9b24c0.json
│   │   │       ├── 312833499f9c491079bd9c421bb7748b0cbd6d61995dd3f737c95a3cbb419618.json
│   │   │       ├── 3178dd9c1418b3beef1622f8c6d799a7696658dd0836ad58b07ad32b4de7d45a.json
│   │   │       ├── 31ed6de1f11a2c7c729585df00f5b9771faaebfcf0fe5e0e1ef576ddb8bc2f45.json
│   │   │       ├── 320b8e977e78e0a2e0785ab924e34865f7a375e972ef9321734f8f80c3eb8cc1.json
│   │   │       ├── 35dfd8f664244499c4f71ee3f823646cedbcdf81e2d4347cf0811fb8c6c125ee.json
│   │   │       ├── 36937ecb88a6e9f8fa651301eec6ff67475bbac1be25e7a13c86a8277c98bb48.json
│   │   │       ├── 3834c7260d5e13652912c368323a34730dc146130308b24fe9ea8973d9a8e506.json
│   │   │       ├── 3dbd47e5e0948a0ff31276286ec4fb6efc8aa812dbd480bd13bdd38b943de8d9.json
│   │   │       ├── 3de13cca391c49e098175655088ac9aacfa54cd798b39d348bfb5dc6f07ebebd.json
│   │   │       ├── 3e9651207bdc1dfcb70dd793e64f67c868c387aa35a49a8063f41fa6a8043717.json
│   │   │       ├── 3f6155da28ed43ed210f605c9a73489ea9ba0efd72dcf0c8950ba8de7745b3b5.json
│   │   │       ├── 41cef0bb70ac77cebe7f2faf8bb7787b615a1024467f899fc56f2317c49ff36b.json
│   │   │       ├── 42fb2bad50133e35a6d5ef48c791dfbc1663c619a7285707af911479a7855a47.json
│   │   │       ├── 44ced40f05ee80ae5379c0b8f915e8ca4225c71129874a7be4fd7752323d5d3b.json
│   │   │       ├── 450f801ddc6b9422b78345505360fecfbd53eb7c3d457c9d4defc88f4642205a.json
│   │   │       ├── 458b1a962aa7f0c6a7ba7ae830fd4573c43696f00fd99c9bcc3e63103f9c02fd.json
│   │   │       ├── 45c01dc025ab83b73ffd2aad2fa243005a188dd8e892f3b67c7a329bc79b5765.json
│   │   │       ├── 460db33fb2758cbd068c7d60ec4d593e3031b36b555bf774fd786c5c12eab419.json
│   │   │       ├── 462c38743e0110e85769e82b61349d382601582ab0a6ab5f7ead5929cf8ae3cf.json
│   │   │       ├── 4bee4421938055c8a36ee409415785b976f25af69be087449593412db046df70.json
│   │   │       ├── 4e4cf0606e497bec9d3dbc18c7ad727a16fc6e42bd49a85c59159c77f12b3193.json
│   │   │       ├── 519116ed0682c1aee2eec2e319669e279fadc7eecf7a86e1f4784f845c7cbfc5.json
│   │   │       ├── 545c9d6ad1a4c383120b4f68276e7524ae04ab58edebabfb6e174c89926c7d92.json
│   │   │       ├── 557755d0b740a2773da830dc267c4931a1cb521e6871f168053c839dc0b1eb1d.json
│   │   │       ├── 57ecce380c8e87034e85dc8f2d252950626ba2129c42904a3ffddf1ea9c12207.json
│   │   │       ├── 5cc37d422f622c72daaad2426c4ace8ca05fd3d16e2d7b4b659ab15626d174ff.json
│   │   │       ├── 603347a75259c2f0e426f611fb35796aa0d6f2dfc4c2b2414fddeb82a5254e62.json
│   │   │       ├── 60c1c25d2ff4cc6efe0a75521c699e020ed3a856c9014bdc23a81169002b17ba.json
│   │   │       ├── 6689e99ef7e838cd1448d0ec732e166fbff4c78f7841110cadd62e5dc73739e9.json
│   │   │       ├── 66adc12f022c0f317bfbf8fbcc5caf7269664b5d0540cabf37e18263267a195d.json
│   │   │       ├── 6a7f2b0c6468ba34b317bc1b31742a0c146be409367c6cd8da22692db607194b.json
│   │   │       ├── 6c511d203fe69a8d55d54ca83000526cd1969faadf3384ab669f08448feb8898.json
│   │   │       ├── 6f88a5bde4bf595c4f5100db053ea2f4eb64290b2c70592868b0d85b53aac8d9.json
│   │   │       ├── 705f7b5f88d4d8ecbd740be0173095291cd76e12abe7cd26c8d2d173e19fe07c.json
│   │   │       ├── 70706616f919cff0a1ebbbfa2e27ace0f019a2ecaf0c48a62e3307c80b0fef1a.json
│   │   │       ├── 74ed118f4b60770c48beb29ce825cf97a3964ccb5b5fe66ebf842cc6801a2a4d.json
│   │   │       ├── 7584236cc4c884277ac2f59004ebba18483fadb6f69b66f93ffcae0cd5817d02.json
│   │   │       ├── 75b785fd795e1bfc3894b17b3013fe51b231f4ccf16e2377650e0c101a8b9763.json
│   │   │       ├── 764fea27ad135ccb3b760e477bbc780ab5c2f39f47506d01d59b9c1586449e26.json
│   │   │       ├── 7770672cf01f7b1e870aa72c326c109c69e2ed7e1697964f3bfbc863525d1afc.json
│   │   │       ├── 7a931a1744f298c3ec03405427e10ae7a0ee64e848d305a75bd83daa421fcb7c.json
│   │   │       ├── 7b6384ad709d3b71b20d35906c9c23a0f96311757803ab1d0d8f11368d4501e1.json
│   │   │       ├── 7d10a5735351908e238cf2c414618bbe7d48d18ce9d49b3984fa8d607719caee.json
│   │   │       ├── 7d86722e011233394e42a6cebc5bd5fc4afc5da2f5f8aafbbb37bba33fedecbb.json
│   │   │       ├── 7daffc49ea89c793a7b12228f91fcf2d20102bdbb706369802e9bc2b8dd834d2.json
│   │   │       ├── 7f358f4b6f95920694fae236e0c5f06d5240f0948481b7cd58e7e27b327fd549.json
│   │   │       ├── 7f75ef07dd8856cbc1669947bcb3160a1172650ada6abd83301e100d836d568a.json
│   │   │       ├── 804be3eb24881846556415e450e346eb1bdd6bb70c129c4039410b86472d255e.json
│   │   │       ├── 80ed23328d12bd5e863f3b14da5876a2ccd05e05f4b30fd1af2f973ced6dc46b.json
│   │   │       ├── 82adb79278d6c4374eb28b9d98771b8e09b793df963b494a6eb453b017e6cf73.json
│   │   │       ├── 8558a550dcc57e110dbc758fe6096b11e2a056403865be9922651f1f23a4caf9.json
│   │   │       ├── 86243c6707d84e5d69ce4b7e6214dc497c500c524941b52c8158ae5654d47cb4.json
│   │   │       ├── 8911446e74221b4711da435c47e7ea033d1add78884e1142d8553597248d539b.json
│   │   │       ├── 8a6f4cba34bf0b3c26cbc4e0c119d472c6f52ecb4d81ae896d6cb5806adac8fc.json
│   │   │       ├── 8b7e750d9913f5d66ff4cdfcae23ff47d97be94b4fa2c17d85d9ad946efa22bc.json
│   │   │       ├── 8b8c3c4839624435bb46c544a16b197625edb4b5f60bc0affd3a592258ba84b6.json
│   │   │       ├── 8bc0ad8f117a166a9db6610c0fd1bc7f244b10fad7c32c0bad3efe05d2214913.json
│   │   │       ├── 8eb7e9e653ffbcbb28b60a0fd10ebcfaf275ec24e4a7bedbe95895dd90334d3e.json
│   │   │       ├── 8f815d453cad3f68baacfe151bb75fa397f4165b325118f91e12fc83b16ed804.json
│   │   │       ├── 94cb8d9db980db4282a00d26617ea80a9ac2cd5ddcf00f365b1473a38b3e2658.json
│   │   │       ├── 950c826227fa7ce5f0e6faa5875105974429919d2182c853a1de7ed8a2221109.json
│   │   │       ├── 9974f2700a05ec68ab7097d19edb6bf86926125ea3274c5f5fac5cbd16b0ce67.json
│   │   │       ├── 9e3fca6e0271d7997f2122b1a21a64a9accdf920f722cfe3a4a429481d6c9731.json
│   │   │       ├── a0a6b1ea3e368be4d2ee9827ec0dd4b5ed86be39e0989095e56504b9a95b3e6d.json
│   │   │       ├── a4ff108281bdee8578ef46283c168f551fa8b06e26d7aafd1c7e10e8ca22b63d.json
│   │   │       ├── a54648429f837c4db2df2d6b828a43e7e40548f9aa28cc039518d33d5be5b83f.json
│   │   │       ├── a6e0be65ca17539e17f9eee0ffbea22f5f165c073e04ec10f6a60063b05bbb64.json
│   │   │       ├── a73864bb446d00aafb7ea76f48874dacf939f7fa2785f5bcb55ef63fb7d1390e.json
│   │   │       ├── a822fcea3230562bd471308bce62471db8f2086becde9a8b87d53f9bcada2425.json
│   │   │       ├── abb3a41b35cae6eb46c7933de5d67ca1aa9900592a46153e2bb490b17576a510.json
│   │   │       ├── ac5bd830caffcbcea91ed5ebc6fb019965e4df43218e117bc4efb25a71e4df20.json
│   │   │       ├── ae0176d271f39b3d2cd8de91a9d82b15aa25a411a18e7c0bb9f3119efdb9136d.json
│   │   │       ├── b0479e24e4c3dc60e1ecd46841c33e4da7d5ce9e6885afc5351bb21dca132dec.json
│   │   │       ├── b2bd075c1fcfe82d5d9d5aca6672a915e746dfecbf6db0987bde34416d3421af.json
│   │   │       ├── b44971cc99529eb090027e3ba7031407a4c71a0e7f8660d875fc66c2dae96d9b.json
│   │   │       ├── b56cfb737d63b1be31353a460349ebe46f674c64d021a56c54bad318ba03ab71.json
│   │   │       ├── b963faff0dc0d459dcae2632d521c7ddca1e6085ab5b01e562bebcd4a2cbdc65.json
│   │   │       ├── b99baac85a08b8462b8368f8550283aeff2209c052d1a96ec80561369825502d.json
│   │   │       ├── bc9c1eb96b2e06b6ed747eb8fbf3dab6f6ea8739c44589dd2bac6711405cdb55.json
│   │   │       ├── bd3b31ca841072b8cad45eb5d4e1d55c986c7c487bd18f58a48d01cca132ce83.json
│   │   │       ├── bd65a36941ced0cb34037d0f068968af970efbef014a79ee8e6f96a4add6a73b.json
│   │   │       ├── be452241faaecc67ba2029360faf48df0b0e1c08b9c732a1328da3a45c2e4a1b.json
│   │   │       ├── bf7f56f9d451c8d22943a987c96e53299821eb26854ba28bba683b32b1de8328.json
│   │   │       ├── bfa18c1dd1b993fd0ff7bc2009cb4f8bff1a5bb85f67009d9735452c2831da05.json
│   │   │       ├── c11e3e12f2ad4ee03828f555f312c7e2559a78ac6a7f6bea80ba684e23f16488.json
│   │   │       ├── c21f5b0f5d70577723d6afc2fb2874c64be051505deada0d7af8ee70c75b61d1.json
│   │   │       ├── c4870067b3b063062eafd7891a7edeb166c51c5f60cd6bee87e647606dee13db.json
│   │   │       ├── c72acd652ce7d452ddcceb7ac722ff42775032feb7d2cf8f37ec8806e6462c33.json
│   │   │       ├── cacc3c1958a051f036db54131a70d99abf6c2027b3041f1c3d9b109d63de5dec.json
│   │   │       ├── cb62722a94f22324bf8673a052019b121f4d14703176d46273835f6c74eb158c.json
│   │   │       ├── ccac5466a562bfeac3693b93361ecb9d86445eaccba94a10e990c4e6312f234e.json
│   │   │       ├── ccdf976f5a2a7038926ae66a7f54dc40f4733784b509954324ae7444fc7b748e.json
│   │   │       ├── ce810d9c5b58714d1c6323deccb8a3bd6ef6561f822343877321db7a21488c99.json
│   │   │       ├── d121cbb159f9033c7a7821e2bd1d0239e6d847fe069ef73c5f25e344b87d25cf.json
│   │   │       ├── d34d913f928f29d289b039944c132ad257323ef3eadc89057d00b03aae01105c.json
│   │   │       ├── d38f051d65dd35e8a8b03b39986fb0929731874808d89a4d6f1c33c2de5c29e5.json
│   │   │       ├── d3d43e14eb2e4043b72d1afeecc41bcd3d9c8f38b6514451eba0977afba380d1.json
│   │   │       ├── d423e9ce434eceeb72b4e4747aee96a841537388f074b0b31a4b05be616fc614.json
│   │   │       ├── d5b93d02505b8ecd6db5069dc1bc0a187d570633066b1b45b815bbf601639981.json
│   │   │       ├── d9111e2817a3a92974d324deea405f5bad304432c7760a4ed22ccdb6a3b6e632.json
│   │   │       ├── ddb908d0f5a042e6192aea1cea3069aa642aaaf66d43899c60d3934897bd2060.json
│   │   │       ├── ddc5713d519cc18c3f72f2f3150c2c37001e1423b3790aa047c78e982db28b53.json
│   │   │       ├── de245d1d763cf84b62e743c43d5e56ee84969d5d2f2be7d360a7b52015efc476.json
│   │   │       ├── e03de2510a71614629c78808fc4745b79cb1f733364fa49751add41117e066d6.json
│   │   │       ├── e38c6d22f916bcaf610e1566cf56f0756b0664779ac30003ac383d2d241a56b2.json
│   │   │       ├── e9885d38a3be3cfe7c69816636c061f8eeab6d2e455d1c49621681806f29cf0a.json
│   │   │       ├── ebe147ea306792e53c76714dc339ba341c2d969e4c4f742e2bbb3653118a44e9.json
│   │   │       ├── ee005ea3000ea3f488068a89d0e20a39323d456f022e6bb8f05ff5869b57c378.json
│   │   │       ├── f0b0bd32c7f323b5a5772763fdcf529017501f7cfe17408c1b6095cafaeeb3f6.json
│   │   │       ├── f18d4f3883341a1366ca14d42c199520550830e0e0a0f34c097a8fcbc40d7753.json
│   │   │       ├── f41f5aef9fd8840e710790c4d27d5d3433f600c50abb863d51320d6d2363972e.json
│   │   │       ├── f64452863f211fe7ebc40694f66dfc5baa62ea798e53fea38f1fed6e59d0b96d.json
│   │   │       ├── f6a40f3f4684617d05372a00b32e899878a5dcd177e898fa203d906a29357ea2.json
│   │   │       ├── f75cdf8eba23931464b8e289ba8f1218d80f9f5e92ccdbd1217f3845a72ded17.json
│   │   │       ├── f85363455bdb26c33aacbe0fcfbd0cd1477f026562a4f2e3dc6850b4b3603182.json
│   │   │       ├── fcd1f72b02d9195a8e92ae0032628d784d8ed3e4a5f5e6cb5451424718a87ba2.json
│   │   │       └── fd60ab68e05b4bd7d6c6d58656f349ffc3c11aec7d86f646175243510339fd0e.json
│   │   ├── last_query_stamp
│   │   └── stat-index.json
│   ├── graph.html
│   ├── graph.json
│   └── manifest.json
├── images
│   ├── cofounder.jpg
│   └── founder.jpg
├── logo
│   ├── favicon.ico
│   ├── logo.jpg
│   └── logo.png
├── paperclip-company
│   ├── COMPANY.md
│   ├── LICENSE
│   ├── README.md
│   ├── agents
│   │   ├── ceo
│   │   │   └── AGENTS.md
│   │   ├── chief-of-staff
│   │   │   └── AGENTS.md
│   │   ├── delivery-lead
│   │   │   └── AGENTS.md
│   │   ├── lead-researcher
│   │   │   └── AGENTS.md
│   │   ├── qa-security
│   │   │   └── AGENTS.md
│   │   ├── sales-engineer
│   │   │   └── AGENTS.md
│   │   └── technical-lead
│   │       └── AGENTS.md
│   ├── projects
│   │   └── us-client-web-apps
│   │       ├── PROJECT.md
│   │       └── tasks
│   │           ├── 01-discovery
│   │           │   └── TASK.md
│   │           ├── 02-scoping
│   │           │   └── TASK.md
│   │           ├── 03-build
│   │           │   └── TASK.md
│   │           ├── 04-qa
│   │           │   └── TASK.md
│   │           └── 05-deploy
│   │               └── TASK.md
│   └── tasks
├── setup.bat
├── update_tree.py
└── website
    ├── 404.php
    ├── about.php
    ├── admin
    │   ├── auth.php
    │   ├── delete.php
    │   ├── index.php
    │   ├── login.php
    │   ├── logout.php
    │   ├── project-form.php
    │   └── toggle.php
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
    │   │   ├── EmailService.php
    │   │   └── ProjectService.php
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
    │   ├── Env.php
    │   └── database.php
    ├── contact.php
    ├── data
    │   └── projects.json
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
    ├── storage
    │   └── auth
    │       └── admin_lockouts.json
    └── terms.php
```
<!-- TREE_END -->