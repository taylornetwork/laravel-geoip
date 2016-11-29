<?php

namespace TaylorNetwork\GeoIP\Drivers;

class FreeGeoIP extends Driver
{
    /**
     * @inheritdoc
     */
    public function define ()
    {
        $this->name = 'FreeGeoIP';
        $this->method = 'GET';
        $this->URL = 'http://freegeoip.net/json/';
        $this->responseType = 'JSON';
    }

    /**
     * @inheritDoc
     */
    public function responseCallback($response)
    {
        return trim($response, "\n");
    }


}