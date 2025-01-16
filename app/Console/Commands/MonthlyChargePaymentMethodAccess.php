<?php

namespace App\Console\Commands;

use App\Models\PaymentMethodAccess;
use App\Models\Subscription;
use App\Payment\Subscribe;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Iziibuy;

class MonthlyChargePaymentMethodAccess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment-method-access:charge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $prevMonth = today()->subMonthsNoOverflow()->startOfMonth();
        $paymentMethods = PaymentMethodAccess::whereBetween('last_paid_at', [$prevMonth->toDateTimeString(), $prevMonth->copy()->endOfMonth()->toDateTimeString()])->where('status', 1)->get();
    
        foreach ($paymentMethods as $data) {
            if ($data->subscription->status == 1) {
                $subscriptionDatabase =  $data->subscription;
                $subscriptionQuickpay =  (new Subscribe())->subscription($data->subscription->key);
                $charge = $data->fee();
                // $charge = setting('payment.payment_method_fee') + (setting('payment.payment_method_fee') * .25);
                if ($subscriptionQuickpay->subscription->state ==  "active") {
                    $subscription_fee =   $charge;
                    $create_charge = $subscriptionQuickpay->charge($subscription_fee);

                    if ($create_charge['status']) {
                        $payment = $subscriptionQuickpay->payment($create_charge['data']->id);
                        if ($payment['data']->state == 'processed') {

                            $subscriptionDatabase->paid_at = now();
                            $subscriptionDatabase->status = true;
                            $subscriptionDatabase->establishment_status = true;
                            $subscriptionDatabase->save();

                            $subscriptionDatabase->charges()->create([
                                'amount' => $subscription_fee,
                                'status' => true
                            ]);


                            $data->status = true;
                            $data->key = Str::uuid();
                            $data->last_paid_at = now();
                            $data->save();
                        }
                    } else {
                        $subscriptionDatabase->status = false;
                        $subscriptionDatabase->save();

                        $data->status = false;
                        $data->save();
                    }
                };
            } else {
                $data->update([
                    'status' => 0
                ]);
            }
        }
    }
}
