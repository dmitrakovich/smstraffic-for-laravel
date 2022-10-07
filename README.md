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

## Official Documentation

Documentation for Laravel Vonage Notification Channel can be found on the [Laravel website](https://laravel.com/docs/notifications#sms-notifications).

## Contributing

Thank you for considering contributing to SmsTraffic for Laravel!

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## License

Laravel Vonage Notification Channel is open-sourced software licensed under the [MIT license](LICENSE.md).
