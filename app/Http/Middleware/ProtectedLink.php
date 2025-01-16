<?php

namespace App\Http\Middleware;

use App\Models\ProtectedLink as ModelsProtectedLink;
use Closure;
use Illuminate\Http\Request;

class ProtectedLink
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

        $protectedLink = ModelsProtectedLink::where('uid', '=', $request->uid)->where('link', url()->current())->first();
        if ($protectedLink && $protectedLink->password == $request->password) {
            
            return $next($request);
        } else {
            abort(403);
        }
    }
}
