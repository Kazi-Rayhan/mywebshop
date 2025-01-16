<?php

namespace App\Payment\Elavon;

use App\Elavon\Converge2\Client\ClientConfig;
use App\Elavon\Converge2\Converge2;
use App\Elavon\Converge2\Response\OrderResponse;
use App\Elavon\Converge2\Response\PaymentSessionResponse;
use App\Models\ExternalOrder;
use App\Models\Order;


class ApiElavonPayment
{

    public $endpoint;
    protected $elavon;
    protected $shop;
    public $keys;
    protected $order;


    public function __construct(ExternalOrder $order)
    {
        $this->order = $order;
        $shop = $this->order->paymentMethodAccess;

       

        $merchantAlias =  $shop->elavon_merchant_alias;
        $publicKey =  $shop->elavon_public_key;
        $secretKey =  $shop->elavon_secret_key;
        $this->keys = [
            'mercahantAlias' => setting('payment.elavon_merchant_alias'),
            'publicKey' =>  setting('payment.elavon_public_key'),
            'secretKey' => setting('payment.elavon_public_key')
        ];
        $this->endpoint = 'https://uat.hpp.converge.eu.elavonaws.com';
        // if (env('APP_ENV') == 'local') {
        // } else {
        //     $this->endpoint = 'https://hpp.eu.convergepay.com';
        // }

        $this->elavon = new Converge2($this->config());
    }


    protected function config()
    {

        $config = new ClientConfig();

        $config->setMerchantAlias($this->keys['mercahantAlias']);
        $config->setPublicKey($this->keys['publicKey']);
        $config->setSecretKey($this->keys['secretKey']);

        $config->setSandboxMode();
        if (env('APP_ENV') == 'local') {
        }

        return $config;
    }


  



    protected function makeOrderCreateBody()
    {

        return   [
            'total' => (object) [
                'amount' => $this->order->amount,
                'currencyCode' => $this->order->currency
            ],
            'description' => sprintf('Purchase from %s- %s', env('APP_NAME'), $this->order->id),
            // 'expiresAt' => now()->addHours(2)->toISOString(),
            // 'returnUrl' => route('callback.elavon.payment.success'),
            'items' => null,
            'shipTo' => [
                'fullName' => $this->order->first_name . ' ' . $this->order->last_name,
                'company' => "",
                'postalCode' => $this->order->post_code,
                'street1' => $this->order->address,
                'street2' => '',
                'city' => $this->order->city,
                'countryCode' => 'NOR',
                'primaryPhone' => $this->order->phone,
                'email' => $this->order->email
            ],
            'shopperEmailAddress' => $this->order->email,
            'shopperReference' => $this->order->email,
            'customFields' => [
                'vendor_id' => env('APP_NAME'),
                'vendor_app_name' => env('APP_NAME'),
                'vendor_app_version' => '1.0.0',
                'php_version' => phpversion(),
                // 'woocommerce_version' => '8.1.1',
                // 'WooCommerceID' => '54eccead-f25d-453b-a799-630fe3f17e53'
            ]
        ];
    }

