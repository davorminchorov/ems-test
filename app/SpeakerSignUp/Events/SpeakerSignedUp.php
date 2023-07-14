<?php

declare(strict_types=1);

namespace App\SpeakerSignUp\Events;

final readonly class SpeakerSignedUp
{
    public function __construct(
        public string $name,
        public string $email,
        public string $bio
    ) {

    }
}
