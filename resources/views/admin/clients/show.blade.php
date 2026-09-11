@extends('admin.layouts.app')

@section('title', "Client Profile: {$client->name}")
@section('page-title', 'Client Account Details')

@push('styles')
<style>
    .details-card {
        background: #141820;
        background: linear-gradient(180deg, #171c26 0%, #131720 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        padding: 1.75rem;
    }

    .client-avatar-frame {
        position: relative;
        display: inline-block;
        width: 92px;
        height: 92px;
        margin: 0 auto 1rem;
    }
    .client-avatar-img {
        width: 92px;
        height: 92px;
        border-radius: 22px;
        object-fit: cover;
        border: 3px solid rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.6);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
    }
    .client-avatar-initials {
        width: 92px;
        height: 92px;
        border-radius: 22px;
        background: linear-gradient(135deg, #fce07e 0%, #d4af37 100%);
        color: #0b0f17;
        font-size: 2.3rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.6);
        box-shadow: 0 4px 20px rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.35);
    }

    .card-heading {
        font-family: 'Playfair Display', serif;
        font-size: 1.12rem;
        font-weight: 700;
        color: #f8fafc;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding-bottom: 0.75rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.6rem;
    }
    .card-heading i {
        color: var(--theme-secondary, #d4af37);
    }

    .info-row {
        padding: 0.8rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }
    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .info-label {
        font-size: 0.82rem;
        color: #94a3b8;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .info-label i {
        color: var(--theme-secondary, #d4af37);
        font-size: 0.95rem;
    }
    .info-value {
        font-size: 0.88rem;
        color: #f1f5f9;
        font-weight: 600;
        text-align: right;
    }

    .info-tile {
        background: #0d1117;
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 12px;
        padding: 0.9rem 1rem;
        height: 100%;
        transition: border-color 0.2s ease, transform 0.2s ease;
    }
    .info-tile:hover {
        border-color: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.35);
        transform: translateY(-2px);
    }
    .info-tile-label {
        font-size: 0.76rem;
        color: #94a3b8;
        font-weight: 500;
        margin-bottom: 0.3rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-tile-value {
        font-size: 0.92rem;
        color: #f1f5f9;
        font-weight: 600;
    }

    .info-block-box {
        background: #0d1117;
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 12px;
        padding: 1.1rem;
        color: #cbd5e1;
        font-size: 0.9rem;
        line-height: 1.65;
    }

    /* Form Controls Dark Theme */
    .form-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: #cbd5e1;
        margin-bottom: 0.4rem;
        letter-spacing: 0.2px;
    }
    .form-control, .form-select {
        background: #0d1117 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #f1f5f9 !important;
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        font-size: 0.88rem;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.6) !important;
        box-shadow: 0 0 0 3px rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.18) !important;
    }
    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.3) !important;
    }

    /* Modal Dark Theme */
    .modal-content {
        background: #141820 !important;
        background: linear-gradient(180deg, #171c26 0%, #131720 100%) !important;
        border: 1px solid rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.35) !important;
        border-radius: 16px !important;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.75) !important;
        color: #f1f5f9 !important;
    }
    .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }
    .modal-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    /* Proposals Dark Tabs */
    .custom-dark-tabs {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        gap: 0.5rem;
    }
    .custom-dark-tabs .nav-link {
        color: #94a3b8;
        border: none;
        border-bottom: 2px solid transparent;
        background: transparent;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        font-size: 0.86rem;
        transition: all 0.2s ease;
    }
    .custom-dark-tabs .nav-link:hover {
        color: #f1f5f9;
        border-bottom-color: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.4);
    }
    .custom-dark-tabs .nav-link.active {
        color: #fde68a;
        border-bottom-color: var(--theme-secondary, #d4af37);
        background: transparent;
    }

    .table-dark-custom {
        --bs-table-bg: transparent;
        --bs-table-color: #cbd5e1;
        --bs-table-hover-bg: rgba(255, 255, 255, 0.04);
        --bs-table-hover-color: #ffffff;
        border-color: rgba(255, 255, 255, 0.06);
    }
    .table-dark-custom th {
        background: rgba(255, 255, 255, 0.02);
        color: #94a3b8;
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 0.85rem 1rem;
    }
    .table-dark-custom td {
        padding: 0.85rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="alert alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert" style="background: rgba(34, 197, 94, 0.14); border: 1px solid rgba(34, 197, 94, 0.35); color: #86efac; border-radius: 12px;">
            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert" style="background: rgba(239, 68, 68, 0.14); border: 1px solid rgba(239, 68, 68, 0.35); color: #fca5a5; border-radius: 12px;">
            <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Top Action Toolbar -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary text-white btn-sm px-3 py-2 d-inline-flex align-items-center gap-2" style="border-radius: 8px;">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Client Accounts</span>
            </a>
            
            <div class="d-flex align-items-center gap-2">
                <h4 class="fw-bold text-white mb-0 font-serif">{{ $client->name }}</h4>
                @if($client->isVerified())
                    <span class="badge" style="background: rgba(59, 130, 246, 0.2); color: #93c5fd; border: 1px solid rgba(59, 130, 246, 0.45); padding: 0.35rem 0.65rem; border-radius: 6px; font-weight: 700;">
                        <i class="bi bi-patch-check-fill me-1"></i> Verified Seal
                    </span>
                @else
                    <span class="badge" style="background: rgba(234, 179, 8, 0.2); color: #fde047; border: 1px solid rgba(234, 179, 8, 0.4); padding: 0.35rem 0.65rem; border-radius: 6px; font-weight: 700;">
                        <i class="bi bi-clock-history me-1"></i> Pending Audit
                    </span>
                @endif
                <span class="badge {{ $client->status === 'active' ? 'bg-success' : 'bg-danger' }} px-2.5 py-1 rounded-pill" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                    {{ strtoupper($client->status) }}
                </span>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- Impersonate Client Login -->
            <form action="{{ route('admin.clients.impersonate', $client) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-warning text-gold btn-sm px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2" style="border-radius: 8px; border-color: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.6);">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login As Client</span>
                </button>
            </form>

            <!-- Toggle Status (Activate / Suspend) -->
            <form action="{{ route('admin.clients.status', $client) }}" method="POST" class="d-inline" onsubmit="return confirm('Toggle active/suspended status for this account?');">
                @csrf
                <input type="hidden" name="status" value="{{ $client->status === 'active' ? 'suspended' : 'active' }}">
                <input type="hidden" name="suspension_reason" value="Status toggled by administrative oversight">
                <button type="submit" class="btn {{ $client->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' }} btn-sm px-3 py-2 d-inline-flex align-items-center gap-2" style="border-radius: 8px;">
                    <i class="bi {{ $client->status === 'active' ? 'bi-slash-circle' : 'bi-check-circle' }}"></i>
                    <span>{{ $client->status === 'active' ? 'Suspend Account' : 'Activate Account' }}</span>
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Profile Card, Audit Data, Matchmaker, Membership -->
        <div class="col-12 col-lg-4">
            <!-- Client Overview Profile Card -->
            <div class="details-card text-center mb-4">
                <div class="client-avatar-frame">
                    @if($candidateProfile && !empty($candidateProfile->resolved_image) && $candidateProfile->resolved_image !== asset('site-logo/marriage-logo.jpeg'))
                        <img src="{{ $candidateProfile->resolved_image }}" alt="{{ $client->name }}" class="client-avatar-img">
                    @else
                        <div class="client-avatar-initials">
                            {{ strtoupper(substr($client->name, 0, 1)) }}
                        </div>
                    @endif

                    @if($candidateProfile?->is_discreet)
                        <span class="position-absolute bottom-0 end-0 badge rounded-circle bg-dark border border-secondary text-warning p-2" title="Discreet photo blur enabled by client">
                            <i class="bi bi-eye-slash-fill"></i>
                        </span>
                    @endif
                </div>

                <h4 class="fw-bold text-white mb-1 font-serif">{{ $client->name }}</h4>
                <p class="small mb-2 text-white-50">
                    Profile For: <strong class="text-white">{{ ucfirst($client->profile_for ?? 'Self') }}</strong>
                </p>

                @if($candidateProfile)
                    <div class="mb-3">
                        <span class="badge font-monospace px-3 py-1.5 rounded-pill" style="background: rgba(201, 151, 56, 0.15); border: 1px solid rgba(201, 151, 56, 0.4); color: #fde68a; font-size: 0.85rem;">
                            <i class="bi bi-person-badge-fill me-1"></i>{{ $candidateProfile->profile_code }}
                        </span>
                    </div>
                @endif

                <!-- Direct Contact Actions -->
                <div class="d-grid gap-2 pt-3 border-top border-secondary border-opacity-15">
                    @if(!empty($client->email))
                        <a href="mailto:{{ $client->email }}" class="btn btn-sm btn-outline-secondary text-white py-2 d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px;">
                            <i class="bi bi-envelope-fill text-gold"></i>
                            <span class="text-truncate">{{ $client->email }}</span>
                        </a>
                    @endif

                    @if(!empty($client->phone))
                        <a href="tel:{{ $client->phone }}" class="btn btn-sm btn-outline-secondary text-white py-2 d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px;">
                            <i class="bi bi-telephone-fill text-gold"></i>
                            <span>{{ $client->phone }}</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Account Audit Metadata Card -->
            <div class="details-card mb-4">
                <div class="card-heading">
                    <div><i class="bi bi-shield-lock me-2"></i>Account Audit Data</div>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-telephone"></i> Registered Phone</span>
                    <span class="info-value font-monospace">{{ $client->phone }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-envelope"></i> Email Address</span>
                    <span class="info-value text-truncate" style="max-width: 170px;">{{ $client->email }}</span>
                </div>

                @if($client->guardian_name)
                    <div class="info-row">
                        <span class="info-label"><i class="bi bi-person-badge"></i> Guardian Name</span>
                        <span class="info-value">{{ $client->guardian_name }}</span>
                    </div>
                @endif

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-patch-check"></i> Verification Seal</span>
                    <span class="info-value">
                        @if($client->isVerified())
                            <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i>Verified</span>
                        @else
                            <span class="text-warning"><i class="bi bi-clock-history me-1"></i>Pending Review</span>
                        @endif
                    </span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-calendar3"></i> Joined Date</span>
                    <span class="info-value">{{ $client->created_at->format('d M Y, h:i A') }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-activity"></i> Last Active</span>
                    <span class="info-value">{{ $client->last_login_at ? $client->last_login_at->diffForHumans() : 'Never' }}</span>
                </div>
            </div>

            <!-- Assigned Matchmaker (RM) Card -->
            <div class="details-card mb-4">
                <div class="card-heading">
                    <div><i class="bi bi-person-badge text-gold me-2"></i>Assigned Matchmaker (RM)</div>
                    <button class="btn btn-sm btn-outline-warning text-gold py-1 px-2.5 rounded-pill" data-bs-toggle="modal" data-bs-target="#reassignStaffModal" style="font-size: 0.78rem;">
                        <i class="bi bi-arrow-repeat me-1"></i> Change
                    </button>
                </div>

                @if($client->assignedStaff)
                    <div class="d-flex align-items-center gap-3 p-3 rounded" style="background: #0d1117; border: 1px solid rgba(255, 255, 255, 0.07);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 46px; height: 46px; background: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.15); color: #fde68a; border: 1px solid rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.35); font-size: 1.15rem; flex-shrink: 0;">
                            {{ strtoupper(substr($client->assignedStaff->name, 0, 1)) }}
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="fw-bold text-white mb-0 text-truncate">{{ $client->assignedStaff->name }}</h6>
                            <div class="small text-gold mb-1" style="font-size: 0.78rem;">{{ $client->assignedStaff->designation ?? $client->assignedStaff->role_label }}</div>
                            <div class="small text-muted-custom">
                                <i class="bi bi-telephone-fill text-gold me-1"></i>{{ $client->assignedStaff->phone }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4 rounded" style="background: #0d1117; border: 1px dashed rgba(255, 255, 255, 0.12);">
                        <i class="bi bi-person-x fs-2 text-secondary d-block mb-2"></i>
                        <div class="small text-white-50 mb-2">No relationship manager allocated yet.</div>
                        <button class="btn btn-sm btn-admin-primary px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#reassignStaffModal">
                            <i class="bi bi-person-plus me-1"></i> Assign Matchmaker
                        </button>
                    </div>
                @endif
            </div>

            <!-- Active Membership Subscription Card -->
            <div class="details-card mb-4">
                <div class="card-heading">
                    <div><i class="bi bi-gem text-gold me-2"></i>Membership Package</div>
                    <button class="btn btn-sm btn-outline-warning text-gold py-1 px-2.5 rounded-pill" data-bs-toggle="modal" data-bs-target="#upgradePlanModal" style="font-size: 0.78rem;">
                        <i class="bi bi-arrow-up-circle me-1"></i> Upgrade
                    </button>
                </div>

                @php $sub = $client->activeSubscription; @endphp
                @if($sub)
                    <div class="p-3 rounded mb-3" style="background: #0d1117; border: 1px solid rgba(255, 255, 255, 0.07);">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-white fs-6 font-serif">{{ $sub->package_name }}</span>
                            <span class="badge bg-success px-2 py-1 rounded-pill" style="font-size: 0.72rem;">ACTIVE</span>
                        </div>

                        @php
                            $usedPct = $sub->proposals_quota > 0 ? min(100, ($sub->proposals_used / $sub->proposals_quota) * 100) : 0;
                        @endphp
                        <div class="progress mb-2" style="height: 8px; background: rgba(255, 255, 255, 0.08); border-radius: 10px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $usedPct }}%; background: linear-gradient(90deg, #d4af37, #f5d061); border-radius: 10px;" aria-valuenow="{{ $usedPct }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="d-flex justify-content-between small text-white-50" style="font-size: 0.8rem;">
                            <span>Proposals Sent: <strong class="text-white">{{ $sub->proposals_used }}</strong></span>
                            <span>Limit: <strong class="text-gold">{{ $sub->proposals_quota }}</strong> (Left: {{ $sub->remainingProposals() }})</span>
                        </div>
                    </div>

                    <div class="info-row">
                        <span class="info-label"><i class="bi bi-cash-stack"></i> Amount Paid</span>
                        <span class="info-value text-gold">৳{{ number_format((float) ($sub->price_paid ?? 0)) }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label"><i class="bi bi-hourglass-split"></i> Expires On</span>
                        <span class="info-value">{{ $sub->expires_at ? $sub->expires_at->format('d M Y') : 'Lifetime Privilege' }}</span>
                    </div>
                @else
                    <div class="text-center py-4 rounded" style="background: #0d1117; border: 1px dashed rgba(255, 255, 255, 0.12);">
                        <i class="bi bi-gem fs-2 text-secondary d-block mb-2"></i>
                        <div class="small text-white-50 mb-2">No active package assigned to this client.</div>
                        <button class="btn btn-sm btn-outline-warning text-gold px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#upgradePlanModal">
                            <i class="bi bi-plus-circle me-1"></i> Allocate Package
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Verification Decision, Biodata Credentials, Partner Preferences, Proposals -->
        <div class="col-12 col-lg-8">
            <!-- Verification & Audit Decision Form Card -->
            <div class="details-card mb-4">
                <div class="card-heading">
                    <div><i class="bi bi-patch-check-fill text-primary me-2"></i>Audit &amp; Verification Decision</div>
                </div>

                <form action="{{ route('admin.clients.verify', $client) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Verification Seal Badge</label>
                            <select name="verification_status" class="form-select" required>
                                <option value="verified" {{ $client->verification_status === 'verified' ? 'selected' : '' }}>Verified (Grant Blue Seal Badge)</option>
                                <option value="pending" {{ $client->verification_status === 'pending' ? 'selected' : '' }}>Pending Audit / Incomplete</option>
                                <option value="rejected" {{ $client->verification_status === 'rejected' ? 'selected' : '' }}>Reject / Suspicious Credentials</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Candidate Profile Public Approval</label>
                            <select name="approval_status" class="form-select">
                                <option value="approved" {{ $candidateProfile?->approval_status === 'approved' ? 'selected' : '' }}>Approved for Public Matching</option>
                                <option value="under_review" {{ $candidateProfile?->approval_status === 'under_review' ? 'selected' : '' }}>Under Review / Private</option>
                                <option value="draft" {{ $candidateProfile?->approval_status === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="rejected" {{ $candidateProfile?->approval_status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Internal Administrative Audit Notes</label>
                            <textarea name="admin_notes" class="form-control" rows="2" placeholder="e.g. Identity verified via NID. Family background vetted with local references in Gulshan.">{{ $candidateProfile?->admin_notes }}</textarea>
                        </div>

                        <div class="col-12 text-end pt-2">
                            <button type="submit" class="btn btn-admin-primary px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                                <i class="bi bi-save"></i>
                                <span>Save Decision &amp; Seal</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Full Candidate Biodata Credentials Card -->
            @if($candidateProfile)
                <div class="details-card mb-4">
                    <div class="card-heading">
                        <div><i class="bi bi-file-earmark-person text-gold me-2"></i>Candidate Biodata Credentials</div>
                        <span class="badge" style="background: rgba(201, 151, 56, 0.15); border: 1px solid rgba(201, 151, 56, 0.4); color: #fde68a; font-size: 0.8rem;">
                            Profile Completion: {{ $candidateProfile->completion_score }}%
                        </span>
                    </div>

                    <!-- 8 Key Metrics Tiles -->
                    <div class="row g-3 mb-4">
                        <div class="col-6 col-md-3">
                            <div class="info-tile">
                                <div class="info-tile-label"><i class="bi bi-gender-ambiguous me-1"></i>Gender</div>
                                <div class="info-tile-value">{{ ucfirst($candidateProfile->gender) }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="info-tile">
                                <div class="info-tile-label"><i class="bi bi-calendar-heart me-1"></i>Age</div>
                                <div class="info-tile-value">{{ $candidateProfile->age }} Years</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="info-tile">
                                <div class="info-tile-label"><i class="bi bi-arrows-vertical me-1"></i>Height</div>
                                <div class="info-tile-value">{{ $candidateProfile->height }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="info-tile">
                                <div class="info-tile-label"><i class="bi bi-moon-stars me-1"></i>Religion</div>
                                <div class="info-tile-value">{{ $candidateProfile->religion }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="info-tile">
                                <div class="info-tile-label"><i class="bi bi-geo-alt me-1"></i>Desher Bari</div>
                                <div class="info-tile-value text-truncate">{{ $candidateProfile->desher_bari }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="info-tile">
                                <div class="info-tile-label"><i class="bi bi-pin-map me-1"></i>Current City</div>
                                <div class="info-tile-value text-truncate">{{ $candidateProfile->location }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="info-tile">
                                <div class="info-tile-label"><i class="bi bi-award me-1"></i>Category</div>
                                <div class="info-tile-value text-truncate">{{ $candidateProfile->category }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="info-tile">
                                <div class="info-tile-label"><i class="bi bi-cash-coin me-1"></i>Annual Income</div>
                                <div class="info-tile-value text-truncate">{{ $candidateProfile->income }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Education Details -->
                    <div class="mb-3">
                        <div class="small fw-semibold text-white-50 mb-1.5"><i class="bi bi-mortarboard-fill text-gold me-1"></i> Education &amp; Academic Background</div>
                        <div class="info-block-box">{{ $candidateProfile->education }}</div>
                    </div>

                    <!-- Profession Details -->
                    <div class="mb-3">
                        <div class="small fw-semibold text-white-50 mb-1.5"><i class="bi bi-briefcase-fill text-gold me-1"></i> Profession, Role &amp; Organization</div>
                        <div class="info-block-box">{{ $candidateProfile->profession }}</div>
                    </div>

                    <!-- Family Lineage Details -->
                    <div class="mb-2">
                        <div class="small fw-semibold text-white-50 mb-1.5"><i class="bi bi-people-fill text-gold me-1"></i> Family Lineage &amp; Heritage (Bongsho)</div>
                        <div class="info-block-box" style="white-space: pre-line;">{{ $candidateProfile->family }}</div>
                    </div>
                </div>

                <!-- Partner Preferences & Alliance Criteria Card -->
                <div class="details-card mb-4">
                    <div class="card-heading">
                        <div><i class="bi bi-heart-pulse-fill text-danger me-2"></i>Partner Preferences &amp; Criteria</div>
                    </div>

                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="info-tile">
                                <div class="info-tile-label">Preferred Age Range</div>
                                <div class="info-tile-value text-gold">
                                    {{ $candidateProfile->pref_age_min ?? 'Any' }} - {{ $candidateProfile->pref_age_max ?? 'Any' }} yrs
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="info-tile">
                                <div class="info-tile-label">Preferred Desher Bari</div>
                                <div class="info-tile-value">{{ $candidateProfile->pref_desher_bari ?? 'Any District' }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="info-tile">
                                <div class="info-tile-label">Preferred Religion</div>
                                <div class="info-tile-value">{{ $candidateProfile->pref_religion ?? 'Islam (Sunni)' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="info-tile">
                                <div class="info-tile-label">Preferred Education</div>
                                <div class="info-tile-value">{{ $candidateProfile->pref_education ?? 'Graduate / Masters / Professional' }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="info-tile">
                                <div class="info-tile-label">Preferred Profession</div>
                                <div class="info-tile-value">{{ $candidateProfile->pref_profession ?? 'Corporate / Doctor / Engineer / BCS' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Proposals Pipeline & Mediation Card -->
            <div class="details-card mb-4">
                <div class="card-heading mb-0 pb-0 border-bottom-0">
                    <div><i class="bi bi-send-check text-gold me-2"></i>Proposals Pipeline &amp; Mediation</div>
                </div>

                <ul class="nav custom-dark-tabs mt-2" id="proposalTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent-proposals" type="button" role="tab">
                            <i class="bi bi-arrow-up-right-circle me-1"></i> Sent Interests ({{ $client->sentProposals->count() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="received-tab" data-bs-toggle="tab" data-bs-target="#received-proposals" type="button" role="tab">
                            <i class="bi bi-arrow-down-left-circle me-1"></i> Received Proposals ({{ $receivedProposals->count() }})
                        </button>
                    </li>
                </ul>

                <div class="tab-content pt-3" id="proposalTabsContent">
                    <!-- Sent Proposals Tab -->
                    <div class="tab-pane fade show active" id="sent-proposals" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-dark-custom align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Target Candidate</th>
                                        <th>Gender / Age</th>
                                        <th>Date Sent</th>
                                        <th class="text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($client->sentProposals as $sent)
                                        <tr>
                                            <td>
                                                <strong class="text-white font-monospace">{{ $sent->receiverProfile->profile_code }}</strong>
                                                <div class="small text-white-50">{{ $sent->receiverProfile->profession }}</div>
                                            </td>
                                            <td>{{ ucfirst($sent->receiverProfile->gender) }}, {{ $sent->receiverProfile->age }} yrs</td>
                                            <td>{{ $sent->created_at->format('d M Y') }}</td>
                                            <td class="text-end">
                                                <span class="badge {{ $sent->status === 'accepted' ? 'bg-success' : ($sent->status === 'declined' ? 'bg-danger' : 'bg-warning text-dark') }} px-2.5 py-1 rounded-pill" style="font-size: 0.72rem;">
                                                    {{ strtoupper($sent->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-white-50">
                                                <i class="bi bi-inbox fs-3 d-block mb-1 text-secondary"></i>
                                                No sent proposals recorded yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Received Proposals Tab -->
                    <div class="tab-pane fade" id="received-proposals" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-dark-custom align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Sender Family / Candidate</th>
                                        <th>Contact Info</th>
                                        <th>Date Received</th>
                                        <th class="text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($receivedProposals as $rec)
                                        <tr>
                                            <td>
                                                <strong class="text-white font-monospace">{{ $rec->senderProfile?->profile_code }}</strong>
                                                <div class="small text-white-50">{{ $rec->senderUser?->name }}</div>
                                            </td>
                                            <td>
                                                <span class="font-monospace text-gold">{{ $rec->senderUser?->phone }}</span>
                                            </td>
                                            <td>{{ $rec->created_at->format('d M Y') }}</td>
                                            <td class="text-end">
                                                <span class="badge {{ $rec->status === 'accepted' ? 'bg-success' : ($rec->status === 'declined' ? 'bg-danger' : 'bg-warning text-dark') }} px-2.5 py-1 rounded-pill" style="font-size: 0.72rem;">
                                                    {{ strtoupper($rec->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-white-50">
                                                <i class="bi bi-inbox fs-3 d-block mb-1 text-secondary"></i>
                                                No received proposals recorded yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Reassign Relationship Manager -->
<div class="modal fade" id="reassignStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start">
            <form action="{{ route('admin.clients.assign-staff', $client) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-serif fw-bold text-white mb-0">
                        <i class="bi bi-person-badge text-gold me-2"></i>Assign Relationship Manager
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Select Matchmaker Staff</label>
                        <select name="assigned_staff_id" class="form-select">
                            <option value="">-- No Matchmaker Assigned --</option>
                            @foreach($staffMembers as $staff)
                                <option value="{{ $staff->id }}" {{ $client->assigned_staff_id == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->name }} ({{ $staff->role_label }}) - {{ $staff->phone }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary text-white btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-admin-primary btn-sm px-4 fw-semibold">
                        <i class="bi bi-check-lg me-1"></i> Save Assignment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Allocate / Upgrade Membership Plan -->
<div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start">
            <form action="{{ route('admin.clients.subscription', $client) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-serif fw-bold text-white mb-0">
                        <i class="bi bi-gem text-gold me-2"></i>Allocate Membership Package
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Predefined Package Selector -->
                    <div class="mb-3">
                        <label class="form-label">Select Predefined Package (Optional)</label>
                        <select name="package_id" class="form-select" id="modalUpgradePkgSelect" onchange="handleModalUpgradePackageSelect(this)">
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
                        <input type="text" name="package_name" id="modalPkgName" class="form-control" value="Elite Business Alliance" required>
                    </div>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">Proposals Quota</label>
                            <input type="number" name="proposals_quota" id="modalPkgQuota" class="form-control" value="25" min="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Validity (Months)</label>
                            <input type="number" name="validity_months" class="form-control" value="6" min="1" max="36" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">Amount Paid (BDT)</label>
                            <input type="number" name="price_paid" id="modalPkgPrice" class="form-control" value="50000" min="0" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Payment Channel</label>
                            <select name="payment_method" class="form-select">
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
                        <input type="text" name="transaction_id" class="form-control" placeholder="e.g. TR-BKASH-898231">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary text-white btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-admin-primary btn-sm px-4 fw-semibold">
                        <i class="bi bi-check-circle me-1"></i> Activate Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function handleModalUpgradePackageSelect(selectEl) {
        const option = selectEl.options[selectEl.selectedIndex];
        if (option && option.dataset.name) {
            document.getElementById('modalPkgName').value = option.dataset.name;
            document.getElementById('modalPkgPrice').value = option.dataset.price || 0;
            document.getElementById('modalPkgQuota').value = option.dataset.proposals || 25;
        }
    }
</script>
@endpush

@endsection
