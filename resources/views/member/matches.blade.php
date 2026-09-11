@extends('member.layouts.app')

@section('title', 'ডেইলি স্মার্ট ম্যাচ - Biye Marriage Media')

@section('content')
<div class="row g-4">
    <!-- Filter Card -->
    <div class="col-12">
        <div class="card filter-luxury-card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-3.5 p-md-4">
                <form action="{{ route('member.matches') }}" method="GET" class="row g-2.5 g-md-3 align-items-end">
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-semibold text-secondary mb-1">
                            <i class="bi bi-briefcase-fill text-warning me-1"></i>{{ __('পেশা দিয়ে সার্চ') }}
                        </label>
                        <input type="text" name="profession" value="{{ request('profession') }}" class="form-control filter-input-luxury" placeholder="e.g. Doctor, Engineer, BCS">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold text-secondary mb-1">
                            <i class="bi bi-geo-alt-fill text-warning me-1"></i>{{ __('দেশের বাড়ি (জেলা)') }}
                        </label>
                        <input type="text" name="desher_bari" value="{{ request('desher_bari') }}" class="form-control filter-input-luxury" placeholder="e.g. Dhaka, Sylhet">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold text-secondary mb-1">
                            <i class="bi bi-moon-stars-fill text-warning me-1"></i>{{ __('ধর্ম') }}
                        </label>
                        <div class="dropdown custom-filter-dropdown w-100 position-relative">
                            <input type="hidden" name="religion" id="religionFilterInput" value="{{ request('religion') }}">
                            <button type="button" 
                                    class="form-select filter-input-luxury w-100 d-flex justify-content-between align-items-center text-truncate text-start" 
                                    id="religionDropdownTrigger"
                                    data-bs-toggle="dropdown" 
                                    data-bs-display="static" 
                                    data-bs-auto-close="true"
                                    aria-expanded="false">
                                <span class="text-truncate" id="religionSelectedLabel">
                                    {{ request('religion') ?: __('সকল ধর্ম') }}
                                </span>
                            </button>
                            <ul class="dropdown-menu custom-dropdown-menu shadow-lg w-100 p-1.5 border-0" aria-labelledby="religionDropdownTrigger">
                                <li>
                                    <a class="dropdown-item custom-filter-option rounded-2 py-2 px-3 d-flex justify-content-between align-items-center {{ !request('religion') ? 'active-option' : '' }}" 
                                       href="javascript:void(0)" 
                                       data-value="">
                                        <span>{{ __('সকল ধর্ম') }}</span>
                                        @if(!request('religion'))
                                            <i class="bi bi-check2 text-warning fw-bold check-icon"></i>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item custom-filter-option rounded-2 py-2 px-3 d-flex justify-content-between align-items-center {{ request('religion') === 'Islam (Sunni)' ? 'active-option' : '' }}" 
                                       href="javascript:void(0)" 
                                       data-value="Islam (Sunni)">
                                        <span>Islam (Sunni)</span>
                                        @if(request('religion') === 'Islam (Sunni)')
                                            <i class="bi bi-check2 text-warning fw-bold check-icon"></i>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item custom-filter-option rounded-2 py-2 px-3 d-flex justify-content-between align-items-center {{ request('religion') === 'Islam (Shia)' ? 'active-option' : '' }}" 
                                       href="javascript:void(0)" 
                                       data-value="Islam (Shia)">
                                        <span>Islam (Shia)</span>
                                        @if(request('religion') === 'Islam (Shia)')
                                            <i class="bi bi-check2 text-warning fw-bold check-icon"></i>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item custom-filter-option rounded-2 py-2 px-3 d-flex justify-content-between align-items-center {{ request('religion') === 'Hinduism' ? 'active-option' : '' }}" 
                                       href="javascript:void(0)" 
                                       data-value="Hinduism">
                                        <span>Hinduism</span>
                                        @if(request('religion') === 'Hinduism')
                                            <i class="bi bi-check2 text-warning fw-bold check-icon"></i>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item custom-filter-option rounded-2 py-2 px-3 d-flex justify-content-between align-items-center {{ request('religion') === 'Christianity' ? 'active-option' : '' }}" 
                                       href="javascript:void(0)" 
                                       data-value="Christianity">
                                        <span>Christianity</span>
                                        @if(request('religion') === 'Christianity')
                                            <i class="bi bi-check2 text-warning fw-bold check-icon"></i>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item custom-filter-option rounded-2 py-2 px-3 d-flex justify-content-between align-items-center {{ request('religion') === 'Buddhism' ? 'active-option' : '' }}" 
                                       href="javascript:void(0)" 
                                       data-value="Buddhism">
                                        <span>Buddhism</span>
                                        @if(request('religion') === 'Buddhism')
                                            <i class="bi bi-check2 text-warning fw-bold check-icon"></i>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item custom-filter-option rounded-2 py-2 px-3 d-flex justify-content-between align-items-center {{ request('religion') === 'Others' ? 'active-option' : '' }}" 
                                       href="javascript:void(0)" 
                                       data-value="Others">
                                        <span>Others</span>
                                        @if(request('religion') === 'Others')
                                            <i class="bi bi-check2 text-warning fw-bold check-icon"></i>
                                        @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold text-secondary mb-1">
                            <i class="bi bi-calendar-range text-warning me-1"></i>{{ __('সর্বনিম্ন বয়স') }}
                        </label>
                        <input type="number" name="age_min" value="{{ request('age_min') }}" class="form-control filter-input-luxury" placeholder="18" min="18" max="75">
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold text-secondary mb-1">
                            <i class="bi bi-calendar-range-fill text-warning me-1"></i>{{ __('সর্বোচ্চ বয়স') }}
                        </label>
                        <input type="number" name="age_max" value="{{ request('age_max') }}" class="form-control filter-input-luxury" placeholder="45" min="18" max="75">
                    </div>
                    <div class="col-12 col-md-1">
                        <label class="form-label small fw-semibold mb-1 d-none d-md-block opacity-0" style="user-select: none;">&nbsp;</label>
                        <div class="d-flex gap-1.5">
                            <button type="submit" class="btn btn-dark w-100 d-flex align-items-center justify-content-center shadow-xs filter-btn-luxury" id="filterSubmitBtn" title="{{ __('ফিল্টার প্রয়োগ করুন') }}">
                                <i class="bi bi-funnel-fill text-warning"></i>
                            </button>
                            @if(request()->hasAny(['profession', 'desher_bari', 'religion', 'age_min', 'age_max']))
                                <a href="{{ route('member.matches') }}" class="btn btn-outline-danger d-flex align-items-center justify-content-center filter-btn-luxury px-2.5 filter-reset-btn" id="filterResetBtn" title="{{ __('ফিল্টার রিসেট করুন') }}">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Candidates Grid -->
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold font-serif text-dark mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-people-fill text-maroon"></i>
                <span>{{ __('প্রস্তাবিত বায়োডাটা তালিকা') }} ({{ $profiles->total() }})</span>
            </h5>
            <div class="small text-muted">
                {{ app()->getLocale() === 'en' ? 'Showing' : 'দেখাচ্ছে' }} <strong class="text-dark font-monospace">{{ $profiles->firstItem() ?? 0 }} - {{ $profiles->lastItem() ?? 0 }}</strong>
            </div>
        </div>

        <div class="row g-3">
            @forelse($profiles as $profile)
                @php
                    $isShortlisted = in_array($profile->id, $shortlistedProfileIds);
                    $hasSentProposal = in_array($profile->id, $sentProposalProfileIds);
                @endphp
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="match-card-royal h-100 p-3 text-center d-flex flex-column justify-content-between position-relative">
                        <div>
                            <!-- Recommended Top Badge -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-gold-subtle text-dark border border-warning-subtle rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                    <i class="bi bi-stars text-warning me-0.5"></i>{{ __('স্মার্ট ম্যাচ') }}
                                </span>
                                <span class="badge bg-light text-secondary border rounded-pill px-2 py-0.5" style="font-size: 0.68rem;">
                                    {{ $profile->gender === 'female' ? __('পাত্রী') : __('পাত্র') }}
                                </span>
                            </div>

                            <!-- Avatar with Luxury Ring & Discreet Blur if applicable -->
                            <div class="position-relative d-inline-block mx-auto mb-2.5">
                                <div class="match-avatar-ring">
                                    <img src="{{ $profile->resolved_image }}" 
                                         alt="{{ $profile->profile_code }}" 
                                         class="rounded-circle object-fit-cover {{ $profile->is_discreet ? 'blur-discreet' : '' }}">
                                </div>
                                
                                @if($profile->is_discreet)
                                    <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-dark p-1 border border-2 border-white" style="font-size: 0.62rem;" title="Discreet Photo Protected">
                                        <i class="bi bi-eye-slash-fill text-warning"></i>
                                    </span>
                                @else
                                    <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-primary p-1 border border-2 border-white" style="font-size: 0.62rem;" title="{{ __('ভেরিফাইড প্রোফাইল') }}">
                                        <i class="bi bi-patch-check-fill text-white"></i>
                                    </span>
                                @endif
                            </div>

                            <h6 class="fw-bold font-serif text-dark mb-1 fs-6">{{ $profile->profile_code }}</h6>
                            
                            <!-- Demographic Info (Single Line Capsule) -->
                            <div class="d-flex justify-content-center mb-2.5">
                                <div class="badge bg-light text-dark border border-light-subtle rounded-pill px-2.5 py-1 text-nowrap d-inline-flex align-items-center gap-1.5 shadow-2xs" style="font-size: 0.78rem; max-width: 100%;">
                                    <span class="fw-semibold">{{ $profile->age }} {{ __('বছর') }}</span>
                                    <span class="text-muted opacity-50">&bull;</span>
                                    <span>{{ $profile->height }}</span>
                                    <span class="text-muted opacity-50">&bull;</span>
                                    <span class="text-secondary text-truncate" style="max-width: 85px;" title="{{ $profile->desher_bari }}">
                                        <i class="bi bi-geo-alt-fill text-warning me-0.5"></i>{{ $profile->desher_bari }}
                                    </span>
                                </div>
                            </div>

                            <!-- Profession & Education (Clean Editorial Typography, No Enclosing Box) -->
                            <div class="px-1 mb-3 text-center">
                                <div class="fw-bold text-dark text-truncate mb-1" style="font-size: 0.88rem;" title="{{ $profile->profession }}">
                                    <i class="bi bi-briefcase-fill text-warning me-1"></i>{{ $profile->profession }}
                                </div>
                                <div class="text-muted text-truncate" style="font-size: 0.78rem;" title="{{ $profile->education }}">
                                    <i class="bi bi-mortarboard-fill text-secondary me-1"></i>{{ $profile->education }}
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 justify-content-center pt-2 border-top">
                            <form action="{{ route('member.shortlists.toggle', $profile) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="btn btn-sm {{ $isShortlisted ? 'btn-danger' : 'btn-outline-danger' }} rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" 
                                        style="width: 38px; height: 38px;"
                                        title="{{ $isShortlisted ? 'শর্টলিস্ট থেকে মুছুন' : 'শর্টলিস্টে রাখুন' }}">
                                    <i class="bi bi-heart{{ $isShortlisted ? '-fill' : '' }} fs-6"></i>
                                </button>
                            </form>

                            @if($hasSentProposal)
                                <span class="badge bg-success-subtle text-success rounded-pill d-inline-flex align-items-center justify-content-center gap-1 small w-100 fw-semibold" style="height: 38px; font-size: 0.76rem;">
                                    <i class="bi bi-check-all fs-6"></i> {{ __('প্রস্তাব পাঠানো হয়েছে') }}
                                </span>
                            @else
                                <button type="button" class="btn btn-elite-primary btn-sm rounded-pill px-3 py-2 small fw-semibold w-100 d-flex align-items-center justify-content-center gap-1.5 shadow-xs" data-bs-toggle="modal" data-bs-target="#sendProposalModal{{ $profile->id }}" style="height: 38px;">
                                    <i class="bi bi-send-fill text-warning"></i>
                                    <span>{{ __('প্রস্তাব পাঠান') }}</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal: Send Proposal -->
                <div class="modal fade" id="sendProposalModal{{ $profile->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden text-start">
                            <form action="{{ route('member.proposals.send', $profile) }}" method="POST">
                                @csrf
                                <div class="modal-header text-white" style="background: linear-gradient(135deg, #851829 0%, #520f1a 100%);">
                                    <h5 class="modal-title font-serif fw-bold d-flex align-items-center gap-2">
                                        <i class="bi bi-envelope-heart-fill text-warning"></i> বিয়ের প্রস্তাবনা পাঠান
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="d-flex align-items-center gap-3 mb-3 p-3 bg-light rounded-3 border">
                                        <img src="{{ $profile->resolved_image }}" class="rounded-circle object-fit-cover {{ $profile->is_discreet ? 'blur-discreet' : '' }}" style="width: 52px; height: 52px; border: 2px solid var(--theme-secondary);">
                                        <div>
                                            <div class="fw-bold font-serif text-dark fs-6">{{ $profile->profile_code }}</div>
                                            <div class="small text-muted">{{ $profile->age }} বছর &bull; {{ $profile->profession }} ({{ $profile->desher_bari }})</div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label small fw-semibold text-dark">প্রাথমিক পারিবারিক বার্তা (ঐচ্ছিক)</label>
                                        <textarea name="message" class="form-control" rows="3" placeholder="শ্রদ্ধাভাজন অভিভাবক, আমরা আপনার প্রার্থীর বায়োডাটা দেখে সম্মানিত বোধ করেছি এবং পারিবারিক আলোচনার আগ্রহ প্রকাশ করছি..."></textarea>
                                    </div>

                                    <div class="alert alert-warning-subtle text-dark small py-2 px-3 mb-0 rounded-3 border border-warning-subtle d-flex align-items-center gap-2">
                                        <i class="bi bi-info-circle-fill text-warning fs-5"></i>
                                        <div>প্রস্তাব পাঠানোর পর আপনার দায়িত্বপ্রাপ্ত ম্যাচমেকার অপর পরিবারের সাথে আলোচনা করে অগ্রগতি জানাবেন।</div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">বাতিল</button>
                                    <button type="submit" class="btn btn-elite-primary rounded-pill px-4 fw-semibold">
                                        <i class="bi bi-send-fill me-1"></i> প্রস্তাব নিশ্চিত করুন
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 py-5 text-center text-muted">
                    <div class="rounded-circle bg-light d-inline-flex p-3 mb-2 text-warning">
                        <i class="bi bi-search fs-1"></i>
                    </div>
                    <h5 class="fw-bold text-dark font-serif">কোনো বায়োডাটা পাওয়া যায়নি</h5>
                    <p class="small text-muted mb-0">আপনার সার্চ ফিল্টার পরিবর্তন করে পুনরায় চেষ্টা করুন।</p>
                </div>
            @endforelse
        </div>

        @if($profiles->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $profiles->links() }}
            </div>
        @endif
    </div>
