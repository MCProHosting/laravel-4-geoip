<?php namespace Torann\GeoIP;

use GeoIp2\Database\Reader;

class ReaderProvider {

    public function make($data = null) {
    	if($data === null) {
    		return new Reader(app_path() . '/database/maxmind/GeoLite2-City.mmdb');
    	}else{
    		return new Reader($data);
    	}
    }
}
