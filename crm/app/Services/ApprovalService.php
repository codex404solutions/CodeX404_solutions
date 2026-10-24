<?php
declare(strict_types=1);

namespace CRM\Services;

use PDO;

require_once __DIR__ . '/StorageService.php';
require_once __DIR__ . '/AuditService.php';

/**
 * ApprovalService
 * Implements strict human-in-the-loop governance for AI agent outputs,
 * financial thresholds, privilege elevations, and operational gates.
 *
 * Requirements:
 * 1. Reads rules from approval_rules table (type, threshold, required_role).
 * 2. Blocks self-approval (requester cannot approve their own requests).
 * 3. Enforces authority limits and required role validation.
 * 4. Logs every decision and change into the immutable audit_logs table.
 */
class ApprovalService
{
    public const TYPES = [
        'email_draft' => 'Outbound Email Draft',
        'social_post' => 'Social Media Post',
        'proposal_discount' => 'Custom Pricing / Discount',
        'project_budget' => 'Project Scope & Budget Elevation',
        'deployment' => 'Production Deployment',
        'privilege_elevation' => 'Privilege Escalation Request',
        'user_provisioning_elevation' => 'Elevated Account Provisioning'
    ];

    /**
     * Submit an item to the approval queue.
     * Evaluates active approval_rules to dynamically assign required_role and threshold.
     */
    public static function submit(
        string $type,
        string $title,
        array $payload,
        string $requestedBy = 'Agent',
        ?string $requestedUserId = null,
        float $amount = 0.00
    ): array {
        // Resolve best matching approval rule
        $matchedRule = self::findMatchingRule($type, $amount);

        $item = [
            'type' => $type,
            'title' => $title,
            'amount' => $amount,
            'status' => 'pending', // pending, approved, rejected
            'requested_by' => $requestedBy,
            'requested_user_id' => $requestedUserId,
            'payload' => $payload,
            'rule_id' => $matchedRule['id'] ?? null,
            'required_role' => $matchedRule['required_role'] ?? self::getDefaultRequiredRole($type),
            'decision_notes' => null,
            'resolved_at' => null
        ];

        $inserted = StorageService::insert('approvals', $item);

        // Audit the submission
        AuditService::log(
            'approval_submitted',
            'approval',
            $inserted['id'] ?? null,
            "Approval item submitted: '{$title}' ({$type}) with required role [{$item['required_role']}]",
            ['type' => $type, 'amount' => $amount, 'required_role' => $item['required_role']],
            ['id' => $requestedUserId, 'name' => $requestedBy]
        );

        return $inserted;
    }

    /**
     * Retrieve all approval rules from MySQL.
     * 
     * @return array<int, array>
     */
    public static function getAllRules(): array
    {
        $pdo = StorageService::getPdo();
        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT * FROM `approval_rules` ORDER BY `type` ASC, `threshold` ASC");
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (\Throwable $e) {
                // fallback
            }
        }

