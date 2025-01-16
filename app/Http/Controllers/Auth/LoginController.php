<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Services\MailchimpService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if (session()->has('mailchimp_group')) {

            $response = (new MailchimpService)->addSubscriberToList(session()->get('mailchimp_group'), $user);
            session()->forget('mailchimp_group');
        }
        $role = Auth::user()->role_id;
      
        if ($role == 1) {
            return redirect(route('voyager.dashboard'));
        } elseif ($role == 2) {
            if (session()->has('login_redirect')) {

                return redirect(session()->get('login_redirect'));
            }
            if ($role == 2 && session()->has('login_redirect')) {
    
                return redirect(session()->get('login_redirect'));
            }
            if (session()->has('user_name')) {
                return redirect(route('shop.home', ['user_name' => session('user_name')]));
            }
            return redirect(route('home'));
        } elseif ($role == 3) {
            return redirect(route('shop.dashboard'));
        } elseif ($role == 4) {
            return redirect(route('manager.dashboard'));
        } elseif ($role == 5) {
            return redirect(route('retailer.dashboard'));
        } elseif ($role == 6) {
            return redirect(route('external.dashboard'));
        } elseif ($role == 7) {
            return redirect(route('enterprise.dashboard'));
        } else {
            return redirect(route('home'));
        }
        // echo 'hello';
    }

    public function logout(Request $request)
    {
        $url =   session()->get('login_redirect') ?? '/';

        $this->guard()->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return redirect($url);
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect($url);
    }
}
