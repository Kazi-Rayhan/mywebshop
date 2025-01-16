<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnterprisePaid
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
        
        if($user->enterpriseOnboarding->status == 1){
            return $next($request);
        }elseif(
            $user->enterpriseOnboarding->company_registration == null && 
            @$user->enterpriseOnboarding->company_address->city == null &&
            @$user->enterpriseOnboarding->company_address->street == null &&
            @$user->enterpriseOnboarding->company_address->post_code == null &&
            @$user->enterpriseOnboarding->company_email == null &&
            @$user->enterpriseOnboarding->company_domain == null
            ){
                return redirect(route('enterprise.completeProfile'))->with('success', 'Please finish your profile before proceeding.');
            }
        
            return $next($request);
    }
}
