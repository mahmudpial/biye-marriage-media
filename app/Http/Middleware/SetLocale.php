<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported application locales.
     *
     * @var array<int, string>
     */
    protected array $supportedLocales = ['bn', 'en'];

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('lang') && in_array($request->query('lang'), $this->supportedLocales, true)) {
            $locale = $request->query('lang');
            session(['locale' => $locale]);
        } else {
            $locale = session('locale', config('app.locale', 'bn'));
            if (! in_array($locale, $this->supportedLocales, true)) {
                $locale = config('app.fallback_locale', 'bn');
            }
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
