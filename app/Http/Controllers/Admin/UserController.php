<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of admin staff and matchmakers.
     */
    public function index(Request $request): View
    {
        $query = User::query()->where('is_admin', true);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->orderBy('role', 'asc')->orderBy('name', 'asc')->paginate(10)->withQueryString();

        $allStaff = User::where('is_admin', true)->get();

        $stats = [
            'total' => $allStaff->count(),
            'active' => $allStaff->where('is_active', true)->count(),
            'super_admins' => $allStaff->where('role', User::ROLE_SUPER_ADMIN)->count(),
            'matchmakers' => $allStaff->whereIn('role', [User::ROLE_SENIOR_MATCHMAKER, User::ROLE_RELATIONSHIP_MANAGER])->count(),
        ];

        return view('admin.users.index', [
            'users' => $users,
            'stats' => $stats,
            'roles' => User::ROLES,
            'filters' => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new administrative user / matchmaker.
     */
    public function create(): View
    {
        return view('admin.users.form', [
            'user' => new User([
                'is_active' => true,
                'role' => User::ROLE_RELATIONSHIP_MANAGER,
            ]),
            'roles' => User::ROLES,
            'isEdit' => false,
        ]);
    }

    /**
     * Store a newly created admin user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['required', 'string', Rule::in(array_keys(User::ROLES))],
                'designation' => ['nullable', 'string', 'max:100'],
                'phone' => ['nullable', 'string', 'max:30'],
                'is_active' => ['nullable'],
            ], [
                'name.required' => 'Full name is required.',
                'email.required' => 'Official email address is required.',
                'email.unique' => 'This email address is already registered to another staff member.',
                'password.min' => 'The password must be at least 8 characters long.',
                'password.confirmed' => 'Password confirmation does not match.',
                'role.required' => 'Please designate a team role.',
            ]);

            $validated['password'] = Hash::make($validated['password']);
            $validated['is_admin'] = true;
            $validated['is_active'] = $request->boolean('is_active', true);

            $user = User::create($validated);

            return redirect()->route('admin.users.index')
                ->with('success', "Team member '{$user->name}' has been added successfully.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('Failed to create team member: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withInput($request->except('password', 'password_confirmation'))->withErrors([
                'error' => 'Unable to create staff account: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified admin staff / matchmaker details.
     */
    public function show(User $user): View
    {
        return view('admin.users.show', [
            'user' => $user,
            'roles' => User::ROLES,
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.form', [
            'user' => $user,
            'roles' => User::ROLES,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
                'role' => ['required', 'string', Rule::in(array_keys(User::ROLES))],
                'designation' => ['nullable', 'string', 'max:100'],
                'phone' => ['nullable', 'string', 'max:30'],
                'is_active' => ['nullable'],
            ], [
                'name.required' => 'Full name is required.',
                'email.required' => 'Official email address is required.',
                'email.unique' => 'This email address is already registered to another staff member.',
                'password.min' => 'The password must be at least 8 characters long.',
                'password.confirmed' => 'Password confirmation does not match.',
                'role.required' => 'Please designate a team role.',
            ]);

            // Self-deactivation protection
            if ($user->id === auth()->id() && ! $request->boolean('is_active')) {
                return back()->withInput()->withErrors([
                    'is_active' => 'Security restriction: You cannot deactivate your own logged-in administrator account.',
                ]);
            }

            // Self-demotion protection if sole super admin
            if ($user->id === auth()->id() && $user->role === User::ROLE_SUPER_ADMIN && $validated['role'] !== User::ROLE_SUPER_ADMIN) {
                $otherSuperAdmins = User::where('role', User::ROLE_SUPER_ADMIN)->where('id', '!=', $user->id)->count();
                if ($otherSuperAdmins === 0) {
                    return back()->withInput()->withErrors([
                        'role' => 'Security restriction: You are currently the sole Super Administrator and cannot demote your own account.',
                    ]);
                }
            }

            if (! empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $validated['is_admin'] = true;
            $validated['is_active'] = $request->boolean('is_active');

            $user->update($validated);

            return redirect()->route('admin.users.index')
                ->with('success', "Staff profile for '{$user->name}' has been updated successfully.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error("Failed to update staff #{$user->id}: ".$e->getMessage(), [
                'exception' => $e,
                'user_id' => $user->id,
            ]);

            return back()->withInput($request->except('password', 'password_confirmation'))->withErrors([
                'error' => 'Unable to update staff account: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            // Guard: Cannot delete self
            if ($user->id === auth()->id()) {
                return back()->withErrors([
                    'error' => 'Security restriction: You cannot delete your own logged-in administrator account.',
                ]);
            }

            // Guard: Cannot delete primary super admin
            if ($user->email === 'admin@biyemedia.com') {
                return back()->withErrors([
                    'error' => 'Security restriction: The primary executive admin account cannot be deleted.',
                ]);
            }

            $name = $user->name;
            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', "Staff account '{$name}' has been deleted.");
        } catch (\Throwable $e) {
            Log::error("Failed to delete staff #{$user->id}: ".$e->getMessage(), [
                'exception' => $e,
                'user_id' => $user->id,
            ]);

            return back()->withErrors([
                'error' => 'Unable to delete staff account: '.$e->getMessage(),
            ]);
        }
    }

    /**
     * Toggle the active status of an admin user.
     */
    public function toggleActive(Request $request, User $user): RedirectResponse|JsonResponse
    {
        // Guard: Cannot toggle own active status
        if ($user->id === auth()->id()) {
            $msg = 'Security restriction: You cannot deactivate your own administrator account.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 403);
            }

            return back()->withErrors(['error' => $msg]);
        }

        // Guard: Cannot deactivate primary super admin
        if ($user->email === 'admin@biyemedia.com' && $user->is_active) {
            $msg = 'Security restriction: The primary system administrator cannot be deactivated.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 403);
            }

            return back()->withErrors(['error' => $msg]);
        }

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        $statusText = $user->is_active ? 'activated' : 'deactivated';
        $message = "Staff member '{$user->name}' is now {$statusText}.";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $user->is_active,
                'message' => $message,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', $message);
    }
}
