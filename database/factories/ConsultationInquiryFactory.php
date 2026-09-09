<?php

namespace Database\Factories;

use App\Models\ConsultationInquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ConsultationInquiry>
 */
class ConsultationInquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $relations = ['Daughter', 'Son', 'Self', 'Brother', 'Sister', 'Family Member'];
        $packages = ['Elite Professional', 'Elite Business', 'Elite Aristocrat'];
        $statuses = ['Pending Review', 'In Progress', 'Contacted', 'Verified'];
        $districts = ['Sylhet', 'Chattogram', 'Dhaka', 'Cumilla', 'Mymensingh', 'Rajshahi', 'Noakhali'];
        $locations = ['Gulshan-2, Dhaka', 'Banani, Dhaka', 'DOHS Baridhara', 'Uttara Sec-4', 'Khulshi, Chattogram', 'Toronto / Dhaka'];

        return [
            'inquiry_code' => 'INQ-'.fake()->unique()->numberBetween(1000, 9999),
            'looking_for' => fake()->randomElement(['Bride', 'Groom']),
            'profile_for' => fake()->randomElement($relations),
            'full_name' => fake()->name(),
            'phone' => '+880 1'.fake()->numberBetween(3, 9).fake()->numberBetween(10, 99).'-'.fake()->numberBetween(100000, 999999),
            'email' => fake()->safeEmail(),
            'city' => fake()->randomElement($locations),
            'desher_bari' => fake()->randomElement($districts),
            'preferred_package' => fake()->randomElement($packages),
            'annual_income' => '৳'.fake()->numberBetween(30, 90).' Lakhs+',
            'message' => fake()->sentence(12),
            'status' => fake()->randomElement($statuses),
            'admin_notes' => null,
        ];
    }

    /**
     * Indicate that the inquiry is pending review.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Pending Review',
        ]);
    }

    /**
     * Indicate that the inquiry is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'In Progress',
        ]);
    }

    /**
     * Indicate that the inquiry is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Verified',
        ]);
    }

    /**
     * Indicate that the inquiry is closed.
     */
    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Closed',
        ]);
    }
}
