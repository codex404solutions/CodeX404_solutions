# CodeX404 Solutions — Deployment Guide

## Environment Strategy

```text
Local Development (localhost)
    ↓
Staging (staging.codex404solutions.online)
    ↓
Production (codex404solutions.online)
```

---

## Local Development Setup

### Prerequisites
- PHP 8.2+
- MySQL 8.0+
- Composer
- Git

### Option 1: XAMPP (Recommended for Windows)
```bash
# 1. Install XAMPP
Download from: https://www.apachefriends.org/

# 2. Start Apache and MySQL
# Click Start buttons in XAMPP Control Panel

# 3. Clone repository
cd C:\xampp\htdocs\
git clone https://github.com/yourusername/codex404-website.git
cd codex404-website

# 4. Install dependencies
composer install

# 5. Copy environment file
cp .env.example .env

# 6. Edit .env with local credentials
DB_HOST=localhost
DB_NAME=codex404_website
DB_USER=root
DB_PASS=

# 7. Create database
# Open http://localhost/phpmyadmin
# Create database: codex404_website

# 8. Run migrations (if exist)
php migrate.php

# 9. Access website
# http://localhost/codex404-website
```

### Option 2: Native PHP Server (Mac/Linux)
```bash
# 1. Check PHP version
php -v  # Must be 8.2+

# 2. Clone repository
git clone https://github.com/yourusername/codex404-website.git
cd codex404-website

# 3. Install dependencies
composer install

# 4. Setup database
mysql -u root -p
CREATE DATABASE codex404_website;
exit;

# 5. Configure .env
cp .env.example .env
# Edit DB credentials

# 6. Start PHP server
php -S localhost:8000

# 7. Access website
# http://localhost:8000
```

### CRM Local Setup
```bash
# Same steps as website, but:
cd C:\xampp\htdocs\codex404-crm

# Create CRM database
CREATE DATABASE codex404_crm;

# Access CRM
http://localhost/codex404-crm
```

---

## Environment Variables

### Website .env.example
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

# Email (SMTP)
MAIL_DRIVER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=info@codex404solutions.com
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@codex404solutions.com
MAIL_FROM_NAME="CodeX404 Solutions"

# CRM Integration
CRM_API_URL=http://localhost/codex404-crm/api/v1
CRM_API_SECRET=local_test_secret_key_123

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

### CRM .env.example
```env
# Application
APP_NAME="CodeX404 CRM"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost/codex404-crm

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
WEBSITE_API_KEY=local_test_secret_key_123
ALLOWED_ORIGINS=http://localhost

# Razorpay (Test Mode)
RAZORPAY_KEY_ID=rzp_test_xxxxxxxxxxxxxxx
RAZORPAY_KEY_SECRET=xxxxxxxxxxxxxxxxxxxxxxxx
RAZORPAY_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxx

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

## Hostinger Shared Hosting Setup

### Step 1: Prepare Hostinger Account
```text
✓ Domain: codex404solutions.online (already registered)
✓ SSL Certificate: Install free Let's Encrypt SSL
✓ PHP Version: Set to 8.2 or 8.3
✓ MySQL Database: Create databases
```

### Step 2: Create Databases via Hostinger Panel
```sql
-- Database 1: Website
Name: u123456789_website
User: u123456789_web
Password: [generate strong password]

