<?php

return [

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
    | Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "logging.channels" configuration array.
    |
    */

    'log_channel' => env('SMSTRAFFIC_LOG_CHANNEL'),

];
