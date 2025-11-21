<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule automatic database backup daily at 2 AM
Schedule::command('backup:database')->dailyAt('02:00')->name('daily-database-backup')->withoutOverlapping();
