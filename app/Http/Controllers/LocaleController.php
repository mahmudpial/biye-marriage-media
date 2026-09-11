<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Switch application locale and redirect back.
     */
    public function switch(Request $request, string $lang): RedirectResponse
    {
        if (in_array($lang, ['bn', 'en'], true)) {
            session(['locale' => $lang]);
        }

        return back();
    }
}
