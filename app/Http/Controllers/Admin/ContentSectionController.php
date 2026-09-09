<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContentSectionController extends Controller
{
    /**
     * Display the Homepage & Content Sections CMS Studio.
     */
    public function index(): View
    {
        $settings = SiteSetting::allAsArray();

        $heroFeatures = SiteSetting::getJson('hero_features');
        $specialtiesItems = SiteSetting::getJson('specialties_items');
        $processSteps = SiteSetting::getJson('process_steps');
        $aboutPillars = SiteSetting::getJson('about_pillars');
        $aboutConciergePoints = SiteSetting::getJson('about_concierge_points');

        return view('admin.sections.index', [
            'settings' => $settings,
            'heroFeatures' => $heroFeatures,
            'specialtiesItems' => $specialtiesItems,
            'processSteps' => $processSteps,
            'aboutPillars' => $aboutPillars,
            'aboutConciergePoints' => $aboutConciergePoints,
        ]);
    }

    /**
     * Update the homepage and content section settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            // Hero
            'hero_badge' => ['nullable', 'string', 'max:100'],
            'hero_title' => ['sometimes', 'required', 'string', 'max:500'],
            'hero_subtitle' => ['sometimes', 'required', 'string', 'max:1000'],
            'hero_cta_primary_text' => ['nullable', 'string', 'max:100'],
            'hero_cta_secondary_text' => ['nullable', 'string', 'max:100'],
            'hero_features' => ['nullable', 'array'],
            'hero_features.*.icon' => ['nullable', 'string', 'max:100'],
            'hero_features.*.title' => ['nullable', 'string', 'max:150'],
            'hero_features.*.desc' => ['nullable', 'string', 'max:255'],

            // Specialties
            'specialties_tag' => ['nullable', 'string', 'max:100'],
            'specialties_title' => ['sometimes', 'required', 'string', 'max:255'],
            'specialties_desc' => ['nullable', 'string', 'max:1000'],
            'specialties_items' => ['nullable', 'array'],
            'specialties_items.*.icon' => ['nullable', 'string', 'max:100'],
            'specialties_items.*.title' => ['nullable', 'string', 'max:150'],
            'specialties_items.*.desc' => ['nullable', 'string', 'max:500'],

            // Seamless Process
            'process_tag' => ['nullable', 'string', 'max:100'],
            'process_title' => ['sometimes', 'required', 'string', 'max:255'],
            'process_desc' => ['nullable', 'string', 'max:1000'],
            'process_cta_text' => ['nullable', 'string', 'max:150'],
            'process_steps' => ['nullable', 'array'],
            'process_steps.*.number' => ['nullable', 'string', 'max:20'],
            'process_steps.*.title' => ['nullable', 'string', 'max:150'],
            'process_steps.*.desc' => ['nullable', 'string', 'max:500'],

            // About Section
            'about_hero_badge' => ['nullable', 'string', 'max:100'],
            'about_hero_title' => ['sometimes', 'required', 'string', 'max:255'],
            'about_hero_subtitle' => ['nullable', 'string', 'max:1000'],
            'about_heritage_tag' => ['nullable', 'string', 'max:100'],
            'about_heritage_title' => ['sometimes', 'required', 'string', 'max:255'],
            'about_heritage_p1' => ['nullable', 'string', 'max:2000'],
            'about_heritage_p2' => ['nullable', 'string', 'max:2000'],
            'about_wedding_quote' => ['nullable', 'string', 'max:500'],
            'about_pillars_tag' => ['nullable', 'string', 'max:100'],
            'about_pillars_title' => ['nullable', 'string', 'max:255'],
            'about_pillars_desc' => ['nullable', 'string', 'max:1000'],
            'about_pillars' => ['nullable', 'array'],
            'about_pillars.*.icon' => ['nullable', 'string', 'max:100'],
            'about_pillars.*.title' => ['nullable', 'string', 'max:150'],
            'about_pillars.*.desc' => ['nullable', 'string', 'max:500'],
            'about_concierge_tag' => ['nullable', 'string', 'max:100'],
            'about_concierge_title' => ['nullable', 'string', 'max:255'],
            'about_concierge_desc' => ['nullable', 'string', 'max:1000'],
            'about_concierge_points' => ['nullable', 'array'],
            'about_concierge_points.*.title' => ['nullable', 'string', 'max:150'],
            'about_concierge_points.*.desc' => ['nullable', 'string', 'max:500'],

            // Final CTA
            'final_cta_badge' => ['nullable', 'string', 'max:100'],
            'final_cta_title' => ['sometimes', 'required', 'string', 'max:255'],
            'final_cta_subtitle' => ['nullable', 'string', 'max:1000'],
            'final_cta_button_text' => ['nullable', 'string', 'max:100'],

            // Footer
            'footer_copyright_text' => ['nullable', 'string', 'max:255'],
            'footer_trust_title' => ['nullable', 'string', 'max:100'],
            'footer_trust_subtitle' => ['nullable', 'string', 'max:150'],
            'footer_presence_note' => ['nullable', 'string', 'max:200'],
        ]);

        try {
            // 1. Text & Textarea fields mapping: key => [group, type]
            $textFields = [
                // Hero
                'hero_badge' => ['hero', 'text'],
                'hero_title' => ['hero', 'text'],
                'hero_subtitle' => ['hero', 'textarea'],
                'hero_cta_primary_text' => ['hero', 'text'],
                'hero_cta_secondary_text' => ['hero', 'text'],

                // Specialties
                'specialties_tag' => ['specialties', 'text'],
                'specialties_title' => ['specialties', 'text'],
                'specialties_desc' => ['specialties', 'textarea'],

                // Seamless Process
                'process_tag' => ['process', 'text'],
                'process_title' => ['process', 'text'],
                'process_desc' => ['process', 'textarea'],
                'process_cta_text' => ['process', 'text'],

                // About
                'about_hero_badge' => ['about', 'text'],
                'about_hero_title' => ['about', 'text'],
                'about_hero_subtitle' => ['about', 'textarea'],
                'about_heritage_tag' => ['about', 'text'],
                'about_heritage_title' => ['about', 'text'],
                'about_heritage_p1' => ['about', 'textarea'],
                'about_heritage_p2' => ['about', 'textarea'],
                'about_wedding_quote' => ['about', 'text'],
                'about_pillars_tag' => ['about', 'text'],
                'about_pillars_title' => ['about', 'text'],
                'about_pillars_desc' => ['about', 'textarea'],
                'about_concierge_tag' => ['about', 'text'],
                'about_concierge_title' => ['about', 'text'],
                'about_concierge_desc' => ['about', 'textarea'],

                // Final CTA
                'final_cta_badge' => ['final_cta', 'text'],
                'final_cta_title' => ['final_cta', 'text'],
                'final_cta_subtitle' => ['final_cta', 'textarea'],
                'final_cta_button_text' => ['final_cta', 'text'],

                // Footer
                'footer_copyright_text' => ['footer', 'text'],
                'footer_trust_title' => ['footer', 'text'],
                'footer_trust_subtitle' => ['footer', 'text'],
                'footer_presence_note' => ['footer', 'text'],
            ];

            foreach ($textFields as $key => [$group, $type]) {
                if ($request->has($key)) {
                    SiteSetting::set($key, (string) $request->input($key, ''), $group, $type);
                }
            }

            // 2. Structured JSON array fields
            $jsonFields = [
                'hero_features' => 'hero',
                'specialties_items' => 'specialties',
                'process_steps' => 'process',
                'about_pillars' => 'about',
                'about_concierge_points' => 'about',
            ];

            foreach ($jsonFields as $key => $group) {
                if ($request->has($key)) {
                    $arrayVal = $request->input($key);
                    if (is_array($arrayVal)) {
                        // Re-index cleanly as a numeric list
                        $cleanArray = array_values($arrayVal);
                        $jsonString = json_encode($cleanArray, JSON_UNESCAPED_UNICODE);
                        SiteSetting::set($key, $jsonString, $group, 'json');
                    }
                }
            }

            SiteSetting::clearCache();

            $activeTab = $request->input('active_tab');
            $message = match ($activeTab) {
                'hero' => 'Hero Section content updated successfully.',
                'specialties' => 'Our Specialties content updated successfully.',
                'process' => 'Seamless Process content updated successfully.',
                'about' => 'About Page content updated successfully.',
                'cta' => 'Final VIP CTA content updated successfully.',
                'footer' => 'Footer & Trust content updated successfully.',
                default => 'Page content sections updated successfully.',
            };

            $routeParams = $request->filled('active_tab') ? ['tab' => $activeTab] : [];

            return redirect()->route('admin.sections.index', $routeParams)
                ->with('success', $message);
        } catch (\Throwable $e) {
            Log::error('Failed to update content sections: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withInput()->withErrors([
                'error' => 'Unable to save page sections: '.$e->getMessage(),
            ]);
        }
    }
}
