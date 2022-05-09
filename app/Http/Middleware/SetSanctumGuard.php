<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SetSanctumGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if (Str::startsWith($request->getRequestUri(), '/service_provider')) {
            config(['sanctum.guard' => 'service_provider']);
        } elseif (Str::startsWith($request->getRequestUri(), '/user')) {
            config(['sanctum.guard' => 'web']);
        } 

        return $next($request);
    }
}
