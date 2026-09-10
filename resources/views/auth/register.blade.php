@extends('layouts.app')

@section('title', 'রেজিস্ট্রেশন - Biye Marriage Media | Elite Matrimony Portal')

@section('content')
<div class="py-5" style="background: linear-gradient(180deg, #fdfbf7 0%, #f4efe9 100%); min-height: 85vh;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <!-- Header Banner -->
                    <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, var(--theme-primary, #851829) 0%, #4a0d17 100%);">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white text-maroon p-2 mb-2 shadow-sm" style="width: 54px; height: 54px;">
                            <i class="bi bi-person-plus-fill fs-3"></i>
                        </div>
                        <h3 class="font-serif fw-bold mb-1">রেজিস্ট্রেশন করুন</h3>
                        <p class="small text-white-50 mb-0">Biye Marriage Media-তে পাত্র-পাত্রীর উপযুক্ত ম্যাচমেকিং অ্যাকাউন্ট খুলুন</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        @if($errors->any())
                            <div class="alert alert-danger rounded-3 py-2 small mb-4">
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $err)
                                        <li>{{ $err }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register.submit') }}" method="POST">
                            @csrf

                            <!-- Profile For -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-dark">অ্যাকাউন্টটি কার জন্য খোলা হচ্ছে? <span class="text-danger">*</span></label>
                                <select name="profile_for" id="regProfileFor" class="form-select" required onchange="handleProfileForChange(this)">
                                    <option value="self" {{ old('profile_for') === 'self' ? 'selected' : '' }}>আমার নিজের জন্য (Self)</option>
                                    <option value="daughter" {{ old('profile_for') === 'daughter' ? 'selected' : '' }}>মেয়ের জন্য (Daughter)</option>
                                    <option value="son" {{ old('profile_for') === 'son' ? 'selected' : '' }}>ছেলের জন্য (Son)</option>
                                    <option value="brother" {{ old('profile_for') === 'brother' ? 'selected' : '' }}>ভাইয়ের জন্য (Brother)</option>
                                    <option value="sister" {{ old('profile_for') === 'sister' ? 'selected' : '' }}>বোনের জন্য (Sister)</option>
                                    <option value="relative" {{ old('profile_for') === 'relative' ? 'selected' : '' }}>অন্যান্য আত্মীয় / অভিভাবক (Relative)</option>
                                </select>
                            </div>

                            <!-- Guardian Name (Visible when guardian creates) -->
                            <div class="mb-3" id="guardianFieldGroup" style="display: {{ old('profile_for', 'self') === 'self' ? 'none' : 'block' }};">
                                <label class="form-label small fw-semibold text-dark">অভিভাবকের পূর্ণ নাম</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person-badge text-secondary"></i></span>
                                    <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" class="form-control" placeholder="e.g. Al-Hajj Abdul Karim">
                                </div>
                            </div>

                            <!-- Full Name -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-dark" id="lblCandidateName">আপনার পূর্ণ নাম <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person text-secondary"></i></span>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="e.g. Barrister / Engineer / Dr. ..." required>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-dark">পাত্র নাকি পাত্রী? <span class="text-danger">*</span></label>
                                <div class="d-flex gap-4 p-2 bg-light rounded-3 border">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female" {{ old('gender', 'female') === 'female' ? 'checked' : '' }} required>
                                        <label class="form-check-label small fw-semibold text-dark" for="genderFemale">
                                            পাত্রী (Bride / Female)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male" {{ old('gender') === 'male' ? 'checked' : '' }} required>
                                        <label class="form-check-label small fw-semibold text-dark" for="genderMale">
                                            পাত্র (Groom / Male)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile & Email -->
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-semibold text-dark">মোবাইল নম্বর <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">+880</span>
                                        <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="017XXXXXXXX" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-semibold text-dark">ইমেইল ঠিকানা <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-envelope text-secondary"></i></span>
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="name@example.com" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Desher Bari & Profession -->
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-semibold text-dark">দেশের বাড়ি (জেলা)</label>
                                    <input type="text" name="desher_bari" value="{{ old('desher_bari') }}" class="form-control" placeholder="e.g. Dhaka, Sylhet, Cumilla">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-semibold text-dark">পেশা</label>
                                    <input type="text" name="profession" value="{{ old('profession') }}" class="form-control" placeholder="e.g. Doctor, Software Engineer">
                                </div>
                            </div>

                            <!-- Password & Confirmation -->
                            <div class="row g-3 mb-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-semibold text-dark">পাসওয়ার্ড <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" placeholder="কমপক্ষে ৬ অক্ষর" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label small fw-semibold text-dark">কনফার্ম পাসওয়ার্ড <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="পুনরায় লিখুন" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-elite-primary w-100 py-2.5 rounded-pill fw-semibold fs-6 mb-3">
                                <i class="bi bi-arrow-right-circle me-1.5"></i> অ্যাকাউন্ট তৈরি করুন
                            </button>

                            <div class="text-center pt-2">
                                <span class="text-muted small">ইতিমধ্যে একটি অ্যাকাউন্ট রয়েছে?</span>
                                <a href="{{ route('login') }}" class="small fw-semibold text-maroon text-decoration-none ms-1">
                                    লগইন করুন &rarr;
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function handleProfileForChange(selectEl) {
        const val = selectEl.value;
        const guardianGroup = document.getElementById('guardianFieldGroup');
        const candidateLbl = document.getElementById('lblCandidateName');
        
        if (val === 'self') {
            guardianGroup.style.display = 'none';
            candidateLbl.innerHTML = 'আপনার পূর্ণ নাম <span class="text-danger">*</span>';
        } else {
            guardianGroup.style.display = 'block';
            candidateLbl.innerHTML = 'পাত্র / পাত্রীর পূর্ণ নাম <span class="text-danger">*</span>';
        }
    }
</script>
@endpush
@endsection
