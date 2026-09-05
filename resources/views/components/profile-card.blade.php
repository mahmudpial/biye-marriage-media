@props(['profile'])

<div class="elite-profile-card">
    <!-- Profile Photo Container with Discreet Privacy Filter -->
    <div class="profile-thumb-wrapper">
        <span class="profile-badge-category">
            <i class="bi bi-star-fill text-gold me-1"></i>{{ $profile['category'] }}
        </span>

        <img src="{{ $profile['image'] }}" alt="Elite Bangladeshi Profile" class="profile-img {{ $profile['discreet'] ? 'discreet-blur' : '' }}">

        @if($profile['discreet'])
        <div class="profile-privacy-overlay">
            <span class="privacy-badge"><i class="bi bi-shield-lock-fill me-1"></i> Confidential Profile</span>
            <p class="small mb-2 text-white-50">Photo shielded by family discretion</p>
            <button type="button" class="btn btn-sm btn-elite-gold py-1 px-3 fs-7 btn-toggle-discreet">
                <i class="bi bi-eye me-1"></i> Preview Profile
            </button>
        </div>
        @endif
    </div>

    <!-- Profile Information Body -->
    <div class="profile-body">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <span class="profile-id-code">{{ $profile['id'] }}</span>
            <span class="badge bg-gold-subtle text-dark border border-warning-subtle small fw-medium">
                <i class="bi bi-patch-check-fill text-gold me-1"></i>NID & HNI Verified
            </span>
        </div>

        <h4 class="profile-title-name">
            {{ $profile['age'] }} Yrs, {{ $profile['height'] }} • {{ $profile['religion'] }}
        </h4>

        <ul class="profile-meta-list">
            <li>
                <i class="bi bi-briefcase-fill"></i>
                <span class="text-truncate"><strong>{{ $profile['profession'] }}</strong></span>
            </li>
            <li>
                <i class="bi bi-mortarboard-fill"></i>
                <span class="text-truncate">{{ $profile['education'] }}</span>
            </li>
            <li>
                <i class="bi bi-compass-fill"></i>
                <span>Desher Bari: <strong>{{ $profile['desher_bari'] }}</strong></span>
            </li>
            <li>
                <i class="bi bi-geo-alt-fill"></i>
                <span>{{ $profile['location'] }}</span>
            </li>
            <li>
                <i class="bi bi-cash-stack"></i>
                <span class="text-maroon fw-semibold">Package/Income: {{ $profile['income'] }}</span>
            </li>
            <li class="pt-1 border-top mt-2">
                <i class="bi bi-people-fill"></i>
                <span class="small text-muted text-truncate">{{ $profile['family'] }}</span>
            </li>
        </ul>

        <div class="mt-auto pt-2">
            <button type="button" class="btn btn-elite-primary btn-profile-cta" data-bs-toggle="modal" data-bs-target="#consultationModal">
                <i class="bi bi-send-fill"></i>
                <span>Connect with Manager</span>
            </button>
        </div>
    </div>
</div>
