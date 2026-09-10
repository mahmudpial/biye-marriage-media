<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MembershipPackage;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClientController extends Controller
{
    /**
     * Display a listing of client accounts.
     */
    public function index(Request $request): View
    {
        $query = User::clients()->with(['candidateProfile', 'assignedStaff', 'activeSubscription']);

        // Search by keyword
        if ($request->filled('q')) {
            $search = trim($request->q);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('guardian_name', 'like', "%{$search}%")
                    ->orWhereHas('candidateProfile', function ($sub) use ($search) {
                        $sub->where('profile_code', 'like', "%{$search}%")
                            ->orWhere('desher_bari', 'like', "%{$search}%")
                            ->orWhere('profession', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by Verification Status
        if ($request->filled('verification_status')) {
            $query->where('verification_status', $request->verification_status);
        }

        // Filter by Account Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Assigned Matchmaker
        if ($request->filled('assigned_staff_id')) {
            $query->where('assigned_staff_id', $request->assigned_staff_id);
        }

        // Filter by Gender
        if ($request->filled('gender')) {
            $gender = $request->gender;
            $query->whereHas('candidateProfile', function ($sub) use ($gender) {
                $sub->where('gender', $gender);
            });
        }

        $clients = $query->latest()->paginate(15)->withQueryString();

        // Statistics
        $totalClients = User::clients()->count();
        $pendingVerificationCount = User::clients()->where('verification_status', User::VERIFICATION_PENDING)->count();
        $activeClientsCount = User::clients()->where('status', User::STATUS_ACTIVE)->count();
        $suspendedClientsCount = User::clients()->where('status', User::STATUS_SUSPENDED)->count();

        $staffMembers = User::staffMembers()->get();
        $packages = MembershipPackage::all();

        return view('admin.clients.index', compact(
            'clients',
            'totalClients',
            'pendingVerificationCount',
            'activeClientsCount',
            'suspendedClientsCount',
            'staffMembers',
            'packages'
        ));
    }

    /**
     * Display full profile & history for a client.
     */
    public function show(User $client): View
    {
        abort_unless($client->isClient(), 404);

        $client->load([
            'candidateProfile',
            'assignedStaff',
            'subscriptions.package',
            'sentProposals.receiverProfile',
            'shortlists.candidateProfile',
            'documents',
        ]);

        $candidateProfile = $client->candidateProfile;
        $receivedProposals = $candidateProfile
            ? $candidateProfile->receivedProposals()->with(['senderUser', 'senderProfile'])->latest()->get()
            : collect();

        $staffMembers = User::staffMembers()->get();
        $packages = MembershipPackage::all();

        return view('admin.clients.show', compact(
            'client',
            'candidateProfile',
            'receivedProposals',
            'staffMembers',
            'packages'
        ));
    }

    /**
     * Toggle client status (Active / Suspended / Ban).
     */
    public function updateStatus(Request $request, User $client): RedirectResponse
    {
        abort_unless($client->isClient(), 404);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:active,suspended,pending'],
            'suspension_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $status = $validated['status'];
        $isActive = ($status === User::STATUS_ACTIVE);

        $client->update([
            'status' => $status,
            'is_active' => $isActive,
            'suspension_reason' => $status === User::STATUS_SUSPENDED ? ($validated['suspension_reason'] ?? 'Administrative moderation') : null,
        ]);

        $message = $isActive
            ? 'ক্লায়েন্ট অ্যাকাউন্ট সক্রিয় করা হয়েছে।'
            : 'ক্লায়েন্ট অ্যাকাউন্ট স্থগিত করা হয়েছে।';

        return back()->with('success', $message);
    }

    /**
     * Verify or Reject client account credentials.
     */
    public function verify(Request $request, User $client): RedirectResponse
    {
        abort_unless($client->isClient(), 404);

        $validated = $request->validate([
            'verification_status' => ['required', 'string', 'in:verified,pending,rejected'],
            'approval_status' => ['nullable', 'string', 'in:approved,under_review,rejected,draft'],
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $vStatus = $validated['verification_status'];

        $client->update([
            'verification_status' => $vStatus,
            'verified_at' => $vStatus === User::VERIFICATION_VERIFIED ? now() : null,
        ]);

        // Synchronize candidate profile approval
        if ($client->candidateProfile) {
            $approvalStatus = $validated['approval_status'] ?? ($vStatus === User::VERIFICATION_VERIFIED ? 'approved' : 'under_review');
            $client->candidateProfile->update([
                'approval_status' => $approvalStatus,
                'admin_notes' => $validated['admin_notes'] ?? $client->candidateProfile->admin_notes,
            ]);
        }

        $message = $vStatus === User::VERIFICATION_VERIFIED
            ? 'ক্লায়েন্ট বায়োডাটা এবং ব্লু ভেরিফাইড সিল সফলভাবে অনুমোদন করা হয়েছে।'
            : 'ভেরিফিকেশন স্ট্যাটাস পরিবর্তন করা হয়েছে।';

        return back()->with('success', $message);
    }

    /**
     * Assign or reassign a Relationship Manager (Staff).
     */
    public function assignStaff(Request $request, User $client): RedirectResponse
    {
        abort_unless($client->isClient(), 404);

        $validated = $request->validate([
            'assigned_staff_id' => ['nullable', 'exists:users,id'],
        ]);

        $client->update([
            'assigned_staff_id' => $validated['assigned_staff_id'] ?: null,
        ]);

        return back()->with('success', 'ম্যাচমেকার রিলেশনশিপ ম্যানেজার সফলভাবে অ্যাসাইন করা হয়েছে।');
    }

    /**
     * Upgrade subscription plan and allocate proposal quota.
     */
    public function updateSubscription(Request $request, User $client): RedirectResponse
    {
        abort_unless($client->isClient(), 404);

        $validated = $request->validate([
            'package_id' => ['nullable', 'exists:membership_packages,id'],
            'package_name' => ['required', 'string', 'max:100'],
            'price_paid' => ['required', 'numeric', 'min:0'],
            'proposals_quota' => ['required', 'integer', 'min:0'],
            'contact_views_quota' => ['nullable', 'integer', 'min:0'],
            'validity_months' => ['required', 'integer', 'min:1', 'max:36'],
            'payment_method' => ['nullable', 'string', 'max:50'],
            'transaction_id' => ['nullable', 'string', 'max:100'],
            'admin_notes' => ['nullable', 'string', 'max:500'],
        ]);

        // Deactivate previous active subscriptions
        $client->subscriptions()->where('status', 'active')->update(['status' => 'expired']);

        // Create new active subscription
        UserSubscription::create([
            'user_id' => $client->id,
            'package_id' => $validated['package_id'] ?: null,
            'package_name' => $validated['package_name'],
            'price_paid' => $validated['price_paid'],
            'proposals_quota' => $validated['proposals_quota'],
            'proposals_used' => 0,
            'contact_views_quota' => $validated['contact_views_quota'] ?? 0,
            'contact_views_used' => 0,
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => now()->addMonths((int) $validated['validity_months']),
            'payment_method' => $validated['payment_method'] ?? 'manual_admin',
            'transaction_id' => $validated['transaction_id'] ?? null,
            'admin_notes' => $validated['admin_notes'] ?? 'Manual package upgrade by administrator.',
        ]);

        return back()->with('success', 'ক্লায়েন্টের মেম্বারশিপ প্যাকেজ ও প্রপোজাল কোটা সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Impersonate client to view and resolve profile issues.
     */
    public function impersonate(User $client): RedirectResponse
    {
        abort_unless($client->isClient(), 404);

        $admin = Auth::user();
        session(['impersonator_admin_id' => $admin->id]);

        Auth::login($client);

        return redirect()->route('member.dashboard')
            ->with('info', "আপনি বর্তমানে ক্লায়েন্ট [{$client->name}]-এর ভিউতে রয়েছেন। সমস্যা সমাধান শেষে উপরে ক্লিক করে অ্যাডমিন ড্যাশবোর্ডে ফিরে যান।");
    }

    /**
     * Stop impersonating and return to admin portal.
     */
    public function stopImpersonate(): RedirectResponse
    {
        $adminId = session()->pull('impersonator_admin_id');

        if ($adminId) {
            $admin = User::find($adminId);
            if ($admin && $admin->isStaff()) {
                Auth::login($admin);

                return redirect()->route('admin.clients.index')
                    ->with('success', 'স্বাভাবিক অ্যাডমিন অ্যাকাউন্টে ফিরে এসেছেন।');
            }
        }

        return redirect()->route('home');
    }
}
