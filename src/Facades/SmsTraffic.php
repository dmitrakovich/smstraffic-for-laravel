<?php

namespace Illuminate\Notifications\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Notifications\Client\SmsTraffic as SmsTrafficClient;

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