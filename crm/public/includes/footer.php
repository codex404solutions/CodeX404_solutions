<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Unified Footer, Modals & Scripts Shell
 */
?>
            <!-- ======================================================== -->
            <!-- CRM COMMAND CENTER ENTERPRISE FOOTER SYSTEM               -->
            <!-- ======================================================== -->
            <footer class="crm-footer mt-auto pt-4 pb-3">
                <div class="row g-4 align-items-center">
                    <!-- Brand & Platform Architecture -->
                    <div class="col-12 col-md-5">
                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                            <span class="crm-footer-brand-pill">
                                <img src="assets/images/logo/logo.png" alt="CodeX404 Solutions" style="height: 24px; object-fit: contain;">
                            </span>
                            <span class="badge crm-footer-badge text-uppercase">CRM &amp; AGENT OS</span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold" style="font-size: 0.68rem;">v4.0.4 Enterprise</span>
                        </div>
                        <p class="text-muted small mb-0" style="font-size: 0.78rem; line-height: 1.5;">
                            Autonomous B2B Customer Relationship Management &amp; Paperclip Multi-Agent Operations Command Center. Powered by deterministic storage locks, real-time multi-currency FX conversions, and human-in-the-loop governance.
                        </p>
                    </div>

                    <!-- Telemetry & Metric Highlights -->
                    <div class="col-12 col-md-4">
                        <div class="crm-footer-telemetry p-2">
                            <div class="row g-2 text-center">
                                <div class="col-4">
                                    <div class="crm-footer-stat-box">
                                        <div class="fw-bold text-success" style="font-size: 0.95rem;"><?= count($opportunities) ?></div>
                                        <div class="crm-footer-stat-label">Active Deals</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="crm-footer-stat-box">
                                        <div class="fw-bold text-info" style="font-size: 0.95rem;"><?= count($agents) ?></div>
                                        <div class="crm-footer-stat-label">Paperclip Swarm</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="crm-footer-stat-box">
                                        <div class="fw-bold text-warning" style="font-size: 0.95rem;"><?= count($pendingApprovals) ?></div>
                                        <div class="crm-footer-stat-label">Pending HITL</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Platform Bridges & Navigation Links -->
                    <div class="col-12 col-md-3 text-md-end">
                        <div class="d-flex flex-column gap-1 align-items-md-end">
                            <a href="../website/admin/" target="_blank" class="crm-footer-link">
                                <i class="bi bi-shield-lock text-info"></i> <span>Portfolio &amp; Admin Panel</span>
                            </a>
                            <a href="../website/discovery-call" target="_blank" class="crm-footer-link">
                                <i class="bi bi-lightning-charge text-warning"></i> <span>Client Discovery Intake</span>
                            </a>
                            <a href="../website/" target="_blank" class="crm-footer-link">
                                <i class="bi bi-globe2 text-primary"></i> <span>Public Production Website</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Bottom Status & Copyright Divider -->
                <div class="crm-footer-divider mt-3 pt-3 d-flex flex-wrap align-items-center justify-content-between gap-2" style="font-size: 0.72rem;">
                    <div class="text-muted">
                        &copy; <?= date('Y') ?> <strong>CodeX404 Solutions</strong> &bull; All Rights Reserved. Enterprise Dual-Tone UI Architecture.
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted d-flex align-items-center gap-1">
                            <span class="agent-badge-pulse" style="width: 6px; height: 6px;"></span>
                            Storage: MySQL (codex404_db)
                        </span>
                        <span class="text-muted d-none d-sm-inline">&bull;</span>
                        <span class="text-muted">Multi-Page CRM Engine</span>
                    </div>
                </div>
            </footer>

        </main>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 1: NEW INBOUND LEAD                                -->