-- Database 2: CRM
Name: u123456789_crm
User: u123456789_crm
Password: [generate strong password]
```

### Step 3: Create Subdomain for CRM
```text
Hostinger Panel → Domains → Subdomains
Subdomain: crm
Full domain: crm.codex404solutions.online
Document Root: /home/u123456789/domains/crm.codex404solutions.online/public_html
```

### Step 4: Directory Structure on Hostinger
```text
/home/u123456789/
├── domains/
│   ├── codex404solutions.online/
│   │   └── public_html/          ← Main website here
│   │       ├── index.php
│   │       ├── .env              ← Protected by .htaccess
│   │       ├── .htaccess
│   │       ├── app/
│   │       ├── config/
│   │       ├── includes/
│   │       ├── assets/
│   │       ├── storage/
│   │       │   └── logs/
│   │       └── vendor/
│   │
│   └── crm.codex404solutions.online/
│       └── public_html/          ← CRM here
│           ├── index.php
│           ├── .env
│           ├── .htaccess
│           ├── app/
│           ├── api/
│           ├── config/
│           ├── public/
│           ├── storage/
│           └── vendor/
```

### Step 5: Upload Files via FTP
```bash
# Using FileZilla or similar FTP client
Host: ftp.codex404solutions.online
Username: u123456789
Password: [your FTP password]
Port: 21

# Upload website files to:
/domains/codex404solutions.online/public_html/

# Upload CRM files to:
/domains/crm.codex404solutions.online/public_html/
```

### Step 6: Configure .htaccess for Main Website
```apache
# /public_html/.htaccess

# Protect .env file
<Files ".env">
    Order allow,deny
    Deny from all
</Files>

# Protect sensitive directories
<DirectoryMatch "^.*/storage/.*$">
    Order allow,deny
    Deny from all
</DirectoryMatch>

# Enable HTTPS redirect
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Clean URLs (remove .php extension)
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME}.php -f
RewriteRule ^(.+)$ $1.php [L,QSA]

# Security headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"
    Header always set Permissions-Policy "geolocation=(), microphone=(), camera=()"
</IfModule>

# Compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
</IfModule>

# Browser caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType image/svg+xml "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
    ExpiresByType application/pdf "access plus 1 month"
    ExpiresByType font/woff2 "access plus 1 year"
</IfModule>

# Disable directory browsing
Options -Indexes

# Error pages
ErrorDocument 404 /404.php
ErrorDocument 500 /500.php
```

### Step 7: Configure Production .env Files
```bash
# SSH into Hostinger (if available) or use File Manager
# Edit /public_html/.env

APP_ENV=production
APP_DEBUG=false
APP_URL=https://codex404solutions.com

DB_HOST=localhost
DB_NAME=u123456789_website
DB_USER=u123456789_web
DB_PASS=[actual database password]

CRM_API_URL=https://crm.codex404solutions.online/api/v1
CRM_API_SECRET=[generate 64-char random string]

MAIL_HOST=smtp.hostinger.com
MAIL_USERNAME=info@codex404solutions.com
MAIL_PASSWORD=[actual email password]

SESSION_SECURE=true
```

### Step 8: Set File Permissions
```bash
# Via SSH or File Manager
# Files: 644
find /path/to/website -type f -exec chmod 644 {} \;

# Directories: 755
find /path/to/website -type d -exec chmod 755 {} \;

# Storage directory: 775 (writable)
chmod -R 775 storage/
chmod -R 775 storage/logs/
chmod -R 775 storage/cache/
chmod -R 775 storage/sessions/
```

### Step 9: Import Database
```bash
# Via phpMyAdmin (Hostinger Panel)
# 1. Select database: u123456789_website
# 2. Click Import
# 3. Upload website_schema.sql
# 4. Execute

# Same for CRM database
```

### Step 10: Test Website
```bash
# Test checklist:
✓ https://codex404solutions.com loads
✓ All pages load without errors
✓ Contact form submits
✓ Images load
✓ CSS/JS loads
✓ SSL certificate valid (green padlock)
✓ No PHP errors in logs
```

---

## Staging Environment

### Purpose
Test changes before production deployment

### Setup
```text
Subdomain: staging.codex404solutions.online
CRM: crm-staging.codex404solutions.online

# Same structure as production
# Use separate databases
# Protected with basic auth
```

### .htaccess for Staging (Password Protection)
```apache
# Staging password protection
AuthType Basic
AuthName "Staging Area"
AuthUserFile /home/u123456789/.htpasswd
Require valid-user
```

### Create .htpasswd
```bash
# Generate via online tool or command:
htpasswd -c .htpasswd admin
# Password: [choose staging password]
```

---

## Database Migrations

### Migration System (Simple PHP)
```php
// migrate.php
<?php
require_once 'config/database.php';

