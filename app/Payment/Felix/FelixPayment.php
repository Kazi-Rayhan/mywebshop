<?php

namespace App\Payment\Felix;

use Illuminate\Support\Facades\Http;

class FelixPayment
{
    private $productId = '111111';
    private $webId = '72393';
    private $token;
    private $sId;
    private $appmode = 'desktop';
    private $expiry = '120000';
    private $amount;
    private $firebaseId = 'dK5jAgpERNkhKuKJ1bh-6k:APA91bFFiEAIS6XmYKetyICU6fRxld29TwJMz_PhvhppXlYoCudPe2BErxznhg4mTfsv-MBNJ1ezmTbIdaiIZcxjgi1Su860MC7MJ11FlU61du7BSYq3Sv9xCsl9G-MuFrOKX4aU2XV7';

    public function __construct($amount)
    {
        $this->amount = $amount;
    }
    private function getToken()
    {
        $response =  Http::post("https://sandbox-pay.payfelix.com/v0.1/get-token", [
            "webId" => $this->webId,
            "productId" => $this->productId,
        ]);


        $this->token = json_decode($response)->token;
        $this->sId = json_decode($response)->sId;
        return $this;
    }

    private function getLink()
    {

        $response =  Http::withToken($this->token)->withHeaders([
            'sId' => $this->sId,
            "Content-Type" => "application/json"
        ])->post("https://sandbox-pay.payfelix.com/v0.1/start", [
            'appMode' => $this->appmode,
            'amount' => '1',
            'tip' => '0',
            'expiry' => $this->expiry,
            'firebaseId' => $this->firebaseId,
        ]);

        return json_decode($response->body())->urlData;
    }

    public static function createNewPaymenLink($amount)
    {
        return (new self($amount))->getToken()->getLink();
    }
}
