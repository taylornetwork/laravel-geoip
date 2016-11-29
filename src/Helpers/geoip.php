<?php

use TaylorNetwork\GeoIP\GeoIP;

if (! function_exists('geoip') )
{
    function geoip ($ip = null)
    {
        return (new GeoIP())->findIP($ip);
    }
}