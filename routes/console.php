<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

  // Schedule::command('reminders:send')->cron('0 9,14,18 * * *');
    Schedule::command('reminders:send')->dailyAt('09:30');
  Schedule::command('reminders:send')->dailyAt('14:15');
  Schedule::command('reminders:send')->dailyAt('18:30');
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
