# CodeX404 Solutions — Monorepo Structure Guide

**Decision:** Single repository for Website + CRM  
**Date:** October 6, 2026  
**Status:** Recommended Structure

---

## 📁 Complete Repository Structure

```text
codex404-solutions/
├── .github/
│   └── workflows/
│       ├── deploy-website.yml      # Website deployment
│       └── deploy-crm.yml          # CRM deployment
│
├── website/                         # Main Website
│   ├── index.php
│   ├── solutions.php
│   ├── ai-solutions.php
│   ├── ai-agents.php
│   ├── automation.php
│   ├── software-development.php
│   ├── mobile-apps.php
│   ├── saas.php
│   ├── industries.php
│   ├── case-studies.php
│   ├── portfolio.php
│   ├── process.php
│   ├── about.php
│   ├── engagement-models.php
│   ├── security.php
│   ├── faq.php
│   ├── contact.php
│   ├── discovery-call.php
│   ├── privacy.php
│   ├── terms.php
│   ├── 404.php
│   ├── .env.example
│   ├── .htaccess
│   │
│   ├── includes/
│   │   ├── header.php
│   │   ├── footer.php
│   │   ├── navigation.php
│   │   └── seo.php
│   │
│   ├── components/
│   │   ├── hero.php
│   │   ├── cta.php
│   │   ├── service-card.php
│   │   ├── case-study-card.php
│   │   ├── testimonial.php
│   │   └── faq-item.php
│   │
│   ├── app/
│   │   ├── Controllers/
│   │   │   ├── ContactController.php
│   │   │   └── LeadController.php
│   │   ├── Services/
│   │   │   ├── EmailService.php
│   │   │   └── CRMIntegrationService.php
│   │   ├── Validators/
│   │   │   └── FormValidator.php
│   │   └── Helpers/
│   │       └── Sanitizer.php
│   │
│   ├── config/
│   │   ├── database.php
│   │   ├── mail.php
│   │   └── app.php
│   │
│   ├── assets/
│   │   ├── css/
│   │   │   ├── main.css
│   │   │   ├── components.css
│   │   │   └── responsive.css
│   │   ├── js/
│   │   │   ├── main.js
│   │   │   └── forms.js
│   │   ├── images/
│   │   │   ├── logo.svg
│   │   │   ├── hero/
│   │   │   └── case-studies/
│   │   └── fonts/
│   │
│   ├── storage/
│   │   ├── logs/
│   │   │   ├── app.log
│   │   │   ├── crm-api.log
│   │   │   └── errors.log
│   │   ├── cache/
│   │   └── sessions/
│   │
│   └── vendor/                      # Composer dependencies
│
├── crm/                             # CRM Application
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── dashboard.php
│   ├── .env.example
│   ├── .htaccess
│   │
│   ├── api/
│   │   └── v1/
│   │       ├── leads.php           # Website → CRM integration
│   │       ├── health.php          # Health check
│   │       └── razorpay/
│   │           ├── webhook.php
│   │           └── verify-payment.php
│   │
│   ├── app/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── LeadController.php
│   │   │   ├── CompanyController.php
│   │   │   ├── ContactController.php
│   │   │   ├── OpportunityController.php
│   │   │   ├── ProposalController.php
│   │   │   ├── ClientController.php
│   │   │   ├── ProjectController.php
│   │   │   ├── InvoiceController.php
│   │   │   ├── PaymentController.php
│   │   │   └── UserController.php
│   │   │
│   │   ├── Models/
│   │   │   ├── User.php
│   │   │   ├── Role.php
│   │   │   ├── Permission.php
│   │   │   ├── Lead.php
│   │   │   ├── Company.php
│   │   │   ├── Contact.php
│   │   │   ├── Opportunity.php
│   │   │   ├── Proposal.php
│   │   │   ├── Client.php
│   │   │   ├── Project.php
│   │   │   ├── Invoice.php
│   │   │   └── Payment.php
│   │   │
│   │   ├── Services/
│   │   │   ├── AuthService.php
│   │   │   ├── PermissionService.php
│   │   │   ├── LeadService.php
│   │   │   ├── OpportunityService.php
│   │   │   ├── ProposalService.php
│   │   │   ├── InvoiceService.php
│   │   │   ├── PaymentService.php
│   │   │   ├── RazorpayService.php
│   │   │   └── EmailService.php
│   │   │
│   │   ├── Repositories/
│   │   │   ├── LeadRepository.php
│   │   │   ├── CompanyRepository.php
│   │   │   ├── OpportunityRepository.php
│   │   │   └── InvoiceRepository.php
│   │   │
│   │   ├── Middleware/
│   │   │   ├── AuthMiddleware.php
│   │   │   ├── PermissionMiddleware.php
│   │   │   └── ApiAuthMiddleware.php
│   │   │
│   │   └── Helpers/
│   │       ├── PermissionChecker.php
│   │       ├── AuditLogger.php
│   │       └── DateHelper.php
│   │
│   ├── config/
│   │   ├── database.php
│   │   ├── auth.php
│   │   ├── permissions.php
│   │   └── razorpay.php
│   │
│   ├── database/
│   │   ├── migrations/
│   │   │   ├── 001_create_users_table.sql
│   │   │   ├── 002_create_roles_permissions.sql
│   │   │   ├── 003_create_leads_table.sql
│   │   │   ├── 004_create_companies_table.sql
│   │   │   ├── 005_create_opportunities_table.sql
│   │   │   ├── 006_create_invoices_table.sql
│   │   │   └── 007_create_payments_table.sql
│   │   └── seeds/
│   │       ├── roles_seed.sql
│   │       └── permissions_seed.sql
│   │
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.php
│   │   │   ├── auth.php
│   │   │   └── components/
│   │   │       ├── header.php
│   │   │       ├── sidebar.php
│   │   │       └── footer.php
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   └── forgot-password.php
│   │   ├── dashboard/
│   │   │   ├── ceo.php
│   │   │   ├── cto.php
│   │   │   ├── sales.php
│   │   │   └── developer.php
│   │   ├── leads/
│   │   │   ├── index.php
│   │   │   ├── show.php
│   │   │   └── create.php
│   │   ├── opportunities/
│   │   │   ├── kanban.php
│   │   │   └── show.php
│   │   ├── projects/
│   │   │   └── index.php
│   │   └── invoices/
│   │       ├── index.php
│   │       └── show.php
│   │
│   ├── public/
│   │   └── assets/
│   │       ├── css/
│   │       │   ├── crm.css
│   │       │   └── dashboard.css
│   │       ├── js/
│   │       │   ├── crm.js
│   │       │   └── kanban.js
│   │       └── images/
│   │
│   ├── storage/
│   │   ├── logs/
│   │   │   ├── app.log
│   │   │   ├── api-incoming.log
│   │   │   ├── security.log
│   │   │   └── payment.log
│   │   ├── uploads/
│   │   ├── cache/
│   │   └── sessions/
│   │
│   └── vendor/                      # Composer dependencies
│
├── docs/                            # All Documentation
│   ├── Main-Website/
│   │   ├── PRD.md
│   │   ├── ARCHITECTURE.md
│   │   ├── RULES.md
│   │   ├── DESIGN.md
│   │   ├── TASKS.md
│   │   ├── MEMORY.md
│   │   └── DEVELOPMENT_PROMPT.md
│   ├── CRM/
│   │   ├── PRD.md
│   │   ├── ARCHITECTURE.md
│   │   ├── RULES.md
│   │   ├── DESIGN.md
│   │   ├── TASKS.md
│   │   ├── MEMORY.md
│   │   └── DEVELOPMENT_PROMPT.md
│   ├── STACK.md
│   ├── API_CONTRACT.md
│   ├── DEPLOYMENT.md
│   ├── RAZORPAY_INTEGRATION.md
│   ├── MONOREPO_STRUCTURE.md (this file)
│   └── QUICK_START_GUIDE.md
│
├── scripts/                         # Utility Scripts
│   ├── migrate.php                  # Run database migrations
│   ├── seed.php                     # Seed database
│   ├── backup.sh                    # Backup database
│   └── deploy-local.sh              # Local deployment helper
│
├── tests/                           # Tests (Future)
│   ├── website/
│   └── crm/
│
├── .gitignore
├── .env.example                     # Global env template
├── composer.json                    # Global dependencies
├── composer.lock
└── README.md
```

