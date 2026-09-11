@extends('member.layouts.app')

@section('title', 'আমার বায়োডাটা (সিভি) - ' . site_setting('site_name', 'Biye Marriage Media'))

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-xl-10">
        <!-- Top Breadcrumb & Action Ribbon -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 no-print">
            <div class="card-body p-3.5 px-md-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1 small">
                            <li class="breadcrumb-item"><a href="{{ route('member.dashboard') }}" class="text-maroon text-decoration-none">ড্যাশবোর্ড</a></li>
                            <li class="breadcrumb-item active" aria-current="page">আমার বায়োডাটা সিভি</li>
                        </ol>
                    </nav>
                    <h4 class="font-serif fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                        <i class="bi bi-file-earmark-person-fill text-maroon"></i>
                        <span>আমার পূর্ণাঙ্গ বায়োডাটা (Marriage CV)</span>
                    </h4>
                </div>

                <!-- Action Buttons: Edit, Discreet Toggle & Print -->
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('member.biodata.edit') }}" class="btn btn-elite-primary btn-sm rounded-pill px-3.5 py-2 fw-semibold shadow-sm">
                        <i class="bi bi-pencil-square me-1.5"></i> বায়োডাটা এডিট করুন
                    </a>

                    <form action="{{ route('member.biodata.toggle-discreet') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn {{ $candidateProfile->is_discreet ? 'btn-outline-dark' : 'btn-outline-danger' }} btn-sm rounded-pill px-3 py-2 fw-semibold">
                            <i class="bi bi-eye-slash-fill me-1"></i>
                            {{ $candidateProfile->is_discreet ? 'ছবি আনব্লার করুন' : 'ছবি ব্লার করুন' }}
                        </button>
                    </form>

                    <button type="button" onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-2 fw-semibold">
                        <i class="bi bi-printer me-1"></i> প্রিন্ট / PDF
                    </button>
                </div>
            </div>
        </div>

        <!-- Marriage CV Container Card -->
        <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden cv-container-card mb-5">
            <!-- CV Header Banner (Velvet Royal Maroon Gradient) -->
            <div class="p-4 p-md-5 text-white position-relative" style="background: linear-gradient(135deg, #640f1c 0%, #851829 45%, #2c050d 100%); border-bottom: 2px solid #c99738;">
                <div class="position-absolute top-0 end-0 h-100 w-50 pointer-events-none d-none d-md-block" 
                     style="background: radial-gradient(ellipse at 85% 20%, rgba(201, 151, 56, 0.25) 0%, transparent 65%);"></div>

                <div class="row align-items-center g-4 position-relative z-1">
                    <!-- Candidate Photo Frame -->
                    <div class="col-12 col-md-auto text-center text-md-start">
                        <div class="position-relative d-inline-block">
                            <div class="cv-avatar-ring">
                                <img src="{{ $candidateProfile->resolved_image }}" 
                                     alt="Candidate Portrait" 
                                     class="rounded-circle object-fit-cover {{ $candidateProfile->is_discreet ? 'blur-discreet' : '' }}" 
                                     style="width: 120px; height: 120px; border: 3px solid #c99738;">
                            </div>
                            @if($user->isVerified())
                                <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-primary border border-2 border-white p-1" title="অফিসিয়াল ব্লু ভেরিফাইড মেম্বার">
                                    <i class="bi bi-patch-check-fill fs-6"></i>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Candidate Headline & Metadata -->
                    <div class="col-12 col-md">
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                            <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fw-bold font-monospace fs-6">
                                {{ $candidateProfile->profile_code }}
                            </span>
                            <span class="badge bg-white text-maroon px-2.5 py-1 rounded-pill fw-semibold small">
                                {{ ucfirst($candidateProfile->gender) }} ({{ $candidateProfile->gender === 'female' ? 'পাত্রী' : 'পাত্র' }})
                            </span>
                            @if($candidateProfile->category)
                                <span class="badge bg-black bg-opacity-30 border border-white border-opacity-20 text-white px-2.5 py-1 rounded-pill small">
                                    {{ $candidateProfile->category }}
                                </span>
                            @endif
                            @if($candidateProfile->is_discreet)
                                <span class="badge bg-dark px-2.5 py-1 rounded-pill small" title="Discreet Photo Protection">
                                    <i class="bi bi-shield-lock-fill me-1 text-warning"></i>Discreet Mode
                                </span>
                            @endif
                        </div>

                        <h2 class="font-serif fw-bold text-white mb-2 fs-3">
                            {{ $candidateProfile->profession ?? 'অভিজাত পেশাজীবী' }}
                        </h2>
                        
                        <div class="text-white-50 small d-flex align-items-center gap-3 flex-wrap">
                            <span><i class="bi bi-calendar3 text-warning me-1"></i>বয়স: <strong class="text-white">{{ $candidateProfile->age }} বছর</strong></span>
                            <span>&bull;</span>
                            <span><i class="bi bi-rulers text-warning me-1"></i>উচ্চতা: <strong class="text-white">{{ $candidateProfile->height }}</strong></span>
                            <span>&bull;</span>
                            <span><i class="bi bi-geo-alt-fill text-warning me-1"></i>বর্তমান অবস্থান: <strong class="text-white">{{ $candidateProfile->location }}</strong></span>
                            <span>&bull;</span>
                            <span><i class="bi bi-house-door-fill text-warning me-1"></i>দেশের বাড়ি: <strong class="text-white">{{ $candidateProfile->desher_bari }}</strong></span>
                        </div>
                    </div>

                    <!-- Right Completion Pill (Print hidden or displayed) -->
                    <div class="col-12 col-md-auto text-md-end no-print">
                        <div class="p-3 rounded-4 bg-black bg-opacity-25 border border-white border-opacity-15 text-center">
                            <div class="text-white-50 small mb-1" style="font-size: 0.76rem;">সিভি সম্পূর্ণতা:</div>
                            <h4 class="fw-bold text-warning font-serif mb-1">{{ $candidateProfile->completion_score }}%</h4>
                            <div class="progress" style="height: 6px; width: 100px; background-color: rgba(255,255,255,0.2);">
                                <div class="progress-bar bg-warning" style="width: {{ $candidateProfile->completion_score }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CV Body: Organized Sections -->
            <div class="card-body p-4 p-md-5">
                <!-- 1. Personal & Demographic Dossier -->
                <div class="cv-section mb-5">
                    <h5 class="cv-section-title font-serif">
                        <i class="bi bi-person-lines-fill text-maroon me-2"></i>১. ব্যক্তিগত ও শারীরিক বিবরণ
                    </h5>
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-4">
                            <div class="cv-info-tile">
                                <div class="cv-label">প্রার্থীর কোড</div>
                                <div class="cv-val font-monospace text-maroon fw-bold">{{ $candidateProfile->profile_code }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="cv-info-tile">
                                <div class="cv-label">বয়স (Age)</div>
                                <div class="cv-val">{{ $candidateProfile->age }} বছর</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="cv-info-tile">
                                <div class="cv-label">উচ্চতা (Height)</div>
                                <div class="cv-val">{{ $candidateProfile->height }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="cv-info-tile">
                                <div class="cv-label">ধর্ম ও শাখা</div>
                                <div class="cv-val">{{ $candidateProfile->religion ?? 'Islam (Sunni)' }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="cv-info-tile">
                                <div class="cv-label">বৈবাহিক অবস্থা</div>
                                <div class="cv-val">{{ $candidateProfile->marital_status ?? 'অবিবাহিত (Never Married)' }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="cv-info-tile">
                                <div class="cv-label">স্থায়ী ঠিকানা / দেশের বাড়ি</div>
                                <div class="cv-val">{{ $candidateProfile->desher_bari }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="cv-info-tile">
                                <div class="cv-label">বর্তমান বসবাসের এলাকা</div>
                                <div class="cv-val">{{ $candidateProfile->location }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="cv-info-tile">
                                <div class="cv-label">ক্যাটাগরি</div>
                                <div class="cv-val">{{ $candidateProfile->category ?? 'Elite Professional' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Education & Career Dossier -->
                <div class="cv-section mb-5">
                    <h5 class="cv-section-title font-serif">
                        <i class="bi bi-mortarboard-fill text-maroon me-2"></i>২. শিক্ষাগত যোগ্যতা ও ক্যারিয়ার প্রোফাইল
                    </h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="cv-info-tile">
                                <div class="cv-label">সর্বোচ্চ ডিগ্রি ও শিক্ষা প্রতিষ্ঠান</div>
                                <div class="cv-val fw-semibold fs-6 text-dark lh-base">
                                    {{ $candidateProfile->education }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="cv-info-tile">
                                <div class="cv-label">বর্তমান পেশা ও পদবী</div>
                                <div class="cv-val fw-semibold text-dark">
                                    {{ $candidateProfile->profession }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="cv-info-tile">
                                <div class="cv-label">বার্ষিক আয় / উপার্জন পরিসর</div>
                                <div class="cv-val text-success fw-bold">
                                    {{ $candidateProfile->income }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Family Lineage & Heritage -->
                <div class="cv-section mb-5">
                    <h5 class="cv-section-title font-serif">
                        <i class="bi bi-house-heart-fill text-maroon me-2"></i>৩. পারিবারিক পরিচয় ও বংশমর্যাদা
                    </h5>
                    <div class="cv-info-tile p-4">
                        <div class="cv-label mb-2">পিতা-মাতার বিবরণ, ভাই-বোন ও পারিবারিক ঐতিহ্য</div>
                        <div class="cv-val lh-lg text-secondary" style="font-size: 0.95rem; white-space: pre-line;">
                            {{ $candidateProfile->family }}
                        </div>
                    </div>
                </div>

                <!-- 4. Partner Preferences -->
                <div class="cv-section mb-5">
                    <h5 class="cv-section-title font-serif">
                        <i class="bi bi-heart-pulse-fill text-danger me-2"></i>৪. কাঙ্ক্ষিত জীবনসঙ্গী (Partner Preferences)
                    </h5>
                    <div class="row g-3">
                        <div class="col-sm-6 col-md-3">
                            <div class="cv-info-tile">
                                <div class="cv-label">কাঙ্ক্ষিত বয়স সীমা</div>
                                <div class="cv-val">
                                    @if($candidateProfile->pref_age_min || $candidateProfile->pref_age_max)
                                        {{ $candidateProfile->pref_age_min ?? '১৮' }} - {{ $candidateProfile->pref_age_max ?? '৪০' }} বছর
                                    @else
                                        উভয় পক্ষের সম্মতি সাপেক্ষে
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="cv-info-tile">
                                <div class="cv-label">কাঙ্ক্ষিত উচ্চতা</div>
                                <div class="cv-val">
                                    {{ $candidateProfile->pref_height_min ?? "৫'০\"" }} - {{ $candidateProfile->pref_height_max ?? "৬'০\"" }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="cv-info-tile">
                                <div class="cv-label">পছন্দের দেশের বাড়ি (জেলা)</div>
                                <div class="cv-val">
                                    {{ $candidateProfile->pref_desher_bari ?? 'যেকোনো উপযুক্ত জেলা' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="cv-info-tile">
                                <div class="cv-label">প্রত্যাশিত শিক্ষাগত যোগ্যতা</div>
                                <div class="cv-val">
                                    {{ $candidateProfile->pref_education ?? 'স্নাতক / সমমর্যাদার ডিগ্রিধারী' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="cv-info-tile">
                                <div class="cv-label">প্রত্যাশিত পেশা</div>
                                <div class="cv-val">
                                    {{ $candidateProfile->pref_profession ?? 'সুপ্রতিষ্ঠিত চাকরিজীবী / ব্যবসায়ী' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. Verification & Concierge Seal -->
                <div class="p-4 rounded-4 bg-light border border-warning-subtle d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-maroon text-white fw-bold d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.3rem;">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark font-serif fs-6">অফিসিয়াল বায়োডাটা ভেরিফিকেশন ও নিরাপত্তা সনদ</div>
                            <div class="small text-muted">
                                এই বায়োডাটাটি {{ site_setting('site_name', 'Biye Marriage Media') }} কনসিয়ার্জ টিমের মাধ্যমে সংরক্ষিত ও পরিচালিত।
                            </div>
                        </div>
                    </div>

                    <div class="no-print">
                        <a href="{{ route('member.biodata.edit') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 py-1.5 fw-semibold">
                            <i class="bi bi-pencil-square me-1"></i> তথ্য এডিট করুন
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Discreet Photo Blur */
.blur-discreet {
    filter: blur(8px);
    transition: filter 0.3s ease;
}

/* CV Container Aesthetics */
.cv-container-card {
    border: 1px solid rgba(201, 151, 56, 0.35) !important;
    background: #ffffff;
}

.cv-avatar-ring {
    width: 126px;
    height: 126px;
    border-radius: 50%;
    padding: 3px;
    background: linear-gradient(135deg, #c99738 0%, #851829 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
}

.cv-section-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #1e293b;
    border-bottom: 2px solid rgba(133, 24, 41, 0.12);
    padding-bottom: 0.6rem;
    margin-bottom: 1.25rem;
}

.cv-info-tile {
    background: #fdfdfd;
    border: 1px solid rgba(0, 0, 0, 0.07);
    border-radius: 12px;
    padding: 1rem 1.15rem;
    height: 100%;
    transition: all 0.2s ease;
}

.cv-info-tile:hover {
    border-color: rgba(201, 151, 56, 0.45);
    background: #ffffff;
    box-shadow: 0 4px 12px rgba(133, 24, 41, 0.04);
}

.cv-label {
    font-size: 0.76rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    margin-bottom: 0.35rem;
}

.cv-val {
    font-size: 0.95rem;
    color: #1e293b;
    font-weight: 600;
}

/* Print CSS */
@media print {
    body {
        background: #ffffff !important;
        color: #000000 !important;
    }
    .member-topbar, .member-navbar, .mobile-bottom-bar, footer, .no-print {
        display: none !important;
    }
    .cv-container-card {
        border: none !important;
        box-shadow: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection
