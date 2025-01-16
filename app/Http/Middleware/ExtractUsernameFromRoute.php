<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExtractUsernameFromRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $route = $request->route();

        if ($route && $route->hasParameter('user_name')) {
            $username = $route->parameter('user_name');
            $request->attributes->set('username', $username);
        }

        return $next($request);
    }
}
