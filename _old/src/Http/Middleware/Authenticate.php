<?php

namespace Boss\Http\Middleware;

use Boss\Boss;

class Authenticate
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|null
     */
    public function handle($request, $next)
    {
        return Boss::check($request) ? $next($request) : abort(403);
    }
}
