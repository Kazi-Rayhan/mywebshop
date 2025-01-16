<?php

namespace App\Http\Controllers;

use App\Events\PurchaseComplete;
use App\Mail\NotificationEmail;
use App\Mail\OrderConfirmed;
use App\Mail\OrderDelivered;
use App\Mail\SubscriptionBoxInvoice;
use App\Models\Charge;
use App\Models\ExternalOrder;
use App\Models\Membership;
use App\Models\Order;
use App\Models\Package;
use App\Models\Shop;
use App\Models\Subscription;
use App\Models\User;
use App\Payment\Elavon\ApiElavonPayment;
use App\Payment\Elavon\ElavonPayment;
use App\Payment\Quickpay\QuickPayPayment;
use App\Payment\Subscribe;
use App\Payment\Two\TwoPayment;
use App\Payment\UserSubscription;
use App\Services\CreditWallet;
use App\Services\RetailerCommission;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class CallbackController extends Controller
{

    public function paymentSuccess($paymentId, Order $order)
    {

        try {
            $status =  (new QuickPayPayment($order))->paymentStatus($paymentId);

            if ($status['data']['accepted'] != true) throw new Exception('Payment is not accepted');

            define('PAID', 1);
            define('DELIVERED', 5);
            define('NOTCAPTURED', 4);
            define('PENDING', 0);
            $captured = false;
            switch ($status['data']['state']) {
                case 'processed':
                    if ($order->shop->retailer_id && $status['data']['test_mode'] != true) {
                        RetailerCommission::commission_from_sales($order)->pay();
                    }
                    $order->status = DELIVERED;
                    $captured = true;
                    break;

                case 'new':
                    $order->status = NOTCAPTURED;
                    break;

                default:
                    $order->status = PENDING;
                    break;
            }
            $order->payment_status = true;
            $order->paid_at = now();
            $order->save();
            if ($order->is_vcard) {
                $message =  "Order has been confirmed . Download details from here: <a href='" . route('order.managers-csv', $order->id) . "'>Download CSV</a>";
                if ($captured) {
                    Mail::to($order->shop->user->email)->send(new OrderConfirmed($order, $message, false));
                    Mail::to($order->shop->user->email)->later(now()->addMinutes(10), new OrderDelivered($order, $message, $captured));
                } else {
                    Mail::to($order->shop->user->email)->send(new OrderConfirmed($order, $message, $captured));
                }
            } else {
                if ($captured) {
                    Mail::to($order->shop->user->email)->send(new OrderConfirmed($order, 'Order has been confirmed', false));
                    Mail::to($order->shop->user->email)->later(now()->addMinutes(10),new OrderDelivered($order, 'Order has been confirmed', $captured));
                } else {
                    Mail::to($order->shop->user->email)->send(new OrderConfirmed($order, 'Order has been confirmed', $captured));
                }
            }

            PurchaseComplete::dispatch($order);

            $message =  'Order placed on ' . $order->created_at->format('M d, Y') . ' has been confirmed.';
            Mail::to($order->email)->send(new OrderConfirmed($order, $message, $captured));

            return redirect()->route('thankyou', ['user_name' => $order->shop->user_name, 'order' => $order]);
        } catch (Exception $e) {
            return redirect()->route('shop.home', $order->shop->user_name)->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->route('shop.home', $order->shop->user_name)->withErrors($e->getMessage());
        }
    }

    public function twoPaymentSuccess(Order $order)
    {

        (new TwoPayment($order->shop, $order))->confirm();

        return redirect()->route('thankyou', ['user_name' => $order->shop->user_name, 'order' => $order]);
    }

    public function elavonPaymentSuccess(Request $request)
    {

        try {


            $order = Order::where('payment_id', $request->sessionId)->first();
            $response = (new ElavonPayment($order))->processPayment($request->sessionId);
            $order->createMeta('elavon_transaction_id', $response['id']);
            if ($response['state']) {
                $order->status = 5;
                $order->payment_status = true;
                $order->paid_at = now();
                $order->save();
                if ($order->is_vcard) {
                    $message =  "Order has been confirmed . Download details from here: <a href='" . route('order.managers-csv', $order->id) . "'>Download CSV</a>";
                    Mail::to($order->shop->user->email)->send(new OrderConfirmed($order, $message, true));
                } else {
                    Mail::to($order->shop->user->email)->send(new OrderConfirmed($order, 'Order has been confirmed', true));
                }

                PurchaseComplete::dispatch($order);

                $message =  'Order placed on ' . $order->created_at->format('M d, Y') . ' has been confirmed.';
                Mail::to($order->email)->send(new OrderConfirmed($order, $message, true));
                return redirect()->route('thankyou', ['user_name' => $order->shop->user_name, 'order' => $order]);
            } else {
                throw new Exception('Payment is not accepted');
            }
        } catch (Exception $e) {
            return redirect()->route('shop.home', $order->shop->user_name)->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->route('shop.home', $order->shop->user_name)->withErrors($e->getMessage());
        }
    }
    public function elavonApiPaymentSuccess(Request $request)
    {

        try {


            $order = ExternalOrder::where('payment_id', $request->sessionId)->first();
            $response = (new ApiElavonPayment($order))->processPayment($request->sessionId);
            $order->response = $response['id'];
          
            if ($response['state']) {
                $order->status = 'COMPLETED';
    
                $order->save();
                // if ($order->is_vcard) {
                //     $message =  "Order has been confirmed . Download details from here: <a href='" . route('order.managers-csv', $order->id) . "'>Download CSV</a>";
                //     Mail::to($order->shop->user->email)->send(new OrderConfirmed($order, $message, true));
                // } else {
                //     Mail::to($order->shop->user->email)->send(new OrderConfirmed($order, 'Order has been confirmed', true));
                // }

                // PurchaseComplete::dispatch($order);

                // $message =  'Order placed on ' . $order->created_at->format('M d, Y') . ' has been confirmed.';
                // Mail::to($order->email)->send(new OrderConfirmed($order, $message, true));
                return redirect($order->success_redirect_url);
            } else {
                throw new Exception('Payment is not accepted');
            }
        } catch (Exception $e) {
            return redirect($order->failed_redirect_url);
        } catch (Error $e) {
            return redirect($order->failed_redirect_url);
        }
    }
    public function elavonApiPaymentCancel($order_id)
    {
        $order = ExternalOrder::where('id', $order_id)->first();
        $order->status = "CANCELED";
        $order->save();
        return redirect($order->failed_redirect_url);
    }
    public function elavonPaymentCancel($order_id)
    {
        $order = Order::where('id', $order_id)->first();
        return redirect()->route('shop.home', $order->shop->user_name)->withErrors('Order canceled');
    }

    public function subscriptionSuccess($subscription_id)
    {
        // Retrieve the order based on the payment ID
        $order = Order::where('payment_id', $subscription_id)->first();
        if ($order) {
            // Get the QuickPay API key from the associated shop
            $subscriptionKey = $order->shop->quickpay_api_key;

            // Initialize the Subscribe class with the API key and retrieve the subscription details
            $quickPay = (new Subscribe($subscriptionKey))->subscription($subscription_id);
            $sub = $quickPay->get()['data'];

            // Check if the subscription was accepted
            if ($sub->accepted == true) {
                // Update the order status and payment status
                $order->status = 5;
                $order->payment_status = 1;
                $order->save();

                // Retrieve the package and trainer associated with the order
                $package = Package::find($order->package);
                $trainer = User::find($order->trainer);

                // Retrieve the client (user who made the order)
                $client = $order->user;

                // Add credits to the client's account for the specified shop and trainer
                if ($package->type == 'default') {
                    (new CreditWallet($client, $trainer))->deposit($package->getDuration($client->split == true), 'session_credits', $package->validity);
                } else {
                    (new CreditWallet($client, $trainer))->deposit($package->getDuration($client->split == true), 'subscription_credits', $package->validity);
                }
                // Create a meta record for the client indicating the personal trainer
                $client->createMeta('personal_trainner', $order->trainer);

                // Update the client's "pt_trainer_id" with the trainer ID from the order
                $client->pt_trainer_id = $order->trainer;
                $client->pt_package_id = $order->package;
                $client->pt_package_price = $order->total;
                $client->save();

                // Retrieve the credit record for the client, shop, and trainer
                $credit = $client->getCredit($order->shop->id, $trainer->id);

                // Charge the order total using QuickPay
                $charge = $quickPay->charge($order->total);

                // Create or update a subscription record with the relevant details
                $model = Subscription::updateOrCreate(['key' => $subscription_id], [
                    'key' => $subscription_id,
                    'url' => $sub->link->url,
                    'fee' => $order->total,
                    'paid_at' => now(),
                    'status' => $order->renew == 1 ? true : false,
                    'establishment_status' => true,
                    'subscribable_id' => $credit->id,
                    'subscribable_type' => get_class($credit),
                ]);

                // Pause execution for 5 seconds (optional)
                sleep(5);

                // Create a charge record for the subscription
                $model->charges()->create([
                    'amount' => $order->total,
                    'status' => true
                ]);
            }



            // Check if the user is authenticated
            if (!auth()->check()) {
                // Redirect to the shop's home page with a success message
                return redirect(route('shop.home', $order->shop->user_name))->with('success', 'Payment Confirmed');
            } else {
                if ($order->user_id == auth()->id()) {
                    // Redirect to the trainer services schedule page
                    return redirect()->route('trainer_services.schedule', ['user_name' => $order->shop->user_name, 'user' => $trainer, 'option' =>  $order->shop->defaultoption]);
                } else {
                    // Redirect to the shop's home page with a success message
                    return redirect(route('shop.home', $order->shop->user_name))->with('success', 'Payment Confirmed');
                }
            }
        } else {
            $subscription = Subscription::where('key', $subscription_id)->first();
            $quickPay = (new Subscribe())->subscription($subscription_id);

            $sub = $quickPay->get()['data'];
            if ($sub->accepted == true) {
                $subscription->paid_at = now();
                $subscription->status = 1;
                $subscription->save();

                $charge = $quickPay->charge($subscription->fee());

                sleep(5);

                $subscription->charges()->create([
                    'amount' => $subscription->fee(),
                    'status' => true,
                    'quickpay_order_id' => $charge['data']->order_id,
                    'charge_details' => json_encode($charge['data']),
                    'payment_details' => json_encode([
                        'enterprise' => [
                            'uid' => $subscription->subscribable->unqid,
                            'name' => $subscription->subscribable->enterprise_name,
                            'domain' => $subscription->subscribable->domain,
                        ],
                        'detials' => $subscription->feeDetails()

                    ]),

                ]);

                $subscription->subscribable()->update(
                    [
                        'paid_at' => now(),
                        'status' => true
                    ]
                );
            }

            return redirect($subscription->subscribable->domain . '/admin/admin/confirm_subscription/' . $subscription->subscribable->unqid);
        }
    }



    public function subscriptionCallback()
    {
        $request_body = file_get_contents("php://input");
        $checksum     = $this->sign($request_body, setting('payment.private_key'));
        $payment = json_decode($request_body);
        $charge = Charge::where('order_id', $payment->order_id)->first();
        if ($checksum == $_SERVER["HTTP_QUICKPAY_CHECKSUM_SHA256"]) {

            if ($charge && $payment->state == 'processed') {
                $charge->shop->update([
                    'status' => 1,
                    'paid_at' => Carbon::now(),
                ]);
                $charge->update([
                    'status' => 1,
                    'details' => json_encode($charge->shop->subscriptionFeeDetails()),
                ]);
                $mail_data = [
                    'subject' => 'Subscription auto renew',
                    'body' => 'Your subscription to webshop has auto renewed',
                    'button_link' => route('shop.dashboard'),
                    'button_text' => 'Visit',
                    'emails' => [],
                ];
                if (@$charge?->shop?->user) {
                    Mail::to($charge->shop->user->email)->send(new NotificationEmail($mail_data));
                }
            }
        } else {
            $charge->shop->update([
                'status' => 0,
            ]);
        }
    }
    private function sign($base, $private_key)
    {
        return hash_hmac("sha256", $base, $private_key);
    }
    public function confirmUserSubscription($user_name, $subscription_id)
    {

        $shop = Shop::where('user_name', $user_name)->firstOrFail();
        $quickPay = new UserSubscription($shop);

        if ($quickPay->checkSubscription($subscription_id)) {
            $membership = Membership::where('order_id', $quickPay->subscription($subscription_id)->order_id)->first();

            $membership->subscription_id = $quickPay->subscription($subscription_id)->id;
            $membership->save();

            if ($membership->status == 1) {
                return redirect()->route('user.memberships', $membership->shop->user_name)->withSuccess('Thank your for subscribe');
            }
            if ($membership->paid_at) {
                if ($membership->paid_at->isSameMonth(today())) {
                    $membership->status = 1;
                    if ($membership->establishment_status == 0) $membership->establisment_status = 1;
                    $membership->save();
                    return redirect()->route('user.dashboard', $membership->shop->user_name)->withSuccess('Thank your for subscribe');
                }
            }
            $charge_status = $quickPay->chargeViaSubscription($membership, 'Subscription fee');
            if ($charge_status) {
                $membership->status = 1;
                if ($membership->establishment_status == 0) $membership->establisment_status = 1;
                $membership->paid_at = Carbon::now();

                $membership->save();

                Mail::to($membership->email)->send(new SubscriptionBoxInvoice($membership, 'Thank your for subscribe'));
                return redirect()->route('user.dashboard', $membership->shop->user_name)->withSuccess('Thank your for charge');
            }
        }




        return redirect(route('user.dashboard', $membership->shop->user_name))->withErrors('There is a problem with your Payment method. Please try again later');
    }
}
