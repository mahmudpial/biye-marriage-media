@extends('admin.layouts.app')

@section('title', $sectionDef['title'] . ' | Page Content CMS')
@section('page-title', $sectionDef['title'])

@section('content')
<div class="container-fluid px-0">

    <!-- Top Navigation Bar & Action Controls -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.sections.index') }}" class="btn btn-outline-secondary text-white btn-sm px-3 py-2 d-inline-flex align-items-center gap-2" style="border-radius: 8px;">
                <i class="bi bi-arrow-left"></i>
                <span>All Sections</span>
            </a>
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h4 class="fw-bold text-white mb-0 font-serif">{{ $sectionDef['title'] }}</h4>
                    <span class="badge rounded-pill px-2.5 py-1 small" style="background: rgba(212, 175, 55, 0.15); color: var(--gold-light); border: 1px solid var(--border-gold); font-size: 0.72rem;">
                        {{ $sectionDef['category'] }}
                    </span>
                </div>
                <div class="text-secondary small mt-0.5">
                    {{ $sectionDef['description'] }}
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- Section Quick Switcher -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary text-white border-opacity-50 btn-sm dropdown-toggle px-3 py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-shuffle me-1 text-gold"></i> Switch Section
                </button>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow-lg" style="background: var(--card-bg); border: 1px solid var(--border-card); max-height: 380px; overflow-y: auto;">
                    @foreach($sections as $sKey => $s)
                    <li>
                        <a class="dropdown-item py-2 d-flex align-items-center gap-2 {{ $sKey === $sectionKey ? 'active bg-maroon text-gold' : 'text-secondary' }}" href="{{ route('admin.sections.edit', $sKey) }}">
                            <i class="bi {{ $s['icon'] }} text-gold"></i>
                            <span>{{ $s['nav_label'] }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            @if(!empty($sectionDef['preview_url']))
            <a href="{{ $sectionDef['preview_url'] }}" target="_blank" class="btn btn-outline-warning text-gold border-opacity-50 btn-sm px-3 py-2">
                <i class="bi bi-box-arrow-up-right me-1"></i> View Live Page
            </a>
            @endif
        </div>
    </div>

    <!-- Main Section Form -->
    <form action="{{ route('admin.sections.update-section', $sectionKey) }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border-left: 4px solid #ef4444 !important;">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Please resolve the following errors:</div>
            <ul class="mb-0 ps-3 small">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="row g-4">
            <!-- Left Column: Form Fields -->
            <div class="col-lg-8">
                
                {{-- SECTION 1: GENERAL & BRAND IDENTITY --}}
                @if($sectionKey === 'general')
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-award"></i> Brand &amp; Identity Content
                    </div>

                    <div class="mb-3">
                        <label for="site_name" class="form-label">Site Name / Company Title <span class="text-danger">*</span></label>
                        <input type="text" name="site_name" id="site_name" class="form-control" value="{{ old('site_name', $settings['site_name'] ?? '') }}" required>
                        <div class="form-text text-muted-custom small">Appears across the top navigation, page titles, and copyright banners.</div>
                    </div>

                    <div class="mb-3">
                        <label for="site_tagline" class="form-label">Brand Tagline (Bengali or English) <span class="text-danger">*</span></label>
                        <input type="text" name="site_tagline" id="site_tagline" class="form-control" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="about_summary" class="form-label">Executive Brand Summary <span class="text-danger">*</span></label>
                        <textarea name="about_summary" id="about_summary" rows="4" class="form-control" required>{{ old('about_summary', $settings['about_summary'] ?? '') }}</textarea>
                        <div class="form-text text-muted-custom small">Displayed in the footer brand column and introductory excerpts.</div>
                    </div>
                </div>

                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-image"></i> Brand Logos &amp; Visual Assets
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">Primary Brand Logo</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div class="media-preview-box">
                                    <img src="{{ site_setting_image('site_logo') }}" id="logoPreview" alt="Site Logo" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-gold);">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="site_logo_file" id="site_logo_file" class="form-control form-control-sm" accept="image/*">
                                    <div class="form-text text-muted-custom small">Recommended: 200x200px PNG/JPG/WEBP</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Browser Favicon</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <div class="media-preview-box">
                                    <img src="{{ site_setting_image('site_favicon') }}" id="faviconPreview" alt="Site Favicon" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border-gold);">
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="site_favicon_file" id="site_favicon_file" class="form-control form-control-sm" accept="image/*">
                                    <div class="form-text text-muted-custom small">Recommended: 64x64px square icon</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="section-card mb-4">
                    <div class="form-section-title d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-palette2"></i> Dynamic 3-Tier Theme Color System</span>
                        <span class="badge bg-dark text-gold border border-warning border-opacity-25 px-2 py-1 small" style="font-size: 0.72rem;">Live Sync</span>
                    </div>
                    <p class="text-secondary small mb-3">
                        Choose your 3 core theme colors. All buttons, badges, gradients, cards, and highlights across the entire frontend and admin panel will automatically harmonize with these tokens.
                    </p>

                    <!-- Presets Strip -->
                    <div class="mb-4 p-3 rounded" style="background: rgba(0, 0, 0, 0.25); border: 1px solid rgba(255, 255, 255, 0.08);">
                        <label class="form-label small text-gold fw-semibold mb-2 d-flex align-items-center gap-1">
                            <i class="bi bi-stars"></i> Curated Luxury Color Presets:
                        </label>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary text-white border-opacity-25 d-inline-flex align-items-center gap-2 theme-preset-btn" data-primary="#851829" data-secondary="#c99738" data-accent="#121620">
                                <span class="d-flex gap-1">
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #851829; display: inline-block;"></span>
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #c99738; display: inline-block;"></span>
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #121620; display: inline-block;"></span>
                                </span>
                                <span>Royal Burgundy &amp; Gold</span>
                            </button>

                            <button type="button" class="btn btn-sm btn-outline-secondary text-white border-opacity-25 d-inline-flex align-items-center gap-2 theme-preset-btn" data-primary="#124e3f" data-secondary="#d4af37" data-accent="#0a1c17">
                                <span class="d-flex gap-1">
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #124e3f; display: inline-block;"></span>
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #d4af37; display: inline-block;"></span>
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #0a1c17; display: inline-block;"></span>
                                </span>
                                <span>Emerald Dignity</span>
                            </button>

                            <button type="button" class="btn btn-sm btn-outline-secondary text-white border-opacity-25 d-inline-flex align-items-center gap-2 theme-preset-btn" data-primary="#182e4e" data-secondary="#e09f87" data-accent="#0c1524">
                                <span class="d-flex gap-1">
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #182e4e; display: inline-block;"></span>
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #e09f87; display: inline-block;"></span>
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #0c1524; display: inline-block;"></span>
                                </span>
                                <span>Sapphire &amp; Rose Gold</span>
                            </button>

                            <button type="button" class="btn btn-sm btn-outline-secondary text-white border-opacity-25 d-inline-flex align-items-center gap-2 theme-preset-btn" data-primary="#581845" data-secondary="#d4a373" data-accent="#1a0715">
                                <span class="d-flex gap-1">
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #581845; display: inline-block;"></span>
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #d4a373; display: inline-block;"></span>
                                    <span style="width: 12px; height: 12px; border-radius: 50%; background: #1a0715; display: inline-block;"></span>
                                </span>
                                <span>Majestic Plum &amp; Bronze</span>
                            </button>
                        </div>
                    </div>

                    <!-- 3 Color Input Columns -->
                    <div class="row g-3 mb-3">
                        <!-- Primary Color -->
                        <div class="col-md-4">
                            <label for="theme_primary" class="form-label d-flex align-items-center justify-content-between">
                                <span>Primary Brand Color</span>
                                <small class="text-gold" style="font-size: 0.72rem;">Buttons &amp; Headings</small>
                            </label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color p-1" id="theme_primary_picker" value="{{ old('theme_primary', $settings['theme_primary'] ?? '#851829') }}" title="Choose primary color" style="width: 46px; height: 38px;">
                                <input type="text" name="theme_primary" id="theme_primary" class="form-control" value="{{ old('theme_primary', $settings['theme_primary'] ?? '#851829') }}" placeholder="#851829" maxlength="7">
                            </div>
                            <div class="form-text text-muted-custom small mt-1">Default: #851829 (Royal Burgundy)</div>
                        </div>

                        <!-- Secondary Color -->
                        <div class="col-md-4">
                            <label for="theme_secondary" class="form-label d-flex align-items-center justify-content-between">
                                <span>Secondary Accent</span>
                                <small class="text-gold" style="font-size: 0.72rem;">Badges &amp; Glows</small>
                            </label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color p-1" id="theme_secondary_picker" value="{{ old('theme_secondary', $settings['theme_secondary'] ?? '#c99738') }}" title="Choose secondary color" style="width: 46px; height: 38px;">
                                <input type="text" name="theme_secondary" id="theme_secondary" class="form-control" value="{{ old('theme_secondary', $settings['theme_secondary'] ?? '#c99738') }}" placeholder="#c99738" maxlength="7">
                            </div>
                            <div class="form-text text-muted-custom small mt-1">Default: #c99738 (Warm Matrimonial Gold)</div>
                        </div>

                        <!-- Third / Surface Color -->
                        <div class="col-md-4">
                            <label for="theme_accent" class="form-label d-flex align-items-center justify-content-between">
                                <span>Third / Surface Color</span>
                                <small class="text-gold" style="font-size: 0.72rem;">Bases &amp; Cards</small>
                            </label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color p-1" id="theme_accent_picker" value="{{ old('theme_accent', $settings['theme_accent'] ?? '#121620') }}" title="Choose third color" style="width: 46px; height: 38px;">
                                <input type="text" name="theme_accent" id="theme_accent" class="form-control" value="{{ old('theme_accent', $settings['theme_accent'] ?? '#121620') }}" placeholder="#121620" maxlength="7">
                            </div>
                            <div class="form-text text-muted-custom small mt-1">Default: #121620 (Midnight Slate Luxury)</div>
                        </div>
                    </div>

                    <!-- Live Dynamic Preview Swatch Strip -->
                    <div class="p-3 rounded mt-3" id="themeLivePreviewBox" style="background: {{ old('theme_accent', $settings['theme_accent'] ?? '#121620') }}; border: 1px solid rgba(255, 255, 255, 0.12); transition: all 0.3s ease;">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                            <span class="small fw-semibold" style="color: #f1f5f9;">Live Theme Harmonies Preview:</span>
                            <span class="badge rounded-pill px-2.5 py-1 small" id="previewBadge" style="background: rgba(201, 151, 56, 0.2); color: {{ old('theme_secondary', $settings['theme_secondary'] ?? '#c99738') }}; border: 1px solid {{ old('theme_secondary', $settings['theme_secondary'] ?? '#c99738') }};">
                                <i class="bi bi-check-circle-fill me-1"></i> 100% Confidential
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <button type="button" class="btn btn-sm px-3 py-1.5 fw-semibold text-white shadow-sm" id="previewPrimaryBtn" style="background: {{ old('theme_primary', $settings['theme_primary'] ?? '#851829') }}; border: 1px solid rgba(255, 255, 255, 0.2);">
                                <i class="bi bi-heart-fill me-1"></i> Primary Button
                            </button>
                            <button type="button" class="btn btn-sm px-3 py-1.5 fw-semibold" id="previewSecondaryBtn" style="background: transparent; color: {{ old('theme_secondary', $settings['theme_secondary'] ?? '#c99738') }}; border: 1px solid {{ old('theme_secondary', $settings['theme_secondary'] ?? '#c99738') }};">
                                <i class="bi bi-stars me-1"></i> Secondary Outline
                            </button>
                            <span class="small" id="previewAccentText" style="color: #cbd5e1;">Sample headline with accent highlights</span>
                        </div>
                    </div>
                </div>
                @endif

                {{-- SECTION 2: HELPLINE & DIRECT CONTACT --}}
                @if($sectionKey === 'contact')
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-headset"></i> Matrimonial Helplines &amp; Communication Channels
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contact_phone" class="form-label">Priority Contact Phone <span class="text-danger">*</span></label>
                            <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="whatsapp_number" class="form-label">WhatsApp Number (with Country Code) <span class="text-danger">*</span></label>
                            <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '') }}" placeholder="e.g. 8801577723404" required>
                        </div>

                        <div class="col-12">
                            <label for="contact_email" class="form-label">Official Inquiries Email <span class="text-danger">*</span></label>
                            <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}" required>
                        </div>

                        <div class="col-12">
                            <label for="office_address" class="form-label">Physical Office Address <span class="text-danger">*</span></label>
                            <textarea name="office_address" id="office_address" rows="3" class="form-control" required>{{ old('office_address', $settings['office_address'] ?? '') }}</textarea>
                        </div>

                        <div class="col-12">
                            <label for="office_hours" class="form-label">Consultation Operating Hours <span class="text-danger">*</span></label>
                            <input type="text" name="office_hours" id="office_hours" class="form-control" value="{{ old('office_hours', $settings['office_hours'] ?? '') }}" required>
                        </div>
                    </div>
                </div>
                @endif

                {{-- SECTION 3: SOCIAL MEDIA PROFILES --}}
                @if($sectionKey === 'social')
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-share-fill"></i> Official Social Network URLs
                    </div>

                    <div class="mb-3">
                        <label for="facebook_url" class="form-label"><i class="bi bi-facebook text-primary me-1"></i> Facebook Official Page URL</label>
                        <input type="url" name="facebook_url" id="facebook_url" class="form-control" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" placeholder="https://facebook.com/...">
                    </div>

                    <div class="mb-3">
                        <label for="instagram_url" class="form-label"><i class="bi bi-instagram text-danger me-1"></i> Instagram Profile URL</label>
                        <input type="url" name="instagram_url" id="instagram_url" class="form-control" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" placeholder="https://instagram.com/...">
                    </div>

                    <div class="mb-3">
                        <label for="whatsapp_url" class="form-label"><i class="bi bi-whatsapp text-success me-1"></i> Direct WhatsApp Link</label>
                        <input type="url" name="whatsapp_url" id="whatsapp_url" class="form-control" value="{{ old('whatsapp_url', $settings['whatsapp_url'] ?? '') }}" placeholder="https://wa.me/...">
                    </div>

                    <div class="mb-3">
                        <label for="youtube_url" class="form-label"><i class="bi bi-youtube text-danger me-1"></i> YouTube Channel URL</label>
                        <input type="url" name="youtube_url" id="youtube_url" class="form-control" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" placeholder="https://youtube.com/@...">
                    </div>
                </div>
                @endif

                {{-- SECTION 4: ANNOUNCEMENT MARQUEE BAR --}}
                @if($sectionKey === 'announcement')
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-megaphone"></i> Announcement Bar Controls
                    </div>

                    <div class="form-check form-switch mb-4 p-3 rounded" style="background: rgba(255, 255, 255, 0.04); border: 1px solid var(--border-card);">
                        <input class="form-check-input ms-0 me-3" type="checkbox" role="switch" name="announcement_enabled" id="announcement_enabled" value="1" {{ old('announcement_enabled', $settings['announcement_enabled'] ?? '0') === '1' ? 'checked' : '' }} style="transform: scale(1.3);">
                        <label class="form-check-label fw-bold text-white pt-1" for="announcement_enabled">
                            Enable Announcement Marquee Bar on Public Website
                        </label>
                        <div class="text-secondary small mt-1">When enabled, a gold promotional banner appears at the very top of all frontend pages.</div>
                    </div>

                    <div class="mb-3">
                        <label for="announcement_text" class="form-label">Announcement Message Text <span class="text-danger">*</span></label>
                        <textarea name="announcement_text" id="announcement_text" rows="3" class="form-control" required>{{ old('announcement_text', $settings['announcement_text'] ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="announcement_link" class="form-label">Call-to-Action Link URL</label>
                        <input type="text" name="announcement_link" id="announcement_link" class="form-control" value="{{ old('announcement_link', $settings['announcement_link'] ?? '/contact') }}">
                        <div class="form-text text-muted-custom small">Relative URL (e.g. <code>/contact</code>) or absolute URL.</div>
                    </div>
                </div>
                @endif

                {{-- SECTION 5: SEO & SEARCH METADATA --}}
                @if($sectionKey === 'seo')
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-search"></i> Global Search Engine Optimization (SEO)
                    </div>

                    <div class="mb-3">
                        <label for="meta_title_suffix" class="form-label">Global Meta Title Suffix <span class="text-danger">*</span></label>
                        <input type="text" name="meta_title_suffix" id="meta_title_suffix" class="form-control" value="{{ old('meta_title_suffix', $settings['meta_title_suffix'] ?? '') }}" required>
                        <div class="form-text text-muted-custom small">Appended to browser title tabs (e.g. <code>Biye Marriage Media | বিশ্বাসের বন্ধনে, সুন্দর আগামী</code>).</div>
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Default Meta Search Description <span class="text-danger">*</span></label>
                        <textarea name="meta_description" id="meta_description" rows="4" class="form-control" required>{{ old('meta_description', $settings['meta_description'] ?? '') }}</textarea>
                        <div class="form-text text-muted-custom small">Used by Google, Bing, and search crawlers for SERP snippets.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Social Share Image (OpenGraph / WhatsApp Preview)</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="media-preview-box">
                                <img src="{{ site_setting_image('meta_og_image') }}" id="ogImagePreview" alt="OG Preview" style="width: 120px; height: 63px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border-gold);">
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" name="meta_og_image_file" id="meta_og_image_file" class="form-control form-control-sm" accept="image/*">
                                <div class="form-text text-muted-custom small">Recommended: 1200x630px JPG or PNG for optimal WhatsApp &amp; Facebook previews.</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- SECTION 6: HOMEPAGE HERO SECTION --}}
                @if($sectionKey === 'hero')
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-stars"></i> Primary Hero Banner Content
                    </div>

                    <div class="mb-3">
                        <label for="hero_badge" class="form-label">Trust Crest Badge Text</label>
                        <input type="text" name="hero_badge" id="hero_badge" class="form-control" value="{{ old('hero_badge', $settings['hero_badge'] ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label for="hero_title" class="form-label">Hero Title Headline <span class="text-danger">*</span></label>
                        <textarea name="hero_title" id="hero_title" rows="2" class="form-control" required>{{ old('hero_title', $settings['hero_title'] ?? '') }}</textarea>
                        <div class="form-text text-muted-custom small">HTML styling allowed: <code>&lt;span class="text-gold font-serif fst-italic"&gt;Trust &amp; Confidentiality&lt;/span&gt;</code></div>
                    </div>

                    <div class="mb-3">
                        <label for="hero_subtitle" class="form-label">Hero Subtitle Paragraph <span class="text-danger">*</span></label>
                        <textarea name="hero_subtitle" id="hero_subtitle" rows="3" class="form-control" required>{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="hero_cta_primary_text" class="form-label">Primary CTA Button Label</label>
                            <input type="text" name="hero_cta_primary_text" id="hero_cta_primary_text" class="form-control" value="{{ old('hero_cta_primary_text', $settings['hero_cta_primary_text'] ?? 'Register Profile') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="hero_cta_secondary_text" class="form-label">Secondary CTA Button Label</label>
                            <input type="text" name="hero_cta_secondary_text" id="hero_cta_secondary_text" class="form-control" value="{{ old('hero_cta_secondary_text', $settings['hero_cta_secondary_text'] ?? 'Contact Us') }}">
                        </div>
                    </div>
                </div>

                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-grid"></i> 4 Value Highlights Feature Boxes
                    </div>

                    <div class="row g-3">
                        @foreach($heroFeatures as $idx => $feature)
                        <div class="col-md-6">
                            <div class="p-3 rounded border border-secondary border-opacity-25" style="background: rgba(0,0,0,0.25);">
                                <div class="fw-bold text-gold small mb-2"><i class="bi bi-patch-check me-1"></i> Highlight Box #{{ $idx + 1 }}</div>
                                <div class="mb-2">
                                    <label class="form-label small">Bootstrap Icon Class</label>
                                    <input type="text" name="hero_features[{{ $idx }}][icon]" class="form-control form-control-sm" value="{{ $feature['icon'] ?? '' }}" placeholder="bi-shield-lock-fill">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Title</label>
                                    <input type="text" name="hero_features[{{ $idx }}][title]" class="form-control form-control-sm" value="{{ $feature['title'] ?? '' }}">
                                </div>
                                <div>
                                    <label class="form-label small">Description</label>
                                    <input type="text" name="hero_features[{{ $idx }}][desc]" class="form-control form-control-sm" value="{{ $feature['desc'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- SECTION 7: OUR SPECIALTIES --}}
                @if($sectionKey === 'specialties')
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-gem"></i> Specialties Section Header
                    </div>

                    <div class="mb-3">
                        <label for="specialties_tag" class="form-label">Section Tag / Pre-Title</label>
                        <input type="text" name="specialties_tag" id="specialties_tag" class="form-control" value="{{ old('specialties_tag', $settings['specialties_tag'] ?? 'Our Specialties') }}">
                    </div>

                    <div class="mb-3">
                        <label for="specialties_title" class="form-label">Specialties Section Title <span class="text-danger">*</span></label>
                        <input type="text" name="specialties_title" id="specialties_title" class="form-control" value="{{ old('specialties_title', $settings['specialties_title'] ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="specialties_desc" class="form-label">Section Description</label>
                        <textarea name="specialties_desc" id="specialties_desc" rows="3" class="form-control">{{ old('specialties_desc', $settings['specialties_desc'] ?? '') }}</textarea>
                    </div>
                </div>

                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-collection"></i> 6 Specialty Service Pillar Cards
                    </div>

                    <div class="row g-3">
                        @foreach($specialtiesItems as $idx => $item)
                        <div class="col-md-6">
                            <div class="p-3 rounded border border-secondary border-opacity-25 h-100" style="background: rgba(0,0,0,0.25);">
                                <div class="fw-bold text-gold small mb-2"><i class="bi bi-gem me-1"></i> Pillar Card #{{ $idx + 1 }}</div>
                                <div class="mb-2">
                                    <label class="form-label small">Bootstrap Icon Class</label>
                                    <input type="text" name="specialties_items[{{ $idx }}][icon]" class="form-control form-control-sm" value="{{ $item['icon'] ?? 'bi-shield-lock-fill' }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Card Title</label>
                                    <input type="text" name="specialties_items[{{ $idx }}][title]" class="form-control form-control-sm" value="{{ $item['title'] ?? '' }}">
                                </div>
                                <div>
                                    <label class="form-label small">Description</label>
                                    <textarea name="specialties_items[{{ $idx }}][desc]" rows="3" class="form-control form-control-sm">{{ $item['desc'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- SECTION 8: SEAMLESS PROCESS --}}
                @if($sectionKey === 'process')
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-signpost-split"></i> Process Section Header &amp; CTA
                    </div>

                    <div class="mb-3">
                        <label for="process_tag" class="form-label">Section Tag / Category</label>
                        <input type="text" name="process_tag" id="process_tag" class="form-control" value="{{ old('process_tag', $settings['process_tag'] ?? 'Seamless Process') }}">
                    </div>

                    <div class="mb-3">
                        <label for="process_title" class="form-label">Process Section Heading <span class="text-danger">*</span></label>
                        <input type="text" name="process_title" id="process_title" class="form-control" value="{{ old('process_title', $settings['process_title'] ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="process_desc" class="form-label">Section Description</label>
                        <textarea name="process_desc" id="process_desc" rows="3" class="form-control">{{ old('process_desc', $settings['process_desc'] ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="process_cta_text" class="form-label">Schedule Consultation Button Text</label>
                        <input type="text" name="process_cta_text" id="process_cta_text" class="form-control" value="{{ old('process_cta_text', $settings['process_cta_text'] ?? 'Schedule Your Family Consultation') }}">
                    </div>
                </div>

                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-123"></i> 3 Milestone Step Cards
                    </div>

                    <div class="row g-3">
                        @foreach($processSteps as $idx => $step)
                        <div class="col-md-4">
                            <div class="p-3 rounded border border-secondary border-opacity-25 h-100" style="background: rgba(0,0,0,0.25);">
                                <div class="fw-bold text-gold small mb-2"><i class="bi bi-clock-history me-1"></i> Step {{ $step['number'] ?? sprintf('%02d', $idx + 1) }}</div>
                                <div class="mb-2">
                                    <label class="form-label small">Step Number Label</label>
                                    <input type="text" name="process_steps[{{ $idx }}][number]" class="form-control form-control-sm" value="{{ $step['number'] ?? sprintf('%02d', $idx + 1) }}">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label small">Step Title</label>
                                    <input type="text" name="process_steps[{{ $idx }}][title]" class="form-control form-control-sm" value="{{ $step['title'] ?? '' }}">
                                </div>
                                <div>
                                    <label class="form-label small">Description</label>
                                    <textarea name="process_steps[{{ $idx }}][desc]" rows="4" class="form-control form-control-sm">{{ $step['desc'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- SECTION 9: ABOUT US & PILLARS --}}
                @if($sectionKey === 'about')
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-building"></i> About Us Page Hero &amp; Heritage
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="about_hero_badge" class="form-label">About Hero Crest Badge</label>
                            <input type="text" name="about_hero_badge" id="about_hero_badge" class="form-control" value="{{ old('about_hero_badge', $settings['about_hero_badge'] ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="about_hero_title" class="form-label">About Page Hero Title <span class="text-danger">*</span></label>
                            <input type="text" name="about_hero_title" id="about_hero_title" class="form-control" value="{{ old('about_hero_title', $settings['about_hero_title'] ?? '') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="about_hero_subtitle" class="form-label">About Hero Subtitle</label>
                        <textarea name="about_hero_subtitle" id="about_hero_subtitle" rows="2" class="form-control">{{ old('about_hero_subtitle', $settings['about_hero_subtitle'] ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="about_heritage_title" class="form-label">Heritage Section Heading <span class="text-danger">*</span></label>
                        <input type="text" name="about_heritage_title" id="about_heritage_title" class="form-control" value="{{ old('about_heritage_title', $settings['about_heritage_title'] ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="about_heritage_p1" class="form-label">Heritage Paragraph 1 (Founding Philosophy)</label>
                        <textarea name="about_heritage_p1" id="about_heritage_p1" rows="3" class="form-control">{{ old('about_heritage_p1', $settings['about_heritage_p1'] ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="about_heritage_p2" class="form-label">Heritage Paragraph 2 (Overseas &amp; Discretion)</label>
                        <textarea name="about_heritage_p2" id="about_heritage_p2" rows="3" class="form-control">{{ old('about_heritage_p2', $settings['about_heritage_p2'] ?? '') }}</textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Bangladeshi Wedding Showcase Image</label>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ site_setting_image('about_wedding_image') }}" id="weddingImgPreview" alt="Wedding" style="width: 80px; height: 60px; border-radius: 6px; object-fit: cover; border: 1px solid var(--border-gold);">
                                <div class="flex-grow-1">
                                    <input type="file" name="about_wedding_image_file" id="about_wedding_image_file" class="form-control form-control-sm" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="about_wedding_quote" class="form-label">Wedding Image Quote Overlay</label>
                            <input type="text" name="about_wedding_quote" id="about_wedding_quote" class="form-control" value="{{ old('about_wedding_quote', $settings['about_wedding_quote'] ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-shield-check"></i> 3 Core Advantage Pillars
                    </div>

                    <div class="row g-3">
                        @foreach($aboutPillars as $idx => $pillar)
                        <div class="col-md-4">
                            <div class="p-3 rounded border border-secondary border-opacity-25 h-100" style="background: rgba(0,0,0,0.25);">
                                <div class="fw-bold text-gold small mb-2"><i class="bi bi-award me-1"></i> Pillar #{{ $idx + 1 }}</div>
                                <div class="mb-2">
                                    <label class="form-label small">Icon Class</label>
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

                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-person-check-fill"></i> Concierge Network &amp; Executive Photo
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Executive Matchmaker Showcase Image</label>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ site_setting_image('about_concierge_image') }}" id="conciergeImgPreview" alt="Concierge" style="width: 80px; height: 60px; border-radius: 6px; object-fit: cover; border: 1px solid var(--border-gold);">
                                <div class="flex-grow-1">
                                    <input type="file" name="about_concierge_image_file" id="about_concierge_image_file" class="form-control form-control-sm" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="about_concierge_title" class="form-label">Concierge Section Title</label>
                            <input type="text" name="about_concierge_title" id="about_concierge_title" class="form-control" value="{{ old('about_concierge_title', $settings['about_concierge_title'] ?? '') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="about_concierge_desc" class="form-label">Concierge Description</label>
                        <textarea name="about_concierge_desc" id="about_concierge_desc" rows="2" class="form-control">{{ old('about_concierge_desc', $settings['about_concierge_desc'] ?? '') }}</textarea>
                    </div>

                    <div class="row g-3">
                        @foreach($aboutConciergePoints as $idx => $pt)
                        <div class="col-md-4">
                            <div class="p-3 rounded border border-secondary border-opacity-25 h-100" style="background: rgba(0,0,0,0.25);">
                                <div class="fw-bold text-gold small mb-2"><i class="bi bi-check-circle me-1"></i> Point #{{ $idx + 1 }}</div>
                                <div class="mb-2">
                                    <label class="form-label small">Point Title</label>
                                    <input type="text" name="about_concierge_points[{{ $idx }}][title]" class="form-control form-control-sm" value="{{ $pt['title'] ?? '' }}">
                                </div>
                                <div>
                                    <label class="form-label small">Point Description</label>
                                    <textarea name="about_concierge_points[{{ $idx }}][desc]" rows="3" class="form-control form-control-sm">{{ $pt['desc'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- SECTION 10: FINAL VIP CTA --}}
                @if($sectionKey === 'cta')
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-telephone-outbound"></i> Bottom VIP Conversion Banner
                    </div>

                    <div class="mb-3">
                        <label for="final_cta_badge" class="form-label">Badge Pill Above Heading</label>
                        <input type="text" name="final_cta_badge" id="final_cta_badge" class="form-control" value="{{ old('final_cta_badge', $settings['final_cta_badge'] ?? 'Begin Your Exclusive Journey') }}">
                    </div>

                    <div class="mb-3">
                        <label for="final_cta_title" class="form-label">Final CTA Headline <span class="text-danger">*</span></label>
                        <input type="text" name="final_cta_title" id="final_cta_title" class="form-control" value="{{ old('final_cta_title', $settings['final_cta_title'] ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="final_cta_subtitle" class="form-label">Reassurance Subtitle</label>
                        <textarea name="final_cta_subtitle" id="final_cta_subtitle" rows="3" class="form-control">{{ old('final_cta_subtitle', $settings['final_cta_subtitle'] ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="final_cta_button_text" class="form-label">VIP Callback Button Label</label>
                        <input type="text" name="final_cta_button_text" id="final_cta_button_text" class="form-control" value="{{ old('final_cta_button_text', $settings['final_cta_button_text'] ?? 'Request VIP Callback') }}">
                    </div>
                </div>
                @endif

                {{-- SECTION 11: FOOTER NOTES & TRUST BADGES --}}
                @if($sectionKey === 'footer')
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-card-text"></i> Footer Details &amp; Trust Credentials
                    </div>

                    <div class="mb-3">
                        <label for="footer_presence_note" class="form-label">Regional Presence Note</label>
                        <input type="text" name="footer_presence_note" id="footer_presence_note" class="form-control" value="{{ old('footer_presence_note', $settings['footer_presence_note'] ?? 'Services: Bangladesh & Overseas Matchmaking') }}">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="footer_trust_title" class="form-label">Trust Badge Title</label>
                            <input type="text" name="footer_trust_title" id="footer_trust_title" class="form-control" value="{{ old('footer_trust_title', $settings['footer_trust_title'] ?? '100% Confidential') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="footer_trust_subtitle" class="form-label">Trust Badge Subtitle</label>
                            <input type="text" name="footer_trust_subtitle" id="footer_trust_subtitle" class="form-control" value="{{ old('footer_trust_subtitle', $settings['footer_trust_subtitle'] ?? 'Islamic Values & Verified Matchmaking') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="footer_copyright_text" class="form-label">Legal Copyright Statement</label>
                        <input type="text" name="footer_copyright_text" id="footer_copyright_text" class="form-control" value="{{ old('footer_copyright_text', $settings['footer_copyright_text'] ?? '') }}">
                    </div>
                </div>
                @endif

                <!-- Save & Action Controls -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 p-3 rounded" style="background: rgba(20, 3, 9, 0.7); border: 1px solid var(--border-gold);">
                    <button type="submit" class="btn btn-admin-primary px-4 py-2.5 fw-bold fs-6 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-check2-circle fs-5"></i>
                        <span>Save &amp; Publish {{ $sectionDef['nav_label'] }}</span>
                    </button>
                    <a href="{{ route('admin.sections.index') }}" class="btn btn-admin-cancel px-4 py-2.5 fw-bold fs-6">
                        <i class="bi bi-x-circle me-1"></i> Return to CMS Hub
                    </a>
                </div>

            </div>

            <!-- Right Column: Sidebar Info & Quick Live Preview -->
            <div class="col-lg-4">
                <div class="section-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-info-circle"></i> Section Overview
                    </div>
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="section-card-icon-frame" style="width: 44px; height: 44px; border-radius: 10px; font-size: 1.25rem;">
                            <i class="bi {{ $sectionDef['icon'] }}"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white">{{ $sectionDef['title'] }}</div>
                            <span class="badge bg-dark text-gold border border-warning border-opacity-25 px-2 py-0.5 small">{{ $sectionDef['category'] }}</span>
                        </div>
                    </div>
                    <p class="text-secondary small mb-3">
                        {{ $sectionDef['description'] }}
                    </p>
                    <div class="p-2.5 rounded text-secondary small" style="background: rgba(0,0,0,0.3); border: 1px dashed var(--border-gold);">
                        <i class="bi bi-lightning-charge-fill text-gold me-1"></i> Changes publish instantly across the website upon saving.
                    </div>
                </div>

                <!-- Navigation List of All 11 Sections -->
                <div class="section-card">
                    <div class="form-section-title">
                        <i class="bi bi-layers"></i> All Content Sections
                    </div>
                    <div class="d-flex flex-column gap-1.5">
                        @foreach($sections as $sKey => $s)
                        <a href="{{ route('admin.sections.edit', $sKey) }}" class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ $sKey === $sectionKey ? 'bg-maroon text-white fw-bold border border-warning border-opacity-50' : 'text-secondary bg-dark bg-opacity-25' }}">
                            <span class="small d-flex align-items-center gap-2">
                                <i class="bi {{ $s['icon'] }} {{ $sKey === $sectionKey ? 'text-gold' : 'text-muted-custom' }}"></i>
                                <span>{{ $s['nav_label'] }}</span>
                            </span>
                            <i class="bi bi-chevron-right small text-muted-custom"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Live image upload preview handler
    function bindImagePreview(inputId, imgId) {
        const input = document.getElementById(inputId);
        const img = document.getElementById(imgId);
        if (!input || !img) return;

        input.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        bindImagePreview('site_logo_file', 'logoPreview');
        bindImagePreview('site_favicon_file', 'faviconPreview');
        bindImagePreview('about_wedding_image_file', 'weddingImgPreview');
        bindImagePreview('about_concierge_image_file', 'conciergeImgPreview');
        bindImagePreview('meta_og_image_file', 'ogImagePreview');

        // Dynamic Theme Colors Two-Way Binding & Live Preview
        const primaryPicker = document.getElementById('theme_primary_picker');
        const primaryInput = document.getElementById('theme_primary');
        const secondaryPicker = document.getElementById('theme_secondary_picker');
        const secondaryInput = document.getElementById('theme_secondary');
        const accentPicker = document.getElementById('theme_accent_picker');
        const accentInput = document.getElementById('theme_accent');

        const previewBox = document.getElementById('themeLivePreviewBox');
        const previewPrimaryBtn = document.getElementById('previewPrimaryBtn');
        const previewSecondaryBtn = document.getElementById('previewSecondaryBtn');
        const previewBadge = document.getElementById('previewBadge');

        function updateThemePreview() {
            if (!previewBox) return;
            const p = primaryInput ? primaryInput.value : '#851829';
            const s = secondaryInput ? secondaryInput.value : '#c99738';
            const a = accentInput ? accentInput.value : '#121620';

            previewBox.style.background = a;
            if (previewPrimaryBtn) previewPrimaryBtn.style.background = p;
            if (previewSecondaryBtn) {
                previewSecondaryBtn.style.color = s;
                previewSecondaryBtn.style.borderColor = s;
            }
            if (previewBadge) {
                previewBadge.style.color = s;
                previewBadge.style.borderColor = s;
            }
        }

        function syncColorPair(picker, textInput) {
            if (!picker || !textInput) return;
            picker.addEventListener('input', function () {
                textInput.value = this.value;
                updateThemePreview();
            });
            textInput.addEventListener('input', function () {
                if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
                    picker.value = this.value;
                    updateThemePreview();
                }
            });
        }

        syncColorPair(primaryPicker, primaryInput);
        syncColorPair(secondaryPicker, secondaryInput);
        syncColorPair(accentPicker, accentInput);

        // Preset buttons click
        document.querySelectorAll('.theme-preset-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const p = this.getAttribute('data-primary');
                const s = this.getAttribute('data-secondary');
                const a = this.getAttribute('data-accent');

                if (primaryPicker) primaryPicker.value = p;
                if (primaryInput) primaryInput.value = p;
                if (secondaryPicker) secondaryPicker.value = s;
                if (secondaryInput) secondaryInput.value = s;
                if (accentPicker) accentPicker.value = a;
                if (accentInput) accentInput.value = a;

                updateThemePreview();
            });
        });
    });
</script>
@endpush
@endsection
