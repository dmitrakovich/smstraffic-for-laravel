<?php

namespace Illuminate\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Client\SmsTraffic;

/**
 * @param SmsTraffic $client The SmsTraffic client instance.
 * @param string $from The phone number notifications should be sent from.
 */
class SmsTrafficChannel
{
    /**
     * Create a new SmsTraffic channel instance.
     */
    public function __construct(protected SmsTraffic $client, protected string $from)
    {
    }


    public function send($notifiable, Notification $notification)
    {
        return 34534;
    }
}
