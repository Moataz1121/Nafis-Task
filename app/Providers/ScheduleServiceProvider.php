<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Schedule $schedule): void
    {
        //
        $schedule->call(\App\Tasks\SendTaskReminder::class)->dailyAt('00:00');
        $schedule->call(\App\Tasks\MarkOverdueTasks::class)->dailyAt('00:00');


    }
}
