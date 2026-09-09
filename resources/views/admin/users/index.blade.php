@extends('admin.layouts.app')

@section('title', 'Admin Staff & Matchmakers CMS')
@section('page-title', 'Staff & Matchmaker Accounts')

@push('styles')
<style>
    .users-wrapper {
        width: 100%;
    }

    /* Stat Pills */
    .stat-pill {
        background: #141820;
        background: linear-gradient(180deg, #171c26 0%, #131720 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        transition: transform 0.2s ease, border-color 0.2s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.35);
    }
    .stat-pill:hover {
        border-color: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.45);
        transform: translateY(-2px);
    }
    .stat-pill .num {
        font-size: 1.65rem;
        font-weight: 700;
        color: #f1f5f9;
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
        color: #f1f5f9;
        font-size: 0.76rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.35rem;
    }
    .filter-input, .filter-select {
        background: #0d1117 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #ffffff !important;
        font-size: 0.88rem;
        border-radius: 9px;
        padding: 0.55rem 0.85rem;
    }
    .filter-input:focus, .filter-select:focus {
        border-color: rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.6) !important;
        box-shadow: 0 0 0 0.2rem rgba(var(--theme-secondary-rgb, 201, 151, 56), 0.2) !important;
    }
    .filter-input::placeholder {
        color: rgba(255, 255, 255, 0.35) !important;
    }

    /* Table Container */
    .table-container {
        background: #141820;
        background: linear-gradient(180deg, #171c26 0%, #131720 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    }
    .table-users {
        min-width: 980px;
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }
    .table-users thead th {
        background: #10141d !important;
        color: #f1f5f9 !important;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 1rem 0.95rem;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1) !important;
        vertical-align: middle;
        white-space: nowrap;
    }
    .table-users tbody td {
        padding: 0.95rem;
        vertical-align: middle;
        background: transparent !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        color: #e2e8f0;
    }
    .table-users tbody tr {
        transition: background-color 0.15s ease;
    }
    .table-users tbody tr:hover {
        background: rgba(255, 255, 255, 0.03) !important;
    }

    /* User Avatar */
    .staff-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.05rem;
        color: #0b0206;
        background: linear-gradient(135deg, #fce07e 0%, #d4af37 100%);
        border: 2px solid rgba(212, 175, 55, 0.5);
        box-shadow: 0 2px 10px rgba(212, 175, 55, 0.25);
        flex-shrink: 0;
    }

    /* Role Badges */
    .badge-role {
        font-size: 0.74rem;
        padding: 0.35rem 0.65rem;
        border-radius: 8px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        white-space: nowrap;
        letter-spacing: 0.3px;
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

    /* Status Badges & Toggle */
    .btn-status-toggle {
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0.28rem 0.65rem;
        border-radius: 20px;
        font-size: 0.74rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        border: none;
    }
    .btn-status-toggle.active {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
        border: 1px solid rgba(34, 197, 94, 0.5);
    }
    .btn-status-toggle.active:hover {
        background: #22c55e;
        color: #0b0206;
        transform: scale(1.03);
    }
    .btn-status-toggle.inactive {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.5);
    }
    .btn-status-toggle.inactive:hover {
        background: #ef4444;
        color: #ffffff;
        transform: scale(1.03);
    }

    /* Action Buttons: 36px square */
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
    .btn-action-icon.disabled {
        opacity: 0.35;
        cursor: not-allowed;
        pointer-events: none;
    }

    .badge-you {
        font-size: 0.65rem;
        background: rgba(212, 175, 55, 0.2);
        color: #fde68a;
        border: 1px solid rgba(212, 175, 55, 0.4);
        padding: 0.15rem 0.45rem;
        border-radius: 6px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0 users-wrapper">

    <!-- Quick Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-pill d-flex align-items-center justify-content-between">
                <div>
                    <div class="num">{{ $stats['total'] }}</div>
                    <div class="label">Total Staff</div>
                </div>
                <div class="rounded-circle p-2" style="background: rgba(212, 175, 55, 0.15); color: var(--accent-gold);">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-pill d-flex align-items-center justify-content-between">
                <div>
                    <div class="num text-success">{{ $stats['active'] }}</div>
                    <div class="label">Active Accounts</div>
                </div>
                <div class="rounded-circle p-2" style="background: rgba(34, 197, 94, 0.15); color: #4ade80;">
                    <i class="bi bi-shield-check fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-pill d-flex align-items-center justify-content-between">
                <div>
                    <div class="num" style="color: #fde68a;">{{ $stats['super_admins'] }}</div>
                    <div class="label">Super Admins</div>
                </div>
                <div class="rounded-circle p-2" style="background: rgba(212, 175, 55, 0.2); color: #f5d061;">
                    <i class="bi bi-award-fill fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-pill d-flex align-items-center justify-content-between">
                <div>
                    <div class="num" style="color: #93c5fd;">{{ $stats['matchmakers'] }}</div>
                    <div class="label">Matchmakers</div>
                </div>
                <div class="rounded-circle p-2" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa;">
                    <i class="bi bi-heart-pulse-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="d-flex justify-content-end align-items-center mb-4">
        <a href="{{ route('admin.users.create') }}" class="btn btn-admin-primary px-3 py-2 fw-bold text-dark d-inline-flex align-items-center gap-2">
            <i class="bi bi-person-plus-fill"></i>
            <span>Add Team Member</span>
        </a>
    </div>

    <!-- Filter & Search Card -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="filter-label"><i class="bi bi-search me-1"></i> Search Name, Email, Phone</label>
                    <input type="text" name="search" class="form-control filter-input" placeholder="e.g. Shabnam, Gulshan, manager@..." value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="filter-label"><i class="bi bi-briefcase me-1"></i> Team Role</label>
                    <select name="role" class="form-select filter-select">
                        <option value="">All Roles</option>
                        @foreach($roles as $roleKey => $roleLabel)
                            <option value="{{ $roleKey }}" {{ ($filters['role'] ?? '') === $roleKey ? 'selected' : '' }}>
                                {{ $roleLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="filter-label"><i class="bi bi-toggle2-on me-1"></i> Account Status</label>
                    <select name="status" class="form-select filter-select">
                        <option value="">All Statuses</option>
                        <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active (Online)</option>
                        <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-admin-primary flex-grow-1 py-2 fw-bold text-dark">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>
                    @if(!empty($filters['search']) || !empty($filters['role']) || !empty($filters['status']))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-2 py-2" title="Reset Filters">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="table-container mb-4">
        <div class="table-responsive">
            <table class="table table-users align-middle">
                <thead>
                    <tr>
                        <th>Team Member</th>
                        <th style="width: 190px;">Assigned Role</th>
                        <th>Contact Details</th>
                        <th style="width: 130px;" class="text-center">Status</th>
                        <th style="width: 140px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $staff)
                        <tr>
                            <!-- User Name & Designation -->
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="staff-avatar">
                                        {{ strtoupper(substr($staff->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-white fs-6 d-flex align-items-center gap-2">
                                            <a href="{{ route('admin.users.show', $staff) }}" class="text-white text-decoration-none">
                                                {{ $staff->name }}
                                            </a>
                                            @if($staff->id === auth()->id())
                                                <span class="badge-you">You</span>
                                            @endif
                                        </div>
                                        <div class="small mt-0.5" style="color: #94a3b8;">
                                            {{ $staff->designation ?: 'Matchmaking Relationship Manager' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Role Badge -->
                            <td>
                                @php
                                    $roleClass = 'role-' . ($staff->role ?? 'relationship_manager');
                                @endphp
                                <span class="badge-role {{ $roleClass }}">
                                    @if($staff->role === 'super_admin')
                                        <i class="bi bi-shield-fill-check"></i>
                                    @elseif($staff->role === 'senior_matchmaker')
                                        <i class="bi bi-heart-fill"></i>
                                    @else
                                        <i class="bi bi-person-badge-fill"></i>
                                    @endif
                                    {{ $roles[$staff->role] ?? $staff->role_label }}
                                </span>
                            </td>

                            <!-- Contact Channels -->
                            <td>
                                <div class="small">
                                    <i class="bi bi-envelope text-gold me-1 opacity-75"></i>
                                    <a href="mailto:{{ $staff->email }}" class="text-white text-decoration-none">{{ $staff->email }}</a>
                                </div>
                                @if(!empty($staff->phone))
                                    <div class="small mt-1">
                                        <i class="bi bi-telephone-fill text-gold me-1 opacity-75"></i>
                                        <a href="tel:{{ $staff->phone }}" class="text-decoration-none" style="color: #cbd5e1;">{{ $staff->phone }}</a>
                                    </div>
                                @endif
                            </td>

                            <!-- Status Toggle -->
                            <td class="text-center">
                                @if($staff->id === auth()->id() || ($staff->email === 'admin@biyemedia.com' && $staff->is_active))
                                    <span class="btn-status-toggle active" style="cursor: default;" title="Self account cannot be deactivated">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>Active</span>
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('admin.users.toggle-active', $staff) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn-status-toggle {{ $staff->is_active ? 'active' : 'inactive' }}" title="Click to toggle active status">
                                            <i class="bi {{ $staff->is_active ? 'bi-check-circle-fill' : 'bi-slash-circle-fill' }}"></i>
                                            <span>{{ $staff->is_active ? 'Active' : 'Suspended' }}</span>
                                        </button>
                                    </form>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-1.5">
                                    <!-- View Details Button -->
                                    <a href="{{ route('admin.users.show', $staff) }}" class="btn-action-icon view" title="View Full Profile Details" data-bs-toggle="tooltip">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.users.edit', $staff) }}" class="btn-action-icon edit" title="Edit Staff Member" data-bs-toggle="tooltip">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    @if($staff->id === auth()->id() || $staff->email === 'admin@biyemedia.com')
                                        <button type="button" class="btn-action-icon delete disabled" title="Primary or self account cannot be deleted">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn-action-icon delete" title="Delete Staff Account" onclick="confirmDeleteUser({{ $staff->id }}, '{{ addslashes($staff->name) }}', '{{ addslashes($staff->email) }}')">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <div class="mb-3">
                                        <i class="bi bi-person-x text-secondary opacity-50" style="font-size: 3.5rem;"></i>
                                    </div>
                                    <h5 class="text-white fw-bold mb-2">No Staff Members Found</h5>
                                    <p class="text-secondary small mb-4" style="max-width: 440px; margin: 0 auto;">
                                        @if(!empty($filters['search']) || !empty($filters['role']) || !empty($filters['status']))
                                            No team members match your current filters. Try resetting search criteria.
                                        @else
                                            Expand your matrimonial operations by adding dedicated relationship managers for Gulshan, Banani, Sylhet, and Global NRB desks.
                                        @endif
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        @if(!empty($filters['search']) || !empty($filters['role']) || !empty($filters['status']))
                                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4 py-2">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.users.create') }}" class="btn btn-admin-primary px-4 py-2 fw-bold text-dark">
                                            <i class="bi bi-person-plus-fill me-1"></i> Add Team Member
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-3 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: rgba(0, 0, 0, 0.2);">
                <div class="text-muted small">
                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} team members
                </div>
                <div>
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #18030c; border: 1px solid rgba(239, 68, 68, 0.5); border-radius: 16px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2 text-danger">
                    <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    <h5 class="modal-title fw-bold text-white">Delete Staff Account</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-secondary pt-3">
                Are you sure you want to permanently delete the staff account for:
                <div class="p-3 my-2 rounded-3 border border-secondary border-opacity-25 text-white small" style="background: rgba(0,0,0,0.3);">
                    <div class="fw-bold" id="deleteUserName"></div>
                    <div class="text-secondary small" id="deleteUserEmail"></div>
                </div>
                <p class="small text-danger opacity-75 mt-2 mb-0">
                    <i class="bi bi-info-circle me-1"></i> This action cannot be undone. The staff member will immediately lose all access to the administration portal.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteUserForm" method="POST" action="">
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
    function confirmDeleteUser(userId, userName, userEmail) {
        const modalEl = document.getElementById('deleteUserModal');
        const formEl = document.getElementById('deleteUserForm');
        const nameEl = document.getElementById('deleteUserName');
        const emailEl = document.getElementById('deleteUserEmail');

        nameEl.textContent = userName;
        emailEl.textContent = userEmail;
        formEl.action = "{{ url('admin/users') }}/" + userId;

        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
</script>
@endpush
