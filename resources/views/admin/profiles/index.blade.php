@extends('admin.layouts.app')

@section('title', 'Candidate Profiles & Biodata')
@section('page-title', 'Candidate Profiles Management')

@push('styles')
<style>
    /* Clean, focused layout container */
    .profiles-wrapper {
        width: 100%;
    }

    /* Filter Card */
    .filter-card {
        background: #18030c;
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 14px;
        padding: 1.15rem 1.35rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35);
    }
    .filter-label {
        color: #fde68a;
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.35rem;
    }
    .filter-input, .filter-select {
        background: #0f0207 !important;
        border: 1px solid rgba(212, 175, 55, 0.35) !important;
        color: #ffffff !important;
        font-size: 0.88rem;
        border-radius: 9px;
        padding: 0.55rem 0.85rem;
    }
    .filter-input:focus, .filter-select:focus {
        border-color: #f5d061 !important;
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25) !important;
    }
    .filter-input::placeholder {
        color: rgba(255, 255, 255, 0.45) !important;
    }

    /* Table Container - Smooth horizontal scroll on smaller viewports */
    .table-container {
        background: #17040d;
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    }
    .table-profiles {
        min-width: 1400px;
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }
    .table-profiles thead th {
        background: #240614 !important;
        color: #fef08a !important;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 1rem 0.95rem;
        border-bottom: 2px solid rgba(212, 175, 55, 0.35) !important;
        vertical-align: middle;
        white-space: nowrap;
    }
    .table-profiles tbody td {
        padding: 0.95rem 0.95rem;
        vertical-align: middle;
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }
    .table-profiles tbody tr:hover td {
        background: rgba(212, 175, 55, 0.06) !important;
    }
    .table-profiles tbody tr:last-child td {
        border-bottom: none;
    }

    /* Candidate Photo */
    .profile-thumb {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        object-fit: cover;
        border: 1.5px solid rgba(212, 175, 55, 0.4);
        flex-shrink: 0;
    }
    .profile-thumb.is-discreet {
        filter: blur(2px);
    }

    /* High-contrast Badges */
    .badge-bride {
        background: rgba(244, 63, 94, 0.22);
        color: #fecdd3;
        border: 1px solid rgba(244, 63, 94, 0.45);
        font-weight: 700;
        font-size: 0.72rem;
        padding: 0.25rem 0.55rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    .badge-groom {
        background: rgba(14, 165, 233, 0.22);
        color: #bae6fd;
        border: 1px solid rgba(14, 165, 233, 0.45);
        font-weight: 700;
        font-size: 0.72rem;
        padding: 0.25rem 0.55rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    .badge-tier {
        background: rgba(212, 175, 55, 0.18);
        color: #fef08a;
        border: 1px solid rgba(212, 175, 55, 0.4);
        font-weight: 600;
        font-size: 0.74rem;
        padding: 0.25rem 0.55rem;
        border-radius: 6px;
    }
    .badge-discreet {
        background: rgba(147, 51, 234, 0.2);
        color: #e9d5ff;
        border: 1px solid rgba(147, 51, 234, 0.4);
        font-size: 0.68rem;
        padding: 0.18rem 0.48rem;
        border-radius: 5px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Status Toggle Pills - Bright Green vs Bright Red */
    .btn-status-toggle {
        border-radius: 20px;
        padding: 0.38rem 0.85rem;
        font-size: 0.8rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-status-toggle.active {
        background: #16a34a !important;
        color: #ffffff !important;
        box-shadow: 0 0 10px rgba(22, 163, 74, 0.4);
    }
    .btn-status-toggle.active:hover {
        background: #22c55e !important;
        transform: scale(1.03);
    }
    .btn-status-toggle.inactive {
        background: #dc2626 !important;
        color: #ffffff !important;
        box-shadow: 0 0 10px rgba(220, 38, 38, 0.4);
    }
    .btn-status-toggle.inactive:hover {
        background: #ef4444 !important;
        transform: scale(1.03);
    }

    /* Action Icon Buttons: Edit & Delete */
    .btn-action-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
        border: none;
    }
    .btn-action-icon.edit {
        background: #d4af37;
        color: #0d0206 !important;
        border: 1px solid #f5d061;
        box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
    }
    .btn-action-icon.edit:hover {
        background: #f5d061;
        color: #000000 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(212, 175, 55, 0.55);
    }
    .btn-action-icon.delete {
        background: rgba(220, 38, 38, 0.2);
        border: 1px solid rgba(239, 68, 68, 0.55) !important;
        color: #fca5a5 !important;
    }
    .btn-action-icon.delete:hover {
        background: #dc2626;
        color: #ffffff !important;
        border-color: #ef4444 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.55);
    }

    /* High contrast text utilities */
    .text-silver {
        color: #cbd5e1 !important;
    }
    .text-gold-bright {
        color: #fde68a !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0 profiles-wrapper">

    <!-- Filter & Search Toolbar -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('admin.profiles.index') }}" class="row g-2 align-items-end">
            <!-- Search Text -->
            <div class="col-lg-4 col-md-6">
                <label class="filter-label">Search</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary border-opacity-50 text-gold">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        name="q" 
                        class="form-control filter-input" 
                        placeholder="Search ID code, profession, district..." 
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
                    <option value="Elite Professional" {{ request('category') == 'Elite Professional' ? 'selected' : '' }}>Professional</option>
                    <option value="Elite Business" {{ request('category') == 'Elite Business' ? 'selected' : '' }}>Business</option>
                    <option value="Elite Aristocrat" {{ request('category') == 'Elite Aristocrat' ? 'selected' : '' }}>Aristocrat</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div class="col-6 col-lg-2 col-md-4">
                <label class="filter-label">Status</label>
                <select name="status" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="col-6 col-lg-2 col-md-8 d-flex gap-2">
                <button type="submit" class="btn btn-admin-primary flex-grow-1 py-2 fw-bold">
                    <i class="bi bi-funnel-fill me-1"></i> Filter
                </button>
                @if(request()->anyFilled(['q', 'gender', 'category', 'status']))
                    <a href="{{ route('admin.profiles.index') }}" class="btn btn-outline-secondary py-2 px-3" title="Reset Filters">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Candidate Profiles Table -->
    <div class="table-container shadow-lg">
        <!-- Table Card Header -->
        <div class="p-3 px-4 border-bottom border-secondary border-opacity-25 d-flex flex-wrap justify-content-between align-items-center gap-3" style="background: rgba(0, 0, 0, 0.25);">
            <div class="d-flex align-items-center gap-2">
                <h5 class="text-white fw-bold mb-0">
                    <i class="bi bi-people-fill text-gold me-1"></i> Candidates List
                </h5>
                <span class="badge rounded-pill bg-dark border border-warning-subtle text-gold px-2.5 py-1">
                    {{ $profiles->total() }} Candidates
                </span>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('profiles') }}" target="_blank" class="btn btn-outline-warning btn-sm px-3 py-1.5 text-gold fw-semibold">
                    <i class="bi bi-globe2 me-1"></i> View Live Gallery
                </a>
                <a href="{{ route('admin.profiles.create') }}" class="btn btn-admin-primary btn-sm px-3 py-1.5 fw-bold">
                    <i class="bi bi-plus-circle-fill me-1"></i> + Add New Candidate
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-profiles align-middle">
                <thead>
                    <tr>
                        <th style="width: 170px;">Candidate</th>
                        <th style="width: 160px;">Demographics</th>
                        <th style="min-width: 230px;">Profession</th>
                        <th style="min-width: 220px;">Education</th>
                        <th style="min-width: 190px;">Present Location</th>
                        <th style="min-width: 170px;">Ancestral Origin</th>
                        <th style="width: 170px;">Tier &amp; Income</th>
                        <th class="text-center" style="width: 110px;">Status</th>
                        <th class="text-end" style="width: 110px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profiles as $profile)
                    <tr>
                        <!-- 1. Candidate Photo & Code -->
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <img src="{{ $profile->resolved_image }}" alt="{{ $profile->profile_code }}" class="profile-thumb {{ $profile->is_discreet ? 'is-discreet' : '' }}">
                                <div>
                                    <div class="fw-bold text-gold-bright font-monospace fs-6">
                                        {{ $profile->profile_code }}
                                    </div>
                                    @if($profile->is_discreet)
                                        <span class="badge badge-discreet mt-1">
                                            <i class="bi bi-shield-lock-fill"></i> Discreet
                                        </span>
                                    @else
                                        <span class="badge bg-dark border border-secondary border-opacity-50 text-silver mt-1" style="font-size: 0.68rem;">
                                            <i class="bi bi-eye-fill text-success me-0.5"></i> Public
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- 2. Demographics -->
                        <td>
                            <div>
                                @if($profile->gender === 'female')
                                    <span class="badge badge-bride">
                                        <i class="bi bi-gender-female"></i> Bride
                                    </span>
                                @else
                                    <span class="badge badge-groom">
                                        <i class="bi bi-gender-male"></i> Groom
                                    </span>
                                @endif
                            </div>
                            <div class="text-white fw-bold mt-1 fs-7">
                                {{ $profile->age }} Yrs &bull; {{ $profile->height }}
                            </div>
                            <div class="small text-silver mt-0.5">
                                {{ $profile->religion }}
                            </div>
                        </td>

                        <!-- 3. Profession -->
                        <td>
                            <div class="text-white fw-bold fs-6">
                                {{ $profile->profession }}
                            </div>
                        </td>

                        <!-- 4. Education -->
                        <td>
                            <div class="text-silver d-flex align-items-center gap-1.5">
                                <i class="bi bi-mortarboard-fill text-gold flex-shrink-0 fs-6"></i>
                                <span class="text-white fw-medium">{{ $profile->education }}</span>
                            </div>
                        </td>

                        <!-- 5. Present Location -->
                        <td>
                            <div class="text-white fw-medium d-flex align-items-center gap-1.5">
                                <i class="bi bi-geo-alt-fill text-danger flex-shrink-0"></i>
                                <span>{{ $profile->location }}</span>
                            </div>
                        </td>

                        <!-- 6. Ancestral Origin (Desher Bari) -->
                        <td>
                            <div class="text-silver d-flex align-items-center gap-1.5">
                                <i class="bi bi-house-door-fill text-gold flex-shrink-0"></i>
                                <strong class="text-white">{{ $profile->desher_bari }}</strong>
                            </div>
                        </td>

                        <!-- 7. Tier & Income -->
                        <td>
                            <div>
                                <span class="badge badge-tier">
                                    {{ $profile->category }}
                                </span>
                            </div>
                            <div class="small fw-bold mt-1 text-gold-bright">
                                <i class="bi bi-cash-stack me-1 text-gold"></i>{{ $profile->income }}
                            </div>
                        </td>

                        <!-- 8. Status Toggle: Active in bright green vs Inactive in red -->
                        <td class="text-center">
                            <form action="{{ route('admin.profiles.toggle-active', $profile) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button 
                                    type="submit" 
                                    class="btn-status-toggle {{ $profile->is_active ? 'active' : 'inactive' }}"
                                    title="Click to toggle active / inactive status"
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

                        <!-- 9. Actions: Edit & Delete Icon Buttons -->
                        <td class="text-end">
                            <div class="d-inline-flex gap-2 align-items-center justify-content-end">
                                <!-- Edit Icon Button -->
                                <a 
                                    href="{{ route('admin.profiles.edit', $profile) }}" 
                                    class="btn-action-icon edit" 
                                    title="Edit Candidate"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Delete Icon Button -->
                                <button 
                                    type="button" 
                                    class="btn-action-icon delete" 
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
                                    <div class="modal-content text-white" style="background: #1c0510; border: 1px solid rgba(220, 53, 69, 0.45); border-radius: 14px;">
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
                        <td colspan="9" class="text-center py-5 text-silver">
                            <i class="bi bi-people display-4 d-block mb-3 opacity-25 text-gold"></i>
                            <h5 class="text-white fw-bold">No candidate profiles found</h5>
                            <p class="small text-silver mb-3">Try adjusting your search query or reset the filters.</p>
                            <a href="{{ route('admin.profiles.create') }}" class="btn btn-admin-primary btn-sm px-3.5 py-2 fw-bold">
                                <i class="bi bi-plus-circle-fill me-1"></i> + Add New Candidate
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
