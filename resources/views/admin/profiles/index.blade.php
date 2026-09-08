@extends('admin.layouts.app')

@section('title', 'Candidate Profiles & Biodata')
@section('page-title', 'Candidate Profiles Management')

@push('styles')
<style>
    .stat-pill {
        background: #1e0510;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }
    .stat-pill:hover {
        border-color: rgba(212, 175, 55, 0.4);
        transform: translateY(-2px);
    }
    .stat-pill .num {
        font-size: 1.6rem;
        font-weight: 700;
        color: #fff;
    }
    .stat-pill .label {
        font-size: 0.78rem;
        color: var(--text-muted-custom);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-card {
        background: #1b040e;
        border: 1px solid rgba(212, 175, 55, 0.22);
        border-radius: 16px;
        padding: 1.25rem;
    }

    .profile-thumb {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        object-fit: cover;
        border: 1px solid rgba(212, 175, 55, 0.3);
    }
    .profile-thumb.is-discreet {
        filter: blur(2.5px);
    }

    .table-profiles th {
        background: rgba(0, 0, 0, 0.45) !important;
        color: #fce7a1 !important;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 1rem 0.85rem;
        border-bottom: 1px solid rgba(212, 175, 55, 0.25) !important;
        white-space: nowrap;
    }
    .table-profiles td {
        padding: 0.9rem 0.85rem;
        vertical-align: middle;
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }
    .table-profiles tr:hover td {
        background: rgba(212, 175, 55, 0.05) !important;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        color: #fff;
        text-decoration: none;
    }
    .btn-action-icon.edit {
        background: rgba(212, 175, 55, 0.15);
        border-color: rgba(212, 175, 55, 0.35);
        color: #fde68a;
    }
    .btn-action-icon.edit:hover {
        background: var(--accent-gold);
        color: #1a040b;
    }
    .btn-action-icon.delete {
        background: rgba(239, 68, 68, 0.15);
        border-color: rgba(239, 68, 68, 0.35);
        color: #fca5a5;
    }
    .btn-action-icon.delete:hover {
        background: #ef4444;
        color: #fff;
    }

    .toggle-switch-btn {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-size: 1.15rem;
        line-height: 1;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 py-2 px-3 mb-4 text-white d-flex align-items-center" style="background: rgba(34, 197, 94, 0.2); border-left: 4px solid #22c55e !important;" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Top Metric Counters Strip -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-pill">
                <div class="label"><i class="bi bi-people-fill text-gold me-1"></i> Total Portfolio</div>
                <div class="num">{{ number_format($stats['total']) }}</div>
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
                <div class="num text-info">{{ number_format($stats['brides']) }}</div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-xl">
            <div class="stat-pill">
                <div class="label"><i class="bi bi-gender-male text-warning me-1"></i> Grooms (Patro)</div>
                <div class="num text-warning">{{ number_format($stats['grooms']) }}</div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-xl">
            <div class="stat-pill">
                <div class="label"><i class="bi bi-star-fill text-gold me-1"></i> Featured Home</div>
                <div class="num text-gold">{{ number_format($stats['featured']) }}</div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Controls -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('admin.profiles.index') }}" class="row g-2 align-items-center">
            <!-- Search Text -->
            <div class="col-lg-4 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary border-opacity-50 text-gold">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        name="q" 
                        class="form-control bg-dark text-white border-secondary border-opacity-50" 
                        placeholder="Search by Code, Profession, Desher Bari..." 
                        value="{{ request('q') }}"
                    >
                </div>
            </div>

            <!-- Gender Filter -->
            <div class="col-6 col-lg-2 col-md-3">
                <select name="gender" class="form-select bg-dark text-white border-secondary border-opacity-50" onchange="this.form.submit()">
                    <option value="">All Genders</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Brides (Female)</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Grooms (Male)</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div class="col-6 col-lg-2 col-md-3">
                <select name="category" class="form-select bg-dark text-white border-secondary border-opacity-50" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <option value="Elite Professional" {{ request('category') == 'Elite Professional' ? 'selected' : '' }}>Professional</option>
                    <option value="Elite Business" {{ request('category') == 'Elite Business' ? 'selected' : '' }}>Business</option>
                    <option value="Elite Aristocrat" {{ request('category') == 'Elite Aristocrat' ? 'selected' : '' }}>Aristocrat</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div class="col-6 col-lg-2 col-md-3">
                <select name="status" class="form-select bg-dark text-white border-secondary border-opacity-50" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                    <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured Only</option>
                    <option value="discreet" {{ request('status') == 'discreet' ? 'selected' : '' }}>Discreet Only</option>
                </select>
            </div>

            <!-- Buttons: Search & Add -->
            <div class="col-6 col-lg-2 col-md-9 d-flex gap-2 justify-content-end">
                @if(request()->anyFilled(['q', 'gender', 'category', 'status']))
                    <a href="{{ route('admin.profiles.index') }}" class="btn btn-outline-secondary px-2" title="Reset Filters">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
                <a href="{{ route('admin.profiles.create') }}" class="btn btn-admin-primary text-nowrap w-100">
                    <i class="bi bi-plus-circle-fill me-1"></i> Add Candidate
                </a>
            </div>
        </form>
    </div>

    <!-- Candidate Profiles Table Card -->
    <div class="admin-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="font-playfair text-white fw-bold mb-0">
                    <i class="bi bi-person-lines-fill text-gold me-2"></i> Matrimonial Portfolio
                </h5>
                <p class="small text-muted-custom mb-0">Showing {{ $profiles->firstItem() ?? 0 }}-{{ $profiles->lastItem() ?? 0 }} of {{ $profiles->total() }} candidates</p>
            </div>
            <a href="{{ route('profiles') }}" target="_blank" class="btn btn-sm btn-outline-light text-nowrap">
                <i class="bi bi-box-arrow-up-right me-1"></i> View Live Gallery
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-profiles text-nowrap mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Candidate</th>
                        <th>Demographics</th>
                        <th>Education &amp; Profession</th>
                        <th>Location &amp; District</th>
                        <th>Category &amp; Income</th>
                        <th class="text-center">Featured</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profiles as $profile)
                    <tr>
                        <!-- Candidate Photo & Code -->
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $profile->resolved_image }}" alt="{{ $profile->profile_code }}" class="profile-thumb {{ $profile->is_discreet ? 'is-discreet' : '' }}">
                                <div>
                                    <div class="fw-bold text-white font-monospace" style="color: #fde68a !important;">
                                        {{ $profile->profile_code }}
                                    </div>
                                    @if($profile->is_discreet)
                                        <span class="badge" style="background: rgba(212, 175, 55, 0.15); color: #fde68a; font-size: 0.68rem; border: 1px solid rgba(212, 175, 55, 0.3);">
                                            <i class="bi bi-shield-lock-fill me-1"></i>Discreet
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-25 text-white-50" style="font-size: 0.68rem;">Public</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Demographics -->
                        <td>
                            <div class="text-white fw-medium">
                                @if($profile->gender === 'female')
                                    <span class="badge bg-info bg-opacity-20 text-info border border-info border-opacity-25 me-1">Bride</span>
                                @else
                                    <span class="badge bg-warning bg-opacity-20 text-warning border border-warning border-opacity-25 me-1">Groom</span>
                                @endif
                                <span>{{ $profile->age }} Yrs, {{ $profile->height }}</span>
                            </div>
                            <div class="small text-muted-custom mt-1">{{ $profile->religion }}</div>
                        </td>

                        <!-- Education & Profession -->
                        <td>
                            <div class="text-white fw-semibold text-truncate" style="max-width: 240px;" title="{{ $profile->profession }}">
                                {{ $profile->profession }}
                            </div>
                            <div class="small text-muted-custom text-truncate" style="max-width: 240px;" title="{{ $profile->education }}">
                                <i class="bi bi-mortarboard me-1 text-gold"></i>{{ $profile->education }}
                            </div>
                        </td>

                        <!-- Location & Desher Bari -->
                        <td>
                            <div class="text-white">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $profile->location }}
                            </div>
                            <div class="small text-muted-custom">
                                Home: <strong class="text-white-50">{{ $profile->desher_bari }}</strong>
                            </div>
                        </td>

                        <!-- Category & Income -->
                        <td>
                            <span class="badge" style="background: rgba(212, 175, 55, 0.16); color: #fde68a; border: 1px solid rgba(212, 175, 55, 0.35); font-size: 0.76rem;">
                                {{ $profile->category }}
                            </span>
                            <div class="small fw-medium mt-1" style="color: #fcd34d;">
                                {{ $profile->income }}
                            </div>
                        </td>

                        <!-- Featured Toggle -->
                        <td class="text-center">
                            <form method="POST" action="{{ route('admin.profiles.toggle-featured', $profile) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="toggle-switch-btn" title="Click to toggle featured on homepage">
                                    @if($profile->is_featured)
                                        <i class="bi bi-star-fill text-gold fs-5"></i>
                                    @else
                                        <i class="bi bi-star text-secondary fs-5"></i>
                                    @endif
                                </button>
                            </form>
                        </td>

                        <!-- Active Toggle -->
                        <td class="text-center">
                            <form method="POST" action="{{ route('admin.profiles.toggle-active', $profile) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="toggle-switch-btn" title="Click to toggle active status">
                                    @if($profile->is_active)
                                        <span class="badge bg-success bg-opacity-20 text-success border border-success border-opacity-35 py-1 px-2">
                                            <i class="bi bi-check-circle-fill me-1"></i>Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-20 text-danger border border-danger border-opacity-35 py-1 px-2">
                                            <i class="bi bi-x-circle-fill me-1"></i>Inactive
                                        </span>
                                    @endif
                                </button>
                            </form>
                        </td>

                        <!-- Actions -->
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.profiles.edit', $profile) }}" class="btn-action-icon edit" title="Edit Profile">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <button 
                                    type="button" 
                                    class="btn-action-icon delete" 
                                    title="Delete Profile"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteModal{{ $profile->id }}"
                                >
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </div>

                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade text-start" id="deleteModal{{ $profile->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="background: #1f040f; border: 1px solid rgba(239, 68, 68, 0.4); color: #fff;">
                                        <div class="modal-header border-secondary border-opacity-25">
                                            <h5 class="modal-title font-playfair text-danger">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Delete
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to permanently delete candidate profile <strong class="text-gold font-monospace">#{{ $profile->profile_code }}</strong>?</p>
                                            <p class="small text-muted-custom mb-0">Candidate: {{ $profile->age }} Yrs, {{ $profile->profession }} ({{ $profile->location }})</p>
                                        </div>
                                        <div class="modal-footer border-secondary border-opacity-25">
                                            <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form method="POST" action="{{ route('admin.profiles.destroy', $profile) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger px-3">
                                                    <i class="bi bi-trash-fill me-1"></i> Delete Profile
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
                        <td colspan="8" class="text-center py-5 text-muted-custom">
                            <i class="bi bi-folder-x fs-1 d-block mb-2 text-secondary"></i>
                            No candidate profiles found matching your search filters.
                            <div class="mt-2">
                                <a href="{{ route('admin.profiles.create') }}" class="btn btn-sm btn-admin-primary">
                                    <i class="bi bi-plus-circle me-1"></i> Add First Candidate
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($profiles->hasPages())
            <div class="p-3 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center">
                <div class="small text-muted-custom">
                    Showing {{ $profiles->firstItem() }} to {{ $profiles->lastItem() }} of {{ $profiles->total() }} results
                </div>
                <div>
                    {{ $profiles->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
