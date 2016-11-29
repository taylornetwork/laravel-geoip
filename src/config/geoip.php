<?php

return [
    
    /*
     |--------------------------------------------------------------------------
     | Register Helper Function
     |--------------------------------------------------------------------------
     |
     | Set to true if you want the global helper function 'geoip' to be available
     |
     */
    'registerHelper' => true,

    /*
     |--------------------------------------------------------------------------
     | Driver
     |--------------------------------------------------------------------------
     |
     | Driver to use with GeoIP, must be registered in array below.
     |
     */
    'driver' => 'FreeGeoIP',

    /*
     |--------------------------------------------------------------------------
     | Register Drivers
     |--------------------------------------------------------------------------
     |
     | Register the drivers you want to be available with GeoIP
     | 
     */
    'drivers' => [
        'FreeGeoIP' => TaylorNetwork\GeoIP\Drivers\FreeGeoIP::class,
    ],
    
];