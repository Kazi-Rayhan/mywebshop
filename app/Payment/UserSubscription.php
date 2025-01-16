<?php

namespace App\Payment;

use App\Models\Membership;
use App\Models\MembershipCharge;
use App\Models\Shop;
use Exception;
use QuickPay\QuickPay;

class UserSubscription
{
    private $api_key;
    private $client;

    public function __construct(Shop $shop)
    {
        $this->client = new QuickPay(":{$shop->quickpay_api_key}");
    }

    public function subscribe(Membership $membership)
    {
        $order_id = rand(9999, 9999999999);
        $subscribe = $this->client->request->post('/subscriptions', [
            'order_id' => $order_id,
            'currency' => 'NOK',
            'description' => "Membership , id: $membership->id",
            "variables" => [
                'plan' => "Subscription for " . $membership->subscription_id,
                'price' => $membership->subscriptionFee() * 100,
                'created_at' => now()->format('d M, Y')
            ]

        ]);

        $status = $subscribe->httpStatus();

        if ($status === 201) {
            $subscriptionInstance = $subscribe->asObject();

            $endpoint = sprintf("/subscriptions/%s/link", $subscriptionInstance->id);

            $subscription = $this->client->request->put($endpoint, [
                "language" => "en",
                "currency" => "NOK",
                "autofee" => 0,
                "order_id" => $subscriptionInstance->order_id,
                "continueurl" => route('confirm.userSubscription', [$membership->shop->user_name, $subscriptionInstance->id]),
                "cancelurl" => route('subscription-boxes', ['user_name' => request()->user_name]),
                "amount" => $membership->subscriptionFee() * 100

            ]);
            $membership->payment_url = $subscription->asObject()->url;
            $membership->order_id = $order_id;
            $membership->update();

            return $subscription->httpStatus();
        }
    }

    public function subscription($subscription_id)
    {
        $subscription = $this->client->request->get(sprintf("/subscriptions/%s", $subscription_id));
        if($subscription->status_code == 401){
            throw new Exception($subscription->asObject()->message);
        }
        return $subscription->asObject();
    }

    public function checkSubscription($subscription_id): bool
    {
        $subscription = $this->subscription($subscription_id);

        if ($subscription->accepted == true) {
            return true;
        }

        return false;
    }
    public function payment(Membership $membership)
    {
        $quick_pay_order_id = rand(4444, 999999999);
        $payment = $this->client->request->post('/payments', [
            'order_id' => $quick_pay_order_id,
            'currency' => 'NOK'
        ]);

        $status = $payment->httpStatus();

        if ($status === 201) {
            $paymentObject = $payment->asObject();
            $endpoint = sprintf("/payments/%s/link", $paymentObject->id);

            $link = $this->client->request->put($endpoint, [
                "language" => "en",
                "currency" => "NOK",
                "autocapture" => true,
                "autofee" => 0,
                "order_id" => $paymentObject->order_id,
                "continueurl" => route('confirmPayment', $paymentObject->id),
                "cancelurl" => route('shop.home', ['user_name' => $membership->shop->user_name]),
                "amount" => $membership->subscriptionFee() * 100,

            ]);
            $membership->payment_url = $link->asObject()->url;
            $membership->order_id = $quick_pay_order_id;
            $membership->save();
        }
        return $link;
    }

    public function paymentStatus($paymentid)
    {
        $endpoint = sprintf("/payments/%s", $paymentid);
        $payment = $this->client->request->get($endpoint);

        return $payment;
    }

    public function chargeViaSubscription(Membership $membership)
    {

        $order_id = hexdec(uniqid());
        $payment = $this->client->request->post(sprintf("/subscriptions/%s/recurring", $membership->subscription_id), [
            'auto_capture' => true,
            'amount' => $membership->subscriptionFee() * 100,
            'order_id' => $order_id
        ]);
        sleep(5);
        if (isset($payment->asObject()->id)) {
            $payment_check = $this->client->request->get(sprintf("/payments/%s", $payment->asObject()->id));
            if ($payment_check->asObject()->state == 'processed') {
                $charge = MembershipCharge::create([
                    'shop_id' => $membership->shop->id,
                    'membership_id' => $membership->id,
                    'amount' => $membership->subscriptionFee(),
                    'status' => true
                ]);
                return $status = true;
            }
        }
        return $status = false;
    }

    public function unsubscibe(Shop $shop)
    {
        $payment = $this->client->request->post(sprintf("/subscriptions/%s/cancel", $shop->subscription_id), [
            'id' => $shop->subscription_id
        ]);
        $shop->update([
            'subscription_id' => null
        ]);
        sleep(5);
        $subscription = $this->subscription($shop->subscription_id);
        return $subscription;
    }
}
