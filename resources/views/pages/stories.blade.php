@extends('layouts.app')

@section('title', 'সাকসেস স্টোরিজ - Biye Marriage Media | Celebrated Matrimonial Alliances')

@section('content')

<!-- Stories Hero Banner -->
<section class="stories-hero-section position-relative text-center text-white overflow-hidden">
    <div class="stories-hero-overlay"></div>
    <div class="container position-relative py-5">
        <div class="mx-auto" style="max-width: 820px;">
            <div class="d-inline-flex align-items-center gap-2 px-3.5 py-1.5 rounded-pill mb-3 stories-crest-badge">
                <i class="bi bi-heart-fill text-gold"></i>
                <span class="fw-semibold small tracking-wide">Timeless Nuptials &amp; Sacred Alliances</span>
            </div>
            
            <h1 class="display-5 font-serif fw-bold text-white mb-3 lh-sm">
                Biye Marriage Media Success Stories
            </h1>
            
            <p class="text-white-50 fs-6 mx-auto mb-4" style="max-width: 720px; line-height: 1.75;">
                Celebrating the joyful unions of prominent business families, esteemed civil service leaders, respected physicians, and accomplished global NRB individuals united through our discreet, trusted family concierge.
            </p>

            <!-- Key Trust Metrics Strip -->
            <div class="row g-2 justify-content-center pt-2">
                <div class="col-6 col-md-3">
                    <div class="stories-stat-pill">
                        <span class="stat-number font-serif">2,500+</span>
                        <span class="stat-label">Alliances Formed</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stories-stat-pill">
                        <span class="stat-number font-serif">100%</span>
                        <span class="stat-label">Confidential &amp; Private</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stories-stat-pill">
                        <span class="stat-number font-serif">12+ Yrs</span>
                        <span class="stat-label">Matrimonial Trust</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stories-stat-pill">
                        <span class="stat-number font-serif">Global</span>
                        <span class="stat-label">BD &amp; NRB Desks</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stories Grid Showcase Section -->
