<?php
declare(strict_types=1);

namespace App\Services;

class CRMIntegrationService
{
    private string $logPath;
    private string $storagePath;

    public function __construct()
    {
        $this->logPath = LOGS_PATH . '/crm-api.log';
        $this->storagePath = SUBMISSIONS_PATH;
    }

    /**
     * Persist a lead locally, then optionally deliver it to a separately hosted CRM.
     * Outbound transport is fail-closed: HTTPS + explicit HMAC secret required.
     */
    public function dispatchLead(array $leadData): array
    {
        $idempotencyKey = 'lead_' . bin2hex(random_bytes(16));
        $timestamp = date('c');
        $payload = [
            'idempotency_key' => $idempotencyKey,
            'timestamp' => $timestamp,
            'source' => 'codex404_website',
            'environment' => ENVIRONMENT,
            'lead' => $leadData,
            'client_ip' => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent' => substr((string)($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 500)
        ];

        @mkdir($this->storagePath, 0700, true);
        @mkdir(dirname($this->logPath), 0700, true);
        $jsonPayload = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE);
        if (!is_string($jsonPayload)) {
            return ['status' => 'stored_locally', 'idempotency_key' => $idempotencyKey];
        }

        $fileName = $this->storagePath . '/' . date('Y-m-d_His') . '_' . $idempotencyKey . '.json';
        @file_put_contents($fileName, $jsonPayload, LOCK_EX);
        @chmod($fileName, 0600);

        // Avoid logging contact details or complete remote responses.
        @file_put_contents(
            $this->logPath,
            "[{$timestamp}] lead={$idempotencyKey} type=" . ($leadData['type'] ?? 'inquiry') . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );

        $crmUrl = (class_exists('Env') ? \Env::get('CRM_WEBHOOK_URL', '') : '') ?: (getenv('CRM_WEBHOOK_URL') ?: '');
        $crmSecret = (class_exists('Env') ? \Env::get('CRM_WEBHOOK_SECRET', '') : '') ?: (getenv('CRM_WEBHOOK_SECRET') ?: '');
        if ($crmUrl === '' || $crmSecret === '' || !str_starts_with(strtolower($crmUrl), 'https://')) {
            return [
                'status' => 'stored_locally',
                'idempotency_key' => $idempotencyKey,
                'message' => 'Lead saved for CRM follow-up; secure CRM sync is not configured.'
            ];
        }

        $unixTimestamp = time();
        $signature = hash_hmac('sha256', $jsonPayload, $crmSecret);
        $ch = curl_init($crmUrl);
        if ($ch === false) {
            return ['status' => 'stored_locally', 'idempotency_key' => $idempotencyKey];
        }
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonPayload,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'X-CodeX404-Signature: ' . $signature,
                'X-CodeX404-Timestamp: ' . (string)$unixTimestamp,
                'X-Idempotency-Key: ' . $idempotencyKey
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_MAXREDIRS => 0
        ]);
        $response = curl_exec($ch);
        $httpCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        @file_put_contents(
            $this->logPath,
            "[{$timestamp}] crm_sync={$idempotencyKey} status={$httpCode} error=" . ($curlError !== '' ? 'transport_error' : 'none') . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );

        return [
            'status' => ($httpCode >= 200 && $httpCode < 300) ? 'synced' : 'stored_locally',
            'idempotency_key' => $idempotencyKey,
            'http_status' => $httpCode ?: null
        ];
    }
}
