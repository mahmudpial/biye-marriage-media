@extends('admin.layouts.app')

@section('title', 'VIP Inquiries & Leads Management')
@section('page-title', 'VIP Inquiries & Leads CMS')

@push('styles')
<style>
    /* Clean layout wrapper */
    .inquiries-wrapper {
        width: 100%;
    }

    /* Stat Pills */
    .stat-pill {
        background: #141820;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    }
    .stat-pill:hover {
        border-color: rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.45);
        transform: translateY(-2px);
    }
    .stat-pill .num {
        font-size: 1.65rem;
        font-weight: 700;
        color: #f8fafc;
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
    }
    .filter-input:focus, .filter-select:focus {
        border-color: var(--theme-secondary, #d4af37) !important;
        box-shadow: 0 0 0 0.2rem rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.25) !important;
    }
    .filter-input::placeholder {
        color: #64748b !important;
    }
    .form-select option {
        background: #0d1117 !important;
        color: #f8fafc !important;
    }

    /* Table Container */
    .table-container {
        background: #141820;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    }
    .table-inquiries {
        min-width: 980px;
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }
    .table-inquiries thead th {
        background: #111622 !important;
        color: #f8fafc !important;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 1rem 0.95rem;
        border-bottom: 2px solid rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.35) !important;
        vertical-align: middle;
        white-space: nowrap;
    }
    .table-inquiries tbody td {
        padding: 0.95rem 0.95rem;
        vertical-align: middle;
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        color: #e2e8f0;
        font-size: 0.88rem;
    }
    .table-inquiries tbody tr:hover td {
        background: rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.05) !important;
    }

    /* Badges */
    .badge-code {
        background: #0d1117;
        color: #f8fafc;
        border: 1px solid rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.4);
        font-family: monospace;
        font-size: 0.82rem;
        font-weight: 700;
        padding: 0.35rem 0.65rem;
        border-radius: 8px;
    }
    .badge-gold {
        background: rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.15);
        color: var(--theme-secondary, #fde68a);
        border: 1px solid rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.35);
        font-weight: 600;
        padding: 0.3rem 0.6rem;
        border-radius: 8px;
        font-size: 0.76rem;
    }

    /* Status Badges & Quick Select */
    .status-badge {
        font-size: 0.78rem;
        font-weight: 700;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        white-space: nowrap;
    }
    .status-pending {
        background: rgba(245, 158, 11, 0.18);
        color: #fde68a;
        border: 1px solid rgba(245, 158, 11, 0.5);
    }
    .status-progress {
        background: rgba(14, 165, 233, 0.18);
        color: #7dd3fc;
        border: 1px solid rgba(14, 165, 233, 0.5);
    }
    .status-contacted {
        background: rgba(168, 85, 247, 0.18);
        color: #d8b4fe;
        border: 1px solid rgba(168, 85, 247, 0.5);
    }
    .status-verified {
        background: rgba(34, 197, 94, 0.18);
        color: #86efac;
        border: 1px solid rgba(34, 197, 94, 0.5);
    }
    .status-closed {
        background: rgba(148, 163, 184, 0.18);
        color: #cbd5e1;
        border: 1px solid rgba(148, 163, 184, 0.4);
    }

    /* Action Buttons (36px square) */
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
    .btn-action-icon.view {
        background: rgba(56, 189, 248, 0.15);
        border: 1px solid rgba(56, 189, 248, 0.4);
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
        background: rgba(220, 38, 38, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.45) !important;
        color: #fca5a5 !important;
    }
    .btn-action-icon.delete:hover {
        background: #dc2626;
        color: #ffffff !important;
        border-color: #ef4444 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(220, 38, 38, 0.55);
    }

    .btn-contact-chip {
        padding: 0.25rem 0.55rem;
        border-radius: 8px;
        font-size: 0.78rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        transition: all 0.2s ease;
    }
    .btn-contact-chip.phone {
        background: rgba(245, 158, 11, 0.15);
        color: #fde68a;
        border: 1px solid rgba(245, 158, 11, 0.35);
    }
    .btn-contact-chip.phone:hover {
        background: #f59e0b;
        color: #000;
    }
    .btn-contact-chip.whatsapp {
        background: rgba(34, 197, 94, 0.15);
        color: #86efac;
        border: 1px solid rgba(34, 197, 94, 0.35);
    }
    .btn-contact-chip.whatsapp:hover {
        background: #22c55e;
        color: #fff;
    }

    /* Modal Form Controls */
    .modal-card {
        background: #141820;
        border: 1px solid rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.35);
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);
    }
    .modal-detail-label {
        font-size: 0.76rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }
    .modal-detail-val {
        color: #f8fafc;
        font-size: 0.95rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0 inquiries-wrapper">

    <!-- Quick Stats Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-pill">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Total Leads</div>
                        <div class="num">{{ $stats['total'] }}</div>
                    </div>
                    <i class="bi bi-journal-text fs-3 text-gold opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-pill">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Pending Review</div>
                        <div class="num text-warning">{{ $stats['pending'] }}</div>
                    </div>
                    <i class="bi bi-clock-history fs-3 text-warning opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-pill">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">In Progress</div>
                        <div class="num" style="color: #7dd3fc;">{{ $stats['in_progress'] }}</div>
                    </div>
                    <i class="bi bi-arrow-repeat fs-3 opacity-50" style="color: #7dd3fc;"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-pill">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="label">Verified / Enrolled</div>
                        <div class="num text-success">{{ $stats['verified'] }}</div>
                    </div>
                    <i class="bi bi-check2-circle fs-3 text-success opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('admin.inquiries.index') }}" class="row g-2 align-items-end">
            <!-- Search Text -->
            <div class="col-lg-4 col-md-6">
                <label class="filter-label">Search Inquiries</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-secondary border-opacity-50 text-gold">
                        <i class="bi bi-search"></i>
                    </span>
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control filter-input" 
                        placeholder="Search name, phone, code, district, city..." 
                        value="{{ request('search') }}"
                    >
                </div>
            </div>

            <!-- Status Filter -->
            <div class="col-lg-3 col-md-3 col-6">
                <label class="filter-label">Lead Status</label>
                <select name="status" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="Pending Review" {{ request('status') === 'Pending Review' ? 'selected' : '' }}>Pending Review</option>
                    <option value="In Progress" {{ request('status') === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Contacted" {{ request('status') === 'Contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="Verified" {{ request('status') === 'Verified' ? 'selected' : '' }}>Verified</option>
                    <option value="Closed" {{ request('status') === 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <!-- Preferred Package Filter -->
            <div class="col-lg-3 col-md-3 col-6">
                <label class="filter-label">Target Tier</label>
                <select name="package" class="form-select filter-select" onchange="this.form.submit()">
                    <option value="">All Tiers</option>
                    <option value="Elite Professional" {{ request('package') === 'Elite Professional' ? 'selected' : '' }}>Elite Professional</option>
                    <option value="Elite Business" {{ request('package') === 'Elite Business' ? 'selected' : '' }}>Elite Business</option>
                    <option value="Elite Aristocrat" {{ request('package') === 'Elite Aristocrat' ? 'selected' : '' }}>Elite Aristocrat</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="col-lg-2 col-md-12 d-flex gap-2">
                <button type="submit" class="btn btn-admin-primary flex-grow-1 py-2 fw-bold text-dark">
                    <i class="bi bi-funnel-fill me-1"></i> Filter
                </button>
                @if(request()->anyFilled(['search', 'status', 'package', 'looking_for']))
                    <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary py-2 px-3" title="Reset Filters">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Inquiries Table Card -->
    <div class="table-container shadow-lg">
        <!-- Table Card Header -->
        <div class="p-3 px-4 border-bottom border-secondary border-opacity-25 d-flex flex-wrap justify-content-between align-items-center gap-3" style="background: rgba(0, 0, 0, 0.25);">
            <div class="d-flex align-items-center gap-2">
                <h5 class="text-white fw-bold mb-0">
                    <i class="bi bi-person-lines-fill text-gold me-1"></i> VIP Consultation Pipeline
                </h5>
                <span class="badge rounded-pill bg-dark border border-warning-subtle text-gold px-2.5 py-1">
                    {{ $inquiries->total() }} Leads
                </span>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('contact') }}" target="_blank" class="btn btn-outline-warning btn-sm px-3 py-1.5 text-gold fw-semibold">
                    <i class="bi bi-globe2 me-1"></i> Public Contact Form
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-inquiries align-middle">
                <thead>
                    <tr>
                        <th>Client / Guardian</th>
                        <th>Phone &amp; Direct Contact</th>
                        <th>Seeking Match For</th>
                        <th>Location &amp; Desher Bari</th>
                        <th>Target Tier</th>
                        <th class="text-center" style="width: 150px;">Status</th>
                        <th style="width: 130px;">Received</th>
                        <th class="text-end" style="width: 110px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inquiries as $inq)
                        <tr>
                            <!-- Client Name & Relation -->
                            <td>
                                <div class="fw-bold text-white fs-6 mb-0.5">{{ $inq->full_name }}</div>
                                <div class="small">
                                    <span class="badge rounded-pill bg-dark border border-secondary text-silver" style="font-size: 0.72rem;">
                                        For: {{ $inq->profile_for }}
                                    </span>
                                </div>
                            </td>

                            <!-- Phone & WhatsApp -->
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <a href="tel:{{ $inq->phone }}" class="btn-contact-chip phone" title="Call Client">
                                        <i class="bi bi-telephone-fill"></i> {{ $inq->phone }}
                                    </a>
                                    @if($inq->clean_phone)
                                        <a href="https://wa.me/{{ $inq->clean_phone }}" target="_blank" class="btn-contact-chip whatsapp" title="Chat on WhatsApp">
                                            <i class="bi bi-whatsapp"></i> Chat WhatsApp
                                        </a>
                                    @endif
                                </div>
                            </td>

                            <!-- Seeking Match For -->
                            <td>
                                <div class="text-white fw-semibold mb-0.5">
                                    <i class="bi bi-person-heart text-gold me-1"></i>{{ $inq->looking_for }}
                                </div>
                                @if($inq->message)
                                    <div class="small text-muted text-truncate" style="max-width: 220px;" title="{{ $inq->message }}">
                                        {{ $inq->message }}
                                    </div>
                                @endif
                            </td>

                            <!-- Location & Ancestral Home -->
                            <td>
                                <div class="text-white small fw-medium">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $inq->city ?: 'Pan-Bangladesh' }}
                                </div>
                                <div class="small text-silver">
                                    Home: {{ $inq->desher_bari ?: 'Not Specified' }}
                                </div>
                            </td>

                            <!-- Target Package Tier -->
                            <td>
                                <span class="badge-gold text-nowrap">
                                    <i class="bi bi-gem me-1 text-gold"></i>{{ $inq->preferred_package ?: 'Standard' }}
                                </span>
                            </td>

                            <!-- Status Dropdown Quick-Update -->
                            <td class="text-center">
                                @php
                                    $statusClass = match($inq->status) {
                                        'Pending Review' => 'status-pending',
                                        'In Progress' => 'status-progress',
                                        'Contacted' => 'status-contacted',
                                        'Verified' => 'status-verified',
                                        default => 'status-closed',
                                    };
                                @endphp
                                <form action="{{ route('admin.inquiries.update-status', $inq) }}" method="POST" class="d-inline">
                                    @csrf
                                    <select 
                                        name="status" 
                                        class="form-select form-select-sm {{ $statusClass }} fw-bold" 
                                        style="font-size: 0.78rem; padding: 0.35rem 0.65rem; border-radius: 12px; cursor: pointer;"
                                        onchange="this.form.submit()"
                                        title="Change lead workflow status"
                                    >
                                        <option value="Pending Review" {{ $inq->status === 'Pending Review' ? 'selected' : '' }}>Pending Review</option>
                                        <option value="In Progress" {{ $inq->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="Contacted" {{ $inq->status === 'Contacted' ? 'selected' : '' }}>Contacted</option>
                                        <option value="Verified" {{ $inq->status === 'Verified' ? 'selected' : '' }}>Verified</option>
                                        <option value="Closed" {{ $inq->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </form>
                            </td>

                            <!-- Date Received -->
                            <td>
                                <div class="small text-silver">
                                    {{ $inq->created_at ? $inq->created_at->format('M d, Y') : 'N/A' }}
                                </div>
                                <div class="small text-muted" style="font-size: 0.72rem;">
                                    {{ $inq->created_at ? $inq->created_at->diffForHumans() : '' }}
                                </div>
                            </td>

                            <!-- Action Buttons -->
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <!-- View/Edit Details Modal Button (36px Gold) -->
                                    <button 
                                        type="button" 
                                        class="btn-action-icon view" 
                                        title="View Full Lead &amp; Matchmaker Notes"
                                        onclick="openInquiryModal({{ json_encode($inq) }})"
                                    >
                                        <i class="bi bi-eye-fill"></i>
                                    </button>

                                    <!-- Delete Button (36px Red) -->
                                    <button 
                                        type="button" 
                                        class="btn-action-icon delete" 
                                        title="Delete Lead"
                                        onclick="confirmDeleteInquiry('{{ $inq->id }}', '{{ $inq->inquiry_code }}', '{{ addslashes($inq->full_name) }}')"
                                    >
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox fs-1 text-gold opacity-50 d-block mb-3"></i>
                                    <h5 class="text-white fw-bold mb-2">No Consultation Requests Found</h5>
                                    <p class="text-muted mb-4">
                                        @if(request()->anyFilled(['search', 'status', 'package', 'looking_for']))
                                            No inquiries match your search filters. Try clearing your filters.
                                        @else
                                            New consultation requests submitted by clients will automatically appear here.
                                        @endif
                                    </p>
                                    @if(request()->anyFilled(['search', 'status', 'package', 'looking_for']))
                                        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary px-4 py-2">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inquiries->hasPages())
            <div class="p-3 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: rgba(0, 0, 0, 0.2);">
                <div class="text-muted small">
                    Showing {{ $inquiries->firstItem() }} to {{ $inquiries->lastItem() }} of {{ $inquiries->total() }} inquiries
                </div>
                <div>
                    {{ $inquiries->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal: View Inquiry Details & Add Matchmaker Notes -->
<div class="modal fade" id="inquiryDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-card">
            <div class="modal-header border-bottom border-secondary border-opacity-25 pb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge-code" id="modalInqCode">INQ-1001</span>
                    <h5 class="modal-title fw-bold text-white mb-0">VIP Consultation Lead Details</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="modalUpdateInquiryForm" method="POST" action="">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">
                    <!-- Client Profile Section -->
                    <div class="row g-3 mb-4 pb-3 border-bottom border-secondary border-opacity-25">
                        <div class="col-md-4">
                            <div class="modal-detail-label">Client / Guardian Name</div>
                            <div class="modal-detail-val text-gold" id="modalFullName"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="modal-detail-label">Phone &amp; WhatsApp</div>
                            <div class="modal-detail-val">
                                <span id="modalPhone" class="text-warning"></span>
                                <a id="modalWhatsAppLink" href="#" target="_blank" class="btn btn-sm btn-outline-success ms-2 py-0 px-2" style="font-size: 0.72rem;">
                                    <i class="bi bi-whatsapp"></i> Chat
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="modal-detail-label">Email Address</div>
                            <div class="modal-detail-val">
                                <a id="modalEmailLink" href="#" class="text-silver text-decoration-none small">
                                    <i class="bi bi-envelope me-1"></i><span id="modalEmail"></span>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="modal-detail-label">Seeking Alliance</div>
                            <div class="modal-detail-val text-white" id="modalSeeking"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="modal-detail-label">Location / Residence</div>
                            <div class="modal-detail-val" id="modalCity"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="modal-detail-label">Ancestral District (Desher Bari)</div>
                            <div class="modal-detail-val text-white" id="modalDesherBari"></div>
                        </div>

                        <div class="col-md-6">
                            <div class="modal-detail-label">Annual Income / Bracket</div>
                            <div class="modal-detail-val text-silver" id="modalIncome"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-detail-label">Preferred Tier / Package</div>
                            <div class="modal-detail-val text-gold" id="modalPackage"></div>
                        </div>

                        <!-- Specific Client Preferences -->
                        <div class="col-12" id="modalMessageContainer">
                            <div class="modal-detail-label">Client Requirement / Specific Notes</div>
                            <div class="p-2.5 rounded-3 bg-dark border border-secondary border-opacity-25 small text-silver" id="modalMessage"></div>
                        </div>
                    </div>

                    <!-- Workflow & Matchmaker Notes Section -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="modalStatusSelect" class="form-label text-gold fw-bold small">Update Workflow Status</label>
                            <select name="status" id="modalStatusSelect" class="form-select filter-select">
                                <option value="Pending Review">Pending Review</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Contacted">Contacted</option>
                                <option value="Verified">Verified</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="modalPackageSelect" class="form-label text-gold fw-bold small">Assigned Package Tier</label>
                            <select name="preferred_package" id="modalPackageSelect" class="form-select filter-select">
                                <option value="Elite Professional">Elite Professional</option>
                                <option value="Elite Business">Elite Business</option>
                                <option value="Elite Aristocrat">Elite Aristocrat</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="modalAdminNotes" class="form-label text-gold fw-bold small">Private Matchmaker / Relationship Manager Notes</label>
                            <textarea 
                                name="admin_notes" 
                                id="modalAdminNotes" 
                                rows="3" 
                                class="form-control filter-input" 
                                placeholder="e.g. Spoke with the father. Prefers meetings at Westin Dhaka. Family verified through local Sylhet council..."
                            ></textarea>
                            <div class="form-text text-silver small">These notes are confidential and visible only to administrators.</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top border-secondary border-opacity-25 pt-3">
                    <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-admin-primary px-4 fw-bold text-dark">
                        <i class="bi bi-check2-circle me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Delete Confirmation -->
<div class="modal fade" id="deleteInquiryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #141820; border: 1px solid rgba(239, 68, 68, 0.5); border-radius: 16px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2 text-danger">
                    <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    <h5 class="modal-title fw-bold text-white">Delete Consultation Lead</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-silver pt-3">
                Are you sure you want to delete inquiry <strong id="deleteInquiryCode" class="text-warning"></strong> for <strong id="deleteInquiryName" class="text-white"></strong>?
                <p class="small text-danger opacity-75 mt-2 mb-0">
                    <i class="bi bi-info-circle me-1"></i> This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteInquiryForm" method="POST" action="">
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
    function openInquiryModal(inquiry) {
        document.getElementById('modalInqCode').textContent = inquiry.inquiry_code;
        document.getElementById('modalFullName').textContent = inquiry.full_name;
        document.getElementById('modalPhone').textContent = inquiry.phone;
        document.getElementById('modalEmail').textContent = inquiry.email;
        document.getElementById('modalEmailLink').href = 'mailto:' + inquiry.email;

        // Clean phone for WhatsApp
        const cleanPhone = (inquiry.phone || '').replace(/[^0-9]/g, '');
        const waNumber = cleanPhone.startsWith('01') && cleanPhone.length === 11 ? '88' + cleanPhone : cleanPhone;
        document.getElementById('modalWhatsAppLink').href = 'https://wa.me/' + waNumber;

        document.getElementById('modalSeeking').textContent = (inquiry.looking_for || '') + ' (for ' + (inquiry.profile_for || '') + ')';
        document.getElementById('modalCity').textContent = inquiry.city || 'Not Specified';
        document.getElementById('modalDesherBari').textContent = inquiry.desher_bari || 'Not Specified';
        document.getElementById('modalIncome').textContent = inquiry.annual_income || 'Confidential / Disclosed in Person';
        document.getElementById('modalPackage').textContent = inquiry.preferred_package || 'Standard Inquiry';

        const msgContainer = document.getElementById('modalMessageContainer');
        const msgEl = document.getElementById('modalMessage');
        if (inquiry.message && inquiry.message.trim() !== '') {
            msgContainer.style.display = 'block';
            msgEl.textContent = inquiry.message;
        } else {
            msgContainer.style.display = 'none';
        }

        document.getElementById('modalStatusSelect').value = inquiry.status || 'Pending Review';
        document.getElementById('modalPackageSelect').value = inquiry.preferred_package || 'Elite Business';
        document.getElementById('modalAdminNotes').value = inquiry.admin_notes || '';

        const formEl = document.getElementById('modalUpdateInquiryForm');
        formEl.action = "{{ url('admin/inquiries') }}/" + inquiry.id;

        const modal = new bootstrap.Modal(document.getElementById('inquiryDetailModal'));
        modal.show();
    }

    function confirmDeleteInquiry(inquiryId, inquiryCode, inquiryName) {
        document.getElementById('deleteInquiryCode').textContent = '#' + inquiryCode;
        document.getElementById('deleteInquiryName').textContent = inquiryName;
        document.getElementById('deleteInquiryForm').action = "{{ url('admin/inquiries') }}/" + inquiryId;

        const modal = new bootstrap.Modal(document.getElementById('deleteInquiryModal'));
        modal.show();
    }
</script>
@endpush
