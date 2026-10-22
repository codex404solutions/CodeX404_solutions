<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Shared Creation & Dispatch Modals
 */

use CRM\Services\CrmSecurity;
$currentPage = $activePage ?? 'dashboard';
?>

<!-- ================================================================ -->
<!-- MODAL: ADD NEW INBOUND LEAD                                      -->
<!-- ================================================================ -->
<div class="modal fade" id="modalNewLead" tabindex="-1" aria-labelledby="modalNewLeadLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= CrmSecurity::escape($csrfToken) ?>">
                <input type="hidden" name="action" value="create_lead">
                <input type="hidden" name="return_page" value="<?= htmlspecialchars($currentPage) ?>">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalNewLeadLabel">
                        <i class="bi bi-person-plus-fill text-warning me-2"></i>Create Inbound Lead
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <input type="hidden" name="return_page" value="<?= htmlspecialchars($currentPage) ?>">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalNewDealLabel">
                        <i class="bi bi-briefcase-fill text-success me-2"></i>Add Pipeline Opportunity
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <input type="hidden" name="return_page" value="<?= htmlspecialchars($currentPage) ?>">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalNewProjectLabel">
                        <i class="bi bi-rocket-takeoff-fill text-primary me-2"></i>Create Client Delivery Project
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                <input type="hidden" name="return_page" value="<?= htmlspecialchars($currentPage) ?>">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalDispatchAgentLabel">
                        <i class="bi bi-robot text-info me-2"></i>Dispatch Paperclip Specialist Agent
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-muted">Target Specialist Agent <span class="text-danger">*</span></label>
                            <select name="agent_slug" id="dispatchAgentSelect" class="form-select">
                                <?php foreach (($agents ?? []) as $slug => $ag): ?>
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
                                <?php foreach (($leads ?? []) as $l): ?>
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
                <input type="hidden" name="return_page" value="<?= htmlspecialchars($currentPage) ?>">

                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="modalAgentRoutinesLabel">
                        <i class="bi bi-lightning-fill text-warning me-2"></i>Select &amp; Execute Agent Routine
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-muted">Routine Category <span class="text-danger">*</span></label>
                            <select name="routine" class="form-select">
                                <option value="tech_audit" selected>⚡ Tech Stack &amp; Architecture Audit (Technical Lead)</option>
                                <option value="discovery_questions">⚡ Discovery Questions Brief (Lead Researcher)</option>
                                <option value="draft_email">⚡ Personalized Cold Outreach (Sales Engineer -&gt; HITL)</option>
                                <option value="security_scan">⚡ Application OWASP Security Gate (QA &amp; Security)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-muted">Select Target Prospect Context (Optional)</label>
                            <select name="lead_id" class="form-select">
                                <option value="">-- Generic CodeX404 Template Context --</option>
                                <?php foreach (($leads ?? []) as $l): ?>
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
                    <h5 class="modal-title fw-bold mb-0" id="outputModalTitle">Agent Output</h5>
                    <small class="text-info" id="outputModalAgent"></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <pre id="outputModalBody" class="mono p-3 rounded" style="background: rgba(0, 0, 0, 0.5); border: 1px solid rgba(255, 255, 255, 0.1); max-height: 480px; overflow-y: auto; white-space: pre-wrap; font-size: 0.85rem;"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
