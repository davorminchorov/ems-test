<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

final class TalkProposalCannotBeSubmittedWithoutSpeakerProfile extends \Exception
{
    public function __construct()
    {
        parent::__construct(
            'A talk proposal cannot be submitted without a speaker profile.',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
