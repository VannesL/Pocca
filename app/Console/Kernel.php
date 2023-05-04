<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //delete vendors
        $schedule->call(function () {
            DB::table('vendors')
                ->where('upcoming_deletion_date', '<=', Carbon::now())
                ->delete();
        })->daily();

        //finish orders
        $schedule->call(function () {
            DB::table('orders')
                ->where('finish_time', '<=', Carbon::now())
                ->update(['status_id' => 5]);
        })->everyTenMinutes();
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
