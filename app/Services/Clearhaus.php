<?php

namespace App\Services;

use App\Models\ClearhausToken;
use Carbon\Carbon;
use Clearhaus\Client;
use Illuminate\Support\Facades\Http;

class Clearhaus
{
    const MERCHANT_URL = 'https://merchant.clearhaus.com';
    const GATEWAY_URL = 'https://gateway.clearhaus.com';

    private $client  = [
        'key' => 'c79f6d77-25d2-4d25-9778-43a43ac78f58',
        'grant_type' => 'client_credentials',
        'id' => '5pigla75a7mm0hp4eo48g5s2l5',
        'secret' => '87qm36cklp809v23unfg4h6fj8eq46ft9td0prr204u015rpv2h'
    ];



    private function get_access_token()
    {

        $findToken = ClearhausToken::where('expired_at', '>', now())->first();

        if (!$findToken) {
            $response = Http::withBasicAuth($this->client['id'], $this->client['secret'])
                ->withHeaders([
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ])
                ->asForm()
                ->post(
                    $this::MERCHANT_URL . '/oauth/token',
                    [
                        'audience' => $this::MERCHANT_URL,
                        'grant_type' => $this->client['grant_type']
                    ]
                );
            $data = json_decode($response->body());
            $token = ClearhausToken::create([
                'token' => $data->access_token,
                'expired_at' => Carbon::parse(now())->addMinute(24)->toDateTimeString()
            ]);
            return $token->token;
        }
        return $findToken->token;
    }



    public function get_transactions()
    {
        
        $response = Http::withToken($this->get_access_token())->get($this::MERCHANT_URL . '/transactions')->body();
        
        return json_decode($response);
    }

    public function get_transaction($id)
    {

        $response = Http::withToken($this->get_access_token())->get($this::MERCHANT_URL . '/transactions?query=reference:' . $id)->body();

        return array_values((array)json_decode($response)->_embedded)[0];
    }
    public function refund()
    {
        $client = new Client('c79f6d77-25d2-4d25-9778-43a43ac78f58');

        $client->enableSignature();

    
        $authorization = $client->refunds()->refund('1746961994101237');

        return $authorization;
    }

    
}
