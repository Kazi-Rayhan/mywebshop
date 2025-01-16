<?php

namespace App\Http\Controllers;

use App\Mail\NotificationEmail;
use App\Mail\OrderConfirmed;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop as ShopModel;
use App\Models\User;
use Error;
use Exception;
use App\Payment\Two\TwoPayment;
use App\Services\NewOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Newsletter\Facades\Newsletter;
use TCG\Voyager\Models\Page;
use TCG\Voyager\Models\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {

    // $role = Auth::user()->role_id;
    // if ($role == 1) {
    // return redirect(route('voyager.dashboard'));
    // } elseif ($role == 2) {
    // if (session()->has('user_name')) {
    // return redirect(route('shop.home', ['user_name' => session('user_name')]));
    // }
    // return redirect(route('home'));
    // } elseif ($role == 3) {
    // return redirect(route('shop.dashboard'));
    // } elseif ($role == 4) {
    // return redirect(route('manager.dashboard'));
    // } elseif ($role == 5) {
    // return redirect(route('retailer.dashboard'));
    // } else {
    // return redirect(route('home'));
    // }
    // }
    public function contact()
    {
        $a = rand(1, 10);
        $b = rand(1, 10);
        session()->put('captcha', $a . "+" . $b);
        session()->put('captcha_result', $a + $b);
        return view('contact');
    }

    public function about()
    {
        return view('about');
    }
    public function faqs()
    {
        $post = Post::get();
        return view('faqs');
    }
    public function thankyou()
    {
        if (request()->order) {
            $order = Order::find(request()->order);
            if ($order->is_company && !$order->status) {
                (new TwoPayment($order->shop, $order))->confirm();
            }
            $shop = $order->shop;
        } else {
            $order = new Order();
            $shop = new ShopModel();
        }
        return view('thankyou', compact('shop', 'order'));
    }

    public function send_order_notification(Request $request)
    {
        $request->validate([
            'email' => ['required']
        ]);
        if ($request->order) {
            $order = Order::find($request->order);
            $message =  'Order placed on ' . $order->created_at->format('M d, Y') . ' has been confirmed.';


            if ($order->create_a_account) {
                $mail_data = [
                    'subject' =>  __('words.signup_from_thankyou_subject'),
                    'body' =>  __('words.signup_from_thankyou_body'),
                    'button_link' => route('register', ['first_name' => $order->first_name, 'last_name' => $order->last_name, 'email' => $request->email]),
                    'button_text' => __('words.signup_from_thankyou_button'),
                    'emails' => [],
                ];
                $order->createMeta('email', $request->email);
                Mail::to($request->email)->send(new NotificationEmail($mail_data));
            }
            Mail::to($request->email)->send(new OrderConfirmed($order, $message));



            return redirect(route('thankyou', ['user_name' => $order->shop->user_name]))->with('success_msg', 'Email send successfully');
        }
        if ($request->booking) {
            $booking = Booking::find($request->booking);
            $message =  'Booking placed on ' . $booking->created_at->format('M d, Y') . ' has been confirmed.';
            Mail::to($request->email)->send(new OrderConfirmed($booking, $message));
            Mail::to($booking->shop->email)->send(new OrderConfirmed($booking, $message));
            return redirect(route('thankyou', ['user_name' => $booking->shop->user_name]))->with('success_msg', 'Email send successfully');
        }
    }
    public function contact_store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:40'],
            'email' => ['required', 'max:100', 'email'],
            'subject' => ['required', 'max:100'],
            'message' => ['required', 'max:2000'],
            'captcha' => 'required'
        ]);
        try {

            if ($request->captcha != session()->get('captcha_result')) throw  new Exception('Captcha Failed');
            
            Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);
            
            $mail_data = [
                'subject' => $request->subject,
                'body' => $request->message . '<br> From:' . $request->name . ' ' . $request->email,
                'button_link' => '',
                'button_text' => 'Visit',
                'emails' => [],
            ];
            
            
            session()->forget('captcha');
            session()->forget('captcha_result');

            Mail::to(setting('site.email'))->send(new NotificationEmail($mail_data));
            
            return redirect()->back()->with('success', 'Message sent successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }catch (Error $e){
            return redirect()->back()->withErrors($e->getMessage());

        }
    }

    public function newsletter(Request $request)
    {
        $sub =  Newsletter::isSubscribed($request->email);

        if ($sub) {
            return redirect()->back()->with('success_msg', 'You already subscribed');
        } else {
            Newsletter::subscribe($request->email, listName: 'subscribers');
        }
        return redirect()->back()->with('success_msg', 'You Subscribed');
    }
    public function posts($slug)
    {
        $post = Post::where('slug', $slug)->where('status', 'PUBLISHED')->first();
        if (!$post) {
            abort(404);
        }
        return view('posts', compact('post'));
    }

    public function pages($slug)
    {
        $post = Page::where('slug', $slug)->where('status', 'ACTIVE')->first();
        if (!$post) {
            abort(404);
        }
        return view('posts', compact('post'));
    }
}