<!-- ======================================================== -->
<div class="modal fade" id="modalNewLead" tabindex="-1" aria-labelledby="modalNewLeadLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= \CRM\Services\CrmSecurity::escape($csrfToken) ?>">
                <input type="hidden" name="action" value="create_lead">
                <input type="hidden" name="return_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalNewLeadLabel"><i class="bi bi-person-plus-fill text-warning me-2"></i>Record New Inbound Lead</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted">Prospect Full Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Sarah Jenkins" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted">Work Email Address *</label>
                            <input type="email" name="email" class="form-control" placeholder="s.jenkins@enterprise.com" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="+1 (555) 234-5678">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted">Company Name</label>
                            <input type="text" name="company_name" class="form-control" placeholder="Apex Global Logistics">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted">Target Country</label>
                            <select name="country" class="form-select">
                                <option value="United States" selected>United States (USA)</option>
                                <option value="United Kingdom">United Kingdom (UK)</option>
                                <option value="Canada">Canada</option>
                                <option value="Germany">Germany</option>
                                <option value="Australia">Australia</option>
                                <option value="United Arab Emirates">United Arab Emirates (UAE)</option>
                                <option value="India">India</option>
                                <option value="Other">Other / Global</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted">Service Interest</label>
                            <select name="service_interest" class="form-select">
                                <option value="Custom Web Application" selected>Custom Web Application</option>
                                <option value="Enterprise CRM / SaaS Platform">Enterprise CRM / SaaS Platform</option>
                                <option value="Autonomous Multi-Agent AI System">Autonomous Multi-Agent AI System</option>
                                <option value="Legacy Stack Modernization">Legacy Stack Modernization</option>
                                <option value="Full Cloud Infrastructure &amp; DevOps">Full Cloud Infrastructure &amp; DevOps</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted">Projected Budget Bracket</label>
                            <select name="budget" class="form-select">
                                <option value="$10,000 - $20,000">$10,000 - $20,000</option>
                                <option value="$20,000 - $35,000" selected>$20,000 - $35,000 (Sweet Spot)</option>
                                <option value="$35,000 - $60,000">$35,000 - $60,000</option>
                                <option value="$60,000 - $100,000+">$60,000 - $100,000+ (Enterprise)</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label small text-muted">Expected Timeline</label>
                            <select name="timeline" class="form-select">
                                <option value="Immediate (< 1 month)">Immediate (&lt; 1 month)</option>
                                <option value="1-2 months" selected>1-2 months</option>
                                <option value="2-4 months">2-4 months</option>
                                <option value="Flexible / Discovery Phase">Flexible / Discovery Phase</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Problem Statement &amp; High-Level Architecture Requirements</label>
                            <textarea name="problem_description" class="form-control" rows="3" placeholder="Describe the business problem, current bottlenecks, desired integrations, or target deliverables..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold px-4">
                        <i class="bi bi-check2-circle me-1"></i> Save &amp; Auto-Score Lead
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 2: NEW SALES OPPORTUNITY / DEAL                   -->
<!-- ======================================================== -->
<div class="modal fade" id="modalNewDeal" tabindex="-1" aria-labelledby="modalNewDealLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= \CRM\Services\CrmSecurity::escape($csrfToken) ?>">
                <input type="hidden" name="action" value="create_opportunity">
                <input type="hidden" name="return_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalNewDealLabel"><i class="bi bi-cash-stack text-success me-2"></i>Add Deal to Sales Pipeline</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Deal Title *</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. NextGen Logistics Portal Architecture" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted">Client Company *</label>
                            <input type="text" name="company" class="form-control" placeholder="Apex Logistics" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Deal Value (USD) *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="value" class="form-control" placeholder="25000" step="1000" value="25000" required>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted">Client Contact Name</label>
                            <input type="text" name="client_name" class="form-control" placeholder="Sarah Jenkins">
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Client Email</label>
                            <input type="email" name="client_email" class="form-control" placeholder="sarah@apex.com">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted">Initial Stage</label>
                            <select name="stage" class="form-select">
                                <option value="lead_in">Lead In</option>
                                <option value="discovery" selected>Discovery</option>
                                <option value="proposal_draft">Proposal Draft</option>
                                <option value="proposal_sent">Proposal Sent</option>
                                <option value="negotiation">Negotiation</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Assigned Specialist</label>
                            <select name="assigned_to" class="form-select">
                                <option value="Pre-Sales Engineer">Pre-Sales Engineer</option>
                                <option value="Sales Discovery Coach">Sales Discovery Coach</option>
                                <option value="Technical Proposal Writer">Technical Proposal Writer</option>
                                <option value="Founder / Principal Architect" selected>Founder / Principal</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Expected Close Date</label>
                        <input type="date" name="expected_close_date" class="form-control" value="<?= date('Y-m-d', strtotime('+3 weeks')) ?>">
                    </div>
                    <div class="mb-0">
                        <label class="form-label small text-muted">Opportunity Notes &amp; Scope Summary</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Key deliverables, tech constraints, budget approval status..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success fw-bold px-4">
                        <i class="bi bi-plus-lg me-1"></i> Add to Pipeline
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 3: NEW CLIENT DELIVERY PROJECT                     -->
<!-- ======================================================== -->
<div class="modal fade" id="modalNewProject" tabindex="-1" aria-labelledby="modalNewProjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= \CRM\Services\CrmSecurity::escape($csrfToken) ?>">
                <input type="hidden" name="action" value="create_project">
                <input type="hidden" name="return_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalNewProjectLabel"><i class="bi bi-rocket-takeoff-fill text-primary me-2"></i>Initialize Client Deliverable</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Project / Deliverable Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Horizon Fleet IoT Real-Time Dashboard" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted">Client Company Name *</label>
                            <input type="text" name="client_name" class="form-control" placeholder="Horizon Logistics LLC" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Client Email</label>
                            <input type="email" name="client_email" class="form-control" placeholder="contact@horizon.com">
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted">Contract Budget (USD)</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="budget" class="form-control" placeholder="28000" step="1000" value="28000">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Target Delivery Deadline</label>
                            <input type="date" name="deadline" class="form-control" value="<?= date('Y-m-d', strtotime('+6 weeks')) ?>">
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small text-muted">Lead Engineering Agent</label>
                        <select name="lead_engineer" class="form-select">
                            <option value="Senior Full-Stack Architect" selected>Senior Full-Stack Architect</option>
                            <option value="Senior Code Reviewer">Senior Code Reviewer</option>
                            <option value="DevOps &amp; Infrastructure Lead">DevOps &amp; Infrastructure Lead</option>
                            <option value="Security &amp; Compliance Auditor">Security &amp; Compliance Auditor</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">
                        <i class="bi bi-rocket-fill me-1"></i> Launch Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 4: DISPATCH PAPERCLIP AGENT                        -->
