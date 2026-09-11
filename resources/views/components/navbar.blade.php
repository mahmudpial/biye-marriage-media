<nav class="navbar navbar-expand-lg elite-navbar sticky-top">
    <div class="container">
        <!-- Brand Logo & Title -->
        <a class="elite-brand" href="{{ route('home') }}">
            <div class="d-flex align-items-center">
                <!-- Site Brand Logo -->
                <div class="brand-logo-frame me-2">
                    <img src="{{ site_setting_image('site_logo', asset('site-logo/marriage-logo.jpeg')) }}" alt="Biye Marriage Media Logo">
                </div>
                <div class="elite-brand-text">
                    <span class="elite-brand-title">{{ site_setting('site_name', 'Biye Marriage Media') }}</span>
                    <span class="elite-brand-subtitle text-gold fw-semibold">{{ site_setting('site_tagline', 'বিশ্বাসের বন্ধনে, সুন্দর আগামী') }}</span>
                </div>
            </div>
        </a>

        <!-- Mobile Toggler Button -->
        <button class="navbar-toggler border-0 p-1" type="button" data-bs-toggle="collapse" data-bs-target="#eliteNavbarCollapse" aria-controls="eliteNavbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="eliteNavbarCollapse">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                <li class="nav-item">
                    <a class="nav-link elite-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link elite-nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">{{ __('About Us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link elite-nav-link {{ request()->routeIs('profiles') ? 'active' : '' }}" href="{{ route('profiles') }}">{{ __('Find Matches') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link elite-nav-link {{ request()->routeIs('stories') ? 'active' : '' }}" href="{{ route('stories') }}">{{ __('Success Stories') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link elite-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">{{ __('Contact') }}</a>
                </li>
            </ul>

            <!-- Right Actions -->
            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                <a href="https://wa.me/{{ site_setting('whatsapp_number', '8801577723404') }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 py-2 fw-medium d-none d-xl-inline-flex align-items-center gap-1">
                    <i class="bi bi-whatsapp"></i> WhatsApp
                </a>

                <!-- Language Switcher -->
                @php
                    $frontLocale = app()->getLocale();
                @endphp
                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-2.5 py-1.5 d-flex align-items-center gap-1 border-1 text-dark" 
                            type="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false" 
                            title="{{ __('Switch Language') }}"
                            style="border-color: rgba(201, 151, 56, 0.45); background: #ffffff;">
                        <i class="bi bi-translate text-warning"></i>
                        <span class="fw-bold small" style="font-size: 0.76rem;">{{ $frontLocale === 'bn' ? 'বাং' : 'EN' }}</span>
                        <i class="bi bi-chevron-down text-muted" style="font-size: 0.62rem;"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 py-1.5 mt-1" style="min-width: 135px; border: 1px solid rgba(201, 151, 56, 0.25) !important;">
                        <li>
                            <a class="dropdown-item py-1.5 px-3 small d-flex align-items-center justify-content-between {{ $frontLocale === 'bn' ? 'fw-bold text-maroon' : '' }}" 
                               href="{{ route('locale.switch', 'bn') }}">
                                <span class="d-flex align-items-center gap-2"><span>🇧🇩</span> বাংলা</span>
                                @if($frontLocale === 'bn') <i class="bi bi-check2 text-warning fw-bold"></i> @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-1.5 px-3 small d-flex align-items-center justify-content-between {{ $frontLocale === 'en' ? 'fw-bold text-maroon' : '' }}" 
                               href="{{ route('locale.switch', 'en') }}">
                                <span class="d-flex align-items-center gap-2"><span>🇬🇧</span> English</span>
                                @if($frontLocale === 'en') <i class="bi bi-check2 text-warning fw-bold"></i> @endif
                            </a>
                        </li>
                    </ul>
                </div>

                @auth
                    @if(auth()->user()->isStaff())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger btn-sm rounded-pill px-3.5 py-2 fw-semibold d-inline-flex align-items-center gap-1.5">
                            <i class="bi bi-shield-lock-fill"></i>
                            <span>Admin Console</span>
                        </a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-elite-primary btn-sm rounded-pill px-3.5 py-2 fw-semibold dropdown-toggle d-inline-flex align-items-center gap-1.5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-check-fill"></i>
                                <span>{{ \Illuminate\Support\Str::limit(auth()->user()->name, 15) }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-1 py-2" style="min-width: 200px;">
                                <li>
                                    <a class="dropdown-item py-2 small fw-semibold" href="{{ route('member.dashboard') }}">
                                        <i class="bi bi-grid-1x2 text-maroon me-2"></i> {{ __('আমার ড্যাশবোর্ড') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 small" href="{{ route('member.biodata.edit') }}">
                                        <i class="bi bi-file-earmark-person text-primary me-2"></i> {{ __('বায়োডাটা এডিট') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 small" href="{{ route('member.matches') }}">
                                        <i class="bi bi-stars text-gold me-2"></i> {{ __('ডেইলি ম্যাচ') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2 small" href="{{ route('member.proposals') }}">
                                        <i class="bi bi-send-check text-success me-2"></i> {{ __('প্রস্তাবনা') }}
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 small text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i> {{ __('লগআউট') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                @else
                    <button type="button" class="btn btn-elite-primary btn-sm rounded-pill px-3.5 py-2 fw-semibold d-inline-flex align-items-center gap-1.5" data-bs-toggle="modal" data-bs-target="#memberLoginModal">
                        <i class="bi bi-person-lock"></i>
                        <span>{{ __('Login') }}</span>
                    </button>
                @endauth
            </div>
        </div>
    </div>
</nav>
