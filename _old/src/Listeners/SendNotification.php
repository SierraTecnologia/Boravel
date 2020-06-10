<?php

namespace Boss\Listeners;

use Boss\Lock;
use Boss\Boss;
use Illuminate\Support\Facades\Notification;

class SendNotification
{
    /**
     * Handle the event.
     *
     * @param  mixed  $event
     * @return void
     */
    public function handle($event)
    {
        $notification = $event->toNotification();

        if (! app(Lock::class)->get('notification:'.$notification->signature(), 300)) {
            return;
        }

        Notification::route('slack', Boss::$slackWebhookUrl)
                    ->route('nexmo', Boss::$smsNumber)
                    ->route('mail', Boss::$email)
                    ->notify($notification);
    }
}
