@extends('admin.layouts.app')

@section('title', 'Success Stories CMS')
@section('page-title', 'Success Stories CMS')

@push('styles')
<style>
    /* Clean layout wrapper */
    .stories-wrapper {
        width: 100%;
    }

    /* Stat Pills */
    .stat-pill {
        background: #18030c;
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        transition: transform 0.2s ease, border-color 0.2s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    }
    .stat-pill:hover {
        border-color: rgba(212, 175, 55, 0.55);
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

    /* Table Container */
    .table-container {
        background: #17040d;
        border: 1px solid rgba(212, 175, 55, 0.3);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    }
    .table-stories {
        min-width: 1050px;
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }
    .table-stories thead th {
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
    .table-stories tbody td {
        padding: 0.95rem 0.95rem;
        vertical-align: middle;
        background: transparent !important;
        border-bottom: 1px solid rgba(212, 175, 55, 0.12) !important;
        color: #e2e8f0;
        font-size: 0.88rem;
    }
    .table-stories tbody tr:hover td {
        background: rgba(212, 175, 55, 0.05) !important;
    }

    /* Thumbnail */
    .story-thumb {
        width: 58px;
        height: 58px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid rgba(212, 175, 55, 0.4);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
    }

    /* Badges & Location Pill */
    .badge-gold {
        background: rgba(212, 175, 55, 0.15);
        color: #fde68a;
        border: 1px solid rgba(212, 175, 55, 0.35);
        font-weight: 600;
        padding: 0.35rem 0.65rem;
        border-radius: 8px;
        font-size: 0.76rem;
    }
    .story-location-tag {
        display: inline-flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e2e8f0;
        font-size: 0.78rem;
        font-weight: 500;
        padding: 0.3rem 0.65rem;
        border-radius: 6px;
        letter-spacing: 0.2px;
        white-space: nowrap;
    }
    .story-location-tag i {
        color: var(--theme-secondary, #d4af37);
        font-size: 0.8rem;
    }

    /* Clean Testimonial Quote Card */
    .story-quote-card {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        background: #0f141d;
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-left: 3px solid var(--theme-secondary, #d4af37);
        padding: 0.45rem 0.7rem;
        border-radius: 8px;
        color: #cbd5e1;
        font-size: 0.8rem;
        line-height: 1.45;
        font-style: italic;
        max-width: 280px;
        transition: all 0.2s ease;
        cursor: default;
    }
    .story-quote-card:hover {
        background: #141b27;
        border-color: rgba(212, 175, 55, 0.35);
        border-left-color: var(--theme-secondary, #d4af37);
        color: #ffffff;
    }
    .story-quote-icon {
        font-size: 0.9rem;
        color: var(--theme-secondary, #d4af37);
        margin-right: 0.25rem;
        vertical-align: -1px;
    }

    /* Status Toggle Buttons */
    .btn-status-toggle {
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.3rem 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-status-toggle.active {
        background: rgba(34, 197, 94, 0.2);
        color: #86efac;
        border: 1px solid rgba(34, 197, 94, 0.5);
    }
    .btn-status-toggle.active:hover {
        background: #16a34a;
        color: #ffffff;
        transform: scale(1.03);
    }
    .btn-status-toggle.inactive {
        background: rgba(239, 68, 68, 0.2);
        color: #fca5a5;
        border: 1px solid rgba(239, 68, 68, 0.5);
    }
    .btn-status-toggle.inactive:hover {
        background: #dc2626;
        color: #ffffff;
        transform: scale(1.03);
    }

    /* Featured Toggle */
    .btn-featured-toggle {
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.3rem 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        transition: all 0.2s ease;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-featured-toggle.featured {
        background: rgba(212, 175, 55, 0.22);
        color: #fde68a;
        border: 1px solid rgba(212, 175, 55, 0.6);
    }
    .btn-featured-toggle.featured:hover {
        background: #d4af37;
        color: #0b0206;
        transform: scale(1.03);
    }
    .btn-featured-toggle.standard {
        background: rgba(148, 163, 184, 0.15);
        color: #cbd5e1;
        border: 1px solid rgba(148, 163, 184, 0.3);
    }
    .btn-featured-toggle.standard:hover {
        background: #64748b;
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
<div class="container-fluid px-0 stories-wrapper">

    <!-- Quick Stats Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="stat-pill">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Total Stories</div>
                        <div class="num">{{ $stats['total'] }}</div>
                    </div>
                    <i class="bi bi-heart-pulse-fill fs-3 text-gold opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
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
        <div class="col-12 col-md-4">
            <div class="stat-pill">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Featured on Home</div>
                        <div class="num text-gold">{{ $stats['featured'] }}</div>
                    </div>
                    <i class="bi bi-stars fs-3 text-gold opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('admin.stories.index') }}" class="row g-2 align-items-end">
            <!-- Search Text -->
            <div class="col-lg-5 col-md-6">
                <label class="filter-label">Search Stories</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary border-opacity-50 text-gold">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control filter-input" 
                        placeholder="Search couple names, titles, locations, venue..." 
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

            <!-- Featured Showcase -->
            <div class="col-lg-2 col-md-3 col-6">
                <label class="filter-label">Homepage Showcase</label>
                <select name="featured" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">All Stories</option>
                    <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Featured Only</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="col-lg-2 col-md-12 d-flex gap-2">
                <button type="submit" class="btn btn-admin-primary flex-grow-1 py-2 fw-bold text-dark">
                    <i class="bi bi-funnel-fill me-1"></i> Filter
                </button>
                @if(request()->anyFilled(['search', 'status', 'featured']))
                    <a href="{{ route('admin.stories.index') }}" class="btn btn-outline-secondary py-2 px-3" title="Reset Filters">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Stories Table Card -->
    <div class="table-container shadow-lg">
        <!-- Table Card Header -->
        <div class="p-3 px-4 border-bottom border-secondary border-opacity-25 d-flex flex-wrap justify-content-between align-items-center gap-3" style="background: rgba(0, 0, 0, 0.25);">
            <div class="d-flex align-items-center gap-2">
                <h5 class="text-white fw-bold mb-0">
                    <i class="bi bi-heart-fill text-gold me-1"></i> Success Stories Catalog
                </h5>
                <span class="badge rounded-pill bg-dark border border-warning-subtle text-gold px-2.5 py-1">
                    {{ $stories->total() }} Stories
                </span>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('stories') }}" target="_blank" class="btn btn-outline-warning btn-sm px-3 py-1.5 text-gold fw-semibold">
                    <i class="bi bi-globe2 me-1"></i> Preview Public Stories
                </a>
                <a href="{{ route('admin.stories.create') }}" class="btn btn-admin-primary btn-sm px-3.5 py-1.5 fw-bold text-dark">
                    <i class="bi bi-plus-circle-fill me-1"></i> + Add New Story
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-stories align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;" class="text-center">Order</th>
                        <th style="width: 70px;">Photo</th>
                        <th>Couple &amp; Pedigree Titles</th>
                        <th>Locations</th>
                        <th>Wedding Date &amp; Venue</th>
                        <th>Testimonial Quote</th>
                        <th class="text-center" style="width: 120px;">Featured</th>
                        <th class="text-center" style="width: 120px;">Status</th>
                        <th class="text-end" style="width: 110px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stories as $story)
                        <tr>
                            <!-- Order / ID -->
                            <td class="text-center">
                                <span class="badge rounded-pill bg-dark border border-secondary text-secondary" title="Sort Order #{{ $story->sort_order }}">
                                    #{{ $story->sort_order }}
                                </span>
                            </td>

                            <!-- Photo Thumbnail -->
                            <td>
                                <img src="{{ $story->image }}" alt="{{ $story->names }}" class="story-thumb">
                            </td>

                            <!-- Couple Names & Titles -->
                            <td>
                                <div class="fw-bold text-gold-bright fs-6 mb-0.5">{{ $story->names }}</div>
                                <div class="small text-silver">{{ $story->titles }}</div>
                            </td>

                            <!-- Locations -->
                            <td>
                                <div class="story-location-tag">
                                    <i class="bi bi-geo-alt-fill me-1"></i>
                                    <span>{{ $story->locations }}</span>
                                </div>
                            </td>

                            <!-- Wedding Date & Venue -->
                            <td>
                                <div class="small text-white fw-semibold">
                                    <i class="bi bi-calendar-heart text-gold me-1"></i>{{ $story->year }}
                                </div>
                            </td>

                            <!-- Testimonial Quote -->
                            <td style="max-width: 280px;">
                                <div class="story-quote-card" title="{{ $story->quote }}">
                                    <i class="bi bi-quote story-quote-icon"></i>
                                    <span>{{ $story->quote }}</span>
                                </div>
                            </td>

                            <!-- Featured Toggle -->
                            <td class="text-center">
                                <form action="{{ route('admin.stories.toggle-featured', $story) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="btn-featured-toggle {{ $story->is_featured ? 'featured' : 'standard' }}"
                                        title="Click to toggle homepage featured state"
                                    >
                                        <i class="bi {{ $story->is_featured ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        {{ $story->is_featured ? 'Featured' : 'Standard' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Status Toggle -->
                            <td class="text-center">
                                <form action="{{ route('admin.stories.toggle-active', $story) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="btn-status-toggle {{ $story->is_active ? 'active' : 'inactive' }}"
                                        title="Click to toggle publish status"
                                    >
                                        <i class="bi {{ $story->is_active ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                                        {{ $story->is_active ? 'Published' : 'Draft' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Action Buttons -->
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <!-- View Details Button (36px Sky/Cyan) -->
                                    <button 
                                        type="button" 
                                        class="btn-action-icon view" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewStoryModal{{ $story->id }}"
                                        title="View Full Testimonial Details"
                                    >
                                        <i class="bi bi-eye-fill"></i>
                                    </button>

                                    <!-- Edit Button (36px Gold) -->
                                    <a 
                                        href="{{ route('admin.stories.edit', $story) }}" 
                                        class="btn-action-icon edit" 
                                        title="Edit Success Story"
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <!-- Delete Button (36px Red) -->
                                    <button 
                                        type="button" 
                                        class="btn-action-icon delete" 
                                        title="Delete Story"
                                        onclick="confirmDeleteStory('{{ $story->id }}', '{{ addslashes($story->names) }}')"
                                    >
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>

                                <!-- View Story Modal -->
                                <div class="modal fade text-start" id="viewStoryModal{{ $story->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content text-white" style="background: #141820; border: 1px solid rgba(212, 175, 55, 0.35); border-radius: 16px;">
                                            <div class="modal-header border-bottom border-secondary border-opacity-25 py-3 px-4">
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="bi bi-heart-fill text-gold fs-5"></i>
                                                    <h5 class="modal-title fw-bold text-white mb-0">{{ $story->names }}</h5>
                                                </div>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row g-4 align-items-center">
                                                    <div class="col-md-5 text-center">
                                                        <img src="{{ $story->image }}" alt="{{ $story->names }}" class="img-fluid rounded-3 border border-warning border-opacity-25 shadow-sm mb-2" style="max-height: 240px; object-fit: cover; width: 100%;">
                                                        <div class="text-gold fw-bold">{{ $story->names }}</div>
                                                        <div class="text-silver small">{{ $story->titles }}</div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="d-flex flex-wrap gap-2 mb-3">
                                                            <span class="story-location-tag">
                                                                <i class="bi bi-geo-alt-fill me-1"></i> {{ $story->locations }}
                                                            </span>
                                                            <span class="badge rounded-pill bg-dark border border-secondary border-opacity-50 text-white px-2.5 py-1.5 small">
                                                                <i class="bi bi-calendar-heart text-gold me-1"></i> {{ $story->year }}
                                                            </span>
                                                            @if($story->is_featured)
                                                                <span class="badge rounded-pill bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1.5 small">
                                                                    <i class="bi bi-star-fill me-1"></i> Featured on Home
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <label class="text-gold fw-semibold small text-uppercase mb-1 d-block" style="letter-spacing: 0.5px;">Testimonial Quote</label>
                                                        <div class="p-3 rounded-3" style="background: #0b0f17; border-left: 4px solid var(--theme-secondary, #d4af37); color: #cbd5e1; font-style: italic; line-height: 1.6;">
                                                            <i class="bi bi-quote fs-4 text-gold me-1"></i>{{ $story->quote }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top border-secondary border-opacity-25 py-2.5 px-4 d-flex justify-content-between">
                                                <span class="small text-muted">Order Priority: #{{ $story->sort_order }}</span>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('stories') }}" target="_blank" class="btn btn-outline-secondary btn-sm px-3">
                                                        <i class="bi bi-globe me-1"></i> Public Gallery
                                                    </a>
                                                    <a href="{{ route('admin.stories.edit', $story) }}" class="btn btn-admin-primary btn-sm px-3 fw-bold text-dark">
                                                        <i class="bi bi-pencil-square me-1"></i> Edit Story
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-heartbreak fs-1 text-gold opacity-50 d-block mb-3"></i>
                                    <h5 class="text-white fw-bold mb-2">No Success Stories Found</h5>
                                    <p class="text-muted mb-4">
                                        @if(request()->anyFilled(['search', 'status', 'featured']))
                                            No stories match your search filters. Try clearing your filters.
                                        @else
                                            Get started by adding your first celebrated matrimonial alliance!
                                        @endif
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        @if(request()->anyFilled(['search', 'status', 'featured']))
                                            <a href="{{ route('admin.stories.index') }}" class="btn btn-outline-secondary px-4 py-2">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.stories.create') }}" class="btn btn-admin-primary px-4 py-2 fw-bold text-dark">
                                            <i class="bi bi-plus-circle-fill me-1"></i> Add First Success Story
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($stories->hasPages())
            <div class="p-3 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: rgba(0, 0, 0, 0.2);">
                <div class="text-muted small">
                    Showing {{ $stories->firstItem() }} to {{ $stories->lastItem() }} of {{ $stories->total() }} stories
                </div>
                <div>
                    {{ $stories->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteStoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #18030c; border: 1px solid rgba(239, 68, 68, 0.5); border-radius: 16px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2 text-danger">
                    <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    <h5 class="modal-title fw-bold text-white">Delete Success Story</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-silver pt-3">
                Are you sure you want to delete the success story for <strong id="deleteStoryName" class="text-white"></strong>?
                <p class="small text-danger opacity-75 mt-2 mb-0">
                    <i class="bi bi-info-circle me-1"></i> This action cannot be undone. Associated photos stored in local media will also be permanently deleted.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteStoryForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 fw-bold">
                        <i class="bi bi-trash3-fill me-1"></i> Confirm Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDeleteStory(storyId, storyName) {
        const modalEl = document.getElementById('deleteStoryModal');
        const formEl = document.getElementById('deleteStoryForm');
        const nameEl = document.getElementById('deleteStoryName');

        nameEl.textContent = storyName;
        formEl.action = "{{ url('admin/stories') }}/" + storyId;

        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
</script>
@endpush
