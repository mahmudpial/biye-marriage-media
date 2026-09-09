@extends('admin.layouts.app')

@section('title', 'FAQs & Knowledgebase CMS')
@section('page-title', 'FAQs & Knowledgebase CMS')

@push('styles')
<style>
    .faqs-wrapper {
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
    .table-faqs {
        min-width: 950px;
        width: 100%;
        margin-bottom: 0;
        border-collapse: collapse;
    }
    .table-faqs thead th {
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
    .table-faqs tbody td {
        padding: 1rem 0.95rem;
        vertical-align: top;
        background: transparent !important;
        border-bottom: 1px solid rgba(212, 175, 55, 0.12);
        color: #e2e8f0;
    }
    .table-faqs tbody tr {
        transition: background-color 0.15s ease;
    }
    .table-faqs tbody tr:hover {
        background: rgba(212, 175, 55, 0.04) !important;
    }

    /* Category Badges */
    .badge-category {
        font-size: 0.75rem;
        padding: 0.35rem 0.65rem;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        white-space: nowrap;
    }
    .cat-Confidentiality {
        background: rgba(168, 85, 247, 0.2);
        color: #d8b4fe;
        border: 1px solid rgba(168, 85, 247, 0.4);
    }
    .cat-Verification {
        background: rgba(34, 197, 94, 0.2);
        color: #86efac;
        border: 1px solid rgba(34, 197, 94, 0.4);
    }
    .cat-NRB {
        background: rgba(59, 130, 246, 0.2);
        color: #93c5fd;
        border: 1px solid rgba(59, 130, 246, 0.4);
    }
    .cat-Membership {
        background: rgba(234, 179, 8, 0.2);
        color: #fde047;
        border: 1px solid rgba(234, 179, 8, 0.4);
    }
    .cat-Values {
        background: rgba(20, 184, 166, 0.2);
        color: #5eead4;
        border: 1px solid rgba(20, 184, 166, 0.4);
    }
    .cat-General {
        background: rgba(148, 163, 184, 0.2);
        color: #cbd5e1;
        border: 1px solid rgba(148, 163, 184, 0.4);
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

    .faq-answer-preview {
        font-size: 0.84rem;
        color: #94a3b8;
        line-height: 1.5;
        margin-top: 0.35rem;
    }
    .faq-order-badge {
        background: rgba(212, 175, 55, 0.15);
        color: #fde68a;
        border: 1px solid rgba(212, 175, 55, 0.35);
        font-size: 0.8rem;
        font-weight: 700;
        padding: 0.25rem 0.55rem;
        border-radius: 6px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0 faqs-wrapper">

    <!-- Quick Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-pill d-flex align-items-center justify-content-between">
                <div>
                    <div class="num">{{ $stats['total'] }}</div>
                    <div class="label">Total Questions</div>
                </div>
                <div class="rounded-circle p-2" style="background: rgba(212, 175, 55, 0.15); color: var(--accent-gold);">
                    <i class="bi bi-question-diamond-fill fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-pill d-flex align-items-center justify-content-between">
                <div>
                    <div class="num text-success">{{ $stats['active'] }}</div>
                    <div class="label">Active Published</div>
                </div>
                <div class="rounded-circle p-2" style="background: rgba(34, 197, 94, 0.15); color: #4ade80;">
                    <i class="bi bi-check-circle-fill fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-pill d-flex align-items-center justify-content-between">
                <div>
                    <div class="num text-warning">{{ $stats['inactive'] }}</div>
                    <div class="label">Drafts / Hidden</div>
                </div>
                <div class="rounded-circle p-2" style="background: rgba(234, 179, 8, 0.15); color: #facc15;">
                    <i class="bi bi-eye-slash-fill fs-4"></i>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-pill d-flex align-items-center justify-content-between">
                <div>
                    <div class="num" style="color: #93c5fd;">{{ $stats['categories_count'] }}</div>
                    <div class="label">Categories</div>
                </div>
                <div class="rounded-circle p-2" style="background: rgba(59, 130, 246, 0.15); color: #60a5fa;">
                    <i class="bi bi-tags-fill fs-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Actions Bar -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h4 class="mb-1 text-white fw-bold">Matrimonial FAQs &amp; Knowledgebase</h4>
            <p class="text-secondary small mb-0">Manage trust, confidentiality, and process clarifications displayed on the public site.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.faqs.create') }}" class="btn btn-admin-primary px-3 py-2 fw-bold text-dark d-inline-flex align-items-center gap-2">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Publish New FAQ</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('admin.faqs.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="filter-label"><i class="bi bi-search me-1"></i> Search Question / Answer</label>
                    <input type="text" name="search" class="form-control filter-input" placeholder="e.g. confidentiality, verification, fees, NRB..." value="{{ $filters['search'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="filter-label"><i class="bi bi-tag me-1"></i> Category</label>
                    <select name="category" class="form-select filter-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $catKey => $catLabel)
                            <option value="{{ $catKey }}" {{ ($filters['category'] ?? '') === $catKey ? 'selected' : '' }}>
                                {{ $catLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="filter-label"><i class="bi bi-toggle2-on me-1"></i> Status</label>
                    <select name="status" class="form-select filter-select">
                        <option value="">All Statuses</option>
                        <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Published (Active)</option>
                        <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>Hidden (Draft)</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-admin-primary flex-grow-1 py-2 fw-bold text-dark">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>
                    @if(!empty($filters['search']) || !empty($filters['category']) || !empty($filters['status']))
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary px-2 py-2" title="Reset Filters">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- FAQs Table -->
    <div class="table-container mb-4">
        <div class="table-responsive">
            <table class="table table-faqs align-middle">
                <thead>
                    <tr>
                        <th style="width: 70px;" class="text-center">Order</th>
                        <th>Question &amp; Answer Excerpt</th>
                        <th style="width: 170px;">Category</th>
                        <th style="width: 130px;" class="text-center">Status</th>
                        <th style="width: 110px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                        <tr>
                            <!-- Order -->
                            <td class="text-center">
                                <span class="faq-order-badge">#{{ $faq->sort_order }}</span>
                            </td>

                            <!-- Question & Answer Excerpt -->
                            <td>
                                <div class="fw-bold text-white fs-6 mb-1 d-flex align-items-center gap-2">
                                    <i class="bi bi-patch-question text-gold"></i>
                                    <span>{{ $faq->question }}</span>
                                </div>
                                <div class="faq-answer-preview">
                                    {{ Str::limit($faq->answer, 140) }}
                                </div>
                            </td>

                            <!-- Category -->
                            <td>
                                @php
                                    $catClass = match(true) {
                                        str_contains($faq->category, 'Confidentiality') => 'cat-Confidentiality',
                                        str_contains($faq->category, 'Verification') => 'cat-Verification',
                                        str_contains($faq->category, 'NRB') => 'cat-NRB',
                                        str_contains($faq->category, 'Membership') => 'cat-Membership',
                                        str_contains($faq->category, 'Values') || str_contains($faq->category, 'Shariah') => 'cat-Values',
                                        default => 'cat-General',
                                    };
                                @endphp
                                <span class="badge-category {{ $catClass }}">
                                    <i class="bi bi-tag-fill"></i>
                                    {{ $categories[$faq->category] ?? $faq->category }}
                                </span>
                            </td>

                            <!-- Status Toggle -->
                            <td class="text-center">
                                <form method="POST" action="{{ route('admin.faqs.toggle-active', $faq) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-status-toggle {{ $faq->is_active ? 'active' : 'inactive' }}" title="Click to toggle status">
                                        <i class="bi {{ $faq->is_active ? 'bi-check-circle-fill' : 'bi-eye-slash-fill' }}"></i>
                                        <span>{{ $faq->is_active ? 'Published' : 'Hidden' }}</span>
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn-action-icon edit" title="Edit FAQ" data-bs-toggle="tooltip">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <button type="button" class="btn-action-icon delete" title="Delete FAQ" onclick="confirmDeleteFaq({{ $faq->id }}, '{{ addslashes($faq->question) }}')">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <div class="mb-3">
                                        <i class="bi bi-question-circle text-secondary opacity-50" style="font-size: 3.5rem;"></i>
                                    </div>
                                    <h5 class="text-white fw-bold mb-2">No Frequently Asked Questions Found</h5>
                                    <p class="text-secondary small mb-4" style="max-width: 440px; margin: 0 auto;">
                                        @if(!empty($filters['search']) || !empty($filters['category']) || !empty($filters['status']))
                                            No FAQs match your current filters. Try resetting the search terms.
                                        @else
                                            Build trust with prospective families by publishing common inquiries regarding confidentiality, pedigree checks, and process etiquette.
                                        @endif
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        @if(!empty($filters['search']) || !empty($filters['category']) || !empty($filters['status']))
                                            <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary px-4 py-2">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filters
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.faqs.create') }}" class="btn btn-admin-primary px-4 py-2 fw-bold text-dark">
                                            <i class="bi bi-plus-circle-fill me-1"></i> Publish First FAQ
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($faqs->hasPages())
            <div class="p-3 border-top border-secondary border-opacity-25 d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: rgba(0, 0, 0, 0.2);">
                <div class="text-muted small">
                    Showing {{ $faqs->firstItem() }} to {{ $faqs->lastItem() }} of {{ $faqs->total() }} questions
                </div>
                <div>
                    {{ $faqs->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteFaqModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #18030c; border: 1px solid rgba(239, 68, 68, 0.5); border-radius: 16px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6);">
            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2 text-danger">
                    <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    <h5 class="modal-title fw-bold text-white">Delete FAQ</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-secondary pt-3">
                Are you sure you want to permanently delete this question?
                <div class="p-3 my-2 rounded-3 border border-secondary border-opacity-25 text-white fst-italic small" id="deleteFaqQuestion" style="background: rgba(0,0,0,0.3);"></div>
                <p class="small text-danger opacity-75 mt-2 mb-0">
                    <i class="bi bi-info-circle me-1"></i> This action cannot be undone. The question will be removed immediately from the public website accordion.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteFaqForm" method="POST" action="">
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
    function confirmDeleteFaq(faqId, questionText) {
        const modalEl = document.getElementById('deleteFaqModal');
        const formEl = document.getElementById('deleteFaqForm');
        const questionEl = document.getElementById('deleteFaqQuestion');

        questionEl.textContent = questionText;
        formEl.action = "{{ url('admin/faqs') }}/" + faqId;

        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
</script>
@endpush
