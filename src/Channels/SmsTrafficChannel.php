<?php

namespace Illuminate\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Client\SmsTraffic;

class SmsTrafficChannel
{
    /**
     * Create a new SmsTraffic channel instance.
     */
    public function __construct(protected SmsTraffic $client)
    {
    }

    public function send($notifiable, Notification $notification)
    {
        return 34534;
    }
}
