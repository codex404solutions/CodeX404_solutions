<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Shared HTML Head & Global Styles
 */
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="combo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Command Center') ?> — CodeX404 Solutions CRM &amp; Agent OS</title>
    <meta name="robots" content="noindex, nofollow">

    <script>
        (() => {
            const storedTheme = localStorage.getItem('codex_crm_theme');
            let theme = storedTheme ? storedTheme : 'combo';
            const effective = (theme === 'auto')
                ? (window.matchMedia('(prefers-color-scheme: light)').matches ? 'combo' : 'dark')
                : theme;
            document.documentElement.setAttribute('data-bs-theme', effective);
        })();
        window.CODEX_EXCHANGE_RATES = <?= json_encode($liveExchangeRates ?? [], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
        window.CODEX_CURRENCIES = <?= json_encode(\CRM\Services\CurrencyService::CURRENCIES, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
    </script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/logo/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/logo/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/logo/favicon-16x16.png">

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

        /* Dual-Tone Architecture: Dark & Light Combination */
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

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--cx-bg);
            color: var(--cx-text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        [data-bs-theme="light"] body,
        [data-bs-theme="combo"] body {
            background-color: #F8FAFC !important;
            color: #0F172A !important;
        }

        /* 1. DARK EXECUTIVE SIDEBAR */
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
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 0.85rem;
            border-radius: 8px;
            font-size: 0.84rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.18s ease;
            margin-bottom: 0.25rem;
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

        /* 2. LIGHT/COMBO MAIN WORKSPACE */
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
            border-color: #CBD5E1 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
        }

        [data-bs-theme="light"] .dropdown-item,
        [data-bs-theme="combo"] .dropdown-item {
            color: #334155 !important;
        }

        [data-bs-theme="light"] .dropdown-item:hover,
        [data-bs-theme="combo"] .dropdown-item:hover {
            background-color: #F1F5F9 !important;
            color: #0284C7 !important;
        }

        [data-bs-theme="light"] .dropdown-header,
        [data-bs-theme="combo"] .dropdown-header {
            color: #64748B !important;
        }

        [data-bs-theme="light"] .dropdown-divider,
        [data-bs-theme="combo"] .dropdown-divider {
            border-color: #E2E8F0 !important;
        }

        /* Common Elements */
        .crm-card {
            background: var(--cx-card);
            border: 1px solid var(--cx-border);
            border-radius: 12px;
            padding: 1.25rem;
            transition: all 0.2s ease;
        }

        .crm-card:hover {
            border-color: var(--cx-border-active);
        }

        .agent-card {
            background: var(--cx-card);
            border: 1px solid var(--cx-border);
            border-radius: 12px;
            padding: 1.25rem;
            transition: all 0.25s ease;
        }

        .agent-card:hover {
            border-color: var(--cx-cyan);
            transform: translateY(-2px);
        }

        .agent-badge-pulse {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10B981;
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* FX Ticker Marquee */
        .fx-marquee-container {
            overflow: hidden;
            white-space: nowrap;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
            font-family: 'JetBrains Mono', monospace;
            border: 1px solid var(--cx-border);
        }

        [data-bs-theme="light"] .fx-marquee-container,
        [data-bs-theme="combo"] .fx-marquee-container {
            background: #FFFFFF !important;
            border-color: #E2E8F0 !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .fx-marquee-content {
            display: inline-flex;
            gap: 1.5rem;
            animation: fx-scroll 35s linear infinite;
        }

        .fx-marquee-content:hover {
            animation-play-state: paused;
        }

        @keyframes fx-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Kanban Board Horizontal Scroll / Grid */
        .kanban-board-container {
            display: flex;
            overflow-x: auto;
            gap: 1rem;
            padding-bottom: 1rem;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .kanban-col-item {
            flex: 0 0 280px;
            min-width: 280px;
            scroll-snap-align: start;
        }

        @media (min-width: 1400px) {
            .kanban-board-container {
                display: grid;
                grid-template-columns: repeat(6, 1fr);
                overflow-x: visible;
                gap: 1rem;
            }
            .kanban-col-item {
                flex: initial;
                min-width: 0;
            }
        }

        .kanban-col {
            background: var(--cx-kanban-col);
            border: 1px solid var(--cx-border);
            border-radius: 12px;
            padding: 0.75rem;
            display: flex;
            flex-direction: column;
            min-height: 480px;
        }

        .kanban-deal-card {
            background: var(--cx-kanban-card);
            border: 1px solid var(--cx-border);
            border-radius: 10px;
            padding: 0.85rem;
            margin-bottom: 0.65rem;
            transition: all 0.2s ease;
        }

        .kanban-deal-card:hover {
            border-color: var(--cx-cyan);
            transform: translateY(-2px);
        }

        /* ========================================================= */
        /* CRM COMMAND CENTER ENTERPRISE FOOTER SYSTEM               */
        /* Fully Responsive, Sticky, Multi-Theme (Dark, Combo, Light)*/
        /* ========================================================= */
        .crm-footer {
            background: rgba(17, 24, 39, 0.75);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            padding: 1.5rem 1.5rem;
            margin-top: auto;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.4);
            transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        [data-bs-theme="light"] .crm-footer,
        [data-bs-theme="combo"] .crm-footer {
            background: #FFFFFF !important;
            border-color: #E2E8F0 !important;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05) !important;
        }

        [data-bs-theme="dark"] .crm-footer {
            background: rgba(11, 15, 25, 0.85) !important;
            border-color: rgba(56, 189, 248, 0.15) !important;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.55) !important;
        }

        /* Brand pill in footer */
        .crm-footer-brand-pill {
            display: inline-flex;
            align-items: center;
            background: #0B0F19;
            padding: 4px 10px;
            border-radius: 10px;
            border: 1px solid rgba(56, 189, 248, 0.25);
            text-decoration: none;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .crm-footer-brand-pill:hover {
            transform: translateY(-1px);
            border-color: var(--cx-cyan);
        }

        [data-bs-theme="light"] .crm-footer-brand-pill,
        [data-bs-theme="combo"] .crm-footer-brand-pill {
            background: #F8FAFC !important;
            border-color: #CBD5E1 !important;
        }

        .crm-footer-badge {
            background: #0B0F19;
            color: #38BDF8;
            border: 1px solid rgba(56, 189, 248, 0.3);
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            padding: 0.35rem 0.55rem;
            border-radius: 6px;
        }

        [data-bs-theme="light"] .crm-footer-badge,
        [data-bs-theme="combo"] .crm-footer-badge {
            background: #E0F2FE !important;
            color: #0284C7 !important;
            border-color: #BAE6FD !important;
        }

        /* Telemetry Card Inside CRM Footer */
        .crm-footer-telemetry {
            border-radius: 12px;
            padding: 0.85rem 1rem;
            transition: all 0.2s ease;
        }

        [data-bs-theme="light"] .crm-footer-telemetry,
        [data-bs-theme="combo"] .crm-footer-telemetry {
            background: #F8FAFC !important;
            border: 1px solid #E2E8F0 !important;
        }

        [data-bs-theme="dark"] .crm-footer-telemetry {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        /* Stat Pill Boxes inside CRM Telemetry */
        .crm-footer-stat-box {
            padding: 0.45rem 0.3rem;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.15s ease, background-color 0.2s ease, border-color 0.2s ease;
        }

        [data-bs-theme="light"] .crm-footer-stat-box,
        [data-bs-theme="combo"] .crm-footer-stat-box {
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        }

        [data-bs-theme="dark"] .crm-footer-stat-box {
            background: rgba(0, 0, 0, 0.45) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .crm-footer-stat-box:hover {
            transform: translateY(-2px);
        }

        .crm-footer-stat-label {
            font-size: 0.65rem;
            color: var(--cx-text-muted);
            margin-top: 2px;
        }

        [data-bs-theme="light"] .crm-footer-stat-label,
        [data-bs-theme="combo"] .crm-footer-stat-label {
            color: #64748B !important;
        }

        /* High-contrast stat colors across themes */
        .crm-stat-cyan {
            color: #38BDF8;
        }
        [data-bs-theme="light"] .crm-stat-cyan,
        [data-bs-theme="combo"] .crm-stat-cyan {
            color: #0284C7 !important;
        }

        .crm-stat-amber {
            color: #FBBF24;
        }
        [data-bs-theme="light"] .crm-stat-amber,
        [data-bs-theme="combo"] .crm-stat-amber {
            color: #D97706 !important;
        }

        .crm-stat-emerald {
            color: #34D399;
        }
        [data-bs-theme="light"] .crm-stat-emerald,
        [data-bs-theme="combo"] .crm-stat-emerald {
            color: #059669 !important;
        }

        /* Platform Bridges & Links inside CRM Footer */
        .crm-footer-link {
            color: var(--cx-text-muted);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            padding: 0.35rem 0.6rem;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .crm-footer-link:hover {
            color: #38BDF8 !important;
            background: rgba(56, 189, 248, 0.08);
            transform: translateX(2px);
        }

        [data-bs-theme="light"] .crm-footer-link,
        [data-bs-theme="combo"] .crm-footer-link {
            color: #334155 !important;
        }

        [data-bs-theme="light"] .crm-footer-link:hover,
        [data-bs-theme="combo"] .crm-footer-link:hover {
            color: #0284C7 !important;
            background: rgba(2, 132, 199, 0.08);
        }

        /* Divider Border inside CRM Footer */
        .crm-footer-divider {
            border-top: 1px solid var(--cx-border) !important;
        }

        [data-bs-theme="light"] .crm-footer-divider,
        [data-bs-theme="combo"] .crm-footer-divider {
            border-top-color: #E2E8F0 !important;
        }

        [data-bs-theme="dark"] .crm-footer-divider {
            border-top-color: rgba(255, 255, 255, 0.08) !important;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0 flex-grow-1 d-flex flex-column">
    <div class="row g-0 flex-grow-1">
