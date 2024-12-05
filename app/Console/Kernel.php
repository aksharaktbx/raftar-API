<?php

namespace App\Console;

use App\Console\Commands\GenerateGameResult;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\GenerateGameResult::class,
    ];


    protected function schedule(Schedule $schedule)
    {

        $schedule->command('game:generate-result')->everyMinute();
    }
}
