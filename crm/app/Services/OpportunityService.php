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

    public static function getAll(): array
    {
        return StorageService::read('opportunities');
    }

    public static function updateStage(string $id, string $stage): ?array
    {
        $prob = self::STAGES[$stage]['probability'] ?? 20;
        return StorageService::update('opportunities', $id, [
            'stage' => $stage,
            'probability' => $prob
        ]);
    }
}
