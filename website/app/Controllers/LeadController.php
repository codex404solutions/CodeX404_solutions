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

        // Sanitize
        $data = [
            'type' => 'discovery_call',
            'name' => Sanitizer::cleanString($_POST['name'] ?? ''),
            'email' => Sanitizer::cleanEmail($_POST['email'] ?? ''),
            'phone' => Sanitizer::cleanPhone($_POST['phone'] ?? ''),
            'company' => Sanitizer::cleanString($_POST['company'] ?? ''),
            'country' => Sanitizer::cleanString($_POST['country'] ?? 'Global'),
            'job_title' => Sanitizer::cleanString($_POST['job_title'] ?? ''),
            'service_interest' => Sanitizer::cleanString($_POST['service_interest'] ?? ''),
            'budget' => Sanitizer::cleanString($_POST['budget'] ?? 'Flexible'),
            'timeline' => Sanitizer::cleanString($_POST['timeline'] ?? '1-3 months'),
            'problem_description' => Sanitizer::cleanString($_POST['problem_description'] ?? ''),
            'privacy_consent' => !empty($_POST['privacy_consent']),
            '_gotcha' => $_POST['_gotcha'] ?? ''
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

        return [
            'status' => 'success',
            'message' => 'Discovery Call request confirmed! A Solutions Architect will review your requirements and coordinate a meeting schedule.',
            'ref' => $crmResult['idempotency_key'] ?? null
        ];
    }
}
