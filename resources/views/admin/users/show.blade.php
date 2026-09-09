@extends('admin.layouts.app')

@section('title', "Staff Profile: {$user->name}")
@section('page-title', 'Staff Member Details')

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

    .staff-profile-avatar {
        width: 84px;
        height: 84px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 2.2rem;
        color: #0b0206;
        background: linear-gradient(135deg, #fce07e 0%, #d4af37 100%);
        border: 3px solid rgba(212, 175, 55, 0.6);
        box-shadow: 0 4px 20px rgba(212, 175, 55, 0.35);
    }

    .badge-role-lg {
        font-size: 0.82rem;
        padding: 0.45rem 0.85rem;
        border-radius: 10px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        letter-spacing: 0.4px;
    }
    .role-super_admin {
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.25) 0%, rgba(245, 208, 97, 0.15) 100%);
        color: #fde68a;
        border: 1px solid rgba(212, 175, 55, 0.55);
    }
    .role-senior_matchmaker {
        background: rgba(168, 85, 247, 0.2);
        color: #d8b4fe;
        border: 1px solid rgba(168, 85, 247, 0.45);
    }
    .role-relationship_manager {
        background: rgba(59, 130, 246, 0.2);
        color: #93c5fd;
        border: 1px solid rgba(59, 130, 246, 0.45);
    }
    .role-profile_auditor {
        background: rgba(20, 184, 166, 0.2);
        color: #5eead4;
        border: 1px solid rgba(20, 184, 166, 0.45);
    }

    .info-row {
        padding: 0.85rem 0;
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

    .capability-item {
        background: #0d1117;
        border: 1px solid rgba(255, 255, 255, 0.07);
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.85rem;
        transition: border-color 0.2s ease;
    }
    .capability-item:hover {
        border-color: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.35);
    }
    .capability-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.12);
        color: var(--theme-secondary, #d4af37);
        border: 1px solid rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    .card-heading {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #f1f5f9;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding-bottom: 0.75rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .card-heading i {
        color: var(--theme-secondary, #d4af37);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Top Action Toolbar -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary text-white btn-sm px-3 py-2 d-inline-flex align-items-center gap-2" style="border-radius: 8px;">
                <i class="bi bi-arrow-left"></i>
                <span>Back to Staff List</span>
            </a>
            @if($user->id === auth()->id())
                <span class="badge" style="background: rgba(212, 175, 55, 0.2); color: #fde68a; border: 1px solid rgba(212, 175, 55, 0.4); padding: 0.4rem 0.7rem; border-radius: 6px; font-weight: 700;">
                    <i class="bi bi-person-check-fill me-1"></i> Your Account
                </span>
            @endif
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <!-- Edit Staff Member -->
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-admin-primary btn-sm px-3 py-2 fw-bold text-dark d-inline-flex align-items-center gap-2">
                <i class="bi bi-pencil-square"></i>
                <span>Edit Credentials</span>
            </a>

            <!-- Toggle Status (if not self or root admin) -->
            @if($user->id !== auth()->id() && !($user->email === 'admin@biyemedia.com' && $user->is_active))
                <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn {{ $user->is_active ? 'btn-outline-danger' : 'btn-outline-success' }} btn-sm px-3 py-2 d-inline-flex align-items-center gap-2" style="border-radius: 8px;">
                        <i class="bi {{ $user->is_active ? 'bi-slash-circle' : 'bi-check-circle' }}"></i>
                        <span>{{ $user->is_active ? 'Suspend Account' : 'Activate Account' }}</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column: Staff Summary Profile Card -->
        <div class="col-lg-4">
            <div class="details-card text-center mb-4">
                <div class="d-flex justify-content-center mb-3">
                    <div class="staff-profile-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>

                <h4 class="fw-bold text-white mb-1 font-serif">{{ $user->name }}</h4>
                <p class="small mb-3" style="color: #94a3b8;">
                    {{ $user->designation ?: 'Matchmaking Relationship Manager' }}
                </p>

                @php
                    $roleClass = 'role-' . ($user->role ?? 'relationship_manager');
                @endphp
                <div class="mb-3">
                    <span class="badge-role-lg {{ $roleClass }}">
                        @if($user->role === 'super_admin')
                            <i class="bi bi-shield-fill-check"></i>
                        @elseif($user->role === 'senior_matchmaker')
                            <i class="bi bi-heart-fill"></i>
                        @else
                            <i class="bi bi-person-badge-fill"></i>
                        @endif
                        {{ $roles[$user->role] ?? $user->role_label }}
                    </span>
                </div>

                <div class="mb-4">
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }} px-3 py-1.5 rounded-pill" style="font-size: 0.76rem; letter-spacing: 0.5px;">
                        <i class="bi {{ $user->is_active ? 'bi-check-circle-fill' : 'bi-slash-circle-fill' }} me-1"></i>
                        {{ $user->is_active ? 'ACTIVE & ONLINE' : 'SUSPENDED' }}
                    </span>
                </div>

                <!-- Direct Contact Actions -->
                <div class="d-grid gap-2 pt-2 border-top border-secondary border-opacity-15">
                    @if(!empty($user->email))
                        <a href="mailto:{{ $user->email }}" class="btn btn-sm btn-outline-secondary text-white py-2 d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px;">
                            <i class="bi bi-envelope-fill text-gold"></i>
                            <span class="text-truncate">{{ $user->email }}</span>
                        </a>
                    @endif

                    @if(!empty($user->phone))
                        <a href="tel:{{ $user->phone }}" class="btn btn-sm btn-outline-secondary text-white py-2 d-flex align-items-center justify-content-center gap-2" style="border-radius: 8px;">
                            <i class="bi bi-telephone-fill text-gold"></i>
                            <span>{{ $user->phone }}</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Account Metadata Card -->
            <div class="details-card">
                <div class="card-heading">
                    <i class="bi bi-shield-lock"></i> Account Audit Data
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-hash"></i> Staff System ID</span>
                    <span class="info-value">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-calendar3"></i> Date Registered</span>
                    <span class="info-value">{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-clock-history"></i> Last Activity</span>
                    <span class="info-value">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label"><i class="bi bi-patch-check"></i> Email Status</span>
                    <span class="info-value">
                        @if($user->email_verified_at)
                            <span class="text-success"><i class="bi bi-check2-circle me-1"></i>Verified</span>
                        @else
                            <span class="text-warning"><i class="bi bi-exclamation-circle me-1"></i>Pending</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Right Column: Details & Role Capabilities -->
        <div class="col-lg-8">
            <!-- Full Profile Specifications -->
            <div class="details-card mb-4">
                <div class="card-heading">
                    <i class="bi bi-person-badge"></i> Detailed Profile Specifications
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #0d1117; border: 1px solid rgba(255, 255, 255, 0.07);">
                            <div class="small text-muted-custom mb-1">Official Full Name</div>
                            <div class="fw-bold text-white fs-6">{{ $user->name }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #0d1117; border: 1px solid rgba(255, 255, 255, 0.07);">
                            <div class="small text-muted-custom mb-1">Administrative Role</div>
                            <div class="fw-bold text-gold fs-6">{{ $roles[$user->role] ?? $user->role_label }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #0d1117; border: 1px solid rgba(255, 255, 255, 0.07);">
                            <div class="small text-muted-custom mb-1">Assigned Designation &amp; Desk</div>
                            <div class="fw-bold text-white fs-6">{{ $user->designation ?: 'Matchmaking Relationship Manager' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #0d1117; border: 1px solid rgba(255, 255, 255, 0.07);">
                            <div class="small text-muted-custom mb-1">Official Email Address</div>
                            <div class="fw-bold text-white fs-6">{{ $user->email }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #0d1117; border: 1px solid rgba(255, 255, 255, 0.07);">
                            <div class="small text-muted-custom mb-1">Contact Phone Number</div>
                            <div class="fw-bold text-white fs-6">{{ $user->phone ?: 'Not provided' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background: #0d1117; border: 1px solid rgba(255, 255, 255, 0.07);">
                            <div class="small text-muted-custom mb-1">Operational Authority Scope</div>
                            <div class="fw-bold text-white fs-6">
                                {{ $user->role === 'super_admin' ? 'Universal System Control' : 'Matchmaking & Client Operations' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Permissions & Functional Capabilities -->
            <div class="details-card">
                <div class="card-heading">
                    <i class="bi bi-key-fill"></i> Functional Permissions &amp; Capabilities
                </div>

                <div class="row g-3">
                    @if($user->role === 'super_admin')
                        <div class="col-md-6">
                            <div class="capability-item">
                                <div class="capability-icon"><i class="bi bi-shield-shaded"></i></div>
                                <div>
                                    <div class="fw-bold text-white small">Universal Portal Access</div>
                                    <div class="small text-secondary" style="font-size: 0.78rem;">Unrestricted authorization over candidate biodata, financial packages, settings, and staff accounts.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="capability-item">
                                <div class="capability-icon"><i class="bi bi-people-fill"></i></div>
                                <div>
                                    <div class="fw-bold text-white small">Staff &amp; Role Management</div>
                                    <div class="small text-secondary" style="font-size: 0.78rem;">Can onboard matchmakers, assign regional branches, update credentials, or revoke account access.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="capability-item">
                                <div class="capability-icon"><i class="bi bi-palette-fill"></i></div>
                                <div>
                                    <div class="fw-bold text-white small">Content &amp; Brand Styling CMS</div>
                                    <div class="small text-secondary" style="font-size: 0.78rem;">Authorized to alter 3-tier theme colors, hero banners, helplines, announcements, and SEO meta.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="capability-item">
                                <div class="capability-icon"><i class="bi bi-gem"></i></div>
                                <div>
                                    <div class="fw-bold text-white small">Financial Packages &amp; Pricing</div>
                                    <div class="small text-secondary" style="font-size: 0.78rem;">Can configure VIP package pricing, features list, badge highlights, and discount tags.</div>
                                </div>
                            </div>
                        </div>
                    @elseif($user->role === 'senior_matchmaker')
                        <div class="col-md-6">
                            <div class="capability-item">
                                <div class="capability-icon"><i class="bi bi-heart-pulse-fill"></i></div>
                                <div>
                                    <div class="fw-bold text-white small">VIP Matrimonial Matching</div>
                                    <div class="small text-secondary" style="font-size: 0.78rem;">Full access to candidate biodata, matchmaking portfolios, family backgrounds, and verified profiles.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="capability-item">
                                <div class="capability-icon"><i class="bi bi-headset"></i></div>
                                <div>
                                    <div class="fw-bold text-white small">Lead Inquiries &amp; Consultations</div>
                                    <div class="small text-secondary" style="font-size: 0.78rem;">Can respond to consultation requests, manage callback queues, and assign match consultations.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="capability-item">
                                <div class="capability-icon"><i class="bi bi-stars"></i></div>
                                <div>
                                    <div class="fw-bold text-white small">Success Stories Curation</div>
                                    <div class="small text-secondary" style="font-size: 0.78rem;">Authorized to publish real matrimonial marriage success stories and client testimonials.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="capability-item">
                                <div class="capability-icon"><i class="bi bi-lock-fill"></i></div>
                                <div>
                                    <div class="fw-bold text-white small">Confidential Client Privacy</div>
                                    <div class="small text-secondary" style="font-size: 0.78rem;">Restricted from altering system brand theme colors or deleting core database configurations.</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-md-6">
                            <div class="capability-item">
                                <div class="capability-icon"><i class="bi bi-person-lines-fill"></i></div>
                                <div>
                                    <div class="fw-bold text-white small">Relationship Desk Inquiries</div>
                                    <div class="small text-secondary" style="font-size: 0.78rem;">Authorized to view incoming VIP inquiries, record phone conversation notes, and follow up.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="capability-item">
                                <div class="capability-icon"><i class="bi bi-people"></i></div>
                                <div>
                                    <div class="fw-bold text-white small">Candidate Biodata Assistance</div>
                                    <div class="small text-secondary" style="font-size: 0.78rem;">Assists registered brides and grooms with profile completion, verification photos, and document intake.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="capability-item">
                                <div class="capability-icon"><i class="bi bi-question-diamond"></i></div>
                                <div>
                                    <div class="fw-bold text-white small">FAQs &amp; Helpdesk Inquiries</div>
                                    <div class="small text-secondary" style="font-size: 0.78rem;">Can reference knowledgebase articles and assist families inquiring about registration steps.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="capability-item">
                                <div class="capability-icon"><i class="bi bi-shield-check"></i></div>
                                <div>
                                    <div class="fw-bold text-white small">Standard Staff Security</div>
                                    <div class="small text-secondary" style="font-size: 0.78rem;">Protected operational role under direct supervision of Senior Matchmakers and Super Administrators.</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
