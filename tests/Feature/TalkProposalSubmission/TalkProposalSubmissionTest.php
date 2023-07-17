<?php

declare(strict_types=1);

namespace Tests\Feature\TalkProposalSubmission;

use App\Exceptions\TalkProposalCannotBeSubmittedWithoutSpeakerProfile;
use App\Models\Speaker;
use App\Models\TalkProposal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class TalkProposalSubmissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function a_speaker_can_submit_a_talk_proposal(): void
    {
        $user = User::factory()->create();
        $speaker = Speaker::factory()->create([
            'user_id' => $user->id,
        ]);

        $talkProposal = TalkProposal::factory()->make();

        $response = $this->actingAs($user)
            ->from(route('talk-proposals.submission-page'))
            ->post(route('talk-proposals.submit'), [
                'title' => $talkProposal->title,
                'abstract' => $talkProposal->abstract,
                'preferred_time_slot' => $talkProposal->preferred_time_slot,
            ])
            ->assertRedirect('/dashboard')
            ->assertSessionHas('status', __('Your talk proposal was submitted successfully!'));

        $this->assertDatabaseHas($talkProposal->getTable(), $talkProposal->getAttributes());
    }

    /**
     * @test
     */
    public function a_talk_proposal_cannot_be_submitted_without_a_speaker_profile(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(TalkProposalCannotBeSubmittedWithoutSpeakerProfile::class);

        $user = User::factory()->create();
        $talkProposal = TalkProposal::factory()->make();

        $response = $this->actingAs($user)
            ->from(route('talk-proposals.submission-page'))
            ->followingRedirects()
            ->post(route('talk-proposals.submit'), [
                'title' => $talkProposal->title,
                'abstract' => $talkProposal->abstract,
                'preferred_time_slot' => $talkProposal->preferred_time_slot,
            ]);

        $this->assertDatabaseMissing($talkProposal->getTable(), $talkProposal->getAttributes());
    }

    /**
     * @test
     *
     * @dataProvider talkProposalSubmissionValidationDataProvider
     */
    public function check_talk_proposal_submission_validation_errors(string $field, mixed $value): void
    {
        $user = User::factory()->create();
        $speaker = Speaker::factory()->make();
        $talkProposal = TalkProposal::factory()->make();

        $response = $this->actingAs($user)
            ->from(route('talk-proposals.submission-page'))
            ->followingRedirects()
            ->post(route('talk-proposals.submit'), [
                'title' => $talkProposal->title,
                'abstract' => $talkProposal->abstract,
                'preferred_time_slot' => $talkProposal->preferred_time_slot,
                $field => $value,
            ]);

        $this->assertDatabaseMissing($talkProposal->getTable(), $talkProposal->getAttributes());
    }

    /**
     * The data provider for the login validation errors.
     */
    public static function talkProposalSubmissionValidationDataProvider(): array
    {
        return [
            'The title field is required' => ['title', ''],
            'The title may not be greater than 200 characters' => [
                'title',
                str_repeat(string: 'a', times: 210),
            ],
            'The abstract field is required' => ['abstract', ''],
            'The abstract may not be less than 10 characters' => [
                'abstract',
                str_repeat(string: 'a', times: 9),
            ],
            'The abstract may not be greater than 1000 characters' => [
                'abstract',
                str_repeat(string: 'a', times: 1100),
            ],
            'The preferred time slot field is required' => ['preferred_time_slot', ''],
            'The preferred time slot should be in the time format of H:i:s' => [
                'preferred_time_slot',
                'aa:aa:aa',
            ],
        ];
    }
}
