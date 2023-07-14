<?php

declare(strict_types=1);

namespace Tests\Feature\SpeakerSignUp;

use App\Models\UserAuthentication;
use App\SpeakerSignUp\Commands\SignUpSpeakerCommand;
use App\SpeakerSignUp\Events\SpeakerSignedUp;
use App\SpeakerSignUp\Models\Speaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

final class SpeakerSignUpTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     * @return void
     */
    public function a_speaker_can_sign_up(): void
    {
        Bus::fake();
        Event::fake();

        $user = UserAuthentication::factory()->create();
        $speaker = Speaker::factory()->make();

        $response = $this->actingAs($user)->from(route('speakers.sign-up-page'))->followingRedirects()->post(route('speakers.sign-up'), [
            'name' => $speaker->name,
            'email' => $speaker->email,
            'bio' => $speaker->bio,
        ]);

        Bus::assertDispatched(SignUpSpeakerCommand::class);

        Event::assertDispatched(SpeakerSignedUp::class);

        $this->assertDatabaseHas($speaker->getTable(), $speaker->getAttributes());

        $response->assertCreated();

        $response->assertSeeText('Dashboard');
    }


    /**
     * @test
     * @dataProvider speakerSignUpValidationDataProvider
     *
     * @param string $field
     * @param mixed $value
     *
     * @return void
     */
    public function check_speaker_sign_up_validation_errors(string $field, mixed $value): void
    {
        Bus::fake();
        Event::fake();

        $user = UserAuthentication::factory()->create();
        $speaker = Speaker::factory()->make();

        $response = $this->actingAs($user)->from(route('speakers.sign-up-page'))->followingRedirects()->post(route('speakers.sign-up'), [
            'name' => $speaker->name,
            'email' => 'test@example.com',
            'bio' => $speaker->bio,
            $field => $value,
        ]);

        Bus::assertNotDispatched(SignUpSpeakerCommand::class);

        Event::assertNotDispatched(SpeakerSignedUp::class);

        $this->assertDatabaseMissing($speaker->getTable(), $speaker->getAttributes());
    }

    /**
     * The data provider for the login validation errors.
     *
     * @return array
     */
    public static function speakerSignUpValidationDataProvider(): array
    {
        return [
            'The name field is required' => ['name', ''],
            'The name may not be greater than 150 characters' => [
                'name',
                str_repeat(string: 'a', times: 160),
            ],
            'The email field is required' => ['email', ''],
            'The email may not be greater than 200 characters' => [
                'email',
                str_repeat(string: 'a', times: 210),
            ],
            'The bio field is required' => ['bio', ''],
            'The bio may not be greater than 1000 characters' => [
                'bio',
                str_repeat(string: 'a', times: 1100),
            ],
            'The email must be a valid email address (format)' => ['email', 'invalidemailaddress'],
            'The email must be a valid email address (domain)' => ['email', 'test@invaliddomainthatdoesnotexist.com'],
            'The email must be a valid email address (RFC)' => ['email', 'p[][;lp@example.com'],
            'The email has already been taken' => ['email', 'test@example.com'],

        ];
    }
}
