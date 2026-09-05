<!-- VIP Consultation Request Modal (Bangladesh) -->
<div class="modal fade elite-modal" id="consultationModal" tabindex="-1" aria-labelledby="consultationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h4 class="modal-title font-serif fw-bold text-white mb-1" id="consultationModalLabel">
                        <i class="bi bi-shield-lock me-2 text-gold"></i>Request Confidential Consultation
                    </h4>
                    <p class="small text-white-50 mb-0">Our Senior Matchmaker will contact you with 100% discretion.</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white">
                <form action="{{ route('consultation.submit') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <!-- Looking For -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Seeking Alliance For</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="looking_for" id="modalSeekBride" value="Bride" checked>
                                    <label class="form-check-label small" for="modalSeekBride">Bride (Patri)</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="looking_for" id="modalSeekGroom" value="Groom">
                                    <label class="form-check-label small" for="modalSeekGroom">Groom (Patro)</label>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Managed By -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Creating Profile For</label>
                            <select class="form-select" name="profile_for" required>
                                <option value="Daughter" selected>Daughter</option>
                                <option value="Son">Son</option>
                                <option value="Self">Self</option>
                                <option value="Brother">Brother</option>
                                <option value="Sister">Sister</option>
                                <option value="Family Member">Family Guardian / Relative</option>
                            </select>
                        </div>

                        <!-- Contact Full Name -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Full Name of Contact Person <span class="text-danger">*</span></label>
                            <div class="input-group elite-input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-person text-secondary"></i></span>
                                <input type="text" class="form-control" name="full_name" placeholder="e.g. Barrister / Al-Hajj Rahman" required>
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Mobile / WhatsApp Number <span class="text-danger">*</span></label>
                            <div class="input-group elite-input-group">
                                <span class="input-group-text bg-light">+880</span>
                                <input type="tel" class="form-control" name="phone" placeholder="01577-711210" required>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group elite-input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-envelope text-secondary"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="name@familyoffice.com" required>
                            </div>
                        </div>

                        <!-- Current Residence -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Current Residence / Area</label>
                            <div class="input-group elite-input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-geo-alt text-secondary"></i></span>
                                <input type="text" class="form-control" name="city" placeholder="e.g. Gulshan-2, Dhaka / London NRB">
                            </div>
                        </div>

                        <!-- District of Origin (Desher Bari) -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">District of Origin (Desher Bari)</label>
                            <div class="input-group elite-input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-compass text-secondary"></i></span>
                                <input type="text" class="form-control" name="desher_bari" placeholder="e.g. Sylhet, Chattogram, Dhaka, Cumilla">
                            </div>
                        </div>

                        <!-- Preferred Tier -->
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Interested Membership Tier</label>
                            <select class="form-select" name="preferred_package">
                                <option value="Elite Professional">Elite Professional (BCS, Doctors, BUET, IBA, CXOs)</option>
                                <option value="Elite Business" selected>Elite Business (Industrialists, RMG Exporters, Founders)</option>
                                <option value="Elite Aristocrat">Elite Aristocrat (Top Dynasties, Conglomerates & UHNI NRBs)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 pt-2 text-center border-top">
                        <button type="submit" class="btn btn-elite-primary btn-lg w-100 py-2.5 fs-6 d-flex justify-content-center align-items-center gap-2 text-center">
                            <i class="bi bi-lock-fill"></i>
                            <span>Request Confidential Callback</span>
                        </button>
                        <p class="text-muted small mt-2 mb-0">
                            <i class="bi bi-shield-check text-success me-1"></i>Your information is safeguarded with strict non-disclosure and will never be shared publicly.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
