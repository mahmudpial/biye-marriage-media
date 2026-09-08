@extends('admin.layouts.app')

@section('title', $isEdit ? "Edit Profile #{$profile->profile_code}" : 'Create Candidate Profile')
@section('page-title', $isEdit ? "Edit Candidate #{$profile->profile_code}" : 'New Candidate Profile')

@push('styles')
<style>
    .form-card {
        background: #1c050e;
        border: 1px solid rgba(212, 175, 55, 0.25);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        padding: 2rem;
    }

    .form-section-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #fef08a;
        border-bottom: 1px solid rgba(212, 175, 55, 0.3);
        padding-bottom: 0.65rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    .form-section-title i {
        color: #d4af37;
        margin-right: 0.6rem;
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
    .form-text, .text-muted-custom {
        color: #cbd5e1 !important;
    }

    .photo-preview-box {
        width: 140px;
        height: 140px;
        border-radius: 16px;
        border: 2px dashed rgba(212, 175, 55, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: rgba(0, 0, 0, 0.4);
        position: relative;
    }
    .photo-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Polished Privacy & Publishing Switch Cards */
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
        width: 3rem;
        height: 1.65rem;
        cursor: pointer;
        background-color: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: background-position 0.2s ease-in-out, background-color 0.2s ease, border-color 0.2s ease;
    }
    .custom-switch-control .form-check-input:focus {
        border-color: #f5d061;
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
    }
    .custom-switch-control .form-check-input:checked {
        background-color: #22c55e;
        border-color: #22c55e;
        box-shadow: 0 0 12px rgba(34, 197, 94, 0.5);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('admin.profiles.index') }}" class="btn btn-sm btn-outline-secondary px-3 py-1.5 text-silver" style="border-radius: 8px;">
            <i class="bi bi-arrow-left me-1"></i> Back to Candidates List
        </a>
        @if($isEdit)
            <span class="badge" style="background: rgba(212, 175, 55, 0.18); color: #fde68a; border: 1px solid rgba(212, 175, 55, 0.4); font-size: 0.82rem; padding: 0.4rem 0.8rem; border-radius: 8px;">
                <i class="bi bi-fingerprint me-1 text-gold"></i> ID: {{ $profile->profile_code }}
            </span>
        @endif
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 py-2 px-3 mb-4 text-white" style="background: rgba(220, 53, 69, 0.25); border-left: 4px solid #ef4444 !important;" role="alert">
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
        action="{{ $isEdit ? route('admin.profiles.update', $profile) : route('admin.profiles.store') }}" 
        enctype="multipart/form-data"
    >
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="row g-4">
            <!-- Left 8 Columns: Main Information -->
            <div class="col-lg-8">
                <!-- Section 1: Demographics & Identity -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-person-badge-fill"></i> Candidate Demographics &amp; Identity
                    </div>

                    <div class="row g-3">
                        <!-- Profile Code -->
                        <div class="col-md-4">
                            <label for="profile_code" class="form-label">
                                Profile Code <span class="text-white-50 small">(Auto-generated if empty)</span>
                            </label>
                            <input 
                                type="text" 
                                name="profile_code" 
                                id="profile_code" 
                                class="form-control font-monospace" 
                                placeholder="e.g. BD-ELT-9041" 
                                value="{{ old('profile_code', $profile->profile_code) }}"
                            >
                        </div>

                        <!-- Gender -->
                        <div class="col-md-4">
                            <label for="gender" class="form-label">Looking As (Gender) <span class="text-danger">*</span></label>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="female" {{ old('gender', $profile->gender) === 'female' ? 'selected' : '' }}>Bride (Female / Patri)</option>
                                <option value="male" {{ old('gender', $profile->gender) === 'male' ? 'selected' : '' }}>Groom (Male / Patro)</option>
                            </select>
                        </div>

                        <!-- Age -->
                        <div class="col-md-4">
                            <label for="age" class="form-label">Age (Years) <span class="text-danger">*</span></label>
                            <input 
                                type="number" 
                                name="age" 
                                id="age" 
                                class="form-control" 
                                min="18" 
                                max="99" 
                                required 
                                value="{{ old('age', $profile->age) }}"
                            >
                        </div>

                        <!-- Height -->
                        <div class="col-md-4">
                            <label for="height" class="form-label">Height <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="height" 
                                id="height" 
                                class="form-control" 
                                placeholder="e.g. 5'5&quot; or 5'11&quot;" 
                                required 
                                value="{{ old('height', $profile->height) }}"
                            >
                        </div>

                        <!-- Religion & Practicing -->
                        <div class="col-md-4">
                            <label for="religion" class="form-label">Religion &amp; Sect <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="religion" 
                                id="religion" 
                                class="form-control" 
                                placeholder="e.g. Islam (Sunni) / Deen-conscious" 
                                required 
                                value="{{ old('religion', $profile->religion ?? 'Islam (Sunni)') }}"
                            >
                        </div>

                        <!-- Category -->
                        <div class="col-md-4">
                            <label for="category" class="form-label">Elite Category <span class="text-danger">*</span></label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="Elite Professional" {{ old('category', $profile->category) === 'Elite Professional' ? 'selected' : '' }}>Elite Professional</option>
                                <option value="Elite Business" {{ old('category', $profile->category) === 'Elite Business' ? 'selected' : '' }}>Elite Business</option>
                                <option value="Elite Aristocrat" {{ old('category', $profile->category) === 'Elite Aristocrat' ? 'selected' : '' }}>Elite Aristocrat</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Education, Profession & Income -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-briefcase-fill"></i> Education, Profession &amp; Location
                    </div>

                    <div class="row g-3">
                        <!-- Education -->
                        <div class="col-md-6">
                            <label for="education" class="form-label">Educational Qualification <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="education" 
                                id="education" 
                                class="form-control" 
                                placeholder="e.g. MBBS (DMC), FCPS Part-II or B.Sc. BUET" 
                                required 
                                value="{{ old('education', $profile->education) }}"
                            >
                        </div>

                        <!-- Profession -->
                        <div class="col-md-6">
                            <label for="profession" class="form-label">Current Profession / Title <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="profession" 
                                id="profession" 
                                class="form-control" 
                                placeholder="e.g. Senior Strategy Consultant / Managing Director" 
                                required 
                                value="{{ old('profession', $profile->profession) }}"
                            >
                        </div>

                        <!-- Location -->
                        <div class="col-md-6">
                            <label for="location" class="form-label">Current Residence Location <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="location" 
                                id="location" 
                                class="form-control" 
                                placeholder="e.g. Gulshan-2, Dhaka or London / Sylhet" 
                                required 
                                value="{{ old('location', $profile->location) }}"
                            >
                        </div>

                        <!-- Annual Income / Package -->
                        <div class="col-md-6">
                            <label for="income" class="form-label">Annual Income / Assets Tier <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="income" 
                                id="income" 
                                class="form-control" 
                                placeholder="e.g. ৳45 Lakhs+ or ৳1.8 Crore+ or Govt Grade" 
                                required 
                                value="{{ old('income', $profile->income) }}"
                            >
                        </div>
                    </div>
                </div>

                <!-- Section 3: Family Heritage & District -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-people-fill"></i> Family Heritage &amp; Roots (Bongsho)
                    </div>

                    <div class="row g-3">
                        <!-- Desher Bari -->
                        <div class="col-md-12">
                            <label for="desher_bari" class="form-label">Ancestral District (Desher Bari) <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="desher_bari" 
                                id="desher_bari" 
                                class="form-control" 
                                placeholder="e.g. Sylhet, Chattogram, Dhaka, Cumilla, Mymensingh" 
                                required 
                                value="{{ old('desher_bari', $profile->desher_bari) }}"
                            >
                        </div>

                        <!-- Family Background Description -->
                        <div class="col-md-12">
                            <label for="family" class="form-label">Family Background Brief <span class="text-danger">*</span></label>
                            <textarea 
                                name="family" 
                                id="family" 
                                rows="3" 
                                class="form-control" 
                                placeholder="e.g. Prominent Tea Estate & Export Business Family in Sylhet & Dhaka; father is retired Secretary..."
                                required
                            >{{ old('family', $profile->family) }}</textarea>
                            <div class="form-text text-muted-custom small">This concise brief appears on the candidate's card for verified families.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right 4 Columns: Photo Upload & Status Toggles -->
            <div class="col-lg-4">
                <!-- Section 4: Photo & Media -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-image-fill"></i> Candidate Photograph
                    </div>

                    <div class="text-center mb-3">
                        <div class="photo-preview-box mx-auto mb-2" id="photoPreviewBox">
                            @if($profile->image)
                                <img src="{{ $profile->resolved_image }}" id="previewImg" alt="Preview">
                            @else
                                <img src="{{ asset('site-logo/marriage-logo.jpeg') }}" id="previewImg" alt="Default Logo">
                            @endif
                        </div>
                        <div class="small text-muted-custom">Recommended square ratio (800x800)</div>
                    </div>

                    <!-- File Upload Input -->
                    <div class="mb-3">
                        <label for="image_file" class="form-label">Upload New Photo File</label>
                        <input type="file" name="image_file" id="image_file" class="form-control" accept="image/*">
                        <div class="form-text text-muted-custom small">Max size: 3MB (JPEG, PNG, WebP)</div>
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
                            value="{{ old('image_url', str_starts_with($profile->image ?? '', 'http') ? $profile->image : '') }}"
                        >
                    </div>
                </div>

                <!-- Section 5: Visibility & Privacy Settings -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-sliders"></i> Privacy &amp; Publishing
                    </div>

                    <!-- Discreet Privacy Toggle -->
                    <div class="switch-card">
                        <div class="switch-card-header">
                            <div class="switch-card-info">
                                <label class="switch-card-title" for="is_discreet">
                                    <i class="bi bi-shield-lock-fill"></i>
                                    <span>Confidential Discreet Mode</span>
                                </label>
                                <p class="switch-card-desc">
                                    Photo is blurred with privacy overlay until family requests unlock.
                                </p>
                            </div>
                            <div class="form-check form-switch custom-switch-control mb-0">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    role="switch" 
                                    id="is_discreet" 
                                    name="is_discreet" 
                                    value="1" 
                                    {{ old('is_discreet', $profile->is_discreet) ? 'checked' : '' }}
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Featured on Homepage Toggle -->
                    <div class="switch-card">
                        <div class="switch-card-header">
                            <div class="switch-card-info">
                                <label class="switch-card-title" for="is_featured">
                                    <i class="bi bi-star-fill"></i>
                                    <span>Feature on Homepage</span>
                                </label>
                                <p class="switch-card-desc">
                                    Displays this profile in the 4 VIP featured spots on the homepage.
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
                                    {{ old('is_featured', $profile->is_featured) ? 'checked' : '' }}
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Active Publishing Toggle -->
                    <div class="switch-card">
                        <div class="switch-card-header">
                            <div class="switch-card-info">
                                <label class="switch-card-title" for="is_active">
                                    <i class="bi bi-globe2"></i>
                                    <span>Publish to Public Gallery</span>
                                </label>
                                <p class="switch-card-desc">
                                    If disabled, profile will be hidden from public view.
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
                                    {{ old('is_active', $profile->is_active) ? 'checked' : '' }}
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit & Cancel Actions -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-admin-primary py-2.5 fw-bold fs-6">
                        <i class="bi bi-check2-circle me-1 fs-5"></i> {{ $isEdit ? 'Save Profile Changes' : 'Create & Publish Profile' }}
                    </button>
                    <a href="{{ route('admin.profiles.index') }}" class="btn btn-admin-cancel py-2.5 fw-bold fs-6">
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
