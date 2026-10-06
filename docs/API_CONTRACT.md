# CodeX404 Solutions — Website ↔ CRM API Contract

## Purpose
Define the exact integration between the main website (codex404solutions.online) and CRM (crm.codex404solutions.online).

The website captures leads through forms and sends them securely to the CRM.

---

## Integration Architecture

```text
User fills form on website
    ↓
Client-side validation (UX only)
    ↓
Form submits to website backend (POST)
    ↓
Server-side validation
    ↓
Website PHP makes authenticated request to CRM API
    ↓
CRM validates, creates/updates lead
    ↓
CRM returns response
    ↓
Website shows success/error to user
```

**Critical:** API credentials must NEVER be in browser JavaScript.

---

## Endpoint 1: Create Lead

### URL
```
POST https://crm.codex404solutions.online/api/v1/leads
```

### Authentication
```http
Authorization: Bearer {CRM_API_SECRET}
Content-Type: application/json
```

### Headers
```http
Authorization: Bearer sk_live_abc123xyz... (from .env)
Content-Type: application/json
X-Request-Source: website
X-Idempotency-Key: {uuid-v4}
```

### Request Body
```json
{
  "idempotency_key": "550e8400-e29b-41d4-a716-446655440000",
  "source": "website_contact_form",
  "utm_source": "linkedin",
  "utm_medium": "organic",
  "utm_campaign": "ai-automation-launch",
  "utm_content": "hero-cta",
  "utm_term": null,
  "page_url": "https://codex404solutions.online/contact",
  "referrer": "https://www.linkedin.com/in/mnoukhej/",
  "user_agent": "Mozilla/5.0...",
  "ip_address": "203.0.113.42",
  "lead": {
    "name": "John Doe",
    "email": "john.doe@example.com",
    "phone": "+1-555-123-4567",
    "company": "Example Corp",
    "job_title": "Operations Manager",
    "country": "United States",
    "timezone": "America/New_York",
    "industry": "Healthcare",
    "website": "https://example.com",
    "linkedin": "https://www.linkedin.com/in/johndoe",
    "service_interest": "AI Automation",
    "problem": "Manual reporting takes our team 10 hours per week. Looking to automate data collection and dashboard generation.",
    "budget": "10000-25000",
    "timeline": "Q1 2027",
    "preferred_contact": "email",
    "newsletter_optin": true
  }
}
```

### Field Specifications

#### Required Fields
- `idempotency_key` (string, UUID v4) - Prevents duplicate submissions
- `source` (string) - One of: `website_contact_form`, `website_discovery_form`, `website_audit_request`
- `lead.name` (string, 2-100 chars)
- `lead.email` (string, valid email format)

#### Optional Fields
- `utm_*` (strings, max 255 chars each)
- `page_url` (string, valid URL)
- `referrer` (string, valid URL or null)
- `user_agent` (string, max 500 chars)
- `ip_address` (string, valid IPv4/IPv6)
- `lead.phone` (string, international format preferred)
- `lead.company` (string, max 255 chars)
- `lead.job_title` (string, max 100 chars)
- `lead.country` (string, max 100 chars)
- `lead.timezone` (string, valid timezone identifier)
- `lead.industry` (string, max 100 chars)
- `lead.website` (string, valid URL)
- `lead.linkedin` (string, valid URL)
- `lead.service_interest` (string, max 255 chars)
- `lead.problem` (text, max 2000 chars)
- `lead.budget` (string, one of: `<5000`, `5000-10000`, `10000-25000`, `25000-50000`, `>50000`, `not-disclosed`)
- `lead.timeline` (string, max 100 chars)
- `lead.preferred_contact` (string, one of: `email`, `phone`, `whatsapp`)
- `lead.newsletter_optin` (boolean)

### Validation Rules

#### Email
```php
// Must be valid format
filter_var($email, FILTER_VALIDATE_EMAIL)

// Should not be disposable email
// Block: temp-mail.org, guerrillamail.com, etc.

// Should be business email (preferred, not enforced)
// Warn if: gmail.com, yahoo.com, etc. on high-value forms
```

#### Phone
```php
// International format preferred
// E.164 format: +[country code][number]
// Example: +14155552671

// Accept formats:
// +1-555-123-4567
// +91 98765 43210
// (555) 123-4567 (will normalize)
```

#### Company Domain
```php
// If company provided, optionally extract domain from email
// john@acmecorp.com → "acmecorp.com"
// Use for duplicate detection
```

