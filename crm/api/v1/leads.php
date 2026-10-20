<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Inbound Leads API Endpoint
 * Authenticates webhook requests from the main website and ingests leads.
 * Fail-closed: requires HTTPS, HMAC signature, rate limiting, and valid idempotency key.
 */

namespace CRM;

use CRM\Services\StorageService;
use CRM\Services\LeadService;
use CRM\Services\OpportunityService;
use CRM\Services\PaperclipService;
use CRM\Services\ApprovalService;

$crmRoot = dirname(__DIR__, 2);
require_once $crmRoot . '/config/config.php';
require_once $crmRoot . '/app/Services/StorageService.php';
require_once $crmRoot . '/app/Services/LeadService.php';
require_once $crmRoot . '/app/Services/OpportunityService.php';
require_once $crmRoot . '/app/Services/PaperclipService.php';
require_once $crmRoot . '/app/Services/ApprovalService.php';

StorageService::init($crmRoot . '/storage');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
    exit;
}

// 1. IP Allowlisting (Optional - if CRM_WEBHOOK_ALLOWED_IPS configured)
$allowedIpsConfig = defined('CRM_WEBHOOK_ALLOWED_IPS') ? CRM_WEBHOOK_ALLOWED_IPS : (getenv('CRM_WEBHOOK_ALLOWED_IPS') ?: '');
if ($allowedIpsConfig !== '') {
    $allowedList = array_map('trim', explode(',', $allowedIpsConfig));
    $clientIp = $_SERVER['REMOTE_ADDR'] ?? '';
    $isAllowed = in_array($clientIp, $allowedList, true) || in_array($clientIp, ['127.0.0.1', '::1'], true);

    if (!$isAllowed) {
        http_response_code(403);
        echo json_encode(['status' => 'error', 'message' => 'Forbidden: Source IP is not authorized to submit webhook events.']);
        exit;
    }
}

// 2. Stricter Request Size Cap (32 KB maximum for JSON lead payload)
$maxBytes = 32768;
if (isset($_SERVER['CONTENT_LENGTH']) && (int)$_SERVER['CONTENT_LENGTH'] > $maxBytes) {
    http_response_code(413);
    echo json_encode(['status' => 'error', 'message' => 'Payload too large. Maximum permitted size is 32 KB.']);
    exit;
}

$rawInput = file_get_contents('php://input');
if (!$rawInput || strlen($rawInput) > $maxBytes) {
    http_response_code(strlen($rawInput) > $maxBytes ? 413 : 400);
    echo json_encode(['status' => 'error', 'message' => strlen($rawInput) > $maxBytes ? 'Payload exceeds 32 KB limit.' : 'Empty request body.']);
    exit;
}

// 3. Signature Verification (HMAC SHA-256) — fail closed, no fallback secret
$crmSecret = (defined('CRM_WEBHOOK_SECRET') && CRM_WEBHOOK_SECRET !== '') ? CRM_WEBHOOK_SECRET : (getenv('CRM_WEBHOOK_SECRET') ?: '');
$signature = $_SERVER['HTTP_X_CODEX404_SIGNATURE'] ?? '';

if ($crmSecret === '') {
    http_response_code(503);
    echo json_encode(['status' => 'error', 'message' => 'CRM webhook secret not configured.']);
    exit;
}

if ($signature === '') {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Missing HMAC signature.']);
    exit;
}

$expected = hash_hmac('sha256', $rawInput, $crmSecret);
if (!hash_equals($expected, $signature)) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Invalid HMAC signature.']);
    exit;
}

// Parse JSON payload
$payload = json_decode($rawInput, true);
if (!is_array($payload)) {
    http_response_code(422);
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON payload.']);
    exit;
}

// 4. Request Timestamp Validation (Replay Attack Prevention)
// Accepted via header X-CodeX404-Timestamp or within payload 'timestamp'
$rawTimestamp = $_SERVER['HTTP_X_CODEX404_TIMESTAMP'] ?? ($payload['timestamp'] ?? null);
if ($rawTimestamp === null || $rawTimestamp === '') {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Missing request timestamp for replay verification.']);
    exit;
}

$parsedTime = is_numeric($rawTimestamp) ? (int)$rawTimestamp : strtotime((string)$rawTimestamp);
if ($parsedTime === false || $parsedTime <= 0) {
    http_response_code(422);
    echo json_encode(['status' => 'error', 'message' => 'Invalid request timestamp format.']);
    exit;
}

