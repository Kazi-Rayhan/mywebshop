<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShopValidation
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

        if (empty($request->header('X-API-Key')) == true) return response('Permission Deined', 403);
      
        if (
            !isset($request->shop) ||
            is_null($request->shop->security_key)|| 
            $request->shop->security_key != 
            $request->header('X-API-Key')
        ) {
            return response('Permission Deined', 403);
        }
        return $next($request);
    }
}
