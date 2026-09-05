@extends('layouts.app')

@section('title', 'Packages - Membership Plans in Bangladesh (BDT ৳) | Biye Marriage Media')

@section('content')

<!-- Packages Hero -->
<section class="py-5" style="background: linear-gradient(135deg, #440710 0%, #751423 50%, #2a050b 100%); color: #fff;">
    <div class="container text-center py-4">
        <span class="hero-crest-badge">
            <i class="bi bi-crown text-gold"></i> Bespoke Tiers in Bangladesh
        </span>
        <h1 class="display-5 font-serif fw-bold text-white mb-3">Elite Membership Packages</h1>
        <p class="fs-5 text-white-50 mx-auto" style="max-width: 720px;">
            Carefully structured memberships designed to cater to high-net-worth professionals, entrepreneurial families, and ultra-high-net-worth dynasties across Bangladesh and the NRB diaspora.
        </p>
    </div>
</section>

<!-- Package Cards Section -->
<section class="section-padding bg-soft">
    <div class="container">
        <div class="row g-4 align-items-stretch mb-5">
            @foreach($packages as $pkg)
            <div class="col-lg-4 d-flex">
                <div class="package-card w-100 {{ $pkg['featured'] ? 'featured' : '' }}">
                    @if($pkg['featured'])
                        <div class="package-ribbon">Most Preferred in BD</div>
                    @endif

                    <div class="package-header">
                        <div class="package-meta-bar">
                            <span class="package-category-badge {{ $pkg['featured'] ? 'featured' : '' }}">
                                {{ $pkg['badge'] }}
                            </span>
                            <i class="bi bi-crown-fill package-crown-icon {{ $pkg['featured'] ? 'featured' : '' }}"></i>
                        </div>

                        <h3 class="package-tier-name font-serif">{{ $pkg['name'] }}</h3>
                        <p class="package-target">{{ $pkg['description'] }}</p>
                    </div>

                    <div class="package-divider"></div>

                    <ul class="package-features">
                        @foreach($pkg['benefits'] as $benefit)
                        <li>
                            <i class="bi bi-check2-circle"></i>
                            <span>{{ $benefit }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <div class="package-footer">
                        <button type="button" class="btn {{ $pkg['featured'] ? 'btn-elite-primary shadow-sm' : 'btn-elite-outline' }} w-100 py-2.5" data-bs-toggle="modal" data-bs-target="#consultationModal">
                            Request Fee Details (BDT ৳) & Consultation
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Comparison Matrix -->
<section class="section-padding bg-white border-top">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Feature Comparison</span>
            <h2 class="section-title">Package Comparison Matrix (Bangladesh)</h2>
            <p class="section-desc">
                Review the privileges and personalized services included in each membership tier.
            </p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center shadow-sm rounded-4 overflow-hidden">
                <thead class="bg-maroon text-white font-serif">
                    <tr>
                        <th class="text-start py-3 px-4" style="width: 40%; background: #5e0d1b;">Service & Privilege</th>
                        <th class="py-3" style="width: 20%; background: #751423;">Elite Professional</th>
                        <th class="py-3" style="width: 20%; background: #851829; border-left: 2px solid #c99738; border-right: 2px solid #c99738;">
                            Elite Business <span class="badge bg-gold text-dark ms-1">Popular</span>
                        </th>
                        <th class="py-3" style="width: 20%; background: #5e0d1b;">Elite Aristocrat</th>
                    </tr>
                </thead>
                <tbody class="small">
                    <tr>
                        <td class="text-start py-3 px-4 fw-semibold text-dark">Dedicated Relationship Manager</td>
                        <td><span class="text-success fw-bold">Senior Specialist</span></td>
                        <td style="background: #fdf9f1;"><span class="text-success fw-bold">Principal RM (HNI Specialist)</span></td>
                        <td><span class="text-maroon fw-bold">Director / Board-Level</span></td>
                    </tr>
                    <tr>
                        <td class="text-start py-3 px-4 fw-semibold text-dark">Target Demographic</td>
                        <td>BCS Cadres, BUET/IBA, Doctors, CXOs</td>
                        <td style="background: #fdf9f1;">Industrialists, RMG Exporters, Merchants</td>
                        <td>Billionaires, Top Dynasties & Celebrities</td>
                    </tr>
                    <tr>
                        <td class="text-start py-3 px-4 fw-semibold text-dark">In-Person Family Residence Visits</td>
                        <td>Dhaka / Chattogram Office</td>
                        <td style="background: #fdf9f1;"><i class="bi bi-check-circle-fill text-success fs-5"></i> Gulshan, DOHS, Khulshi Home Visits</td>
                        <td><i class="bi bi-check-circle-fill text-success fs-5"></i> Unlimited Executive Residence Visits</td>
                    </tr>
                    <tr>
                        <td class="text-start py-3 px-4 fw-semibold text-dark">Confidential Blind Matchmaking</td>
                        <td><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                        <td style="background: #fdf9f1;"><i class="bi bi-check-circle-fill text-success fs-5"></i></td>
                        <td><i class="bi bi-check-circle-fill text-success fs-5"></i> 100% Blind (Zero Online Trace)</td>
                    </tr>
                    <tr>
                        <td class="text-start py-3 px-4 fw-semibold text-dark">Weekly Curated Recommendations</td>
                        <td>3 - 5 Handpicked</td>
                        <td style="background: #fdf9f1;">5 - 8 Priority Matches</td>
                        <td>Bespoke Scouting & Introductions</td>
                    </tr>
                    <tr>
                        <td class="text-start py-3 px-4 fw-semibold text-dark">Global NRB Outreach (UK/US/Gulf)</td>
                        <td>Select Hubs</td>
                        <td style="background: #fdf9f1;"><i class="bi bi-check-circle-fill text-success fs-5"></i> London, NY, Toronto, Dubai</td>
                        <td><i class="bi bi-check-circle-fill text-success fs-5"></i> Worldwide VIP Concierge</td>
                    </tr>
                    <tr>
                        <td class="text-start py-3 px-4 fw-semibold text-dark">Meeting Coordination & Venue Liaison</td>
                        <td>Assisted Scheduling</td>
                        <td style="background: #fdf9f1;"><i class="bi bi-check-circle-fill text-success fs-5"></i> Radisson, Westin, InterCon</td>
                        <td><i class="bi bi-check-circle-fill text-success fs-5"></i> Private Lounges & Luxury Venues</td>
                    </tr>
                    <tr>
                        <td class="text-start py-3 px-4 fw-semibold text-dark">Verification Protocols</td>
                        <td>NID & Academic Verification</td>
                        <td style="background: #fdf9f1;">NID, TIN & Asset Audit</td>
                        <td>Discrete Lineage & Forensic Audit</td>
                    </tr>
                    <tr class="bg-light">
                        <td class="text-start py-4 px-4 fw-bold">Consultation & Enrollment</td>
                        <td class="py-4">
                            <button type="button" class="btn btn-outline-dark btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#consultationModal">Select Plan</button>
                        </td>
                        <td class="py-4" style="background: #fdf9f1;">
                            <button type="button" class="btn btn-elite-primary btn-sm px-4" data-bs-toggle="modal" data-bs-target="#consultationModal">Apply for Business</button>
                        </td>
                        <td class="py-4">
                            <button type="button" class="btn btn-elite-gold btn-sm px-3" data-bs-toggle="modal" data-bs-target="#consultationModal">Private Invitation</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Membership Criteria in Bangladesh -->
<section class="section-padding bg-soft">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Eligibility</span>
            <h2 class="section-title">Who Qualifies for Biye Marriage Media?</h2>
            <p class="section-desc">
                To preserve the exclusivity of our circle, all candidate families must meet specific social, educational, or entrepreneurial criteria.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 border border-warning-subtle h-100 shadow-sm">
                    <i class="bi bi-mortarboard-fill fs-2 text-maroon mb-3 d-block"></i>
                    <h5 class="font-serif fw-bold text-dark mb-2">Education & Career Pedigree</h5>
                    <p class="small text-muted mb-0">
                        Graduates from premier institutions (BUET, IBA - Dhaka University, DMC, IUT, NSU) or elite foreign universities (Ivy League, UK Russell Group, LSE, Oxford) holding senior corporate, medical, or legal leadership roles.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 border border-warning-subtle h-100 shadow-sm">
                    <i class="bi bi-briefcase-fill fs-2 text-maroon mb-3 d-block"></i>
                    <h5 class="font-serif fw-bold text-dark mb-2">Industrialists & RMG Exporters</h5>
                    <p class="small text-muted mb-0">
                        Second or third generation successors of prominent Bangladeshi business conglomerates, garments/textile export houses, pharmaceuticals, shipping lines, and venture founders.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 border border-warning-subtle h-100 shadow-sm">
                    <i class="bi bi-bank fs-2 text-maroon mb-3 d-block"></i>
                    <h5 class="font-serif fw-bold text-dark mb-2">Civil Services & Armed Forces</h5>
                    <p class="small text-muted mb-0">
                        Officers of Bangladesh Civil Service (BCS Administration, Foreign Affairs, Police, Judiciary), Bangladesh Armed Forces (Army, Navy, Air Force) or celebrated aristocratic family lineages.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
