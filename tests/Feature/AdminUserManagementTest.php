<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_user_management(): void
    {
        $response = $this->get(route('admin.users.index'));

        $response->assertRedirect('/admin/login');
    }

    public function test_non_admin_cannot_access_user_management(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_view_users_list(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Dr. Farhana Executive',
            'email' => 'farhana@biyemedia.com',
            'designation' => 'Senior HNI Matchmaker',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Staff &amp; Matchmaker Accounts', false);
        $response->assertSee('Dr. Farhana Executive');
        $response->assertSee('farhana@biyemedia.com');
        $response->assertSee('Senior HNI Matchmaker');
    }

    public function test_admin_can_view_user_details_page(): void
    {
        $admin = User::factory()->admin()->create();
        $targetUser = User::factory()->create([
            'name' => 'Farhana VIP Matchmaker',
            'email' => 'farhana.vip@biyemedia.com',
            'designation' => 'Executive Matchmaker',
            'is_admin' => true,
            'role' => User::ROLE_SENIOR_MATCHMAKER,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.show', $targetUser));

        $response->assertStatus(200);
        $response->assertSee('Staff Member Details');
        $response->assertSee('Farhana VIP Matchmaker');
        $response->assertSee('farhana.vip@biyemedia.com');
        $response->assertSee('Executive Matchmaker');
        $response->assertSee('VIP Matrimonial Matching');
    }

    public function test_admin_can_filter_users_by_search_keyword(): void
    {
        $admin = User::factory()->admin()->create();

        $matchmaker = User::factory()->admin()->create([
            'name' => 'Shabnam Begum (Gulshan Desk)',
            'email' => 'shabnam@biyemedia.com',
        ]);

        $otherStaff = User::factory()->admin()->create([
            'name' => 'Kamal Hossain (Sylhet)',
            'email' => 'kamal@biyemedia.com',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.index', [
            'search' => 'Shabnam',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Shabnam Begum');
        $response->assertDontSee('Kamal Hossain');
    }

    public function test_admin_can_filter_users_by_role(): void
    {
        $admin = User::factory()->admin()->create();

        $auditor = User::factory()->create([
            'name' => 'NID Credential Verifier',
            'is_admin' => true,
            'role' => User::ROLE_PROFILE_AUDITOR,
        ]);

        $manager = User::factory()->create([
            'name' => 'Overseas Desk Coordinator',
            'is_admin' => true,
            'role' => User::ROLE_RELATIONSHIP_MANAGER,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.index', [
            'role' => User::ROLE_PROFILE_AUDITOR,
        ]));

        $response->assertStatus(200);
        $response->assertSee('NID Credential Verifier');
        $response->assertDontSee('Overseas Desk Coordinator');
    }

    public function test_admin_can_filter_users_by_status(): void
    {
        $admin = User::factory()->admin()->create();

        $activeStaff = User::factory()->create([
            'name' => 'Active Officer',
            'is_admin' => true,
            'is_active' => true,
        ]);

        $suspendedStaff = User::factory()->create([
            'name' => 'Suspended Matchmaker',
            'is_admin' => true,
            'is_active' => false,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.index', [
            'status' => 'inactive',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Suspended Matchmaker');
        $response->assertDontSee('Active Officer');
    }

    public function test_admin_can_view_create_user_form(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.users.create'));

        $response->assertStatus(200);
        $response->assertSee('Add New Team Member');
        $response->assertSee('Official Email Address');
        $response->assertSee('Administrative Role');
    }

    public function test_admin_can_create_new_staff_member(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = [
            'name' => 'Nasreen Sultana',
            'email' => 'nasreen@biyemedia.com',
            'password' => 'secretPass123',
            'password_confirmation' => 'secretPass123',
            'role' => User::ROLE_SENIOR_MATCHMAKER,
            'designation' => 'Senior Relationship Manager (Baridhara DOHS)',
            'phone' => '+880 1711-998877',
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->post(route('admin.users.store'), $payload);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Nasreen Sultana',
            'email' => 'nasreen@biyemedia.com',
            'role' => User::ROLE_SENIOR_MATCHMAKER,
            'is_admin' => 1,
            'is_active' => 1,
        ]);

        $newUser = User::where('email', 'nasreen@biyemedia.com')->first();
        $this->assertTrue(Hash::check('secretPass123', $newUser->password));
    }

    public function test_user_creation_validation_requires_mandatory_fields(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => '',
            'email' => '',
            'password' => '',
            'role' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'password', 'role']);
    }

    public function test_user_creation_validation_enforces_unique_email(): void
    {
        $admin = User::factory()->admin()->create(['email' => 'existing@biyemedia.com']);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Duplicate User',
            'email' => 'existing@biyemedia.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => User::ROLE_RELATIONSHIP_MANAGER,
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_admin_can_view_edit_user_form(): void
    {
        $admin = User::factory()->admin()->create();
        $staff = User::factory()->create([
            'name' => 'Target Matchmaker',
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.users.edit', $staff));

        $response->assertStatus(200);
        $response->assertSee('Edit Staff: Target Matchmaker');
    }

    public function test_admin_can_update_staff_member_details(): void
    {
        $admin = User::factory()->admin()->create();
        $staff = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@biyemedia.com',
            'is_admin' => true,
            'role' => User::ROLE_RELATIONSHIP_MANAGER,
        ]);

        $payload = [
            'name' => 'Updated Officer Name',
            'email' => 'original@biyemedia.com',
            'role' => User::ROLE_SENIOR_MATCHMAKER,
            'designation' => 'Lead Matchmaker (Chattogram Desk)',
            'phone' => '+880 1819-001122',
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->put(route('admin.users.update', $staff), $payload);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $staff->refresh();
        $this->assertEquals('Updated Officer Name', $staff->name);
        $this->assertEquals(User::ROLE_SENIOR_MATCHMAKER, $staff->role);
        $this->assertEquals('Lead Matchmaker (Chattogram Desk)', $staff->designation);
    }

    public function test_admin_can_update_staff_password(): void
    {
        $admin = User::factory()->admin()->create();
        $staff = User::factory()->create([
            'is_admin' => true,
            'password' => Hash::make('oldPassword123'),
        ]);

        $payload = [
            'name' => $staff->name,
            'email' => $staff->email,
            'role' => $staff->role,
            'password' => 'newSecretPass789',
            'password_confirmation' => 'newSecretPass789',
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->put(route('admin.users.update', $staff), $payload);

        $response->assertRedirect(route('admin.users.index'));

        $staff->refresh();
        $this->assertTrue(Hash::check('newSecretPass789', $staff->password));
    }

    public function test_admin_can_delete_another_staff_member(): void
    {
        $admin = User::factory()->admin()->create();
        $otherStaff = User::factory()->create([
            'name' => 'Staff To Delete',
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $otherStaff));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', ['id' => $otherStaff->id]);
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

        $response->assertSessionHasErrors('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_cannot_delete_primary_super_admin(): void
    {
        $admin = User::factory()->admin()->create();
        $primaryAdmin = User::factory()->create([
            'email' => 'admin@biyemedia.com',
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $primaryAdmin));

        $response->assertSessionHasErrors('error');
        $this->assertDatabaseHas('users', ['id' => $primaryAdmin->id]);
    }

    public function test_admin_can_toggle_staff_active_status(): void
    {
        $admin = User::factory()->admin()->create();
        $staff = User::factory()->create([
            'is_admin' => true,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.users.toggle-active', $staff));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertFalse($staff->fresh()->is_active);

        // Toggle back to active
        $this->actingAs($admin)->post(route('admin.users.toggle-active', $staff));
        $this->assertTrue($staff->fresh()->is_active);
    }

    public function test_admin_cannot_deactivate_their_own_account(): void
    {
        $admin = User::factory()->admin()->create(['is_active' => true]);

        $response = $this->actingAs($admin)->post(route('admin.users.toggle-active', $admin));

        $response->assertSessionHasErrors('error');
        $this->assertTrue($admin->fresh()->is_active);
    }

    public function test_deactivated_admin_cannot_log_in(): void
    {
        $user = User::factory()->create([
            'email' => 'suspended@biyemedia.com',
            'password' => Hash::make('securePassword123'),
            'is_admin' => true,
            'is_active' => false,
        ]);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'suspended@biyemedia.com',
            'password' => 'securePassword123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_deactivated_admin_is_rejected_by_middleware_if_session_active(): void
    {
        $suspendedAdmin = User::factory()->create([
            'is_admin' => true,
            'is_active' => false,
        ]);

        $response = $this->actingAs($suspendedAdmin)->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
