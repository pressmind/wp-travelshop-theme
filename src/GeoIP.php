<?php

namespace Pressmind\Travelshop;

use GeoIp2\Database\Reader;

class GeoIP
{
    private static $runtime_cache = [];

    /**
     * Gets the current Location by GeoIp Database from the User.
     * @return \GeoIp2\Model\City|false
     * @throws \GeoIp2\Exception\AddressNotFoundException
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    public static function getLocation($ip = null, $min_accurancy = 20)
    {
        if(empty($ip)){
            $ip = self::getUserIp();
        }
        if(isset(self::$runtime_cache[$ip])){
            return self::$runtime_cache[$ip];
        }
        try{
            $cityDbReader = new Reader(APPLICATION_PATH . '/database/GeoIP2-City.mmdb');
            $result = $cityDbReader->city($ip);
            if($result->location->accuracyRadius <= $min_accurancy){
                self::$runtime_cache[$ip] = $result;
            }else{
                return false;
            }
            return self::$runtime_cache[$ip];
        }catch (\Exception $e){
            self::$runtime_cache[$ip] = false;
            return false;
        }
    }

    /**
     * Get real visitor IP behind CloudFlare network, or some other LBs
     * https://stackoverflow.com/questions/13646690/how-to-get-real-ip-from-visitor
     * @return mixed
     */
    public static function getUserIp()
    {
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = $_SERVER['REMOTE_ADDR'];
        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }
        return $ip;
    }

}