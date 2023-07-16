<?php

declare(strict_types=1);

namespace App\Commands;

final readonly class SubmitTalkProposalCommand
{
    public function __construct(
        public string $title,
        public string $abstract,
        public string $preferredTimeSlot
    ) {

    }
}
