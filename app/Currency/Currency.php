<?php

namespace App\Currency;

use Error;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Currency
{
    protected const API_URL = 'http://api.exchangerate.host/live';
    protected const PLACES = 2;
    protected $symbol;
    protected $price;
    protected $base;

    public function __construct(string $symbol, float $price, string $base)
    {
        $this->symbol = strtoupper($symbol);
        $this->price = $price;
        $this->base = strtoupper($base);
    }




    protected function getExcangeRate()
    {




        $exchangeRate = Cache::remember('exchangerate-' . $this->base . '-' . $this->symbol . request()->user_name, 900, function () {
            if ($this->symbol != $this->base) {

                return   Http::get(
                    $this::API_URL,
                    [
                        'access_key' => 'b9438f75cf99d65c4bbe6fcc3eb0c738',
                        'source' => $this->base,
                        'places' => $this::PLACES,
                        'symbols' => $this->symbol,
                    ]
                )->json()['quotes'][$this->base . $this->symbol];
            } else {
                return 1;
            }
        });


        return $exchangeRate;
    }

    public static function convert($symbol, $price, $base = 'nok')
    {
        try {
            $currency = new static($symbol, $price, $base);

            $convert = $currency->price * $currency->getExcangeRate();

            return $convert;
        } catch (Error $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
