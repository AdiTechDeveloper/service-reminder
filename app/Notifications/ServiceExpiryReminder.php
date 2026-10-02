<?php

namespace App\Notifications;

use App\Models\ClientService;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class ServiceExpiryReminder extends Notification
{
    public function __construct(public ClientService $service)
    {
    }

    // Database = notification history, WebPush = browser/device notification
    public function via($notifiable): array
    {
        return ['database', WebPushChannel::class];
    }

    protected function text(): string
    {
        $s = $this->service;
        $d = $s->days_left;

        $when = $d === 0
            ? 'expires today'
            : "expires in {$d} days ({$s->expiry_date->format('d M Y')})";

        return "{$s->client->name}'s {$s->serviceType->name}"
            . ($s->title ? " ({$s->title})" : '')
            . " {$when}.";
    }

    public function toArray($notifiable): array
    {
        $s = $this->service;

        return [
            'client_service_id' => $s->id,
            'client'            => $s->client->name,
            'company'           => $s->client->company,
            'service'           => $s->serviceType->name,
            'title'             => $s->title,
            'expiry_date'       => $s->expiry_date->toDateString(),
            'days_left'         => $s->days_left,
            'message'           => $this->text(),
        ];
    }

    public function toWebPush($notifiable, $notification): WebPushMessage
    {
        return (new WebPushMessage)
            ->title('Service Expiry Reminder')
            ->body($this->text())
            ->tag('service-' . $this->service->id)
            ->data([
                'url' => route(
                    'notifications.index',
                    ['highlight' => $notification->id],
                    false
                ),
            ]);
    }
}