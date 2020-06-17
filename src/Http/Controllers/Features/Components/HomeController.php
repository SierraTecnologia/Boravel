<?php

namespace Boravel\Http\Controllers\Features\Components;

use Boravel\Http\Controllers\Controller as BaseController;
use Exception;
use Throwable;


class HomeController extends BaseController
{

    public function index()
    {
        $trainnings = [];
        return view('components.dashboards.components', compact('trainnings'));
    }

    
}
