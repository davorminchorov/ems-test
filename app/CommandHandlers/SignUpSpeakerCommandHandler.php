<?php

namespace App\CommandHandlers;

use App\Commands\SignUpSpeakerCommand;
use App\Events\SpeakerSignedUp;
use App\Exceptions\EmailAddressAlreadyExists;
use App\Models\Speaker;
use Illuminate\Events\Dispatcher;

final readonly class SignUpSpeakerCommandHandler
{
    public function __construct(private Speaker $speaker, private Dispatcher $eventDispatcher)
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
            $signUpSpeakerCommand->userId,
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
