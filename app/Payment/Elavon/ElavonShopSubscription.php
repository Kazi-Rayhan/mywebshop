<?php

namespace App\Payment\Elavon;

use App\Elavon\Converge2\Client\ClientConfig;
use App\Elavon\Converge2\Converge2;
use App\Elavon\Converge2\Response\ShopperResponse;
use App\Models\Shop;

class ElavonShopSubscription
{
    protected $elavon;
    protected $shop;

    protected function config()
    {
        $config = new ClientConfig();
        $config->setMerchantAlias('xvjtx7x8pr2mv27bkm2h26tp3k4t');
        $config->setPublicKey('pk_j7r8dfd3qyxm76d27tqxxvhj4mc4');
        $config->setSecretKey('sk_4brwqdqky32tp3vgpycckq4b73db');

        if (env('APP_ENV') == 'local') {
            $config->setSandboxMode();
        }

        return $config;
    }


    public function __construct(Shop $shop)
    {
        $this->shop = $shop;
        $this->elavon = new Converge2($this->config());
    }

    protected function getShopperCreateReqBody(): array
    {
        return [
            'fullName' => $this->shop->user->fullName,
            'company' => $this->shop->company_name,
            'primaryAddress' => array(
                'street1' => $this->shop->street,
                'street2' => '',
                'city' =>  $this->shop->city,
                'region' =>  $this->shop->city, // You can set a value if available
                'postalCode' => $this->shop->post_code,
                'countryCode' => 'NOR',
            ),
            'primaryPhone' => $this->shop->contact_phone,
            'email' => $this->shop->contact_email,
        ];
    }
    protected function getStoreCardReqBody(): array
    {
        $shopper = $this->makeNewShopper();
        return [
            'shopper' => $shopper->getId(),
            'card' => [
                'holderName' => $this->shop->user->fullName,
                'number' => $this->shop->card_number,
                'expirationMonth' => $this->shop->expiration_month,
                'expirationYear' => $this->shop->expiration_year,
                'securityCode' => $this->shop->ccv,
                'billTo' => [
                    'fullName' =>  $this->shop->user->fullName,
                    'street1' =>  $this->shop->street,
                    'street2' => '',
                    'city' => $this->shop->city,
                    'region' => $this->shop->city,
                    'postalCode' => $this->shop->post_code,
                    'countryCode' => 'NOR',
                    'primaryPhone' => $this->shop->contact_phone,
                ]
            ]
        ];
    }

    protected function getTransactionCreateReqBody($amount): array
    {
        return [
            'type' => 'sale',
            'total' => array(
                'amount' => $amount,
                'currencyCode' => 'NOK',
            ),
            'doCapture' => 1,
            'shopperInteraction' => 'telephoneOrder',
            'shipTo' => [
                'fullName' => $this->shop->user->fullName,
                'company' => $this->shop->company_name,
                'postalCode' => $this->shop->post_code,
                'street1' => $this->shop->street,
                'street2' => '',
                'city' => $this->shop->city,
                'countryCode' => 'NOR',
                'primaryPhone' => $this->shop->contact_phone,
                'email' => $this->shop->contact_email
            ],
            'shopperEmailAddress' => $this->shop->user->email,
            'doSendReceipt' => null,
            'shopperIpAddress' => $_SERVER['REMOTE_ADDR'],
            'shopperReference' => $this->shop->id,
            'shopperStatement' => array(
                'name' =>  $this->shop->user->fullName,
                'phone' => $this->shop->contact_phone,
                'url' => null,
            ),
            'description' =>  sprintf('Charged via card for shop : %s',  $this->shop->user_name),
            'shopperLanguageTag' => app()->getLocale(),
            'shopperTimeZone' => config('app.timezone'),
            'customFields' => [
                'vendor_id' => env('APP_NAME'),
                'vendor_app_name' => env('APP_NAME'),
                'vendor_app_version' => '1.0.0',
                'php_version' => phpversion(),
            ],
            'createdBy' => env('APP_NAME'),
            'orderReference' => uniqid(),
            'storedCard' => $this->shop->subscription_id,
        ];
    }

    protected function makeNewShopper(): ShopperResponse
    {
        return $this->elavon->createShopper($this->getShopperCreateReqBody());
    }

    protected function storeACard()
    {
        return $this->elavon->createStoredCard($this->getStoreCardReqBody());
    }

    protected function parseUrl($url)
    {

        // Parse the URL to get the path
        $path = parse_url($url, PHP_URL_PATH);

        // Split the path using "/"
        $parts = explode('/', $path);

        // Get the last part of the array
        $desiredPart = end($parts);

        // Output the result
        return $desiredPart;
    }

    public function createSubscription()
    {
        $response = $this->storeACard();

        if ($response->isSuccess()) {
            return [
                'status' => true,
                'code' => 200,
                'data' => [
                    'shopperId' => $this->parseUrl($response->getShopper()),
                    'cardId' => $response->getId(),
                ]
            ];
        } else {
            $message = '';
            foreach ($response->getData()->failures as $failure) {

                $message .= ' | ' . $failure->getDescription();
            }
            return [
                'status' => false,
                'code' => $response->getData()->status,
                'data' => [
                    'message' => $message
                ]
            ];
        }
    }
    // khmxym7c8mc2h6kp4qwmjvggdtb4

    public function chargeViaCard($amount)
    {
        $response = $this->elavon->createSaleTransaction($this->getTransactionCreateReqBody($amount));
        
        if ($response->isSuccess()) {
            return [
                'status' => true,
                'code' => 200,
                'data' => [
                    'status' => $response->getState()->isAuthorized() || $response->getState()->isCaptured(),
                    'id' => $response->getId()
                ]
            ];
        } else {
            $message = '';
            foreach ($response->getData()->failures as $failure) {

                $message .= ' | ' . $failure->getDescription();
            }
            return [
                'status' => false,
                'code' => $response->getData()->status,
                'data' => [
                    'message' => $message
                ]
            ];
        }
    }


    public function getSubscription()
    {

        return $this->elavon->getStoredCard($this->shop->subscription_id);
    }
}
