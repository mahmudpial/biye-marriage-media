<?php

namespace Tests\Feature;

use App\Models\CandidateProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_admin_profiles(): void
    {
        $response = $this->get(route('admin.profiles.index'));

        $response->assertRedirect('/admin/login');
    }

    public function test_non_admin_cannot_access_admin_profiles(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.profiles.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_view_profiles_list(): void
    {
        $admin = User::factory()->admin()->create();
        $profile = CandidateProfile::factory()->create([
            'profile_code' => 'BD-TEST-0001',
            'profession' => 'Senior Test Architect',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.profiles.index'));

        $response->assertStatus(200);
        $response->assertSee('Candidate Profiles Management');
        $response->assertSee('BD-TEST-0001');
        $response->assertSee('Senior Test Architect');
        $response->assertSee('modal-badges-grid');
    }

    public function test_admin_can_view_create_profile_form(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.profiles.create'));

        $response->assertStatus(200);
        $response->assertSee('Create Candidate Profile');
        $response->assertSee('Create &amp; Publish Profile', false);
    }

    public function test_admin_can_store_a_new_candidate_profile_with_url(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.profiles.store'), [
            'profile_code' => 'BD-ELT-9999',
            'gender' => 'female',
            'age' => 27,
            'height' => "5'6\"",
            'religion' => 'Islam (Sunni)',
            'desher_bari' => 'Sylhet',
            'education' => 'MSc Imperial College London',
            'profession' => 'Biomedical Scientist',
            'location' => 'Gulshan-2, Dhaka',
            'income' => '৳40 Lakhs+',
            'category' => 'Elite Professional',
            'family' => 'Respected Tea Planters & Corporate Family',
            'image_url' => 'https://images.unsplash.com/photo-test',
            'is_discreet' => '1',
            'is_featured' => '1',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.profiles.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('candidate_profiles', [
            'profile_code' => 'BD-ELT-9999',
            'profession' => 'Biomedical Scientist',
            'is_active' => true,
            'is_featured' => true,
        ]);
    }

    public function test_admin_can_store_profile_with_image_upload(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();
        $file = UploadedFile::fake()->image('profile.jpg');

        $response = $this->actingAs($admin)->post(route('admin.profiles.store'), [
            'gender' => 'male',
            'age' => 31,
            'height' => "5'11\"",
            'religion' => 'Islam',
            'desher_bari' => 'Dhaka',
            'education' => 'BUET Graduate',
            'profession' => 'Software Director',
            'location' => 'Dhanmondi, Dhaka',
            'income' => '৳60 Lakhs+',
            'category' => 'Elite Professional',
            'family' => 'Industrialists',
            'image_file' => $file,
            'is_discreet' => '0',
            'is_featured' => '0',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.profiles.index'));

        $profile = CandidateProfile::where('profession', 'Software Director')->first();
        $this->assertNotNull($profile);
        $this->assertNotNull($profile->image);
        Storage::disk('public')->assertExists($profile->image);
    }

    public function test_admin_can_view_edit_profile_form(): void
    {
        $admin = User::factory()->admin()->create();
        $profile = CandidateProfile::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.profiles.edit', $profile));

        $response->assertStatus(200);
        $response->assertSee('Edit Candidate #'.$profile->profile_code);
        $response->assertSee('Save Profile Changes');
    }

    public function test_admin_can_update_candidate_profile(): void
    {
        $admin = User::factory()->admin()->create();
        $profile = CandidateProfile::factory()->create([
            'profession' => 'Old Profession',
            'desher_bari' => 'Dhaka',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.profiles.update', $profile), [
            'profile_code' => $profile->profile_code,
            'gender' => $profile->gender,
            'age' => 29,
            'height' => $profile->height,
            'religion' => $profile->religion,
            'desher_bari' => 'Chattogram',
            'education' => 'Updated Education',
            'profession' => 'Executive Director',
            'location' => 'Khulshi, Chattogram',
            'income' => '৳1 Crore+',
            'category' => 'Elite Business',
            'family' => 'Industrialist Group',
            'is_discreet' => '1',
            'is_featured' => '1',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.profiles.index'));
        $this->assertDatabaseHas('candidate_profiles', [
            'id' => $profile->id,
            'profession' => 'Executive Director',
            'desher_bari' => 'Chattogram',
        ]);
    }

    public function test_admin_can_toggle_active_and_featured_status(): void
    {
        $admin = User::factory()->admin()->create();
        $profile = CandidateProfile::factory()->create([
            'is_active' => true,
            'is_featured' => false,
        ]);

        $responseToggleActive = $this->actingAs($admin)->patch(route('admin.profiles.toggle-active', $profile));
        $responseToggleActive->assertRedirect();
        $this->assertDatabaseHas('candidate_profiles', [
            'id' => $profile->id,
            'is_active' => false,
        ]);

        $responseToggleFeatured = $this->actingAs($admin)->patch(route('admin.profiles.toggle-featured', $profile));
        $responseToggleFeatured->assertRedirect();
        $this->assertDatabaseHas('candidate_profiles', [
            'id' => $profile->id,
            'is_featured' => true,
        ]);
    }

    public function test_admin_can_delete_candidate_profile(): void
    {
        $admin = User::factory()->admin()->create();
        $profile = CandidateProfile::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.profiles.destroy', $profile));

        $response->assertRedirect(route('admin.profiles.index'));
        $this->assertDatabaseMissing('candidate_profiles', [
            'id' => $profile->id,
        ]);
    }

    public function test_public_profiles_page_displays_active_database_candidates(): void
    {
        $activeCandidate = CandidateProfile::factory()->create([
            'profile_code' => 'BD-PUBLIC-01',
            'profession' => 'Supreme Court Advocate',
            'is_active' => true,
        ]);

        $inactiveCandidate = CandidateProfile::factory()->create([
            'profile_code' => 'BD-HIDDEN-02',
            'profession' => 'Secret Inactive Candidate',
            'is_active' => false,
        ]);

        $response = $this->get(route('profiles'));

        $response->assertStatus(200);
        $response->assertSee('BD-PUBLIC-01');
        $response->assertSee('Supreme Court Advocate');
        $response->assertDontSee('BD-HIDDEN-02');
        $response->assertDontSee('Secret Inactive Candidate');
    }

    public function test_admin_can_update_candidate_profile_via_direct_post(): void
    {
        $admin = User::factory()->admin()->create();
        $profile = CandidateProfile::factory()->create([
            'profession' => 'Before Post Update',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.profiles.update.post', $profile), [
            'profile_code' => $profile->profile_code,
            'gender' => $profile->gender,
            'age' => 30,
            'height' => $profile->height,
            'religion' => $profile->religion,
            'desher_bari' => 'Sylhet',
            'education' => 'Master of Science',
            'profession' => 'Post Updated Profession',
            'location' => 'Gulshan, Dhaka',
            'income' => '৳80 Lakhs+',
            'category' => 'Elite Professional',
            'family' => 'Renowned Family',
            'is_discreet' => '1',
            'is_featured' => '0',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.profiles.index'));
        $this->assertDatabaseHas('candidate_profiles', [
            'id' => $profile->id,
            'profession' => 'Post Updated Profession',
        ]);
    }
}
