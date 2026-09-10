<?php

namespace Database\Factories;

use App\Models\CandidateProfile;
use App\Models\Shortlist;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Shortlist>
 */
class ShortlistFactory extends Factory
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
            'candidate_profile_id' => CandidateProfile::factory(),
        ];
    }
}
