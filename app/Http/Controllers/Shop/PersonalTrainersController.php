<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainerBookingRequest;
use App\Mail\BookingPlaced;
use App\Models\Booking;
use App\Models\Credit;
use App\Models\Level;
use App\Models\Package;
use App\Models\Packageoption;
use App\Models\Qrcode;
use App\Models\Shop;
use App\Models\User;
use App\Services\Commission;
use App\Services\CreditWallet;
use App\Services\MailchimpService;
use App\Services\PackageBuyService;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;
use Carbon\Carbon;

class PersonalTrainersController extends Controller
{

    public function storeTrainer(Request $request, $username, User $user, Packageoption $option)
    {
        try {
            DB::beginTransaction();
            $shop = Shop::where('user_name', $username)->firstOrFail();

            $start_at = Carbon::parse($request->input('date'))->setTimeFromTimeString($request->input('time'));
            $end_at = $start_at->copy()->addMinutes($option->minutes);

            $booking = $this->createOrUpdateBooking($request, $user, $shop, $option, $start_at, $end_at);
            $this->subtractCreditsForBooking($booking, $shop, $user, $option);
            $this->updateBookingWithPackageDetails($booking, $user);

            DB::commit();

            $this->sendBookingConfirmationEmail($booking);

            if ($request->input('continue')) {
                return redirect()->route('products', ['user_name' => request('user_name')])
                    ->with('success', "Your appointment was created successfully. You'll receive an email from us containing details of your appointment.");
            }

            return back()->with('success-booking', 'Your appointment has been cancelled.');
        } catch (Exception $e) {
            DB::rollBack();
            // Log the error for debugging purposes
            Log::error('Error in storeTrainer method: ' . $e->getMessage());

            return back()->withErrors($e->getMessage());
        } catch (Throwable $e) {
            DB::rollBack();
            // Log the error for debugging purposes
            Log::error('Throwable error in storeTrainer method: ' . $e->getMessage());

            return back()->withErrors($e->getMessage());
        }
    }



    public function cancel($user_name, Booking $booking)
    {
        abort_if(auth()->id() != $booking->user_id, 403);
        $booking->status = 3;
        $booking->save();
        return back()->with('success', 'Your appoint has been cancelled');
    }

    public function trainers($user_name, User $trainer = null)
    {
        $shop = Cache::remember('shop-' . request()->user_name, 900, function () {
            return   Shop::where('user_name', request()->user_name)->first();
        });
        // $trainer = auth()->user()->trainer($shop);

        // if (!$trainer || $trainer->getShop() != $shop) {
        //     abort($trainer ? 403 : 404);
        // }


        $session = $shop->defaultoption;

        return view('shop.personal_trainers.personal_trainers', compact('session', 'shop', 'trainer'));
    }

