<?php

namespace Tests\Feature;

use App\Models\CandidateProfile;
use App\Models\Proposal;
use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ClientPortalFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_is_accessible(): void
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
        $response->assertSee('রেজিস্ট্রেশন করুন');
        $response->assertSee('profile_for');
        $response->assertSee('genderFemale');
    }

    public function test_client_can_register_and_is_redirected_to_member_dashboard(): void
    {
        $staff = User::factory()->admin()->create();

        $registrationData = [
            'name' => 'Farhana Rahman',
            'email' => 'farhana.rahman@example.com',
            'phone' => '01712345678',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'profile_for' => 'daughter',
            'guardian_name' => 'Dr. A. Rahman',
            'gender' => 'female',
            'desher_bari' => 'Sylhet',
            'profession' => 'Resident Physician',
        ];

        $response = $this->post(route('register.submit'), $registrationData);

        $response->assertRedirect(route('member.dashboard'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'farhana.rahman@example.com',
            'user_type' => User::TYPE_CLIENT,
            'profile_for' => 'daughter',
            'guardian_name' => 'Dr. A. Rahman',
            'verification_status' => User::VERIFICATION_PENDING,
            'status' => User::STATUS_ACTIVE,
        ]);

        $user = User::where('email', 'farhana.rahman@example.com')->first();
        $this->assertNotNull($user->candidateProfile);
        $this->assertEquals('female', $user->candidateProfile->gender);
        $this->assertEquals('Sylhet', $user->candidateProfile->desher_bari);

        $this->assertDatabaseHas('user_subscriptions', [
            'user_id' => $user->id,
            'proposals_quota' => 5,
            'status' => 'active',
        ]);
    }

    public function test_client_can_login_and_redirects_to_member_dashboard(): void
    {
        $client = User::factory()->client()->create([
            'email' => 'member@example.com',
            'phone' => '01811223344',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post(route('login.submit'), [
            'login' => 'member@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('member.dashboard'));
        $this->assertAuthenticatedAs($client);
    }

    public function test_suspended_client_cannot_login(): void
    {
        $suspendedUser = User::factory()->client()->create([
            'email' => 'suspended@example.com',
            'password' => bcrypt('secret123'),
            'status' => User::STATUS_SUSPENDED,
            'suspension_reason' => 'Fraudulent profile information provided',
        ]);

        $response = $this->from(route('login'))->post(route('login.submit'), [
            'login' => 'suspended@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['login']);
        $this->assertGuest();
    }

    public function test_client_can_view_member_dashboard_with_completion_score(): void
    {
        $client = User::factory()->client()->create();
        $profile = CandidateProfile::factory()->create([
            'user_id' => $client->id,
            'completion_score' => 65,
        ]);
        UserSubscription::factory()->create(['user_id' => $client->id]);

        $response = $this->actingAs($client)->get(route('member.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('আসসালামু আলাইকুম');
        $response->assertSee('65% সম্পন্ন');
    }

    public function test_client_can_view_cv_style_biodata_showcase(): void
    {
        $client = User::factory()->client()->create();
        $profile = CandidateProfile::factory()->create([
            'user_id' => $client->id,
            'profession' => 'Senior Strategic Consultant',
            'desher_bari' => 'Sylhet',
        ]);

        $response = $this->actingAs($client)->get(route('member.biodata.show'));

        $response->assertStatus(200);
        $response->assertSee('আমার পূর্ণাঙ্গ বায়োডাটা (Marriage CV)');
        $response->assertSee($profile->profile_code);
        $response->assertSee('Senior Strategic Consultant');
        $response->assertSee('Sylhet');
        $response->assertSee('বায়োডাটা এডিট করুন');
    }

    public function test_client_can_access_biodata_edit_form(): void
    {
        $client = User::factory()->client()->create();
        $profile = CandidateProfile::factory()->create([
            'user_id' => $client->id,
            'profession' => 'Lead Software Architect',
        ]);

        $response = $this->actingAs($client)->get(route('member.biodata.edit'));

        $response->assertStatus(200);
        $response->assertSee('বায়োডাটা তথ্য আপডেট করুন');
        $response->assertSee('Lead Software Architect');
        $response->assertSee('বায়োডাটা সংরক্ষণ করুন');
    }

    public function test_client_can_update_biodata(): void
    {
        $client = User::factory()->client()->create();
        $profile = CandidateProfile::factory()->create([
            'user_id' => $client->id,
            'gender' => 'female',
            'age' => 26,
            'height' => "5'4\"",
        ]);

        $response = $this->actingAs($client)->post(route('member.biodata.update'), [
            'gender' => 'female',
            'age' => 27,
            'height' => "5'5\"",
            'religion' => 'Islam (Sunni)',
            'desher_bari' => 'Dhaka',
            'education' => 'MSc in Economics, Dhaka University',
            'profession' => 'Senior Research Officer',
            'location' => 'Banani DOHS, Dhaka',
            'income' => '৳20 Lakhs+',
            'family' => 'Father is a retired judge, mother is a homemaker. 2 brothers well established.',
            'pref_age_min' => 28,
            'pref_age_max' => 33,
            'pref_desher_bari' => 'Dhaka',
            'is_discreet' => 1,
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('candidate_profiles', [
            'id' => $profile->id,
            'age' => 27,
            'desher_bari' => 'Dhaka',
            'profession' => 'Senior Research Officer',
            'pref_age_min' => 28,
            'is_discreet' => 1,
        ]);
    }

    public function test_client_can_toggle_discreet_photo_blur(): void
    {
        $client = User::factory()->client()->create();
        $profile = CandidateProfile::factory()->create([
            'user_id' => $client->id,
            'is_discreet' => true,
        ]);

        $response = $this->actingAs($client)->post(route('member.biodata.toggle-discreet'));

        $response->assertRedirect();
        $this->assertDatabaseHas('candidate_profiles', [
            'id' => $profile->id,
            'is_discreet' => false,
        ]);
    }

    public function test_client_can_toggle_shortlist(): void
    {
        $client = User::factory()->client()->create();
        $targetCandidate = CandidateProfile::factory()->create();

        // Add to shortlist
        $response = $this->actingAs($client)->post(route('member.shortlists.toggle', $targetCandidate));
        $response->assertRedirect();
        $this->assertDatabaseHas('shortlists', [
            'user_id' => $client->id,
            'candidate_profile_id' => $targetCandidate->id,
        ]);

        // Remove from shortlist
        $response = $this->actingAs($client)->post(route('member.shortlists.toggle', $targetCandidate));
        $response->assertRedirect();
        $this->assertDatabaseMissing('shortlists', [
            'user_id' => $client->id,
            'candidate_profile_id' => $targetCandidate->id,
        ]);
    }

    public function test_client_can_send_proposal_and_quota_is_deducted(): void
    {
        $client = User::factory()->client()->create();
        $myProfile = CandidateProfile::factory()->create([
            'user_id' => $client->id,
            'gender' => 'female',
        ]);
        $targetGroom = CandidateProfile::factory()->create([
            'gender' => 'male',
            'approval_status' => 'approved',
            'is_active' => true,
        ]);
        $subscription = UserSubscription::factory()->create([
            'user_id' => $client->id,
            'proposals_quota' => 5,
            'proposals_used' => 1,
        ]);

        $response = $this->actingAs($client)->post(route('member.proposals.send', $targetGroom), [
            'message' => 'Our family would like to inquire regarding alliance.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('proposals', [
            'sender_user_id' => $client->id,
            'sender_profile_id' => $myProfile->id,
            'receiver_profile_id' => $targetGroom->id,
            'status' => Proposal::STATUS_PENDING,
        ]);

        // Verify quota consumed
        $this->assertEquals(2, $subscription->fresh()->proposals_used);
    }

    public function test_client_can_accept_received_proposal(): void
    {
        $client = User::factory()->client()->create();
        $myProfile = CandidateProfile::factory()->create([
            'user_id' => $client->id,
        ]);
        $senderUser = User::factory()->client()->create();
        $senderProfile = CandidateProfile::factory()->create([
            'user_id' => $senderUser->id,
        ]);

        $proposal = Proposal::create([
            'sender_user_id' => $senderUser->id,
            'sender_profile_id' => $senderProfile->id,
            'receiver_profile_id' => $myProfile->id,
            'status' => Proposal::STATUS_PENDING,
        ]);

        $response = $this->actingAs($client)->post(route('member.proposals.respond', $proposal), [
            'status' => 'accepted',
        ]);

        $response->assertSessionHas('success');
        $this->assertEquals('accepted', $proposal->fresh()->status);
        $this->assertNotNull($proposal->fresh()->responded_at);
    }

    public function test_client_can_update_password(): void
    {
        $client = User::factory()->client()->create([
            'password' => bcrypt('oldpassword123'),
        ]);

        $response = $this->actingAs($client)->post(route('member.password.update'), [
            'current_password' => 'oldpassword123',
            'password' => 'newpassword456',
            'password_confirmation' => 'newpassword456',
        ]);

        $response->assertSessionHas('success');
        $this->assertTrue(Hash::check('newpassword456', $client->fresh()->password));
    }

    public function test_client_cannot_update_password_with_wrong_current_password(): void
    {
        $client = User::factory()->client()->create([
            'password' => bcrypt('correctpassword'),
        ]);

        $response = $this->actingAs($client)->post(route('member.password.update'), [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword456',
            'password_confirmation' => 'newpassword456',
        ]);

        $response->assertSessionHasErrors(['current_password']);
        $this->assertFalse(Hash::check('newpassword456', $client->fresh()->password));
    }
}
