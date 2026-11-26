<?php
declare(strict_types=1);

namespace App\Careers;

use PDO;

/**
 * Audit logging & applicant portal notification recording.
 */
final class ActivityLogService
{
    public static function log(
        string $actorType,
        ?string $actorId,
        ?string $actorName,
        string $action,
        string $entityType,
        ?string $entityId,
        string $summary,
        array $metadata = []
    ): void {
        try {
            $pdo = CareersDB::pdo();
            $stmt = $pdo->prepare("
                INSERT INTO `recruitment_activity_logs`
                    (`actor_type`, `actor_id`, `actor_name`, `action`, `entity_type`, `entity_id`, `summary`, `metadata_json`, `ip_hash`)
                VALUES
                    (:atype, :aid, :aname, :act, :etype, :eid, :sum, :meta, :ip)
            ");
            $stmt->execute([
                ':atype' => in_array($actorType, ['admin', 'applicant', 'system'], true) ? $actorType : 'system',
                ':aid'   => $actorId,
                ':aname' => $actorName,
                ':act'   => substr($action, 0, 100),
                ':etype' => substr($entityType, 0, 60),
                ':eid'   => $entityId,
                ':sum'   => substr($summary, 0, 255),
                ':meta'  => !empty($metadata) ? json_encode($metadata, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null,
                ':ip'    => CareersDB::hashIp(),
            ]);
        } catch (\Throwable $e) {
            error_log('Careers ActivityLog error: ' . $e->getMessage());
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function listRecent(int $limit = 100, string $actionFilter = ''): array
    {
        $pdo = CareersDB::pdo();
        $sql = "SELECT * FROM `recruitment_activity_logs`";
        $params = [];
        if ($actionFilter !== '') {
            $sql .= " WHERE `action` LIKE :act";
            $params[':act'] = $actionFilter . '%';
        }
        $sql .= " ORDER BY `id` DESC LIMIT " . max(1, min(300, $limit));
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function notifyApplicant(
        int $candidateId,
        ?int $applicationId,
        string $type,
        string $title,
        string $message
    ): void {
        try {
            $pdo = CareersDB::pdo();
            $stmt = $pdo->prepare("
                INSERT INTO `applicant_notifications` (`candidate_id`, `application_id`, `type`, `title`, `message`, `is_read`)
                VALUES (?, ?, ?, ?, ?, 0)
            ");
            $stmt->execute([$candidateId, $applicationId, $type, substr($title, 0, 180), $message]);
        } catch (\Throwable $e) {
            error_log('Applicant notification error: ' . $e->getMessage());
        }
    }
}
