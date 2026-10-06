<?php
declare(strict_types=1);

namespace App\Services;

class EmailService {
    public function sendLeadNotification(array $leadData): bool {
        $to = COMPANY_EMAIL;
        $subject = "[New Lead] " . ($leadData['name'] ?? 'Website Inquiry') . " - " . ($leadData['company'] ?? 'CodeX404');

        $body = "New Lead Submission received on CodeX404 Solutions Website:\n\n";
        foreach ($leadData as $k => $v) {
            if ($k === '_gotcha' || $k === 'csrf_token') continue;
            $label = ucwords(str_replace('_', ' ', (string)$k));
            $body .= "{$label}: {$v}\n";
        }
        $body .= "\nTime: " . date('Y-m-d H:i:s T') . "\n";
        $body .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1') . "\n";

        $headers = "From: " . COMPANY_EMAIL . "\r\n" .
                   "Reply-To: " . ($leadData['email'] ?? COMPANY_EMAIL) . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        // Attempt mail send if configured
        if (ENVIRONMENT === 'production' && function_exists('mail')) {
            @mail($to, $subject, $body, $headers);
        }

        // Always log notification
        $logFile = LOGS_PATH . '/app.log';
        $logMsg = "[" . date('Y-m-d H:i:s') . "] Notification queued for " . ($leadData['email'] ?? 'unknown') . PHP_EOL;
        @file_put_contents($logFile, $logMsg, FILE_APPEND);

        return true;
    }
}
