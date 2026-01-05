<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  protected function schedule(Schedule $schedule): void
  {
    // Schedule your loan reminder command
    $schedule->command('loans:send-reminders --force')->everyMinute()->withoutOverlapping();
    $schedule->call(function () {
      \Log::info('Scheduler is running at ' . now());
    })->everyMinute();
  }

  protected function commands(): void
  {
    $this->load(__DIR__ . '/Commands');
    require base_path('routes/console.php');
  }
}
