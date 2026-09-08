<?php

namespace Database\Factories;

use App\Models\MembershipPackage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<MembershipPackage>
 */
class MembershipPackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true).' Tier';

        return [
            'slug' => Str::slug($name),
            'name' => ucwords($name),
            'badge' => fake()->sentence(4),
            'price' => fake()->randomElement(['৳50,000 / 6 Months', '৳1,20,000 / Annual', 'Custom Concierge Quote']),
            'description' => fake()->paragraph(),
            'benefits' => [
                'Dedicated Senior Relationship Manager in Dhaka / Ctg',
                'Educational & Income verification (Annual ৳30 Lakhs+)',
                'Handpicked matches from verified aristocratic families',
                'Direct coordination with counterpart family matchmakers',
            ],
            'featured' => false,
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
