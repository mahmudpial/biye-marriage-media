<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_locale_is_bengali(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $this->assertEquals('bn', app()->getLocale());
    }

    public function test_user_can_switch_locale_to_english_via_route(): void
    {
        $response = $this->from(route('home'))->get(route('locale.switch', ['lang' => 'en']));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('locale', 'en');
    }

    public function test_user_can_switch_locale_to_bengali_via_route(): void
    {
        $response = $this->withSession(['locale' => 'en'])
            ->from(route('home'))
            ->get(route('locale.switch', ['lang' => 'bn']));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('locale', 'bn');
    }

    public function test_invalid_locale_does_not_change_session(): void
    {
        $response = $this->withSession(['locale' => 'bn'])
            ->from(route('home'))
            ->get(route('locale.switch', ['lang' => 'fr']));

        $response->assertRedirect(route('home'));
        $response->assertSessionMissing('locale', 'fr');
    }

    public function test_query_parameter_lang_updates_locale(): void
    {
        $response = $this->get(route('home', ['lang' => 'en']));

        $response->assertStatus(200);
        $this->assertEquals('en', app()->getLocale());
        $response->assertSessionHas('locale', 'en');
    }

    public function test_frontend_renders_english_translations_when_locale_is_english(): void
    {
        $response = $this->withSession(['locale' => 'en'])->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Home');
        $response->assertSee('Find Matches');
        $response->assertSee('Success Stories');
        $response->assertSee('Contact');
    }

    public function test_member_portal_renders_english_translations_when_locale_is_english(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['locale' => 'en'])
            ->get(route('member.matches'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Search by Profession');
        $response->assertSee('Recommended Biodata List');
    }
}
