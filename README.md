# SmsTraffic for Laravel

## Details

Inspired by [Laravel Vonage Notification Channel](https://github.com/laravel/vonage-notification-channel).

## Note
This library implements limited functionality.

## Documentation

Sending SMS notifications in Laravel is powered by [SMS Traffic](https://www.smstraffic.ru/). Before you can send notifications via SMS Traffic, you need to install the `dmitrakovich/smstraffic-for-laravel` and `guzzlehttp/guzzle` packages:
```shell
composer require dmitrakovich/smstraffic-for-laravel guzzlehttp/guzzle
```
The package includes a [configuration file](https://github.com/dmitrakovich/smstraffic-for-laravel/blob/main/config/smstraffic.php). However, you are not required to export this configuration file to your own application. You can simply use environment variables.
```properties
SMSTRAFFIC_SMS_FROM=
SMSTRAFFIC_LOGIN=
SMSTRAFFIC_PASSWORD=
SMSTRAFFIC_ROUTE=
```
### Formatting SMS Notifications

If a notification supports being sent as an SMS, you should define a `toSmsTraffic` method on the notification class. This method will receive a `$notifiable` entity and should return an `Illuminate\Notifications\Messages\SmsTrafficMessage` instance:
```php
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
```
#### Notification route

If you would like to send some notifications to another route that is different route specified by your `SMSTRAFFIC_ROUTE` environment variable, you may call the `route` method on a `SmsTrafficMessage` instance:
```php
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
```
### Customizing The "From" Number

If you would like to send some notifications from a phone number that is different from the phone number specified by your `SMSTRAFFIC_SMS_FROM` environment variable, you may call the `from` method on a `SmsTrafficMessage` instance:
```php
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
```
### Routing SMS Notifications

To route SmsTraffic notifications to the proper phone number, define a `routeNotificationForSmsTraffic` method on your notifiable entity:
```php
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
```
### Using The SmsTraffic Facade

Alternatively, you may send notifications via the `\Illuminate\Notifications\Facades\SmsTraffic` facade:
```php
SmsTraffic::send($phones, $message);
```

### Checking Delivery Status

You can poll delivery status for previously sent messages using `status()`. Pass a single message id or an array of up to **15** identifiers per request (comma-separated in the API). Identifiers are always handled as strings — do not cast them to integers.

The library supports two XML response formats:

| | Classic RU API | Smart Delivery BY |
|---|---|---|
| Default URLs | `api.smstraffic.ru` | `sds.smstraffic.by/smartdelivery-in/multi.php` |
| Message id | `sms_id` | `msg-info/id` |
| Status values | `Delivered`, `Expired`, … | `READ`, `DELIVERED`, … |
| Channel | — | `msg-info/channel-info/channel` (`viber`, `sms`, …) |
| Batch | `<sms>` elements | `<msg-infos>` / multiple `<msg-info>` |

```php
use Illuminate\Notifications\Client\Response\SmsTrafficStatusCollectionResponse;
use Illuminate\Notifications\Facades\SmsTraffic;

$response = SmsTraffic::status('165314138129206752561536268436567490747');

if ($response instanceof SmsTrafficStatusCollectionResponse) {
    foreach ($response->getStatuses() as $status) {
        $status->getSmsId();
        $status->getStatus(); // Delivered, READ, DELIVERED, ...
        $status->getChannel(); // viber, sms, ... (Smart Delivery only)
        $status->getDeliveryDate();
        $status->getReadDate();
        $status->getSubmissionDate();
        $status->getSendDate();
        $status->getLastStatusChangeDate();
        $status->getError(); // per-message error, if any
        $status->isFinal(); // true for terminal statuses
    }
}

// Multiple ids (max 15)
$response = SmsTraffic::status([
    '8287713301',
    '8287713302',
]);
```

Status information is retained by the provider for approximately **2 days**. Final statuses include:

- Classic: `Delivered`, `Non Delivered`, `Rejected`, `Expired`, `Deleted`, `Unknown status`
- Smart Delivery: `READ`, `DELIVERED`, `EXPIRED`, `REJECTED`, `DELETED`, `FAILED`, `UNDELIVERED`

Use `SmsTrafficStatusResponse::finalStatuses()` for the full combined list.

If more than 15 ids are passed, `TooManySmsIdsException` is thrown before any HTTP request is made.
## Official Documentation

Documentation for Laravel Vonage Notification Channel can be found on the [Laravel website](https://laravel.com/docs/notifications#sms-notifications).

## Contributing

Thank you for considering contributing to SmsTraffic for Laravel!

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## License

Laravel Vonage Notification Channel is open-sourced software licensed under the [MIT license](LICENSE.md).
