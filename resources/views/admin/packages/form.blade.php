@extends('admin.layouts.app')

@section('title', $isEdit ? "Edit Package: {$package->name}" : 'Create Membership Package')
@section('page-title', $isEdit ? "Edit Package: {$package->name}" : 'New Membership Package')

@push('styles')
<style>
    .form-card {
        background: #19030d;
        border: 1px solid rgba(212, 175, 55, 0.25);
        border-radius: 16px;
        padding: 1.75rem;
    }
    .form-section-title {
        color: #fce7a1;
        font-family: 'Cinzel', Georgia, serif;
        font-size: 1.05rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(212, 175, 55, 0.2);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .form-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #e5e7eb;
        margin-bottom: 0.4rem;
    }
    .form-control, .form-select {
        background: #12020a !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #fff !important;
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        font-size: 0.9rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: rgba(212, 175, 55, 0.6) !important;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.15) !important;
    }
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.3) !important;
    }
    .switch-card {
        background: #150209;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Header & Breadcrumb -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <div class="small text-muted-custom mb-1">
                <a href="{{ route('admin.packages.index') }}" class="text-gold text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i> Membership Packages
                </a> 
                <span class="mx-1">&rsaquo;</span> 
                <span>{{ $isEdit ? 'Edit Package' : 'New Tier' }}</span>
            </div>
            <h4 class="text-white fw-bold mb-0">
                {{ $isEdit ? "Edit Membership Tier: {$package->name}" : 'Create New Membership Tier' }}
            </h4>
        </div>

        <div>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary btn-sm px-3 py-2">
                <i class="bi bi-x-circle me-1"></i> Discard &amp; Back
            </a>
        </div>
    </div>

    <!-- Validation Errors Alert -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 py-2.5 px-3 mb-4 text-white" style="background: rgba(220, 53, 69, 0.25); border-left: 4px solid #ef4444 !important;" role="alert">
            <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Please fix the following errors:</div>
            <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form 
        method="POST" 
        action="{{ $isEdit ? route('admin.packages.update', $package) : route('admin.packages.store') }}"
    >
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="row g-4">
            <!-- Left 8 Columns: Package Content -->
            <div class="col-lg-8">
                <!-- Section 1: Package Identity -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-gem"></i> Package Identity &amp; Positioning
                    </div>

                    <div class="row g-3">
                        <!-- Package Name -->
                        <div class="col-md-7">
                            <label for="name" class="form-label">
                                Tier Name <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control" 
                                placeholder="e.g. Elite Professional, Elite Business, Elite Aristocrat" 
                                required 
                                value="{{ old('name', $package->name) }}"
                            >
                        </div>

                        <!-- Slug / Identifier -->
                        <div class="col-md-5">
                            <label for="slug" class="form-label">
                                URL Identifier / Slug <span class="text-white-50 small">(Auto-generated if empty)</span>
                            </label>
                            <input 
                                type="text" 
                                name="slug" 
                                id="slug" 
                                class="form-control font-monospace" 
                                placeholder="e.g. professional, business" 
                                value="{{ old('slug', $package->slug) }}"
                            >
                        </div>

                        <!-- Badge Subtitle -->
                        <div class="col-md-7">
                            <label for="badge" class="form-label">
                                Target Badge / Subtitle
                            </label>
                            <input 
                                type="text" 
                                name="badge" 
                                id="badge" 
                                class="form-control" 
                                placeholder="e.g. BCS, Medical & Corporate Leaders or Most Preferred in BD" 
                                value="{{ old('badge', $package->badge) }}"
                            >
                            <div class="form-text text-muted-custom small">Appears as an embossed luxury ribbon on the package card.</div>
                        </div>

                        <!-- Price / Fee Structure -->
                        <div class="col-md-5">
                            <label for="price" class="form-label">
                                Fee Structure / Pricing (BDT ৳)
                            </label>
                            <input 
                                type="text" 
                                name="price" 
                                id="price" 
                                class="form-control" 
                                placeholder="e.g. ৳60,000 / 6 Mo or Bespoke Retainer" 
                                value="{{ old('price', $package->price) }}"
                            >
                        </div>

                        <!-- Overview Description -->
                        <div class="col-md-12">
                            <label for="description" class="form-label">
                                Tier Description &amp; Target Persona
                            </label>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="3" 
                                class="form-control" 
                                placeholder="e.g. Exclusive matchmaking for top corporate CXOs, BCS Cadres, doctors, engineers, and IBA graduates.."
                            >{{ old('description', $package->description) }}</textarea>
                            <div class="form-text text-muted-custom small">Brief synopsis displayed directly under the tier name on public pages.</div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Included Privileges & Benefits -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-card-checklist"></i> Matchmaking Privileges &amp; Benefits
                    </div>

                    <div class="mb-2">
                        <label for="benefits_text" class="form-label">
                            Included Privileges List <span class="text-danger">*</span>
                        </label>
                        @php
                            $defaultBenefits = is_array($package->benefits) ? implode("\n", $package->benefits) : '';
                        @endphp
                        <textarea 
                            name="benefits_text" 
                            id="benefits_text" 
                            rows="8" 
                            class="form-control font-monospace" 
                            placeholder="Dedicated Senior Relationship Manager in Dhaka / Ctg&#10;Educational & Income verification (Annual ৳30 Lakhs+)&#10;Handpicked matches from verified aristocratic families&#10;Direct coordination with counterpart family matchmakers&#10;Confidential introductions with mutual profile unlock"
                            required
                        >{{ old('benefits_text', $defaultBenefits) }}</textarea>
                        <div class="form-text text-muted-custom small mt-2">
                            <i class="bi bi-info-circle me-1 text-gold"></i>
                            <strong>Enter one privilege per line.</strong> Each line is rendered on the public website with a luxury gold checkmark icon.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right 4 Columns: Publishing & Display Options -->
            <div class="col-lg-4">
                <!-- Section 3: Priority & Placement -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-sliders"></i> Display &amp; Status
                    </div>

                    <!-- Display Order -->
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">
                            Display Sort Order
                        </label>
                        <input 
                            type="number" 
                            name="sort_order" 
                            id="sort_order" 
                            class="form-control" 
                            min="0" 
                            step="1" 
                            value="{{ old('sort_order', $package->sort_order ?? 0) }}"
                        >
                        <div class="form-text text-muted-custom small">Lower numbers appear first on the pricing grid (e.g. 1, 2, 3).</div>
                    </div>

                    <!-- Featured / Most Preferred Switch -->
                    <div class="switch-card">
                        <div class="form-check form-switch mb-0">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                role="switch" 
                                id="featured" 
                                name="featured" 
                                value="1" 
                                {{ old('featured', $package->featured) ? 'checked' : '' }}
                            >
                            <label class="form-check-label text-white fw-medium ms-2" for="featured">
                                Most Preferred in BD (Featured)
                            </label>
                        </div>
                        <div class="small text-muted-custom mt-1 ms-4">
                            Embosses a gold "Most Preferred in BD" ribbon and elevates the card styling on the homepage and packages page.
                        </div>
                    </div>

                    <!-- Active Publishing Switch -->
                    <div class="switch-card">
                        <div class="form-check form-switch mb-0">
                            <input 
                                class="form-check-input" 
                                type="checkbox" 
                                role="switch" 
                                id="is_active" 
                                name="is_active" 
                                value="1" 
                                {{ old('is_active', $package->is_active ?? true) ? 'checked' : '' }}
                            >
                            <label class="form-check-label text-white fw-medium ms-2" for="is_active">
                                Publish to Public Website
                            </label>
                        </div>
                        <div class="small text-muted-custom mt-1 ms-4">
                            If disabled, this tier will be hidden from all public pricing grids and lead intake forms.
                        </div>
                    </div>
                </div>

                <!-- Submit & Cancel Actions -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-admin-primary py-2.5 fw-bold">
                        <i class="bi bi-check2-circle me-1"></i> {{ $isEdit ? 'Save Package Changes' : 'Create & Publish Package' }}
                    </button>
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary py-2">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
