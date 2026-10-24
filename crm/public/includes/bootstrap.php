<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Common Bootstrap
 * Handles services initialization, authentication session, CSRF, POST mutations, and flash messaging.
 */

namespace CRM;

use CRM\Services\StorageService;
use CRM\Services\LeadService;
use CRM\Services\OpportunityService;
use CRM\Services\ProjectService;
use CRM\Services\ApprovalService;
use CRM\Services\PaperclipService;
use CRM\Services\RBACService;
use CRM\Services\UserService;
use CRM\Services\AuthService;
use CRM\Services\CrmSecurity;
use CRM\Services\CurrencyService;

$crmRoot = dirname(__DIR__, 2);
require_once $crmRoot . '/app/Services/StorageService.php';
require_once $crmRoot . '/app/Services/LeadService.php';
require_once $crmRoot . '/app/Services/OpportunityService.php';
require_once $crmRoot . '/app/Services/ProjectService.php';
require_once $crmRoot . '/app/Services/ApprovalService.php';
require_once $crmRoot . '/app/Services/PaperclipService.php';
require_once $crmRoot . '/app/Services/RBACService.php';
require_once $crmRoot . '/app/Services/UserService.php';
require_once $crmRoot . '/app/Services/AuthService.php';
require_once $crmRoot . '/app/Services/CrmSecurity.php';
require_once $crmRoot . '/app/Services/CurrencyService.php';

StorageService::init($crmRoot . '/storage');
UserService::seedDefaultUsersIfEmpty();
AuthService::startSession();
$currentUser = AuthService::user();

if ($currentUser === null) {
    header('Location: login');
    exit;
}

$flashMessage = null;
$flashType = 'success';
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    $flashType = $_SESSION['flash_type'] ?? 'success';
    unset($_SESSION['flash_message'], $_SESSION['flash_type']);
}

