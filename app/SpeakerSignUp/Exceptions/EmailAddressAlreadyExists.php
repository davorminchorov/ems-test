<?php

namespace App\SpeakerSignUp\Exceptions;

use Symfony\Component\HttpFoundation\Response;

final class EmailAddressAlreadyExists extends \Exception
{
    public function __construct()
    {
        parent::__construct(
            'The email address is already taken.',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
