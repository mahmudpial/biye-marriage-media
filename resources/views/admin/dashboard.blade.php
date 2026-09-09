@extends('admin.layouts.app')

@section('title', 'Dashboard Overview')
@section('page-title', 'Matrimonial Admin Dashboard')

@push('styles')
<style>
    .banner-card {
        background: linear-gradient(135deg, #380818 0%, #1c050e 100%);
        border: 1px solid rgba(212, 175, 55, 0.35);
        border-radius: 20px;
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.55);
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .banner-glow {
        position: absolute;
        top: -60px;
        right: -60px;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(212, 175, 55, 0.18) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .banner-desc {
        color: #f0e2e7 !important;
        font-size: 0.96rem;
        line-height: 1.65;
        font-weight: 400;
        max-width: 650px;
    }

    /* Metric Stat Cards */
    .metric-card {
        background: #1c050e;
        border: 1px solid rgba(255, 255, 255, 0.09);
        border-radius: 18px;
        padding: 1.4rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        transition: all 0.25s ease;
        height: 100%;
    }

    .metric-card:hover {
        border-color: rgba(212, 175, 55, 0.35);
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.55);
    }

    .metric-label {
        font-size: 0.76rem;
        font-weight: 600;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        color: #d1c3c9;
        margin-bottom: 0.4rem;
    }

    .metric-value {
        font-size: 2.3rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.1;
        margin-bottom: 0.4rem;
        letter-spacing: -0.5px;
    }

    .metric-subtext {
        font-size: 0.8rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .metric-icon-box {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    /* Table Enhancements (Strict Single Line) */
    .table-responsive-custom {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: rgba(212, 175, 55, 0.3) rgba(0, 0, 0, 0.2);
    }

    .table-responsive-custom::-webkit-scrollbar {
        height: 6px;
    }

    .table-responsive-custom::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 4px;
    }

    .table-responsive-custom::-webkit-scrollbar-thumb {
        background: rgba(212, 175, 55, 0.35);
        border-radius: 4px;
    }

    .table-responsive-custom::-webkit-scrollbar-thumb:hover {
        background: var(--accent-gold);
    }

    .admin-table {
        margin-bottom: 0;
        width: 100%;
        white-space: nowrap !important;
    }

    .admin-table thead th {
        background: rgba(0, 0, 0, 0.35);
        color: #fce7a1;
        font-size: 0.8rem;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        padding: 0.95rem 1.15rem;
        border-bottom: 2px solid rgba(212, 175, 55, 0.25);
        white-space: nowrap !important;
    }

    .admin-table tbody td {
        padding: 0.95rem 1.15rem;
        vertical-align: middle;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        background: transparent;
        color: #f1e7ec;
        white-space: nowrap !important;
    }

    .admin-table tbody tr:hover td {
        background: rgba(255, 255, 255, 0.03);
    }

    /* Quick Action Button Styles */
    .action-btn-link {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: #ffffff !important;
        padding: 0.85rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .action-btn-link:hover {
        background: rgba(212, 175, 55, 0.15);
        border-color: rgba(212, 175, 55, 0.4);
        color: #ffffff !important;
        transform: translateX(4px);
    }

    .action-btn-link i.icon-prefix {
        font-size: 1.15rem;
        color: var(--accent-gold);
    }

    /* System info list */
    .system-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.7rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        font-size: 0.86rem;
    }

    .system-info-label {
        color: #cbd5e1;
    }

    .system-info-val {
        color: #ffffff;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<!-- Welcome Top Banner -->
<div class="row mb-4">
    <div class="col-12">
        <div class="banner-card">
            <div class="banner-glow"></div>
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 position-relative" style="z-index: 2;">
                <div>
                    <span class="badge rounded-pill px-3 py-2 text-dark mb-2" style="background: linear-gradient(135deg, #fce07e 0%, #d4af37 100%); font-weight: 700; font-size: 0.78rem;">
                        <i class="bi bi-shield-check me-1"></i> Verified Super Admin
                    </span>
                    <h2 class="text-white mb-2 fw-bold font-playfair">Welcome back, {{ auth()->user()->name }}!</h2>
                    <p class="banner-desc mb-0">
                        Welcome to the Biye Marriage Media Confidential Administration Console. Manage client biodata, VIP consultation leads, and membership packages with complete privacy and control.
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('profiles') }}" target="_blank" class="btn btn-outline-light px-3 py-2 rounded-3 text-white fw-semibold" style="border-color: rgba(255, 255, 255, 0.25); font-size: 0.88rem;">
                        <i class="bi bi-eye me-1 text-gold"></i> View Live Profiles
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="btn px-3 py-2 rounded-3 text-dark fw-bold" style="background: linear-gradient(135deg, #fce07e 0%, #d4af37 100%); font-size: 0.88rem;">
                        <i class="bi bi-globe2 me-1"></i> Visit Public Portal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Metrics & Statistics Row -->
<div class="row g-3 mb-4">
    <!-- Stat 1: Verified Profiles -->
    <div class="col-xl-3 col-sm-6">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="metric-label">Total Profiles</div>
                    <div class="metric-value">{{ number_format($stats['verified_profiles'] ?? 1250) }}</div>
                    <div class="metric-subtext" style="color: #4ade80;">
                        <i class="bi bi-patch-check-fill"></i>
                        <span>100% Verified Biodata</span>
                    </div>
                </div>
                <div class="metric-icon-box" style="background: rgba(212, 175, 55, 0.16); color: #fce7a1;">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 2: Pending VIP Leads -->
    <div class="col-xl-3 col-sm-6">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="metric-label">New VIP Inquiries</div>
                    <div class="metric-value">{{ $stats['pending_leads'] ?? 14 }}</div>
                    <div class="metric-subtext" style="color: #fbbf24;">
                        <i class="bi bi-clock-history"></i>
                        <span>4 New Requests Today</span>
                    </div>
                </div>
                <div class="metric-icon-box" style="background: rgba(245, 158, 11, 0.16); color: #fbbf24;">
                    <i class="bi bi-envelope-paper-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 3: Monthly Matches -->
    <div class="col-xl-3 col-sm-6">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="metric-label">Monthly Matches</div>
                    <div class="metric-value">{{ $stats['monthly_matches'] ?? 88 }}</div>
                    <div class="metric-subtext" style="color: #34d399;">
                        <i class="bi bi-graph-up-arrow"></i>
                        <span>+12% vs Last Month</span>
                    </div>
                </div>
                <div class="metric-icon-box" style="background: rgba(52, 211, 153, 0.16); color: #34d399;">
                    <i class="bi bi-heart-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat 4: Registered Admins -->
    <div class="col-xl-3 col-sm-6">
        <div class="metric-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="metric-label">Registered Admins</div>
                    <div class="metric-value">{{ $stats['total_users'] ?? 1 }}</div>
                    <div class="metric-subtext" style="color: #38bdf8;">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>System Protected</span>
                    </div>
                </div>
                <div class="metric-icon-box" style="background: rgba(56, 189, 248, 0.16); color: #38bdf8;">
                    <i class="bi bi-person-check-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Inquiries Section (Full Width for Clean Single-Line Alignment) -->
<div class="row mb-4">
    <div class="col-12">
        <div class="admin-card">
            <div class="admin-card-header">
                <div>
                    <h5 class="text-white mb-1 fw-bold font-playfair">
                        <i class="bi bi-journal-text text-gold me-2"></i> Recent VIP Consultation Requests
                    </h5>
                    <div class="small" style="color: #d1c5ca;">Latest submissions from website consultation form (Single-line overview)</div>
                </div>
                <span class="badge px-3 py-2 fw-semibold" style="background: rgba(245, 158, 11, 0.2); color: #fde68a; border: 1px solid rgba(245, 158, 11, 0.4);">
                    4 New Inquiries
                </span>
            </div>

            <div class="table-responsive-custom">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>Inquiry ID</th>
                            <th>Client / Guardian</th>
                            <th>Phone Number</th>
                            <th>Seeking Match For</th>
                            <th>Location &amp; Ancestral Home</th>
                            <th>Package</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentInquiries as $inq)
                            <tr>
                                <!-- ID -->
                                <td>
                                    <span class="badge px-2 py-1 fw-bold text-nowrap" style="background: rgba(0, 0, 0, 0.5); color: #fce7a1; border: 1px solid rgba(212, 175, 55, 0.35); font-family: monospace; font-size: 0.82rem;">
                                        {{ $inq['id'] }}
                                    </span>
                                </td>

                                <!-- Applicant Name -->
                                <td>
                                    <span class="fw-bold text-white text-nowrap" style="font-size: 0.92rem;">{{ $inq['name'] }}</span>
                                </td>

                                <!-- Phone -->
                                <td>
                                    <span class="text-nowrap small fw-medium" style="color: #fcd34d;">
                                        <i class="bi bi-telephone text-warning me-1"></i>{{ $inq['phone'] }}
                                    </span>
                                </td>

                                <!-- Seeking / Match Requirement -->
                                <td>
                                    <span class="text-nowrap" style="color: #f1e6eb; font-size: 0.88rem;">
                                        <i class="bi bi-person-heart text-gold me-1"></i>{{ $inq['looking_for'] }}
                                    </span>
                                </td>

                                <!-- Location & Desher Bari -->
                                <td>
                                    <span class="text-nowrap text-white fw-medium" style="font-size: 0.86rem;">
                                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $inq['location'] }}
                                    </span>
                                    <span class="text-nowrap small ms-1" style="color: #cbd5e1;">(Home: {{ $inq['desher_bari'] }})</span>
                                </td>

                                <!-- Package -->
                                <td>
                                    <span class="badge fw-semibold text-nowrap" style="background: rgba(212, 175, 55, 0.16); color: #fde68a; border: 1px solid rgba(212, 175, 55, 0.35); font-size: 0.78rem;">
                                        {{ $inq['package'] }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td>
                                    @if ($inq['status'] === 'Pending Review')
                                        <span class="badge text-nowrap" style="background: rgba(245, 158, 11, 0.2); color: #fde68a; border: 1px solid rgba(245, 158, 11, 0.4); font-size: 0.78rem;">
                                            <i class="bi bi-hourglass-split me-1"></i> Pending Review
                                        </span>
                                    @elseif ($inq['status'] === 'In Progress')
                                        <span class="badge text-nowrap" style="background: rgba(14, 165, 233, 0.2); color: #7dd3fc; border: 1px solid rgba(14, 165, 233, 0.4); font-size: 0.78rem;">
                                            <i class="bi bi-arrow-repeat me-1"></i> In Progress
                                        </span>
                                    @elseif ($inq['status'] === 'Verified')
                                        <span class="badge text-nowrap" style="background: rgba(34, 197, 94, 0.2); color: #86efac; border: 1px solid rgba(34, 197, 94, 0.4); font-size: 0.78rem;">
                                            <i class="bi bi-check2-circle me-1"></i> Verified
                                        </span>
                                    @else
                                        <span class="badge text-nowrap" style="background: rgba(168, 85, 247, 0.2); color: #d8b4fe; border: 1px solid rgba(168, 85, 247, 0.4); font-size: 0.78rem;">
                                            <i class="bi bi-telephone-check me-1"></i> {{ $inq['status'] }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Row: Shortcuts & System Info (Side-by-Side) -->
<div class="row g-4">
    <!-- Quick Action Shortcuts -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <h5 class="text-white mb-3 fw-bold font-playfair">
                <i class="bi bi-lightning-charge-fill text-gold me-2"></i> Quick Actions
            </h5>
            <div class="d-grid gap-2">
                <a href="{{ route('profiles') }}" target="_blank" class="action-btn-link">
                    <span class="d-flex align-items-center gap-2">
                        <i class="bi bi-search icon-prefix"></i>
                        <span>Search &amp; Filter Biodata</span>
                    </span>
                    <i class="bi bi-chevron-right text-gold small"></i>
                </a>

                <a href="{{ route('admin.packages.index') }}" class="action-btn-link">
                    <span class="d-flex align-items-center gap-2">
                        <i class="bi bi-gem icon-prefix"></i>
                        <span>Manage Membership Packages</span>
                    </span>
                    <i class="bi bi-chevron-right text-gold small"></i>
                </a>

                <a href="{{ route('admin.stories.index') }}" class="action-btn-link">
                    <span class="d-flex align-items-center gap-2">
                        <i class="bi bi-heart-pulse-fill icon-prefix"></i>
                        <span>Manage Success Stories</span>
                    </span>
                    <i class="bi bi-chevron-right text-gold small"></i>
                </a>

                <a href="{{ route('contact') }}" target="_blank" class="action-btn-link">
                    <span class="d-flex align-items-center gap-2">
                        <i class="bi bi-headset icon-prefix"></i>
                        <span>Direct Client Support</span>
                    </span>
                    <i class="bi bi-chevron-right text-gold small"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- System & Security Info -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <h5 class="text-white mb-3 fw-bold font-playfair">
                <i class="bi bi-shield-check text-gold me-2"></i> System &amp; Security
            </h5>
            <div>
                <div class="system-info-row">
                    <span class="system-info-label">Application Version:</span>
                    <span class="system-info-val">Biye Media v1.0.0</span>
                </div>
                <div class="system-info-row">
                    <span class="system-info-label">Framework:</span>
                    <span class="system-info-val text-warning">Laravel {{ app()->version() }}</span>
                </div>
                <div class="system-info-row">
                    <span class="system-info-label">Database Driver:</span>
                    <span class="system-info-val text-info">{{ strtoupper(config('database.default')) }}</span>
                </div>
                <div class="system-info-row">
                    <span class="system-info-label">Current Admin Session:</span>
                    <span class="system-info-val text-success">
                        <i class="bi bi-lock-fill me-1"></i> Encrypted &amp; Protected
                    </span>
                </div>
                <div class="system-info-row border-bottom-0 pb-0">
                    <span class="system-info-label">Timezone:</span>
                    <span class="system-info-val">{{ config('app.timezone', 'Asia/Dhaka') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
