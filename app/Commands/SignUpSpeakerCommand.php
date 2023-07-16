<?php

declare(strict_types=1);

namespace App\Commands;

final readonly class SignUpSpeakerCommand
{
    public function __construct(
        public string $name,
        public string $email,
        public string $bio
    ) {

    }
}