$migrations = [
    '001_create_contacts_table.sql',
    '002_create_newsletter_table.sql',
    '003_add_utm_tracking.sql'
];

foreach ($migrations as $migration) {
    echo "Running: $migration\n";
    $sql = file_get_contents("database/migrations/$migration");
    $pdo->exec($sql);
    echo "✓ Completed\n";
}

echo "\nAll migrations completed successfully!\n";
```

### Example Migration
```sql
-- database/migrations/001_create_contacts_table.sql
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    company VARCHAR(255),
    country VARCHAR(100),
    service_interest VARCHAR(255),
    problem TEXT,
    source VARCHAR(50),
    utm_source VARCHAR(100),
    utm_campaign VARCHAR(100),
    status ENUM('new', 'contacted', 'qualified', 'synced_to_crm') DEFAULT 'new',
    crm_lead_id VARCHAR(36),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## Deployment Checklist

### Pre-Deployment (Local)
- [ ] All features tested locally
- [ ] No console errors
- [ ] No PHP errors/warnings
- [ ] Forms validate correctly
- [ ] Database migrations created
- [ ] .env.example updated
- [ ] Secrets removed from code
- [ ] Git commit and push

### Deployment to Staging
- [ ] Pull latest code to staging
- [ ] Run database migrations
- [ ] Update .env for staging
- [ ] Test all critical paths
- [ ] Test CRM integration
- [ ] Check error logs
- [ ] Performance test (Lighthouse)
- [ ] Security scan

### Deployment to Production
- [ ] Backup current production database
- [ ] Backup current production files
- [ ] Set DNS TTL to 300 (5 minutes)
- [ ] Deploy new code via FTP/Git
- [ ] Run database migrations
- [ ] Update production .env
- [ ] Test immediately after deploy
- [ ] Monitor error logs (30 minutes)
- [ ] Monitor website uptime
- [ ] Submit new sitemap to Google
- [ ] Clear CDN cache (if using)
- [ ] Announce to team

### Post-Deployment (24 Hours)
- [ ] Monitor error logs daily
- [ ] Check Google Analytics traffic
- [ ] Check form submissions working
- [ ] Check CRM lead creation working
- [ ] Verify email notifications
- [ ] Test payment flow (if applicable)
- [ ] Monitor server resources
- [ ] Check SSL certificate expiry

---

## Backup Strategy

### Automated Backups (Hostinger)
```text
Hostinger provides:
- Daily automatic backups (last 7-30 days depending on plan)
- Accessible via Hostinger Panel → Backups
- Restoration available with one click
```

### Manual Backups (Weekly)

#### Database Backup
```bash
# Via phpMyAdmin
# 1. Select database
# 2. Export tab
# 3. Quick export → SQL format
# 4. Download: codex404_website_2026-10-05.sql

# Save to:
Google Drive: /Backups/CodeX404/Website/
```

#### Files Backup
```bash
# Via FTP or File Manager
# 1. Compress public_html/ directory
# 2. Download: codex404_website_files_2026-10-05.zip

# Save to:
Google Drive: /Backups/CodeX404/Website/
```

#### Automated Backup Script (if SSH access available)
```bash
#!/bin/bash
# backup.sh

DATE=$(date +%Y-%m-%d)
BACKUP_DIR="/home/u123456789/backups"

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u u123456789_web -p[password] u123456789_website > $BACKUP_DIR/website_db_$DATE.sql

# Files backup
tar -czf $BACKUP_DIR/website_files_$DATE.tar.gz /home/u123456789/domains/codex404solutions.online/public_html/

# Keep only last 7 days
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

echo "Backup completed: $DATE"
```

### Backup Schedule
- **Daily:** Automatic (Hostinger)
- **Weekly:** Manual database + files
- **Before major update:** Manual full backup
- **Monthly:** Download all backups to local storage

