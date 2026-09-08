@extends('admin.layouts.app')

@section('title', 'Membership Packages & Pricing')
@section('page-title', 'Membership Packages & Pricing CMS')

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

    .table-packages th {
        background: rgba(0, 0, 0, 0.45) !important;
        color: #fce7a1 !important;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 1rem 0.85rem;
        border-bottom: 1px solid rgba(212, 175, 55, 0.25) !important;
        white-space: nowrap;
    }
    .table-packages td {
        padding: 1rem 0.85rem;
        vertical-align: middle;
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }
    .table-packages tr:hover td {
        background: rgba(212, 175, 55, 0.05) !important;
    }

    .btn-action-icon {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: #e5e7eb;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-action-icon:hover {
        background: rgba(212, 175, 55, 0.2);
        border-color: rgba(212, 175, 55, 0.4);
        color: #fce7a1;
    }
    .btn-action-icon.btn-danger-custom:hover {
        background: rgba(220, 53, 69, 0.25);
        border-color: rgba(220, 53, 69, 0.5);
        color: #f87171;
    }

    .package-icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.2) 0%, rgba(117, 20, 35, 0.4) 100%);
        border: 1px solid rgba(212, 175, 55, 0.35);
        color: var(--gold-light);
        font-size: 1.3rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 py-2.5 px-3 mb-4 text-white" style="background: rgba(25, 135, 84, 0.35); border-left: 4px solid #22c55e !important;" role="alert">
            <i class="bi bi-check-circle-fill me-2 text-success"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header Actions & Portfolio Stats -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="text-white fw-bold mb-1">
                <i class="bi bi-gem text-gold me-2"></i> Membership Packages Management
            </h4>
            <p class="text-muted-custom small mb-0">
                Configure bespoke membership tiers, fee structures, and elite matchmaking privileges displayed across the portal.
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('packages') }}" target="_blank" class="btn btn-outline-warning btn-sm px-3 py-2 text-gold">
                <i class="bi bi-box-arrow-up-right me-1"></i> Preview Public Pricing
            </a>
            <a href="{{ route('admin.packages.create') }}" class="btn btn-admin-primary btn-sm px-3 py-2 fw-semibold">
                <i class="bi bi-plus-circle-fill me-1"></i> Create New Package
            </a>
        </div>
    </div>

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

    <!-- Filter & Search Card -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('admin.packages.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label small text-muted-custom mb-1">Search Packages</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-transparent border-secondary border-opacity-50 text-gold">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search by package name, target audience, or badge..." 
                        value="{{ request('search') }}"
                    >
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label small text-muted-custom mb-1">Publish Status</label>
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Only</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Only</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label small text-muted-custom mb-1">Highlight Tier</label>
                <select name="featured" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Tiers</option>
                    <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Most Preferred Only</option>
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-admin-primary btn-sm flex-grow-1 py-1.5">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                @if(request()->anyFilled(['search', 'status', 'featured']))
                    <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-secondary btn-sm py-1.5" title="Reset Filters">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Packages Data Table -->
    <div class="card bg-transparent border-0">
        <div class="table-responsive rounded-4 border border-secondary border-opacity-25" style="background: #18030c;">
            <table class="table table-packages mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;">Order</th>
                        <th>Package Tier</th>
                        <th>Badge &amp; Category</th>
                        <th>Pricing / Fee</th>
                        <th>Privileges Included</th>
                        <th class="text-center">Most Preferred</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" style="min-width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $pkg)
                    <tr>
                        <!-- Sort Order -->
                        <td>
                            <span class="badge rounded-pill bg-dark border border-secondary border-opacity-50 text-gold fw-bold px-2 py-1">
                                #{{ $pkg->sort_order }}
                            </span>
                        </td>

                        <!-- Package Tier -->
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="package-icon-box">
                                    <i class="bi bi-crown"></i>
                                </div>
                                <div>
                                    <div class="text-white fw-bold fs-6">{{ $pkg->name }}</div>
                                    <div class="text-muted-custom small font-monospace">slug: {{ $pkg->slug }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Badge / Subtitle -->
                        <td>
                            @if($pkg->badge)
                                <span class="badge" style="background: rgba(212, 175, 55, 0.15); color: #fce7a1; border: 1px solid rgba(212, 175, 55, 0.35); font-size: 0.78rem;">
                                    <i class="bi bi-tag-fill me-1 text-gold"></i>{{ $pkg->badge }}
                                </span>
                            @else
                                <span class="text-muted-custom small">&mdash;</span>
                            @endif
                        </td>

                        <!-- Price / Fee -->
                        <td>
                            @if($pkg->price)
                                <span class="fw-semibold text-white">
                                    {{ $pkg->price }}
                                </span>
                            @else
                                <span class="text-muted-custom small">Consultation Quote</span>
                            @endif
                        </td>

                        <!-- Privileges Count -->
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge rounded-pill bg-secondary bg-opacity-25 text-white border border-secondary border-opacity-50 px-2 py-1 small">
                                    {{ is_array($pkg->benefits) ? count($pkg->benefits) : 0 }} Benefits
                                </span>
                            </div>
                            @if(is_array($pkg->benefits) && count($pkg->benefits) > 0)
                                <div class="text-muted-custom small text-truncate mt-1" style="max-width: 260px;" title="{{ implode(' • ', $pkg->benefits) }}">
                                    {{ $pkg->benefits[0] }}
                                </div>
                            @endif
                        </td>

                        <!-- Most Preferred Badge Toggle -->
                        <td class="text-center">
                            <form action="{{ route('admin.packages.toggle-featured', $pkg) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm border-0 bg-transparent p-0" title="Click to toggle featured ribbon">
                                    @if($pkg->featured)
                                        <span class="badge bg-warning text-dark border border-warning fw-bold px-2 py-1">
                                            <i class="bi bi-star-fill me-1"></i> Featured
                                        </span>
                                    @else
                                        <span class="badge bg-dark text-muted-custom border border-secondary border-opacity-25 px-2 py-1">
                                            <i class="bi bi-star me-1"></i> Standard
                                        </span>
                                    @endif
                                </button>
                            </form>
                        </td>

                        <!-- Active Toggle -->
                        <td class="text-center">
                            <form action="{{ route('admin.packages.toggle-active', $pkg) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm border-0 bg-transparent p-0" title="Click to toggle active status">
                                    @if($pkg->is_active)
                                        <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50 px-2 py-1">
                                            <i class="bi bi-check-circle-fill me-1"></i> Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-25 text-danger border border-danger border-opacity-50 px-2 py-1">
                                            <i class="bi bi-x-circle-fill me-1"></i> Inactive
                                        </span>
                                    @endif
                                </button>
                            </form>
                        </td>

                        <!-- Actions -->
                        <td class="text-end">
                            <div class="d-inline-flex gap-1">
                                <a 
                                    href="{{ route('admin.packages.edit', $pkg) }}" 
                                    class="btn-action-icon" 
                                    title="Edit Package"
                                >
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <button 
                                    type="button" 
                                    class="btn-action-icon btn-danger-custom border-0" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deletePackageModal{{ $pkg->id }}"
                                    title="Delete Package"
                                >
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade text-start" id="deletePackageModal{{ $pkg->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content text-white" style="background: #1f0511; border: 1px solid rgba(220, 53, 69, 0.4);">
                                        <div class="modal-header border-bottom border-secondary border-opacity-25">
                                            <h5 class="modal-title fw-bold text-danger">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Delete Membership Package
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body py-4">
                                            <p class="mb-2">Are you sure you want to delete the package <strong class="text-gold">{{ $pkg->name }}</strong>?</p>
                                            <p class="small text-muted-custom mb-0">
                                                This will permanently remove this tier from the public pricing and comparison matrix.
                                            </p>
                                        </div>
                                        <div class="modal-footer border-top border-secondary border-opacity-25">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.packages.destroy', $pkg) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm px-3">
                                                    <i class="bi bi-trash3-fill me-1"></i> Delete Package
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
                            <i class="bi bi-gem display-5 d-block mb-3 opacity-25"></i>
                            <h5 class="text-white">No membership packages found</h5>
                            <p class="small mb-3">Adjust your search filters or create a new package tier.</p>
                            <a href="{{ route('admin.packages.create') }}" class="btn btn-admin-primary btn-sm">
                                <i class="bi bi-plus-circle me-1"></i> Add First Package
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($packages->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3 px-2">
                <div class="text-muted-custom small">
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
