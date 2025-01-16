<?php

namespace App\Payment\Two;

use App\Models\Order;
use App\Models\Shop;
use Error;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Http;
use Iziibuy;

class TwoPayment
{

    private $order;
    private  $API;
    private $MERCHANT_SHORT_NAME;
    private $MERCHANT_ID;
    private $API_KEY;
    private $payment_id;




    public function __construct(Shop $shop, Order $order)
    {
        $this->order = $order;
        $this->API = env('TWO_API_ENDPOINT', 'sandbox.api.two.inc/v2/');
        $this->MERCHANT_SHORT_NAME = env('TWO_API_MERCHANT_SHORT_NAME', '2izii');
        $this->MERCHANT_ID = env('TWO_API_MERCHANT_SHORT_NAME', '0ab5dd59-4698-4208-89a6-d1e5c6660596');
        $this->API_KEY = env('TWO_API_KEY', 'secret_test_xW3ISgdIC8diLZR2I7OKasEVpA7EPEeH4bU97kRAWqc');
        // $this->API = env('TWO_API_ENDPOINT', 'sandbox.api.two.inc/v1/');
        // $this->MERCHANT_SHORT_NAME = $shop->merchnat_short_name;
        // $this->MERCHANT_ID = $shop->merchant_id;
        // $this->API_KEY = $shop->two_api_key;
        // $this->payment_id = $order->payment_id;
    }

    private function sendRequest(string $request, array $body = [])
    {

        $apis = [
            'intent' => "order_intent",
            'create' => "order",
            'confirm' =>  "order/" . $this->payment_id . "/confirm",
            'fulfilled' =>  "order/" . $this->payment_id . "/fulfilled",
            'cancel' => "order/" . $this->payment_id . "/cancel",
            'refund' => "order/" . $this->payment_id . "/refund"

        ];
        $url = $this->API . $apis[$request];
        return  json_decode(
            Http::withHeaders([
                'X-API-Key' => $this->API_KEY,
            ])->post($url, $body)->body()
        );
    }

    public function compose_body()
    {

        $billing_and_shipping_address = [
            'organization_name' => $this->order->company_name,
            'street_address' => $this->order->address,
            'postal_code' => $this->order->post_code,
            'city' => $this->order->city,
            'region' => $this->order->state,
            'country' => strtoupper($this->order->company_country_prefix)
        ];

        $items =  $this->order->products->map(function ($product) {

            $gross_amount = (float) Iziibuy::round_num(($product->pivot->price) * $product->pivot->quantity);

            $net_amount = (float) Iziibuy::round_num($gross_amount / (1 + ($product->tax) / 100));

            $tax_amount =  (float) Iziibuy::round_num($gross_amount - $net_amount);

            return [
                'line_items' => [
                    "type" => "PHYSICAL",
                    "name" => $product->name,
                    "description" => Str::limit(strip_tags($product->description), 100),
                    "discount_amount" => 0,
                    "gross_amount" => $gross_amount,
                    "net_amount" => $net_amount,
                    "quantity" => $product->pivot->quantity,
                    "unit_price" => (int) $product->pivot->price,
                    "tax_amount" => $tax_amount,
                    "tax_rate" =>  (float) number_format($product->tax / 100, 2),
                    "tax_class_name" => "VAT " . $product->tax . "%",
                    "quantity_unit" => "pcs",
                    "image_url" => Iziibuy::image($product->image),
                    "product_page_url" => $product->path(),
                    "details" => [
                        "brand" => $product->shop->name ?? '',
                        "categories" =>  [...$product->categories->pluck('name')],
                        "part_number" => (string) $product->id
                    ],
                    "prototype_id" =>  (string) Str::uuid()
                ],
                'tax_subtotals' => [
                    'tax_amount' => $tax_amount,
                    'tax_rate' => (float) number_format($product->tax / 100, 2),
                    'taxable_amount' => $net_amount
                ]
            ];
        });

        $line_items = [...$items->pluck('line_items')];
        $tax_subtotals = [...$items->pluck('tax_subtotals')];


        $req_body = [
            'currency' => $this->order->get_currency(),
            'gross_amount' => $this->order->total,
            'net_amount' => $this->order->subtotal,
            'tax_amount' => $this->order->tax,
            'discount_amount' => $this->order->disocunt ?? 0,
            'discount_rate' => ($this->order->disocunt / $this->order->total) * 100,
            'invoice_type' => 'FUNDED_INVOICE',
            'buyer' => [
                'company' => [
                    'organization_number' => $this->order->company_id,
                    'country_prefix' => strtoupper($this->order->company_country_prefix),
                    'company_name' => $this->order->company_name
                ],
                'representative' => [
                    'email' => $this->order->email,
                    'first_name' => $this->order->first_name,
                    'last_name' => $this->order->last_name,
                    'phone_number' => $this->order->phone
                ],
            ],
            'line_items' => $line_items,
            'tax_subtotals' => $tax_subtotals,
            'recurring' => false,
            'merchant_additional_info' => '',
            'merchant_order_id' => (string)     $this->order->id,
            'merchant_reference' => '',
            'merchant_urls' => [
                'merchant_confirmation_url' => route('thankyou', [$this->order->shop->user_name, 'order' => $this->order->id]),
            ],
            'billing_address' => $billing_and_shipping_address,
            'shipping_address' => $billing_and_shipping_address,
            "merchant_id" => $this->MERCHANT_ID,
            "merchant_short_name" => $this->MERCHANT_SHORT_NAME,
            "order_origination" => "ONLINE"
        ];
        return $req_body;
    }

