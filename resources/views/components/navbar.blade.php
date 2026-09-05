<nav class="navbar navbar-expand-lg elite-navbar sticky-top">
    <div class="container">
        <!-- Brand Logo & Title -->
        <a class="elite-brand" href="{{ route('home') }}">
            <div class="d-flex align-items-center">
                <!-- Site Brand Logo -->
                <div class="brand-logo-frame me-2">
                    <img src="{{ asset('site-logo/marriage-logo.jpeg') }}" alt="Biye Marriage Media Logo">
                </div>
                <div class="elite-brand-text">
                    <span class="elite-brand-title">Biye Marriage Media</span>
                    <span class="elite-brand-subtitle text-gold fw-semibold">বিশ্বাসের বন্ধনে, সুন্দর আগামী</span>
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
                    <a class="nav-link elite-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link elite-nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link elite-nav-link {{ request()->routeIs('profiles') ? 'active' : '' }}" href="{{ route('profiles') }}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link elite-nav-link {{ request()->routeIs('stories') ? 'active' : '' }}" href="{{ route('stories') }}">Stories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link elite-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>

            <!-- Right Actions -->
            <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                <a href="https://wa.me/8801577711210" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 py-2 fw-medium d-none d-xl-inline-flex align-items-center gap-1">
                    <i class="bi bi-whatsapp"></i> WhatsApp
                </a>
                <button type="button" class="btn btn-outline-secondary btn-login-nav btn-sm rounded-pill px-3 py-2 fw-medium text-dark border-1" data-bs-toggle="modal" data-bs-target="#memberLoginModal">
                    <i class="bi bi-person-lock me-1"></i> Login
                </button>
                <button type="button" class="btn btn-elite-primary btn-sm px-3 py-2" data-bs-toggle="modal" data-bs-target="#consultationModal">
                    <i class="bi bi-person-plus-fill me-1"></i> Register Profile
                </button>
            </div>
        </div>
    </div>
</nav>
