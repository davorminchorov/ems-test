<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Commands\SubmitTalkProposalCommand;
use App\Http\Requests\TalkProposalSubmissionRequest;
use Illuminate\Bus\Dispatcher;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\RedirectResponse;

final readonly class TalkProposalSubmissionController
{
    public function __construct(private Dispatcher $dispatcher, private Session $session)
    {

    }

    public function __invoke(TalkProposalSubmissionRequest $request): RedirectResponse
    {
        $this->dispatcher->dispatch(
            new SubmitTalkProposalCommand(
                $request->get('title'),
                $request->get('abstract'),
                $request->get('preferred_time_slot'),
            )
        );

        $this->session->flash('status', __('The talk proposal was submitted successfully!'));

        return new RedirectResponse('dashboard');
    }
}
