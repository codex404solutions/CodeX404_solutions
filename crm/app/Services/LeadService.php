<?php
declare(strict_types=1);

namespace CRM\Services;

/**
 * LeadService
 * Manages lead lifecycles, US market scoring, and stage transitions.
 */
class LeadService
{
    /**
     * Compute lead score based on buyer signals (budget, timeline, country, scope).
     */
    public static function calculateScore(array $lead): int
    {
        $score = 10; // baseline

        // USA prospect bonus
        $country = strtolower($lead['country'] ?? '');
        if (str_contains($country, 'usa') || str_contains($country, 'united states') || str_contains($country, 'us')) {
            $score += 30;
        }

        // Budget scoring
        $budget = strtolower($lead['budget'] ?? '');
        if (str_contains($budget, '15,000') || str_contains($budget, '15k')) {
            $score += 25;
        } elseif (str_contains($budget, '30,000') || str_contains($budget, '30k') || str_contains($budget, 'enterprise')) {
            $score += 40;
        } elseif (str_contains($budget, '5,000') || str_contains($budget, '5k')) {
            $score += 15;
        }

        // Timeline urgency
        $timeline = strtolower($lead['timeline'] ?? '');
        if (str_contains($timeline, 'immediately') || str_contains($timeline, 'urgent') || str_contains($timeline, '1 month')) {
            $score += 20;
        }

        // Clear problem description (>50 chars shows serious buyer)
        if (strlen($lead['problem_description'] ?? '') > 50) {
            $score += 15;
        }

        return min($score, 100);
    }

    /**
     * Store and qualify a new lead.
     */
    public static function createLead(array $data): array
    {
        $score = self::calculateScore($data);
        $record = [
            'type' => $data['type'] ?? 'discovery_call',
            'source' => $data['source'] ?? 'website',
            'name' => trim($data['name'] ?? ''),
            'email' => trim($data['email'] ?? ''),
            'phone' => trim($data['phone'] ?? ''),
            'company_name' => trim($data['company_name'] ?? $data['company'] ?? ''),
            'country' => trim($data['country'] ?? 'USA'),
            'job_title' => trim($data['job_title'] ?? ''),
            'service_interest' => trim($data['service_interest'] ?? ''),
            'budget' => trim($data['budget'] ?? ''),
            'timeline' => trim($data['timeline'] ?? ''),
            'problem_description' => trim($data['problem_description'] ?? ''),
            'status' => 'new',
            'lead_score' => $score
        ];

        return StorageService::insert('leads', $record);
    }

    public static function getAll(): array
    {
        $leads = StorageService::read('leads');
        usort($leads, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        return $leads;
    }

    public static function getById(string $id): ?array
    {
        return StorageService::findById('leads', $id);
    }

    public static function update(string $id, array $updates): ?array
    {
        if (isset($updates['budget']) || isset($updates['country']) || isset($updates['timeline'])) {
            $existing = self::getById($id) ?? [];
            $merged = array_merge($existing, $updates);
            $updates['lead_score'] = self::calculateScore($merged);
        }
        return StorageService::update('leads', $id, $updates);
    }

    public static function updateStatus(string $id, string $status): ?array
    {
        return StorageService::update('leads', $id, ['status' => $status]);
    }

    public static function delete(string $id): bool
    {
        $records = StorageService::read('leads');
        $filtered = array_filter($records, fn($item) => ($item['id'] ?? '') !== $id);
        if (count($filtered) !== count($records)) {
            StorageService::write('leads', array_values($filtered));
            return true;
        }
        return false;
    }
}
