<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Facades\Iziibuy;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Message;
use App\Models\Order;
use App\Models\Membership;
use App\Models\Credit;
use App\Models\Packageoption;
use App\Models\Shop;
use App\Rules\MatchOldPassword;
use App\Models\User;
use App\Services\ServicePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Nette\MemberAccessException;

class DashboardController extends Controller
{


    public function profile()
    {
        return view('dashboard.user.profile');
    }
    public function passwordchange()
    {
        return view('dashboard.user.password-change');
    }
    public function dashboard($username)
    {
        $shop = Shop::where('user_name', $username)->first();
        $order = Order::where('user_id', auth()->id())->count();
        $booking = Booking::where('user_id', auth()->id())->count();
        
        return view('dashboard.user.dashboard', compact('shop', 'order', 'booking'));
    }
    public function booking()
    {

        $bookings = Booking::where('user_id', auth()->id())->where('service_type', 1)->latest()->get();
        return view('dashboard.user.booking', compact('bookings'));
    }
    public function orders()
    {

        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('dashboard.user.order', compact('orders'));
    }
    public function memberships()
    {

        $memberships = Membership::where('user_id', auth()->id())->latest()->get();
        return view('dashboard.user.memberships', compact('memberships'));
    }

    public function ptTrainer($username)
    {
        $shop = Shop::where('user_name', $username)->first();
        $credit = auth()->user()->credits()->first();
        return view('dashboard.user.ptTrainer', compact('credit', 'shop'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'name' => ['required', 'max:40'],
            'last_name' => ['required', 'max:40'],
            'phone' => ['required'],
            'address' => ['required', 'max:200'],
            'country' => ['required', 'max:50'],
            'city' => ['required', 'max:50'],
            'post_code' => ['required', 'max:10'],
            'state' => ['required', 'max:20'],
        ]);
        auth()->user()->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
        ]);
        auth()->user()->createMetas([
            'country' => $request->country,
            'city' => $request->city,
            'address' => $request->address,
            'post_code' => $request->post_code,
            'state' => $request->state,
        ]);
        return back()->with('success_msg', 'Profile updated successfully!');
    }
    function ChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success_msg', 'Password changed successfully');
    }

    public function trainerServicesSchedule($username, User $user, Packageoption $option)
    {
        if (request()->wantsJson()) {
            $period = (new ServicePeriod($option, $user, request('date')))
                ->getPeriods();

            return response()->json([
                'events' => $period
            ]);
        }
        if(!auth()->check()) return redirect()->route('login');

        if ($user->getShop()->user_name != $username) abort(403);
        if ($option->shop->user_name != $username) abort(403);

        $shop = Shop::where('user_name', $username)->first();
        $trainer_services = Packageoption::where('shop_id', $shop->id)->get();
        $bookings = Booking::where('user_id', auth()->id())->where('service_type', 1)->where('manager_id', $user->id)->latest()->get();
        $messages = Message::with('message_sender')->where('sender', $user->id)
            ->where('receiver', auth()->id())
            ->orWhere(function ($query) use ($user) {
                $query->where('receiver', $user->id)->where('sender', auth()->id());
            })
            ->get();
        
        return view('shop.booking.time-slot-trainers', [
            'service' => $option,
            'manager' => $user,
            'trainer_services' => $trainer_services,
            'option' => $option,
            'messages' => $messages,
            'bookings' => $bookings
        ]);
    }

    public function bookingShow($username, Booking $booking)
    {
        if ($booking->user_id != auth()->id()) abort(403, 'You do not have access');
        return view('dashboard.user.booking_show', compact('booking'));
    }

    public function invoice($username, Order $order)
    {
        if ($order->user_id != auth()->id()) abort(403, 'You do not have access');
        $products = $order->products;
        return view('dashboard.user.invoice', compact('order', 'products'));
    }
    public function chat($user_name, User $user)
    {
        $messages = Message::with('message_sender')->where('sender', $user->id)
            ->where('receiver', auth()->id())
            ->orWhere(function ($query) use ($user) {
                $query->where('receiver', $user->id)->where('sender', auth()->id());
            })
            ->get();
        return view('dashboard.user.chat', compact('user', 'messages'));
    }

    public function renew($user_name, Credit $credit)
    {
        if ($credit->user_id != auth()->id()) abort(403);
        $sub = $credit->subscription;
        $sub->status = !$sub->status;
        $sub->save();
        return redirect()->back()->with('success', 'Renewal Status Updated');
    }
}
