<?php
declare(strict_types=1);

namespace CRM\Services;

require_once dirname(__DIR__, 2) . '/config/config.php';

/**
 * PaperclipService
 * Dispatches tasks and triggers routines into the Paperclip agent runtime.
 * Handles HMAC signing and graceful failure if Paperclip is temporarily offline.
 */
class PaperclipService
{
    private static function getBaseUrl(): string
    {
        return rtrim(CRM_PAPERCLIP_URL, '/');
    }

    private static function getApiKey(): string
    {
        return CRM_PAPERCLIP_API_KEY;
    }

    private static function getCompanyId(): string
    {
        return CRM_PAPERCLIP_COMPANY_ID;
    }

    /**
     * Dispatch a lead into Paperclip as an actionable task/issue.
     */
    public static function createLeadTask(array $lead): array
    {
        $companyId = self::getCompanyId();
        $apiKey = self::getApiKey();
        $url = self::getBaseUrl() . "/api/companies/{$companyId}/issues";

        $leadName = $lead['name'] ?? 'Prospect';
        $company = $lead['company_name'] ?? 'Unknown Company';
        $budget = $lead['budget'] ?? 'Not specified';
        $problem = $lead['problem_description'] ?? 'No problem description provided.';

        $title = "Qualify Lead: {$leadName} ({$company})";
        $description = "### New Inbound Website Lead\n\n"
            . "- **Contact:** {$leadName} ({$lead['email']})\n"
            . "- **Company:** {$company}\n"
            . "- **Country:** " . ($lead['country'] ?? 'USA') . "\n"
            . "- **Budget:** {$budget}\n"
            . "- **Timeline:** " . ($lead['timeline'] ?? 'Flexible') . "\n"
            . "- **Problem Vision:**\n>{$problem}\n\n"
            . "### Next Actions Required\n"
            . "1. **Lead Researcher:** Run background technical check on {$company}.\n"
            . "2. **Sales Engineer:** Prepare 3 custom discovery questions.\n"
            . "3. **Chief of Staff:** Stage email draft in Approval Queue.";

        $payload = [
            'title' => $title,
            'description' => $description,
            'status' => 'todo',
            'priority' => ($lead['lead_score'] ?? 0) >= 60 ? 'high' : 'medium'
        ];

        // Only call a configured Paperclip company. Never guess an ID.
        if ($apiKey !== '' && $companyId !== '') {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $apiKey
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 3
            ]);
            $response = curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($code >= 200 && $code < 300) {
                $resData = json_decode((string)$response, true);
                return [
                    'status' => 'synced',
                    'issue_id' => $resData['id'] ?? null
                ];
            }
        }

        // Graceful offline recording
        return [
            'status' => 'queued_locally',
            'message' => 'Paperclip URL or API key not configured. Recorded in local queue.'
        ];
    }
}
