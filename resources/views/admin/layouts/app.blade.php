<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Biye Marriage Media Admin Portal</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('site-logo/marriage-logo.jpeg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('site-logo/marriage-logo.jpeg') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --theme-primary: {{ site_setting('theme_primary', '#851829') }};
            --theme-primary-rgb: {{ site_setting_rgb('theme_primary', '#851829') }};
            --theme-secondary: {{ site_setting('theme_secondary', '#c99738') }};
            --theme-secondary-rgb: {{ site_setting_rgb('theme_secondary', '#c99738') }};
            --theme-accent: {{ site_setting('theme_accent', '#121620') }};
            --theme-accent-rgb: {{ site_setting_rgb('theme_accent', '#121620') }};

            --admin-bg: #0b0f17;
            --sidebar-bg: #111622;
            --topbar-bg: rgba(17, 22, 34, 0.88);
            --card-bg: #141820;
            --card-surface: #171c26;
            --accent-gold: var(--theme-secondary);
            --accent-gold-hover: #f5d061;
            --gold-light: #fde68a;
            --text-main: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted-custom: #94a3b8;
            --border-card: rgba(255, 255, 255, 0.08);
            --border-gold: rgba(var(--theme-secondary-rgb), 0.35);
            --sidebar-width: 265px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif;
            background-color: var(--admin-bg);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ================= SIDEBAR ================= */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: #111622;
            background: linear-gradient(180deg, #131824 0%, #0d1117 100%);
            border-right: 1px solid var(--border-card);
            height: 100vh;
            height: 100dvh;
            max-height: 100vh;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1030;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            padding: 1.35rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            border-bottom: 1px solid var(--border-card);
            text-decoration: none;
            background: rgba(13, 17, 23, 0.7);
            flex-shrink: 0;
        }

        .sidebar-brand img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 2px solid var(--accent-gold);
            object-fit: cover;
            box-shadow: 0 0 12px rgba(var(--theme-secondary-rgb), 0.35);
        }

        .sidebar-brand .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem;
            font-weight: 700;
            color: #f8fafc;
            line-height: 1.2;
            letter-spacing: 0.3px;
        }

        .sidebar-brand .brand-sub {
            font-size: 0.68rem;
            color: var(--accent-gold);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 1rem 0.85rem;
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.12) transparent;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(var(--theme-secondary-rgb), 0.45);
        }

        .nav-category {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 1.6px;
            color: var(--accent-gold);
            padding: 1rem 0.75rem 0.35rem;
            font-weight: 700;
            opacity: 0.95;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 0.95rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
            transition: all 0.2s ease;
            position: relative;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            color: var(--accent-gold);
            transition: transform 0.2s ease, color 0.2s ease;
            width: 20px;
            text-align: center;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.07);
            color: #ffffff;
        }

        .sidebar-link:hover i {
            color: #ffffff;
            transform: scale(1.1);
        }

        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(var(--theme-secondary-rgb), 0.18) 0%, rgba(var(--theme-secondary-rgb), 0.04) 100%);
            color: #ffffff;
            font-weight: 600;
            border-left: 3px solid var(--accent-gold);
        }

        .sidebar-link.active i {
            color: var(--accent-gold);
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--border-card);
            background: rgba(13, 17, 23, 0.75);
            flex-shrink: 0;
        }

        /* ================= MAIN CONTENT WRAPPER ================= */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        /* ================= TOP HEADER ================= */
        .admin-topbar {
            background: var(--topbar-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-card);
            padding: 0.75rem 1.75rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .topbar-date {
            color: var(--text-muted-custom);
            font-size: 0.8rem;
            font-weight: 400;
        }

        /* Circular Earth / Globe Site Visit Button */
        .btn-earth-visit {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(var(--theme-secondary-rgb), 0.12);
            border: 1px solid var(--border-gold);
            color: var(--accent-gold);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .btn-earth-visit:hover {
            background: linear-gradient(135deg, var(--accent-gold) 0%, #a17822 100%);
            color: #0b0f17;
            border-color: var(--accent-gold);
            transform: scale(1.08) rotate(15deg);
            box-shadow: 0 0 16px rgba(var(--theme-secondary-rgb), 0.5);
        }

        /* Profile Dropdown Button */
        .admin-profile-btn {
            background: #141820;
            border: 1px solid var(--border-card);
            border-radius: 40px;
            padding: 0.35rem 0.9rem 0.35rem 0.4rem;
            color: #f8fafc;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .admin-profile-btn:hover, .admin-profile-btn[aria-expanded="true"] {
            background: #171c26;
            border-color: var(--border-gold);
            color: #ffffff;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-gold) 0%, #a17822 100%);
            color: #0b0f17;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            box-shadow: 0 0 8px rgba(var(--theme-secondary-rgb), 0.3);
        }

        .user-name-text {
            font-size: 0.86rem;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.2;
        }

        .user-status-text {
            font-size: 0.7rem;
            color: #34d399;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-weight: 500;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #10b981;
            display: inline-block;
            box-shadow: 0 0 6px #10b981;
        }

        /* Admin Dropdown Menu */
        .admin-dropdown-menu {
            background: #141820;
            border: 1px solid var(--border-card);
            border-radius: 14px;
            padding: 0.65rem 0;
            min-width: 240px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.7);
            margin-top: 0.6rem !important;
        }

        .dropdown-header-custom {
            padding: 0.6rem 1.25rem 0.75rem;
            border-bottom: 1px solid var(--border-card);
        }

        .dropdown-header-custom .name {
            font-weight: 600;
            color: #f8fafc;
            font-size: 0.9rem;
        }

        .dropdown-header-custom .email {
            font-size: 0.76rem;
            color: var(--accent-gold);
        }

        .admin-dropdown-menu .dropdown-item {
            padding: 0.6rem 1.25rem;
            color: var(--text-secondary);
            font-size: 0.86rem;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            transition: all 0.15s ease;
        }

        .admin-dropdown-menu .dropdown-item:hover {
            background: rgba(var(--theme-secondary-rgb), 0.12);
            color: #ffffff;
        }

        .admin-dropdown-menu .dropdown-item.text-danger {
            color: #f87171 !important;
        }

        .admin-dropdown-menu .dropdown-item.text-danger:hover {
            background: rgba(220, 53, 69, 0.2);
            color: #ffffff !important;
        }

        .admin-dropdown-menu .dropdown-divider {
            border-top-color: var(--border-card);
            margin: 0.4rem 0;
        }

        .sidebar-toggle-btn {
            background: #141820;
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: var(--accent-gold);
            border-radius: 8px;
            padding: 0.35rem 0.65rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .sidebar-toggle-btn:hover {
            background: #171c26;
            border-color: var(--accent-gold);
            color: #ffffff;
        }

        .text-gold {
            color: var(--accent-gold) !important;
        }
        .text-silver {
            color: var(--text-secondary) !important;
        }

        /* ================= CARDS & UI ELEMENTS ================= */
        .admin-card {
            background: var(--card-bg);
            border: 1px solid var(--border-card);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            transition: border-color 0.2s ease, transform 0.2s ease;
        }

        .admin-card:hover {
            border-color: rgba(212, 175, 55, 0.3);
        }

        .admin-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            border-bottom: 1px solid var(--border-card);
            padding-bottom: 0.85rem;
        }

        /* Text readability utility classes */
        .text-clean-muted {
            color: var(--text-muted-custom) !important;
        }

        .text-clean-light {
            color: var(--text-secondary) !important;
        }

        .text-clean-white {
            color: #ffffff !important;
        }

        .text-clean-gold {
            color: var(--gold-light) !important;
        }

        /* ================= EXECUTIVE ADMIN BUTTONS ================= */
        .btn-admin-primary {
            background: linear-gradient(135deg, var(--accent-gold) 0%, #a17822 100%) !important;
            color: #0b0f17 !important;
            border: 1px solid #fde68a !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 14px rgba(var(--theme-secondary-rgb), 0.4);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-admin-primary:hover {
            background: linear-gradient(135deg, #fde68a 0%, var(--accent-gold) 100%) !important;
            color: #000000 !important;
            border-color: #ffffff !important;
            transform: translateY(-1.5px);
            box-shadow: 0 6px 20px rgba(var(--theme-secondary-rgb), 0.6);
        }
        .btn-admin-primary:active {
            transform: translateY(0);
        }

        .btn-admin-cancel {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%) !important;
            color: #ffffff !important;
            border: 1px solid #ef4444 !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.4);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-admin-cancel:hover {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            color: #ffffff !important;
            border-color: #fca5a5 !important;
            transform: translateY(-1.5px);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.6);
        }
        .btn-admin-cancel:active {
            transform: translateY(0);
        }

        /* Action Icon Buttons: Edit & Delete */
        .btn-action-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }
        .btn-action-icon.edit {
            background: var(--theme-secondary, #d4af37);
            color: #0b0f17 !important;
            border: 1px solid #f5d061;
            box-shadow: 0 2px 8px rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.3);
        }
        .btn-action-icon.edit:hover {
            background: #f5d061;
            color: #000000 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(212, 175, 55, 0.55);
        }
        .btn-action-icon.view {
            background: rgba(59, 130, 246, 0.2);
            border: 1px solid rgba(59, 130, 246, 0.45);
            color: #60a5fa !important;
        }
        .btn-action-icon.view:hover {
            background: #2563eb;
            color: #ffffff !important;
            border-color: #3b82f6 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.45);
        }
        .btn-action-icon.delete {
            background: rgba(220, 38, 38, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.55) !important;
            color: #fca5a5 !important;
        }
        .btn-action-icon.delete:hover {
            background: #dc2626;
            color: #ffffff !important;
            border-color: #ef4444 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.55);
        }

        /* ================= EXECUTIVE TOAST NOTIFICATIONS ================= */
        .admin-toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            pointer-events: none;
        }
        .admin-toast {
            pointer-events: auto;
            background: #141820;
            border-radius: 14px;
            min-width: 320px;
            max-width: 440px;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.7);
            animation: toastSlideIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            transition: opacity 0.4s ease, transform 0.4s ease;
        }
        .admin-toast.toast-success {
            border: 1px solid rgba(34, 197, 94, 0.5);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.7), 0 0 20px rgba(34, 197, 94, 0.25);
        }
        .admin-toast.toast-error {
            border: 1px solid rgba(239, 68, 68, 0.5);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.7), 0 0 20px rgba(239, 68, 68, 0.25);
        }
        .admin-toast.toast-info {
            border: 1px solid rgba(14, 165, 233, 0.5);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.7), 0 0 20px rgba(14, 165, 233, 0.25);
        }
        .admin-toast-body {
            display: flex;
            align-items: center;
            padding: 0.95rem 1.15rem;
            gap: 0.85rem;
        }
        .admin-toast-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .toast-success .admin-toast-icon {
            background: rgba(34, 197, 94, 0.18);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.35);
        }
        .toast-error .admin-toast-icon {
            background: rgba(239, 68, 68, 0.18);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.35);
        }
        .toast-info .admin-toast-icon {
            background: rgba(14, 165, 233, 0.18);
            color: #0ea5e9;
            border: 1px solid rgba(14, 165, 233, 0.35);
        }
        .admin-toast-content {
            flex-grow: 1;
        }
        .admin-toast-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 0.15rem;
        }
        .admin-toast-message {
            font-size: 0.8rem;
            color: #cbd5e1;
            line-height: 1.4;
            margin-bottom: 0;
        }
        .admin-toast-close {
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.1rem;
            cursor: pointer;
            padding: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease;
        }
        .admin-toast-close:hover {
            color: #ffffff;
        }
        .toast-progress-track {
            height: 3px;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
        }
        .toast-progress-bar {
            height: 100%;
            width: 100%;
            animation: toastCountdown 5s linear forwards;
        }
        .toast-success .toast-progress-bar {
            background: #22c55e;
        }
        .toast-error .toast-progress-bar {
            background: #ef4444;
        }
        .toast-info .toast-progress-bar {
            background: #0ea5e9;
        }
        @keyframes toastCountdown {
            from { width: 100%; }
            to { width: 0%; }
        }
        @keyframes toastSlideIn {
            from {
                opacity: 0;
                transform: translateX(40px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        /* Responsive Breakpoints */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
                box-shadow: 0 0 40px rgba(0, 0, 0, 0.8);
            }
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- Brand Header -->
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('site-logo/marriage-logo.jpeg') }}" alt="Biye Media Logo">
            <div>
                <div class="brand-title">Biye Media</div>
                <div class="brand-sub">Admin Console</div>
            </div>
        </a>

        <!-- Navigation Links -->
        <div class="sidebar-nav">
            <div class="nav-category">Core Menu</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>

            <div class="nav-category">Matrimony Management</div>
            <a href="{{ route('admin.profiles.index') }}" class="sidebar-link {{ request()->routeIs('admin.profiles.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Profiles &amp; Biodata</span>
            </a>
            <a href="{{ route('admin.packages.index') }}" class="sidebar-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                <i class="bi bi-gem"></i>
                <span>Packages &amp; Membership</span>
            </a>
            <a href="{{ route('admin.stories.index') }}" class="sidebar-link {{ request()->routeIs('admin.stories.*') ? 'active' : '' }}">
                <i class="bi bi-heart-pulse-fill"></i>
                <span>Success Stories</span>
            </a>
            <a href="{{ route('admin.inquiries.index') }}" class="sidebar-link {{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
                <i class="bi bi-person-lines-fill"></i>
                <span>VIP Inquiries &amp; Leads</span>
            </a>
            <a href="{{ route('admin.faqs.index') }}" class="sidebar-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
                <i class="bi bi-question-diamond-fill"></i>
                <span>FAQs &amp; Knowledgebase</span>
            </a>

            <div class="nav-category">Administration &amp; Staff</div>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i>
                <span>Staff &amp; Matchmakers</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i>
                <span>Site Settings</span>
            </a>
            <a href="{{ route('admin.sections.index') }}" class="sidebar-link {{ request()->routeIs('admin.sections.*') ? 'active' : '' }}">
                <i class="bi bi-layout-text-window-reverse"></i>
                <span>Page Content CMS</span>
            </a>

            <div class="nav-category">Access &amp; Support</div>
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                <i class="bi bi-globe2"></i>
                <span>Visit Public Website</span>
            </a>
            <a href="{{ route('contact') }}" target="_blank" class="sidebar-link">
                <i class="bi bi-headset"></i>
                <span>Helpdesk &amp; Support</span>
            </a>
        </div>

        <!-- Sidebar Clean Footer -->
        <div class="sidebar-footer">
            <div class="d-flex align-items-center gap-2">
                <div class="user-avatar" style="width: 32px; height: 32px; font-size: 0.8rem;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <div class="text-truncate fw-semibold text-clean-white" style="font-size: 0.82rem;">{{ auth()->user()->name ?? 'Administrator' }}</div>
                    <div class="text-truncate" style="font-size: 0.72rem; color: var(--accent-gold);">{{ auth()->user()->role_label ?? 'Administrator' }}</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
        <!-- Top Navbar -->
        <header class="admin-topbar d-flex justify-content-between align-items-center">
            <!-- Left: Sidebar Toggle & Page Title -->
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle-btn d-lg-none" id="sidebarToggleBtn" type="button" aria-label="Toggle Sidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div>
                    <h5 class="mb-0 text-clean-white fw-bold">@yield('page-title', 'Admin Portal')</h5>
                    <div class="topbar-date d-none d-sm-block">{{ date('l, d F Y') }} &bull; Bangladesh Standard Time</div>
                </div>
            </div>

            <!-- Right: Earth Logo Button & Profile Dropdown -->
            <div class="d-flex align-items-center gap-3">
                <!-- Round Shape Earth Logo Button (Public Site Link) -->
                <a href="{{ route('home') }}" target="_blank" class="btn-earth-visit" title="Visit Public Website" data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <i class="bi bi-globe2"></i>
                </a>

                <!-- Profile Dropdown (Logout item is inside here) -->
                <div class="dropdown">
                    <button class="admin-profile-btn dropdown-toggle border-0" type="button" id="adminProfileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="d-none d-sm-block text-start">
                            <div class="user-name-text">{{ auth()->user()->name ?? 'Admin' }}</div>
                            <div class="user-status-text">
                                <span class="status-dot"></span> Online
                            </div>
                        </div>
                        <i class="bi bi-chevron-down ms-1" style="font-size: 0.75rem; color: var(--accent-gold);"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end admin-dropdown-menu" aria-labelledby="adminProfileDropdown">
                        <li class="dropdown-header-custom">
                            <div class="name">{{ auth()->user()->name ?? 'Administrator' }}</div>
                            <div class="email">{{ auth()->user()->email ?? 'admin@biyemedia.com' }}</div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-grid-1x2-fill text-gold"></i>
                                <span>Dashboard Home</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                <i class="bi bi-globe2 text-gold"></i>
                                <span>Visit Public Website</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profiles') }}" target="_blank">
                                <i class="bi bi-people text-gold"></i>
                                <span>Browse Biodata</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-person-gear text-gold"></i>
                                <span>Staff &amp; Matchmakers</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.settings.index') }}">
                                <i class="bi bi-sliders text-gold"></i>
                                <span>Site Settings</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.sections.index') }}">
                                <i class="bi bi-layout-text-window-reverse text-gold"></i>
                                <span>Page Content CMS</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger w-100 text-start border-0 bg-transparent">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out (Logout)</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Floating Executive Toast Notifications -->
        <div class="admin-toast-container" id="adminToastContainer">
            @if (session('success'))
                <div class="admin-toast toast-success" role="alert" aria-live="polite">
                    <div class="admin-toast-body">
                        <div class="admin-toast-icon">
                            <i class="bi bi-check2-circle"></i>
                        </div>
                        <div class="admin-toast-content">
                            <div class="admin-toast-title">Success</div>
                            <p class="admin-toast-message">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="admin-toast-close" data-dismiss="admin-toast" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="toast-progress-track">
                        <div class="toast-progress-bar"></div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="admin-toast toast-error" role="alert" aria-live="polite">
                    <div class="admin-toast-body">
                        <div class="admin-toast-icon">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="admin-toast-content">
                            <div class="admin-toast-title">Notice</div>
                            <p class="admin-toast-message">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="admin-toast-close" data-dismiss="admin-toast" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="toast-progress-track">
                        <div class="toast-progress-bar"></div>
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="admin-toast toast-info" role="alert" aria-live="polite">
                    <div class="admin-toast-body">
                        <div class="admin-toast-icon">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>
                        <div class="admin-toast-content">
                            <div class="admin-toast-title">Information</div>
                            <p class="admin-toast-message">{{ session('info') }}</p>
                        </div>
                        <button type="button" class="admin-toast-close" data-dismiss="admin-toast" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                    <div class="toast-progress-track">
                        <div class="toast-progress-bar"></div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="container-fluid px-4 py-3 flex-grow-1">
            @yield('content')
        </main>

        <!-- Admin Footer -->
        <footer class="px-4 py-3 text-center border-top border-secondary border-opacity-25" style="background: rgba(0,0,0,0.35); font-size: 0.8rem; color: var(--text-muted-custom);">
            &copy; {{ date('Y') }} Biye Marriage Media Bangladesh &bull; Confidential & Secure Matrimonial Administration Portal.
        </footer>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggleBtn');
        const sidebar = document.getElementById('adminSidebar');

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('show');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function (e) {
                if (window.innerWidth < 992 && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            });
        }

        // Initialize Bootstrap tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        // Auto-dismiss Executive Toast Notifications after exactly 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            const toastElements = document.querySelectorAll('.admin-toast');
            toastElements.forEach(function (toastEl) {
                setTimeout(function () {
                    dismissToast(toastEl);
                }, 5000);
            });

            document.addEventListener('click', function (e) {
                const closeBtn = e.target.closest('[data-dismiss="admin-toast"]');
                if (closeBtn) {
                    const toastEl = closeBtn.closest('.admin-toast');
                    if (toastEl) {
                        dismissToast(toastEl);
                    }
                }
            });

            function dismissToast(el) {
                if (!el || el.dataset.dismissed) return;
                el.dataset.dismissed = 'true';
                el.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateX(30px) scale(0.95)';
                setTimeout(function () {
                    el.remove();
                }, 350);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
