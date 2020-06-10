<?php

namespace Boss\Http\Controllers;

use Boss\Boss;

class HomeController extends Controller
{
    /**
     * Single page application catch-all route.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boss::layout', [
            'cssFile' => Boss::$useDarkTheme ? 'app-dark.css' : 'app.css',
            'bossScriptVariables' => Boss::scriptVariables(),
        ]);
    }
}
