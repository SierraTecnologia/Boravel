<?php

namespace Boravel\Facades;

use Illuminate\Support\Facades\Facade;

class Boravel extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'boravel';
    }
}
