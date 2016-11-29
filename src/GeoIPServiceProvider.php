<?php

namespace TaylorNetwork\GeoIP;

use Illuminate\Support\ServiceProvider;
use TaylorNetwork\GeoIP\Commands\GeoIPDriverCommand;

class GeoIPServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/geoip.php' => config_path('geoip.php'),
        ]);
    }
    
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/geoip.php', 'geoip'
        );
        
        $this->commands([
            GeoIPDriverCommand::class,
        ]);

        if(config('geoip.registerHelper', true))
        {
            require_once __DIR__.'/Helpers/geoip.php';
        }
        
        $this->app->bind('GeoIP', function () {
            return new GeoIP (); 
        });
    }
}