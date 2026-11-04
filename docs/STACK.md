# CodeX404 Solutions — Technology Stack

## Decision Date
October 2026

## Stack Philosophy
Use proven, stable technologies that work well on shared hosting (Hostinger) while maintaining professional quality and security.

---

## Main Website Stack

### Backend
- **Language:** PHP 8.2+
- **Server:** Apache (Hostinger default)
- **Database:** MySQL 8.0+
- **Architecture:** MVC-inspired structure without framework bloat

### Frontend
- **HTML5** (semantic markup)
- **CSS3** (custom design system)
- **Vanilla JavaScript** (no framework)
- **Optional:** Minimal Bootstrap utilities where genuinely useful

### Why This Stack?
- ✅ Hostinger shared hosting native support
- ✅ Zero deployment complexity
- ✅ Fast page loads (no framework overhead)
- ✅ Easy maintenance
- ✅ Perfect for marketing/content website
- ✅ SEO-friendly server-side rendering
- ❌ NOT over-engineered for simple use case

---

## CRM Stack

### Backend
- **Language:** PHP 8.2+
- **Framework:** Pure PHP or lightweight routing (NO Laravel/Symfony for shared hosting)
- **Database:** MySQL 8.0+
- **Architecture:** Modular monolith
- **API:** REST endpoints for AJAX operations

### Frontend
- **HTML/PHP** templates (server-rendered)
- **CSS3** with design system
- **JavaScript:** Vanilla JS + minimal libraries
- **AJAX:** Fetch API for dynamic updates
- **Optional:** Alpine.js (3KB) for reactive components IF needed

### Why This Stack?
- ✅ Shared hosting compatible
- ✅ No complex build process
- ✅ Full control over performance
- ✅ Progressive enhancement approach
- ✅ Works without JavaScript (core features)
- ✅ Lower hosting costs
- ❌ React/Vue would require Node.js (not available on basic shared hosting)

---

## Database

### Main Website Database
```sql
-- Minimal schema
- contacts (lead form submissions)
- newsletter_subscribers
- analytics_events (optional)
```

### CRM Database
```sql
-- Full business schema (see ARCHITECTURE.md)
- users, roles, permissions, user_roles, role_permissions
- companies, contacts, leads
- opportunities, pipelines, proposals
- clients, projects, invoices, payments
- activities, tasks, notes
- campaigns, automations, audit_logs
```

### Database Strategy
- **Single MySQL instance** with separate databases:
  - `codex404_website`
  - `codex404_crm`
- **Character Set:** utf8mb4 (proper emoji/international support)
- **Engine:** InnoDB (transactions, foreign keys)
- **Backups:** Daily automated via Hostinger + manual weekly

---

## Shared Libraries

### Email
- **Service:** SMTP (Hostinger email or Gmail SMTP)
- **Library:** PHPMailer 6.x
- **Templates:** Plain PHP templates (no Twig overhead)

### Validation
- Custom validation classes (no external dependency needed for simple rules)

### Security
- **Password Hashing:** `password_hash()` with `PASSWORD_BCRYPT`
- **CSRF:** Custom token system using `$_SESSION`
- **XSS:** `htmlspecialchars()` everywhere
- **SQL Injection:** Prepared statements (PDO)

### Payment Gateway
- **Provider:** Razorpay
- **Integration:** Razorpay PHP SDK
- **Webhook:** Server-side verification
- **Test Mode:** Razorpay test keys in development

---

## Frontend Libraries (Minimal, Optional)

### Allowed CDN Libraries (if needed)
```html
<!-- Icons (if not using SVG sprites) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.x/font/bootstrap-icons.min.css">

<!-- Date Picker (for CRM scheduling) -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.x"></script>

<!-- Charts (for CRM dashboard) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.x"></script>

<!-- Alpine.js (ONLY if reactive UI needed) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
```

### Build Process
- **None required** for PHP stack
- **Optional:** 
  - Basic CSS minification (manual or PHP-based)
  - Image optimization (TinyPNG API or similar)
  - No webpack, no npm, no complex builds

---

## Development Environment

### Local Setup
```bash
# Option 1: XAMPP
- Apache + MySQL + PHP built-in
- Works on Windows/Mac/Linux

# Option 2: MAMP
- Similar to XAMPP, Mac-focused

# Option 3: Native PHP server
php -S localhost:8000
```

