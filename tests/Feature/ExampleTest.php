<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_home_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Biye Marriage Media');
        $response->assertSee('Bangladesh');
        $response->assertSee('Find Your Perfect Life Partner with Trust &amp; Confidentiality', false);
        $response->assertSee('বিশ্বাসের বন্ধনে, সুন্দর আগামী');
        $response->assertSee('Islamic values and family compatibility');
        $response->assertSee('Elite Professional');
        $response->assertSee('Elite Business');
        $response->assertSee('Elite Aristocrat');
        $response->assertSee('site-logo/marriage-logo.jpeg');
    }

    public function test_about_page_renders_successfully(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('About Biye Marriage Media');
        $response->assertSee('Built on Trust, Islamic Values');
        $response->assertSee('বিশ্বাসের বন্ধনে, সুন্দর আগামী');
    }

    public function test_packages_page_renders_successfully(): void
    {
        $response = $this->get('/packages');
        $response->assertStatus(200);
        $response->assertSee('Elite Membership Packages');
        $response->assertSee('Package Comparison Matrix (Bangladesh)');
    }

    public function test_profiles_page_renders_successfully(): void
    {
        $response = $this->get('/profiles');
        $response->assertStatus(200);
        $response->assertSee('Explore Elite Profiles in Bangladesh');
        $response->assertSee('Desher Bari');
    }

    public function test_stories_page_renders_successfully(): void
    {
        $response = $this->get('/stories');
        $response->assertStatus(200);
        $response->assertSee('Biye Marriage Media Success Stories');
    }

    public function test_contact_page_renders_successfully(): void
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);
        $response->assertSee('Contact Biye Marriage Media');
        $response->assertSee('+880 1577-723404');
        $response->assertDontSee('+880 1577-711210');
        $response->assertDontSee('+880 1577-733404');
        $response->assertSee('biyemarriagemedia@gmail.com');
        $response->assertSee('Kuril Chowrasta');
        $response->assertSee('www.biyemarriagemedia.com');
    }

    public function test_consultation_form_submits_successfully(): void
    {
        $response = $this->post('/consultation', [
            'looking_for' => 'Bride',
            'profile_for' => 'Daughter',
            'full_name' => 'Barrister Rafiqul Islam',
            'phone' => '01711223344',
            'email' => 'rafiq@example.com',
            'city' => 'Gulshan-2, Dhaka',
            'desher_bari' => 'Sylhet',
            'annual_income' => '৳75 Lakh - ৳2 Crore',
            'preferred_package' => 'Elite Business'
        ]);

        $response->assertSessionHas('success_modal', true);
        $response->assertSessionHas('consultation_name', 'Barrister Rafiqul Islam');
    }

    public function test_nav_items_are_updated(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Home');
        $response->assertSee('About');
        $response->assertSee('Profile');
        $response->assertSee('Stories');
        $response->assertSee('Contact');
        $response->assertSee('Login');
    }

    public function test_login_route_redirects(): void
    {
        $response = $this->get('/login');
        $response->assertRedirect('/?login=1');
    }

    public function test_home_page_renders_success_stories_and_modal(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Elite Bangladesh Success Stories');
        $response->assertSee('data-story-index="0"', false);
        $response->assertSee('storyDetailModal');
        $response->assertSee('Inquire for Similar Matchmaking');
        $response->assertSee('Read More Celebrated Alliances');
        $response->assertSee('btn-stories-more');
        $response->assertSee('stories-data');
    }

    public function test_footer_and_final_cta_section_clean_up(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Quick Links with golden chevron arrows (no login link)
        $response->assertDontSee('<li><a href="#" data-bs-toggle="modal" data-bs-target="#memberLoginModal">Login</a></li>', false);
        $response->assertSee('<i class="bi bi-chevron-right text-gold me-2"></i>Home', false);
        $response->assertSee('<i class="bi bi-chevron-right text-gold me-2"></i>About', false);
        $response->assertSee('<i class="bi bi-chevron-right text-gold me-2"></i>Profile', false);
        $response->assertSee('<i class="bi bi-chevron-right text-gold me-2"></i>Stories', false);
        $response->assertSee('<i class="bi bi-chevron-right text-gold me-2"></i>Contact', false);

        // Circular social media icon buttons in left brand column
        $response->assertSee('footer-social-row');
        $response->assertSee('footer-social-icon');
        $response->assertSee('footer-social-fb');
        $response->assertSee('https://www.facebook.com/biyemarriagemedia');
        $response->assertSee('footer-social-insta');
        $response->assertSee('footer-social-wa');

        // Kuril Chowrasta head office and helpline
        $response->assertSee('Kuril Chowrasta Office:');
        $response->assertSee('www.biyemarriagemedia.com');
        $response->assertSee('+880 1577-723404');
        $response->assertDontSee('+880 1577-711210');
        $response->assertDontSee('+880 1577-733404');
        $response->assertSee('biyemarriagemedia@gmail.com');

        // Right-side trust badge
        $response->assertSee('100% Confidential');
        $response->assertSee('Islamic Values & Verified Matchmaking', false);

        // Final CTA buttons present with responsive wrapper
        $response->assertSee('vip-cta-actions d-flex flex-column flex-md-row', false);
        $response->assertSee('Request VIP Callback');
        $response->assertSee('Call +880 1577-723404');
        $response->assertSee('WhatsApp Concierge');
    }
}

