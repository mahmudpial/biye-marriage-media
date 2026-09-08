<?php

namespace Tests\Feature;

use App\Models\MembershipPackage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPackageTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_admin_packages(): void
    {
        $response = $this->get(route('admin.packages.index'));

        $response->assertRedirect('/admin/login');
    }

    public function test_non_admin_cannot_access_admin_packages(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.packages.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_view_packages_list(): void
    {
        $admin = User::factory()->admin()->create();
        $package = MembershipPackage::factory()->create([
            'name' => 'Diplomat Tier',
            'badge' => 'Embassy & Foreign Service',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.packages.index'));

        $response->assertStatus(200);
        $response->assertSee('Packages List');
        $response->assertSee('Diplomat Tier');
        $response->assertSee('Embassy &amp; Foreign Service', false);
    }

    public function test_admin_can_view_create_package_form(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.packages.create'));

        $response->assertStatus(200);
        $response->assertSee('Package Identity &amp; Positioning', false);
        $response->assertSee('Create &amp; Publish Package', false);
    }

    public function test_admin_can_store_new_package(): void
    {
        $admin = User::factory()->admin()->create();

        $benefitsText = "Dedicated Senior Matchmaker\nBespoke verification checks\nConfidential hotel meetings";

        $response = $this->actingAs($admin)->post(route('admin.packages.store'), [
            'name' => 'Royal Heritage',
            'slug' => 'royal-heritage',
            'badge' => 'Royalty & Zamindar Lineage',
            'price' => '৳3,00,000 / Bespoke',
            'description' => 'Tailored exclusively for families of historical prestige.',
            'benefits_text' => $benefitsText,
            'sort_order' => 5,
            'featured' => '1',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.packages.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('membership_packages', [
            'name' => 'Royal Heritage',
            'slug' => 'royal-heritage',
            'price' => '৳3,00,000 / Bespoke',
            'featured' => true,
            'is_active' => true,
            'sort_order' => 5,
        ]);

        $saved = MembershipPackage::where('slug', 'royal-heritage')->first();
        $this->assertNotNull($saved);
        $this->assertCount(3, $saved->benefits);
        $this->assertEquals('Dedicated Senior Matchmaker', $saved->benefits[0]);
    }

    public function test_admin_can_view_edit_package_form(): void
    {
        $admin = User::factory()->admin()->create();
        $package = MembershipPackage::factory()->create([
            'name' => 'Global NRB Concierge',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.packages.edit', $package));

        $response->assertStatus(200);
        $response->assertSee('Tier: Global NRB Concierge');
        $response->assertSee('Save Package Changes');
    }

    public function test_admin_can_deactivate_package_via_edit_form(): void
    {
        $admin = User::factory()->admin()->create();
        $package = MembershipPackage::factory()->create([
            'name' => 'Active Tier',
            'is_active' => true,
        ]);

        // When is_active is unchecked, the browser sends no is_active key
        $response = $this->actingAs($admin)->put(route('admin.packages.update', $package), [
            'name' => 'Active Tier',
            'benefits_text' => 'Benefit A',
            // no is_active sent
        ]);

        $response->assertRedirect(route('admin.packages.index'));
        $package->refresh();
        $this->assertFalse($package->is_active);
    }

    public function test_package_requires_at_least_one_valid_benefit(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.packages.store'), [
            'name' => 'Invalid Tier',
            'benefits_text' => "   \n  \n  ",
        ]);

        $response->assertSessionHasErrors('benefits_text');
    }

    public function test_admin_can_update_package(): void
    {
        $admin = User::factory()->admin()->create();
        $package = MembershipPackage::factory()->create([
            'name' => 'Old Tier Name',
            'slug' => 'old-tier',
            'sort_order' => 1,
        ]);

        $newBenefits = "Updated Privilege 1\nUpdated Privilege 2";

        $response = $this->actingAs($admin)->put(route('admin.packages.update', $package), [
            'name' => 'Updated Tier Name',
            'slug' => 'updated-tier',
            'badge' => 'Updated Subtitle',
            'price' => '৳85,000 / 6 Mo',
            'description' => 'Updated Description',
            'benefits_text' => $newBenefits,
            'sort_order' => 2,
            'featured' => '0',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.packages.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('membership_packages', [
            'id' => $package->id,
            'name' => 'Updated Tier Name',
            'slug' => 'updated-tier',
            'sort_order' => 2,
            'featured' => false,
        ]);

        $package->refresh();
        $this->assertCount(2, $package->benefits);
        $this->assertEquals('Updated Privilege 1', $package->benefits[0]);
    }

    public function test_admin_can_toggle_active_and_featured_states(): void
    {
        $admin = User::factory()->admin()->create();
        $package = MembershipPackage::factory()->create([
            'is_active' => true,
            'featured' => false,
        ]);

        $toggleActiveResponse = $this->actingAs($admin)->patch(route('admin.packages.toggle-active', $package));
        $toggleActiveResponse->assertRedirect();
        $this->assertDatabaseHas('membership_packages', [
            'id' => $package->id,
            'is_active' => false,
        ]);

        $toggleFeaturedResponse = $this->actingAs($admin)->patch(route('admin.packages.toggle-featured', $package));
        $toggleFeaturedResponse->assertRedirect();
        $this->assertDatabaseHas('membership_packages', [
            'id' => $package->id,
            'featured' => true,
        ]);
    }

    public function test_admin_can_delete_package(): void
    {
        $admin = User::factory()->admin()->create();
        $package = MembershipPackage::factory()->create([
            'name' => 'Temporary Promo Package',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.packages.destroy', $package));

        $response->assertRedirect(route('admin.packages.index'));
        $this->assertDatabaseMissing('membership_packages', [
            'id' => $package->id,
        ]);
    }

    public function test_public_pricing_pages_render_active_database_packages(): void
    {
        $activePkg = MembershipPackage::factory()->create([
            'name' => 'Diamond Elite Tier',
            'badge' => 'Ultra High Net Worth',
            'is_active' => true,
            'benefits' => ['Exclusive Matchmaker', 'Private Jet Escort'],
        ]);

        $inactivePkg = MembershipPackage::factory()->create([
            'name' => 'Decommissioned Tier',
            'is_active' => false,
        ]);

        $responsePackages = $this->get(route('packages'));
        $responsePackages->assertStatus(200);
        $responsePackages->assertSee('Diamond Elite Tier');
        $responsePackages->assertSee('Exclusive Matchmaker');
        $responsePackages->assertDontSee('Decommissioned Tier');

        $responseHome = $this->get(route('home'));
        $responseHome->assertStatus(200);
        $responseHome->assertSee('Diamond Elite Tier');
        $responseHome->assertDontSee('Decommissioned Tier');
    }
}
