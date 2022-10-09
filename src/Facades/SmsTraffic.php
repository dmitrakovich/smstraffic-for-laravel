<?php

namespace Illuminate\Notifications\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Notifications\Client\Response\SmsTrafficResponse;
use Illuminate\Notifications\Client\SmsTraffic as SmsTrafficClient;

/**
 * @method static SmsTrafficResponse send(string $to, string $message, array $options = [])
 *
 * @see \Illuminate\Notifications\Client\SmsTraffic
 */
class SmsTraffic extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SmsTrafficClient::class;
    }
}
