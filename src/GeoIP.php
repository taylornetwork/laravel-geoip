<?php

namespace TaylorNetwork\GeoIP;

use GuzzleHttp\Client as GuzzleClient;
use TaylorNetwork\GeoIP\Drivers\Driver;
use TaylorNetwork\GeoIP\Exceptions\GeoIPException;

class GeoIP
{
    /**
     * @var Driver
     */
    protected $driver;

    /**
     * @var GuzzleClient
     */
    protected $guzzleClient;

    /**
     * GeoIP constructor.
     */
    public function __construct ()
    {
        $drivers = config('geoip.drivers');
        $driver = config('geoip.driver');

        if (array_key_exists($driver, $drivers))
        {
            $this->driver = new $drivers[$driver] ();
        }
        else
        {
            throw new GeoIPException('Driver not registered');
        }
    }

    /**
     * Find the location of an IP address
     * 
     * @param null|string $ip
     * @return mixed
     */
    public function findIP ($ip = null)
    {
        $response = $this->driver->findIP($ip);

        if ($response === false)
        {
            $response = $this->makeRequest($ip);
        }
        
        return $this->decode($this->driver->responseCallback($response));
    }

    /**
     * Make Guzzle request
     * 
     * @param null|string $ip
     * @return mixed
     */
    public function makeRequest ($ip = null)
    {
        return $this->getGuzzleClient()
                ->request($this->driver->property('method'), $this->driver->property('URL') . $ip)
                ->getBody()
                ->getContents();
    }

    /**
     * Get an instance of GuzzleHttp\Client
     * 
     * @return GuzzleClient
     */
    protected function getGuzzleClient ()
    {
        if (!isset($this->guzzleClient) || !$this->guzzleClient instanceof GuzzleClient)
        {
            $this->guzzleClient = new GuzzleClient();
        }

        return $this->guzzleClient;
    }

    /**
     * Decode the response
     * 
     * @param $response
     * @return mixed
     */
    protected function decode($response)
    {
        switch ($this->driver->property('responseType'))
        {
            case 'JSON':
                return json_decode($response);
                break;
            
            case 'XML':
                return $response;
                break;
            
            case 'ARRAY':
                return $response;
                break;
            
            default: 
                return $response;
                break;
        }
    }
}