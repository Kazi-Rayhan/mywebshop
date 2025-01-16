<?php

namespace App\Services\Subscription;

use App\Mail\ShopInvoice;
use App\Models\Charge;
use App\Payment\Elavon\ElavonShopSubscription;
use App\Services\RetailerCommission;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Mail;

trait ElavonSubscriptionServiceTrait
{


    protected function createSubscriptionWithElavon()
    {
        $subscription = (new ElavonShopSubscription($this->shop))->createSubscription();
        
        if ($subscription['status'] == true) {

            $this->shop->shopperId = $subscription['data']['shopperId'];
            $this->shop->subscription_id = $subscription['data']['cardId'];
            $this->shop->save();
            return route('shop.confirm.subscription', $subscription['data']['cardId']);
        } else {
            $message = $subscription['data']['message'];
            throw new Exception($message);
        }
    }

    protected function confirmSubscriptionWithElavon()
    {

        $subscription = (new ElavonShopSubscription($this->shop))->getSubscription();
        
        if ($subscription->isSuccess()) {

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

            $charge_status =  (new ElavonShopSubscription($this->shop))->chargeViaCard($amount);
            
            if ($charge_status['status']) {
                Mail::to($this->shop->user->email)->send(new ShopInvoice($this->shop));

                if ($charge_status['data']['status']) {
                    Charge::create([
                        'shop_id' => $this->shop->id,
                        'order_id' =>  $charge_status['data']['id'],
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