### Environment Variables
```env
# .env file (never commit)
DB_HOST=localhost
DB_NAME=codex404_website
DB_USER=root
DB_PASS=

CRM_DB_NAME=codex404_crm

SMTP_HOST=smtp.hostinger.com
SMTP_USER=info@codex404solutions.com
SMTP_PASS=

RAZORPAY_KEY_ID=rzp_test_xxx
RAZORPAY_KEY_SECRET=xxx
RAZORPAY_WEBHOOK_SECRET=whsec_xxx

CRM_API_SECRET=generate-random-256bit-key

APP_ENV=development
APP_DEBUG=true
```

### Production Environment
```env
APP_ENV=production
APP_DEBUG=false
ERROR_REPORTING=0
DISPLAY_ERRORS=0
```

---

## Deployment Strategy

### Main Website
```text
Local Development
    ↓
Git Repository (GitHub private)
    ↓
FTP/SFTP to Hostinger public_html/
    ↓
Smoke Test
```

### CRM
```text
Local Development
    ↓
Git Repository (GitHub private)
    ↓
Deploy to crm.codex404solutions.online/
    ↓
Run database migrations
    ↓
Smoke Test + Security Check
```

### Hostinger Directory Structure
```text
public_html/
├── index.php (main website)
├── solutions.php
├── contact.php
├── ...
├── .env (protected by .htaccess)
├── app/
├── config/
├── includes/
└── assets/

crm.codex404solutions.online/ (subdomain or addon domain)
├── index.php (CRM entry point)
├── .env
├── app/
├── config/
├── public/
│   └── assets/
└── storage/
```

---

## Performance Optimization

### Caching Strategy
- **Opcode Cache:** Enable OPcache on Hostinger
- **Database Query Cache:** MySQL query cache
- **Static Assets:** 
  - Browser caching via `.htaccess`
  - CDN for images (optional: Cloudflare)
- **Session Storage:** File-based (default) or Redis if available

### .htaccess Optimization
```apache
# Enable compression
<IfModule mod_deflate.c>
  AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>

# Browser caching
<IfModule mod_expires.c>
  ExpiresActive On
  ExpiresByType image/jpg "access plus 1 year"
  ExpiresByType image/jpeg "access plus 1 year"
  ExpiresByType image/png "access plus 1 year"
  ExpiresByType image/webp "access plus 1 year"
  ExpiresByType text/css "access plus 1 month"
  ExpiresByType application/javascript "access plus 1 month"
</IfModule>

# Security headers
Header always set X-Content-Type-Options "nosniff"
Header always set X-Frame-Options "SAMEORIGIN"
Header always set X-XSS-Protection "1; mode=block"
```

---

## Security Measures

