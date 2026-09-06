<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Biye Marriage Media - Find Your Perfect Life Partner with Trust & Confidentiality')</title>
    <meta name="description" content="Biye Marriage Media provides 100% confidential and professional matchmaking services in Bangladesh and overseas. Discover verified profiles and find your perfect life partner based on Islamic values and family compatibility.">

    <!-- Favicon / Site Icon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('site-logo/marriage-logo.jpeg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('site-logo/marriage-logo.jpeg') }}">
    <link rel="apple-touch-icon" href="{{ asset('site-logo/marriage-logo.jpeg') }}">

    <!-- OpenGraph -->
    <meta property="og:title" content="Biye Marriage Media - Find Your Perfect Life Partner with Trust & Confidentiality">
    <meta property="og:description" content="Biye Marriage Media provides 100% confidential and professional matchmaking services in Bangladesh and overseas. Discover verified profiles and find your perfect life partner based on Islamic values and family compatibility.">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('site-logo/marriage-logo.jpeg') }}">

    <!-- Google Fonts: Playfair Display, Poppins, Great Vibes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,400;1,600&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Elite Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/elite-theme.css') }}">
    
    @stack('styles')
</head>
<body>

    <!-- Top Priority VIP Helpdesk Bar (Bangladesh) -->
    <div class="elite-topbar">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-shield-check text-gold me-1"></i> 100% Confidential Service</span>
                <span class="d-none d-md-inline topbar-divider">|</span>
                <span class="d-none d-md-inline text-gold fw-medium"><i class="bi bi-heart-fill me-1"></i> বিশ্বাসের বন্ধনে, সুন্দর আগামী</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="tel:+8801577723404"><i class="bi bi-telephone-fill text-gold me-1"></i> +880 1577-723404</a>
                <span class="topbar-divider">|</span>
                <a href="https://wa.me/8801577723404" target="_blank"><i class="bi bi-whatsapp text-success me-1"></i> VIP WhatsApp</a>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    @include('components.navbar')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer Component -->
    @include('components.footer')

    <!-- VIP Modals -->
    @include('components.lead-modal')
    @include('components.login-modal')

    <!-- Success Feedback Modal (If Submitted) -->
    @if(session('success_modal'))
    <div class="modal fade show d-block" id="successCallbackModal" tabindex="-1" style="background: rgba(0,0,0,0.65);" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4 border-gold" style="border-radius: 16px;">
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <i class="bi bi-check-circle-fill text-success display-3"></i>
                    </div>
                    <h3 class="font-serif text-maroon mb-2">Inquiry Received Discreetly</h3>
                    <p class="text-muted mb-4">
                        Thank you, <strong>{{ session('consultation_name') }}</strong>. A Senior Relationship Manager from our Dhaka VIP Concierge Desk will reach out to you within 24 hours to coordinate your confidential in-home or private club consultation.
                    </p>
                    <a href="{{ route('home') }}" class="btn btn-elite-primary px-4">Continue Browsing</a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Bootstrap 5.3.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom Interaction Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Discreet Profile Blur Toggle
            const toggleButtons = document.querySelectorAll('.btn-toggle-discreet');
            toggleButtons.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const card = this.closest('.elite-profile-card');
                    const img = card.querySelector('.profile-img');
                    const overlay = card.querySelector('.profile-privacy-overlay');
                    
                    if (img.classList.contains('discreet-blur')) {
                        img.classList.remove('discreet-blur');
                        if (overlay) overlay.style.display = 'none';
                        this.innerHTML = '<i class="bi bi-eye-slash me-1"></i> Shield Photo';
                    } else {
                        img.classList.add('discreet-blur');
                        if (overlay) overlay.style.display = 'flex';
                        this.innerHTML = '<i class="bi bi-eye me-1"></i> Preview Profile';
                    }
                });
            });

            // Auto open login modal if ?login=1 is in URL
            if (new URLSearchParams(window.location.search).has('login')) {
                const loginModalEl = document.getElementById('memberLoginModal');
                if (loginModalEl) {
                    new bootstrap.Modal(loginModalEl).show();
                }
            }

            // Auto dismiss flash modal on outside click
            const successModal = document.getElementById('successCallbackModal');
            if (successModal) {
                successModal.addEventListener('click', function(e) {
                    if (e.target === successModal) {
                        successModal.remove();
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