---

## Monitoring

### Uptime Monitoring
```text
Service: UptimeRobot (Free Plan)
Monitors:
- https://codex404solutions.com (check every 5 minutes)
- https://crm.codex404solutions.online (check every 5 minutes)
- https://crm.codex404solutions.online/health (API health check)

Alerts:
- Email: mnouk@codex404solutions.online
- SMS: (optional, paid)
```

### Health Check Endpoints

#### Website Health Check
```php
// health.php
<?php
header('Content-Type: application/json');

$health = [
    'status' => 'healthy',
    'timestamp' => date('c'),
    'checks' => []
];

// Check database
try {
    $pdo = require 'config/database.php';
    $health['checks']['database'] = 'ok';
} catch (Exception $e) {
    $health['status'] = 'unhealthy';
    $health['checks']['database'] = 'failed';
}

// Check disk space
$diskFree = disk_free_space('/');
$diskTotal = disk_total_space('/');
$diskPercent = ($diskFree / $diskTotal) * 100;
$health['checks']['disk_space'] = $diskPercent > 10 ? 'ok' : 'warning';

// Check writable directories
$health['checks']['storage_writable'] = is_writable('storage/logs/') ? 'ok' : 'failed';

echo json_encode($health, JSON_PRETTY_PRINT);
```

#### CRM Health Check
```php
// api/health.php
<?php
// Same as above, plus:
// - Check queue jobs
// - Check API authentication
// - Check email service
// - Check Razorpay connectivity
```

### Error Monitoring
```php
// config/error-handler.php
<?php
function handleError($errno, $errstr, $errfile, $errline) {
    $error = [
        'type' => $errno,
        'message' => $errstr,
        'file' => $errfile,
        'line' => $errline,
        'time' => date('Y-m-d H:i:s')
    ];
    
    // Log to file
    error_log(json_encode($error) . "\n", 3, 'storage/logs/errors.log');
    
    // Send email alert for critical errors
    if ($errno === E_ERROR || $errno === E_USER_ERROR) {
        mail(
            'mnouk@codex404solutions.online',
            'Critical Error on CodeX404 Website',
            "Error: $errstr\nFile: $errfile\nLine: $errline",
            'From: alerts@codex404solutions.online'
        );
    }
    
    // Display generic error in production
    if (getenv('APP_ENV') === 'production') {
        echo "An error occurred. Please try again later.";
        exit;
    }
}

set_error_handler('handleError');
```

### Performance Monitoring
```text
Tools:
- Google Lighthouse (weekly manual checks)
- Google Search Console (weekly review)
- Google Analytics (daily traffic check)
- Server logs (weekly review)

Metrics to track:
- Page load time (target: < 3 seconds)
- Core Web Vitals (all green)
- Form submission rate
- Bounce rate
- CRM API response time
```

---

## SSL Certificate

### Installation (Hostinger Auto-SSL)
```text
1. Go to Hostinger Panel → SSL
2. Click "Install SSL" for codex404solutions.online
3. Select "Free Let's Encrypt SSL"
4. Wait 5-10 minutes for activation
5. Repeat for crm.codex404solutions.online
```

### Verification
```bash
# Check SSL status
https://www.ssllabs.com/ssltest/analyze.html?d=codex404solutions.online

# Target grade: A or A+
```

### Auto-Renewal
Let's Encrypt certificates auto-renew every 90 days via Hostinger.
Monitor expiry dates monthly.

---

## Rollback Plan

### If Deployment Fails

#### Option 1: Quick Rollback (FTP)
```bash
# 1. Connect via FTP
# 2. Delete new files from public_html/
# 3. Upload backup files from previous version
# 4. Restore database from backup (phpMyAdmin)
# 5. Test website
```

#### Option 2: Hostinger Restore
```bash
# 1. Go to Hostinger Panel → Backups
# 2. Select yesterday's backup
# 3. Click "Restore"
# 4. Wait 5-10 minutes
# 5. Test website
```

