<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

final readonly class SpeakerSignUpPageController
{
    public function __construct(private Factory $viewFactory)
    {

    }

    public function __invoke(): View
    {
        return $this->viewFactory->make('speakers.sign-up');
    }
}
