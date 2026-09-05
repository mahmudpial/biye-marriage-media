@extends('layouts.app')

@section('title', 'Success Stories - Celebrated Marriages in Bangladesh | Biye Marriage Media')

@section('content')

<!-- Stories Hero -->
<section class="py-5" style="background: linear-gradient(135deg, #440710 0%, #751423 50%, #2a050b 100%); color: #fff;">
    <div class="container text-center py-4">
        <span class="hero-crest-badge">
            <i class="bi bi-heart-fill text-gold"></i> Timeless Bangladeshi Nuptials
        </span>
        <h1 class="display-5 font-serif fw-bold text-white mb-3">Biye Marriage Media Success Stories</h1>
        <p class="fs-5 text-white-50 mx-auto" style="max-width: 720px;">
            Celebrating the joyous unions of prominent business families, accomplished leaders, and distinguished individuals brought together through our discreet family concierge.
        </p>
    </div>
</section>

<!-- Stories Grid -->
<section class="section-padding bg-soft">
    <div class="container">
        <div class="row g-4">
            @foreach($stories as $story)
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 border border-warning-subtle">
                    <div class="row g-0 h-100">
                        <div class="col-md-5 position-relative">
                            <img src="{{ $story['image'] }}" alt="{{ $story['names'] }}" class="img-fluid h-100 w-100 object-fit-cover" style="min-height: 280px;">
                            <span class="badge bg-maroon position-absolute top-0 start-0 m-3 px-2 py-1 small">
                                Verified Alliance
                            </span>
                        </div>
                        <div class="col-md-7 p-4 d-flex flex-direction-column justify-content-between">
                            <div>
                                <span class="badge bg-gold-subtle text-dark border border-warning-subtle small mb-2">
                                    {{ $story['year'] }}
                                </span>
                                <h4 class="font-serif fw-bold text-maroon mb-1">{{ $story['names'] }}</h4>
                                <p class="small text-gold fw-semibold mb-2">{{ $story['titles'] }}</p>
                                <p class="small text-muted mb-3"><i class="bi bi-geo-alt-fill text-maroon me-1"></i>{{ $story['locations'] }}</p>
                                <p class="small text-secondary fst-italic">
                                    "{{ $story['quote'] }}"
                                </p>
                            </div>
                            <div class="pt-3 border-top mt-3 d-flex justify-content-between align-items-center">
                                <span class="small text-muted"><i class="bi bi-person-check text-success me-1"></i> Facilitated by Biye Marriage Media Concierge</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Video Testimonial Banner -->
        <div class="mt-5 p-5 rounded-4 text-center text-white" style="background: linear-gradient(135deg, var(--elite-maroon-dark), #33050c); border: 2px solid var(--elite-gold-primary);">
            <i class="bi bi-stars text-gold display-5 mb-3 d-block"></i>
            <h3 class="font-serif fw-bold mb-2">Ready to Write Your Own Family Success Story?</h3>
            <p class="text-white-50 mx-auto mb-4" style="max-width: 600px;">
                Join over 25,000 distinguished Bangladeshi families who trusted Biye Marriage Media for life's most momentous alliance.
            </p>
            <button type="button" class="btn btn-elite-gold px-4 py-2" data-bs-toggle="modal" data-bs-target="#consultationModal">
                <i class="bi bi-calendar-event me-2"></i> Arrange a Private Family Consultation
            </button>
        </div>
    </div>
</section>

@endsection
