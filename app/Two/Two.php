<?php

namespace App\Two;

use Illuminate\Support\Facades\Http;

class Two
{

    private  $API;
    private $MERCHANT_SHORT_NAME;
    private $MERCHANT_ID;
    private $API_KEY;
    private $data;




    public function __construct(array $data)
    {
        $this->data = $data;
        $this->API = env('TWO_API_ENDPOINT', 'sandbox.api.two.inc/v1/');
        $this->MERCHANT_SHORT_NAME = env('TWO_API_MERCHANT_SHORT_NAME', '2izii');
        $this->MERCHANT_ID = env('TWO_API_MERCHANT_SHORT_NAME', '0ab5dd59-4698-4208-89a6-d1e5c6660596');
        $this->API_KEY = env('TWO_API_KEY', 'secret_test_xW3ISgdIC8diLZR2I7OKasEVpA7EPEeH4bU97kRAWqc');
    }

    private function sendRequest(string $request, array $body = [], $merchant = null)
    {

        $apis = [
            'business_customer' => "merchant/$this->MERCHANT_ID/customer",
            'marketplace' => "partner/$this->MERCHANT_ID/merchant",
            'merchant' => "/partner/$this->MERCHANT_ID/merchant/$merchant"

        ];
        $url = $this->API . $apis[$request];

        return  json_decode(
            Http::withHeaders([
                'X-API-Key' => $this->API_KEY,
            ])->post($url, $body)->body()
        );
    }

    public function business_customer()
    {
        $this->data['merchant_redirect_urls'] = [
            'onboarding_completed_url' => url('/'),
            'onboarding_failed_url' => url('/')
        ];
        $response = $this->sendRequest('business_customer', $this->data);
        return $response;
    }

    public function marketplace()
    {

        return  $this->sendRequest('marketplace', $this->data);
    }

    public function merchant($merchant)
    {
        $apis = [
            'business_customer' => "merchant/$this->MERCHANT_ID/customer",
            'marketplace' => "partner/$this->MERCHANT_ID/merchant",
            'merchant' => "/partner/$this->MERCHANT_ID/merchant/$merchant"

        ];
        $url = $this->API .  "/partner/$this->MERCHANT_ID/merchant/$merchant";

        return  json_decode(
            Http::withHeaders([
                'X-API-Key' => $this->API_KEY,
            ])->get($url)->body()
        );
    }
}
