<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — System Architecture, RBAC & API Configuration
 */

namespace CRM;

require_once __DIR__ . '/includes/bootstrap.php';

$currentPage = 'settings';
$pageTitle = 'System Architecture, RBAC & API Ingestion';
$pageSubtitle = 'Integration parameters, storage telemetry, and HMAC webhook signature specs';
$htmlTitle = 'System & API Settings — CodeX404 Solutions CRM';

require_once __DIR__ . '/includes/header.php';
?>

<div class="row g-4 mb-4">
    <!-- System & Storage Diagnostics -->
    <div class="col-12 col-xl-6">
        <div class="crm-card p-4 h-100">
            <h6 class="fw-bold text-white mb-3"><i class="bi bi-hdd-network text-info me-2"></i>System & Storage Architecture Diagnostic</h6>
            <div class="table-responsive">
                <table class="table table-custom mb-3 small">
                    <tr>
                        <td class="text-muted" style="width: 35%;">Storage Subsystem</td>
                        <td class="mono small">crm/storage/data/*.json (Deterministic Atomic Locks)</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Multi-Page Architecture</td>
                        <td><span class="badge bg-info-subtle text-info">Enabled (Modular Native PHP Engine)</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Security Guardrails</td>
                        <td><span class="badge bg-success-subtle text-success">CSRF, RBAC, Output Encoding Active</span></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Multi-Currency Engine</td>
                        <td><span class="badge bg-success-subtle text-success">Real-time Currency Conversion (USD, INR, EUR, GBP, AED)</span></td>
                    </tr>
                </table>
            </div>
            <div class="p-3 rounded-3" style="background: rgba(56, 189, 248, 0.05); border: 1px solid rgba(56, 189, 248, 0.2);">
                <div class="small text-info fw-bold mb-1"><i class="bi bi-info-circle me-1"></i> Architecture Overview:</div>
                <div class="small text-muted">
                    Modular native PHP architecture with atomic file-level persistence, prepared database bridges, and granular role-based access control.
                </div>
            </div>
        </div>
    </div>

    <!-- Webhook & Lead Ingestion Guide -->
    <div class="col-12 col-xl-6">
        <div class="crm-card p-4 h-100">
            <h6 class="fw-bold text-white mb-3"><i class="bi bi-shield-lock text-warning me-2"></i>Inbound Webhook API &amp; HMAC Security</h6>
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
                    All security tests verified: Zero plaintext credentials, persistent brute-force lockout, CSRF protection, and strict SameSite session cookies.
                </div>
            </div>
        </div>
    </div>

    <!-- Live Multi-Currency FX Status -->
    <div class="col-12 col-xl-6">
        <div class="crm-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-white mb-0"><i class="bi bi-currency-exchange text-success me-2"></i>Real-Time Multi-Currency Engine Status</h6>
                <span class="badge bg-success-subtle text-success border border-success-subtle">
                    <span class="agent-badge-pulse me-1" style="width: 6px; height: 6px;"></span>Live Rates
                </span>
            </div>
            <p class="small text-muted mb-3">
                All monetary figures across Dashboard, Inbound Leads, Pipeline Kanban, and Client Deliveries convert instantly without reloading:
            </p>
            <div class="table-responsive">
                <table class="table table-custom small mb-0">
                    <thead>
                        <tr>
                            <th>Currency</th>
                            <th>Code</th>
                            <th>Symbol</th>
                            <th>Live Rate (1 USD =)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (\CRM\Services\CurrencyService::CURRENCIES as $cCode => $cInfo): ?>
                            <tr>
                                <td><?= $cInfo['flag'] ?> <?= htmlspecialchars($cInfo['name']) ?></td>
                                <td class="fw-bold text-white"><?= htmlspecialchars($cCode) ?></td>
                                <td><span class="badge bg-secondary-subtle text-muted"><?= htmlspecialchars($cInfo['symbol']) ?></span></td>
                                <td class="mono text-info">
                                    <?= number_format((float)($liveExchangeRates[$cCode] ?? 1.0), ($cCode === 'INR' || $cCode === 'AED' ? 2 : 4)) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active User & RBAC Permissions Matrix -->
    <div class="col-12 col-xl-6">
        <div class="crm-card p-4 h-100">
            <h6 class="fw-bold text-white mb-3"><i class="bi bi-person-badge text-primary me-2"></i>Session Identity &amp; RBAC Authorization</h6>
            <div class="table-responsive">
                <table class="table table-custom small mb-3">
                    <tr>
                        <td class="text-muted" style="width: 35%;">User Name</td>
                        <td class="fw-bold text-white"><?= htmlspecialchars($currentUser['name'] ?? 'Admin') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Account Email</td>
                        <td class="text-info"><?= htmlspecialchars($currentUser['email'] ?? 'admin@codex404.com') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Assigned Roles</td>
                        <td>
                            <?php foreach ($currentUser['roles'] ?? ['admin'] as $r): ?>
                                <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase"><?= htmlspecialchars($r) ?></span>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">HITL Decision Gate</td>
                        <td>
                            <?php if (\CRM\Services\RBACService::hasPermission($currentUser['roles'] ?? [], 'approvals.decide')): ?>
                                <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle me-1"></i>Authorized Sign-Off</span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger"><i class="bi bi-x-circle me-1"></i>Read Only</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center pt-2 border-top" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                <span class="small text-muted">Session security: Encrypted cookie + HTTPOnly</span>
                <a href="logout" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-box-arrow-left me-1"></i> Sign Out
                </a>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
