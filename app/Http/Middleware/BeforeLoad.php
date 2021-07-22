<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use MercadoPago\SDK;

class BeforeLoad
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        SDK::setAccessToken(env('MP_ACCESS_TOKEN'));
        return $next($request);
    }
}
