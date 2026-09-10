<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\CandidateProfile;
use App\Models\Proposal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProposalController extends Controller
{
    /**
     * Display proposals sent and received.
     */
    public function index(): View
    {
        $user = Auth::user();
        $candidateProfile = $user->candidateProfile;
        $activeSubscription = $user->activeSubscription;

        $sentProposals = $user->sentProposals()
            ->with(['receiverProfile', 'assignedStaff'])
            ->latest()
            ->paginate(10, ['*'], 'sent_page');

        $receivedProposals = $candidateProfile
            ? $candidateProfile->receivedProposals()
                ->with(['senderUser', 'senderProfile', 'assignedStaff'])
                ->latest()
                ->paginate(10, ['*'], 'received_page')
            : collect();

        return view('member.proposals', compact(
            'user',
            'candidateProfile',
            'activeSubscription',
            'sentProposals',
            'receivedProposals'
        ));
    }

    /**
     * Send a marriage proposal/interest to a candidate.
     */
    public function send(Request $request, CandidateProfile $candidateProfile): RedirectResponse
    {
        $user = Auth::user();
        $myProfile = $user->candidateProfile;

        if (! $myProfile) {
            return redirect()->route('member.biodata.edit')
                ->with('error', 'প্রস্তাব পাঠানোর পূর্বে আপনার বায়োডাটা সম্পন্ন করুন।');
        }

        if ($myProfile->gender === $candidateProfile->gender) {
            return back()->with('error', 'শুধুমাত্র বিপরীত লিঙ্গের পাত্র/পাত্রীর বায়োডাটাতে প্রস্তাব পাঠানো সম্ভব।');
        }

        // Check if already sent
        $alreadySent = Proposal::query()
            ->where('sender_user_id', $user->id)
            ->where('receiver_profile_id', $candidateProfile->id)
            ->exists();

        if ($alreadySent) {
            return back()->with('info', 'আপনি ইতিমধ্যে এই পাত্র/পাত্রীর কাছে প্রস্তাব পাঠিয়েছেন। আমাদের ম্যাচমেকার টিম এটি পর্যবেক্ষণ করছে।');
        }

        // Check quota in active subscription
        $subscription = $user->activeSubscription;
        if (! $subscription || ! $subscription->hasProposals()) {
            return back()->with('error', 'আপনার বর্তমান প্যাকেজের প্রপোজাল কোটা শেষ হয়ে গেছে। অনুগ্রহ করে প্যাকেজ আপগ্রেড করুন বা আপনার রিলেশনশিপ ম্যানেজারের সাথে যোগাযোগ করুন।');
        }

        $validated = $request->validate([
            'message' => ['nullable', 'string', 'max:500'],
        ]);

        // Consume 1 quota
        $subscription->increment('proposals_used');

        Proposal::create([
            'sender_user_id' => $user->id,
            'sender_profile_id' => $myProfile->id,
            'receiver_profile_id' => $candidateProfile->id,
            'status' => Proposal::STATUS_PENDING,
            'assigned_staff_id' => $user->assigned_staff_id,
            'sender_message' => $validated['message'] ?? 'We are expressing preliminary family interest after reviewing the respectful biodata credentials.',
        ]);

        return back()->with('success', 'আপনার প্রস্তাবনাটি সফলভাবে পাঠানো হয়েছে! আমাদের সিনিয়র ম্যাচমেকার অপর পক্ষের অভিভাবকের সাথে কথা বলে অগ্রগতি জানাবেন।');
    }

    /**
     * Respond to an incoming proposal (Accept / Decline).
     */
    public function respond(Request $request, Proposal $proposal): RedirectResponse
    {
        $user = Auth::user();
        $myProfile = $user->candidateProfile;

        if (! $myProfile || $proposal->receiver_profile_id !== $myProfile->id) {
            abort(403, 'Unauthorized action on proposal.');
        }

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:accepted,declined'],
        ]);

        $status = $validated['status'];
        $proposal->update([
            'status' => $status,
            'responded_at' => now(),
        ]);

        $msg = $status === 'accepted'
            ? 'আপনি প্রস্তাবটি সাদরে গ্রহণ করেছেন! দায়িত্বপ্রাপ্ত ম্যাচমেকার উভয় পরিবারের মধ্যে আলোচনা সমন্বয় করবেন।'
            : 'প্রস্তাবটি বিনীতভাবে নাকচ করা হয়েছে।';

        return back()->with('success', $msg);
    }
}