### If Database Migration Fails
```sql
-- Keep rollback migrations
-- Example: 001_create_contacts_table_rollback.sql
DROP TABLE IF EXISTS contacts;

-- Run in reverse order
```

---

## Deployment Automation (Future)

### Git Deploy Hook (if Hostinger supports it)
```bash
# .git/hooks/post-receive
#!/bin/bash
git --work-tree=/home/u123456789/domains/codex404solutions.online/public_html --git-dir=/home/u123456789/repos/website.git checkout -f

# Run migrations
cd /home/u123456789/domains/codex404solutions.online/public_html
php migrate.php

# Clear cache
rm -rf storage/cache/*

echo "Deployment completed!"
```

### GitHub Actions (if using GitHub)
```yaml
# .github/workflows/deploy.yml
name: Deploy to Production

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      
      - name: Deploy via FTP
        uses: SamKirkland/FTP-Deploy-Action@4.0.0
        with:
          server: ftp.codex404solutions.online
          username: ${{ secrets.FTP_USERNAME }}
          password: ${{ secrets.FTP_PASSWORD }}
          local-dir: ./
          server-dir: /domains/codex404solutions.online/public_html/
```

**Note:** Implement automation after manual deployment is stable (3-6 months)

---

## Troubleshooting

### Website Not Loading
```bash
# Check:
1. DNS propagation: https://dnschecker.org
2. SSL certificate: https://www.ssllabs.com/ssltest/
3. Hostinger server status
4. PHP error logs: /storage/logs/
5. Apache error logs: (Hostinger Panel → Error Logs)
```

### CRM API Not Responding
```bash
# Check:
1. CRM subdomain DNS
2. CRM .env file exists
3. Database connection working
4. API secret matches between website and CRM
5. Rate limiting not triggered
6. Check /storage/logs/api-incoming.log
```

### Forms Not Submitting
```bash
# Check:
1. PHP mail() function enabled (Hostinger)
2. SMTP credentials correct
3. Spam folder (for test emails)
4. Check /storage/logs/mail.log
5. reCAPTCHA if enabled
```

### Database Connection Failed
```bash
# Check:
1. Database credentials in .env
2. Database exists in Hostinger Panel
3. Database user has permissions
4. MySQL service running
5. Connection from PHP:
   php -r "new PDO('mysql:host=localhost;dbname=test', 'user', 'pass');"
```

---

## Support Contacts

### Hostinger Support
- Email: support@hostinger.com
- Live Chat: Hostinger Panel → Help
- Response Time: Usually within 24 hours

### DNS Provider
- (Same as Hostinger if domain registered there)

### Emergency Contacts
- Developer: [Your phone number]
- Backup Admin: [Backup contact]

---

## Deployment Timeline

### Week 1: Setup
- Day 1-2: Local development environment
- Day 3-4: Staging environment
- Day 5-7: Test deployment workflow

### Week 2: Production
- Day 8: Backup current website
- Day 9: Deploy new website to production
- Day 10-14: Monitor and fix issues

### Week 3-4: CRM
- Day 15-21: CRM development locally
- Day 22-28: CRM deployment to staging, then production

---

## Post-Launch Checklist

### Week 1
- [ ] Monitor error logs daily
- [ ] Check form submissions working
- [ ] Verify CRM integration
- [ ] Check SSL certificate
- [ ] Monitor uptime
- [ ] Review Google Analytics

### Month 1
- [ ] Weekly manual backups
- [ ] Performance review (Lighthouse)
- [ ] Security scan
- [ ] Review and optimize slow pages
- [ ] Update dependencies if needed

### Quarterly
- [ ] Full security audit
- [ ] Database optimization
- [ ] Review and clean old logs
- [ ] Update documentation
- [ ] Disaster recovery drill

---

**Last Updated:** October 2026  
**Status:** Production Ready  
**Maintained By:** Noukhez Mohammed
