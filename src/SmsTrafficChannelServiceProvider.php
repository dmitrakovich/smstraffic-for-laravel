<?php

namespace Illuminate\Notifications;

use Illuminate\Notifications\Channels\SmsTrafficChannel;
use Illuminate\Notifications\Client\SmsTraffic;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;

class SmsTrafficChannelServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/smstraffic.php', 'smstraffic');

        $this->app->singleton(SmsTraffic::class, function ($app) {
            $config = $app['config']['smstraffic'];
            return new SmsTraffic($config['login'], $config['password'], $config['sms_from']);
        });

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('smstraffic', function ($app) {
                return new SmsTrafficChannel(
                    $app->make(SmsTraffic::class),
                    $app['config']['smstraffic.sms_from']
                );
            });
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/smstraffic.php' => $this->app->configPath('smstraffic.php'),
            ], 'smstraffic');
        }
    }
}
