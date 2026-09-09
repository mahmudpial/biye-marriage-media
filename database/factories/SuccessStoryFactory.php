<?php

namespace Database\Factories;

use App\Models\SuccessStory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SuccessStory>
 */
class SuccessStoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $groom = fake()->firstNameMale().' '.fake()->lastName();
        $bride = fake()->firstNameFemale().' '.fake()->lastName();

        $titles = [
            'Barrister & RMG Director',
            'Cardiologist & Tech Entrepreneur',
            'Civil Service (BCS) & Architect',
            'VP at Investment Bank & Corporate Lawyer',
            'AI Researcher & Senior Consultant',
        ];

        $locations = [
            'Gulshan-2, Dhaka & London',
            'Banani, Dhaka & Singapore',
            'DOHS Baridhara, Dhaka & Toronto',
            'Khulshi, Chattogram & Dubai',
            'Sylhet & San Francisco',
        ];

        $venues = [
            'Married at Senakunj, Dhaka',
            'Married at Radisson Blu Water Garden',
            'Married at The Westin Dhaka',
            'Married at Radisson Blu Bay View, Ctg',
            'Married at Rose View Hotel, Sylhet',
        ];

        return [
            'names' => "{$bride} & {$groom}",
            'titles' => fake()->randomElement($titles),
            'locations' => fake()->randomElement($locations),
            'image' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?auto=format&fit=crop&w=800&q=80',
            'quote' => 'Biye Marriage Media facilitated our union with exceptional privacy, care, and understanding of our family values.',
            'year' => fake()->randomElement($venues).' • '.fake()->monthName().' '.fake()->numberBetween(2023, 2025),
            'is_featured' => fake()->boolean(40),
            'is_active' => true,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }

    /**
     * Indicate that the story is featured on the homepage.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the story is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
