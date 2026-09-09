<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\ContentSectionController;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminContentSectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_content_sections(): void
    {
        $response = $this->get(route('admin.sections.index'));

        $response->assertRedirect('/admin/login');
    }

    public function test_non_admin_cannot_access_content_sections(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.sections.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_view_content_sections_card_hub(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.sections.index'));

        $response->assertStatus(200);
        $response->assertSee('Website Sections &amp; Page CMS Studio', false);
        $response->assertSee('Total CMS Modules');

        // All 11 section titles and nav labels
        $sections = ContentSectionController::getSectionsDefinition();
        $this->assertCount(11, $sections);

        foreach ($sections as $key => $sec) {
            $response->assertSee($sec['title']);
            $response->assertSee($sec['nav_label']);
            $response->assertSee(route('admin.sections.edit', $key), false);
        }
    }

    public function test_admin_can_view_each_of_the_11_section_edit_pages(): void
    {
        $admin = User::factory()->admin()->create();

        $sections = ContentSectionController::getSectionsDefinition();

        foreach (array_keys($sections) as $sectionKey) {
            $response = $this->actingAs($admin)->get(route('admin.sections.edit', $sectionKey));
            $response->assertStatus(200);
            $response->assertSee('All Sections', false);
            $response->assertSee($sections[$sectionKey]['title']);
            $response->assertSee('Switch Section', false);
        }
    }

    public function test_invalid_section_slug_returns_404(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin/sections/nonexistent-slug');

        $response->assertStatus(404);
    }

    public function test_admin_can_update_general_brand_section_with_images(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $logo = UploadedFile::fake()->image('test-brand-logo.png', 300, 100);
        $favicon = UploadedFile::fake()->image('test-favicon.png', 64, 64);

        $payload = [
            'site_name' => 'Biye Marriage Media VIP Platinum',
            'site_tagline' => 'আভিজাত্য ও বিশ্বাসের বিশ্বস্ত মিলনমেলা',
            'about_summary' => 'Bangladesh premier bespoke matrimony registry for elite families.',
            'site_logo' => $logo,
            'site_favicon' => $favicon,
        ];

        $response = $this->actingAs($admin)->post(route('admin.sections.update-section', 'general'), $payload);

        $response->assertRedirect(route('admin.sections.edit', 'general'));
        $response->assertSessionHas('success', 'General & Brand Identity content updated successfully.');

        $this->assertEquals('Biye Marriage Media VIP Platinum', SiteSetting::get('site_name'));
        $this->assertEquals('আভিজাত্য ও বিশ্বাসের বিশ্বস্ত মিলনমেলা', SiteSetting::get('site_tagline'));

        $logoPath = SiteSetting::get('site_logo');
        $this->assertNotNull($logoPath);
        Storage::disk('public')->assertExists($logoPath);

        $faviconPath = SiteSetting::get('site_favicon');
        $this->assertNotNull($faviconPath);
        Storage::disk('public')->assertExists($faviconPath);

        // Verify public reflection on navbar and footer
        SiteSetting::clearCache();
        $publicResponse = $this->get(route('home'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Biye Marriage Media VIP Platinum');
        $publicResponse->assertSee('আভিজাত্য ও বিশ্বাসের বিশ্বস্ত মিলনমেলা');
    }

    public function test_admin_can_update_hero_section_and_reflects_on_homepage(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = [
            'hero_title' => 'Find Your Soulmate with <span class="text-gold">Complete Privacy</span>',
            'hero_subtitle' => 'Exclusive matchmaking service for Bangladesh and Global NRBs.',
            'hero_cta_primary_text' => 'Join Private Registry',
            'hero_cta_secondary_text' => 'Direct Consultation',
            'hero_features' => [
                [
                    'icon' => 'bi-shield-check',
                    'title' => '100% Guaranteed Confidential',
                    'desc' => 'High profile discretion guaranteed',
                ],
                [
                    'icon' => 'bi-award-fill',
                    'title' => 'Strictly Vetted Profiles',
                    'desc' => 'All educational and family credentials confirmed',
                ],
            ],
        ];

        $response = $this->actingAs($admin)->post(route('admin.sections.update-section', 'hero'), $payload);

        $response->assertRedirect(route('admin.sections.edit', 'hero'));
        $response->assertSessionHas('success', 'Homepage Hero Section content updated successfully.');

        $this->assertEquals($payload['hero_title'], SiteSetting::get('hero_title'));
        $this->assertEquals($payload['hero_subtitle'], SiteSetting::get('hero_subtitle'));
        $this->assertEquals($payload['hero_cta_primary_text'], SiteSetting::get('hero_cta_primary_text'));
        $this->assertEquals($payload['hero_cta_secondary_text'], SiteSetting::get('hero_cta_secondary_text'));

        // Verify public view reflection
        SiteSetting::clearCache();
        $publicResponse = $this->get(route('home'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Find Your Soulmate with', false);
        $publicResponse->assertSee('Exclusive matchmaking service for Bangladesh and Global NRBs.');
        $publicResponse->assertSee('Join Private Registry');
        $publicResponse->assertSee('100% Guaranteed Confidential');
    }

    public function test_admin_can_update_specialties_and_process_sections(): void
    {
        $admin = User::factory()->admin()->create();

        // 1. Update Specialties
        $specialtiesPayload = [
            'specialties_tag' => 'Exclusive Services',
            'specialties_title' => 'Bespoke Matrimony For Educated Families',
            'specialties_desc' => 'Tailored specifically for BCS cadres, doctors, engineers, and NRB professionals.',
            'specialties_items' => [
                [
                    'icon' => 'bi-gem',
                    'title' => 'Doctor & Engineer Matching',
                    'desc' => 'Verified medical and engineering professionals worldwide.',
                ],
            ],
        ];

        $respSpecialties = $this->actingAs($admin)->post(route('admin.sections.update-section', 'specialties'), $specialtiesPayload);
        $respSpecialties->assertRedirect(route('admin.sections.edit', 'specialties'));
        $respSpecialties->assertSessionHas('success', 'Our Specialties & Services content updated successfully.');
        $this->assertEquals('Exclusive Services', SiteSetting::get('specialties_tag'));

        // 2. Update Process
        $processPayload = [
            'process_tag' => '3 Easy Steps',
            'process_title' => 'How We Connect Respectable Families',
            'process_desc' => 'Smooth and honorable matchmaking at every stage.',
            'process_cta_text' => 'Book Your Meeting Now',
            'process_steps' => [
                [
                    'step' => '01',
                    'title' => 'Family Intake & Background Check',
                    'desc' => 'We meet with parents or legal guardians directly.',
                ],
                [
                    'step' => '02',
                    'title' => 'Curated Biographies Sharing',
                    'desc' => 'Only profiles matching your standards are shared.',
                ],
            ],
        ];

        $respProcess = $this->actingAs($admin)->post(route('admin.sections.update-section', 'process'), $processPayload);
        $respProcess->assertRedirect(route('admin.sections.edit', 'process'));
        $respProcess->assertSessionHas('success', 'Seamless Process Timeline content updated successfully.');
        $this->assertEquals('3 Easy Steps', SiteSetting::get('process_tag'));
        $this->assertEquals('Book Your Meeting Now', SiteSetting::get('process_cta_text'));

        // Check Homepage reflection
        SiteSetting::clearCache();
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Exclusive Services');
        $homeResponse->assertSee('Bespoke Matrimony For Educated Families');
        $homeResponse->assertSee('Doctor &amp; Engineer Matching', false);
        $homeResponse->assertSee('3 Easy Steps');
        $homeResponse->assertSee('Book Your Meeting Now');
        $homeResponse->assertSee('Family Intake &amp; Background Check', false);
    }

    public function test_admin_can_update_about_section_with_photos_and_reflects_on_about_page(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $weddingPhoto = UploadedFile::fake()->image('wedding.jpg', 800, 600);
        $conciergePhoto = UploadedFile::fake()->image('concierge.jpg', 800, 600);

        $aboutPayload = [
            'about_hero_badge' => 'ঐতিহ্য ও সততা',
            'about_hero_title' => 'The Story Behind Biye Marriage Media',
            'about_hero_subtitle' => 'Two decades of uniting families in dignity and faith.',
            'about_heritage_tag' => 'Our 20 Year Legacy',
            'about_heritage_title' => 'Rooted in Bangladeshi Tradition and Islamic Values',
            'about_heritage_p1' => 'Our organization was founded to restore respectability to modern matchmaking.',
            'about_heritage_p2' => 'Every guardian receives bespoke concierge attention.',
            'about_wedding_quote' => '"A holy bond founded on mutual respect and shared dreams."',
            'about_pillars_tag' => 'Core Guarantees',
            'about_pillars_title' => 'Three Pillars of Our Distinction',
            'about_pillars_desc' => 'Why families choose us for confidential partner searches.',
            'about_concierge_tag' => 'Dedicated Concierge',
            'about_concierge_title' => 'Direct Family Relationship Directors',
            'about_concierge_desc' => 'Personalized matchmaker assigned to your family.',
            'about_wedding_image' => $weddingPhoto,
            'about_concierge_image' => $conciergePhoto,
            'about_pillars' => [
                [
                    'icon' => 'bi-shield-shaded',
                    'title' => 'Absolute Purdah & Privacy',
                    'desc' => 'Photos are never displayed without family consent.',
                ],
            ],
            'about_concierge_points' => [
                [
                    'title' => 'Executive Home Visits',
                    'desc' => 'Our directors visit your Dhaka or Sylhet home.',
                ],
            ],
        ];

        $response = $this->actingAs($admin)->post(route('admin.sections.update-section', 'about'), $aboutPayload);

        $response->assertRedirect(route('admin.sections.edit', 'about'));
        $response->assertSessionHas('success', 'About Us Page & Core Pillars content updated successfully.');

        $this->assertEquals('The Story Behind Biye Marriage Media', SiteSetting::get('about_hero_title'));
        $this->assertEquals('ঐতিহ্য ও সততা', SiteSetting::get('about_hero_badge'));

        $savedWeddingPath = SiteSetting::get('about_wedding_image');
        $this->assertNotNull($savedWeddingPath);
        Storage::disk('public')->assertExists($savedWeddingPath);

        // Verify About page reflection
        SiteSetting::clearCache();
        $aboutResponse = $this->get(route('about'));
        $aboutResponse->assertStatus(200);
        $aboutResponse->assertSee('The Story Behind Biye Marriage Media');
        $aboutResponse->assertSee('ঐতিহ্য ও সততা');
        $aboutResponse->assertSee('Rooted in Bangladeshi Tradition and Islamic Values');
        $aboutResponse->assertSee('Absolute Purdah &amp; Privacy', false);
        $aboutResponse->assertSee('Executive Home Visits');
        $aboutResponse->assertSee($savedWeddingPath);
    }

    public function test_admin_can_update_final_cta_and_footer_sections(): void
    {
        $admin = User::factory()->admin()->create();

        // 1. Update Final CTA
        $ctaPayload = [
            'final_cta_badge' => 'Private Matrimonial Concierge',
            'final_cta_title' => 'Begin Your Family Journey With Complete Confidence',
            'final_cta_subtitle' => 'Our senior consultants are available 7 days a week for discrete consultations.',
            'final_cta_button_text' => 'Request Executive Consultation',
        ];

        $respCta = $this->actingAs($admin)->post(route('admin.sections.update-section', 'cta'), $ctaPayload);
        $respCta->assertRedirect(route('admin.sections.edit', 'cta'));
        $respCta->assertSessionHas('success', 'Final VIP Call-to-Action content updated successfully.');
        $this->assertEquals('Private Matrimonial Concierge', SiteSetting::get('final_cta_badge'));

        // 2. Update Footer
        $footerPayload = [
            'footer_presence_note' => 'Offices in Dhaka, Chittagong, Sylhet, and London Desk',
            'footer_trust_title' => '100% Shariah Compliant & Verified',
            'footer_trust_subtitle' => 'Trusted by 50,000+ Bangladeshi Families',
            'footer_copyright_text' => '© 2026 Biye Marriage Media VIP Matrimony. All Rights Reserved.',
        ];

        $respFooter = $this->actingAs($admin)->post(route('admin.sections.update-section', 'footer'), $footerPayload);
        $respFooter->assertRedirect(route('admin.sections.edit', 'footer'));
        $respFooter->assertSessionHas('success', 'Footer Notes & Trust Badges content updated successfully.');
        $this->assertEquals('© 2026 Biye Marriage Media VIP Matrimony. All Rights Reserved.', SiteSetting::get('footer_copyright_text'));

        // Verify public view reflection
        SiteSetting::clearCache();
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Private Matrimonial Concierge');
        $homeResponse->assertSee('Begin Your Family Journey With Complete Confidence');
        $homeResponse->assertSee('Request Executive Consultation');
        $homeResponse->assertSee('Offices in Dhaka, Chittagong, Sylhet, and London Desk');
        $homeResponse->assertSee('100% Shariah Compliant & Verified', false);
        $homeResponse->assertSee('© 2026 Biye Marriage Media VIP Matrimony. All Rights Reserved.');
    }

    public function test_admin_can_update_announcement_contact_social_and_seo_sections(): void
    {
        $admin = User::factory()->admin()->create();

        // 1. Announcement Bar
        $announcementPayload = [
            'announcement_enabled' => '1',
            'announcement_text' => 'Special Ramadan 2026 Family Matchmaking Consultations Now Open',
            'announcement_link' => 'https://wa.me/8801577723404',
        ];
        $respAnnounce = $this->actingAs($admin)->post(route('admin.sections.update-section', 'announcement'), $announcementPayload);
        $respAnnounce->assertRedirect(route('admin.sections.edit', 'announcement'));
        $this->assertEquals('1', SiteSetting::get('announcement_enabled'));
        $this->assertEquals($announcementPayload['announcement_text'], SiteSetting::get('announcement_text'));

        // 2. Helpline & Contact
        $contactPayload = [
            'contact_phone' => '+880 1700-112233',
            'whatsapp_number' => '8801700112233',
            'contact_email' => 'concierge@biyemarriagemedia.com',
            'office_address' => 'Suite 402, Level 4, Gulshan-2, Dhaka 1212',
            'office_hours' => 'Saturday - Thursday: 10:00 AM - 8:00 PM',
        ];
        $respContact = $this->actingAs($admin)->post(route('admin.sections.update-section', 'contact'), $contactPayload);
        $respContact->assertRedirect(route('admin.sections.edit', 'contact'));
        $this->assertEquals('+880 1700-112233', SiteSetting::get('contact_phone'));

        // 3. Social Media
        $socialPayload = [
            'facebook_url' => 'https://facebook.com/biyemarriagemedia.official',
            'instagram_url' => 'https://instagram.com/biyemarriagemedia.official',
            'whatsapp_url' => 'https://wa.me/8801700112233',
            'youtube_url' => 'https://youtube.com/@biyemarriagemedia',
        ];
        $respSocial = $this->actingAs($admin)->post(route('admin.sections.update-section', 'social'), $socialPayload);
        $respSocial->assertRedirect(route('admin.sections.edit', 'social'));
        $this->assertEquals('https://facebook.com/biyemarriagemedia.official', SiteSetting::get('facebook_url'));

        // 4. SEO & Meta
        $seoPayload = [
            'meta_title_suffix' => 'Biye Marriage Media | Most Trusted Matchmaking Agency in Bangladesh',
            'meta_description' => 'Elite matrimonial portal ensuring verified family lineages and safe matchmaking.',
        ];
        $respSeo = $this->actingAs($admin)->post(route('admin.sections.update-section', 'seo'), $seoPayload);
        $respSeo->assertRedirect(route('admin.sections.edit', 'seo'));
        $this->assertEquals('Biye Marriage Media | Most Trusted Matchmaking Agency in Bangladesh', SiteSetting::get('meta_title_suffix'));

        // Verify public reflection on home
        SiteSetting::clearCache();
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Special Ramadan 2026 Family Matchmaking Consultations Now Open');
        $homeResponse->assertSee('+880 1700-112233');
        $homeResponse->assertSee('https://facebook.com/biyemarriagemedia.official');
        $homeResponse->assertSee('Biye Marriage Media | Most Trusted Matchmaking Agency in Bangladesh');
    }

    public function test_legacy_post_route_backward_compatibility(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = [
            'active_tab' => 'hero',
            'hero_title' => 'Legacy Route Title Check',
            'hero_subtitle' => 'Testing legacy route support',
        ];

        $response = $this->actingAs($admin)->post(route('admin.sections.update'), $payload);

        $response->assertRedirect(route('admin.sections.edit', 'hero'));
        $response->assertSessionHas('success', 'Homepage Hero Section content updated successfully.');
        $this->assertEquals('Legacy Route Title Check', SiteSetting::get('hero_title'));
    }

    public function test_validation_errors_when_required_fields_missing(): void
    {
        $admin = User::factory()->admin()->create();

        // Hero title cannot be empty
        $response = $this->actingAs($admin)->post(route('admin.sections.update-section', 'hero'), [
            'hero_title' => '',
        ]);

        $response->assertSessionHasErrors(['hero_title']);
    }

    public function test_admin_can_update_theme_colors_and_reflects_dynamically(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = [
            'site_name' => 'Biye Marriage Media',
            'site_tagline' => 'বিশ্বাসের বন্ধনে, সুন্দর আগামী',
            'about_summary' => 'Executive matchmaking service.',
            'theme_primary' => '#124e3f',
            'theme_secondary' => '#d4af37',
            'theme_accent' => '#0a1c17',
        ];

        $response = $this->actingAs($admin)->post(route('admin.sections.update-section', 'general'), $payload);

        $response->assertRedirect(route('admin.sections.edit', 'general'));
        $response->assertSessionHas('success', 'General & Brand Identity content updated successfully.');

        $this->assertEquals('#124e3f', SiteSetting::get('theme_primary'));
        $this->assertEquals('#d4af37', SiteSetting::get('theme_secondary'));
        $this->assertEquals('#0a1c17', SiteSetting::get('theme_accent'));

        // Test RGB calculations
        $this->assertEquals('18, 78, 63', SiteSetting::getHexRgb('theme_primary', '#851829'));

        // Verify public reflection of dynamic CSS variables
        SiteSetting::clearCache();
        $publicResponse = $this->get(route('home'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('--theme-primary: #124e3f;', false);
        $publicResponse->assertSee('--theme-secondary: #d4af37;', false);
        $publicResponse->assertSee('--theme-accent: #0a1c17;', false);
        $publicResponse->assertSee('--theme-primary-rgb: 18, 78, 63;', false);
    }

    public function test_invalid_theme_color_fails_validation(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.sections.update-section', 'general'), [
            'site_name' => 'Biye Marriage Media',
            'site_tagline' => 'বিশ্বাসের বন্ধনে, সুন্দর আগামী',
            'about_summary' => 'Executive matchmaking service.',
            'theme_primary' => 'invalid-color-code',
        ]);

        $response->assertSessionHasErrors(['theme_primary']);
    }
}
