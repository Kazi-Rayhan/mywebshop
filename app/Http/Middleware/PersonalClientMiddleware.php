<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class PersonalClientMiddleware
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
        if(request('user_id')){
            $user = User::find(request('user_id'));
        }else{
           $user = $request->user;
        }
        $personalTrainer = $user->pt_trainer_id;
        $isAuthUserVendor = auth()->user()->role_id == 3;
        $userManagers = auth()->user()->managers->pluck('id');

        if ( $isAuthUserVendor && $userManagers->contains($personalTrainer)) {
            // Perform the desired actions for when the personal trainer is found among the user's managers
            return $next($request);
        }
        if ($user->pt_trainer_id == auth()->id())  return $next($request);
        abort(403);
    }
}
