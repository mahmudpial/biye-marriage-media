@extends('layouts.app')

@section('title', 'Biye Marriage Media - Find Your Perfect Life Partner with Trust & Confidentiality')

@section('content')

<!-- Hero Section with Ambient Luxury Background and Lead Form -->
<section class="elite-hero position-relative">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center g-5">
            <!-- Left Hero Content -->
            <div class="col-lg-7">
                <h1 class="hero-title">
                    Find Your Perfect Life Partner with <span class="text-gold font-serif fst-italic">Trust & Confidentiality</span>
                </h1>

                <p class="hero-subtitle">
                    Professional bride and groom matching in Bangladesh and overseas. We prioritize Islamic values and family compatibility to help you find your ideal match.
                </p>

                <!-- Value Highlights Grid -->
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="hero-feature-box">
                            <div class="hero-feature-icon">
                                <i class="bi bi-shield-lock-fill fs-5"></i>
                            </div>
                            <div>
                                <h6 class="hero-feature-title">100% Confidential Service</h6>
                                <span class="hero-feature-desc">Your privacy & identity always protected</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="hero-feature-box">
                            <div class="hero-feature-icon">
                                <i class="bi bi-patch-check-fill fs-5"></i>
                            </div>
                            <div>
                                <h6 class="hero-feature-title">Verified Profiles</h6>
                                <span class="hero-feature-desc">Genuine & authentic matches</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="hero-feature-box">
                            <div class="hero-feature-icon">
                                <i class="bi bi-moon-stars-fill fs-5"></i>
                            </div>
                            <div>
                                <h6 class="hero-feature-title">Islamic Matchmaking</h6>
                                <span class="hero-feature-desc">Focus on shared Islamic values</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="hero-feature-box">
                            <div class="hero-feature-icon">
                                <i class="bi bi-globe-americas fs-5"></i>
                            </div>
                            <div>
                                <h6 class="hero-feature-title">Bangladesh & Overseas</h6>
                                <span class="hero-feature-desc">Connecting families locally & globally</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <button type="button" class="btn btn-elite-gold px-4 py-2" data-bs-toggle="modal" data-bs-target="#consultationModal">
                        <i class="bi bi-person-plus-fill me-1"></i> Register Profile
                    </button>
                    <a href="{{ route('contact') }}" class="btn btn-elite-outline-gold px-4 py-2">
                        <i class="bi bi-envelope-fill me-1"></i> Contact Us
                    </a>
                </div>
            </div>

            <!-- Right Hero Consultation Card (Compact & Sleek) -->
            <div class="col-lg-5">
                <div class="lead-card">
                    <div class="lead-card-header">
                        <span class="badge bg-maroon text-white mb-1 px-3 py-1 rounded-pill small" style="font-size: 0.75rem; letter-spacing: 0.5px;">VIP Priority Inquiry</span>
                        <h3 class="lead-card-title font-serif">Share your family details</h3>
                        <p class="lead-card-subtitle">We will arrange a discreet, confidential consultation</p>
                    </div>

                    <form action="{{ route('consultation.submit') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Seeking Partner For</label>
                            <div class="d-flex gap-4 pt-1">
                                <label class="form-check" for="seekBride">
                                    <input class="form-check-input" type="radio" name="looking_for" id="seekBride" value="Bride" checked>
                                    <span class="form-check-label fw-medium">Bride (Patri)</span>
                                </label>
                                <label class="form-check" for="seekGroom">
                                    <input class="form-check-input" type="radio" name="looking_for" id="seekGroom" value="Groom">
                                    <span class="form-check-label fw-medium">Groom (Patro)</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Profile Managed By</label>
                            <select class="form-select" name="profile_for" required>
                                <option value="Daughter" selected>Daughter</option>
                                <option value="Son">Son</option>
                                <option value="Self">Self</option>
                                <option value="Brother">Brother</option>
                                <option value="Sister">Sister</option>
                                <option value="Family Member">Family Guardian / Relative</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Your Full Name</label>
                            <div class="input-group elite-input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" name="full_name" placeholder="e.g. Barrister / Al-Hajj Rahman" required>
                            </div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <label class="form-label">Mobile / WhatsApp</label>
                                <div class="input-group elite-input-group">
                                    <span class="input-group-text small fw-semibold">+880</span>
                                    <input type="tel" class="form-control" name="phone" placeholder="01577723404" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Email Address</label>
                                <div class="input-group elite-input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" placeholder="name@email.com" required>
                                </div>
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label">Current Residence</label>
                                <div class="input-group elite-input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" class="form-control" name="city" placeholder="e.g. Gulshan, Dhaka">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Desher Bari (District)</label>
                                <div class="input-group elite-input-group">
                                    <span class="input-group-text"><i class="bi bi-compass"></i></span>
                                    <input type="text" class="form-control" name="desher_bari" placeholder="e.g. Sylhet / Ctg">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-elite-primary w-100 py-2.5 fw-semibold d-flex justify-content-center align-items-center gap-2 text-center" style="font-size: 0.95rem; border-radius: 8px;">
                            <i class="bi bi-calendar-event"></i>
                            <span>Request Confidential Consultation</span>
                        </button>

                        <div class="text-center mt-2">
                            <span class="small text-muted" style="font-size: 0.76rem;">
                                <i class="bi bi-lock-fill text-gold me-1"></i> Data handled with strict non-disclosure
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Trust Metric Counters for Bangladesh -->
<section class="stat-counter-section">
    <div class="container">
        <div class="row g-3 g-lg-4 justify-content-center">
            <div class="col-6 col-lg-3 d-flex">
                <div class="stat-counter-box h-100 w-100">
                    <div class="stat-number">
                        <span class="counter-value" data-target="15">0</span><span class="stat-suffix">+</span>
                    </div>
                    <div class="stat-label">Years of Matchmaking Heritage</div>
                </div>
            </div>
            <div class="col-6 col-lg-3 d-flex">
                <div class="stat-counter-box h-100 w-100">
                    <div class="stat-number">
                        <span class="counter-value" data-target="25000" data-format="comma">0</span><span class="stat-suffix">+</span>
                    </div>
                    <div class="stat-label">Elite Bangladeshi Families Served</div>
                </div>
            </div>
            <div class="col-6 col-lg-3 d-flex">
                <div class="stat-counter-box h-100 w-100">
                    <div class="stat-number">
                        <span class="counter-value" data-target="100">0</span><span class="stat-suffix">%</span>
                    </div>
                    <div class="stat-label">Confidential & NID Verified</div>
                </div>
            </div>
            <div class="col-6 col-lg-3 d-flex">
                <div class="stat-counter-box h-100 w-100">
                    <div class="stat-number">
                        <span class="counter-value" data-target="8">0</span><span class="stat-suffix">+</span>
                    </div>
                    <div class="stat-label">Metropolitan Hubs & NRB Desks</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Services & Specialties Section -->
