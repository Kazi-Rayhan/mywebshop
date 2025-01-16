<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Models\Shop;
use App\Models\User;
use App\Models\Service;
use App\Models\PriceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ManagerScheduleRequest;
use App\Mail\BookingPlaced;
use App\Models\Booking;
use App\Models\Level;
use App\Models\Packageoption;
use Shop as ShopFacade;
use Error;
use Exception;
use Illuminate\Support\Facades\Mail;
use QuickPay\QuickPay;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{

    public function assignGroupCreate(User $user)
    {
        $serviceIds = $user->services->pluck('id');

        $user->load([
            'schedules',
            'priceGroups' => function ($query) use ($serviceIds) {
                $query->whereIn('service_id', $serviceIds);
            },
        ]);

        $groups = PriceGroup::where('shop_id', auth()->user()->shop->id)->get();

        return view('dashboard.shop.booking.assign_group_create', compact(
            'user',
            'groups',
        ));
    }

    public function updateManagerSchedule(ManagerScheduleRequest $request, User $user)
    {
        $schedules = $request->validated();

        foreach ($schedules as $schedule) {
            $user->schedules()->updateOrCreate(
                ['day' => $schedule['day']],
                $schedule
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Schedule updated successfully');
    }

    public function updateStorePriceManager(Request $request, User $user)
    {

        $attributes = $request->validate([
            'groups' => 'required|array',
            'groups.*.service_id' => 'required|exists:services,id',
            'groups.*.price_group_id' => 'required|exists:price_groups,id',
            'groups.*.manager_id' => 'required|exists:users,id',
        ]);

        $user->priceGroups()->upsert(
            $attributes['groups'],
            ['manager_id', 'service_id']
        );

        return redirect()
            ->back()
            ->with('Group assigned successfully');
    }

    public function show($username, Service $service, User $manager)
    {
        abort_if(!$service->isActive(), 404);

        $booking = request()->date('date')
            ->setTimeFromTimeString(request('time'));


        return view('booking.checkout', [
            'service' => $service,
            'manager' => $manager,
            'booking' => $booking,
        ]);
    }

    public function store(Request $request, $username, Service $service, User $manager)
    {

        $shop = Shop::where('user_name', $username)->firstOrFail();

        $start_at = $request->date('date')
            ->setTimeFromTimeString($request->time);

        $end_at = $start_at->copy()->addMinutes($service->needed_time);

        $booking = Auth::user()->appointment()->create([
            'end_at'        => $end_at,
            'start_at'      => $start_at,
            'shop_id'       => $shop->id,
            'service_type' => 0,
            'manager_id'    => $manager->id,
            'service_id'    => $service->id,
        ]);

        Mail::to(Auth::user()->email)->send(new BookingPlaced($booking));
        if ($request->continue) return redirect()->route('products', ['user_name' => request('user_name')])->with('success', "Youre appointment created successfully . You'll recive a email from us containing details of your appointment");
        return redirect()->route('booking-placed', ['user_name' => request('user_name'), $booking]);
    }



    public function cancel($user_name, Booking $booking)
    {
        abort_if(auth()->id() != $booking->user_id, 403);
        $booking->status = 3;
        $booking->save();
        return back()->with('success', 'Your appoint has been cancelled');
    }


    public function booking($user_name, Booking $booking)
    {

        if ($booking->user_id != auth()->id()) {
            return abort(403, 'You are not allowed');
        }

        return view('booking.show', compact('booking'));
    }


    public function pay($user_name, Booking $booking)
    {


        if (!is_null($booking->payment_url)) {

            return redirect($booking->payment_url);
        }

        if (!$booking->shop->quickpay_api_key) {
            return back()->withErrors('No payment configuiration found. Please contact shop owner for more information');
        }

        // try {

        $payment = $this->payQuick($booking);
        if ($payment->httpStatus() === 200) {
            return redirect($payment->asObject()->url);
        }
        // } catch (\Exception $e) {
        //     return back()->withErrors('There is a problem with the payment');
        // }
    }

    public function payQuick(Booking $booking)
    {
        $api_key = $booking->shop->quickpay_api_key;

        $client = new QuickPay(":{$api_key}");

        $quick_pay_order_id = '1007' . rand(4444, 999999999);
        $payment = $client->request->post('/payments', [
            'order_id' => $quick_pay_order_id,
            'currency' => 'NOK'
        ]);

        $status = $payment->httpStatus();

        if ($status === 201) {
            $paymentObject = $payment->asObject();

            $endpoint = sprintf("/payments/%s/link", $paymentObject->id);
            $link = $client->request->put($endpoint, [
                "language" => "en",
                "currency" => "NOK",
                "autocapture" => true,
                "autofee" => 0,
                "order_id" => $paymentObject->order_id,
                "continueurl" => route('confirmPayment.booking', ['user_name' => $booking->shop->user_name, 'paymentid' => $paymentObject->id, 'shop' => $booking->shop->id]),
                "cancelurl" => route('booking-placed', [$booking->shop->user_name, $booking]),
                "amount" => $booking->service->price($booking->manager) * 100,

            ]);


            $booking->payment_url = $link->asObject()->url;
            $booking->quick_pay_order_id = $quick_pay_order_id;
            $booking->save();
        }
        return $link;
    }

    public function myCalender(Request $request)
    {
        $bookings = Booking::where('shop_id', auth()->user()->getShop()->id);

        if ($request->filled('status')) $bookings =  $bookings->where('status', $request->status);

        $bookings = $bookings->latest()->paginate(20);

        return view('dashboard.shop.booking.calender', compact('bookings'));
    }
    public function index(Request $request)
    {
        $shop = auth()->user()->shop;
        $bookings = Booking::where('shop_id', $shop->id);
        if ($request->filled('status')) $bookings =  $bookings->where('status', $request->status);

        $bookings = $bookings->latest()->paginate(20);

        return view('dashboard.shop.booking.index', compact('bookings'));
    }
    public function confirmPayment($user_name,$paymentid, Shop $shop)
    {
        $api_key = $shop->quickpay_api_key;
        $client = new QuickPay(":{$api_key}");
        sleep(4);
        $endpoint = sprintf("/payments/%s", $paymentid);
        $payment = $client->request->get($endpoint);

        if ($payment->asObject()->state == 'processed') {
            $booking = Booking::where('quick_pay_order_id', $payment->asObject()->order_id)->first();
            if ($booking) {
                $message =  'Order placed on ' . $booking->created_at->format('M d, Y') . ' has been confirmed.';
                $booking->payment_status = Booking::PAYMENT_STATUS_PAID;
                $booking->payment_id = $payment->asObject()->id;
                $booking->save();
                // if ($booking->shop->retailer_id) {
                //     RetailerCommission::commission_from_sales($booking)->pay();
                // }

                Mail::to($booking->shop->user->email)->send(new BookingPlaced($booking, 'A new booking has been placed'));
                Mail::to($booking->customer->email)->send(new BookingPlaced($booking, $message));
            }

            return redirect(route('thankyou', ['user_name' => $shop->user_name, 'booking' => $booking]));
        }
    }
}
