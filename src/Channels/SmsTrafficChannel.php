<?php

namespace Illuminate\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Client\SmsTraffic;
use Illuminate\Notifications\Messages\SmsTrafficMessage;
use Illuminate\Notifications\Client\Response\SmsTrafficResponse;

class SmsTrafficChannel
{
    /**
     * Create a new SmsTraffic channel instance.
     */
    public function __construct(protected SmsTraffic $client)
    {
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @return SmsTrafficResponse
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSmsTraffic($notifiable);

        $to = $message->to ?: $notifiable->routeNotificationFor('smstraffic', $notification);

        if (empty($to)) {
            return;
        }

        if (is_string($message)) {
            $message = new SmsTrafficMessage($message);
        }

        $options = array_filter([
            'originator' => $message->from,
            'route' => $message->route,
        ]);

        return $this->client->send($to, $message->content, $options);
    }
}