<!-- ======================================================== -->
<div class="modal fade" id="modalDispatchAgent" tabindex="-1" aria-labelledby="modalDispatchAgentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= \CRM\Services\CrmSecurity::escape($csrfToken) ?>">
                <input type="hidden" name="action" value="dispatch_paperclip">
                <input type="hidden" name="return_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalDispatchAgentLabel"><i class="bi bi-robot text-info me-2"></i>Dispatch Autonomous Specialist Agent</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Target Specialist Agent *</label>
                        <select name="agent_slug" id="dispatchAgentSelect" class="form-select">
                            <?php foreach ($agents as $slug => $ag): ?>
                                <option value="<?= htmlspecialchars($slug) ?>"><?= htmlspecialchars($ag['name']) ?> (<?= htmlspecialchars($ag['title']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Task Brief Title *</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Conduct Deep Competitor & Architecture Teardown" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Detailed Instructions / Context Prompt</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Provide background constraints, desired output format, or specific technologies to assess..."></textarea>
                    </div>
                    <div class="row g-2 mb-0">
                        <div class="col-6">
                            <label class="form-label small text-muted">Execution Priority</label>
                            <select name="priority" class="form-select">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High (Immediate)</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Associated Prospect (Optional)</label>
                            <select name="lead_id" id="dispatchLeadSelect" class="form-select">
                                <option value="">-- None / Internal --</option>
                                <?php foreach ($leads as $l): ?>
                                    <option value="<?= htmlspecialchars($l['id']) ?>"><?= htmlspecialchars($l['name']) ?> (<?= htmlspecialchars($l['company_name'] ?? 'Co') ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info text-dark fw-bold px-4">
                        <i class="bi bi-send-fill me-1"></i> Dispatch &amp; Execute
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 5: 1-CLICK AUTONOMOUS AGENT ROUTINES               -->
<!-- ======================================================== -->
<div class="modal fade" id="modalAgentRoutines" tabindex="-1" aria-labelledby="modalAgentRoutinesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= \CRM\Services\CrmSecurity::escape($csrfToken) ?>">
                <input type="hidden" name="action" value="run_routine">
                <input type="hidden" name="return_url" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalAgentRoutinesLabel"><i class="bi bi-lightning-fill text-warning me-2"></i>Execute Autonomous Routine</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-muted mb-3">
                        Autonomous routines coordinate multiple specialized agents to complete high-impact business workflows without manual prompting.
                    </p>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Select Standard Operating Routine *</label>
                        <select name="routine" class="form-select" required>
                            <option value="triage_inbound_lead">1. Inbound Lead Triage &amp; MEDDPICC Qualification</option>
                            <option value="generate_web_proposal">2. Technical Proposal &amp; Architecture Spec Generation</option>
                            <option value="senior_code_audit">3. Autonomous Code Review &amp; Security Audit</option>
                            <option value="delivery_signoff">4. Client Milestone Verification &amp; Delivery Sign-Off</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small text-muted">Context Lead (Optional)</label>
                        <select name="lead_id" class="form-select">
                            <option value="">-- Apply to Most Recent Prospect --</option>
                            <?php foreach ($leads as $l): ?>
                                <option value="<?= htmlspecialchars($l['id']) ?>"><?= htmlspecialchars($l['name']) ?> (<?= htmlspecialchars($l['company_name'] ?? 'N/A') ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold px-4">
                        <i class="bi bi-play-circle-fill me-1"></i> Run Routine Now
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 6: AGENT OUTPUT VIEWER                             -->
<!-- ======================================================== -->
<div class="modal fade" id="modalViewOutput" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-0" id="outputModalTitle">Task Execution Output</h5>
                    <small class="text-info" id="outputModalAgent">Executed by Specialist Agent</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <pre id="outputModalBody" class="mono text-light p-3 rounded mb-0" style="background: rgba(0, 0, 0, 0.4); max-height: 480px; overflow-y: auto; white-space: pre-wrap; font-size: 0.82rem;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MOBILE OFFCANVAS SIDEBAR (Multi-Page Navigation)         -->
<!-- ======================================================== -->
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar" style="width: 280px;">
    <div class="offcanvas-header border-bottom border-secondary">
        <a href="dashboard" class="d-inline-block text-decoration-none">
            <img src="assets/images/logo/logo.png" alt="CodeX404 Solutions" style="max-height: 38px; object-fit: contain;">
        </a>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-3">
        <nav class="nav flex-column" id="mobileNav">
            <a href="dashboard" class="crm-nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill me-2"></i> Dashboard
            </a>
            <a href="leads" class="crm-nav-link <?= $currentPage === 'leads' ? 'active' : '' ?>">
                <i class="bi bi-person-lines-fill me-2"></i> Inbound Leads (<?= $totalLeads ?>)
            </a>
            <a href="pipeline" class="crm-nav-link <?= $currentPage === 'pipeline' ? 'active' : '' ?>">
                <i class="bi bi-kanban-fill me-2"></i> Sales Pipeline
            </a>
            <a href="projects" class="crm-nav-link <?= $currentPage === 'projects' ? 'active' : '' ?>">
                <i class="bi bi-rocket-takeoff-fill me-2"></i> Client Delivery
            </a>
            <a href="paperclip" class="crm-nav-link <?= $currentPage === 'paperclip' ? 'active' : '' ?>">
                <i class="bi bi-robot me-2"></i> Paperclip Agents
            </a>
            <a href="approvals" class="crm-nav-link <?= $currentPage === 'approvals' ? 'active' : '' ?>">
                <i class="bi bi-shield-check me-2"></i> Approvals (<?= count($pendingApprovals) ?>)
            </a>
            <a href="users" class="crm-nav-link <?= $currentPage === 'users' ? 'active' : '' ?>">
                <i class="bi bi-people-fill me-2 text-info"></i> Users &amp; Roles (<?= $totalWorkforceCount ?? count($allUsers ?? []) ?>)
            </a>
            <?php 
            $userRolesListMob = array_map('strtolower', (array)($currentUser['roles'] ?? []));
            if (in_array('superadmin', $userRolesListMob, true) || in_array('founder', $userRolesListMob, true)):
            ?>
                <a href="hierarchy-settings" class="crm-nav-link <?= $currentPage === 'hierarchy-settings' ? 'active' : '' ?>">
                    <i class="bi bi-diagram-3-fill me-2 text-warning"></i> Hierarchy &amp; Rules
                </a>
            <?php endif; ?>
            <a href="profile" class="crm-nav-link <?= $currentPage === 'profile' ? 'active' : '' ?>">
                <i class="bi bi-person-badge me-2 text-primary"></i> My Full Profile
            </a>
            <a href="settings" class="crm-nav-link <?= $currentPage === 'settings' ? 'active' : '' ?>">
                <i class="bi bi-sliders me-2"></i> System &amp; API
            </a>
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
            <a href="../website/discovery-call" target="_blank" class="btn btn-sm btn-outline-warning text-start"><i class="bi bi-lightning-charge me-1"></i> Public Discovery Form</a>
            <a href="logout" class="btn btn-sm btn-danger text-start mt-2"><i class="bi bi-box-arrow-left me-1"></i> Sign Out</a>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3.3 Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- CRM Console JS (Browser-Cached) -->
    <script src="js/crm.js?v=<?= file_exists(dirname(__DIR__) . '/js/crm.js') ? filemtime(dirname(__DIR__) . '/js/crm.js') : time() ?>" defer></script>

</body>
</html>