    private function refund_body($amount, $reason)
    {
        $items =  $this->order->products->map(function ($product) {
            $tax = Iziibuy::round_num($product->pivot->price * ($product->tax / 100));
            $gross_amount = (float) Iziibuy::round_num(($product->pivot->price) * $product->pivot->quantity);
            $net_amount = (float) Iziibuy::round_num(($product->pivot->price - $tax) * $product->pivot->quantity);
            $tax_amount = (float)Iziibuy::round_num($gross_amount - $net_amount);
            return [
                "type" => "PHYSICAL",
                "name" => $product->name,
                "description" => Str::limit(strip_tags($product->description), 100),
                "discount_amount" => 0,
                "gross_amount" => $gross_amount,
                "net_amount" => $net_amount,
                "quantity" => $product->pivot->quantity,
                "unit_price" => (int) $product->pivot->price,
                "tax_amount" => $tax_amount,
                "tax_rate" => number_format($product->tax / 100, 2),
                "tax_class_name" => "VAT " . $product->tax . "%",
                "quantity_unit" => "pcs",
                "image_url" => Iziibuy::image($product->image),
                "product_page_url" => $product->path(),
                "details" => [
                    "brand" => $product->shop->name ?? '',
                    "categories" =>  [...$product->categories->pluck('name')],
                    "part_number" => (string) $product->id
                ],
                "prototype_id" =>  (string) Str::uuid()
            ];
        });
        $line_items = [...$items];

        $req_body = [
            'amount' => $amount,
            'currency' => $this->order->get_currency(),
            'initiate_payment_to_buyer' => true,
            'line_items' => $line_items,
            'reason' => $reason
        ];
        return $req_body;
    }


    public  function getPaymentLink()
    {

        try {
            $response = $this->sendRequest('create', $this->compose_body());
            if (isset($response->error_code)) throw new Exception($response->error_details);
            return [
                'status' => true,
                'data' => [
                    'payment_id' => $response->id,
                    'url' => $response->payment_url
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

    public  function orderIntent()
    {
        $response = $this->sendRequest('intent', $this->compose_body());

        return $response;
    }

    public function confirm()
    {
        $response = $this->sendRequest('confirm');

        DB::beginTransaction();
        $this->order->payment_status = 1;
        $this->order->status = 1;
        $this->order->save();
        DB::commit();
        return $response;
    }

    public function fulfilled()
    {

        $response = $this->sendRequest('fulfilled');

        DB::beginTransaction();
        $this->order->status = 5;
        $this->order->payment_status = 1;
        $this->order->save();
        DB::commit();
        return $response;
    }

    public function cancel()
    {
        $response = $this->sendRequest('cancel');
        DB::beginTransaction();
        $this->order->status = 3;
        $this->order->payment_status = 1;
        $this->order->save();
        DB::commit();
        return $response;
    }

    public function invoice()
    {
        return 'https://' . $this->API . 'invoice/' . $this->order->payment_id . '/pdf';
    }

    public function refund($amount, $reason)
    {

        $response = $this->sendRequest('refund', $this->refund_body($amount, $reason));
        if (@$response->error_details) throw new Exception($response->error_details);
        DB::beginTransaction();
        $this->order->refund = $amount;
        $this->order->save();
        DB::commit();
        return $response;
    }
}
