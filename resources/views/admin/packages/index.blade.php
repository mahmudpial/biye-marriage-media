@extends('admin.layouts.app')

@section('title', 'Membership Packages & Pricing')
@section('page-title', 'Membership Packages CMS')

@push('styles')
<style>
    /* Clean layout wrapper */
    .packages-wrapper {
        width: 100%;
    }

    /* Stat Pills */
    .stat-pill {
        background: #141820;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        transition: transform 0.2s ease, border-color 0.2s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    }
    .stat-pill:hover {
        border-color: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.5);
        transform: translateY(-2px);
    }
    .stat-pill .num {
        font-size: 1.65rem;
        font-weight: 700;
        color: #fff;
    }
    .stat-pill .label {
        font-size: 0.76rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    /* Filter Card */
    .filter-card {
        background: #141820;
        background: linear-gradient(180deg, #171c26 0%, #131720 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 1.15rem 1.35rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35);
    }
    .filter-label {
        color: var(--theme-secondary, #d4af37);
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.35rem;
    }
    .filter-input, .filter-select {
        background: #0d1117 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #f8fafc !important;
        font-size: 0.88rem;
        border-radius: 9px;
        padding: 0.55rem 0.85rem;
        transition: all 0.2s ease;
    }
    .filter-input:focus, .filter-select:focus {
        border-color: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.6) !important;
        box-shadow: 0 0 0 0.2rem rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.2) !important;
    }
    .filter-input::placeholder {
        color: #64748b !important;
    }

    /* Table Container */
    .table-container {
        background: #141820;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    }
    .table-packages {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }
    .table-packages thead th {
        background: #111622 !important;
        color: #f8fafc !important;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 1rem 0.95rem;
        border-bottom: 2px solid rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.35) !important;
        vertical-align: middle;
        white-space: nowrap;
    }
    .table-packages tbody td {
        padding: 0.95rem 0.95rem;
        vertical-align: middle;
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        color: #e2e8f0;
    }
    .table-packages tbody tr:hover td {
        background: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.05) !important;
    }
    .table-packages tbody tr:last-child td {
        border-bottom: none;
    }

    /* Icon Box */
    .package-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.12);
        border: 1px solid rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.3);
        color: var(--theme-secondary, #d4af37);
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    /* Badges */
    .badge-tier {
        background: rgba(212, 175, 55, 0.18);
        color: #fef08a;
        border: 1px solid rgba(212, 175, 55, 0.4);
        font-weight: 600;
        font-size: 0.76rem;
        padding: 0.28rem 0.6rem;
        border-radius: 6px;
        display: inline-block;
    }

    /* Status Toggle: Bright Green Active vs Bright Red Inactive */
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

    /* Featured Toggle */
    .btn-featured-toggle {
        border-radius: 20px;
        padding: 0.32rem 0.75rem;
        font-size: 0.76rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-featured-toggle.featured {
        background: rgba(212, 175, 55, 0.25);
        border: 1px solid #f5d061;
        color: #fef08a;
    }
    .btn-featured-toggle.featured:hover {
        background: #f5d061;
        color: #000000;
        transform: scale(1.03);
    }
    .btn-featured-toggle.standard {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.16);
        color: #94a3b8;
    }
    .btn-featured-toggle.standard:hover {
        border-color: rgba(212, 175, 55, 0.4);
        color: #ffffff;
        transform: scale(1.03);
    }

    /* Action Icon Buttons: 36px square Edit & Delete */
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
        color: #0b0f17 !important;
        border: 1px solid #f5d061;
        box-shadow: 0 2px 8px rgba(212, 175, 55, 0.3);
    }
    .btn-action-icon.edit:hover {
        background: #f5d061;
        color: #000000 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(212, 175, 55, 0.55);
    }
    .btn-action-icon.view {
        background: rgba(56, 189, 248, 0.18);
        border: 1px solid rgba(56, 189, 248, 0.5) !important;
        color: #38bdf8 !important;
    }
    .btn-action-icon.view:hover {
        background: #0284c7;
        color: #ffffff !important;
        border-color: #38bdf8 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(2, 132, 199, 0.55);
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

    /* Colors */
    .text-silver {
        color: #cbd5e1 !important;
    }
    .text-gold-bright {
        color: #fde68a !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0 packages-wrapper">

    <!-- Quick Stats Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-pill">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Total Packages</div>
                        <div class="num">{{ $stats['total'] }}</div>
                    </div>
                    <i class="bi bi-boxes fs-3 text-gold opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-pill">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Published Active</div>
                        <div class="num text-success">{{ $stats['active'] }}</div>
                    </div>
                    <i class="bi bi-check-circle-fill fs-3 text-success opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-pill">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Most Preferred</div>
                        <div class="num text-gold">{{ $stats['featured'] }}</div>
                    </div>
                    <i class="bi bi-star-fill fs-3 text-gold opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-pill">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Total Privileges</div>
                        <div class="num" style="color: #93c5fd;">{{ $stats['total_benefits'] }}</div>
                    </div>
                    <i class="bi bi-card-checklist fs-3 opacity-50" style="color: #93c5fd;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('admin.packages.index') }}" class="row g-2 align-items-end">
            <!-- Search Text -->
            <div class="col-lg-5 col-md-6">
                <label class="filter-label">Search Packages</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary border-opacity-50 text-gold">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control filter-input" 
                        placeholder="Search tier name, badge or persona..." 
                        value="{{ request('search') }}"
                    >
                </div>
            </div>

            <!-- Publish Status -->
            <div class="col-lg-3 col-md-3 col-6">
                <label class="filter-label">Publish Status</label>
                <select name="status" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                </select>
            </div>

            <!-- Highlight Tier -->
            <div class="col-lg-2 col-md-3 col-6">
                <label class="filter-label">Highlight Tier</label>
                <select name="featured" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">All Tiers</option>
                    <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Most Preferred Only</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="col-lg-2 col-md-12 d-flex gap-2 align-items-end">
                <button type="submit" class="btn btn-admin-primary flex-grow-1 fw-semibold">
                    <i class="bi bi-funnel-fill me-1"></i> Filter
                </button>
                @if(request()->anyFilled(['search', 'status', 'featured']))
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary filter-reset-btn" title="Reset Filters">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Packages Table Card -->
    <div class="table-container shadow-lg">
        <!-- Table Card Header -->
        <div class="p-3 px-4 border-bottom border-secondary border-opacity-25 d-flex flex-wrap justify-content-between align-items-center gap-3" style="background: rgba(0, 0, 0, 0.25);">
            <div class="d-flex align-items-center gap-2">
                <h5 class="text-white fw-bold mb-0">
                    <i class="bi bi-gem text-gold me-1"></i> Packages List
                </h5>
                <span class="badge rounded-pill bg-dark border border-warning-subtle text-gold px-2.5 py-1">
                    {{ $packages->total() }} Tiers
                </span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.packages.create') }}" class="btn btn-admin-primary fw-semibold d-inline-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>+ Add New Package</span>
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-packages align-middle">
                <thead>
                    <tr>
                        <th style="width: 70px;" class="text-center">Order</th>
                        <th style="width: 220px;" class="text-center">Package Tier</th>
                        <th style="width: 200px;" class="text-center">Badge &amp; Category</th>
                        <th style="width: 170px;" class="text-center">Pricing / Fee</th>
                        <th class="text-center">Privileges Included</th>
                        <th class="text-center" style="width: 140px;">Most Preferred</th>
                        <th class="text-center" style="width: 120px;">Status</th>
                        <th class="text-center" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $pkg)
                    <tr>
                        <!-- 1. Order -->
                        <td class="text-center">
                            <span class="badge rounded-pill bg-dark border border-secondary border-opacity-50 text-gold fw-bold px-2.5 py-1">
                                #{{ $pkg->sort_order }}
                            </span>
                        </td>

                        <!-- 2. Package Tier -->
                        <td class="text-center">
                            <div>
                                <div class="text-white fw-bold fs-6 mb-0.5">{{ $pkg->name }}</div>
                                <div class="text-silver small font-monospace" style="font-size: 0.78rem;">
                                    <span class="text-muted-custom">slug:</span> {{ $pkg->slug }}
                                </div>
                            </div>
                        </td>

                        <!-- 3. Badge & Category -->
                        <td class="text-center">
                            @if($pkg->badge)
                                <span class="badge-tier">
                                    <i class="bi bi-tag-fill me-1 text-gold"></i>{{ $pkg->badge }}
                                </span>
                            @else
                                <span class="text-muted-custom small">&mdash;</span>
                            @endif
                        </td>

                        <!-- 4. Price / Fee -->
                        <td class="text-center">
                            @if($pkg->price)
                                <span class="fw-bold text-gold-bright fs-6">
                                    {{ $pkg->price }}
                                </span>
                            @else
                                <span class="text-silver small italic">Consultation Quote</span>
                            @endif
                        </td>

                        <!-- 5. Privileges Included -->
                        <td class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <span class="badge rounded-pill bg-dark text-white border border-secondary border-opacity-50 px-2.5 py-1 small">
                                    <i class="bi bi-check2-circle text-gold me-1"></i>{{ is_array($pkg->benefits) ? count($pkg->benefits) : 0 }} Benefits
                                </span>
                            </div>
                            @if(is_array($pkg->benefits) && count($pkg->benefits) > 0)
                                <div class="text-silver small text-truncate mt-1 mx-auto" style="max-width: 280px;" title="{{ implode(' • ', $pkg->benefits) }}">
                                    {{ $pkg->benefits[0] }}
                                </div>
                            @endif
                        </td>

                        <!-- 6. Most Preferred Toggle -->
                        <td class="text-center">
                            <form action="{{ route('admin.packages.toggle-featured', $pkg) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button 
                                    type="submit" 
                                    class="btn-featured-toggle {{ $pkg->featured ? 'featured' : 'standard' }}"
                                    title="Click to toggle most preferred ribbon"
                                >
                                    @if($pkg->featured)
                                        <i class="bi bi-star-fill text-gold"></i> Featured
                                    @else
                                        <i class="bi bi-star"></i> Standard
                                    @endif
                                </button>
                            </form>
                        </td>

                        <!-- 7. Status Toggle (Active bright green vs Inactive red) -->
                        <td class="text-center">
                            <form action="{{ route('admin.packages.toggle-active', $pkg) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button 
                                    type="submit" 
                                    class="btn-status-toggle {{ $pkg->is_active ? 'active' : 'inactive' }}"
                                    title="Click to toggle active / inactive status"
                                >
                                    @if($pkg->is_active)
                                        <i class="bi bi-check-circle-fill"></i> Active
                                    @else
                                        <i class="bi bi-x-circle-fill"></i> Inactive
                                    @endif
                                </button>
                            </form>
                        </td>

                        <!-- 8. Actions: View, Edit & Delete Icon Buttons -->
                        <td class="text-center">
                            <div class="d-flex gap-2 align-items-center justify-content-center">
                                <!-- View Details Icon Button -->
                                <button 
                                    type="button" 
                                    class="btn-action-icon view" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#viewPackageModal{{ $pkg->id }}"
                                    title="View Package Privileges &amp; Details"
                                >
                                    <i class="bi bi-eye-fill"></i>
                                </button>

                                <!-- Edit Icon Button -->
                                <a 
                                    href="{{ route('admin.packages.edit', $pkg) }}" 
                                    class="btn-action-icon edit" 
                                    title="Edit Package"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Delete Icon Button -->
                                <button 
                                    type="button" 
                                    class="btn-action-icon delete" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deletePackageModal{{ $pkg->id }}"
                                    title="Delete Package"
                                >
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </div>

                            <!-- Package Details Modal -->
                            <div class="modal fade text-start" id="viewPackageModal{{ $pkg->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content text-white" style="background: #141820; border: 1px solid rgba(212, 175, 55, 0.35); border-radius: 16px;">
                                        <div class="modal-header border-bottom border-secondary border-opacity-25 py-3 px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-crown text-gold fs-5"></i>
                                                <h5 class="modal-title fw-bold text-white mb-0">Package: <span class="text-gold">{{ $pkg->name }}</span></h5>
                                            </div>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row g-4 mb-3">
                                                <div class="col-md-6">
                                                    <div class="modal-label">Pricing / Fee Structure</div>
                                                    <div class="fs-4 fw-bold text-gold-bright">{{ $pkg->price ?: 'Custom Quote' }}</div>
                                                </div>
                                                <div class="col-md-6 text-md-end">
                                                    <div class="modal-label mb-1">Status &amp; Showcase</div>
                                                    <span class="badge {{ $pkg->is_active ? 'bg-success' : 'bg-danger' }} px-2.5 py-1.5 me-1">
                                                        {{ $pkg->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                    @if($pkg->is_popular)
                                                        <span class="badge bg-warning text-dark px-2.5 py-1.5 fw-bold">
                                                            <i class="bi bi-star-fill"></i> Most Preferred
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            @if($pkg->description)
                                            <div class="mb-3 p-3 rounded-3" style="background: #0b0f17; border-left: 3px solid var(--theme-secondary, #d4af37);">
                                                <div class="modal-label mb-1">Overview Description</div>
                                                <div class="text-silver small" style="line-height: 1.55;">{{ $pkg->description }}</div>
                                            </div>
                                            @endif

                                            <div>
                                                <div class="modal-label text-gold mb-2">
                                                    <i class="bi bi-check2-all me-1"></i> Included Privileges &amp; Features ({{ is_array($pkg->benefits) ? count($pkg->benefits) : 0 }})
                                                </div>
                                                <div class="row g-2">
                                                    @forelse($pkg->benefits ?? [] as $benefit)
                                                        <div class="col-md-6">
                                                            <div class="d-flex align-items-start gap-2 p-2 rounded" style="background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.06);">
                                                                <i class="bi bi-check-circle-fill text-success flex-shrink-0 mt-0.5"></i>
                                                                <span class="small text-silver">{{ $benefit }}</span>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="col-12 text-silver small">No specific privileges listed.</div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top border-secondary border-opacity-25 py-2.5 px-4 d-flex justify-content-between">
                                            <span class="small text-silver font-monospace">Sort Order #{{ $pkg->sort_order }}</span>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('packages') }}" target="_blank" class="btn btn-outline-secondary btn-sm px-3">
                                                    <i class="bi bi-globe me-1"></i> Public Pricing Page
                                                </a>
                                                <a href="{{ route('admin.packages.edit', $pkg) }}" class="btn btn-admin-primary btn-sm px-3 fw-semibold">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit Package
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade text-start" id="deletePackageModal{{ $pkg->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content text-white" style="background: #141820; border: 1px solid rgba(220, 53, 69, 0.45); border-radius: 16px;">
                                        <div class="modal-header border-bottom border-secondary border-opacity-25 py-3">
                                            <h5 class="modal-title fw-bold text-danger d-flex align-items-center gap-2">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                                Delete Membership Package
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body py-4">
                                            <p class="mb-2 fs-6">
                                                Are you sure you want to delete <strong class="text-gold">{{ $pkg->name }}</strong>?
                                            </p>
                                            <p class="small text-silver mb-0">
                                                This will permanently remove this tier from the public pricing matrix and lead intake forms.
                                            </p>
                                        </div>
                                        <div class="modal-footer border-top border-secondary border-opacity-25 py-2.5">
                                            <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.packages.destroy', $pkg) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm px-3 fw-bold">
                                                    <i class="bi bi-trash3-fill me-1"></i> Yes, Delete Package
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
                            <i class="bi bi-gem display-4 d-block mb-3 opacity-25 text-gold"></i>
                            <h5 class="text-white fw-bold">No membership packages found</h5>
                            <p class="small text-silver mb-3">Adjust your search query or reset the filters.</p>
                            <a href="{{ route('admin.packages.create') }}" class="btn btn-admin-primary px-3 fw-semibold">
                                <i class="bi bi-plus-circle-fill me-1"></i> + Add New Package
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($packages->hasPages())
            <div class="d-flex justify-content-between align-items-center p-3 px-4 border-top border-secondary border-opacity-25">
                <div class="text-silver small">
                    Showing {{ $packages->firstItem() }} to {{ $packages->lastItem() }} of {{ $packages->total() }} packages
                </div>
                <div>
                    {{ $packages->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
