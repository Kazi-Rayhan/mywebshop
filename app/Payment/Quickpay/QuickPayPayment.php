<?php

namespace App\Payment\Quickpay;

use App\Models\Enterprise;
use App\Models\Order;
use Error;
use Exception;
use QuickPay\QuickPay;
use Iziibuy;

class QuickPayPayment
{
    private $api_key;
    private $enterprise;
    private $client;
    private $order;
    private $payment_id;
    public function __construct(Order $order)
    {
        $this->order = $order;

        $this->api_key = Iziibuy::isEnterprise() ? Iziibuy::quickpay_api_key() : $order->shop->quickpay_api_key;
        $this->client = new QuickPay(":{$this->api_key}");
        $this->enterprise = Enterprise::first();
        $this->payment_id = rand(4444, 999999999);
    }

    public function createNewPayment()
    {
        return $this->client->request->post('/payments', [
            'order_id' => $this->payment_id,
            'currency' => $this->order->currency,
            "variables" => [
                'subtotal' => $this->order->subtotal ?? 0,
                'shipping' => $this->order->shipping_cost ?? 0,
                'vat' => $this->order->tax ?? 0,
                'created_at' => $this->order->created_at->format('d M, Y')
            ]
        ]);
    }

    public function getPaymentLink($autocapture = false)
    {
        try {


            $payment = $this->createNewPayment();
            define('PAYMENT_CREATED_SUCCESSFULLY', $payment->httpStatus() === 201);

            if (PAYMENT_CREATED_SUCCESSFULLY) {
                $paymentObject = $payment->asObject();
                $endpoint = sprintf("/payments/%s/link", $paymentObject->id);

                $link = $this->client->request->put($endpoint, [
                    "language" => "en",
                    "currency" => $this->order->currency,
                    "autocapture" => $autocapture,
                    "autofee" => 0,
                    "order_id" => $paymentObject->order_id,
                    "continueurl" => route('callback.payment.success', [$paymentObject->id, $this->order]),
                    "cancelurl" => route('shop.home', $this->order->shop->user_name),
                    "amount" => $this->order->total * 100,

                ]);
                if ($link->asObject()->url) {
                    return [
                        'status' => true,
                        'data' => [
                            'payment_id' => $paymentObject->id,
                            'url' => $link->asObject()->url
                        ]
                    ];
                }
            }
            return [
                'status' => false,
                'data' => [
                    'message' => $payment->asObject()->message
                ]
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'data' => [
                    'message' => $e->getMessage()
                ]
            ];
        } catch (Error $e) {
            return [
                'status' => false,
                'data' => [
                    'message' => $e->getMessage()
                ]
            ];
        }
    }

    public function paymentStatus($paymentId)
    {
        try {
            $endpoint = sprintf("/payments/%s", $paymentId);
            $payment = $this->client->request->get($endpoint);
            return  [
                'status' => true,
                'data' => (array) $payment->asObject()
            ];
        } catch (Exception $e) {
            return  [
                'status' => false,
                'data' => [
                    'message' => $e->getMessage()
                ]
            ];
        } catch (Error $e) {
            return  [
                'status' => false,
                'data' => [
                    'message' => $e->getMessage()
                ]
            ];
        }
    }

    public function capture()
    {
        try {
            $endpoint = sprintf("/payments/%s/capture", $this->order->payment_id);
            $payment = $this->client->request->post($endpoint, ['amount' => $this->order->total * 100]);
            return  [
                'status' => true,
                'data' => (array) $payment->asObject()
            ];
        } catch (Exception $e) {
            return  [
                'status' => false,
                'data' => [
                    'message' => $e->getMessage()
                ]
            ];
        } catch (Error $e) {
            return  [
                'status' => false,
                'data' => [
                    'message' => $e->getMessage()
                ]
            ];
        }
    }
}