---

## 🔧 GitHub Actions Workflows

### **Workflow 1: Deploy Website**

**File:** `.github/workflows/deploy-website.yml`

```yaml
name: Deploy Website to Hostinger

on:
  push:
    branches:
      - main
      - dev
    paths:
      - 'website/**'
      - '.github/workflows/deploy-website.yml'

jobs:
  deploy-prod:
    if: github.ref == 'refs/heads/main'
    runs-on: ubuntu-latest

    steps:
      - name: Checkout Repo
        uses: actions/checkout@v4

      - name: Deploy Website to Production
        uses: SamKirkland/FTP-Deploy-Action@v4.3.5
        with:
          server: ${{ secrets.FTP_SERVER_PROD }}
          username: ${{ secrets.FTP_USERNAME_PROD }}
          password: ${{ secrets.FTP_PASSWORD_PROD }}
          port: 21
          protocol: ftp
          local-dir: ./website/
          server-dir: /
          exclude: |
            **/.git*
            **/.github/**
            **/*.md
            **/.env
            **/tests/**
            **/storage/logs/**
            **/storage/cache/**
            **/storage/sessions/**

  deploy-dev:
    if: github.ref == 'refs/heads/dev'
    runs-on: ubuntu-latest

    steps:
      - name: Checkout Repo
        uses: actions/checkout@v4

      - name: Deploy Website to Dev
        uses: SamKirkland/FTP-Deploy-Action@v4.3.5
        with:
          server: ${{ secrets.FTP_SERVER_DEV }}
          username: ${{ secrets.FTP_USERNAME_DEV }}
          password: ${{ secrets.FTP_PASSWORD_DEV }}
          port: 21
          protocol: ftp
          local-dir: ./website/
          server-dir: /
          exclude: |
            **/.git*
            **/.github/**
            **/*.md
            **/.env
            **/tests/**
            **/storage/logs/**
            **/storage/cache/**
            **/storage/sessions/**
```