// 5-minute replay window tolerance
$currentTime = time();
$driftSeconds = abs($currentTime - $parsedTime);
if ($driftSeconds > 300) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Request timestamp expired or outside allowable clock tolerance window (replay attack prevention).'
    ]);
    exit;
}

$leadData = $payload['lead'] ?? $payload;

if (!is_array($leadData) || empty($leadData['email'])) {
    http_response_code(422);
    echo json_encode(['status' => 'error', 'message' => 'Valid lead email is required.']);
    exit;
}

// 5. Stricter Lead Field Validation & Length Restrictions
$email = trim((string)$leadData['email']);
if (strlen($email) > 254 || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    http_response_code(422);
    echo json_encode(['status' => 'error', 'message' => 'Provided lead email does not match valid RFC format.']);
    exit;
}

// Cap incoming string field lengths to prevent resource exhaustion
$leadData['email'] = $email;
if (isset($leadData['name'])) {
    $leadData['name'] = mb_substr(trim((string)$leadData['name']), 0, 100);
}
if (isset($leadData['company_name'])) {
    $leadData['company_name'] = mb_substr(trim((string)$leadData['company_name']), 0, 120);
}
if (isset($leadData['company'])) {
    $leadData['company'] = mb_substr(trim((string)$leadData['company']), 0, 120);
}
if (isset($leadData['problem_description'])) {
    $leadData['problem_description'] = mb_substr(trim((string)$leadData['problem_description']), 0, 5000);
}

// 6. Idempotency key validation
$idempotencyKey = $payload['idempotency_key'] ?? '';
if ($idempotencyKey === '' || !preg_match('/^[a-z0-9_]{10,64}$/i', $idempotencyKey)) {
    http_response_code(422);
    echo json_encode(['status' => 'error', 'message' => 'Invalid or missing idempotency key.']);
    exit;
}

// Check if already processed
$existing = StorageService::findByField('leads', 'idempotency_key', $idempotencyKey);
if ($existing !== null) {
    // Already processed; return existing lead info (idempotent success)
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Duplicate lead received; already recorded.',
        'lead_id' => $existing['id'] ?? null,
        'duplicate' => true
    ]);
    exit;
}

// 7. Ingest Lead into CRM
$lead = LeadService::createLead($leadData);
$lead['idempotency_key'] = $idempotencyKey; // store for future deduplication
StorageService::update('leads', $lead['id'], ['idempotency_key' => $idempotencyKey]);

// 8. Create a Sales Opportunity automatically
$opportunity = OpportunityService::createFromLead($lead);

// 9. Dispatch task to Paperclip Agent Runtime
$paperclipResult = PaperclipService::createLeadTask($lead);

// 10. Stage an Email Draft in the Approval Queue (DO NOT SEND AUTOMATICALLY)
$draftSubject = "Quick observations on " . (!empty($lead['company_name']) ? $lead['company_name'] : 'your') . "'s website architecture";
$draftBody = "Hi " . htmlspecialchars($lead['name'] ?: 'there') . ",\n\n"
    . "Thanks for reaching out to CodeX404 Solutions regarding your project.\n\n"
    . "I reviewed your requirements: \"" . htmlspecialchars(substr($lead['problem_description'] ?? '', 0, 150)) . "...\"\n\n"
    . "We've built similar systems and would be glad to walk through an architecture roadmap.\n\n"
    . "Would 15 minutes this Thursday work for an initial technical alignment?\n\n"
    . "Best,\nMuhammad Noukhez\nFounder & CEO, CodeX404 Solutions";

ApprovalService::submit('email_draft', "Discovery Followup: {$lead['email']}", [
    'to' => $lead['email'],
    'subject' => $draftSubject,
    'body' => $draftBody,
    'lead_id' => $lead['id']
], 'Growth Marketer Agent');

// 11. Return response
http_response_code(201);
echo json_encode([
    'status' => 'success',
    'lead_id' => $lead['id'],
    'opportunity_id' => $opportunity['id'],
    'paperclip' => $paperclipResult,
    'approval_staged' => true,
    'message' => 'Lead processed into CRM, Opportunity opened, and Email Draft staged for approval.'
]);