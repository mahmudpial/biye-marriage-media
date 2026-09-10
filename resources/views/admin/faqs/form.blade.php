@extends('admin.layouts.app')

@section('title', $isEdit ? "Edit FAQ: {$faq->question}" : 'Publish Matrimonial FAQ')
@section('page-title', $isEdit ? 'Edit FAQ' : 'New Matrimonial FAQ')

@push('styles')
<style>
    .form-card {
        background: #141820;
        background: linear-gradient(180deg, #171c26 0%, #131720 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 18px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.45);
        padding: 1.75rem 2rem;
    }

    .form-section-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #f8fafc;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding-bottom: 0.75rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }
    .form-section-title i {
        color: var(--accent-gold);
        font-size: 1.15rem;
    }

    .form-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--theme-secondary, #d4af37);
        margin-bottom: 0.4rem;
        letter-spacing: 0.3px;
    }

    .form-control, .form-select {
        background: #0d1117 !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        color: #f8fafc !important;
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--theme-secondary, #d4af37) !important;
        box-shadow: 0 0 0 3px rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.25) !important;
    }
    .form-control::placeholder {
        color: #64748b !important;
    }
    .form-select option {
        background: #0d1117 !important;
        color: #f8fafc !important;
    }
    .form-text, .text-muted-custom {
        color: #cbd5e1 !important;
    }

    /* Switches */
    .switch-card {
        background: #141820;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 1.15rem 1.25rem;
        margin-bottom: 1.15rem;
        transition: border-color 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
    }
    .switch-card:hover {
        border-color: rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.45);
        background: #171c26;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.35);
    }
    .switch-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.25rem;
    }
    .switch-card-info {
        flex: 1;
    }
    .switch-card-title {
        font-size: 0.92rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 0.2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    .switch-card-title i {
        color: var(--accent-gold);
    }
    .switch-card-desc {
        font-size: 0.76rem;
        color: #94a3b8;
        margin-bottom: 0;
        line-height: 1.4;
    }
    .custom-switch-control .form-check-input {
        width: 2.8rem;
        height: 1.45rem;
        cursor: pointer;
        background-color: #334155;
        border-color: #475569;
    }
    .custom-switch-control .form-check-input:checked {
        background-color: #22c55e;
        border-color: #16a34a;
    }

    /* Live Preview Box */
    .preview-box {
        background: #0d1117;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 1.25rem;
    }
    .preview-accordion-header {
        font-weight: 700;
        color: #f8fafc;
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }
    .preview-accordion-body {
        font-size: 0.85rem;
        color: #cbd5e1;
        line-height: 1.6;
        border-left: 2px solid var(--accent-gold);
        padding-left: 0.75rem;
    }

    /* Actions */
    .btn-admin-cancel {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #cbd5e1 !important;
        border-radius: 10px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    .btn-admin-cancel:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff !important;
        border-color: rgba(255, 255, 255, 0.2);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">

    <!-- Header & Back Navigation -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h4 class="mb-1 text-white fw-bold">
                {{ $isEdit ? "Edit FAQ #{$faq->id}" : 'Publish New Matrimonial FAQ' }}
            </h4>
            <p class="text-secondary small mb-0">
                Ensure answers convey dignity, verification standards, and Islamic family etiquette.
            </p>
        </div>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary px-3 py-2 d-inline-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i>
            <span>Back to FAQs List</span>
        </a>
    </div>

    <!-- Main Form -->
    <form method="POST" action="{{ $isEdit ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="row g-4">
            <!-- Left Column: Primary Question & Answer -->
            <div class="col-lg-8">
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-patch-question-fill"></i> Question &amp; Answer Content
                    </div>

                    <!-- Category Selector -->
                    <div class="mb-4">
                        <label for="category" class="form-label">Knowledgebase Category <span class="text-danger">*</span></label>
                        <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $catKey => $catLabel)
                                <option value="{{ $catKey }}" {{ old('category', $faq->category) === $catKey ? 'selected' : '' }}>
                                    {{ $catLabel }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text text-muted-custom small">Groups related questions for prospective family reviews.</div>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Question Input -->
                    <div class="mb-4">
                        <label for="question" class="form-label">Frequently Asked Question <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            name="question" 
                            id="question" 
                            class="form-control @error('question') is-invalid @enderror" 
                            placeholder="e.g. How does Biye Marriage Media ensure complete confidentiality in Bangladesh?"
                            value="{{ old('question', $faq->question) }}" 
                            maxlength="500" 
                            required
                        >
                        <div class="form-text text-muted-custom small">Write in clear, respectful, and articulate English or Bengali.</div>
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Answer Textarea -->
                    <div class="mb-3">
                        <label for="answer" class="form-label">Detailed Answer &amp; Policy Clarification <span class="text-danger">*</span></label>
                        <textarea 
                            name="answer" 
                            id="answer" 
                            rows="6" 
                            class="form-control @error('answer') is-invalid @enderror" 
                            placeholder="Detail the exact process, safety measures, relationship manager support, or documentation required..."
                            required
                        >{{ old('answer', $faq->answer) }}</textarea>
                        <div class="form-text text-muted-custom small">Detailed answers build strong trust with conservative and high-net-worth guardians.</div>
                        @error('answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Live Preview Card -->
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-eye-fill"></i> Live Homepage Accordion Preview
                    </div>
                    <div class="preview-box">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge rounded-pill px-2.5 py-1 small fw-bold" id="previewCategoryBadge" style="background: rgba(var(--theme-secondary-rgb, 212, 175, 55), 0.18); color: var(--accent-gold); border: 1px solid var(--border-gold);">
                                {{ $categories[$faq->category] ?? ($faq->category ?: 'General') }}
                            </span>
                            <span class="text-secondary small">Sort: #<span id="previewSortOrder">{{ $faq->sort_order ?? 1 }}</span></span>
                        </div>
                        <div class="preview-accordion-header" id="previewQuestion">
                            {{ $faq->question ?: 'Your question will appear here...' }}
                        </div>
                        <div class="preview-accordion-body" id="previewAnswer">
                            {{ $faq->answer ?: 'Your answer will be previewed here in real-time as you type.' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings, Sort Order & Actions -->
            <div class="col-lg-4">
                <div class="form-card mb-4">
                    <div class="form-section-title">
                        <i class="bi bi-sliders"></i> Publishing Controls
                    </div>

                    <!-- Sort Order -->
                    <div class="mb-4">
                        <label for="sort_order" class="form-label">Display Order Sequence</label>
                        <input 
                            type="number" 
                            name="sort_order" 
                            id="sort_order" 
                            class="form-control @error('sort_order') is-invalid @enderror" 
                            min="0" 
                            max="9999" 
                            value="{{ old('sort_order', $faq->sort_order ?? 1) }}"
                        >
                        <div class="form-text text-muted-custom small">Lower numbers appear first on the public website accordion.</div>
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Active Toggle Switch -->
                    <div class="switch-card mb-3">
                        <div class="switch-card-header">
                            <div class="switch-card-info">
                                <label class="switch-card-title" for="is_active">
                                    <i class="bi bi-globe"></i>
                                    <span>Public Website Status</span>
                                </label>
                                <p class="switch-card-desc">
                                    When active, this FAQ appears in the homepage accordion.
                                </p>
                            </div>
                            <div class="form-check form-switch custom-switch-control mb-0">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    role="switch" 
                                    id="is_active" 
                                    name="is_active" 
                                    value="1" 
                                    {{ old('is_active', $faq->is_active ?? true) ? 'checked' : '' }}
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit & Cancel Actions -->
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-admin-primary py-2.5 fw-bold fs-6">
                        <i class="bi bi-check2-circle me-1 fs-5"></i> {{ $isEdit ? 'Save FAQ Changes' : 'Publish Matrimonial FAQ' }}
                    </button>
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-admin-cancel py-2.5 fw-bold fs-6 text-center">
                        <i class="bi bi-x-circle me-1 fs-5"></i> Cancel &amp; Back
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Live preview sync
    const questionInput = document.getElementById('question');
    const answerInput = document.getElementById('answer');
    const categorySelect = document.getElementById('category');
    const sortOrderInput = document.getElementById('sort_order');

    const previewQuestion = document.getElementById('previewQuestion');
    const previewAnswer = document.getElementById('previewAnswer');
    const previewCategoryBadge = document.getElementById('previewCategoryBadge');
    const previewSortOrder = document.getElementById('previewSortOrder');

    questionInput.addEventListener('input', function() {
        previewQuestion.textContent = this.value.trim() || 'Your question will appear here...';
    });

    answerInput.addEventListener('input', function() {
        previewAnswer.textContent = this.value.trim() || 'Your answer will be previewed here in real-time as you type.';
    });

    categorySelect.addEventListener('change', function() {
        const selectedText = this.options[this.selectedIndex]?.text || 'General';
        previewCategoryBadge.textContent = selectedText.replace('-- Select Category --', 'General');
    });

    sortOrderInput.addEventListener('input', function() {
        previewSortOrder.textContent = this.value || '1';
    });
</script>
@endpush
@endsection
