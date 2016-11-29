# GeoIP for Laravel

An easy way to get the location of an IP address in Laravel 5

## Install

Via Composer

``` bash
$ composer require tayornetwork/geo-ip
```

## Setup

Register the service provider in the providers array in `config/app.php`

``` php
'providers' => [

	TaylorNetwork\GeoIP\GeoIPServiceProvider::class,

],
```

---

Add the `GeoIP` facade to the aliases array in `config/app.php`

``` php
'aliases' => [

	'GeoIP' => TaylorNetwork\GeoIP\Facades\GeoIP::class,

],
```

---

Publish Config

``` bash
$ php artisan vendor:publish
```

Adds `geoip.php` to your `config` folder

## Basic Usage

### Helper Function

This package comes with a global helper function `geoip` which will return call the `GeoIP` class for you.

Get the location of a specific IP address by passing it to `geoip`

``` php
geoip('8.8.8.8');

// Returns an object

{#xxx
	+"ip": "8.8.8.8",
	+"country_code": "US",
	+"country_name": "United States",
	+"region_code": "CA",
	+"region_name": "California",
	+"city": "Mountain View",
	+"zip_code": "94035",
	+"time_zone": "America/Los_Angeles",
	+"latitude": 37.386,
	+"longitude": -122.0838,
	+"metro_code": 807,
}
```

Calling `geoip()` with no parameters will return the location of your IP address.

### Class

``` php
$geoip = new TaylorNetwork\GeoIP\GeoIP ();
```

#### Available Methods

##### findIP (string | null $ip)

Usage is identical to helper function (see [Helper Function](#helper-function))

##### makeRequest (string | null $ip)

Returns the raw response from the HTTP request.

``` php
$geoip->makeRequest('8.8.8.8');

// Returns

"{"ip":"8.8.8.8","country_code":"US","country_name":"United States","region_code":"CA","region_name":"California","city":"Mountain View","zip_code":"94035","time_zone":"America/Los_Angeles","latitude":37.386,"longitude":-122.0838,"metro_code":807}\n"
```

If called with no parameters, your IP address location is returned.

##### decode (mixed $response)

Decodes the response given by `$response`.

By default a JSON string is returned (see [makeRequest](#makerequest)), `decode` will decode the response with `json_decode` to return an object.

``` php
$response = $geoip->makeRequest('8.8.8.8');

/* 
 * We need to remove the newline at the end of the response 
 * or decode will fail due to invalid JSON.
 * 
 * By default this is done in a driver callback function.
 */
$trimmed = trim($response, "\n"); 

$geoip->decode($trimmed);

// Returns

{#xxx
	+"ip": "8.8.8.8",
	+"country_code": "US",
	+"country_name": "United States",
	+"region_code": "CA",
	+"region_name": "California",
	+"city": "Mountain View",
	+"zip_code": "94035",
	+"time_zone": "America/Los_Angeles",
	+"latitude": 37.386,
	+"longitude": -122.0838,
	+"metro_code": 807,
}
```


##### getGuzzleClient ()

Returns an instance of `GuzzleHttp\Client`

##### getDriver ()

Returns an instance of the driver, by default `FreeGeoIP` 

See [Drivers](#drivers)

### Facade


``` php
GeoIP::findIP()
```

All methods in the class are available with the facade. (see [Class](#class))

## Drivers

This package comes with a FreeGeoIP driver by default. However you can use any custom driver you want with this package.

To create a new driver run

``` bash
$ php artisan geoip:driver DriverName
```

This will generate a driver class in `App\GeoIP\Drivers`

**To use a driver, it MUST be registered in `config/geoip.php`**

A driver class will look something like this.

``` php
namespace App\GeoIP\Drivers;

use TaylorNetwork\GeoIP\Drivers\Driver;

class DriverName extends Driver
{
    /**
     * Driver Definition
     *
     * Set all required properties here.
     *
     * @return void
     */
    public function define ()
    {
        $this->name = 'DriverName';
        $this->method = 'GET';
        $this->URL = 'http://driver-url.com';
        $this->responseType = 'JSON';
    }
}
```

*All properties in the define() function must be set to a non empty value*

### Override Methods

If you want to use your own function to find an IP address, or need to format the response after an HTTP request you can override these methods in your driver.

#### responseCallback (mixed $response)

Called after an HTTP request, but before passing to the `GeoIP` decode function (see [Decode](#decode))

``` php
public function responseCallback($response) 
{
	// Code to format, etc.
	
	return $response;
}
```

#### findIP (string | null $ip)

Called when `findIP` is called from class. If `false` is returned, `GeoIP` will do the work. If not the response is then passed to `responseCallback` and then `decode`

``` php
public function findIP ($ip = null)
{
	// Code to do HTTP request, and get response...
	
	return $response;
}
```

### Available Methods

#### property (string $key)

Returns a driver property.

``` php
$driver->property('name');

// Returns

'DriverName'
```

#### properties ()

Returns all driver properties in an associative array.

## Credits

- Author: [Sam Taylor][link-author]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[link-author]: https://github.com/taylornetwork