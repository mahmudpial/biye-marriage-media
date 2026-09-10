@extends('member.layouts.app')

@section('title', 'ডেইলি স্মার্ট ম্যাচ - Biye Marriage Media')

@section('content')
<div class="row g-4">
    <!-- Filter Card -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-3 p-md-4">
                <form action="{{ route('member.matches') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-semibold text-muted mb-1">পেশা দিয়ে সার্চ</label>
                        <input type="text" name="profession" value="{{ request('profession') }}" class="form-control bg-light" placeholder="e.g. Doctor, Engineer, BCS">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold text-muted mb-1">দেশের বাড়ি (জেলা)</label>
                        <input type="text" name="desher_bari" value="{{ request('desher_bari') }}" class="form-control bg-light" placeholder="e.g. Dhaka, Sylhet">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold text-muted mb-1">ধর্ম</label>
                        <select name="religion" class="form-select bg-light">
                            <option value="">সকল ধর্ম</option>
                            <option value="Islam (Sunni)" {{ request('religion') === 'Islam (Sunni)' ? 'selected' : '' }}>Islam (Sunni)</option>
                            <option value="Hinduism" {{ request('religion') === 'Hinduism' ? 'selected' : '' }}>Hinduism</option>
                            <option value="Christianity" {{ request('religion') === 'Christianity' ? 'selected' : '' }}>Christianity</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold text-muted mb-1">সর্বনিম্ন বয়স</label>
                        <input type="number" name="age_min" value="{{ request('age_min') }}" class="form-control bg-light" placeholder="18" min="18" max="75">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold text-muted mb-1">সর্বোচ্চ বয়স</label>
                        <input type="number" name="age_max" value="{{ request('age_max') }}" class="form-control bg-light" placeholder="45" min="18" max="75">
                    </div>
                    <div class="col-12 col-md-1 d-flex align-items-end pt-3 pt-md-0">
                        <button type="submit" class="btn btn-dark w-100 py-2">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Candidates Grid -->
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold font-serif text-dark mb-0">
                <i class="bi bi-people-fill text-maroon me-2"></i>প্রস্তাবিত বায়োডাটা তালিকা ({{ $profiles->total() }})
            </h5>
            <div class="small text-muted">
                দেখাচ্ছে {{ $profiles->firstItem() ?? 0 }} - {{ $profiles->lastItem() ?? 0 }}
            </div>
        </div>

        <div class="row g-3">
            @forelse($profiles as $profile)
                @php
                    $isShortlisted = in_array($profile->id, $shortlistedProfileIds);
                    $hasSentProposal = in_array($profile->id, $sentProposalProfileIds);
                @endphp
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white hover-shadow position-relative">
                        <div class="position-relative d-inline-block mx-auto mb-3">
                            <img src="{{ $profile->resolved_image }}" 
                                 alt="{{ $profile->profile_code }}" 
                                 class="rounded-circle object-fit-cover shadow-sm {{ $profile->is_discreet ? 'blur-discreet' : '' }}" 
                                 style="width: 90px; height: 90px; border: 2.5px solid #851829;">
                            @if($profile->is_discreet)
                                <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-dark" style="font-size: 0.65rem;" title="Discreet Photo Protected">
                                    <i class="bi bi-eye-slash-fill"></i>
                                </span>
                            @endif
                        </div>
                        <h6 class="fw-bold font-serif text-dark mb-1">{{ $profile->profile_code }}</h6>
                        <div class="small text-muted mb-2">
                            {{ ucfirst($profile->gender) }}, {{ $profile->age }} বছর, {{ $profile->height }}
                        </div>
                        <div class="badge bg-light text-maroon border mb-2">{{ $profile->category }}</div>
                        <div class="small text-dark fw-semibold text-truncate mb-1" title="{{ $profile->profession }}">
                            {{ $profile->profession }}
                        </div>
                        <div class="small text-secondary text-truncate mb-2" style="font-size: 0.8rem;" title="{{ $profile->education }}">
                            {{ $profile->education }}
                        </div>
                        <div class="small text-muted mb-3" style="font-size: 0.78rem;">
                            <i class="bi bi-geo-alt text-danger me-1"></i>দেশের বাড়ি: {{ $profile->desher_bari }}
                        </div>

                        <div class="d-flex gap-2 justify-content-center mt-auto pt-2 border-top">
                            <form action="{{ route('member.shortlists.toggle', $profile) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $isShortlisted ? 'btn-danger' : 'btn-outline-danger' }} rounded-circle p-2" title="{{ $isShortlisted ? 'শর্টলিস্ট থেকে মুছুন' : 'শর্টলিস্ট করুন' }}">
                                    <i class="bi bi-heart{{ $isShortlisted ? '-fill' : '' }}"></i>
                                </button>
                            </form>

                            @if($hasSentProposal)
                                <span class="badge bg-success-subtle text-success py-2 px-3 rounded-pill d-inline-flex align-items-center gap-1 small">
                                    <i class="bi bi-check-all"></i> প্রস্তাব পাঠানো হয়েছে
                                </span>
                            @else
                                <button type="button" class="btn btn-elite-primary btn-sm rounded-pill px-3.5 small" data-bs-toggle="modal" data-bs-target="#sendProposalModal{{ $profile->id }}">
                                    <i class="bi bi-send-fill me-1"></i> প্রস্তাব পাঠান
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal: Send Proposal -->
                <div class="modal fade" id="sendProposalModal{{ $profile->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content text-start">
                            <form action="{{ route('member.proposals.send', $profile) }}" method="POST">
                                @csrf
                                <div class="modal-header bg-maroon text-white">
                                    <h5 class="modal-title font-serif fw-bold">
                                        <i class="bi bi-envelope-heart-fill me-2 text-gold"></i>বিয়ের প্রস্তাবনা পাঠান
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="d-flex align-items-center gap-3 mb-3 p-2 bg-light rounded-3">
                                        <img src="{{ $profile->resolved_image }}" class="rounded-circle object-fit-cover {{ $profile->is_discreet ? 'blur-discreet' : '' }}" style="width: 50px; height: 50px;">
                                        <div>
                                            <div class="fw-bold text-dark">{{ $profile->profile_code }}</div>
                                            <div class="small text-muted">{{ $profile->age }} বছর, {{ $profile->profession }} ({{ $profile->desher_bari }})</div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold">পারিবারিক বার্তা (ঐচ্ছিক)</label>
                                        <textarea name="message" class="form-control" rows="3" placeholder="শ্রদ্ধাভাজন অভিভাবক, আমরা আপনার প্রার্থীর বায়োডাটা দেখে সম্মানিত বোধ করেছি এবং পারিবারিক আলোচনার আগ্রহ প্রকাশ করছি..."></textarea>
                                    </div>
                                    <div class="alert alert-info small py-2 mb-0">
                                        <i class="bi bi-info-circle me-1"></i> প্রস্তাব পাঠালে আপনার বর্তমান কোটা থেকে ১টি প্রস্তাবনা গণনা করা হবে।
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">বাতিল</button>
                                    <button type="submit" class="btn btn-elite-primary px-4 fw-semibold">প্রস্তাব নিশ্চিত করুন</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center text-muted">
                    <i class="bi bi-search fs-1 text-secondary mb-2 d-block"></i>
                    <h5>কোনো বায়োডাটা পাওয়া যায়নি</h5>
                    <p class="small">আপনার সার্চ ফিল্টার পরিবর্তন করে পুনরায় চেষ্টা করুন।</p>
                </div>
            @endforelse
        </div>

        @if($profiles->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $profiles->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.blur-discreet {
    filter: blur(6px);
}
.hover-shadow {
    transition: all 0.2s ease;
}
.hover-shadow:hover {
    box-shadow: 0 10px 25px rgba(133, 24, 41, 0.09) !important;
    transform: translateY(-2px);
}
</style>
@endsection