</div>

<style>
/* Discreet Blur Styling */
.blur-discreet {
    filter: blur(6px);
    transition: filter 0.3s ease;
}

/* Match Card Royal - Unified with Dashboard Luxury Styling */
.match-card-royal {
    background: #ffffff;
    border: 1px solid rgba(201, 151, 56, 0.22);
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03);
    transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.match-card-royal:hover {
    transform: translateY(-4px);
    border-color: rgba(201, 151, 56, 0.65);
    box-shadow: 0 12px 28px rgba(133, 24, 41, 0.08);
}

.match-avatar-ring {
    width: 86px;
    height: 86px;
    border-radius: 50%;
    padding: 3px;
    background: linear-gradient(135deg, #fef08a 0%, #c99738 50%, #851829 100%);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
}

.match-avatar-ring img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ffffff;
}

/* Filter Card Luxury Container */
.filter-luxury-card {
    background: #ffffff;
    border: 1px solid rgba(201, 151, 56, 0.22) !important;
    border-radius: 20px !important;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.03) !important;
    position: relative;
    z-index: 20;
    overflow: visible !important;
}

.filter-luxury-card .card-body {
    overflow: visible !important;
}

.filter-input-luxury {
    border: 1px solid rgba(201, 151, 56, 0.22) !important;
    border-radius: 12px !important;
    height: 42px !important;
    font-size: 0.88rem;
    background-color: #faf8f5 !important;
    transition: all 0.2s ease;
}

