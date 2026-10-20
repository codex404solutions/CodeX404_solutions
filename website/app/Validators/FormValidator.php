<?php
declare(strict_types=1);

namespace App\Validators;

class FormValidator {
    private array $errors = [];

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

        // Company
        $company = trim((string)($data['company'] ?? ''));
        $companyLen = mb_strlen($company, 'UTF-8');
        if ($company === '' || $companyLen < 2) {
            $this->errors['company'] = 'Company name or organization is required.';
        } elseif ($companyLen > 120) {
            $this->errors['company'] = 'Company name cannot exceed 120 characters.';
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
        if ($interest === '') {
            $this->errors['service_interest'] = 'Please select a primary solution area.';
        } elseif (mb_strlen($interest, 'UTF-8') > 100) {
            $this->errors['service_interest'] = 'Service interest value is too long.';
        }

        // Budget & Timeline
        $budget = trim((string)($data['budget'] ?? ''));
        if ($budget !== '' && mb_strlen($budget, 'UTF-8') > 50) {
            $this->errors['budget'] = 'Budget selection cannot exceed 50 characters.';
        }
        $timeline = trim((string)($data['timeline'] ?? ''));
        if ($timeline !== '' && mb_strlen($timeline, 'UTF-8') > 50) {
            $this->errors['timeline'] = 'Timeline selection cannot exceed 50 characters.';
        }

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
