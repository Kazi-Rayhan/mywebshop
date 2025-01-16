<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Livewire\Component;

class Companysearch extends Component
{
    public $countries = [
        'NO' => 'words.country_norway',
        'SE' => 'words.country_sweden',
        'GB' => 'words.country_united_kingdom',
    ];

    public $select;
    public $country;
    public $companyName;
    public $companyNumber;
    public $results = [];
    public $address;
    public $city;
    public $postcode;

    public function mount(){
        $this->companyName = old('company_name');
        $this->companyNumber = old('company_number');
        $this->country = old('company_country_prefix');
        $this->address = old('address');
        $this->city = old('city');
        $this->postcode = old('post_code');
    }
    public function getApi()
    {
        switch ($this->country) {
            case 'no':
                return 'http://no.search.two.inc/search';
                break;
            case 'se':
                return 'http://se.search.two.inc/search';
                break;
            case 'uk':
                return 'http://gb.search.two.inc/search';
                break;
            default:
                return 'http://no.search.two.inc/search';
                break;
        }
    }

    public function search($query)
    {

        $api =  $this->getApi();
        $response = Http::get(
            $api,
            [
                'limit' => 50,
                'offset' => 0,
                'q' => $query
            ]
        )->json();

        if ($response['status'] === 'success') {

            $items =  $response['data']['items'];
            return $items;
        };
        return [];
    }



    public function updatingCompanyName()
    {
        if (strlen($this->companyName) > 2) {
            $this->results = $this->search($this->companyName);
        }
    }

    public function updatedCompanyName()
    {
        $key = Arr::first($this->results, function ($item) {
            return $item['name'] == $this->companyName;
        });
        if ($key) {
            $this->companyNumber = $key['id'];
            $address = json_decode(Http::get("http://sandbox.api.two.inc/v1/$this->country/company/$this->companyNumber/address")->body());
            if ($address) {

                $this->city = $address->address->city;
                $this->address = $address->address->streetAddress;
                $this->postcode = $address->address->postalCode;
            }
        }
    }



    public function updatedCompanyNumber()
    {
        $this->results = $this->search($this->companyNumber);
        $key = Arr::first($this->results, function ($item) {
            return $item['id'] == $this->companyNumber;
        });
        if ($key) {
            $this->companyName = $key['name'];
            $address = json_decode(Http::get("http://sandbox.api.two.inc/v1/$this->country/company/$this->companyNumber/address")->body());
            if ($address) {

                $this->city = $address->address->city;
                $this->address = $address->address->streetAddress;
                $this->postcode = $address->address->postalCode;
            }
        }
    }







    public function render()
    {
        return view('livewire.companysearch');
    }
}
