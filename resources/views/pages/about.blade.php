@extends('layouts.app')

@section('title', 'About Us - Biye Marriage Media | বিশ্বাসের বন্ধনে, সুন্দর আগামী')

@section('content')

<!-- About Hero -->
<section class="py-5" style="background: linear-gradient(135deg, #440710 0%, #751423 50%, #2a050b 100%); color: #fff;">
    <div class="container text-center py-4">
        <span class="hero-crest-badge">
            <i class="bi bi-shield-check text-gold"></i> {{ site_setting('about_hero_badge', 'বিশ্বাসের বন্ধনে, সুন্দর আগামী') }}
        </span>
        <h1 class="display-5 font-serif fw-bold text-white mb-3">{{ site_setting('about_hero_title', 'About Biye Marriage Media') }}</h1>
        <p class="fs-5 text-white-50 mx-auto" style="max-width: 760px;">
            {{ site_setting('about_hero_subtitle', 'Professional bride and groom matching in Bangladesh and overseas. We prioritize Islamic values and family compatibility to help you find your ideal life partner.') }}
        </p>
    </div>
</section>

<!-- Company Heritage -->
<section class="section-padding bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-tag">{{ site_setting('about_heritage_tag', 'About Biye Marriage Media') }}</span>
                <h2 class="section-title">{{ site_setting('about_heritage_title', 'Built on Trust, Islamic Values & Deep Family Compatibility') }}</h2>
                <p class="text-secondary leading-relaxed mb-4">
                    {{ site_setting('about_heritage_p1', 'At Biye Marriage Media, we believe that a successful marriage is built on trust, Islamic values, and deep family compatibility. We operate as professional marriage consultants dedicated to providing a safe, secure, and 100% confidential platform for bride and groom matching.') }}
                </p>
                <p class="text-secondary leading-relaxed mb-4">
                    {{ site_setting('about_heritage_p2', 'Whether you are looking for a match within Bangladesh or seeking expatriate profiles overseas, our verified matchmaking process ensures you find the perfect life partner with complete peace of mind. We understand that finding a life partner is a deeply sacred family journey that demands the highest standards of discretion and respect.') }}
                </p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 rounded border border-warning-subtle bg-gold-subtle">
                            <h4 class="font-serif text-maroon mb-1">100%</h4>
                            <span class="small text-muted">Confidential & Secure</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded border border-warning-subtle bg-gold-subtle">
                            <h4 class="font-serif text-maroon mb-1">Global</h4>
                            <span class="small text-muted">Bangladesh & Overseas NRBs</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="{{ site_setting_image('about_wedding_image', 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1000&q=80') }}" alt="Bangladeshi Wedding" class="img-fluid rounded-4 shadow-lg" style="height: 420px; width: 100%; object-fit: cover;">
                    <div class="position-absolute bottom-0 start-0 end-0 p-4 bg-dark bg-opacity-75 text-white rounded-bottom-4">
                        <p class="fst-italic mb-0 small">
                            {{ site_setting('about_wedding_quote', '"বিশ্বাসের বন্ধনে, সুন্দর আগামী — Dedicated to creating blessed, honorable, and lifelong marital unions."') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- The Elite Advantage Pillars -->
<section class="section-padding bg-soft">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">{{ site_setting('about_pillars_tag', 'Core Principles') }}</span>
            <h2 class="section-title">{{ site_setting('about_pillars_title', 'The Cornerstones of Our Service') }}</h2>
            <p class="section-desc">
                {{ site_setting('about_pillars_desc', 'Every member experiences our three unshakeable commitments to prestige and privacy.') }}
            </p>
        </div>

        <div class="row g-4">
            @foreach(site_setting_json('about_pillars') as $pillar)
            <div class="col-lg-4">
                <div class="pillar-card text-center p-4">
                    <div class="pillar-icon-box mx-auto">
                        <i class="bi {{ $pillar['icon'] ?? 'bi-patch-check-fill' }}"></i>
                    </div>
                    <h4 class="pillar-title">{{ $pillar['title'] ?? '' }}</h4>
                    <p class="pillar-desc">
                        {{ $pillar['desc'] ?? '' }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Relationship Manager Network in Bangladesh -->
<section class="section-padding bg-white">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-lg-2">
                <span class="section-tag">{{ site_setting('about_concierge_tag', 'Personalized Concierge') }}</span>
                <h2 class="section-title">{{ site_setting('about_concierge_title', 'Your Private Matchmaker & Family Confidant') }}</h2>
                <p class="text-secondary leading-relaxed mb-4">
                    {{ site_setting('about_concierge_desc', 'Finding the right life partner is a deeply personal and family-centered journey. Our matchmakers act as private advisors:') }}
                </p>
                <ul class="list-unstyled mb-4">
                    @foreach(site_setting_json('about_concierge_points') as $point)
                    <li class="d-flex align-items-start gap-3 mb-3">
                        <i class="bi bi-check-circle-fill text-maroon fs-5 mt-1"></i>
                        <div>
                            <strong>{{ $point['title'] ?? '' }}:</strong> {{ $point['desc'] ?? '' }}
                        </div>
                    </li>
                    @endforeach
                </ul>

                <button type="button" class="btn btn-elite-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#consultationModal">
                    <i class="bi bi-person-lines-fill me-1"></i> Request a Matchmaker Call
                </button>
            </div>

            <div class="col-lg-6 order-lg-1">
                <img src="{{ site_setting_image('about_concierge_image', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=1000&q=80') }}" alt="Executive Matchmaker" class="img-fluid rounded-4 shadow" style="height: 420px; width: 100%; object-fit: cover;">
            </div>
        </div>
    </div>
</section>

<!-- Bottom CTA -->
<section class="py-5 bg-maroon text-white text-center">
    <div class="container py-3">
        <h3 class="font-serif fw-bold mb-2">Speak to Our Dhaka Matchmaking Directorate</h3>
        <p class="text-white-50 mb-4">{{ site_setting('office_address', 'Ka-57/3, Second Floor, Kuril Chowrasta, Vatara, Dhaka, Bangladesh, 1212') }}</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <button type="button" class="btn btn-elite-gold px-4 py-2" data-bs-toggle="modal" data-bs-target="#consultationModal">
                <i class="bi bi-calendar2-check me-1"></i> Schedule Private Family Consultation
            </button>
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', site_setting('contact_phone', '+8801577723404')) }}" class="btn btn-elite-outline-gold px-4 py-2">
                <i class="bi bi-telephone-fill me-1"></i> {{ site_setting('contact_phone', '+880 1577-723404') }}
            </a>
            <a href="https://wa.me/{{ site_setting('whatsapp_number', '8801577723404') }}" target="_blank" class="btn btn-outline-light px-4 py-2">
                <i class="bi bi-whatsapp text-success me-1"></i> WhatsApp
            </a>
        </div>
    </div>
</section>

@endsection