// -------------------------------------------------------------
// POST Request Processing (State Mutations with CSRF & RBAC)
// -------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $returnUrl = $_POST['return_url'] ?? $_SERVER['HTTP_REFERER'] ?? './';

    if (!CrmSecurity::verifyCsrf($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        $_SESSION['flash_message'] = 'Security validation failed (CSRF token expired). Please try again.';
        $_SESSION['flash_type'] = 'danger';
        header('Location: ' . $returnUrl);
        exit;
    }

    $action = $_POST['action'] ?? '';
    $userRoles = $currentUser['roles'] ?? [];

    switch ($action) {
        // --- 1. APPROVAL DECISION (HITL) ---
        case 'approval_decision':
            if (!RBACService::hasPermission($userRoles, 'approvals.decide')) {
                $_SESSION['flash_message'] = 'Permission denied: Cannot decide approvals.';
                $_SESSION['flash_type'] = 'danger';
                break;
            }
            $approvalId = trim((string)($_POST['approval_id'] ?? ''));
            $decision = trim((string)($_POST['decision'] ?? ''));
            $notes = trim((string)($_POST['decision_notes'] ?? ''));

            if ($decision === 'approve') {
                ApprovalService::approve($approvalId, $currentUser['name'], $notes ?: null);
                $_SESSION['flash_message'] = "Draft approved successfully! Logged by {$currentUser['name']}.";
                $_SESSION['flash_type'] = 'success';
            } elseif ($decision === 'reject') {
                ApprovalService::reject($approvalId, $currentUser['name'], $notes ?: null);
                $_SESSION['flash_message'] = "Draft rejected.";
                $_SESSION['flash_type'] = 'warning';
            }
            break;

        // --- 2. CREATE LEAD ---
        case 'create_lead':
            $leadData = [
                'name' => trim((string)($_POST['name'] ?? '')),
                'email' => trim((string)($_POST['email'] ?? '')),
                'phone' => trim((string)($_POST['phone'] ?? '')),
                'company_name' => trim((string)($_POST['company_name'] ?? '')),
                'country' => trim((string)($_POST['country'] ?? 'United States')),
                'budget' => trim((string)($_POST['budget'] ?? '$15,000 - $30,000')),
                'timeline' => trim((string)($_POST['timeline'] ?? '1-2 months')),
                'problem_description' => trim((string)($_POST['problem_description'] ?? '')),
                'service_interest' => trim((string)($_POST['service_interest'] ?? 'Custom Web Application')),
                'source' => 'crm_manual'
            ];

            if ($leadData['name'] === '' || $leadData['email'] === '') {
                $_SESSION['flash_message'] = 'Prospect Name and Work Email are required.';
                $_SESSION['flash_type'] = 'danger';
            } else {
                $newLead = LeadService::createLead($leadData);
                $_SESSION['flash_message'] = "Lead for '{$newLead['name']}' ({$newLead['company_name']}) created with Score {$newLead['lead_score']}/100!";
                $_SESSION['flash_type'] = 'success';
            }
            break;

        // --- 3. UPDATE LEAD STATUS ---
        case 'update_lead_status':
            $leadId = trim((string)($_POST['lead_id'] ?? ''));
            $status = trim((string)($_POST['status'] ?? ''));
            if ($leadId !== '' && $status !== '') {
                LeadService::updateStatus($leadId, $status);
                $_SESSION['flash_message'] = "Lead status updated to '{$status}'.";
                $_SESSION['flash_type'] = 'info';
            }
            break;

        // --- 4. CONVERT LEAD TO OPPORTUNITY ---
        case 'convert_lead':
            $leadId = trim((string)($_POST['lead_id'] ?? ''));
            $lead = LeadService::getById($leadId);
            if ($lead) {
                $estValue = (float)($_POST['estimated_value'] ?? 25000.00);
                $opp = OpportunityService::createFromLead($lead, $estValue);
                LeadService::updateStatus($leadId, 'qualified');
                $_SESSION['flash_message'] = "Lead converted to Sales Deal: '{$opp['title']}' ($" . number_format($opp['value'], 0) . ")!";
                $_SESSION['flash_type'] = 'success';
            }
            break;

        // --- 5. DELETE LEAD ---
        case 'delete_lead':
            $leadId = trim((string)($_POST['lead_id'] ?? ''));
            if ($leadId !== '') {
                LeadService::delete($leadId);
                $_SESSION['flash_message'] = 'Lead removed from CRM.';
                $_SESSION['flash_type'] = 'warning';
            }
            break;

        // --- 6. CREATE OPPORTUNITY ---
        case 'create_opportunity':
            $oppData = [
                'title' => trim((string)($_POST['title'] ?? 'Custom Web Solution')),
                'company' => trim((string)($_POST['company'] ?? 'Client Inc')),
                'client_name' => trim((string)($_POST['client_name'] ?? '')),
                'client_email' => trim((string)($_POST['client_email'] ?? '')),
                'value' => (float)($_POST['value'] ?? 15000.00),
                'stage' => trim((string)($_POST['stage'] ?? 'discovery')),
                'assigned_to' => trim((string)($_POST['assigned_to'] ?? 'Sales Engineer')),
                'expected_close_date' => $_POST['expected_close_date'] ?? date('Y-m-d', strtotime('+3 weeks')),
                'notes' => trim((string)($_POST['notes'] ?? ''))
            ];
            OpportunityService::create($oppData);
            $_SESSION['flash_message'] = "New deal '{$oppData['title']}' added to pipeline ($" . number_format($oppData['value'], 0) . ")!";
            $_SESSION['flash_type'] = 'success';
            break;

        // --- 7. ADVANCE OPPORTUNITY STAGE ---
        case 'advance_opportunity':
            $oppId = trim((string)($_POST['opportunity_id'] ?? ''));
            $newStage = trim((string)($_POST['stage'] ?? ''));
            if ($oppId !== '' && $newStage !== '') {
                OpportunityService::advanceStage($oppId, $newStage);
                $_SESSION['flash_message'] = "Deal moved to stage '" . strtoupper(str_replace('_', ' ', $newStage)) . "'.";
                $_SESSION['flash_type'] = 'info';
            }
            break;

        // --- 8. DELETE OPPORTUNITY ---
        case 'delete_opportunity':
            $oppId = trim((string)($_POST['opportunity_id'] ?? ''));
            if ($oppId !== '') {
                OpportunityService::delete($oppId);
                $_SESSION['flash_message'] = 'Deal removed from pipeline.';
                $_SESSION['flash_type'] = 'warning';
            }
            break;

        // --- 9. CREATE PROJECT ---
        case 'create_project':
            $projData = [
                'name' => trim((string)($_POST['name'] ?? 'Client Deliverable')),
                'client_name' => trim((string)($_POST['client_name'] ?? 'Client')),
                'client_email' => trim((string)($_POST['client_email'] ?? '')),
                'budget' => (float)($_POST['budget'] ?? 20000.00),
                'deadline' => $_POST['deadline'] ?? date('Y-m-d', strtotime('+6 weeks')),
                'lead_engineer' => trim((string)($_POST['lead_engineer'] ?? 'Delivery Lead Agent'))
            ];
            ProjectService::create($projData);
            $_SESSION['flash_message'] = "Project '{$projData['name']}' created and initialized with delivery milestones!";
            $_SESSION['flash_type'] = 'success';
            break;

        // --- 10. TOGGLE MILESTONE ---
        case 'toggle_milestone':
            $projectId = trim((string)($_POST['project_id'] ?? ''));
            $milestoneIndex = (int)($_POST['milestone_index'] ?? 0);
            $updated = ProjectService::toggleMilestone($projectId, $milestoneIndex);
            if ($updated) {
                $_SESSION['flash_message'] = "Milestone updated! Project progress is now {$updated['progress']}%.";
                $_SESSION['flash_type'] = 'success';
            }
            break;

        // --- 11. DELETE PROJECT ---
        case 'delete_project':
            $projectId = trim((string)($_POST['project_id'] ?? ''));
            if ($projectId !== '') {
                ProjectService::delete($projectId);
                $_SESSION['flash_message'] = 'Project removed.';
                $_SESSION['flash_type'] = 'warning';
            }
            break;

        // --- 12. DISPATCH CUSTOM PAPERCLIP TASK ---
        case 'dispatch_paperclip':
            $agentSlug = trim((string)($_POST['agent_slug'] ?? 'sales-engineer'));
            $title = trim((string)($_POST['title'] ?? 'Task Brief'));
            $description = trim((string)($_POST['description'] ?? ''));
            $priority = trim((string)($_POST['priority'] ?? 'medium'));
            $leadId = !empty($_POST['lead_id']) ? trim((string)$_POST['lead_id']) : null;

            $task = PaperclipService::createTask($agentSlug, $title, $description, $priority, $leadId);
            $_SESSION['flash_message'] = "Dispatched Task #{$task['id']} to {$agentSlug}! Status: Completed/Active.";
            $_SESSION['flash_type'] = 'success';
            break;

        // --- 13. EXECUTE PAPERCLIP AUTONOMOUS ROUTINE ---
        case 'run_routine':
            $routine = trim((string)($_POST['routine'] ?? ''));
            $leadId = !empty($_POST['lead_id']) ? trim((string)$_POST['lead_id']) : null;
            $context = [];
            if ($leadId) {
                $lead = LeadService::getById($leadId);
                if ($lead) {
                    $context = [
                        'lead_id' => $lead['id'],
                        'name' => $lead['name'] ?? 'Prospect',
                        'company' => $lead['company_name'] ?? 'Prospect Company',
                        'email' => $lead['email'] ?? '',
                        'needs' => $lead['problem_description'] ?? $lead['needs'] ?? 'Modern web solution',
                        'budget' => $lead['budget'] ?? '$15,000+'
                    ];
                }
            }
            $result = PaperclipService::runRoutine($routine, $context);
            if (($result['status'] ?? '') === 'success') {
                $_SESSION['flash_message'] = "⚡ Routine Executed: " . htmlspecialchars($result['message'] ?? 'Done!');
                $_SESSION['flash_type'] = 'success';
            } else {
                $_SESSION['flash_message'] = "Routine error: " . htmlspecialchars($result['message'] ?? 'Failed');
                $_SESSION['flash_type'] = 'danger';
            }
            break;

        // --- 14. CREATE NEW USER ---
        case 'create_user':
            try {
                $grantedPerms = isset($_POST['custom_granted']) && is_array($_POST['custom_granted']) ? $_POST['custom_granted'] : [];
                $deniedPerms = isset($_POST['custom_denied']) && is_array($_POST['custom_denied']) ? $_POST['custom_denied'] : [];
                $userAssignedRoles = isset($_POST['roles']) && is_array($_POST['roles']) ? $_POST['roles'] : ['viewer'];
                $accessScope = trim((string)($_POST['access_scope'] ?? 'crm_only'));

                $createdUser = UserService::create([
                    'name' => trim((string)($_POST['name'] ?? '')),
                    'username' => trim((string)($_POST['username'] ?? '')),
                    'email' => trim((string)($_POST['email'] ?? '')),
                    'phone' => trim((string)($_POST['phone'] ?? '')),
                    'title' => trim((string)($_POST['title'] ?? 'Staff Member')),
                    'department' => trim((string)($_POST['department'] ?? 'Operations')),
                    'bio' => trim((string)($_POST['bio'] ?? '')),
                    'password' => (string)($_POST['password'] ?? 'admin@1234'),
                    'status' => trim((string)($_POST['status'] ?? 'active')),
                    'access_scope' => $accessScope,
                    'roles' => $userAssignedRoles,
                    'custom_permissions' => [
                        'granted' => $grantedPerms,
                        'denied' => $deniedPerms
                    ]
                ], $currentUser);

                if (!empty($createdUser['approval_required'])) {
                    $_SESSION['flash_message'] = "🛡️ Privilege Escalation Notice: Account provisioning for '{$createdUser['name']}' requires Founder / Superadmin sign-off. Request has been routed to the Executive HITL Queue.";
                    $_SESSION['flash_type'] = 'warning';
                } else {
                    $scopeTitle = $createdUser['access_scope'] === 'both' ? 'Both Admin & CRM' : ($createdUser['access_scope'] === 'admin_only' ? 'Website Admin Only' : 'CRM Only');
                    $_SESSION['flash_message'] = "New workforce account created for '{$createdUser['name']}' (@{$createdUser['username']}) with clearance [{$scopeTitle}] and " . count($createdUser['roles']) . " active multi-roles!";
                    $_SESSION['flash_type'] = 'success';
                }
            } catch (\Throwable $e) {
                $_SESSION['flash_message'] = 'Error creating user: ' . $e->getMessage();
                $_SESSION['flash_type'] = 'danger';
            }
            break;

        // --- 15. UPDATE USER & PERMISSIONS ---
        case 'update_user':
            $targetUserId = trim((string)($_POST['user_id'] ?? ''));
            if ($targetUserId === '') {
                $_SESSION['flash_message'] = 'Invalid user identifier.';
                $_SESSION['flash_type'] = 'danger';
                break;
            }

            try {
                $grantedPerms = isset($_POST['custom_granted']) && is_array($_POST['custom_granted']) ? $_POST['custom_granted'] : [];
                $deniedPerms = isset($_POST['custom_denied']) && is_array($_POST['custom_denied']) ? $_POST['custom_denied'] : [];
                $userAssignedRoles = isset($_POST['roles']) && is_array($_POST['roles']) ? $_POST['roles'] : null;
                $accessScope = isset($_POST['access_scope']) ? trim((string)$_POST['access_scope']) : null;

                $updatePayload = [
                    'name' => trim((string)($_POST['name'] ?? '')),
                    'username' => trim((string)($_POST['username'] ?? '')),
                    'email' => trim((string)($_POST['email'] ?? '')),
                    'phone' => trim((string)($_POST['phone'] ?? '')),
                    'title' => trim((string)($_POST['title'] ?? '')),
                    'department' => trim((string)($_POST['department'] ?? '')),
                    'bio' => trim((string)($_POST['bio'] ?? '')),
                    'status' => trim((string)($_POST['status'] ?? 'active')),
                    'custom_permissions' => [
                        'granted' => $grantedPerms,
                        'denied' => $deniedPerms
                    ]
                ];

                if (isset($_POST['avatar'])) {
                    $updatePayload['avatar'] = trim((string)$_POST['avatar']);
                }

                if ($userAssignedRoles !== null) {
                    $updatePayload['roles'] = $userAssignedRoles;
                }
                if ($accessScope !== null) {
                    $updatePayload['access_scope'] = $accessScope;
                }

                $updated = UserService::update($targetUserId, $updatePayload, $currentUser);

                // Handle optional avatar file upload if provided
                if (!empty($_FILES['avatar_file']['tmp_name']) && is_uploaded_file($_FILES['avatar_file']['tmp_name'])) {
                    UserService::uploadAvatar($targetUserId, $_FILES['avatar_file']);
                    $updated = UserService::getById($targetUserId);
                }

                if (!empty($updated['approval_required'])) {
                    $_SESSION['flash_message'] = "🛡️ Privilege Escalation Notice: High-authority changes (executive roles/portal access) for '{$updated['user']['name']}' require Founder / Superadmin sign-off. Request has been routed to the Executive HITL Queue.";
                    $_SESSION['flash_type'] = 'warning';
                } elseif ($updated) {
                    if (($currentUser['id'] ?? '') === $targetUserId) {
                        AuthService::refreshSessionUser();
                    }
                    $_SESSION['flash_message'] = "Profile & Multi-Role configuration for '{$updated['name']}' successfully updated!";
                    $_SESSION['flash_type'] = 'success';
                } else {
                    $_SESSION['flash_message'] = 'Target user not found.';
                    $_SESSION['flash_type'] = 'warning';
                }
            } catch (\Throwable $e) {
                $_SESSION['flash_message'] = 'Update failed: ' . $e->getMessage();
                $_SESSION['flash_type'] = 'danger';
            }
            break;

        // --- 16. CHANGE USER PASSWORD ---
        case 'change_user_password':
            if (!RBACService::hasPermission($userRoles, 'users.edit', $currentUser['custom_permissions'] ?? null)) {
                $_SESSION['flash_message'] = 'Permission denied: Cannot reset user credentials.';
                $_SESSION['flash_type'] = 'danger';
                break;
            }

            $targetUserId = trim((string)($_POST['user_id'] ?? ''));
            $newPass = (string)($_POST['new_password'] ?? '');

            try {
                if (UserService::updatePassword($targetUserId, $newPass)) {
                    $_SESSION['flash_message'] = 'Password reset successfully.';
                    $_SESSION['flash_type'] = 'success';
                } else {
                    $_SESSION['flash_message'] = 'Failed to reset password.';
                    $_SESSION['flash_type'] = 'danger';
                }
            } catch (\Throwable $e) {
                $_SESSION['flash_message'] = $e->getMessage();
                $_SESSION['flash_type'] = 'danger';
            }
            break;

        // --- 17. DELETE USER ---
        case 'delete_user':
            if (!RBACService::hasPermission($userRoles, 'users.delete', $currentUser['custom_permissions'] ?? null)) {
                $_SESSION['flash_message'] = 'Permission denied: Cannot remove team members.';
                $_SESSION['flash_type'] = 'danger';
                break;
            }

            $targetUserId = trim((string)($_POST['user_id'] ?? ''));
            try {
                if (UserService::delete($targetUserId, $currentUser['id'] ?? '')) {
                    $_SESSION['flash_message'] = 'User account deleted permanently.';
                    $_SESSION['flash_type'] = 'warning';
                } else {
                    $_SESSION['flash_message'] = 'Failed to delete user.';
                    $_SESSION['flash_type'] = 'danger';
                }
            } catch (\Throwable $e) {
                $_SESSION['flash_message'] = $e->getMessage();
                $_SESSION['flash_type'] = 'danger';
            }
            break;

        // --- 18. UPDATE MY OWN PROFILE ---
        case 'update_my_profile':
            $myId = $currentUser['id'] ?? '';
            if ($myId === '') {
                $_SESSION['flash_message'] = 'Active session error.';
                $_SESSION['flash_type'] = 'danger';
                break;
            }

            try {
                $myProfileData = [
                    'name' => trim((string)($_POST['name'] ?? $currentUser['name'])),
                    'phone' => trim((string)($_POST['phone'] ?? '')),
                    'title' => trim((string)($_POST['title'] ?? '')),
                    'department' => trim((string)($_POST['department'] ?? '')),
                    'bio' => trim((string)($_POST['bio'] ?? '')),
                    'timezone' => trim((string)($_POST['timezone'] ?? 'UTC')),
                    'currency' => trim((string)($_POST['currency'] ?? 'USD'))
                ];
                if (isset($_POST['avatar'])) {
                    $myProfileData['avatar'] = trim((string)$_POST['avatar']);
                }

                $updated = UserService::update($myId, $myProfileData);

                // Handle optional avatar file upload if provided in profile update
                if (!empty($_FILES['avatar_file']['tmp_name']) && is_uploaded_file($_FILES['avatar_file']['tmp_name'])) {
                    UserService::uploadAvatar($myId, $_FILES['avatar_file']);
                }

                AuthService::refreshSessionUser();
                $_SESSION['flash_message'] = 'Your personal profile details have been updated!';
                $_SESSION['flash_type'] = 'success';
            } catch (\Throwable $e) {
                $_SESSION['flash_message'] = 'Profile update error: ' . $e->getMessage();
                $_SESSION['flash_type'] = 'danger';
            }
            break;

        // --- 18b. UPLOAD AVATAR PHOTO DIRECTLY ---
        case 'upload_avatar':
            $myId = $currentUser['id'] ?? '';
            try {
                if (empty($_FILES['avatar_file']['tmp_name'])) {
                    throw new \InvalidArgumentException('Please select an image file to upload.');
                }
                UserService::uploadAvatar($myId, $_FILES['avatar_file']);
                AuthService::refreshSessionUser();
                $_SESSION['flash_message'] = 'Profile display picture successfully updated!';
                $_SESSION['flash_type'] = 'success';
            } catch (\Throwable $e) {
                $_SESSION['flash_message'] = 'Avatar upload failed: ' . $e->getMessage();
                $_SESSION['flash_type'] = 'danger';
            }
            break;

        // --- 18c. REMOVE AVATAR PHOTO ---
        case 'remove_avatar':
            $myId = $currentUser['id'] ?? '';
            try {
                UserService::removeAvatar($myId);
                AuthService::refreshSessionUser();
                $_SESSION['flash_message'] = 'Profile picture removed. Restored to default initials badge.';
                $_SESSION['flash_type'] = 'info';
            } catch (\Throwable $e) {
                $_SESSION['flash_message'] = 'Avatar removal error: ' . $e->getMessage();
                $_SESSION['flash_type'] = 'danger';
            }
            break;

        // --- 19. CHANGE MY OWN PASSWORD ---
        case 'change_my_password':
            $myId = $currentUser['id'] ?? '';
            $currentPass = (string)($_POST['current_password'] ?? '');
            $newPass = (string)($_POST['new_password'] ?? '');
            $confirmPass = (string)($_POST['confirm_password'] ?? '');

            if ($newPass !== $confirmPass) {
                $_SESSION['flash_message'] = 'New password confirmation does not match.';
                $_SESSION['flash_type'] = 'danger';
                break;
            }

            $userRec = UserService::getById($myId);
            if (!$userRec || empty($userRec['password_hash']) || !password_verify($currentPass, $userRec['password_hash'])) {
                $_SESSION['flash_message'] = 'Incorrect current password.';
                $_SESSION['flash_type'] = 'danger';
                break;
            }

            try {
                UserService::updatePassword($myId, $newPass);
                $_SESSION['flash_message'] = 'Your password has been changed successfully!';
                $_SESSION['flash_type'] = 'success';
            } catch (\Throwable $e) {
                $_SESSION['flash_message'] = $e->getMessage();
                $_SESSION['flash_type'] = 'danger';
            }
            break;

        // --- 20. CREATE / UPDATE CUSTOM ROLE ---
        case 'save_role':
            if (!RBACService::hasPermission($userRoles, 'roles.manage', $currentUser['custom_permissions'] ?? null)) {
                $_SESSION['flash_message'] = 'Permission denied: Cannot manage roles & permissions.';
                $_SESSION['flash_type'] = 'danger';
                break;
            }

            $slug = strtolower(trim((string)($_POST['slug'] ?? '')));
            $name = trim((string)($_POST['name'] ?? ''));
            $desc = trim((string)($_POST['description'] ?? ''));
            $color = trim((string)($_POST['color'] ?? 'info'));
            $perms = isset($_POST['permissions']) && is_array($_POST['permissions']) ? $_POST['permissions'] : [];

            if ($slug === '' || $name === '') {
                $_SESSION['flash_message'] = 'Role Slug and Role Name are required.';
                $_SESSION['flash_type'] = 'danger';
                break;
            }

            RBACService::saveRole([
                'slug' => $slug,
                'name' => $name,
                'description' => $desc,
                'color' => $color,
                'permissions' => $perms
            ]);

            $_SESSION['flash_message'] = "Role '{$name}' saved with " . count($perms) . " permissions configured!";
            $_SESSION['flash_type'] = 'success';
            break;

        // --- 21. DELETE CUSTOM ROLE ---
        case 'delete_role':
            if (!RBACService::hasPermission($userRoles, 'roles.manage', $currentUser['custom_permissions'] ?? null)) {
                $_SESSION['flash_message'] = 'Permission denied: Cannot remove roles.';
                $_SESSION['flash_type'] = 'danger';
                break;
            }

            $slug = trim((string)($_POST['slug'] ?? ''));
            if (RBACService::deleteRole($slug)) {
                $_SESSION['flash_message'] = "Role '{$slug}' deleted successfully.";
                $_SESSION['flash_type'] = 'info';
            } else {
                $_SESSION['flash_message'] = 'Protected system roles cannot be deleted.';
                $_SESSION['flash_type'] = 'danger';
            }
            break;
    }

    header('Location: ' . $returnUrl);
    exit;
}

