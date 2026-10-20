<?php
declare(strict_types=1);

namespace CRM\Services;

/**
 * ProjectService
 * Manages client delivery projects, engineering milestones, and delivery pipelines.
 */
class ProjectService
{
    public static function getAll(): array
    {
        $all = StorageService::read('projects');
        usort($all, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        return $all;
    }

    public static function getById(string $id): ?array
    {
        return StorageService::findById('projects', $id);
    }

    public static function create(array $data): array
    {
        $project = [
            'name' => trim((string)($data['name'] ?? 'Custom Web Project')),
            'client_name' => trim((string)($data['client_name'] ?? 'Client')),
            'client_email' => trim((string)($data['client_email'] ?? '')),
            'status' => $data['status'] ?? 'in_progress', // planning, in_progress, in_review, delivered
            'progress' => (int)($data['progress'] ?? 25),
            'budget' => (float)($data['budget'] ?? 15000.00),
            'deadline' => $data['deadline'] ?? date('Y-m-d', strtotime('+6 weeks')),
            'lead_engineer' => $data['lead_engineer'] ?? 'Technical Lead Agent',
            'milestones' => $data['milestones'] ?? [
                ['title' => 'Architecture & PRD Finalization', 'completed' => true],
                ['title' => 'Core Backend & API Development', 'completed' => true],
                ['title' => 'Frontend UI & System Integration', 'completed' => false],
                ['title' => 'QA, Security Audit & Handoff', 'completed' => false]
            ]
        ];

        return StorageService::insert('projects', $project);
    }

    public static function update(string $id, array $updates): ?array
    {
        return StorageService::update('projects', $id, $updates);
    }

    public static function toggleMilestone(string $projectId, int $milestoneIndex): ?array
    {
        $project = self::getById($projectId);
        if (!$project || !isset($project['milestones'][$milestoneIndex])) {
            return null;
        }

        $milestones = $project['milestones'];
        // Support either 'completed' or 'done' keys seamlessly
        $isDone = !empty($milestones[$milestoneIndex]['completed']) || !empty($milestones[$milestoneIndex]['done']);
        $newStatus = !$isDone;
        $milestones[$milestoneIndex]['completed'] = $newStatus;
        $milestones[$milestoneIndex]['done'] = $newStatus;

        // Auto-recalculate progress
        $total = count($milestones);
        $doneCount = 0;
        foreach ($milestones as $m) {
            if (!empty($m['completed']) || !empty($m['done'])) {
                $doneCount++;
            }
        }
        $progress = $total > 0 ? (int)round(($doneCount / $total) * 100) : 0;
        $status = $progress === 100 ? 'delivered' : ($progress > 0 ? 'in_progress' : 'planning');

        return self::update($projectId, [
            'milestones' => $milestones,
            'progress' => $progress,
            'status' => $status,
            'updated_at' => date('c')
        ]);
    }

    public static function delete(string $id): bool
    {
        $records = StorageService::read('projects');
        $filtered = array_filter($records, fn($p) => ($p['id'] ?? '') !== $id);
        if (count($filtered) !== count($records)) {
            StorageService::write('projects', array_values($filtered));
            return true;
        }
        return false;
    }
}
