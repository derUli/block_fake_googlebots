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
        
        if (strpos($agent, 'Google') !== false && self::isValidGoogleIp($ip)) {
            
            $is_valid_request = true;
        }
        
        return $is_valid_request;
    }
}