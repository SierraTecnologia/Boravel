<?php

namespace Boravel\Services\System;

use Illuminate\Support\Facades\Cache;


class CacheService
{

    private static function getBusinessKey($key)
    {
        return BusinessService::getSingleton()->getCode().$key;
    }

    public static function get($key)
    {
        return Cache::get(self::getBusinessKey($key));
    }

    public static function set($key, $value)
    {
        return Cache::set(self::getBusinessKey($key), $value);
    }

    public static function clear($key)
    {
        return Cache::clear(self::getBusinessKey($key));
    }

    public static function getUniversal($key)
    {
        return Cache::get($key);
    }

    public static function setUniversal($key, $value)
    {
        return Cache::set($key, $value);
    }

    public static function clearUniversal($key)
    {
        return Cache::clear($key);
    }
}
