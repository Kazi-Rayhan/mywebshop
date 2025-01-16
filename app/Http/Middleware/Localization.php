<?php

namespace App\Http\Middleware;

use App\Constants\Constants;
use App\Models\Shop;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Localization
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
        if (Constants::LANGUAGES['status']) {

            if (auth()->check() && auth()->user()->default_language) {
                app()->setLocale(auth()->user()->default_language);
            } else if ($request->user_name) {
                $shop = Cache::remember('shop-' . request()->user_name, 900, function () {
                    return   Shop::where('user_name', request()->user_name)->first();
                });
                if(!$shop) abort(404);
                session()->put('lang', $shop->default_language ? $shop->default_language : Constants::LANGUAGES['default']);
                app()->setLocale($shop->default_language ? $shop->default_language : Constants::LANGUAGES['default']);
            } else {
                app()->setLocale(Constants::LANGUAGES['default']);
            }

            if (request()->has('lang')) {
                session()->put('lang', request()->lang);
            }
            if (session()->has('lang')) app()->setLocale(session()->get('lang'));
        }

        return $next($request);
    }
}