.filter-input-luxury:focus {
    border-color: var(--theme-secondary) !important;
    background-color: #ffffff !important;
    box-shadow: 0 0 0 3px rgba(201, 151, 56, 0.15) !important;
}

.filter-btn-luxury {
    height: 42px !important;
    border-radius: 12px !important;
    font-weight: 600;
    background: linear-gradient(135deg, var(--theme-primary) 0%, #5d0f1b 100%) !important;
    border: 1px solid rgba(201, 151, 56, 0.35) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(133, 24, 41, 0.22) !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.filter-btn-luxury:hover, .filter-btn-luxury:focus {
    background: linear-gradient(135deg, #9d1e32 0%, var(--theme-primary) 100%) !important;
    border-color: var(--theme-secondary) !important;
    box-shadow: 0 6px 18px rgba(133, 24, 41, 0.35) !important;
    transform: translateY(-1px);
}

.filter-reset-btn {
    background: #ffffff !important;
    border: 1px solid rgba(220, 53, 69, 0.35) !important;
    color: #dc3545 !important;
    transition: all 0.2s ease !important;
}

.filter-reset-btn:hover {
    background: #dc3545 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.25) !important;
}

/* Custom Dropdown Menu matching Input Field Width & Luxury UI */
.custom-filter-dropdown {
    position: relative;
    width: 100%;
}

.custom-filter-dropdown .dropdown-menu {
    top: 100% !important;
    left: 0 !important;
    right: 0 !important;
    width: 100% !important;
    min-width: 100% !important;
    max-width: 100% !important;
    max-height: 280px;
    overflow-y: auto;
    box-sizing: border-box !important;
    background: #ffffff !important;
    border: 1.5px solid rgba(201, 151, 56, 0.35) !important;
    border-radius: 14px !important;
    box-shadow: 0 14px 35px rgba(133, 24, 41, 0.16) !important;
    margin-top: 6px !important;
    padding: 6px !important;
    z-index: 100 !important;
    animation: dropdownFadeIn 0.18s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.custom-filter-dropdown .dropdown-menu::-webkit-scrollbar {
    width: 5px;
}

.custom-filter-dropdown .dropdown-menu::-webkit-scrollbar-track {
    background: #f8f6f3;
    border-radius: 10px;
}

.custom-filter-dropdown .dropdown-menu::-webkit-scrollbar-thumb {
    background: rgba(201, 151, 56, 0.4);
    border-radius: 10px;
}

.custom-filter-dropdown .dropdown-menu::-webkit-scrollbar-thumb:hover {
    background: rgba(133, 24, 41, 0.6);
}

@keyframes dropdownFadeIn {
    from {
        opacity: 0;
        transform: translateY(-4px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.custom-filter-dropdown .dropdown-item {
    font-size: 0.86rem;
    color: #2c323f;
    border-radius: 8px;
    padding: 8px 12px;
    font-weight: 500;
    transition: all 0.18s ease;
}

.custom-filter-dropdown .dropdown-item:hover {
    background-color: rgba(201, 151, 56, 0.12) !important;
    color: var(--theme-primary) !important;
    font-weight: 600;
    transform: translateX(2px);
}

.custom-filter-dropdown .dropdown-item.active-option {
    background-color: rgba(201, 151, 56, 0.15) !important;
    color: #851829 !important;
    font-weight: 700;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropdown = document.querySelector('.custom-filter-dropdown');
    if (!dropdown) return;

    const input = document.getElementById('religionFilterInput');
    const label = document.getElementById('religionSelectedLabel');
    const options = dropdown.querySelectorAll('.custom-filter-option');

    options.forEach(function (option) {
        option.addEventListener('click', function (e) {
            e.preventDefault();
            const val = this.getAttribute('data-value');
            const text = this.querySelector('span').textContent;

            input.value = val;
            label.textContent = text;

            options.forEach(function (el) {
                el.classList.remove('active-option');
                const check = el.querySelector('.check-icon');
                if (check) check.remove();
            });

            this.classList.add('active-option');
            this.insertAdjacentHTML('beforeend', '<i class="bi bi-check2 text-warning fw-bold check-icon"></i>');

            const bsDropdown = bootstrap.Dropdown.getInstance(document.getElementById('religionDropdownTrigger'));
            if (bsDropdown) {
                bsDropdown.hide();
            }

            // Trigger spinner animation on the filter button
            const filterBtn = document.getElementById('filterSubmitBtn');
            if (filterBtn) {
                filterBtn.innerHTML = '<span class="spinner-border spinner-border-sm text-warning" role="status" aria-hidden="true" style="width: 1.15rem; height: 1.15rem; border-width: 2.2px;"></span>';
                filterBtn.style.pointerEvents = 'none';
                filterBtn.style.opacity = '0.9';
            }

            // Auto-submit the filter form
            const form = dropdown.closest('form');
            if (form) {
                form.submit();
            }
        });
    });

    // Trigger spinner when submitting filter form via button or enter key
    const filterForm = document.querySelector('.filter-luxury-card form');
    if (filterForm) {
        filterForm.addEventListener('submit', function () {
            const filterBtn = document.getElementById('filterSubmitBtn');
            if (filterBtn && !filterBtn.dataset.submitted) {
                filterBtn.dataset.submitted = 'true';
                filterBtn.innerHTML = '<span class="spinner-border spinner-border-sm text-warning" role="status" aria-hidden="true" style="width: 1.15rem; height: 1.15rem; border-width: 2.2px;"></span>';
                filterBtn.style.pointerEvents = 'none';
                filterBtn.style.opacity = '0.9';
            }
        });
    }

    // Trigger spinner when clicking reset filter button
    const resetBtn = document.getElementById('filterResetBtn');
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            this.innerHTML = '<span class="spinner-border spinner-border-sm text-danger" role="status" aria-hidden="true" style="width: 0.95rem; height: 0.95rem; border-width: 1.8px;"></span>';
            this.style.pointerEvents = 'none';
            this.style.opacity = '0.9';
        });
    }
});
</script>
@endsection
