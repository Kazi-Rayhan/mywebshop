<?php

namespace App\Services;

use Iziibuy;
use App\Mail\OrderPlaced;
use App\Models\{User, Shop, Credit, Order, Package, Subscription};
use App\Payment\Payment;
use App\Payment\Subscribe;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PackageBuyService
{
    public Shop $shop;
    public User $trainer;
    public User $customer;
    public  $credit;

    public function __construct(Shop $shop, User $trainer, User $customer)
    {
        $this->shop = $shop;
        $this->trainer = $trainer;
        $this->customer = $customer;
        $this->credit = $customer->getCredit($shop->id, $trainer->id);
    }
    public function check_if_user_has_subscription(): bool
    {


        if ($this->credit && $this->credit->subscribed()) {
            return true;
        } else {
            return false;
        }
    }

    public function buyPackage(Package $package, $data, $is_manager = false, $split = false)
    {

        if ($this->check_if_user_has_subscription()) {
            //charge from subscription and send to thank you
            $quickPay = new Subscribe($this->shop->quickpay_api_key);
            $key = $this->customer->getCredit($this->shop->id, request()->trainer)->subscription->key;
            $sub = $quickPay->subscription($key);

            $subscription = Subscription::where('key', $key)->first();

            $order = $subscription->order;
            $trainer = request()->trainer;
            $charge = (new Subscribe($this->shop->quickpay_api_key))->subscription($key)->charge(request()->total_price);


            $subscription->charges()->create([
                'amount' => request()->total_price,
                'status' => true
            ]);
            if ($charge) {
                $subscription->paid_at = Carbon::now();
                $subscription->save();
                $package = Package::find(request()->package);

                $this->updateClientPackage($order);

                (new CreditWallet($this->customer, User::find($trainer)))->deposit($package->duration, $package->type == 'default' ? 'session_credits' : 'subscription_credits', $package->validity);
                if ($is_manager) {

                    Mail::to($order->email)->send(new OrderPlaced($order, __('words.client_order_email')));
                    return redirect()
                        ->route('manager.booking.client.index')
                        ->with('success', 'Minutes added');
                } else {

                    if (auth()->check() && $trainer) return redirect()->route('trainer_services.schedule', ['user_name' => $this->shop->user_name, 'user' => $trainer, 'option' =>  $this->shop->defaultoption]);
                    return redirect(route('thankyou', ['user_name' => $this->shop->user_name, 'order' => $order]));
                }
            }

            if ($is_manager) {
                return redirect()
                    ->route('manager.booking.client.index')
                    ->with('success', 'Minutes added');
            } else {
                return redirect(route('thankyou', ['user_name' => $this->shop->user_name, 'order' => $order]));
            }
        } else {
            try {


                $order =  $this->createOrder($data, $package);
                // $client->createMetas([
                //     'current_package' => request()->package,
                //     'current_package_price' =>  $order->total
                // ]);
                $this->updateClientPackage($order);


                $payment =  (new Subscribe($this->shop->quickpay_api_key))->subscription()->getUrl($order->total);

                if ($payment['status'] == false) throw new Exception($payment['data']['message']);
                $order->payment_id = $payment['data']['payment_id'];
                $order->payment_url = $payment['data']['url'];

                $order->save();
                if ($is_manager) {

                    Mail::to($order->email)->send(new OrderPlaced($order, __('words.client_order_email')));
                    return redirect()
                        ->route('manager.booking.client.index')
                        ->with('success', 'Ordre plassert. Vennligst betal nå for å bekrefte din ordre');
                } else {

                    return redirect()
                        ->route(
                            'payment',
                            [
                                'order' => $order,
                                'user_name' => request('user_name')
                            ]
                        )
                        ->with('success_msg', 'Ordre plassert. Vennligst betal nå for å bekrefte din ordre');
                }
            } catch (Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            } catch (Error $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
            // }
        }
    }

    private function createOrder($data, $package)
    {
        //create new order
        $order = Order::create([
            'user_id' => $this->customer->id,
            'shop_id' => $this->shop->id,
            'subtotal' => $data['subtotal'],
            'total' => $data['total'],
            'tax' => $data['tax'],
            'payment_method' => 'subscription',
            'type' => $data['type'],
            'currency' => $data['currency'],
        ]);

        $order->createMetas([
            'package' => $package->id,
            'trainer' => $this->trainer->id,
            'renew' => request()->has('renew'),
            'credit' => $package->sessions * $this->shop->defaultoption->minutes,
            'name'          =>  $data['name'],
            'last_name'     =>  $data['last_name'],
            'email'         =>  $data['email'],
            'phone'         =>  $data['phone'],
            'address'       =>  $data['address'],
            'city'          =>  $data['city'],
            'state'         =>  $data['state'],
            'post_code'     =>  $data['post_code'],
            'country'       =>  $data['country'],
        ]);

        return $order;
    }
    private function updateClientPackage($order)
    {
        $client = $this->customer;

        $new_history = json_decode($client->pt_package_history, true); // Decode JSON string into an associative array
        $new_history[] = ['package' => request()->package, 'price' => Iziibuy::price($order->total), 'created_at' => now()->format('d-m-Y')]; // Append new element to the array


        $client->pt_package_id = request()->package;
        $client->pt_package_price = $order->total;
        $client->pt_package_purchase_history = json_encode($new_history);
        $client->save();

        return $client;
    }
}
