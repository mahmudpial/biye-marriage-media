<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the site settings management page.
     */
    public function index(): View
    {
        $settings = SiteSetting::allAsArray();

        return view('admin.settings.index', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update the site settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            // General
            'site_name' => ['required', 'string', 'max:100'],
            'site_tagline' => ['nullable', 'string', 'max:200'],
            'about_summary' => ['nullable', 'string', 'max:1000'],

            // Contact
            'contact_phone' => ['required', 'string', 'max:50'],
            'whatsapp_number' => ['required', 'string', 'max:50'],
            'contact_email' => ['required', 'email', 'max:100'],
            'office_address' => ['required', 'string', 'max:300'],
            'office_hours' => ['nullable', 'string', 'max:150'],

            // Social
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'whatsapp_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],

            // Announcement
            'announcement_enabled' => ['nullable'],
            'announcement_text' => ['nullable', 'string', 'max:500'],
            'announcement_link' => ['nullable', 'string', 'max:255'],

            // SEO
            'meta_title_suffix' => ['nullable', 'string', 'max:150'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $definitions = [
                // General
                'site_name' => ['group' => 'general', 'type' => 'text'],
                'site_tagline' => ['group' => 'general', 'type' => 'text'],
                'about_summary' => ['group' => 'general', 'type' => 'textarea'],

                // Contact
                'contact_phone' => ['group' => 'contact', 'type' => 'text'],
                'whatsapp_number' => ['group' => 'contact', 'type' => 'text'],
                'contact_email' => ['group' => 'contact', 'type' => 'text'],
                'office_address' => ['group' => 'contact', 'type' => 'textarea'],
                'office_hours' => ['group' => 'contact', 'type' => 'text'],

                // Social
                'facebook_url' => ['group' => 'social', 'type' => 'text'],
                'instagram_url' => ['group' => 'social', 'type' => 'text'],
                'whatsapp_url' => ['group' => 'social', 'type' => 'text'],
                'youtube_url' => ['group' => 'social', 'type' => 'text'],

                // Announcement
                'announcement_enabled' => ['group' => 'announcement', 'type' => 'boolean'],
                'announcement_text' => ['group' => 'announcement', 'type' => 'textarea'],
                'announcement_link' => ['group' => 'announcement', 'type' => 'text'],

                // SEO
                'meta_title_suffix' => ['group' => 'seo', 'type' => 'text'],
                'meta_description' => ['group' => 'seo', 'type' => 'textarea'],
            ];

            foreach ($definitions as $key => $meta) {
                if ($key === 'announcement_enabled') {
                    $val = $request->boolean('announcement_enabled') ? '1' : '0';
                } else {
                    $val = $request->input($key, '');
                }

                SiteSetting::set($key, $val ?? '', $meta['group'], $meta['type']);
            }

            SiteSetting::clearCache();

            return redirect()->route('admin.settings.index')
                ->with('success', 'Site settings updated successfully.');
        } catch (\Throwable $e) {
            Log::error('Failed to update site settings: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Unable to save settings: '.$e->getMessage(),
            ]);
        }
    }
}
