<?php

namespace App\Providers;

use App\SpeakerSignUp\CommandHandlers\SignUpSpeakerCommandHandler;
use App\SpeakerSignUp\Commands\SignUpSpeakerCommand;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

class CommandBusServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Bus::map([
            SignUpSpeakerCommand::class => SignUpSpeakerCommandHandler::class,
        ]);
    }
}