---

### **Workflow 2: Deploy CRM**

**File:** `.github/workflows/deploy-crm.yml`

```yaml
name: Deploy CRM to Hostinger

on:
  push:
    branches:
      - main
      - dev
    paths:
      - 'crm/**'
      - '.github/workflows/deploy-crm.yml'

jobs:
  deploy-prod:
    if: github.ref == 'refs/heads/main'
    runs-on: ubuntu-latest

    steps:
      - name: Checkout Repo
        uses: actions/checkout@v4

      - name: Deploy CRM to Production
        uses: SamKirkland/FTP-Deploy-Action@v4.3.5
        with:
          server: ${{ secrets.FTP_SERVER_CRM_PROD }}
          username: ${{ secrets.FTP_USERNAME_CRM_PROD }}
          password: ${{ secrets.FTP_PASSWORD_CRM_PROD }}
          port: 21
          protocol: ftp
          local-dir: ./crm/
          server-dir: /
          exclude: |
            **/.git*
            **/.github/**
            **/*.md
            **/.env
            **/tests/**
            **/storage/logs/**
            **/storage/cache/**
            **/storage/sessions/**
            **/storage/uploads/**

  deploy-dev:
    if: github.ref == 'refs/heads/dev'
    runs-on: ubuntu-latest

    steps:
      - name: Checkout Repo
        uses: actions/checkout@v4

      - name: Deploy CRM to Dev
        uses: SamKirkland/FTP-Deploy-Action@v4.3.5
        with:
          server: ${{ secrets.FTP_SERVER_CRM_DEV }}
          username: ${{ secrets.FTP_USERNAME_CRM_DEV }}
          password: ${{ secrets.FTP_PASSWORD_CRM_DEV }}
          port: 21
          protocol: ftp
          local-dir: ./crm/
          server-dir: /
          exclude: |
            **/.git*
            **/.github/**
            **/*.md
            **/.env
            **/tests/**
            **/storage/logs/**
            **/storage/cache/**
            **/storage/sessions/**
            **/storage/uploads/**
```

---

## 📝 Environment Files

### **Website .env.example**

**File:** `website/.env.example`

```env
# Application
APP_NAME="CodeX404 Solutions"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_NAME=codex404_website
DB_USER=root
DB_PASS=

# Email
MAIL_DRIVER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=hello@codex404solutions.online
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@codex404solutions.online
MAIL_FROM_NAME="CodeX404 Solutions"

# CRM Integration
CRM_API_URL=http://localhost/crm/api/v1
CRM_API_SECRET=local_test_secret_key_change_in_production

# Analytics
GOOGLE_ANALYTICS_ID=
GOOGLE_TAG_MANAGER_ID=

# Recaptcha (optional)
RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET_KEY=

# Security
SESSION_LIFETIME=120
SESSION_SECURE=false
SESSION_HTTP_ONLY=true
```

---

### **CRM .env.example**

**File:** `crm/.env.example`

