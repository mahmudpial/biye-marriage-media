<?php

namespace Tests\Feature;

use App\Models\SuccessStory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminStoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_admin_stories(): void
    {
        $response = $this->get(route('admin.stories.index'));

        $response->assertRedirect('/admin/login');
    }

    public function test_non_admin_cannot_access_admin_stories(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.stories.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_view_stories_list(): void
    {
        $admin = User::factory()->admin()->create();
        $story = SuccessStory::factory()->create([
            'names' => 'Nusrat & Shahriar Kabir',
            'titles' => 'Surgeon & Fintech Founder',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.stories.index'));

        $response->assertStatus(200);
        $response->assertSee('Success Stories Catalog');
        $response->assertSee('Nusrat &amp; Shahriar Kabir', false);
        $response->assertSee('Surgeon &amp; Fintech Founder', false);
    }

    public function test_admin_can_filter_stories_by_search_and_status(): void
    {
        $admin = User::factory()->admin()->create();

        $matchingStory = SuccessStory::factory()->create([
            'names' => 'Zeba & Farhan Choudhury',
            'locations' => 'DOHS Banani & London',
            'is_active' => true,
        ]);

        $otherStory = SuccessStory::factory()->create([
            'names' => 'Sabrina & Arif Hasan',
            'locations' => 'Khulshi, Chattogram',
            'is_active' => false,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.stories.index', [
            'search' => 'Banani',
            'status' => 'active',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Zeba &amp; Farhan Choudhury', false);
        $response->assertDontSee('Sabrina &amp; Arif Hasan', false);
    }

    public function test_admin_can_view_create_story_form(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.stories.create'));

        $response->assertStatus(200);
        $response->assertSee('Couple &amp; Nuptial Identity', false);
        $response->assertSee('Publish Success Story');
    }

    public function test_admin_can_store_new_story_with_image_url(): void
    {
        $admin = User::factory()->admin()->create();

        $data = [
            'names' => 'Ayesha & Salman Khan',
            'titles' => 'Diplomat & Managing Director',
            'locations' => 'Gulshan-2, Dhaka & Geneva',
            'year' => 'Married at Senakunj, Dhaka • Nov 2025',
            'quote' => 'A beautifully managed matchmaking process with extraordinary discretion.',
            'image_url' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80',
            'sort_order' => 10,
            'is_featured' => '1',
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->post(route('admin.stories.store'), $data);

        $response->assertRedirect(route('admin.stories.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('success_stories', [
            'names' => 'Ayesha & Salman Khan',
            'titles' => 'Diplomat & Managing Director',
            'locations' => 'Gulshan-2, Dhaka & Geneva',
            'year' => 'Married at Senakunj, Dhaka • Nov 2025',
            'is_featured' => true,
            'is_active' => true,
        ]);
    }

    public function test_admin_can_store_new_story_with_uploaded_file(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $file = UploadedFile::fake()->image('couple.jpg', 800, 800);

        $data = [
            'names' => 'Maliha & Dr. Tanvir',
            'titles' => 'Architect & Cardiothoracic Surgeon',
            'locations' => 'Uttara & Toronto',
            'year' => 'Married at Radisson Blu • Dec 2024',
            'quote' => 'Remarkable service and impeccable etiquette.',
            'image_file' => $file,
            'sort_order' => 2,
            'is_featured' => '0',
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->post(route('admin.stories.store'), $data);

        $response->assertRedirect(route('admin.stories.index'));

        $story = SuccessStory::where('names', 'Maliha & Dr. Tanvir')->first();
        $this->assertNotNull($story);
        $this->assertStringStartsWith('stories/', $story->raw_image);
        Storage::disk('public')->assertExists($story->raw_image);
    }

    public function test_admin_can_view_edit_story_form(): void
    {
        $admin = User::factory()->admin()->create();
        $story = SuccessStory::factory()->create(['names' => 'Sadia & Rehan']);

        $response = $this->actingAs($admin)->get(route('admin.stories.edit', $story));

        $response->assertStatus(200);
        $response->assertSee('Edit Story: Sadia &amp; Rehan', false);
        $response->assertSee('Save Story Changes');
    }

    public function test_admin_can_update_story(): void
    {
        $admin = User::factory()->admin()->create();
        $story = SuccessStory::factory()->create([
            'names' => 'Old Names',
            'quote' => 'Old quote',
        ]);

        $response = $this->actingAs($admin)->put(route('admin.stories.update', $story), [
            'names' => 'Updated Couple Names',
            'titles' => 'Updated Titles',
            'locations' => 'Updated Locations',
            'year' => 'Married at Senakunj • Oct 2025',
            'quote' => 'Brand new testimonial quote for the couple.',
            'sort_order' => 1,
            'is_featured' => '1',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.stories.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('success_stories', [
            'id' => $story->id,
            'names' => 'Updated Couple Names',
            'quote' => 'Brand new testimonial quote for the couple.',
        ]);
    }

    public function test_admin_can_update_story_via_post_fallback(): void
    {
        $admin = User::factory()->admin()->create();
        $story = SuccessStory::factory()->create([
            'names' => 'Initial Couple',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.stories.update.post', $story), [
            'names' => 'Direct POST Update Couple',
            'titles' => 'Titles Test',
            'locations' => 'Locations Test',
            'year' => 'Wedding 2025',
            'quote' => 'Test quote',
            'sort_order' => 1,
            'is_featured' => '0',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.stories.index'));

        $this->assertDatabaseHas('success_stories', [
            'id' => $story->id,
            'names' => 'Direct POST Update Couple',
        ]);
    }

    public function test_admin_can_toggle_story_active_status(): void
    {
        $admin = User::factory()->admin()->create();
        $story = SuccessStory::factory()->create(['is_active' => true]);

        $response = $this->actingAs($admin)->post(route('admin.stories.toggle-active', $story));

        $response->assertRedirect();
        $this->assertFalse($story->fresh()->is_active);

        // Toggle back
        $response = $this->actingAs($admin)->post(route('admin.stories.toggle-active', $story));

        $response->assertRedirect();
        $this->assertTrue($story->fresh()->is_active);
    }

    public function test_admin_can_toggle_story_featured_status(): void
    {
        $admin = User::factory()->admin()->create();
        $story = SuccessStory::factory()->create(['is_featured' => false]);

        $response = $this->actingAs($admin)->post(route('admin.stories.toggle-featured', $story));

        $response->assertRedirect();
        $this->assertTrue($story->fresh()->is_featured);

        // Toggle back
        $response = $this->actingAs($admin)->post(route('admin.stories.toggle-featured', $story));

        $response->assertRedirect();
        $this->assertFalse($story->fresh()->is_featured);
    }

    public function test_admin_can_delete_story(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $file = UploadedFile::fake()->image('story_to_delete.jpg');
        $storedPath = $file->store('stories', 'public');

        $story = SuccessStory::factory()->create([
            'image' => $storedPath,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.stories.destroy', $story));

        $response->assertRedirect(route('admin.stories.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('success_stories', ['id' => $story->id]);
        Storage::disk('public')->assertMissing($storedPath);
    }

    public function test_admin_story_show_route_redirects_to_edit(): void
    {
        $admin = User::factory()->admin()->create();
        $story = SuccessStory::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.stories.show', $story));

        $response->assertRedirect(route('admin.stories.edit', $story));
    }

    public function test_public_stories_page_displays_database_stories(): void
    {
        $story = SuccessStory::factory()->create([
            'names' => 'Tahsin & Rawnak Jahan',
            'titles' => 'Investment Banker & Lawyer',
            'locations' => 'Baridhara, Dhaka',
            'is_active' => true,
        ]);

        $response = $this->get(route('stories'));

        $response->assertStatus(200);
        $response->assertSee('Tahsin &amp; Rawnak Jahan', false);
        $response->assertSee('Investment Banker &amp; Lawyer', false);
        $response->assertSee('Baridhara, Dhaka');
    }

    public function test_public_home_page_displays_database_stories(): void
    {
        $story = SuccessStory::factory()->create([
            'names' => 'Fariha & Mehdi Hasan',
            'titles' => 'Doctor & Software VP',
            'is_active' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Fariha &amp; Mehdi Hasan', false);
    }
}
