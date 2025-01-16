<?php

namespace App\Console\Commands;

use App\Models\Charge;
use Illuminate\Console\Command;
use QuickPay\QuickPay;

class check_if_payment_is_test_or_not extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'charges:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the charge is from test card or not';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $quickpay = $this->initializeClient();
        $charges = Charge::unresolved()->limit(50)->get();
        $array = [];
        foreach ($charges as $charge) {
            $this->processCharge($charge, $quickpay);
        }
        return Command::SUCCESS;
    }

    private function initializeClient()
    {
        return new QuickPay(":4785f74061ff2bbbc7520764252ff66bb655340e1d8b353ceb4fdc2eb3d46ac0");
    }
    private function processCharge($charge, $client)
    {
        $api = sprintf("/payments?order_id=%s", $charge->order_id);
        $payment_body = json_decode($client->request->get($api)->response_data);

        if ($payment_body && $payment_body[0]) {

            $charge->payment_type = $payment_body[0]->test_mode ? "Test" : "Real";
            $charge->payment_body = json_encode($payment_body);
        } else {
            $charge->payment_type = "Test";
            $charge->payment_body = '';
        }

        $charge->save();
    }
}
