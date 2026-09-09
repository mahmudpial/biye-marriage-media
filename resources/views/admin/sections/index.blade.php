@extends('admin.layouts.app')

@section('title', 'Page Content & Sections CMS Studio')
@section('page-title', 'Page Content & Sections CMS Studio')

@section('content')
<div class="container-fluid px-0">

    <!-- Header & Executive Controls -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-white mb-1 font-serif">Website Sections &amp; Page CMS Studio</h4>
            <p class="text-secondary small mb-0">
                Modular visual management suite. Select any website section below to customize headings, texts, images, and layout blocks.
            </p>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-warning text-gold border-opacity-50 btn-sm px-3 py-2">
                <i class="bi bi-globe2 me-1"></i> Live Homepage
            </a>
            <a href="{{ route('about') }}" target="_blank" class="btn btn-outline-light btn-sm px-3 py-2">
                <i class="bi bi-building me-1"></i> Live About Page
            </a>
            <a href="{{ route('contact') }}" target="_blank" class="btn btn-outline-light btn-sm px-3 py-2">
                <i class="bi bi-headset me-1"></i> Live Contact Page
            </a>
        </div>
    </div>

    <!-- Executive Metrics Overview -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="section-card p-3 d-flex align-items-center gap-3">
                <div class="metric-icon-box" style="background: rgba(212, 175, 55, 0.15); color: var(--accent-gold); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; border: 1px solid var(--border-gold);">
                    <i class="bi bi-grid-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-white mb-0">11</div>
                    <div class="small text-secondary">Total CMS Modules</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="section-card p-3 d-flex align-items-center gap-3">
                <div class="metric-icon-box" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; border: 1px solid rgba(59, 130, 246, 0.3);">
                    <i class="bi bi-house-door-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-white mb-0">5</div>
                    <div class="small text-secondary">Homepage Live Sections</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="section-card p-3 d-flex align-items-center gap-3">
                <div class="metric-icon-box" style="background: rgba(168, 85, 247, 0.15); color: #c084fc; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; border: 1px solid rgba(168, 85, 247, 0.3);">
                    <i class="bi bi-award-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-white mb-0">5</div>
                    <div class="small text-secondary">Brand &amp; Communications</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="section-card p-3 d-flex align-items-center gap-3">
                <div class="metric-icon-box" style="background: rgba(34, 197, 94, 0.15); color: #4ade80; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; border: 1px solid rgba(34, 197, 94, 0.3);">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-white mb-0">100%</div>
                    <div class="small text-secondary">Dynamic CMS Coverage</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Box Cards Section Grid -->
    <div class="row g-4">
        @foreach($sections as $key => $section)
        <div class="col-xl-4 col-md-6 d-flex">
            <div class="section-card w-100 d-flex flex-column p-4 position-relative section-module-card">
                <!-- Top Card Row: Icon & Category Badge -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="section-card-icon-frame">
                        <i class="bi {{ $section['icon'] }}"></i>
                    </div>
                    <span class="badge rounded-pill px-2.5 py-1 small" style="background: rgba(212, 175, 55, 0.12); color: var(--gold-light); border: 1px solid var(--border-gold); font-size: 0.72rem; letter-spacing: 0.4px;">
                        {{ $section['category'] }}
                    </span>
                </div>

                <!-- Section Title & Meta -->
                <div class="mb-1 text-gold fw-semibold small d-flex align-items-center gap-1">
                    <span>{{ $section['nav_label'] }}</span>
                </div>
                <h5 class="text-white fw-bold font-serif mb-2">{{ $section['title'] }}</h5>
                <p class="text-secondary small mb-4 flex-grow-1" style="line-height: 1.55;">
                    {{ $section['description'] }}
                </p>

                <!-- Card Footer & Action Button -->
                <div class="pt-3 border-top border-secondary border-opacity-10 d-flex align-items-center justify-content-between">
                    <span class="badge bg-dark text-muted-custom border border-secondary border-opacity-25 px-2 py-1 small" style="font-size: 0.7rem;">
                        <i class="bi bi-check2-circle text-success me-1"></i> {{ $section['badge'] }}
                    </span>
                    <a href="{{ route('admin.sections.edit', $section['key']) }}" class="btn btn-sm btn-admin-primary px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1">
                        <span>Manage Section</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

@push('styles')
<style>
    .section-module-card {
        transition: transform 0.22s ease, box-shadow 0.22s ease, border-color 0.22s ease;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    .section-module-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        border-color: rgba(212, 175, 55, 0.4);
    }
    .section-card-icon-frame {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.2) 0%, rgba(20, 3, 9, 0.4) 100%);
        border: 1px solid rgba(212, 175, 55, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--gold-light);
    }
</style>
@endpush
@endsection
