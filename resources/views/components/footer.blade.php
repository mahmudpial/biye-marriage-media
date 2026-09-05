<footer class="elite-footer">
    <div class="container">
        <div class="row g-4 mb-5">
            <!-- Brand Column -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <div class="brand-logo-frame me-2">
                        <img src="{{ asset('site-logo/marriage-logo.jpeg') }}" alt="Biye Marriage Media Logo">
                    </div>
                    <div>
                        <span class="footer-brand-title d-block">Biye Marriage Media</span>
                        <small class="text-gold" style="font-size: 0.8rem; letter-spacing: 0.5px;">বিশ্বাসের বন্ধনে, সুন্দর আগামী</small>
                    </div>
                </div>
                <p class="text-light-50 mb-3" style="font-size: 0.92rem; color: #b3b8c4;">
                    Professional bride and groom matching in Bangladesh and overseas. We prioritize Islamic values and family compatibility to help you find your ideal life partner with 100% confidentiality.
                </p>
                <div class="footer-social-row mt-3">
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="footer-social-icon footer-social-fb" aria-label="Facebook Page">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="footer-social-icon footer-social-insta" aria-label="Instagram Profile">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://wa.me/8801577711210" target="_blank" rel="noopener noreferrer" class="footer-social-icon footer-social-wa" aria-label="WhatsApp Concierge">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 col-6">
                <h5 class="footer-heading">Quick Links</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}"><i class="bi bi-chevron-right text-gold me-2"></i>Home</a></li>
                    <li><a href="{{ route('about') }}"><i class="bi bi-chevron-right text-gold me-2"></i>About</a></li>
                    <li><a href="{{ route('profiles') }}"><i class="bi bi-chevron-right text-gold me-2"></i>Profile</a></li>
                    <li><a href="{{ route('stories') }}"><i class="bi bi-chevron-right text-gold me-2"></i>Stories</a></li>
                    <li><a href="{{ route('contact') }}"><i class="bi bi-chevron-right text-gold me-2"></i>Contact</a></li>
                </ul>
            </div>

            <!-- Head Office & Presence -->
            <div class="col-lg-3 col-md-6 col-6">
                <h5 class="footer-heading">Head Office</h5>
                <div class="small mb-3" style="color: #cbd2df; line-height: 1.6;">
                    <i class="bi bi-geo-alt-fill text-gold me-1"></i>
                    <strong>Kuril Chowrasta Office:</strong><br>
                    Ka-57/3, Second Floor, Kuril Chowrasta, Vatara, Dhaka, Bangladesh, 1212
                </div>
                <div class="small" style="color: #b3b8c4;">
                    <i class="bi bi-globe text-gold me-1"></i>
                    <a href="https://www.biyemarriagemedia.com" target="_blank" class="text-gold text-decoration-none">www.biyemarriagemedia.com</a>
                </div>
                <div class="mt-2 small text-light-50">
                    Services: Bangladesh & Overseas Matchmaking
                </div>
            </div>

            <!-- Priority Contact Helpline -->
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-heading">Contact & Helpline</h5>
                <p class="small mb-2" style="color: #b3b8c4;">Speak directly with our matrimonial consultants:</p>
                <div class="mb-2">
                    <a href="tel:+8801577711210" class="footer-contact-link d-flex align-items-center gap-2 text-gold fw-semibold fs-6 text-decoration-none">
                        <i class="bi bi-telephone-outbound-fill"></i>
                        <span>+880 1577-711210</span>
                    </a>
                    <a href="tel:+8801577733404" class="footer-contact-link d-flex align-items-center gap-2 text-gold fw-semibold fs-6 text-decoration-none mt-1">
                        <i class="bi bi-telephone-fill"></i>
                        <span>+880 1577-733404</span>
                    </a>
                </div>
                <div class="mb-2">
                    <a href="https://wa.me/8801577711210" target="_blank" class="footer-contact-link d-flex align-items-center gap-2 text-success fw-medium text-decoration-none small">
                        <i class="bi bi-whatsapp"></i>
                        <span>WhatsApp Concierge</span>
                    </a>
                </div>
                <div class="mb-3">
                    <a href="mailto:biyemarriagemedia@gmail.com" class="footer-contact-link d-flex align-items-center gap-2 text-light fw-medium text-decoration-none small">
                        <i class="bi bi-envelope-fill text-gold"></i>
                        <span>biyemarriagemedia@gmail.com</span>
                    </a>
                </div>
                <div class="p-2 px-3 rounded" style="background: rgba(201, 151, 56, 0.1); border: 1px dashed rgba(201, 151, 56, 0.35);">
                    <div class="small text-gold fw-semibold"><i class="bi bi-check-circle-fill me-1"></i> 100% Confidential</div>
                    <span class="small" style="color: #cbd2df; font-size: 0.8rem;">Islamic Values & Verified Matchmaking</span>
                </div>
            </div>
        </div>

        <hr class="footer-divider">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 pt-2 text-white-50 small">
            <div>
                © {{ date('Y') }} Biye Marriage Media. All rights reserved. Private family matchmaking services.
            </div>
            <div class="d-flex gap-3">
                <a href="{{ route('about') }}" class="text-white-50 text-decoration-none">Privacy & Purdah Pledge</a>
                <span>•</span>
                <a href="{{ route('about') }}" class="text-white-50 text-decoration-none">NID Verification Standard</a>
                <span>•</span>
                <a href="{{ route('contact') }}" class="text-white-50 text-decoration-none">Terms of Confidentiality</a>
            </div>
        </div>
    </div>
</footer>
