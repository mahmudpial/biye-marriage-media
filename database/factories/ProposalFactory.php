<?php

namespace Database\Factories;

use App\Models\CandidateProfile;
use App\Models\Proposal;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Proposal>
 */
class ProposalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sender_user_id' => User::factory(),
            'sender_profile_id' => CandidateProfile::factory(),
            'receiver_profile_id' => CandidateProfile::factory(),
            'status' => Proposal::STATUS_PENDING,
            'is_matchmaker_suggested' => false,
            'sender_message' => fake()->sentence(),
        ];
    }
}
