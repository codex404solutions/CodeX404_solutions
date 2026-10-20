<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Validators\FormValidator;
use App\Services\CRMIntegrationService;
use App\Services\EmailService;
use App\Helpers\Sanitizer;

class LeadController {
    public function handleDiscovery(): array {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['status' => 'error', 'message' => 'Invalid request method.'];
        }

        // Rate limiting
        if (!check_rate_limit('discovery_submit', 5, 60)) {
            return [
                'status' => 'error',
                'message' => 'Too many requests. Please wait a minute before submitting again.'
            ];
        }

        // CSRF verification
        $token = $_POST['csrf_token'] ?? '';
        if (!verify_csrf_token($token)) {
            return [
                'status' => 'error',
                'message' => 'Security token invalid or expired. Please refresh the page.'
            ];
        }

        // Sanitize with strict field length bounds
        $data = [
            'type' => 'discovery_call',
            'name' => Sanitizer::cleanString($_POST['name'] ?? '', 100),
            'email' => Sanitizer::cleanEmail($_POST['email'] ?? '', 254),
            'phone' => Sanitizer::cleanPhone($_POST['phone'] ?? '', 25),
            'company' => Sanitizer::cleanString($_POST['company'] ?? '', 120),
            'country' => Sanitizer::cleanString($_POST['country'] ?? 'Global', 100),
            'job_title' => Sanitizer::cleanString($_POST['job_title'] ?? '', 100),
            'service_interest' => Sanitizer::cleanString($_POST['service_interest'] ?? '', 100),
            'budget' => Sanitizer::cleanString($_POST['budget'] ?? 'Flexible', 50),
            'timeline' => Sanitizer::cleanString($_POST['timeline'] ?? '1-3 months', 50),
            'problem_description' => Sanitizer::cleanString($_POST['problem_description'] ?? '', 5000),
            'privacy_consent' => !empty($_POST['privacy_consent']),
            '_gotcha' => Sanitizer::cleanString($_POST['_gotcha'] ?? '', 100)
        ];

        // Validate
        $validator = new FormValidator();
        if (!$validator->validateDiscovery($data)) {
            return [
                'status' => 'error',
                'message' => 'Please provide the required project and contact information.',
                'errors' => $validator->getErrors()
            ];
        }

        // Dispatch
        $crmService = new CRMIntegrationService();
        $crmResult = $crmService->dispatchLead($data);

        $emailService = new EmailService();
        $emailService->sendLeadNotification($data);

        $crmStatus = $crmResult['status'] ?? 'stored_locally';
        $crmMessage = $crmStatus === 'synced'
            ? 'Discovery Call request confirmed and synced to CRM. A Solutions Architect will review your requirements and coordinate a meeting schedule.'
            : 'Discovery Call request confirmed and saved locally for CRM follow-up.';

        return [
            'status' => 'success',
            'message' => $crmMessage,
            'ref' => $crmResult['idempotency_key'] ?? null,
            'crm_sync' => $crmStatus
        ];
    }
}