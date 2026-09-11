<?php

namespace Tests\Feature;

use App\Models\ConsultationInquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminInquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_access_inquiries_cms(): void
    {
        $response = $this->get(route('admin.inquiries.index'));

        $response->assertRedirect('/admin/login');
    }

    public function test_non_admin_cannot_access_inquiries_cms(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.inquiries.index'));

        $response->assertStatus(403);
    }

    public function test_public_consultation_form_stores_inquiry_in_database(): void
    {
        $payload = [
            'looking_for' => 'Bride',
            'profile_for' => 'Son',
            'full_name' => 'Dr. Kamal Hossain',
            'phone' => '01712-345678',
            'email' => 'kamal@example.com',
            'city' => 'Gulshan-2, Dhaka',
            'desher_bari' => 'Sylhet',
            'preferred_package' => 'Elite Business',
            'annual_income' => '৳50 Lakhs+',
            'message' => 'Seeking an educated doctor or architect bride for my son.',
        ];

        $response = $this->post(route('consultation.submit'), $payload);

        $response->assertSessionHas('success_modal', true);
        $response->assertSessionHas('consultation_name', 'Dr. Kamal Hossain');

        $this->assertDatabaseHas('consultation_inquiries', [
            'full_name' => 'Dr. Kamal Hossain',
            'email' => 'kamal@example.com',
            'looking_for' => 'Bride',
            'profile_for' => 'Son',
            'status' => 'Pending Review',
            'preferred_package' => 'Elite Business',
        ]);

        $inquiry = ConsultationInquiry::where('email', 'kamal@example.com')->first();
        $this->assertNotNull($inquiry);
        $this->assertStringStartsWith('INQ-', $inquiry->inquiry_code);
    }

    public function test_admin_can_view_inquiries_list(): void
    {
        $admin = User::factory()->admin()->create();
        $inquiry = ConsultationInquiry::factory()->create([
            'inquiry_code' => 'INQ-9901',
            'full_name' => 'Prof. Shamsul Alam',
            'phone' => '+880 1711-223344',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.inquiries.index'));

        $response->assertStatus(200);
        $response->assertSee('VIP Consultation Pipeline');
        $response->assertSee('INQ-9901');
        $response->assertSee('Prof. Shamsul Alam');
    }

    public function test_admin_can_filter_inquiries_by_search_and_status(): void
    {
        $admin = User::factory()->admin()->create();

        $matching = ConsultationInquiry::factory()->create([
            'full_name' => 'Barrister Anisur Rahman',
            'city' => 'Banani, Dhaka',
            'status' => 'Pending Review',
        ]);

        $other = ConsultationInquiry::factory()->create([
            'full_name' => 'Mr. Jahangir Kabir',
            'city' => 'Khulshi, Chattogram',
            'status' => 'Closed',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.inquiries.index', [
            'search' => 'Anisur',
            'status' => 'Pending Review',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Barrister Anisur Rahman');
        $response->assertDontSee('Mr. Jahangir Kabir');
    }

    public function test_admin_can_fetch_inquiry_details_as_json(): void
    {
        $admin = User::factory()->admin()->create();
        $inquiry = ConsultationInquiry::factory()->create([
            'full_name' => 'Mrs. Nilufar Yasmin',
            'email' => 'nilufar@example.com',
        ]);

        $response = $this->actingAs($admin)->getJson(route('admin.inquiries.show', $inquiry));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'inquiry' => [
                'id' => $inquiry->id,
                'full_name' => 'Mrs. Nilufar Yasmin',
                'email' => 'nilufar@example.com',
            ],
        ]);
    }

    public function test_admin_can_update_inquiry_status_and_notes(): void
    {
        $admin = User::factory()->admin()->create();
        $inquiry = ConsultationInquiry::factory()->create([
            'status' => 'Pending Review',
            'admin_notes' => null,
        ]);

        $response = $this->actingAs($admin)->put(route('admin.inquiries.update', $inquiry), [
            'status' => 'In Progress',
            'preferred_package' => 'Elite Aristocrat',
            'admin_notes' => 'Spoke with father. Scheduled family meeting at Radisson.',
        ]);

        $response->assertRedirect(route('admin.inquiries.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('consultation_inquiries', [
            'id' => $inquiry->id,
            'status' => 'In Progress',
            'preferred_package' => 'Elite Aristocrat',
            'admin_notes' => 'Spoke with father. Scheduled family meeting at Radisson.',
        ]);
    }

    public function test_admin_can_quick_update_inquiry_status(): void
    {
        $admin = User::factory()->admin()->create();
        $inquiry = ConsultationInquiry::factory()->create([
            'status' => 'Pending Review',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.inquiries.update-status', $inquiry), [
            'status' => 'Verified',
        ]);

        $response->assertRedirect();
        $this->assertEquals('Verified', $inquiry->fresh()->status);
    }

    public function test_admin_can_delete_inquiry(): void
    {
        $admin = User::factory()->admin()->create();
        $inquiry = ConsultationInquiry::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.inquiries.destroy', $inquiry));

        $response->assertRedirect(route('admin.inquiries.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('consultation_inquiries', ['id' => $inquiry->id]);
    }

    public function test_dashboard_displays_database_inquiries_and_pending_count(): void
    {
        $admin = User::factory()->admin()->create();

        $inq1 = ConsultationInquiry::factory()->create([
            'inquiry_code' => 'INQ-7701',
            'full_name' => 'Ambassador Tariq Karim',
            'status' => 'Pending Review',
        ]);

        $inq2 = ConsultationInquiry::factory()->create([
            'inquiry_code' => 'INQ-7702',
            'full_name' => 'Dr. Rubana Huq',
            'status' => 'Pending Review',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('INQ-7701');
        $response->assertSee('Ambassador Tariq Karim');
        $response->assertSee('INQ-7702');
        $response->assertSee('Dr. Rubana Huq');
    }

    public function test_admin_inquiry_client_column_and_direct_contact_buttons(): void
    {
        $admin = User::factory()->admin()->create();

        $inquiry = ConsultationInquiry::factory()->create([
            'full_name' => 'Engineer Rafiqul Islam',
            'profile_for' => 'Son',
            'phone' => '01712-345678',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.inquiries.index'));

        $response->assertStatus(200);

        // Client / Guardian column: inline icon + name and borderless "For Son"
        $response->assertSee('client-name-highlight');
        $response->assertSee('Engineer Rafiqul Islam');
        $response->assertSee('client-relation-text');
        $response->assertSee('For Son');

        // Phone & Direct Contact column: call and whatsapp action buttons
        $response->assertSee('btn-action-icon call', false);
        $response->assertSee('tel:01712345678', false);
        $response->assertSee('btn-action-icon whatsapp', false);
        $response->assertSee('https://wa.me/8801712345678', false);
    }
}
