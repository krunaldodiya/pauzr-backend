<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\AddCoupons;
use App\Console\Commands\AddCategories;
use App\Console\Commands\AddStores;
use App\Console\Commands\AddTimer;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AddCategories::class,
        AddCoupons::class,
        AddStores::class,
        AddTimer::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('coupomated:add-stores')
            ->hourly();

        $schedule->command('timer:add')
            ->daily()
            ->timezone('Asia/Kolkata')
            ->between('10:00', '17:00');

        $schedule->command('backup:clean')
            ->daily()
            ->at('01:00');

        $schedule->command('backup:run')
            ->daily()
            ->at('02:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
