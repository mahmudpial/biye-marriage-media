<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsClient
{
    /**
     * Handle an incoming request for member portal.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // If suspended or inactive
        if (! $user->is_active || $user->status === User::STATUS_SUSPENDED) {
            $reason = $user->suspension_reason ? ': '.$user->suspension_reason : '.';
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['login' => 'আপনার অ্যাকাউন্টটি স্থগিত রয়েছে'.$reason.' বিস্তারিত জানতে হেল্পডেস্কে যোগাযোগ করুন।']);
        }

        return $next($request);
    }
}
