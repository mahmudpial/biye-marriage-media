@extends('layouts.app')

@section('title', 'সদস্য লগইন - Biye Marriage Media | Elite Matrimony Portal')

@section('content')
<div class="py-5" style="background: linear-gradient(180deg, #fdfbf7 0%, #f4efe9 100%); min-height: 80vh;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <!-- Header Banner -->
                    <div class="p-4 text-center text-white" style="background: linear-gradient(135deg, var(--theme-primary, #851829) 0%, #4a0d17 100%);">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white text-maroon p-2 mb-2 shadow-sm" style="width: 50px; height: 50px;">
                            <i class="bi bi-shield-lock-fill fs-4"></i>
                        </div>
                        <h4 class="font-serif fw-bold mb-1">এলিট মেম্বার অ্যাক্সেস</h4>
                        <p class="small text-white-50 mb-0">আপনার নিবন্ধিত মেম্বার অ্যাকাউন্টে সাইন ইন করুন</p>
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

                        <form action="{{ route('login.submit') }}" method="POST">
                            @csrf

                            <!-- Email / Mobile -->
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-dark">নিবন্ধিত মোবাইল নম্বর বা ইমেইল</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person text-secondary"></i></span>
                                    <input type="text" name="login" value="{{ old('login') }}" class="form-control" placeholder="017XXXXXXXX বা name@email.com" required autofocus>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label small fw-semibold text-dark mb-0">পাসওয়ার্ড</label>
                                    <span class="small text-muted" title="পাসওয়ার্ড ভুলে গেলে আপনার ম্যাচমেকারের সাথে যোগাযোগ করুন">ভুলে গেছেন?</span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-key text-secondary"></i></span>
                                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                    <label class="form-check-label small text-muted" for="rememberMe">
                                        আমাকে মনে রাখুন
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-elite-primary w-100 py-2.5 rounded-pill fw-semibold fs-6 mb-4">
                                <i class="bi bi-box-arrow-in-right me-1.5"></i> সাইন ইন করুন
                            </button>

                            <!-- New User Prompt -->
                            <div class="pt-3 border-top text-center">
                                <p class="text-secondary small mb-2">
                                    নতুন ইউজার অথবা এখনো কোনো অ্যাকাউন্ট নেই?
                                </p>
                                <a href="{{ route('register') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4 py-2 fw-semibold">
                                    <i class="bi bi-person-plus-fill me-1 text-maroon"></i> নতুন প্রোফাইল রেজিস্টার করুন &rarr;
                                </a>
                            </div>

                            <!-- Administrative Staff Link -->
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.login') }}" class="small text-muted text-decoration-none" style="font-size: 0.78rem;">
                                    <i class="bi bi-shield-lock me-1 text-gold"></i> প্রশাসনিক কর্মকর্তা? <strong class="text-secondary">অ্যাডমিন লগইন &rarr;</strong>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
