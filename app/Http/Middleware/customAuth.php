<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Http\Request;

class customAuth
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
        return $next($request);
    }
}
