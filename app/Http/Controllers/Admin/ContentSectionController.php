<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ContentSectionController extends Controller
{
    /**
     * Get definitions and metadata for all 11 manageable content sections.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function getSectionsDefinition(): array
    {
        return [
            'general' => [
                'key' => 'general',
                'title' => 'General & Brand Identity',
                'nav_label' => 'General & Brand',
                'category' => 'Global Branding',
                'icon' => 'bi-award',
                'badge' => 'Site & Brand',
                'description' => 'Site title, brand tagline, executive about summary, site logo, and favicon assets.',
                'preview_url' => route('home'),
            ],
            'contact' => [
                'key' => 'contact',
                'title' => 'Helpline & Regional Contact',
                'nav_label' => 'Helpline & Contact',
                'category' => 'Communications',
                'icon' => 'bi-headset',
                'badge' => 'Direct Channels',
                'description' => 'Primary hotline, WhatsApp concierge, official email, physical Dhaka office address, and hours.',
                'preview_url' => route('contact'),
            ],
            'social' => [
                'key' => 'social',
                'title' => 'Social Media Profiles',
                'nav_label' => 'Social Links',
                'category' => 'Social Network',
                'icon' => 'bi-share-fill',
                'badge' => '4 Channels',
                'description' => 'Facebook page, Instagram profile, WhatsApp direct link, and YouTube matrimonial channel.',
                'preview_url' => route('home'),
            ],
            'announcement' => [
                'key' => 'announcement',
                'title' => 'Announcement Marquee Bar',
                'nav_label' => 'Announcement Bar',
                'category' => 'Top Notice Bar',
                'icon' => 'bi-megaphone',
                'badge' => 'Live Ticker',
                'description' => 'Top header notice ticker with live toggle switch, custom broadcast message, and action URL.',
                'preview_url' => route('home'),
            ],
            'seo' => [
                'key' => 'seo',
                'title' => 'SEO & Social Share Meta',
                'nav_label' => 'SEO & Meta',
                'category' => 'Search & Share',
                'icon' => 'bi-search',
                'badge' => 'Metadata',
                'description' => 'Meta title suffix, default search description, and OpenGraph social thumbnail image.',
                'preview_url' => route('home'),
            ],
            'hero' => [
                'key' => 'hero',
                'title' => 'Homepage Hero Section',
                'nav_label' => 'Hero Section',
                'category' => 'Homepage Core',
                'icon' => 'bi-stars',
                'badge' => 'Landing Banner',
                'description' => 'Hero headline, serif highlights, intro subtitle, primary & secondary CTAs, and 4 highlight boxes.',
                'preview_url' => route('home'),
            ],
            'specialties' => [
                'key' => 'specialties',
                'title' => 'Our Specialties & Services',
                'nav_label' => 'Specialties',
                'category' => 'Service Pillars',
                'icon' => 'bi-gem',
                'badge' => '6 Service Cards',
                'description' => 'Section tag, heading, overview text, and 6 bespoke service pillar cards with custom icons.',
                'preview_url' => route('home'),
            ],
            'process' => [
                'key' => 'process',
                'title' => 'Seamless Process Timeline',
                'nav_label' => 'Process',
                'category' => 'Process Timeline',
                'icon' => 'bi-signpost-split',
                'badge' => '3 Step Cards',
                'description' => 'Milestone timeline tag, title, description, consultation booking CTA button, and 3 numbered step cards.',
                'preview_url' => route('home'),
            ],
            'about' => [
                'key' => 'about',
                'title' => 'About Us Page & Core Pillars',
                'nav_label' => 'About & Pillars',
                'category' => 'About Heritage',
                'icon' => 'bi-building',
                'badge' => 'Heritage & Pillars',
                'description' => 'About hero banner, founding philosophy, wedding photo & quote, 3 core pillars, and matchmaker concierge team.',
                'preview_url' => route('about'),
            ],
            'cta' => [
                'key' => 'cta',
                'title' => 'Final VIP Call-to-Action',
                'nav_label' => 'Final CTA',
                'category' => 'Conversion Banner',
                'icon' => 'bi-telephone-outbound',
                'badge' => 'VIP Banner',
                'description' => 'Bottom VIP headline, gold crest badge, family privacy reassurance note, and callback button text.',
                'preview_url' => route('home'),
            ],
            'footer' => [
                'key' => 'footer',
                'title' => 'Footer Notes & Trust Badges',
                'nav_label' => 'Footer Notes',
                'category' => 'Global Footer',
                'icon' => 'bi-card-text',
                'badge' => 'Legal & Trust',
                'description' => 'Regional presence notes, 100% confidential trust badge texts, and official legal copyright statement.',
                'preview_url' => route('home'),
            ],
        ];
    }

    /**
     * Display the Card-Based Page Content & Sections CMS Studio Hub.
     */
    public function index(): View
    {
        $sections = self::getSectionsDefinition();
        $settings = SiteSetting::allAsArray();

        $stats = [
            'total_sections' => count($sections),
            'homepage_sections' => 5,
            'branding_sections' => 5,
            'page_modules' => 3,
        ];

        return view('admin.sections.index', [
            'sections' => $sections,
            'settings' => $settings,
            'stats' => $stats,
        ]);
    }

    /**
     * Display the dedicated editor form for a specific content section.
     */
    public function edit(string $section): View
    {
        $definitions = self::getSectionsDefinition();

        if (! array_key_exists($section, $definitions)) {
            abort(404, "Section '{$section}' not found.");
        }

        $sectionDef = $definitions[$section];
        $settings = SiteSetting::allAsArray();

        $heroFeatures = SiteSetting::getJson('hero_features');
        $specialtiesItems = SiteSetting::getJson('specialties_items');
        $processSteps = SiteSetting::getJson('process_steps');
        $aboutPillars = SiteSetting::getJson('about_pillars');
        $aboutConciergePoints = SiteSetting::getJson('about_concierge_points');

        return view('admin.sections.edit', [
            'sectionKey' => $section,
            'sectionDef' => $sectionDef,
            'sections' => $definitions,
            'settings' => $settings,
            'heroFeatures' => $heroFeatures,
            'specialtiesItems' => $specialtiesItems,
            'processSteps' => $processSteps,
            'aboutPillars' => $aboutPillars,
            'aboutConciergePoints' => $aboutConciergePoints,
        ]);
    }

    /**
     * Update a specific content section directly via its dedicated route.
     */
    public function updateSection(Request $request, string $section): RedirectResponse
    {
        $definitions = self::getSectionsDefinition();

        if (! array_key_exists($section, $definitions)) {
            abort(404, "Section '{$section}' not found.");
        }

        $sectionDef = $definitions[$section];

        try {
            switch ($section) {
                case 'general':
                    $request->validate([
                        'site_name' => ['required', 'string', 'max:150'],
                        'site_tagline' => ['required', 'string', 'max:255'],
                        'about_summary' => ['required', 'string', 'max:1000'],
                        'site_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
                        'site_logo_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
                        'site_favicon' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,ico', 'max:2048'],
                        'site_favicon_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,ico', 'max:2048'],
                        'theme_primary' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
                        'theme_secondary' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
                        'theme_accent' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
                    ]);

                    SiteSetting::set('site_name', (string) $request->input('site_name'), 'general', 'text');
                    SiteSetting::set('site_tagline', (string) $request->input('site_tagline'), 'general', 'text');
                    SiteSetting::set('about_summary', (string) $request->input('about_summary'), 'general', 'textarea');

                    if ($request->filled('theme_primary')) {
                        SiteSetting::set('theme_primary', (string) $request->input('theme_primary'), 'general', 'color');
                    }
                    if ($request->filled('theme_secondary')) {
                        SiteSetting::set('theme_secondary', (string) $request->input('theme_secondary'), 'general', 'color');
                    }
                    if ($request->filled('theme_accent')) {
                        SiteSetting::set('theme_accent', (string) $request->input('theme_accent'), 'general', 'color');
                    }

                    $logoPath = $this->handleFileUpload($request, 'site_logo_file', SiteSetting::get('site_logo'));
                    if ($logoPath) {
                        SiteSetting::set('site_logo', $logoPath, 'general', 'image');
                    }

                    $faviconPath = $this->handleFileUpload($request, 'site_favicon_file', SiteSetting::get('site_favicon'));
                    if ($faviconPath) {
                        SiteSetting::set('site_favicon', $faviconPath, 'general', 'image');
                    }
                    break;

                case 'contact':
                    $request->validate([
                        'contact_phone' => ['required', 'string', 'max:50'],
                        'whatsapp_number' => ['required', 'string', 'max:50'],
                        'contact_email' => ['required', 'email', 'max:150'],
                        'office_address' => ['required', 'string', 'max:500'],
                        'office_hours' => ['required', 'string', 'max:200'],
                    ]);

                    SiteSetting::set('contact_phone', (string) $request->input('contact_phone'), 'contact', 'text');
                    SiteSetting::set('whatsapp_number', (string) $request->input('whatsapp_number'), 'contact', 'text');
                    SiteSetting::set('contact_email', (string) $request->input('contact_email'), 'contact', 'text');
                    SiteSetting::set('office_address', (string) $request->input('office_address'), 'contact', 'textarea');
                    SiteSetting::set('office_hours', (string) $request->input('office_hours'), 'contact', 'text');
                    break;

                case 'social':
                    $request->validate([
                        'facebook_url' => ['nullable', 'string', 'max:255'],
                        'instagram_url' => ['nullable', 'string', 'max:255'],
                        'whatsapp_url' => ['nullable', 'string', 'max:255'],
                        'youtube_url' => ['nullable', 'string', 'max:255'],
                    ]);

                    SiteSetting::set('facebook_url', (string) $request->input('facebook_url', ''), 'social', 'text');
                    SiteSetting::set('instagram_url', (string) $request->input('instagram_url', ''), 'social', 'text');
                    SiteSetting::set('whatsapp_url', (string) $request->input('whatsapp_url', ''), 'social', 'text');
                    SiteSetting::set('youtube_url', (string) $request->input('youtube_url', ''), 'social', 'text');
                    break;

                case 'announcement':
                    $request->validate([
                        'announcement_enabled' => ['nullable'],
                        'announcement_text' => ['required', 'string', 'max:500'],
                        'announcement_link' => ['nullable', 'string', 'max:255'],
                    ]);

                    $enabled = $request->has('announcement_enabled') ? '1' : '0';
                    SiteSetting::set('announcement_enabled', $enabled, 'announcement', 'boolean');
                    SiteSetting::set('announcement_text', (string) $request->input('announcement_text'), 'announcement', 'textarea');
                    SiteSetting::set('announcement_link', (string) $request->input('announcement_link', '/contact'), 'announcement', 'text');
                    break;

                case 'seo':
                    $request->validate([
                        'meta_title_suffix' => ['required', 'string', 'max:255'],
                        'meta_description' => ['required', 'string', 'max:1000'],
                        'meta_og_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
                        'meta_og_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
                    ]);

                    SiteSetting::set('meta_title_suffix', (string) $request->input('meta_title_suffix'), 'seo', 'text');
                    SiteSetting::set('meta_description', (string) $request->input('meta_description'), 'seo', 'textarea');

                    $ogPath = $this->handleFileUpload($request, 'meta_og_image_file', SiteSetting::get('meta_og_image'));
                    if ($ogPath) {
                        SiteSetting::set('meta_og_image', $ogPath, 'seo', 'image');
                    }
                    break;

                case 'hero':
                    $request->validate([
                        'hero_badge' => ['nullable', 'string', 'max:100'],
                        'hero_title' => ['required', 'string', 'max:500'],
                        'hero_subtitle' => ['required', 'string', 'max:1000'],
                        'hero_cta_primary_text' => ['nullable', 'string', 'max:100'],
                        'hero_cta_secondary_text' => ['nullable', 'string', 'max:100'],
                        'hero_features' => ['nullable', 'array'],
                        'hero_features.*.icon' => ['nullable', 'string', 'max:100'],
                        'hero_features.*.title' => ['nullable', 'string', 'max:150'],
                        'hero_features.*.desc' => ['nullable', 'string', 'max:255'],
                    ]);

                    SiteSetting::set('hero_badge', (string) $request->input('hero_badge', ''), 'hero', 'text');
                    SiteSetting::set('hero_title', (string) $request->input('hero_title'), 'hero', 'text');
                    SiteSetting::set('hero_subtitle', (string) $request->input('hero_subtitle'), 'hero', 'textarea');
                    SiteSetting::set('hero_cta_primary_text', (string) $request->input('hero_cta_primary_text', ''), 'hero', 'text');
                    SiteSetting::set('hero_cta_secondary_text', (string) $request->input('hero_cta_secondary_text', ''), 'hero', 'text');

                    if ($request->has('hero_features')) {
                        $clean = array_values(array_filter($request->input('hero_features', []), fn ($item) => ! empty($item['title'] ?? '')));
                        SiteSetting::set('hero_features', json_encode($clean, JSON_UNESCAPED_UNICODE), 'hero', 'json');
                    }
                    break;

                case 'specialties':
                    $request->validate([
                        'specialties_tag' => ['nullable', 'string', 'max:100'],
                        'specialties_title' => ['required', 'string', 'max:255'],
                        'specialties_desc' => ['nullable', 'string', 'max:1000'],
                        'specialties_items' => ['nullable', 'array'],
                        'specialties_items.*.icon' => ['nullable', 'string', 'max:100'],
                        'specialties_items.*.title' => ['nullable', 'string', 'max:150'],
                        'specialties_items.*.desc' => ['nullable', 'string', 'max:500'],
                    ]);

                    SiteSetting::set('specialties_tag', (string) $request->input('specialties_tag', ''), 'specialties', 'text');
                    SiteSetting::set('specialties_title', (string) $request->input('specialties_title'), 'specialties', 'text');
                    SiteSetting::set('specialties_desc', (string) $request->input('specialties_desc', ''), 'specialties', 'textarea');

                    if ($request->has('specialties_items')) {
                        $clean = array_values(array_filter($request->input('specialties_items', []), fn ($item) => ! empty($item['title'] ?? '')));
                        SiteSetting::set('specialties_items', json_encode($clean, JSON_UNESCAPED_UNICODE), 'specialties', 'json');
                    }
                    break;

                case 'process':
                    $request->validate([
                        'process_tag' => ['nullable', 'string', 'max:100'],
                        'process_title' => ['required', 'string', 'max:255'],
                        'process_desc' => ['nullable', 'string', 'max:1000'],
                        'process_cta_text' => ['nullable', 'string', 'max:150'],
                        'process_steps' => ['nullable', 'array'],
                        'process_steps.*.number' => ['nullable', 'string', 'max:20'],
                        'process_steps.*.title' => ['nullable', 'string', 'max:150'],
                        'process_steps.*.desc' => ['nullable', 'string', 'max:500'],
                    ]);

                    SiteSetting::set('process_tag', (string) $request->input('process_tag', ''), 'process', 'text');
                    SiteSetting::set('process_title', (string) $request->input('process_title'), 'process', 'text');
                    SiteSetting::set('process_desc', (string) $request->input('process_desc', ''), 'process', 'textarea');
                    SiteSetting::set('process_cta_text', (string) $request->input('process_cta_text', ''), 'process', 'text');

                    if ($request->has('process_steps')) {
                        $clean = array_values(array_filter($request->input('process_steps', []), fn ($item) => ! empty($item['title'] ?? '')));
                        SiteSetting::set('process_steps', json_encode($clean, JSON_UNESCAPED_UNICODE), 'process', 'json');
                    }
                    break;

                case 'about':
                    $request->validate([
                        'about_hero_badge' => ['nullable', 'string', 'max:100'],
                        'about_hero_title' => ['required', 'string', 'max:255'],
                        'about_hero_subtitle' => ['nullable', 'string', 'max:1000'],
                        'about_heritage_tag' => ['nullable', 'string', 'max:100'],
                        'about_heritage_title' => ['required', 'string', 'max:255'],
                        'about_heritage_p1' => ['nullable', 'string', 'max:2000'],
                        'about_heritage_p2' => ['nullable', 'string', 'max:2000'],
                        'about_wedding_quote' => ['nullable', 'string', 'max:500'],
                        'about_wedding_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
                        'about_wedding_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
                        'about_concierge_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
                        'about_concierge_image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
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
                    ]);

                    SiteSetting::set('about_hero_badge', (string) $request->input('about_hero_badge', ''), 'about', 'text');
                    SiteSetting::set('about_hero_title', (string) $request->input('about_hero_title'), 'about', 'text');
                    SiteSetting::set('about_hero_subtitle', (string) $request->input('about_hero_subtitle', ''), 'about', 'textarea');
                    SiteSetting::set('about_heritage_tag', (string) $request->input('about_heritage_tag', ''), 'about', 'text');
                    SiteSetting::set('about_heritage_title', (string) $request->input('about_heritage_title'), 'about', 'text');
                    SiteSetting::set('about_heritage_p1', (string) $request->input('about_heritage_p1', ''), 'about', 'textarea');
                    SiteSetting::set('about_heritage_p2', (string) $request->input('about_heritage_p2', ''), 'about', 'textarea');
                    SiteSetting::set('about_wedding_quote', (string) $request->input('about_wedding_quote', ''), 'about', 'text');
                    SiteSetting::set('about_pillars_tag', (string) $request->input('about_pillars_tag', ''), 'about', 'text');
                    SiteSetting::set('about_pillars_title', (string) $request->input('about_pillars_title', ''), 'about', 'text');
                    SiteSetting::set('about_pillars_desc', (string) $request->input('about_pillars_desc', ''), 'about', 'textarea');
                    SiteSetting::set('about_concierge_tag', (string) $request->input('about_concierge_tag', ''), 'about', 'text');
                    SiteSetting::set('about_concierge_title', (string) $request->input('about_concierge_title', ''), 'about', 'text');
                    SiteSetting::set('about_concierge_desc', (string) $request->input('about_concierge_desc', ''), 'about', 'textarea');

                    $weddingImgPath = $this->handleFileUpload($request, 'about_wedding_image_file', SiteSetting::get('about_wedding_image'));
                    if ($weddingImgPath) {
                        SiteSetting::set('about_wedding_image', $weddingImgPath, 'about', 'image');
                    }

                    $conciergeImgPath = $this->handleFileUpload($request, 'about_concierge_image_file', SiteSetting::get('about_concierge_image'));
                    if ($conciergeImgPath) {
                        SiteSetting::set('about_concierge_image', $conciergeImgPath, 'about', 'image');
                    }

                    if ($request->has('about_pillars')) {
                        $clean = array_values(array_filter($request->input('about_pillars', []), fn ($item) => ! empty($item['title'] ?? '')));
                        SiteSetting::set('about_pillars', json_encode($clean, JSON_UNESCAPED_UNICODE), 'about', 'json');
                    }

                    if ($request->has('about_concierge_points')) {
                        $clean = array_values(array_filter($request->input('about_concierge_points', []), fn ($item) => ! empty($item['title'] ?? '')));
                        SiteSetting::set('about_concierge_points', json_encode($clean, JSON_UNESCAPED_UNICODE), 'about', 'json');
                    }
                    break;

                case 'cta':
                    $request->validate([
                        'final_cta_badge' => ['nullable', 'string', 'max:100'],
                        'final_cta_title' => ['required', 'string', 'max:255'],
                        'final_cta_subtitle' => ['nullable', 'string', 'max:1000'],
                        'final_cta_button_text' => ['nullable', 'string', 'max:100'],
                    ]);

                    SiteSetting::set('final_cta_badge', (string) $request->input('final_cta_badge', ''), 'final_cta', 'text');
                    SiteSetting::set('final_cta_title', (string) $request->input('final_cta_title'), 'final_cta', 'text');
                    SiteSetting::set('final_cta_subtitle', (string) $request->input('final_cta_subtitle', ''), 'final_cta', 'textarea');
                    SiteSetting::set('final_cta_button_text', (string) $request->input('final_cta_button_text', ''), 'final_cta', 'text');
                    break;

                case 'footer':
                    $request->validate([
                        'footer_copyright_text' => ['nullable', 'string', 'max:255'],
                        'footer_trust_title' => ['nullable', 'string', 'max:100'],
                        'footer_trust_subtitle' => ['nullable', 'string', 'max:150'],
                        'footer_presence_note' => ['nullable', 'string', 'max:200'],
                    ]);

                    SiteSetting::set('footer_copyright_text', (string) $request->input('footer_copyright_text', ''), 'footer', 'text');
                    SiteSetting::set('footer_trust_title', (string) $request->input('footer_trust_title', ''), 'footer', 'text');
                    SiteSetting::set('footer_trust_subtitle', (string) $request->input('footer_trust_subtitle', ''), 'footer', 'text');
                    SiteSetting::set('footer_presence_note', (string) $request->input('footer_presence_note', ''), 'footer', 'text');
                    break;
            }

            SiteSetting::clearCache();

            return redirect()->route('admin.sections.edit', $section)
                ->with('success', "{$sectionDef['title']} content updated successfully.");
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error("Failed to update section {$section}: ".$e->getMessage(), [
                'exception' => $e,
            ]);

            return back()->withInput()->withErrors([
                'error' => "Unable to save section: {$e->getMessage()}",
            ]);
        }
    }

    /**
     * Backward-compatible handler for legacy multi-tab POST requests.
     */
    public function update(Request $request): RedirectResponse
    {
        $activeTab = $request->input('active_tab', 'hero');

        // If an active_tab matches one of our section slugs, route it to updateSection
        if (array_key_exists($activeTab, self::getSectionsDefinition())) {
            return $this->updateSection($request, $activeTab);
        }

        $request->validate([
            'hero_title' => ['sometimes', 'required', 'string', 'max:500'],
            'specialties_title' => ['sometimes', 'required', 'string', 'max:255'],
            'process_title' => ['sometimes', 'required', 'string', 'max:255'],
            'about_hero_title' => ['sometimes', 'required', 'string', 'max:255'],
            'final_cta_title' => ['sometimes', 'required', 'string', 'max:255'],
        ]);

        SiteSetting::clearCache();

        return redirect()->route('admin.sections.index')
            ->with('success', 'Page content sections updated successfully.');
    }

    /**
     * Handle local file upload with optional cleanup of previous media.
     */
    protected function handleFileUpload(Request $request, string $inputName, ?string $currentValue = null): ?string
    {
        $file = null;
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
        } elseif (str_ends_with($inputName, '_file')) {
            $baseName = substr($inputName, 0, -5);
            if ($request->hasFile($baseName)) {
                $file = $request->file($baseName);
            }
        } elseif ($request->hasFile($inputName.'_file')) {
            $file = $request->file($inputName.'_file');
        }

        if ($file) {
            if ($currentValue && ! str_starts_with($currentValue, 'http') && file_exists(public_path('storage/'.$currentValue))) {
                try {
                    Storage::disk('public')->delete($currentValue);
                } catch (\Throwable $e) {
                    Log::warning('Failed deleting old image: '.$e->getMessage());
                }
            }

            try {
                $stored = $file->store('settings', 'public');
                if ($stored) {
                    return $stored;
                }
            } catch (\Throwable $e) {
                Log::error('Settings image upload failed: '.$e->getMessage(), [
                    'exception' => $e,
                ]);
            }
        }

        return null;
    }
}
