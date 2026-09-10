<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\Proposal;
use App\Models\Shortlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the member overview dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();
        $candidateProfile = $user->candidateProfile;

        // Ensure candidate profile exists
        if (! $candidateProfile) {
            $candidateProfile = CandidateProfile::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'profile_code' => 'BD-ELT-'.random_int(20000, 99999),
                'gender' => 'female',
                'age' => 26,
                'height' => "5'4\"",
                'religion' => 'Islam (Sunni)',
                'desher_bari' => 'Dhaka',
                'education' => 'Bachelor / Masters',
                'profession' => 'Executive',
                'location' => 'Dhaka, Bangladesh',
                'income' => 'Confidential',
                'family' => 'Reputed family details will be provided.',
                'approval_status' => 'draft',
                'completion_score' => 40,
                'is_active' => true,
            ]);
        }

        $activeSubscription = $user->activeSubscription;
        $relationshipManager = $user->assignedStaff;

        $shortlistsCount = $user->shortlists()->count();
        $sentProposalsCount = $user->sentProposals()->count();
        $receivedProposalsCount = $candidateProfile ? $candidateProfile->receivedProposals()->count() : 0;
        $pendingReceivedCount = $candidateProfile ? $candidateProfile->receivedProposals()->where('status', Proposal::STATUS_PENDING)->count() : 0;

        // Smart Matches based on opposite gender and active approved status
        $oppositeGender = $candidateProfile->gender === 'female' ? 'male' : 'female';
        $recommendedProfilesQuery = CandidateProfile::query()
            ->where('is_active', true)
            ->where('approval_status', 'approved')
            ->where('gender', $oppositeGender);

        if (! empty($candidateProfile->pref_desher_bari)) {
            $recommendedProfilesQuery->where('desher_bari', $candidateProfile->pref_desher_bari);
        }

        $recommendedProfiles = $recommendedProfilesQuery->latest()->take(6)->get();

        // If no strict preference matches found, fallback to latest opposite gender
        if ($recommendedProfiles->isEmpty()) {
            $recommendedProfiles = CandidateProfile::query()
                ->where('is_active', true)
                ->where('approval_status', 'approved')
                ->where('gender', $oppositeGender)
                ->latest()
                ->take(6)
                ->get();
        }

        $shortlistedProfileIds = $user->shortlists()->pluck('candidate_profile_id')->toArray();

        return view('member.dashboard', compact(
            'user',
            'candidateProfile',
            'activeSubscription',
            'relationshipManager',
            'shortlistsCount',
            'sentProposalsCount',
            'receivedProposalsCount',
            'pendingReceivedCount',
            'recommendedProfiles',
            'shortlistedProfileIds'
        ));
    }

    /**
     * Browse matching partner profiles for the member.
     */
    public function matches(Request $request): View
    {
        $user = Auth::user();
        $candidateProfile = $user->candidateProfile;
        $oppositeGender = ($candidateProfile?->gender === 'female') ? 'male' : 'female';

        $query = CandidateProfile::query()
            ->where('is_active', true)
            ->where('approval_status', 'approved')
            ->where('gender', $oppositeGender);

        if ($request->filled('profession')) {
            $query->where('profession', 'like', '%'.$request->profession.'%');
        }

        if ($request->filled('desher_bari')) {
            $query->where('desher_bari', $request->desher_bari);
        }

        if ($request->filled('religion')) {
            $query->where('religion', $request->religion);
        }

        if ($request->filled('age_min')) {
            $query->where('age', '>=', (int) $request->age_min);
        }

        if ($request->filled('age_max')) {
            $query->where('age', '<=', (int) $request->age_max);
        }

        $profiles = $query->latest()->paginate(12)->withQueryString();
        $shortlistedProfileIds = $user->shortlists()->pluck('candidate_profile_id')->toArray();
        $sentProposalProfileIds = $user->sentProposals()->pluck('receiver_profile_id')->toArray();

        return view('member.matches', compact('user', 'candidateProfile', 'profiles', 'shortlistedProfileIds', 'sentProposalProfileIds'));
    }

    /**
     * View member shortlists.
     */
    public function shortlists(): View
    {
        $user = Auth::user();
        $shortlists = $user->shortlists()->with('candidateProfile')->latest()->paginate(12);
        $sentProposalProfileIds = $user->sentProposals()->pluck('receiver_profile_id')->toArray();

        return view('member.shortlists', compact('user', 'shortlists', 'sentProposalProfileIds'));
    }

    /**
     * Toggle shortlist item.
     */
    public function toggleShortlist(Request $request, CandidateProfile $candidateProfile)
    {
        $user = Auth::user();
        $existing = Shortlist::where('user_id', $user->id)
            ->where('candidate_profile_id', $candidateProfile->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $status = 'removed';
            $message = 'প্রোফাইলটি আপনার পছন্দের তালিকা (Shortlist) থেকে মুছে ফেলা হয়েছে।';
        } else {
            Shortlist::create([
                'user_id' => $user->id,
                'candidate_profile_id' => $candidateProfile->id,
            ]);
            $status = 'added';
            $message = 'প্রোফাইলটি সফলভাবে শর্টলিস্টে যুক্ত করা হয়েছে।';
        }

        if ($request->wantsJson()) {
            return response()->json(['status' => $status, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
