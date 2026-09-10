<!-- Member Login Modal -->
<div class="modal fade elite-modal" id="memberLoginModal" tabindex="-1" aria-labelledby="memberLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title font-serif fw-bold text-white mb-0" id="memberLoginModalLabel">
                        <i class="bi bi-person-circle me-2 text-gold"></i>Elite Member Access
                    </h5>
                    <p class="small text-white-50 mb-0">Secure portal for active elite clients & families</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <ul class="nav nav-pills nav-fill mb-4 p-1 bg-light rounded-pill" id="loginTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill py-2 small fw-semibold" id="otp-tab" data-bs-toggle="pill" data-bs-target="#otp-login" type="button" role="tab" aria-controls="otp-login" aria-selected="true">
                            Login via OTP
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill py-2 small fw-semibold" id="pwd-tab" data-bs-toggle="pill" data-bs-target="#pwd-login" type="button" role="tab" aria-controls="pwd-login" aria-selected="false">
                            Password Login
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="loginTabContent">
                    <!-- OTP Login -->
                    <div class="tab-pane fade show active" id="otp-login" role="tabpanel" aria-labelledby="otp-tab">
                        <form onsubmit="event.preventDefault(); alert('For prototype demonstration: Please request a VIP consultation or contact your relationship manager.');">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-dark">Registered Mobile Number / Elite ID</label>
                                <div class="input-group elite-input-group">
                                    <span class="input-group-text bg-light">+880</span>
                                    <input type="tel" class="form-control" placeholder="Enter 10-digit mobile" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-elite-primary w-100 py-2 fw-medium mt-2">
                                Send Secret OTP
                            </button>
                        </form>
                    </div>

                    <!-- Password Login -->
                    <div class="tab-pane fade" id="pwd-login" role="tabpanel" aria-labelledby="pwd-tab">
                        <form onsubmit="event.preventDefault(); alert('For prototype demonstration: Please request a VIP consultation or contact your relationship manager.');">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-dark">Elite Member ID or Email</label>
                                <div class="input-group elite-input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-person text-secondary"></i></span>
                                    <input type="text" class="form-control" placeholder="e.g. ELT-78901 or name@domain.com" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label small fw-semibold text-dark mb-0">Password</label>
                                    <a href="#" class="small text-maroon text-decoration-none" onclick="alert('Please contact your dedicated relationship manager to reset credentials.')">Forgot?</a>
                                </div>
                                <div class="input-group elite-input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-key text-secondary"></i></span>
                                    <input type="password" class="form-control" placeholder="••••••••••••" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-elite-primary w-100 py-2 fw-medium mt-2">
                                Secure Sign In
                            </button>
                        </form>
                    </div>
                </div>

                <!-- New User / Registration Section -->
                <div class="mt-4 pt-3 border-top">
                    <div class="new-member-banner p-3.5 rounded-3" style="background: linear-gradient(135deg, #fdfbf7 0%, #f7f1e5 100%); border: 1px solid rgba(201, 151, 56, 0.35); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);">
                        <div class="d-flex align-items-center gap-2.5 mb-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 34px; height: 34px; background: rgba(133, 24, 41, 0.1); color: var(--theme-primary, #851829); border: 1px solid rgba(133, 24, 41, 0.25);">
                                <i class="bi bi-person-plus-fill fs-6"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.92rem; line-height: 1.2;">
                                    New to Biye Marriage Media?
                                </h6>
                                <span class="text-secondary" style="font-size: 0.77rem;">
                                    নতুন ব্যবহারকারী বা এখনও অ্যাকাউন্ট / বায়োডাটা তৈরি করেননি?
                                </span>
                            </div>
                        </div>
                        <p class="text-muted mb-3" style="font-size: 0.82rem; line-height: 1.45;">
                            Register your matrimonial profile or request a confidential VIP matchmaking consultation to connect with verified elite families.
                        </p>
                        <div class="d-grid">
                            <button type="button" class="btn btn-elite-primary py-2 px-3 rounded-pill fw-semibold shadow-sm d-inline-flex align-items-center justify-content-center gap-2" id="btnSwitchToRegister" data-bs-dismiss="modal">
                                <i class="bi bi-person-plus-fill"></i>
                                <span>Register Profile / Create Account</span>
                            </button>
                        </div>
                    </div>

                    <!-- Discreet Admin Login Link -->
                    <div class="mt-3 text-center">
                        <a href="{{ route('admin.login') }}" class="small text-muted text-decoration-none" style="font-size: 0.77rem;">
                            <i class="bi bi-shield-lock me-1 text-gold"></i> Administrative Staff? <strong class="text-secondary">Login to Admin Portal &rarr;</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const switchBtn = document.getElementById('btnSwitchToRegister');
        if (switchBtn) {
            switchBtn.addEventListener('click', function (e) {
                e.preventDefault();
                const loginModalEl = document.getElementById('memberLoginModal');
                const consultationModalEl = document.getElementById('consultationModal');
                
                if (loginModalEl && typeof bootstrap !== 'undefined') {
                    const loginModal = bootstrap.Modal.getInstance(loginModalEl);
                    if (loginModal) {
                        loginModal.hide();
                    }
                }
                
                setTimeout(function () {
                    if (consultationModalEl && typeof bootstrap !== 'undefined') {
                        const consultationModal = bootstrap.Modal.getOrCreateInstance(consultationModalEl);
                        consultationModal.show();
                    }
                }, 300);
            });
        }
    });
</script>
@endpush
