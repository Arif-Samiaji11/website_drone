<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes (Laravel 12)
|--------------------------------------------------------------------------
| Laravel 12 tidak memakai app/Console/Kernel.php untuk schedule.
| Jadwal (scheduler) bisa diregister di sini via afterResolving(Schedule::class).
*/

// ✅ Scheduler: jalan setiap hari setelah jam 00:00 (00:05)
app()->afterResolving(Schedule::class, function (Schedule $schedule) {
    $schedule->command('news:fetch')
        ->dailyAt('00:05')
        ->withoutOverlapping()
        ->runInBackground();
});

// Default command bawaan Laravel
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
