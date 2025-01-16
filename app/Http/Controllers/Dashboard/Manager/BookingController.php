<?php

namespace App\Http\Controllers\Dashboard\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerBookingRequest;
use App\Http\Resources\BookingResource;
use App\Mail\BookingPlaced;
use App\Mail\OrderPlaced;
use App\Models\Booking;
use App\Models\Level;
use App\Models\Message;
use App\Models\Order;
use App\Models\Package;
use App\Models\Packageoption;
use App\Models\User;
use App\Services\Commission;
use App\Services\CreditWallet;
use App\Services\PackageBuyService;
use App\Services\ServicePeriod;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        if (request()->filled('show_up')) {

            $booking = Booking::findOrFail(request('booking_id'));
            $booking->show_up = request('show_up');
            $booking->save();
            return back()->with('success', 'success');
        }
        $bookings = Booking::where('manager_id', auth()->id())->where('service_type', 1);
        if ($request->filled('status')) $bookings =  $bookings->where('status', $request->status);

        $bookings = $bookings->latest()->paginate(20);

        return view('dashboard.manager.booking.index', compact('bookings'));
    }
    public function bulk(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'bookings' => 'required|array',
            'bookings.*' => 'exists:bookings,id', // Assuming 'bookings' is the table name
            'show_up_bulk' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update the database records
        Booking::whereIn('id', $request->bookings)->update([
            'show_up' => $request->show_up_bulk
        ]);

        // Return a success response
        return response()->json(['message' => 'Bulk update successful'], 200);
    }
    public function createNote(Request $request, Booking $booking)
    {

        $request->validate([
            'note' => 'required'
        ]);

        $booking->createMeta('note', $request->note);
        return redirect()->back()->withSuccess('Note added');
    }

    public function myCalender()
    {
        $user_id = request('user_id');
        $user = User::where('id', $user_id)->first();

        if ($user) {
            $user->sentMessages(auth()->user())->where('seen', 0)->update(['seen' => 1]);
            $messages = Message::with('message_sender')->where('sender', $user->id)
                ->where('receiver', auth()->id())
                ->orWhere(function ($query) use ($user) {
                    $query->where('receiver', $user->id)->where('sender', auth()->id());
                })
                ->get();
        } else {
            $messages = [];
        }
        $clients = Auth::user()->where('pt_trainer_id', auth()->id())->paginate(10);

        return view('dashboard.manager.booking.calender', compact('messages', 'user', 'clients'));
    }
    public function booking_show(User $user,  Packageoption $option)
    {

        $user->sentMessages(auth()->user())->where('seen', 0)->update(['seen' => 1]);
        $manager = User::find(auth()->id());
        $shop = $manager->getShop();
        $orders = Order::where('payment_status', 1)
            ->where('status', 5)
            ->where('type', 1)
            ->where('user_id', $user->id)
            ->whereHas('metas', fn ($query) => $query->where('column_name', 'trainer')->where('column_value', $manager->id))
            ->get();
        $trainer_services = Packageoption::where('shop_id', $shop->id)->get();
        $bookings = Booking::where('user_id', $user->id)->where('service_type', 1)->where('manager_id', $manager->id)->latest()->get();
        $messages =    $messages = Message::with('message_sender')->where('sender', $manager->id)

            ->orWhere(function ($query) use ($manager, $user) {
                $query->where('receiver', $manager->id)->where('sender', $user->id);
            })

            ->get();
        if (request()->wantsJson()) {
            $period = (new ServicePeriod($option, $manager, request('date')))
                ->getPeriods();

            return response()->json([
                'events' => $period
            ]);
        }


        return view('dashboard.manager.booking.time-slot', [
            'service' => $option,
            'manager' => $manager,
            'trainer_services' => $trainer_services,
            'option' => $option,
            'messages' => $messages,
            'bookings' => $bookings,
            'user' => $user,
            'orders' => $orders,
            'shop' => $shop
        ]);
    }
    public function service_index(User $user)
    {

        $shop = Auth::user()->getShop();
        $packages = Package::where('shop_id', $shop->id)->get();
        $trainers = $shop->users()->personalTrainer()->get();
        $session = Packageoption::where('shop_id', $shop->id)->get()->filter(function ($option) {
            return $option->default;
        })->first();
        return view('dashboard.manager.booking.services', compact('user', 'packages', 'session', 'shop'));
    }

    public function service_book(TrainerBookingRequest $request, User $user)
    {
        $shop = auth()->user()->getShop();

        try {

            // if ($request->trainer == auth()->id()) {
            //     throw new Exception('You can not book yourself');
            // }

            if (empty($shop->defaultoption)) {
                throw new Exception('This shop do not have any defualt option selected');
            }
            $package = Package::find($request->package);
            $data = [
                'user_id'       => $user->id,
                'shop_id'       => $shop->id,
                'name'    => $user->name,
                'last_name'     =>  $user->last_name,
                'email'         =>  $user->email,
                'phone'         =>  $user->phone,
                'address'       =>  $user->address ?? '',
                'city'          =>  $user->city ?? '',
                'state'         =>  $user->state ?? '',
                'post_code'     =>  $user->post_code ?? '',
                'country'       =>  $user->country ?? '',
                'type'          => 1,
                'tax'      => $request->tax,
                'subtotal'      => $request->sub_price,
                'total'         => $request->total_price,
                'payment_method' => 'subscription',
                'currency' => 'NOK'
            ];

            $trainer = User::find($request->trainer);
            $customer = $user;

            $buy_package = new PackageBuyService($shop, $trainer, $customer);
            return $buy_package->buyPackage($package, $data, true);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function getEvents()
    {

        $bookings = Booking::where('manager_id', auth()->id())->whereBetween('start_at', [Carbon::parse(request()->date)->startOfDay(), Carbon::parse(request()->date)->endOfDay()])->get();
        return BookingResource::collection($bookings);
    }

    public function confirm_booking(Request $request, User $user, Packageoption $option)
    {
        try {

            DB::beginTransaction();
            $shop = auth()->user()->getShop();


            $start_at = $request->start_at ?? $request->date('date')
                ->setTimeFromTimeString($request->time);

            if ($request->has('miniutes')) {
                $end_at =  Carbon::parse($start_at)->addMinutes($request->miniutes);
            } else {
                $end_at =  $start_at->copy()->addMinutes($option->minutes);
            }

            if (request()->filled('reschedule')) {
                $appointment = Booking::find($request->reschedule);
                if ($appointment->manager_id != $user->id) abort(403);
                $logs = $appointment->log ? json_decode($appointment->log) : [];
                $log['from'] = ['service_id' => $appointment->service_id, 'start_at' => $appointment->start_at, 'end_at' => $appointment->end_at];
            } else {
                $appointment = $user->appointment();
            }


            $booking =  $appointment->updateOrCreate(['id' => $request->reschedule], [
                'end_at'        => $end_at,
                'start_at'      => $start_at,
                'shop_id'       => $shop->id,
                'manager_id'    => auth()->user()->id,
                'service_id'    => $option->id,
                'service_type'    => 1,
                'payment_status' => 1,
            ]);
            $level = Level::where('id', $user->level)->first();





            // $commission = $credit->price / $credit->
            if ($booking->wasRecentlyCreated) {
                if ($request->type == 'subscription') {
                    $minutes = $request->miniutes;
                    $credit = (new CreditWallet($user, $booking->manager))->spend($minutes);
                } else {
                    $credit = (new CreditWallet($user, $booking->manager))->spend($booking->service->minutes);
                }


                (new Commission($credit, $booking))->give();
            } else {
                $log['to'] = ['service_id' => $booking->service_id, 'start_at' => $booking->start_at, 'end_at' => $booking->end_at];
                array_push($logs, $log);
                $booking->createMeta('log', json_encode($logs));
            }
            DB::commit();
            Mail::to($user->email)->send(new BookingPlaced($booking));
            if ($request->continue) return redirect()->route('products', ['user_name' => request('user_name')])->with('success', "Youre appointment created successfully . You'll recive a email from us containing details of your appointment");
            return back()->with('success-booking', 'Your appoint has been cancelled');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }


    public function booking_cancel(Booking $booking)
    {
        try {
            if ($booking->shop_id != auth()->user()->getShop()->id)
                throw new Exception("You do not have access");
            if ($booking->status != 'Pending')

                throw new Exception("Status can't be changed");
            DB::beginTransaction();

            if (request()->charge == false && $booking->service_type == 1) {

                $booking->customer->addCredits($booking->shop_id, $booking->manager_id, $booking->service->minutes);
            }

            $booking->update(['status' => $booking::STATUS_CANCELED]);
            DB::commit();


            return redirect()->back()->with('success', 'Status updated to canceled');
        } catch (Exception $e) {
            DB::transaction();
            return redirect()->back()->with('error', $e->getMessage());
        } catch (Error $e) {
            DB::transaction();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function booking_complete(Booking $booking)
    {
        try {
            if ($booking->shop_id != auth()->user()->getShop()->id)
                throw new Exception("You do not have access");
            if ($booking->status != 'Pending')
                throw new Exception("Status can't be changed");
            $booking->update(['status' => $booking::STATUS_COMPLETED]);
            return redirect()->back()->with('success', 'Status updated to completed');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
