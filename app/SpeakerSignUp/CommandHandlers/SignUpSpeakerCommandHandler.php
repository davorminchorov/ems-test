<?php

namespace App\SpeakerSignUp\CommandHandlers;

use App\SpeakerSignUp\Commands\SignUpSpeakerCommand;
use App\SpeakerSignUp\Events\SpeakerSignedUp;
use App\SpeakerSignUp\Exceptions\EmailAddressAlreadyExists;
use App\SpeakerSignUp\Models\Speaker;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Events\Dispatcher;

final readonly class SignUpSpeakerCommandHandler
{
    public function __construct(private Factory $authenticationFactory, private Speaker $speaker, private Dispatcher $eventDispatcher)
    {

    }

    /**
     * @throws EmailAddressAlreadyExists
     */
    public function handle(SignUpSpeakerCommand $signUpSpeakerCommand): Speaker
    {
        $emailExists = $this->speaker->byEmail($signUpSpeakerCommand->email);

        if ($emailExists) {
            throw new EmailAddressAlreadyExists();
        }

        $speaker = Speaker::signUp(
            $this->authenticationFactory->guard('web')->id(),
            $signUpSpeakerCommand->name,
            $signUpSpeakerCommand->email,
            $signUpSpeakerCommand->bio
        );

        $this->eventDispatcher->dispatch(
            new SpeakerSignedUp(
                $signUpSpeakerCommand->name,
                $signUpSpeakerCommand->email,
                $signUpSpeakerCommand->bio
            )
        );

        return $speaker;
    }
}
