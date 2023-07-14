<?php

declare(strict_types=1);

namespace Tests\Feature\SpeakerSignUp;

use App\Models\UserAuthentication;
use App\SpeakerSignUp\Exceptions\EmailAddressAlreadyExists;
use App\SpeakerSignUp\Models\Speaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

final class SpeakerSignUpTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function a_speaker_can_sign_up(): void
    {
        $user = UserAuthentication::factory()->create();
        $speaker = Speaker::factory()->make();

        $response = $this->actingAs($user)
            ->from(route('speakers.sign-up-page'))
            ->followingRedirects()->post(route('speakers.sign-up'), [
                'name' => $speaker->name,
                'email' => $speaker->email,
                'bio' => $speaker->bio,
            ]);

        $this->assertDatabaseHas($speaker->getTable(), $speaker->getAttributes());

        $response->assertOk();

        $response->assertSeeText('Dashboard');
    }


    /**
     * @test
     */
    public function a_speaker_cannot_sign_up_if_the_email_address_already_exists(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(EmailAddressAlreadyExists::class);

        $user = UserAuthentication::factory()->create();
        $email = 'something@gmail.com';
        $speakerWithExistingEmail = Speaker::factory()->create(['email' => $email, 'user_id' => $user->id]);
        $speaker = Speaker::factory()->make(['email' => $email]);

        $response = $this->actingAs($user)
            ->from(route('speakers.sign-up-page'))
            ->followingRedirects()
            ->post(route('speakers.sign-up'), [
                'name' => $speaker->name,
                'email' => $speaker->email,
                'bio' => $speaker->bio,
            ]);

        $this->assertDatabaseMissing($speaker->getTable(), $speaker->getAttributes());
    }
    
    /**
     * @test
     *
     * @dataProvider speakerSignUpValidationDataProvider
     */
    public function check_speaker_sign_up_validation_errors(string $field, mixed $value): void
    {
        $user = UserAuthentication::factory()->create();
        $speaker = Speaker::factory()->make();

        $response = $this->actingAs($user)
            ->from(route('speakers.sign-up-page'))
            ->followingRedirects()
            ->post(route('speakers.sign-up'), [
                'name' => $speaker->name,
                'email' => $speaker->email,
                'bio' => $speaker->bio,
                $field => $value,
            ]);

        $this->assertDatabaseMissing($speaker->getTable(), $speaker->getAttributes());
    }

    /**
     * The data provider for the login validation errors.
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
        ];
    }
}
