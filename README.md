# SmsTraffic for Laravel

## Details

Inspired by [Laravel Vonage Notification Channel](https://github.com/laravel/vonage-notification-channel).

## Note
This library implements limited functionality.

## Documentation

Sending SMS notifications in Laravel is powered by [SMS Traffic](https://www.smstraffic.ru/). Before you can send notifications via SMS Traffic, you need to install the `dmitrakovich/smstraffic-for-laravel` and `guzzlehttp/guzzle` packages:

    composer require dmitrakovich/smstraffic-for-laravel guzzlehttp/guzzle

The package includes a [configuration file](https://github.com/dmitrakovich/smstraffic-for-laravel/blob/main/config/smstraffic.php). However, you are not required to export this configuration file to your own application. You can simply use environment variables.

    SMSTRAFFIC_SMS_FROM=
    SMSTRAFFIC_LOGIN=
    SMSTRAFFIC_PASSWORD=
    SMSTRAFFIC_ROUTE=

### Formatting SMS Notifications

If a notification supports being sent as an SMS, you should define a `toSmsTraffic` method on the notification class. This method will receive a `$notifiable` entity and should return an `Illuminate\Notifications\Messages\SmsTrafficMessage` instance:

    /**
     * Get the SmsTraffic / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SmsTrafficMessage
     */
    public function toSmsTraffic($notifiable)
    {
        return (new SmsTrafficMessage)
                    ->content('Your SMS message content');
    }

#### Notification route

If you would like to send some notifications to another route that is different route specified by your `SMSTRAFFIC_ROUTE` environment variable, you may call the `route` method on a `SmsTrafficMessage` instance:

    /**
     * Get the SmsTraffic / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SmsTrafficMessage
     */
    public function toSmsTraffic($notifiable)
    {
        return (new SmsTrafficMessage)
                    ->content('Your unicode message')
                    ->route('whatsapp(180)-sms');
    }

### Customizing The "From" Number

If you would like to send some notifications from a phone number that is different from the phone number specified by your `SMSTRAFFIC_SMS_FROM` environment variable, you may call the `from` method on a `SmsTrafficMessage` instance:

    /**
     * Get the SmsTraffic / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SmsTrafficMessage
     */
    public function toSmsTraffic($notifiable)
    {
        return (new SmsTrafficMessage)
                    ->content('Your SMS message content')
                    ->from('15554443333');
    }

### Routing SMS Notifications

To route SmsTraffic notifications to the proper phone number, define a `routeNotificationForSmsTraffic` method on your notifiable entity:

    <?php

    namespace App\Models;

    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable
    {
        use Notifiable;

        /**
         * Route notifications for the SmsTraffic channel.
         *
         * @param  \Illuminate\Notifications\Notification  $notification
         * @return string
         */
        public function routeNotificationForSmsTraffic($notification)
        {
            return $this->phone_number;
        }
    }

## Official Documentation

Documentation for Laravel Vonage Notification Channel can be found on the [Laravel website](https://laravel.com/docs/notifications#sms-notifications).

## Contributing

Thank you for considering contributing to SmsTraffic for Laravel!

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## License

Laravel Vonage Notification Channel is open-sourced software licensed under the [MIT license](LICENSE.md).
