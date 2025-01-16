<?php

namespace App\Payment;

use App\Models\Order;
use App\Models\Shop;
use App\Payment\Elavon\ElavonPayment;
use App\Payment\Quickpay\QuickPayPayment;
use App\Payment\Two\TwoPayment;

class Payment
{
    protected Shop $shop;
    protected Order $order;
    protected string $method;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->shop = $order->shop;
        $this->method = $order->payment_method ?? 'quickpay';
    }

    public  function getUrl($id = null)
    {

        switch ($this->method) {

            case 'two':
                return (new TwoPayment($this->shop, $this->order))->getPaymentLink();
                break;
            case 'elavon':
                return (new ElavonPayment($this->order))->getPaymentLink();
                break;
            default:
                $autocapture = $this->order->is_digital == true ? true : false;

                return (new QuickPayPayment($this->order))->getPaymentLink($autocapture);
                break;
        }
    }


    public  function confirm()
    {
        switch ($this->method) {
            case 'quickpay':

                break;
            case 'two':

                break;
            default:

                break;
        }
    }

    public function status()
    {
    }
}
