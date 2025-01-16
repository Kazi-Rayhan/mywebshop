<?php

namespace App\Payments\Subscription;


use App\Models\Shop;
use QuickPay\QuickPay;

class SubscriptionPayment
{
    protected $payment;

    public function __construct($api)
    {
        $this->payment = new QuickPay(":{$api}");
    }
    

    public function getPaymentUrlForSubscription($model): string
    {
        define('SUCCESS', 201);

        $order_id = rand(9999, 9999999999);
        $subscribe = $this->payment->request->post('/subscriptions', [
            'order_id' => $order_id,
            'currency' => 'NOK',
            'description' => "Subscription for " . " #" . $model->id . ' ' . substr(get_class($model), 11)
        ]);
        $status = $subscribe->httpStatus();
        if ($status === SUCCESS) {
            $subscriptionInstance = $subscribe->asObject();
            $endpoint = sprintf("/subscriptions/%s/link", $subscriptionInstance->id);

            $subscription = $this->payment->request->put($endpoint, [
                "language" => "en",
                "currency" => "NOK",
                "autofee" => 0,
                "order_id" => $subscriptionInstance->order_id,
                "continueurl" => $model->subscription_continue_url(),
                "cancelurl" => $model->subscription_cancel_url(),
                "amount" => $model->subscriptionFee() * 100

            ]);
            $model->subscribe()->create([
                'payment_url' => $subscription->asObject()->url,
                'order_id' => $order_id,
            ]);

            return $model->subscribe->payment_url;
        }
      
        return route('subscription.failed', $model->shop->user_name);
    }

    private function subscription($key)
    {
        $subscription = $this->payment->request->get(sprintf("/subscriptions/%s", $key));
        return $subscription->asObject();
    }
    public function subscribe($key,$model)
    {
        $subscription = $this->subscription($key);
        $model = $model->where('')
        if ($subscription->accepted == true) {
            $this->model->subscribe->key = $subscription->id;
            $this->model->subscribe->save();
        };

        if ($this->model->subscribe->status  == 1) {
            return true;
        } else {
            $charge = $this->charge();
            if ($charge == false) return false;
            $this->model->subscribe->status = 1;

            if ($this->model->subscribe->establishment_status == 0) {
                $this->model->subscribe->establishment_status = 1;
            }
    
            $this->model->subscribe->paid_at = now();

            $this->model->subscribe->save();

            return true;
        }
        return false;
    }

    private function charge()
    {

        $order_id = hexdec(uniqid());
        $payment = $this->payment->request->post(sprintf("/subscriptions/%s/recurring", $this->model->subscribe->key), [
            'auto_capture' => true,
            'amount' => $this->model->subscriptionFee() * 100,
            'order_id' => $order_id
        ]);
        sleep(5);
        if (isset($payment->asObject()->id)) {
            $payment_check = $this->payment->request->get(sprintf("/payments/%s", $payment->asObject()->id));
            if ($payment_check->asObject()->state == 'processed') {
                $charge = $this->model->subscribe->charges()->create([
                    'amount' => $this->model->subscriptionFee(),
                    'status' => true
                ]);
                return $status = true;
            }
        }
        return $status = false;
    }
}
