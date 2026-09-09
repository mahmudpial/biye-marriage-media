@extends('admin.layouts.app')

@section('title', $isEdit ? "Edit Staff: {$user->name}" : 'Add New Team Member')
@section('page-title', $isEdit ? 'Edit Team Member' : 'New Staff Account')

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
        color: var(--accent-gold);
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

    /* Role Descriptions */
    .role-hint-card {
        background: #0f0207;
        border: 1px solid rgba(212, 175, 55, 0.2);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.8rem;
        color: #cbd5e1;
        margin-top: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Back Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary text-white btn-sm px-3 py-2 d-inline-flex align-items-center gap-2" style="border-radius: 8px;">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Staff List</span>
        </a>
    </div>

    <!-- Main Form -->
    <form method="POST" action="{{ $isEdit ? route('admin.users.update', $user) : route('admin.users.store') }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="row g-4">
            <!-- Left Column: Personal Information & Credentials -->
            <div class="col-lg-8">
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-person-lines-fill"></i> Staff Profile &amp; Contact Information
                    </div>

                    <div class="row g-3">
                        <!-- Full Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                placeholder="e.g. Shabnam Begum"
                                value="{{ old('name', $user->name) }}" 
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label">Official Email Address <span class="text-danger">*</span></label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                placeholder="e.g. matchmaker@biyemedia.com"
                                value="{{ old('email', $user->email) }}" 
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Designation -->
                        <div class="col-md-6">
                            <label for="designation" class="form-label">Designation &amp; Regional Branch</label>
                            <input 
                                type="text" 
                                name="designation" 
                                id="designation" 
                                class="form-control @error('designation') is-invalid @enderror" 
                                placeholder="e.g. Senior Matchmaker (Gulshan & Banani Desk)"
                                value="{{ old('designation', $user->designation) }}"
                            >
                            <div class="form-text text-muted-custom small">Internal title displayed in client interaction logs.</div>
                            @error('designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Priority Contact Number</label>
                            <input 
                                type="text" 
                                name="phone" 
                                id="phone" 
                                class="form-control @error('phone') is-invalid @enderror" 
                                placeholder="e.g. +880 1711-223344"
                                value="{{ old('phone', $user->phone) }}"
                            >
                            <div class="form-text text-muted-custom small">Used for client WhatsApp &amp; in-person appointment calls.</div>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Password Credentials Section -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-shield-lock-fill"></i> Account Authentication Credentials
                    </div>

                    @if($isEdit)
                        <div class="alert alert-dark border border-secondary border-opacity-25 text-silver small mb-3">
                            <i class="bi bi-info-circle text-gold me-1"></i> Leave password fields empty if you do not wish to change this staff member's password.
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">
                                {{ $isEdit ? 'New Password (Optional)' : 'Password' }} 
                                @if(!$isEdit) <span class="text-danger">*</span> @endif
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Minimum 8 characters"
                                {{ $isEdit ? '' : 'required' }}
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">
                                Confirm {{ $isEdit ? 'New ' : '' }}Password 
                                @if(!$isEdit) <span class="text-danger">*</span> @endif
                            </label>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation" 
                                class="form-control" 
                                placeholder="Retype password"
                                {{ $isEdit ? '' : 'required' }}
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Role & Account Controls -->
            <div class="col-lg-4">
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-sliders"></i> Role &amp; Access Controls
                    </div>

                    <!-- Role Selector -->
                    <div class="mb-4">
                        <label for="role" class="form-label">Administrative Role <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                            @foreach($roles as $roleKey => $roleLabel)
                                <option value="{{ $roleKey }}" {{ old('role', $user->role) === $roleKey ? 'selected' : '' }}>
                                    {{ $roleLabel }}
                                </option>
                            @endforeach
                        </select>
                        <div class="role-hint-card" id="roleDescriptionBox">
                            <strong>Role Scope:</strong>
                            <div id="roleDescriptionText" class="mt-1">
                                Matchmakers handle high-profile consultations, biodata verification, and client family coordination.
                            </div>
                        </div>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Active Toggle Switch -->
                    <div class="switch-card mb-3">
                        <div class="switch-card-header">
                            <div class="switch-card-info">
                                <label class="switch-card-title" for="is_active">
                                    <i class="bi bi-shield-check"></i>
                                    <span>Account Status</span>
                                </label>
                                <p class="switch-card-desc">
                                    Active accounts can log into the administration portal.
                                </p>
                            </div>
                            <div class="form-check form-switch custom-switch-control mb-0">
                                @if($isEdit && $user->id === auth()->id())
                                    <input class="form-check-input" type="checkbox" checked disabled title="You cannot deactivate your own logged-in account">
                                    <input type="hidden" name="is_active" value="1">
                                @else
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        role="switch" 
                                        id="is_active" 
                                        name="is_active" 
                                        value="1" 
                                        {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}
                                    >
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit & Cancel Actions -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-admin-primary py-2.5 fw-bold fs-6">
                        <i class="bi bi-check2-circle me-1 fs-5"></i> {{ $isEdit ? 'Save Staff Profile' : 'Create Staff Account' }}
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-admin-cancel py-2.5 fw-bold fs-6 text-center">
                        <i class="bi bi-x-circle me-1 fs-5"></i> Cancel &amp; Back
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const roleDescriptions = {
        'super_admin': 'Full administrative control over portal users, security policies, candidate databases, and pricing packages.',
        'senior_matchmaker': 'Dedicated authority for high-profile client families, confidential briefings, and meeting venue reservations.',
        'relationship_manager': 'Coordinates consultation leads, in-home residence visits in Dhaka/Ctg/Sylhet, and NRB family inquiries.',
        'profile_auditor': 'Performs background authentication, NID verification, and institutional credential checks on candidate biodatas.'
    };

    const roleSelect = document.getElementById('role');
    const descText = document.getElementById('roleDescriptionText');

    function updateRoleDescription() {
        const val = roleSelect.value;
        descText.textContent = roleDescriptions[val] || 'Administrative portal user.';
    }

    roleSelect.addEventListener('change', updateRoleDescription);
    updateRoleDescription();
</script>
@endpush
@endsection
