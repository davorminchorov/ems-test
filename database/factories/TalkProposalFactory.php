<?php

namespace Database\Factories;

use App\Models\TalkProposal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TalkProposal>
 */
class TalkProposalFactory extends Factory
{
    protected $model = TalkProposal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(5, true),
            'abstract' => $this->faker->paragraphs(2, true),
            'preferred_time_slot' => $this->faker->time(),
        ];
    }
}