```env
# Application
APP_NAME="CodeX404 CRM"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost/crm

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_NAME=codex404_crm
DB_USER=root
DB_PASS=

# Email
MAIL_DRIVER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=crm@codex404solutions.online
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls

# API Keys
WEBSITE_API_KEY=local_test_secret_key_change_in_production
ALLOWED_ORIGINS=http://localhost

# Razorpay
RAZORPAY_KEY_ID=rzp_test_xxxxxxxxxxxxxxx
RAZORPAY_KEY_SECRET=xxxxxxxxxxxxxxxxxxxxxxxx
RAZORPAY_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxx
RAZORPAY_MODE=test

# Rate Limiting
RATE_LIMIT_PER_MINUTE=100
API_TIMEOUT=10

# Session
SESSION_LIFETIME=480
SESSION_SECURE=false
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# Security
CSRF_ENABLED=true
PASSWORD_MIN_LENGTH=12
```

---

## 📦 Composer Configuration

**File:** `composer.json` (Root level)

```json
{
  "name": "codex404/solutions",
  "description": "CodeX404 Solutions - Website + CRM",
  "type": "project",
  "require": {
    "php": ">=8.2",
    "phpmailer/phpmailer": "^6.9",
    "razorpay/razorpay": "^2.9"
  },
  "require-dev": {
    "phpstan/phpstan": "^1.10"
  },
  "autoload": {
    "psr-4": {
      "Website\\": "website/app/",
      "CRM\\": "crm/app/"
    }
  }
}
```

---

## 🚫 .gitignore

**File:** `.gitignore` (Root level)

```gitignore
# Environment files
.env
*.env
!.env.example

# Vendor
vendor/
composer.lock

# Logs
storage/logs/*.log
*.log

# Cache
storage/cache/*
!storage/cache/.gitkeep

# Sessions
storage/sessions/*
!storage/sessions/.gitkeep

# Uploads
storage/uploads/*
!storage/uploads/.gitkeep

# OS
.DS_Store
Thumbs.db
desktop.ini

# IDE
.vscode/
.idea/
*.swp
*.swo

# Backups
*.bak
*.backup
*.sql

# Temp
tmp/
temp/
*.tmp
```

---

## 📋 README.md

**File:** `README.md` (Root level)

```markdown
# CodeX404 Solutions

**AI & Software Engineering Partner for Growing Businesses**

This monorepo contains:
- Main Website (codex404solutions.online)
- CRM System (crm.codex404solutions.online)

---

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- MySQL 8.0+
- Composer

### Installation

**1. Clone Repository**
```bash
git clone https://github.com/yourusername/codex404-solutions.git
cd codex404-solutions
```

**2. Install Dependencies**
```bash
composer install
```

**3. Setup Website**
```bash
cd website
cp .env.example .env
# Edit .env with your database credentials

# Create database
mysql -u root -p
CREATE DATABASE codex404_website;
exit;
```

**4. Setup CRM**
```bash
cd ../crm
cp .env.example .env
# Edit .env with your database credentials

# Create database
mysql -u root -p
CREATE DATABASE codex404_crm;
exit;

# Run migrations
php ../scripts/migrate.php
```

**5. Start Local Server**
```bash
# Website
cd website
php -S localhost:8000

# CRM (in another terminal)
cd crm
php -S localhost:8001
```

**6. Access Applications**
- Website: http://localhost:8000
- CRM: http://localhost:8001

---

## 📖 Documentation

See `docs/` directory for complete documentation:
- [Quick Start Guide](docs/QUICK_START_GUIDE.md)
- [Technology Stack](docs/STACK.md)
- [API Contract](docs/API_CONTRACT.md)
- [Deployment Guide](docs/DEPLOYMENT.md)

---

## 🏗️ Project Structure

```
codex404-solutions/
├── website/          # Main public website
├── crm/              # Internal CRM system
├── docs/             # Documentation
└── scripts/          # Utility scripts
```

---

## 🔐 Security

- Never commit `.env` files
- Keep `composer.lock` up to date
- Use prepared statements for database queries
- Validate all user input
- Escape all output

---

## 📧 Contact

- Website: https://codex404solutions.online
- Email: hello@codex404solutions.online
- LinkedIn: https://www.linkedin.com/in/mnoukhej/
```

---

## 🎯 Development Workflow

### **Working on Website**

