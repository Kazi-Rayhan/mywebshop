<?php

namespace App\Console\Commands;

use App\Models\Enterprise;
use App\Payment\Subscribe;
use Error;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use QuickPay\QuickPay;

class EnterpriseMonthlyCharge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enterprise:payment {status=0}';

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


        $enterprises = Enterprise::where('status', 1)->where('paid_at', '<', now()->startOfMonth())->get();
        foreach ($enterprises as $enterprise) {
            Log::info("Charge attempt start :" . $enterprise->id);
            try {
                if ($enterprise) {
                    if ($enterprise?->subscription && $enterprise?->subscription->key) {

                        $sub =  (new Subscribe())->subscription($enterprise->subscription->key);

                        $charge = $sub->charge($enterprise->details()->total_fee);


                        Log::info(json_encode($charge));
                        if ($charge['status']) {
                            $payment = $sub->payment($charge['data']->id);

                            Log::info($payment);
                            if ($payment['data']->state == 'processed') {
                                $enterprise->subscription->charges()->create([
                                    'amount' => $enterprise->details()->total_fee,
                                    'status' => true,
                                    'quickpay_order_id' => $charge['data']->order_id,
                                    'charge_details' => json_encode($charge['data']),
                                    'payment_details' => json_encode([
                                        'enterprise' => [
                                            'uid' => $enterprise->unqid,
                                            'name' => $enterprise->enterprise_name,
                                            'domain' => $enterprise->domain,
                                        ],
                                        'detials' => $enterprise->details()

                                    ]),

                                ]);
                                $enterprise->paid_at = now();
                                $enterprise->subscription->paid_at = now();
                                $enterprise->save();
                                $enterprise->subscription->save();
                                Log::info("Charge complete :" . $enterprise->id);
                            } else {
                                $enterprise->status = $this->argument('status');
                                $enterprise->subscription->status = $this->argument('status');
                                $enterprise->save();
                                $enterprise->subscription->save();
                                Log::info("Charge failed :" . $enterprise->id);
                            }
                        }
                    } else {
                        $enterprise->status = 0;
                        $enterprise->subscription->status = 0;
                        $enterprise->save();
                        $enterprise->subscription->save();
                    }
                }
            } catch (Exception $e) {
                Log::info($e->getMessage());
                continue;
            } catch (Error $e) {
                Log::info($e->getMessage());
                continue;
            }
            Log::info("Charge attempt finished :" . $enterprise->id);
        }
    }
}