<section class="section-padding bg-soft">
    <div class="container">
        <div class="section-header text-center">
            <span class="section-tag">Our Specialties</span>
            <h2 class="section-title">Professional Matchmaking Services Tailored For You</h2>
            <p class="section-desc">
                Built on trust, Islamic values, and deep family compatibility for clients in Bangladesh and overseas.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            <!-- Specialty 1: 100% Confidential Service -->
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="pillar-card w-100">
                    <div class="pillar-icon-box mb-3">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <h4 class="pillar-title font-serif">100% Confidential Service</h4>
                    <p class="pillar-desc text-muted mb-0">
                        Your privacy and identity are always protected with strict non-disclosure protocols and private profile sharing.
                    </p>
                </div>
            </div>

            <!-- Specialty 2: Bride & Groom Matching -->
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="pillar-card w-100">
                    <div class="pillar-icon-box mb-3">
                        <i class="bi bi-heart-pulse-fill"></i>
                    </div>
                    <h4 class="pillar-title font-serif">Bride & Groom Matching</h4>
                    <p class="pillar-desc text-muted mb-0">
                        Dedicated specialized services for finding the right groom (Patro) or bride (Patri) with complete peace of mind.
                    </p>
                </div>
            </div>

            <!-- Specialty 3: Personalized Matchmaking -->
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="pillar-card w-100">
                    <div class="pillar-icon-box mb-3">
                        <i class="bi bi-sliders"></i>
                    </div>
                    <h4 class="pillar-title font-serif">Personalized Matchmaking</h4>
                    <p class="pillar-desc text-muted mb-0">
                        Tailored searches based on your specific lifestyle, cultural preferences, district roots (Desher Bari), and expectations.
                    </p>
                </div>
            </div>

            <!-- Specialty 4: Islamic Matchmaking -->
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="pillar-card w-100">
                    <div class="pillar-icon-box mb-3">
                        <i class="bi bi-moon-stars-fill"></i>
                    </div>
                    <h4 class="pillar-title font-serif">Islamic Matchmaking</h4>
                    <p class="pillar-desc text-muted mb-0">
                        A core focus on shared Islamic values, Deen-conscious lifestyles, family guardian (Wali) coordination, and noble traditions.
                    </p>
                </div>
            </div>

            <!-- Specialty 5: Professional Marriage Consultancy -->
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="pillar-card w-100">
                    <div class="pillar-icon-box mb-3">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <h4 class="pillar-title font-serif">Professional Marriage Consultancy</h4>
                    <p class="pillar-desc text-muted mb-0">
                        Expert guidance throughout your partner search with dedicated, experienced marriage consultants and advisors.
                    </p>
                </div>
            </div>

            <!-- Specialty 6: Bangladesh & Overseas Matchmaking -->
            <div class="col-lg-4 col-md-6 d-flex">
                <div class="pillar-card w-100">
                    <div class="pillar-icon-box mb-3">
                        <i class="bi bi-globe-americas"></i>
                    </div>
                    <h4 class="pillar-title font-serif">Bangladesh & Overseas Matchmaking</h4>
                    <p class="pillar-desc text-muted mb-0">
                        Connecting families locally across Bangladesh and globally across the UK, USA, Canada, UAE, Australia, and European diaspora.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="section-padding bg-white">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Seamless Process</span>
            <h2 class="section-title">How Our Private Matchmaking Works</h2>
            <p class="section-desc">
                From initial confidential consultation to alliance celebrations, experience personalized attention at every step.
            </p>
        </div>

        <div class="process-timeline-wrapper position-relative mt-5 pt-2">
            <!-- Subtle elegant horizontal connecting line linking Step 1 to Step 2 and Step 3 in desktop view -->
            <div class="process-connecting-line d-none d-md-block" aria-hidden="true"></div>

            <div class="row gx-4 gy-5 gy-md-4 align-items-stretch position-relative" style="z-index: 2;">
                <!-- Step 1 -->
                <div class="col-md-4 d-flex">
                    <div class="step-card w-100">
                        <div class="step-number">01</div>
                        <h4 class="step-title font-serif">Understanding Family Expectations</h4>
                        <p class="step-desc">
                            Your Relationship Manager hosts an in-depth private consultation at your residence or club to understand your family values, district preference (Desher Bari), and partner requirements.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-md-4 d-flex">
                    <div class="step-card w-100">
                        <div class="step-number">02</div>
                        <h4 class="step-title font-serif">Handpicking Verified Recommendations</h4>
                        <p class="step-desc">
                            Your Relationship Manager rigorously filters verified high-caliber profiles from our private registry and presents curated executive briefs directly to family guardians.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-md-4 d-flex">
                    <div class="step-card w-100">
                        <div class="step-number">03</div>
                        <h4 class="step-title font-serif">Facilitating High-Level Introductions</h4>
                        <p class="step-desc">
                            Upon mutual interest, your Relationship Manager coordinates confidential family meetings at premier 5-star venues (Radisson, Westin, InterContinental) or private family lounges.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-5 pt-2">
            <button type="button" class="btn btn-elite-primary btn-process-cta" data-bs-toggle="modal" data-bs-target="#consultationModal">
                <i class="bi bi-calendar-check me-2"></i>Schedule Your Family Consultation
            </button>
        </div>
    </div>
