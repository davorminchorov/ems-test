<?php

namespace App\SpeakerSignUp\CommandHandlers;

use App\SpeakerSignUp\Commands\SignUpSpeakerCommand;
use App\SpeakerSignUp\Models\Speaker;
use Illuminate\Contracts\Auth\Factory;

final readonly class SignUpSpeakerCommandHandler
{
    public function __construct(public Factory $authenticationFactory)
    {

    }

    public function handle(SignUpSpeakerCommand $signUpSpeakerCommand): Speaker
    {
        return Speaker::signUp(
            $this->authenticationFactory->guard('web')->id(),
            $signUpSpeakerCommand->name,
            $signUpSpeakerCommand->email,
            $signUpSpeakerCommand->bio
        );
    }
}
