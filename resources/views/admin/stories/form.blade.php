@extends('admin.layouts.app')

@section('title', $isEdit ? "Edit Story: {$story->names}" : 'Add Success Story')
@section('page-title', $isEdit ? "Edit Story: {$story->names}" : 'New Success Story')

@push('styles')
<style>
    .form-card {
        background: #141820;
        background: linear-gradient(180deg, #171c26 0%, #131720 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        padding: 2rem;
    }

    .form-section-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #f8fafc;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding-bottom: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .form-section-title i {
        color: var(--accent-gold);
        font-size: 1.15rem;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--theme-secondary, #d4af37);
        margin-bottom: 0.4rem;
        letter-spacing: 0.3px;
    }

    .form-control, .form-select {
        background: #0d1117 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #f8fafc !important;
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--theme-secondary, #d4af37) !important;
        box-shadow: 0 0 0 3px rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.25) !important;
    }
    .form-control::placeholder {
        color: #64748b !important;
    }
    .form-select option {
        background: #0d1117 !important;
        color: #f8fafc !important;
    }
    .form-text, .text-muted-custom {
        color: #cbd5e1 !important;
    }

    /* Switches */
    .switch-card {
        background: #141820;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 1.15rem 1.25rem;
        margin-bottom: 1.15rem;
        transition: border-color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }
    .switch-card:hover {
        border-color: rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.45);
        background: #171c26;
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
        color: #ffffff;
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    .switch-card-title i {
        color: #d4af37;
        font-size: 1.15rem;
    }
    .switch-card-desc {
        color: #cbd5e1 !important;
        font-size: 0.82rem;
        line-height: 1.45;
        margin-bottom: 0;
    }

    .custom-switch-control .form-check-input {
        width: 2.8rem;
        height: 1.45rem;
        cursor: pointer;
        background-color: #334155;
        border-color: #475569;
        transition: background-position 0.2s ease-in-out, background-color 0.2s ease, border-color 0.2s ease;
    }
    .custom-switch-control .form-check-input:checked {
        background-color: #22c55e;
        border-color: #16a34a;
        box-shadow: 0 0 10px rgba(34, 197, 94, 0.4);
    }

    /* Photo Preview Box */
    .photo-preview-box {
        width: 160px;
        height: 160px;
        border-radius: 16px;
        overflow: hidden;
        border: 2px solid var(--accent-gold);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        background: #000;
    }
    .photo-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Buttons */
    .btn-admin-cancel {
        background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%) !important;
        color: #ffffff !important;
        border: 1px solid #ef4444 !important;
        border-radius: 10px;
        font-weight: 700;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.4);
    }
    .btn-admin-cancel:hover {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        color: #ffffff !important;
        border-color: #fca5a5 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.6);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Top Navigation Breadcrumbs -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-gold text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.stories.index') }}" class="text-gold text-decoration-none">Success Stories</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $isEdit ? 'Edit Story' : 'New Story' }}</li>
            </ol>
        </nav>

        <a href="{{ route('admin.stories.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-1.5 text-silver">
            <i class="bi bi-arrow-left me-1"></i> Back to Catalog
        </a>
    </div>

    <!-- Error Summary Alert -->
    @if($errors->any())
        <div class="alert alert-danger border-0 rounded-3 mb-4 shadow" style="background: rgba(220, 38, 38, 0.25); border: 1px solid #ef4444 !important; color: #fecaca;">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-exclamation-octagon-fill fs-5 me-2 text-danger"></i>
                <h6 class="fw-bold mb-0 text-white">Please correct the errors below:</h6>
            </div>
            <ul class="mb-0 small ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form 
        action="{{ $isEdit ? route('admin.stories.update', $story) : route('admin.stories.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
    >
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="row g-4">
            <!-- Left 8 Columns: Couple Information & Testimonial -->
            <div class="col-lg-8">
                <!-- Section 1: Couple & Alliance Details -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-people-fill"></i> Couple &amp; Nuptial Identity
                    </div>

                    <div class="row g-3">
                        <!-- Couple Names -->
                        <div class="col-md-12">
                            <label for="names" class="form-label">Couple Names <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="names" 
                                id="names" 
                                class="form-control" 
                                placeholder="e.g. Nabila &amp; Farhan Rahman" 
                                required 
                                value="{{ old('names', $story->names) }}"
                            >
                            <div class="form-text text-muted-custom small">Bride and Groom full names or aristocratic titles.</div>
                        </div>

                        <!-- Occupations / Titles -->
                        <div class="col-md-6">
                            <label for="titles" class="form-label">Occupations &amp; Pedigree Titles <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="titles" 
                                id="titles" 
                                class="form-control" 
                                placeholder="e.g. Barrister (Lincoln's Inn) &amp; RMG Director" 
                                required 
                                value="{{ old('titles', $story->titles) }}"
                            >
                            <div class="form-text text-muted-custom small">Professional achievements and lineage designation.</div>
                        </div>

                        <!-- Locations -->
                        <div class="col-md-6">
                            <label for="locations" class="form-label">Locations / Residence <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="locations" 
                                id="locations" 
                                class="form-control" 
                                placeholder="e.g. Gulshan-2, Dhaka &amp; London" 
                                required 
                                value="{{ old('locations', $story->locations) }}"
                            >
                            <div class="form-text text-muted-custom small">Residential and ancestral locations (Pan-Bangladesh / NRB).</div>
                        </div>

                        <!-- Wedding Venue & Date -->
                        <div class="col-md-12">
                            <label for="year" class="form-label">Wedding Date &amp; Venue <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="year" 
                                id="year" 
                                class="form-control" 
                                placeholder="e.g. Married at Senakunj, Dhaka • Dec 2024" 
                                required 
                                value="{{ old('year', $story->year) }}"
                            >
                            <div class="form-text text-muted-custom small">Wedding venue and date. Tip: Use a bullet (•) to separate venue from date.</div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Testimonial Quote -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-chat-quote-fill"></i> Testimonial &amp; Words of Gratitude
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="quote" class="form-label">Client / Family Testimonial Quote <span class="text-danger">*</span></label>
                            <textarea 
                                name="quote" 
                                id="quote" 
                                rows="4" 
                                class="form-control" 
                                placeholder="e.g. Biye Marriage Media handled our alliance with exceptional dignity and discretion. Finding a partner who understood both our business lineage and cultural values was effortless." 
                                required
                            >{{ old('quote', $story->quote) }}</textarea>
                            <div class="form-text text-muted-custom small">The heartfelt message or endorsement displayed on public stories page and homepage modal.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right 4 Columns: Photo Upload & Settings -->
            <div class="col-lg-4">
                <!-- Section 3: Couple Photograph -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-image-fill"></i> Couple Photograph
                    </div>

                    <div class="text-center mb-3">
                        <div class="photo-preview-box mx-auto mb-2" id="photoPreviewBox">
                            @if($story->image)
                                <img src="{{ $story->image }}" id="previewImg" alt="Preview">
                            @else
                                <img src="{{ asset('site-logo/marriage-logo.jpeg') }}" id="previewImg" alt="Default Logo">
                            @endif
                        </div>
                        <div class="small text-muted-custom">Recommended portrait/wedding photo (800x800)</div>
                    </div>

                    <!-- File Upload Input -->
                    <div class="mb-3">
                        <label for="image_file" class="form-label">Upload New Photo</label>
                        <input type="file" name="image_file" id="image_file" class="form-control" accept="image/*">
                        <div class="form-text text-muted-custom small">Max size: 5MB (JPEG, PNG, WebP)</div>
                    </div>

                    <div class="text-center my-2 text-white-50 small">&mdash; OR &mdash;</div>

                    <!-- Direct Image URL Input -->
                    <div class="mb-3">
                        <label for="image_url" class="form-label">Image Web URL (Unsplash / CDN)</label>
                        <input 
                            type="url" 
                            name="image_url" 
                            id="image_url" 
                            class="form-control font-monospace" 
                            placeholder="https://images.unsplash.com/..." 
                            value="{{ old('image_url', str_starts_with($story->raw_image ?? '', 'http') ? $story->raw_image : '') }}"
                        >
                    </div>
                </div>

                <!-- Section 4: Visibility & Homepage Settings -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-sliders"></i> Display &amp; Publishing
                    </div>

                    <!-- Sort Order -->
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Display Sort Order</label>
                        <input 
                            type="number" 
                            name="sort_order" 
                            id="sort_order" 
                            class="form-control" 
                            min="0" 
                            max="9999" 
                            value="{{ old('sort_order', $story->sort_order ?? 0) }}"
                        >
                        <div class="form-text text-muted-custom small">Lower numbers appear first in the catalog.</div>
                    </div>

                    <!-- Featured on Homepage Toggle -->
                    <div class="switch-card">
                        <div class="switch-card-header">
                            <div class="switch-card-info">
                                <label class="switch-card-title" for="is_featured">
                                    <i class="bi bi-stars"></i>
                                    <span>Feature on Homepage</span>
                                </label>
                                <p class="switch-card-desc">
                                    Showcase prominently on the homepage success stories slider/modal.
                                </p>
                            </div>
                            <div class="form-check form-switch custom-switch-control mb-0">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    role="switch" 
                                    id="is_featured" 
                                    name="is_featured" 
                                    value="1" 
                                    {{ old('is_featured', $story->is_featured) ? 'checked' : '' }}
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Publish Status Toggle -->
                    <div class="switch-card">
                        <div class="switch-card-header">
                            <div class="switch-card-info">
                                <label class="switch-card-title" for="is_active">
                                    <i class="bi bi-globe2"></i>
                                    <span>Publish to Public Site</span>
                                </label>
                                <p class="switch-card-desc">
                                    If disabled, this story remains draft and invisible to visitors.
                                </p>
                            </div>
                            <div class="form-check form-switch custom-switch-control mb-0">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    role="switch" 
                                    id="is_active" 
                                    name="is_active" 
                                    value="1" 
                                    {{ old('is_active', $story->is_active) ? 'checked' : '' }}
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit & Cancel Actions -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-admin-primary py-2.5 fw-bold fs-6">
                        <i class="bi bi-check2-circle me-1 fs-5"></i> {{ $isEdit ? 'Save Story Changes' : 'Publish Success Story' }}
                    </button>
                    <a href="{{ route('admin.stories.index') }}" class="btn btn-admin-cancel py-2.5 fw-bold fs-6 text-center">
                        <i class="bi bi-x-circle me-1 fs-5"></i> Cancel &amp; Back
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Live image preview when selecting local file
    document.getElementById('image_file').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                document.getElementById('previewImg').src = evt.target.result;
            };
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Live image preview when entering image URL
    document.getElementById('image_url').addEventListener('input', function(e) {
        if (e.target.value.trim() !== '') {
            document.getElementById('previewImg').src = e.target.value.trim();
        }
    });
</script>
@endpush
@endsection
