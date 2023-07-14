<?php

declare(strict_types=1);

namespace App\SpeakerSignUp\Http\Controllers;

use App\SpeakerSignUp\Commands\SignUpSpeakerCommand;
use App\SpeakerSignUp\Http\Requests\SpeakerSignUpRequest;
use Illuminate\Contracts\Bus\Dispatcher;

final readonly class SpeakerSignUpController
{
    public function __construct(private Dispatcher $dispatcher)
    {

    }

    public function __invoke(SpeakerSignUpRequest $request)
    {
        $this->dispatcher->dispatch(
            new SignUpSpeakerCommand(
                $request->get('name'),
                $request->get('email'),
                $request->get('bio'),
            )
        );

        return back()->with('speaker', 'speaker-signed-up');
    }
}
