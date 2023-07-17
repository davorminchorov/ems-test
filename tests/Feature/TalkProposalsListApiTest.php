<?php

namespace Tests\Feature;

use App\Models\Speaker;
use App\Models\TalkProposal;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TalkProposalsListApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_display_a_list_of_talk_proposals_ordered_by_preferred_time_slot(): void
    {
        $talkProposals = TalkProposal::factory()
            ->times(5)
            ->for(Speaker::factory()->for(User::factory())->create())
            ->create();

        $response = $this->getJson(route('api.v1.talk-proposals-list'));

        $response->assertJsonFragment($this->talkProposalsJsonResponseStructure($talkProposals));

        $response->assertOk();
    }

    private function talkProposalsJsonResponseStructure(Collection $talkProposals): array
    {
        return [
            'data' => $talkProposals->map(function (TalkProposal $talkProposal) {
                return [
                    'id' => $talkProposal->id,
                    'title' => $talkProposal->title,
                    'abstract' => $talkProposal->abstract,
                    'preferred_time_slot' => $talkProposal->preferred_time_slot,
                    'speaker' => [
                        'id' => $talkProposal->speaker->id,
                        'name' => $talkProposal->speaker->name,
                        'bio' => $talkProposal->speaker->bio,
                    ],
                    'created_at' => $talkProposal->created_at,
                ];
            })->toArray(),
        ];
    }
}