        $all = StorageService::read('approval_rules', []);
        return is_array($all) ? $all : [];
    }

    /**
     * Save (create or update) an approval rule.
     */
    public static function saveRule(array $ruleData, ?array $actor = null): array
    {
        $id = !empty($ruleData['id']) ? (string)$ruleData['id'] : 'rule_' . bin2hex(random_bytes(6));
        $record = [
            'id' => $id,
            'rule_name' => trim((string)($ruleData['rule_name'] ?? 'Approval Policy')),
            'type' => trim((string)($ruleData['type'] ?? 'proposal_discount')),
            'threshold' => (float)($ruleData['threshold'] ?? 0.00),
            'required_role' => trim(strtolower((string)($ruleData['required_role'] ?? 'superadmin'))),
            'description' => trim((string)($ruleData['description'] ?? '')),
            'is_active' => isset($ruleData['is_active']) ? (int)$ruleData['is_active'] : 1,
            'created_by' => $actor['username'] ?? ($actor['name'] ?? 'admin')
        ];

        $existing = self::getRuleById($id);
        $saved = StorageService::insert('approval_rules', $record);

        AuditService::log(
            $existing ? 'rule_updated' : 'rule_created',
            'approval_rule',
            $id,
            "Approval rule '{$record['rule_name']}' ({$record['type']}) saved with threshold \${$record['threshold']} for role [{$record['required_role']}].",
            $record,
            $actor
        );

        return $saved;
    }

    /**
     * Delete an approval rule.
     */
    public static function deleteRule(string $id, ?array $actor = null): bool
    {
        $rule = self::getRuleById($id);
        if (!$rule) {
            return false;
        }

        $deleted = StorageService::delete('approval_rules', $id);
        if ($deleted) {
            AuditService::log(
                'rule_deleted',
                'approval_rule',
                $id,
                "Approval rule '{$rule['rule_name']}' ({$rule['type']}) removed.",
                $rule,
                $actor
            );
        }
        return $deleted;
    }

    public static function getRuleById(string $id): ?array
    {
        $rules = self::getAllRules();
        foreach ($rules as $r) {
            if (($r['id'] ?? '') === $id) {
                return $r;
            }
        }
        return null;
    }

    /**
     * Match the highest applicable threshold rule for a given type & amount.
     */
    public static function findMatchingRule(string $type, float $amount = 0.00): ?array
    {
        $rules = self::getAllRules();
        $matching = array_filter($rules, function($r) use ($type, $amount) {
            if (empty($r['is_active'])) return false;
            if (($r['type'] ?? '') !== $type) return false;
            return (float)($r['threshold'] ?? 0.00) <= $amount;
        });

        if (empty($matching)) {
            // Find base rule for this type (threshold 0)
            foreach ($rules as $r) {
                if (!empty($r['is_active']) && ($r['type'] ?? '') === $type) {
                    return $r;
                }
            }
            return null;
        }

        // Sort descending by threshold to pick highest tier
        usort($matching, fn($a, $b) => (float)($b['threshold'] ?? 0) <=> (float)($a['threshold'] ?? 0));
        return reset($matching) ?: null;
    }

    public static function getPending(): array
    {
        $all = StorageService::read('approvals', []);
        return array_values(array_filter($all, fn($item) => ($item['status'] ?? '') === 'pending'));
    }

    public static function getAll(): array
    {
        $all = StorageService::read('approvals', []);
        usort($all, fn($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        return $all;
    }

    /**
     * Approve an item with strict self-approval block, required role check, and audit logging.
     *
     * @param string $id Approval ticket ID
     * @param string $approvedBy Approver display name
     * @param string|null $notes Authorization notes
     * @param array|null $approverUser Current authenticated approver user record
     * @return array Result [success => bool, message => string, item => array|null]
     */
    public static function approve(string $id, string $approvedBy, ?string $notes = null, ?array $approverUser = null): array
    {
        $all = StorageService::read('approvals', []);
        $target = null;
        foreach ($all as $item) {
            if (($item['id'] ?? '') === $id) {
                $target = $item;
                break;
            }
        }

        if (!$target) {
            return ['success' => false, 'message' => 'Approval ticket not found.', 'item' => null];
        }

        if (($target['status'] ?? '') !== 'pending') {
            return ['success' => false, 'message' => 'This request has already been decided.', 'item' => $target];
        }

        // 1. BLOCK SELF-APPROVAL
        // If requested_user_id matches current user ID, or requested_by matches current user username
        $approverId = $approverUser['id'] ?? ($_SESSION['codex_crm_user_id'] ?? ($_SESSION['codex_admin_user_id'] ?? null));
        $approverUsername = $approverUser['username'] ?? ($_SESSION['codex_crm_user']['username'] ?? ($_SESSION['codex_admin_user'] ?? ''));

        if (!empty($target['requested_user_id']) && $approverId && $target['requested_user_id'] === $approverId) {
            AuditService::log('approval_blocked_self', 'approval', $id, "Self-approval blocked for user '{$approverUsername}' on item '{$target['title']}'", ['approval_id' => $id], $approverUser);
            return ['success' => false, 'message' => 'Security Violation: Self-approval is strictly forbidden. A different authorized manager must approve your request.', 'item' => null];
        }

        if (!empty($target['requested_by']) && $approverUsername && strtolower(trim((string)$target['requested_by'])) === strtolower(trim((string)$approverUsername))) {
            AuditService::log('approval_blocked_self', 'approval', $id, "Self-approval blocked for user '{$approverUsername}' on item '{$target['title']}'", ['approval_id' => $id], $approverUser);
            return ['success' => false, 'message' => 'Security Violation: Self-approval is strictly forbidden. A different authorized manager must approve your request.', 'item' => null];
        }

        // 2. VERIFY REQUIRED ROLE & AUTHORITY LIMIT
        $approverRoles = (array)($approverUser['roles'] ?? ['admin']);
        $cleanRoles = array_map('strtolower', array_map('trim', $approverRoles));
        $isSupreme = in_array('superadmin', $cleanRoles, true) || in_array('founder', $cleanRoles, true);

        $requiredRole = strtolower(trim((string)($target['required_role'] ?? '')));
        if ($requiredRole !== '' && !$isSupreme) {
            if (!in_array($requiredRole, $cleanRoles, true)) {
                AuditService::log('approval_blocked_role', 'approval', $id, "Approval denied: User '{$approverUsername}' lacks required role '{$requiredRole}'", ['required_role' => $requiredRole, 'user_roles' => $cleanRoles], $approverUser);
                return ['success' => false, 'message' => "Insufficient Authority: This item requires the [{$requiredRole}] role or Founder/Superadmin supreme clearance.", 'item' => null];
            }
        }

        // Check approver monetary approval limit if an amount is attached
        $amount = (float)($target['amount'] ?? 0.00);
        if ($amount > 0 && !$isSupreme && isset($approverUser['approval_limit'])) {
            $userLimit = (float)$approverUser['approval_limit'];
            if ($userLimit > 0 && $amount > $userLimit) {
                AuditService::log('approval_blocked_limit', 'approval', $id, "Approval denied: Amount \${$amount} exceeds user limit \${$userLimit}", ['amount' => $amount, 'approval_limit' => $userLimit], $approverUser);
                return ['success' => false, 'message' => "Authority Tier Exceeded: The requested amount (\$" . number_format($amount, 2) . ") exceeds your authorized approval limit (\$" . number_format($userLimit, 2) . ").", 'item' => null];
            }
        }

        // 3. EXECUTE PRIVILEGED / PROVISIONING PAYLOAD HOOKS
        $type = $target['type'] ?? '';
        $payload = (array)($target['payload'] ?? []);

        if ($type === 'privilege_elevation' && !empty($payload['user_id'])) {
            if (class_exists('\\CRM\\Services\\UserService')) {
                UserService::applyElevatedPrivileges((string)$payload['user_id'], $payload);
            }
        } elseif ($type === 'user_provisioning_elevation' && !empty($payload['user_data'])) {
            if (class_exists('\\CRM\\Services\\UserService')) {
                UserService::applyApprovedUserCreation((array)$payload['user_data']);
            }
        }

        $updated = StorageService::update('approvals', $id, [
            'status' => 'approved',
            'approved_by' => $approvedBy,
            'decision_notes' => $notes,
            'resolved_at' => date('c')
        ]);

        // 4. LOG DECISION IN AUDIT TABLE
        AuditService::log(
            'approval_granted',
            'approval',
            $id,
            "Approval granted for '{$target['title']}' ({$type}) by {$approvedBy}" . ($notes ? ": {$notes}" : ""),
            [
                'approval_id' => $id,
                'type' => $type,
                'amount' => $amount,
                'requested_by' => $target['requested_by'] ?? null,
                'approved_by' => $approvedBy,
                'notes' => $notes
            ],
            $approverUser
        );

        return ['success' => true, 'message' => "Action '{$target['title']}' authorized and signed off successfully.", 'item' => $updated];
    }

    /**
     * Reject an item with self-rejection block check and audit logging.
     */
    public static function reject(string $id, string $rejectedBy, ?string $notes = null, ?array $approverUser = null): array
    {
        $all = StorageService::read('approvals', []);
        $target = null;
        foreach ($all as $item) {
            if (($item['id'] ?? '') === $id) {
                $target = $item;
                break;
            }
        }

        if (!$target) {
            return ['success' => false, 'message' => 'Approval ticket not found.', 'item' => null];
        }

        $approverId = $approverUser['id'] ?? ($_SESSION['codex_crm_user_id'] ?? ($_SESSION['codex_admin_user_id'] ?? null));
        $approverUsername = $approverUser['username'] ?? ($_SESSION['codex_crm_user']['username'] ?? ($_SESSION['codex_admin_user'] ?? ''));

        if (!empty($target['requested_user_id']) && $approverId && $target['requested_user_id'] === $approverId) {
            return ['success' => false, 'message' => 'Self-action blocked: Requesters cannot resolve their own approval tickets.', 'item' => null];
        }

        $updated = StorageService::update('approvals', $id, [
            'status' => 'rejected',
            'approved_by' => $rejectedBy,
            'decision_notes' => $notes,
            'resolved_at' => date('c')
        ]);

        AuditService::log(
            'approval_rejected',
            'approval',
            $id,
            "Approval rejected for '{$target['title']}' by {$rejectedBy}" . ($notes ? ": {$notes}" : ""),
            [
                'approval_id' => $id,
                'type' => $target['type'] ?? '',
                'rejected_by' => $rejectedBy,
                'notes' => $notes
            ],
            $approverUser
        );

        return ['success' => true, 'message' => "Action '{$target['title']}' was rejected.", 'item' => $updated];
    }

    private static function getDefaultRequiredRole(string $type): string
    {
        return match($type) {
            'privilege_elevation', 'user_provisioning_elevation' => 'superadmin',
            'deployment' => 'cto',
            'project_budget' => 'coo',
            'proposal_discount' => 'sales_manager',
            'email_draft', 'social_post' => 'marketing_manager',
            default => 'superadmin'
        };
    }
}