### Hosting Level
- ✅ HTTPS/SSL (free Let's Encrypt via Hostinger)
- ✅ PHP version 8.2+ (security patches)
- ✅ Disable directory browsing
- ✅ Protect sensitive files (.env, config/)
- ✅ Regular backups
- ✅ File permissions (644 files, 755 directories)

### Application Level
- ✅ Prepared statements (NO string concatenation in SQL)
- ✅ Output escaping (`htmlspecialchars()` everywhere)
- ✅ CSRF tokens (session-based)
- ✅ Rate limiting (IP-based tracking)
- ✅ Input validation (server-side)
- ✅ Password requirements (min 12 chars, complexity)
- ✅ Secure session configuration

### .htaccess Protection
```apache
# Protect .env file
<Files ".env">
    Order allow,deny
    Deny from all
</Files>

# Protect config directory
<DirectoryMatch "^.*/config/.*$">
    Order allow,deny
    Deny from all
</DirectoryMatch>

# Protect uploads from execution
<Directory "storage/uploads">
    php_flag engine off
    RemoveHandler .php .phtml .php3
    RemoveType .php .phtml .php3
</Directory>
```

---

## Monitoring & Logging

### Error Logging
```php
// Production error handler
if (APP_ENV === 'production') {
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/storage/logs/php-errors.log');
}
```

### Application Logging
```php
// Custom logger
- storage/logs/app.log (general application events)
- storage/logs/security.log (failed logins, suspicious activity)
- storage/logs/api.log (website → CRM integration)
- storage/logs/payment.log (Razorpay transactions)
```

### Monitoring Tools
- **Uptime:** UptimeRobot (free tier)
- **Analytics:** Google Analytics 4
- **Error Tracking:** Custom email alerts for critical errors
- **Performance:** Chrome Lighthouse (manual weekly checks)

---

## Version Control

### Git Strategy
```bash
# Branches
main         # production-ready code
develop      # integration branch
feature/*    # new features
hotfix/*     # urgent production fixes
```

### .gitignore
```gitignore
.env
vendor/
storage/logs/*.log
storage/cache/*
storage/sessions/*
storage/uploads/*
.DS_Store
Thumbs.db
*.bak
```

---

## Dependencies Management

### PHP Dependencies (Composer)
```json
{
  "require": {
    "php": ">=8.2",
    "phpmailer/phpmailer": "^6.9",
    "razorpay/razorpay": "^2.9"
  },
  "require-dev": {
    "phpstan/phpstan": "^1.10"
  }
}
```

### Why Minimal Dependencies?
- ✅ Faster deployments
- ✅ Fewer security vulnerabilities
- ✅ Better performance
- ✅ Easier debugging
- ✅ Lower hosting resource usage

---

## Testing Strategy

### Local Testing
- Manual testing on localhost
- Test all forms, links, authentication
- Test CRM RBAC with different user roles
- Test Razorpay in test mode

### Staging Testing
- Deploy to `staging.codex404solutions.online`
- Real-world testing before production
- SEO/performance checks

### Production Testing
- Smoke test critical paths after deployment
- Monitor error logs first 24 hours
- Weekly security scans

---

## Backup Strategy

### Automated Backups (Hostinger)
- Daily automatic backups (Hostinger feature)
- Retention: 7-30 days depending on plan

### Manual Backups
- Weekly database exports
- Monthly full site backup
- Store off-server (Google Drive/Dropbox)

### Backup Script
```bash
#!/bin/bash
# Run weekly via cron or manually

DATE=$(date +%Y-%m-%d)

# Database
mysqldump -u username -p database_name > backup_$DATE.sql

# Files
tar -czf files_$DATE.tar.gz public_html/

# Upload to cloud storage
# (use Hostinger file manager or FTP client)
```

---

## Migration Path (Future Scalability)

### When to Consider Upgrading Stack
If you reach:
- 10,000+ CRM records
- 100+ concurrent users
- Complex real-time features needed
- Mobile app requirement

### Then Consider:
- **VPS Hosting** (more resources)
- **API Layer** (Laravel or FastAPI backend)
- **Modern Frontend** (React/Vue for CRM)
- **Managed Database** (better performance)
- **Redis** (caching, queues)
- **CDN** (global performance)

### For Now (Year 1-2)
✅ **Shared hosting PHP stack is perfect**
- Lower costs
- Faster development
- Easier maintenance
- Sufficient performance
- Room to grow

---

## Razorpay Integration Specifics

### SDK Version
- **razorpay/razorpay:** ^2.9

### Implementation Points
1. **CRM Invoice Page:** Generate payment link
2. **Customer Payment Portal:** Razorpay checkout
3. **Webhook Endpoint:** `/api/razorpay/webhook.php`
4. **Payment Verification:** Server-side signature check

### Security
- Store keys in `.env` only
- Verify webhook signatures
- Use HTTPS for payment pages
- Log all transactions
- Never trust client-side payment status

---

## Decision Log

| Decision | Reason | Date |
|----------|--------|------|
| PHP over Python | Hostinger shared hosting compatibility | Oct 2026 |
| MySQL over PostgreSQL | Included in hosting plan | Oct 2026 |
| Vanilla JS over React | No Node.js on shared hosting | Oct 2026 |
| Razorpay payment gateway | India-focused, good documentation | Oct 2026 |
| Minimal dependencies | Performance, security, simplicity | Oct 2026 |

---

## Final Notes

This stack is **production-ready** for:
- 0-1000 website visitors/day
- 0-100 CRM users
- 0-5000 CRM records
- ₹0-25 lakh monthly revenue operations

When you outgrow this, you'll have revenue to invest in better infrastructure.

**Start simple. Scale when needed. Not before.**
