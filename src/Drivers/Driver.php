<?php

namespace TaylorNetwork\GeoIP\Drivers;

use TaylorNetwork\GeoIP\Exceptions\GeoIPException;

abstract class Driver
{
    /**
     * The name of the driver
     * 
     * @var string
     */
    protected $name;

    /**
     * The HTTP to make requests
     * 
     * @var string
     */
    protected $method;

    /**
     * The URL to make requests to
     * 
     * @var string
     */
    protected $URL;

    /**
     * The response type will be... 
     * 
     * (ARRAY, JSON, XML, etc.)
     * 
     * @var string
     */
    protected $responseType;

    /**
     * Driver constructor.
     */
     public function __construct ()
     {
         $this->define();
         $this->validateDriver();
     }

    /**
     * Define driver values
     *
     * @return void
     */
    abstract protected function define ();

    /**
     * Find an IP address
     * 
     * By default this is called, if false is returned, the 
     * GeoIP class will use GuzzleHttp\Client to make the request.
     * Feel free to override this method in your driver class if 
     * you need to make the request differently.
     * 
     * @param string|null $ip
     * @return mixed
     */
    public function findIP ($ip = null)
    {
        return false;
    }

    /**
     * Callback after getting response 
     * 
     * This will called after response is received and the 
     * returned value will then be decoded.
     * 
     * @param $response
     * @return mixed
     */
    public function responseCallback ($response)
    {
        return $response;
    }

    /**
     * Validate Driver
     *
     * @throws GeoIPException
     */
    protected function validateDriver()
    {
        $required = [ 'name' => 'string', 'method' => 'string', 'URL' => 'string', 'responseType' => 'string' ];

        foreach ($required as $property => $type)
        {
            if (!$this->$property)
            {
                throw new GeoIPException('The \''.$property.'\' property must be set on driver');
            }

            if (gettype($property) !== $type)
            {
                throw new GeoIPException('The \''.$property.'\' property must be a type of ' . $type);
            }
        }
    }

    /**
     * Returns a property by key
     *
     * @param string $key
     * @return mixed
     */
    public function property($key)
    {
        return $this->fixProperty($key);
    }

    /**
     * Returns an array of all properties
     *
     * @return array
     */
    public function properties()
    {
        $array = [];

        foreach($this as $key => $value)
        {
            $array[$key] = $this->fixProperty($key);
        }

        return $array;
    }

    /**
     * Fixes property values
     *
     * @param string $key
     * @return mixed
     */
    protected function fixProperty ($key)
    {
        switch ($key)
        {
            case 'method':
            case 'responseType':
                return strtoupper($this->$key);
                break;

            case 'URL':
                substr($this->$key, -1, 1) === '/' ? $return = $this->$key : $return = $this->$key . '/';
                return strtolower($return);
                break;

            default:
                return $this->$key;
                break;
        }
    }
}