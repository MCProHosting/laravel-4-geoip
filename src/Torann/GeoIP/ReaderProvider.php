<?php namespace Torann\GeoIP;

use GeoIp2\Database\Reader;

class ReaderProvider {

    public function make($data) {
        return new Reader($data);
    }
}
