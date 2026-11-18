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
            'division' => strtoupper(Sanitizer::cleanString($_POST['division'] ?? '', 20)),
            'country' => Sanitizer::cleanString($_POST['country'] ?? '', 100),
            'website' => Sanitizer::cleanString($_POST['website'] ?? '', 255),
            'job_title' => Sanitizer::cleanString($_POST['job_title'] ?? '', 100),
            'service_interest' => Sanitizer::cleanString($_POST['service_interest'] ?? '', 100),
            'budget' => Sanitizer::cleanString($_POST['budget'] ?? '', 50),
            'timeline' => Sanitizer::cleanString($_POST['timeline'] ?? '', 50),
            'problem_description' => Sanitizer::cleanString($_POST['problem_description'] ?? '', 5000),
            'privacy_consent' => ($_POST['privacy_consent'] ?? null) === '1',
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

        $data['service_interest'] = FormValidator::serviceLabel($data['division'], $data['service_interest']);
        $data['budget'] = FormValidator::budgetLabel($data['budget']);
        $data['timeline'] = FormValidator::timelineLabel($data['timeline']);

        // Dispatch
        $crmService = new CRMIntegrationService();
        $crmResult = $crmService->dispatchLead($data);

        if (($crmResult['status'] ?? '') === 'unavailable') {
            return [
                'status' => 'error',
                'message' => 'We could not save your request. Please email ' . COMPANY_EMAIL . ' directly.'
            ];
        }

        $emailService = new EmailService();
        $emailService->sendLeadNotification($data);

        return [
            'status' => 'success',
            'message' => 'Your Discovery Call request has been saved for follow-up. We’ll contact you by email to coordinate next steps.',
            'ref' => $crmResult['idempotency_key'] ?? null,
            'crm_sync' => $crmResult['status'] ?? 'stored_locally'
        ];
    }
}
