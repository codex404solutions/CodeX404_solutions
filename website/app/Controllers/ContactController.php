<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Validators\FormValidator;
use App\Services\CRMIntegrationService;
use App\Services\EmailService;
use App\Helpers\Sanitizer;
use Database;

class ContactController {
    public function handle(): array {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['status' => 'error', 'message' => 'Invalid request method.'];
        }

        // Rate limiting check
        if (!check_rate_limit('contact_submit', 5, 60)) {
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

        $division = strtoupper(Sanitizer::cleanString($_POST['division'] ?? '', 20));
        $serviceCode = Sanitizer::cleanString($_POST['service'] ?? '', 80);
        $serviceLabel = FormValidator::serviceLabel($division, $serviceCode);
        $rawSubject = Sanitizer::cleanString($_POST['subject'] ?? '', 120);
        if ($rawSubject === '') {
            $rawSubject = $serviceLabel !== '' ? $serviceLabel : 'General Inquiry';
        }
        if ($division !== '') {
            $rawSubject = $division . ': ' . $rawSubject;
        }

        // Sanitize with strict field length bounds
        $data = [
            'type' => 'general_contact',
            'name' => Sanitizer::cleanString($_POST['name'] ?? '', 100),
            'email' => Sanitizer::cleanEmail($_POST['email'] ?? '', 254),
            'phone' => Sanitizer::cleanPhone($_POST['phone'] ?? '', 25),
            'company' => Sanitizer::cleanString($_POST['company'] ?? '', 120),
            'country' => Sanitizer::cleanString($_POST['country'] ?? '', 100),
            'website' => Sanitizer::cleanString($_POST['website'] ?? '', 255),
            'division' => $division,
            'service' => $serviceCode,
            'budget' => Sanitizer::cleanString($_POST['budget'] ?? '', 30),
            'timeline' => Sanitizer::cleanString($_POST['timeline'] ?? '', 30),
            'subject' => Sanitizer::cleanString($rawSubject, 150),
            'message' => Sanitizer::cleanString($_POST['message'] ?? '', 5000),
            'privacy_consent' => ($_POST['privacy_consent'] ?? null) === '1',
            '_gotcha' => Sanitizer::cleanString($_POST['_gotcha'] ?? '', 100)
        ];

        // Validate
        $validator = new FormValidator();
        if (!$validator->validateContact($data)) {
            return [
                'status' => 'error', 
                'message' => 'Please correct the highlighted form errors.',
                'errors' => $validator->getErrors()
            ];
        }

        $data['service'] = FormValidator::serviceLabel($data['division'], $data['service']);
        $data['budget'] = FormValidator::budgetLabel($data['budget']);
        $data['timeline'] = FormValidator::timelineLabel($data['timeline']);

        $messageLines = ['Project details: ' . $data['message']];
        foreach ([
            'Company' => $data['company'],
            'Phone' => $data['phone'],
            'Country' => $data['country'],
            'Website' => $data['website'],
            'Service' => $data['service'],
            'Budget' => $data['budget'],
            'Timeline' => $data['timeline'],
        ] as $label => $value) {
            if ($value !== '') {
                $messageLines[] = $label . ': ' . $value;
            }
        }
        $persistedMessage = implode("\n", $messageLines);

        // 1. Try DB insertion if DB available
        $pdo = Database::getConnection();
        $dbSaved = false;
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO contact_messages (name, email, subject, message, created_at)
                    VALUES (:name, :email, :subject, :message, NOW())
                ");
                $stmt->execute([
                    ':name' => $data['name'],
                    ':email' => $data['email'],
                    ':subject' => $data['subject'],
                    ':message' => $persistedMessage
                ]);
                $dbSaved = true;
            } catch (\Throwable $e) {
                // Non-fatal, fallback to file storage; log code only to avoid information leakage
                @file_put_contents(
                    LOGS_PATH . '/app.log',
                    "[" . date('c') . "] Contact DB insert skipped: code " . $e->getCode() . PHP_EOL,
                    FILE_APPEND | LOCK_EX
                );
            }
        }

        // 2. Dispatch to CRM & Email services
        $crmService = new CRMIntegrationService();
        $crmResult = $crmService->dispatchLead($data);

        if (($crmResult['status'] ?? '') === 'unavailable' && !$dbSaved) {
            return [
                'status' => 'error',
                'message' => 'We could not save your inquiry. Please email ' . COMPANY_EMAIL . ' directly.'
            ];
        }

        $emailService = new EmailService();
        $emailService->sendLeadNotification($data);

        return [
            'status' => 'success',
            'message' => 'Thank you for reaching out. Your inquiry has been saved for follow-up. If you need to add details, email ' . COMPANY_EMAIL . '.',
            'ref' => $crmResult['idempotency_key'] ?? null
        ];
    }
}
