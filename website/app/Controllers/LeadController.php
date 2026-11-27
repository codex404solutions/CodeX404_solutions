<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Validators\FormValidator;
use App\Services\CRMIntegrationService;
use App\Services\EmailService;
use App\Helpers\Sanitizer;
use Database;

class LeadController
{
    private static function normalizeWebsiteUrl(string $rawUrl): string
    {
        $trimmed = trim($rawUrl);
        if ($trimmed === '') {
            return '';
        }
        if (!str_contains($trimmed, '://') && preg_match('/^[a-z0-9.-]+\.[a-z]{2,}(\/.*)?$/i', $trimmed)) {
            return 'https://' . $trimmed;
        }
        return $trimmed;
    }

    public function handleDiscovery(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['status' => 'error', 'message' => 'Invalid request method.'];
        }

        // Rate limiting
        if (!check_rate_limit('discovery_submit', 12, 60)) {
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
            'website' => self::normalizeWebsiteUrl(Sanitizer::cleanString($_POST['website'] ?? '', 255)),
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

        $referenceCode = 'lead_' . bin2hex(random_bytes(16));
        $data['reference_code'] = $referenceCode;
        $data['service_interest'] = FormValidator::serviceLabel($data['division'], $data['service_interest']);
        $data['budget'] = FormValidator::budgetLabel($data['budget']);
        $data['timeline'] = FormValidator::timelineLabel($data['timeline']);

        $clientIp = function_exists('get_client_ip')
            ? substr((string) get_client_ip(), 0, 50)
            : substr((string) ($_SERVER['REMOTE_ADDR'] ?? ''), 0, 50);

        $subject = $data['division'] . ': Discovery Call' . ($data['service_interest'] !== '' ? ' — ' . $data['service_interest'] : '');

        // 1. Persist Discovery Call request to MySQL contact_messages
        $pdo = Database::getConnection();
        $dbSaved = false;
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO `contact_messages` (
                        `type`, `reference_code`, `inquiry_category`, `division`,
                        `service_interest`, `partner_role`, `name`, `email`, `phone`,
                        `company`, `country`, `website`, `budget`, `timeline`,
                        `subject`, `message`, `ip_address`, `status`, `created_at`
                    ) VALUES (
                        'discovery_call', :reference_code, 'discovery', :division,
                        :service_interest, :partner_role, :name, :email, :phone,
                        :company, :country, :website, :budget, :timeline,
                        :subject, :message, :ip_address, 'new', NOW()
                    )
                ");
                $stmt->execute([
                    ':reference_code'   => $referenceCode,
                    ':division'         => $data['division'] !== '' ? $data['division'] : null,
                    ':service_interest' => $data['service_interest'] !== '' ? $data['service_interest'] : null,
                    ':partner_role'     => $data['job_title'] !== '' ? $data['job_title'] : null,
                    ':name'             => $data['name'],
                    ':email'            => $data['email'],
                    ':phone'            => $data['phone'] !== '' ? $data['phone'] : null,
                    ':company'          => $data['company'] !== '' ? $data['company'] : null,
                    ':country'          => $data['country'] !== '' ? $data['country'] : null,
                    ':website'          => $data['website'] !== '' ? $data['website'] : null,
                    ':budget'           => $data['budget'] !== '' ? $data['budget'] : null,
                    ':timeline'         => $data['timeline'] !== '' ? $data['timeline'] : null,
                    ':subject'          => substr($subject, 0, 255),
                    ':message'          => $data['problem_description'],
                    ':ip_address'       => $clientIp !== '' ? $clientIp : null,
                ]);
                $dbSaved = true;
            } catch (\Throwable $e) {
                @file_put_contents(
                    LOGS_PATH . '/app.log',
                    "[" . date('c') . "] Discovery DB insert skipped: code " . $e->getCode() . PHP_EOL,
                    FILE_APPEND | LOCK_EX
                );
            }
        }

        // 2. Dispatch backup JSON & optional outbound webhook + Email notification
        $crmService = new CRMIntegrationService();
        $crmResult = $crmService->dispatchLead($data);

        if (($crmResult['status'] ?? '') === 'unavailable' && !$dbSaved) {
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
            'ref' => $referenceCode,
            'crm_sync' => $crmResult['status'] ?? 'stored_locally'
        ];
    }
}
