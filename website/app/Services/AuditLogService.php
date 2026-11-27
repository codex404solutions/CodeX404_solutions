<?php
declare(strict_types=1);

namespace App\Services;

use Database;
use PDO;

/**
 * MySQL-backed Admin Audit Log Service.
 * Records authentication, RBAC, user lifecycle, and portfolio actions.
 */
final class AuditLogService
{
    /**
     * Write an audit record using PDO prepared statements. Fails closed without breaking the caller.
     *
     * @param array<string, mixed>|null $metadata
     */
    public static function record(
        ?string $actorId,
        ?string $actorUsername,
        string $action,
        string $entityType,
        ?string $entityId,
        string $summary,
        ?array $metadata = null
    ): void {
        $pdo = Database::getConnection();
        if (!$pdo) {
            return;
        }

        try {
            $ip = function_exists('get_client_ip')
                ? get_client_ip()
                : (string)($_SERVER['REMOTE_ADDR'] ?? '');

            $stmt = $pdo->prepare('
                INSERT INTO `admin_audit_logs` (
                    `actor_id`, `actor_username`, `action`, `entity_type`,
                    `entity_id`, `summary`, `metadata_json`, `ip_address`
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ');
            $stmt->execute([
                $actorId !== null && $actorId !== '' ? substr($actorId, 0, 64) : null,
                $actorUsername !== null && $actorUsername !== '' ? substr($actorUsername, 0, 100) : null,
                substr(trim($action), 0, 100),
                substr(trim($entityType), 0, 64),
                $entityId !== null && $entityId !== '' ? substr($entityId, 0, 64) : null,
                substr(trim($summary), 0, 255),
                $metadata !== null ? json_encode($metadata, JSON_UNESCAPED_SLASHES) : null,
                $ip !== '' ? substr($ip, 0, 64) : null,
            ]);
        } catch (\Throwable $e) {
            // Do not crash primary workflow if migration hasn't run yet
        }
    }

    /**
     * Fetch recent audit events for telemetry / diagnostics views.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function recent(int $limit = 15): array
    {
        $pdo = Database::getConnection();
        if (!$pdo) {
            return [];
        }

        try {
            $safeLimit = max(1, min(100, $limit));
            $stmt = $pdo->prepare('SELECT * FROM `admin_audit_logs` ORDER BY `id` DESC LIMIT ?');
            $stmt->bindValue(1, $safeLimit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Build WHERE clause and bound params for audit log filtering.
     *
     * @param array<string, mixed> $filters
     * @return array{0: string, 1: array<int, string>}
     */
    private static function buildWhere(array $filters): array
    {
        $clauses = [];
        $params = [];

        $q = trim((string)($filters['q'] ?? ''));
        if ($q !== '') {
            $like = '%' . $q . '%';
            $clauses[] = '(`actor_username` LIKE ? OR `action` LIKE ? OR `entity_type` LIKE ? OR `entity_id` LIKE ? OR `summary` LIKE ? OR `ip_address` LIKE ?)';
            array_push($params, $like, $like, $like, $like, $like, $like);
        }

        $entity = trim((string)($filters['entity'] ?? ''));
        if ($entity !== '' && $entity !== 'all') {
            $clauses[] = '`entity_type` = ?';
            $params[] = $entity;
        }

        $severity = trim((string)($filters['severity'] ?? ''));
        if ($severity === 'security') {
            $clauses[] = '(`action` LIKE ? OR `action` LIKE ? OR `action` LIKE ?)';
            array_push($params, '%fail%', '%delete%', '%revoke%');
        } elseif ($severity === 'auth') {
            $clauses[] = '`action` LIKE ?';
            $params[] = 'auth.%';
        }

        $from = trim((string)($filters['from'] ?? ''));
        if ($from !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $from)) {
            $clauses[] = '`created_at` >= ?';
            $params[] = $from . ' 00:00:00';
        }

        $to = trim((string)($filters['to'] ?? ''));
        if ($to !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $to)) {
            $clauses[] = '`created_at` <= ?';
            $params[] = $to . ' 23:59:59';
        }

        $where = $clauses ? ('WHERE ' . implode(' AND ', $clauses)) : '';
        return [$where, $params];
    }

    /**
     * Query audit logs with filtering and pagination.
     *
     * @param array<string, mixed> $filters
     * @return array<int, array<string, mixed>>
     */
    public static function query(array $filters = [], int $limit = 50, int $offset = 0): array
    {
        $pdo = Database::getConnection();
        if (!$pdo) {
            return [];
        }

        try {
            [$where, $params] = self::buildWhere($filters);
            $safeLimit = max(1, min(500, $limit));
            $safeOffset = max(0, $offset);

            $sql = "SELECT * FROM `admin_audit_logs` {$where} ORDER BY `id` DESC LIMIT ? OFFSET ?";
            $stmt = $pdo->prepare($sql);
            $idx = 1;
            foreach ($params as $val) {
                $stmt->bindValue($idx++, $val, PDO::PARAM_STR);
            }
            $stmt->bindValue($idx++, $safeLimit, PDO::PARAM_INT);
            $stmt->bindValue($idx, $safeOffset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Count audit log records matching filters.
     *
     * @param array<string, mixed> $filters
     */
    public static function count(array $filters = []): int
    {
        $pdo = Database::getConnection();
        if (!$pdo) {
            return 0;
        }

        try {
            [$where, $params] = self::buildWhere($filters);
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM `admin_audit_logs` {$where}");
            $stmt->execute($params);
            return (int)$stmt->fetchColumn();
        } catch (\Throwable $e) {
            return 0;
        }
    }

    /**
     * Summary KPIs and distinct entity types for the Audit Logs console.
     *
     * @return array{total: int, today: int, security_alerts: int, unique_actors: int, entity_types: array<int, string>}
     */
    public static function stats(): array
    {
        $defaults = [
            'total' => 0,
            'today' => 0,
            'security_alerts' => 0,
            'unique_actors' => 0,
            'entity_types' => [],
        ];
        $pdo = Database::getConnection();
        if (!$pdo) {
            return $defaults;
        }

        try {
            $todayPrefix = date('Y-m-d') . ' 00:00:00';
            $defaults['total'] = (int)$pdo->query('SELECT COUNT(*) FROM `admin_audit_logs`')->fetchColumn();
            $stmtToday = $pdo->prepare('SELECT COUNT(*) FROM `admin_audit_logs` WHERE `created_at` >= ?');
            $stmtToday->execute([$todayPrefix]);
            $defaults['today'] = (int)$stmtToday->fetchColumn();

            $defaults['security_alerts'] = (int)$pdo->query("SELECT COUNT(*) FROM `admin_audit_logs` WHERE `action` LIKE '%fail%' OR `action` LIKE '%delete%' OR `action` LIKE '%revoke%'")->fetchColumn();
            $defaults['unique_actors'] = (int)$pdo->query('SELECT COUNT(DISTINCT `actor_username`) FROM `admin_audit_logs` WHERE `actor_username` IS NOT NULL')->fetchColumn();
            $defaults['entity_types'] = $pdo->query('SELECT DISTINCT `entity_type` FROM `admin_audit_logs` WHERE `entity_type` IS NOT NULL ORDER BY `entity_type` ASC')->fetchAll(PDO::FETCH_COLUMN) ?: [];
            return $defaults;
        } catch (\Throwable $e) {
            return $defaults;
        }
    }
}
