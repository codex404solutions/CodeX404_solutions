<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Validators\FormValidator;
use App\Services\CRMIntegrationService;
use App\Services\EmailService;
use App\Helpers\Sanitizer;
use Database;

class ContactController
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

    public function handle(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['status' => 'error', 'message' => 'Invalid request method.'];
        }

        // Rate limiting check (12 submissions/minute protects against floods while allowing multi-category & retry flows)
        if (!check_rate_limit('contact_submit', 12, 60)) {
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
        $rawCategory = $_POST['inquiry_category'] ?? null;
        if ($rawCategory === null || trim((string) $rawCategory) === '') {
            // Default to 'general' when category omitted (e.g., Chatbot quick lead), or 'project' if division is specified
            $category = $division !== '' ? 'project' : 'general';
        } else {
            $category = strtolower(Sanitizer::cleanString((string) $rawCategory, 30));
        }

        if (!array_key_exists($category, FormValidator::contactCategories())) {
            $category = 'project';
        }
        $categoryLabel = FormValidator::categoryLabel($category);

        $serviceCode = Sanitizer::cleanString($_POST['service'] ?? '', 80);
        $serviceLabel = $division !== '' ? FormValidator::serviceLabel($division, $serviceCode) : '';
        $partnershipType = Sanitizer::cleanString($_POST['partnership_type'] ?? '', 50);
        $partnerRole = Sanitizer::cleanString($_POST['partner_role'] ?? '', 100);
        $engagementModel = Sanitizer::cleanString($_POST['engagement_model'] ?? '', 50);
        $inquiryArea = Sanitizer::cleanString($_POST['inquiry_area'] ?? '', 50);
        $website = self::normalizeWebsiteUrl(Sanitizer::cleanString($_POST['website'] ?? '', 255));

        $rawSubject = Sanitizer::cleanString($_POST['subject'] ?? '', 120);
        if ($rawSubject === '') {
            $rawSubject = $serviceLabel !== '' ? $serviceLabel : $categoryLabel;
        }
        if ($division !== '') {
            $rawSubject = $division . ': ' . $rawSubject;
        } elseif ($category !== 'project' && stripos($rawSubject, $categoryLabel) === false) {
            $rawSubject = $categoryLabel . ': ' . $rawSubject;
        }

        // Sanitize with strict field length bounds
        $data = [
            'type' => 'general_contact',
            'inquiry_category' => $category,
            'name' => Sanitizer::cleanString($_POST['name'] ?? '', 100),
            'email' => Sanitizer::cleanEmail($_POST['email'] ?? '', 254),
            'phone' => Sanitizer::cleanPhone($_POST['phone'] ?? '', 25),
            'company' => Sanitizer::cleanString($_POST['company'] ?? '', 120),
            'country' => Sanitizer::cleanString($_POST['country'] ?? '', 100),
            'website' => $website,
            'division' => $division,
            'service' => $serviceCode,
            'partnership_type' => $partnershipType,
            'partner_role' => $partnerRole,
            'engagement_model' => $engagementModel,
            'inquiry_area' => $inquiryArea,
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

        $referenceCode = 'lead_' . bin2hex(random_bytes(16));
        $data['reference_code'] = $referenceCode;
        $data['inquiry_category'] = $categoryLabel;
        $data['service'] = $data['division'] !== '' ? FormValidator::serviceLabel($data['division'], $data['service']) : '';
        $data['partnership_type'] = FormValidator::partnershipTypeLabel($data['partnership_type']);
        $data['engagement_model'] = FormValidator::engagementModelLabel($data['engagement_model']);
        $data['inquiry_area'] = FormValidator::generalInquiryAreaLabel($data['inquiry_area']);
        $data['budget'] = FormValidator::budgetLabel($data['budget']);
        $data['timeline'] = FormValidator::timelineLabel($data['timeline']);

        $clientIp = function_exists('get_client_ip')
            ? substr((string) get_client_ip(), 0, 50)
            : substr((string) ($_SERVER['REMOTE_ADDR'] ?? ''), 0, 50);

        // 1. Persist structured record in MySQL contact_messages
        $pdo = Database::getConnection();
        $dbSaved = false;
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO `contact_messages` (
                        `type`, `reference_code`, `inquiry_category`, `division`,
                        `service_interest`, `engagement_model`, `partnership_type`, `partner_role`,
                        `inquiry_area`, `name`, `email`, `phone`, `company`, `country`, `website`,
                        `budget`, `timeline`, `subject`, `message`, `ip_address`, `status`, `created_at`
                    ) VALUES (
                        :type, :reference_code, :inquiry_category, :division,
                        :service_interest, :engagement_model, :partnership_type, :partner_role,
                        :inquiry_area, :name, :email, :phone, :company, :country, :website,
                        :budget, :timeline, :subject, :message, :ip_address, 'new', NOW()
                    )
                ");
                $stmt->execute([
                    ':type'             => 'general_contact',
                    ':reference_code'   => $referenceCode,
                    ':inquiry_category' => $category,
                    ':division'         => $data['division'] !== '' ? $data['division'] : null,
                    ':service_interest' => $data['service'] !== '' ? $data['service'] : null,
                    ':engagement_model' => $data['engagement_model'] !== '' ? $data['engagement_model'] : null,
                    ':partnership_type' => $data['partnership_type'] !== '' ? $data['partnership_type'] : null,
                    ':partner_role'     => $data['partner_role'] !== '' ? $data['partner_role'] : null,
                    ':inquiry_area'     => $data['inquiry_area'] !== '' ? $data['inquiry_area'] : null,
                    ':name'             => $data['name'],
                    ':email'            => $data['email'],
                    ':phone'            => $data['phone'] !== '' ? $data['phone'] : null,
                    ':company'          => $data['company'] !== '' ? $data['company'] : null,
                    ':country'          => $data['country'] !== '' ? $data['country'] : null,
                    ':website'          => $data['website'] !== '' ? $data['website'] : null,
                    ':budget'           => $data['budget'] !== '' ? $data['budget'] : null,
                    ':timeline'         => $data['timeline'] !== '' ? $data['timeline'] : null,
                    ':subject'          => $data['subject'],
                    ':message'          => $data['message'],
                    ':ip_address'       => $clientIp !== '' ? $clientIp : null,
                ]);
                $dbSaved = true;
            } catch (\Throwable $e) {
                @file_put_contents(
                    LOGS_PATH . '/app.log',
                    "[" . date('c') . "] Contact DB insert skipped: code " . $e->getCode() . PHP_EOL,
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
                'message' => 'We could not save your inquiry. Please email ' . COMPANY_EMAIL . ' directly.'
            ];
        }

        $emailService = new EmailService();
        $emailService->sendLeadNotification($data);

        return [
            'status' => 'success',
            'message' => 'Thank you for reaching out. Your ' . $categoryLabel . ' has been saved for follow-up. If you need to add details, email ' . COMPANY_EMAIL . '.',
            'ref' => $referenceCode
        ];
    }
}
