@extends('layouts.app')

@section('title', 'Contact Us & Regional Hubs - VIP Concierge Bangladesh | Biye Marriage Media')

@section('content')

<!-- Contact Hero -->
<section class="py-5" style="background: linear-gradient(135deg, #440710 0%, #751423 50%, #2a050b 100%); color: #fff;">
    <div class="container text-center py-4">
        <span class="hero-crest-badge">
            <i class="bi bi-headset text-gold"></i> VIP Family Concierge
        </span>
        <h1 class="display-5 font-serif fw-bold text-white mb-3">Contact Biye Marriage Media</h1>
        <p class="fs-5 text-white-50 mx-auto" style="max-width: 720px;">
            Schedule a private, confidential consultation at your residence in Gulshan/Banani/DOHS/Khulshi, our regional hubs, or virtually with a Senior Relationship Specialist.
        </p>
    </div>
</section>

<!-- Contact Form & Concierge Details -->
<section class="section-padding bg-soft">
    <div class="container">
        <div class="row g-5">
            <!-- Left Contact Info -->
            <div class="col-lg-5">
                <div class="bg-white p-4 p-md-5 rounded-4 border border-warning-subtle shadow-sm h-100">
                    <span class="section-tag">Direct Access</span>
                    <h3 class="font-serif fw-bold text-maroon mb-4">Dedicated Helpline</h3>

                    <!-- Priority Phones -->
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="rounded-circle bg-gold-subtle text-maroon p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-telephone-fill fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Priority Contact Numbers</h6>
                            <div class="d-flex flex-column gap-1">
                                <a href="tel:+8801577711210" class="text-maroon fs-5 fw-bold text-decoration-none">+880 1577-711210</a>
                                <a href="tel:+8801577733404" class="text-maroon fs-5 fw-bold text-decoration-none">+880 1577-733404</a>
                            </div>
                            <p class="small text-muted mb-0 mt-1">Saturday to Friday, 9:00 AM - 10:00 PM BST</p>
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="rounded-circle bg-success-subtle text-success p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-whatsapp fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">WhatsApp VIP Concierge</h6>
                            <a href="https://wa.me/8801577711210" target="_blank" class="text-success fs-6 fw-bold text-decoration-none">Chat Directly on WhatsApp (+880 1577-711210)</a>
                            <p class="small text-muted mb-0">Instant, discrete family coordination</p>
                        </div>
                    </div>

                    <!-- Email & Website -->
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="rounded-circle bg-gold-subtle text-maroon p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-envelope-fill fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Email & Official Website</h6>
                            <a href="mailto:biyemarriagemedia@gmail.com" class="text-maroon fw-semibold text-decoration-none d-block">biyemarriagemedia@gmail.com</a>
                            <a href="https://www.biyemarriagemedia.com" target="_blank" class="text-secondary small text-decoration-none d-block mt-1">
                                <i class="bi bi-globe me-1 text-gold"></i> www.biyemarriagemedia.com
                            </a>
                        </div>
                    </div>

                    <!-- Head Office Address -->
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="rounded-circle bg-gold-subtle text-maroon p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="bi bi-geo-alt-fill fs-5"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">Head Office Address</h6>
                            <p class="text-secondary small mb-0 leading-relaxed">
                                Ka-57/3, Second Floor, Kuril Chowrasta, Vatara, Dhaka, Bangladesh, 1212
                            </p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="p-3 rounded-3 bg-maroon text-white text-center">
                        <i class="bi bi-house-door-fill text-gold fs-4 mb-1 d-block"></i>
                        <h6 class="fw-bold mb-1">In-Person Residence Consultations</h6>
                        <p class="small text-white-50 mb-0">
                            Our matchmakers conduct discreet home visits across Dhaka and nationwide upon appointment with family guardians.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Consultation Form -->
            <div class="col-lg-7">
                <div class="bg-white p-4 p-md-5 rounded-4 border border-warning-subtle shadow-sm">
                    <span class="section-tag">Book Consultation</span>
                    <h3 class="font-serif fw-bold text-maroon mb-2">Request an In-Depth Meeting</h3>
                    <p class="text-muted small mb-4">Fill out your preliminary details. We will contact you discreetly.</p>

                    <form action="{{ route('consultation.submit') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Looking Alliance For</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="looking_for" id="contactBride" value="Bride" checked>
                                        <label class="form-check-label small" for="contactBride">Bride (Patri)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="looking_for" id="contactGroom" value="Groom">
                                        <label class="form-check-label small" for="contactGroom">Groom (Patro)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Profile Managed By</label>
                                <select class="form-select" name="profile_for" required>
                                    <option value="Daughter" selected>Daughter</option>
                                    <option value="Son">Son</option>
                                    <option value="Self">Self</option>
                                    <option value="Brother">Brother</option>
                                    <option value="Sister">Sister</option>
                                    <option value="Family Member">Family Guardian / Relative</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="full_name" placeholder="Full Name" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Contact Number <span class="text-danger">*</span></label>
                                <div class="input-group elite-input-group">
                                    <span class="input-group-text bg-light">+880</span>
                                    <input type="tel" class="form-control" name="phone" placeholder="01577711210" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="name@domain.com" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Current Residence (Area/City)</label>
                                <input type="text" class="form-control" name="city" placeholder="e.g. Gulshan-2 / Baridhara DOHS">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Desher Bari (District Origin)</label>
                                <input type="text" class="form-control" name="desher_bari" placeholder="e.g. Sylhet, Chattogram, Dhaka">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-dark">Annual Income / Business Assets</label>
                                <select class="form-select" name="annual_income">
                                    <option value="৳30 Lakh - ৳75 Lakh">৳30 Lakh - ৳75 Lakh</option>
                                    <option value="৳75 Lakh - ৳2 Crore">৳75 Lakh - ৳2 Crore</option>
                                    <option value="৳2 Crore - ৳10 Crore">৳2 Crore - ৳10 Crore</option>
                                    <option value="৳10 Crore+ / Conglomerate UHNI">৳10 Crore+ / Conglomerate UHNI</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-semibold text-dark">Preferred Package Tier</label>
                                <select class="form-select" name="preferred_package">
                                    <option value="Elite Professional">Elite Professional (BCS, Doctors, BUET, IBA, CXOs)</option>
                                    <option value="Elite Business" selected>Elite Business (Industrialists, RMG Exporters, Merchants)</option>
                                    <option value="Elite Aristocrat">Elite Aristocrat (Top Conglomerates, Billionaires & Celebrated Lineages)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 pt-2">
                            <button type="submit" class="btn btn-elite-primary btn-lg w-100 py-3 fs-6 d-flex justify-content-center align-items-center gap-2 text-center">
                                <i class="bi bi-send-check"></i>
                                <span>Submit Confidential Inquiry</span>
                            </button>
                            <p class="small text-muted text-center mt-2 mb-0">
                                <i class="bi bi-shield-check text-success me-1"></i> A Senior Relationship Manager will contact you discreetly within 24 hours.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Regional Offices Grid -->
        <div class="mt-5 pt-4">
            <div class="section-header">
                <span class="section-tag">Nationwide & Global</span>
                <h3 class="section-title">Our Metropolitan Presence</h3>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-4 border border-warning-subtle shadow-sm h-100">
                        <h5 class="font-serif fw-bold text-maroon mb-1">Dhaka Head Office</h5>
                        <p class="small text-muted mb-2">Ka-57/3, Second Floor, Kuril Chowrasta, Vatara, Dhaka-1212</p>
                        <p class="small text-secondary mb-0"><i class="bi bi-telephone text-gold me-1"></i> +880 1577-711210</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-4 border border-warning-subtle shadow-sm h-100">
                        <h5 class="font-serif fw-bold text-maroon mb-1">Dhaka Diplomatic / DOHS</h5>
                        <p class="small text-muted mb-2">Baridhara DOHS & Uttara Sector 4, Dhaka</p>
                        <p class="small text-secondary mb-0"><i class="bi bi-telephone text-gold me-1"></i> +880 2 841 7800</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-4 border border-warning-subtle shadow-sm h-100">
                        <h5 class="font-serif fw-bold text-maroon mb-1">Chattogram Regional Hub</h5>
                        <p class="small text-muted mb-2">GEC Circle, Nasirabad / Khulshi, Chattogram</p>
                        <p class="small text-secondary mb-0"><i class="bi bi-telephone text-gold me-1"></i> +880 31 654 320</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-4 border border-warning-subtle shadow-sm h-100">
                        <h5 class="font-serif fw-bold text-maroon mb-1">Sylhet NRI Concierge Desk</h5>
                        <p class="small text-muted mb-2">Main Road, Upashahar & Zindabazar, Sylhet</p>
                        <p class="small text-secondary mb-0"><i class="bi bi-telephone text-gold me-1"></i> +880 821 723 900</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-4 border border-warning-subtle shadow-sm h-100">
                        <h5 class="font-serif fw-bold text-maroon mb-1">London (UK) NRB Desk</h5>
                        <p class="small text-muted mb-2">Canary Wharf & Brick Lane, London, UK</p>
                        <p class="small text-secondary mb-0"><i class="bi bi-telephone text-gold me-1"></i> +44 20 7946 0192</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-4 bg-white rounded-4 border border-warning-subtle shadow-sm h-100">
                        <h5 class="font-serif fw-bold text-maroon mb-1">New York & Dubai Desks</h5>
                        <p class="small text-muted mb-2">Midtown Manhattan, NY & Downtown Dubai, UAE</p>
                        <p class="small text-secondary mb-0"><i class="bi bi-telephone text-gold me-1"></i> +1 212 555 0184</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
