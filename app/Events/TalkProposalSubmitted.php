<?php

declare(strict_types=1);

namespace App\Events;

final readonly class TalkProposalSubmitted
{
    public function __construct(
        public string $speakerName,
        public string $speakerBio,
        public string $title,
        public string $abstract,
        public string $preferredTimeSlot
    ) {

    }
}
