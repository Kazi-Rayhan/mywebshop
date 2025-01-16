<?php

namespace App\Payment;

use App\Models\Subscription;
use Iziibuy;
use QuickPay\QuickPay;

class Subscribe

{
    const STATUS = ['SUCCESS' => 201];
    const ENDPOINT = [
        'SUBSCRIPTION' => '/subscriptions',
        'GET_SUBSCRIPTION_URL' => '/subscriptions/%s/link',
        'CHARGE' => '/subscriptions/%s/recurring'
    ];
    protected $client;
    public $subscription;
    protected $isEnterprise;
    public $api;
    public function __construct($api = null)
    {
        $this->api = Iziibuy::isEnterprise() ? Iziibuy::quickpay_api_key() : $api ?? Iziibuy::quickpay_api_key();
        $this->client = new QuickPay(":{$this->api}");
    }

    public function enterprise()
    {
        $this->isEnterprise = true;
        return $this;
    }
    public function subscription($id = null)
    {

        if ($id) {

            $this->subscription = $this->client->request->get(sprintf($this::ENDPOINT['SUBSCRIPTION'] . '/%s', $id))->asObject();
        } else {

            $this->subscription = $this->client->request->post($this::ENDPOINT['SUBSCRIPTION'], [
                'order_id' => rand(4444, 999999999),
                'currency' => 'NOK',
                'description' => "Subscription",
                "variables" => [
                    'plan' => "Subscription for " . rand(4444, 999999999),
                    'created_at' => now()->format('d M, Y')
                ]
            ])->asObject();
        }
        return $this;
    }



    public function getUrl($fee, $shop = false, array $url = null)
    {
        $endpoint = sprintf($this::ENDPOINT['GET_SUBSCRIPTION_URL'], $this->subscription->id);
        if ($this->isEnterprise) {
            $params = [
                "language" => "en",
                "currency" => "NOK",
                "autofee" => 0,
                "order_id" => $this->subscription->order_id,
                "continueurl" => route('admin.confirm_subscription', $this->subscription->id),
                "cancelurl" => route('voyager.dashboard'),
                "amount" => $fee * 100,
                "variables" => [
                    'plan' => "Subscription for " . $this->subscription->id,
                    'price' => $fee,
                    'created_at' => now()->format('d M, Y')
                ]

            ];
        } else {

            if (!$url) {
                $url = [
                    "continueurl" => $shop == true ? route('shop.confirm.subscription', $this->subscription->id) : route('callback.subscription.success', $this->subscription->id),
                    "cancelurl" => $shop == true ? route('shop.subscription.payment') :  route('callback.subscription.cancel', $this->subscription->id),
                ];
            }

            $params = [
                "language" => "en",
                "currency" => "NOK",
                "autofee" => 0,
                "order_id" => $this->subscription->order_id,
                "amount" => $fee * 100,
                "variables" => [
                    'plan' => "Subscription for " . $this->subscription->id,
                    'price' => $fee,
                    'created_at' => now()->format('d M, Y')
                ]

            ];
            $params = array_merge($params, $url);
        }

        $url = $this->client->request->put($endpoint, $params);

        return [
            'status' => $url->httpStatus() != 200 ? false : true,
            'data' => $url->httpStatus() != 200 ? (array) $url->asObject() : [
                'payment_id' => $this->subscription->id,
                'url' => $url->asObject()->url
            ]

        ];
    }





    public function charge($amount, $auto_capture = true)
    {
        $charge = $this->client->request->post(sprintf("/subscriptions/%s/recurring", $this->subscription->id), [
            'auto_capture' => $auto_capture,
            'amount' => $amount * 100,
            'order_id' => hexdec(uniqid())
        ]);
        sleep(10);
        return [
            'status' => $charge->httpStatus() != 202 ? false : true,
            'data' =>  $charge->asObject()
        ];
    }


    public function get()
    {

        return [
            'status' => isset($this->subscription->id) ? true : false,
            'data' => $this->subscription
        ];
    }

    public function unsubscibe($shop)
    {
        $payment = $this->client->request->post(sprintf("/subscriptions/%s/cancel", $shop->subscription_id), [
            'id' => $shop->subscription_id
        ]);
        $shop->update([
            'subscription_id' => null
        ]);
        sleep(5);
        $subscription = $this->subscription($shop->subscription_id)->get();
        return $subscription;
    }



    public function stopsubscription(Subscription $subscription)
    {
        $this->client->request->post(sprintf("/subscriptions/%s/cancel", $subscription->key), [
            'id' => $subscription->key
        ]);
        $subscription->update([
            'status' => 0
        ]);

        $subscription = $this->subscription($subscription->key)->get();
        return $subscription;
    }

    public function startubscription(Subscription $subscription)
    {
        $this->client->request->post(sprintf("/subscriptions/%s/start", $subscription->key), [
            'id' => $subscription->key
        ]);
        $subscription->update([
            'status' => 1
        ]);

        $subscription = $this->subscription($subscription->key)->get();
        return $subscription;
    }

    public function payment($id)
    {


        $charge = $this->client->request->get(sprintf("/payments/%s", $id))->asObject();

        return [
            'status' => isset($charge->id) ? true : false,
            'data' =>  $charge
        ];
    }
}