<section class="py-5" style="background-color: #fdfbf7;">
    <div class="container py-3">
        <!-- Section Subheading -->
        <div class="text-center mb-5">
            <span class="badge bg-gold-subtle text-dark border border-warning-subtle px-3 py-1.5 rounded-pill small fw-semibold text-uppercase mb-2">
                <i class="bi bi-stars text-gold me-1"></i> Real Journeys of Union
            </span>
            <h2 class="font-serif fw-bold text-maroon display-6 mb-2">
                Featured Family Alliances
            </h2>
            <p class="text-secondary small mx-auto" style="max-width: 580px;">
                Read how our Senior Matchmakers and Relationship Managers facilitated seamless introductions respecting heritage, lifestyle, and privacy.
            </p>
            <div class="divider-gold mx-auto mt-2"></div>
        </div>

        <!-- 2-Column Responsive Card Grid -->
        <div class="row g-4 justify-content-center">
            @foreach($stories as $story)
                @php
                    $names = data_get($story, 'names');
                    $titles = data_get($story, 'titles');
                    $locations = data_get($story, 'locations');
                    $image = data_get($story, 'image');
                    $quote = data_get($story, 'quote');
                    $year = data_get($story, 'year');
                @endphp
                <div class="col-12 col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 story-luxury-card bg-white d-flex flex-column">
                        <!-- Card Photo Banner (Equal Aspect Ratio & High Resolution) -->
                        <div class="story-img-container position-relative overflow-hidden">
                            <img src="{{ $image }}" alt="{{ $names }}" class="story-card-img w-100 h-100 object-fit-cover">
                            
                            <!-- Soft Gradient Vignette for Text Legibility -->
                            <div class="story-img-overlay"></div>

                            <!-- Top Badges -->
                            <div class="position-absolute top-0 start-0 end-0 p-3 d-flex justify-content-between align-items-center">
                                <span class="badge bg-maroon text-white border border-gold-subtle px-3 py-1.5 rounded-pill small shadow-sm">
                                    <i class="bi bi-patch-check-fill text-gold me-1"></i> Verified Alliance
                                </span>
                                <span class="badge bg-dark bg-opacity-75 text-white border border-secondary px-3 py-1.5 rounded-pill small backdrop-blur">
                                    <i class="bi bi-geo-alt-fill text-gold me-1"></i> {{ $locations }}
                                </span>
                            </div>

                            <!-- Bottom Ceremony Date Badge -->
                            <div class="position-absolute bottom-0 start-0 p-3">
                                <span class="badge bg-gold text-dark fw-semibold px-3 py-1.5 rounded-pill shadow-sm">
                                    <i class="bi bi-calendar2-heart-fill me-1 text-maroon"></i> {{ $year }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Body with Ample Breathing Room -->
                        <div class="card-body p-4 p-md-4 d-flex flex-column justify-content-between flex-grow-1">
                            <div>
                                <!-- Couple Title & Designation -->
                                <h3 class="font-serif fw-bold text-maroon mb-1 fs-4">
                                    {{ $names }}
                                </h3>
                                <div class="d-flex align-items-center gap-1.5 text-secondary small fw-medium mb-3">
                                    <i class="bi bi-mortarboard-fill text-gold"></i>
                                    <span>{{ $titles }}</span>
                                </div>

                                <!-- Pull Quote Block -->
                                <div class="story-quote-box p-3 rounded-3 position-relative mb-3">
                                    <i class="bi bi-quote text-gold fs-1 position-absolute top-0 end-0 me-3 mt-0 opacity-25"></i>
                                    <p class="fst-italic text-dark mb-0 small" style="line-height: 1.7; position: relative; z-index: 1;">
                                        &ldquo;{{ $quote }}&rdquo;
                                    </p>
                                </div>
                            </div>

                            <!-- Facilitation Footer -->
                            <div class="pt-3 border-top mt-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="concierge-icon-circle rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-shield-lock-fill text-maroon fs-6"></i>
                                    </div>
                                    <span class="small fw-semibold text-dark" style="font-size: 0.82rem;">
                                        Facilitated by Biye Marriage Media Concierge
                                    </span>
                                </div>
                                <span class="badge bg-light text-muted border border-secondary-subtle px-2.5 py-1 rounded-pill small" style="font-size: 0.72rem;">
                                    <i class="bi bi-check2-all text-success me-1"></i> Family Consented
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Trust Assurance 3-Column Highlights -->
        <div class="row g-4 mt-5 pt-2">
            <div class="col-12 col-md-4">
                <div class="p-4 bg-white rounded-4 border border-warning-subtle shadow-sm h-100 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light p-3 text-maroon mb-3 shadow-xs" style="width: 54px; height: 54px;">
                        <i class="bi bi-shield-fill-check fs-4"></i>
                    </div>
                    <h5 class="font-serif fw-bold text-dark mb-2">Strict Bilateral Consent</h5>
                    <p class="text-secondary small mb-0" style="line-height: 1.65;">
                        Photographs, identities, and family details are showcased solely after explicit written authorization from both allied families.
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="p-4 bg-white rounded-4 border border-warning-subtle shadow-sm h-100 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light p-3 text-gold mb-3 shadow-xs" style="width: 54px; height: 54px;">
                        <i class="bi bi-person-hearts fs-4"></i>
                    </div>
                    <h5 class="font-serif fw-bold text-dark mb-2">In-Person Family Etiquette</h5>
                    <p class="text-secondary small mb-0" style="line-height: 1.65;">
                        From initial in-home discussions to meeting arrangements at 5-star venues (Radisson, Westin), our matchmakers manage all nuances.
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="p-4 bg-white rounded-4 border border-warning-subtle shadow-sm h-100 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light p-3 text-maroon mb-3 shadow-xs" style="width: 54px; height: 54px;">
                        <i class="bi bi-globe-americas fs-4"></i>
                    </div>
                    <h5 class="font-serif fw-bold text-dark mb-2">Global NRB Cross-Border Desks</h5>
                    <p class="text-secondary small mb-0" style="line-height: 1.65;">
                        Connecting high-achieving Bangladeshi diaspora in London, New York, Toronto, and Sydney with premier families back home.
                    </p>
                </div>
            </div>
        </div>

        <!-- VIP CTA Invitation Banner -->
        <div class="mt-5 p-4 p-md-5 rounded-4 text-center text-white position-relative overflow-hidden stories-cta-card">
            <div class="position-relative z-1">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white text-gold p-2 mb-3 shadow-sm" style="width: 54px; height: 54px;">
                    <i class="bi bi-gem fs-3"></i>
                </div>
                <h3 class="font-serif fw-bold mb-2 display-6">
                    Ready to Begin Your Family's Sacred Journey?
                </h3>
                <p class="text-white-50 mx-auto mb-4" style="max-width: 620px; line-height: 1.7;">
                    Join over 25,000 distinguished Bangladeshi and NRB families who entrusted Biye Marriage Media for life's most momentous decision.
                </p>
                <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                    <button type="button" class="btn btn-elite-gold px-4 py-2.5 rounded-pill fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#consultationModal">
                        <i class="bi bi-calendar2-check-fill me-2"></i> Request Confidential Consultation
                    </button>
                    <a href="{{ route('register') }}" class="btn btn-outline-light px-4 py-2.5 rounded-pill fw-semibold">
                        <i class="bi bi-person-plus-fill me-2"></i> Register Member Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Stories Hero Section */
.stories-hero-section {
    background: radial-gradient(circle at 50% 20%, rgba(201, 151, 56, 0.2) 0%, transparent 60%),
                linear-gradient(135deg, #3d0710 0%, #681220 50%, #200408 100%);
    padding: 70px 0 60px;
    border-bottom: 2px solid rgba(201, 151, 56, 0.25);
}

.stories-crest-badge {
    background: rgba(201, 151, 56, 0.16);
    border: 1px solid rgba(201, 151, 56, 0.45);
    color: #f7dfa5;
    letter-spacing: 0.5px;
    backdrop-filter: blur(8px);
}

.stories-stat-pill {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 14px;
    padding: 12px 14px;
    backdrop-filter: blur(6px);
    transition: all 0.3s ease;
}
.stories-stat-pill:hover {
    background: rgba(255, 255, 255, 0.14);
    border-color: var(--elite-gold-primary, #c99738);
    transform: translateY(-2px);
}
.stories-stat-pill .stat-number {
    display: block;
    font-size: 1.35rem;
    font-weight: 700;
    color: #f7dfa5;
    line-height: 1.2;
}
.stories-stat-pill .stat-label {
    display: block;
    font-size: 0.76rem;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Luxury Story Card Box Model */
.story-luxury-card {
    border: 1.5px solid rgba(201, 151, 56, 0.28) !important;
    transition: transform 0.35s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.35s ease;
}
.story-luxury-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 36px rgba(68, 7, 16, 0.14) !important;
    border-color: rgba(201, 151, 56, 0.6) !important;
}

.story-img-container {
    height: 310px;
    background-color: #f0ebe4;
}
.story-card-img {
    transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
}
.story-luxury-card:hover .story-card-img {
    transform: scale(1.05);
}

.story-img-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(16, 3, 5, 0.65) 0%, rgba(16, 3, 5, 0.1) 40%, transparent 100%);
    pointer-events: none;
}

/* Quote Styling */
.story-quote-box {
    background-color: #fcf9f5;
    border-left: 3.5px solid var(--theme-primary, #851829);
    border-radius: 8px;
}

.concierge-icon-circle {
    width: 30px;
    height: 30px;
    background: rgba(133, 24, 41, 0.08);
    flex-shrink: 0;
}

.divider-gold {
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, transparent, #c99738, transparent);
    border-radius: 2px;
}

.stories-cta-card {
    background: linear-gradient(135deg, #440710 0%, #29040a 100%);
    border: 2px solid rgba(201, 151, 56, 0.45);
    box-shadow: 0 12px 30px rgba(68, 7, 16, 0.2);
}

.backdrop-blur {
    backdrop-filter: blur(6px);
}
</style>

@endsection
