<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Display the admin login view.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle an incoming admin authentication request.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        try {
            if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'is_admin' => true], $remember)) {
                $request->session()->regenerate();

                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Welcome back! You have successfully signed into the admin console.');
            }

            // If credentials matched a non-admin user
            if (Auth::validate(['email' => $credentials['email'], 'password' => $credentials['password']])) {
                return back()->withInput($request->only('email', 'remember'))
                    ->withErrors(['email' => 'Your account does not have administrator access privileges.']);
            }

            return back()->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'The provided credentials do not match our records.']);
        } catch (\Throwable $e) {
            Log::error('Admin authentication failure: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'Authentication error: '.$e->getMessage()]);
        }
    }

    /**
     * Destroy an authenticated admin session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('info', 'You have been successfully signed out of the admin panel.');
    }
}
