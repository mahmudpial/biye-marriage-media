@extends('layouts.app')

@section('title', 'Search Profiles - Confidential Matchmaking | Biye Marriage Media')

@section('content')

<!-- Search Header -->
<section class="py-5" style="background: linear-gradient(135deg, #440710 0%, #751423 50%, #2a050b 100%); color: #fff;">
    <div class="container text-center py-4">
        <span class="hero-crest-badge">
            <i class="bi bi-shield-lock-fill text-gold"></i> Vetted Bangladeshi Portfolio
        </span>
        <h1 class="display-5 font-serif fw-bold text-white mb-3">Explore Elite Profiles in Bangladesh</h1>
        <p class="fs-5 text-white-50 mx-auto" style="max-width: 720px;">
            Preview sample verified profiles from our private registry. In accordance with family privacy traditions, full credentials and portfolios are shared privately by your Relationship Manager.
        </p>
    </div>
</section>

<!-- Filter and Profile Grid Section -->
<section class="section-padding bg-soft">
    <div class="container">
        <!-- Privacy Notice Alert -->
        <div class="alert alert-warning border border-warning-subtle shadow-sm rounded-4 p-3 mb-5 d-flex align-items-center gap-3 bg-gold-subtle">
            <i class="bi bi-shield-fill-check fs-2 text-maroon flex-shrink-0"></i>
            <div class="small">
                <strong>Confidential Matchmaking Protocol:</strong> Photographs and full identifying information are shielded to safeguard client family privacy and adhere to cultural modesty. Click <em>"Preview Profile"</em> on individual cards or contact your Relationship Manager for customized family portfolios.
            </div>
        </div>

        <div class="row g-4">
            <!-- Filter Sidebar -->
            <div class="col-lg-3">
                <div class="bg-white rounded-4 p-4 border border-warning-subtle shadow-sm sticky-top" style="top: 100px; z-index: 10;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="font-serif fw-bold text-maroon mb-0">Refine Search</h5>
                        <a href="{{ route('profiles') }}" class="small text-muted text-decoration-none"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
                    </div>

                    <form action="{{ route('profiles') }}" method="GET">
                        <!-- Gender Filter -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-dark">Looking For</label>
                            <select class="form-select form-select-sm" name="gender" onchange="this.form.submit()">
                                <option value="">All Profiles</option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Brides (Patri)</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Grooms (Patro)</option>
                            </select>
                        </div>

                        <!-- Membership Tier -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-dark">Elite Category</label>
                            <select class="form-select form-select-sm" name="category" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                <option value="Professional" {{ request('category') == 'Professional' ? 'selected' : '' }}>Elite Professional (BCS/BUET/IBA/Doctors)</option>
                                <option value="Business" {{ request('category') == 'Business' ? 'selected' : '' }}>Elite Business (Industrialists/RMG)</option>
                                <option value="Aristocrat" {{ request('category') == 'Aristocrat' ? 'selected' : '' }}>Elite Aristocrat (UHNI/Dynasties)</option>
                            </select>
                        </div>

                        <!-- District of Origin (Desher Bari) -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-dark">Desher Bari (District)</label>
                            <select class="form-select form-select-sm" name="desher_bari" onchange="this.form.submit()">
                                <option value="">All Districts</option>
                                <option value="Dhaka" {{ request('desher_bari') == 'Dhaka' ? 'selected' : '' }}>Dhaka</option>
                                <option value="Chattogram" {{ request('desher_bari') == 'Chattogram' ? 'selected' : '' }}>Chattogram</option>
                                <option value="Sylhet" {{ request('desher_bari') == 'Sylhet' ? 'selected' : '' }}>Sylhet</option>
                                <option value="Cumilla" {{ request('desher_bari') == 'Cumilla' ? 'selected' : '' }}>Cumilla</option>
                                <option value="Mymensingh" {{ request('desher_bari') == 'Mymensingh' ? 'selected' : '' }}>Mymensingh</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-elite-primary btn-sm w-100 py-2 mt-2">
                            <i class="bi bi-funnel me-1"></i> Apply Filters
                        </button>
                    </form>

                    <div class="border-top mt-4 pt-3 text-center">
                        <p class="small text-muted mb-2">Need a discrete shortlist?</p>
                        <button type="button" class="btn btn-outline-dark btn-sm rounded-pill w-100" data-bs-toggle="modal" data-bs-target="#consultationModal">
                            <i class="bi bi-telephone-inbound me-1"></i> Speak to Matchmaker
                        </button>
                    </div>
                </div>
            </div>

            <!-- Profile Cards List -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="font-serif fw-bold text-dark mb-0">
                        Displaying Verified Elite Candidates ({{ count($profiles) }})
                    </h5>
                    <span class="small text-muted">NID & Strict Non-Disclosure Verified</span>
                </div>

                @if(count($profiles) > 0)
                <div class="row g-4">
                    @foreach($profiles as $profile)
                    <div class="col-md-6 col-lg-4">
                        <x-profile-card :profile="$profile" />
                    </div>
                    @endforeach
                </div>
                @else
                <div class="bg-white p-5 rounded-4 text-center border border-warning-subtle">
                    <i class="bi bi-search text-muted display-4 mb-3 d-block"></i>
                    <h4 class="font-serif text-maroon">No matching sample profiles found</h4>
                    <p class="text-muted">Our private registry holds thousands of confidential profiles not displayed online.</p>
                    <a href="{{ route('profiles') }}" class="btn btn-outline-secondary btn-sm me-2">Clear Filters</a>
                    <button type="button" class="btn btn-elite-primary btn-sm" data-bs-toggle="modal" data-bs-target="#consultationModal">Request Custom Shortlist</button>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
