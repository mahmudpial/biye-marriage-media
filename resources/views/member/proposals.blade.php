@extends('member.layouts.app')

@section('title', 'প্রস্তাবনা ও পারিবারিক যোগাযোগ - Biye Marriage Media')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="font-serif fw-bold text-dark mb-1">
                        <i class="bi bi-send-check-fill text-maroon me-2"></i>প্রস্তাবনা ও পারিবারিক আগ্রহ ট্র্যাকার
                    </h4>
                    <p class="small text-muted mb-0">
                        উভয় পরিবারের মধ্যে ম্যাচমেকিং প্রক্রিয়ার অগ্রগতি ও আগ্রহ মনিটর করুন।
                    </p>
                </div>
                @if($activeSubscription)
                    <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-pill badge-quota small">
                        <i class="bi bi-award-fill text-gold"></i>
                        <span>প্রপোজাল কোটা: <strong>{{ $activeSubscription->proposals_used }}</strong> / {{ $activeSubscription->proposals_quota }} (অবশিষ্ট: {{ $activeSubscription->remainingProposals() }})</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Proposals Tabs Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
            <div class="card-header bg-white p-3 border-bottom">
                <ul class="nav nav-pills nav-fill" id="proposalPills" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill fw-semibold py-2" id="received-tab" data-bs-toggle="pill" data-bs-target="#received-pane" type="button" role="tab">
                            <i class="bi bi-inbox-fill me-1.5"></i> আগত প্রস্তাবনা (Received)
                            <span class="badge bg-danger ms-1">{{ $receivedProposals instanceof \Illuminate\Pagination\LengthAwarePaginator ? $receivedProposals->total() : $receivedProposals->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill fw-semibold py-2" id="sent-tab" data-bs-toggle="pill" data-bs-target="#sent-pane" type="button" role="tab">
                            <i class="bi bi-send-fill me-1.5"></i> পাঠানো প্রস্তাবনা (Sent)
                            <span class="badge bg-secondary ms-1">{{ $sentProposals->total() }}</span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content" id="proposalPillsContent">
                    <!-- Received Tab -->
                    <div class="tab-pane fade show active" id="received-pane" role="tabpanel">
                        @if($receivedProposals->isEmpty())
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 text-secondary mb-2 d-block"></i>
                                <h5>কোনো আগত প্রস্তাবনা নেই</h5>
                                <p class="small mb-0">অন্যান্য পরিবারের পক্ষ থেকে আগ্রহ আসলে এখানে তাৎক্ষণিক দেখতে পাবেন।</p>
                            </div>
                        @else
                            <div class="row g-3">
                                @foreach($receivedProposals as $proposal)
                                    @php
                                        $senderProf = $proposal->senderProfile;
                                        $senderUser = $proposal->senderUser;
                                    @endphp
                                    <div class="col-12">
                                        <div class="p-3 p-md-4 rounded-3 border bg-light d-flex flex-wrap justify-content-between align-items-center gap-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $senderProf?->resolved_image ?? asset('site-logo/marriage-logo.jpeg') }}" 
                                                     alt="Sender" 
                                                     class="rounded-circle object-fit-cover shadow-sm {{ $senderProf?->is_discreet ? 'blur-discreet' : '' }}" 
                                                     style="width: 65px; height: 65px; border: 2px solid #851829;">
                                                <div>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <h6 class="fw-bold font-serif text-dark mb-0">
                                                            {{ $senderProf?->profile_code ?? 'Candidate' }}
                                                        </h6>
                                                        <span class="badge bg-light text-dark border">
                                                            {{ $senderUser?->name }} ({{ ucfirst($senderUser?->profile_for ?? 'Family') }})
                                                        </span>
                                                    </div>
                                                    <div class="small text-muted">
                                                        {{ $senderProf?->gender ? ucfirst($senderProf->gender) : '' }}, {{ $senderProf?->age }} বছর, {{ $senderProf?->height }} | {{ $senderProf?->profession }} ({{ $senderProf?->desher_bari }})
                                                    </div>
                                                    @if($proposal->sender_message)
                                                        <div class="small text-dark mt-2 p-2 bg-white rounded border fst-italic" style="max-width: 580px;">
                                                            "{{ $proposal->sender_message }}"
                                                        </div>
                                                    @endif
                                                    <div class="small text-muted mt-1" style="font-size: 0.76rem;">
                                                        তারিখ: {{ $proposal->created_at->format('d M Y, h:i A') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column align-items-end gap-2">
                                                @if($proposal->status === 'pending')
                                                    <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill small">
                                                        <i class="bi bi-clock-history me-1"></i> আপনার সিদ্ধান্তের অপেক্ষায়
                                                    </span>
                                                    <div class="d-flex gap-2">
                                                        <form action="{{ route('member.proposals.respond', $proposal) }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="status" value="accepted">
                                                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-3">
                                                                <i class="bi bi-check-lg me-1"></i> গ্রহণ করুন
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('member.proposals.respond', $proposal) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই প্রস্তাবটি নাকচ করতে চান?');">
                                                            @csrf
                                                            <input type="hidden" name="status" value="declined">
                                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                                <i class="bi bi-x-lg me-1"></i> নাকচ
                                                            </button>
                                                        </form>
                                                    </div>
                                                @elseif($proposal->status === 'accepted')
                                                    <span class="badge bg-success px-3 py-1.5 rounded-pill small">
                                                        <i class="bi bi-check-circle-fill me-1"></i> প্রস্তাব গৃহীত হয়েছে
                                                    </span>
                                                    <div class="small text-success fw-medium text-end">
                                                        ম্যাচমেকার উভয় পরিবারে আলোচনা শুরু করেছেন।
                                                    </div>
                                                @elseif($proposal->status === 'declined')
                                                    <span class="badge bg-danger-subtle text-danger px-3 py-1.5 rounded-pill small">
                                                        <i class="bi bi-x-circle me-1"></i> প্রস্তাব নাকচ করা হয়েছে
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($receivedProposals instanceof \Illuminate\Pagination\LengthAwarePaginator && $receivedProposals->hasPages())
                                <div class="mt-4">
                                    {{ $receivedProposals->links() }}
                                </div>
                            @endif
                        @endif
                    </div>

                    <!-- Sent Tab -->
                    <div class="tab-pane fade" id="sent-pane" role="tabpanel">
                        @if($sentProposals->isEmpty())
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-send fs-1 text-secondary mb-2 d-block"></i>
                                <h5>আপনি এখনো কোনো প্রস্তাব পাঠাননি</h5>
                                <p class="small mb-3">স্মার্ট ম্যাচ তালিকা থেকে পাত্র-পাত্রীর বায়োডাটা দেখে আগ্রহ প্রকাশ করতে পারেন।</p>
                                <a href="{{ route('member.matches') }}" class="btn btn-elite-primary btn-sm rounded-pill px-4">
                                    <i class="bi bi-search-heart me-1"></i> ম্যাচমেকিং বায়োডাটা খুঁজুন
                                </a>
                            </div>
                        @else
                            <div class="row g-3">
                                @foreach($sentProposals as $sent)
                                    @php
                                        $target = $sent->receiverProfile;
                                    @endphp
                                    <div class="col-12">
                                        <div class="p-3 p-md-4 rounded-3 border bg-white d-flex flex-wrap justify-content-between align-items-center gap-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ $target->resolved_image }}" 
                                                     alt="Target" 
                                                     class="rounded-circle object-fit-cover shadow-sm {{ $target->is_discreet ? 'blur-discreet' : '' }}" 
                                                     style="width: 60px; height: 60px; border: 2px solid #851829;">
                                                <div>
                                                    <h6 class="fw-bold font-serif text-dark mb-0">{{ $target->profile_code }}</h6>
                                                    <div class="small text-muted">
                                                        {{ ucfirst($target->gender) }}, {{ $target->age }} বছর | {{ $target->profession }} ({{ $target->desher_bari }})
                                                    </div>
                                                    @if($sent->sender_message)
                                                        <div class="small text-secondary mt-1">
                                                            বার্তা: <em>"{{ $sent->sender_message }}"</em>
                                                        </div>
                                                    @endif
                                                    <div class="small text-muted mt-1" style="font-size: 0.76rem;">
                                                        প্রেরণের সময়: {{ $sent->created_at->format('d M Y, h:i A') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                @if($sent->status === 'accepted')
                                                    <span class="badge bg-success px-3 py-1.5 rounded-pill">
                                                        <i class="bi bi-check-circle-fill me-1"></i> অপর পরিবার গ্রহণ করেছে
                                                    </span>
                                                @elseif($sent->status === 'declined')
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-secondary px-3 py-1.5 rounded-pill">
                                                            <i class="bi bi-x-circle me-1"></i> বিনীতভাবে নাকচ
                                                        </span>
                                                        <form action="{{ route('member.proposals.cancel', $sent) }}" method="POST" onsubmit="return confirm('এই নাকচ হওয়া প্রস্তাবনা রেকর্ডটি কি তালিকা থেকে মুছে ফেলতে চান?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-secondary btn-sm rounded-pill px-2.5 py-1 d-inline-flex align-items-center gap-1 shadow-2xs" style="font-size: 0.76rem;" title="রেকর্ড মুছে ফেলুন">
                                                                <i class="bi bi-trash3"></i>
                                                                <span>মুছে ফেলুন</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="d-flex flex-column flex-sm-row align-items-end align-items-sm-center gap-2">
                                                        <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill small">
                                                            <i class="bi bi-hourglass-split me-1"></i> পর্যালোচনায় রয়েছে (Pending)
                                                        </span>
                                                        <form action="{{ route('member.proposals.cancel', $sent) }}" method="POST" onsubmit="return confirm('আপনি কি নিশ্চিত যে এই প্রস্তাবনাটি প্রত্যাহার করতে চান? প্রত্যাহার করলে আপনার ১টি প্রপোজাল কোটা ফেরত পাবেন।');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1.5 shadow-2xs proposal-withdraw-btn" style="font-size: 0.78rem; font-weight: 500;" title="প্রস্তাবনা প্রত্যাহার করুন">
                                                                <i class="bi bi-x-circle-fill text-danger"></i>
                                                                <span>প্রত্যাহার / বাতিল</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($sentProposals->hasPages())
                                <div class="mt-4">
                                    {{ $sentProposals->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.blur-discreet {
    filter: blur(6px);
}

.proposal-withdraw-btn {
    border-color: rgba(220, 53, 69, 0.4) !important;
    color: #dc3545 !important;
    background-color: rgba(220, 53, 69, 0.04) !important;
    transition: all 0.2s ease;
}

.proposal-withdraw-btn:hover {
    background-color: #dc3545 !important;
    color: #ffffff !important;
    border-color: #dc3545 !important;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.25) !important;
}

.proposal-withdraw-btn:hover i {
    color: #ffffff !important;
}
</style>
@endsection
