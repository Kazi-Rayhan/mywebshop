<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ClientWelcomeEmail;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Auth\Events\Registered;
use App\Mail\NotificationEmail;
use App\Models\Order;
use App\Services\MailchimpService;
use App\Services\UserMetaService;
use App\Two\Two;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;
    use RedirectsUsers;
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (isset(request()->is_business_user)) {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                "company_country_prefix" => "required|string",
                "email_domain" => "required|email",
                "legal_name" => "required|string",
                "website" => "required|url",
                "company_number" => "required",
                "trade_name" => "required|string",
                "city" => "required|string",
                "country" => "required|string",
                "company_name" => "required|string",
                "post_code" => "required|string",

                "address" => "required|string"
            ];
        } else {
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];
        }

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();

        $user = User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (isset(request()->is_business_user)) {
            $body = [
                "country_prefix" => $data['company_country_prefix'],
                "email_domain" => $data['email_domain'],
                "legal_name" => $data['legal_name'],
                "merchant_customer_id" => (string) $user->id,
                "website" => $data['website'],
                "organization_id" => $data['company_number'],

                "trade_name" => $data['trade_name'],
                "official_address" => [
                    'id' => 1,
                    'city' => $data['city'],
                    'country' =>  $data['country'],
                    'organization_name' => $data['company_name'],
                    'postal_code' => $data['post_code'],
                    'region' => $data['city'],
                    'street_address'  => $data['address'],
                ],
                "shipping_addresses" => [
                    [
                        'id' => 1,
                        'city' => $data['city'],
                        'country' =>  $data['country'],
                        'organization_name' => $data['company_name'],
                        'postal_code' => $data['post_code'],
                        'region' => $data['city'],
                        'street_address'  => $data['address'],
                    ]
                ]
            ];
            $response = (new Two($body))->business_customer();
            if (isset($response->error_code)) {
                throw new Exception($response->error_details);
            }
            $user->createMetas(['business_customer_id' => $response->id]);
        }

        if (session()->has('order')) {
            Order::find(session()->get('order'))->update(['user_id' => $user->id]);
        }
        DB::commit();
        return $user;
    }
    public function register(Request $request)
    {
        try {
            $this->validator($request->all())->validate();

            event(new Registered($user = $this->create($request->all())));

            $this->guard()->login($user);


            ClientWelcomeEmail::dispatch($user);

            if (session()->has('mailchimp_group')) {

                $response = (new MailchimpService)->addSubscriberToList(session()->get('mailchimp_group'), $user);
                session()->forget('mailchimp_group');
            }
            if ($response = $this->registered($request, $user)) {
                return $response;
            }



            return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect(session()->has('login_redirect') ? session()->get('login_redirect') : $this->redirectPath());
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
    protected function registered(Request $request, $user)
    {
        //
    }
    protected function guard()
    {
        return Auth::guard();
    }
}