</section>

<!-- Elite Membership Packages Showcase in BDT (৳) -->
<section class="section-padding bg-soft">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Tailored Memberships</span>
            <h2 class="section-title">Exclusive Elite BD Packages</h2>
            <p class="section-desc">
                Choose the bespoke tier that best aligns with your family’s social standing and alliance objectives.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">
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
                            Inquire for Fee & Enrollment
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5 pt-3">
            <a href="{{ route('packages') }}" class="package-comparison-link">
                <span>View Full Package Comparison Matrix (BDT ৳)</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Featured Elite Profiles Preview -->
<section class="section-padding bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-5">
            <div>
                <span class="section-tag">Confidential Showcases</span>
                <h2 class="section-title mb-1">Featured Bangladeshi Candidates</h2>
                <p class="text-muted mb-0">Handpicked prospective brides and grooms from distinguished family lineages.</p>
            </div>
            <div>
                <a href="{{ route('profiles') }}" class="btn btn-elite-outline px-4 py-2">
                    <i class="bi bi-search me-1"></i> Browse All Profiles
                </a>
            </div>
        </div>

        <div class="row g-4">
            @foreach($profiles as $profile)
            <div class="col-lg-3 col-md-6">
                <x-profile-card :profile="$profile" />
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Brand Ambassador / Distinguished Families Showcase -->
<section class="ambassador-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="text-gold text-uppercase fw-semibold letter-spacing-2 small d-block mb-2">বিশ্বাসের বন্ধনে, সুন্দর আগামী</span>
                <h2 class="display-6 font-serif fw-bold text-white mb-4">
                    Professional Bride & Groom Matching with Islamic Values
                </h2>
                <p class="text-white-50 fs-6 mb-4 leading-relaxed">
                    At <strong class="text-white">Biye Marriage Media</strong>, we believe that a successful marriage is built on trust, Islamic values, and deep family compatibility. We operate as professional marriage consultants dedicated to providing a safe, secure, and 100% confidential platform for bride and groom matching. Whether you are looking for a match within Bangladesh or seeking expatriate profiles overseas, our verified matchmaking process ensures you find the perfect life partner with complete peace of mind.
                </p>

                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-shield-lock-fill text-gold fs-3"></i>
                            <div>
                                <h6 class="text-white mb-0">100% Confidential Service</h6>
                                <span class="small text-white-50">Total privacy & discrete meetings</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-3">
                            <i class="bi bi-check-circle-fill text-gold fs-3"></i>
                            <div>
                                <h6 class="text-white mb-0">Verified Profiles</h6>
                                <span class="small text-white-50">Family background authentications</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-elite-gold btn-ambassador-cta" data-bs-toggle="modal" data-bs-target="#consultationModal">
                    <i class="bi bi-chat-quote-fill"></i>
                    <span>Book Confidential Family Discussion</span>
                </button>
            </div>

            <div class="col-lg-6">
                <div class="ambassador-card p-4 text-center">
                    <div class="position-relative rounded-3 overflow-hidden shadow-lg mb-3">
                        <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&w=1000&q=80" alt="Bangladeshi Wedding" class="img-fluid" style="height: 320px; width: 100%; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 end-0 p-3 bg-dark bg-opacity-75 text-start">
                            <span class="badge bg-gold text-dark fw-bold mb-1">বিশ্বাসের বন্ধনে, সুন্দর আগামী</span>
                            <h5 class="text-white font-serif mb-0">Islamic Values & Family Compatibility</h5>
                        </div>
                    </div>
                    <p class="ambassador-disclaimer">
                        "Biye Marriage Media is not an open dating portal; it is an honorable family bridge connecting lineages of distinction across Bangladesh and overseas."
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Elite Success Stories -->
<section class="section-padding bg-soft">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Celebrated Nuptials</span>
            <h2 class="section-title">Elite Bangladesh Success Stories</h2>
            <p class="section-desc">
                Discover how prominent families discovered harmonious lifelong alliances through our personalized concierge.
            </p>
        </div>

        <div class="row g-4">
            @foreach($stories as $index => $story)
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="story-card w-100" data-story-index="{{ $index }}" role="button" tabindex="0" aria-label="View success story of {{ $story['names'] }}">
                    <div class="story-img-wrap">
                        <img src="{{ $story['image'] }}" alt="{{ $story['names'] }}" class="story-img" loading="lazy">
                        <span class="badge bg-maroon position-absolute top-0 end-0 m-3 px-2.5 py-1 small rounded-pill shadow-sm">
                            <i class="bi bi-calendar-heart me-1 text-gold"></i>{{ Str::contains($story['year'], '•') ? trim(Str::afterLast($story['year'], '•')) : $story['year'] }}
                        </span>
                        <div class="story-img-overlay">
                            <span class="story-hover-hint">
                                <i class="bi bi-eye-fill"></i> Read Full Story
                            </span>
                        </div>
                    </div>
                    <div class="story-content">
                        <h4 class="story-couple">{{ $story['names'] }}</h4>
                        <div class="story-profiles">{{ $story['titles'] }}</div>
                        <div class="story-location"><i class="bi bi-geo-alt text-gold me-1"></i>{{ $story['locations'] }}</div>
                        <p class="story-quote">
                            "{{ $story['quote'] }}"
                        </p>
                        <div class="story-footer">
                            <span class="story-footer-link">
                                Read Full Story <i class="bi bi-arrow-right"></i>
                            </span>
                            <span class="badge bg-gold-subtle text-maroon rounded-circle p-1.5" title="Verified Alliance">
                                <i class="bi bi-patch-check-fill text-gold"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('stories') }}" class="btn-stories-more" id="openStoriesShowcaseBtn">
                <span>Read More Celebrated Alliances</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Interactive Success Story Modal Popup -->
