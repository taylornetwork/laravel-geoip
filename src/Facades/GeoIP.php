<?php

namespace TaylorNetwork\GeoIP\Facades;

use Illuminate\Support\Facades\Facade;

class GeoIP extends Facade
{
    /**
     * Get the facade accessor
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'GeoIP';
    }
}