@extends('admin.layouts.app')

@section('title', 'Client Accounts & Verification - Biye Marriage Media Admin')
@section('header_title', 'Client Accounts Management')

@push('styles')
<style>
    /* Clients Layout Wrapper */
    .clients-wrapper {
        width: 100%;
    }

    /* Stat Cards Ribbon */
    .stat-pill {
        background: #141820;
        background: linear-gradient(180deg, #171c26 0%, #131720 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 1.1rem 1.25rem;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-pill:hover {
        border-color: rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.45);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
    }
    .stat-pill .num {
        font-size: 1.65rem;
        font-weight: 700;
        color: #f8fafc;
        line-height: 1.2;
    }
    .stat-pill .label {
        font-size: 0.74rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    .stat-icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }
    .stat-icon-total {
        background: rgba(56, 189, 248, 0.15);
        color: #38bdf8;
        border: 1px solid rgba(56, 189, 248, 0.3);
    }
    .stat-icon-pending {
        background: rgba(251, 191, 36, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(251, 191, 36, 0.3);
    }
    .stat-icon-active {
        background: rgba(74, 222, 128, 0.15);
        color: #4ade80;
        border: 1px solid rgba(74, 222, 128, 0.3);
    }
    .stat-icon-suspended {
        background: rgba(248, 113, 113, 0.15);
        color: #f87171;
        border: 1px solid rgba(248, 113, 113, 0.3);
    }

    /* Filter & Search Panel */
    .filter-card {
        background: #141820;
        background: linear-gradient(180deg, #171c26 0%, #131720 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 1.15rem 1.35rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35);
    }
    .filter-input-group-text {
        background: #0d1117 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-right: none !important;
        color: #94a3b8 !important;
        border-top-left-radius: 9px !important;
        border-bottom-left-radius: 9px !important;
    }
    .filter-input {
        background: #0d1117 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #f8fafc !important;
        font-size: 0.88rem;
        border-radius: 9px;
        padding: 0.55rem 0.85rem;
    }
    .filter-input.with-addon {
        border-left: none !important;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }
    .filter-select {
        background-color: #0d1117 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #f8fafc !important;
        font-size: 0.88rem;
        border-radius: 9px;
        padding: 0.55rem 2.2rem 0.55rem 0.85rem !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23d4af37' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right 0.75rem center !important;
        background-size: 13px 10px !important;
    }
    .filter-select option {
        background: #0d1117 !important;
        color: #f8fafc !important;
    }
    .filter-input:focus, .filter-select:focus {
        border-color: var(--theme-secondary, #d4af37) !important;
        box-shadow: 0 0 0 0.2rem rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.25) !important;
    }
    .filter-input::placeholder {
        color: #64748b !important;
    }
    .btn-admin-filter {
        background: linear-gradient(135deg, var(--theme-primary, #851829) 0%, #a31c33 100%);
        color: #ffffff !important;
        border: 1px solid rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.35);
        border-radius: 9px;
        font-weight: 600;
        font-size: 0.88rem;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(133, 24, 41, 0.35);
    }
    .btn-admin-filter:hover {
        background: linear-gradient(135deg, #a31c33 0%, var(--theme-primary, #851829) 100%);
        box-shadow: 0 4px 14px rgba(133, 24, 41, 0.55);
        transform: translateY(-1px);
    }
    .btn-admin-reset {
        background: #0d1117;
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #cbd5e1 !important;
        border-radius: 9px;
        height: 38px;
        width: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .btn-admin-reset:hover {
        background: #171c26;
        color: #ffffff !important;
        border-color: rgba(255, 255, 255, 0.25);
    }

    /* Table Container */
    .table-container {
        background: #141820;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    }
    .table-header-bar {
        background: #161b26;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 1.1rem 1.4rem;
    }
    .table-clients {
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }
    .table-clients thead th {
        background: #111622 !important;
        color: #f8fafc !important;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 1rem 0.95rem;
        border-bottom: 2px solid rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.35) !important;
        vertical-align: middle;
        white-space: nowrap !important;
    }
    .table-clients tbody td {
        padding: 1rem 0.95rem;
        vertical-align: middle;
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        color: #e2e8f0;
        font-size: 0.88rem;
    }
    .table-clients tbody tr:hover td {
        background: rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.05) !important;
    }
    .table-clients tbody tr:last-child td {
        border-bottom: none !important;
    }

    /* Badges & Pills */
    .client-avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.74rem;
        font-weight: 700;
        letter-spacing: 0.3px;
        background: #0d1117;
        color: var(--theme-secondary, #d4af37);
        border: 1.5px solid rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.45);
        flex-shrink: 0;
        overflow: hidden;
    }
    .client-relation-text {
        font-size: 0.76rem;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        background: transparent !important;
        border: none !important;
        padding: 0 !important;
        line-height: 1.3;
    }
    .badge-relation {
        background: transparent !important;
        color: #94a3b8 !important;
        border: none !important;
        font-size: 0.76rem;
        font-weight: 500;
        padding: 0 !important;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    .badge-bride {
        background: rgba(244, 63, 94, 0.18);
        color: #fecdd3;
        border: 1px solid rgba(244, 63, 94, 0.4);
        font-size: 0.74rem;
        font-weight: 600;
        padding: 0.25rem 0.55rem;
        border-radius: 6px;
    }
    .badge-groom {
        background: rgba(14, 165, 233, 0.18);
        color: #bae6fd;
        border: 1px solid rgba(14, 165, 233, 0.4);
        font-size: 0.74rem;
        font-weight: 600;
        padding: 0.25rem 0.55rem;
        border-radius: 6px;
    }
    .badge-verified-pill {
        background: rgba(34, 197, 94, 0.16);
        color: #86efac;
        border: 1px solid rgba(34, 197, 94, 0.45);
        font-size: 0.76rem;
        font-weight: 600;
        padding: 0.35rem 0.65rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .badge-rejected-pill {
        background: rgba(244, 63, 94, 0.16);
        color: #fca5a5;
        border: 1px solid rgba(244, 63, 94, 0.45);
        font-size: 0.76rem;
        font-weight: 600;
        padding: 0.35rem 0.65rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .badge-pending-pill {
        background: rgba(245, 158, 11, 0.16);
        color: #fde68a;
        border: 1px solid rgba(245, 158, 11, 0.45);
        font-size: 0.76rem;
        font-weight: 600;
        padding: 0.35rem 0.65rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .badge-status-active {
        background: #16a34a;
        color: #ffffff;
        box-shadow: 0 0 10px rgba(22, 163, 74, 0.4);
        font-size: 0.76rem;
        font-weight: 700;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }
    .badge-status-suspended {
        background: #dc2626;
        color: #ffffff;
        box-shadow: 0 0 10px rgba(220, 38, 38, 0.4);
        font-size: 0.76rem;
        font-weight: 700;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* Manage Button & Menu */
    .btn-manage-admin {
        background: #0d1117;
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: #f8fafc;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.38rem 0.8rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }
    .btn-manage-admin:hover, .btn-manage-admin:focus {
        background: #171c26;
        border-color: rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.6);
        color: #ffffff;
        box-shadow: 0 0 12px rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.2);
    }
    .dropdown-menu-admin {
        background: #121722 !important;
        border: 1px solid rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.35) !important;
        border-radius: 12px !important;
        padding: 0.45rem !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.65) !important;
        min-width: 220px;
        z-index: 1060 !important;
    }
    .dropdown-menu-admin .dropdown-item {
        color: #cbd5e1 !important;
        font-size: 0.84rem !important;
        font-weight: 500 !important;
        border-radius: 7px !important;
        padding: 0.45rem 0.85rem !important;
        transition: all 0.15s ease !important;
        display: flex;
        align-items: center;
    }
    .dropdown-menu-admin .dropdown-item:hover {
        background: rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.15) !important;
        color: #ffffff !important;
    }
    .dropdown-menu-admin .dropdown-divider {
        border-color: rgba(255, 255, 255, 0.08) !important;
        margin: 0.35rem 0;
    }

    /* Modal Styling */
    .modal-admin-dialog .modal-content {
        background: #141820 !important;
        border: 1px solid rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.35) !important;
        border-radius: 16px !important;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6) !important;
        overflow: hidden;
    }
    .modal-admin-dialog .modal-header {
        background: #171c26 !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 1.1rem 1.4rem;
    }
    .modal-admin-dialog .modal-title {
        color: #f8fafc !important;
        font-size: 1.05rem;
    }
    .modal-admin-dialog .modal-body {
        background: #141820 !important;
        color: #f8fafc !important;
        padding: 1.25rem 1.4rem;
    }
    .modal-admin-dialog .modal-footer {
        background: #171c26 !important;
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 0.9rem 1.4rem;
    }
    .modal-admin-dialog .form-label {
        color: var(--theme-secondary, #d4af37) !important;
        font-size: 0.78rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        margin-bottom: 0.35rem !important;
    }
    .modal-admin-dialog .form-control,
    .modal-admin-dialog .form-select {
        background: #0d1117 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #f8fafc !important;
        font-size: 0.88rem !important;
        border-radius: 8px !important;
    }
    .modal-admin-dialog .form-control:focus,
    .modal-admin-dialog .form-select:focus {
        border-color: var(--theme-secondary, #d4af37) !important;
        box-shadow: 0 0 0 0.2rem rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.25) !important;
    }
    .modal-admin-dialog .btn-cancel {
        background: #0d1117 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #cbd5e1 !important;
        border-radius: 8px !important;
        font-size: 0.88rem;
    }
    .modal-admin-dialog .btn-cancel:hover {
        background: #171c26 !important;
        color: #ffffff !important;
    }

    /* Alert Styling */
    .alert-admin-success {
        background: rgba(34, 197, 94, 0.15) !important;
        border: 1px solid rgba(34, 197, 94, 0.4) !important;
        color: #86efac !important;
        border-radius: 12px;
    }
    .alert-admin-danger {
        background: rgba(239, 68, 68, 0.15) !important;
        border: 1px solid rgba(239, 68, 68, 0.4) !important;
        color: #fca5a5 !important;
        border-radius: 12px;
    }

    /* Typography helpers */
    .text-gold {
        color: var(--theme-secondary, #d4af37) !important;
    }
    .text-silver {
        color: #cbd5e1 !important;
    }

    /* Pagination */
    .table-container .card-footer {
        background: #161b26 !important;
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
    }
    .table-container .pagination .page-link {
        background: #0d1117 !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        color: #cbd5e1 !important;
    }
    .table-container .pagination .page-item.active .page-link {
        background: var(--theme-primary, #851829) !important;
        border-color: rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.4) !important;
        color: #ffffff !important;
    }
    .table-container .pagination .page-item.disabled .page-link {
        background: #090d13 !important;
        color: #64748b !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-2 clients-wrapper">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="alert alert-admin-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-admin-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Ribbon -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-pill">
                <div class="stat-icon-circle stat-icon-total">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="label">Total Clients</div>
                    <div class="num">{{ number_format($totalClients) }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-pill">
                <div class="stat-icon-circle stat-icon-pending">
                    <i class="bi bi-shield-exclamation"></i>
                </div>
                <div>
                    <div class="label">Pending Audit</div>
                    <div class="num">{{ number_format($pendingVerificationCount) }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-pill">
                <div class="stat-icon-circle stat-icon-active">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div>
                    <div class="label">Active Clients</div>
                    <div class="num">{{ number_format($activeClientsCount) }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-pill">
                <div class="stat-icon-circle stat-icon-suspended">
                    <i class="bi bi-person-x-fill"></i>
                </div>
                <div>
                    <div class="label">Suspended</div>
                    <div class="num">{{ number_format($suspendedClientsCount) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Panel -->
    <div class="filter-card mb-4">
        <form action="{{ route('admin.clients.index') }}" method="GET" class="row g-2 align-items-center">
            <!-- Search Keyword -->
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-text filter-input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control filter-input with-addon" placeholder="Search by name, email, phone...">
                </div>
            </div>

            <!-- Verification Status -->
            <div class="col-6 col-md-2">
                <select name="verification_status" class="form-select filter-select">
                    <option value="">All Verifications</option>
                    <option value="pending" {{ request('verification_status') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                    <option value="verified" {{ request('verification_status') === 'verified' ? 'selected' : '' }}>Verified (Blue Seal)</option>
                    <option value="rejected" {{ request('verification_status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <!-- Account Status -->
            <div class="col-6 col-md-2">
                <select name="status" class="form-select filter-select">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>

            <!-- Gender Filter -->
            <div class="col-6 col-md-2">
                <select name="gender" class="form-select filter-select">
                    <option value="">All Genders</option>
                    <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Bride (Patri)</option>
                    <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Groom (Patro)</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-6 col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-admin-filter w-100">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                @if(request()->hasAny(['q', 'verification_status', 'status', 'gender', 'assigned_staff_id']))
                    <a href="{{ route('admin.clients.index') }}" class="btn-admin-reset" title="Reset Filters">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Clients Table Card -->
    <div class="table-container">
        <div class="table-header-bar d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0 fw-bold text-white font-serif">
                <i class="bi bi-person-lines-fill text-gold me-2"></i>Registered Matrimony Clients ({{ $clients->total() }})
            </h5>
            <div class="small text-muted">
                Showing {{ $clients->firstItem() ?? 0 }} to {{ $clients->lastItem() ?? 0 }} of {{ $clients->total() }} clients
            </div>
        </div>
        <div class="table-responsive">
            <table class="table-clients">
                <thead>
                    <tr>
                        <th style="min-width: 250px;">Client &amp; Candidate</th>
                        <th style="min-width: 200px;">Guardian / Contact</th>
                        <th style="min-width: 190px;">Profile Snapshot</th>
                        <th style="min-width: 170px; white-space: nowrap !important;">Assigned RM</th>
                        <th style="min-width: 180px; white-space: nowrap !important;">Package &amp; Quota</th>
                        <th style="min-width: 140px; white-space: nowrap !important;">Verification</th>
                        <th style="min-width: 110px; white-space: nowrap !important;">Status</th>
                        <th class="text-end pe-4" style="min-width: 110px; white-space: nowrap !important;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        @php
                            $profile = $client->candidateProfile;
                            $subscription = $client->activeSubscription;
                        @endphp
                        <tr>
                            {{-- Client & Candidate --}}
                            <td>
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="client-avatar-circle">
                                        @if($profile && $profile->image)
                                            <img src="{{ $profile->resolved_image }}" alt="{{ $client->name }}" class="w-100 h-100 object-fit-cover">
                                        @else
                                            {{ $client->initials }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-white d-flex align-items-center gap-1.5 fs-6">
                                            <span>{{ $client->name }}</span>
                                            @if($client->isVerified())
                                                <i class="bi bi-patch-check-fill text-primary" title="Verified Blue Seal"></i>
                                            @endif
                                        </div>
                                        <div class="client-relation-text mt-0.5">
                                            <i class="bi bi-people me-1 text-gold"></i>For {{ ucfirst($client->profile_for ?? 'Self') }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Guardian / Contact -->
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <div class="small fw-semibold text-white">
                                        <i class="bi bi-telephone me-1 text-gold"></i>{{ $client->phone }}
                                    </div>
                                    <div class="small text-silver text-truncate" style="max-width: 190px;" title="{{ $client->email }}">
                                        <i class="bi bi-envelope me-1 text-muted"></i>{{ $client->email }}
                                    </div>
                                    @if($client->guardian_name)
                                        <div class="small text-muted" style="font-size: 0.75rem;">
                                            <i class="bi bi-person-badge me-1 text-gold"></i>Guardian: <span class="text-silver">{{ $client->guardian_name }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Snapshot -->
                            <td>
                                @if($profile)
                                    <div class="d-flex flex-column gap-1">
                                        <div>
                                            <span class="{{ $profile->gender === 'female' ? 'badge-bride' : 'badge-groom' }}">
                                                {{ ucfirst($profile->gender) }}, {{ $profile->age }} yrs, {{ $profile->height }}
                                            </span>
                                        </div>
                                        <div class="small text-silver text-truncate" style="max-width: 180px;" title="{{ $profile->profession }}">
                                            <i class="bi bi-briefcase me-1 text-muted"></i>{{ $profile->profession }}
                                        </div>
                                        <div class="small text-muted" style="font-size: 0.75rem;">
                                            <i class="bi bi-geo-alt me-0.5 text-gold"></i>{{ $profile->desher_bari }}
                                        </div>
                                    </div>
                                @else
                                    <span class="badge" style="background: rgba(255, 255, 255, 0.06); color: #94a3b8; border: 1px solid rgba(255, 255, 255, 0.1); font-size: 0.75rem;">
                                        Biodata Not Created
                                    </span>
                                @endif
                            </td>

                            <!-- Assigned RM (Stacked neatly vertically, each item on separate line) -->
                            <td>
                                @if($client->assignedStaff)
                                    <div class="d-flex flex-column gap-1">
                                        <div class="fw-bold text-white small text-nowrap">
                                            <i class="bi bi-headset me-1 text-gold"></i>{{ $client->assignedStaff->name }}
                                        </div>
                                        <div class="text-silver text-nowrap" style="font-size: 0.75rem;">
                                            <i class="bi bi-shield-check me-1 text-muted"></i>{{ $client->assignedStaff->role_label }}
                                        </div>
                                    </div>
                                @else
                                    <span class="badge" style="background: rgba(245, 158, 11, 0.15); color: #fde68a; border: 1px solid rgba(245, 158, 11, 0.35); font-size: 0.75rem;">
                                        <i class="bi bi-exclamation-circle me-1"></i>Unassigned
                                    </span>
                                @endif
                            </td>

                            <!-- Package & Quota (Stacked neatly vertically, each item on separate line) -->
                            <td>
                                @if($subscription)
                                    <div class="d-flex flex-column gap-1">
                                        <div class="fw-bold text-gold small text-nowrap">
                                            <i class="bi bi-gem me-1"></i>{{ $subscription->package_name }}
                                        </div>
                                        <div class="text-silver text-nowrap" style="font-size: 0.76rem;">
                                            <i class="bi bi-send-check me-1 text-muted"></i>Proposals: <strong class="text-white">{{ $subscription->proposals_used }}/{{ $subscription->proposals_quota }}</strong>
                                        </div>
                                        @if($subscription->expires_at)
                                            <div class="text-muted text-nowrap" style="font-size: 0.72rem;">
                                                <i class="bi bi-clock-history me-1"></i>Exp: {{ $subscription->expires_at->format('d M Y') }}
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="badge" style="background: rgba(255, 255, 255, 0.06); color: #94a3b8; border: 1px solid rgba(255, 255, 255, 0.1); font-size: 0.75rem;">
                                        <i class="bi bi-dash-circle me-1"></i>No Package
                                    </span>
                                @endif
                            </td>

                            <!-- Verification Status -->
                            <td>
                                @if($client->verification_status === 'verified')
                                    <span class="badge-verified-pill">
                                        <i class="bi bi-patch-check-fill"></i> Verified
                                    </span>
                                @elseif($client->verification_status === 'rejected')
                                    <span class="badge-rejected-pill">
                                        <i class="bi bi-x-circle"></i> Rejected
                                    </span>
                                @else
                                    <span class="badge-pending-pill">
                                        <i class="bi bi-clock-history"></i> Pending Audit
                                    </span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td>
                                @if($client->status === 'active')
                                    <span class="badge-status-active">
                                        <i class="bi bi-check-circle"></i> Active
                                    </span>
                                @else
                                    <span class="badge-status-suspended" title="{{ $client->suspension_reason }}">
                                        <i class="bi bi-slash-circle"></i> Suspended
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-4">
                                <div class="dropdown">
                                    <button class="btn btn-manage-admin dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-sliders me-1 text-gold"></i>Manage
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-admin shadow-lg">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.clients.show', $client) }}">
                                                <i class="bi bi-eye text-info me-2"></i> View Full Biodata &amp; History
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#verifyModal{{ $client->id }}">
                                                <i class="bi bi-patch-check text-success me-2"></i> Verify / Audit Profile
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staffModal{{ $client->id }}">
                                                <i class="bi bi-person-badge text-info me-2"></i> Assign Matchmaker
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#packageModal{{ $client->id }}">
                                                <i class="bi bi-gem text-gold me-2"></i> Upgrade Package &amp; Quota
                                            </button>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.clients.status', $client) }}" method="POST" onsubmit="return confirm('Change status for this client?');">
                                                @csrf
                                                <input type="hidden" name="status" value="{{ $client->status === 'active' ? 'suspended' : 'active' }}">
                                                <input type="hidden" name="suspension_reason" value="Toggled by administrator">
                                                <button type="submit" class="dropdown-item {{ $client->status === 'active' ? 'text-danger' : 'text-success' }}">
                                                    <i class="bi {{ $client->status === 'active' ? 'bi-lock' : 'bi-unlock' }} me-2"></i>
                                                    {{ $client->status === 'active' ? 'Suspend Account' : 'Activate Account' }}
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.clients.impersonate', $client) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-secondary">
                                                    <i class="bi bi-box-arrow-in-right me-2"></i> Login As Client
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Verification Modal -->
                                <div class="modal fade modal-admin-dialog" id="verifyModal{{ $client->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content text-start">
                                            <form action="{{ route('admin.clients.verify', $client) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title font-serif fw-bold">
                                                        <i class="bi bi-patch-check-fill text-primary me-2"></i>Verify Client Biodata
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="small text-silver mb-3">
                                                        Client: <strong class="text-white">{{ $client->name }}</strong> ({{ $client->phone }})
                                                    </p>
                                                    <div class="mb-3">
                                                        <label class="form-label">Verification Seal Decision</label>
                                                        <select name="verification_status" class="form-select filter-select" required>
                                                            <option value="verified" {{ $client->verification_status === 'verified' ? 'selected' : '' }}>Verified (Grant Blue Seal Badge)</option>
                                                            <option value="pending" {{ $client->verification_status === 'pending' ? 'selected' : '' }}>Pending Audit / Incomplete</option>
                                                            <option value="rejected" {{ $client->verification_status === 'rejected' ? 'selected' : '' }}>Reject / Suspicious Credentials</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Candidate Profile Public Approval</label>
                                                        <select name="approval_status" class="form-select filter-select">
                                                            <option value="approved" {{ $profile?->approval_status === 'approved' ? 'selected' : '' }}>Approved for Public Matching</option>
                                                            <option value="under_review" {{ $profile?->approval_status === 'under_review' ? 'selected' : '' }}>Under Review / Private</option>
                                                            <option value="rejected" {{ $profile?->approval_status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Admin Verification Notes</label>
                                                        <textarea name="admin_notes" class="form-control filter-input" rows="3" placeholder="e.g. NID verified via WhatsApp call. Educational certificates cross-checked.">{{ $profile?->admin_notes }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-admin-filter">Save Verification</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Assign Staff Modal -->
                                <div class="modal fade modal-admin-dialog" id="staffModal{{ $client->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content text-start">
                                            <form action="{{ route('admin.clients.assign-staff', $client) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title font-serif fw-bold">
                                                        <i class="bi bi-person-badge text-info me-2"></i>Assign Relationship Manager
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Select Matchmaker Staff</label>
                                                        <select name="assigned_staff_id" class="form-select filter-select">
                                                            <option value="">-- No Matchmaker Assigned --</option>
                                                            @foreach($staffMembers as $staff)
                                                                <option value="{{ $staff->id }}" {{ $client->assigned_staff_id == $staff->id ? 'selected' : '' }}>
                                                                    {{ $staff->name }} ({{ $staff->role_label }}) - {{ $staff->phone }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <p class="small text-muted mb-0">
                                                        The assigned matchmaker will be displayed in the client's member dashboard with their direct phone and WhatsApp contact card.
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-admin-filter">Assign Staff</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Package & Quota Upgrade Modal -->
                                <div class="modal fade modal-admin-dialog" id="packageModal{{ $client->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content text-start">
                                            <form action="{{ route('admin.clients.subscription', $client) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title font-serif fw-bold">
                                                        <i class="bi bi-gem text-gold me-2"></i>Allocate Membership Package
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Select Predefined Package (Optional)</label>
                                                        <select name="package_id" class="form-select filter-select" id="pkgSelect{{ $client->id }}" onchange="handlePackageSelect(this, '{{ $client->id }}')">
                                                            <option value="">Custom Package</option>
                                                            @foreach($packages as $pkg)
                                                                @php
                                                                    $cleaned = preg_replace('/[^0-9]/', '', (string) $pkg->price);
                                                                    $numericPrice = is_numeric($cleaned) && $cleaned !== '' ? (int) $cleaned : 0;
                                                                @endphp
                                                                <option value="{{ $pkg->id }}" data-name="{{ $pkg->name }}" data-price="{{ $numericPrice }}" data-proposals="25">
                                                                    {{ $pkg->name }} ({{ $pkg->price }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Package Name</label>
                                                        <input type="text" name="package_name" id="pkgName{{ $client->id }}" class="form-control filter-input" value="{{ $subscription?->package_name ?? 'Elite Business Alliance' }}" required>
                                                    </div>
                                                    <div class="row g-2 mb-3">
                                                        <div class="col-6">
                                                            <label class="form-label">Proposals Quota</label>
                                                            <input type="number" name="proposals_quota" id="pkgQuota{{ $client->id }}" class="form-control filter-input" value="{{ $subscription?->proposals_quota ?? 25 }}" min="1" required>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label">Validity (Months)</label>
                                                            <input type="number" name="validity_months" class="form-control filter-input" value="6" min="1" max="36" required>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2 mb-3">
                                                        <div class="col-6">
                                                            <label class="form-label">Amount Paid (BDT)</label>
                                                            <input type="number" name="price_paid" id="pkgPrice{{ $client->id }}" class="form-control filter-input" value="{{ $subscription?->price_paid ?? 0 }}" min="0" required>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label">Payment Channel</label>
                                                            <select name="payment_method" class="form-select filter-select">
                                                                <option value="bkash">bKash Merchant</option>
                                                                <option value="nagad">Nagad</option>
                                                                <option value="bank">Bank Deposit</option>
                                                                <option value="cash">Cash / Office Visit</option>
                                                                <option value="complimentary">Complimentary / VIP</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Transaction ID / Reference</label>
                                                        <input type="text" name="transaction_id" class="form-control filter-input" placeholder="e.g. TR-BKASH-898231">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-admin-filter">Activate Plan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 text-gold opacity-50 mb-2 d-block"></i>
                                <div>No client accounts found matching the criteria.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clients->hasPages())
            <div class="card-footer py-3">
                {{ $clients->links() }}
            </div>
        @endif
    </div>

</div>

@push('scripts')
<script>
    function handlePackageSelect(selectEl, clientId) {
        const option = selectEl.options[selectEl.selectedIndex];
        if (option && option.dataset.name) {
            document.getElementById('pkgName' + clientId).value = option.dataset.name;
            document.getElementById('pkgPrice' + clientId).value = option.dataset.price || 0;
            document.getElementById('pkgQuota' + clientId).value = option.dataset.proposals || 20;
        }
    }
</script>
@endpush
@endsection
