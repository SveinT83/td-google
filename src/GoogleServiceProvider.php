<?php

namespace TronderData\Google;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

final class GoogleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/google.php', 'google');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'google');
        $this->commands([RefreshGoogleInsights::class]);
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule): void {
            $schedule->command('google:insights-refresh')->daily()->withoutOverlapping();
        });
    }
}
