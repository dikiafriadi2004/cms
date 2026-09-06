<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Backup Schedule
Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->daily()->at('02:00');

// Auto-publish scheduled posts (mark as published when published_at <= now)
Schedule::call(function () {
    DB::table('posts')
        ->where('status', 'scheduled')
        ->where('published_at', '<=', now())
        ->update(['status' => 'published', 'updated_at' => now()]);
})->everyFiveMinutes()->name('publish-scheduled-posts');

// Prune ad analytics older than 90 days to keep table small
Schedule::call(function () {
    DB::table('ad_analytics')
        ->where('event_date', '<', now()->subDays(90))
        ->delete();
})->daily()->at('03:00')->name('prune-ad-analytics');

// Prune failed jobs older than 30 days
Schedule::command('queue:prune-failed --hours=720')->daily()->at('03:30');
