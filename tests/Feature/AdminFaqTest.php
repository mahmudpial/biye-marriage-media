<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFaqTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_admin_faqs(): void
    {
        $response = $this->get(route('admin.faqs.index'));

        $response->assertRedirect('/admin/login');
    }

    public function test_non_admin_cannot_access_admin_faqs(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.faqs.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_view_faqs_list(): void
    {
        $admin = User::factory()->admin()->create();
        $faq = Faq::factory()->create([
            'question' => 'How does Biye Marriage Media ensure complete confidentiality in Bangladesh?',
            'answer' => 'We practice strict blind matchmaking for high society families.',
            'category' => 'Confidentiality',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.faqs.index'));

        $response->assertStatus(200);
        $response->assertSee('Publish New FAQ');
        $response->assertSee('How does Biye Marriage Media ensure complete confidentiality in Bangladesh?', false);
        $response->assertSee('Confidentiality &amp; Discretion', false);
    }

    public function test_admin_can_filter_faqs_by_search_keyword(): void
    {
        $admin = User::factory()->admin()->create();

        $matchingFaq = Faq::factory()->create([
            'question' => 'What is the background check for Gulshan candidates?',
            'answer' => 'We verify National ID, passport, and family lineage.',
        ]);

        $otherFaq = Faq::factory()->create([
            'question' => 'How do NRB consultations work overseas?',
            'answer' => 'Desks operate in London and New York.',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.faqs.index', [
            'search' => 'Gulshan',
        ]));

        $response->assertStatus(200);
        $response->assertSee('What is the background check for Gulshan candidates?', false);
        $response->assertDontSee('How do NRB consultations work overseas?', false);
    }

    public function test_admin_can_filter_faqs_by_category(): void
    {
        $admin = User::factory()->admin()->create();

        $nrbFaq = Faq::factory()->create([
            'question' => 'Can overseas families in London register?',
            'category' => 'NRB Matchmaking',
        ]);

        $shariahFaq = Faq::factory()->create([
            'question' => 'Is Deen-conscious matchmaking supported?',
            'category' => 'Values & Shariah',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.faqs.index', [
            'category' => 'NRB Matchmaking',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Can overseas families in London register?', false);
        $response->assertDontSee('Is Deen-conscious matchmaking supported?', false);
    }

    public function test_admin_can_filter_faqs_by_status(): void
    {
        $admin = User::factory()->admin()->create();

        $activeFaq = Faq::factory()->create([
            'question' => 'Are biodata shared publicly online?',
            'is_active' => true,
        ]);

        $draftFaq = Faq::factory()->create([
            'question' => 'Draft question under review',
            'is_active' => false,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.faqs.index', [
            'status' => 'inactive',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Draft question under review', false);
        $response->assertDontSee('Are biodata shared publicly online?', false);
    }

    public function test_admin_can_view_create_faq_form(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.faqs.create'));

        $response->assertStatus(200);
        $response->assertSee('Publish New Matrimonial FAQ');
        $response->assertSee('Frequently Asked Question');
        $response->assertSee('Detailed Answer &amp; Policy Clarification', false);
    }

    public function test_admin_can_create_new_faq_with_valid_data(): void
    {
        $admin = User::factory()->admin()->create();

        $payload = [
            'question' => 'How are family meetings scheduled at 5-star hotels in Dhaka?',
            'answer' => 'Our Relationship Manager reserves private salons at Radisson Blu or Westin upon mutual consent.',
            'category' => 'General',
            'sort_order' => 10,
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->post(route('admin.faqs.store'), $payload);

        $response->assertRedirect(route('admin.faqs.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('faqs', [
            'question' => 'How are family meetings scheduled at 5-star hotels in Dhaka?',
            'category' => 'General',
            'sort_order' => 10,
            'is_active' => 1,
        ]);
    }

    public function test_faq_creation_validation_requires_mandatory_fields(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.faqs.store'), [
            'question' => '',
            'answer' => '',
            'category' => '',
        ]);

        $response->assertSessionHasErrors(['question', 'answer', 'category']);
        $this->assertEquals(0, Faq::count());
    }

    public function test_admin_can_view_edit_faq_form(): void
    {
        $admin = User::factory()->admin()->create();
        $faq = Faq::factory()->create([
            'question' => 'What is the consultation fee structure?',
            'category' => 'Membership & Fees',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.faqs.edit', $faq));

        $response->assertStatus(200);
        $response->assertSee('Edit FAQ');
        $response->assertSee('What is the consultation fee structure?');
    }

    public function test_admin_can_update_existing_faq(): void
    {
        $admin = User::factory()->admin()->create();
        $faq = Faq::factory()->create([
            'question' => 'Old Question Title',
            'answer' => 'Old answer text',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $payload = [
            'question' => 'Updated Question: Pedigree Verification Standards',
            'answer' => 'Updated answer: Comprehensive educational and corporate credentials.',
            'category' => 'Verification',
            'sort_order' => 5,
            'is_active' => '1',
        ];

        $response = $this->actingAs($admin)->put(route('admin.faqs.update', $faq), $payload);

        $response->assertRedirect(route('admin.faqs.index'));
        $response->assertSessionHas('success');

        $faq->refresh();
        $this->assertEquals('Updated Question: Pedigree Verification Standards', $faq->question);
        $this->assertEquals('Verification', $faq->category);
        $this->assertEquals(5, $faq->sort_order);
    }

    public function test_admin_can_delete_faq(): void
    {
        $admin = User::factory()->admin()->create();
        $faq = Faq::factory()->create([
            'question' => 'Temporary Question to be deleted',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.faqs.destroy', $faq));

        $response->assertRedirect(route('admin.faqs.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('faqs', [
            'id' => $faq->id,
        ]);
    }

    public function test_admin_can_toggle_faq_active_status(): void
    {
        $admin = User::factory()->admin()->create();
        $faq = Faq::factory()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.faqs.toggle-active', $faq));

        $response->assertRedirect(route('admin.faqs.index'));
        $this->assertFalse($faq->fresh()->is_active);

        // Toggle back to true
        $this->actingAs($admin)->post(route('admin.faqs.toggle-active', $faq));
        $this->assertTrue($faq->fresh()->is_active);
    }

    public function test_admin_can_toggle_faq_active_status_via_json(): void
    {
        $admin = User::factory()->admin()->create();
        $faq = Faq::factory()->create([
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->postJson(route('admin.faqs.toggle-active', $faq));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_active' => false,
        ]);
    }

    public function test_public_home_page_renders_active_faqs_from_database(): void
    {
        $faq = Faq::factory()->create([
            'question' => 'How does Biye Marriage Media protect high-profile family privacy in Dhaka?',
            'answer' => 'All profile discussions occur under strict bilateral non-disclosure agreements.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('How does Biye Marriage Media protect high-profile family privacy in Dhaka?');
        $response->assertSee('All profile discussions occur under strict bilateral non-disclosure agreements.');
    }

    public function test_public_home_page_does_not_render_inactive_faqs(): void
    {
        $activeFaq = Faq::factory()->create([
            'question' => 'Active Question for Homepage Display',
            'is_active' => true,
        ]);

        $inactiveFaq = Faq::factory()->create([
            'question' => 'Confidential Unpublished Draft Question',
            'is_active' => false,
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Active Question for Homepage Display');
        $response->assertDontSee('Confidential Unpublished Draft Question');
    }
}
