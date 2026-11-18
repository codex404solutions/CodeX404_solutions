<?php
declare(strict_types=1);

namespace App\Validators;

class FormValidator {
    private array $errors = [];

    /** @return array<string, array<string, string>> */
    public static function serviceOptions(): array {
        return [
            'BUILD' => [
                'web_platform' => 'Websites and custom web platforms',
                'saas_mvp' => 'SaaS products and MVPs',
                'mobile_pwa' => 'Mobile applications and progressive web apps',
                'other' => 'Another BUILD requirement',
            ],
            'GROW' => [
                'search_visibility' => 'Search visibility (SEO, AEO, GEO, or local search)',
                'digital_marketing' => 'Digital marketing and campaigns',
                'content_brand' => 'Content and brand growth',
                'conversion_measurement' => 'Conversion and measurement',
                'other' => 'Another GROW requirement',
            ],
            'AUTOMATE' => [
                'ai_knowledge' => 'AI assistants and knowledge tools',
                'ai_agents' => 'AI agents and tool-using workflows',
                'workflow_integrations' => 'Workflow and system integrations',
                'other' => 'Another AUTOMATE requirement',
            ],
        ];
    }

    public static function serviceLabel(string $division, string $service): string {
        $division = strtoupper(trim($division));
        return self::serviceOptions()[$division][$service] ?? '';
    }

    public static function budgetLabel(string $budget): string {
        return [
            '' => '',
            'under_5k' => 'Under $5,000',
            '5k_15k' => '$5,000–$15,000',
            '15k_50k' => '$15,000–$50,000',
            '50k_plus' => '$50,000+',
            'flexible' => 'Flexible / need guidance',
        ][$budget] ?? '';
    }

    public static function timelineLabel(string $timeline): string {
        return [
            '' => '',
            'under_1_month' => 'Under 1 month',
            '1_3_months' => '1–3 months',
            '3_6_months' => '3–6 months',
            'exploratory' => 'Exploratory / planning',
        ][$timeline] ?? '';
    }

    private function validateServiceForDivision(string $division, string $service, bool $required, string $field): void {
        if ($service === '') {
            if ($required) {
                $this->errors[$field] = 'Please select a service within your chosen division.';
            }
            return;
        }

        if (self::serviceLabel($division, $service) === '') {
            $this->errors[$field] = 'Please select a service that matches your chosen division.';
        }
    }

    private function validateProjectContext(array $data): void {
        $country = trim((string)($data['country'] ?? ''));
        if (mb_strlen($country, 'UTF-8') > 100) {
            $this->errors['country'] = 'Country cannot exceed 100 characters.';
        }

        $website = trim((string)($data['website'] ?? ''));
        if ($website !== '') {
            $parts = parse_url($website);
            if (mb_strlen($website, 'UTF-8') > 255 || !is_array($parts) || !in_array(strtolower((string)($parts['scheme'] ?? '')), ['http', 'https'], true) || empty($parts['host']) || filter_var($website, FILTER_VALIDATE_URL) === false) {
                $this->errors['website'] = 'Please enter a valid website URL beginning with http:// or https://.';
            }
        }

        $allowedBudgets = ['', 'under_5k', '5k_15k', '15k_50k', '50k_plus', 'flexible'];
        $budget = (string)($data['budget'] ?? '');
        if (!in_array($budget, $allowedBudgets, true)) {
            $this->errors['budget'] = 'Please select one of the listed budget ranges.';
        }

        $allowedTimelines = ['', 'under_1_month', '1_3_months', '3_6_months', 'exploratory'];
        $timeline = (string)($data['timeline'] ?? '');
        if (!in_array($timeline, $allowedTimelines, true)) {
            $this->errors['timeline'] = 'Please select one of the listed timeline options.';
        }
    }

    /**
     * Validate an email address format and length according to RFC standards.
     */
    public function isValidEmail(?string $email): bool {
        if ($email === null || $email === '') {
            return false;
        }

        $length = mb_strlen($email, 'UTF-8');
        if ($length > 254 || $length < 5) {
            return false;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }

        // Domain must contain at least one dot and valid characters
        $parts = explode('@', $email);
        if (count($parts) !== 2) {
            return false;
        }

        $domain = $parts[1];
        if (!str_contains($domain, '.') || str_ends_with($domain, '.') || str_starts_with($domain, '.')) {
            return false;
        }

        return true;
    }

    /**
     * Validate an international phone number.
     */
    public function isValidPhone(?string $phone, bool $required = false): bool {
        if ($phone === null || trim($phone) === '') {
            return !$required;
        }

        $trimmed = trim($phone);
        $len = mb_strlen($trimmed, 'UTF-8');
        if ($len < 7 || $len > 25) {
            return false;
        }

        // Must match phone character set
        if (!preg_match('/^\+?[0-9\s\-\(\)\.]{7,25}$/', $trimmed)) {
            return false;
        }

        // Must contain at least 7 digits
        $digitsOnly = preg_replace('/\D/', '', $trimmed);
        return strlen($digitsOnly) >= 7;
    }

    /**
     * Validate problem description quality and anti-spam heuristics.
     */
    public function isValidProblemDescription(?string $text, int $minLength = 15, int $maxLength = 5000): bool {
        if ($text === null) {
            return false;
        }

        $trimmed = trim($text);
        $len = mb_strlen($trimmed, 'UTF-8');
        if ($len < $minLength || $len > $maxLength) {
            return false;
        }

        // Must contain substantive text (at least 10 letters or numbers)
        $alphanumericCount = preg_match_all('/[a-zA-Z0-9]/', $trimmed);
        if ($alphanumericCount < 10) {
            return false;
        }

        // Reject obvious repetitive spam (e.g. 10 or more identical consecutive characters)
        if (preg_match('/(.)\1{9,}/', $trimmed)) {
            return false;
        }

        return true;
    }