### Success Response (201 Created)
```json
{
  "success": true,
  "message": "Lead created successfully",
  "data": {
    "lead_id": "550e8400-e29b-41d4-a716-446655440000",
    "status": "new",
    "duplicate": false,
    "owner_assigned": true,
    "owner_name": "Noukhez (Auto-assigned)"
  }
}
```

### Success Response (200 OK - Duplicate Detected)
```json
{
  "success": true,
  "message": "Lead already exists, activity recorded",
  "data": {
    "lead_id": "existing-uuid-here",
    "status": "contacted",
    "duplicate": true,
    "activity_logged": true,
    "last_contact": "2026-09-15T10:30:00Z"
  }
}
```

### Error Responses

#### 400 Bad Request - Validation Error
```json
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Invalid request data",
    "fields": {
      "lead.email": "Invalid email format",
      "lead.name": "Name must be between 2 and 100 characters",
      "idempotency_key": "Must be a valid UUID"
    }
  },
  "request_id": "req_abc123xyz"
}
```

#### 401 Unauthorized
```json
{
  "success": false,
  "error": {
    "code": "UNAUTHORIZED",
    "message": "Invalid or missing API credentials"
  }
}
```

#### 429 Too Many Requests
```json
{
  "success": false,
  "error": {
    "code": "RATE_LIMIT_EXCEEDED",
    "message": "Too many requests from this IP. Try again in 60 seconds.",
    "retry_after": 60
  }
}
```

#### 500 Internal Server Error
```json
{
  "success": false,
  "error": {
    "code": "SERVER_ERROR",
    "message": "An internal error occurred. Please try again later.",
    "request_id": "req_abc123xyz"
  }
}
```

---

## Rate Limiting

### Website → CRM Requests
- **Limit:** 100 requests per minute per IP
- **Burst:** 10 requests per second
- **Response:** 429 status with `Retry-After` header
- **Exemption:** CRM API secret can whitelist website server IP

### Per-Email Rate Limiting
- **Limit:** 3 submissions per email per 24 hours
- **Purpose:** Prevent spam, duplicate submissions
- **Response:** 429 with message "This email has already submitted a request recently"

---

## Idempotency

### How It Works
```php
// Website generates UUID v4
$idempotency_key = uuid_v4();

// Stores in hidden form field or session
<input type="hidden" name="idempotency_key" value="<?= $idempotency_key ?>">

// Sends with request
$data['idempotency_key'] = $idempotency_key;

// CRM checks if this key was already processed
// If yes: return existing response (don't create duplicate)
// If no: process request normally
```

### CRM Implementation
```sql
CREATE TABLE api_idempotency (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idempotency_key VARCHAR(36) UNIQUE NOT NULL,
    response_body TEXT NOT NULL,
    status_code INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_key_created (idempotency_key, created_at)
);

-- Cleanup old keys after 24 hours
DELETE FROM api_idempotency 
WHERE created_at < NOW() - INTERVAL 24 HOUR;
```

---

## Security Measures

### 1. API Key Storage
```php
// Website .env
CRM_API_SECRET=sk_live_abc123xyz789...

// NEVER in JavaScript
// NEVER in HTML
// NEVER in Git
// NEVER in frontend code
```

### 2. Request Signing (Optional Enhancement)
```php
// Website generates signature
$payload = json_encode($data);
$signature = hash_hmac('sha256', $payload, CRM_API_SECRET);

// Sends in header
X-Signature: sha256={$signature}

// CRM verifies signature
$expected = hash_hmac('sha256', $received_payload, CRM_API_SECRET);
if (!hash_equals($expected, $received_signature)) {
    return 401;
}
```

### 3. HTTPS Only
- All API calls MUST use HTTPS
- Reject HTTP requests
- Use SSL certificate verification

### 4. Input Sanitization
```php
// CRM backend
$name = filter_var($input['name'], FILTER_SANITIZE_STRING);
$email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);

// Then validate
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return validation_error('Invalid email');
}
```

### 5. SQL Injection Prevention
```php
// Always use prepared statements
$stmt = $pdo->prepare('INSERT INTO leads (name, email) VALUES (?, ?)');
$stmt->execute([$name, $email]);

// NEVER
$query = "INSERT INTO leads (name) VALUES ('$name')"; // VULNERABLE!
```

---

## Error Handling

