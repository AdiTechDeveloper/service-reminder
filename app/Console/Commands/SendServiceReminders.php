<?php

namespace App\Console\Commands;

use App\Models\ClientService;
use App\Notifications\ServiceExpiryReminder;
use Illuminate\Console\Command;

class SendServiceReminders extends Command
{
    protected $signature = 'reminders:send
        {--days=10 : Number of days before expiry}
        {--force : Ignore today\'s already-sent check}';

    protected $description = 'Send expiry reminders to users via database and browser push';

    public function handle(): int
    {
        $sent = 0;

        ClientService::with(['user', 'client', 'serviceType'])
            ->expiringWithin((int) $this->option('days'))
            ->chunkById(100, function ($services) use (&$sent) {

                foreach ($services as $service) {

                    $service->user->notify(
                        new ServiceExpiryReminder($service)
                    );

                    $service->update([
                        'last_reminded_on' => today(),
                    ]);

                    $sent++;
                }
            });

        $this->info("{$sent} reminder(s) sent.");

        return self::SUCCESS;
    }
}