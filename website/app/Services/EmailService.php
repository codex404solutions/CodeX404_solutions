<?php
declare(strict_types=1);

namespace App\Services;

class EmailService {
    public function sendLeadNotification(array $leadData): bool {
        $to = COMPANY_EMAIL;
        $name = trim(str_replace(["\r", "\n"], ' ', (string)($leadData['name'] ?? 'Website Inquiry')));
        $company = trim(str_replace(["\r", "\n"], ' ', (string)($leadData['company'] ?? 'CodeX404')));
        $subject = '[New Lead] ' . $name . ' - ' . $company;

        $body = "New Lead Submission received on CodeX404 Solutions Website:\n\n";
        foreach ($leadData as $k => $v) {
            if ($k === '_gotcha' || $k === 'csrf_token') continue;
            $label = ucwords(str_replace('_', ' ', (string)$k));
            $body .= "{$label}: {$v}\n";
        }
        $body .= "\nTime: " . date('Y-m-d H:i:s T') . "\n";

        $headers = "From: " . COMPANY_EMAIL . "\r\n" .
                   "Reply-To: " . ($leadData['email'] ?? COMPANY_EMAIL) . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        // Only report delivery when the configured PHP mail transport accepts it.
        if (ENVIRONMENT !== 'production' || !function_exists('mail')) {
            $this->logDelivery(false);
            return false;
        }

        $sent = @mail($to, $subject, $body, $headers);
        $this->logDelivery($sent);

        return $sent;
    }

    private function logDelivery(bool $sent): void {
        $logFile = LOGS_PATH . '/app.log';
        $status = $sent ? 'accepted_by_transport' : 'not_sent';
        @file_put_contents(
            $logFile,
            '[' . date('Y-m-d H:i:s') . '] lead_notification=' . $status . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );
    }
}
