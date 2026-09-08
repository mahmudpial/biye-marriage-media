<?php

namespace Database\Factories;

use App\Models\CandidateProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CandidateProfile>
 */
class CandidateProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['male', 'female']);
        $code = 'BD-ELT-'.fake()->unique()->numberBetween(1000, 9999);

        return [
            'profile_code' => $code,
            'gender' => $gender,
            'age' => fake()->numberBetween(24, 38),
            'height' => fake()->randomElement(["5'3\"", "5'5\"", "5'7\"", "5'10\"", "6'0\""]),
            'religion' => 'Islam (Sunni)',
            'desher_bari' => fake()->randomElement(['Dhaka', 'Chattogram', 'Sylhet', 'Cumilla', 'Mymensingh']),
            'education' => fake()->randomElement(['BSc in CSE (BUET)', 'MBBS (DMC)', 'BBA from IBA', 'Bar-at-Law']),
            'profession' => fake()->randomElement(['Software Architect', 'Resident Physician', 'Assistant Commissioner (BCS)', 'Investment Banker']),
            'location' => fake()->randomElement(['Gulshan-2, Dhaka', 'Banani, Dhaka', 'Baridhara DOHS', 'Khulshi, Chattogram']),
            'income' => fake()->randomElement(['৳30 Lakhs+', '৳50 Lakhs+', '৳1.2 Crore+']),
            'category' => fake()->randomElement(['Elite Professional', 'Elite Business', 'Elite Aristocrat']),
            'family' => fake()->sentence(8),
            'image' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80',
            'is_discreet' => fake()->boolean(70),
            'is_featured' => fake()->boolean(30),
            'is_active' => true,
        ];
    }
}
