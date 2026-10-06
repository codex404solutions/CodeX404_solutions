<?php
declare(strict_types=1);

namespace App\Services;

class CRMIntegrationService {
    private string $logPath;
    private string $storagePath;

    public function __construct() {
        $this->logPath = LOGS_PATH . '/crm-api.log';
        $this->storagePath = SUBMISSIONS_PATH;
    }

    /**
     * Dispatch lead payload to CRM pipeline with idempotency and persistent backup
     */
    public function dispatchLead(array $leadData): array {
        $idempotencyKey = 'lead_' . bin2hex(random_bytes(16));
        $timestamp = date('c');

        $payload = [
            'idempotency_key' => $idempotencyKey,
            'timestamp' => $timestamp,
            'source' => 'codex404_website',
            'environment' => ENVIRONMENT,
            'lead' => $leadData,
            'client_ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
        ];

        // 1. Persist local backup JSON record
        $fileName = $this->storagePath . '/' . date('Y-m-d_His') . '_' . $idempotencyKey . '.json';
        @file_put_contents($fileName, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // 2. Append to CRM log
        $logLine = "[{$timestamp}] [DISPATCH] ID={$idempotencyKey} Type=" . ($leadData['type'] ?? 'inquiry') . " Email=" . ($leadData['email'] ?? 'N/A') . PHP_EOL;
        @file_put_contents($this->logPath, $logLine, FILE_APPEND);

        // 3. Webhook delivery if CRM endpoint is configured in environment
        $crmUrl = getenv('CRM_WEBHOOK_URL') ?: null;
        $crmSecret = getenv('CRM_WEBHOOK_SECRET') ?: 'codex404_crm_secret';

        if ($crmUrl) {
            $jsonPayload = json_encode($payload);
            $signature = hash_hmac('sha256', $jsonPayload, $crmSecret);

            $ch = curl_init($crmUrl);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $jsonPayload,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'X-CodeX404-Signature: ' . $signature,
                    'X-Idempotency-Key: ' . $idempotencyKey
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 4
            ]);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $webhookLog = "[{$timestamp}] [WEBHOOK] URL={$crmUrl} Status={$httpCode} Res={$response}" . PHP_EOL;
            @file_put_contents($this->logPath, $webhookLog, FILE_APPEND);
        }

        return [
            'status' => 'success',
            'idempotency_key' => $idempotencyKey,
            'message' => 'Lead received and queued for review.'
        ];
    }
}