    public function bookTrainer(TrainerBookingRequest $request, $user_name)
    {

        $shop = Shop::where('user_name', $user_name)->first();


        if (!auth()->check()) {
            if (isset($request->user['register'])) {
                $hashedPassword = Hash::make($request->user['register']['password']);
                $request->merge([
                    'user' => array_merge($request->user['register'], ['password' => $hashedPassword])
                ]);
                $user = User::create($request->user['register']);
                Auth::login($user);
            }
            if (isset($request->user['login'])) {
                $user = User::where('email', $request->user['login']['email'])->firstOrFail();
                if (Hash::check($request->user['login']['password'], $user->password)) {
                    Auth::login($user, true);
                }
            }
            if (!auth()->check()) {
                return redirect()->back()->withErrors('Something went wrong');
            }
        }

        try {

            if ($request->trainer == auth()->id()) {
                throw new Exception('You can not book yourself');
            }

            if (empty($shop->defaultoption)) {
                throw new Exception('This shop do not have any defualt option selected');
            }
            $package = Package::find($request->package);
            $data = [
                'user_id'       => auth()->id(),
                'shop_id'       => $shop->id,
                'name'    => auth()->user()->name,
                'last_name'     =>  auth()->user()->last_name,
                'email'         =>  auth()->user()->email,
                'phone'         =>  auth()->user()->phone,
                'address'       =>  auth()->user()->address ?? '',
                'city'          =>  auth()->user()->city ?? '',
                'state'         =>  auth()->user()->state ?? '',
                'post_code'     =>  auth()->user()->post_code ?? '',
                'country'       =>  auth()->user()->country ?? '',
                'type'          => 1,
                'tax'      => $request->tax,
                'subtotal'      => $request->sub_price,
                'total'         => $request->total_price,
                'payment_method' => 'subscription',
                'currency' => 'NOK'
            ];

            $trainer = User::find($request->trainer);
            $customer = User::find(auth()->id());

            $customer->createMeta('split', $request->split == 'on');

            $buy_package = new PackageBuyService($shop, $trainer, $customer);
            return $buy_package->buyPackage($package, $data);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function list($user_name)
    {
        if (request()->filled('group')) {
            $qrcode = Qrcode::where('group', request()->group)->first();
            $qrcode->increment('count');
            if (auth()->check()) {
                $response = (new MailchimpService)->addSubscriberToList($qrcode->group, auth()->user());
                session()->forget('mailchimp_group');
            } else {
                session()->put('mailchimp_group', request()->group);
            }
        }
        $shop = Cache::remember('shop-' . request()->user_name, 900, function () {
            return   Shop::where('user_name', request()->user_name)->first();
        });
        $trainers = $shop->users()->personalTrainer()->get();

        return view('shop.personal_trainers.list', compact('shop', 'trainers'));
    }


    public function freeBooking($user_name, Request $request)
    {

        try {
            DB::beginTransaction();
            $shop = Cache::remember('shop-' . request()->user_name, 900, function () {
                return   Shop::where('user_name', request()->user_name)->first();
            });

            $user = User::find($request->trainer);

            auth()->user()->update([
                'pt_trainer_id' => $user->id,
                'pt_free_tier' => true,
            ]);

            $option = $shop->defaultOption;


            $duration = $option->minutes;

            (new CreditWallet(auth()->user(), $user))->deposit($duration, 'admin_credits');

            $start_at = Carbon::parse($request->input('date'))->setTimeFromTimeString($request->input('time'));
            $end_at = $start_at->copy()->addMinutes($option->minutes);

            $booking = $this->createOrUpdateBooking($request, $user, $shop, $option, $start_at, $end_at);
            $this->subtractCreditsForBooking($booking, $shop, $user, $option);
            $this->updateBookingWithPackageDetails($booking, $user);


            $this->sendBookingConfirmationEmail($booking);

            if ($request->input('continue')) {
                return redirect()->route('products', ['user_name' => request('user_name')])
                    ->with('success', "Your appointment was created successfully. You'll receive an email from us containing details of your appointment.");
            }

            DB::commit();
            return redirect($user->bookingUrl())->with('success', 'Your appointment has been booked.');
        } catch (Exception $e) {
            DB::rollBack();
            // Log the error for debugging purposes
            Log::error('Error in storeTrainer method: ' . $e->getMessage());

            return back()->withErrors($e->getMessage());
        } catch (Throwable $e) {
            DB::rollBack();
            // Log the error for debugging purposes
            Log::error('Throwable error in storeTrainer method: ' . $e->getMessage());

            return back()->withErrors($e->getMessage());
        }
    }

    private function createOrUpdateBooking(Request $request, User $user, Shop $shop, Packageoption $option, Carbon $start_at, Carbon $end_at)
    {
        $appointment = $this->getAppointmentForUser($request, $user);

        $bookingData = [
            'end_at' => $end_at,
            'start_at' => $start_at,
            'shop_id' => $shop->id,
            'manager_id' => $user->id,
            'service_id' => $option->id,
            'service_type' => 1,
            'payment_status' => 1,
        ];

        return $appointment->updateOrCreate(['id' => $request->input('reschedule')], $bookingData);
    }

    private function getAppointmentForUser(Request $request, User $user)
    {
        if (request()->filled('reschedule')) {
            $appointment = Booking::find($request->input('reschedule'));

            if ($appointment->manager_id != $user->id) {
                abort(403);
            }

            $logs = $appointment->log ? json_decode($appointment->log) : [];
            $log['from'] = [
                'service_id' => $appointment->service_id,
                'start_at' => $appointment->start_at,
                'end_at' => $appointment->end_at,
            ];
        } else {
            $appointment = Auth::user()->appointment();
        }

        return $appointment;
    }

    private function subtractCreditsForBooking(Booking $booking, Shop $shop, User $user, Packageoption $option)
    {
        if ($booking->wasRecentlyCreated) {

            $client = User::find(auth()->id());


            $credit = (new CreditWallet($client, $booking->manager))->spend($booking->service->minutes);

            (new Commission($credit, $booking))->give();
        } else {
            $logs = $booking->log ? json_decode($booking->log) : [];
            $log['to'] = [
                'service_id' => $booking->service_id,
                'start_at' => $booking->start_at,
                'end_at' => $booking->end_at,
            ];
            array_push($logs, $log);
            $booking->createMeta('log', json_encode($logs));
        }
    }

    private function updateBookingWithPackageDetails(Booking $booking, User $user)
    {
        // Perform any additional operations related to updating the booking with package details
        // This can be further refactored or extracted into separate methods or classes if needed
    }

    private function sendBookingConfirmationEmail(Booking $booking)
    {
        // Send the booking confirmation email to the user
        Mail::to(Auth::user()->email)->send(new BookingPlaced($booking));
    }
}
