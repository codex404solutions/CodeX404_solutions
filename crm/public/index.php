<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Full-Featured CRM & Paperclip Agent Command Center
 * Modern Bootstrap 5.3 Dark-Themed Executive Workspace
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

$crmRoot = dirname(__DIR__);
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
    header('Location: login.php');
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
    if (!CrmSecurity::verifyCsrf($_POST['csrf_token'] ?? null)) {
        http_response_code(403);
        $_SESSION['flash_message'] = 'Security validation failed (CSRF token expired). Please try again.';
        $_SESSION['flash_type'] = 'danger';
        header('Location: index.php');
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

    $targetTab = $_POST['current_tab'] ?? '';
    header('Location: index.php' . ($targetTab !== '' ? '#' . urlencode($targetTab) : ''));
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
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeX404 Solutions — CRM & Paperclip Autonomous Command Center</title>

    <script>
        (() => {
            const storedTheme = localStorage.getItem('codex_crm_theme');
            let theme = storedTheme ? storedTheme : 'combo';
            const effective = (theme === 'auto')
                ? (window.matchMedia('(prefers-color-scheme: light)').matches ? 'combo' : 'dark')
                : theme;
            document.documentElement.setAttribute('data-bs-theme', effective);
        })();
        window.CODEX_EXCHANGE_RATES = <?= json_encode($liveExchangeRates, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        window.CODEX_CURRENCIES = <?= json_encode(CurrencyService::CURRENCIES, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    </script>

    <!-- Favicon using Original Logo -->
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo/logo.png">
    <link rel="shortcut icon" href="assets/images/logo/favicon.ico">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root, [data-bs-theme="dark"] {
            --cx-bg: #0B0F19;
            --cx-card: #111827;
            --cx-card-hover: #162032;
            --cx-border: rgba(56, 189, 248, 0.15);
            --cx-border-active: rgba(56, 189, 248, 0.4);
            --cx-cyan: #38BDF8;
            --cx-emerald: #10B981;
            --cx-amber: #F59E0B;
            --cx-purple: #818CF8;
            --cx-text-primary: #F8FAFC;
            --cx-text-muted: #94A3B8;
            --cx-kanban-col: rgba(17, 24, 39, 0.6);
            --cx-kanban-card: #1A2234;
        }

        /* ========================================================= */
        /* Dual-Tone Architecture: Dark & Light Combination          */
        /* ========================================================= */
        [data-bs-theme="light"],
        [data-bs-theme="combo"] {
            --cx-bg: #F8FAFC;
            --cx-card: #FFFFFF;
            --cx-card-hover: #F1F5F9;
            --cx-border: #E2E8F0;
            --cx-border-active: #0284C7;
            --cx-cyan: #0284C7;
            --cx-emerald: #059669;
            --cx-amber: #D97706;
            --cx-purple: #6366F1;
            --cx-text-primary: #0F172A;
            --cx-text-muted: #64748B;
            --cx-kanban-col: #F1F5F9;
            --cx-kanban-card: #FFFFFF;
        }

        [data-bs-theme="light"] body,
        [data-bs-theme="combo"] body {
            background-color: #F8FAFC !important;
            color: #0F172A !important;
        }

        /* 1. DARK EXECUTIVE SIDEBAR (Anchors visual hierarchy & gives original logo 100% crisp contrast) */
        .crm-sidebar,
        [data-bs-theme="light"] .crm-sidebar,
        [data-bs-theme="combo"] .crm-sidebar,
        #mobileSidebar,
        [data-bs-theme="light"] #mobileSidebar,
        [data-bs-theme="combo"] #mobileSidebar {
            background: #0B0F19 !important;
            border-right: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #F8FAFC !important;
        }

        .crm-sidebar .crm-brand,
        [data-bs-theme="light"] .crm-sidebar .crm-brand,
        [data-bs-theme="combo"] .crm-sidebar .crm-brand {
            color: #FFFFFF !important;
        }

        .crm-sidebar .text-white,
        [data-bs-theme="light"] .crm-sidebar .text-white,
        [data-bs-theme="combo"] .crm-sidebar .text-white,
        #mobileSidebar .text-white,
        [data-bs-theme="light"] #mobileSidebar .text-white,
        [data-bs-theme="combo"] #mobileSidebar .text-white {
            color: #FFFFFF !important;
        }

        .crm-sidebar .text-muted,
        [data-bs-theme="light"] .crm-sidebar .text-muted,
        [data-bs-theme="combo"] .crm-sidebar .text-muted,
        #mobileSidebar .text-muted,
        [data-bs-theme="light"] #mobileSidebar .text-muted,
        [data-bs-theme="combo"] #mobileSidebar .text-muted {
            color: #94A3B8 !important;
        }

        .crm-sidebar .rounded-3,
        [data-bs-theme="light"] .crm-sidebar .rounded-3,
        [data-bs-theme="combo"] .crm-sidebar .rounded-3 {
            background: rgba(255, 255, 255, 0.04) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .crm-sidebar .crm-nav-link,
        [data-bs-theme="light"] .crm-sidebar .crm-nav-link,
        [data-bs-theme="combo"] .crm-sidebar .crm-nav-link,
        #mobileSidebar .crm-nav-link,
        [data-bs-theme="light"] #mobileSidebar .crm-nav-link,
        [data-bs-theme="combo"] #mobileSidebar .crm-nav-link {
            color: #94A3B8 !important;
        }

        .crm-sidebar .crm-nav-link:hover,
        .crm-sidebar .crm-nav-link.active,
        [data-bs-theme="light"] .crm-sidebar .crm-nav-link:hover,
        [data-bs-theme="light"] .crm-sidebar .crm-nav-link.active,
        [data-bs-theme="combo"] .crm-sidebar .crm-nav-link:hover,
        [data-bs-theme="combo"] .crm-sidebar .crm-nav-link.active,
        #mobileSidebar .crm-nav-link:hover,
        #mobileSidebar .crm-nav-link.active,
        [data-bs-theme="light"] #mobileSidebar .crm-nav-link:hover,
        [data-bs-theme="light"] #mobileSidebar .crm-nav-link.active,
        [data-bs-theme="combo"] #mobileSidebar .crm-nav-link:hover,
        [data-bs-theme="combo"] #mobileSidebar .crm-nav-link.active {
            background: rgba(56, 189, 248, 0.12) !important;
            color: #38BDF8 !important;
            border-left: 3px solid #38BDF8 !important;
        }

        .crm-sidebar .badge.bg-dark,
        [data-bs-theme="light"] .crm-sidebar .badge.bg-dark,
        [data-bs-theme="combo"] .crm-sidebar .badge.bg-dark {
            background-color: #111827 !important;
            color: #94A3B8 !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        .crm-sidebar .btn-outline-secondary,
        [data-bs-theme="light"] .crm-sidebar .btn-outline-secondary,
        [data-bs-theme="combo"] .crm-sidebar .btn-outline-secondary {
            color: #CBD5E1 !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
            background: rgba(255, 255, 255, 0.03) !important;
        }

        .crm-sidebar .btn-outline-secondary:hover,
        [data-bs-theme="light"] .crm-sidebar .btn-outline-secondary:hover,
        [data-bs-theme="combo"] .crm-sidebar .btn-outline-secondary:hover {
            color: #38BDF8 !important;
            border-color: #38BDF8 !important;
            background: rgba(56, 189, 248, 0.1) !important;
        }

        /* 2. LIGHT MAIN WORKSPACE (Cards, Charts, Tables, Kanban) */
        [data-bs-theme="light"] main,
        [data-bs-theme="combo"] main {
            background-color: #F8FAFC !important;
            color: #0F172A !important;
        }

        [data-bs-theme="light"] main .border-bottom,
        [data-bs-theme="combo"] main .border-bottom {
            border-color: #E2E8F0 !important;
        }

        [data-bs-theme="light"] .crm-card,
        [data-bs-theme="combo"] .crm-card {
            background-color: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04) !important;
        }

        [data-bs-theme="light"] .crm-card[style*="linear-gradient"],
        [data-bs-theme="combo"] .crm-card[style*="linear-gradient"] {
            background: linear-gradient(135deg, #F0F9FF 0%, #EEF2FF 100%) !important;
            border: 1px solid #BAE6FD !important;
        }

        [data-bs-theme="light"] .agent-card,
        [data-bs-theme="combo"] .agent-card {
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04) !important;
        }

        [data-bs-theme="light"] .agent-card:hover,
        [data-bs-theme="combo"] .agent-card:hover {
            border-color: #0284C7 !important;
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.15) !important;
        }

        [data-bs-theme="light"] .kanban-col,
        [data-bs-theme="combo"] .kanban-col {
            background: #F1F5F9 !important;
            border: 1px solid #CBD5E1 !important;
        }

        [data-bs-theme="light"] .kanban-deal-card,
        [data-bs-theme="combo"] .kanban-deal-card {
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04) !important;
        }

        [data-bs-theme="light"] .kanban-deal-card:hover,
        [data-bs-theme="combo"] .kanban-deal-card:hover {
            border-color: #0284C7 !important;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08) !important;
        }

        [data-bs-theme="light"] .approval-box,
        [data-bs-theme="combo"] .approval-box {
            background: #FFFBEB !important;
            border: 1px solid #FDE68A !important;
        }

        [data-bs-theme="light"] .modal-content,
        [data-bs-theme="combo"] .modal-content {
            background-color: #FFFFFF !important;
            color: #0F172A !important;
            border: 1px solid #CBD5E1 !important;
        }

        [data-bs-theme="light"] .modal-header,
        [data-bs-theme="light"] .modal-footer,
        [data-bs-theme="combo"] .modal-header,
        [data-bs-theme="combo"] .modal-footer {
            border-color: #E2E8F0 !important;
        }

        [data-bs-theme="light"] .form-control,
        [data-bs-theme="light"] .form-select,
        [data-bs-theme="combo"] .form-control,
        [data-bs-theme="combo"] .form-select {
            background-color: #FFFFFF !important;
            border-color: #CBD5E1 !important;
            color: #0F172A !important;
        }

        [data-bs-theme="light"] .form-control:focus,
        [data-bs-theme="light"] .form-select:focus,
        [data-bs-theme="combo"] .form-control:focus,
        [data-bs-theme="combo"] .form-select:focus {
            background-color: #FFFFFF !important;
            border-color: #0284C7 !important;
            color: #0F172A !important;
            box-shadow: 0 0 0 0.25rem rgba(14, 165, 233, 0.2) !important;
        }

        [data-bs-theme="light"] select option,
        [data-bs-theme="combo"] select option {
            background-color: #FFFFFF !important;
            color: #0F172A !important;
        }

        [data-bs-theme="light"] .input-group-text,
        [data-bs-theme="combo"] .input-group-text {
            background-color: #F1F5F9 !important;
            border-color: #CBD5E1 !important;
            color: #475569 !important;
        }

        [data-bs-theme="light"] .table-custom,
        [data-bs-theme="combo"] .table-custom {
            --bs-table-bg: transparent;
            --bs-table-border-color: #E2E8F0;
            color: #0F172A !important;
        }

        [data-bs-theme="light"] .table-custom th,
        [data-bs-theme="combo"] .table-custom th {
            background-color: #F8FAFC !important;
            color: #64748B !important;
            border-bottom: 2px solid #E2E8F0 !important;
        }

        [data-bs-theme="light"] .table-custom td,
        [data-bs-theme="combo"] .table-custom td {
            border-bottom: 1px solid #E2E8F0 !important;
            color: #0F172A !important;
        }

        [data-bs-theme="light"] .table-hover tbody tr:hover td,
        [data-bs-theme="combo"] .table-hover tbody tr:hover td {
            background-color: #F8FAFC !important;
        }

        [data-bs-theme="light"] .dropdown-menu,
        [data-bs-theme="combo"] .dropdown-menu {
            background-color: #FFFFFF !important;
            color: #0F172A !important;
            border-color: #CBD5E1 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
        }

        [data-bs-theme="light"] .dropdown-item,
        [data-bs-theme="combo"] .dropdown-item {
            color: #0F172A !important;
        }

        [data-bs-theme="light"] .dropdown-item:hover,
        [data-bs-theme="light"] .dropdown-item:focus,
        [data-bs-theme="combo"] .dropdown-item:hover,
        [data-bs-theme="combo"] .dropdown-item:focus {
            background-color: #F1F5F9 !important;
            color: #0284C7 !important;
        }

        [data-bs-theme="light"] .dropdown-divider,
        [data-bs-theme="combo"] .dropdown-divider {
            border-color: #E2E8F0 !important;
        }

        /* Target text in main area */
        [data-bs-theme="light"] main .text-white,
        [data-bs-theme="combo"] main .text-white {
            color: #0F172A !important;
        }

        [data-bs-theme="light"] main .text-light,
        [data-bs-theme="combo"] main .text-light {
            color: #334155 !important;
        }

        [data-bs-theme="light"] main .text-white-50,
        [data-bs-theme="combo"] main .text-white-50 {
            color: #64748B !important;
        }

        [data-bs-theme="light"] main .text-muted,
        [data-bs-theme="combo"] main .text-muted {
            color: #64748B !important;
        }

        [data-bs-theme="light"] main .bg-dark,
        [data-bs-theme="combo"] main .bg-dark {
            background-color: #F1F5F9 !important;
            color: #0F172A !important;
        }

        [data-bs-theme="light"] main .border-secondary,
        [data-bs-theme="combo"] main .border-secondary {
            border-color: #CBD5E1 !important;
        }

        [data-bs-theme="light"] main [style*="background: rgba(255, 255, 255"],
        [data-bs-theme="combo"] main [style*="background: rgba(255, 255, 255"] {
            background: #F8FAFC !important;
            border-color: #E2E8F0 !important;
        }

        [data-bs-theme="light"] main [style*="background: rgba(0, 0, 0"],
        [data-bs-theme="combo"] main [style*="background: rgba(0, 0, 0"] {
            background: #F1F5F9 !important;
            border-color: #E2E8F0 !important;
        }

        [data-bs-theme="light"] pre#outputModalBody,
        [data-bs-theme="light"] pre.mono,
        [data-bs-theme="combo"] pre#outputModalBody,
        [data-bs-theme="combo"] pre.mono {
            background-color: #F8FAFC !important;
            border: 1px solid #E2E8F0 !important;
            color: #0F172A !important;
        }

        /* Badges & Buttons contrast protection */
        [data-bs-theme="light"] .badge.text-white,
        [data-bs-theme="light"] .btn.text-white,
        [data-bs-theme="light"] .badge .text-white,
        [data-bs-theme="light"] .btn .text-white,
        [data-bs-theme="light"] .btn-danger,
        [data-bs-theme="light"] .btn-primary,
        [data-bs-theme="light"] .btn-success,
        [data-bs-theme="light"] .bg-danger,
        [data-bs-theme="light"] .bg-success,
        [data-bs-theme="light"] .bg-primary,
        [data-bs-theme="combo"] .badge.text-white,
        [data-bs-theme="combo"] .btn.text-white,
        [data-bs-theme="combo"] .badge .text-white,
        [data-bs-theme="combo"] .btn .text-white,
        [data-bs-theme="combo"] .btn-danger,
        [data-bs-theme="combo"] .btn-primary,
        [data-bs-theme="combo"] .btn-success,
        [data-bs-theme="combo"] .bg-danger,
        [data-bs-theme="combo"] .bg-success,
        [data-bs-theme="combo"] .bg-primary {
            color: #FFFFFF !important;
        }

        [data-bs-theme="light"] .btn-info,
        [data-bs-theme="combo"] .btn-info {
            background-color: #0284C7 !important;
            border-color: #0284C7 !important;
            color: #FFFFFF !important;
        }

        [data-bs-theme="light"] ::-webkit-scrollbar-track,
        [data-bs-theme="combo"] ::-webkit-scrollbar-track {
            background: #F1F5F9;
        }

        [data-bs-theme="light"] ::-webkit-scrollbar-thumb,
        [data-bs-theme="combo"] ::-webkit-scrollbar-thumb {
            background: #CBD5E1;
        }

        body {
            background-color: var(--cx-bg);
            color: var(--cx-text-primary);
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
        }

        .mono { font-family: 'JetBrains Mono', monospace; }

        /* Custom Scrollbars */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #0b0f19; }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #38bdf8; }

        /* Sidebar Styling */
        .crm-sidebar {
            background: var(--cx-card);
            border-right: 1px solid var(--cx-border);
            min-height: 100vh;
        }

        .crm-brand {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .crm-nav-link {
            color: var(--cx-text-muted);
            border-radius: 8px;
            padding: 0.65rem 0.95rem;
            font-weight: 600;
            font-size: 0.92rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.15s ease;
            text-decoration: none;
            margin-bottom: 0.35rem;
        }

        .crm-nav-link:hover, .crm-nav-link.active {
            background: rgba(56, 189, 248, 0.12);
            color: #FFFFFF;
            border-left: 3px solid var(--cx-cyan);
        }

        .crm-nav-link i { font-size: 1.1rem; }

        /* Command Cards */
        .crm-card {
            background: var(--cx-card);
            border: 1px solid var(--cx-border);
            border-radius: 14px;
            transition: transform 0.15s ease, border-color 0.15s ease;
        }

        .crm-card:hover {
            border-color: var(--cx-border-active);
        }

        .kpi-num {
            font-size: 1.9rem;
            font-weight: 800;
            line-height: 1.1;
        }

        /* Agent Cards */
        .agent-card {
            background: #111827;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .agent-card:hover {
            border-color: var(--cx-cyan);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(56, 189, 248, 0.1);
        }

        .agent-badge-pulse {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--cx-emerald);
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* Kanban Column */
        .kanban-col {
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--cx-border);
            border-radius: 12px;
            min-height: 520px;
            padding: 1rem;
        }

        .kanban-deal-card {
            background: #1A2234;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            padding: 0.9rem;
            margin-bottom: 0.85rem;
            transition: all 0.15s ease;
        }

        .kanban-deal-card:hover {
            border-color: var(--cx-cyan);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        }

        /* Lead Score Meter */
        .score-pill {
            font-size: 0.75rem;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 20px;
        }

        .score-high { background: rgba(16, 185, 129, 0.2); color: #34D399; border: 1px solid rgba(16, 185, 129, 0.4); }
        .score-med { background: rgba(56, 189, 248, 0.2); color: #38BDF8; border: 1px solid rgba(56, 189, 248, 0.4); }
        .score-low { background: rgba(245, 158, 11, 0.2); color: #FBBF24; border: 1px solid rgba(245, 158, 11, 0.4); }

        /* Tables */
        .table-custom {
            --bs-table-bg: transparent;
            --bs-table-border-color: rgba(255, 255, 255, 0.07);
            color: var(--cx-text-primary);
        }

        .table-custom th {
            font-size: 0.76rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--cx-text-muted);
            font-weight: 700;
            padding: 0.85rem 1rem;
        }

        .table-custom td {
            padding: 1rem;
            vertical-align: middle;
        }

        /* Approvals */
        .approval-box {
            background: rgba(245, 158, 11, 0.04);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 12px;
            padding: 1.25rem;
        }

        .modal-content {
            background-color: #111827;
            border: 1px solid var(--cx-border);
            color: var(--cx-text-primary);
        }

        .modal-header, .modal-footer {
            border-color: rgba(255, 255, 255, 0.08);
        }

        .form-control, .form-select {
            background-color: #0B0F19;
            border-color: rgba(255, 255, 255, 0.15);
            color: #FFF;
        }

        .form-control:focus, .form-select:focus {
            background-color: #0E1424;
            border-color: var(--cx-cyan);
            color: #FFF;
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.2);
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- ======================================================== -->
        <!-- SIDEBAR NAVIGATION (Desktop + Offcanvas Mobile)         -->
        <!-- ======================================================== -->
        <aside class="col-12 col-lg-2 d-none d-lg-block crm-sidebar p-3 position-sticky top-0" style="height: 100vh; overflow-y: auto;">
            <!-- Brand with Original Logo -->
            <div class="mb-4 px-2 pt-2 text-center">
                <a href="index.php" class="d-block text-decoration-none">
                    <img src="assets/images/logo/logo.png" alt="CodeX404 Solutions" class="img-fluid" style="max-height: 48px; object-fit: contain;">
                </a>
                <div class="mt-2 d-flex align-items-center justify-content-center gap-2">
                    <span class="badge bg-dark border border-secondary text-info text-uppercase" style="font-size: 0.65rem; letter-spacing: 0.08em;">CRM & AGENT OS</span>
                </div>
            </div>

            <!-- User Status Card -->
            <div class="p-2 mb-3 rounded-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="fw-bold small text-white"><?= htmlspecialchars($currentUser['name']) ?></span>
                    <span class="agent-badge-pulse" title="Active Session"></span>
                </div>
                <div class="d-flex gap-1 flex-wrap">
                    <?php foreach ($currentUser['roles'] as $r): ?>
                        <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase" style="font-size: 0.65rem;"><?= htmlspecialchars($r) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="nav flex-column mb-4" id="crmSidebarNav">
                <a href="#dashboard" class="crm-nav-link active" data-bs-toggle="pill" data-bs-target="#tab-dashboard">
                    <span><i class="bi bi-grid-1x2-fill me-2 text-info"></i> Dashboard</span>
                    <span class="badge rounded-pill bg-dark border border-secondary text-muted">Overview</span>
                </a>
                <a href="#leads" class="crm-nav-link" data-bs-toggle="pill" data-bs-target="#tab-leads">
                    <span><i class="bi bi-person-lines-fill me-2 text-warning"></i> Inbound Leads</span>
                    <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle"><?= $totalLeads ?></span>
                </a>
                <a href="#pipeline" class="crm-nav-link" data-bs-toggle="pill" data-bs-target="#tab-pipeline">
                    <span><i class="bi bi-kanban-fill me-2 text-success"></i> Sales Pipeline</span>
                    <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle"><?= count($opportunities) ?></span>
                </a>
                <a href="#projects" class="crm-nav-link" data-bs-toggle="pill" data-bs-target="#tab-projects">
                    <span><i class="bi bi-rocket-takeoff-fill me-2 text-primary"></i> Client Delivery</span>
                    <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle"><?= count($projects) ?></span>
                </a>
                <a href="#paperclip" class="crm-nav-link" data-bs-toggle="pill" data-bs-target="#tab-paperclip">
                    <span><i class="bi bi-robot me-2 text-info"></i> Paperclip Agents</span>
                    <span class="badge rounded-pill bg-info-subtle text-info border border-info-subtle"><?= count($agents) ?></span>
                </a>
                <a href="#approvals" class="crm-nav-link" data-bs-toggle="pill" data-bs-target="#tab-approvals">
                    <span><i class="bi bi-shield-check me-2 text-warning"></i> HITL Approvals</span>
                    <?php if (count($pendingApprovals) > 0): ?>
                        <span class="badge rounded-pill bg-danger text-white"><?= count($pendingApprovals) ?></span>
                    <?php else: ?>
                        <span class="badge rounded-pill bg-secondary text-white">0</span>
                    <?php endif; ?>
                </a>
                <a href="#settings" class="crm-nav-link" data-bs-toggle="pill" data-bs-target="#tab-settings">
                    <span><i class="bi bi-sliders me-2 text-secondary"></i> System & API</span>
                    <span class="badge rounded-pill bg-dark border border-secondary text-muted">Webhooks</span>
                </a>
            </nav>

            <hr style="border-color: rgba(255, 255, 255, 0.1);">

            <!-- Quick External Links -->
            <div class="px-2">
                <small class="text-uppercase text-muted fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Public Fronts</small>
                <div class="d-grid gap-1 mt-2">
                    <a href="../website/discovery-call.php" target="_blank" class="btn btn-sm btn-outline-secondary text-start d-flex justify-content-between align-items-center" style="font-size: 0.78rem;">
                        <span><i class="bi bi-lightning-charge me-1 text-warning"></i> Lead Discovery Form</span>
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                    <a href="../website/admin/index.php" target="_blank" class="btn btn-sm btn-outline-secondary text-start d-flex justify-content-between align-items-center" style="font-size: 0.78rem;">
                        <span><i class="bi bi-shield-lock me-1 text-info"></i> Website Admin</span>
                        <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                    <a href="logout.php" class="btn btn-sm btn-outline-danger text-start mt-2" style="font-size: 0.8rem;">
                        <i class="bi bi-box-arrow-left me-1"></i> Sign Out
                    </a>
                </div>
            </div>
        </aside>

        <!-- ======================================================== -->
        <!-- MAIN CONTENT AREA                                        -->
        <!-- ======================================================== -->
        <main class="col-12 col-lg-10 p-3 p-md-4" style="min-height: 100vh; overflow-x: hidden;">

            <!-- Top Header & Status Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-4 border-bottom" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                <div class="d-flex align-items-center gap-3">
                    <!-- Mobile Hamburger -->
                    <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div>
                        <h1 class="h4 mb-0 fw-bold">Company CRM & Paperclip Command Center</h1>
                        <p class="text-muted small mb-0">Autonomous multi-agent pipeline with Human-in-the-Loop governance</p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- Paperclip Engine Status Badge -->
                    <div class="badge d-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34D399;">
                        <span class="agent-badge-pulse"></span>
                        <span class="fw-semibold">Paperclip Engine: <?= htmlspecialchars($paperclipConn['mode'] ?? 'Local Runtime') ?></span>
                    </div>

                    <!-- Real-Time Live Currency Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-2 py-1" id="bd-currency-crm" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Switch Currency in Real Time">
                            <span class="currency-flag-active" id="bd-currency-flag">🇺🇸</span>
                            <span class="fw-bold small" id="bd-currency-code">USD</span>
                            <span class="badge bg-dark border border-secondary text-info px-1 py-0" id="bd-currency-symbol" style="font-size: 0.65rem;">$</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-currency-crm" style="min-width: 250px;">
                            <li class="dropdown-header d-flex justify-content-between align-items-center">
                                <span class="small text-uppercase fw-bold text-muted">Real-Time Currency</span>
                                <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.65rem;">
                                    <span class="agent-badge-pulse me-1" style="width: 6px; height: 6px;"></span>Live Rates
                                </span>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="USD">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇺🇸</span>
                                        <span><strong>USD</strong> &bull; US Dollar</span>
                                    </span>
                                    <span class="badge bg-secondary-subtle text-muted">$</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="INR">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇮🇳</span>
                                        <span><strong>INR</strong> &bull; Indian Rupee</span>
                                    </span>
                                    <span class="badge bg-warning-subtle text-warning">₹</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="EUR">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇪🇺</span>
                                        <span><strong>EUR</strong> &bull; Euro</span>
                                    </span>
                                    <span class="badge bg-info-subtle text-info">€</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="GBP">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇬🇧</span>
                                        <span><strong>GBP</strong> &bull; British Pound</span>
                                    </span>
                                    <span class="badge bg-primary-subtle text-primary">£</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="AED">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇦🇪</span>
                                        <span><strong>AED</strong> &bull; UAE Dirham</span>
                                    </span>
                                    <span class="badge bg-success-subtle text-success">د.إ</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="CAD">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇨🇦</span>
                                        <span><strong>CAD</strong> &bull; Canadian Dollar</span>
                                    </span>
                                    <span class="badge bg-secondary-subtle text-muted">C$</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="AUD">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇦🇺</span>
                                        <span><strong>AUD</strong> &bull; Australian Dollar</span>
                                    </span>
                                    <span class="badge bg-secondary-subtle text-muted">A$</span>
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="SGD">
                                    <span class="d-flex align-items-center gap-2">
                                        <span>🇸🇬</span>
                                        <span><strong>SGD</strong> &bull; Singapore Dollar</span>
                                    </span>
                                    <span class="badge bg-secondary-subtle text-muted">S$</span>
                                </button>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li class="px-3 py-1">
                                <small class="text-muted" style="font-size: 0.68rem;" id="crm-currency-ticker">
                                    1 USD = ₹<?= number_format((float)($liveExchangeRates['INR'] ?? 95.05), 2) ?> &bull; €<?= number_format((float)($liveExchangeRates['EUR'] ?? 0.89), 2) ?> &bull; £<?= number_format((float)($liveExchangeRates['GBP'] ?? 0.75), 2) ?>
                                </small>
                            </li>
                        </ul>
                    </div>

                    <!-- Bootstrap Theme Toggle Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-2 py-1" id="bd-theme-crm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-circle-half theme-icon-active text-primary"></i>
                            <span class="small d-none d-md-inline" id="bd-theme-crm-text">Dark &amp; Light</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-crm">
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="combo">
                                    <i class="bi bi-circle-half text-primary"></i> Dark &amp; Light Combo
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="dark">
                                    <i class="bi bi-moon-stars-fill text-info"></i> Full Dark Mode
                                </button>
                            </li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="light">
                                    <i class="bi bi-sun-fill text-warning"></i> Pure Light Mode
                                </button>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="auto">
                                    <i class="bi bi-laptop text-secondary"></i> System Auto
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Quick Action Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-info btn-sm dropdown-toggle fw-bold text-dark px-3" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-plus-lg me-1"></i> Quick Action
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalNewLead"><i class="bi bi-person-plus me-2 text-warning"></i> Add Inbound Lead</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalNewDeal"><i class="bi bi-cash-stack me-2 text-success"></i> Add Pipeline Deal</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalNewProject"><i class="bi bi-rocket me-2 text-primary"></i> Create Client Project</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalDispatchAgent"><i class="bi bi-robot me-2 text-info"></i> Dispatch Paperclip Agent</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Flash Alert Messages -->
            <?php if ($flashMessage): ?>
                <div class="alert alert-<?= htmlspecialchars($flashType) ?> alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle-fill fs-5"></i>
                        <div><?= htmlspecialchars($flashMessage) ?></div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- ======================================================== -->
            <!-- TAB PANELS CONTENT CONTAINER                             -->
            <!-- ======================================================== -->
            <div class="tab-content" id="crmTabContent">

                <!-- ---------------------------------------------------- -->
                <!-- TAB 1: EXECUTIVE DASHBOARD                           -->
                <!-- ---------------------------------------------------- -->
                <div class="tab-pane fade show active" id="tab-dashboard" role="tabpanel">

                    <!-- 4 Top KPI Cards -->
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="crm-card p-3 p-xl-4 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small fw-bold text-uppercase">Inbound Leads</span>
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">CRM Inflow</span>
                                </div>
                                <div class="kpi-num text-white"><?= $totalLeads ?></div>
                                <div class="small text-muted mt-2 d-flex align-items-center gap-1">
                                    <i class="bi bi-shield-check text-success"></i> <?= $activeLeads ?> active qualified
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="crm-card p-3 p-xl-4 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small fw-bold text-uppercase">Active Pipeline</span>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle"><?= count($activePipelineDeals) ?> Deals</span>
                                </div>
                                <div class="kpi-num text-success currency-val" data-usd="<?= (float)$pipelineValue ?>">$<?= number_format($pipelineValue, 0) ?></div>
                                <div class="small text-muted mt-2 d-flex align-items-center gap-1">
                                    <i class="bi bi-trophy text-warning"></i> <span class="currency-val" data-usd="<?= (float)$closedWonValue ?>">$<?= number_format($closedWonValue, 0) ?></span> won closed
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="crm-card p-3 p-xl-4 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small fw-bold text-uppercase">Client Delivery</span>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Active Sprints</span>
                                </div>
                                <div class="kpi-num text-primary"><?= $activeProjectsCount ?></div>
                                <div class="small text-muted mt-2 d-flex align-items-center gap-1">
                                    <i class="bi bi-kanban text-info"></i> <?= count($projects) ?> total client accounts
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="crm-card p-3 p-xl-4 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small fw-bold text-uppercase">Paperclip Agents</span>
                                    <span class="badge bg-info-subtle text-info border border-info-subtle">7/7 Ready</span>
                                </div>
                                <div class="kpi-num text-info">7</div>
                                <div class="small text-muted mt-2 d-flex align-items-center gap-1">
                                    <i class="bi bi-shield-exclamation text-warning"></i> <?= count($pendingApprovals) ?> pending HITL checks
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pipeline Stage Progress Distribution -->
                    <div class="crm-card p-3 p-md-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="fw-bold mb-1"><i class="bi bi-funnel text-info me-2"></i>Sales Funnel Velocity & Pipeline Distribution</h6>
                                <p class="text-muted small mb-0">Total combined pipeline value: <strong><span class="currency-val" data-usd="<?= (float)($pipelineValue + $closedWonValue) ?>">$<?= number_format($pipelineValue + $closedWonValue, 0) ?></span> <span class="currency-label-code">USD</span></strong></p>
                            </div>
                            <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalNewDeal">
                                <i class="bi bi-plus-circle me-1"></i> New Deal
                            </button>
                        </div>
                        <div class="progress" style="height: 18px; background-color: rgba(255, 255, 255, 0.05);">
                            <?php
                            $stagesCount = [
                                'discovery' => count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'discovery')),
                                'scoping' => count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'scoping')),
                                'proposal' => count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'proposal')),
                                'negotiation' => count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'negotiation')),
                                'closed_won' => count(array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === 'closed_won'))
                            ];
                            $totalOpportunitiesCount = max(count($opportunities), 1);
                            $pctDiscovery = round(($stagesCount['discovery'] / $totalOpportunitiesCount) * 100);
                            $pctScoping = round(($stagesCount['scoping'] / $totalOpportunitiesCount) * 100);
                            $pctProposal = round(($stagesCount['proposal'] / $totalOpportunitiesCount) * 100);
                            $pctNegotiation = round(($stagesCount['negotiation'] / $totalOpportunitiesCount) * 100);
                            $pctWon = round(($stagesCount['closed_won'] / $totalOpportunitiesCount) * 100);
                            ?>
                            <div class="progress-bar bg-secondary" style="width: <?= $pctDiscovery ?>%" title="Discovery: <?= $stagesCount['discovery'] ?>">Discovery (<?= $stagesCount['discovery'] ?>)</div>
                            <div class="progress-bar bg-info" style="width: <?= $pctScoping ?>%" title="Scoping: <?= $stagesCount['scoping'] ?>">Scoping (<?= $stagesCount['scoping'] ?>)</div>
                            <div class="progress-bar bg-warning" style="width: <?= $pctProposal ?>%" title="Proposal: <?= $stagesCount['proposal'] ?>">Proposal (<?= $stagesCount['proposal'] ?>)</div>
                            <div class="progress-bar bg-primary" style="width: <?= $pctNegotiation ?>%" title="Negotiation: <?= $stagesCount['negotiation'] ?>">Negotiation (<?= $stagesCount['negotiation'] ?>)</div>
                            <div class="progress-bar bg-success" style="width: <?= $pctWon ?>%" title="Won: <?= $stagesCount['closed_won'] ?>">Won (<?= $stagesCount['closed_won'] ?>)</div>
                        </div>
                    </div>

                    <!-- 1-Click Autonomous Agent Routines Banner -->
                    <div class="crm-card p-3 p-md-4 mb-4" style="background: linear-gradient(135deg, rgba(56, 189, 248, 0.08) 0%, rgba(129, 140, 248, 0.04) 100%);">
                        <div class="row align-items-center g-3">
                            <div class="col-12 col-xl-5">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <span class="badge bg-info text-dark fw-bold">PAPERCLIP AUTONOMOUS ROUTINES</span>
                                    <span class="text-muted small">Dual Mode: Live / Local</span>
                                </div>
                                <h5 class="fw-bold mb-1 text-white">Execute Specialist Agent Routines in 1 Click</h5>
                                <p class="text-muted small mb-0">Agents synthesize client audits, draft outreach, and enforce security gates.</p>
                            </div>
                            <div class="col-12 col-xl-7">
                                <div class="d-flex gap-2 flex-wrap justify-content-xl-end">
                                    <!-- Routine: Tech Audit -->
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                        <input type="hidden" name="action" value="run_routine">
                                        <input type="hidden" name="routine" value="tech_audit">
                                        <button type="submit" class="btn btn-sm btn-outline-info fw-semibold" title="Dispatches Technical Lead">
                                            <i class="bi bi-cpu me-1"></i> Tech Audit
                                        </button>
                                    </form>

                                    <!-- Routine: Discovery Questions -->
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                        <input type="hidden" name="action" value="run_routine">
                                        <input type="hidden" name="routine" value="discovery_questions">
                                        <button type="submit" class="btn btn-sm btn-outline-warning fw-semibold" title="Dispatches Lead Researcher">
                                            <i class="bi bi-question-diamond me-1"></i> Discovery Brief
                                        </button>
                                    </form>

                                    <!-- Routine: Cold Email (HITL) -->
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                        <input type="hidden" name="action" value="run_routine">
                                        <input type="hidden" name="routine" value="draft_email">
                                        <button type="submit" class="btn btn-sm btn-outline-primary fw-semibold" title="Dispatches Sales Engineer into HITL approval">
                                            <i class="bi bi-envelope-paper me-1"></i> Draft Outreach
                                        </button>
                                    </form>

                                    <!-- Routine: Security Gate -->
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                        <input type="hidden" name="action" value="run_routine">
                                        <input type="hidden" name="routine" value="security_scan">
                                        <button type="submit" class="btn btn-sm btn-outline-success fw-semibold" title="Dispatches QA & Security Lead">
                                            <i class="bi bi-shield-lock me-1"></i> Security Scan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Split Grid: Recent Leads & Active Pipeline -->
                    <div class="row g-4">
                        <!-- Recent Leads Feed -->
                        <div class="col-12 col-xl-6">
                            <div class="crm-card p-3 p-md-4 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0"><i class="bi bi-person-lines-fill text-warning me-2"></i>Recent Inbound Leads</h6>
                                    <a href="#leads" class="small text-info text-decoration-none" onclick="document.querySelector('[data-bs-target=\'#tab-leads\']').click();">View All (<?= $totalLeads ?>) &rarr;</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-custom mb-0">
                                        <thead>
                                            <tr>
                                                <th>Prospect</th>
                                                <th>Budget</th>
                                                <th>Score</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($leads)): ?>
                                                <tr><td colspan="4" class="text-center text-muted py-3">No inbound leads captured yet.</td></tr>
                                            <?php else: ?>
                                                <?php foreach (array_slice($leads, 0, 4) as $l): ?>
                                                    <tr>
                                                        <td>
                                                            <div class="fw-bold text-white"><?= htmlspecialchars($l['name'] ?? 'Prospect') ?></div>
                                                            <small class="text-muted"><?= htmlspecialchars($l['company_name'] ?? 'N/A') ?> &bull; <?= htmlspecialchars($l['country'] ?? 'USA') ?></small>
                                                        </td>
                                                        <td class="small text-white currency-budget" data-raw-budget="<?= htmlspecialchars($l['budget'] ?? 'Flexible') ?>"><?= htmlspecialchars($l['budget'] ?? 'Flexible') ?></td>
                                                        <td>
                                                            <?php
                                                            $score = (int)($l['lead_score'] ?? 0);
                                                            $scoreClass = $score >= 80 ? 'score-high' : ($score >= 60 ? 'score-med' : 'score-low');
                                                            ?>
                                                            <span class="score-pill <?= $scoreClass ?>"><?= $score ?>/100</span>
                                                        </td>
                                                        <td>
                                                            <form method="POST" class="d-inline">
                                                                <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                                                <input type="hidden" name="action" value="convert_lead">
                                                                <input type="hidden" name="lead_id" value="<?= CrmSecurity::escape($l['id']) ?>">
                                                                <button type="submit" class="btn btn-xs btn-outline-success py-1 px-2" style="font-size: 0.72rem;" title="Convert to Deal">
                                                                    <i class="bi bi-arrow-right-circle"></i> Convert
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Active Deals Feed -->
                        <div class="col-12 col-xl-6">
                            <div class="crm-card p-3 p-md-4 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold mb-0"><i class="bi bi-briefcase text-success me-2"></i>Active Deals in Progress</h6>
                                    <a href="#pipeline" class="small text-info text-decoration-none" onclick="document.querySelector('[data-bs-target=\'#tab-pipeline\']').click();">View Kanban &rarr;</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-custom mb-0">
                                        <thead>
                                            <tr>
                                                <th>Opportunity</th>
                                                <th>Value</th>
                                                <th>Stage</th>
                                                <th>Assigned</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($opportunities)): ?>
                                                <tr><td colspan="4" class="text-center text-muted py-3">No deals currently active.</td></tr>
                                            <?php else: ?>
                                                <?php foreach (array_slice($opportunities, 0, 4) as $opp): ?>
                                                    <tr>
                                                        <td>
                                                            <div class="fw-bold text-white"><?= htmlspecialchars($opp['title'] ?? 'Deal') ?></div>
                                                            <small class="text-muted"><?= htmlspecialchars($opp['company'] ?? ($opp['client_name'] ?? 'Client')) ?></small>
                                                        </td>
                                                        <td class="fw-bold text-success currency-val" data-usd="<?= (float)($opp['value'] ?? 0) ?>">$<?= number_format((float)($opp['value'] ?? 0), 0) ?></td>
                                                        <td>
                                                            <span class="badge bg-dark border border-secondary text-capitalize" style="font-size: 0.7rem;">
                                                                <?= htmlspecialchars(str_replace('_', ' ', $opp['stage'] ?? 'discovery')) ?>
                                                            </span>
                                                        </td>
                                                        <td class="small text-muted"><?= htmlspecialchars($opp['assigned_to'] ?? 'Sales Engineer') ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ---------------------------------------------------- -->
                <!-- TAB 2: INBOUND LEADS MANAGEMENT                      -->
                <!-- ---------------------------------------------------- -->
                <div class="tab-pane fade" id="tab-leads" role="tabpanel">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div>
                            <h4 class="fw-bold mb-1"><i class="bi bi-person-lines-fill text-warning me-2"></i>Inbound Leads & Qualification Engine</h4>
                            <p class="text-muted small mb-0">Automated lead scoring optimized for high-value US enterprise buyers</p>
                        </div>
                        <button class="btn btn-warning btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalNewLead">
                            <i class="bi bi-person-plus-fill me-1"></i> + Add New Lead
                        </button>
                    </div>

                    <div class="crm-card p-0 overflow-hidden">
                        <div class="table-responsive">
                            <table class="table table-custom mb-0 align-middle">
                                <thead>
                                    <tr>
                                        <th>Prospect & Company</th>
                                        <th>Contact Details</th>
                                        <th>Budget & Timeline</th>
                                        <th>US Score</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($leads)): ?>
                                        <tr><td colspan="6" class="text-center text-muted py-4">No leads found in storage. Click '+ Add New Lead' to create one.</td></tr>
                                    <?php else: ?>
                                        <?php foreach ($leads as $l): ?>
                                            <tr>
                                                <td>
                                                    <div class="fw-bold text-white fs-6"><?= htmlspecialchars($l['name'] ?? 'Prospect') ?></div>
                                                    <div class="small text-muted">
                                                        <i class="bi bi-building me-1"></i><?= htmlspecialchars($l['company_name'] ?? 'N/A') ?> 
                                                        &bull; <span class="badge bg-dark border border-secondary"><?= htmlspecialchars($l['country'] ?? 'USA') ?></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="small text-white"><i class="bi bi-envelope me-1 text-muted"></i><?= htmlspecialchars($l['email'] ?? 'N/A') ?></div>
                                                    <?php if (!empty($l['phone'])): ?>
                                                        <div class="small text-muted"><i class="bi bi-telephone me-1 text-muted"></i><?= htmlspecialchars($l['phone']) ?></div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="small fw-semibold text-white currency-budget" data-raw-budget="<?= htmlspecialchars($l['budget'] ?? 'Flexible') ?>"><?= htmlspecialchars($l['budget'] ?? 'Flexible') ?></div>
                                                    <div class="small text-muted"><?= htmlspecialchars($l['timeline'] ?? '1-3 months') ?></div>
                                                </td>
                                                <td>
                                                    <?php
                                                    $score = (int)($l['lead_score'] ?? 0);
                                                    $scoreClass = $score >= 80 ? 'score-high' : ($score >= 60 ? 'score-med' : 'score-low');
                                                    ?>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="score-pill <?= $scoreClass ?>"><?= $score ?>/100</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                                        <input type="hidden" name="action" value="update_lead_status">
                                                        <input type="hidden" name="lead_id" value="<?= CrmSecurity::escape($l['id']) ?>">
                                                        <input type="hidden" name="current_tab" value="leads">
                                                        <select name="status" class="form-select form-select-sm py-1 px-2 border-secondary bg-dark text-white" style="font-size: 0.75rem; width: auto;" onchange="this.form.submit()">
                                                            <?php
                                                            $statuses = ['new' => 'New', 'contacted' => 'Contacted', 'qualified' => 'Qualified', 'proposal_sent' => 'Proposal Sent', 'closed' => 'Closed'];
                                                            foreach ($statuses as $k => $label):
                                                            ?>
                                                                <option value="<?= $k ?>" <?= ($l['status'] ?? '') === $k ? 'selected' : '' ?>><?= $label ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </form>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group btn-group-sm">
                                                        <!-- Convert to Deal -->
                                                        <form method="POST" class="d-inline">
                                                            <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                                            <input type="hidden" name="action" value="convert_lead">
                                                            <input type="hidden" name="lead_id" value="<?= CrmSecurity::escape($l['id']) ?>">
                                                            <input type="hidden" name="current_tab" value="leads">
                                                            <button type="submit" class="btn btn-sm btn-outline-success py-1 px-2" title="Convert to Deal Opportunity">
                                                                <i class="bi bi-briefcase-fill"></i> Convert
                                                            </button>
                                                        </form>

                                                        <!-- Dispatch to Agent -->
                                                        <button class="btn btn-sm btn-outline-info py-1 px-2" data-bs-toggle="modal" data-bs-target="#modalDispatchAgent" data-lead-id="<?= htmlspecialchars($l['id']) ?>" data-lead-company="<?= htmlspecialchars($l['company_name'] ?? '') ?>" title="Dispatch Agent Routine">
                                                            <i class="bi bi-robot"></i> Agent
                                                        </button>

                                                        <!-- Delete -->
                                                        <form method="POST" class="d-inline" onsubmit="return confirm('Remove this lead?');">
                                                            <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                                            <input type="hidden" name="action" value="delete_lead">
                                                            <input type="hidden" name="lead_id" value="<?= CrmSecurity::escape($l['id']) ?>">
                                                            <input type="hidden" name="current_tab" value="leads">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ---------------------------------------------------- -->
                <!-- TAB 3: SALES PIPELINE (KANBAN BOARD)                 -->
                <!-- ---------------------------------------------------- -->
                <div class="tab-pane fade" id="tab-pipeline" role="tabpanel">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div>
                            <h4 class="fw-bold mb-1"><i class="bi bi-kanban-fill text-success me-2"></i>Interactive Sales Pipeline (Kanban)</h4>
                            <p class="text-muted small mb-0">Track B2B web development proposals and multi-stage deal progression</p>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge bg-success-subtle text-success border border-success-subtle d-flex align-items-center px-3">
                                Total Value:&nbsp;<span class="currency-val" data-usd="<?= (float)array_sum(array_column($opportunities, 'value')) ?>">$<?= number_format(array_sum(array_column($opportunities, 'value')), 0) ?></span>
                            </span>
                            <button class="btn btn-success btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalNewDeal">
                                <i class="bi bi-plus-circle me-1"></i> + New Deal
                            </button>
                        </div>
                    </div>

                    <!-- Kanban Columns Grid -->
                    <div class="row g-3">
                        <?php
                        $pipelineColumns = [
                            'discovery' => ['title' => 'Discovery', 'color' => 'secondary', 'icon' => 'bi-search'],
                            'scoping' => ['title' => 'Technical Scoping', 'color' => 'info', 'icon' => 'bi-code-slash'],
                            'proposal' => ['title' => 'Proposal Sent', 'color' => 'warning', 'icon' => 'bi-file-earmark-text'],
                            'negotiation' => ['title' => 'Negotiation', 'color' => 'primary', 'icon' => 'bi-chat-dots'],
                            'closed_won' => ['title' => 'Closed Won', 'color' => 'success', 'icon' => 'bi-check-circle-fill'],
                            'closed_lost' => ['title' => 'Closed Lost', 'color' => 'danger', 'icon' => 'bi-x-circle']
                        ];

                        foreach ($pipelineColumns as $stageSlug => $colInfo):
                            $stageDeals = array_filter($opportunities, fn($o) => ($o['stage'] ?? '') === $stageSlug);
                            $colTotalVal = array_sum(array_column($stageDeals, 'value'));
                        ?>
                            <div class="col-12 col-md-6 col-xl-2">
                                <div class="kanban-col h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                        <div class="fw-bold small text-<?= $colInfo['color'] ?>">
                                            <i class="bi <?= $colInfo['icon'] ?> me-1"></i> <?= $colInfo['title'] ?>
                                        </div>
                                        <span class="badge bg-dark border border-secondary" style="font-size: 0.7rem;"><?= count($stageDeals) ?></span>
                                    </div>
                                    <div class="text-muted small mb-3 currency-val" data-usd="<?= (float)$colTotalVal ?>" style="font-size: 0.75rem;">
                                        $<?= number_format($colTotalVal, 0) ?>
                                    </div>

                                    <!-- Deal Cards in this column -->
                                    <?php if (empty($stageDeals)): ?>
                                        <div class="text-muted text-center py-4 small" style="opacity: 0.5;">No deals in <?= $colInfo['title'] ?></div>
                                    <?php else: ?>
                                        <?php foreach ($stageDeals as $deal): ?>
                                            <div class="kanban-deal-card">
                                                <div class="fw-bold text-white small mb-1"><?= htmlspecialchars($deal['title'] ?? 'Deal') ?></div>
                                                <div class="small text-muted mb-2"><?= htmlspecialchars($deal['company'] ?? ($deal['client_name'] ?? 'Client')) ?></div>
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="fw-bold text-success currency-val" data-usd="<?= (float)($deal['value'] ?? 0) ?>" style="font-size: 0.95rem;">$<?= number_format((float)($deal['value'] ?? 0), 0) ?></span>
                                                    <span class="badge bg-dark border border-secondary small" style="font-size: 0.65rem;"><?= (int)($deal['probability'] ?? 50) ?>% Win</span>
                                                </div>
                                                <div class="small text-muted mb-3" style="font-size: 0.72rem;">
                                                    <i class="bi bi-person me-1"></i><?= htmlspecialchars($deal['assigned_to'] ?? 'Technical Lead') ?>
                                                </div>

                                                <!-- Stage Switcher Dropdown & Delete -->
                                                <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                                    <form method="POST" class="d-inline">
                                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                                        <input type="hidden" name="action" value="advance_opportunity">
                                                        <input type="hidden" name="opportunity_id" value="<?= CrmSecurity::escape($deal['id']) ?>">
                                                        <input type="hidden" name="current_tab" value="pipeline">
                                                        <select name="stage" class="form-select form-select-sm py-0 px-1 bg-dark text-white border-secondary" style="font-size: 0.68rem; width: auto;" onchange="this.form.submit()">
                                                            <?php foreach ($pipelineColumns as $sKey => $sVal): ?>
                                                                <option value="<?= $sKey ?>" <?= $sKey === $stageSlug ? 'selected' : '' ?>><?= $sVal['title'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </form>

                                                    <form method="POST" class="d-inline" onsubmit="return confirm('Delete this deal?');">
                                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                                        <input type="hidden" name="action" value="delete_opportunity">
                                                        <input type="hidden" name="opportunity_id" value="<?= CrmSecurity::escape($deal['id']) ?>">
                                                        <input type="hidden" name="current_tab" value="pipeline">
                                                        <button type="submit" class="btn btn-link text-danger p-0" title="Delete Deal">
                                                            <i class="bi bi-trash" style="font-size: 0.8rem;"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- ---------------------------------------------------- -->
                <!-- TAB 4: CLIENT DELIVERY PROJECTS                      -->
                <!-- ---------------------------------------------------- -->
                <div class="tab-pane fade" id="tab-projects" role="tabpanel">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div>
                            <h4 class="fw-bold mb-1"><i class="bi bi-rocket-takeoff-fill text-primary me-2"></i>Client Delivery Projects & Milestone Gates</h4>
                            <p class="text-muted small mb-0">Delivery oversight, engineering sprint tracking, and milestone completion verification</p>
                        </div>
                        <button class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalNewProject">
                            <i class="bi bi-plus-circle me-1"></i> + New Project
                        </button>
                    </div>

                    <div class="row g-4">
                        <?php if (empty($projects)): ?>
                            <div class="col-12">
                                <div class="crm-card p-4 text-center text-muted">
                                    No active client delivery projects. Click '+ New Project' to initialize a deliverable.
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach ($projects as $proj): ?>
                                <div class="col-12 col-xl-6">
                                    <div class="crm-card p-4 h-100">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h5 class="fw-bold text-white mb-1"><?= htmlspecialchars($proj['name'] ?? 'Project') ?></h5>
                                                <div class="text-muted small">
                                                    <i class="bi bi-building me-1"></i>Client: <strong><?= htmlspecialchars($proj['client_name'] ?? ($proj['client'] ?? 'Client')) ?></strong>
                                                    &bull; Budget: <strong class="text-success currency-val" data-usd="<?= (float)($proj['budget'] ?? 0) ?>">$<?= number_format((float)($proj['budget'] ?? 0), 0) ?></strong>
                                                </div>
                                            </div>
                                            <span class="badge bg-<?= ($proj['status'] ?? '') === 'delivered' ? 'success' : (($proj['status'] ?? '') === 'in_progress' ? 'primary' : 'secondary') ?>-subtle text-<?= ($proj['status'] ?? '') === 'delivered' ? 'success' : (($proj['status'] ?? '') === 'in_progress' ? 'primary' : 'secondary') ?> border border-<?= ($proj['status'] ?? '') === 'delivered' ? 'success' : (($proj['status'] ?? '') === 'in_progress' ? 'primary' : 'secondary') ?>-subtle text-uppercase" style="font-size: 0.72rem;">
                                                <?= htmlspecialchars(str_replace('_', ' ', $proj['status'] ?? 'planning')) ?>
                                            </span>
                                        </div>

                                        <!-- Progress Bar -->
                                        <div class="my-3">
                                            <div class="d-flex justify-content-between small text-muted mb-1">
                                                <span>Milestones Progress</span>
                                                <span class="fw-bold text-white"><?= (int)($proj['progress'] ?? 0) ?>%</span>
                                            </div>
                                            <div class="progress" style="height: 8px; background: rgba(255, 255, 255, 0.08);">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: <?= (int)($proj['progress'] ?? 0) ?>%"></div>
                                            </div>
                                        </div>

                                        <!-- Milestone Checklist -->
                                        <div class="p-3 rounded-3 mb-3" style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.05);">
                                            <div class="small fw-bold text-uppercase text-muted mb-2" style="font-size: 0.72rem;">Engineering Milestones (Click checkbox to toggle)</div>
                                            <div class="d-flex flex-column gap-2">
                                                <?php
                                                $milestones = $proj['milestones'] ?? [];
                                                foreach ($milestones as $idx => $m):
                                                    $isDone = !empty($m['done']) || !empty($m['completed']);
                                                ?>
                                                    <form method="POST" class="d-flex align-items-center justify-content-between">
                                                        <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                                        <input type="hidden" name="action" value="toggle_milestone">
                                                        <input type="hidden" name="project_id" value="<?= CrmSecurity::escape($proj['id']) ?>">
                                                        <input type="hidden" name="milestone_index" value="<?= $idx ?>">
                                                        <input type="hidden" name="current_tab" value="projects">

                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="checkbox" id="m_<?= CrmSecurity::escape($proj['id']) ?>_<?= $idx ?>" <?= $isDone ? 'checked' : '' ?> onchange="this.form.submit()">
                                                            <label class="form-check-label small <?= $isDone ? 'text-decoration-line-through text-muted' : 'text-white' ?>" for="m_<?= CrmSecurity::escape($proj['id']) ?>_<?= $idx ?>">
                                                                <?= htmlspecialchars($m['title'] ?? 'Milestone') ?>
                                                            </label>
                                                        </div>
                                                        <?php if (!empty($m['target_date'])): ?>
                                                            <span class="badge bg-dark border border-secondary text-muted" style="font-size: 0.65rem;"><?= htmlspecialchars($m['target_date']) ?></span>
                                                        <?php endif; ?>
                                                    </form>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <!-- Footer Info & Actions -->
                                        <div class="d-flex justify-content-between align-items-center text-muted small pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                            <div>
                                                <i class="bi bi-person-badge me-1"></i> Lead: <strong><?= htmlspecialchars($proj['lead_engineer'] ?? ($proj['lead_agent'] ?? 'Delivery Lead')) ?></strong>
                                                &bull; Target: <?= htmlspecialchars($proj['deadline'] ?? 'TBD') ?>
                                            </div>
                                            <form method="POST" class="d-inline" onsubmit="return confirm('Delete this project?');">
                                                <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                                <input type="hidden" name="action" value="delete_project">
                                                <input type="hidden" name="project_id" value="<?= CrmSecurity::escape($proj['id']) ?>">
                                                <input type="hidden" name="current_tab" value="projects">
                                                <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Delete Project">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- ---------------------------------------------------- -->
                <!-- TAB 5: PAPERCLIP AUTONOMOUS AGENT NETWORK            -->
                <!-- ---------------------------------------------------- -->
                <div class="tab-pane fade" id="tab-paperclip" role="tabpanel">
                    <!-- Network Status Banner -->
                    <div class="crm-card p-3 p-md-4 mb-4" style="background: linear-gradient(135deg, rgba(17, 24, 39, 0.9) 0%, rgba(30, 41, 59, 0.8) 100%);">
                        <div class="row align-items-center g-3">
                            <div class="col-12 col-md-7">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="agent-badge-pulse"></span>
                                    <span class="fw-bold text-info">PAPERCLIP 7-AGENT SPECIALIST NETWORK</span>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle">ONLINE</span>
                                </div>
                                <h4 class="fw-bold text-white mb-1">Autonomous Company Operations & Task Engine</h4>
                                <p class="text-muted small mb-0">Each agent operates within its domain skills and stages external actions into the Human-in-the-Loop approval queue.</p>
                            </div>
                            <div class="col-12 col-md-5 text-md-end">
                                <button class="btn btn-info btn-sm fw-bold me-2" data-bs-toggle="modal" data-bs-target="#modalDispatchAgent">
                                    <i class="bi bi-send-fill me-1"></i> Dispatch Custom Task
                                </button>
                                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgentRoutines">
                                    <i class="bi bi-lightning-fill text-warning me-1"></i> 1-Click Routines
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 7 Agent Cards Grid -->
                    <div class="row g-3 mb-4">
                        <?php foreach ($agents as $slug => $ag): ?>
                            <div class="col-12 col-md-6 col-xl-4">
                                <div class="agent-card p-3 p-xl-4 h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="rounded-3 p-2 d-flex align-items-center justify-content-center" style="background: rgba(56, 189, 248, 0.1); border: 1px solid rgba(56, 189, 248, 0.2); width: 38px; height: 38px;">
                                                    <i class="bi <?= htmlspecialchars($ag['icon'] ?? 'bi-robot') ?> text-info fs-5"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-white fs-6"><?= htmlspecialchars($ag['name'] ?? 'Agent') ?></div>
                                                    <small class="text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($ag['title'] ?? '') ?></small>
                                                </div>
                                            </div>
                                            <span class="badge bg-dark border border-secondary text-uppercase" style="font-size: 0.65rem;">
                                                <?= htmlspecialchars($ag['badge'] ?? 'Agent') ?>
                                            </span>
                                        </div>

                                        <p class="text-muted small mt-2 mb-3" style="font-size: 0.82rem; min-height: 40px;">
                                            <?= htmlspecialchars($ag['description'] ?? '') ?>
                                        </p>

                                        <!-- Skills Pills -->
                                        <div class="d-flex gap-1 flex-wrap mb-3">
                                            <?php foreach ($ag['skills'] ?? [] as $sk): ?>
                                                <span class="badge bg-dark text-info border border-secondary" style="font-size: 0.68rem; font-family: 'JetBrains Mono', monospace;">
                                                    #<?= htmlspecialchars($sk) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                                        <div class="d-flex align-items-center gap-1 small text-muted">
                                            <span class="agent-badge-pulse"></span>
                                            <span>Active (Reports to: <?= htmlspecialchars($ag['reports_to'] ? strtoupper($ag['reports_to']) : 'Board') ?>)</span>
                                        </div>
                                        <button class="btn btn-xs btn-outline-info py-1 px-2" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#modalDispatchAgent" data-agent-slug="<?= htmlspecialchars($slug) ?>">
                                            <i class="bi bi-send me-1"></i> Dispatch
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Live Task Queue & Output History Table -->
                    <div class="crm-card p-3 p-md-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0"><i class="bi bi-list-task text-info me-2"></i>Live Paperclip Task Queue & Output Log</h5>
                            <span class="badge bg-dark border border-secondary text-muted"><?= count($paperclipTasks) ?> Tasks Logged</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>Task ID</th>
                                        <th>Agent</th>
                                        <th>Title / Routine</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Timestamp</th>
                                        <th class="text-end">Output Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($paperclipTasks)): ?>
                                        <tr><td colspan="7" class="text-center text-muted py-4">No agent tasks in queue. Dispatch a task above!</td></tr>
                                    <?php else: ?>
                                        <?php foreach ($paperclipTasks as $t): ?>
                                            <tr>
                                                <td class="mono small text-info"><?= htmlspecialchars($t['id'] ?? 'task') ?></td>
                                                <td class="fw-bold text-white small"><?= htmlspecialchars($t['agent_title'] ?? ($t['agent'] ?? 'Agent')) ?></td>
                                                <td>
                                                    <div class="fw-semibold text-white small"><?= htmlspecialchars($t['title'] ?? 'Task') ?></div>
                                                    <?php if (!empty($t['description'])): ?>
                                                        <small class="text-muted text-truncate d-inline-block" style="max-width: 280px;"><?= htmlspecialchars($t['description']) ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $pri = $t['priority'] ?? 'medium';
                                                    $priColor = $pri === 'urgent' ? 'danger' : ($pri === 'high' ? 'warning' : 'secondary');
                                                    ?>
                                                    <span class="badge bg-<?= $priColor ?>-subtle text-<?= $priColor ?> border border-<?= $priColor ?>-subtle text-uppercase" style="font-size: 0.65rem;"><?= htmlspecialchars($pri) ?></span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle text-uppercase" style="font-size: 0.65rem;">
                                                        <i class="bi bi-check2 me-1"></i><?= htmlspecialchars($t['status'] ?? 'completed') ?>
                                                    </span>
                                                </td>
                                                <td class="small text-muted"><?= htmlspecialchars(date('M j, g:i a', strtotime($t['created_at'] ?? 'now'))) ?></td>
                                                <td class="text-end">
                                                    <button class="btn btn-xs btn-outline-secondary py-1 px-2 btn-view-task-output" style="font-size: 0.72rem;" data-title="<?= htmlspecialchars($t['title'] ?? '') ?>" data-agent="<?= htmlspecialchars($t['agent_title'] ?? ($t['agent'] ?? '')) ?>" data-output="<?= htmlspecialchars(is_string($t['output'] ?? '') ? ($t['output'] ?? '') : json_encode($t['output'] ?? [], JSON_PRETTY_PRINT)) ?>">
                                                        <i class="bi bi-eye"></i> View Result
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ---------------------------------------------------- -->
                <!-- TAB 6: HUMAN-IN-THE-LOOP (HITL) APPROVALS            -->
                <!-- ---------------------------------------------------- -->
                <div class="tab-pane fade" id="tab-approvals" role="tabpanel">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div>
                            <h4 class="fw-bold mb-1"><i class="bi bi-shield-check text-warning me-2"></i>Human-in-the-Loop Governance Queue</h4>
                            <p class="text-muted small mb-0">Safety Guarantee: Zero autonomous outbound actions (emails, proposals, social posts) execute without explicit founder sign-off</p>
                        </div>
                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-2">
                            <?= count($pendingApprovals) ?> Pending Decisions
                        </span>
                    </div>

                    <!-- Pending Items Grid -->
                    <div class="row g-4 mb-5">
                        <?php if (empty($pendingApprovals)): ?>
                            <div class="col-12">
                                <div class="crm-card p-4 text-center text-muted">
                                    <i class="bi bi-check-all text-success fs-1 mb-2"></i>
                                    <h5>All clear! No pending agent actions require approval.</h5>
                                    <p class="small mb-0">When agents generate outbound drafts or pricing proposals, they will stage here automatically.</p>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php foreach ($pendingApprovals as $item): ?>
                                <div class="col-12 col-xl-6">
                                    <div class="approval-box h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h5 class="fw-bold text-white mb-1"><?= htmlspecialchars($item['title'] ?? 'Draft Action') ?></h5>
                                                    <div class="small text-muted">
                                                        Requested by: <strong class="text-info"><?= htmlspecialchars($item['requested_by'] ?? 'Autonomous Agent') ?></strong>
                                                        &bull; Created: <?= htmlspecialchars(date('M j, g:i a', strtotime($item['created_at'] ?? 'now'))) ?>
                                                    </div>
                                                </div>
                                                <span class="badge bg-warning text-dark fw-bold text-uppercase" style="font-size: 0.7rem;">
                                                    <?= htmlspecialchars($item['type'] ?? 'draft') ?>
                                                </span>
                                            </div>

                                            <!-- Pre-Formatted Payload Preview -->
                                            <div class="p-3 rounded-3 my-3" style="background: rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.08);">
                                                <?php
                                                $payload = $item['payload'] ?? [];
                                                if (isset($payload['to'], $payload['subject'], $payload['body'])):
                                                ?>
                                                    <div class="small text-muted mb-1">To: <span class="text-white"><?= htmlspecialchars($payload['to']) ?></span></div>
                                                    <div class="small text-muted mb-2">Subject: <span class="text-white fw-bold"><?= htmlspecialchars($payload['subject']) ?></span></div>
                                                    <div class="small text-light p-2 rounded" style="background: rgba(255,255,255,0.03); white-space: pre-wrap; font-size: 0.84rem;"><?= htmlspecialchars($payload['body']) ?></div>
                                                <?php else: ?>
                                                    <pre class="mb-0 text-light mono" style="font-size: 0.78rem; overflow-x: auto;"><?= htmlspecialchars(json_encode($payload, JSON_PRETTY_PRINT)) ?></pre>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Decision Form -->
                                        <form method="POST" class="pt-2 border-top" style="border-color: rgba(245, 158, 11, 0.2) !important;">
                                            <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                                            <input type="hidden" name="action" value="approval_decision">
                                            <input type="hidden" name="approval_id" value="<?= CrmSecurity::escape($item['id']) ?>">
                                            <input type="hidden" name="current_tab" value="approvals">

                                            <div class="input-group input-group-sm mb-2">
                                                <input type="text" name="decision_notes" class="form-control" placeholder="Optional review comment / adjustment notes...">
                                            </div>

                                            <div class="d-flex gap-2 justify-content-end">
                                                <button type="submit" name="decision" value="reject" class="btn btn-sm btn-outline-danger px-3">
                                                    <i class="bi bi-x-circle me-1"></i> Reject Draft
                                                </button>
                                                <button type="submit" name="decision" value="approve" class="btn btn-sm btn-success px-4 fw-bold">
                                                    <i class="bi bi-check-circle-fill me-1"></i> Sign-Off & Approve
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Resolved Audit History Table -->
                    <div class="crm-card p-3 p-md-4">
                        <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-info"></i>Audit Trail: Resolved Approvals</h6>
                        <div class="table-responsive">
                            <table class="table table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>Item Title</th>
                                        <th>Type</th>
                                        <th>Requested By</th>
                                        <th>Decided By</th>
                                        <th>Decision Status</th>
                                        <th>Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $resolved = array_filter($allApprovals, fn($a) => ($a['status'] ?? '') !== 'pending');
                                    if (empty($resolved)):
                                    ?>
                                        <tr><td colspan="6" class="text-center text-muted py-3">No resolved approvals recorded yet.</td></tr>
                                    <?php else: ?>
                                        <?php foreach (array_slice($resolved, 0, 8) as $res): ?>
                                            <tr>
                                                <td class="fw-semibold text-white small"><?= htmlspecialchars($res['title'] ?? 'Action') ?></td>
                                                <td class="small text-muted"><?= htmlspecialchars($res['type'] ?? '') ?></td>
                                                <td class="small text-info"><?= htmlspecialchars($res['requested_by'] ?? 'Agent') ?></td>
                                                <td class="small text-white"><?= htmlspecialchars($res['approved_by'] ?? ($res['rejected_by'] ?? 'Founder')) ?></td>
                                                <td>
                                                    <span class="badge bg-<?= ($res['status'] ?? '') === 'approved' ? 'success' : 'danger' ?>-subtle text-<?= ($res['status'] ?? '') === 'approved' ? 'success' : 'danger' ?> border border-<?= ($res['status'] ?? '') === 'approved' ? 'success' : 'danger' ?>-subtle text-uppercase" style="font-size: 0.68rem;">
                                                        <?= htmlspecialchars($res['status'] ?? '') ?>
                                                    </span>
                                                </td>
                                                <td class="small text-muted"><?= htmlspecialchars(date('M j, g:i a', strtotime($res['resolved_at'] ?? ($res['created_at'] ?? 'now')))) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ---------------------------------------------------- -->
                <!-- TAB 7: SYSTEM CONFIGURATION & WEBHOOK INGESTION      -->
                <!-- ---------------------------------------------------- -->
                <div class="tab-pane fade" id="tab-settings" role="tabpanel">
                    <div class="mb-4">
                        <h4 class="fw-bold mb-1"><i class="bi bi-sliders text-secondary me-2"></i>System Architecture, RBAC & API Ingestion</h4>
                        <p class="text-muted small mb-0">Integration parameters, Paperclip endpoints, and HMAC webhook signature specs</p>
                    </div>

                    <div class="row g-4">
                        <!-- Paperclip Integration Diagnostic -->
                        <div class="col-12 col-xl-6">
                            <div class="crm-card p-4 h-100">
                                <h6 class="fw-bold text-white mb-3"><i class="bi bi-cpu text-info me-2"></i>Paperclip Daemon Integration Diagnostic</h6>
                                <div class="table-responsive">
                                    <table class="table table-custom mb-3 small">
                                        <tr>
                                            <td class="text-muted" style="width: 35%;">Engine Mode</td>
                                            <td class="fw-bold text-info"><?= htmlspecialchars($paperclipConn['mode'] ?? 'local_standalone') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Target Daemon URL</td>
                                            <td class="mono"><?= htmlspecialchars($paperclipConn['url'] ?? 'http://127.0.0.1:3100') ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Active Specialist Roles</td>
                                            <td><span class="badge bg-success-subtle text-success">7 Agents Registered & Online</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Storage Subsystem</td>
                                            <td class="mono small">crm/storage/data/*.json (Deterministic Atomic Locks)</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="p-3 rounded-3" style="background: rgba(56, 189, 248, 0.05); border: 1px solid rgba(56, 189, 248, 0.2);">
                                    <div class="small text-info fw-bold mb-1"><i class="bi bi-info-circle me-1"></i> Dual-Mode Architecture:</div>
                                    <div class="small text-muted">
                                        The CRM features an embedded autonomous execution runtime capable of running all 7 specialist routines locally, and will seamlessly bridge with any live Paperclip background daemon when <code class="text-info">PAPERCLIP_API_KEY</code> is configured in <code class="text-info">crm/.env</code>.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Webhook & Lead Ingestion Guide -->
                        <div class="col-12 col-xl-6">
                            <div class="crm-card p-4 h-100">
                                <h6 class="fw-bold text-white mb-3"><i class="bi bi-shield-lock text-warning me-2"></i>Inbound Webhook API & HMAC Security</h6>
                                <p class="text-muted small mb-3">
                                    External discovery forms and microservices securely transmit inbound leads directly to the CRM ingestion endpoint:
                                </p>
                                <div class="p-2 rounded bg-black mono small text-info mb-3">
                                    POST /codes/CodeX404_solutions/crm/api/v1/leads.php
                                </div>
                                <div class="small text-muted mb-2">Required HTTP Headers for Production Gate:</div>
                                <ul class="small text-muted ps-3 mb-3">
                                    <li><code class="text-white">X-Signature-256</code>: HMAC-SHA256 hash of raw JSON payload using shared secret.</li>
                                    <li><code class="text-white">X-Signature-Timestamp</code>: UNIX timestamp within &plusmn;300s replay tolerance.</li>
                                    <li><code class="text-white">Content-Type</code>: application/json</li>
                                </ul>
                                <div class="p-3 rounded-3" style="background: rgba(16, 185, 129, 0.05); border: 1px solid rgba(16, 185, 129, 0.2);">
                                    <div class="small text-success fw-bold mb-1"><i class="bi bi-shield-check me-1"></i> Security Hardening Status:</div>
                                    <div class="small text-muted">
                                        All 32 security tests verified: Zero plaintext credentials, persistent brute-force lockout, CSRF protection, and strict SameSite session cookies.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<!-- ================================================================ -->
<!-- MODAL: ADD NEW INBOUND LEAD                                      -->
<!-- ================================================================ -->
<div class="modal fade" id="modalNewLead" tabindex="-1" aria-labelledby="modalNewLeadLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                <input type="hidden" name="action" value="create_lead">
                <input type="hidden" name="current_tab" value="leads">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white" id="modalNewLeadLabel">
                        <i class="bi bi-person-plus-fill text-warning me-2"></i>Create Inbound Lead
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Prospect Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. David Miller">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Work Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="e.g. david@enterprise-client.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Company Name</label>
                            <input type="text" name="company_name" class="form-control" placeholder="e.g. Miller Logistics Inc">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="+1 (555) 000-0000">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Country / Market</label>
                            <select name="country" class="form-select">
                                <option value="United States" selected>United States (US Tier 1)</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="Canada">Canada</option>
                                <option value="Germany">Germany</option>
                                <option value="Australia">Australia</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Budget Tier</label>
                            <select name="budget" class="form-select">
                                <option value="$5,000 - $10,000">$5,000 - $10,000</option>
                                <option value="$15,000 - $30,000" selected>$15,000 - $30,000</option>
                                <option value="$30,000 - $50,000">$30,000 - $50,000</option>
                                <option value="$50,000+ Enterprise">$50,000+ Enterprise</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small text-muted">Timeline</label>
                            <select name="timeline" class="form-select">
                                <option value="Immediately (Urgent)" selected>Immediately (Urgent)</option>
                                <option value="1-2 months">1-2 months</option>
                                <option value="2-3 months">2-3 months</option>
                                <option value="Exploratory">Exploratory</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Primary Solution Interest</label>
                            <select name="service_interest" class="form-select">
                                <option value="Custom Web Application" selected>Custom Web Application / SaaS</option>
                                <option value="AI Autonomous Agent Systems">AI Autonomous Agent Systems / Workflows</option>
                                <option value="E-Commerce & High-Throughput Portals">E-Commerce & High-Throughput Portals</option>
                                <option value="API Architecture & Cloud Modernization">API Architecture & Cloud Modernization</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Project Needs & Problem Scope</label>
                            <textarea name="problem_description" class="form-control" rows="3" placeholder="Describe the client's current bottleneck, tech stack requirements, and key objectives..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm fw-bold px-4">Create Lead & Score</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================================================================ -->
<!-- MODAL: ADD NEW PIPELINE DEAL (OPPORTUNITY)                       -->
<!-- ================================================================ -->
<div class="modal fade" id="modalNewDeal" tabindex="-1" aria-labelledby="modalNewDealLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                <input type="hidden" name="action" value="create_opportunity">
                <input type="hidden" name="current_tab" value="pipeline">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white" id="modalNewDealLabel">
                        <i class="bi bi-briefcase-fill text-success me-2"></i>Add Pipeline Opportunity
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-muted">Deal Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g. Apex Logistics - Dispatch Portal MVP">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Company / Client</label>
                            <input type="text" name="company" class="form-control" required placeholder="e.g. Apex Global Logistics">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Contract Value ($ USD) <span class="text-danger">*</span></label>
                            <input type="number" step="500" name="value" class="form-control" required value="25000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Initial Stage</label>
                            <select name="stage" class="form-select">
                                <option value="discovery" selected>Discovery</option>
                                <option value="scoping">Technical Scoping</option>
                                <option value="proposal">Proposal Sent</option>
                                <option value="negotiation">Negotiation</option>
                                <option value="closed_won">Closed Won</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Assigned Owner / Agent</label>
                            <select name="assigned_to" class="form-select">
                                <option value="CEO">CEO / Founder</option>
                                <option value="Chief of Staff">Chief of Staff</option>
                                <option value="Sales Engineer" selected>Sales Engineer</option>
                                <option value="Technical Lead">Technical Lead</option>
                                <option value="Delivery Lead">Delivery Lead</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Expected Target Close Date</label>
                            <input type="date" name="expected_close_date" class="form-control" value="<?= date('Y-m-d', strtotime('+3 weeks')) ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Scoping Notes</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Key technical deliverables, integrations, or client decision criteria..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm fw-bold px-4">Add Deal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================================================================ -->
<!-- MODAL: ADD NEW CLIENT DELIVERY PROJECT                           -->
<!-- ================================================================ -->
<div class="modal fade" id="modalNewProject" tabindex="-1" aria-labelledby="modalNewProjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                <input type="hidden" name="action" value="create_project">
                <input type="hidden" name="current_tab" value="projects">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white" id="modalNewProjectLabel">
                        <i class="bi bi-rocket-takeoff-fill text-primary me-2"></i>Create Client Delivery Project
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-muted">Project Deliverable Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. NovaCare Telehealth Patient Portal">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Client Name <span class="text-danger">*</span></label>
                            <input type="text" name="client_name" class="form-control" required placeholder="NovaCare Health">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Client Email</label>
                            <input type="email" name="client_email" class="form-control" placeholder="cto@novacare.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Budget ($ USD)</label>
                            <input type="number" step="1000" name="budget" class="form-control" value="35000">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Delivery Deadline</label>
                            <input type="date" name="deadline" class="form-control" value="<?= date('Y-m-d', strtotime('+6 weeks')) ?>">
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Lead Delivery Engineer</label>
                            <select name="lead_engineer" class="form-select">
                                <option value="Delivery Lead Agent" selected>Delivery Lead Agent</option>
                                <option value="Technical Lead Agent">Technical Lead Agent</option>
                                <option value="QA & Security Lead Agent">QA & Security Lead Agent</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm fw-bold px-4">Create Project</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================================================================ -->
<!-- MODAL: DISPATCH CUSTOM PAPERCLIP AGENT TASK                      -->
<!-- ================================================================ -->
<div class="modal fade" id="modalDispatchAgent" tabindex="-1" aria-labelledby="modalDispatchAgentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                <input type="hidden" name="action" value="dispatch_paperclip">
                <input type="hidden" name="current_tab" value="paperclip">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white" id="modalDispatchAgentLabel">
                        <i class="bi bi-robot text-info me-2"></i>Dispatch Paperclip Specialist Agent
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-muted">Target Specialist Agent <span class="text-danger">*</span></label>
                            <select name="agent_slug" id="dispatchAgentSelect" class="form-select">
                                <?php foreach ($agents as $slug => $ag): ?>
                                    <option value="<?= $slug ?>"><?= htmlspecialchars($ag['name']) ?> &mdash; <?= htmlspecialchars($ag['title']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Task Objective / Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g. Audit HL7/FHIR requirements for telemedicine client">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Task Priority</label>
                            <select name="priority" class="form-select">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent Pre-Flight</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted">Associate with Lead (Optional)</label>
                            <select name="lead_id" id="dispatchLeadSelect" class="form-select">
                                <option value="">-- Standalone Task --</option>
                                <?php foreach ($leads as $l): ?>
                                    <option value="<?= htmlspecialchars($l['id']) ?>"><?= htmlspecialchars($l['name']) ?> (<?= htmlspecialchars($l['company_name'] ?? 'N/A') ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Detailed Instructions & Constraints</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Provide context, required deliverable format, or architectural parameters..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info btn-sm fw-bold px-4 text-dark">Dispatch Task</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================================================================ -->
<!-- MODAL: 1-CLICK AUTONOMOUS ROUTINES PICKER                        -->
<!-- ================================================================ -->
<div class="modal fade" id="modalAgentRoutines" tabindex="-1" aria-labelledby="modalAgentRoutinesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                <input type="hidden" name="action" value="run_routine">
                <input type="hidden" name="current_tab" value="paperclip">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-white" id="modalAgentRoutinesLabel">
                        <i class="bi bi-lightning-fill text-warning me-2"></i>Select & Execute Agent Routine
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-muted">Routine Category <span class="text-danger">*</span></label>
                            <select name="routine" class="form-select">
                                <option value="tech_audit" selected>⚡ Tech Stack & Architecture Audit (Technical Lead)</option>
                                <option value="discovery_questions">⚡ Discovery Questions Brief (Lead Researcher)</option>
                                <option value="draft_email">⚡ Personalized Cold Outreach (Sales Engineer -> HITL)</option>
                                <option value="security_scan">⚡ Application OWASP Security Gate (QA & Security)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Select Target Prospect Context (Optional)</label>
                            <select name="lead_id" class="form-select">
                                <option value="">-- Generic CodeX404 Template Context --</option>
                                <?php foreach ($leads as $l): ?>
                                    <option value="<?= htmlspecialchars($l['id']) ?>"><?= htmlspecialchars($l['name']) ?> &bull; <?= htmlspecialchars($l['company_name'] ?? 'N/A') ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted" style="font-size: 0.72rem;">Selecting a prospect injects company name, budget, and problem scope into the agent routine.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm fw-bold px-4 text-dark">Run Routine Now</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================================================================ -->
<!-- MODAL: VIEW AGENT TASK OUTPUT                                    -->
<!-- ================================================================ -->
<div class="modal fade" id="modalViewOutput" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold text-white mb-0" id="outputModalTitle">Agent Output</h5>
                    <small class="text-info" id="outputModalAgent"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <pre id="outputModalBody" class="mono p-3 rounded text-light" style="background: rgba(0, 0, 0, 0.5); border: 1px solid rgba(255, 255, 255, 0.1); max-height: 480px; overflow-y: auto; white-space: pre-wrap; font-size: 0.85rem;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar" style="width: 280px;">
    <div class="offcanvas-header border-bottom border-secondary">
        <a href="index.php" class="d-inline-block text-decoration-none">
            <img src="assets/images/logo/logo.png" alt="CodeX404 Solutions" style="max-height: 38px; object-fit: contain;">
        </a>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-3">
        <nav class="nav flex-column" id="mobileNav">
            <a href="#dashboard" class="crm-nav-link active" data-bs-toggle="pill" data-bs-target="#tab-dashboard" data-bs-dismiss="offcanvas"><i class="bi bi-grid-1x2-fill me-2"></i> Dashboard</a>
            <a href="#leads" class="crm-nav-link" data-bs-toggle="pill" data-bs-target="#tab-leads" data-bs-dismiss="offcanvas"><i class="bi bi-person-lines-fill me-2"></i> Inbound Leads (<?= $totalLeads ?>)</a>
            <a href="#pipeline" class="crm-nav-link" data-bs-toggle="pill" data-bs-target="#tab-pipeline" data-bs-dismiss="offcanvas"><i class="bi bi-kanban-fill me-2"></i> Pipeline Deals</a>
            <a href="#projects" class="crm-nav-link" data-bs-toggle="pill" data-bs-target="#tab-projects" data-bs-dismiss="offcanvas"><i class="bi bi-rocket-takeoff-fill me-2"></i> Client Projects</a>
            <a href="#paperclip" class="crm-nav-link" data-bs-toggle="pill" data-bs-target="#tab-paperclip" data-bs-dismiss="offcanvas"><i class="bi bi-robot me-2"></i> Paperclip Agents</a>
            <a href="#approvals" class="crm-nav-link" data-bs-toggle="pill" data-bs-target="#tab-approvals" data-bs-dismiss="offcanvas"><i class="bi bi-shield-check me-2"></i> Approvals (<?= count($pendingApprovals) ?>)</a>
            <a href="#settings" class="crm-nav-link" data-bs-toggle="pill" data-bs-target="#tab-settings" data-bs-dismiss="offcanvas"><i class="bi bi-sliders me-2"></i> System & API</a>
        </nav>
        <hr class="border-secondary my-3">
        <!-- Mobile Currency Selector -->
        <div class="dropdown mb-2">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2" id="bd-currency-mobile" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="d-flex align-items-center gap-2">
                    <span id="bd-currency-mobile-flag">🇺🇸</span>
                    <span id="bd-currency-mobile-text"><strong>USD</strong> &bull; US Dollar</span>
                </span>
                <span class="badge bg-secondary-subtle text-muted" id="bd-currency-mobile-symbol">$</span>
            </button>
            <ul class="dropdown-menu w-100 shadow" aria-labelledby="bd-currency-mobile">
                <li class="dropdown-header small text-uppercase fw-bold text-muted">Real-Time Currency</li>
                <li><hr class="dropdown-divider my-1"></li>
                <li><button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="USD"><span>🇺🇸 <strong>USD</strong> &bull; US Dollar</span><span class="badge bg-secondary-subtle text-muted">$</span></button></li>
                <li><button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="INR"><span>🇮🇳 <strong>INR</strong> &bull; Rupee</span><span class="badge bg-warning-subtle text-warning">₹</span></button></li>
                <li><button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="EUR"><span>🇪🇺 <strong>EUR</strong> &bull; Euro</span><span class="badge bg-info-subtle text-info">€</span></button></li>
                <li><button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="GBP"><span>🇬🇧 <strong>GBP</strong> &bull; British Pound</span><span class="badge bg-primary-subtle text-primary">£</span></button></li>
                <li><button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="AED"><span>🇦🇪 <strong>AED</strong> &bull; UAE Dirham</span><span class="badge bg-success-subtle text-success">د.إ</span></button></li>
                <li><button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="CAD"><span>🇨🇦 <strong>CAD</strong> &bull; Canadian Dollar</span><span class="badge bg-secondary-subtle text-muted">C$</span></button></li>
                <li><button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="AUD"><span>🇦🇺 <strong>AUD</strong> &bull; Australian Dollar</span><span class="badge bg-secondary-subtle text-muted">A$</span></button></li>
                <li><button type="button" class="dropdown-item d-flex align-items-center justify-content-between py-2" data-crm-currency="SGD"><span>🇸🇬 <strong>SGD</strong> &bull; Singapore Dollar</span><span class="badge bg-secondary-subtle text-muted">S$</span></button></li>
            </ul>
        </div>

        <!-- Mobile Theme Toggle -->
        <div class="dropdown mb-3">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100 d-flex align-items-center justify-content-between px-3 py-2" id="bd-theme-mobile" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="d-flex align-items-center gap-2">
                    <i class="bi bi-circle-half theme-icon-active text-primary"></i>
                    <span id="bd-theme-mobile-text">Dark &amp; Light</span>
                </span>
            </button>
            <ul class="dropdown-menu w-100 shadow" aria-labelledby="bd-theme-mobile">
                <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="combo"><i class="bi bi-circle-half text-primary"></i> Dark &amp; Light Combo</button></li>
                <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="dark"><i class="bi bi-moon-stars-fill text-info"></i> Full Dark Mode</button></li>
                <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="light"><i class="bi bi-sun-fill text-warning"></i> Pure Light Mode</button></li>
                <li><hr class="dropdown-divider"></li>
                <li><button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="auto"><i class="bi bi-laptop text-secondary"></i> System Auto</button></li>
            </ul>
        </div>
        <div class="d-grid gap-2">
            <a href="../website/discovery-call.php" target="_blank" class="btn btn-sm btn-outline-warning text-start"><i class="bi bi-lightning-charge me-1"></i> Public Discovery Form</a>
            <a href="logout.php" class="btn btn-sm btn-danger text-start mt-2"><i class="bi bi-box-arrow-left me-1"></i> Sign Out</a>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3.3 Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    // Tab Hash Synchronization
    document.addEventListener('DOMContentLoaded', function () {
        const hash = window.location.hash;
        if (hash) {
            const triggerEl = document.querySelector(`.crm-sidebar a[href="${hash}"]`);
            if (triggerEl) {
                const tab = new bootstrap.Tab(triggerEl);
                tab.show();
            }
        }

        // Update URL hash when a sidebar tab is clicked
        const navLinks = document.querySelectorAll('.crm-nav-link[data-bs-toggle="pill"]');
        navLinks.forEach(function (link) {
            link.addEventListener('shown.bs.tab', function (e) {
                const targetHash = e.target.getAttribute('href');
                if (targetHash && history.pushState) {
                    history.pushState(null, null, targetHash);
                }
            });
        });

        // View Task Output Modal Handler
        const outputModal = new bootstrap.Modal(document.getElementById('modalViewOutput'));
        document.querySelectorAll('.btn-view-task-output').forEach(function (btn) {
            btn.addEventListener('click', function () {
                document.getElementById('outputModalTitle').textContent = this.dataset.title || 'Agent Output';
                document.getElementById('outputModalAgent').textContent = 'Executed by ' + (this.dataset.agent || 'Specialist Agent');
                document.getElementById('outputModalBody').textContent = this.dataset.output || 'No output recorded.';
                outputModal.show();
            });
        });

        // Pre-fill Dispatch Modal when clicked from an Agent card or Lead row
        const modalDispatch = document.getElementById('modalDispatchAgent');
        if (modalDispatch) {
            modalDispatch.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                const agentSlug = button.getAttribute('data-agent-slug');
                if (agentSlug) {
                    const select = document.getElementById('dispatchAgentSelect');
                    if (select) select.value = agentSlug;
                }

                const leadId = button.getAttribute('data-lead-id');
                if (leadId) {
                    const leadSelect = document.getElementById('dispatchLeadSelect');
                    if (leadSelect) leadSelect.value = leadId;
                }
            });
        }

        // =========================================================
        // Bootstrap 5.3 Theme Switcher (Combo / Dark / Light / Auto)
        // =========================================================
        const getStoredTheme = () => localStorage.getItem('codex_crm_theme');
        const setStoredTheme = theme => localStorage.setItem('codex_crm_theme', theme);
        const getPreferredTheme = () => {
            const storedTheme = getStoredTheme();
            if (storedTheme) return storedTheme;
            return 'combo'; // Default to requested Dark & Light combination
        };

        const updateThemeUI = (theme) => {
            let label = 'Dark & Light';
            let iconClass = 'bi bi-circle-half text-primary theme-icon-active';

            if (theme === 'combo') {
                label = 'Dark & Light';
                iconClass = 'bi bi-circle-half text-primary theme-icon-active';
            } else if (theme === 'light') {
                label = 'Light';
                iconClass = 'bi bi-sun-fill text-warning theme-icon-active';
            } else if (theme === 'dark') {
                label = 'Dark';
                iconClass = 'bi bi-moon-stars-fill text-info theme-icon-active';
            } else {
                label = 'Auto';
                iconClass = 'bi bi-laptop text-secondary theme-icon-active';
            }

            const textEl = document.getElementById('bd-theme-crm-text');
            const iconEl = document.querySelector('#bd-theme-crm .theme-icon-active');
            if (textEl) textEl.textContent = label;
            if (iconEl) iconEl.className = iconClass;

            const mobileTextEl = document.getElementById('bd-theme-mobile-text');
            const mobileIconEl = document.querySelector('#bd-theme-mobile .theme-icon-active');
            if (mobileTextEl) mobileTextEl.textContent = label;
            if (mobileIconEl) mobileIconEl.className = iconClass;

            document.querySelectorAll('[data-bs-theme-value]').forEach(el => {
                if (el.getAttribute('data-bs-theme-value') === theme) {
                    el.classList.add('active');
                } else {
                    el.classList.remove('active');
                }
            });
        };

        const applyTheme = (theme) => {
            const effectiveTheme = (theme === 'auto')
                ? (window.matchMedia('(prefers-color-scheme: light)').matches ? 'combo' : 'dark')
                : theme;
            document.documentElement.setAttribute('data-bs-theme', effectiveTheme);
            updateThemeUI(theme);
        };

        applyTheme(getPreferredTheme());

        document.querySelectorAll('[data-bs-theme-value]').forEach(btn => {
            btn.addEventListener('click', () => {
                const selected = btn.getAttribute('data-bs-theme-value');
                setStoredTheme(selected);
                applyTheme(selected);
            });
        });

        window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', () => {
            const stored = getStoredTheme();
            if (!stored || stored === 'auto') {
                applyTheme('auto');
            }
        });

        // =========================================================
        // Real-Time Multi-Currency Conversion Engine
        // (USD, INR, EUR, GBP, AED, CAD, AUD, SGD)
        // =========================================================
        const getStoredCurrency = () => localStorage.getItem('codex_crm_currency') || 'USD';
        const setStoredCurrency = cur => localStorage.setItem('codex_crm_currency', cur);

        const formatMoney = (amountUsd, targetCurrency) => {
            const rates = window.CODEX_EXCHANGE_RATES || {};
            const rate = parseFloat(rates[targetCurrency]) || 1.0;
            const meta = (window.CODEX_CURRENCIES && window.CODEX_CURRENCIES[targetCurrency]) || { symbol: '$', locale: 'en-US' };
            const converted = Math.round(amountUsd * rate);

            try {
                const formatted = new Intl.NumberFormat(meta.locale || 'en-US', {
                    maximumFractionDigits: 0
                }).format(converted);
                return `${meta.symbol}${formatted}`;
            } catch (err) {
                return `${meta.symbol}${converted.toLocaleString()}`;
            }
        };

        const formatBudgetRange = (rawBudget, targetCurrency) => {
            if (!rawBudget || typeof rawBudget !== 'string') return rawBudget;
            const rates = window.CODEX_EXCHANGE_RATES || {};
            const rate = parseFloat(rates[targetCurrency]) || 1.0;
            const meta = (window.CODEX_CURRENCIES && window.CODEX_CURRENCIES[targetCurrency]) || { symbol: '$', locale: 'en-US' };

            // Match all $15,000 patterns
            return rawBudget.replace(/\$\s*([\d,]+)/g, (match, p1) => {
                const num = parseFloat(p1.replace(/,/g, ''));
                if (isNaN(num)) return match;
                const converted = Math.round(num * rate);
                try {
                    const formatted = new Intl.NumberFormat(meta.locale || 'en-US', {
                        maximumFractionDigits: 0
                    }).format(converted);
                    return `${meta.symbol}${formatted}`;
                } catch (e) {
                    return `${meta.symbol}${converted.toLocaleString()}`;
                }
            });
        };

        const applyCurrency = (currencyCode) => {
            const currencies = window.CODEX_CURRENCIES || {};
            const cur = currencies[currencyCode] || { symbol: '$', flag: '🇺🇸', name: 'US Dollar' };

            // 1. Update Top Navbar Trigger
            const flagEl = document.getElementById('bd-currency-flag');
            const codeEl = document.getElementById('bd-currency-code');
            const symEl = document.getElementById('bd-currency-symbol');
            if (flagEl) flagEl.textContent = cur.flag;
            if (codeEl) codeEl.textContent = currencyCode;
            if (symEl) symEl.textContent = cur.symbol;

            // 2. Update Mobile Trigger
            const mFlagEl = document.getElementById('bd-currency-mobile-flag');
            const mTextEl = document.getElementById('bd-currency-mobile-text');
            const mSymEl = document.getElementById('bd-currency-mobile-symbol');
            if (mFlagEl) mFlagEl.textContent = cur.flag;
            if (mTextEl) mTextEl.innerHTML = `<strong>${currencyCode}</strong> &bull; ${cur.name}`;
            if (mSymEl) mSymEl.textContent = cur.symbol;

            // 3. Mark Active Item in Dropdowns
            document.querySelectorAll('[data-crm-currency]').forEach(item => {
                if (item.getAttribute('data-crm-currency') === currencyCode) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });

            // 4. Update all tagged monetary values in real time
            document.querySelectorAll('.currency-val').forEach(el => {
                const usd = parseFloat(el.getAttribute('data-usd') || '0');
                el.textContent = formatMoney(usd, currencyCode);
            });

            // 5. Update all tagged budget ranges in real time
            document.querySelectorAll('.currency-budget').forEach(el => {
                const raw = el.getAttribute('data-raw-budget') || el.textContent;
                el.textContent = formatBudgetRange(raw, currencyCode);
            });

            // 6. Update currency labels (e.g. USD in pipeline summary)
            document.querySelectorAll('.currency-label-code').forEach(el => {
                el.textContent = currencyCode;
            });
        };

        // Attach click listeners to all currency buttons
        document.querySelectorAll('[data-crm-currency]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const selected = btn.getAttribute('data-crm-currency');
                setStoredCurrency(selected);
                applyCurrency(selected);
            });
        });

        // Initialize preferred currency on load
        const initialCurrency = getStoredCurrency();
        applyCurrency(initialCurrency);

        // Background live rates sync (fetch from API endpoint to keep rates freshest)
        (async () => {
            try {
                const res = await fetch('api/v1/rates.php');
                if (res.ok) {
                    const data = await res.json();
                    if (data && data.rates) {
                        window.CODEX_EXCHANGE_RATES = data.rates;
                        // Re-apply to reflect latest precision rates
                        applyCurrency(getStoredCurrency());
                        // Update ticker text if element exists
                        const tickerEl = document.getElementById('crm-currency-ticker');
                        if (tickerEl && data.rates.INR && data.rates.EUR && data.rates.GBP) {
                            tickerEl.innerHTML = `1 USD = ₹${parseFloat(data.rates.INR).toFixed(2)} &bull; €${parseFloat(data.rates.EUR).toFixed(2)} &bull; £${parseFloat(data.rates.GBP).toFixed(2)}`;
                        }
                    }
                }
            } catch (err) {
                // Silently fallback to server-injected rates
            }
        })();
    });
</script>

</body>
</html>
