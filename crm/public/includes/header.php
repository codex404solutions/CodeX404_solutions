<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — CRM Unified Header & Layout Shell
 */

$currentPage = $currentPage ?? 'dashboard';
$pageTitle = $pageTitle ?? 'Company CRM & Paperclip Command Center';
$pageSubtitle = $pageSubtitle ?? 'Autonomous multi-agent pipeline with Human-in-the-Loop governance';
$htmlTitle = $htmlTitle ?? ($pageTitle . ' — CodeX404 Solutions CRM');
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($htmlTitle) ?></title>

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
            --cx-bg: #040711;
            --cx-card: #0A0F1D;
            --cx-card-hover: #0F172A;
            --cx-nav-bg: #070B14;
            --cx-border: rgba(56, 189, 248, 0.16);
            --cx-border-active: rgba(56, 189, 248, 0.4);
            --cx-cyan: #38BDF8;
            --cx-emerald: #10B981;
            --cx-amber: #F59E0B;
            --cx-purple: #818CF8;
            --cx-text-primary: #F8FAFC;
            --cx-text-muted: #94A3B8;
            --cx-kanban-col: rgba(10, 15, 29, 0.7);
            --cx-kanban-card: #111827;
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
            background: #070B14 !important;
            border-right: 1px solid rgba(56, 189, 248, 0.16) !important;
            color: #F8FAFC !important;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .crm-sidebar-inner {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .crm-sidebar-section-title {
            font-size: 0.68rem;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: var(--cx-text-muted);
            margin-bottom: 0.45rem;
            padding: 0 0.4rem;
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
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .crm-nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.48rem 0.7rem;
            border-radius: 8px;
            color: var(--cx-text-muted);
            font-size: 0.82rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-bottom: 0.25rem;
        }

        .crm-nav-link:hover,
        .crm-sidebar .crm-nav-link:hover,
        [data-bs-theme="light"] .crm-sidebar .crm-nav-link:hover,
        [data-bs-theme="combo"] .crm-sidebar .crm-nav-link:hover,
        #mobileSidebar .crm-nav-link:hover {
            color: #38BDF8 !important;
            background: rgba(56, 189, 248, 0.08) !important;
        }

        .crm-nav-link.active,
        .crm-sidebar .crm-nav-link.active,
        [data-bs-theme="light"] .crm-sidebar .crm-nav-link.active,
        [data-bs-theme="combo"] .crm-sidebar .crm-nav-link.active,
        #mobileSidebar .crm-nav-link.active {
            color: #FFFFFF !important;
            background: rgba(56, 189, 248, 0.14) !important;
            border-left: 3px solid #38BDF8 !important;
            font-weight: 600;
        }

        .crm-sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.42rem 0.65rem;
            border-radius: 8px;
            color: var(--cx-text-muted);
            font-size: 0.78rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .crm-sidebar-link:hover {
            color: #38BDF8;
            background: rgba(56, 189, 248, 0.08);
            border-color: rgba(56, 189, 248, 0.3);
        }

        /* 2. DUAL-TONE WORKSPACE BODY */
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--cx-bg);
            color: var(--cx-text-primary);
            min-height: 100vh;
        }

        .mono {
            font-family: 'JetBrains Mono', monospace;
        }

        .crm-card {
            background-color: var(--cx-card);
            border: 1px solid var(--cx-border);
            border-radius: 14px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .crm-card:hover {
            border-color: var(--cx-border-active);
        }

        .metric-card {
            border-radius: 12px;
            padding: 1.25rem;
            background: var(--cx-card);
            border: 1px solid var(--cx-border);
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .metric-card:hover {
            transform: translateY(-2px);
            border-color: var(--cx-border-active);
        }

        [data-bs-theme="light"] .metric-card,
        [data-bs-theme="combo"] .metric-card,
        [data-bs-theme="light"] .crm-card,
        [data-bs-theme="combo"] .crm-card {
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05) !important;
        }

        [data-bs-theme="light"] .metric-card:hover,
        [data-bs-theme="combo"] .metric-card:hover,
        [data-bs-theme="light"] .crm-card:hover,
        [data-bs-theme="combo"] .crm-card:hover {
            border-color: #0284C7 !important;
            box-shadow: 0 10px 15px -3px rgba(14, 165, 233, 0.12), 0 4px 6px -4px rgba(14, 165, 233, 0.08) !important;
        }

        .agent-card {
            background: var(--cx-card);
            border: 1px solid var(--cx-border);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .agent-card:hover {
            border-color: var(--cx-cyan);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(56, 189, 248, 0.1);
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

        .kanban-col {
            background: rgba(17, 24, 39, 0.6);
            border: 1px solid var(--cx-border);
            border-radius: 12px;
            min-height: 520px;
            padding: 1rem;
        }

        [data-bs-theme="light"] .kanban-col,
        [data-bs-theme="combo"] .kanban-col {
            background: #F1F5F9 !important;
            border: 1px solid #CBD5E1 !important;
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

        .approval-box {
            background: rgba(245, 158, 11, 0.04);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 12px;
            padding: 1.25rem;
        }

        [data-bs-theme="light"] .approval-box,
        [data-bs-theme="combo"] .approval-box {
            background: #FFFBEB !important;
            border: 1px solid #FDE68A !important;
        }

        .modal-content {
            background-color: #111827;
            border: 1px solid var(--cx-border);
            color: var(--cx-text-primary);
        }

        [data-bs-theme="light"] .modal-content,
        [data-bs-theme="combo"] .modal-content {
            background-color: #FFFFFF !important;
            color: #0F172A !important;
            border: 1px solid #CBD5E1 !important;
        }

        .modal-header, .modal-footer {
            border-color: rgba(255, 255, 255, 0.08);
        }

        [data-bs-theme="light"] .modal-header,
        [data-bs-theme="light"] .modal-footer,
        [data-bs-theme="combo"] .modal-header,
        [data-bs-theme="combo"] .modal-footer {
            border-color: #E2E8F0 !important;
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

        [data-bs-theme="light"] main .text-white,
        [data-bs-theme="combo"] main .text-white {
            color: #0F172A !important;
        }

        [data-bs-theme="light"] main .text-light,
        [data-bs-theme="combo"] main .text-light {
            color: #334155 !important;
        }

        [data-bs-theme="light"] main .text-white-50,
        [data-bs-theme="combo"] main .text-white-50,
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

        .agent-badge-pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--cx-emerald);
            display: inline-block;
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        html, body {
            max-width: 100%;
            overflow-x: clip;
        }

        main {
            max-width: 100%;
            overflow-x: hidden;
            min-width: 0;
        }

        /* Colorful Gradient Text Utilities */
        .text-gradient-rainbow {
            background: linear-gradient(135deg, #38BDF8 0%, #818CF8 30%, #C084FC 65%, #F472B6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: #38BDF8;
        }

        .text-gradient-cyan {
            background: linear-gradient(135deg, #38BDF8 0%, #0284C7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: #38BDF8;
        }

        .text-gradient-emerald {
            background: linear-gradient(135deg, #34D399 0%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: #10B981;
        }

        .text-gradient-amber {
            background: linear-gradient(135deg, #FBBF24 0%, #EA580C 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: #F59E0B;
        }

        .text-gradient-purple {
            background: linear-gradient(135deg, #C084FC 0%, #7C3AED 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: #818CF8;
        }

        /* Continuous Marquee Scroller Ticker */
        .crm-marquee-wrap {
            position: relative;
            background: rgba(17, 24, 39, 0.7);
            border: 1px solid var(--cx-border);
            border-radius: 12px;
            padding: 0.5rem 0.75rem;
            overflow: hidden;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            backdrop-filter: blur(8px);
        }

        [data-bs-theme="light"] .crm-marquee-wrap,
        [data-bs-theme="combo"] .crm-marquee-wrap {
            background: #FFFFFF !important;
            border-color: #E2E8F0 !important;
        }

        .crm-marquee-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.35rem 0.75rem;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--cx-cyan);
            background: rgba(56, 189, 248, 0.12);
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 9999px;
            flex-shrink: 0;
            white-space: nowrap;
            z-index: 2;
        }

        [data-bs-theme="light"] .crm-marquee-badge,
        [data-bs-theme="combo"] .crm-marquee-badge {
            background: rgba(14, 165, 233, 0.1) !important;
            border-color: rgba(14, 165, 233, 0.25) !important;
            color: #0284c7 !important;
        }

        .crm-marquee-viewport {
            flex: 1;
            min-width: 0;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            -webkit-mask-image: linear-gradient(90deg, transparent 0%, black 16px, black calc(100% - 16px), transparent 100%);
            mask-image: linear-gradient(90deg, transparent 0%, black 16px, black calc(100% - 16px), transparent 100%);
        }

        .crm-marquee-track {
            display: flex;
            gap: 2rem;
            align-items: center;
            white-space: nowrap;
            width: max-content;
            animation: crmMarqueeLoop 38s linear infinite;
        }

        .crm-marquee-wrap:hover .crm-marquee-track {
            animation-play-state: paused;
        }

        @keyframes crmMarqueeLoop {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .crm-marquee-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--cx-text-muted);
        }

        .crm-marquee-item strong {
            color: var(--cx-text-primary);
        }

        .crm-marquee-item .sep {
            color: var(--cx-text-muted);
            opacity: 0.4;
            margin-left: 1.5rem;
        }

        /* Futuristic Animated SVG Hero Banner */
        .crm-hero-banner {
            position: relative;
            background: radial-gradient(circle at 85% 20%, rgba(56, 189, 248, 0.12) 0%, rgba(129, 140, 248, 0.08) 45%, rgba(17, 24, 39, 0.95) 100%), #111827;
            border: 1px solid rgba(56, 189, 248, 0.25);
            border-radius: 20px;
            overflow: hidden;
            padding: 2.25rem 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        [data-bs-theme="light"] .crm-hero-banner,
        [data-bs-theme="combo"] .crm-hero-banner {
            background: radial-gradient(circle at 85% 20%, rgba(14, 165, 233, 0.12) 0%, rgba(99, 102, 241, 0.08) 45%, #FFFFFF 100%), #FFFFFF !important;
            border: 1px solid #CBD5E1 !important;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08) !important;
        }

        .crm-banner-svg-canvas {
            position: absolute;
            top: 0;
            right: 0;
            width: 55%;
            height: 100%;
            pointer-events: none;
            opacity: 0.85;
            z-index: 1;
        }

        .crm-banner-content {
            position: relative;
            z-index: 2;
            max-width: 680px;
        }

        .crm-banner-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            background: rgba(56, 189, 248, 0.12);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: var(--cx-cyan);
            margin-bottom: 1rem;
        }

        .crm-banner-title {
            font-size: clamp(1.6rem, 2.5vw, 2.3rem);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.02em;
            margin-bottom: 0.85rem;
        }

        .crm-banner-desc {
            font-size: 0.95rem;
            color: var(--cx-text-muted);
            line-height: 1.55;
            margin-bottom: 1.4rem;
        }

        /* SVG Animations */
        @keyframes crmNodePulse {
            0%, 100% { transform: scale(1); filter: drop-shadow(0 0 4px #38BDF8); }
            50% { transform: scale(1.15); filter: drop-shadow(0 0 14px #C084FC); }
        }

        @keyframes crmOrbitSpin {
            0% { transform: rotate(0deg); transform-origin: 350px 170px; }
            100% { transform: rotate(360deg); transform-origin: 350px 170px; }
        }

        .svg-orbit-ring {
            animation: crmOrbitSpin 32s linear infinite;
        }

        /* Responsive Kanban Board */
        .kanban-board-container {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scroll-snap-type: x mandatory;
            padding-bottom: 1.25rem;
            width: 100%;
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

        /* Responsive Agents Slider Carousel */
        .agents-slider-viewport {
            overflow: hidden;
            width: 100%;
            position: relative;
            padding: 0.5rem 0.25rem 1rem;
            cursor: grab;
        }

        .agents-slider-viewport:active {
            cursor: grabbing;
        }

        .agents-slider-track {
            display: flex;
            gap: 16px;
            transition: transform 0.45s cubic-bezier(0.25, 1, 0.5, 1);
            will-change: transform;
        }

        .agent-slider-card {
            flex: 0 0 calc(33.333% - 11px);
            min-width: 280px;
        }

        @media (max-width: 1100px) {
            .agent-slider-card {
                flex: 0 0 calc(50% - 8px);
            }
        }

        @media (max-width: 640px) {
            .agent-slider-card {
                flex: 0 0 100%;
            }
        }

        .agent-dot {
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            padding: 0;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .agent-dot.active {
            width: 24px;
            background: #38BDF8;
        }

        /* CRM Footer System */
        .crm-footer {
            background: rgba(11, 15, 25, 0.85);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            padding: 1.5rem 1.5rem;
            margin-top: auto;
            position: relative;
            z-index: 5;
            width: 100%;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(12px);
            transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        [data-bs-theme="light"] .crm-footer,
        [data-bs-theme="combo"] .crm-footer {
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05) !important;
        }

        [data-bs-theme="dark"] .crm-footer {
            background: rgba(11, 15, 25, 0.85) !important;
            border: 1px solid rgba(56, 189, 248, 0.18) !important;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.55) !important;
            backdrop-filter: blur(12px);
        }

        .crm-footer-brand-pill {
            display: inline-flex;
            align-items: center;
            background: #0B0F19 !important;
            padding: 5px 12px;
            border-radius: 10px;
            border: 1px solid rgba(56, 189, 248, 0.3) !important;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .crm-footer-brand-pill:hover {
            transform: translateY(-1px);
            border-color: #38BDF8 !important;
            box-shadow: 0 4px 12px rgba(56, 189, 248, 0.2);
        }

        [data-bs-theme="light"] .crm-footer-brand-pill,
        [data-bs-theme="combo"] .crm-footer-brand-pill {
            background: #0B0F19 !important;
            border-color: rgba(2, 132, 199, 0.35) !important;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.1);
        }

        .crm-footer-badge {
            background: #0B0F19 !important;
            color: #38BDF8 !important;
            border: 1px solid rgba(56, 189, 248, 0.35) !important;
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            padding: 0.35rem 0.55rem;
            border-radius: 6px;
            font-weight: 700;
        }

        [data-bs-theme="light"] .crm-footer-badge,
        [data-bs-theme="combo"] .crm-footer-badge {
            background: #0F172A !important;
            color: #38BDF8 !important;
            border-color: rgba(56, 189, 248, 0.4) !important;
        }

        .crm-footer-telemetry {
            border-radius: 12px;
            padding: 1rem;
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

        .crm-footer-stat-box {
            padding: 0.5rem 0.25rem;
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
            font-weight: 500;
        }

        [data-bs-theme="light"] .crm-footer-stat-label,
        [data-bs-theme="combo"] .crm-footer-stat-label {
            color: #64748B !important;
        }

        .crm-footer-link {
            color: var(--cx-text-muted);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-size: 0.8rem;
            padding: 0.35rem 0.6rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .crm-footer-link:hover {
            color: #38BDF8 !important;
            background: rgba(56, 189, 248, 0.1) !important;
            transform: translateX(2px);
        }

        [data-bs-theme="light"] .crm-footer-link,
        [data-bs-theme="combo"] .crm-footer-link {
            color: #334155 !important;
        }

        [data-bs-theme="light"] .crm-footer-link:hover,
        [data-bs-theme="combo"] .crm-footer-link:hover {
            color: #0284C7 !important;
            background: rgba(2, 132, 199, 0.08) !important;
        }

        [data-bs-theme="dark"] .crm-footer-link {
            color: #94A3B8 !important;
        }

        [data-bs-theme="dark"] .crm-footer-link:hover {
            color: #38BDF8 !important;
            background: rgba(56, 189, 248, 0.1) !important;
        }

        [data-bs-theme="light"] .crm-footer .text-muted,
        [data-bs-theme="combo"] .crm-footer .text-muted {
            color: #64748B !important;
        }

        [data-bs-theme="dark"] .crm-footer .text-muted {
            color: #94A3B8 !important;
        }

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

<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- ======================================================== -->
        <!-- DESKTOP EXECUTIVE SIDEBAR NAVIGATION                    -->
        <!-- ======================================================== -->
        <aside class="col-12 col-lg-2 d-none d-lg-block crm-sidebar p-0">
            <div class="crm-sidebar-inner p-3 position-sticky top-0" style="max-height: 100vh; overflow-y: auto;">
                <!-- Brand with Original Logo -->
                <div class="mb-2 px-1 pt-1 text-center">
                    <a href="dashboard" class="d-block text-decoration-none">
                        <img src="assets/images/logo/logo.png" alt="CodeX404 Solutions" class="img-fluid" style="max-height: 32px; object-fit: contain;">
                    </a>
                    <div class="mt-1 d-flex align-items-center justify-content-center gap-1">
                        <span class="badge border text-uppercase" style="font-size: 0.6rem; letter-spacing: 0.08em; background: #0F172A; color: #38BDF8; border-color: rgba(56, 189, 248, 0.3) !important;">CRM &amp; AGENT OS</span>
                    </div>
                </div>

                <!-- User Status Card -->
                <div class="p-2 mb-2 rounded-3" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <div class="d-flex align-items-center gap-2">
                            <span class="agent-badge-pulse" title="Active Session" style="width: 6px; height: 6px;"></span>
                            <span class="fw-bold small text-white" style="font-size: 0.78rem;"><?= htmlspecialchars($currentUser['name']) ?></span>
                        </div>
                        <a href="logout" class="text-danger small text-decoration-none" title="Sign Out" style="font-size: 0.75rem;"><i class="bi bi-box-arrow-left"></i></a>
                    </div>
                    <div class="d-flex gap-1 flex-wrap">
                        <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase" style="font-size: 0.58rem;">Admin</span>
                        <?php foreach (array_slice($currentUser['roles'], 0, 2) as $r): ?>
                            <span class="badge bg-secondary-subtle text-muted text-uppercase" style="font-size: 0.58rem;"><?= htmlspecialchars($r) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Navigation Section Title -->
                <div class="crm-sidebar-section-title">Navigation</div>

                <!-- Multi-Page Navigation Links -->
                <nav class="nav flex-column mb-2" id="crmSidebarNav">
                    <a href="dashboard" class="crm-nav-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>">
                        <span><i class="bi bi-grid-1x2-fill me-2 text-info"></i> Dashboard</span>
                        <span class="badge rounded-pill bg-dark border border-secondary text-muted" style="font-size: 0.62rem;">Top</span>
                    </a>
                    <a href="leads" class="crm-nav-link <?= $currentPage === 'leads' ? 'active' : '' ?>">
                        <span><i class="bi bi-person-lines-fill me-2 text-warning"></i> Inbound Leads</span>
                        <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle" style="font-size: 0.62rem;"><?= $totalLeads ?></span>
                    </a>
                    <a href="pipeline" class="crm-nav-link <?= $currentPage === 'pipeline' ? 'active' : '' ?>">
                        <span><i class="bi bi-kanban-fill me-2 text-success"></i> Sales Pipeline</span>
                        <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle" style="font-size: 0.62rem;"><?= count($opportunities) ?></span>
                    </a>
                    <a href="projects" class="crm-nav-link <?= $currentPage === 'projects' ? 'active' : '' ?>">
                        <span><i class="bi bi-rocket-takeoff-fill me-2 text-primary"></i> Client Delivery</span>
                        <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle" style="font-size: 0.62rem;"><?= count($projects) ?></span>
                    </a>
                    <a href="paperclip" class="crm-nav-link <?= $currentPage === 'paperclip' ? 'active' : '' ?>">
                        <span><i class="bi bi-robot me-2 text-info"></i> Paperclip Agents</span>
                        <span class="badge rounded-pill bg-info-subtle text-info border border-info-subtle" style="font-size: 0.62rem;"><?= count($agents) ?></span>
                    </a>
                    <a href="approvals" class="crm-nav-link <?= $currentPage === 'approvals' ? 'active' : '' ?>">
                        <span><i class="bi bi-shield-check me-2 text-warning"></i> HITL Approvals</span>
                        <?php if (count($pendingApprovals) > 0): ?>
                            <span class="badge rounded-pill bg-danger text-white" style="font-size: 0.62rem;"><?= count($pendingApprovals) ?></span>
                        <?php else: ?>
                            <span class="badge rounded-pill bg-secondary text-white" style="font-size: 0.62rem;">0</span>
                        <?php endif; ?>
                    </a>
                    <a href="settings" class="crm-nav-link <?= $currentPage === 'settings' ? 'active' : '' ?>">
                        <span><i class="bi bi-sliders me-2 text-secondary"></i> System &amp; API</span>
                        <span class="badge rounded-pill bg-dark border border-secondary text-muted" style="font-size: 0.62rem;">API</span>
                    </a>
                </nav>

                <!-- Platform Bridges Title -->
                <div class="crm-sidebar-section-title">Platform Bridges</div>

                <div class="d-flex gap-1 mb-2">
                    <a href="../website/admin/" target="_blank" class="crm-sidebar-link flex-fill text-center justify-content-center py-1" style="font-size: 0.72rem;">
                        <i class="bi bi-shield-lock me-1 text-info"></i> Admin
                    </a>
                    <a href="../website/discovery-call" target="_blank" class="crm-sidebar-link flex-fill text-center justify-content-center py-1" style="font-size: 0.72rem;">
                        <i class="bi bi-lightning-charge me-1 text-warning"></i> Intake
                    </a>
                </div>
            </div>
        </aside>

        <!-- ======================================================== -->
        <!-- MAIN CONTENT AREA                                        -->
        <!-- ======================================================== -->
        <main class="col-12 col-lg-10 p-3 p-md-4 d-flex flex-column" style="min-height: 100vh; overflow-x: hidden;">

            <!-- Top Header & Status Bar -->
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-4 border-bottom" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                <div class="d-flex align-items-center gap-3">
                    <!-- Mobile Hamburger -->
                    <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div>
                        <h1 class="h4 mb-0 fw-bold"><?= htmlspecialchars($pageTitle) ?></h1>
                        <p class="text-muted small mb-0"><?= htmlspecialchars($pageSubtitle) ?></p>
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

            <!-- Real-Time FX & Intelligence Marquee Scroller Ticker -->
            <div class="crm-marquee-wrap">
                <div class="crm-marquee-badge">
                    <span class="agent-badge-pulse" style="width: 6px; height: 6px;"></span>
                    <span>Live Intelligence</span>
                </div>
                <div class="crm-marquee-viewport">
                    <div class="crm-marquee-track">
                        <!-- Set 1 -->
                        <div class="crm-marquee-item">
                            <i class="bi bi-currency-exchange text-warning"></i>
                            <span>1 USD = <strong>₹<?= number_format((float)($liveExchangeRates['INR'] ?? 95.05), 2) ?> INR</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-currency-euro text-info"></i>
                            <span>1 USD = <strong>€<?= number_format((float)($liveExchangeRates['EUR'] ?? 0.89), 2) ?> EUR</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-currency-pound text-primary"></i>
                            <span>1 USD = <strong>£<?= number_format((float)($liveExchangeRates['GBP'] ?? 0.75), 2) ?> GBP</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-cash-stack text-success"></i>
                            <span>1 USD = <strong>د.إ<?= number_format((float)($liveExchangeRates['AED'] ?? 3.67), 2) ?> AED</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-robot text-info"></i>
                            <span>Paperclip Swarm: <strong>7/7 Autonomous Agents Armed</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-graph-up-arrow text-success"></i>
                            <span>Pipeline Value: <strong class="currency-val" data-usd="<?= (float)$pipelineValue ?>">$<?= number_format($pipelineValue, 0) ?></strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-shield-check text-warning"></i>
                            <span>HITL Queue: <strong><?= count($pendingApprovals) ?> Pending Decisions</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-lightning-charge-fill text-warning"></i>
                            <span>Lead Velocity: <strong><?= $totalLeads ?> Total &bull; <?= $activeLeads ?> Active Inbound</strong></span>
                            <span class="sep">&bull;</span>
                        </div>

                        <!-- Set 2 (Duplicate for Infinite Smooth Loop) -->
                        <div class="crm-marquee-item">
                            <i class="bi bi-currency-exchange text-warning"></i>
                            <span>1 USD = <strong>₹<?= number_format((float)($liveExchangeRates['INR'] ?? 95.05), 2) ?> INR</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-currency-euro text-info"></i>
                            <span>1 USD = <strong>€<?= number_format((float)($liveExchangeRates['EUR'] ?? 0.89), 2) ?> EUR</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-currency-pound text-primary"></i>
                            <span>1 USD = <strong>£<?= number_format((float)($liveExchangeRates['GBP'] ?? 0.75), 2) ?> GBP</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-cash-stack text-success"></i>
                            <span>1 USD = <strong>د.إ<?= number_format((float)($liveExchangeRates['AED'] ?? 3.67), 2) ?> AED</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-robot text-info"></i>
                            <span>Paperclip Swarm: <strong>7/7 Autonomous Agents Armed</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-graph-up-arrow text-success"></i>
                            <span>Pipeline Value: <strong class="currency-val" data-usd="<?= (float)$pipelineValue ?>">$<?= number_format($pipelineValue, 0) ?></strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-shield-check text-warning"></i>
                            <span>HITL Queue: <strong><?= count($pendingApprovals) ?> Pending Decisions</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
                        <div class="crm-marquee-item">
                            <i class="bi bi-lightning-charge-fill text-warning"></i>
                            <span>Lead Velocity: <strong><?= $totalLeads ?> Total &bull; <?= $activeLeads ?> Active Inbound</strong></span>
                            <span class="sep">&bull;</span>
                        </div>
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
