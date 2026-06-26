<!doctype html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Mahasiswa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;450;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        // Prevent FOUC - set theme before render
        (function() {
            const stored = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = stored || (prefersDark ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    <style>
        /* ===== LIGHT MODE (default) ===== */
        :root,
        [data-theme="light"] {
            --bg: #ffffff;
            --bg-secondary: #fafafa;
            --bg-tertiary: #f4f4f5;
            --bg-elevated: #ffffff;
            --bg-sidebar: #ffffff;
            --bg-navbar: rgba(255, 255, 255, 0.8);
            --bg-hover: #f4f4f5;
            --bg-active: #f0f0f0;
            --bg-code: #f6f8fa;

            --foreground: #171717;
            --foreground-secondary: #666666;
            --foreground-tertiary: #8f8f8f;
            --foreground-muted: #b4b4b4;

            --border: #eaeaea;
            --border-secondary: #f0f0f0;
            --border-hover: #c9c9c9;

            --accent: #0070f3;
            --accent-hover: #0060df;
            --accent-bg: #0070f317;

            --success: #10b981;
            --success-bg: #10b98117;
            --success-border: #10b98133;

            --error: #ee0000;
            --error-bg: #ee000017;
            --error-border: #ee000033;

            --warning: #f59e0b;
            --warning-bg: #f59e0b17;
            --warning-border: #f59e0b33;

            --info: #3b82f6;
            --info-bg: #3b82f617;

            --shadow-xs: 0 1px 2px rgba(0,0,0,0.04);
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.06);
            --shadow-lg: 0 8px 24px rgba(0,0,0,0.08);

            --gradient-brand: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
            --gradient-warning: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --gradient-danger: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            --gradient-info: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            --gradient-purple: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            --gradient-pink: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        }

        /* ===== DARK MODE ===== */
        [data-theme="dark"] {
            --bg: #0a0a0a;
            --bg-secondary: #0f0f0f;
            --bg-tertiary: #1a1a1a;
            --bg-elevated: #111111;
            --bg-sidebar: #0a0a0a;
            --bg-navbar: rgba(10, 10, 10, 0.8);
            --bg-hover: #1a1a1a;
            --bg-active: #222222;
            --bg-code: #1a1a1a;

            --foreground: #ededed;
            --foreground-secondary: #a1a1a1;
            --foreground-tertiary: #737373;
            --foreground-muted: #525252;

            --border: #262626;
            --border-secondary: #1f1f1f;
            --border-hover: #404040;

            --accent: #0070f3;
            --accent-hover: #1a84ff;
            --accent-bg: #0070f320;

            --success: #10b981;
            --success-bg: #10b98120;
            --success-border: #10b98140;

            --error: #f87171;
            --error-bg: #ee000020;
            --error-border: #ee000040;

            --warning: #fbbf24;
            --warning-bg: #f59e0b20;
            --warning-border: #f59e0b40;

            --info: #60a5fa;
            --info-bg: #3b82f620;

            --shadow-xs: 0 1px 2px rgba(0,0,0,0.3);
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.4);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.5);
            --shadow-lg: 0 8px 24px rgba(0,0,0,0.6);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--bg);
            color: var(--foreground);
            font-size: 14px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            font-feature-settings: "cv11", "ss01";
            font-variation-settings: "opsz" 32;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* ===== FADE IN ANIMATION ===== */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(16px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 0 0 var(--accent-bg); }
            50% { box-shadow: 0 0 0 8px rgba(0, 112, 243, 0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            height: 100vh;
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border);
            position: fixed;
            width: 260px;
            top: 0;
            left: 0;
            padding: 20px 12px;
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 3px;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 12px 20px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 12px;
            text-decoration: none;
            color: var(--foreground);
            transition: opacity 0.2s ease;
        }

        .sidebar-brand:hover {
            opacity: 0.8;
        }

        .sidebar-brand-icon {
            width: 32px;
            height: 32px;
            background: var(--foreground);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .sidebar-brand:hover .sidebar-brand-icon {
            transform: rotate(-5deg) scale(1.05);
        }

        .sidebar-brand-icon svg {
            color: var(--bg);
            width: 16px;
            height: 16px;
        }

        .sidebar-brand-text {
            font-weight: 600;
            font-size: 15px;
            letter-spacing: -0.02em;
        }

        .sidebar-section {
            padding: 8px 0;
        }

        .sidebar-section-title {
            font-size: 11px;
            font-weight: 600;
            color: var(--foreground-tertiary);
            padding: 4px 12px 8px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .sidebar a {
            color: var(--foreground-secondary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 6px;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 450;
            margin-bottom: 2px;
            position: relative;
        }

        .sidebar a:hover {
            background: var(--bg-hover);
            color: var(--foreground);
            transform: translateX(2px);
        }

        .sidebar a.active {
            background: var(--bg-tertiary);
            color: var(--foreground);
            font-weight: 500;
        }

        .sidebar a.active::before {
            content: '';
            position: absolute;
            left: -12px;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: var(--foreground);
            border-radius: 0 3px 3px 0;
        }

        .sidebar a i,
        .sidebar a svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }

        .sidebar a:hover svg {
            transform: scale(1.1);
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid var(--border);
        }

        .sidebar-footer a {
            color: var(--foreground-tertiary);
        }

        .sidebar-footer a:hover {
            color: var(--error);
            background: var(--error-bg);
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* ===== NAVBAR ===== */
        .navbar-custom {
            background: var(--bg-navbar);
            border-bottom: 1px solid var(--border);
            padding: 12px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: saturate(180%) blur(16px);
            -webkit-backdrop-filter: saturate(180%) blur(16px);
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .navbar-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--foreground);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-title .avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--gradient-brand);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 12px;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
            background: var(--bg-tertiary);
            color: var(--foreground-secondary);
            border: 1px solid var(--border);
            gap: 6px;
        }

        /* ===== THEME TOGGLE ===== */
        .theme-toggle {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--bg);
            color: var(--foreground-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .theme-toggle:hover {
            background: var(--bg-hover);
            color: var(--foreground);
            border-color: var(--border-hover);
            transform: rotate(15deg);
        }

        .theme-toggle svg {
            width: 16px;
            height: 16px;
            transition: transform 0.4s ease;
        }

        [data-theme="light"] .theme-toggle .icon-moon { display: block; }
        [data-theme="light"] .theme-toggle .icon-sun { display: none; }
        [data-theme="dark"] .theme-toggle .icon-moon { display: none; }
        [data-theme="dark"] .theme-toggle .icon-sun { display: block; }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            padding: 32px;
            max-width: 1280px;
            margin: 0 auto;
            animation: fadeIn 0.4s ease-out;
        }

        .page-header {
            margin-bottom: 32px;
            animation: fadeIn 0.5s ease-out;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--foreground);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header h1 .icon-wrapper {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
        }

        .page-header h1 .icon-wrapper svg {
            width: 18px;
            height: 18px;
        }

        .page-header p {
            color: var(--foreground-secondary);
            font-size: 15px;
            margin-left: 48px;
        }

        /* ===== CARDS ===== */
        .card {
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .card:hover {
            border-color: var(--border-hover);
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            font-weight: 500;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg-secondary);
        }

        .card-header svg {
            width: 16px;
            height: 16px;
            color: var(--foreground-secondary);
        }

        .card-body {
            padding: 20px;
        }

        /* ===== STAT CARDS ===== */
        .stat-card {
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
            animation: slideInRight 0.4s ease-out;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--card-accent, var(--gradient-info));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card.accent-blue { --card-accent: var(--gradient-info); }
        .stat-card.accent-green { --card-accent: var(--gradient-success); }
        .stat-card.accent-orange { --card-accent: var(--gradient-warning); }
        .stat-card.accent-purple { --card-accent: var(--gradient-purple); }
        .stat-card.accent-red { --card-accent: var(--gradient-danger); }
        .stat-card.accent-pink { --card-accent: var(--gradient-pink); }

        .stat-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .stat-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover .stat-card-icon {
            transform: scale(1.1) rotate(-5deg);
        }

        .stat-card-icon svg {
            width: 20px;
            height: 20px;
            color: #fff;
        }

        .stat-card-icon.blue { background: var(--gradient-info); }
        .stat-card-icon.green { background: var(--gradient-success); }
        .stat-card-icon.orange { background: var(--gradient-warning); }
        .stat-card-icon.purple { background: var(--gradient-purple); }
        .stat-card-icon.red { background: var(--gradient-danger); }
        .stat-card-icon.pink { background: var(--gradient-pink); }

        .stat-card-trend {
            display: inline-flex;
            align-items: center;
            gap: 2px;
            font-size: 12px;
            font-weight: 500;
            padding: 2px 8px;
            border-radius: 6px;
        }

        .stat-card-trend.up {
            background: var(--success-bg);
            color: var(--success);
        }

        .stat-card-trend svg {
            width: 12px;
            height: 12px;
        }

        .stat-card-label {
            font-size: 13px;
            color: var(--foreground-secondary);
            margin-bottom: 4px;
            font-weight: 500;
        }

        .stat-card-value {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.04em;
            color: var(--foreground);
            line-height: 1.1;
        }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            border: 1px solid var(--border);
            background: var(--bg);
            color: var(--foreground);
            line-height: 1.4;
            white-space: nowrap;
            position: relative;
            overflow: hidden;
        }

        .btn:hover {
            background: var(--bg-hover);
            border-color: var(--border-hover);
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn svg {
            width: 14px;
            height: 14px;
            transition: transform 0.2s ease;
        }

        .btn:hover svg {
            transform: translateX(1px);
        }

        .btn-primary {
            background: var(--foreground);
            color: var(--bg);
            border-color: var(--foreground);
        }

        .btn-primary:hover {
            opacity: 0.9;
            background: var(--foreground);
            border-color: var(--foreground);
        }

        .btn-success {
            background: var(--gradient-success);
            color: #fff;
            border-color: transparent;
        }

        .btn-success:hover {
            filter: brightness(1.05);
            background: var(--gradient-success);
            border-color: transparent;
        }

        .btn-danger {
            background: var(--bg);
            color: var(--error);
            border-color: var(--error-border);
        }

        .btn-danger:hover {
            background: var(--error-bg);
            border-color: var(--error);
        }

        .btn-warning {
            background: var(--bg);
            color: var(--warning);
            border-color: var(--warning-border);
        }

        .btn-warning:hover {
            background: var(--warning-bg);
            border-color: var(--warning);
        }

        .btn-accent {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }

        .btn-accent:hover {
            background: var(--accent-hover);
            border-color: var(--accent-hover);
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 13px;
            border-radius: 6px;
        }

        .btn-sm svg {
            width: 13px;
            height: 13px;
        }

        /* ===== TABLES ===== */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            padding: 12px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: var(--foreground-tertiary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            border-bottom: 1px solid var(--border);
            background: var(--bg-secondary);
        }

        table tbody td {
            padding: 14px 16px;
            font-size: 14px;
            border-bottom: 1px solid var(--border);
            color: var(--foreground);
            transition: background-color 0.15s ease;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        table tbody tr {
            transition: background-color 0.15s ease;
        }

        table tbody tr:hover td {
            background: var(--bg-hover);
        }

        /* ===== FORMS ===== */
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--foreground);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-label svg {
            width: 14px;
            height: 14px;
            color: var(--foreground-secondary);
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: var(--foreground);
            background: var(--bg);
            transition: all 0.2s ease;
            outline: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--foreground);
            box-shadow: 0 0 0 3px var(--bg-tertiary);
        }

        .form-control::placeholder {
            color: var(--foreground-muted);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        small, .form-text {
            font-size: 12px;
            color: var(--foreground-tertiary);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        small svg, .form-text svg {
            width: 12px;
            height: 12px;
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 14px 16px;
            border-radius: 10px;
            font-size: 14px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 24px;
            border: 1px solid;
            animation: fadeIn 0.3s ease-out;
        }

        .alert svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .alert-success {
            background: var(--success-bg);
            border-color: var(--success-border);
            color: var(--success);
        }

        .alert-danger {
            background: var(--error-bg);
            border-color: var(--error-border);
            color: var(--error);
        }

        .alert-info {
            background: var(--info-bg);
            border-color: var(--info);
            color: var(--info);
        }

        .alert-warning {
            background: var(--warning-bg);
            border-color: var(--warning-border);
            color: var(--warning);
        }

        .alert ul {
            margin: 0;
            padding-left: 16px;
        }

        /* ===== GRID ===== */
        .grid {
            display: grid;
            gap: 16px;
        }

        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }

        @media (max-width: 1024px) {
            .grid-3, .grid-4 { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .page-content { padding: 20px 16px; }
            .page-header h1 { font-size: 22px; }
            .page-header p { margin-left: 0; }
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .navbar-custom { padding: 12px 16px; }
        }

        /* ===== UTILITIES ===== */
        .d-flex { display: flex; }
        .align-items-center { align-items: center; }
        .justify-content-between { justify-content: space-between; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .gap-4 { gap: 16px; }
        .mb-3 { margin-bottom: 16px; }
        .mb-4 { margin-bottom: 24px; }
        .mb-6 { margin-bottom: 32px; }
        .mt-3 { margin-top: 16px; }
        .text-center { text-align: center; }
        .text-muted { color: var(--foreground-tertiary) !important; }
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }

        /* ===== BADGE ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid var(--border);
            background: var(--bg-secondary);
            color: var(--foreground-secondary);
            font-variant-numeric: tabular-nums;
        }

        .badge svg {
            width: 12px;
            height: 12px;
        }

        .badge-success {
            background: var(--success-bg);
            border-color: var(--success-border);
            color: var(--success);
        }

        .badge-info {
            background: var(--info-bg);
            color: var(--info);
            border-color: transparent;
        }

        .badge-warning {
            background: var(--warning-bg);
            color: var(--warning);
            border-color: var(--warning-border);
        }

        .badge-danger {
            background: var(--error-bg);
            color: var(--error);
            border-color: var(--error-border);
        }

        /* ===== LINKS ===== */
        a.link {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: color 0.2s ease;
        }

        a.link:hover {
            color: var(--accent-hover);
            text-decoration: underline;
        }

        a.link svg {
            width: 13px;
            height: 13px;
            transition: transform 0.2s ease;
        }

        a.link:hover svg {
            transform: translate(2px, -2px);
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            padding: 56px 20px;
            text-align: center;
            color: var(--foreground-tertiary);
        }

        .empty-state-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            background: var(--bg-tertiary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            border: 1px solid var(--border);
        }

        .empty-state-icon svg {
            width: 28px;
            height: 28px;
            opacity: 0.6;
        }

        .empty-state h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--foreground);
            margin-bottom: 4px;
        }

        .empty-state p {
            font-size: 14px;
            color: var(--foreground-secondary);
        }

        /* ===== CLASS CARD ===== */
        .class-card {
            background: var(--bg-elevated);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .class-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle at top right, var(--card-accent, var(--info-bg)), transparent 70%);
            opacity: 0.6;
            transition: opacity 0.3s ease;
        }

        .class-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .class-card:hover::after {
            opacity: 1;
        }

        .class-card-header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
        }

        .class-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .class-card-icon svg {
            width: 20px;
            height: 20px;
            color: #fff;
        }

        .class-card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--foreground);
            margin-bottom: 2px;
            letter-spacing: -0.01em;
        }

        .class-card-subtitle {
            font-size: 13px;
            color: var(--foreground-secondary);
        }

        .class-card-body {
            position: relative;
            z-index: 1;
        }

        /* ===== NOTIFICATION ITEM ===== */
        .notification-item {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: flex-start;
            gap: 12px;
            transition: background-color 0.15s ease;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item:hover {
            background: var(--bg-hover);
        }

        .notification-item.unread {
            background: var(--info-bg);
        }

        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-icon svg {
            width: 18px;
            height: 18px;
            color: #fff;
        }

        .notification-content {
            flex: 1;
        }

        .notification-message {
            font-size: 14px;
            color: var(--foreground);
            margin-bottom: 4px;
        }

        .notification-time {
            font-size: 12px;
            color: var(--foreground-tertiary);
        }

        .notification-badge {
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            background: var(--accent);
            color: #fff;
        }

        /* ===== PROFILE CARD ===== */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 32px;
            padding: 24px;
            background: var(--bg-secondary);
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--border);
            box-shadow: var(--shadow-md);
        }

        .profile-info h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 4px;
            letter-spacing: -0.02em;
        }

        .profile-info p {
            color: var(--foreground-secondary);
            font-size: 14px;
        }

        /* ===== MOBILE MENU ===== */
        .mobile-menu-toggle {
            display: none;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--bg);
            color: var(--foreground);
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .mobile-menu-toggle svg {
            width: 18px;
            height: 18px;
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
            }
        }

        /* ===== TOOLTIP ===== */
        [data-tooltip] {
            position: relative;
        }

        [data-tooltip]::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: calc(100% + 6px);
            left: 50%;
            transform: translateX(-50%);
            padding: 4px 8px;
            background: var(--foreground);
            color: var(--bg);
            border-radius: 6px;
            font-size: 11px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            z-index: 1000;
        }

        [data-tooltip]:hover::after {
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('mahasiswa.dashboard') }}" class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i data-lucide="graduation-cap"></i>
            </div>
            <span class="sidebar-brand-text">LMS Mahasiswa</span>
        </a>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Menu Utama</div>
            <a href="{{ route('mahasiswa.dashboard') }}" class="{{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}" data-tooltip="Ringkasan aktivitas">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('mahasiswa.matakuliah.index') }}" class="{{ request()->routeIs('mahasiswa.matakuliah*') ? 'active' : '' }}" data-tooltip="Mata kuliah yang diambil">
                <i data-lucide="book-open"></i>
                <span>Mata Kuliah</span>
            </a>
            <a href="{{ route('mahasiswa.tugas.index') }}" class="{{ request()->routeIs('mahasiswa.tugas*') ? 'active' : '' }}" data-tooltip="Daftar tugas">
                <i data-lucide="clipboard-list"></i>
                <span>Tugas</span>
            </a>
            <a href="{{ route('mahasiswa.nilai.index') }}" class="{{ request()->routeIs('mahasiswa.nilai*') ? 'active' : '' }}" data-tooltip="Nilai tugas">
                <i data-lucide="star"></i>
                <span>Nilai</span>
            </a>
            <a href="{{ route('mahasiswa.jadwal.index') }}" class="{{ request()->routeIs('mahasiswa.jadwal*') ? 'active' : '' }}" data-tooltip="Jadwal kuliah">
                <i data-lucide="calendar"></i>
                <span>Jadwal</span>
            </a>
            <a href="{{ route('mahasiswa.absensi.index') }}" class="{{ request()->routeIs('mahasiswa.absensi*') ? 'active' : '' }}" data-tooltip="Riwayat absensi">
                <i data-lucide="calendar-check"></i>
                <span>Absensi</span>
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Akun</div>
            <a href="{{ route('mahasiswa.profil') }}" class="{{ request()->routeIs('mahasiswa.profil*') ? 'active' : '' }}" data-tooltip="Profil saya">
                <i data-lucide="user"></i>
                <span>Profil</span>
            </a>
            {{-- <a href="{{ route('mahasiswa.notifikasi.index') }}" class="{{ request()->routeIs('mahasiswa.notifikasi*') ? 'active' : '' }}" data-tooltip="Notifikasi">
                <i data-lucide="bell"></i>
                <span>Notifikasi</span>
                @if(Auth::guard('mahasiswa')->user()->notifikasi()->where('status_baca', 'belum')->count() > 0)
                    <span style="margin-left:auto;background:var(--error);color:#fff;padding:2px 6px;border-radius:10px;font-size:10px;font-weight:600;">
                        {{ Auth::guard('mahasiswa')->user()->notifikasi()->where('status_baca', 'belum')->count() }}
                    </span>
                @endif
            </a> --}}
            
        </div>

        <div class="sidebar-footer">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i data-lucide="log-out"></i>
                <span>Keluar</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <nav class="navbar-custom">
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
                    <i data-lucide="menu"></i>
                </button>
                <div class="navbar-title">
                    <div class="avatar">
                        {{ strtoupper(substr(Auth::guard('mahasiswa')->user()->nama_mahasiswa, 0, 1)) }}
                    </div>
                    <span>{{ Auth::guard('mahasiswa')->user()->nama_mahasiswa }}</span>
                </div>
            </div>
            <div class="navbar-actions">
                <div class="navbar-badge">
                    <i data-lucide="hash" style="width:12px;height:12px;"></i>
                    {{ Auth::guard('mahasiswa')->user()->nim }}
                </div>
                <button class="theme-toggle" id="themeToggle" data-tooltip="Ganti tema" onclick="toggleTheme()">
                    <i data-lucide="moon" class="icon-moon"></i>
                    <i data-lucide="sun" class="icon-sun"></i>
                </button>
            </div>
        </nav>

        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i data-lucide="check-circle-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i data-lucide="alert-triangle"></i>
                    <div>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        // Initialize icons
        lucide.createIcons();

        // Theme toggle logic
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            // Re-render icons
            lucide.createIcons();
        }

        // Re-init icons when theme changes to update sun/moon
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });

        // Close sidebar on outside click (mobile)
        document.addEventListener('click', (e) => {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-menu-toggle');
            if (window.innerWidth <= 768 && sidebar.classList.contains('open')) {
                if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            }
        });
    </script>
</body>
</html>