<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserSubscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserSubscription>
 */
class UserSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'package_id' => null,
            'package_name' => 'Complimentary Access',
            'price_paid' => 0.00,
            'proposals_quota' => 5,
            'proposals_used' => 0,
            'contact_views_quota' => 0,
            'contact_views_used' => 0,
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => now()->addMonths(6),
        ];
    }
}
