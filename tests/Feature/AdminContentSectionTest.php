<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_admin_can_view_content_sections_studio(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.sections.index'));

        $response->assertStatus(200);
        $response->assertSee('Page Content &amp; Sections CMS Studio', false);
        $response->assertSee('Hero Section', false);
        $response->assertSee('Specialties', false);
        $response->assertSee('Process', false);
        $response->assertSee('About &amp; Pillars', false);
        $response->assertSee('Final CTA', false);
        $response->assertSee('Footer Notes', false);
    }

    public function test_admin_can_update_hero_section_and_reflects_on_homepage(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = [
            'active_tab' => 'hero',
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

        $response = $this->actingAs($admin)->post(route('admin.sections.update'), $payload);

        $response->assertRedirect(route('admin.sections.index', ['tab' => 'hero']));
        $response->assertSessionHas('success', 'Hero Section content updated successfully.');

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
            'active_tab' => 'specialties',
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

        $respSpecialties = $this->actingAs($admin)->post(route('admin.sections.update'), $specialtiesPayload);
        $respSpecialties->assertRedirect(route('admin.sections.index', ['tab' => 'specialties']));
        $this->assertEquals('Exclusive Services', SiteSetting::get('specialties_tag'));

        // 2. Update Process
        $processPayload = [
            'active_tab' => 'process',
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

        $respProcess = $this->actingAs($admin)->post(route('admin.sections.update'), $processPayload);
        $respProcess->assertRedirect(route('admin.sections.index', ['tab' => 'process']));
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

    public function test_admin_can_update_about_section_and_reflects_on_about_page(): void
    {
        $admin = User::factory()->admin()->create();

        $aboutPayload = [
            'active_tab' => 'about',
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

        $response = $this->actingAs($admin)->post(route('admin.sections.update'), $aboutPayload);

        $response->assertRedirect(route('admin.sections.index', ['tab' => 'about']));
        $response->assertSessionHas('success', 'About Page content updated successfully.');

        $this->assertEquals('The Story Behind Biye Marriage Media', SiteSetting::get('about_hero_title'));
        $this->assertEquals('ঐতিহ্য ও সততা', SiteSetting::get('about_hero_badge'));

        // Verify About page reflection
        SiteSetting::clearCache();
        $aboutResponse = $this->get(route('about'));
        $aboutResponse->assertStatus(200);
        $aboutResponse->assertSee('The Story Behind Biye Marriage Media');
        $aboutResponse->assertSee('ঐতিহ্য ও সততা');
        $aboutResponse->assertSee('Rooted in Bangladeshi Tradition and Islamic Values');
        $aboutResponse->assertSee('Absolute Purdah &amp; Privacy', false);
        $aboutResponse->assertSee('Executive Home Visits');
    }

    public function test_admin_can_update_final_cta_and_footer_sections(): void
    {
        $admin = User::factory()->admin()->create();

        // 1. Update Final CTA
        $ctaPayload = [
            'active_tab' => 'cta',
            'final_cta_badge' => 'Private Matrimonial Concierge',
            'final_cta_title' => 'Begin Your Family Journey With Complete Confidence',
            'final_cta_subtitle' => 'Our senior consultants are available 7 days a week for discrete consultations.',
            'final_cta_button_text' => 'Request Executive Consultation',
        ];

        $respCta = $this->actingAs($admin)->post(route('admin.sections.update'), $ctaPayload);
        $respCta->assertRedirect(route('admin.sections.index', ['tab' => 'cta']));
        $this->assertEquals('Private Matrimonial Concierge', SiteSetting::get('final_cta_badge'));

        // 2. Update Footer
        $footerPayload = [
            'active_tab' => 'footer',
            'footer_presence_note' => 'Offices in Dhaka, Chittagong, Sylhet, and London Desk',
            'footer_trust_title' => '100% Shariah Compliant & Verified',
            'footer_trust_subtitle' => 'Trusted by 50,000+ Bangladeshi Families',
            'footer_copyright_text' => '© 2026 Biye Marriage Media VIP Matrimony. All Rights Reserved.',
        ];

        $respFooter = $this->actingAs($admin)->post(route('admin.sections.update'), $footerPayload);
        $respFooter->assertRedirect(route('admin.sections.index', ['tab' => 'footer']));
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

    public function test_validation_errors_when_required_fields_missing(): void
    {
        $admin = User::factory()->admin()->create();

        // Hero title cannot be empty
        $response = $this->actingAs($admin)->post(route('admin.sections.update'), [
            'active_tab' => 'hero',
            'hero_title' => '',
        ]);

        $response->assertSessionHasErrors(['hero_title']);
    }
}
