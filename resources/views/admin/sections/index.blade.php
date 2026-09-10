@extends('admin.layouts.app')

@section('title', 'Page Content & Sections CMS Studio')
@section('page-title', 'Page Content & Sections CMS Studio')

@section('content')
<div class="container-fluid px-0">

    <!-- Executive Metrics Overview -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="section-card p-3 d-flex align-items-center gap-3">
                <div class="metric-icon-box" style="background: rgba(212, 175, 55, 0.15); color: var(--accent-gold); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; border: 1px solid var(--border-gold);">
                    <i class="bi bi-grid-fill"></i>
                </div>
                <div>
                    <div class="fs-4 fw-bold text-white mb-0">{{ count($sections) + 1 }}</div>
                    <div class="small text-silver">Total CMS Modules</div>
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
                    <div class="small text-silver">Homepage Live Sections</div>
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
                    <div class="small text-silver">Brand &amp; Communications</div>
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
                    <div class="small text-silver">Dynamic CMS Coverage</div>
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
                    <span class="badge rounded-pill px-2.5 py-1" style="background: rgba(255, 255, 255, 0.05); color: #94a3b8; border: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.72rem; letter-spacing: 0.4px;">
                        {{ $section['category'] }}
                    </span>
                </div>

                <!-- Section Title & Meta -->
                <div class="mb-1 text-gold fw-semibold small d-flex align-items-center gap-1" style="color: var(--theme-secondary, #d4af37) !important; font-size: 0.78rem; letter-spacing: 0.4px;">
                    <i class="bi bi-circle-fill me-1" style="font-size: 0.4rem; opacity: 0.75;"></i>
                    <span>{{ $section['nav_label'] }}</span>
                </div>
                <h5 class="fw-bold font-serif mb-2" style="color: #f1f5f9; font-size: 1.15rem; letter-spacing: -0.01em;">{{ $section['title'] }}</h5>
                <p class="small mb-4 flex-grow-1" style="color: #94a3b8; line-height: 1.6; font-size: 0.88rem;">
                    {{ $section['description'] }}
                </p>

                <!-- Card Footer & Action Button -->
                <div class="pt-3 border-top border-secondary border-opacity-10 d-flex align-items-center justify-content-between">
                    <span class="badge bg-dark text-muted-custom border border-secondary border-opacity-25 px-2.5 py-1 small" style="font-size: 0.7rem; font-weight: 500;">
                        <i class="bi bi-check2-circle text-success me-1"></i> {{ $section['badge'] }}
                    </span>
                    <a href="{{ route('admin.sections.edit', $section['key']) }}" class="btn btn-sm btn-manage-section px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5">
                        <span>Manage Section</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach

        <!-- FAQs & Knowledgebase CMS Hub Card -->
        <div class="col-xl-4 col-md-6 d-flex">
            <div class="section-card w-100 d-flex flex-column p-4 position-relative section-module-card">
                <!-- Top Card Row: Icon & Category Badge -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="section-card-icon-frame">
                        <i class="bi bi-question-diamond-fill"></i>
                    </div>
                    <span class="badge rounded-pill px-2.5 py-1" style="background: rgba(255, 255, 255, 0.05); color: #94a3b8; border: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.72rem; letter-spacing: 0.4px;">
                        Client Assurance
                    </span>
                </div>

                <!-- Section Title & Meta -->
                <div class="mb-1 text-gold fw-semibold small d-flex align-items-center gap-1" style="color: var(--theme-secondary, #d4af37) !important; font-size: 0.78rem; letter-spacing: 0.4px;">
                    <i class="bi bi-circle-fill me-1" style="font-size: 0.4rem; opacity: 0.75;"></i>
                    <span>FAQs &amp; Helpdesk</span>
                </div>
                <h5 class="fw-bold font-serif mb-2" style="color: #f1f5f9; font-size: 1.15rem; letter-spacing: -0.01em;">FAQs &amp; Knowledgebase</h5>
                <p class="small mb-4 flex-grow-1" style="color: #94a3b8; line-height: 1.6; font-size: 0.88rem;">
                    Matrimonial trust, confidentiality assurances, packages questions, and process clarifications displayed on public portal.
                </p>

                <!-- Card Footer & Action Button -->
                <div class="pt-3 border-top border-secondary border-opacity-10 d-flex align-items-center justify-content-between">
                    <span class="badge bg-dark text-muted-custom border border-secondary border-opacity-25 px-2.5 py-1 small" style="font-size: 0.7rem; font-weight: 500;">
                        <i class="bi bi-patch-question-fill text-warning me-1"></i> Knowledgebase
                    </span>
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-sm btn-manage-section px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1.5">
                        <span>Manage FAQs</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .section-module-card {
        background: #141820;
        background: linear-gradient(180deg, #171c26 0%, #131720 100%);
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 16px;
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.25s ease;
    }
    .section-module-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 32px -4px rgba(0, 0, 0, 0.5), 0 0 20px -3px rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.15);
        border-color: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.35);
    }
    .section-card-icon-frame {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        background: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.1);
        border: 1px solid rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.22);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--theme-secondary, #d4af37);
        transition: transform 0.25s ease;
    }
    .section-module-card:hover .section-card-icon-frame {
        transform: scale(1.05);
        border-color: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.4);
    }
    .btn-manage-section {
        background: rgba(var(--theme-primary-rgb, 133, 24, 41), 0.22);
        color: #fce7a1;
        border: 1px solid rgba(var(--theme-primary-rgb, 133, 24, 41), 0.5);
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .btn-manage-section:hover {
        background: var(--theme-primary, #851829);
        color: #ffffff;
        border-color: var(--theme-primary, #851829);
        box-shadow: 0 4px 14px rgba(var(--theme-primary-rgb, 133, 24, 41), 0.4);
    }
</style>
@endpush
@endsection
