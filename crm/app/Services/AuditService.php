<?php
declare(strict_types=1);

namespace CRM\Services;

use PDO;

/**
 * AuditService
 * Immutable security audit logger for CodeX404 Solutions.
 * Logs all approval decisions, rule alterations, privilege grants, and sensitive workforce modifications.
 */
class AuditService
{
    /**
     * Write an immutable audit log record to MySQL audit_logs.
     */
    public static function log(
        string $action,
        string $resourceType,
        ?string $resourceId = null,
        ?string $details = null,
        ?array $changes = null,
        ?array $actor = null
    ): void {
        $userId = $actor['id'] ?? ($_SESSION['codex_crm_user_id'] ?? ($_SESSION['codex_admin_user_id'] ?? null));
        $username = $actor['username'] ?? ($actor['name'] ?? ($_SESSION['codex_crm_user']['username'] ?? ($_SESSION['codex_admin_user'] ?? 'system')));
        $ip = self::getClientIp();
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'CLI/Internal';

        $entry = [
            'user_id' => $userId ? (string)$userId : null,
            'username' => (string)$username,
            'action' => $action,
            'resource_type' => $resourceType,
            'resource_id' => $resourceId ? (string)$resourceId : null,
            'details' => $details,
            'changes' => $changes,
            'ip_address' => $ip,
            'user_agent' => substr((string)$userAgent, 0, 500),
            'created_at' => date('Y-m-d H:i:s')
        ];

        StorageService::insert('audit_logs', $entry);
    }

    /**
     * Retrieve recent audit logs for review and compliance.
     * 
     * @return array<int, array>
     */
    public static function getRecent(int $limit = 50, ?string $resourceType = null): array
    {
        $pdo = StorageService::getPdo();
        if ($pdo) {
            try {
                if ($resourceType !== null) {
                    $stmt = $pdo->prepare("SELECT * FROM `audit_logs` WHERE `resource_type` = :res ORDER BY `created_at` DESC LIMIT :limit");
                    $stmt->bindValue(':res', $resourceType, PDO::PARAM_STR);
                    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                } else {
                    $stmt = $pdo->prepare("SELECT * FROM `audit_logs` ORDER BY `created_at` DESC LIMIT :limit");
                    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                }
                $stmt->execute();
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as &$r) {
                    if (isset($r['changes']) && is_string($r['changes'])) {
                        $r['changes'] = json_decode($r['changes'], true) ?: [];
                    }
                }
                return $rows;
            } catch (\Throwable $e) {
                // fallback
            }
        }

        $all = StorageService::read('audit_logs', []);
        if (!is_array($all)) {
            return [];
        }
        if ($resourceType !== null) {
            $all = array_filter($all, fn($item) => ($item['resource_type'] ?? '') === $resourceType);
        }
        usort($all, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        return array_slice($all, 0, $limit);
    }

    private static function getClientIp(): string
    {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return (string)$_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', (string)$_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ips[0]);
        }
        return (string)($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
    }
}
