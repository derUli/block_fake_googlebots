<?php

class GoogleBotCheckHelper extends Helper
{

    private static function isValidGoogleIp($ip)
    {
        $hostname = gethostbyaddr($ip); // "crawl-66-249-66-1.googlebot.com"
        return preg_match('/\.googlebot|google\.com$/i', $hostname);
    }

    public static function looksLikeGoogleBot($useragent = null)
    {
        if (is_null($useragent)) {
            $useragent = get_useragent();
        }
        return strstr(strtolower($useragent), "googlebot");
    }

    public static function isValidGoogleRequest($ip = null, $agent = null)
    {
        if (is_null($ip)) {
            $ip = get_ip();
        }
        
        if (is_null($agent)) {
            $agent = get_useragent();
        }
        
        $is_valid_request = false;
        
        $value_from_db = self::isFakeFromDB($ip);
        if (! is_null($value_from_db)) {
            $is_valid_request = ! $value_from_db;
        } else if (strpos($agent, 'Google') !== false && self::isValidGoogleIp($ip)) {
            $is_valid_request = true;
            self::saveIP($ip, ! $is_valid_request);
        } else {
            self::saveIP($ip, ! $is_valid_request);
        }
        
        return $is_valid_request;
    }

    private static function saveIP($ip, $fake)
    {
        $sql = "REPLACE INTO `{prefix}googlebot_ips`(ip, fake) values(?,?)";
        $args = array(
            strval($ip),
            boolval($fake)
        );
        Database::pQuery($sql, $args, true);
    }

    private static function isFakeFromDB($ip)
    {
        $sql = "select `fake` from `{prefix}googlebot_ips` where ip = ?";
        $args = array(
            strval($ip)
        );
        $query = Database::pQuery($sql, $args, true);
        if (Database::any($query)) {
            $row = Database::fetchSingle($query);
            return boolval($row->fake);
        }
        return null;
    }
}