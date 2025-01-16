<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Paid
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
        $user = Auth::user();
        if($user->shop->status == 1){
            return $next($request);
        }elseif(
            $user->shop->company_registration == null && 
            $user->shop->city == null && 
            $user->shop->street == null &&
            $user->shop->post_code == null &&
            $user->shop->contact_email == null &&
            $user->shop->contact_phone == null 
        ){
            return redirect(route('shop.completeProfile'))->with('success','Please finish your profile before proceeding.');
        }
        return redirect(route('shop.subscription.payment'));
    }
}
