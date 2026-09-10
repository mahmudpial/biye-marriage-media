@extends('member.layouts.app')

@section('title', 'সদস্য ড্যাশবোর্ড - Biye Marriage Media')

@section('content')
<div class="row g-4">
    <!-- Welcome Banner & Completion Progress -->
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden text-white" style="background: linear-gradient(135deg, #851829 0%, #4a0d17 100%);">
            <div class="card-body p-4 p-md-5 position-relative">
                <div class="row align-items-center g-4">
                    <div class="col-12 col-lg-8">
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 text-white small mb-3 border border-white border-opacity-10">
                            <i class="bi bi-shield-check text-gold"></i>
                            <span>১০০% গোপনীয় ও বিশ্বস্ত এলিট ম্যাচমেকিং সার্ভিস</span>
                        </div>
                        <h2 class="font-serif fw-bold mb-2">
                            আসসালামু আলাইকুম, {{ $user->name }}!
                        </h2>
                        <p class="text-white-50 mb-4" style="max-width: 600px;">
                            Biye Marriage Media-তে আপনার পাত্র/পাত্রীর জন্য উপযুক্ত দ্বীনদার ও সমমর্যাদার পারিবারিক জীবনসঙ্গী খুঁজে পেতে আমরা আন্তরিকভাবে নিবেদিত।
                        </p>

                        <!-- Completion Meter -->
                        <div class="p-3 rounded-3 bg-black bg-opacity-20 border border-white border-opacity-10" style="max-width: 540px;">
                            <div class="d-flex justify-content-between align-items-center mb-2 small">
                                <span class="text-white-50">বায়োডাটা পূরণের অগ্রগতি:</span>
                                <strong class="text-white">{{ $candidateProfile->completion_score }}% সম্পন্ন</strong>
                            </div>
                            <div class="progress mb-3" style="height: 10px; background-color: rgba(255,255,255,0.15);">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $candidateProfile->completion_score }}%" aria-valuenow="{{ $candidateProfile->completion_score }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('member.biodata.edit') }}" class="btn btn-warning btn-sm rounded-pill px-4 fw-semibold text-dark">
                                    <i class="bi bi-pencil-square me-1"></i> বায়োডাটা সম্পূর্ণ করুন &rarr;
                                </a>
                                <a href="{{ route('member.matches') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                                    <i class="bi bi-search-heart me-1"></i> ম্যাচ খুঁজুন
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Avatar & Badges -->
                    <div class="col-12 col-lg-4 text-lg-end">
                        <div class="d-inline-block text-center p-3 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10">
                            <div class="position-relative d-inline-block mb-2">
                                <img src="{{ $candidateProfile->resolved_image }}" alt="{{ $user->name }}" class="rounded-circle shadow object-fit-cover border border-3 border-white" style="width: 90px; height: 90px;">
                                @if($user->isVerified())
                                    <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-primary border border-white p-1" title="অফিসিয়াল ব্লু ভেরিফাইড সিল">
                                        <i class="bi bi-patch-check-fill fs-6"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="fw-bold font-serif text-white fs-6 mb-1">{{ $candidateProfile->profile_code }}</div>
                            <div class="badge bg-white text-maroon rounded-pill px-3 py-1 small fw-semibold">
                                {{ ucfirst($candidateProfile->gender) }}, {{ $candidateProfile->age }} বছর
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="col-6 col-md-3">
        <a href="{{ route('member.shortlists') }}" class="text-decoration-none">
            <div class="stat-card-member p-3 p-md-4 text-center">
                <div class="rounded-circle bg-danger-subtle text-danger mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.3rem;">
                    <i class="bi bi-bookmark-heart-fill"></i>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $shortlistsCount }}</h3>
                <div class="small text-muted">পছন্দের তালিকা (Shortlist)</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('member.proposals') }}" class="text-decoration-none">
            <div class="stat-card-member p-3 p-md-4 text-center">
                <div class="rounded-circle bg-primary-subtle text-primary mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.3rem;">
                    <i class="bi bi-send-check-fill"></i>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $sentProposalsCount }}</h3>
                <div class="small text-muted">পাঠানো প্রস্তাবনা (Sent)</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('member.proposals') }}" class="text-decoration-none">
            <div class="stat-card-member p-3 p-md-4 text-center position-relative">
                @if($pendingReceivedCount > 0)
                    <span class="position-absolute top-0 end-0 m-2 badge rounded-pill bg-danger">
                        {{ $pendingReceivedCount }} নতুন
                    </span>
                @endif
                <div class="rounded-circle bg-success-subtle text-success mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.3rem;">
                    <i class="bi bi-inbox-fill"></i>
                </div>
                <h3 class="fw-bold text-dark mb-0">{{ $receivedProposalsCount }}</h3>
                <div class="small text-muted">আগত আগ্রহ (Received)</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card-member p-3 p-md-4 text-center">
            <div class="rounded-circle bg-warning-subtle text-warning mx-auto mb-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.3rem;">
                <i class="bi bi-gem"></i>
            </div>
            <h3 class="fw-bold text-dark mb-0">
                {{ $activeSubscription ? $activeSubscription->remainingProposals() : 0 }}
            </h3>
            <div class="small text-muted">অবশিষ্ট প্রপোজাল কোটা</div>
        </div>
    </div>

    <!-- Assigned Relationship Manager Helpdesk & Photo Privacy Card -->
    <div class="col-12 col-lg-8">
        <!-- Relationship Manager Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-8">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-maroon text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" style="width: 58px; height: 58px; font-size: 1.4rem;">
                                {{ strtoupper(substr($relationshipManager?->name ?? 'M', 0, 1)) }}
                            </div>
                            <div>
                                <span class="badge bg-gold-subtle text-gold small px-2 py-0.5 rounded-pill mb-1">
                                    আপনার ব্যক্তিগত রিলেশনশিপ ম্যানেজার
                                </span>
                                <h5 class="fw-bold text-dark mb-0 font-serif">{{ $relationshipManager?->name ?? 'সিনিয়র ম্যাচমেকার টিম' }}</h5>
                                <div class="small text-muted">{{ $relationshipManager?->designation ?? 'গুলশান ও আন্তর্জাতিক ডেস্কে সিনিয়র ম্যাচমেকিং এক্সিকিউটিভ' }}</div>
                            </div>
                        </div>
                        <p class="small text-secondary mt-3 mb-0">
                            পাত্র-পাত্রী পছন্দ হলে বা পরিবারের সাথে সরাসরি কথা বলতে আপনার ম্যাচমেকারের সাথে নিশ্চিন্তে পরামর্শ করুন।
                        </p>
                    </div>
                    <div class="col-12 col-md-4 text-md-end">
                        <div class="d-flex flex-column gap-2">
                            <a href="tel:{{ $relationshipManager?->phone ?? '+8801577723404' }}" class="btn btn-outline-dark btn-sm rounded-pill py-2">
                                <i class="bi bi-telephone-fill me-1.5 text-maroon"></i> সরাসরি কল করুন
                            </a>
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $relationshipManager?->phone ?? '8801577723404');
                            @endphp
                            <a href="https://wa.me/{{ $cleanPhone }}?text=Hello%2C%20I%20am%20member%20{{ urlencode($user->name) }}%20(Code%3A%20{{ $candidateProfile->profile_code }}).%20I%20need%20assistance%20regarding%20matchmaking." 
                               target="_blank" 
                               class="btn btn-success btn-sm rounded-pill py-2 fw-semibold">
                                <i class="bi bi-whatsapp me-1.5"></i> WhatsApp মেসেজ
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Smart Matches -->
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-white py-3.5 border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold text-dark mb-0 font-serif">
                        <i class="bi bi-stars text-gold me-2"></i>আপনার জন্য প্রস্তাবিত ম্যাচ (Daily Matches)
                    </h5>
                    <div class="small text-muted">আপনার প্রত্যাশা ও বিপরীত লিঙ্গের বায়োডাটা অনুযায়ী নির্বাচিত</div>
                </div>
                <a href="{{ route('member.matches') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    সব দেখুন &rarr;
                </a>
            </div>
            <div class="card-body p-3 p-md-4">
                <div class="row g-3">
                    @forelse($recommendedProfiles as $match)
                        @php
                            $isShortlisted = in_array($match->id, $shortlistedProfileIds);
                        @endphp
                        <div class="col-12 col-sm-6 col-xl-4">
                            <div class="card h-100 border rounded-3 p-3 text-center shadow-none hover-shadow">
                                <div class="position-relative d-inline-block mx-auto mb-2">
                                    <img src="{{ $match->resolved_image }}" 
                                         alt="Candidate" 
                                         class="rounded-circle object-fit-cover shadow-sm {{ $match->is_discreet ? 'blur-discreet' : '' }}" 
                                         style="width: 76px; height: 76px; border: 2px solid #851829;">
                                    @if($match->is_discreet)
                                        <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-dark" style="font-size: 0.6rem;" title="Discreet Photo">
                                            <i class="bi bi-eye-slash-fill"></i>
                                        </span>
                                    @endif
                                </div>
                                <h6 class="fw-bold font-serif text-dark mb-1">{{ $match->profile_code }}</h6>
                                <div class="small text-muted mb-2">
                                    {{ $match->age }} বছর, {{ $match->height }} | {{ $match->desher_bari }}
                                </div>
                                <div class="small text-dark fw-medium text-truncate mb-1" title="{{ $match->profession }}">
                                    {{ $match->profession }}
                                </div>
                                <div class="small text-secondary text-truncate mb-3" style="font-size: 0.78rem;" title="{{ $match->education }}">
                                    {{ $match->education }}
                                </div>

                                <div class="d-flex gap-1.5 justify-content-center mt-auto">
                                    <form action="{{ route('member.shortlists.toggle', $match) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $isShortlisted ? 'btn-danger' : 'btn-outline-danger' }} rounded-circle p-2" title="{{ $isShortlisted ? 'শর্টলিস্ট থেকে মুছুন' : 'শর্টলিস্টে রাখুন' }}">
                                            <i class="bi bi-heart{{ $isShortlisted ? '-fill' : '' }}"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-elite-primary btn-sm rounded-pill px-3 small" data-bs-toggle="modal" data-bs-target="#sendProposalModal{{ $match->id }}">
                                        <i class="bi bi-send-fill me-1"></i> প্রস্তাব পাঠান
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal: Send Proposal -->
                        <div class="modal fade" id="sendProposalModal{{ $match->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content text-start">
                                    <form action="{{ route('member.proposals.send', $match) }}" method="POST">
                                        @csrf
                                        <div class="modal-header bg-maroon text-white">
                                            <h5 class="modal-title font-serif fw-bold">
                                                <i class="bi bi-envelope-heart-fill me-2 text-gold"></i>বিয়ের প্রস্তাবনা পাঠান
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="d-flex align-items-center gap-3 mb-3 p-2 bg-light rounded-3">
                                                <img src="{{ $match->resolved_image }}" class="rounded-circle object-fit-cover {{ $match->is_discreet ? 'blur-discreet' : '' }}" style="width: 50px; height: 50px;">
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $match->profile_code }}</div>
                                                    <div class="small text-muted">{{ $match->age }} বছর, {{ $match->profession }} ({{ $match->desher_bari }})</div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold">প্রাথমিক পারিবারিক বার্তা (ঐচ্ছিক)</label>
                                                <textarea name="message" class="form-control" rows="3" placeholder="শ্রদ্ধাভাজন অভিভাবক, আমরা আপনার প্রার্থীর বায়োডাটা দেখে সম্মানিত বোধ করেছি এবং পারিবারিক আলোচনার আগ্রহ প্রকাশ করছি..."></textarea>
                                            </div>
                                            <div class="alert alert-info small py-2 mb-0">
                                                <i class="bi bi-info-circle me-1"></i> প্রস্তাব পাঠানোর পর আপনার দায়িত্বপ্রাপ্ত ম্যাচমেকার অপর পরিবারের সাথে আলোচনা করে অগ্রগতি জানাবেন।
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">বাতিল</button>
                                            <button type="submit" class="btn btn-elite-primary px-4 fw-semibold">
                                                প্রস্তাব নিশ্চিত করুন
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-4 text-center text-muted">
                            <i class="bi bi-stars fs-2 d-block text-secondary mb-2"></i>
                            <div>বর্তমানে আপনার ক্যাটাগরিতে নতুন কোনো বায়োডাটা নেই। শীঘ্রই নতুন প্রোফাইল যোগ হবে।</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Privacy & Account Status -->
    <div class="col-12 col-lg-4">
        <!-- Photo Privacy Vault Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold text-dark mb-0 font-serif">
                    <i class="bi bi-shield-lock-fill text-maroon me-2"></i>গোপনীয়তা ও ফটো ভল্ট
                </h6>
            </div>
            <div class="card-body p-4 text-center">
                <div class="mb-3">
                    @if($candidateProfile->is_discreet)
                        <div class="rounded-circle bg-dark-subtle text-dark mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 64px; height: 64px; font-size: 1.8rem;">
                            <i class="bi bi-eye-slash-fill"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">Discreet Mode চালু আছে</h6>
                        <p class="small text-muted mb-3">
                            আপনার ছবি অন্যান্য ভিজিটরদের কাছে স্বয়ংক্রিয়ভাবে ব্লার থাকবে। অনুমতি দেওয়া হলে তবেই দেখা যাবে।
                        </p>
                    @else
                        <div class="rounded-circle bg-success-subtle text-success mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 64px; height: 64px; font-size: 1.8rem;">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1">ছবি উন্মুক্ত রয়েছে</h6>
                        <p class="small text-muted mb-3">
                            ভেরিফাইড মেম্বাররা আপনার ছবি দেখতে পাচ্ছেন।
                        </p>
                    @endif

                    <form action="{{ route('member.biodata.toggle-discreet') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn {{ $candidateProfile->is_discreet ? 'btn-outline-dark' : 'btn-outline-danger' }} btn-sm rounded-pill px-4">
                            <i class="bi bi-arrow-repeat me-1"></i>
                            {{ $candidateProfile->is_discreet ? 'ছবি আনব্লার করুন' : 'ছবি ব্লার/গোপন করুন' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Membership Details Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold text-dark mb-0 font-serif">
                    <i class="bi bi-award-fill text-gold me-2"></i>মেম্বারশিপ ও কোটা স্ট্যাটাস
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <span class="small text-muted d-block">বর্তমান প্যাকেজ:</span>
                        <h6 class="fw-bold text-dark mb-0">{{ $activeSubscription?->package_name ?? 'Complimentary Plan' }}</h6>
                    </div>
                    <span class="badge bg-success text-white">সক্রিয়</span>
                </div>
                <div class="small text-muted mb-2">
                    মোট প্রপোজাল কোটা: <strong>{{ $activeSubscription?->proposals_quota ?? 5 }}</strong> টি
                </div>
                <div class="small text-muted mb-2">
                    ব্যবহৃত হয়েছে: <strong>{{ $activeSubscription?->proposals_used ?? 0 }}</strong> টি
                </div>
                <div class="small text-muted mb-3">
                    মেয়াদ: <strong>{{ $activeSubscription?->expires_at ? $activeSubscription->expires_at->format('d M Y') : '৬ মাস' }}</strong>
                </div>
                <a href="{{ route('packages') }}" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill w-100 py-2">
                    <i class="bi bi-arrow-up-circle me-1"></i> প্যাকেজ আপগ্রেড দেখুন
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.blur-discreet {
    filter: blur(6px);
    transition: filter 0.3s ease;
}
.hover-shadow {
    transition: all 0.2s ease;
}
.hover-shadow:hover {
    box-shadow: 0 8px 24px rgba(133, 24, 41, 0.08) !important;
    border-color: rgba(133, 24, 41, 0.25) !important;
}
</style>
@endsection