```bash
# Create feature branch
git checkout -b feature/homepage-redesign

# Make changes in website/ directory
cd website
# ... edit files ...

# Test locally
php -S localhost:8000

# Commit and push
git add website/
git commit -m "feat(website): update homepage hero section"
git push origin feature/homepage-redesign

# Create PR to dev branch
# After review, merge to dev
# Test on dev.codex404solutions.online

# When ready, merge dev → main
# Auto-deploys to codex404solutions.online
```

---

### **Working on CRM**

```bash
# Create feature branch
git checkout -b feature/lead-management

# Make changes in crm/ directory
cd crm
# ... edit files ...

# Test locally
php -S localhost:8001

# Commit and push
git add crm/
git commit -m "feat(crm): add lead duplicate detection"
git push origin feature/lead-management

# Create PR to dev branch
# After review, merge to dev
# Test on dev-crm (or dev.codex404solutions.online/crm)

# When ready, merge dev → main
# Auto-deploys to crm.codex404solutions.online
```

---

### **Working on Both**

```bash
# If changes affect both website and CRM
git checkout -b feature/website-crm-integration

# Make changes
# ... edit website/ and crm/ files ...

# Commit together
git add website/ crm/
git commit -m "feat: add website → CRM lead integration"
git push origin feature/website-crm-integration

# Both workflows will trigger
# - deploy-website.yml (for website/ changes)
# - deploy-crm.yml (for crm/ changes)
```

---

## 🔄 Migration from Current Setup

### **Your Current Structure:**
```text
codex404/
├── (website files)
└── .github/workflows/deploy.yml
```

### **New Monorepo Structure:**
```bash
# 1. Create new structure
mkdir -p codex404-solutions/website
mkdir -p codex404-solutions/crm
mkdir -p codex404-solutions/docs
mkdir -p codex404-solutions/.github/workflows

# 2. Move website files
mv codex404/* codex404-solutions/website/

# 3. Move workflows
mv codex404/.github/workflows/deploy.yml codex404-solutions/.github/workflows/deploy-website.yml

# 4. Update workflow paths
# Edit deploy-website.yml:
# local-dir: ./codex404/ → local-dir: ./website/

# 5. Add documentation
cp -r CodeX404-FULL-DETAILED-Docs/* codex404-solutions/docs/

# 6. Create .gitignore, composer.json, README.md
# (Copy from examples above)

# 7. Initialize git
cd codex404-solutions
git init
git add .
git commit -m "Initial commit: monorepo structure"
git remote add origin https://github.com/yourusername/codex404-solutions.git
git push -u origin main

# 8. Create dev branch
git checkout -b dev
git push -u origin dev
```

---

## ⚠️ Important Notes

### **1. Deployment Triggers**

With `paths:` filter in workflows:
- Changes to `website/` only → triggers `deploy-website.yml`
- Changes to `crm/` only → triggers `deploy-crm.yml`
- Changes to both → triggers both workflows
- Changes to `docs/` → no deployment (documentation only)

### **2. Environment Files**

Each application has its own `.env`:
- `website/.env` (for website)
- `crm/.env` (for CRM)
- Both ignored by git
- Must be created manually on each environment

### **3. Dependencies**

Single `composer.json` at root:
- Shared dependencies (PHPMailer, Razorpay)
- Autoloading for both apps
- Run `composer install` once at root

### **4. Database**

Two separate databases:
- `codex404_website` (for website contacts)
- `codex404_crm` (for full CRM data)
- Migrations in `crm/database/migrations/`

---

## 📊 Advantages of Monorepo

✅ **Single Source of Truth**
- All code in one place
- Shared documentation
- Unified version history

✅ **Easier Refactoring**
- Change API contract → update both apps in same PR
- Atomic commits across website and CRM

✅ **Simplified CI/CD**
- One set of secrets
- Coordinated deployments
- Single PR review process

✅ **Shared Code**
- Common utilities
- Shared PHP classes
- DRY principle

✅ **Better Testing**
- Integration tests across website + CRM
- Single test suite setup

---

## 🎉 You're Ready!

**Your monorepo structure is:**
- ✅ Organized (website/, crm/, docs/)
- ✅ Automated (GitHub Actions for both)
- ✅ Scalable (easy to add more apps)
- ✅ Professional (standard monorepo pattern)

**Next steps:**
1. Restructure your current repo into monorepo
2. Update workflow files
3. Test deployments to dev branch
4. Start building website
5. Add CRM when ready

---

**Questions?** Refer to docs/ or ask! 🚀
