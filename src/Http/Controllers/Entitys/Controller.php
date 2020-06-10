<?php

namespace Boravel\Http\Controllers\Admin;

use Response;
use Boravel\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}
