<?php

namespace App\Listeners;

use App\Events\SpeakerSignedUp;

class SendSignUpConfirmationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SpeakerSignedUp $event): void
    {
        //
    }
}
