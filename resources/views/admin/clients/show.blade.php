@extends('admin.layouts.app')

@section('title', 'Client Profile: ' . $client->name . ' - Biye Marriage Media Admin')
@section('header_title', 'Client Account Details')

@section('content')
<div class="container-fluid py-2">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Top Action Bar -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-2">
                <i class="bi bi-arrow-left me-1"></i> Back to Client List
            </a>
            <h4 class="font-serif fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <span>{{ $client->name }}</span>
                @if($client->isVerified())
                    <i class="bi bi-patch-check-fill text-primary" title="Verified Blue Seal"></i>
                @endif
                <span class="badge {{ $client->status === 'active' ? 'bg-success' : 'bg-danger' }} fs-6 fw-normal">
                    {{ ucfirst($client->status) }}
                </span>
            </h4>
        </div>
        <div class="d-flex align-items-center gap-2">
            <form action="{{ route('admin.clients.impersonate', $client) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login As Client
                </button>
            </form>
            <form action="{{ route('admin.clients.status', $client) }}" method="POST" onsubmit="return confirm('Toggle active/suspended status for this account?');">
                @csrf
                <input type="hidden" name="status" value="{{ $client->status === 'active' ? 'suspended' : 'active' }}">
                <input type="hidden" name="suspension_reason" value="Toggled by administrative oversight">
                <button type="submit" class="btn {{ $client->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' }} btn-sm rounded-pill px-3">
                    <i class="bi {{ $client->status === 'active' ? 'bi-lock-fill' : 'bi-unlock-fill' }} me-1"></i>
                    {{ $client->status === 'active' ? 'Suspend Account' : 'Activate Account' }}
                </button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column -->
        <div class="col-12 col-lg-4">
            <!-- Profile Photo & Summary Card -->
            <div class="card border-0 shadow-sm rounded-3 bg-white mb-4 overflow-hidden">
                <div class="bg-maroon py-4 px-3 text-center text-white" style="background: linear-gradient(135deg, #851829 0%, #4a0d17 100%);">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ $candidateProfile?->resolved_image ?? asset('site-logo/marriage-logo.jpeg') }}" 
                             alt="{{ $client->name }}" 
                             class="rounded-circle shadow border border-3 border-white object-fit-cover" 
                             style="width: 110px; height: 110px;">
                        @if($candidateProfile?->is_discreet)
                            <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-dark border border-white" title="Discreet photo blur enabled by client">
                                <i class="bi bi-eye-slash-fill"></i>
                            </span>
                        @endif
                    </div>
                    <h5 class="fw-bold font-serif mb-1">{{ $client->name }}</h5>
                    <p class="small text-white-50 mb-1">
                        Profile Managed For: <strong>{{ ucfirst($client->profile_for ?? 'Self') }}</strong>
                    </p>
                    @if($candidateProfile)
                        <span class="badge bg-white text-maroon fw-bold px-3 py-1 rounded-pill">
                            {{ $candidateProfile->profile_code }}
                        </span>
                    @endif
                </div>
                <div class="card-body p-3">
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Registered Phone:</span>
                            <strong class="text-dark">{{ $client->phone }}</strong>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Email Address:</span>
                            <span class="text-dark">{{ $client->email }}</span>
                        </li>
                        @if($client->guardian_name)
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                <span class="text-muted">Guardian Name:</span>
                                <strong class="text-dark">{{ $client->guardian_name }}</strong>
                            </li>
                        @endif
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Verification Seal:</span>
                            <span>
                                @if($client->isVerified())
                                    <span class="badge bg-success-subtle text-success"><i class="bi bi-patch-check-fill me-1"></i>Verified</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning"><i class="bi bi-clock-history me-1"></i>Pending Review</span>
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Registration Date:</span>
                            <span class="text-dark">{{ $client->created_at->format('d M Y, h:i A') }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Last Active:</span>
                            <span class="text-dark">{{ $client->last_login_at ? $client->last_login_at->diffForHumans() : 'Never' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Assigned Relationship Manager Card -->
            <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0 font-serif">
                        <i class="bi bi-person-badge text-info me-2"></i>Assigned Matchmaker (RM)
                    </h6>
                    <button class="btn btn-sm btn-outline-info rounded-pill px-2.5" data-bs-toggle="modal" data-bs-target="#reassignStaffModal">
                        Change
                    </button>
                </div>
                <div class="card-body p-3">
                    @if($client->assignedStaff)
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-info-subtle text-info fw-bold d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.2rem;">
                                {{ strtoupper(substr($client->assignedStaff->name, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">{{ $client->assignedStaff->name }}</h6>
                                <div class="small text-muted mb-1">{{ $client->assignedStaff->designation ?? $client->assignedStaff->role_label }}</div>
                                <div class="small text-secondary">
                                    <i class="bi bi-telephone-fill me-1"></i>{{ $client->assignedStaff->phone }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">
                            <i class="bi bi-person-slash fs-3 d-block mb-1"></i>
                            <div class="small">No relationship manager assigned yet.</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Active Membership Subscription Card -->
            <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark mb-0 font-serif">
                        <i class="bi bi-gem text-warning me-2"></i>Membership &amp; Quotas
                    </h6>
                    <button class="btn btn-sm btn-outline-warning rounded-pill px-2.5 text-dark" data-bs-toggle="modal" data-bs-target="#upgradePlanModal">
                        Upgrade
                    </button>
                </div>
                <div class="card-body p-3">
                    @php $sub = $client->activeSubscription; @endphp
                    @if($sub)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-dark fs-6">{{ $sub->package_name }}</span>
                            <span class="badge bg-success text-white">Active</span>
                        </div>
                        <div class="progress mb-2" style="height: 8px;">
                            @php
                                $usedPct = $sub->proposals_quota > 0 ? ($sub->proposals_used / $sub->proposals_quota) * 100 : 0;
                            @endphp
                            <div class="progress-bar bg-maroon" role="progressbar" style="width: {{ $usedPct }}%" aria-valuenow="{{ $usedPct }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted mb-2">
                            <span>Proposals Sent: <strong>{{ $sub->proposals_used }}</strong></span>
                            <span>Limit: <strong>{{ $sub->proposals_quota }}</strong> (Remaining: {{ $sub->remainingProposals() }})</span>
                        </div>
                        <hr class="my-2">
                        <div class="small text-muted d-flex justify-content-between">
                            <span>Amount Paid:</span>
                            <strong class="text-dark">৳{{ number_format($sub->price_paid) }}</strong>
                        </div>
                        <div class="small text-muted d-flex justify-content-between mt-1">
                            <span>Expires On:</span>
                            <strong class="text-dark">{{ $sub->expires_at ? $sub->expires_at->format('d M Y') : 'Lifetime' }}</strong>
                        </div>
                    @else
                        <p class="small text-muted mb-0">No active package assigned to this client.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-12 col-lg-8">
            <!-- Verification & Audit Decision Card -->
            <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0 font-serif">
                        <i class="bi bi-patch-check-fill text-primary me-2"></i>Audit &amp; Verification Decision
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.clients.verify', $client) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Verification Seal Badge</label>
                                <select name="verification_status" class="form-select" required>
                                    <option value="verified" {{ $client->verification_status === 'verified' ? 'selected' : '' }}>Verified (Grant Blue Seal Badge)</option>
                                    <option value="pending" {{ $client->verification_status === 'pending' ? 'selected' : '' }}>Pending Audit / Incomplete</option>
                                    <option value="rejected" {{ $client->verification_status === 'rejected' ? 'selected' : '' }}>Reject / Suspicious Credentials</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold">Candidate Profile Public Approval</label>
                                <select name="approval_status" class="form-select">
                                    <option value="approved" {{ $candidateProfile?->approval_status === 'approved' ? 'selected' : '' }}>Approved for Public Matching</option>
                                    <option value="under_review" {{ $candidateProfile?->approval_status === 'under_review' ? 'selected' : '' }}>Under Review / Private</option>
                                    <option value="draft" {{ $candidateProfile?->approval_status === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="rejected" {{ $candidateProfile?->approval_status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-semibold">Internal Audit Notes</label>
                                <textarea name="admin_notes" class="form-control" rows="2" placeholder="e.g. Identity verified via NID. Family background vetted with local references.">{{ $candidateProfile?->admin_notes }}</textarea>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                    <i class="bi bi-save me-1"></i> Update Verification &amp; Approval
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Full Biodata Credentials -->
            @if($candidateProfile)
                <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-dark mb-0 font-serif">
                            <i class="bi bi-card-text text-maroon me-2"></i>Candidate Biodata Credentials
                        </h5>
                        <span class="badge bg-light text-dark border">Completion: {{ $candidateProfile->completion_score }}%</span>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-6 col-md-3">
                                <div class="text-muted small">Gender</div>
                                <div class="fw-semibold text-dark">{{ ucfirst($candidateProfile->gender) }}</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="text-muted small">Age</div>
                                <div class="fw-semibold text-dark">{{ $candidateProfile->age }} Years</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="text-muted small">Height</div>
                                <div class="fw-semibold text-dark">{{ $candidateProfile->height }}</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="text-muted small">Religion</div>
                                <div class="fw-semibold text-dark">{{ $candidateProfile->religion }}</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="text-muted small">Desher Bari (District)</div>
                                <div class="fw-semibold text-dark">{{ $candidateProfile->desher_bari }}</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="text-muted small">Current Location</div>
                                <div class="fw-semibold text-dark">{{ $candidateProfile->location }}</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="text-muted small">Category</div>
                                <div class="fw-semibold text-dark">{{ $candidateProfile->category }}</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="text-muted small">Annual Income</div>
                                <div class="fw-semibold text-dark">{{ $candidateProfile->income }}</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="text-muted small fw-semibold mb-1">Education &amp; Qualifications</div>
                            <div class="p-3 bg-light rounded-3 text-dark">{{ $candidateProfile->education }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="text-muted small fw-semibold mb-1">Profession &amp; Career Details</div>
                            <div class="p-3 bg-light rounded-3 text-dark">{{ $candidateProfile->profession }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="text-muted small fw-semibold mb-1">Family Background &amp; Lineage</div>
                            <div class="p-3 bg-light rounded-3 text-dark" style="white-space: pre-line;">{{ $candidateProfile->family }}</div>
                        </div>
                    </div>
                </div>

                <!-- Partner Preferences -->
                <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h5 class="fw-bold text-dark mb-0 font-serif">
                            <i class="bi bi-heart-pulse text-danger me-2"></i>Partner Preferences &amp; Alliance Criteria
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-6 col-md-4">
                                <div class="text-muted small">Preferred Age Range</div>
                                <div class="fw-semibold text-dark">
                                    {{ $candidateProfile->pref_age_min ?? 'Any' }} - {{ $candidateProfile->pref_age_max ?? 'Any' }} yrs
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="text-muted small">Preferred Desher Bari</div>
                                <div class="fw-semibold text-dark">{{ $candidateProfile->pref_desher_bari ?? 'Any District in Bangladesh' }}</div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="text-muted small">Preferred Religion</div>
                                <div class="fw-semibold text-dark">{{ $candidateProfile->pref_religion ?? 'Islam (Sunni)' }}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="text-muted small">Preferred Education</div>
                                <div class="fw-semibold text-dark">{{ $candidateProfile->pref_education ?? 'Graduate / Professional' }}</div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="text-muted small">Preferred Profession</div>
                                <div class="fw-semibold text-dark">{{ $candidateProfile->pref_profession ?? 'Corporate / Doctor / Engineer / BCS' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Proposals Pipeline & Mediation -->
            <div class="card border-0 shadow-sm rounded-3 bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0 font-serif">
                        <i class="bi bi-send-check text-primary me-2"></i>Proposals History &amp; Mediation
                    </h5>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-tabs px-3 pt-2" id="proposalTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-semibold small" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent-proposals" type="button" role="tab">
                                Sent Interests ({{ $client->sentProposals->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold small" id="received-tab" data-bs-toggle="tab" data-bs-target="#received-proposals" type="button" role="tab">
                                Received Proposals ({{ $receivedProposals->count() }})
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content p-3" id="proposalTabsContent">
                        <!-- Sent Proposals -->
                        <div class="tab-pane fade show active" id="sent-proposals" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 small">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th>Target Candidate</th>
                                            <th>Gender / Age</th>
                                            <th>Date Sent</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($client->sentProposals as $sent)
                                            <tr>
                                                <td>
                                                    <strong>{{ $sent->receiverProfile->profile_code }}</strong> - {{ $sent->receiverProfile->profession }}
                                                </td>
                                                <td>{{ ucfirst($sent->receiverProfile->gender) }}, {{ $sent->receiverProfile->age }} yrs</td>
                                                <td>{{ $sent->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <span class="badge {{ $sent->status === 'accepted' ? 'bg-success' : ($sent->status === 'declined' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                                        {{ ucfirst($sent->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-3 text-muted">No sent proposals recorded yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Received Proposals -->
                        <div class="tab-pane fade" id="received-proposals" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 small">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th>Sender Family / Candidate</th>
                                            <th>Contact Info</th>
                                            <th>Date Received</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($receivedProposals as $rec)
                                            <tr>
                                                <td>
                                                    <strong>{{ $rec->senderProfile?->profile_code }}</strong> ({{ $rec->senderUser?->name }})
                                                </td>
                                                <td>{{ $rec->senderUser?->phone }}</td>
                                                <td>{{ $rec->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <span class="badge {{ $rec->status === 'accepted' ? 'bg-success' : ($rec->status === 'declined' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                                        {{ ucfirst($rec->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-3 text-muted">No received proposals recorded yet.</td>
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
</div>

<!-- Modal: Reassign Staff -->
<div class="modal fade" id="reassignStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start">
            <form action="{{ route('admin.clients.assign-staff', $client) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-serif fw-bold">
                        <i class="bi bi-person-badge text-info me-2"></i>Assign Relationship Manager
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Select Matchmaker Staff</label>
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
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info text-white fw-semibold">Assign RM</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Upgrade Plan -->
<div class="modal fade" id="upgradePlanModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-start">
            <form action="{{ route('admin.clients.subscription', $client) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title font-serif fw-bold">
                        <i class="bi bi-gem text-warning me-2"></i>Allocate Membership Package
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Package Name</label>
                        <input type="text" name="package_name" class="form-control" value="Elite Business Alliance" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Proposals Quota</label>
                            <input type="number" name="proposals_quota" class="form-control" value="25" min="1" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Validity (Months)</label>
                            <input type="number" name="validity_months" class="form-control" value="6" min="1" max="36" required>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Amount Paid (BDT)</label>
                            <input type="number" name="price_paid" class="form-control" value="50000" min="0" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Payment Channel</label>
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
                        <label class="form-label small fw-semibold">Transaction ID / Reference</label>
                        <input type="text" name="transaction_id" class="form-control" placeholder="e.g. TR-BKASH-898231">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-semibold">Activate Plan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
