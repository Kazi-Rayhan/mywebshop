<?php

namespace App\Services\Subscription;

use App\Mail\ShopInvoice;
use App\Models\Charge;
use App\Payment\Subscribe;
use App\Services\RetailerCommission;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

trait QuickpaySubscriptionServiceTrait
{

    protected function  createSubscriptionWithQuickPay()
    {
        $api =  setting('payment.api_key');
        $quickPay = new Subscribe($api);
        $subscription = $quickPay->subscription()->getUrl($this->shop->subscriptionFee(), true);
        if ($subscription['status'] == true) {
            $this->shop->payment_url = $subscription['data']['url'];
            $this->shop->subscription_id = $subscription['data']['payment_id'];
            $this->shop->save();
            return $this->shop->payment_url;
        } else {
            throw new Exception('Subscription request failed');
        }
    }

    protected function confirmSubscriptionWithQuickPay()
    {
        
        $api = setting('payment.api_key');
        $quickPay = new Subscribe($api);
        $subscription = $quickPay->subscription($this->shop->subscription_id)->get();
        if ($subscription['data']->accepted == true) {

            if ($this->shop->status == 1) {
                return redirect(route('shop.complete.signup'))->with('Thank your for subscribe');
            }
            if ($this->shop->paid_at) {
                if ($this->shop->paid_at->isSameMonth(today())) {
                    $this->shop->status = 1;
                    $this->shop->establishment = 1;
                    return redirect(route('shop.dashboard'))->with('Thank your for subscribe');
                }
            }

            $amount = $this->shop->subscriptionFee();

            $charge_status = $quickPay->subscription($this->shop->subscription_id)->charge($amount);

            if ($charge_status['status']) {
                $payment =  $quickPay->payment($charge_status['data']->id);
                Mail::to($this->shop->user->email)->send(new ShopInvoice($this->shop));

                if ($payment['data']->state == 'processed') {
                    Charge::create([
                        'shop_id' => $this->shop->id,
                        'order_id' =>  $charge_status['data']->id,
                        'amount' => $amount,
                        'status' => true,
                        'comment' => 'subscription fee',
                        'details' => json_encode($this->shop->subscriptionFeeDetails())
                    ]);
                    $this->shop->status = 1;
                    $this->shop->establishment = 1;
                    $this->shop->paid_at = Carbon::now();
                    if ($this->shop->retailer_id) {
                        RetailerCommission::one_time_pay_out($this->shop)->pay();
                        RetailerCommission::commission_from_recurring_payments($this->shop)->pay();
                    }
                    $this->shop->save();
                }

                return redirect(route('shop.complete.signup'))->with('Thank your for subscribe');
            }
        }
        return redirect(route('shop.subscription.payment'))->withErrors('There is a problem with your Payment method. Please try again later');
    }
}