// -------------------------------------------------------------
// Data Aggregation for View Rendering
// -------------------------------------------------------------
$leads = LeadService::getAll();
$opportunities = OpportunityService::getAll();
$projects = ProjectService::getAll();
$pendingApprovals = ApprovalService::getPending();
$allApprovals = ApprovalService::getAll();
$agents = PaperclipService::getAgents();
$paperclipTasks = PaperclipService::getTasks();
$paperclipConn = PaperclipService::checkConnection();

// KPI Calculations
$totalLeads = count($leads);
$activeLeads = count(array_filter($leads, fn($l) => !in_array($l['status'] ?? '', ['closed', 'disqualified'], true)));
$activePipelineDeals = array_filter($opportunities, fn($o) => !in_array($o['stage'] ?? '', ['closed_won', 'closed_lost'], true));
$pipelineValue = array_sum(array_column($activePipelineDeals, 'value'));
$closedWonDeals = array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'closed_won');
$closedWonValue = array_sum(array_column($closedWonDeals, 'value'));
$activeProjectsCount = count(array_filter($projects, fn($p) => ($p['status'] ?? '') === 'in_progress'));
$activeAgentsCount = count($agents);

$liveExchangeRates = CurrencyService::getRates();
$csrfToken = CrmSecurity::csrfToken();

// Workforce & RBAC Aggregation
$allUsers = UserService::getAll();
$allRoles = RBACService::getAllRoles();
$allModules = RBACService::getAllModules();
$effectiveUserPerms = RBACService::getEffectivePermissions(
    (array)($currentUser['roles'] ?? ['admin']),
    (array)($currentUser['custom_permissions'] ?? null)
);
$totalWorkforceCount = count($allUsers);
$activeRolesCount = count($allRoles);