    public function validateContact(array $data): bool {
        $this->errors = [];

        // Full name
        $name = trim((string)($data['name'] ?? ''));
        $nameLen = mb_strlen($name, 'UTF-8');
        if ($name === '' || $nameLen < 2) {
            $this->errors['name'] = 'Full name is required (minimum 2 characters).';
        } elseif ($nameLen > 100) {
            $this->errors['name'] = 'Full name cannot exceed 100 characters.';
        }

        // Email
        $email = trim((string)($data['email'] ?? ''));
        if (!$this->isValidEmail($email)) {
            $this->errors['email'] = 'A valid business or personal email address is required.';
        }

        // Phone (optional, but validated if provided)
        $phone = trim((string)($data['phone'] ?? ''));
        if ($phone !== '' && !$this->isValidPhone($phone, false)) {
            $this->errors['phone'] = 'Please enter a valid phone number (minimum 7 digits).';
        }

        // Company (optional, but length capped)
        $company = trim((string)($data['company'] ?? ''));
        if ($company !== '' && mb_strlen($company, 'UTF-8') > 120) {
            $this->errors['company'] = 'Company name cannot exceed 120 characters.';
        }

        $division = strtoupper(trim((string)($data['division'] ?? '')));
        if (!in_array($division, ['BUILD', 'GROW', 'AUTOMATE'], true)) {
            $this->errors['division'] = 'Please select BUILD, GROW, or AUTOMATE.';
        }

        $this->validateServiceForDivision($division, trim((string)($data['service'] ?? '')), false, 'service');
        $this->validateProjectContext($data);

        // Subject
        $subject = trim((string)($data['subject'] ?? ''));
        if ($subject !== '' && mb_strlen($subject, 'UTF-8') > 150) {
            $this->errors['subject'] = 'Subject cannot exceed 150 characters.';
        }

        // Message
        $message = trim((string)($data['message'] ?? ''));
        $msgLen = mb_strlen($message, 'UTF-8');
        if ($message === '' || $msgLen < 10) {
            $this->errors['message'] = 'Message must be at least 10 characters detailing your request.';
        } elseif ($msgLen > 5000) {
            $this->errors['message'] = 'Message cannot exceed 5,000 characters.';
        }

        // Privacy consent
        if (empty($data['privacy_consent'])) {
            $this->errors['privacy_consent'] = 'You must consent to our Privacy Policy to submit your message.';
        }

        // Honeypot bot trap
        if (!empty($data['_gotcha'])) {
            $this->errors['bot'] = 'Automated bot activity detected.';
        }

        return empty($this->errors);
    }

    public function validateDiscovery(array $data): bool {
        $this->errors = [];

        // Name
        $name = trim((string)($data['name'] ?? ''));
        $nameLen = mb_strlen($name, 'UTF-8');
        if ($name === '' || $nameLen < 2) {
            $this->errors['name'] = 'Full name is required (minimum 2 characters).';
        } elseif ($nameLen > 100) {
            $this->errors['name'] = 'Full name cannot exceed 100 characters.';
        }

        // Email
        $email = trim((string)($data['email'] ?? ''));
        if (!$this->isValidEmail($email)) {
            $this->errors['email'] = 'A valid work email address is required.';
        }

        // Phone (optional, but validated if provided)
        $phone = trim((string)($data['phone'] ?? ''));
        if ($phone !== '' && !$this->isValidPhone($phone, false)) {
            $this->errors['phone'] = 'Please enter a valid contact phone number.';
        }

        // Company (optional)
        $company = trim((string)($data['company'] ?? ''));
        $companyLen = mb_strlen($company, 'UTF-8');
        if ($company !== '' && $companyLen > 120) {
            $this->errors['company'] = 'Company name cannot exceed 120 characters.';
        }

        $division = strtoupper(trim((string)($data['division'] ?? '')));
        if (!in_array($division, ['BUILD', 'GROW', 'AUTOMATE'], true)) {
            $this->errors['division'] = 'Please select BUILD, GROW, or AUTOMATE.';
        }

        // Job Title
        $jobTitle = trim((string)($data['job_title'] ?? ''));
        if ($jobTitle !== '' && mb_strlen($jobTitle, 'UTF-8') > 100) {
            $this->errors['job_title'] = 'Job title cannot exceed 100 characters.';
        }

        // Country
        $country = trim((string)($data['country'] ?? ''));
        if ($country !== '' && mb_strlen($country, 'UTF-8') > 100) {
            $this->errors['country'] = 'Country cannot exceed 100 characters.';
        }

        // Service Interest
        $interest = trim((string)($data['service_interest'] ?? ''));
        $this->validateServiceForDivision($division, $interest, true, 'service_interest');

        $this->validateProjectContext($data);

        // Problem Description
        $problem = (string)($data['problem_description'] ?? '');
        if (!$this->isValidProblemDescription($problem, 15, 5000)) {
            $this->errors['problem_description'] = 'Please provide a clear description of your business problem or vision (between 15 and 5,000 characters).';
        }

        // Privacy consent
        if (empty($data['privacy_consent'])) {
            $this->errors['privacy_consent'] = 'Consent to our Privacy Policy is required.';
        }

        // Honeypot check
        if (!empty($data['_gotcha'])) {
            $this->errors['bot'] = 'Automated bot activity detected.';
        }

        return empty($this->errors);
    }

    public function getErrors(): array {
        return $this->errors;
    }
}
