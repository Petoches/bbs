<?php

namespace App\Console;

use App\Jobs\GetInstagramLatestPosts;
use App\Jobs\UpdateInstagramPostsLikes;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new UpdateInstagramPostsLikes)->everyFifteenMinutes();
        $schedule->job(new GetInstagramLatestPosts)->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
