@extends('member.layouts.app')

@section('title', 'আমার বায়োডাটা এডিটর - Biye Marriage Media')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-xl-10">
        <!-- Header Ribbon -->
        <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
            <div class="card-body p-4 d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="font-serif fw-bold text-dark mb-1">
                        <i class="bi bi-file-earmark-person-fill text-maroon me-2"></i>আমার বায়োডাটা ও পারিবারিক পরিচয়
                    </h4>
                    <p class="small text-muted mb-0">
                        সঠিক ও মার্জিত তথ্য প্রদান করে আপনার বায়োডাটা সমৃদ্ধ করুন।
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-light text-dark border px-3 py-2">
                        কোড: <strong class="text-maroon">{{ $candidateProfile->profile_code }}</strong>
                    </span>
                    <span class="badge bg-warning-subtle text-dark border px-3 py-2">
                        সম্পন্ন: <strong>{{ $candidateProfile->completion_score }}%</strong>
                    </span>
                </div>
            </div>
        </div>

        <form action="{{ route('member.biodata.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Section 1: Basic & Physical Info -->
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0 font-serif">
                        <i class="bi bi-person-lines-fill text-maroon me-2"></i>১. প্রাথমিক ও ব্যক্তিগত বিবরণ
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">প্রার্থীর নাম (গোপন রাখা হয়)</label>
                            <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $candidateProfile->full_name ?? $user->name) }}">
                            <div class="form-text small">নাম ওয়েবসাইটে সাধারণ দর্শকদের কাছে অপ্রকাশিত থাকবে।</div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">লিঙ্গ <span class="text-danger">*</span></label>
                            <select name="gender" class="form-select" required>
                                <option value="female" {{ old('gender', $candidateProfile->gender) === 'female' ? 'selected' : '' }}>পাত্রী (Female)</option>
                                <option value="male" {{ old('gender', $candidateProfile->gender) === 'male' ? 'selected' : '' }}>পাত্র (Male)</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">বয়স (Years) <span class="text-danger">*</span></label>
                            <input type="number" name="age" class="form-control" value="{{ old('age', $candidateProfile->age) }}" min="18" max="75" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">উচ্চতা <span class="text-danger">*</span></label>
                            <input type="text" name="height" class="form-control" value="{{ old('height', $candidateProfile->height) }}" placeholder="e.g. 5'5&quot;" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">ধর্ম ও শাখা <span class="text-danger">*</span></label>
                            <input type="text" name="religion" class="form-control" value="{{ old('religion', $candidateProfile->religion ?? 'Islam (Sunni)') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-semibold">দেশের বাড়ি (মূল জেলা) <span class="text-danger">*</span></label>
                            <input type="text" name="desher_bari" class="form-control" value="{{ old('desher_bari', $candidateProfile->desher_bari) }}" placeholder="e.g. Dhaka, Sylhet, Chattogram" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">বর্তমান বসবাসের অবস্থান <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control" value="{{ old('location', $candidateProfile->location) }}" placeholder="e.g. Gulshan-2, Dhaka" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">ক্যাটাগরি</label>
                            <select name="category" class="form-select">
                                <option value="Elite Professional" {{ old('category', $candidateProfile->category) === 'Elite Professional' ? 'selected' : '' }}>Elite Professional</option>
                                <option value="Elite Business" {{ old('category', $candidateProfile->category) === 'Elite Business' ? 'selected' : '' }}>Elite Business &amp; Industrialist</option>
                                <option value="Elite Aristocrat" {{ old('category', $candidateProfile->category) === 'Elite Aristocrat' ? 'selected' : '' }}>Elite Aristocrat &amp; Renowned Family</option>
                                <option value="Global NRB" {{ old('category', $candidateProfile->category) === 'Global NRB' ? 'selected' : '' }}>Global NRB (US/UK/Canada/Aus)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Education & Career -->
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0 font-serif">
                        <i class="bi bi-mortarboard-fill text-maroon me-2"></i>২. শিক্ষাগত যোগ্যতা ও পেশাগত অর্জন
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-semibold">সর্বোচ্চ ডিগ্রি ও শিক্ষা প্রতিষ্ঠান <span class="text-danger">*</span></label>
                            <textarea name="education" class="form-control" rows="2" placeholder="e.g. BSc in Computer Science &amp; Engineering from BUET, MBA from IBA (Dhaka University)" required>{{ old('education', $candidateProfile->education) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">পেশা ও বর্তমান পদবী <span class="text-danger">*</span></label>
                            <input type="text" name="profession" class="form-control" value="{{ old('profession', $candidateProfile->profession) }}" placeholder="e.g. Lead Software Architect at Multinational Fintech" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">বার্ষিক আয় / উপার্জন পরিসর <span class="text-danger">*</span></label>
                            <input type="text" name="income" class="form-control" value="{{ old('income', $candidateProfile->income) }}" placeholder="e.g. ৳35 Lakhs+ per annum" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Family Lineage -->
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0 font-serif">
                        <i class="bi bi-house-heart-fill text-maroon me-2"></i>৩. পারিবারিক পরিচয় ও পারিবারিক ঐতিহ্য
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">পিতার পেশা, মাতার পেশা, ভাই-বোনের বিবরণ ও পারিবারিক স্ট্যাটাস <span class="text-danger">*</span></label>
                        <textarea name="family" class="form-control" rows="4" placeholder="e.g. পিতা: অবসরপ্রাপ্ত যুগ্ম সচিব (গণপ্রজাতন্ত্রী বাংলাদেশ সরকার)। মাতা: গৃহিণী। ২ ভাই ও ১ বোন—বড় ভাই লন্ডনে ব্যারিস্টার, ছোট বোন ঢাকা বিশ্ববিদ্যালয়ে অধ্যয়নরত। পরিবারটি সুপ্রতিষ্ঠিত ও মার্জিত ইসলামিক মূল্যবোধে বিশ্বাসী।" required>{{ old('family', $candidateProfile->family) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section 4: Photo & Discreet Blur -->
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0 font-serif">
                        <i class="bi bi-camera-fill text-maroon me-2"></i>৪. ছবি ও গোপনীয়তা নিয়ন্ত্রণ (Photo Vault)
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center g-4">
                        <div class="col-12 col-md-3 text-center">
                            <img src="{{ $candidateProfile->resolved_image }}" alt="Candidate Preview" class="rounded-circle shadow object-fit-cover mb-2 border border-2 border-maroon" style="width: 100px; height: 100px;">
                            <div class="small text-muted">বর্তমান ছবি</div>
                        </div>
                        <div class="col-12 col-md-9">
                            <label class="form-label small fw-semibold">নতুন ছবি আপলোড করুন</label>
                            <input type="file" name="image" class="form-control mb-2" accept="image/jpeg,image/png,image/webp">
                            <div class="form-text small mb-3">সুপারিশ: মার্জিত ও স্পষ্ট পোর্ট্রেট ছবি আপলোড করুন (সর্বোচ্চ ৪ মেগাবাইট)।</div>

                            <!-- Discreet Mode Checkbox -->
                            <div class="form-check form-switch p-3 bg-light rounded-3 border">
                                <input class="form-check-input ms-0 me-3" type="checkbox" name="is_discreet" value="1" id="is_discreet" {{ old('is_discreet', $candidateProfile->is_discreet) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold text-dark small" for="is_discreet">
                                    <i class="bi bi-shield-lock text-maroon me-1"></i> ছবি ব্লার / Discreet Photo Mode সক্রিয় রাখুন
                                </label>
                                <div class="small text-muted ps-4 pt-1">
                                    অন থাকলে আপনার ছবি সাধারণ দর্শনার্থীদের কাছে ব্লার থাকবে। আপনি বা ম্যাচমেকার অনুমোদন দিলে তবেই অপর পরিবার দেখতে পাবে।
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 5: Partner Preferences -->
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold text-dark mb-0 font-serif">
                        <i class="bi bi-heart-pulse-fill text-danger me-2"></i>৫. কাঙ্ক্ষিত জীবনসঙ্গীর প্রত্যাশা (Partner Preferences)
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <label class="form-label small fw-semibold">সর্বনিম্ন বয়স</label>
                            <input type="number" name="pref_age_min" class="form-control" value="{{ old('pref_age_min', $candidateProfile->pref_age_min) }}" placeholder="e.g. 22" min="18" max="75">
                        </div>
                        <div class="col-6 col-md-3">
                            <label class="form-label small fw-semibold">সর্বোচ্চ বয়স</label>
                            <input type="number" name="pref_age_max" class="form-control" value="{{ old('pref_age_max', $candidateProfile->pref_age_max) }}" placeholder="e.g. 30" min="18" max="75">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">পছন্দের দেশের বাড়ি (জেলা)</label>
                            <input type="text" name="pref_desher_bari" class="form-control" value="{{ old('pref_desher_bari', $candidateProfile->pref_desher_bari) }}" placeholder="e.g. Dhaka, Cumilla, Sylhet">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">কাঙ্ক্ষিত শিক্ষাগত যোগ্যতা</label>
                            <input type="text" name="pref_education" class="form-control" value="{{ old('pref_education', $candidateProfile->pref_education) }}" placeholder="e.g. Minimum Graduate / Doctor / Engineer">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold">কাঙ্ক্ষিত পেশা</label>
                            <input type="text" name="pref_profession" class="form-control" value="{{ old('pref_profession', $candidateProfile->pref_profession) }}" placeholder="e.g. BCS Cadre, Doctor, Engineer, Banker, Reputed Business">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button Card -->
            <div class="card border-0 shadow-sm rounded-4 bg-white mb-5">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div class="small text-muted">
                        <i class="bi bi-shield-check text-success me-1"></i> তথ্য সংরক্ষণ শেষে ম্যাচমেকার রিভিউ সম্পূর্ণ করা হবে।
                    </div>
                    <button type="submit" class="btn btn-elite-primary px-5 py-2.5 rounded-pill fw-semibold fs-6">
                        <i class="bi bi-check2-circle me-1.5"></i> বায়োডাটা সংরক্ষণ করুন
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
