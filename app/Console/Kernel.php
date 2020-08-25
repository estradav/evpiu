<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\GetTRM',
        'App\Console\Commands\CloseForecasts',
        'App\Console\Commands\InvoiceAudit',
        'App\Console\Commands\ExitAllEmployees',
        'App\Console\Commands\PermisionFolder',
        'App\Console\Commands\GetAllFilesToSensors',
        'App\Console\Commands\GetSensorsData'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('get:trm')->dailyAt('04:00');
         $schedule->command('close:forecasts')->dailyAt('06:00');
         $schedule->command('invoice:audit')->dailyAt('06:30');
         $schedule->command('exit:employees')->dailyAt('23:50');
         $schedule->command('permission:folder')->dailyAt('03:00');
         $schedule->command('sensors:day')->hourly();
         $schedule->command('backup:run')->twiceDaily(12, 17);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
