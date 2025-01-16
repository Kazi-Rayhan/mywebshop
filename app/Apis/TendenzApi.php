<?php

namespace App\Apis;

use Illuminate\Support\Facades\Http;

class TendenzApi
{

    private  $API;
    private $API_KEY;
    private $params;


    public function __construct($params = [])
    {

        $this->API = 'https://api.v4.valhalla09.friggcms.no/api/v4/';

        $this->API_KEY = 'FB95E059-A3F5-419A-AF25-3EFAE00A8D6E';
        $this->params = $params;
        
    }

    private function sendRequest(string $request, $method = 'post',$id=null)
    {

        $apis = [
            'categories' => "categories",
            'products' => "products",
            'prducts_by_category' => "categories/" . $id . "/products"

        ];

        $url = $this->API . $apis[$request];
        $request = Http::withHeaders([
            'X-API-Key' => $this->API_KEY,
        ]);
        switch ($method) {
            case "put":
                return  json_decode(
                    $request->put($url)
                );

            case "get":
                return  json_decode(
                    $request->get($url, $this->params)
                );

            default:
                return  json_decode(
                    $request->post($url)
                );
        }
    }
    public function categories()
    {
        $response = $this->sendRequest('categories', 'get');
        return $response;
    }
    public function Products()
    {
        $response = $this->sendRequest('products', 'get');
        return $response;
    }

    public function ProductsByCategory($id)
    {
      
        $response = $this->sendRequest('prducts_by_category', 'get',$id);
        return $response;
    }
}
