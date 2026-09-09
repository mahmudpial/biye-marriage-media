@extends('admin.layouts.app')

@section('title', 'Site Settings & Contact Configuration')
@section('page-title', 'Site Settings & Brand Configuration')

@push('styles')
<style>
    .settings-card {
        background: #1c050e;
        border: 1px solid rgba(212, 175, 55, 0.25);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        padding: 2rem;
    }

    .settings-nav-tabs {
        border-bottom: 1px solid rgba(212, 175, 55, 0.25);
        gap: 0.5rem;
    }
    .settings-nav-tabs .nav-link {
        color: #94a3b8;
        font-weight: 600;
        font-size: 0.92rem;
        border: 1px solid transparent;
        border-radius: 12px 12px 0 0;
        padding: 0.8rem 1.4rem;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .settings-nav-tabs .nav-link i {
        color: #d4af37;
    }
    .settings-nav-tabs .nav-link:hover {
        color: #fef08a;
        background: rgba(212, 175, 55, 0.08);
        border-color: rgba(212, 175, 55, 0.2) rgba(212, 175, 55, 0.2) transparent;
    }
    .settings-nav-tabs .nav-link.active {
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

    /* Switches */
    .switch-card {
        background: #17040d;
        border: 1px solid rgba(212, 175, 55, 0.25);
        border-radius: 14px;
        padding: 1.15rem 1.25rem;
        margin-bottom: 1.15rem;
        transition: border-color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }
    .switch-card:hover {
        border-color: rgba(212, 175, 55, 0.55);
        background: #1f0511;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.35);
    }
    .switch-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.25rem;
    }
    .switch-card-info {
        flex: 1;
    }
    .switch-card-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    .switch-card-title i {
        color: #d4af37;
    }
    .switch-card-desc {
        font-size: 0.76rem;
        color: #94a3b8;
        margin-bottom: 0;
        line-height: 1.4;
    }
    .custom-switch-control .form-check-input {
        width: 2.8rem;
        height: 1.45rem;
        cursor: pointer;
        background-color: #334155;
        border-color: #475569;
    }
    .custom-switch-control .form-check-input:checked {
        background-color: #22c55e;
        border-color: #16a34a;
    }

    /* Live Preview Banner & Card */
    .live-preview-box {
        background: #14030a;
        border: 1px dashed rgba(212, 175, 55, 0.4);
        border-radius: 14px;
        padding: 1.25rem;
    }
    .preview-banner {
        background: linear-gradient(90deg, #d4af37 0%, #fef08a 50%, #d4af37 100%);
        color: #18030c;
        font-size: 0.82rem;
        font-weight: 700;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.2);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Header & Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h4 class="mb-1 text-white fw-bold">
                Site Settings &amp; Brand Configuration
            </h4>
            <p class="text-secondary small mb-0">
                Configure brand identity, helpline numbers, WhatsApp channels, office address, announcement marquee, and SEO meta tags.
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-dark border border-warning text-gold px-3 py-2">
                <i class="bi bi-shield-check me-1"></i> Dynamic Runtime System
            </span>
        </div>
    </div>

    <!-- Main Settings Form -->
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        <div class="row g-4">
            <!-- Left Column: Settings Nav & Form Tabs -->
            <div class="col-lg-8">
                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs settings-nav-tabs mb-0" id="settingsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                            <i class="bi bi-building"></i> General &amp; Brand
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
                            <i class="bi bi-telephone-inbound"></i> Helpline &amp; Contact
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="social-tab" data-bs-toggle="tab" data-bs-target="#social" type="button" role="tab" aria-controls="social" aria-selected="false">
                            <i class="bi bi-share"></i> Social Links
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="announcement-tab" data-bs-toggle="tab" data-bs-target="#announcement" type="button" role="tab" aria-controls="announcement" aria-selected="false">
                            <i class="bi bi-megaphone"></i> Announcement Bar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="seo-tab" data-bs-toggle="tab" data-bs-target="#seo" type="button" role="tab" aria-controls="seo" aria-selected="false">
                            <i class="bi bi-search"></i> SEO &amp; Meta
                        </button>
                    </li>
                </ul>

                <!-- Tab Content Card -->
                <div class="settings-card rounded-top-0 mb-4">
                    <div class="tab-content" id="settingsTabContent">
                        
                        <!-- TAB 1: General & Brand -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <div class="form-section-title">
                                <i class="bi bi-patch-check-fill"></i> Brand Identity &amp; Platform Profile
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="site_name" class="form-label">Platform Name <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        name="site_name" 
                                        id="site_name" 
                                        class="form-control @error('site_name') is-invalid @enderror" 
                                        value="{{ old('site_name', $settings['site_name'] ?? '') }}" 
                                        required
                                    >
                                    <div class="form-text text-muted-custom small">Displayed across the navbar, emails, and header.</div>
                                    @error('site_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="site_tagline" class="form-label">Brand Tagline</label>
                                    <input 
                                        type="text" 
                                        name="site_tagline" 
                                        id="site_tagline" 
                                        class="form-control @error('site_tagline') is-invalid @enderror" 
                                        value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}"
                                    >
                                    <div class="form-text text-muted-custom small">Subtext in navbar and hero branding (e.g. বিশ্বাসের বন্ধনে, সুন্দর আগামী).</div>
                                    @error('site_tagline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="about_summary" class="form-label">Executive About Summary</label>
                                    <textarea 
                                        name="about_summary" 
                                        id="about_summary" 
                                        rows="4" 
                                        class="form-control @error('about_summary') is-invalid @enderror"
                                        placeholder="Brief introduction displayed in website footer and about highlights..."
                                    >{{ old('about_summary', $settings['about_summary'] ?? '') }}</textarea>
                                    <div class="form-text text-muted-custom small">Short description of services rendered for families and NRBs.</div>
                                    @error('about_summary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- TAB 2: Helpline & Contact -->
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="form-section-title">
                                <i class="bi bi-headset"></i> Public Helpline &amp; Office Headquarters
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="contact_phone" class="form-label">Priority Hotline Number <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        name="contact_phone" 
                                        id="contact_phone" 
                                        class="form-control @error('contact_phone') is-invalid @enderror" 
                                        value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" 
                                        required
                                    >
                                    <div class="form-text text-muted-custom small">Display format (e.g. +880 1577-723404).</div>
                                    @error('contact_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="whatsapp_number" class="form-label">WhatsApp Number (Clean Digits) <span class="text-danger">*</span></label>
                                    <input 
                                        type="text" 
                                        name="whatsapp_number" 
                                        id="whatsapp_number" 
                                        class="form-control @error('whatsapp_number') is-invalid @enderror" 
                                        value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}" 
                                        required
                                    >
                                    <div class="form-text text-muted-custom small">Country code + number without spaces or symbols (e.g. 8801577723404).</div>
                                    @error('whatsapp_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="contact_email" class="form-label">Official Inquiries Email <span class="text-danger">*</span></label>
                                    <input 
                                        type="email" 
                                        name="contact_email" 
                                        id="contact_email" 
                                        class="form-control @error('contact_email') is-invalid @enderror" 
                                        value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" 
                                        required
                                    >
                                    <div class="form-text text-muted-custom small">All customer inquiry CCs and public contact address.</div>
                                    @error('contact_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="office_hours" class="form-label">Office &amp; Salon Visiting Hours</label>
                                    <input 
                                        type="text" 
                                        name="office_hours" 
                                        id="office_hours" 
                                        class="form-control @error('office_hours') is-invalid @enderror" 
                                        value="{{ old('office_hours', $settings['office_hours'] ?? '') }}"
                                    >
                                    <div class="form-text text-muted-custom small">e.g. Saturday to Friday, 9:00 AM - 10:00 PM BST.</div>
                                    @error('office_hours')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="office_address" class="form-label">Headquarters Physical Address <span class="text-danger">*</span></label>
                                    <textarea 
                                        name="office_address" 
                                        id="office_address" 
                                        rows="3" 
                                        class="form-control @error('office_address') is-invalid @enderror" 
                                        required
                                    >{{ old('office_address', $settings['office_address'] ?? '') }}</textarea>
                                    <div class="form-text text-muted-custom small">Printed in website footer, contact page, and official communication disclaimers.</div>
                                    @error('office_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- TAB 3: Social Links -->
                        <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                            <div class="form-section-title">
                                <i class="bi bi-globe2"></i> Social Media &amp; Community Channels
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="facebook_url" class="form-label">
                                        <i class="bi bi-facebook text-primary me-1"></i> Facebook Official Page
                                    </label>
                                    <input 
                                        type="url" 
                                        name="facebook_url" 
                                        id="facebook_url" 
                                        class="form-control @error('facebook_url') is-invalid @enderror" 
                                        placeholder="https://www.facebook.com/biyemarriagemedia"
                                        value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"
                                    >
                                    @error('facebook_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="instagram_url" class="form-label">
                                        <i class="bi bi-instagram text-danger me-1"></i> Instagram Profile URL
                                    </label>
                                    <input 
                                        type="url" 
                                        name="instagram_url" 
                                        id="instagram_url" 
                                        class="form-control @error('instagram_url') is-invalid @enderror" 
                                        placeholder="https://instagram.com/biyemarriagemedia"
                                        value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"
                                    >
                                    @error('instagram_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="whatsapp_url" class="form-label">
                                        <i class="bi bi-whatsapp text-success me-1"></i> WhatsApp Direct Link
                                    </label>
                                    <input 
                                        type="url" 
                                        name="whatsapp_url" 
                                        id="whatsapp_url" 
                                        class="form-control @error('whatsapp_url') is-invalid @enderror" 
                                        placeholder="https://wa.me/8801577723404"
                                        value="{{ old('whatsapp_url', $settings['whatsapp_url'] ?? '') }}"
                                    >
                                    @error('whatsapp_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="youtube_url" class="form-label">
                                        <i class="bi bi-youtube text-danger me-1"></i> YouTube Channel URL
                                    </label>
                                    <input 
                                        type="url" 
                                        name="youtube_url" 
                                        id="youtube_url" 
                                        class="form-control @error('youtube_url') is-invalid @enderror" 
                                        placeholder="https://youtube.com/@biyemarriagemedia"
                                        value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}"
                                    >
                                    @error('youtube_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: Announcement Bar -->
                        <div class="tab-pane fade" id="announcement" role="tabpanel" aria-labelledby="announcement-tab">
                            <div class="form-section-title">
                                <i class="bi bi-bell-fill"></i> Live Announcement Marquee Banner
                            </div>

                            <div class="switch-card mb-4">
                                <div class="switch-card-header">
                                    <div class="switch-card-info">
                                        <label class="switch-card-title" for="announcement_enabled">
                                            <i class="bi bi-broadcast"></i>
                                            <span>Display Announcement Banner</span>
                                        </label>
                                        <p class="switch-card-desc">
                                            When enabled, a high-visibility golden banner displays above the top navigation header across all public visitor pages.
                                        </p>
                                    </div>
                                    <div class="form-check form-switch custom-switch-control mb-0">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            role="switch" 
                                            id="announcement_enabled" 
                                            name="announcement_enabled" 
                                            value="1" 
                                            {{ old('announcement_enabled', ($settings['announcement_enabled'] ?? '0') === '1') ? 'checked' : '' }}
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="announcement_text" class="form-label">Announcement Message Text</label>
                                    <textarea 
                                        name="announcement_text" 
                                        id="announcement_text" 
                                        rows="2" 
                                        class="form-control @error('announcement_text') is-invalid @enderror" 
                                        placeholder="e.g. Special NRB Matrimonial Salon Sessions Open in Dhaka & London - Schedule via VIP Concierge"
                                    >{{ old('announcement_text', $settings['announcement_text'] ?? '') }}</textarea>
                                    <div class="form-text text-muted-custom small">Keep under 150 characters for clean mobile viewing.</div>
                                    @error('announcement_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="announcement_link" class="form-label">Call-to-Action Link (Optional)</label>
                                    <input 
                                        type="text" 
                                        name="announcement_link" 
                                        id="announcement_link" 
                                        class="form-control @error('announcement_link') is-invalid @enderror" 
                                        placeholder="/contact or https://wa.me/8801577723404"
                                        value="{{ old('announcement_link', $settings['announcement_link'] ?? '') }}"
                                    >
                                    <div class="form-text text-muted-custom small">Relative URL (e.g. /contact) or full external link.</div>
                                    @error('announcement_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- TAB 5: SEO & Meta -->
                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                            <div class="form-section-title">
                                <i class="bi bi-graph-up-arrow"></i> Search Engine Optimization &amp; Social Meta
                            </div>

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="meta_title_suffix" class="form-label">Global Page Title / Suffix</label>
                                    <input 
                                        type="text" 
                                        name="meta_title_suffix" 
                                        id="meta_title_suffix" 
                                        class="form-control @error('meta_title_suffix') is-invalid @enderror" 
                                        value="{{ old('meta_title_suffix', $settings['meta_title_suffix'] ?? '') }}"
                                    >
                                    <div class="form-text text-muted-custom small">Appears on browser tabs and Google Search result titles.</div>
                                    @error('meta_title_suffix')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="meta_description" class="form-label">Global Meta Description</label>
                                    <textarea 
                                        name="meta_description" 
                                        id="meta_description" 
                                        rows="3" 
                                        class="form-control @error('meta_description') is-invalid @enderror"
                                    >{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                                    <div class="form-text text-muted-custom small">Summary shown on Google snippets and WhatsApp link previews (150-160 characters ideal).</div>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action Button Card -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <button type="submit" class="btn btn-admin-primary px-4 py-2.5 fw-bold fs-6">
                        <i class="bi bi-check2-circle me-1 fs-5"></i> Save &amp; Publish Site Settings
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-admin-cancel px-4 py-2.5 fw-bold fs-6">
                        <i class="bi bi-x-circle me-1 fs-5"></i> Return to Dashboard
                    </a>
                </div>
            </div>

            <!-- Right Column: Live Previews & Health Card -->
            <div class="col-lg-4">
                <!-- Announcement Preview -->
                <div class="settings-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-eye"></i> Announcement Live Preview
                    </div>

                    <div class="live-preview-box mb-3">
                        <div class="preview-banner text-center" id="bannerPreview">
                            <i class="bi bi-stars"></i>
                            <span id="bannerPreviewText">
                                {{ $settings['announcement_text'] ?? 'Special NRB Matrimonial Salon Sessions Open in Dhaka & London - Schedule via VIP Concierge' }}
                            </span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between small text-secondary">
                        <span>Banner Status:</span>
                        <span class="badge {{ ($settings['announcement_enabled'] ?? '0') === '1' ? 'bg-success' : 'bg-secondary' }}" id="bannerStatusBadge">
                            {{ ($settings['announcement_enabled'] ?? '0') === '1' ? 'ACTIVE & LIVE' : 'HIDDEN' }}
                        </span>
                    </div>
                </div>

                <!-- Public Contact Card Preview -->
                <div class="settings-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-card-text"></i> Public Contact Snapshot
                    </div>

                    <div class="live-preview-box">
                        <h6 class="text-gold fw-bold mb-2">
                            <i class="bi bi-gem me-1"></i> {{ $settings['site_name'] ?? 'Biye Marriage Media' }}
                        </h6>
                        <p class="text-secondary small mb-3">
                            {{ $settings['site_tagline'] ?? 'বিশ্বাসের বন্ধনে, সুন্দর আগামী' }}
                        </p>

                        <div class="d-flex align-items-start gap-2 mb-2 text-white small">
                            <i class="bi bi-telephone-fill text-gold mt-1"></i>
                            <div>
                                <span class="text-secondary d-block" style="font-size: 0.72rem;">Helpline</span>
                                <span class="fw-semibold">{{ $settings['contact_phone'] ?? '+880 1577-723404' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-2 mb-2 text-white small">
                            <i class="bi bi-whatsapp text-success mt-1"></i>
                            <div>
                                <span class="text-secondary d-block" style="font-size: 0.72rem;">WhatsApp Concierge</span>
                                <span class="fw-semibold">+{{ $settings['whatsapp_number'] ?? '8801577723404' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-2 mb-2 text-white small">
                            <i class="bi bi-envelope-fill text-gold mt-1"></i>
                            <div>
                                <span class="text-secondary d-block" style="font-size: 0.72rem;">Official Email</span>
                                <span class="fw-semibold">{{ $settings['contact_email'] ?? 'biyemarriagemedia@gmail.com' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-2 text-white small">
                            <i class="bi bi-geo-alt-fill text-danger mt-1"></i>
                            <div>
                                <span class="text-secondary d-block" style="font-size: 0.72rem;">Headquarters</span>
                                <span class="text-silver small">{{ $settings['office_address'] ?? 'Ka-57/3, Kuril Chowrasta, Vatara, Dhaka-1212' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Help / Information -->
                <div class="settings-card">
                    <div class="form-section-title">
                        <i class="bi bi-info-circle"></i> Quick Admin Guide
                    </div>
                    <ul class="text-secondary small ps-3 mb-0" style="line-height: 1.8;">
                        <li>Changes take effect immediately across all public visitor pages.</li>
                        <li>The announcement banner can be toggled on/off instantly during festivals or special registration periods.</li>
                        <li>The WhatsApp number format must be pure digits including country code (e.g. <code>8801577723404</code>) so that one-click mobile chat links work smoothly.</li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Live update announcement banner preview
    const announcementTextInput = document.getElementById('announcement_text');
    const announcementToggleInput = document.getElementById('announcement_enabled');
    const bannerPreviewText = document.getElementById('bannerPreviewText');
    const bannerStatusBadge = document.getElementById('bannerStatusBadge');
    const bannerPreview = document.getElementById('bannerPreview');

    if (announcementTextInput && bannerPreviewText) {
        announcementTextInput.addEventListener('input', function() {
            bannerPreviewText.textContent = this.value || 'Special NRB Matrimonial Salon Sessions Open in Dhaka & London';
        });
    }

    if (announcementToggleInput && bannerStatusBadge) {
        announcementToggleInput.addEventListener('change', function() {
            if (this.checked) {
                bannerStatusBadge.textContent = 'ACTIVE & LIVE';
                bannerStatusBadge.className = 'badge bg-success';
                bannerPreview.style.opacity = '1';
            } else {
                bannerStatusBadge.textContent = 'HIDDEN';
                bannerStatusBadge.className = 'badge bg-secondary';
                bannerPreview.style.opacity = '0.5';
            }
        });
    }
</script>
@endpush
@endsection