<div class="story-modal-backdrop" id="storyDetailModal" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="story-modal-container">
        <button type="button" class="story-modal-close" id="storyModalCloseBtn" aria-label="Close story details">
            <i class="bi bi-x-lg"></i>
        </button>
        <div class="row g-0">
            <!-- Left Column: High-Resolution Wedding Photograph -->
            <div class="col-md-5">
                <div class="story-modal-img-col">
                    <img src="" alt="" class="story-modal-img" id="modalStoryImg">
                    <div class="story-modal-img-overlay">
                        <span class="badge bg-maroon-dark text-gold border border-gold-subtle px-3 py-1.5 rounded-pill mb-2 align-self-start small">
                            <i class="bi bi-award-fill me-1 text-gold"></i>Verified Aristocratic Alliance
                        </span>
                        <div class="small text-white-50" id="modalStoryVenue"></div>
                    </div>
                </div>
            </div>
            <!-- Right Column: Details & Conversion CTA -->
            <div class="col-md-7 d-flex flex-column justify-content-between">
                <div class="story-modal-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="story-modal-tag">
                            <i class="bi bi-heart-fill text-gold"></i> Celebrated Alliance
                        </span>
                    </div>
                    
                    <h3 class="story-modal-title" id="modalStoryNames"></h3>
                    <div class="story-modal-subtitle" id="modalStoryTitles"></div>
                    
                    <div class="story-modal-meta">
                        <span><i class="bi bi-geo-alt text-gold me-1"></i><span id="modalStoryLocation"></span></span>
                        <span><i class="bi bi-calendar-check text-gold me-1"></i><span id="modalStoryDate"></span></span>
                    </div>
                    
                    <div class="story-modal-quote-wrap">
                        <i class="bi bi-quote fs-3 text-gold opacity-50 lh-1 d-block mb-1"></i>
                        <p class="story-modal-quote" id="modalStoryQuote"></p>
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge bg-light text-dark border px-2.5 py-1.5 small">
                            <i class="bi bi-shield-check text-success me-1"></i>100% Background Verified
                        </span>
                        <span class="badge bg-light text-dark border px-2.5 py-1.5 small">
                            <i class="bi bi-people text-maroon me-1"></i>Family-Level Match
                        </span>
                        <span class="badge bg-light text-dark border px-2.5 py-1.5 small">
                            <i class="bi bi-star-fill text-gold me-1"></i>Bespoke Concierge
                        </span>
                    </div>

                    <button type="button" class="story-modal-cta" id="modalStoryInquireBtn">
                        <i class="bi bi-telephone-outbound me-1"></i>
                        <span>Inquire for Similar Matchmaking</span>
                    </button>
                    <div class="text-center mt-2 small text-muted">
                        <i class="bi bi-lock-fill text-gold me-1"></i>Strictly Confidential Family Discussion
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Frequently Asked Questions Accordion -->
<section class="section-padding bg-white">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Clarifications & Trust</span>
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-desc">
                Everything you need to know about our discrete matchmaking methodology and criteria in Bangladesh.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="accordion" id="eliteFaqAccordion">
                    @foreach($faqs as $index => $faq)
                    <div class="accordion-item elite-faq-item">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button class="accordion-button elite-faq-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                {{ $faq['question'] }}
                            </button>
                        </h2>
                        <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#eliteFaqAccordion">
                            <div class="accordion-body elite-faq-body">
                                {{ $faq['answer'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bottom VIP CTA Banner -->
<section class="py-5" style="background: linear-gradient(135deg, var(--elite-maroon-dark), var(--elite-maroon-deep)); border-top: 2px solid var(--elite-gold-primary);">
    <div class="container text-center text-white py-4">
        <span class="hero-crest-badge mb-3">Begin Your Exclusive Journey</span>
        <h2 class="display-6 font-serif fw-bold text-white mb-3">
            Ready to Find the Ideal Match for Your Family?
        </h2>
        <p class="text-white-50 mx-auto mb-4 fs-5" style="max-width: 680px;">
            Speak directly with an Executive Matchmaker who will handle your family preferences with absolute privacy, cultural respect, and dedicated care.
        </p>
        <div class="vip-cta-actions d-flex flex-column flex-md-row justify-content-center align-items-stretch align-items-md-center gap-3">
            <button type="button" class="btn btn-elite-gold vip-action-btn" data-bs-toggle="modal" data-bs-target="#consultationModal">
                <i class="bi bi-telephone-inbound"></i>
                <span>Request VIP Callback</span>
            </button>
            <a href="tel:+8801577723404" class="btn btn-elite-outline-gold vip-action-btn">
                <i class="bi bi-headset"></i>
                <span>Call +880 1577-723404</span>
            </a>
            <a href="https://wa.me/8801577723404" target="_blank" class="btn btn-outline-light vip-action-btn">
                <i class="bi bi-whatsapp text-success"></i>
                <span>WhatsApp Concierge</span>
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const counterSection = document.querySelector('.stat-counter-section');
        if (!counterSection) return;

        const counterElements = counterSection.querySelectorAll('.counter-value');
        if (!counterElements.length) return;

        let hasAnimated = false;

        function startCounterAnimation() {
            if (hasAnimated) return;
            hasAnimated = true;

            const duration = 1800; // 1.8 seconds smooth animation

            counterElements.forEach(el => {
                const target = parseInt(el.getAttribute('data-target'), 10);
                const isComma = el.getAttribute('data-format') === 'comma';
                const startTime = performance.now();

                function updateCounter(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);

                    // Smooth cubic ease-out curve
                    const easeOut = 1 - Math.pow(1 - progress, 3);
                    const currentVal = Math.floor(easeOut * target);

                    if (isComma) {
                        el.textContent = currentVal.toLocaleString('en-US');
                    } else {
                        el.textContent = currentVal;
                    }

                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        if (isComma) {
                            el.textContent = target.toLocaleString('en-US');
                        } else {
                            el.textContent = target;
                        }
                    }
                }

                requestAnimationFrame(updateCounter);
            });
        }

        // Intersection Observer to trigger animation on scroll
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        startCounterAnimation();
                        obs.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.2,
                rootMargin: '0px 0px -30px 0px'
            });

            observer.observe(counterSection);
        } else {
            startCounterAnimation();
        }
    });
