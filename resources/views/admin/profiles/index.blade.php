@extends('admin.layouts.app')

@section('title', 'Candidate Profiles & Biodata')
@section('page-title', 'Candidate Profiles Management')

@push('styles')
<style>
    /* High-contrast statistics cards */
    .stat-pill {
        background: #1a050f;
        border: 1px solid rgba(212, 175, 55, 0.25);
        border-radius: 14px;
        padding: 1.1rem 1.25rem;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-pill:hover {
        border-color: rgba(212, 175, 55, 0.55);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
        transform: translateY(-2px);
    }
    .stat-pill .num {
        font-size: 1.75rem;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.2;
    }
    .stat-pill .label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #cbd5e1;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.35rem;
    }

    /* Filter Toolbar */
    .filter-card {
        background: #17040d;
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 16px;
        padding: 1.25rem 1.5rem;
    }
    .filter-label {
        color: #fde68a;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.4rem;
    }
    .filter-input, .filter-select {
        background: #0f0207 !important;
        border: 1px solid rgba(212, 175, 55, 0.35) !important;
        color: #ffffff !important;
        font-size: 0.88rem;
        border-radius: 10px;
        padding: 0.55rem 0.85rem;
    }
    .filter-input:focus, .filter-select:focus {
        border-color: #f5d061 !important;
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.2) !important;
    }
    .filter-input::placeholder {
        color: rgba(255, 255, 255, 0.45) !important;
    }

    /* Profiles Data Table */
    .table-container {
        background: #16040d;
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 16px;
        overflow: hidden;
    }
    .table-profiles {
        width: 100%;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-profiles thead th {
        background: #230613 !important;
        color: #fef08a !important;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        padding: 1.05rem 0.95rem;
        border-bottom: 2px solid rgba(212, 175, 55, 0.35) !important;
        vertical-align: middle;
    }
    .table-profiles tbody td {
        padding: 1rem 0.95rem;
        vertical-align: middle;
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .table-profiles tbody tr:hover td {
        background: rgba(212, 175, 55, 0.07) !important;
    }
    .table-profiles tbody tr:last-child td {
        border-bottom: none;
    }

    /* Thumbnail Avatar */
    .profile-avatar-wrapper {
        position: relative;
        width: 50px;
        height: 50px;
        flex-shrink: 0;
    }
    .profile-thumb {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid rgba(212, 175, 55, 0.45);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
    }
    .profile-thumb.is-discreet {
        filter: blur(2.5px);
    }

    /* High-contrast Badges */
    .badge-bride {
        background: rgba(244, 63, 94, 0.22);
        color: #fecdd3;
        border: 1px solid rgba(244, 63, 94, 0.45);
        font-weight: 600;
        font-size: 0.75rem;
        padding: 0.35rem 0.6rem;
    }
    .badge-groom {
        background: rgba(14, 165, 233, 0.22);
        color: #bae6fd;
        border: 1px solid rgba(14, 165, 233, 0.45);
        font-weight: 600;
        font-size: 0.75rem;
        padding: 0.35rem 0.6rem;
    }
    .badge-tier-gold {
        background: rgba(212, 175, 55, 0.2);
        color: #fef08a;
        border: 1px solid rgba(212, 175, 55, 0.45);
        font-weight: 600;
        font-size: 0.76rem;
        padding: 0.35rem 0.65rem;
    }
    .badge-discreet {
        background: rgba(147, 51, 234, 0.22);
        color: #e9d5ff;
        border: 1px solid rgba(147, 51, 234, 0.4);
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }

    /* High-contrast Text Colors */
    .text-primary-bright {
        color: #ffffff !important;
        font-weight: 600;
    }
    .text-silver {
        color: #cbd5e1 !important;
    }
    .text-gold-bright {
        color: #fde68a !important;
    }
    .text-gold-muted {
        color: #eab308 !important;
    }

    /* Action Buttons */
    .btn-action-edit {
        background: rgba(212, 175, 55, 0.18);
        border: 1px solid rgba(212, 175, 55, 0.45);
        color: #fde68a;
        padding: 0.45rem 0.75rem;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-action-edit:hover {
        background: #d4af37;
        color: #120308;
        border-color: #d4af37;
    }
    .btn-action-delete {
        background: rgba(239, 68, 68, 0.18);
        border: 1px solid rgba(239, 68, 68, 0.4);
        color: #fca5a5;
        padding: 0.45rem 0.65rem;
        border-radius: 8px;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .btn-action-delete:hover {
        background: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    /* Status Pill Toggle Buttons */
    .btn-status-toggle {
        border-radius: 20px;
        padding: 0.35rem 0.75rem;
        font-size: 0.78rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }
    .btn-status-toggle.active {
        background: rgba(34, 197, 94, 0.25);
        color: #86efac;
        border-color: rgba(34, 197, 94, 0.5);
    }
    .btn-status-toggle.active:hover {
        background: #22c55e;
        color: #0f172a;
    }
    .btn-status-toggle.inactive {
        background: rgba(239, 68, 68, 0.2);
        color: #fca5a5;
        border-color: rgba(239, 68, 68, 0.4);
    }
    .btn-status-toggle.inactive:hover {
        background: #ef4444;
        color: #ffffff;
    }

    /* Featured Toggle Button */
    .btn-featured-toggle {
        border-radius: 20px;
        padding: 0.35rem 0.75rem;
        font-size: 0.78rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }
    .btn-featured-toggle.featured {
        background: rgba(234, 179, 8, 0.25);
        color: #fef08a;
        border-color: rgba(234, 179, 8, 0.55);
    }
    .btn-featured-toggle.featured:hover {
        background: #eab308;
        color: #1a040b;
    }
    .btn-featured-toggle.standard {
        background: rgba(255, 255, 255, 0.08);
        color: #cbd5e1;
        border-color: rgba(255, 255, 255, 0.15);
    }
    .btn-featured-toggle.standard:hover {
        background: rgba(255, 255, 255, 0.18);
        color: #ffffff;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 py-3 px-4 mb-4 text-white d-flex align-items-center" style="background: rgba(34, 197, 94, 0.25); border-left: 5px solid #22c55e !important;" role="alert">
            <i class="bi bi-check-circle-fill me-3 fs-4 text-success"></i>
            <div class="fs-6">{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Top Action Bar -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="text-white fw-bold mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-person-lines-fill text-gold fs-3"></i>
                <span>Candidate Profiles Management</span>
            </h4>
            <p class="text-silver small mb-0">
                Manage, verify, and publish elite Bangladeshi brides and grooms in the confidential matrimonial registry.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('profiles') }}" target="_blank" class="btn btn-outline-warning btn-sm px-3 py-2 text-gold fw-semibold">
                <i class="bi bi-globe2 me-1"></i> Preview Live Gallery
            </a>
            <a href="{{ route('admin.profiles.create') }}" class="btn btn-admin-primary btn-sm px-3.5 py-2 fw-bold text-dark shadow-sm">
                <i class="bi bi-person-plus-fill me-1 fs-6"></i> Add New Candidate
            </a>
        </div>
    </div>

    <!-- Quick Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-pill">
                <div class="label"><i class="bi bi-people-fill text-gold me-1"></i> Total Candidates</div>
                <div class="num text-gold-bright">{{ number_format($stats['total']) }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-pill">
                <div class="label"><i class="bi bi-check-circle-fill text-success me-1"></i> Active Profiles</div>
                <div class="num text-success">{{ number_format($stats['active']) }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-pill">
                <div class="label"><i class="bi bi-gender-female text-info me-1"></i> Brides (Patri)</div>
                <div class="num" style="color: #f472b6;">{{ number_format($stats['brides']) }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-pill">
                <div class="label"><i class="bi bi-gender-male text-warning me-1"></i> Grooms (Patro)</div>
                <div class="num" style="color: #38bdf8;">{{ number_format($stats['grooms']) }}</div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-xl">
            <div class="stat-pill">
                <div class="label"><i class="bi bi-star-fill text-gold me-1"></i> Homepage Featured</div>
                <div class="num text-gold-bright">{{ number_format($stats['featured']) }}</div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Controls -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('admin.profiles.index') }}" class="row g-3 align-items-end">
            <!-- Search Text -->
            <div class="col-lg-4 col-md-6">
                <label class="filter-label">Search Candidate</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary border-opacity-50 text-gold">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        name="q" 
                        class="form-control filter-input" 
                        placeholder="Search code (BD-ELT-..), profession, district..." 
                        value="{{ request('q') }}"
                    >
                </div>
            </div>

            <!-- Gender Filter -->
            <div class="col-6 col-lg-2 col-md-3">
                <label class="filter-label">Looking For</label>
                <select name="gender" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">All Genders</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Brides (Female)</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Grooms (Male)</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div class="col-6 col-lg-2 col-md-3">
                <label class="filter-label">Tier Category</label>
                <select name="category" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <option value="Elite Professional" {{ request('category') == 'Elite Professional' ? 'selected' : '' }}>Elite Professional</option>
                    <option value="Elite Business" {{ request('category') == 'Elite Business' ? 'selected' : '' }}>Elite Business</option>
                    <option value="Elite Aristocrat" {{ request('category') == 'Elite Aristocrat' ? 'selected' : '' }}>Elite Aristocrat</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div class="col-6 col-lg-2 col-md-4">
                <label class="filter-label">Publish Status</label>
                <select name="status" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                    <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured Only</option>
                    <option value="discreet" {{ request('status') == 'discreet' ? 'selected' : '' }}>Discreet Only</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-6 col-lg-2 col-md-8 d-flex gap-2">
                <button type="submit" class="btn btn-admin-primary flex-grow-1 py-2 fw-bold text-dark">
                    <i class="bi bi-funnel-fill me-1"></i> Filter
                </button>
                @if(request()->anyFilled(['q', 'gender', 'category', 'status']))
                    <a href="{{ route('admin.profiles.index') }}" class="btn btn-outline-secondary py-2" title="Clear Filters">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Candidate Profiles Table Card -->
    <div class="table-container shadow-lg">
        <!-- Table Top Header with Prominent Add Button -->
        <div class="p-3 px-4 border-bottom border-secondary border-opacity-25 d-flex flex-wrap justify-content-between align-items-center gap-3" style="background: rgba(0, 0, 0, 0.3);">
            <div>
                <h5 class="text-white fw-bold mb-0 d-flex align-items-center gap-2 font-serif">
                    <i class="bi bi-card-heading text-gold"></i>
                    <span>Matrimonial Candidates Registry</span>
                </h5>
                <p class="small text-silver mb-0 mt-0.5">
                    Showing <strong>{{ $profiles->firstItem() ?? 0 }}-{{ $profiles->lastItem() ?? 0 }}</strong> of <strong>{{ $profiles->total() }}</strong> total candidates
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.profiles.create') }}" class="btn btn-admin-primary btn-sm px-3.5 py-1.5 fw-bold text-dark">
                    <i class="bi bi-plus-circle-fill me-1"></i> Add Candidate
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-profiles align-middle">
                <thead>
                    <tr>
                        <th style="width: 170px;">Candidate</th>
                        <th style="width: 160px;">Demographics</th>
                        <th>Education &amp; Profession</th>
                        <th>Location &amp; District</th>
                        <th style="width: 170px;">Category &amp; Income</th>
                        <th class="text-center" style="width: 110px;">Featured</th>
                        <th class="text-center" style="width: 110px;">Status</th>
                        <th class="text-end" style="width: 130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profiles as $profile)
                    <tr>
                        <!-- Candidate Photo & Code -->
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="profile-avatar-wrapper">
                                    <img src="{{ $profile->resolved_image }}" alt="{{ $profile->profile_code }}" class="profile-thumb {{ $profile->is_discreet ? 'is-discreet' : '' }}">
                                </div>
                                <div>
                                    <div class="fw-bold text-gold-bright font-monospace fs-6">
                                        {{ $profile->profile_code }}
                                    </div>
                                    @if($profile->is_discreet)
                                        <span class="badge badge-discreet mt-1">
                                            <i class="bi bi-shield-lock-fill me-1"></i>Discreet
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-25 text-silver mt-1" style="font-size: 0.68rem; border: 1px solid rgba(255,255,255,0.15);">
                                            <i class="bi bi-eye-fill me-1 text-success"></i>Public
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Demographics (Gender, Age, Religion) -->
                        <td>
                            <div>
                                @if($profile->gender === 'female')
                                    <span class="badge rounded-pill badge-bride">
                                        <i class="bi bi-gender-female me-1"></i>Bride
                                    </span>
                                @else
                                    <span class="badge rounded-pill badge-groom">
                                        <i class="bi bi-gender-male me-1"></i>Groom
                                    </span>
                                @endif
                            </div>
                            <div class="text-white fw-bold mt-1.5 fs-7">
                                {{ $profile->age }} Yrs &bull; {{ $profile->height }}
                            </div>
                            <div class="small text-silver mt-0.5">
                                <i class="bi bi-moon-stars-fill text-gold me-1"></i>{{ $profile->religion }}
                            </div>
                        </td>

                        <!-- Profession & Education -->
                        <td>
                            <div class="text-white fw-bold fs-6">
                                {{ $profile->profession }}
                            </div>
                            <div class="small text-silver mt-1 d-flex align-items-center gap-1">
                                <i class="bi bi-mortarboard-fill text-gold flex-shrink-0"></i>
                                <span>{{ $profile->education }}</span>
                            </div>
                            @if($profile->family)
                                <div class="small text-silver opacity-75 text-truncate mt-1" style="max-width: 280px;" title="{{ $profile->family }}">
                                    <i class="bi bi-people me-1"></i>{{ $profile->family }}
                                </div>
                            @endif
                        </td>

                        <!-- Location & District -->
                        <td>
                            <div class="text-white fw-medium">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $profile->location }}
                            </div>
                            <div class="small text-silver mt-1">
                                Ancestral: <strong class="text-white">{{ $profile->desher_bari }}</strong>
                            </div>
                        </td>

                        <!-- Category & Income -->
                        <td>
                            <div>
                                <span class="badge rounded-pill badge-tier-gold">
                                    <i class="bi bi-star-fill text-gold me-1"></i>{{ $profile->category }}
                                </span>
                            </div>
                            <div class="small fw-bold mt-1.5 text-gold-bright">
                                <i class="bi bi-cash-stack me-1 text-gold"></i>{{ $profile->income }}
                            </div>
                        </td>

                        <!-- Featured Toggle -->
                        <td class="text-center">
                            <form action="{{ route('admin.profiles.toggle-featured', $profile) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button 
                                    type="submit" 
                                    class="btn btn-featured-toggle {{ $profile->is_featured ? 'featured' : 'standard' }}"
                                    title="Click to toggle featured state on homepage"
                                >
                                    @if($profile->is_featured)
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <span>Featured</span>
                                    @else
                                        <i class="bi bi-star text-silver"></i>
                                        <span>Standard</span>
                                    @endif
                                </button>
                            </form>
                        </td>

                        <!-- Status Toggle -->
                        <td class="text-center">
                            <form action="{{ route('admin.profiles.toggle-active', $profile) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button 
                                    type="submit" 
                                    class="btn btn-status-toggle {{ $profile->is_active ? 'active' : 'inactive' }}"
                                    title="Click to toggle publish status"
                                >
                                    @if($profile->is_active)
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>Active</span>
                                    @else
                                        <i class="bi bi-x-circle-fill"></i>
                                        <span>Inactive</span>
                                    @endif
                                </button>
                            </form>
                        </td>

                        <!-- Actions -->
                        <td class="text-end">
                            <div class="d-inline-flex gap-1.5 align-items-center">
                                <a 
                                    href="{{ route('admin.profiles.edit', $profile) }}" 
                                    class="btn-action-edit" 
                                    title="Edit Candidate Profile"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Edit</span>
                                </a>

                                <button 
                                    type="button" 
                                    class="btn-action-delete border-0" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteProfileModal{{ $profile->id }}"
                                    title="Delete Candidate"
                                >
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade text-start" id="deleteProfileModal{{ $profile->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content text-white" style="background: #1c0510; border: 1px solid rgba(220, 53, 69, 0.45); border-radius: 16px;">
                                        <div class="modal-header border-bottom border-secondary border-opacity-25 py-3">
                                            <h5 class="modal-title fw-bold text-danger d-flex align-items-center gap-2">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                                <span>Delete Candidate Profile</span>
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body py-4">
                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                <img src="{{ $profile->resolved_image }}" alt="Candidate" class="profile-thumb" style="width: 48px; height: 48px;">
                                                <div>
                                                    <div class="fw-bold text-gold-bright font-monospace fs-5">
                                                        {{ $profile->profile_code }}
                                                    </div>
                                                    <div class="text-white small">
                                                        {{ $profile->profession }} &bull; {{ $profile->location }}
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-silver mb-0">
                                                Are you sure you want to permanently delete candidate <strong class="text-white">{{ $profile->profile_code }}</strong>? This action cannot be undone.
                                            </p>
                                        </div>
                                        <div class="modal-footer border-top border-secondary border-opacity-25 py-2.5">
                                            <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.profiles.destroy', $profile) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm px-3.5 py-1.5 fw-bold">
                                                    <i class="bi bi-trash3-fill me-1"></i> Confirm Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-silver">
                            <i class="bi bi-people display-4 d-block mb-3 opacity-25 text-gold"></i>
                            <h5 class="text-white fw-bold">No candidate profiles found</h5>
                            <p class="small text-silver mb-3">Try adjusting your search query or reset the filters.</p>
                            <a href="{{ route('admin.profiles.create') }}" class="btn btn-admin-primary btn-sm px-3 py-2 fw-bold text-dark">
                                <i class="bi bi-person-plus-fill me-1"></i> Add First Candidate
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($profiles->hasPages())
            <div class="p-3 px-4 border-top border-secondary border-opacity-25 d-flex flex-wrap justify-content-between align-items-center gap-2" style="background: rgba(0, 0, 0, 0.25);">
                <div class="text-silver small">
                    Showing {{ $profiles->firstItem() }} to {{ $profiles->lastItem() }} of {{ $profiles->total() }} candidates
                </div>
                <div>
                    {{ $profiles->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
