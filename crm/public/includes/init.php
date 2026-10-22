<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Shared Initialization & Bootstrap
 * Handles namespace, services, session, CSRF, auth check, and shared data models.
 */

namespace CRM;

use CRM\Services\StorageService;
use CRM\Services\LeadService;
use CRM\Services\OpportunityService;
use CRM\Services\ProjectService;
use CRM\Services\ApprovalService;
use CRM\Services\PaperclipService;
use CRM\Services\RBACService;
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
require_once $crmRoot . '/app/Services/AuthService.php';
require_once $crmRoot . '/app/Services/CrmSecurity.php';
require_once $crmRoot . '/app/Services/CurrencyService.php';

StorageService::init($crmRoot . '/storage');
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
    $returnPage = trim((string)($_POST['return_page'] ?? ''));
    if ($returnPage === '') {
        $returnPage = basename($_SERVER['PHP_SELF'], '.php');
        if ($returnPage === 'index') {
            $returnPage = 'dashboard';
        }
    }

    if (!CrmSecurity::verifyCsrf($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        $_SESSION['flash_message'] = 'Security validation failed (CSRF token expired). Please try again.';
        $_SESSION['flash_type'] = 'danger';
        header('Location: ' . $returnPage);
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
    }

    header('Location: ' . $returnPage);
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
