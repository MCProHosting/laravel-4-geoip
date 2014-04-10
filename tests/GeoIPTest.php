<?php

use Torann\GeoIP\GeoIP;
use Mockery as m;

class GeoIPTest extends PHPUnit_Framework_TestCase {

    public function testInternalIPIsDetected() {
    	$g = new GeoIP(m::mock('Illuminate\Config\Repository'), m::mock('Illuminate\Session\Store'));
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

}
?>