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

                <div class="mt-4 pt-3 border-top text-center">
                    <p class="small text-muted mb-2">Not an Elite Member yet?</p>
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#consultationModal">
                        Apply for Elite Membership
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
