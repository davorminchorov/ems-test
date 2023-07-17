<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Commands\SignUpSpeakerCommand;
use App\Http\Requests\SpeakerSignUpRequest;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\RedirectResponse;

final readonly class SpeakerSignUpController
{
    public function __construct(private Dispatcher $dispatcher, private Factory $authenticationFactory, private Session $session)
    {

    }

    public function __invoke(SpeakerSignUpRequest $request): RedirectResponse
    {
        $this->dispatcher->dispatch(
            new SignUpSpeakerCommand(
                $this->authenticationFactory->guard('web')->id(),
                $request->get('name'),
                $request->get('email'),
                $request->get('bio'),
            )
        );

        $this->session->flash('status', __('You signed up as a speaker successfully!'));

        return new RedirectResponse('dashboard');
    }
}
