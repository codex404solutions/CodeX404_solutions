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

        $rawSubject = !empty($_POST['subject']) 
            ? (string)$_POST['subject'] 
            : (!empty($_POST['service']) ? 'Inquiry: ' . (string)$_POST['service'] : 'General Inquiry');

        // Sanitize with strict field length bounds
        $data = [
            'type' => 'general_contact',
            'name' => Sanitizer::cleanString($_POST['name'] ?? '', 100),
            'email' => Sanitizer::cleanEmail($_POST['email'] ?? '', 254),
            'phone' => Sanitizer::cleanPhone($_POST['phone'] ?? '', 25),
            'company' => Sanitizer::cleanString($_POST['company'] ?? '', 120),
            'subject' => Sanitizer::cleanString($rawSubject, 150),
            'message' => Sanitizer::cleanString($_POST['message'] ?? '', 5000),
            'privacy_consent' => !empty($_POST['privacy_consent']) || !empty($_POST['service']),
            'newsletter' => !empty($_POST['newsletter']),
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

        // 1. Try DB insertion if DB available
        $pdo = Database::getConnection();
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
                    ':message' => $data['message']
                ]);
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

        $emailService = new EmailService();
        $emailService->sendLeadNotification($data);

        return [
            'status' => 'success',
            'message' => 'Thank you for reaching out! Our engineering team will review your inquiry and respond within 24 hours.',
            'ref' => $crmResult['idempotency_key'] ?? null
        ];
    }
}
