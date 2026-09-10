<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Member Dashboard - Biye Marriage Media')</title>
    
    <link rel="icon" type="image/jpeg" href="{{ site_setting_image('site_favicon', asset('site-logo/marriage-logo.jpeg')) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/elite-theme.css') }}">

    <style>
        :root {
            --theme-primary: {{ site_setting('theme_primary', '#851829') }};
            --theme-secondary: {{ site_setting('theme_secondary', '#c99738') }};
            --theme-accent: {{ site_setting('theme_accent', '#121620') }};
            --font-serif: 'Playfair Display', Georgia, serif;
            --font-sans: 'Poppins', 'Hind Siliguri', sans-serif;
        }

        body {
            font-family: var(--font-sans);
            background-color: #f7f5f2;
            color: #2c323f;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .font-serif {
            font-family: var(--font-serif);
        }

        .member-navbar {
            background: #ffffff;
            border-bottom: 1px solid rgba(133, 24, 41, 0.08);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

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
        }

        .member-nav-link:hover {
            color: var(--theme-primary);
            background-color: rgba(133, 24, 41, 0.05);
        }

        .member-nav-link.active {
            color: #ffffff !important;
            background: var(--theme-primary) !important;
            box-shadow: 0 4px 12px rgba(133, 24, 41, 0.25);
        }

        .stat-card-member {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card-member:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(133, 24, 41, 0.07);
        }

        .badge-quota {
            background: rgba(201, 151, 56, 0.12);
            color: #8c6310;
            border: 1px solid rgba(201, 151, 56, 0.25);
            font-weight: 600;
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

        /* Mobile Bottom App Bar */
        @media (max-width: 991.98px) {
            .mobile-bottom-bar {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: #ffffff;
                border-top: 1px solid rgba(0, 0, 0, 0.08);
                box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.05);
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

    <!-- Member Navigation Bar -->
    <header class="member-navbar sticky-top">
        <div class="container-xl py-2.5">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Brand / Logo -->
                <a href="{{ route('member.dashboard') }}" class="d-flex align-items-center gap-2.5 text-decoration-none">
                    <img src="{{ site_setting_image('site_logo', asset('site-logo/marriage-logo.jpeg')) }}" 
                         alt="{{ site_setting('brand_name', 'Biye Marriage Media') }}" 
                         height="42" 
                         class="rounded-circle border border-2 border-warning-subtle object-fit-cover">
                    <div>
                        <span class="font-serif fw-bold text-dark fs-5 d-block line-height-1">Biye Media</span>
                        <span class="text-maroon small text-uppercase letter-spacing-1 fw-bold" style="font-size: 0.68rem;">Elite Member Portal</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="d-none d-lg-flex align-items-center gap-1">
                    <a href="{{ route('member.dashboard') }}" class="member-nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-1x2"></i>
                        <span>ড্যাশবোর্ড</span>
                    </a>
                    <a href="{{ route('member.biodata.edit') }}" class="member-nav-link {{ request()->routeIs('member.biodata.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-person"></i>
                        <span>আমার বায়োডাটা</span>
                    </a>
                    <a href="{{ route('member.matches') }}" class="member-nav-link {{ request()->routeIs('member.matches') ? 'active' : '' }}">
                        <i class="bi bi-stars text-gold"></i>
                        <span>ডেইলি ম্যাচ</span>
                    </a>
                    <a href="{{ route('member.shortlists') }}" class="member-nav-link {{ request()->routeIs('member.shortlists') ? 'active' : '' }}">
                        <i class="bi bi-bookmark-heart"></i>
                        <span>শর্টলিস্ট</span>
                    </a>
                    <a href="{{ route('member.proposals') }}" class="member-nav-link {{ request()->routeIs('member.proposals') ? 'active' : '' }}">
                        <i class="bi bi-send-check"></i>
                        <span>প্রস্তাবনা</span>
                        @php
                            $user = Auth::user();
                            $myProfile = $user->candidateProfile;
                            $pendingIn = $myProfile ? $myProfile->receivedProposals()->where('status', 'pending')->count() : 0;
                        @endphp
                        @if($pendingIn > 0)
                            <span class="badge rounded-pill bg-danger" style="font-size: 0.65rem;">{{ $pendingIn }}</span>
                        @endif
                    </a>
                </nav>

                <!-- User Profile & Quota Pill -->
                <div class="d-flex align-items-center gap-2.5">
                    @php
                        $sub = Auth::user()->activeSubscription;
                    @endphp
                    @if($sub)
                        <div class="d-none d-sm-flex align-items-center gap-1.5 px-3 py-1 rounded-pill badge-quota small" title="অবশিষ্ট প্রপোজাল কোটা">
                            <i class="bi bi-send-fill text-gold"></i>
                            <span>কোটা: <strong>{{ $sub->remainingProposals() }}</strong>/{{ $sub->proposals_quota }}</span>
                        </div>
                    @endif

                    <!-- User Profile Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-light border rounded-pill d-flex align-items-center gap-2 py-1.5 px-2.5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-maroon text-white fw-bold d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline fw-semibold small text-dark">{{ Auth::user()->name }}</span>
                            <i class="bi bi-chevron-down text-muted" style="font-size: 0.75rem;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-1 py-2" style="min-width: 220px;">
                            <li class="px-3 py-1">
                                <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                                <div class="small text-muted text-truncate">{{ Auth::user()->email }}</div>
                                <div class="mt-1">
                                    @if(Auth::user()->isVerified())
                                        <span class="badge bg-success-subtle text-success small"><i class="bi bi-patch-check-fill me-1"></i>Verified Member</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning small"><i class="bi bi-clock-history me-1"></i>Verification Pending</span>
                                    @endif
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2 small" href="{{ route('member.dashboard') }}">
                                    <i class="bi bi-speedometer2 text-maroon me-2"></i> ওভারভিউ ড্যাশবোর্ড
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 small" href="{{ route('member.biodata.edit') }}">
                                    <i class="bi bi-pencil-square text-primary me-2"></i> বায়োডাটা এডিট করুন
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 small" href="{{ route('member.matches') }}">
                                    <i class="bi bi-search-heart text-gold me-2"></i> পাত্র-পাত্রী খুঁজুন
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 small" href="{{ route('member.proposals') }}">
                                    <i class="bi bi-inbox text-success me-2"></i> প্রস্তাবনা হিস্ট্রি
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2 small" href="{{ route('home') }}" target="_blank">
                                    <i class="bi bi-globe me-2 text-secondary"></i> মূল ওয়েবসাইট দেখুন
                                </a>
                            </li>
                            @if(Auth::user()->isStaff())
                                <li>
                                    <a class="dropdown-item py-2 small text-danger fw-semibold" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-shield-lock-fill me-2"></i> অ্যাডমিন কনসোল
                                    </a>
                                </li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 small text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> লগআউট
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
            <!-- Flash Notifications -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 rounded-3 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show d-flex align-items-center gap-2 rounded-3 shadow-sm mb-4" role="alert">
                    <i class="bi bi-info-circle-fill fs-5"></i>
                    <div>{{ session('info') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 rounded-3 shadow-sm mb-4" role="alert">
                    <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
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

    <!-- Mobile Bottom App Bar -->
    <div class="mobile-bottom-bar d-lg-none">
        <a href="{{ route('member.dashboard') }}" class="mobile-tab-item {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i>
            <span>হোম</span>
        </a>
        <a href="{{ route('member.biodata.edit') }}" class="mobile-tab-item {{ request()->routeIs('member.biodata.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-person"></i>
            <span>বায়োডাটা</span>
        </a>
        <a href="{{ route('member.matches') }}" class="mobile-tab-item {{ request()->routeIs('member.matches') ? 'active' : '' }}">
            <i class="bi bi-stars"></i>
            <span>ম্যাচ</span>
        </a>
        <a href="{{ route('member.shortlists') }}" class="mobile-tab-item {{ request()->routeIs('member.shortlists') ? 'active' : '' }}">
            <i class="bi bi-bookmark-heart"></i>
            <span>শর্টলিস্ট</span>
        </a>
        <a href="{{ route('member.proposals') }}" class="mobile-tab-item {{ request()->routeIs('member.proposals') ? 'active' : '' }}">
            <i class="bi bi-send-check"></i>
            <span>প্রস্তাব</span>
        </a>
    </div>

    <!-- Member Footer -->
    <footer class="bg-white border-top py-3 text-center small text-muted mt-auto d-none d-lg-block">
        <div class="container-xl d-flex justify-content-between align-items-center">
            <div>
                &copy; {{ date('Y') }} {{ site_setting('brand_name', 'Biye Marriage Media') }}. ১০০% গোপনীয় ও বিশ্বস্ত ম্যাচমেকিং।
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('about') }}" class="text-muted text-decoration-none">আমাদের সম্পর্কে</a>
                <a href="{{ route('packages') }}" class="text-muted text-decoration-none">প্যাকেজসমূহ</a>
                <a href="{{ route('contact') }}" class="text-muted text-decoration-none">যোগাযোগ</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
