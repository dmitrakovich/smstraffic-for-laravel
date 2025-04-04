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
            $client = new SmsTraffic(
                $config['login'],
                $config['password'],
                $config['main_url'],
                $config['backup_url']
            );

            if (!empty($config['sms_from'])) {
                $client->setDefaultOption('originator', $config['sms_from']);
            }
            if (!empty($config['route'])) {
                $client->setDefaultOption('route', $config['route']);
            }

            return $client;
        });

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('smstraffic', function ($app) {
                return new SmsTrafficChannel($app->make(SmsTraffic::class));
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
