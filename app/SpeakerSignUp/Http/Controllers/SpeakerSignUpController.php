<?php

declare(strict_types=1);

namespace App\SpeakerSignUp\Http\Controllers;

use App\SpeakerSignUp\Commands\SignUpSpeakerCommand;
use App\SpeakerSignUp\Http\Requests\SpeakerSignUpRequest;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class SpeakerSignUpController
{
    public function __construct(private Dispatcher $dispatcher, private UrlGenerator $urlGenerator)
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

        return (new RedirectResponse(
            $this->urlGenerator->route('dashboard'),
            Response::HTTP_CREATED,
        ))->with('speaker', 'speaker-signed-up');
    }
}
