<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_admin_auth();

use App\Services\ProjectService;

$projects = ProjectService::getAll();
$totalCount = count($projects);
$activeCount = count(array_filter($projects, fn($p) => !empty($p['active'])));
$draftCount = $totalCount - $activeCount;
$categories = array_values(array_unique(array_filter(array_column($projects, 'category'))));

$flash = get_admin_flash();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="combo">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeX404 Solutions — Production Portfolio & Deliverables Admin</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts: Plus Jakarta Sans & Fira Code -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            --cx-bg-canvas: #030712;
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
            --cx-nav-bg: #070B14; /* Dark command navigation */
            --cx-card-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
            --cx-pill-bg: #F1F5F9;
            --cx-hero-bg: radial-gradient(circle at 85% 15%, rgba(14, 165, 233, 0.09) 0%, rgba(168, 85, 247, 0.06) 45%, #FFFFFF 100%), #FFFFFF;
            --cx-banner-border: rgba(14, 165, 233, 0.25);
            --cx-ticker-bg: #FFFFFF;
        }

        /* Prevent Horizontal Overflow & Overlapping */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        html, body {
            max-width: 100%;
            overflow-x: hidden;
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

        /* ========================================================= */
        /* COLORFUL GRADIENT TYPOGRAPHY                             */
        /* ========================================================= */
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

        /* ========================================================= */
        /* TOP NAVIGATION BAR                                        */
        /* ========================================================= */
        .admin-navbar {
            background-color: var(--cx-nav-bg);
            border-bottom: 1px solid var(--cx-border);
            padding: 0.75rem 1.25rem;
            position: sticky;
            top: 0;
            z-index: 1030;
            backdrop-filter: blur(16px);
        }

        [data-bs-theme="combo"] .admin-navbar,
        [data-bs-theme="dark"] .admin-navbar {
            border-bottom-color: rgba(255, 255, 255, 0.08) !important;
        }

        .admin-brand-pill {
            display: inline-flex;
            align-items: center;
            background: #0B0F19;
            padding: 6px 14px;
            border-radius: 12px;
            border: 1px solid rgba(34, 211, 238, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.35);
            text-decoration: none;
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .admin-brand-pill:hover {
            transform: translateY(-1px);
            border-color: var(--cx-cyan);
            box-shadow: 0 6px 20px rgba(34, 211, 238, 0.2);
        }

        .admin-nav-link {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.5rem 0.85rem;
            border-radius: 8px;
            color: var(--cx-text-secondary);
            text-decoration: none;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        [data-bs-theme="combo"] .admin-navbar .admin-nav-link,
        [data-bs-theme="dark"] .admin-navbar .admin-nav-link {
            color: #94A3B8;
        }

        .admin-nav-link:hover,
        .admin-nav-link.active {
            color: var(--cx-cyan);
            background: rgba(34, 211, 238, 0.1);
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
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* ========================================================= */
        /* FUTURISTIC ANIMATED SVG BANNER                           */
        /* ========================================================= */
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

        /* SVG Animation Keyframes */
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

        .svg-flow-path {
            stroke-dasharray: 8 6;
            animation: flowDash 15s linear infinite;
        }

        .svg-pulsing-node {
            transform-origin: center;
            animation: pulseNode 3s ease-in-out infinite;
        }

        .svg-rotating-ring {
            transform-origin: 350px 180px;
            animation: orbitSlow 25s linear infinite;
        }

        .svg-floating-group {
            animation: floatSlow 6s ease-in-out infinite;
        }

        /* ========================================================= */
        /* CONTINUOUS MARQUEE SCROLLER TICKER                        */
        /* ========================================================= */
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

        /* ========================================================= */
        /* INTERACTIVE DELIVERABLES SLIDER CAROUSEL                  */
        /* ========================================================= */
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

        /* ========================================================= */
        /* CARDS & METRIC WIDGETS                                    */
        /* ========================================================= */
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

        /* ========================================================= */
        /* TABLE STYLING & OVERFLOW GUARDS                           */
        /* ========================================================= */
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

        /* Filter Pills */
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
        }

        .filter-pill-btn:hover,
        .filter-pill-btn.active {
            background: var(--cx-cyan);
            border-color: var(--cx-cyan);
            color: #030712;
            font-weight: 700;
        }

        /* Quick Action Toolbar Buttons */
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

        .modal-header, .modal-footer {
            border-color: var(--cx-border);
        }

        /* Responsive Mobile Nav Drawer */
        #adminMobileNav {
            background: var(--cx-nav-bg);
            border-top: 1px solid var(--cx-border);
            padding: 1rem 0.5rem;
        }

        /* ========================================================= */
        /* ADMIN SIDEBAR & FOOTER STYLING                            */
        /* ========================================================= */
        .admin-sidebar {
            background: var(--cx-nav-bg);
            border-right: 1px solid var(--cx-border);
            z-index: 100;
        }

        .admin-sidebar-section-title {
            font-size: 0.68rem;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.08em;
            color: var(--cx-text-muted);
            margin-bottom: 0.5rem;
            padding: 0 0.5rem;
        }

        .admin-sidebar-link {
            color: var(--cx-text-muted);
            border-radius: 8px;
            padding: 0.55rem 0.85rem;
            font-weight: 600;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.15s ease;
            text-decoration: none;
            margin-bottom: 0.3rem;
            background: transparent;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .admin-sidebar-link:hover {
            color: var(--cx-cyan);
            background: rgba(34, 211, 238, 0.08);
            transform: translateX(2px);
        }

        .admin-sidebar-link.active {
            color: var(--cx-cyan);
            background: rgba(34, 211, 238, 0.12);
            font-weight: 700;
        }

        .admin-sidebar-user-card {
            background: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 12px;
            padding: 0.85rem 1rem;
            margin-bottom: 1.25rem;
        }

        .admin-footer {
            background: var(--cx-bg-card);
            border: 1px solid var(--cx-border);
            border-radius: 16px;
            padding: 1.75rem 1.5rem;
            margin-top: 3rem;
            box-shadow: var(--cx-card-shadow);
        }
    </style>
</head>
<body>

<!-- ======================================================== -->
<!-- TOP COMMAND NAVIGATION BAR                               -->
<!-- ======================================================== -->
<nav class="admin-navbar">
    <div class="container-fluid px-md-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
        <!-- Brand with Original Logo in Dark Pill -->
        <div class="d-flex align-items-center gap-3">
            <a href="<?= admin_url() ?>" class="admin-brand-pill" title="CodeX404 Solutions Admin">
                <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" style="height: 30px; object-fit: contain;">
            </a>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-dark border border-secondary text-info text-uppercase px-2 py-1" style="font-size: 0.68rem; letter-spacing: 0.08em;">
                    PORTFOLIO ADMIN
                </span>
                <span class="d-none d-sm-inline-flex align-items-center gap-1 text-success small fw-semibold" style="font-size: 0.75rem;">
                    <span class="live-dot"></span> Live Sync
                </span>
            </div>
        </div>

        <!-- Center Cross-Platform Nav Links (Desktop) -->
        <div class="d-none d-lg-flex align-items-center gap-1">
            <a href="<?= admin_url() ?>" class="admin-nav-link active">
                <i class="bi bi-grid-1x2-fill text-info"></i> Projects Portfolio
            </a>
            <a href="../../crm/" target="_blank" class="admin-nav-link">
                <i class="bi bi-robot text-warning"></i>
                <span>CRM &amp; Paperclip OS</span>
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle ms-1" style="font-size: 0.65rem;">Autonomous</span>
            </a>
            <a href="<?= url('#work') ?>" target="_blank" class="admin-nav-link">
                <i class="bi bi-box-arrow-up-right text-primary"></i> Public Work
            </a>
            <a href="<?= url('discovery-call') ?>" target="_blank" class="admin-nav-link">
                <i class="bi bi-lightning-charge-fill text-warning"></i> Lead Intake
            </a>
        </div>

        <!-- Right Side Controls: Theme Switcher & Admin User Dropdown -->
        <div class="d-flex align-items-center gap-2">
            <!-- Mobile Toggle Button (Opens Offcanvas Sidebar) -->
            <button class="btn btn-outline-secondary btn-sm d-lg-none py-1 px-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminMobileSidebar" aria-controls="adminMobileSidebar" aria-label="Toggle Navigation">
                <i class="bi bi-list fs-5"></i>
            </button>

            <!-- Bootstrap Theme Toggle Dropdown -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle d-flex align-items-center gap-2 px-3 py-1" id="bd-theme-admin" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                    <i class="bi bi-circle-half theme-icon-active text-info"></i>
                    <span class="small d-none d-sm-inline" id="bd-theme-admin-text">Dark &amp; Light</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-admin">
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

            <!-- Admin Profile Dropdown -->
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-2 py-1 px-2" type="button" id="adminUserDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 24px; height: 24px; font-size: 0.72rem;">
                        A
                    </div>
                    <span class="small fw-semibold d-none d-md-inline"><?= htmlspecialchars((string)($_SESSION['codex_admin_user'] ?? 'admin')) ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="adminUserDropdown">
                    <li class="dropdown-header small text-uppercase fw-bold text-muted">Session Info</li>
                    <li class="px-3 py-1">
                        <small class="text-muted d-block">IP: <code><?= htmlspecialchars(get_client_ip()) ?></code></small>
                        <small class="text-muted d-block">Role: <span class="badge bg-info-subtle text-info">Superadmin</span></small>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a href="../../crm/" target="_blank" class="dropdown-item d-flex align-items-center gap-2">
                            <i class="bi bi-robot text-warning"></i> Open CRM Command Center
                        </a>
                    </li>
                    <li>
                        <a href="<?= url('#work') ?>" target="_blank" class="dropdown-item d-flex align-items-center gap-2">
                            <i class="bi bi-globe2 text-primary"></i> View Public Website
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a href="<?= admin_url('logout') ?>" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                            <i class="bi bi-box-arrow-left"></i> Sign Out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- ======================================================== -->
<!-- MOBILE OFFCANVAS SIDEBAR                                 -->
<!-- ======================================================== -->
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="adminMobileSidebar" style="width: 290px;">
    <div class="offcanvas-header border-bottom border-secondary">
        <div class="d-flex align-items-center gap-2">
            <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" style="max-height: 32px; object-fit: contain;">
            <span class="badge bg-dark border border-secondary text-info text-uppercase" style="font-size: 0.65rem;">ADMIN</span>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-3">
        <!-- User Info -->
        <div class="admin-sidebar-user-card mb-3">
            <div class="d-flex align-items-center justify-content-between mb-1">
                <span class="fw-bold small text-white"><?= htmlspecialchars((string)($_SESSION['codex_admin_user'] ?? 'admin')) ?></span>
                <span class="live-dot" title="Live Session Active"></span>
            </div>
            <div class="d-flex align-items-center gap-1 flex-wrap">
                <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase" style="font-size: 0.65rem;">Superadmin</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.65rem;">Live Sync</span>
            </div>
        </div>

        <div class="d-grid mb-3">
            <a href="<?= admin_url('project-form') ?>" class="btn btn-primary btn-sm fw-bold d-flex align-items-center justify-content-center gap-2 py-2" style="background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%); border: none; border-radius: 10px;">
                <i class="bi bi-plus-circle-fill"></i>
                <span>New Deliverable</span>
            </a>
        </div>

        <div class="admin-sidebar-section-title">Navigation</div>
        <nav class="nav flex-column mb-3">
            <a href="#admin-hero" class="admin-sidebar-link active" data-bs-dismiss="offcanvas">
                <span><i class="bi bi-speedometer2 me-2 text-info"></i> Overview</span>
                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill">Top</span>
            </a>
            <a href="#portfolio-table" class="admin-sidebar-link" data-bs-dismiss="offcanvas">
                <span><i class="bi bi-collection-play-fill me-2 text-warning"></i> Deliverables</span>
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill"><?= $totalCount ?></span>
            </a>
            <a href="#showcase-slider" class="admin-sidebar-link" data-bs-dismiss="offcanvas">
                <span><i class="bi bi-stars me-2 text-primary"></i> Showcase Slider</span>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill"><?= min(6, $totalCount) ?></span>
            </a>
            <a href="#telemetry-ticker" class="admin-sidebar-link" data-bs-dismiss="offcanvas">
                <span><i class="bi bi-activity me-2 text-success"></i> Telemetry Ticker</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Live</span>
            </a>
        </nav>

        <div class="admin-sidebar-section-title">Filter By Status</div>
        <div class="d-flex flex-column gap-1 mb-3">
            <button type="button" class="admin-sidebar-link sidebar-status-filter active" data-status-filter="all" data-bs-dismiss="offcanvas">
                <span><i class="bi bi-grid-fill me-2 text-info"></i> All Systems</span>
                <span class="badge bg-dark border border-secondary text-white rounded-pill"><?= $totalCount ?></span>
            </button>
            <button type="button" class="admin-sidebar-link sidebar-status-filter" data-status-filter="published" data-bs-dismiss="offcanvas">
                <span><i class="bi bi-check-circle-fill me-2 text-success"></i> Published Live</span>
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill"><?= $activeCount ?></span>
            </button>
            <button type="button" class="admin-sidebar-link sidebar-status-filter" data-status-filter="draft" data-bs-dismiss="offcanvas">
                <span><i class="bi bi-shield-lock-fill me-2 text-warning"></i> Staging Drafts</span>
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill"><?= $draftCount ?></span>
            </button>
        </div>

        <div class="admin-sidebar-section-title">Platform Bridges</div>
        <nav class="nav flex-column mb-3">
            <a href="../../crm/" target="_blank" class="admin-sidebar-link">
                <span><i class="bi bi-robot me-2 text-warning"></i> CRM &amp; Paperclip</span>
                <i class="bi bi-box-arrow-up-right small text-muted"></i>
            </a>
            <a href="<?= url('#work') ?>" target="_blank" class="admin-sidebar-link">
                <span><i class="bi bi-globe2 me-2 text-primary"></i> Public Portfolio</span>
                <i class="bi bi-box-arrow-up-right small text-muted"></i>
            </a>
            <a href="<?= url('discovery-call') ?>" target="_blank" class="admin-sidebar-link">
                <span><i class="bi bi-lightning-charge me-2 text-info"></i> Lead Intake Form</span>
                <i class="bi bi-box-arrow-up-right small text-muted"></i>
            </a>
        </nav>

        <hr style="border-color: rgba(255, 255, 255, 0.1);">
        <div class="d-grid">
            <a href="<?= admin_url('logout') ?>" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center gap-2">
                <i class="bi bi-box-arrow-left"></i> Sign Out
            </a>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- 2-COLUMN LAYOUT: SIDEBAR + MAIN CONTENT AREA             -->
<!-- ======================================================== -->
<div class="container-fluid p-0">
    <div class="row g-0">

        <!-- ======================================================== -->
        <!-- ADMIN SIDEBAR (Desktop)                                  -->
        <!-- ======================================================== -->
        <aside class="col-12 col-lg-2 d-none d-lg-block admin-sidebar p-3 position-sticky" style="top: 61px; height: calc(100vh - 61px); overflow-y: auto;">
            <!-- Admin User Status Card -->
            <div class="admin-sidebar-user-card">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="fw-bold small"><?= htmlspecialchars((string)($_SESSION['codex_admin_user'] ?? 'admin')) ?></span>
                    <span class="live-dot" title="Live Session Active"></span>
                </div>
                <div class="d-flex align-items-center gap-1 flex-wrap">
                    <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase" style="font-size: 0.65rem;">Superadmin</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.65rem;">Live Sync</span>
                </div>
            </div>

            <!-- Upload New Project Quick Action CTA -->
            <div class="d-grid mb-3">
                <a href="<?= admin_url('project-form') ?>" class="btn btn-primary btn-sm fw-bold d-flex align-items-center justify-content-center gap-2 py-2 shadow-sm" style="background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%); border: none; border-radius: 10px;">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>New Deliverable</span>
                </a>
            </div>

            <!-- Main Navigation -->
            <div class="admin-sidebar-section-title">Navigation</div>
            <nav class="nav flex-column mb-3" id="adminSidebarNav">
                <a href="#admin-hero" class="admin-sidebar-link active">
                    <span><i class="bi bi-speedometer2 me-2 text-info"></i> Overview</span>
                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill">Top</span>
                </a>
                <a href="#portfolio-table" class="admin-sidebar-link">
                    <span><i class="bi bi-collection-play-fill me-2 text-warning"></i> Deliverables</span>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill"><?= $totalCount ?></span>
                </a>
                <a href="#showcase-slider" class="admin-sidebar-link">
                    <span><i class="bi bi-stars me-2 text-primary"></i> Showcase Slider</span>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill"><?= min(6, $totalCount) ?></span>
                </a>
                <a href="#telemetry-ticker" class="admin-sidebar-link">
                    <span><i class="bi bi-activity me-2 text-success"></i> Telemetry Ticker</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Live</span>
                </a>
            </nav>

            <!-- Quick Filter Shortcuts -->
            <div class="admin-sidebar-section-title">Filter By Status</div>
            <div class="d-flex flex-column gap-1 mb-3">
                <button type="button" class="admin-sidebar-link sidebar-status-filter active" data-status-filter="all">
                    <span><i class="bi bi-grid-fill me-2 text-info"></i> All Systems</span>
                    <span class="badge bg-dark border border-secondary text-white rounded-pill"><?= $totalCount ?></span>
                </button>
                <button type="button" class="admin-sidebar-link sidebar-status-filter" data-status-filter="published">
                    <span><i class="bi bi-check-circle-fill me-2 text-success"></i> Published Live</span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill"><?= $activeCount ?></span>
                </button>
                <button type="button" class="admin-sidebar-link sidebar-status-filter" data-status-filter="draft">
                    <span><i class="bi bi-shield-lock-fill me-2 text-warning"></i> Staging Drafts</span>
                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill"><?= $draftCount ?></span>
                </button>
            </div>

            <!-- Platform Bridges -->
            <div class="admin-sidebar-section-title">Platform Bridges</div>
            <nav class="nav flex-column mb-3">
                <a href="../../crm/" target="_blank" class="admin-sidebar-link">
                    <span><i class="bi bi-robot me-2 text-warning"></i> CRM &amp; Paperclip</span>
                    <i class="bi bi-box-arrow-up-right small text-muted"></i>
                </a>
                <a href="<?= url('#work') ?>" target="_blank" class="admin-sidebar-link">
                    <span><i class="bi bi-globe2 me-2 text-primary"></i> Public Portfolio</span>
                    <i class="bi bi-box-arrow-up-right small text-muted"></i>
                </a>
                <a href="<?= url('discovery-call') ?>" target="_blank" class="admin-sidebar-link">
                    <span><i class="bi bi-lightning-charge me-2 text-info"></i> Lead Intake Form</span>
                    <i class="bi bi-box-arrow-up-right small text-muted"></i>
                </a>
            </nav>

            <hr style="border-color: var(--cx-border);">

            <!-- Sign Out -->
            <div class="d-grid">
                <a href="<?= admin_url('logout') ?>" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px;">
                    <i class="bi bi-box-arrow-left"></i> Sign Out
                </a>
            </div>
        </aside>

        <!-- ======================================================== -->
        <!-- MAIN CONTENT AREA                                        -->
        <!-- ======================================================== -->
        <main class="col-12 col-lg-10 p-3 p-md-4" style="min-height: calc(100vh - 61px); overflow-x: hidden;">

            <!-- Flash Notifications -->
            <?php if ($flash): ?>
                <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : ($flash['type'] === 'success' ? 'success' : 'info') ?> alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm rounded-3 mb-4" role="alert">
                    <i class="bi <?= $flash['type'] === 'error' ? 'bi-exclamation-triangle-fill' : ($flash['type'] === 'success' ? 'bi-check-circle-fill' : 'bi-info-circle-fill') ?> fs-5"></i>
                    <div><?= htmlspecialchars($flash['message']) ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- ======================================================== -->
            <!-- 1. FUTURISTIC ANIMATED SVG HERO BANNER                   -->
            <!-- ======================================================== -->
            <section class="admin-hero-banner" id="admin-hero">
        <!-- High-Detail Animated Cyber Vector SVG Canvas -->
        <svg class="banner-svg-canvas" viewBox="0 0 650 320" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
            <defs>
                <linearGradient id="cyberGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#22D3EE" stop-opacity="0.8"/>
                    <stop offset="50%" stop-color="#3B82F6" stop-opacity="0.6"/>
                    <stop offset="100%" stop-color="#8B5CF6" stop-opacity="0.2"/>
                </linearGradient>
                <linearGradient id="cyberGrad2" x1="100%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#EC4899" stop-opacity="0.7"/>
                    <stop offset="100%" stop-color="#6366F1" stop-opacity="0.2"/>
                </linearGradient>
                <filter id="glowFilter" x="-20%" y="-20%" width="140%" height="140%">
                    <feGaussianBlur stdDeviation="6" result="blur" />
                    <feComposite in="SourceGraphic" in2="blur" operator="over" />
                </filter>
                <pattern id="adminGrid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(34, 211, 238, 0.08)" stroke-width="1"/>
                    <circle cx="40" cy="0" r="1.5" fill="rgba(34, 211, 238, 0.25)"/>
                </pattern>
            </defs>

            <!-- Background Cyber Grid -->
            <rect width="650" height="320" fill="url(#adminGrid)" />

            <!-- Ambient Glow Spheres -->
            <circle cx="500" cy="90" r="140" fill="rgba(34, 211, 238, 0.12)" filter="url(#glowFilter)"/>
            <circle cx="360" cy="220" r="120" fill="rgba(168, 85, 247, 0.1)" filter="url(#glowFilter)"/>

            <!-- Moving Circuit Paths -->
            <g class="svg-flow-path" stroke="url(#cyberGrad1)" stroke-width="2" fill="none">
                <path d="M 120 280 L 220 200 L 340 200 L 420 120 L 580 120" />
                <path d="M 180 320 L 280 240 L 400 240 L 480 170 L 620 170" stroke="url(#cyberGrad2)" stroke-width="1.5" />
                <path d="M 260 20 L 360 80 L 490 80 L 550 40 L 640 40" />
            </g>

            <!-- Pulsing Connection Nodes -->
            <g class="svg-pulsing-node">
                <circle cx="220" cy="200" r="5" fill="#22D3EE" filter="url(#glowFilter)"/>
                <circle cx="340" cy="200" r="4" fill="#3B82F6"/>
                <circle cx="420" cy="120" r="6" fill="#8B5CF6" filter="url(#glowFilter)"/>
                <circle cx="580" cy="120" r="5" fill="#EC4899"/>
                <circle cx="480" cy="170" r="4" fill="#38BDF8"/>
                <circle cx="360" cy="80" r="5" fill="#10B981"/>
            </g>

            <!-- Rotating Orbital Ring Group -->
            <g class="svg-rotating-ring" stroke="rgba(34, 211, 238, 0.25)" stroke-width="1.5" fill="none" stroke-dasharray="12 10">
                <circle cx="350" cy="180" r="85" />
                <circle cx="350" cy="180" r="125" stroke="rgba(139, 92, 246, 0.18)" stroke-dasharray="16 12"/>
            </g>

            <!-- 3D Isometric Cluster Box -->
            <g class="svg-floating-group">
                <polygon points="500,80 550,55 600,80 550,105" fill="rgba(34, 211, 238, 0.25)" stroke="#22D3EE" stroke-width="1.5"/>
                <polygon points="500,80 550,105 550,155 500,130" fill="rgba(59, 130, 246, 0.3)" stroke="#3B82F6" stroke-width="1.5"/>
                <polygon points="550,105 600,80 600,130 550,155" fill="rgba(139, 92, 246, 0.35)" stroke="#8B5CF6" stroke-width="1.5"/>
                <circle cx="550" cy="105" r="4" fill="#FFFFFF" filter="url(#glowFilter)"/>
            </g>
        </svg>

        <div class="banner-content">
            <div class="banner-tech-pill">
                <span class="live-dot" style="width: 7px; height: 7px;"></span>
                <span>CodeX404 Enterprise Architecture V14.2</span>
            </div>
            <h1 class="banner-title">
                Production Deliverables &amp; <br>
                <span class="text-gradient-rainbow">Showcase Command Center</span>
            </h1>
            <p class="banner-description">
                Real-time orchestration of verified enterprise client systems, high-availability architecture specs, interactive sandbox environments, and public portfolio deployments.
            </p>

            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <a href="<?= admin_url('project-form') ?>" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2 px-3 py-2 fw-bold shadow-sm" style="background: linear-gradient(135deg, #0EA5E9 0%, #2563EB 100%); border: none; border-radius: 10px;">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Upload New Project</span>
                </a>
                <a href="<?= url('#work') ?>" target="_blank" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-2 px-3 py-2" style="border-radius: 10px;">
                    <i class="bi bi-eye"></i>
                    <span>Preview Public Showcase</span>
                </a>
                <a href="../../crm/" target="_blank" class="btn btn-outline-info btn-sm d-inline-flex align-items-center gap-2 px-3 py-2" style="border-radius: 10px;">
                    <i class="bi bi-robot text-warning"></i>
                    <span>Launch CRM Command</span>
                </a>
            </div>

            <div class="banner-meta-bar">
                <div class="banner-meta-item">
                    <i class="bi bi-shield-check text-success"></i>
                    <span>Sync: <strong>Instant Webhooks</strong></span>
                </div>
                <div class="banner-meta-item">
                    <i class="bi bi-speedometer2 text-info"></i>
                    <span>Uptime SLA: <strong>99.98% High-Avail</strong></span>
                </div>
                <div class="banner-meta-item">
                    <i class="bi bi-hdd-network text-primary"></i>
                    <span>Inventory: <strong><?= $totalCount ?> Total Systems</strong></span>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================================================== -->
    <!-- 2. CONTINUOUS MARQUEE SCROLLER TICKER                    -->
    <!-- ======================================================== -->
    <div class="admin-marquee-wrap" id="telemetry-ticker">
        <div class="admin-marquee-label">
            <span class="live-dot" style="width: 6px; height: 6px;"></span>
            <span>Live Telemetry</span>
        </div>
        <div class="admin-marquee-viewport">
            <div class="admin-marquee-track">
                <!-- Set 1 -->
                <div class="admin-marquee-item">
                    <i class="bi bi-collection-play-fill text-info"></i>
                    <span>Deliverables: <strong><?= $totalCount ?> Managed Applications</strong></span>
                    <span class="sep">&bull;</span>
                </div>
                <div class="admin-marquee-item">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <span>Public Showcase: <strong><?= $activeCount ?> Published Live</strong></span>
                    <span class="sep">&bull;</span>
                </div>
                <div class="admin-marquee-item">
                    <i class="bi bi-shield-lock-fill text-warning"></i>
                    <span>Staging Sandbox: <strong><?= $draftCount ?> In Review</strong></span>
                    <span class="sep">&bull;</span>
                </div>
                <div class="admin-marquee-item">
                    <i class="bi bi-cpu-fill text-primary"></i>
                    <span>Tech Stack: <strong>PHP 8.3 &bull; Bootstrap 5.3.3 &bull; Dual-Tone Engine</strong></span>
                    <span class="sep">&bull;</span>
                </div>
                <div class="admin-marquee-item">
                    <i class="bi bi-robot text-warning"></i>
                    <span>Paperclip Multi-Agent OS: <strong>Armed &amp; Connected</strong></span>
                    <span class="sep">&bull;</span>
                </div>
                <div class="admin-marquee-item">
                    <i class="bi bi-globe-americas text-info"></i>
                    <span>Domains: <strong><?= count($categories) ?> Industry Categories Synchronized</strong></span>
                    <span class="sep">&bull;</span>
                </div>
                <div class="admin-marquee-item">
                    <i class="bi bi-lightning-charge-fill text-warning"></i>
                    <span>SLA Response: <strong>Sub-100ms Optimized Edge Cache</strong></span>
                    <span class="sep">&bull;</span>
                </div>

                <!-- Set 2 (Duplicate for Infinite Smooth Loop) -->
                <div class="admin-marquee-item">
                    <i class="bi bi-collection-play-fill text-info"></i>
                    <span>Deliverables: <strong><?= $totalCount ?> Managed Applications</strong></span>
                    <span class="sep">&bull;</span>
                </div>
                <div class="admin-marquee-item">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <span>Public Showcase: <strong><?= $activeCount ?> Published Live</strong></span>
                    <span class="sep">&bull;</span>
                </div>
                <div class="admin-marquee-item">
                    <i class="bi bi-shield-lock-fill text-warning"></i>
                    <span>Staging Sandbox: <strong><?= $draftCount ?> In Review</strong></span>
                    <span class="sep">&bull;</span>
                </div>
                <div class="admin-marquee-item">
                    <i class="bi bi-cpu-fill text-primary"></i>
                    <span>Tech Stack: <strong>PHP 8.3 &bull; Bootstrap 5.3.3 &bull; Dual-Tone Engine</strong></span>
                    <span class="sep">&bull;</span>
                </div>
                <div class="admin-marquee-item">
                    <i class="bi bi-robot text-warning"></i>
                    <span>Paperclip Multi-Agent OS: <strong>Armed &amp; Connected</strong></span>
                    <span class="sep">&bull;</span>
                </div>
                <div class="admin-marquee-item">
                    <i class="bi bi-globe-americas text-info"></i>
                    <span>Domains: <strong><?= count($categories) ?> Industry Categories Synchronized</strong></span>
                    <span class="sep">&bull;</span>
                </div>
                <div class="admin-marquee-item">
                    <i class="bi bi-lightning-charge-fill text-warning"></i>
                    <span>SLA Response: <strong>Sub-100ms Optimized Edge Cache</strong></span>
                    <span class="sep">&bull;</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 3. INTERACTIVE DELIVERABLES SHOWCASE SLIDER               -->
    <!-- ======================================================== -->
    <?php if (!empty($projects)): ?>
    <section class="deliverables-slider-section" id="showcase-slider">
        <div class="slider-header">
            <div>
                <h5 class="fw-bold mb-1 d-flex align-items-center gap-2">
                    <i class="bi bi-stars text-warning"></i>
                    <span>Featured Showcase Deliverables</span>
                    <span class="badge bg-info-subtle text-info border border-info-subtle" style="font-size: 0.72rem;">Interactive Carousel</span>
                </h5>
                <p class="text-muted small mb-0">Browse production applications, verified performance metrics, and interactive sandboxes.</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-xs btn-outline-secondary py-1 px-2 d-none d-sm-inline-flex align-items-center gap-1" id="sliderAutoToggle" style="font-size: 0.75rem; border-radius: 8px;">
                    <i class="bi bi-pause-fill" id="sliderAutoIcon"></i>
                    <span id="sliderAutoText">Pause Slider</span>
                </button>
                <button type="button" class="slider-nav-btn" id="sliderPrevBtn" aria-label="Previous slide" title="Previous Slide">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button type="button" class="slider-nav-btn" id="sliderNextBtn" aria-label="Next slide" title="Next Slide">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="slider-viewport" id="deliverablesSliderViewport">
            <div class="slider-track" id="deliverablesSliderTrack">
                <?php foreach ($projects as $idx => $p): ?>
                    <?php
                    $isActive = !empty($p['active']);
                    $category = strtolower((string)($p['category'] ?? 'software'));
                    ?>
                    <div class="slider-card-item">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="category-chip">
                                    <i class="bi bi-tag-fill me-1"></i><?= htmlspecialchars($p['category_label'] ?? ucfirst($p['category'])) ?>
                                </span>
                                <?php if ($isActive): ?>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle d-inline-flex align-items-center gap-1" style="font-size: 0.7rem;">
                                        <span class="live-dot" style="width: 5px; height: 5px;"></span> Live
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-muted border border-secondary-subtle" style="font-size: 0.7rem;">
                                        Draft
                                    </span>
                                <?php endif; ?>
                            </div>

                            <h6 class="fw-bold mb-1 text-truncate" title="<?= htmlspecialchars($p['title']) ?>"><?= htmlspecialchars($p['title']) ?></h6>
                            <div class="d-flex align-items-center gap-2 mb-2 text-muted small">
                                <code class="project-id-chip"><?= htmlspecialchars($p['id']) ?></code>
                                <?php if (!empty($p['mockup_host'])): ?>
                                    <span>&bull;</span>
                                    <span class="text-truncate" style="font-size: 0.76rem; font-family: var(--font-mono);"><?= htmlspecialchars($p['mockup_host']) ?></span>
                                <?php endif; ?>
                            </div>

                            <p class="small text-muted mb-3" style="font-size: 0.8rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.4em;">
                                <?= htmlspecialchars(!empty($p['problem']) ? $p['problem'] : 'Verified production system built for high-throughput enterprise performance.') ?>
                            </p>
                        </div>

                        <div>
                            <?php if (!empty($p['metric'])): ?>
                                <div class="p-2 rounded-3 mb-3 d-flex align-items-center gap-2" style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2);">
                                    <i class="bi bi-graph-up-arrow text-success"></i>
                                    <span class="small fw-semibold text-success text-truncate" style="font-size: 0.78rem;"><?= htmlspecialchars($p['metric']) ?></span>
                                </div>
                            <?php else: ?>
                                <div class="p-2 rounded-3 mb-3 d-flex align-items-center gap-2" style="background: rgba(56, 189, 248, 0.08); border: 1px solid rgba(56, 189, 248, 0.2);">
                                    <i class="bi bi-hdd-network text-info"></i>
                                    <span class="small fw-semibold text-info" style="font-size: 0.78rem;">Verified Client Architecture</span>
                                </div>
                            <?php endif; ?>

                            <div class="d-flex align-items-center justify-content-between gap-2 pt-2 border-top" style="border-color: var(--cx-border) !important;">
                                <span class="demo-chip">
                                    <i class="bi bi-play-circle-fill"></i>
                                    <span><?= htmlspecialchars($p['demo_key'] ?? 'erp') ?></span>
                                </span>
                                <div class="d-flex align-items-center gap-1">
                                    <button type="button" 
                                        class="btn btn-xs btn-outline-info btn-preview-project py-1 px-2"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalProjectPreview"
                                        data-title="<?= htmlspecialchars($p['title']) ?>"
                                        data-category="<?= htmlspecialchars($p['category_label'] ?? $p['category']) ?>"
                                        data-host="<?= htmlspecialchars($p['mockup_host'] ?? '') ?>"
                                        data-problem="<?= htmlspecialchars($p['problem'] ?? '') ?>"
                                        data-solution="<?= htmlspecialchars($p['solution'] ?? '') ?>"
                                        data-metric="<?= htmlspecialchars((string)($p['metric'] ?? '')) ?>"
                                        data-stat1-val="<?= htmlspecialchars($p['stat_1_val'] ?? '') ?>"
                                        data-stat1-lbl="<?= htmlspecialchars($p['stat_1_lbl'] ?? '') ?>"
                                        data-stat2-val="<?= htmlspecialchars($p['stat_2_val'] ?? '') ?>"
                                        data-stat2-lbl="<?= htmlspecialchars($p['stat_2_lbl'] ?? '') ?>"
                                        data-stat3-val="<?= htmlspecialchars($p['stat_3_val'] ?? '') ?>"
                                        data-stat3-lbl="<?= htmlspecialchars($p['stat_3_lbl'] ?? '') ?>"
                                        data-live-url="<?= htmlspecialchars($p['live_url'] ?? '') ?>"
                                        data-tags='<?= json_encode($p['tags'] ?? []) ?>'
                                        style="font-size: 0.75rem; border-radius: 6px;">
                                        <i class="bi bi-eye me-1"></i> Preview
                                    </button>
                                    <a href="<?= admin_url('project-form?id=' . urlencode($p['id'])) ?>" class="btn btn-xs btn-outline-primary py-1 px-2" style="font-size: 0.75rem; border-radius: 6px;">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Slider Pagination Dots Container -->
        <div class="slider-dots" id="deliverablesSliderDots"></div>
    </section>
    <?php endif; ?>

    <!-- ======================================================== -->
    <!-- KPI STATS CARDS ROW                                      -->
    <!-- ======================================================== -->
    <div class="row g-3 mb-4">
        <!-- Stat 1: Total Projects -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Total Deliverables</span>
                    <div class="stat-icon bg-info-subtle text-info">
                        <i class="bi bi-collection-play-fill"></i>
                    </div>
                </div>
                <div class="h2 fw-bold mb-1 text-gradient-cyan"><?= $totalCount ?></div>
                <div class="small text-muted d-flex align-items-center gap-1">
                    <i class="bi bi-check-all text-success"></i> Synchronized in repository
                </div>
            </div>
        </div>

        <!-- Stat 2: Active on Website -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card accent-emerald">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Active on Website</span>
                    <div class="stat-icon bg-success-subtle text-success">
                        <i class="bi bi-globe-americas"></i>
                    </div>
                </div>
                <div class="h2 fw-bold text-success mb-1"><?= $activeCount ?></div>
                <div class="small text-muted d-flex align-items-center gap-1">
                    <?php $pct = $totalCount > 0 ? round(($activeCount / $totalCount) * 100) : 0; ?>
                    <span class="badge bg-success-subtle text-success border border-success-subtle"><?= $pct ?>% Published</span>
                    <span>Visible to prospects</span>
                </div>
            </div>
        </div>

        <!-- Stat 3: Draft / Hidden -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card accent-amber">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Draft / Staging</span>
                    <div class="stat-icon bg-warning-subtle text-warning">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                </div>
                <div class="h2 fw-bold text-warning mb-1"><?= $draftCount ?></div>
                <div class="small text-muted d-flex align-items-center gap-1">
                    <i class="bi bi-shield-lock text-muted"></i> Hidden from public feed
                </div>
            </div>
        </div>

        <!-- Stat 4: Active Categories -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card accent-indigo">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold text-uppercase">Industry Domains</span>
                    <div class="stat-icon bg-primary-subtle text-primary">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                </div>
                <div class="h2 fw-bold text-gradient-purple mb-1"><?= count($categories) ?></div>
                <div class="small text-muted d-flex align-items-center gap-1 text-truncate">
                    <span><?= htmlspecialchars(implode(', ', array_slice($categories, 0, 3))) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- SEARCH, FILTER & TAB CONTROLS                            -->
    <!-- ======================================================== -->
    <div class="admin-card p-3 mb-4">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <!-- Search Input -->
            <div class="position-relative flex-grow-1" style="max-width: 380px;">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text" id="projectSearch" class="form-control form-control-sm ps-5 py-2" placeholder="Search by title, category, host, tag..." style="border-radius: 10px;">
            </div>

            <!-- Filter Pills (Status) -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="filter-pill-btn active" data-filter-status="all">
                    All <span class="badge bg-dark border border-secondary text-white rounded-pill ms-1"><?= $totalCount ?></span>
                </button>
                <button type="button" class="filter-pill-btn" data-filter-status="active">
                    <span class="live-dot me-1" style="width: 6px; height: 6px;"></span>
                    Published <span class="badge bg-success-subtle text-success rounded-pill ms-1"><?= $activeCount ?></span>
                </button>
                <button type="button" class="filter-pill-btn" data-filter-status="draft">
                    Draft <span class="badge bg-warning-subtle text-warning rounded-pill ms-1"><?= $draftCount ?></span>
                </button>
            </div>

            <!-- Category Filter Dropdown -->
            <div class="d-flex align-items-center gap-2">
                <select id="categoryFilter" class="form-select form-select-sm" style="border-radius: 8px; width: auto;">
                    <option value="all">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars(ucfirst($cat)) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- PROJECTS DATA TABLE CARD                                 -->
    <!-- ======================================================== -->
    <div class="admin-card overflow-hidden" id="portfolio-table">
        <?php if (empty($projects)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-folder-x fs-1 d-block mb-3 text-secondary"></i>
                <h5 class="fw-bold">No Projects in Portfolio</h5>
                <p class="small mb-3">Add your first production project deliverable to populate the website showcase.</p>
                <a href="<?= admin_url('project-form') ?>" class="btn btn-primary btn-sm px-3 py-2 fw-bold" style="border-radius: 8px;">
                    <i class="bi bi-plus-circle me-1"></i> Add First Project
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-admin align-middle" id="projectsTable">
                    <thead>
                        <tr>
                            <th style="width: 60px;"># Order</th>
                            <th>Project &amp; Architecture</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Interactive Demo</th>
                            <th>Key Metric</th>
                            <th style="width: 160px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $idx => $p): ?>
                            <?php
                            $isActive = !empty($p['active']);
                            $category = strtolower((string)($p['category'] ?? 'software'));
                            $tagsStr = implode(' ', (array)($p['tags'] ?? []));
                            $searchBlob = strtolower(($p['title'] ?? '') . ' ' . ($p['id'] ?? '') . ' ' . $category . ' ' . ($p['mockup_host'] ?? '') . ' ' . $tagsStr);
                            ?>
                            <tr class="project-row" 
                                data-search="<?= htmlspecialchars($searchBlob) ?>" 
                                data-status="<?= $isActive ? 'active' : 'draft' ?>"
                                data-category="<?= htmlspecialchars($category) ?>"
                                id="row-<?= htmlspecialchars($p['id']) ?>">
                                
                                <!-- Order -->
                                <td class="fw-bold text-muted small" style="font-family: var(--font-mono);">
                                    <?= (int)($p['order'] ?? ($idx + 1)) ?>
                                </td>

                                <!-- Title, ID & Host -->
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- Avatar Icon by Category -->
                                        <div class="rounded-3 d-flex align-items-center justify-content-center text-info fw-bold" style="width: 40px; height: 40px; background: rgba(34, 211, 238, 0.1); border: 1px solid rgba(34, 211, 238, 0.25); flex-shrink: 0;">
                                            <i class="bi <?= $category === 'ai' ? 'bi-cpu' : ($category === 'cloud' ? 'bi-cloud-check' : ($category === 'mobile' ? 'bi-phone' : 'bi-code-square')) ?> fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-white fs-6 mb-1 project-title-text"><?= htmlspecialchars($p['title']) ?></div>
                                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                                <span class="project-id-chip"><?= htmlspecialchars($p['id']) ?></span>
                                                <?php if (!empty($p['live_url'])): ?>
                                                    <span class="text-muted">&bull;</span>
                                                    <a href="<?= htmlspecialchars($p['live_url']) ?>" target="_blank" rel="noopener noreferrer" class="text-info text-decoration-none small d-inline-flex align-items-center gap-1" style="font-family: var(--font-mono); font-size: 0.76rem;">
                                                        <span><?= htmlspecialchars($p['mockup_host'] ?? 'Live URL') ?></span>
                                                        <i class="bi bi-box-arrow-up-right" style="font-size: 0.65rem;"></i>
                                                    </a>
                                                <?php elseif (!empty($p['mockup_host'])): ?>
                                                    <span class="text-muted">&bull;</span>
                                                    <span class="text-muted small" style="font-family: var(--font-mono); font-size: 0.76rem;"><?= htmlspecialchars($p['mockup_host']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Category -->
                                <td>
                                    <span class="category-chip">
                                        <i class="bi bi-tag-fill me-1"></i><?= htmlspecialchars($p['category_label'] ?? ucfirst($p['category'])) ?>
                                    </span>
                                </td>

                                <!-- Status (Toggle button) -->
                                <td>
                                    <form method="POST" action="<?= admin_url('toggle') ?>" class="d-inline">
                                        <?= csrf_input_field() ?>
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($p['id']) ?>">
                                        <?php if ($isActive): ?>
                                            <button type="submit" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1 py-1 px-2 rounded-pill shadow-sm" style="font-size: 0.75rem;" title="Click to hide from public site">
                                                <span class="live-dot" style="width: 6px; height: 6px;"></span>
                                                <span>Published</span>
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1 py-1 px-2 rounded-pill" style="font-size: 0.75rem;" title="Click to publish on website">
                                                <i class="bi bi-circle"></i>
                                                <span>Draft</span>
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </td>

                                <!-- Demo Key -->
                                <td>
                                    <span class="demo-chip">
                                        <i class="bi bi-play-circle-fill"></i>
                                        <span><?= htmlspecialchars($p['demo_key'] ?? 'erp') ?></span>
                                    </span>
                                </td>

                                <!-- Key Metric -->
                                <td style="max-width: 250px;">
                                    <div class="small text-muted text-truncate" title="<?= htmlspecialchars((string)($p['metric'] ?? '')) ?>">
                                        <i class="bi bi-graph-up-arrow text-success me-1"></i><?= htmlspecialchars((string)($p['metric'] ?? 'Active System')) ?>
                                    </div>
                                </td>

                                <!-- Actions Toolbar -->
                                <td>
                                    <div class="d-flex align-items-center justify-content-end gap-1">
                                        <!-- Quick Preview Modal Button -->
                                        <button type="button" 
                                            class="btn btn-sm btn-outline-info btn-action-icon btn-preview-project" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalProjectPreview"
                                            data-title="<?= htmlspecialchars($p['title']) ?>"
                                            data-category="<?= htmlspecialchars($p['category_label'] ?? $p['category']) ?>"
                                            data-host="<?= htmlspecialchars($p['mockup_host'] ?? '') ?>"
                                            data-problem="<?= htmlspecialchars($p['problem'] ?? '') ?>"
                                            data-solution="<?= htmlspecialchars($p['solution'] ?? '') ?>"
                                            data-metric="<?= htmlspecialchars((string)($p['metric'] ?? '')) ?>"
                                            data-stat1-val="<?= htmlspecialchars($p['stat_1_val'] ?? '') ?>"
                                            data-stat1-lbl="<?= htmlspecialchars($p['stat_1_lbl'] ?? '') ?>"
                                            data-stat2-val="<?= htmlspecialchars($p['stat_2_val'] ?? '') ?>"
                                            data-stat2-lbl="<?= htmlspecialchars($p['stat_2_lbl'] ?? '') ?>"
                                            data-stat3-val="<?= htmlspecialchars($p['stat_3_val'] ?? '') ?>"
                                            data-stat3-lbl="<?= htmlspecialchars($p['stat_3_lbl'] ?? '') ?>"
                                            data-live-url="<?= htmlspecialchars($p['live_url'] ?? '') ?>"
                                            data-tags='<?= json_encode($p['tags'] ?? []) ?>'
                                            title="Live Spec Preview">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <!-- Edit Project -->
                                        <a href="<?= admin_url('project-form?id=' . urlencode($p['id'])) ?>" class="btn btn-sm btn-outline-primary btn-action-icon" title="Edit Deliverable">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- Delete Modal Trigger -->
                                        <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-action-icon btn-delete-project"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalDeleteProject"
                                            data-id="<?= htmlspecialchars($p['id']) ?>"
                                            data-title="<?= htmlspecialchars($p['title']) ?>"
                                            title="Delete Project">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2 text-muted small" style="border-color: var(--cx-border) !important;">
                <div id="tableCounterText">
                    Showing <strong><?= $totalCount ?></strong> of <strong><?= $totalCount ?></strong> deliverables
                </div>
                <div class="d-flex align-items-center gap-1">
                    <span class="live-dot" style="width: 6px; height: 6px;"></span>
                    <span>All changes update instantly on public frontend.</span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- ======================================================== -->
    <!-- ADMIN CONSOLE ENTERPRISE FOOTER                          -->
    <!-- ======================================================== -->
    <footer class="admin-footer">
        <div class="row g-4 align-items-center">
            <!-- Brand & Scope -->
            <div class="col-12 col-md-5">
                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                    <img src="<?= asset('images/logo/logo.png') ?>" alt="CodeX404 Solutions" style="height: 30px; object-fit: contain;">
                    <span class="badge bg-dark border border-secondary text-info text-uppercase px-2 py-1" style="font-size: 0.65rem; letter-spacing: 0.08em;">
                        PORTFOLIO ADMIN
                    </span>
                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.68rem;">v14.2 Enterprise</span>
                </div>
                <p class="text-muted small mb-2" style="max-width: 440px;">
                    Production Deliverables &amp; Client Project Management Console. Real-time orchestration of verified enterprise systems, interactive sandboxes, and high-availability showcase specs.
                </p>
                <div class="d-flex align-items-center gap-3 text-muted small flex-wrap" style="font-size: 0.75rem;">
                    <span><i class="bi bi-shield-check text-success me-1"></i> Strict CSRF Protection</span>
                    <span>&bull;</span>
                    <span><i class="bi bi-speedometer2 text-info me-1"></i> 99.98% SLA Uptime</span>
                    <span>&bull;</span>
                    <span><i class="bi bi-hdd-network text-primary me-1"></i> Sub-100ms Edge</span>
                </div>
            </div>

            <!-- Telemetry Summary -->
            <div class="col-12 col-md-4">
                <div class="p-3 rounded-3" style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--cx-border);">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="small fw-bold text-uppercase text-muted" style="font-size: 0.68rem; letter-spacing: 0.06em;">Repository Status</span>
                        <span class="d-flex align-items-center gap-1 text-success small" style="font-size: 0.72rem;">
                            <span class="live-dot" style="width: 6px; height: 6px;"></span> Active Synchronization
                        </span>
                    </div>
                    <div class="row g-2 text-center" style="font-size: 0.75rem;">
                        <div class="col-4">
                            <div class="p-1 rounded bg-black-50 border border-secondary border-opacity-25">
                                <div class="fw-bold text-info"><?= $totalCount ?></div>
                                <div class="text-muted" style="font-size: 0.65rem;">Total Projects</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-1 rounded bg-black-50 border border-secondary border-opacity-25">
                                <div class="fw-bold text-success"><?= $activeCount ?></div>
                                <div class="text-muted" style="font-size: 0.65rem;">Published</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-1 rounded bg-black-50 border border-secondary border-opacity-25">
                                <div class="fw-bold text-warning"><?= $draftCount ?></div>
                                <div class="text-muted" style="font-size: 0.65rem;">In Review</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cross-Platform Navigation -->
            <div class="col-12 col-md-3 text-md-end">
                <div class="small fw-bold text-uppercase text-muted mb-2" style="font-size: 0.68rem; letter-spacing: 0.06em;">Platform Bridges</div>
                <div class="d-flex flex-column gap-1 align-items-md-end" style="font-size: 0.8rem;">
                    <a href="../../crm/" target="_blank" class="text-decoration-none text-warning d-inline-flex align-items-center gap-1">
                        <i class="bi bi-robot"></i> Company CRM &amp; Paperclip OS
                    </a>
                    <a href="<?= url('#work') ?>" target="_blank" class="text-decoration-none text-muted d-inline-flex align-items-center gap-1">
                        <i class="bi bi-box-arrow-up-right text-primary"></i> Public Portfolio Showcase
                    </a>
                    <a href="<?= url('discovery-call') ?>" target="_blank" class="text-decoration-none text-muted d-inline-flex align-items-center gap-1">
                        <i class="bi bi-lightning-charge text-info"></i> Client Discovery Intake Form
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Copyright & Security Notice -->
        <div class="pt-3 mt-3 border-top d-flex flex-wrap align-items-center justify-content-between gap-2" style="border-color: var(--cx-border) !important; font-size: 0.75rem;">
            <div class="text-muted">
                &copy; <?= date('Y') ?> <strong>CodeX404 Solutions</strong>. Enterprise Deliverables Admin Console &bull; Built with PHP 8.3 &bull; Bootstrap 5.3.3 &bull; All Rights Reserved.
            </div>
            <div class="d-flex align-items-center gap-3 text-muted flex-wrap">
                <span class="d-flex align-items-center gap-1"><i class="bi bi-database-check text-info"></i> Storage: JSON Data Store</span>
                <span>&bull;</span>
                <span class="d-flex align-items-center gap-1"><i class="bi bi-shield-lock text-success"></i> Active Session</span>
                <span>&bull;</span>
                <a href="<?= admin_url('logout') ?>" class="text-danger text-decoration-none fw-semibold"><i class="bi bi-box-arrow-left me-1"></i>Sign Out</a>
            </div>
        </div>
    </footer>

</main>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: PROJECT SPEC PREVIEW                              -->
<!-- ======================================================== -->
<div class="modal fade" id="modalProjectPreview" tabindex="-1" aria-labelledby="modalProjectPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-info-subtle text-info border border-info-subtle text-uppercase" id="previewCategory">Software</span>
                    <h5 class="modal-title fw-bold mb-0" id="previewTitle">Project Title</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Host preview banner -->
                <div class="p-3 rounded-3 mb-3 d-flex align-items-center justify-content-between" style="background: rgba(34, 211, 238, 0.05); border: 1px solid rgba(34, 211, 238, 0.2);">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-hdd-network text-info"></i>
                        <span class="small fw-bold text-muted">HOST:</span>
                        <code class="text-white" id="previewHost">app.system.online</code>
                    </div>
                    <a href="#" id="previewLiveLink" target="_blank" class="btn btn-xs btn-outline-info py-1 px-2" style="font-size: 0.75rem;">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Visit System
                    </a>
                </div>

                <!-- Problem Statement -->
                <div class="mb-3">
                    <h6 class="fw-bold small text-muted text-uppercase mb-1"><i class="bi bi-exclamation-circle text-warning me-1"></i> Client Challenge &amp; Problem</h6>
                    <p class="small text-muted p-3 rounded-3" style="background: rgba(0,0,0,0.1); border: 1px solid var(--cx-border);" id="previewProblem">-</p>
                </div>

                <!-- Engineering Solution -->
                <div class="mb-3">
                    <h6 class="fw-bold small text-muted text-uppercase mb-1"><i class="bi bi-gear-wide-connected text-primary me-1"></i> CodeX404 Engineering Solution</h6>
                    <p class="small text-muted p-3 rounded-3" style="background: rgba(0,0,0,0.1); border: 1px solid var(--cx-border);" id="previewSolution">-</p>
                </div>

                <!-- 3 Key Metric Cards -->
                <h6 class="fw-bold small text-muted text-uppercase mb-2"><i class="bi bi-speedometer2 text-success me-1"></i> Verified Performance Metrics</h6>
                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <div class="p-3 text-center rounded-3" style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.2);">
                            <div class="h4 fw-bold text-success mb-0" id="previewStat1Val">-</div>
                            <small class="text-muted" id="previewStat1Lbl">Metric 1</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 text-center rounded-3" style="background: rgba(56, 189, 248, 0.08); border: 1px solid rgba(56, 189, 248, 0.2);">
                            <div class="h4 fw-bold text-info mb-0" id="previewStat2Val">-</div>
                            <small class="text-muted" id="previewStat2Lbl">Metric 2</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-3 text-center rounded-3" style="background: rgba(168, 85, 247, 0.08); border: 1px solid rgba(168, 85, 247, 0.2);">
                            <div class="h4 fw-bold text-primary mb-0" id="previewStat3Val">-</div>
                            <small class="text-muted" id="previewStat3Lbl">Metric 3</small>
                        </div>
                    </div>
                </div>

                <!-- Tags Container -->
                <div>
                    <h6 class="fw-bold small text-muted text-uppercase mb-1">Architecture Tags</h6>
                    <div id="previewTags" class="d-flex flex-wrap gap-1"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: DELETE CONFIRMATION                               -->
<!-- ======================================================== -->
<div class="modal fade" id="modalDeleteProject" tabindex="-1" aria-labelledby="modalDeleteProjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-bottom border-danger-subtle">
                <h5 class="modal-title fw-bold text-danger d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p>Are you sure you want to permanently delete this deliverable from the CodeX404 website portfolio?</p>
                <div class="p-3 rounded-3 mb-2" style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25);">
                    <strong class="text-danger" id="deleteProjectTitle">Project Title</strong>
                    <div class="small text-muted" id="deleteProjectId">ID: project-id</div>
                </div>
                <small class="text-muted">This action cannot be undone. Public links to this showcase item will become 404.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <form method="POST" action="<?= admin_url('delete') ?>" id="deleteProjectForm">
                    <?= csrf_input_field() ?>
                    <input type="hidden" name="id" id="deleteProjectInputId" value="">
                    <button type="submit" class="btn btn-danger btn-sm fw-bold">
                        <i class="bi bi-trash3 me-1"></i> Delete Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5.3.3 Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // =========================================================
    // Real-Time Filter & Search
    // =========================================================
    const searchInput = document.getElementById('projectSearch');
    const statusPillBtns = document.querySelectorAll('.filter-pill-btn');
    const categoryFilter = document.getElementById('categoryFilter');
    const rows = document.querySelectorAll('.project-row');
    const counterText = document.getElementById('tableCounterText');

    let currentStatus = 'all';
    let currentCategory = 'all';

    function filterRows() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        let visibleCount = 0;

        rows.forEach(row => {
            const searchBlob = row.getAttribute('data-search') || '';
            const status = row.getAttribute('data-status') || '';
            const category = row.getAttribute('data-category') || '';

            const matchesQuery = query === '' || searchBlob.includes(query);
            const matchesStatus = currentStatus === 'all' || status === currentStatus;
            const matchesCategory = currentCategory === 'all' || category === currentCategory;

            if (matchesQuery && matchesStatus && matchesCategory) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (counterText) {
            counterText.innerHTML = `Showing <strong>${visibleCount}</strong> of <strong>${rows.length}</strong> deliverables`;
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterRows);
    }

    const sidebarStatusBtns = document.querySelectorAll('.sidebar-status-filter');

    statusPillBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            statusPillBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentStatus = this.getAttribute('data-filter-status') || 'all';

            // Sync sidebar active state
            sidebarStatusBtns.forEach(b => {
                b.classList.toggle('active', b.getAttribute('data-status-filter') === currentStatus);
            });

            filterRows();
        });
    });

    sidebarStatusBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetStatus = this.getAttribute('data-status-filter') || 'all';
            currentStatus = targetStatus;

            sidebarStatusBtns.forEach(b => {
                b.classList.toggle('active', b.getAttribute('data-status-filter') === targetStatus);
            });

            statusPillBtns.forEach(b => {
                b.classList.toggle('active', b.getAttribute('data-filter-status') === targetStatus);
            });

            filterRows();

            const tableEl = document.getElementById('portfolio-table');
            if (tableEl) {
                tableEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    if (categoryFilter) {
        categoryFilter.addEventListener('change', function () {
            currentCategory = this.value;
            filterRows();
        });
    }

    // =========================================================
    // Preview Modal Data Hydration
    // =========================================================
    document.querySelectorAll('.btn-preview-project').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('previewTitle').textContent = this.dataset.title || 'Project';
            document.getElementById('previewCategory').textContent = this.dataset.category || 'Software';
            document.getElementById('previewHost').textContent = this.dataset.host || 'system.codex404solutions.online';
            document.getElementById('previewProblem').textContent = this.dataset.problem || 'No description provided.';
            document.getElementById('previewSolution').textContent = this.dataset.solution || 'No solution recorded.';

            document.getElementById('previewStat1Val').textContent = this.dataset.stat1Val || '-';
            document.getElementById('previewStat1Lbl').textContent = this.dataset.stat1Lbl || 'Metric 1';
            document.getElementById('previewStat2Val').textContent = this.dataset.stat2Val || '-';
            document.getElementById('previewStat2Lbl').textContent = this.dataset.stat2Lbl || 'Metric 2';
            document.getElementById('previewStat3Val').textContent = this.dataset.stat3Val || '-';
            document.getElementById('previewStat3Lbl').textContent = this.dataset.stat3Lbl || 'Metric 3';

            const liveLink = document.getElementById('previewLiveLink');
            if (this.dataset.liveUrl) {
                liveLink.href = this.dataset.liveUrl;
                liveLink.classList.remove('d-none');
            } else {
                liveLink.classList.add('d-none');
            }

            const tagsContainer = document.getElementById('previewTags');
            tagsContainer.innerHTML = '';
            try {
                const tags = JSON.parse(this.dataset.tags || '[]');
                tags.forEach(t => {
                    const span = document.createElement('span');
                    span.className = 'badge bg-secondary-subtle text-muted border border-secondary-subtle';
                    span.textContent = t;
                    tagsContainer.appendChild(span);
                });
            } catch (e) {}
        });
    });

    // =========================================================
    // Delete Modal Hydration
    // =========================================================
    document.querySelectorAll('.btn-delete-project').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id || '';
            const title = this.dataset.title || '';
            document.getElementById('deleteProjectTitle').textContent = title;
            document.getElementById('deleteProjectId').textContent = 'ID: ' + id;
            document.getElementById('deleteProjectInputId').value = id;
        });
    });

    // =========================================================
    // Interactive Deliverables Slider Controller
    // =========================================================
    const sliderViewport = document.getElementById('deliverablesSliderViewport');
    const sliderTrack = document.getElementById('deliverablesSliderTrack');
    const prevBtn = document.getElementById('sliderPrevBtn');
    const nextBtn = document.getElementById('sliderNextBtn');
    const autoToggle = document.getElementById('sliderAutoToggle');
    const autoIcon = document.getElementById('sliderAutoIcon');
    const autoText = document.getElementById('sliderAutoText');
    const dotsContainer = document.getElementById('deliverablesSliderDots');

    if (sliderTrack && sliderViewport) {
        const cards = sliderTrack.querySelectorAll('.slider-card-item');
        let currentIndex = 0;
        let isAutoPlaying = true;
        let autoPlayTimer = null;

        const getItemsPerPage = () => {
            const w = window.innerWidth;
            if (w < 640) return 1;
            if (w < 1024) return 2;
            return 3;
        };

        const getMaxIndex = () => {
            const perPage = getItemsPerPage();
            return Math.max(0, cards.length - perPage);
        };

        const renderDots = () => {
            if (!dotsContainer) return;
            dotsContainer.innerHTML = '';
            const max = getMaxIndex();
            if (max <= 0) return;

            for (let i = 0; i <= max; i++) {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'slider-dot' + (i === currentIndex ? ' active' : '');
                dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
                dot.addEventListener('click', () => {
                    currentIndex = i;
                    updateSlider();
                    resetTimer();
                });
                dotsContainer.appendChild(dot);
            }
        };

        const updateSlider = () => {
            const max = getMaxIndex();
            if (currentIndex > max) currentIndex = max;
            if (currentIndex < 0) currentIndex = 0;

            const firstCard = cards[0];
            if (!firstCard) return;

            const cardWidth = firstCard.offsetWidth;
            const gap = 16; // 1rem gap
            const offset = currentIndex * (cardWidth + gap);
            sliderTrack.style.transform = `translateX(-${offset}px)`;

            if (dotsContainer) {
                const dots = dotsContainer.querySelectorAll('.slider-dot');
                dots.forEach((d, idx) => {
                    d.classList.toggle('active', idx === currentIndex);
                });
            }
        };

        const nextSlide = () => {
            const max = getMaxIndex();
            currentIndex = (currentIndex >= max) ? 0 : currentIndex + 1;
            updateSlider();
        };

        const prevSlide = () => {
            const max = getMaxIndex();
            currentIndex = (currentIndex <= 0) ? max : currentIndex - 1;
            updateSlider();
        };

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                resetTimer();
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                resetTimer();
            });
        }

        const startTimer = () => {
            if (autoPlayTimer) clearInterval(autoPlayTimer);
            if (isAutoPlaying && cards.length > getItemsPerPage()) {
                autoPlayTimer = setInterval(nextSlide, 4500);
            }
        };

        const resetTimer = () => {
            startTimer();
        };

        if (autoToggle) {
            autoToggle.addEventListener('click', () => {
                isAutoPlaying = !isAutoPlaying;
                if (isAutoPlaying) {
                    if (autoIcon) autoIcon.className = 'bi bi-pause-fill';
                    if (autoText) autoText.textContent = 'Pause Slider';
                    startTimer();
                } else {
                    if (autoIcon) autoIcon.className = 'bi bi-play-fill';
                    if (autoText) autoText.textContent = 'Play Slider';
                    if (autoPlayTimer) clearInterval(autoPlayTimer);
                }
            });
        }

        sliderViewport.addEventListener('mouseenter', () => {
            if (autoPlayTimer) clearInterval(autoPlayTimer);
        });

        sliderViewport.addEventListener('mouseleave', () => {
            if (isAutoPlaying) startTimer();
        });

        // Touch & Swipe gestures for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        sliderViewport.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        sliderViewport.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 40) {
                if (diff > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
                resetTimer();
            }
        }, { passive: true });

        renderDots();
        updateSlider();
        startTimer();

        window.addEventListener('resize', () => {
            renderDots();
            updateSlider();
        });
    }

    // =========================================================
    // Theme Switcher (Combo, Dark, Light, Auto)
    // =========================================================
    const getStoredTheme = () => localStorage.getItem('codex_admin_theme');
    const setStoredTheme = theme => localStorage.setItem('codex_admin_theme', theme);
    const getPreferredTheme = () => {
        const storedTheme = getStoredTheme();
        if (storedTheme) return storedTheme;
        return 'combo';
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

        const textEl = document.getElementById('bd-theme-admin-text');
        const iconEl = document.querySelector('#bd-theme-admin .theme-icon-active');
        if (textEl) textEl.textContent = label;
        if (iconEl) iconEl.className = iconClass;

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
});
</script>

</body>
</html>
