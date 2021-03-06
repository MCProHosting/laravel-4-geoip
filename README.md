# GeoIP for Laravel 4

This repo contains some improvements to the original package, primarily on code conventions (PSR-2 style) and removing potentially hazardous behaviour. Unit testing will be added in the future, however that is not of immediate priority.

[![Latest Stable Version](https://poser.pugx.org/torann/geoip/v/stable.png)](https://packagist.org/packages/torann/geoip) [![Total Downloads](https://poser.pugx.org/torann/geoip/downloads.png)](https://packagist.org/packages/torann/geoip)

Determine the geographical location of website visitors based on their IP addresses.

----------

## Installation

- [GeoIP for Laravel 4 on GitHub](https://github.com/torann/laravel-4-geoip)

To get the latest version of GeoIP simply require it in your `composer.json` file.

~~~
"torann/geoip": "dev-master"
~~~

You'll then need to run `composer install` to download it and have the autoloader updated.

Once GeoIP is installed you need to register the service provider with the application. Open up `app/config/app.php` and find the `providers` key.

~~~php
'providers' => array(

    'Torann\GeoIP\GeoIPServiceProvider',

)
~~~

GeoIP also ships with a facade which provides the static syntax for creating collections. You can register the facade in the `aliases` key of your `app/config/app.php` file.

~~~php
'aliases' => array(

    'GeoIP' => 'Torann\GeoIP\GeoIPFacade',

)
~~~

Create configuration file using artisan

~~~
$ php artisan config:publish torann/geoip
~~~

## Usage

Get the location data for a website visitor:

```php
$location = GeoIP::getLocation();
```

> When an IP is not given the `$_SERVER["REMOTE_ADDR"]` is used.

Getting the location data for a given IP:

```php
$location = GeoIP::getLocation( '232.223.11.11' );
```

### Example Data

```php
array (
    "ip"           => "232.223.11.11",
    "isoCode"      => "US",
    "country"      => "United States",
    "city"         => "New Haven",
    "state"        => "CT",
    "postal_code"  => "06510",
    "lat"          => 41.28,
    "lon"          => -72.88
);
```
## Services


### [MaxMind](http://www.maxmind.com)

- **Database Service**: To use the database version of MaxMind services download the `GeoLite2-City.mmdb` from [http://dev.maxmind.com/geoip/geoip2/geolite2/](http://dev.maxmind.com/geoip/geoip2/geolite2/) and extract it to `/app/database/maxmind/`. And that's it.