    protected function makePaymentSessionCreateBody(OrderResponse $response)
    {
        return [
            "order" => $response->getId(),
            "billTo" => array(
                'fullName' => $this->order->customer_name,
                'company' => "",
                'postalCode' => $this->order->customer_post_code,
                'street1' => $this->order->customer_address,
                'street2' => '',
                'city' => $this->order->city,
                'countryCode' => 'NOR',
                'primaryPhone' => $this->order->customer_phone,
                'email' => $this->order->customer_email
            ),
            "returnUrl" =>  route('callback.api.elavon.payment.success'),
            "cancelUrl" =>  route('callback.api.elavon.payment.cancel',['order_id'=>$this->order->id]),
            "originUrl" => $this->order->source_url,
            "defaultLanguageTag" => "en-US",
            "customFields" => array(
                'vendor_id' => env('APP_NAME'),
                'vendor_app_name' => env('APP_NAME'),
                'vendor_app_version' => '1.0.0',
                'php_version' => phpversion(),
            ),
            "doCreateTransaction" => null,
            "doThreeDSecure" => 1,
            "hppType" => "fullPageRedirect"
        ];
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

    protected function makeTransactionCreateBody(PaymentSessionResponse $response)
    {
        return [
            'type' => 'sale',
            'total' => (object) [
                'amount' => $this->order->amount,
                'currencyCode' => $this->order->currency
            ],
            'doCapture' => true,
            'shopperInteraction' => 'ecommerce',
            'shipTo' => [
               'fullName' => $this->order->customer_name,
                'company' => "",
                'postalCode' => $this->order->customer_post_code,
                'street1' => $this->order->customer_address,
                'street2' => '',
                'city' => $this->order->city,
                'countryCode' => 'NOR',
                'primaryPhone' => $this->order->customer_phone,
                'email' => $this->order->customer_email
            ],
            'shopperEmailAddress' => $this->order->customer_email,
            'doSendReceipt' => false,
            'shopperIpAddress' => $_SERVER['REMOTE_ADDR'],
            'shopperReference' => $this->order->customer_email,
            'shopperStatement' => array(
                'name' => $this->order->customer_name,
                'phone' => $this->order->customer_phone,
                'url' => '',
            ),

            'description' => sprintf('Purchase from %s- %s', env('APP_NAME'), $this->order->id),
            'shopperLanguageTag' => app()->getLocale(),
            'shopperTimeZone' => config('app.timezone'),
            'customFields' => [
                'vendor_id' => env('APP_NAME'),
                'vendor_app_name' => env('APP_NAME'),
                'vendor_app_version' => '1.0.0',
                'php_version' => phpversion(),
            ],
            'createdBy' => env('APP_NAME'),
            'orderReference' => $this->order->id,
            'order' => $this->parseUrl($response->getOrder()),
            'hostedCard' => $this->parseUrl($response->getHostedCard()),
            'threeDSecure' => array(
                'directoryServerTransactionId' => $response->getThreeDSecure()->getDirectoryServerTransactionId(),
              
                'transactionStatus' => $response->getThreeDSecure()->getTransactionStatus(),
                'electronicCommerceIndicator' => $response->getThreeDSecure()->getElectronicCommerceIndicator(),
                'authenticationValue' => $response->getThreeDSecure()->getAuthenticationValue(),
                'protocolVersion' => $response->getThreeDSecure()->getProtocolVersion(),
            ),
        ];
    }

    public function getPaymentLink()
    {
        $order_create_body = $this->makeOrderCreateBody();

        $order_create_response = $this->elavon->createOrder($order_create_body);

        $payment_session_create_body = $this->makePaymentSessionCreateBody($order_create_response);

        $payment_session_create_response = $this->elavon->createPaymentSession($payment_session_create_body);

        if ($payment_session_create_response->isSuccess()) {
            return [
                'status' => true,
                'code' => 200,
                'data' => [
                    'payment_id' => $payment_session_create_response->getId(),
                    'url' => $this->endpoint . '/?merchantAlias=' . $this->keys['mercahantAlias'] . '&publicApiKey=' . $this->keys['publicKey'] . '&sessionId=' . $payment_session_create_response->getId()
                ]
            ];
        } else {
            $message = '';
            foreach ($payment_session_create_response->getData()->failures as $failure) {

                $message .= ' | ' . $failure->getDescription();
            }
            return [
                'status' => false,
                'code' => $payment_session_create_response->getData()->status,
                'data' => [
                    'message' => $message
                ]
            ];
        }
    }


    public function processPayment($id)
    {

        if ($this->order->elavon_transaction_id) {
            $sale_transcation_create_response = $this->elavon->getTransaction($this->order->elavon_transaction_id);
        } else {

            $payment_session_response =  $this->elavon->getPaymentSession($id);

            $sale_transcation_create_body = $this->makeTransactionCreateBody($payment_session_response);
            $sale_transcation_create_response = $this->elavon->createSaleTransaction($sale_transcation_create_body);
        }

        return [
            'id' => $sale_transcation_create_response->getId(),
            'state' => $sale_transcation_create_response->getState()->isCaptured() || $sale_transcation_create_response->getState()->isAuthorized(),
        ];
    }
}
