<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExternalPaid
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
        $user = Auth::user();
        
        if($user->paymentMethodAccess->status == 1){
            return $next($request);
        }elseif(
            $user->paymentMethodAccess->company_registration == null && 
            @$user->paymentMethodAccess->company_address->city == null &&
            @$user->paymentMethodAccess->company_address->street == null &&
            @$user->paymentMethodAccess->company_address->post_code == null &&
            @$user->paymentMethodAccess->company_email == null &&
            @$user->paymentMethodAccess->company_domain == null
            ){
                return redirect(route('external.completeProfile'))->with('success', 'Please finish your profile before proceeding.');
            }
        
            return $next($request);
    }
}