### Website PHP Implementation
```php
function sendLeadToCRM($leadData) {
    try {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://crm.codex404solutions.online/api/v1/leads',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . getenv('CRM_API_SECRET'),
                'Content-Type: application/json',
                'X-Request-Source: website',
                'X-Idempotency-Key: ' . $leadData['idempotency_key']
            ],
            CURLOPT_POSTFIELDS => json_encode($leadData),
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => true
        ]);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error) {
            logError('CRM API connection failed: ' . $error);
            return ['success' => false, 'message' => 'Connection error'];
        }
        
        $result = json_decode($response, true);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return $result;
        }
        
        logError('CRM API error: ' . $response);
        return ['success' => false, 'message' => 'Request failed'];
        
    } catch (Exception $e) {
        logError('Exception: ' . $e->getMessage());
        return ['success' => false, 'message' => 'System error'];
    }
}
```

### Timeout Handling
```php
// Set reasonable timeout
CURLOPT_TIMEOUT => 10 // 10 seconds max

// If timeout occurs:
// 1. Log the attempt
// 2. Store lead in local database (fallback)
// 3. Show user a success message (don't confuse them)
// 4. Retry later via cron job
```

### Fallback Strategy
```sql
-- Website database: fallback_leads table
CREATE TABLE fallback_leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idempotency_key VARCHAR(36) UNIQUE,
    lead_data JSON NOT NULL,
    crm_synced BOOLEAN DEFAULT FALSE,
    attempts INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    synced_at TIMESTAMP NULL,
    INDEX idx_synced (crm_synced, attempts)
);
```

```php
// Cron job runs every 5 minutes
// Retries failed submissions
$pendingLeads = getUnsyncedLeads();
foreach ($pendingLeads as $lead) {
    $result = sendLeadToCRM($lead['lead_data']);
    if ($result['success']) {
        markAsSynced($lead['id']);
    } else {
        incrementAttempts($lead['id']);
        if ($lead['attempts'] >= 5) {
            sendAlertEmail('Lead sync failed after 5 attempts');
        }
    }
}
```

---

## Logging

### Website Logs
```php
// Log all CRM API calls
// File: /storage/logs/crm-api.log

[2026-10-06 10:30:45] INFO: Sending lead to CRM
- Email: john@example.com
- Source: website_contact_form
- Idempotency Key: 550e8400-e29b-41d4-a716-446655440000

[2026-10-06 10:30:46] SUCCESS: Lead created
- Lead ID: abc-123-def
- Response Time: 245ms

[2026-10-06 10:35:12] ERROR: CRM API timeout
- Email: jane@example.com
- Stored in fallback_leads table
- Will retry in 5 minutes
```

### CRM Logs
```php
// Log all incoming API requests
// File: /storage/logs/api-incoming.log

[2026-10-06 10:30:46] POST /api/v1/leads
- Source: website
- IP: 203.0.113.42
- Idempotency Key: 550e8400-e29b-41d4-a716-446655440000
- Result: Created (201)
- Lead ID: abc-123-def
- Processing Time: 187ms
```

### DO NOT LOG
- ❌ Full API secret (only last 4 chars: `...xyz`)
- ❌ Passwords
- ❌ Session tokens
- ❌ Credit card numbers (if future payment forms)

---

## Testing

### Test Endpoint
```
POST https://crm-staging.codex404solutions.online/api/v1/leads
```

### Test API Key
```
CRM_API_SECRET_TEST=sk_test_abc123xyz...
```

### Test Cases

#### 1. Valid Lead Creation
```bash
curl -X POST https://crm-staging.codex404solutions.online/api/v1/leads \
  -H "Authorization: Bearer sk_test_abc123" \
  -H "Content-Type: application/json" \
  -d '{
    "idempotency_key": "test-001",
    "source": "website_contact_form",
    "lead": {
      "name": "Test User",
      "email": "test@example.com",
      "company": "Test Corp"
    }
  }'

# Expected: 201 Created
```

#### 2. Duplicate Submission (Same Idempotency Key)
```bash
# Send same request twice
# Expected: 200 OK (returns existing lead)
```

#### 3. Invalid Email
```bash
curl -X POST ... -d '{
  "lead": {"email": "invalid-email"}
}'

# Expected: 400 Bad Request with validation error
```

#### 4. Missing Auth
```bash
curl -X POST ... (no Authorization header)

# Expected: 401 Unauthorized
```

#### 5. Rate Limit
```bash
# Send 101 requests in 60 seconds
# Expected: 429 Too Many Requests on request #101
```

---

## Monitoring

### Alerts
Send email/Slack alert when:
- API error rate > 5% in 5 minutes
- API response time > 3 seconds
- 5+ consecutive failures
- Rate limit triggered > 10 times/hour (possible attack)

