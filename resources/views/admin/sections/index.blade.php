@extends('admin.layouts.app')

@section('title', 'Page Content & Sections CMS Studio')
@section('page-title', 'Homepage & Content Sections CMS')

@push('styles')
<style>
    .section-card {
        background: #1c050e;
        border: 1px solid rgba(212, 175, 55, 0.25);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        padding: 2rem;
    }

    .section-nav-tabs {
        border-bottom: 1px solid rgba(212, 175, 55, 0.25);
        gap: 0.5rem;
    }
    .section-nav-tabs .nav-link {
        color: #94a3b8;
        font-weight: 600;
        font-size: 0.9rem;
        border: 1px solid transparent;
        border-radius: 12px 12px 0 0;
        padding: 0.75rem 1.25rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .section-nav-tabs .nav-link i {
        color: #d4af37;
    }
    .section-nav-tabs .nav-link:hover {
        color: #fef08a;
        background: rgba(212, 175, 55, 0.08);
        border-color: rgba(212, 175, 55, 0.2) rgba(212, 175, 55, 0.2) transparent;
    }
    .section-nav-tabs .nav-link.active {
        color: #ffffff;
        background: #1c050e;
        border-color: rgba(212, 175, 55, 0.35) rgba(212, 175, 55, 0.35) transparent;
        border-top: 3px solid #d4af37;
    }

    .form-section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #fef08a;
        border-bottom: 1px solid rgba(212, 175, 55, 0.25);
        padding-bottom: 0.65rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .form-section-title i {
        color: #d4af37;
    }

    .sub-item-card {
        background: #14030a;
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 12px;
        padding: 1.2rem;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
    }
    .sub-item-card:hover {
        border-color: rgba(212, 175, 55, 0.45);
        background: #1a040d;
    }
    .sub-item-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.85rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px dashed rgba(212, 175, 55, 0.25);
    }
    .sub-item-card-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #fde68a;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #fde68a;
        margin-bottom: 0.4rem;
        letter-spacing: 0.3px;
    }

    .form-control, .form-select {
        background: #0f0207 !important;
        border: 1px solid rgba(212, 175, 55, 0.35) !important;
        color: #ffffff !important;
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #f5d061 !important;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.25) !important;
    }
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.35) !important;
    }
    .form-text, .text-muted-custom {
        color: #cbd5e1 !important;
    }

    /* Live Preview */
    .live-preview-box {
        background: #14030a;
        border: 1px dashed rgba(212, 175, 55, 0.4);
        border-radius: 14px;
        padding: 1.25rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Header & Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h4 class="mb-1 text-white fw-bold">
                Homepage &amp; Content Sections CMS Studio
            </h4>
            <p class="text-secondary small mb-0">
                Customize landing page banners, value propositions, service pillars, process milestones, about heritage, and bottom CTAs.
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-dark border border-warning text-gold px-3 py-2">
                <i class="bi bi-layout-text-window-reverse me-1"></i> Full Section Engine
            </span>
        </div>
    </div>

    <!-- Main Content Form -->
    <form method="POST" action="{{ route('admin.sections.update') }}">
        @csrf

        <div class="row g-4">
            <!-- Left Column: Section Tabs & Editor -->
            <div class="col-lg-8">
                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs section-nav-tabs mb-0" id="sectionTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="hero-tab" data-bs-toggle="tab" data-bs-target="#heroSection" type="button" role="tab">
                            <i class="bi bi-stars"></i> Hero Section
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specialties-tab" data-bs-toggle="tab" data-bs-target="#specialtiesSection" type="button" role="tab">
                            <i class="bi bi-gem"></i> Specialties
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="process-tab" data-bs-toggle="tab" data-bs-target="#processSection" type="button" role="tab">
                            <i class="bi bi-signpost-split"></i> Process
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#aboutSection" type="button" role="tab">
                            <i class="bi bi-building"></i> About &amp; Pillars
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="finalcta-tab" data-bs-toggle="tab" data-bs-target="#finalCtaSection" type="button" role="tab">
                            <i class="bi bi-telephone-outbound"></i> Final CTA
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="footer-tab" data-bs-toggle="tab" data-bs-target="#footerSection" type="button" role="tab">
                            <i class="bi bi-card-text"></i> Footer Notes
                        </button>
                    </li>
                </ul>

                <!-- Tab Panes Card -->
                <div class="section-card rounded-top-0 mb-4">
                    <div class="tab-content" id="sectionTabsContent">
                        
                        <!-- TAB 1: Hero Section -->
                        <div class="tab-pane fade show active" id="heroSection" role="tabpanel">
                            <div class="form-section-title">
                                <i class="bi bi-stars"></i> Main Hero Title, Subtitle &amp; Highlights
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="hero_badge" class="form-label">Hero Crest Badge</label>
                                    <input 
                                        type="text" 
                                        name="hero_badge" 
                                        id="hero_badge" 
                                        class="form-control" 
                                        value="{{ old('hero_badge', $settings['hero_badge'] ?? '') }}"
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label for="hero_cta_primary_text" class="form-label">Primary Button Label</label>
                                    <input 
                                        type="text" 
                                        name="hero_cta_primary_text" 
                                        id="hero_cta_primary_text" 
                                        class="form-control" 
                                        value="{{ old('hero_cta_primary_text', $settings['hero_cta_primary_text'] ?? '') }}"
                                    >
                                </div>
                                <div class="col-12">
                                    <label for="hero_title" class="form-label">
                                        Hero Headline (HTML Allowed for Gold Highlights) <span class="text-danger">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="hero_title" 
                                        id="hero_title" 
                                        class="form-control" 
                                        value="{{ old('hero_title', $settings['hero_title'] ?? '') }}"
                                        required
                                    >
                                    <div class="form-text text-muted-custom small">
                                        Use <code>&lt;span class="text-gold font-serif fst-italic"&gt;Your Gold Text&lt;/span&gt;</code> for luxury accent words.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="hero_subtitle" class="form-label">Hero Introductory Subtitle <span class="text-danger">*</span></label>
                                    <textarea 
                                        name="hero_subtitle" 
                                        id="hero_subtitle" 
                                        rows="3" 
                                        class="form-control" 
                                        required
                                    >{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="form-section-title mt-4">
                                <i class="bi bi-grid-fill"></i> Hero 4-Value Feature Boxes
                            </div>

                            @foreach($heroFeatures as $idx => $feat)
                            <div class="sub-item-card">
                                <div class="sub-item-card-header">
                                    <span class="sub-item-card-title">
                                        <i class="bi {{ $feat['icon'] ?? 'bi-check-circle' }} text-gold"></i> Feature Box #{{ $idx + 1 }}
                                    </span>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label class="form-label small">Bootstrap Icon</label>
                                        <input type="text" name="hero_features[{{ $idx }}][icon]" class="form-control form-control-sm" value="{{ $feat['icon'] ?? '' }}">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label small">Feature Title</label>
                                        <input type="text" name="hero_features[{{ $idx }}][title]" class="form-control form-control-sm" value="{{ $feat['title'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small">Short Description</label>
                                        <input type="text" name="hero_features[{{ $idx }}][desc]" class="form-control form-control-sm" value="{{ $feat['desc'] ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- TAB 2: Our Specialties -->
                        <div class="tab-pane fade" id="specialtiesSection" role="tabpanel">
                            <div class="form-section-title">
                                <i class="bi bi-gem"></i> Our Specialties Header
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label for="specialties_tag" class="form-label">Section Pill Tag</label>
                                    <input type="text" name="specialties_tag" id="specialties_tag" class="form-control" value="{{ old('specialties_tag', $settings['specialties_tag'] ?? '') }}">
                                </div>
                                <div class="col-md-8">
                                    <label for="specialties_title" class="form-label">Main Section Heading <span class="text-danger">*</span></label>
                                    <input type="text" name="specialties_title" id="specialties_title" class="form-control" value="{{ old('specialties_title', $settings['specialties_title'] ?? '') }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="specialties_desc" class="form-label">Section Description</label>
                                    <textarea name="specialties_desc" id="specialties_desc" rows="2" class="form-control">{{ old('specialties_desc', $settings['specialties_desc'] ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="form-section-title mt-4">
                                <i class="bi bi-columns-gap"></i> 6 Matchmaking Specialties Cards
                            </div>

                            <div class="row g-3">
                                @foreach($specialtiesItems as $idx => $item)
                                <div class="col-md-6">
                                    <div class="sub-item-card h-100">
                                        <div class="sub-item-card-header">
                                            <span class="sub-item-card-title">
                                                <i class="bi {{ $item['icon'] ?? 'bi-patch-check' }} text-gold"></i> Card #{{ $idx + 1 }}
                                            </span>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-4">
                                                <label class="form-label small">Icon</label>
                                                <input type="text" name="specialties_items[{{ $idx }}][icon]" class="form-control form-control-sm" value="{{ $item['icon'] ?? '' }}">
                                            </div>
                                            <div class="col-8">
                                                <label class="form-label small">Card Title</label>
                                                <input type="text" name="specialties_items[{{ $idx }}][title]" class="form-control form-control-sm" value="{{ $item['title'] ?? '' }}">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label small">Description</label>
                                                <textarea name="specialties_items[{{ $idx }}][desc]" rows="2" class="form-control form-control-sm">{{ $item['desc'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- TAB 3: Seamless Process -->
                        <div class="tab-pane fade" id="processSection" role="tabpanel">
                            <div class="form-section-title">
                                <i class="bi bi-signpost-split"></i> How It Works Process Header
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label for="process_tag" class="form-label">Timeline Tag</label>
                                    <input type="text" name="process_tag" id="process_tag" class="form-control" value="{{ old('process_tag', $settings['process_tag'] ?? '') }}">
                                </div>
                                <div class="col-md-8">
                                    <label for="process_title" class="form-label">Timeline Heading <span class="text-danger">*</span></label>
                                    <input type="text" name="process_title" id="process_title" class="form-control" value="{{ old('process_title', $settings['process_title'] ?? '') }}" required>
                                </div>
                                <div class="col-md-8">
                                    <label for="process_desc" class="form-label">Timeline Description</label>
                                    <textarea name="process_desc" id="process_desc" rows="2" class="form-control">{{ old('process_desc', $settings['process_desc'] ?? '') }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label for="process_cta_text" class="form-label">Process CTA Button Text</label>
                                    <input type="text" name="process_cta_text" id="process_cta_text" class="form-control" value="{{ old('process_cta_text', $settings['process_cta_text'] ?? '') }}">
                                </div>
                            </div>

                            <div class="form-section-title mt-4">
                                <i class="bi bi-123"></i> 3 Milestone Steps
                            </div>

                            @foreach($processSteps as $idx => $step)
                            <div class="sub-item-card">
                                <div class="sub-item-card-header">
                                    <span class="sub-item-card-title">
                                        <span class="badge bg-gold text-dark me-1">Step {{ $step['number'] ?? '0'.($idx+1) }}</span> Milestone
                                    </span>
                                </div>
                                <div class="row g-2">
                                    <div class="col-md-2">
                                        <label class="form-label small">Step #</label>
                                        <input type="text" name="process_steps[{{ $idx }}][number]" class="form-control form-control-sm" value="{{ $step['number'] ?? '0'.($idx+1) }}">
                                    </div>
                                    <div class="col-md-10">
                                        <label class="form-label small">Step Title</label>
                                        <input type="text" name="process_steps[{{ $idx }}][title]" class="form-control form-control-sm" value="{{ $step['title'] ?? '' }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small">Step Description</label>
                                        <textarea name="process_steps[{{ $idx }}][desc]" rows="2" class="form-control form-control-sm">{{ $step['desc'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- TAB 4: About Section & Heritage -->
                        <div class="tab-pane fade" id="aboutSection" role="tabpanel">
                            <div class="form-section-title">
                                <i class="bi bi-building"></i> About Us Hero &amp; Heritage
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="about_hero_title" class="form-label">About Page Hero Title <span class="text-danger">*</span></label>
                                    <input type="text" name="about_hero_title" id="about_hero_title" class="form-control" value="{{ old('about_hero_title', $settings['about_hero_title'] ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="about_heritage_title" class="form-label">Heritage Section Heading <span class="text-danger">*</span></label>
                                    <input type="text" name="about_heritage_title" id="about_heritage_title" class="form-control" value="{{ old('about_heritage_title', $settings['about_heritage_title'] ?? '') }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="about_heritage_p1" class="form-label">Heritage Paragraph 1 (Founding Philosophy)</label>
                                    <textarea name="about_heritage_p1" id="about_heritage_p1" rows="3" class="form-control">{{ old('about_heritage_p1', $settings['about_heritage_p1'] ?? '') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label for="about_heritage_p2" class="form-label">Heritage Paragraph 2 (Overseas &amp; Discretion)</label>
                                    <textarea name="about_heritage_p2" id="about_heritage_p2" rows="3" class="form-control">{{ old('about_heritage_p2', $settings['about_heritage_p2'] ?? '') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <label for="about_wedding_quote" class="form-label">Wedding Image Quote Badge</label>
                                    <input type="text" name="about_wedding_quote" id="about_wedding_quote" class="form-control" value="{{ old('about_wedding_quote', $settings['about_wedding_quote'] ?? '') }}">
                                </div>
                            </div>

                            <div class="form-section-title mt-4">
                                <i class="bi bi-shield-shaded"></i> 3 Core Principles Pillars
                            </div>

                            <div class="row g-3">
                                @foreach($aboutPillars as $idx => $pillar)
                                <div class="col-md-4">
                                    <div class="sub-item-card h-100">
                                        <div class="sub-item-card-header">
                                            <span class="sub-item-card-title">
                                                <i class="bi {{ $pillar['icon'] ?? 'bi-gem' }} text-gold"></i> Pillar #{{ $idx + 1 }}
                                            </span>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label small">Icon</label>
                                            <input type="text" name="about_pillars[{{ $idx }}][icon]" class="form-control form-control-sm" value="{{ $pillar['icon'] ?? '' }}">
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label small">Title</label>
                                            <input type="text" name="about_pillars[{{ $idx }}][title]" class="form-control form-control-sm" value="{{ $pillar['title'] ?? '' }}">
                                        </div>
                                        <div>
                                            <label class="form-label small">Description</label>
                                            <textarea name="about_pillars[{{ $idx }}][desc]" rows="3" class="form-control form-control-sm">{{ $pillar['desc'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- TAB 5: Final VIP CTA -->
                        <div class="tab-pane fade" id="finalCtaSection" role="tabpanel">
                            <div class="form-section-title">
                                <i class="bi bi-telephone-outbound"></i> Bottom VIP Callback &amp; Alliance Banner
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="final_cta_badge" class="form-label">CTA Top Badge</label>
                                    <input type="text" name="final_cta_badge" id="final_cta_badge" class="form-control" value="{{ old('final_cta_badge', $settings['final_cta_badge'] ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="final_cta_button_text" class="form-label">Callback Button Text</label>
                                    <input type="text" name="final_cta_button_text" id="final_cta_button_text" class="form-control" value="{{ old('final_cta_button_text', $settings['final_cta_button_text'] ?? '') }}">
                                </div>
                                <div class="col-12">
                                    <label for="final_cta_title" class="form-label">Headline <span class="text-danger">*</span></label>
                                    <input type="text" name="final_cta_title" id="final_cta_title" class="form-control" value="{{ old('final_cta_title', $settings['final_cta_title'] ?? '') }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="final_cta_subtitle" class="form-label">Subtitle Description</label>
                                    <textarea name="final_cta_subtitle" id="final_cta_subtitle" rows="3" class="form-control">{{ old('final_cta_subtitle', $settings['final_cta_subtitle'] ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 6: Footer Notes -->
                        <div class="tab-pane fade" id="footerSection" role="tabpanel">
                            <div class="form-section-title">
                                <i class="bi bi-card-text"></i> Global Footer Texts &amp; Disclaimers
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="footer_copyright_text" class="form-label">Copyright Notice Line</label>
                                    <input type="text" name="footer_copyright_text" id="footer_copyright_text" class="form-control" value="{{ old('footer_copyright_text', $settings['footer_copyright_text'] ?? '') }}">
                                    <div class="form-text text-muted-custom small">Appears after the year in the footer bar.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="footer_trust_title" class="form-label">Trust Card Badge Title</label>
                                    <input type="text" name="footer_trust_title" id="footer_trust_title" class="form-control" value="{{ old('footer_trust_title', $settings['footer_trust_title'] ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="footer_trust_subtitle" class="form-label">Trust Card Badge Subtext</label>
                                    <input type="text" name="footer_trust_subtitle" id="footer_trust_subtitle" class="form-control" value="{{ old('footer_trust_subtitle', $settings['footer_trust_subtitle'] ?? '') }}">
                                </div>
                                <div class="col-12">
                                    <label for="footer_presence_note" class="form-label">Presence &amp; Services Note</label>
                                    <input type="text" name="footer_presence_note" id="footer_presence_note" class="form-control" value="{{ old('footer_presence_note', $settings['footer_presence_note'] ?? '') }}">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action Button Card -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <button type="submit" class="btn btn-admin-primary px-4 py-2.5 fw-bold fs-6">
                        <i class="bi bi-check2-circle me-1 fs-5"></i> Save &amp; Publish Content Sections
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-admin-cancel px-4 py-2.5 fw-bold fs-6">
                        <i class="bi bi-x-circle me-1 fs-5"></i> Return to Dashboard
                    </a>
                </div>
            </div>

            <!-- Right Column: Live Section Preview -->
            <div class="col-lg-4">
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-eye"></i> Hero Section Snapshot
                    </div>

                    <div class="live-preview-box mb-3">
                        <span class="badge bg-maroon text-gold border border-warning border-opacity-25 px-2.5 py-1 mb-2 small" id="previewBadge">
                            {{ $settings['hero_badge'] ?? '100% Confidential Service' }}
                        </span>
                        <h5 class="text-white fw-bold mb-2 font-serif" id="previewTitle">
                            {!! $settings['hero_title'] ?? 'Find Your Perfect Life Partner' !!}
                        </h5>
                        <p class="text-secondary small mb-3" id="previewSubtitle">
                            {{ $settings['hero_subtitle'] ?? 'Professional bride and groom matching...' }}
                        </p>
                        <div class="d-flex gap-2">
                            <span class="btn btn-sm btn-elite-gold px-3 py-1 fw-bold" style="font-size: 0.75rem;">
                                {{ $settings['hero_cta_primary_text'] ?? 'Register' }}
                            </span>
                            <span class="btn btn-sm btn-outline-secondary text-white px-3 py-1" style="font-size: 0.75rem;">
                                Contact Us
                            </span>
                        </div>
                    </div>

                    <div class="text-secondary small">
                        <i class="bi bi-info-circle text-gold me-1"></i> Changes publish instantly to the homepage and about page upon saving.
                    </div>
                </div>

                <!-- Navigation Quick Link Card -->
                <div class="section-card">
                    <div class="form-section-title">
                        <i class="bi bi-link-45deg"></i> Quick Management Links
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-warning text-gold border-opacity-50 text-start py-2">
                            <i class="bi bi-sliders me-1"></i> Helplines &amp; Brand Settings
                        </a>
                        <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-light text-start py-2">
                            <i class="bi bi-globe2 me-1"></i> Preview Live Homepage
                        </a>
                        <a href="{{ route('about') }}" target="_blank" class="btn btn-outline-light text-start py-2">
                            <i class="bi bi-building me-1"></i> Preview Live About Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Live update hero preview
    const titleInput = document.getElementById('hero_title');
    const badgeInput = document.getElementById('hero_badge');
    const subtitleInput = document.getElementById('hero_subtitle');
    const previewTitle = document.getElementById('previewTitle');
    const previewBadge = document.getElementById('previewBadge');
    const previewSubtitle = document.getElementById('previewSubtitle');

    if (titleInput && previewTitle) {
        titleInput.addEventListener('input', function() {
            previewTitle.innerHTML = this.value || 'Find Your Perfect Life Partner';
        });
    }
    if (badgeInput && previewBadge) {
        badgeInput.addEventListener('input', function() {
            previewBadge.textContent = this.value || '100% Confidential';
        });
    }
    if (subtitleInput && previewSubtitle) {
        subtitleInput.addEventListener('input', function() {
            previewSubtitle.textContent = this.value || 'Professional bride and groom matching...';
        });
    }
</script>
@endpush
@endsection