</script>

<script id="stories-data" type="application/json">{!! json_encode($stories) !!}</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const storiesDataEl = document.getElementById('stories-data');
        if (!storiesDataEl) return;

        let stories = [];
        try {
            stories = JSON.parse(storiesDataEl.textContent);
        } catch (e) {
            console.error('Failed to parse stories data', e);
            return;
        }

        const storyModal = document.getElementById('storyDetailModal');
        const closeBtn = document.getElementById('storyModalCloseBtn');
        const inquireBtn = document.getElementById('modalStoryInquireBtn');
        const openShowcaseBtn = document.getElementById('openStoriesShowcaseBtn');

        const modalImg = document.getElementById('modalStoryImg');
        const modalNames = document.getElementById('modalStoryNames');
        const modalTitles = document.getElementById('modalStoryTitles');
        const modalLocation = document.getElementById('modalStoryLocation');
        const modalDate = document.getElementById('modalStoryDate');
        const modalVenue = document.getElementById('modalStoryVenue');
        const modalQuote = document.getElementById('modalStoryQuote');

        function openStoryModal(index) {
            const story = stories[index];
            if (!story || !storyModal) return;

            if (modalImg) {
                modalImg.src = story.image;
                modalImg.alt = story.names;
            }
            if (modalNames) modalNames.textContent = story.names;
            if (modalTitles) modalTitles.textContent = story.titles;
            if (modalLocation) modalLocation.textContent = story.locations;

            if (story.year && story.year.includes('•')) {
                const parts = story.year.split('•');
                if (modalVenue) modalVenue.textContent = parts[0].trim();
                if (modalDate) modalDate.textContent = parts[1].trim();
            } else {
                if (modalVenue) modalVenue.textContent = story.year || 'Elite Bangladesh Wedding';
                if (modalDate) modalDate.textContent = 'Celebrated Alliance';
            }

            if (modalQuote) modalQuote.textContent = `"${story.quote}"`;

            storyModal.classList.add('is-active');
            storyModal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeStoryModal() {
            if (!storyModal) return;
            storyModal.classList.remove('is-active');
            storyModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        // Card click & keyboard listeners
        const storyCards = document.querySelectorAll('.story-card[data-story-index]');
        storyCards.forEach(card => {
            const idx = parseInt(card.getAttribute('data-story-index'), 10);
            card.addEventListener('click', function () {
                openStoryModal(idx);
            });
            card.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openStoryModal(idx);
                }
            });
        });

        // Close button
        if (closeBtn) {
            closeBtn.addEventListener('click', closeStoryModal);
        }

        // Backdrop click
        if (storyModal) {
            storyModal.addEventListener('click', function (e) {
                if (e.target === storyModal) {
                    closeStoryModal();
                }
            });
        }

        // ESC key
        window.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && storyModal && storyModal.classList.contains('is-active')) {
                closeStoryModal();
            }
        });

        // Inquire CTA button click -> closes story modal and opens consultation modal
        if (inquireBtn) {
            inquireBtn.addEventListener('click', function () {
                closeStoryModal();
                const consultationModalEl = document.getElementById('consultationModal');
                if (consultationModalEl && typeof bootstrap !== 'undefined') {
                    const modalInstance = bootstrap.Modal.getOrCreateInstance(consultationModalEl);
                    modalInstance.show();
                }
            });
        }

        // Bottom showcase link click
        if (openShowcaseBtn) {
            openShowcaseBtn.addEventListener('click', function (e) {
                e.preventDefault();
                openStoryModal(0);
            });
        }
    });
</script>
@endpush

@endsection
