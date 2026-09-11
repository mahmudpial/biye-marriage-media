@extends('member.layouts.app')

@section('title', 'আমার পছন্দের তালিকা (Shortlists) - Biye Marriage Media')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden" style="border: 1px solid rgba(201, 151, 56, 0.22) !important;">
            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h4 class="font-serif fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                        <i class="bi bi-bookmark-heart-fill text-danger"></i>
                        <span>আমার পছন্দের বায়োডাটা (Shortlists)</span>
                    </h4>
                    <p class="small text-muted mb-0">যেসব পাত্র-পাত্রীর প্রোফাইল আপনি পরবর্তীতে পর্যালোচনার জন্য সংরক্ষণ করেছেন।</p>
                </div>
                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-semibold border border-danger-subtle">
                    মোট সংরক্ষিত: {{ $shortlists->total() }} টি
                </span>
            </div>
        </div>

        <div class="row g-3">
            @forelse($shortlists as $shortlist)
                @php
                    $profile = $shortlist->candidateProfile;
                    $hasSent = in_array($profile->id, $sentProposalProfileIds);
                @endphp
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="match-card-royal h-100 p-3 text-center d-flex flex-column justify-content-between position-relative">
                        <div>
                            <!-- Top Badges -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                    <i class="bi bi-heart-fill text-danger me-0.5"></i>সংরক্ষিত
                                </span>
                                <span class="badge bg-light text-secondary border rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                    {{ $profile->gender === 'female' ? 'পাত্রী' : 'পাত্র' }}
                                </span>
                            </div>

                            <!-- Avatar with Luxury Ring -->
                            <div class="position-relative d-inline-block mx-auto mb-2.5">
                                <div class="match-avatar-ring">
                                    <img src="{{ $profile->resolved_image }}" 
                                         alt="{{ $profile->profile_code }}" 
                                         class="rounded-circle object-fit-cover {{ $profile->is_discreet ? 'blur-discreet' : '' }}">
                                </div>
                                
                                @if($profile->is_discreet)
                                    <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-dark p-1 border border-2 border-white" style="font-size: 0.62rem;" title="Discreet Photo Protected">
                                        <i class="bi bi-eye-slash-fill text-warning"></i>
                                    </span>
                                @else
                                    <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-primary p-1 border border-2 border-white" style="font-size: 0.62rem;" title="ভেরিফাইড প্রোফাইল">
                                        <i class="bi bi-patch-check-fill text-white"></i>
                                    </span>
                                @endif
                            </div>

                            <h6 class="fw-bold font-serif text-dark mb-1 fs-6">{{ $profile->profile_code }}</h6>
                            
                            <!-- Demographic Info (Single Line Capsule) -->
                            <div class="d-flex justify-content-center mb-2.5">
                                <div class="badge bg-light text-dark border border-light-subtle rounded-pill px-2.5 py-1 text-nowrap d-inline-flex align-items-center gap-1.5 shadow-2xs" style="font-size: 0.78rem; max-width: 100%;">
                                    <span class="fw-semibold">{{ $profile->age }} বছর</span>
                                    <span class="text-muted opacity-50">&bull;</span>
                                    <span>{{ $profile->height }}</span>
                                    <span class="text-muted opacity-50">&bull;</span>
                                    <span class="text-secondary text-truncate" style="max-width: 85px;" title="{{ $profile->desher_bari }}">
                                        <i class="bi bi-geo-alt-fill text-warning me-0.5"></i>{{ $profile->desher_bari }}
                                    </span>
                                </div>
                            </div>

                            <!-- Profession & Education -->
                            <div class="px-1 mb-3 text-center">
                                <div class="fw-bold text-dark text-truncate mb-1" style="font-size: 0.88rem;" title="{{ $profile->profession }}">
                                    <i class="bi bi-briefcase-fill text-warning me-1"></i>{{ $profile->profession }}
                                </div>
                                <div class="text-muted text-truncate" style="font-size: 0.78rem;" title="{{ $profile->education }}">
                                    <i class="bi bi-mortarboard-fill text-secondary me-1"></i>{{ $profile->education }}
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-center pt-2 border-top">
                            <form action="{{ route('member.shortlists.toggle', $profile) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                        style="width: 38px; height: 38px;" 
                                        title="শর্টলিস্ট থেকে সরান">
                                    <i class="bi bi-trash3 fs-6"></i>
                                </button>
                            </form>

                            @if($hasSent)
                                <span class="badge bg-success-subtle text-success rounded-pill d-inline-flex align-items-center justify-content-center gap-1 small w-100 fw-semibold" style="height: 38px; font-size: 0.76rem;">
                                    <i class="bi bi-check-all fs-6"></i> প্রস্তাব পাঠানো হয়েছে
                                </span>
                            @else
                                <button type="button" class="btn btn-elite-primary btn-sm rounded-pill px-3 py-2 small fw-semibold w-100 d-flex align-items-center justify-content-center gap-1.5 shadow-xs" data-bs-toggle="modal" data-bs-target="#sendProposalModal{{ $profile->id }}" style="height: 38px;">
                                    <i class="bi bi-send-fill text-warning"></i>
                                    <span>প্রস্তাব পাঠান</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal: Send Proposal -->
                <div class="modal fade" id="sendProposalModal{{ $profile->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden text-start">
                            <form action="{{ route('member.proposals.send', $profile) }}" method="POST">
                                @csrf
                                <div class="modal-header text-white" style="background: linear-gradient(135deg, #851829 0%, #520f1a 100%);">
                                    <h5 class="modal-title font-serif fw-bold d-flex align-items-center gap-2">
                                        <i class="bi bi-envelope-heart-fill text-warning"></i> বিয়ের প্রস্তাবনা পাঠান
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="d-flex align-items-center gap-3 mb-3 p-3 bg-light rounded-3 border">
                                        <img src="{{ $profile->resolved_image }}" class="rounded-circle object-fit-cover {{ $profile->is_discreet ? 'blur-discreet' : '' }}" style="width: 52px; height: 52px; border: 2px solid var(--theme-secondary);">
                                        <div>
                                            <div class="fw-bold font-serif text-dark fs-6">{{ $profile->profile_code }}</div>
                                            <div class="small text-muted">{{ $profile->age }} বছর &bull; {{ $profile->profession }} ({{ $profile->desher_bari }})</div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-dark">প্রাথমিক পারিবারিক বার্তা (ঐচ্ছিক)</label>
                                        <textarea name="message" class="form-control" rows="3" placeholder="শ্রদ্ধাভাজন অভিভাবক, আমরা আপনার প্রার্থীর বায়োডাটা দেখে সম্মানিত বোধ করেছি এবং পারিবারিক আলোচনার আগ্রহ প্রকাশ করছি..."></textarea>
                                    </div>
                                    <div class="alert alert-warning-subtle text-dark small py-2 px-3 mb-0 rounded-3 border border-warning-subtle d-flex align-items-center gap-2">
                                        <i class="bi bi-info-circle-fill text-warning fs-5"></i>
                                        <div>প্রস্তাব পাঠালে আপনার বর্তমান কোটা থেকে ১টি প্রস্তাবনা গণনা করা হবে।</div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">বাতিল</button>
                                    <button type="submit" class="btn btn-elite-primary rounded-pill px-4 fw-semibold">
                                        <i class="bi bi-send-fill me-1"></i> প্রস্তাব নিশ্চিত করুন
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center text-muted bg-white rounded-4 shadow-sm" style="border: 1px solid rgba(201, 151, 56, 0.22) !important;">
                    <i class="bi bi-bookmark-heart fs-1 text-secondary mb-2 d-block"></i>
                    <h5 class="fw-bold text-dark font-serif">আপনার শর্টলিস্ট বর্তমানে খালি</h5>
                    <p class="small mb-3">ডেইলি ম্যাচ বা বায়োডাটা ব্রাউজ করার সময় পছন্দের প্রোফাইলে হার্ট আইকনে ক্লিক করে সংরক্ষণ করুন।</p>
                    <a href="{{ route('member.matches') }}" class="btn btn-elite-primary btn-sm rounded-pill px-4 py-2">
                        <i class="bi bi-search-heart me-1"></i> ম্যাচমেকিং প্রোফাইল দেখুন
                    </a>
                </div>
            @endforelse
        </div>

        @if($shortlists->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $shortlists->links() }}
            </div>
        @endif
    </div>
</div>

<style>
/* Discreet Blur Styling */
.blur-discreet {
    filter: blur(6px);
    transition: filter 0.3s ease;
}

/* Match Card Royal */
.match-card-royal {
    background: #ffffff;
    border: 1px solid rgba(201, 151, 56, 0.22);
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03);
    transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.match-card-royal:hover {
    transform: translateY(-4px);
    border-color: rgba(201, 151, 56, 0.65);
    box-shadow: 0 12px 28px rgba(133, 24, 41, 0.08);
}

.match-avatar-ring {
    width: 86px;
    height: 86px;
    border-radius: 50%;
    padding: 3px;
    background: linear-gradient(135deg, #fef08a 0%, #c99738 50%, #851829 100%);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
}

.match-avatar-ring img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ffffff;
}
</style>
@endsection
