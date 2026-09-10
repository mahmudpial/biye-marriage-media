@extends('admin.layouts.app')

@section('title', $isEdit ? "Edit Package: {$package->name}" : 'Create Membership Package')
@section('page-title', $isEdit ? "Edit Tier: {$package->name}" : 'New Membership Package')

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

    /* Polished Privacy & Publishing Switch Cards */
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
    .custom-switch-control {
        flex-shrink: 0;
    }
    .custom-switch-control .form-check-input {
        width: 2.8rem;
        height: 1.45rem;
        cursor: pointer;
        background-color: #334155;
        border-color: #475569;
        transition: background-position 0.2s ease-in-out, background-color 0.2s ease, border-color 0.2s ease;
    }
    .custom-switch-control .form-check-input:focus {
        border-color: var(--accent-gold);
        box-shadow: 0 0 0 0.2rem rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.25);
    }
    .custom-switch-control .form-check-input:checked {
        background-color: #22c55e;
        border-color: #16a34a;
        box-shadow: 0 0 10px rgba(34, 197, 94, 0.4);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Top Action Bar -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.packages.index') }}" class="btn btn-sm btn-outline-secondary px-3 py-1.5" style="border-radius: 8px;">
            <i class="bi bi-arrow-left me-1"></i> Back to Packages List
        </a>
        @if($isEdit)
            <span class="badge" style="background: rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.18); color: #fde68a; border: 1px solid rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.4); font-size: 0.82rem; padding: 0.4rem 0.8rem; border-radius: 8px;">
                <i class="bi bi-gem me-1 text-gold"></i> Tier: {{ $package->name }}
            </span>
        @endif
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
                            <div class="form-text small mt-1">Appears as an embossed luxury ribbon on the package card.</div>
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
                            <div class="form-text small mt-1">Brief synopsis displayed directly under the tier name on public pages.</div>
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
                        <div class="form-text small mt-2">
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
                        <div class="form-text small mt-1">Lower numbers appear first on the pricing grid (e.g. 1, 2, 3).</div>
                    </div>

                    <!-- Featured / Most Preferred Switch -->
                    <div class="switch-card">
                        <div class="switch-card-header">
                            <div class="switch-card-info">
                                <label class="switch-card-title mb-1" for="featured">
                                    <i class="bi bi-star-fill text-gold"></i> Most Preferred in BD
                                </label>
                                <p class="switch-card-desc">
                                    Embosses a gold "Most Preferred in BD" ribbon and elevates the tier card styling.
                                </p>
                            </div>
                            <div class="form-check form-switch custom-switch-control mb-0">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    role="switch" 
                                    id="featured" 
                                    name="featured" 
                                    value="1" 
                                    {{ old('featured', $package->featured) ? 'checked' : '' }}
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Active Publishing Switch -->
                    <div class="switch-card">
                        <div class="switch-card-header">
                            <div class="switch-card-info">
                                <label class="switch-card-title mb-1" for="is_active">
                                    <i class="bi bi-globe2 text-gold"></i> Public Website Status
                                </label>
                                <p class="switch-card-desc">
                                    Active tiers appear on the public pricing matrix and lead forms. Inactive tiers are hidden.
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
                                    {{ old('is_active', $package->is_active ?? true) ? 'checked' : '' }}
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit & Cancel Actions -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-admin-primary py-2.5 fw-semibold fs-6">
                        <i class="bi bi-check2-circle me-1 fs-5"></i> {{ $isEdit ? 'Save Package Changes' : 'Create & Publish Package' }}
                    </button>
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-admin-cancel py-2.5 fw-bold fs-6">
                        <i class="bi bi-x-circle me-1 fs-5"></i> Cancel &amp; Back
                    </a>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
