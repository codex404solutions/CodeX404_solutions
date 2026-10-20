<?php
declare(strict_types=1);

namespace CRM\Services;

/**
 * ApprovalService
 * Implements strict human-in-the-loop governance for AI agent outputs.
 * Nothing sends or publishes automatically; approved actions are executed
 * only after explicit founder confirmation.
 */
class ApprovalService
{
    public const TYPES = [
        'email_draft' => 'Outbound Email Draft',
        'social_post' => 'Social Media Post',
        'proposal_discount' => 'Custom Pricing / Discount',
        'deployment' => 'Production Deployment'
    ];

    /**
     * Submit an item to the approval queue.
     */
    public static function submit(string $type, string $title, array $payload, string $requestedBy = 'Agent'): array
    {
        $item = [
            'type' => $type,
            'title' => $title,
            'status' => 'pending', // pending, approved, rejected
            'requested_by' => $requestedBy,
            'payload' => $payload,
            'decision_notes' => null,
            'resolved_at' => null
        ];

        return StorageService::insert('approvals', $item);
    }

    public static function getPending(): array
    {
        $all = StorageService::read('approvals');
        return array_values(array_filter($all, fn($item) => ($item['status'] ?? '') === 'pending'));
    }

    public static function getAll(): array
    {
        $all = StorageService::read('approvals');
        usort($all, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        return $all;
    }

    /**
     * Approve an item.
     */
    public static function approve(string $id, string $approvedBy, ?string $notes = null): ?array
    {
        return StorageService::update('approvals', $id, [
            'status' => 'approved',
            'approved_by' => $approvedBy,
            'decision_notes' => $notes,
            'resolved_at' => date('c')
        ]);
    }

    /**
     * Reject an item.
     */
    public static function reject(string $id, string $rejectedBy, ?string $notes = null): ?array
    {
        return StorageService::update('approvals', $id, [
            'status' => 'rejected',
            'approved_by' => $rejectedBy,
            'decision_notes' => $notes,
            'resolved_at' => date('c')
        ]);
    }
}
