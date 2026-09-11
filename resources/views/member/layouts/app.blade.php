<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'সদস্য ড্যাশবোর্ড - ' . site_setting('site_name', 'Biye Marriage Media'))</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ site_setting_image('site_favicon', asset('site-logo/marriage-logo.jpeg')) }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ site_setting_image('site_favicon', asset('site-logo/marriage-logo.jpeg')) }}">
    <link rel="apple-touch-icon" href="{{ site_setting_image('site_favicon', asset('site-logo/marriage-logo.jpeg')) }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3.3 CSS & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Elite Theme Base CSS -->
    <link rel="stylesheet" href="{{ asset('css/elite-theme.css') }}">

    <style>
        :root {
            --theme-primary: {{ site_setting('theme_primary', '#851829') }};
            --theme-secondary: {{ site_setting('theme_secondary', '#c99738') }};
            --theme-accent: {{ site_setting('theme_accent', '#121620') }};
            --font-serif: 'Playfair Display', Georgia, serif;
            --font-sans: 'Poppins', 'Hind Siliguri', sans-serif;
            --elite-maroon-primary: var(--theme-primary);
            --elite-gold-primary: var(--theme-secondary);
        }

        body {
            font-family: var(--font-sans);
            background-color: #f8f6f3;
            color: #2c323f;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .font-serif {
            font-family: var(--font-serif);
        }

        /* Top VIP Helpdesk Bar */
        .member-topbar {
            background: #180308;
            border-bottom: 1px solid rgba(201, 151, 56, 0.3);
            color: #e5e7eb;
            font-size: 0.8rem;
            padding: 0.4rem 0;
        }

        .member-topbar a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .member-topbar a:hover {
            color: var(--theme-secondary);
        }

        .topbar-divider {
            color: rgba(201, 151, 56, 0.4);
            margin: 0 0.4rem;
        }

        /* Main Navbar */
        .member-navbar {
            background: #ffffff;
            border-bottom: 1px solid rgba(201, 151, 56, 0.2);
            box-shadow: 0 4px 20px rgba(133, 24, 41, 0.04);
            z-index: 1040 !important;
        }

        .member-navbar .dropdown {
            position: relative;
        }

        /* Fixed Anchored Dropdown directly under Profile Pill */
        .member-navbar .dropdown-menu {
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            margin-top: 8px !important;
            transform: none !important;
            max-height: calc(100vh - 90px);
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1050 !important;
            box-shadow: 0 16px 40px rgba(133, 24, 41, 0.16), 0 4px 12px rgba(0, 0, 0, 0.06) !important;
        }

        .member-navbar .dropdown-menu::-webkit-scrollbar {
            width: 5px;
        }

        .member-navbar .dropdown-menu::-webkit-scrollbar-track {
            background: #faf8f5;
            border-radius: 10px;
        }

        .member-navbar .dropdown-menu::-webkit-scrollbar-thumb {
            background: rgba(201, 151, 56, 0.4);
            border-radius: 10px;
        }

        .member-navbar .dropdown-menu::-webkit-scrollbar-thumb:hover {
            background: var(--theme-secondary);
        }

        /* Brand Logo Frame */
        .member-brand-logo-frame {
            width: 46px;
            height: 46px;
            min-width: 46px;
            border-radius: 50%;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 2px solid var(--theme-secondary);
            box-shadow: 0 2px 8px rgba(201, 151, 56, 0.2);
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .member-brand-logo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.22);
            transition: transform 0.3s ease;
        }

        .member-brand:hover .member-brand-logo-frame img {
            transform: scale(1.3);
        }

        .member-brand-title {
            font-family: var(--font-serif);
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--theme-primary);
            line-height: 1.1;
        }

        .member-brand-subtitle {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--theme-secondary);
            font-weight: 700;
        }

        /* Nav Links */
        .member-nav-link {
            font-weight: 500;
            color: #4b5563;
            padding: 0.55rem 0.95rem;
            border-radius: 9999px;
            transition: all 0.2s ease;
            font-size: 0.92rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
            border: 1px solid transparent;
        }

        .member-nav-link:hover {
            color: var(--theme-primary);
            background-color: rgba(133, 24, 41, 0.05);
            border-color: rgba(133, 24, 41, 0.1);
        }

        .member-nav-link.active {
            color: #ffffff !important;
            background: linear-gradient(135deg, var(--theme-primary) 0%, #5d0f1b 100%) !important;
            box-shadow: 0 4px 12px rgba(133, 24, 41, 0.25);
            border-color: transparent;
        }

        .badge-quota-pill {
            background: rgba(201, 151, 56, 0.12);
            color: #8c6310;
            border: 1px solid rgba(201, 151, 56, 0.35);
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-elite-primary {
            background: linear-gradient(135deg, var(--theme-primary) 0%, #5d0f1b 100%);
            color: #ffffff;
            border: none;
            box-shadow: 0 4px 14px rgba(133, 24, 41, 0.25);
            transition: all 0.25s ease;
        }
        .btn-elite-primary:hover, .btn-elite-primary:focus {
            background: linear-gradient(135deg, #9d1e32 0%, var(--theme-primary) 100%);
            color: #ffffff;
            box-shadow: 0 6px 18px rgba(133, 24, 41, 0.35);
            transform: translateY(-1px);
        }

        /* User Menu Avatar & Profile Pill */
        .avatar-initials {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, var(--theme-primary) 0%, #5a0e1a 100%);
            color: #ffffff;
            border: 2px solid var(--theme-secondary);
            font-weight: 700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.88rem;
        }

        .member-profile-btn {
            background: linear-gradient(135deg, #ffffff 0%, #fdfbf7 100%);
            border: 1.5px solid rgba(201, 151, 56, 0.45) !important;
            border-radius: 40px;
            padding: 0.35rem 0.95rem 0.35rem 0.4rem;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(201, 151, 56, 0.12);
        }
        .member-profile-btn:hover, .member-profile-btn[aria-expanded="true"] {
            background: #ffffff;
            border-color: var(--theme-secondary) !important;
            box-shadow: 0 4px 16px rgba(201, 151, 56, 0.25);
            transform: translateY(-1px);
        }
        .member-profile-btn .chevron-icon {
            font-size: 0.72rem;
            color: var(--theme-secondary);
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .member-profile-btn[aria-expanded="true"] .chevron-icon {
            transform: rotate(180deg);
        }

        /* Language Switcher Pill Button */
        .member-lang-btn {
            background: linear-gradient(135deg, #ffffff 0%, #fdfbf7 100%);
            border: 1.5px solid rgba(201, 151, 56, 0.4) !important;
            border-radius: 40px;
            padding: 0.38rem 0.8rem;
            color: #1f2937;
            font-size: 0.82rem;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(201, 151, 56, 0.1);
        }
        .member-lang-btn:hover, .member-lang-btn[aria-expanded="true"] {
            background: #ffffff;
            border-color: var(--theme-secondary) !important;
            box-shadow: 0 4px 14px rgba(201, 151, 56, 0.22);
            transform: translateY(-1px);
        }
        .member-lang-dropdown .dropdown-item {
            font-size: 0.82rem;
            color: #374151;
            transition: all 0.15s ease;
        }
        .member-lang-dropdown .dropdown-item:hover {
            background: rgba(201, 151, 56, 0.08);
            color: var(--theme-primary);
        }
        .member-lang-dropdown .dropdown-item.active-lang {
            background: rgba(133, 24, 41, 0.06);
            color: var(--theme-primary);
            font-weight: 700;
        }

        /* Mobile Bottom App Bar */
        @media (max-width: 991.98px) {
            .mobile-bottom-bar {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: #ffffff;
                border-top: 1px solid rgba(201, 151, 56, 0.25);
                box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.06);
                z-index: 1040;
                display: flex;
                justify-content: space-around;
                padding: 0.4rem 0.2rem;
            }
            .mobile-tab-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-decoration: none;
                color: #6b7280;
                font-size: 0.72rem;
                padding: 0.2rem 0.6rem;
                border-radius: 8px;
            }
            .mobile-tab-item.active {
                color: var(--theme-primary);
                font-weight: 600;
            }
            .mobile-tab-item i {
                font-size: 1.25rem;
                margin-bottom: 2px;
            }
            body {
                padding-bottom: 70px;
            }
        }

        /* Floating Luxury Member Toast Notifications */
        .member-toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 420px;
            width: calc(100vw - 48px);
            pointer-events: none;
        }

        .member-toast {
            pointer-events: auto;
            background: #ffffff;
            border: 1px solid rgba(201, 151, 56, 0.35);
            border-radius: 16px;
            box-shadow: 0 16px 40px rgba(133, 24, 41, 0.14), 0 4px 12px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            position: relative;
            animation: memberToastSlideIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .member-toast.toast-success {
            border-left: 4px solid #198754;
        }

        .member-toast.toast-error {
            border-left: 4px solid #dc3545;
        }

        .member-toast.toast-info {
            border-left: 4px solid #0d6efd;
        }

        .member-toast-body {
            display: flex;
            align-items: flex-start;
            padding: 14px 16px;
            gap: 12px;
        }

        .member-toast-icon {
            font-size: 1.25rem;
            line-height: 1;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .toast-success .member-toast-icon {
            color: #198754;
        }

        .toast-error .member-toast-icon {
            color: #dc3545;
        }

        .toast-info .member-toast-icon {
            color: #0d6efd;
        }

        .member-toast-content {
            flex-grow: 1;
            min-width: 0;
        }

        .member-toast-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .member-toast-message {
            font-size: 0.82rem;
            color: #4b5563;
            margin: 0;
            line-height: 1.4;
            word-break: break-word;
        }

        .member-toast-close {
            background: transparent;
            border: none;
            color: #9ca3af;
            font-size: 0.85rem;
            padding: 4px;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.2s ease;
            flex-shrink: 0;
            line-height: 1;
        }

        .member-toast-close:hover {
            color: #1f2937;
            background: rgba(0, 0, 0, 0.05);
        }

        .member-toast-progress-track {
            width: 100%;
            height: 3px;
            background: rgba(201, 151, 56, 0.15);
            overflow: hidden;
        }

        .member-toast-progress-bar {
            height: 100%;
            width: 100%;
            animation: memberToastCountdown 5s linear forwards;
        }

        .toast-success .member-toast-progress-bar {
            background: linear-gradient(90deg, #198754, #20c997);
        }

        .toast-error .member-toast-progress-bar {
            background: linear-gradient(90deg, #dc3545, #e63946);
        }

        .toast-info .member-toast-progress-bar {
            background: linear-gradient(90deg, #c99738, #851829);
        }

        @keyframes memberToastCountdown {
            from { width: 100%; }
            to { width: 0%; }
        }

        @keyframes memberToastSlideIn {
            from {
                opacity: 0;
                transform: translateX(40px) scale(0.92);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Impersonation Notice Bar -->
    @if(session('impersonator_admin_id'))
        <div class="py-2 px-3 text-center text-dark fw-semibold small d-flex justify-content-center align-items-center gap-2 flex-wrap" style="background: #fef08a; border-bottom: 2px solid #eab308;">
            <i class="bi bi-shield-exclamation text-danger fs-6"></i>
            <span>অ্যাডমিন ইমপারসোনেশন মোড: আপনি <strong>{{ Auth::user()->name }}</strong> হিসেবে ক্লায়েন্ট ড্যাশবোর্ড দেখছেন।</span>
            <a href="{{ route('admin.clients.stop-impersonate') }}" class="btn btn-dark btn-sm rounded-pill py-0 px-3 ms-2">
                অ্যাডমিন প্যানেলে ফিরে যান &rarr;
            </a>
        </div>
    @endif

    <!-- VIP Top Priority Helpdesk Bar -->
    <div class="member-topbar d-none d-md-block">
        <div class="container-xl d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <span><i class="bi bi-shield-check text-warning me-1"></i> {{ __('১০০% গোপনীয় ও ব্যক্তিগত ম্যাচমেকিং পোর্টাল') }}</span>
                <span class="topbar-divider">|</span>
                <span class="text-warning-subtle"><i class="bi bi-heart-fill text-warning me-1"></i> {{ site_setting('site_tagline', __('বিশ্বাসের বন্ধনে, সুন্দর আগামী')) }}</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', site_setting('contact_phone', '+8801577723404')) }}">
                    <i class="bi bi-telephone-fill text-warning me-1"></i> {{ site_setting('contact_phone', '+880 1577-723404') }}
                </a>
                <span class="topbar-divider">|</span>
                <a href="https://wa.me/{{ site_setting('whatsapp_number', '8801577723404') }}" target="_blank">
                    <i class="bi bi-whatsapp text-success me-1"></i> VIP WhatsApp
                </a>
                <span class="topbar-divider">|</span>
                <a href="{{ route('home') }}" target="_blank">
                    <i class="bi bi-box-arrow-up-right me-1"></i> {{ __('মূল ওয়েবসাইট') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Floating Luxury Member Toast Notifications -->
    <div class="member-toast-container" id="memberToastContainer">
        @if(session('success'))
            <div class="member-toast toast-success" role="alert" aria-live="polite">
                <div class="member-toast-body">
                    <div class="member-toast-icon">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                    <div class="member-toast-content">
                        <div class="member-toast-title">সফল হয়েছে</div>
                        <p class="member-toast-message">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="member-toast-close" data-dismiss="member-toast" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="member-toast-progress-track">
                    <div class="member-toast-progress-bar"></div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="member-toast toast-error" role="alert" aria-live="polite">
                <div class="member-toast-body">
                    <div class="member-toast-icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="member-toast-content">
                        <div class="member-toast-title">সতর্কবার্তা</div>
                        <p class="member-toast-message">{{ session('error') }}</p>
                    </div>
                    <button type="button" class="member-toast-close" data-dismiss="member-toast" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="member-toast-progress-track">
                    <div class="member-toast-progress-bar"></div>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="member-toast toast-info" role="alert" aria-live="polite">
                <div class="member-toast-body">
                    <div class="member-toast-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <div class="member-toast-content">
                        <div class="member-toast-title">তথ্য</div>
                        <p class="member-toast-message">{{ session('info') }}</p>
                    </div>
                    <button type="button" class="member-toast-close" data-dismiss="member-toast" aria-label="Close">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="member-toast-progress-track">
                    <div class="member-toast-progress-bar"></div>
                </div>
            </div>
        @endif
    </div>

    <!-- Member Navigation Bar -->
    <header class="member-navbar sticky-top">
        <div class="container-xl py-2">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Brand / Logo -->
                <a href="{{ route('member.dashboard') }}" class="member-brand d-flex align-items-center gap-2.5 text-decoration-none">
                    <div class="member-brand-logo-frame">
                        <img src="{{ site_setting_image('site_logo', asset('site-logo/marriage-logo.jpeg')) }}" 
                             alt="{{ site_setting('site_name', 'Biye Marriage Media') }}">
                    </div>
                    <div>
                        <div class="member-brand-title">{{ site_setting('site_name', 'Biye Marriage Media') }}</div>
                        <div class="member-brand-subtitle">ELITE CLIENT PORTAL</div>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="d-none d-lg-flex align-items-center gap-2">
                    <a href="{{ route('member.dashboard') }}" class="member-nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>{{ __('ড্যাশবোর্ড') }}</span>
                    </a>
                    <a href="{{ route('member.biodata.show') }}" class="member-nav-link {{ request()->routeIs('member.biodata.*') ? 'active' : '' }}">
                        <i class="bi bi-person-vcard-fill"></i>
                        <span>{{ __('আমার বায়োডাটা') }}</span>
                    </a>
                    <a href="{{ route('member.matches') }}" class="member-nav-link {{ request()->routeIs('member.matches') ? 'active' : '' }}">
                        <i class="bi bi-stars text-warning"></i>
                        <span>{{ __('ডেইলি ম্যাচ') }}</span>
                    </a>
                    <a href="{{ route('member.shortlists') }}" class="member-nav-link {{ request()->routeIs('member.shortlists') ? 'active' : '' }}">
                        <i class="bi bi-bookmark-heart-fill"></i>
                        <span>{{ __('শর্টলিস্ট') }}</span>
                    </a>
                </nav>

                <!-- User Profile & Dropdown (With Quota & Proposals Inside) -->
                <div class="d-flex align-items-center gap-2">
                    @php
                        $user = Auth::user();
                        $sub = $user->activeSubscription;
                        $myProfile = $user->candidateProfile;
                        $pendingIn = $myProfile ? $myProfile->receivedProposals()->where('status', 'pending')->count() : 0;
                        $activeLocale = app()->getLocale();
                    @endphp

                    <!-- Language Switcher Pill Button -->
                    <div class="dropdown">
                        <button class="member-lang-btn border-0 d-flex align-items-center gap-1.5" 
                                type="button" 
                                data-bs-toggle="dropdown" 
                                data-bs-display="static" 
                                aria-expanded="false" 
                                title="{{ __('Switch Language') }}">
                            <i class="bi bi-translate text-warning"></i>
                            <span class="fw-bold small">{{ $activeLocale === 'bn' ? 'বাং' : 'EN' }}</span>
                            <i class="bi bi-chevron-down text-muted" style="font-size: 0.65rem;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 py-1.5 member-lang-dropdown" style="min-width: 140px; border: 1px solid rgba(201, 151, 56, 0.25) !important;">
                            <li>
                                <a class="dropdown-item py-1.5 px-3 small d-flex align-items-center justify-content-between {{ $activeLocale === 'bn' ? 'active-lang' : '' }}" 
                                   href="{{ route('locale.switch', 'bn') }}">
                                    <span class="d-flex align-items-center gap-2">
                                        <span style="font-size: 1rem;">🇧🇩</span> বাংলা
                                    </span>
                                    @if($activeLocale === 'bn')
                                        <i class="bi bi-check2 text-warning fw-bold"></i>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-1.5 px-3 small d-flex align-items-center justify-content-between {{ $activeLocale === 'en' ? 'active-lang' : '' }}" 
                                   href="{{ route('locale.switch', 'en') }}">
                                    <span class="d-flex align-items-center gap-2">
                                        <span style="font-size: 1rem;">🇬🇧</span> English
                                    </span>
                                    @if($activeLocale === 'en')
                                        <i class="bi bi-check2 text-warning fw-bold"></i>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- User Profile Dropdown Button -->
                    <div class="dropdown">
                        <button class="member-profile-btn border-0 position-relative" type="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <div class="avatar-initials position-relative">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                @if($pendingIn > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" title="{{ $pendingIn }} {{ __('নতুন প্রস্তাব') }}">
                                        <span class="visually-hidden">New proposals</span>
                                    </span>
                                @endif
                            </div>
                            <div class="d-none d-md-block text-start lh-1">
                                <span class="fw-semibold small text-dark d-block">{{ \Illuminate\Support\Str::limit($user->name, 16) }}</span>
                                <span class="text-muted" style="font-size: 0.68rem;">{{ __('ক্লায়েন্ট অ্যাকাউন্ট') }}</span>
                            </div>
                            <i class="bi bi-chevron-down chevron-icon ms-1"></i>
                        </button>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2 py-2" style="min-width: 270px; border: 1px solid rgba(201, 151, 56, 0.2) !important;">
                            <!-- Dropdown Header with Profile Details & Quota Pill -->
                            <li class="px-3 py-2.5 bg-light rounded-top-4 mb-2 border-bottom">
                                <div class="fw-bold text-dark font-serif fs-6">{{ $user->name }}</div>
                                <div class="small text-muted text-truncate" style="font-size: 0.78rem;">{{ $user->email }}</div>
                                
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mt-1.5">
                                    @if($user->isVerified())
                                        <span class="badge bg-success-subtle text-success border border-success-subtle small" style="font-size: 0.72rem;">
                                            <i class="bi bi-patch-check-fill me-1"></i>{{ __('ভেরিফাইড মেম্বার') }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle small fw-semibold" style="font-size: 0.72rem;">
                                            <i class="bi bi-clock-history me-1"></i>{{ __('ভেরিফিকেশন অপেক্ষমাণ') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Proposal Quota Pill inside Dropdown Header -->
                                @if($sub)
                                    <div class="d-flex align-items-center justify-content-between p-2 mt-2 rounded-3 bg-white border border-warning-subtle shadow-xs">
                                        <span class="small text-muted d-flex align-items-center gap-1.5" style="font-size: 0.78rem;">
                                            <i class="bi bi-send-fill text-warning"></i> {{ __('প্রপোজাল কোটা:') }}
                                        </span>
                                        <span class="badge bg-warning text-dark px-2 py-0.5 rounded-pill fw-bold" style="font-size: 0.76rem;">
                                            {{ $sub->remainingProposals() }} / {{ $sub->proposals_quota }} {{ __('বাকি') }}
                                        </span>
                                    </div>
                                @endif
                            </li>

                            <!-- Dropdown Menu Links -->
                            <li>
                                <a class="dropdown-item py-2 small" href="{{ route('member.dashboard') }}">
                                    <i class="bi bi-speedometer2 text-maroon me-2"></i> {{ __('ওভারভিউ ড্যাশবোর্ড') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 small" href="{{ route('member.biodata.show') }}">
                                    <i class="bi bi-file-earmark-person-fill text-primary me-2"></i> {{ __('আমার বায়োডাটা (সিভি)') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 small" href="{{ route('member.biodata.edit') }}">
                                    <i class="bi bi-pencil-square text-secondary me-2"></i> {{ __('বায়োডাটা এডিট করুন') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 small" href="{{ route('member.matches') }}">
                                    <i class="bi bi-search-heart text-warning me-2"></i> {{ __('পাত্র-পাত্রী খুঁজুন') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 small" href="{{ route('member.shortlists') }}">
                                    <i class="bi bi-bookmark-heart text-danger me-2"></i> {{ __('পছন্দের তালিকা (Shortlist)') }}
                                </a>
                            </li>

                            <!-- Proposals with Pending Badge inside Dropdown -->
                            <li>
                                <a class="dropdown-item py-2 small d-flex align-items-center justify-content-between {{ request()->routeIs('member.proposals') ? 'active text-white' : '' }}" href="{{ route('member.proposals') }}">
                                    <span><i class="bi bi-envelope-heart-fill text-success me-2"></i>{{ __('প্রস্তাবনা (Proposals)') }}</span>
                                    @if($pendingIn > 0)
                                        <span class="badge rounded-pill bg-danger" style="font-size: 0.68rem;">{{ $pendingIn }} {{ __('নতুন') }}</span>
                                    @endif
                                </a>
                            </li>

                            <li><hr class="dropdown-divider my-1.5"></li>

                            <li>
                                <button type="button" class="dropdown-item py-2 small text-dark" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                    <i class="bi bi-key-fill text-warning me-2"></i> {{ __('পাসওয়ার্ড পরিবর্তন করুন') }}
                                </button>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 small" href="{{ route('home') }}" target="_blank">
                                    <i class="bi bi-globe me-2 text-secondary"></i> {{ __('মূল ওয়েবসাইট দেখুন') }}
                                </a>
                            </li>
                            @if(Auth::user()->isStaff())
                                <li>
                                    <a class="dropdown-item py-2 small text-danger fw-semibold" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-shield-lock-fill me-2"></i> {{ __('অ্যাডমিন কনসোল') }}
                                    </a>
                                </li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 small text-danger fw-medium">
                                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('লগআউট') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow-1 py-4">
        <div class="container-xl">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4 border-danger-subtle" role="alert">
                    <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> কিছু তথ্যে সমস্যা রয়েছে:</div>
                    <ul class="mb-0 ps-3 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Global Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <form action="{{ route('member.password.update') }}" method="POST">
                    @csrf
                    <div class="modal-header text-white" style="background: linear-gradient(135deg, #851829 0%, #520f1a 100%);">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-warning text-dark p-1.5 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="bi bi-key-fill"></i>
                            </div>
                            <h5 class="modal-title font-serif fw-bold mb-0" id="changePasswordModalLabel">পাসওয়ার্ড পরিবর্তন করুন</h5>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <p class="small text-muted mb-3">
                            আপনার অ্যাকাউন্টের নিরাপত্তা নিশ্চিত করতে একটি শক্তিশালী পাসওয়ার্ড নির্ধারণ করুন। পরবর্তীতে এই পাসওয়ার্ড দিয়ে সরাসরি লগইন করতে পারবেন।
                        </p>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-dark">বর্তমান পাসওয়ার্ড (যদি জানা থাকে)</label>
                            <input type="password" name="current_password" class="form-control" placeholder="বর্তমান পাসওয়ার্ড দিন (ঐচ্ছিক)">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-dark">নতুন পাসওয়ার্ড <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="কমপক্ষে ৬ অক্ষরের নতুন পাসওয়ার্ড" required minlength="6">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-dark">নতুন পাসওয়ার্ড নিশ্চিত করুন <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="নতুন পাসওয়ার্ডটি পুনরায় লিখুন" required minlength="6">
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">বাতিল</button>
                        <button type="submit" class="btn btn-elite-primary rounded-pill px-4 fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> পাসওয়ার্ড সংরক্ষণ করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom App Bar -->
    <div class="mobile-bottom-bar d-lg-none">
        <a href="{{ route('member.dashboard') }}" class="mobile-tab-item {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>হোম</span>
        </a>
        <a href="{{ route('member.biodata.edit') }}" class="mobile-tab-item {{ request()->routeIs('member.biodata.*') ? 'active' : '' }}">
            <i class="bi bi-person-vcard-fill"></i>
            <span>বায়োডাটা</span>
        </a>
        <a href="{{ route('member.matches') }}" class="mobile-tab-item {{ request()->routeIs('member.matches') ? 'active' : '' }}">
            <i class="bi bi-stars"></i>
            <span>ম্যাচ</span>
        </a>
        <a href="{{ route('member.shortlists') }}" class="mobile-tab-item {{ request()->routeIs('member.shortlists') ? 'active' : '' }}">
            <i class="bi bi-bookmark-heart-fill"></i>
            <span>শর্টলিস্ট</span>
        </a>
        <a href="{{ route('member.proposals') }}" class="mobile-tab-item {{ request()->routeIs('member.proposals') ? 'active' : '' }}">
            <i class="bi bi-send-check-fill"></i>
            <span>প্রস্তাব</span>
        </a>
    </div>

    <!-- Member Footer -->
    <footer class="bg-white border-top py-3.5 text-center small text-muted mt-auto d-none d-lg-block">
        <div class="container-xl d-flex justify-content-between align-items-center">
            <div>
                &copy; {{ date('Y') }} <strong>{{ site_setting('site_name', 'Biye Marriage Media') }}</strong>. ১০০% গোপনীয় ও বিশ্বস্ত পারিবারিক পাত্র-পাত্রী ম্যাচমেকিং।
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('about') }}" class="text-muted text-decoration-none hover-maroon">আমাদের সম্পর্কে</a>
                <span class="text-secondary opacity-50">&bull;</span>
                <a href="{{ route('packages') }}" class="text-muted text-decoration-none hover-maroon">প্যাকেজসমূহ</a>
                <span class="text-secondary opacity-50">&bull;</span>
                <a href="{{ route('stories') }}" class="text-muted text-decoration-none hover-maroon">সফল দম্পতি গল্প</a>
                <span class="text-secondary opacity-50">&bull;</span>
                <a href="{{ route('contact') }}" class="text-muted text-decoration-none hover-maroon">যোগাযোগ</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-dismiss Member Toast Notifications after exactly 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            const toastElements = document.querySelectorAll('.member-toast');
            toastElements.forEach(function (toastEl) {
                setTimeout(function () {
                    dismissMemberToast(toastEl);
                }, 5000);
            });

            document.addEventListener('click', function (e) {
                const closeBtn = e.target.closest('[data-dismiss="member-toast"]');
                if (closeBtn) {
                    const toastEl = closeBtn.closest('.member-toast');
                    if (toastEl) {
                        dismissMemberToast(toastEl);
                    }
                }
            });

            function dismissMemberToast(el) {
                if (!el || el.dataset.dismissed) return;
                el.dataset.dismissed = 'true';
                el.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
                el.style.opacity = '0';
                el.style.transform = 'translateX(30px) scale(0.95)';
                setTimeout(function () {
                    el.remove();
                }, 350);
            }

            // Auto-dismiss standard alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert.alert-dismissible');
            alerts.forEach(function (alertEl) {
                setTimeout(function () {
                    try {
                        const bsAlert = bootstrap.Alert.getInstance(alertEl) || new bootstrap.Alert(alertEl);
                        if (bsAlert) {
                            bsAlert.close();
                        }
                    } catch (err) {
                        alertEl.remove();
                    }
                }, 5000);
            });
        });

        // Universal Action Button Loading / Spinner System for Member Portal
        document.addEventListener('submit', function (e) {
            const form = e.target;
            const submitBtn = form.querySelector('button[type="submit"]:not([data-no-loading])');
            if (!submitBtn || submitBtn.dataset.submitted) return;

            // Preserve width & height to prevent layout shift or button jumping
            const rect = submitBtn.getBoundingClientRect();
            if (rect.width > 0 && rect.height > 0) {
                submitBtn.style.minWidth = `${rect.width}px`;
                submitBtn.style.minHeight = `${rect.height}px`;
            }

            submitBtn.dataset.submitted = 'true';

            // Context-sensitive spinner animations
            if (submitBtn.classList.contains('filter-btn-luxury') || submitBtn.id === 'filterSubmitBtn') {
                // Filter search: elegant warning spinner matching luxury gold
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm text-warning" role="status" aria-hidden="true" style="width: 1.15rem; height: 1.15rem; border-width: 2.2px;"></span>';
            } else if (submitBtn.querySelector('.bi-heart') || submitBtn.querySelector('.bi-heart-fill')) {
                // Shortlist heart button
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm text-danger" role="status" style="width: 1rem; height: 1rem; border-width: 2px;"></span>';
            } else if (submitBtn.classList.contains('proposal-withdraw-btn') || form.action.includes('/cancel')) {
                // Proposal cancellation / withdrawal
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm text-danger me-1" role="status" style="width: 0.85rem; height: 0.85rem; border-width: 1.8px;"></span><span>প্রত্যাহার হচ্ছে...</span>';
            } else if (form.action.includes('/respond')) {
                // Proposal respond (accept/decline)
                const isAccept = form.querySelector('input[name="status"][value="accepted"]');
                submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-1" role="status" style="width: 0.85rem; height: 0.85rem; border-width: 1.8px;"></span><span>${isAccept ? 'গ্রহণ করা হচ্ছে...' : 'বাতিল হচ্ছে...'}</span>`;
            } else if (form.action.includes('/proposals')) {
                // Send proposal modal submit
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm text-warning me-1.5" role="status" style="width: 0.95rem; height: 0.95rem; border-width: 2px;"></span><span>প্রস্তাব পাঠানো হচ্ছে...</span>';
            } else if (form.action.includes('/biodata') && !form.action.includes('/toggle-discreet')) {
                // Biodata edit & update
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm text-warning me-1.5" role="status" style="width: 0.95rem; height: 0.95rem; border-width: 2px;"></span><span>তথ্য সংরক্ষণ হচ্ছে...</span>';
            } else if (form.action.includes('/toggle-discreet')) {
                // Discreet photo toggle
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm text-warning me-1.5" role="status" style="width: 0.95rem; height: 0.95rem; border-width: 2px;"></span><span>আপডেট হচ্ছে...</span>';
            } else if (form.action.includes('/password')) {
                // Password update
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm text-warning me-1.5" role="status" style="width: 0.95rem; height: 0.95rem; border-width: 2px;"></span><span>আপডেট হচ্ছে...</span>';
            } else {
                // General submit: replace icon or prepend spinner
                const icon = submitBtn.querySelector('i');
                if (icon) {
                    icon.className = 'spinner-border spinner-border-sm me-1.5';
                    icon.style.width = '0.9rem';
                    icon.style.height = '0.9rem';
                    icon.style.borderWidth = '1.8px';
                } else {
                    submitBtn.insertAdjacentHTML('afterbegin', '<span class="spinner-border spinner-border-sm me-1.5" role="status" style="width: 0.9rem; height: 0.9rem; border-width: 1.8px;"></span>');
                }
            }

            submitBtn.style.pointerEvents = 'none';
            submitBtn.style.opacity = '0.85';
        });
    </script>
    @stack('scripts')
</body>
</html>
