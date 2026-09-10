<?php

namespace Tests\Feature;

use App\Models\CandidateProfile;
use App\Models\MembershipPackage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminClientManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_client_accounts_list(): void
    {
        $admin = User::factory()->admin()->create();
        $client = User::factory()->client()->create(['name' => 'Tanjina Sultana']);
        CandidateProfile::factory()->create(['user_id' => $client->id]);

        $response = $this->actingAs($admin)->get(route('admin.clients.index'));

        $response->assertStatus(200);
        $response->assertSee('Registered Matrimony Clients');
        $response->assertSee('Tanjina Sultana');
    }

    public function test_admin_can_filter_clients_by_verification_status(): void
    {
        $admin = User::factory()->admin()->create();
        $verifiedClient = User::factory()->client()->create([
            'name' => 'Verified Nusrat',
            'verification_status' => User::VERIFICATION_VERIFIED,
        ]);
        $pendingClient = User::factory()->client()->create([
            'name' => 'Pending Anis',
            'verification_status' => User::VERIFICATION_PENDING,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.clients.index', ['verification_status' => 'verified']));

        $response->assertStatus(200);
        $response->assertSee('Verified Nusrat');
        $response->assertDontSee('Pending Anis');
    }

    public function test_admin_can_view_client_details(): void
    {
        $admin = User::factory()->admin()->create();
        $client = User::factory()->client()->create(['name' => 'Saif Chowdhury']);
        $profile = CandidateProfile::factory()->create([
            'user_id' => $client->id,
            'education' => 'BBA from IBA, Dhaka University',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.clients.show', $client));

        $response->assertStatus(200);
        $response->assertSee('Saif Chowdhury');
        $response->assertSee('BBA from IBA, Dhaka University');
    }

    public function test_admin_can_toggle_client_account_status(): void
    {
        $admin = User::factory()->admin()->create();
        $client = User::factory()->client()->create(['status' => User::STATUS_ACTIVE]);

        // Suspend
        $response = $this->actingAs($admin)->post(route('admin.clients.status', $client), [
            'status' => 'suspended',
            'suspension_reason' => 'Violation of terms',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('suspended', $client->fresh()->status);
        $this->assertFalse($client->fresh()->is_active);

        // Reactivate
        $response = $this->actingAs($admin)->post(route('admin.clients.status', $client), [
            'status' => 'active',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('active', $client->fresh()->status);
        $this->assertTrue($client->fresh()->is_active);
    }

    public function test_admin_can_verify_client_and_grant_blue_seal(): void
    {
        $admin = User::factory()->admin()->create();
        $client = User::factory()->client()->create(['verification_status' => User::VERIFICATION_PENDING]);
        $profile = CandidateProfile::factory()->create([
            'user_id' => $client->id,
            'approval_status' => 'draft',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.clients.verify', $client), [
            'verification_status' => 'verified',
            'approval_status' => 'approved',
            'admin_notes' => 'Identity verified via NID & reference check.',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals(User::VERIFICATION_VERIFIED, $client->fresh()->verification_status);
        $this->assertNotNull($client->fresh()->verified_at);
        $this->assertEquals('approved', $profile->fresh()->approval_status);
    }

    public function test_admin_can_assign_relationship_manager_to_client(): void
    {
        $admin = User::factory()->admin()->create();
        $matchmaker = User::factory()->admin()->create([
            'role' => User::ROLE_SENIOR_MATCHMAKER,
            'name' => 'Begum Rokeya',
        ]);
        $client = User::factory()->client()->create();

        $response = $this->actingAs($admin)->post(route('admin.clients.assign-staff', $client), [
            'assigned_staff_id' => $matchmaker->id,
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals($matchmaker->id, $client->fresh()->assigned_staff_id);
    }

    public function test_admin_can_upgrade_client_subscription_and_allocate_quota(): void
    {
        $admin = User::factory()->admin()->create();
        $client = User::factory()->client()->create();
        $package = MembershipPackage::factory()->create(['name' => 'Elite Aristocrat']);

        $response = $this->actingAs($admin)->post(route('admin.clients.subscription', $client), [
            'package_id' => $package->id,
            'package_name' => 'Elite Aristocrat',
            'price_paid' => 45000,
            'proposals_quota' => 30,
            'validity_months' => 6,
            'payment_method' => 'bkash',
            'transaction_id' => 'TR-BK-999888',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('user_subscriptions', [
            'user_id' => $client->id,
            'package_name' => 'Elite Aristocrat',
            'price_paid' => 45000,
            'proposals_quota' => 30,
            'status' => 'active',
        ]);
    }

    public function test_admin_can_impersonate_client_and_stop_impersonating(): void
    {
        $admin = User::factory()->admin()->create();
        $client = User::factory()->client()->create(['name' => 'Impersonated User']);

        // Impersonate
        $response = $this->actingAs($admin)->post(route('admin.clients.impersonate', $client));

        $response->assertRedirect(route('member.dashboard'));
        $this->assertEquals($client->id, auth()->id());
        $this->assertEquals($admin->id, session('impersonator_admin_id'));

        // Stop Impersonating
        $stopResponse = $this->get(route('admin.clients.stop-impersonate'));
        $stopResponse->assertRedirect(route('admin.clients.index'));
        $this->assertEquals($admin->id, auth()->id());
    }
}
