<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSiteSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_site_settings(): void
    {
        $response = $this->get(route('admin.settings.index'));

        $response->assertRedirect('/admin/login');
    }

    public function test_non_admin_cannot_access_site_settings(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.settings.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_view_site_settings_page(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.settings.index'));

        $response->assertStatus(200);
        $response->assertSee('Site Settings &amp; Brand Configuration', false);
        $response->assertSee('General &amp; Brand', false);
        $response->assertSee('Helpline &amp; Contact', false);
        $response->assertSee('Announcement Bar', false);
        $response->assertSee('+880 1577-723404');
        $response->assertSee('biyemarriagemedia@gmail.com');
    }

    public function test_admin_can_update_site_settings(): void
    {
        $admin = User::factory()->admin()->create();

        $updateData = [
            'site_name' => 'Biye Marriage Media VIP',
            'site_tagline' => 'Luxury Matrimonial Matching',
            'about_summary' => 'Updated executive about summary.',
            'contact_phone' => '+880 1700-112233',
            'whatsapp_number' => '8801700112233',
            'contact_email' => 'vip@biyemarriagemedia.com',
            'office_address' => 'Gulshan 2, Road 45, House 10, Dhaka-1212',
            'office_hours' => '9:00 AM - 11:00 PM BST',
            'facebook_url' => 'https://facebook.com/biyemediavip',
            'instagram_url' => 'https://instagram.com/biyemediavip',
            'whatsapp_url' => 'https://wa.me/8801700112233',
            'youtube_url' => 'https://youtube.com/@biyemediavip',
            'announcement_enabled' => '1',
            'announcement_text' => 'Winter Matrimonial Salon Sessions Open in London & Dubai',
            'announcement_link' => '/contact',
            'meta_title_suffix' => 'Biye Marriage Media | Luxury Matchmaking',
            'meta_description' => 'Updated meta description for luxury NRI matrimonial searches.',
        ];

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), $updateData);

        $response->assertRedirect(route('admin.settings.index'));
        $response->assertSessionHas('success', 'Site settings updated successfully.');

        $this->assertEquals('+880 1700-112233', SiteSetting::get('contact_phone'));
        $this->assertEquals('8801700112233', SiteSetting::get('whatsapp_number'));
        $this->assertEquals('vip@biyemarriagemedia.com', SiteSetting::get('contact_email'));
        $this->assertEquals('Gulshan 2, Road 45, House 10, Dhaka-1212', SiteSetting::get('office_address'));
        $this->assertEquals('1', SiteSetting::get('announcement_enabled'));
    }

    public function test_announcement_bar_toggle_reflects_in_public_view(): void
    {
        // 1. Initially disabled
        SiteSetting::set('announcement_enabled', '0');
        SiteSetting::set('announcement_text', 'Special Discount Salon Event');
        SiteSetting::clearCache();

        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertDontSee('announcement-marquee-bar');

        // 2. Enabled with custom text
        SiteSetting::set('announcement_enabled', '1');
        SiteSetting::set('announcement_text', 'Exclusive London Meet & Greet Event');
        SiteSetting::set('announcement_link', '/contact');
        SiteSetting::clearCache();

        $responseActive = $this->get(route('home'));
        $responseActive->assertStatus(200);
        $responseActive->assertSee('announcement-marquee-bar');
        $responseActive->assertSee('Exclusive London Meet &amp; Greet Event', false);
        $responseActive->assertSee('/contact');
    }

    public function test_public_contact_and_about_pages_reflect_updated_contact_info(): void
    {
        SiteSetting::set('contact_phone', '+880 1888-999000');
        SiteSetting::set('whatsapp_number', '8801888999000');
        SiteSetting::set('contact_email', 'concierge@biyemedia.com');
        SiteSetting::set('office_address', 'Banani DOHS, Avenue 3, House 15, Dhaka');
        SiteSetting::clearCache();

        // Check /contact
        $contactResponse = $this->get(route('contact'));
        $contactResponse->assertStatus(200);
        $contactResponse->assertSee('+880 1888-999000');
        $contactResponse->assertSee('8801888999000');
        $contactResponse->assertSee('concierge@biyemedia.com');
        $contactResponse->assertSee('Banani DOHS, Avenue 3, House 15, Dhaka');

        // Check /about
        $aboutResponse = $this->get(route('about'));
        $aboutResponse->assertStatus(200);
        $aboutResponse->assertSee('+880 1888-999000');
        $aboutResponse->assertSee('8801888999000');
        $aboutResponse->assertSee('Banani DOHS, Avenue 3, House 15, Dhaka');
    }

    public function test_validation_fails_for_invalid_setting_data(): void
    {
        $admin = User::factory()->admin()->create();

        $invalidData = [
            'site_name' => '', // required
            'contact_phone' => '', // required
            'whatsapp_number' => '', // required
            'contact_email' => 'invalid-email-string', // must be valid email
            'office_address' => '', // required
            'facebook_url' => 'not-a-valid-url', // must be valid URL
        ];

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), $invalidData);

        $response->assertSessionHasErrors(['site_name', 'contact_phone', 'whatsapp_number', 'contact_email', 'office_address', 'facebook_url']);
    }

    public function test_site_setting_helper_function(): void
    {
        SiteSetting::set('custom_test_key', 'AntigravityValue');

        $this->assertEquals('AntigravityValue', site_setting('custom_test_key'));
        $this->assertEquals('FallbackValue', site_setting('non_existent_key_xyz', 'FallbackValue'));
        $this->assertEquals('+880 1577-723404', site_setting('contact_phone'));
    }
}
