<?php

namespace App\Http\Middleware;

use App\Enterprise\Permissions;
use Closure;
use Illuminate\Http\Request;

class PermisssionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $feature, $action)
    {
        // if (Permissions::check($feature, $action)) {
        //     return $next($request);
        // } else {
        //     abort(403, 'You don not have permission to ' . $action . ' ' . $feature);
        // }
        return $next($request);
    }
}
