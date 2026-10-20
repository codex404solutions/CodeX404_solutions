<?php
declare(strict_types=1);

namespace CRM\Services;

/**
 * OpportunityService
 * Manages the sales pipeline, deal stages, and win/loss records.
 */
class OpportunityService
{
    public const STAGES = [
        'discovery' => ['label' => 'Discovery', 'probability' => 20],
        'scoping' => ['label' => 'Technical Scoping', 'probability' => 40],
        'proposal' => ['label' => 'Proposal Sent', 'probability' => 60],
        'negotiation' => ['label' => 'Negotiation', 'probability' => 80],
        'closed_won' => ['label' => 'Closed Won', 'probability' => 100],
        'closed_lost' => ['label' => 'Closed Lost', 'probability' => 0]
    ];

    public static function getAll(): array
    {
        $all = StorageService::read('opportunities');
        usort($all, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        return $all;
    }

    public static function advanceStage(string $id, string $newStage): ?array
    {
        if (!array_key_exists($newStage, self::STAGES)) {
            return null;
        }
        return self::update($id, [
            'stage' => $newStage,
            'probability' => self::STAGES[$newStage]['probability'] ?? 20,
            'updated_at' => date('c')
        ]);
    }

    public static function createFromLead(array $lead, float $estimatedValue = 5000.00): array
    {
        $opportunity = [
            'lead_id' => $lead['id'] ?? '',
            'title' => ($lead['company_name'] ?? 'Client') . ' — Custom Web App',
            'client_name' => $lead['name'] ?? '',
            'client_email' => $lead['email'] ?? '',
            'value' => $estimatedValue,
            'stage' => 'discovery',
            'probability' => self::STAGES['discovery']['probability'],
            'expected_close_date' => date('Y-m-d', strtotime('+3 weeks'))
        ];

        return StorageService::insert('opportunities', $opportunity);
    }

    public static function create(array $data): array
    {
        $stage = $data['stage'] ?? 'discovery';
        $opportunity = [
            'lead_id' => $data['lead_id'] ?? '',
            'title' => trim((string)($data['title'] ?? 'New Opportunity')),
            'client_name' => trim((string)($data['client_name'] ?? 'Client')),
            'client_email' => trim((string)($data['client_email'] ?? '')),
            'value' => (float)($data['value'] ?? 5000.00),
            'stage' => $stage,
            'probability' => self::STAGES[$stage]['probability'] ?? 20,
            'expected_close_date' => $data['expected_close_date'] ?? date('Y-m-d', strtotime('+3 weeks'))
        ];

        return StorageService::insert('opportunities', $opportunity);
    }

    public static function getById(string $id): ?array
    {
        return StorageService::findById('opportunities', $id);
    }

    public static function update(string $id, array $updates): ?array
    {
        if (isset($updates['stage'])) {
            $updates['probability'] = self::STAGES[$updates['stage']]['probability'] ?? 20;
        }
        return StorageService::update('opportunities', $id, $updates);
    }

    public static function delete(string $id): bool
    {
        $records = StorageService::read('opportunities');
        $filtered = array_filter($records, fn($item) => ($item['id'] ?? '') !== $id);
        if (count($filtered) !== count($records)) {
            StorageService::write('opportunities', array_values($filtered));
            return true;
        }
        return false;
    }
}
