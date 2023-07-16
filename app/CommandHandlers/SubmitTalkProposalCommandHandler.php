<?php

declare(strict_types=1);

namespace App\CommandHandlers;

use App\Commands\SubmitTalkProposalCommand;
use App\Events\TalkProposalSubmitted;
use App\Exceptions\TalkProposalCannotBeSubmittedWithoutSpeakerProfile;
use App\Models\TalkProposal;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Events\Dispatcher;

final readonly class SubmitTalkProposalCommandHandler
{
    public function __construct(private Factory $authenticationFactory, private Dispatcher $eventDispatcher)
    {

    }

    /**
     * @throws TalkProposalCannotBeSubmittedWithoutSpeakerProfile
     */
    public function handle(SubmitTalkProposalCommand $talkProposalCommand): TalkProposal
    {
        $speaker = $this->authenticationFactory->guard('web')->user()->speaker;

        if (! $speaker) {
            throw new TalkProposalCannotBeSubmittedWithoutSpeakerProfile();
        }

        $talkProposal = TalkProposal::submit(
            $speaker->id,
            $talkProposalCommand->title,
            $talkProposalCommand->abstract,
            $talkProposalCommand->preferredTimeSlot
        );

        $this->eventDispatcher->dispatch(
            new TalkProposalSubmitted(
                $speaker->name,
                $speaker->bio,
                $talkProposalCommand->title,
                $talkProposalCommand->abstract,
                $talkProposalCommand->preferredTimeSlot
            )
        );

        return $talkProposal;
    }
}
