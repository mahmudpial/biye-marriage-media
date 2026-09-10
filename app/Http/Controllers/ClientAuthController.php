<?php

namespace App\Http\Controllers;

use App\Models\CandidateProfile;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ClientAuthController extends Controller
{
    /**
     * Show client registration form.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return Auth::user()->isStaff()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('member.dashboard');
        }

        return view('auth.register');
    }

    /**
     * Process new client registration.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'profile_for' => ['required', 'string', 'in:self,daughter,son,brother,sister,relative'],
            'guardian_name' => ['nullable', 'string', 'max:100'],
            'gender' => ['required', 'string', 'in:male,female'],
            'desher_bari' => ['nullable', 'string', 'max:100'],
            'profession' => ['nullable', 'string', 'max:100'],
        ]);

        // Find available Relationship Manager to assign
        $assignedStaff = User::query()
            ->where('is_admin', true)
            ->whereIn('role', [User::ROLE_SENIOR_MATCHMAKER, User::ROLE_RELATIONSHIP_MANAGER, User::ROLE_SUPER_ADMIN])
            ->first();

        // 1. Create Client User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false,
            'user_type' => User::TYPE_CLIENT,
            'profile_for' => $validated['profile_for'],
            'guardian_name' => $validated['guardian_name'] ?? null,
            'assigned_staff_id' => $assignedStaff?->id,
            'verification_status' => User::VERIFICATION_PENDING,
            'status' => User::STATUS_ACTIVE,
            'is_active' => true,
        ]);

        // 2. Assign Welcome Subscription with 5 proposals quota
        UserSubscription::create([
            'user_id' => $user->id,
            'package_id' => null,
            'package_name' => 'Complimentary Welcome Plan',
            'price_paid' => 0.00,
            'proposals_quota' => 5,
            'proposals_used' => 0,
            'contact_views_quota' => 0,
            'contact_views_used' => 0,
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => now()->addMonths(6),
            'payment_method' => 'complimentary',
            'admin_notes' => 'Auto-granted upon initial elite registration.',
        ]);

        // 3. Create Starter Draft Candidate Profile
        $randomCode = 'BD-ELT-'.random_int(20000, 99999);
        while (CandidateProfile::where('profile_code', $randomCode)->exists()) {
            $randomCode = 'BD-ELT-'.random_int(20000, 99999);
        }

        CandidateProfile::create([
            'user_id' => $user->id,
            'full_name' => $validated['profile_for'] === 'self' ? $validated['name'] : null,
            'profile_code' => $randomCode,
            'gender' => $validated['gender'],
            'age' => $validated['gender'] === 'female' ? 25 : 28,
            'height' => $validated['gender'] === 'female' ? "5'3\"" : "5'8\"",
            'religion' => 'Islam (Sunni)',
            'desher_bari' => $validated['desher_bari'] ?? 'Dhaka',
            'education' => 'Bachelor / Master Degree',
            'profession' => $validated['profession'] ?? 'Professional Executive',
            'location' => 'Dhaka, Bangladesh',
            'income' => 'Confidential',
            'category' => 'Elite Professional',
            'family' => 'Reputed family details will be updated by candidate/guardian.',
            'is_discreet' => true,
            'is_featured' => false,
            'is_active' => true,
            'approval_status' => 'draft',
            'completion_score' => 35,
        ]);

        Auth::login($user);

        return redirect()->route('member.dashboard')
            ->with('success', 'স্বাগতম! আপনার অ্যাকাউন্ট সফলভাবে তৈরি হয়েছে। অনুগ্রহ করে আপনার পূর্ণাঙ্গ বায়োডাটা ও জীবনসঙ্গীর প্রত্যাশা পূরণ করুন।');
    }

    /**
     * Show client login view (redirects to modal on home page).
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return Auth::user()->isStaff()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('member.dashboard');
        }

        return redirect('/?login=1');
    }

    /**
     * Authenticate member or staff.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginInput = $credentials['login'];
        $remember = $request->boolean('remember');

        // Look up by email or phone
        $user = User::query()
            ->where('email', $loginInput)
            ->orWhere('phone', $loginInput)
            ->orWhere('phone', '+880'.ltrim($loginInput, '0+88'))
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()->withInput($request->only('login', 'remember'))
                ->withErrors(['login' => 'প্রদত্ত তথ্য আমাদের রেকর্ডের সাথে মিলছে না। অনুগ্রহ করে সঠিক ইমেইল/মোবাইল ও পাসওয়ার্ড দিন।']);
        }

        // Check if account is deactivated or suspended
        if (! $user->is_active || $user->status === User::STATUS_SUSPENDED) {
            $reason = $user->suspension_reason ? ': '.$user->suspension_reason : '.';

            return back()->withInput($request->only('login', 'remember'))
                ->withErrors(['login' => 'আপনার অ্যাকাউন্টটি সাময়িকভাবে স্থগিত রয়েছে'.$reason.' বিস্তারিত জানতে অ্যাডমিন বা রিলেশনশিপ ম্যানেজারের সাথে যোগাযোগ করুন।']);
        }

        Auth::login($user, $remember);
        $user->update(['last_login_at' => now()]);
        $request->session()->regenerate();

        if ($user->isStaff()) {
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back to the Admin Console!');
        }

        return redirect()->intended(route('member.dashboard'))
            ->with('success', 'স্বাগতম! আপনি সফলভাবে লগইন করেছেন।');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('info', 'আপনি সফলভাবে সাইন আউট হয়েছেন।');
    }
}
