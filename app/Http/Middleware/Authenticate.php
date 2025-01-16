<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
     
        if(request()->user_name && $request->url() == @route('trainer-free-booking',request()->user_name)){
            session()->put('login_redirect', $request->getUri());
        }
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
