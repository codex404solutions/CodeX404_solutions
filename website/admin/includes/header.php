<?php
declare(strict_types=1);

/**
 * CodeX404 Solutions — Admin Multi-Page Header & Navigation Include
 */

require_once dirname(__DIR__) . '/auth.php';
require_admin_auth();

use App\Services\ProjectService;

// Ensure portfolio data is loaded and calculated
if (!isset($projects)) {
    $projects = ProjectService::getAll();
}
$totalCount = count($projects);
$activeCount = count(array_filter($projects, fn($p) => !empty($p['active'])));
$draftCount = $totalCount - $activeCount;
if (!isset($categories)) {
    $categories = array_values(array_unique(array_filter(array_column($projects, 'category'))));
}

// Active page & title defaults
$currentPage = $currentPage ?? 'overview';
$pageTitle = $pageTitle ?? 'Portfolio & Deliverables Command Center';
$pageSubtitle = $pageSubtitle ?? 'Production deliverables, interactive sandboxes, and verified showcase specs';

$flash = get_admin_flash();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="combo">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> — CodeX404 Admin</title>
    <meta name="robots" content="noindex, nofollow">

    <script>
        (() => {
            const storedTheme = localStorage.getItem('codex_admin_theme');
            let theme = storedTheme ? storedTheme : 'combo';
            const effective = (theme === 'auto')
                ? (window.matchMedia('(prefers-color-scheme: light)').matches ? 'combo' : 'dark')
                : theme;
            document.documentElement.setAttribute('data-bs-theme', effective);
        })();
    </script>

    <!-- Bootstrap 5.3.3 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts: Plus Jakarta Sans & Fira Code -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/logo/favicon.ico') ?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?= asset('images/logo/favicon.ico') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= asset('images/logo/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= asset('images/logo/favicon-16x16.png') ?>">

    <style>
        /* ========================================================= */
        /* DESIGN TOKENS & DUAL-THEME COLOR SYSTEM                   */
        /* ========================================================= */
        :root {
            --cx-cyan: #22D3EE;
            --cx-cyan-hover: #06B6D4;
            --cx-blue: #3B82F6;
            --cx-indigo: #6366F1;
            --cx-purple: #A855F7;
            --cx-pink: #EC4899;
            --cx-emerald: #10B981;
            --cx-amber: #F59E0B;
            --cx-rose: #F43F5E;
            --font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --font-mono: 'Fira Code', monospace;
        }

        /* 1. DARK MODE (Obsidian Cyber) */
        [data-bs-theme="dark"] {
            --cx-bg-canvas: #040711;
            --cx-bg-surface: #0B0F19;
            --cx-bg-card: rgba(17, 24, 39, 0.75);
            --cx-bg-hover: rgba(31, 41, 55, 0.65);
            --cx-border: rgba(255, 255, 255, 0.08);
            --cx-border-focus: rgba(34, 211, 238, 0.45);
            --cx-text-primary: #F8FAFC;
            --cx-text-secondary: #94A3B8;
            --cx-text-muted: #64748B;
            --cx-nav-bg: #070B14;
            --cx-card-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.55);
            --cx-pill-bg: rgba(255, 255, 255, 0.05);
            --cx-hero-bg: radial-gradient(circle at 80% 20%, rgba(34, 211, 238, 0.12) 0%, rgba(99, 102, 241, 0.08) 40%, rgba(11, 15, 25, 0.95) 100%), #0B0F19;
            --cx-banner-border: rgba(34, 211, 238, 0.2);
            --cx-ticker-bg: rgba(11, 15, 25, 0.8);
        }

        /* 2. PURE LIGHT MODE */
        [data-bs-theme="light"] {
            --cx-bg-canvas: #F8FAFC;
            --cx-bg-surface: #FFFFFF;
            --cx-bg-card: #FFFFFF;
            --cx-bg-hover: #F1F5F9;
            --cx-border: #E2E8F0;
            --cx-border-focus: #0284C7;
            --cx-text-primary: #0F172A;
            --cx-text-secondary: #334155;
            --cx-text-muted: #64748B;
            --cx-nav-bg: #FFFFFF;
            --cx-card-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
            --cx-pill-bg: #F1F5F9;
            --cx-hero-bg: radial-gradient(circle at 80% 20%, rgba(14, 165, 233, 0.08) 0%, rgba(99, 102, 241, 0.05) 50%, #FFFFFF 100%), #F8FAFC;
            --cx-banner-border: rgba(14, 165, 233, 0.25);
            --cx-ticker-bg: rgba(241, 245, 249, 0.9);
        }

        /* 3. DARK & LIGHT COMBO (Pro SaaS Aesthetic) */
        [data-bs-theme="combo"] {
            --cx-bg-canvas: #F1F5F9;
            --cx-bg-surface: #FFFFFF;
            --cx-bg-card: #FFFFFF;
            --cx-bg-hover: #F8FAFC;
            --cx-border: #E2E8F0;
            --cx-border-focus: #0284C7;
            --cx-text-primary: #0F172A;
            --cx-text-secondary: #334155;
            --cx-text-muted: #64748B;
            --cx-nav-bg: #070B14;
            --cx-card-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
            --cx-pill-bg: #F1F5F9;
            --cx-hero-bg: radial-gradient(circle at 85% 15%, rgba(14, 165, 233, 0.09) 0%, rgba(168, 85, 247, 0.06) 45%, #FFFFFF 100%), #FFFFFF;
            --cx-banner-border: rgba(14, 165, 233, 0.25);
            --cx-ticker-bg: #FFFFFF;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            max-width: 100%;
            overflow-x: clip;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--cx-bg-canvas);
            color: var(--cx-text-primary);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            transition: background-color 0.2s ease, color 0.2s ease;
            -webkit-font-smoothing: antialiased;
        }

        /* Gradient Typography */
        .text-gradient-rainbow {
            background: linear-gradient(135deg, #22D3EE 0%, #3B82F6 30%, #8B5CF6 65%, #EC4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: #38BDF8;
        }

        .text-gradient-cyan {
            background: linear-gradient(135deg, #22D3EE 0%, #0284C7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: #22D3EE;
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
            color: #A855F7;
        }

        /* Live Pulse Dot */
        .live-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--cx-emerald);
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        /* Hero Banner */
        .admin-hero-banner {
            position: relative;
            background: var(--cx-hero-bg);
            border: 1px solid var(--cx-banner-border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--cx-card-shadow);
            padding: 2.25rem 2rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(12px);
        }

        .admin-hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #22D3EE 0%, #3B82F6 35%, #8B5CF6 70%, #EC4899 100%);
            z-index: 2;
        }

        .banner-svg-canvas {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 55%;
            height: 100%;
            pointer-events: none;
            opacity: 0.85;
            z-index: 1;
            transition: opacity 0.3s ease;
        }

        @media (max-width: 991.98px) {
            .banner-svg-canvas {
                width: 100%;
                opacity: 0.22;
            }
            .admin-hero-banner {
                padding: 1.75rem 1.25rem;
            }
        }

        .banner-content {
            position: relative;
            z-index: 2;
            max-width: 720px;
        }

        .banner-tech-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.3rem 0.85rem;
            border-radius: 50px;
            background: rgba(34, 211, 238, 0.1);
            border: 1px solid rgba(34, 211, 238, 0.25);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #0284C7;
            margin-bottom: 0.85rem;
        }

        [data-bs-theme="dark"] .banner-tech-pill {
            color: var(--cx-cyan);
        }

        .banner-title {
            font-size: clamp(1.4rem, 3.2vw, 2.15rem);
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 0.65rem;
        }

        .banner-description {
            font-size: 0.92rem;
            line-height: 1.55;
            color: var(--cx-text-secondary);
            margin-bottom: 1.25rem;
        }

        .banner-meta-bar {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .banner-meta-item {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.3rem 0.75rem;
            border-radius: 8px;
            background: var(--cx-pill-bg);
            border: 1px solid var(--cx-border);
            color: var(--cx-text-secondary);
        }

        /* SVG Keyframes */
        @keyframes flowDash {
            to { stroke-dashoffset: -120; }
        }
        @keyframes pulseNode {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.35); opacity: 1; }
        }
        @keyframes orbitSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .svg-flow-path { stroke-dasharray: 8 6; animation: flowDash 15s linear infinite; }
        .svg-pulsing-node { transform-origin: center; animation: pulseNode 3s ease-in-out infinite; }
        .svg-rotating-ring { transform-origin: 350px 180px; animation: orbitSlow 25s linear infinite; }
        .svg-floating-group { animation: floatSlow 6s ease-in-out infinite; }

        /* Continuous Marquee Ticker */
        .admin-marquee-wrap {
            position: relative;
            background: var(--cx-ticker-bg);
            border: 1px solid var(--cx-border);
            border-radius: 14px;
            padding: 0.5rem 0.75rem;
            overflow: hidden;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .admin-marquee-label {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.35rem 0.75rem;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--cx-cyan);
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.22);
            border-radius: 9999px;
            flex-shrink: 0;
            white-space: nowrap;
            z-index: 2;
        }

        .admin-marquee-viewport {
            flex: 1;
            min-width: 0;
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            -webkit-mask-image: linear-gradient(90deg, transparent 0%, black 16px, black calc(100% - 16px), transparent 100%);
            mask-image: linear-gradient(90deg, transparent 0%, black 16px, black calc(100% - 16px), transparent 100%);
        }

        .admin-marquee-track {
            display: flex;
            gap: 2rem;
            align-items: center;
            white-space: nowrap;
            width: max-content;
            animation: marqueeScroll 36s linear infinite;
        }

        .admin-marquee-wrap:hover .admin-marquee-track {
            animation-play-state: paused;
        }

        @keyframes marqueeScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .admin-marquee-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--cx-text-secondary);
        }

        .admin-marquee-item strong {
            color: var(--cx-text-primary);
        }

        .admin-marquee-item .sep {
            color: var(--cx-text-muted);
            opacity: 0.5;
            margin-left: 1.5rem;
        }

        /* Showcase Slider */
        .deliverables-slider-section {
            background: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 18px;
            padding: 1.5rem;
            margin-bottom: 1.75rem;
            box-shadow: var(--cx-card-shadow);
            position: relative;
        }

        .slider-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.15rem;
            flex-wrap: wrap;
        }

        .slider-viewport {
            overflow: hidden;
            width: 100%;
            border-radius: 12px;
            cursor: grab;
            user-select: none;
        }

        .slider-viewport:active {
            cursor: grabbing;
        }

        .slider-track {
            display: flex;
            transition: transform 0.45s cubic-bezier(0.16, 1, 0.3, 1);
            gap: 1rem;
        }

        .slider-card-item {
            flex: 0 0 100%;
            min-width: 0;
            background: var(--cx-bg-surface);
            border: 1px solid var(--cx-border);
            border-radius: 14px;
            padding: 1.25rem;
            position: relative;
            transition: transform 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        @media (min-width: 640px) {
            .slider-card-item {
                flex: 0 0 calc(50% - 0.5rem);
            }
        }

        @media (min-width: 1024px) {
            .slider-card-item {
                flex: 0 0 calc(33.333% - 0.67rem);
            }
        }

        .slider-card-item:hover {
            transform: translateY(-3px);
            border-color: var(--cx-cyan);
            box-shadow: 0 12px 28px -6px rgba(34, 211, 238, 0.15);
        }

        .slider-nav-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: 1px solid var(--cx-border);
            background: var(--cx-bg-surface);
            color: var(--cx-text-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .slider-nav-btn:hover {
            background: var(--cx-cyan);
            border-color: var(--cx-cyan);
            color: #030712;
            transform: scale(1.05);
        }

        .slider-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-top: 1rem;
        }

        .slider-dot {
            width: 8px;
            height: 8px;
            border-radius: 10px;
            background: var(--cx-border);
            border: none;
            padding: 0;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .slider-dot.active {
            width: 24px;
            background: var(--cx-cyan);
        }

        /* Cards & Metric Widgets */
        .admin-card {
            background-color: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            box-shadow: var(--cx-card-shadow);
            transition: all 0.2s ease;
        }

        .stat-card {
            background-color: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            padding: 1.35rem 1.5rem;
            box-shadow: var(--cx-card-shadow);
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, border-color 0.2s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            border-color: var(--cx-cyan);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--card-accent, var(--cx-cyan));
        }

        .stat-card.accent-emerald::before { background: var(--cx-emerald); }
        .stat-card.accent-amber::before { background: var(--cx-amber); }
        .stat-card.accent-indigo::before { background: var(--cx-indigo); }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }

        /* Quick Action Cards */
        .action-hub-card {
            background-color: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            color: inherit;
            display: block;
            height: 100%;
            box-shadow: var(--cx-card-shadow);
        }

        .action-hub-card:hover {
            transform: translateY(-4px);
            border-color: var(--cx-cyan);
            color: inherit;
            box-shadow: 0 16px 36px -8px rgba(34, 211, 238, 0.2);
        }

        /* Tables */
        .table-responsive {
            -webkit-overflow-scrolling: touch;
            border-radius: 14px;
        }

        .table-admin {
            --bs-table-bg: transparent;
            --bs-table-border-color: var(--cx-border);
            color: var(--cx-text-primary);
            margin-bottom: 0;
            width: 100%;
        }

        .table-admin th {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--cx-text-muted);
            padding: 1rem 1.15rem;
            background: rgba(0, 0, 0, 0.02);
            border-bottom: 1px solid var(--cx-border);
            white-space: nowrap;
        }

        [data-bs-theme="dark"] .table-admin th {
            background: rgba(255, 255, 255, 0.02);
        }

        .table-admin td {
            padding: 1.15rem 1.15rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--cx-border);
        }

        .table-admin tr:hover td {
            background-color: var(--cx-bg-hover);
        }

        .project-id-chip {
            font-family: var(--font-mono);
            font-size: 0.74rem;
            color: var(--cx-text-muted);
            word-break: break-all;
        }

        .demo-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-family: var(--font-mono);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.65rem;
            border-radius: 6px;
            background: rgba(168, 85, 247, 0.12);
            color: #A855F7;
            border: 1px solid rgba(168, 85, 247, 0.25);
            white-space: nowrap;
        }

        .category-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.6rem;
            border-radius: 6px;
            background: rgba(56, 189, 248, 0.1);
            color: #0284C7;
            border: 1px solid rgba(56, 189, 248, 0.2);
            white-space: nowrap;
        }

        [data-bs-theme="dark"] .category-chip {
            color: #38BDF8;
        }

        .filter-pill-btn {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            border: 1px solid var(--cx-border);
            background: var(--cx-bg-card);
            color: var(--cx-text-secondary);
            transition: all 0.15s ease;
            cursor: pointer;
            white-space: nowrap;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .filter-pill-btn:hover,
        .filter-pill-btn.active {
            background: var(--cx-cyan);
            border-color: var(--cx-cyan);
            color: #030712;
            font-weight: 700;
        }

        .btn-action-icon {
            width: 34px;
            height: 34px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }

        /* Modals */
        .modal-content {
            background-color: var(--cx-bg-surface);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            color: var(--cx-text-primary);
        }

        .modal-header,
        .modal-footer {
            border-color: var(--cx-border);
        }

        /* Sidebar System */
        .admin-sidebar,
        [data-bs-theme="light"] .admin-sidebar,
        [data-bs-theme="combo"] .admin-sidebar,
        #adminMobileSidebar,
        [data-bs-theme="light"] #adminMobileSidebar,
        [data-bs-theme="combo"] #adminMobileSidebar {
            background: #070B14 !important;
            border-right: 1px solid rgba(56, 189, 248, 0.16) !important;
            color: #F8FAFC !important;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .admin-sidebar-inner {
            display: flex;
            flex-direction: column;
            width: 100%;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.12) transparent;
        }

        .admin-sidebar-inner::-webkit-scrollbar {
            width: 4px;
        }

        .admin-sidebar-inner::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 4px;
        }

        .admin-sidebar-section-title {
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: #94A3B8;
            margin-top: 0.35rem;
            margin-bottom: 0.2rem;
            padding: 0 0.35rem;
        }

        .admin-sidebar-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.36rem 0.6rem;
            border-radius: 7px;
            color: #94A3B8;
            font-size: 0.78rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-bottom: 0.12rem;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            white-space: nowrap;
        }

        .admin-sidebar-link:hover,
        .admin-sidebar .admin-sidebar-link:hover,
        [data-bs-theme="light"] .admin-sidebar .admin-sidebar-link:hover,
        [data-bs-theme="combo"] .admin-sidebar .admin-sidebar-link:hover,
        #adminMobileSidebar .admin-sidebar-link:hover {
            color: #38BDF8 !important;
            background: rgba(56, 189, 248, 0.08) !important;
            transform: none;
        }

        .admin-sidebar-link.active,
        .admin-sidebar .admin-sidebar-link.active,
        [data-bs-theme="light"] .admin-sidebar .admin-sidebar-link.active,
        [data-bs-theme="combo"] .admin-sidebar .admin-sidebar-link.active,
        #adminMobileSidebar .admin-sidebar-link.active {
            color: #FFFFFF !important;
            background: rgba(56, 189, 248, 0.14) !important;
            border-left: 3px solid #38BDF8 !important;
            font-weight: 600;
        }

        .admin-sidebar-bridge-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.42rem 0.65rem;
            border-radius: 8px;
            color: #94A3B8;
            font-size: 0.78rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .admin-sidebar-bridge-link:hover {
            color: #38BDF8 !important;
            background: rgba(56, 189, 248, 0.08) !important;
            border-color: rgba(56, 189, 248, 0.25) !important;
            transform: translateX(2px);
        }

        .admin-sidebar .badge.bg-dark,
        [data-bs-theme="light"] .admin-sidebar .badge.bg-dark,
        [data-bs-theme="combo"] .admin-sidebar .badge.bg-dark,
        #adminMobileSidebar .badge.bg-dark {
            background-color: #111827 !important;
            color: #94A3B8 !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        .admin-sidebar .rounded-3,
        [data-bs-theme="light"] .admin-sidebar .rounded-3,
        [data-bs-theme="combo"] .admin-sidebar .rounded-3,
        #adminMobileSidebar .rounded-3 {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        /* Light & Combo Mode Workspace */
        [data-bs-theme="light"] main,
        [data-bs-theme="combo"] main {
            background-color: #F8FAFC !important;
            color: #0F172A !important;
        }

        [data-bs-theme="light"] main .border-bottom,
        [data-bs-theme="combo"] main .border-bottom {
            border-color: #E2E8F0 !important;
        }

        /* Footer System */
        .admin-footer {
            background: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            padding: 1.75rem 1.5rem;
            margin-top: auto;
            box-shadow: var(--cx-card-shadow);
            transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        [data-bs-theme="light"] .admin-footer,
        [data-bs-theme="combo"] .admin-footer {
            background: #FFFFFF !important;
            border-color: #E2E8F0 !important;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05) !important;
        }

        [data-bs-theme="dark"] .admin-footer {
            background: rgba(11, 15, 25, 0.85) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.55) !important;
            backdrop-filter: blur(12px);
        }

        .admin-footer-brand-pill {
            display: inline-flex;
            align-items: center;
            background: #070B14;
            padding: 4px 10px;
            border-radius: 10px;
            border: 1px solid rgba(34, 211, 238, 0.25);
            text-decoration: none;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .admin-footer-brand-pill:hover {
            transform: translateY(-1px);
            border-color: var(--cx-cyan);
        }

        .admin-footer-badge {
            background: #0B0F19;
            color: #22D3EE;
            border: 1px solid rgba(34, 211, 238, 0.3);
            font-size: 0.65rem;
            letter-spacing: 0.08em;
            padding: 0.35rem 0.55rem;
            border-radius: 6px;
        }

        [data-bs-theme="light"] .admin-footer-badge,
        [data-bs-theme="combo"] .admin-footer-badge {
            background: #0F172A !important;
            color: #38BDF8 !important;
            border-color: #38BDF8 !important;
        }

        .admin-footer-telemetry {
            border-radius: 12px;
            padding: 1rem;
            transition: all 0.2s ease;
        }

        [data-bs-theme="light"] .admin-footer-telemetry,
        [data-bs-theme="combo"] .admin-footer-telemetry {
            background: #F8FAFC !important;
            border: 1px solid #E2E8F0 !important;
        }

        [data-bs-theme="dark"] .admin-footer-telemetry {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .admin-footer-stat-box {
            padding: 0.5rem 0.25rem;
            border-radius: 8px;
            text-align: center;
            transition: transform 0.15s ease, background-color 0.2s ease, border-color 0.2s ease;
        }

        [data-bs-theme="light"] .admin-footer-stat-box,
        [data-bs-theme="combo"] .admin-footer-stat-box {
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        }

        [data-bs-theme="dark"] .admin-footer-stat-box {
            background: rgba(0, 0, 0, 0.45) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .admin-footer-stat-box:hover {
            transform: translateY(-2px);
        }

        .admin-footer-stat-label {
            font-size: 0.65rem;
            color: var(--cx-text-muted);
            margin-top: 2px;
        }

        .admin-footer-link {
            color: var(--cx-text-secondary);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            padding: 0.35rem 0.6rem;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .admin-footer-link:hover {
            color: var(--cx-cyan) !important;
            background: rgba(34, 211, 238, 0.08);
            transform: translateX(2px);
        }

        [data-bs-theme="light"] .admin-footer-link,
        [data-bs-theme="combo"] .admin-footer-link {
            color: #334155 !important;
        }

        [data-bs-theme="light"] .admin-footer-link:hover,
        [data-bs-theme="combo"] .admin-footer-link:hover {
            color: #0284C7 !important;
            background: rgba(2, 132, 199, 0.08);
        }

        .admin-footer-divider {
            border-top: 1px solid var(--cx-border) !important;
        }

        [data-bs-theme="light"] .admin-footer-divider,
        [data-bs-theme="combo"] .admin-footer-divider {
            border-top-color: #E2E8F0 !important;
        }

        [data-bs-theme="dark"] .admin-footer-divider {
            border-top-color: rgba(255, 255, 255, 0.08) !important;
        }
    </style>
</head>

<body>

    <!-- ======================================================== -->
    <!-- 2-COLUMN LAYOUT: SIDEBAR + MAIN CONTENT AREA             -->
    <!-- ======================================================== -->
    <div class="container-fluid p-0">
        <div class="row g-0">

            <!-- ======================================================== -->
            <!-- SIDEBAR NAVIGATION (Desktop)                            -->
            <!-- ======================================================== -->
            <aside class="col-12 col-lg-2 d-none d-lg-block admin-sidebar p-0">
                <div class="admin-sidebar-inner p-2 position-sticky top-0" style="max-height: 100vh; overflow-y: auto;">
                    <!-- Brand with Original Logo -->
                    <div class="mb-1 px-1 pt-1 text-center">
                        <a href="<?= admin_url() ?>" class="d-block text-decoration-none">
                            <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" class="img-fluid"
                                style="max-height: 28px; object-fit: contain;">
                        </a>
                        <div class="mt-1 d-flex align-items-center justify-content-center gap-1">
                            <span class="badge border text-uppercase"
                                style="font-size: 0.58rem; letter-spacing: 0.08em; background: #0F172A; color: #38BDF8; border-color: rgba(56, 189, 248, 0.3) !important;">PORTFOLIO
                                ADMIN</span>
                        </div>
                    </div>

                    <!-- User Status Card -->
                    <div class="p-1.5 px-2 mb-1.5 rounded-3"
                        style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08);">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <div class="d-flex align-items-center gap-1.5">
                                <span class="live-dot" title="Active Session" style="width: 5px; height: 5px;"></span>
                                <span class="fw-bold small text-white"
                                    style="font-size: 0.75rem;"><?= htmlspecialchars((string) ($_SESSION['codex_admin_user'] ?? 'admin')) ?></span>
                            </div>
                            <a href="<?= admin_url('logout') ?>" class="text-danger small text-decoration-none"
                                title="Sign Out" style="font-size: 0.72rem;"><i class="bi bi-box-arrow-left"></i></a>
                        </div>
                        <div class="d-flex gap-1 flex-wrap">
                            <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase"
                                style="font-size: 0.55rem; padding: 0.2em 0.4em;">Superadmin</span>
                            <span class="badge bg-success-subtle text-success border border-success-subtle"
                                style="font-size: 0.55rem; padding: 0.2em 0.4em;">Live Sync</span>
                        </div>
                    </div>

                    <!-- Navigation Section Title -->
                    <div class="admin-sidebar-section-title">Pages</div>

                    <!-- Dedicated Multi-Page Navigation Links -->
                    <nav class="nav flex-column mb-2" id="adminSidebarNav">
                        <a href="<?= admin_url() ?>" class="admin-sidebar-link <?= ($currentPage === 'overview') ? 'active' : '' ?>">
                            <span><i class="bi bi-grid-1x2-fill me-2 text-info"></i> Overview</span>
                            <span class="badge rounded-pill bg-dark border border-secondary text-muted"
                                style="font-size: 0.62rem;">Top</span>
                        </a>
                        <a href="<?= admin_url('deliverables') ?>" class="admin-sidebar-link <?= ($currentPage === 'deliverables') ? 'active' : '' ?>">
                            <span><i class="bi bi-collection-play-fill me-2 text-warning"></i> Deliverables</span>
                            <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle"
                                style="font-size: 0.62rem;"><?= $totalCount ?></span>
                        </a>
                        <a href="<?= admin_url('showcase') ?>" class="admin-sidebar-link <?= ($currentPage === 'showcase') ? 'active' : '' ?>">
                            <span><i class="bi bi-stars me-2 text-primary"></i> Showcase</span>
                            <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle"
                                style="font-size: 0.62rem;"><?= min(6, $totalCount) ?></span>
                        </a>
                        <a href="<?= admin_url('telemetry') ?>" class="admin-sidebar-link <?= ($currentPage === 'telemetry') ? 'active' : '' ?>">
                            <span><i class="bi bi-activity me-2 text-success"></i> Telemetry</span>
                            <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle"
                                style="font-size: 0.62rem;">Live</span>
                        </a>
                    </nav>

                    <!-- Filter By Status Section Title -->
                    <div class="admin-sidebar-section-title">Filter By Status</div>
                    <div class="d-flex flex-column gap-1 mb-2">
                        <?php if ($currentPage === 'deliverables'): ?>
                            <button type="button" class="admin-sidebar-link sidebar-status-filter active"
                                data-status-filter="all">
                                <span><i class="bi bi-grid-fill me-2 text-info"></i> All Systems</span>
                                <span class="badge rounded-pill bg-dark border border-secondary text-muted"
                                    style="font-size: 0.62rem;"><?= $totalCount ?></span>
                            </button>
                            <button type="button" class="admin-sidebar-link sidebar-status-filter"
                                data-status-filter="published">
                                <span><i class="bi bi-check-circle-fill me-2 text-success"></i> Published Live</span>
                                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle"
                                    style="font-size: 0.62rem;"><?= $activeCount ?></span>
                            </button>
                            <button type="button" class="admin-sidebar-link sidebar-status-filter"
                                data-status-filter="draft">
                                <span><i class="bi bi-shield-lock-fill me-2 text-warning"></i> Staging Drafts</span>
                                <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle"
                                    style="font-size: 0.62rem;"><?= $draftCount ?></span>
                            </button>
                        <?php else: ?>
                            <a href="<?= admin_url('deliverables?filter=all') ?>" class="admin-sidebar-link">
                                <span><i class="bi bi-grid-fill me-2 text-info"></i> All Systems</span>
                                <span class="badge rounded-pill bg-dark border border-secondary text-muted"
                                    style="font-size: 0.62rem;"><?= $totalCount ?></span>
                            </a>
                            <a href="<?= admin_url('deliverables?filter=published') ?>" class="admin-sidebar-link">
                                <span><i class="bi bi-check-circle-fill me-2 text-success"></i> Published Live</span>
                                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle"
                                    style="font-size: 0.62rem;"><?= $activeCount ?></span>
                            </a>
                            <a href="<?= admin_url('deliverables?filter=draft') ?>" class="admin-sidebar-link">
                                <span><i class="bi bi-shield-lock-fill me-2 text-warning"></i> Staging Drafts</span>
                                <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle"
                                    style="font-size: 0.62rem;"><?= $draftCount ?></span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Platform Bridges Section Title -->
                    <div class="admin-sidebar-section-title">Platform Bridges</div>
                    <div class="d-flex gap-1 mb-2">
                        <a href="../../crm/" target="_blank"
                            class="admin-sidebar-bridge-link flex-fill text-center justify-content-center py-1"
                            style="font-size: 0.72rem;" title="Company CRM Command">
                            <i class="bi bi-robot me-1 text-warning"></i> CRM
                        </a>
                        <a href="<?= url('#work') ?>" target="_blank"
                            class="admin-sidebar-bridge-link flex-fill text-center justify-content-center py-1"
                            style="font-size: 0.72rem;" title="Public Portfolio Showcase">
                            <i class="bi bi-globe2 me-1 text-primary"></i> Public
                        </a>
                        <a href="<?= url('discovery-call') ?>" target="_blank"
                            class="admin-sidebar-bridge-link flex-fill text-center justify-content-center py-1"
                            style="font-size: 0.72rem;" title="Client Discovery Intake">
                            <i class="bi bi-lightning-charge me-1 text-info"></i> Intake
                        </a>
                    </div>
                </div>
            </aside>

            <!-- ======================================================== -->
            <!-- MAIN CONTENT AREA                                        -->
            <!-- ======================================================== -->
            <main class="col-12 col-lg-10 p-3 p-md-4 d-flex flex-column" style="min-height: 100vh; overflow-x: hidden;">

                <!-- Top Header & Status Bar -->
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pb-3 mb-4 border-bottom"
                    style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <div class="d-flex align-items-center gap-3">
                        <!-- Mobile Hamburger -->
                        <button class="btn btn-outline-secondary d-lg-none" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#adminMobileSidebar" aria-controls="adminMobileSidebar"
                            aria-label="Toggle Navigation">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                        <div>
                            <h1 class="h4 mb-0 fw-bold"><?= htmlspecialchars($pageTitle) ?></h1>
                            <p class="text-muted small mb-0"><?= htmlspecialchars($pageSubtitle) ?></p>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <!-- Repository Status Badge with pulse -->
                        <div class="badge d-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                            style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #34D399;">
                            <span class="live-dot" style="width: 6px; height: 6px;"></span>
                            <span class="fw-semibold">Repository: Active Sync</span>
                        </div>

                        <!-- Bootstrap Theme Toggle Dropdown -->
                        <div class="dropdown">
                            <button
                                class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-2 py-1"
                                id="bd-theme-admin" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-circle-half theme-icon-active text-primary"></i>
                                <span class="small d-none d-md-inline" id="bd-theme-admin-text">Dark &amp; Light</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-admin">
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                        data-bs-theme-value="combo">
                                        <i class="bi bi-circle-half text-primary"></i> Dark &amp; Light Combo
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                        data-bs-theme-value="dark">
                                        <i class="bi bi-moon-stars-fill text-info"></i> Full Dark Mode
                                    </button>
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                        data-bs-theme-value="light">
                                        <i class="bi bi-sun-fill text-warning"></i> Pure Light Mode
                                    </button>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <button type="button" class="dropdown-item d-flex align-items-center gap-2"
                                        data-bs-theme-value="auto">
                                        <i class="bi bi-laptop text-secondary"></i> System Auto
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- New Deliverable Action Button -->
                        <a href="<?= admin_url('project-form') ?>" class="btn btn-info btn-sm fw-bold text-dark px-3"
                            style="background: #38BDF8; border-color: #38BDF8;">
                            <i class="bi bi-plus-lg me-1"></i> New Deliverable
                        </a>
                    </div>
                </div>

                <!-- Flash Notifications -->
                <?php if ($flash): ?>
                    <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : ($flash['type'] === 'success' ? 'success' : 'info') ?> alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-3 mb-4"
                        role="alert">
                        <i
                            class="bi <?= $flash['type'] === 'error' ? 'bi-exclamation-triangle-fill' : ($flash['type'] === 'success' ? 'bi-check-circle-fill' : 'bi-info-circle-fill') ?> fs-5"></i>
                        <div><?= htmlspecialchars($flash['message']) ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
