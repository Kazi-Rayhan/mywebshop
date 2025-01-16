<?php

namespace App\Http\Middleware;

use App\Models\Shop;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShopCheck
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
       
        $shop = Cache::remember('shop-' . request()->user_name, 900, function () {
            return   Shop::where('user_name', request()->user_name)->first();
        });
        
        if ($shop) {
            session()->put('user_name', $shop->user_name);
            session()->put('login_redirect', $request->getUri());

            if (request('manager_id')) {
                session()->put('manager_id', request('manager_id'));
            }
            return $next($request);
        }

        return redirect('404');
    }
}
