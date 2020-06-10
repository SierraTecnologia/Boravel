<?php

namespace Boravel\Services\System;

class Service
{
    public static function getSingleton()
    {
        //@todo Ativar cache de acordo com business
        return new static();
    }
}