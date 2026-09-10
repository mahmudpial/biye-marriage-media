@extends('member.layouts.app')

@section('title', 'আমার পছন্দের তালিকা (Shortlists) - Biye Marriage Media')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="font-serif fw-bold text-dark mb-1">
                        <i class="bi bi-bookmark-heart-fill text-danger me-2"></i>আমার পছন্দের বায়োডাটা (Shortlists)
                    </h4>
                    <p class="small text-muted mb-0">যেসব পাত্র-পাত্রীর প্রোফাইল আপনি পরবর্তীতে পর্যালোচনার জন্য সংরক্ষণ করেছেন।</p>
                </div>
                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-semibold">
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
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-3 text-center bg-white">
                        <div class="position-relative d-inline-block mx-auto mb-3">
                            <img src="{{ $profile->resolved_image }}" 
                                 alt="{{ $profile->profile_code }}" 
                                 class="rounded-circle object-fit-cover shadow-sm {{ $profile->is_discreet ? 'blur-discreet' : '' }}" 
                                 style="width: 85px; height: 85px; border: 2px solid #851829;">
                        </div>
                        <h6 class="fw-bold font-serif text-dark mb-1">{{ $profile->profile_code }}</h6>
                        <div class="small text-muted mb-2">
                            {{ ucfirst($profile->gender) }}, {{ $profile->age }} বছর | {{ $profile->height }}
                        </div>
                        <div class="small text-dark fw-semibold text-truncate mb-1" title="{{ $profile->profession }}">
                            {{ $profile->profession }}
                        </div>
                        <div class="small text-secondary mb-3">
                            <i class="bi bi-geo-alt text-danger me-0.5"></i>{{ $profile->desher_bari }}
                        </div>

                        <div class="d-flex gap-2 justify-content-center mt-auto pt-2 border-top">
                            <form action="{{ route('member.shortlists.toggle', $profile) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-3" title="মুছে ফেলুন">
                                    <i class="bi bi-trash3 me-1 text-danger"></i> সরান
                                </button>
                            </form>

                            @if($hasSent)
                                <span class="badge bg-success-subtle text-success py-2 px-3 rounded-pill small">
                                    <i class="bi bi-check-all"></i> প্রস্তাব পাঠানো হয়েছে
                                </span>
                            @else
                                <button type="button" class="btn btn-elite-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#sendProposalModal{{ $profile->id }}">
                                    <i class="bi bi-send-fill me-1"></i> প্রস্তাব
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
                <div class="col-12 py-5 text-center text-muted bg-white rounded-4 shadow-sm">
                    <i class="bi bi-bookmark-heart fs-1 text-secondary mb-2 d-block"></i>
                    <h5>আপনার শর্টলিস্ট বর্তমানে খালি</h5>
                    <p class="small mb-3">ডেইলি ম্যাচ বা বায়োডাটা ব্রাউজ করার সময় পছন্দের প্রোফাইলে হার্ট আইকনে ক্লিক করে সংরক্ষণ করুন।</p>
                    <a href="{{ route('member.matches') }}" class="btn btn-elite-primary btn-sm rounded-pill px-4">
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
.blur-discreet {
    filter: blur(6px);
}
</style>
@endsection
