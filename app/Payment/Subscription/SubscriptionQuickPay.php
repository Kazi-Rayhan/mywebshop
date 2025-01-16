<?php

namespace App\Payment\Subscription;

use App\Models\Order;
use App\Models\Subscription;
use Exception;
use Illuminate\Support\Carbon;
use QuickPay\QuickPay;
use TCG\Voyager\Models\Setting;
use Iziibuy;

class SubscriptionQuickPay

{
    protected QuickPay $quickPay;
    protected int $id;
    public $api;
    public $order;
    public function __construct($api, Order $order = null)
    {
        $this->order = $order;
        $this->api = Iziibuy::isEnterprise() ? setting('payment.api_key') : $api;
        $this->quickPay = new QuickPay(":{$api}");
        $this->id = $order->id;
    }

    public function get_subscription_payment_url($shop, $fee)
    {

        define('SUCCESS', 201);

        $id = $this->id . '-' . rand(10, 100);
        $request_for_subscription = $this->quickPay->request->post('/subscriptions', [
            'order_id' => $this->id . '-' . rand(10, 100),
            'currency' => 'NOK',
            'description' => "Subscription for " . $this->id,
            "variables" => [
                'plan' => "Subscription for " . $id,
                'created_at' => now()->format('d M, Y')
            ]
        ]);

        if ($request_for_subscription->httpStatus() == SUCCESS) {
            $request_for_subscription_as_object = $request_for_subscription->asObject();
            $end_point_for_suscription_payment_link_request = sprintf("/subscriptions/%s/link", $request_for_subscription_as_object->id);
            $request_for_suscription_payment_link = $this->quickPay->request->put($end_point_for_suscription_payment_link_request, [
                "language" => "en",
                "currency" => "NOK",
                "autofee" => 0,
                "order_id" => $request_for_subscription_as_object->order_id,
                "continueurl" => route('subscription.confirm', [$shop->user_name, $request_for_subscription_as_object->id]),
                "cancelurl" => route('shop.home', $shop->user_name),
                "amount" => $fee * 100

            ]);

            return $request_for_suscription_payment_link->asObject()->url;
        }
        throw new Exception('Subscription url failed');
    }

    public function getSubscription($id)
    {
        $check_subscription_status = $this->quickPay->request->get(sprintf("/subscriptions/%s", $id));
        return $check_subscription_status->asObject();
    }

    // public function checkSubscription($subscription_id): bool
    // {
    //     $subscription = $this->getSubscription($subscription_id);

    //     if ($subscription->accepted == true) {
    //         return true;
    //     }

    //     return false;
    // }

    // public function subscribe($id)
    // {
    //     $check_subscription_status = $this->getSubscription($id);

    //     if ($check_subscription_status->accepted == true) {

    //         $subscription = Subscription::where('order_id', $check_subscription_status->order_id)->first();


    //         $subscription->key = $check_subscription_status->id;
    //         $subscription->save();

    //         if ($subscription->status == 1) {
    //             return true;
    //         } else {
    //             $charge = $this->charge($subscription, $subscription->fee);
    //             if ($charge) {
    //                 $subscription->status = 1;
    //                 if ($subscription->establishment_status == 0) $subscription->establisment_status = 1;
    //                 $subscription->paid_at = Carbon::now();
    //                 $subscription->save();

    //                 return true;
    //             } else {
    //                 return false;
    //             }
    //         }
    //     }
    //     return false;
    // }


    public function subscribeWithouthCharge($id)
    {
        $check_subscription_status = $this->getSubscription($id);


        if ($check_subscription_status->accepted == true) {
            $subscription = Subscription::where('order_id', $check_subscription_status->order_id)->first();
            $subscription->key = $check_subscription_status->id;
            $subscription->establisment_status = 1;
            $subscription->status = 1;
            $subscription->paid_at = Carbon::now();
            $subscription->save();
            return true;
        }
        return false;
    }

    public function unsubscribe()
    {
    }

    public function charge(Subscription $subscription, $amount)
    {

        $order_id = hexdec(uniqid());

        $payment = $this->quickPay->request->post(sprintf("/subscriptions/%s/recurring", $subscription->key), [
            'auto_capture' => true,
            'amount' => $amount * 100,
            'order_id' => $order_id
        ]);
        if (isset($payment->asObject()->id)) {
            $subscription->charges()->create([
                'amount' => $amount,
                'status' => true
            ]);
            return true;
        }
        return false;
    }
}
