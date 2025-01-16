<?php

namespace App\Http\Middleware;

use App\Models\Shop;
use Closure;
use Illuminate\Http\Request;

class SubscribedForService
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
    
        $shop = $this->getShop();
   
        if(!$shop->can_provide_service) abort('403','This shop do not has the rights');
        return $next($request);
    }

    public function getShop()
    {
        
        if (auth()->user()->getShop()) return auth()->user()->getShop();
        if (auth()->user()->shop) return auth()->user()->shop;
  
        // if (request()->user_name) return Shop::where('user_name', request()->user_name)->first();
        return new Shop;
    }
}
