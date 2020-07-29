<?php

namespace App\Helper;

use Exception;

class GennixHelper
{
    public static function externalIP()
    {
        $provider = env('EXTERNAL_IP');

        if ($provider) {
            try {
                $externalIP = file_get_contents($provider);
            } catch (Exception $e) {
                return null;
            }
            return $externalIP;
        }

        return null;
    }


    public static function internalIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $_SERVER['REMOTE_ADDR'];
    }


    public static function userAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }


    public static function urlCurrent()
    {
        return url()->current();
    }

    public static function dateFullFormat()
    {
        setlocale(LC_TIME, str_replace('-', '_', config('app.locale')));
        date_default_timezone_set(config('app.timezone'));

        return strftime(env('DATE_FORMAT_LONG_LONG'), strtotime('today'));
    }
}