### Metrics to Track
```php
// CRM dashboard: API Health
- Total requests (24h, 7d, 30d)
- Success rate
- Average response time
- Error breakdown (400, 401, 429, 500)
- Top sources (website_contact_form, etc.)
- Leads created per day
- Duplicate detection rate
```

---

## Endpoint 2: Newsletter Subscription (Optional)

### URL
```
POST https://crm.codex404solutions.online/api/v1/newsletter/subscribe
```

### Request
```json
{
  "email": "user@example.com",
  "source": "website_footer",
  "tags": ["newsletter", "marketing"]
}
```

### Response (200 OK)
```json
{
  "success": true,
  "message": "Subscribed successfully"
}
```

---

## Endpoint 3: UTM Tracking Pixel (Optional)

### URL
```
GET https://crm.codex404solutions.online/api/v1/track/visit?
  utm_source=linkedin&
  utm_campaign=launch&
  page=/solutions&
  ref=https://linkedin.com
```

### Response
```
1x1 transparent GIF
```

### Purpose
Track website visits in CRM for attribution

---

## Webhooks (Future: CRM → Website)

### Use Case
Notify website when lead status changes

### Example: Lead Qualified
```
POST https://codex404solutions.online/webhooks/crm/lead-status
Authorization: Bearer {WEBSITE_WEBHOOK_SECRET}

{
  "event": "lead.qualified",
  "lead_id": "abc-123",
  "email": "john@example.com",
  "timestamp": "2026-10-06T10:30:00Z"
}
```

### Website Action
- Send automated email sequence
- Update Google Ads conversion tracking
- Trigger marketing automation

**Note:** Implement webhooks in Phase 2 (not MVP)

---

## Performance Targets

### Response Time
- **p50:** < 200ms
- **p95:** < 500ms
- **p99:** < 1000ms

### Availability
- **Target:** 99.5% uptime (43 minutes downtime/month)
- **Acceptable:** 99% uptime (7 hours downtime/month)

### Throughput
- **Target:** 100 requests/minute sustained
- **Peak:** 500 requests/minute (launch day, campaigns)

---

## Rollback Plan

### If CRM API Fails
```php
// Website detects repeated failures
if (getCRMFailureRate() > 0.5) { // 50% failure rate
    // Activate fallback mode
    activateFallbackMode();
    
    // Store all leads locally
    // Show success to users
    // Alert admin
    sendAlert('CRM API degraded - fallback mode active');
    
    // Retry every 5 minutes
    // Restore when CRM healthy
}
```

---

## Migration & Versioning

### API Version
Current: `v1`

### Future Versions
When breaking changes needed:
- Create `/api/v2/leads`
- Support v1 for 6 months
- Notify website admin
- Update website code
- Deprecate v1

### Backward Compatibility
- Add new optional fields anytime
- Never remove required fields
- Never change field types
- Never change error codes
- Document all changes

---

## Security Checklist

Before going live, verify:

- [ ] API secret is 32+ random characters
- [ ] API secret stored in `.env` only
- [ ] HTTPS enforced (no HTTP)
- [ ] CORS configured (only allow website domain)
- [ ] Rate limiting active
- [ ] Input validation active
- [ ] Output sanitization active
- [ ] SQL injection prevention (prepared statements)
- [ ] XSS prevention (htmlspecialchars)
- [ ] CSRF not needed (API, not session-based)
- [ ] Error messages don't leak sensitive info
- [ ] Logs don't contain secrets
- [ ] API monitoring active
- [ ] Alerts configured
- [ ] Backup strategy active

---

## Quick Reference

### Website Environment Variables
```env
CRM_API_URL=https://crm.codex404solutions.online/api/v1
CRM_API_SECRET=sk_live_abc123xyz...
CRM_API_TIMEOUT=10
```

### CRM Environment Variables
```env
WEBSITE_API_KEY=sk_live_abc123xyz...
ALLOWED_ORIGINS=https://codex404solutions.online
RATE_LIMIT_PER_MINUTE=100
```

### Common HTTP Status Codes
- `200` - OK (duplicate detected)
- `201` - Created (new lead)
- `400` - Validation error
- `401` - Unauthorized
- `429` - Rate limited
- `500` - Server error

---

## Contact

If API integration issues occur:
- Check `/storage/logs/api-incoming.log` on CRM
- Check `/storage/logs/crm-api.log` on website
- Review this document
- Test with staging endpoint first

---

**Last Updated:** October 2026  
**Version:** 1.0  
**Status:** Production Ready
