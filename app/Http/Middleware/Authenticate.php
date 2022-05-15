<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if($request->is('service_provider') || $request->is('service_provider')){
            return response()->json(['message'=>'unauthenticated'],Response::HTTP_UNAUTHORIZED);
        }
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
