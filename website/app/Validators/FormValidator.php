<?php
declare(strict_types=1);

namespace App\Validators;

class FormValidator {
    private array $errors = [];

    public function validateContact(array $data): bool {
        $this->errors = [];

        if (empty($data['name']) || mb_strlen($data['name']) < 2) {
            $this->errors['name'] = 'Full name is required (minimum 2 characters).';
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'A valid business or personal email is required.';
        }

        if (empty($data['message']) || mb_strlen($data['message']) < 10) {
            $this->errors['message'] = 'Message must be at least 10 characters detailing your request.';
        }

        if (empty($data['privacy_consent'])) {
            $this->errors['privacy_consent'] = 'You must consent to our Privacy Policy to submit your message.';
        }

        // Honeypot check
        if (!empty($data['_gotcha'])) {
            $this->errors['bot'] = 'Automated bot activity detected.';
        }

        return empty($this->errors);
    }

    public function validateDiscovery(array $data): bool {
        $this->errors = [];

        if (empty($data['name']) || mb_strlen($data['name']) < 2) {
            $this->errors['name'] = 'Full name is required.';
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = 'A valid work email is required.';
        }

        if (empty($data['company']) || mb_strlen($data['company']) < 2) {
            $this->errors['company'] = 'Company name or organization is required.';
        }

        if (empty($data['service_interest'])) {
            $this->errors['service_interest'] = 'Please select a primary solution area.';
        }

        if (empty($data['problem_description']) || mb_strlen($data['problem_description']) < 15) {
            $this->errors['problem_description'] = 'Please provide a brief description of your business problem or vision (min 15 characters).';
        }

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
