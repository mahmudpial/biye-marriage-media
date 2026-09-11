@extends('admin.layouts.app')

@section('title', 'Client Accounts & Verification - Biye Marriage Media Admin')
@section('header_title', 'Client Accounts Management')

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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <div>{{ session('error') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Ribbon -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card p-3 rounded-3 shadow-sm bg-white border d-flex align-items-center gap-3">
                <div class="icon-circle bg-primary-subtle text-primary p-3 rounded-circle fs-4">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Total Clients</div>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalClients) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card p-3 rounded-3 shadow-sm bg-white border d-flex align-items-center gap-3">
                <div class="icon-circle bg-warning-subtle text-warning p-3 rounded-circle fs-4">
                    <i class="bi bi-shield-exclamation"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Pending Audit</div>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($pendingVerificationCount) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card p-3 rounded-3 shadow-sm bg-white border d-flex align-items-center gap-3">
                <div class="icon-circle bg-success-subtle text-success p-3 rounded-circle fs-4">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Active Clients</div>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($activeClientsCount) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card p-3 rounded-3 shadow-sm bg-white border d-flex align-items-center gap-3">
                <div class="icon-circle bg-danger-subtle text-danger p-3 rounded-circle fs-4">
                    <i class="bi bi-person-x-fill"></i>
                </div>
                <div>
                    <div class="text-muted small fw-medium">Suspended</div>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($suspendedClientsCount) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Panel -->
    <div class="card border-0 shadow-sm rounded-3 mb-4 bg-white">
        <div class="card-body p-3">
            <form action="{{ route('admin.clients.index') }}" method="GET" class="row g-2 align-items-center">
                <!-- Search Keyword -->
                <div class="col-12 col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control border-start-0 bg-light" placeholder="Search by name, email, phone, code...">
                    </div>
                </div>

                <!-- Verification Status -->
                <div class="col-6 col-md-2">
                    <select name="verification_status" class="form-select bg-light">
                        <option value="">All Verifications</option>
                        <option value="pending" {{ request('verification_status') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                        <option value="verified" {{ request('verification_status') === 'verified' ? 'selected' : '' }}>Verified (Blue Seal)</option>
                        <option value="rejected" {{ request('verification_status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- Account Status -->
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select bg-light">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>

                <!-- Gender Filter -->
                <div class="col-6 col-md-2">
                    <select name="gender" class="form-select bg-light">
                        <option value="">All Genders</option>
                        <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Bride (Patri)</option>
                        <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Groom (Patro)</option>
                    </select>
                </div>

                <!-- Matchmaker RM -->
                <div class="col-6 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-dark w-100 fw-medium">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['q', 'verification_status', 'status', 'gender', 'assigned_staff_id']))
                        <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary" title="Reset Filters">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Clients Table Card -->
    <div class="card border-0 shadow-sm rounded-3 bg-white">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark font-serif">
                <i class="bi bi-person-lines-fill text-maroon me-2"></i>Registered Matrimony Clients ({{ $clients->total() }})
            </h5>
            <div class="small text-muted">
                Showing {{ $clients->firstItem() ?? 0 }} to {{ $clients->lastItem() ?? 0 }} of {{ $clients->total() }} clients
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted small text-uppercase">
                    <tr>
                        <th style="width: 280px;">Client &amp; Candidate</th>
                        <th>Guardian / Contact</th>
                        <th>Profile Snapshot</th>
                        <th>Assigned RM</th>
                        <th>Package &amp; Quota</th>
                        <th>Verification</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        @php
                            $profile = $client->candidateProfile;
                            $subscription = $client->activeSubscription;
                        @endphp
                        <tr>
                            <!-- Client & Candidate -->
                            <td>
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-maroon fw-bold" style="width: 44px; height: 44px; font-size: 1.1rem; border: 1px solid rgba(133,24,41,0.2);">
                                        @if($profile && $profile->image)
                                            <img src="{{ $profile->resolved_image }}" alt="{{ $client->name }}" class="rounded-circle w-100 h-100 object-fit-cover">
                                        @else
                                            {{ strtoupper(substr($client->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark d-flex align-items-center gap-1">
                                            <span>{{ $client->name }}</span>
                                            @if($client->isVerified())
                                                <i class="bi bi-patch-check-fill text-primary" title="Verified Blue Seal"></i>
                                            @endif
                                        </div>
                                        <div class="small text-muted">
                                            <span class="badge bg-light text-dark border me-1">For {{ ucfirst($client->profile_for ?? 'Self') }}</span>
                                            @if($profile)
                                                <code class="text-maroon fw-semibold">{{ $profile->profile_code }}</code>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Guardian / Contact -->
                            <td>
                                <div class="small fw-semibold text-dark">{{ $client->phone }}</div>
                                <div class="small text-muted">{{ $client->email }}</div>
                                @if($client->guardian_name)
                                    <div class="small text-secondary"><i class="bi bi-person-badge me-1"></i>Guardian: {{ $client->guardian_name }}</div>
                                @endif
                            </td>

                            <!-- Snapshot -->
                            <td>
                                @if($profile)
                                    <div class="small fw-semibold text-dark">
                                        <span class="badge {{ $profile->gender === 'female' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }}">
                                            {{ ucfirst($profile->gender) }}, {{ $profile->age }} yrs, {{ $profile->height }}
                                        </span>
                                    </div>
                                    <div class="small text-muted text-truncate" style="max-width: 180px;" title="{{ $profile->profession }}">
                                        {{ $profile->profession }}
                                    </div>
                                    <div class="small text-secondary">
                                        <i class="bi bi-geo-alt me-0.5"></i>{{ $profile->desher_bari }}
                                    </div>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Biodata Not Created</span>
                                @endif
                            </td>

                            <!-- Assigned RM -->
                            <td>
                                @if($client->assignedStaff)
                                    <div class="d-flex align-items-center gap-1.5">
                                        <div class="small fw-semibold text-dark">{{ $client->assignedStaff->name }}</div>
                                    </div>
                                    <div class="small text-muted" style="font-size: 0.75rem;">{{ $client->assignedStaff->role_label }}</div>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">Unassigned</span>
                                @endif
                            </td>

                            <!-- Subscription & Quota -->
                            <td>
                                @if($subscription)
                                    <div class="small fw-bold text-dark">{{ $subscription->package_name }}</div>
                                    <div class="small text-muted" style="font-size: 0.76rem;">
                                        Proposals: <strong>{{ $subscription->proposals_used }}/{{ $subscription->proposals_quota }}</strong>
                                    </div>
                                    @if($subscription->expires_at)
                                        <div class="small text-secondary" style="font-size: 0.72rem;">
                                            Exp: {{ $subscription->expires_at->format('d M Y') }}
                                        </div>
                                    @endif
                                @else
                                    <span class="badge bg-light text-muted border">No Package</span>
                                @endif
                            </td>

                            <!-- Verification Status -->
                            <td>
                                @if($client->verification_status === 'verified')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-patch-check-fill"></i> Verified
                                    </span>
                                @elseif($client->verification_status === 'rejected')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                        <i class="bi bi-x-circle"></i> Rejected
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                        <i class="bi bi-clock-history"></i> Pending Audit
                                    </span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td>
                                @if($client->status === 'active')
                                    <span class="badge bg-success text-white">Active</span>
                                @else
                                    <span class="badge bg-danger text-white" title="{{ $client->suspension_reason }}">Suspended</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="text-end pe-3">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Manage
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.clients.show', $client) }}">
                                                <i class="bi bi-eye text-primary me-2"></i> View Full Biodata &amp; History
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
                                                <i class="bi bi-gem text-warning me-2"></i> Upgrade Package &amp; Quota
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
                                <div class="modal fade" id="verifyModal{{ $client->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content text-start">
                                            <form action="{{ route('admin.clients.verify', $client) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title font-serif fw-bold">
                                                        <i class="bi bi-patch-check-fill text-primary me-2"></i>Verify Client Biodata
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="small text-muted mb-3">
                                                        Client: <strong>{{ $client->name }}</strong> ({{ $client->phone }})
                                                    </p>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Verification Seal Decision</label>
                                                        <select name="verification_status" class="form-select" required>
                                                            <option value="verified" {{ $client->verification_status === 'verified' ? 'selected' : '' }}>Verified (Grant Blue Seal Badge)</option>
                                                            <option value="pending" {{ $client->verification_status === 'pending' ? 'selected' : '' }}>Pending Audit / Incomplete</option>
                                                            <option value="rejected" {{ $client->verification_status === 'rejected' ? 'selected' : '' }}>Reject / Suspicious Credentials</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Candidate Profile Public Approval</label>
                                                        <select name="approval_status" class="form-select">
                                                            <option value="approved" {{ $profile?->approval_status === 'approved' ? 'selected' : '' }}>Approved for Public Matching</option>
                                                            <option value="under_review" {{ $profile?->approval_status === 'under_review' ? 'selected' : '' }}>Under Review / Private</option>
                                                            <option value="rejected" {{ $profile?->approval_status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold">Admin Verification Notes</label>
                                                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="e.g. NID verified via WhatsApp call. Educational certificates cross-checked.">{{ $profile?->admin_notes }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary fw-semibold">Save Verification</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Assign Staff Modal -->
                                <div class="modal fade" id="staffModal{{ $client->id }}" tabindex="-1" aria-hidden="true">
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
                                                    <p class="small text-muted mb-0">
                                                        The assigned matchmaker will be displayed in the client's member dashboard with their direct phone and WhatsApp contact card.
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-info text-white fw-semibold">Assign Staff</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Package & Quota Upgrade Modal -->
                                <div class="modal fade" id="packageModal{{ $client->id }}" tabindex="-1" aria-hidden="true">
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
                                                        <label class="form-label small fw-semibold">Select Predefined Package (Optional)</label>
                                                        <select name="package_id" class="form-select" id="pkgSelect{{ $client->id }}" onchange="handlePackageSelect(this, '{{ $client->id }}')">
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
                                                        <label class="form-label small fw-semibold">Package Name</label>
                                                        <input type="text" name="package_name" id="pkgName{{ $client->id }}" class="form-control" value="{{ $subscription?->package_name ?? 'Elite Business Alliance' }}" required>
                                                    </div>
                                                    <div class="row g-2 mb-3">
                                                        <div class="col-6">
                                                            <label class="form-label small fw-semibold">Proposals Quota</label>
                                                            <input type="number" name="proposals_quota" id="pkgQuota{{ $client->id }}" class="form-control" value="{{ $subscription?->proposals_quota ?? 25 }}" min="1" required>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label small fw-semibold">Validity (Months)</label>
                                                            <input type="number" name="validity_months" class="form-control" value="6" min="1" max="36" required>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2 mb-3">
                                                        <div class="col-6">
                                                            <label class="form-label small fw-semibold">Amount Paid (BDT)</label>
                                                            <input type="number" name="price_paid" id="pkgPrice{{ $client->id }}" class="form-control" value="{{ $subscription?->price_paid ?? 0 }}" min="0" required>
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 text-secondary mb-2 d-block"></i>
                                <div>No client accounts found matching the criteria.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clients->hasPages())
            <div class="card-footer bg-white py-3 border-top">
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
