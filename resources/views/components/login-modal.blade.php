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

                <!-- New User / Registration Prompt (Clean & Minimal) -->
                <div class="mt-4 pt-3 border-top text-center">
                    <p class="text-secondary mb-2" style="font-size: 0.86rem;">
                        New user or don't have an account yet?
                    </p>
                    <div>
                        <button type="button" class="btn btn-switch-register btn-sm rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-1.5" id="btnSwitchToRegister" data-bs-dismiss="modal">
                            <i class="bi bi-person-plus-fill"></i>
                            <span>Register Profile</span>
                        </button>
                    </div>

                    <!-- Discreet Admin Login Link -->
                    <div class="mt-3 pt-1">
                        <a href="{{ route('admin.login') }}" class="small text-muted text-decoration-none" style="font-size: 0.76rem;">
                            <i class="bi bi-shield-lock me-1 text-gold"></i> Administrative Staff? <strong class="text-secondary">Login to Admin Portal &rarr;</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-switch-register {
    color: var(--theme-primary, #851829);
    border: 1.5px solid rgba(133, 24, 41, 0.35);
    background: rgba(133, 24, 41, 0.04);
    font-size: 0.86rem;
    transition: all 0.25s ease;
}
.btn-switch-register:hover,
.btn-switch-register:focus {
    background: var(--theme-primary, #851829) !important;
    border-color: var(--theme-primary, #851829) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 14px rgba(133, 24, 41, 0.25) !important;
    transform: translateY(-1.5px);
}
.btn-switch-register:hover i,
.btn-switch-register:focus i {
    color: #ffffff !important;
}
</style>

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
