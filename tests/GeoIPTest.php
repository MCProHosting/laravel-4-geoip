<?php

use Torann\GeoIP\GeoIP;
use Torann\GeoIP\ReaderProvider;
use GeoIp2\Database\Reader;
use Mockery as m;

class GeoIPTest extends PHPUnit_Framework_TestCase {

    public function testInternalIPIsDetected() {
    	$g = new GeoIP(m::mock('Illuminate\Config\Repository'), m::mock('Illuminate\Session\Store'), new ReaderProvider());
        
        $this->assertFalse($g->checkIp("0.0.0.0"));
        $this->assertFalse($g->checkIp("10.0.0.0"));
        $this->assertFalse($g->checkIp("127.0.5.10"));
        $this->assertFalse($g->checkIp("169.254.15.255"));
        $this->assertFalse($g->checkIp("192.168.1.1"));
        $this->assertFalse($g->checkIp("255.255.255.255"));
        $this->assertFalse($g->checkIp("255.255.255.255.255"));
        $this->assertFalse($g->checkIp("255.255.255"));
        $this->assertFalse($g->checkIp("255.255.25"));

        $this->assertTrue($g->checkIp("86.41.16.84"));
        $this->assertTrue($g->checkIp("4.4.4.2"));
    }

    public function testGetClientLocationWithNoCache() {
    $locArray = array (
    'ip' => '4.4.4.2',
    'isoCode' => 'US',
    'country' => 'United States',
    'city' => null,
    'state' => null,
    'postal_code' => null,
    'lat' => 38.0,
    'lon' => -97.0
    );

    $reader = m::mock('Torann\GeoIP\ReaderProvider');
    $reader->shouldReceive('make')->andReturn(new Reader('./database/maxmind/GeoLite2-City.mmdb'));

    $config = m::mock('Illuminate\Config\Repository');
    $config->shouldReceive('get')->with('geoip::maxmind')->andReturn(
    array(
        'type' => 'database', // database or web_service
        'user_id' => '',
        'license_key' => ''
    ));
    $config->shouldReceive('get')->with('geoip::service', 'maxmind')->andReturn("maxmind");

    $mock = m::mock('Illuminate\Session\Store');
    $mock->shouldReceive('get')->with('geoip-location')->andReturn(null);
    $mock->shouldReceive('set')->once()->with('geoip-location', false)->andReturn(true);

    $g = new GeoIP($config, $mock, $reader); 	
    
    $this->assertFalse($g->getLocation());
    $this->assertEquals($g->getLocation("4.4.4.2"), $locArray);
    }

    public function testGetClientLocationWithCache() {
    $_SERVER['REMOTE_ADDR'] = '232.223.11.11';

    $cachedArray = array (
    "ip"           => "232.223.11.11",
    "isoCode"      => "US",
    "country"      => "United States",
    "city"         => "New Haven",
    "state"        => "CT",
    "postal_code"  => "06510",
    "lat"          => 41.28,
    "lon"          => -72.88
    );

    $mock = m::mock('Illuminate\Session\Store');
    $mock->shouldReceive('get')->with('geoip-location')->andReturn($cachedArray);
    $mock->shouldReceive('set')->once()->with('geoip-location', $cachedArray)->andReturn(true);

    $g = new GeoIP(m::mock('Illuminate\Config\Repository'), $mock, new ReaderProvider()); 	
    
    $this->assertEquals($g->getLocation(), $cachedArray);
    }

}
?>