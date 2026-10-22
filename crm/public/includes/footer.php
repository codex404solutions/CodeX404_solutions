<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Shared Footer System
 * Enterprise Sticky Footer, Closing Layout Tags, Modals & Scripts
 */
?>

    <!-- ======================================================== -->
    <!-- CRM COMMAND CENTER ENTERPRISE FOOTER                     -->
    <!-- ======================================================== -->
    <footer class="crm-footer mt-auto">
        <div class="row g-4 align-items-center">
            <!-- Brand & Platform Architecture -->
            <div class="col-12 col-md-5">
                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                    <span class="crm-footer-brand-pill">
                        <img src="assets/images/logo/logo.png" alt="CodeX404 Solutions" style="height: 26px; object-fit: contain;">
                    </span>
                    <span class="badge crm-footer-badge text-uppercase">CRM &amp; AGENT OS</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.68rem;">v4.0.4 Enterprise</span>
                </div>
                <p class="text-muted small mb-2" style="max-width: 440px;">
                    Autonomous multi-agent pipeline orchestration with deterministic HITL decision governance, live real-time FX conversions, and sub-100ms task latency.
                </p>
                <div class="d-flex align-items-center gap-2 text-muted small flex-wrap" style="font-size: 0.75rem;">
                    <span class="text-nowrap"><i class="bi bi-shield-check text-success me-1"></i>HMAC Ingestion</span>
                    <span>&bull;</span>
                    <span class="text-nowrap"><i class="bi bi-lightning-charge-fill text-warning me-1"></i>Paperclip Armed</span>
                    <span>&bull;</span>
                    <span class="text-nowrap"><i class="bi bi-clock-history text-info me-1"></i>99.98% SLA</span>
                </div>
            </div>

            <!-- Live Telemetry Badges -->
            <div class="col-12 col-md-4">
                <div class="crm-footer-telemetry">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.06em;">System Status</span>
                        <span class="d-flex align-items-center gap-1 text-success small" style="font-size: 0.72rem;">
                            <span class="agent-badge-pulse" style="width: 6px; height: 6px;"></span> All Daemons Operational
                        </span>
                    </div>
                    <div class="row g-2 text-center" style="font-size: 0.75rem;">
                        <div class="col-4">
                            <div class="crm-footer-stat-box">
                                <div class="fw-bold crm-stat-cyan"><?= isset($agents) ? count($agents) : 7 ?>/7</div>
                                <div class="crm-footer-stat-label">Swarm Nodes</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="crm-footer-stat-box">
                                <div class="fw-bold crm-stat-amber"><?= isset($pendingApprovals) ? count($pendingApprovals) : 0 ?></div>
                                <div class="crm-footer-stat-label">HITL Queue</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="crm-footer-stat-box">
                                <div class="fw-bold crm-stat-emerald"><?= $totalLeads ?? 0 ?></div>
                                <div class="crm-footer-stat-label">Total Inbound</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cross-Platform Bridges -->
            <div class="col-12 col-md-3 text-md-end">
                <div class="small fw-bold text-uppercase text-muted mb-2" style="font-size: 0.68rem; letter-spacing: 0.06em;">Platform Bridges</div>
                <div class="d-flex flex-column gap-1 align-items-md-end">
                    <a href="../website/admin/" target="_blank" class="crm-footer-link text-info">
                        <i class="bi bi-grid-1x2-fill"></i> <span>Website Portfolio Admin</span>
                    </a>
                    <a href="../website/discovery-call" target="_blank" class="crm-footer-link">
                        <i class="bi bi-lightning-charge text-warning"></i> <span>Public Lead Intake Form</span>
                    </a>
                    <a href="../website/" target="_blank" class="crm-footer-link">
                        <i class="bi bi-box-arrow-up-right text-primary"></i> <span>CodeX404 Public Front</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright & Security Notice -->
        <div class="crm-footer-divider pt-3 mt-3 d-flex flex-wrap align-items-center justify-content-between gap-2" style="font-size: 0.75rem;">
            <div class="text-muted">
                &copy; <?= date('Y') ?> <strong>CodeX404 Solutions</strong>. Autonomous Multi-Agent CRM OS &bull; Built with PHP 8.3 &bull; Bootstrap 5.3.3 &bull; All Rights Reserved.
            </div>
            <div class="d-flex align-items-center gap-3 text-muted flex-wrap">
                <span class="d-flex align-items-center gap-1"><i class="bi bi-hdd-stack text-info"></i> Storage: JSON Atomic</span>
                <span>&bull;</span>
                <span class="d-flex align-items-center gap-1"><i class="bi bi-shield-lock text-success"></i> Strict CSRF</span>
                <span>&bull;</span>
                <a href="logout" class="text-danger text-decoration-none fw-semibold"><i class="bi bi-box-arrow-left me-1"></i>Sign Out</a>
            </div>
        </div>
    </footer>
</main>
</div>
</div>

<?php
require_once __DIR__ . '/modals.php';
require_once __DIR__ . '/scripts.php';
?>
</body>
</html>
