@extends('member.layouts.app')

@section('title', 'সদস্য ড্যাশবোর্ড - ' . site_setting('site_name', 'Biye Marriage Media'))

@section('content')
<div class="row g-4">
    <!-- 1. Grand Royal Welcome Hero Banner & Completion Progress -->
    <div class="col-12">
        <div class="card border-0 rounded-4 overflow-hidden text-white shadow-sm position-relative" 
             style="background: linear-gradient(135deg, #640f1c 0%, #851829 45%, #2c050d 100%); border: 1px solid rgba(201, 151, 56, 0.35) !important;">
            
            <!-- Golden Glow Ambient Accent -->
            <div class="position-absolute top-0 end-0 h-100 w-50 pointer-events-none d-none d-md-block" 
                 style="background: radial-gradient(ellipse at 85% 20%, rgba(201, 151, 56, 0.22) 0%, transparent 65%);"></div>

            <div class="card-body p-4 p-md-5 position-relative z-1">
                <div class="row align-items-center g-4">
                    <!-- Left Column (7 Cols): Greetings & Frosted Glass Completion Progress -->
                    <div class="col-12 col-lg-7">
                        <h2 class="font-serif fw-bold mb-2 display-6" style="letter-spacing: -0.5px;">
                            আসসালামু আলাইকুম, {{ $user->name }}!
                        </h2>
                        <p class="text-white-50 mb-4 lh-base" style="max-width: 580px; font-size: 0.96rem;">
                            {{ site_setting('site_name', 'Biye Marriage Media') }}-তে আপনার পরিবারের জন্য উপযুক্ত দ্বীনদার, সুশিক্ষিত ও সমমর্যাদার জীবনসঙ্গী খুঁজে পেতে আমাদের সিনিয়র ম্যাচমেকার টিম আন্তরিকভাবে নিবেদিত।
                        </p>

                        <!-- Refined Frosted Glass Completion Meter Card -->
                        <div class="completion-meter-card p-4 rounded-4 shadow-sm" style="max-width: 580px;">
                            <!-- Perfectly Aligned Title & Completion Badge on One Line -->
                            <div class="d-flex justify-content-between align-items-center mb-1 flex-nowrap gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="meter-icon-box">
                                        <i class="bi bi-award-fill text-warning"></i>
                                    </div>
                                    <span class="fw-bold text-white fs-6 mb-0">{{ __('বায়োডাটা সম্পূর্ণতা সূচক') }}</span>
                                </div>
                                <span class="badge badge-gold-glow px-3 py-1.5 rounded-pill font-monospace fw-bold text-nowrap">
                                    {{ $candidateProfile->completion_score }}% {{ __('সম্পন্ন') }}
                                </span>
                            </div>
                            <div class="text-white-50 small mb-3" style="font-size: 0.76rem; padding-left: 46px;">
                                {{ app()->getLocale() === 'en' ? 'The more complete your biodata, the faster the matchmaking' : 'তথ্য যত সমৃদ্ধ হবে, ম্যাচমেকিং তত দ্রুত ও কার্যকর হবে' }}
                            </div>

                            <!-- Shimmer Gold Progress Bar -->
                            <div class="progress progress-royal-gold mb-3">
                                <div class="progress-bar progress-bar-gold progress-bar-striped progress-bar-animated" 
                                     role="progressbar" 
                                     style="width: {{ $candidateProfile->completion_score }}%;" 
                                     aria-valuenow="{{ $candidateProfile->completion_score }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100"></div>
                            </div>
                            
                            <!-- Action Buttons with Perfect Spacing -->
                            <div class="meter-btn-group pt-1">
                                <a href="{{ route('member.biodata.edit') }}" class="btn btn-warning btn-sm rounded-pill px-3.5 py-2 fw-bold text-dark shadow-sm d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>{{ __('বায়োডাটা আপডেট করুন') }}</span>
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                                <a href="{{ route('member.matches') }}" class="btn btn-outline-light btn-sm rounded-pill px-3.5 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                                    <i class="bi bi-stars text-warning"></i>
                                    <span>{{ __('ডেইলি ম্যাচ দেখুন') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (5 Cols): Dedicated Executive Candidate Dossier Card -->
                    <div class="col-12 col-lg-5">
                        <div class="hero-profile-dossier-card p-4 text-center">
                            <!-- Large Avatar Frame with Dual Gold Ring -->
                            <div class="position-relative d-inline-block mb-3">
                                <div class="hero-avatar-ring-large">
                                    <img src="{{ $candidateProfile->resolved_image }}" 
                                         alt="{{ $user->name }}" 
                                         class="{{ $candidateProfile->is_discreet ? 'blur-discreet' : '' }}">
                                </div>
                                @if($user->isVerified())
                                    <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-primary border border-2 border-white p-1.5" title="{{ __('ভেরিফাইড মেম্বার') }}">
                                        <i class="bi bi-patch-check-fill fs-5"></i>
                                    </span>
                                @endif
                            </div>

                            <!-- Profile Code & Identity -->
                            <h4 class="fw-bold font-serif text-warning mb-1 fs-4 letter-spacing-1">
                                {{ $candidateProfile->profile_code }}
                            </h4>

                            <!-- Demographic Chips with Perfect Gap -->
                            <div class="profile-chip-group mb-2.5">
                                <span class="badge bg-white text-maroon rounded-pill px-3 py-1.5 fw-bold shadow-xs">
                                    {{ $candidateProfile->gender === 'female' ? __('পাত্রী') : __('পাত্র') }}, {{ $candidateProfile->age }} {{ __('বছর') }}
                                </span>
                                <span class="badge bg-black bg-opacity-35 text-white border border-white border-opacity-20 rounded-pill px-3 py-1.5 small">
                                    {{ $candidateProfile->height }}
                                </span>
                                @if($candidateProfile->category)
                                    <span class="badge bg-black bg-opacity-35 text-warning border border-warning-subtle rounded-pill px-3 py-1.5 small">
                                        {{ $candidateProfile->category }}
                                    </span>
                                @endif
                            </div>

                            <!-- Location & Origin -->
                            <div class="small text-white-50 text-truncate mb-3 px-2">
                                <i class="bi bi-geo-alt-fill text-warning me-1"></i>{{ $candidateProfile->location }} &bull; {{ app()->getLocale() === 'en' ? 'Origin:' : 'দেশের বাড়ি:' }} <strong class="text-white">{{ $candidateProfile->desher_bari }}</strong>
                            </div>

                            <!-- Action Button to View Full Marriage CV -->
                            <a href="{{ route('member.biodata.show') }}" class="btn btn-elite-primary rounded-pill w-100 py-2.5 fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-file-earmark-person-fill text-warning fs-6"></i>
                                <span>{{ __('আমার পূর্ণাঙ্গ সিভি দেখুন') }}</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Quick Metrics: 4 Executive KPI Tiles with Royal Accents -->
    <div class="col-6 col-lg-3">
        <a href="{{ route('member.shortlists') }}" class="text-decoration-none">
            <div class="stat-card-luxury p-3.5 p-xl-4 h-100 position-relative">
                <div class="d-flex align-items-center justify-content-between mb-2.5">
                    <div class="stat-icon-box stat-icon-ruby">
                        <i class="bi bi-bookmark-heart-fill"></i>
                    </div>
                    <span class="text-muted small"><i class="bi bi-arrow-up-right"></i></span>
                </div>
                <h3 class="fw-bold text-dark mb-1 font-serif display-7">{{ $shortlistsCount }}</h3>
                <div class="fw-semibold text-dark small">পছন্দের তালিকা</div>
                <div class="text-muted" style="font-size: 0.74rem;">সংরক্ষিত বায়োডাটা</div>
            </div>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <a href="{{ route('member.proposals') }}" class="text-decoration-none">
            <div class="stat-card-luxury p-3.5 p-xl-4 h-100 position-relative">
                <div class="d-flex align-items-center justify-content-between mb-2.5">
                    <div class="stat-icon-box stat-icon-sapphire">
                        <i class="bi bi-send-check-fill"></i>
                    </div>
                    <span class="text-muted small"><i class="bi bi-arrow-up-right"></i></span>
                </div>
                <h3 class="fw-bold text-dark mb-1 font-serif display-7">{{ $sentProposalsCount }}</h3>
                <div class="fw-semibold text-dark small">পাঠানো প্রস্তাবনা</div>
                <div class="text-muted" style="font-size: 0.74rem;">মোট পাঠানো আগ্রহ</div>
            </div>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <a href="{{ route('member.proposals') }}" class="text-decoration-none">
            <div class="stat-card-luxury p-3.5 p-xl-4 h-100 position-relative">
                <div class="d-flex align-items-center justify-content-between mb-2.5">
                    <div class="stat-icon-box stat-icon-emerald">
                        <i class="bi bi-inbox-fill"></i>
                    </div>
                    @if($pendingReceivedCount > 0)
                        <span class="badge rounded-pill bg-danger shadow-xs" style="font-size: 0.68rem;">
                            {{ $pendingReceivedCount }} নতুন
                        </span>
                    @else
                        <span class="text-muted small"><i class="bi bi-arrow-up-right"></i></span>
                    @endif
                </div>
                <h3 class="fw-bold text-dark mb-1 font-serif display-7">{{ $receivedProposalsCount }}</h3>
                <div class="fw-semibold text-dark small">আগত প্রস্তাবনা</div>
                <div class="text-muted" style="font-size: 0.74rem;">অপর পক্ষ থেকে প্রাপ্ত</div>
            </div>
        </a>
    </div>

    <div class="col-6 col-lg-3">
        <div class="stat-card-luxury p-3.5 p-xl-4 h-100 position-relative">
            <div class="d-flex align-items-center justify-content-between mb-2.5">
                <div class="stat-icon-box stat-icon-gold">
                    <i class="bi bi-gem"></i>
                </div>
                <span class="badge bg-warning-subtle text-dark border border-warning-subtle rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                    কোটা
                </span>
            </div>
            <h3 class="fw-bold text-dark mb-1 font-serif display-7">
                {{ $activeSubscription ? $activeSubscription->remainingProposals() : 0 }}
            </h3>
            <div class="fw-semibold text-dark small">অবশিষ্ট কোটা</div>
            <div class="text-muted" style="font-size: 0.74rem;">
                মোট কোটা: {{ $activeSubscription?->proposals_quota ?? 5 }} টি
            </div>
        </div>
    </div>

    <!-- 3. Main Center/Left Column (8 cols): Relationship Manager & Smart Matches -->
    <div class="col-12 col-lg-8">
        <!-- Relationship Manager Concierge Card -->
        <div class="card border-0 shadow-sm rounded-4 concierge-card mb-4 overflow-hidden">
            <div class="card-body p-4">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-8">
                        <div class="d-flex align-items-center gap-3">
                            <div class="position-relative">
                                <div class="rm-avatar-ring">
                                    <div class="rm-avatar-inner">
                                        {{ strtoupper(substr($relationshipManager?->name ?? 'M', 0, 1)) }}
                                    </div>
                                </div>
                                <span class="position-absolute bottom-0 end-0 p-1 bg-success border border-2 border-white rounded-circle" title="সহায়তার জন্য প্রস্তুত" style="width: 14px; height: 14px;"></span>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1 font-serif fs-5 d-flex align-items-center gap-2">
                                    <span>{{ $relationshipManager?->name ?? 'সিনিয়র ম্যাচমেকার টিম' }}</span>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5 fw-semibold" style="font-size: 0.7rem;">
                                        অনলাইন
                                    </span>
                                </h5>
                                <div class="small text-muted mb-1">
                                    {{ $relationshipManager?->designation ?? 'গুলশান ও আন্তর্জাতিক ডেস্কে সিনিয়র ম্যাচমেকিং এক্সিকিউটিভ' }}
                                </div>
                                <span class="badge bg-light text-secondary border small px-2 py-0.5" style="font-size: 0.72rem;">
                                    <i class="bi bi-clock-history me-1 text-warning"></i>সকাল ১০টা - রাত ১০টা পর্যন্ত সক্রিয়
                                </span>
                            </div>
                        </div>
                        <p class="small text-secondary mt-3 mb-0 lh-base" style="font-size: 0.85rem;">
                            পাত্র-পাত্রী পছন্দ হলে সরাসরি অভিভাবক বৈঠক, পরিবার সমন্বয় ও ব্যাকগ্রাউন্ড ভেরিফিকেশনের জন্য আপনার দায়িত্বপ্রাপ্ত ম্যাচমেকারের সাথে যেকোনো সময় যোগাযোগ করুন।
                        </p>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="d-flex flex-column gap-2 justify-content-center h-100">
                            <a href="tel:{{ $relationshipManager?->phone ?? '+8801577723404' }}" class="btn btn-outline-dark rounded-pill py-2.5 px-3 fw-semibold d-inline-flex align-items-center justify-content-center gap-2 shadow-xs">
                                <i class="bi bi-telephone-fill text-maroon"></i>
                                <span>সরাসরি কল করুন</span>
                            </a>
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $relationshipManager?->phone ?? '8801577723404');
                            @endphp
                            <a href="https://wa.me/{{ $cleanPhone }}?text=Hello%2C%20I%20am%20member%20{{ urlencode($user->name) }}%20(Code%3A%20{{ $candidateProfile->profile_code }}).%20I%20need%20assistance%20regarding%20matchmaking." 
                               target="_blank" 
                               class="btn btn-success rounded-pill py-2.5 px-3 fw-semibold d-inline-flex align-items-center justify-content-center gap-2 shadow-sm"
                               style="background-color: #25d366; border-color: #25d366;">
                                <i class="bi bi-whatsapp fs-6"></i>
                                <span>WhatsApp মেসেজ</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Smart Matches Showcase -->
        <div class="card dashboard-main-card overflow-hidden mb-4">
            <div class="card-header py-3.5 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold text-dark mb-0 font-serif d-flex align-items-center gap-2">
                        <i class="bi bi-stars text-warning"></i> <span>আপনার জন্য প্রস্তাবিত ম্যাচ (Daily Matches)</span>
                    </h5>
                    <div class="small text-muted">আপনার পছন্দ, শিক্ষাগত যোগ্যতা ও বিপরীত লিঙ্গের বায়োডাটা অনুযায়ী নির্বাচিত</div>
                </div>
                <a href="{{ route('member.matches') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3.5 py-1.5 fw-medium d-inline-flex align-items-center gap-1">
                    <span>সব দেখুন</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            
            <div class="card-body p-3 p-md-4">
                <div class="row g-3">
                    @forelse($recommendedProfiles as $match)
                        @php
                            $isShortlisted = in_array($match->id, $shortlistedProfileIds);
                        @endphp
                        <div class="col-12 col-sm-6 col-xl-4">
                            <div class="match-card-royal h-100 p-3 text-center d-flex flex-column justify-content-between position-relative">
                                <div>
                                    <!-- Recommended Top Badge -->
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-gold-subtle text-dark border border-warning-subtle rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                            <i class="bi bi-stars text-warning me-0.5"></i>সুপারিশকৃত
                                        </span>
                                        <span class="badge bg-light text-secondary border rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                            {{ $match->gender === 'female' ? 'পাত্রী' : 'পাত্র' }}
                                        </span>
                                    </div>

                                    <!-- Avatar with Luxury Ring & Discreet Blur if applicable -->
                                    <div class="position-relative d-inline-block mx-auto mb-2.5">
                                        <div class="match-avatar-ring">
                                            <img src="{{ $match->resolved_image }}" 
                                                 alt="Candidate" 
                                                 class="rounded-circle object-fit-cover {{ $match->is_discreet ? 'blur-discreet' : '' }}">
                                        </div>
                                        
                                        @if($match->is_discreet)
                                            <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-dark p-1 border border-2 border-white" style="font-size: 0.62rem;" title="Discreet Photo Protected">
                                                <i class="bi bi-eye-slash-fill text-warning"></i>
                                            </span>
                                        @else
                                            <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-primary p-1 border border-2 border-white" style="font-size: 0.62rem;" title="ভেরিফাইড প্রোফাইল">
                                                <i class="bi bi-patch-check-fill text-white"></i>
                                            </span>
                                        @endif
                                    </div>

                                    <h6 class="fw-bold font-serif text-dark mb-1 fs-6">{{ $match->profile_code }}</h6>
                                    
                                    <!-- Demographic Info (Single Line) -->
                                    <div class="d-flex justify-content-center mb-2.5">
                                        <div class="badge bg-light text-dark border border-light-subtle rounded-pill px-2.5 py-1 text-nowrap d-inline-flex align-items-center gap-1.5 shadow-2xs" style="font-size: 0.78rem; max-width: 100%;">
                                            <span class="fw-semibold">{{ $match->age }} বছর</span>
                                            <span class="text-muted opacity-50">&bull;</span>
                                            <span>{{ $match->height }}</span>
                                            <span class="text-muted opacity-50">&bull;</span>
                                            <span class="text-secondary text-truncate" style="max-width: 90px;" title="{{ $match->desher_bari }}">
                                                <i class="bi bi-geo-alt-fill text-warning me-0.5"></i>{{ $match->desher_bari }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Profession & Education (Clean Editorial Typography, No Enclosing Box) -->
                                    <div class="px-1 mb-3 text-center">
                                        <div class="fw-bold text-dark text-truncate mb-1" style="font-size: 0.88rem;" title="{{ $match->profession }}">
                                            <i class="bi bi-briefcase-fill text-warning me-1"></i>{{ $match->profession }}
                                        </div>
                                        <div class="text-muted text-truncate" style="font-size: 0.78rem;" title="{{ $match->education }}">
                                            <i class="bi bi-mortarboard-fill text-secondary me-1"></i>{{ $match->education }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-2 justify-content-center pt-2 border-top">
                                    <form action="{{ route('member.shortlists.toggle', $match) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm {{ $isShortlisted ? 'btn-danger' : 'btn-outline-danger' }} rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                                style="width: 38px; height: 38px;"
                                                title="{{ $isShortlisted ? 'শর্টলিস্ট থেকে মুছুন' : 'শর্টলিস্টে রাখুন' }}">
                                            <i class="bi bi-heart{{ $isShortlisted ? '-fill' : '' }} fs-6"></i>
                                        </button>
                                    </form>

                                    <button type="button" class="btn btn-elite-primary btn-sm rounded-pill px-3 py-2 small fw-semibold w-100 d-flex align-items-center justify-content-center gap-1.5 shadow-xs" data-bs-toggle="modal" data-bs-target="#sendProposalModal{{ $match->id }}">
                                        <i class="bi bi-send-fill text-warning"></i>
                                        <span>প্রস্তাব পাঠান</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal: Send Proposal -->
                        <div class="modal fade" id="sendProposalModal{{ $match->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden text-start">
                                    <form action="{{ route('member.proposals.send', $match) }}" method="POST">
                                        @csrf
                                        <div class="modal-header text-white" style="background: linear-gradient(135deg, #851829 0%, #520f1a 100%);">
                                            <h5 class="modal-title font-serif fw-bold d-flex align-items-center gap-2">
                                                <i class="bi bi-envelope-heart-fill text-warning"></i> বিয়ের প্রস্তাবনা পাঠান
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="d-flex align-items-center gap-3 mb-3 p-3 bg-light rounded-3 border">
                                                <img src="{{ $match->resolved_image }}" class="rounded-circle object-fit-cover {{ $match->is_discreet ? 'blur-discreet' : '' }}" style="width: 52px; height: 52px; border: 2px solid var(--theme-secondary);">
                                                <div>
                                                    <div class="fw-bold font-serif text-dark fs-6">{{ $match->profile_code }}</div>
                                                    <div class="small text-muted">{{ $match->age }} বছর &bull; {{ $match->profession }} ({{ $match->desher_bari }})</div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold text-dark">প্রাথমিক পারিবারিক বার্তা (ঐচ্ছিক)</label>
                                                <textarea name="message" class="form-control" rows="3" placeholder="শ্রদ্ধাভাজন অভিভাবক, আমরা আপনার প্রার্থীর বায়োডাটা দেখে সম্মানিত বোধ করেছি এবং পারিবারিক আলোচনার আগ্রহ প্রকাশ করছি..."></textarea>
                                            </div>

                                            <div class="alert alert-warning-subtle text-dark small py-2 px-3 mb-0 rounded-3 border border-warning-subtle d-flex align-items-center gap-2">
                                                <i class="bi bi-info-circle-fill text-warning fs-5"></i>
                                                <div>প্রস্তাব পাঠানোর পর আপনার দায়িত্বপ্রাপ্ত ম্যাচমেকার অপর পরিবারের সাথে আলোচনা করে অগ্রগতি জানাবেন।</div>
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
                        <div class="col-12 py-5 text-center text-muted">
                            <div class="rounded-circle bg-light d-inline-flex p-3 mb-2 text-warning">
                                <i class="bi bi-stars fs-1"></i>
                            </div>
                            <h6 class="fw-bold text-dark font-serif">বর্তমানে নতুন কোনো ম্যাচ নেই</h6>
                            <p class="small text-muted mb-0" style="max-width: 380px; margin: 0 auto;">
                                আমাদের টিম নিয়মিত নতুন ভেরিফাইড বায়োডাটা যাচাই করছেন। শীঘ্রই আপনার পছন্দের সাথে সামঞ্জস্যপূর্ণ নতুন প্রোফাইল এখানে দেখতে পাবেন।
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- 4. Right Column (4 cols): Membership Quota & Privacy Vault -->
    <div class="col-12 col-lg-4">
        <!-- Membership Details Card -->
        <div class="card dashboard-side-card mb-4 overflow-hidden">
            <div class="card-header py-3.5 px-4">
                <h6 class="fw-bold text-dark mb-0 font-serif d-flex align-items-center gap-2">
                    <i class="bi bi-award-fill text-warning"></i> <span>মেম্বারশিপ ও কোটা স্ট্যাটাস</span>
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-2.5 border-bottom">
                    <div>
                        <span class="small text-muted d-block" style="font-size: 0.74rem;">বর্তমান সক্রিয় প্যাকেজ:</span>
                        <h6 class="fw-bold text-dark mb-0 font-serif fs-5 d-flex align-items-center gap-1.5">
                            <i class="bi bi-award-fill text-warning"></i>
                            <span>{{ $activeSubscription?->package_name ?? 'Complimentary Plan' }}</span>
                        </h6>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small fw-bold">
                        <i class="bi bi-check-circle-fill me-1"></i>সক্রিয়
                    </span>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center small mb-1.5">
                        <span class="text-muted fw-medium">প্রপোজাল কোটা ব্যবহার:</span>
                        <strong class="text-dark font-monospace">
                            {{ $activeSubscription?->proposals_used ?? 0 }} / {{ $activeSubscription?->proposals_quota ?? 5 }}
                        </strong>
                    </div>
                    @php
                        $quotaTotal = max(1, $activeSubscription?->proposals_quota ?? 5);
                        $quotaUsed = $activeSubscription?->proposals_used ?? 0;
                        $quotaPercent = min(100, round(($quotaUsed / $quotaTotal) * 100));
                    @endphp
                    <div class="progress rounded-pill mb-2" style="height: 9px; background-color: #f3ede2;">
                        <div class="progress-bar progress-bar-gold rounded-pill" role="progressbar" style="width: {{ $quotaPercent }}%;" aria-valuenow="{{ $quotaPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 0.76rem;">
                        <span>অবশিষ্ট: <strong class="text-dark">{{ $activeSubscription ? $activeSubscription->remainingProposals() : 0 }} টি</strong></span>
                        <span>ব্যবহার: <strong class="text-dark">{{ $quotaPercent }}%</strong></span>
                    </div>
                </div>

                <div class="small text-muted mb-4 d-flex justify-content-between align-items-center rounded-3 shadow-2xs" style="padding: 12px 18px; background-color: #faf6f0; border: 1px solid rgba(201, 151, 56, 0.22);">
                    <span class="d-inline-flex align-items-center gap-2">
                        <i class="bi bi-calendar-check text-warning"></i>
                        <span class="fw-medium text-secondary">মেয়াদ সমাপ্তি:</span>
                    </span>
                    <strong class="text-dark font-monospace" style="font-size: 0.88rem;">{{ $activeSubscription?->expires_at ? $activeSubscription->expires_at->format('d M Y') : '৬ মাস' }}</strong>
                </div>

                <a href="{{ route('packages') }}" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill w-100 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2 shadow-xs">
                    <i class="bi bi-stars text-warning fs-6"></i>
                    <span>প্যাকেজ রিনিউ বা আপগ্রেড দেখুন &rarr;</span>
                </a>
            </div>
        </div>

        <!-- Photo Privacy Vault Card -->
        <div class="card dashboard-side-card mb-4 overflow-hidden vault-card">
            <div class="card-header py-3.5 px-4">
                <h6 class="fw-bold text-dark mb-0 font-serif d-flex align-items-center gap-2">
                    <i class="bi bi-shield-lock-fill text-maroon"></i> <span>গোপনীয়তা ও ফটো ভল্ট</span>
                </h6>
            </div>
            <div class="card-body p-4 text-center">
                @if($candidateProfile->is_discreet)
                    <div class="vault-icon-circle mx-auto mb-3 shadow-inner" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #851829; border: 1px solid rgba(201, 151, 56, 0.3);">
                        <i class="bi bi-shield-lock-fill text-maroon"></i>
                    </div>
                    <div class="badge bg-dark rounded-pill px-3 py-1.5 small fw-bold mb-2 shadow-xs">
                        <i class="bi bi-lock-fill text-warning me-1"></i>Discreet Mode সক্রিয়
                    </div>
                    <h6 class="fw-bold text-dark mb-1 font-serif fs-6">ছবি সুরক্ষিত ও ব্লার রয়েছে</h6>
                    <p class="small text-muted mb-4 lh-base" style="font-size: 0.82rem;">
                        আপনার ছবি সাধারণ ব্যবহারকারীদের কাছে স্বয়ংক্রিয়ভাবে ব্লার থাকবে। কেবল আপনার অনুমোদিত পরিবারই পরিষ্কার দেখতে পাবেন।
                    </p>
                    <form action="{{ route('member.biodata.toggle-discreet') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-dark btn-sm rounded-pill px-4 py-2.5 fw-semibold w-100 d-flex align-items-center justify-content-center gap-2 shadow-xs">
                            <i class="bi bi-eye-fill text-warning"></i>
                            <span>ছবি উন্মুক্ত করুন</span>
                        </button>
                    </form>
                @else
                    <div class="vault-icon-circle mx-auto mb-3 shadow-inner" style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #059669; border: 1px solid rgba(5, 150, 105, 0.25);">
                        <i class="bi bi-eye-fill text-success"></i>
                    </div>
                    <div class="badge bg-success rounded-pill px-3 py-1.5 small fw-bold mb-2 shadow-xs">
                        <i class="bi bi-check-circle-fill me-1"></i>ফটো উন্মুক্ত
                    </div>
                    <h6 class="fw-bold text-dark mb-1 font-serif fs-6">ছবি উন্মুক্ত রয়েছে</h6>
                    <p class="small text-muted mb-4 lh-base" style="font-size: 0.82rem;">
                        ভেরিফাইড মেম্বাররা আপনার বায়োডাটা ও ছবি দেখতে পাচ্ছেন। গোপনীয়তা বজায় রাখতে চাইলে যেকোনো সময় Discreet Mode অন করতে পারেন।
                    </p>
                    <form action="{{ route('member.biodata.toggle-discreet') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4 py-2.5 fw-semibold w-100 d-flex align-items-center justify-content-center gap-2 shadow-xs">
                            <i class="bi bi-eye-slash-fill"></i>
                            <span>ছবি ব্লার/গোপন করুন</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Discreet Blur Styling */
.blur-discreet {
    filter: blur(6px);
    transition: filter 0.3s ease;
}

/* Completion Meter Card (Frosted Glassmorphism) */
.completion-meter-card {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(201, 151, 56, 0.35);
    transition: all 0.3s ease;
}

.completion-meter-card:hover {
    border-color: rgba(201, 151, 56, 0.6);
    background: rgba(255, 255, 255, 0.11);
}

.meter-icon-box {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(201, 151, 56, 0.18);
    border: 1px solid rgba(201, 151, 56, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    flex-shrink: 0;
}

.badge-gold-glow {
    background: linear-gradient(135deg, #fef08a 0%, #d4af37 100%);
    color: #1a0309;
    box-shadow: 0 2px 10px rgba(212, 175, 55, 0.4);
    font-size: 0.84rem;
}

.progress-royal-gold {
    height: 10px;
    background-color: rgba(0, 0, 0, 0.35);
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    overflow: hidden;
}

.progress-bar-gold {
    background: linear-gradient(90deg, #c99738 0%, #fef08a 50%, #d4af37 100%) !important;
    border-radius: 20px;
    box-shadow: 0 0 12px rgba(212, 175, 55, 0.6);
    transition: width 0.6s ease;
}

.meter-btn-group {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 12px;
}

/* Dedicated Executive Candidate Dossier Card */
.hero-profile-dossier-card {
    background: rgba(18, 3, 7, 0.52);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1.5px solid rgba(201, 151, 56, 0.45);
    border-radius: 24px;
    box-shadow: 0 14px 35px rgba(0, 0, 0, 0.35);
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.hero-profile-dossier-card:hover {
    border-color: rgba(201, 151, 56, 0.8);
    transform: translateY(-3px);
    box-shadow: 0 18px 45px rgba(0, 0, 0, 0.45);
}

.hero-avatar-ring-large {
    width: 125px;
    height: 125px;
    border-radius: 50%;
    padding: 3.5px;
    background: linear-gradient(135deg, #fef08a 0%, #c99738 50%, #851829 100%);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
}

.hero-avatar-ring-large img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ffffff;
}

.profile-chip-group {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

/* Stat Cards Luxury Lift */
.stat-card-luxury {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid rgba(201, 151, 56, 0.22);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03);
    transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.stat-card-luxury:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(133, 24, 41, 0.08);
    border-color: rgba(201, 151, 56, 0.55);
}

.stat-icon-box {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-icon-ruby {
    background: linear-gradient(135deg, #ffe4e6 0%, #fecdd3 100%);
    color: #e11d48;
    border: 1px solid rgba(225, 29, 72, 0.2);
}

.stat-icon-sapphire {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #2563eb;
    border: 1px solid rgba(37, 99, 235, 0.2);
}

.stat-icon-emerald {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #059669;
    border: 1px solid rgba(5, 150, 105, 0.2);
}

.stat-icon-gold {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #d97706;
    border: 1px solid rgba(217, 119, 6, 0.25);
}

/* Concierge Card */
.concierge-card {
    border: 1.5px solid rgba(201, 151, 56, 0.35) !important;
    background: linear-gradient(135deg, #ffffff 0%, #fffdf9 50%, #faf5ee 100%) !important;
    box-shadow: 0 10px 30px rgba(201, 151, 56, 0.07);
    border-radius: 22px !important;
}

.rm-avatar-ring {
    width: 62px;
    height: 62px;
    border-radius: 50%;
    padding: 3px;
    background: linear-gradient(135deg, var(--theme-secondary) 0%, var(--theme-primary) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.rm-avatar-inner {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: var(--theme-primary);
    color: #ffffff;
    font-weight: 700;
    font-size: 1.4rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
}

/* Match Card Royal */
.match-card-royal {
    background: #ffffff;
    border: 1px solid rgba(201, 151, 56, 0.22);
    border-radius: 20px;
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


/* Unified Light White Luxury Card Finish for Dashboard Sections */
.dashboard-main-card,
.dashboard-side-card {
    background: #ffffff !important;
    border: 1px solid rgba(201, 151, 56, 0.22) !important;
    border-radius: 20px !important;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03) !important;
    transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.dashboard-side-card:hover {
    border-color: rgba(201, 151, 56, 0.45) !important;
    box-shadow: 0 10px 25px rgba(133, 24, 41, 0.06) !important;
}

.dashboard-main-card .card-header,
.dashboard-side-card .card-header {
    background: transparent !important;
    border-bottom: 1px solid rgba(201, 151, 56, 0.12) !important;
}

.vault-icon-circle {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
}
</style>
@endsection
