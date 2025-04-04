<?php

return [

    'main_url' => env('SMSTRAFFIC_MAIN_URL', 'https://sds.smstraffic.by/smartdelivery-in/multi.php'),

    'backup_url' => env('SMSTRAFFIC_BACKUP_URL', 'https://sds2.smstraffic.by/smartdelivery-in/multi.php'),

    /*
    |--------------------------------------------------------------------------
    | SMS "From" Number
    |--------------------------------------------------------------------------
    |
    | This configuration option defines the phone number that will be used as
    | the "from" number for all outgoing text messages. You should provide
    | the number you have already reserved within your SmsTraffic dashboard.
    |
    */

    'sms_from' => env('SMSTRAFFIC_SMS_FROM'),

    /*
    |--------------------------------------------------------------------------
    | API Credentials
    |--------------------------------------------------------------------------
    |
    | The following configuration options contain your API credentials, which
    | may be accessed from your SmsTraffic dashboard. These credentials may be
    | used to authenticate with the SmsTraffic API so you may send messages.
    |
    */

    'login' => env('SMSTRAFFIC_LOGIN'),

    'password' => env('SMSTRAFFIC_PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | SMS "route"
    |--------------------------------------------------------------------------
    |
    | The default route for the current message, set in the format:
    | <channel>(<ttl>)-<channel>(<ttl>)-…-<channel>(<ttl>)-<channel>.
    | Example: "viber(60)-sms" in this case the message will be sent to Viber
    | with delivery waiting time 60 sec. If a the message was not delivered,
    | it will be sent to SMS.
    |
    */

    'route' => env('SMSTRAFFIC_ROUTE'),

];
