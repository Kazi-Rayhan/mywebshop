<?php

namespace App\Console\Commands;

use App\Models\Shop;
use App\Two\Two;
use Illuminate\Console\Command;

class TwoPaymentStatusCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'two:checkstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $shops = Shop::WhereNotNull('two_api_key')->WhereNotNull('two_merchant_id')->whereHas('metas', function ($q) {
            return $q->where('column_name', 'two_merchant_status')->where('column_value', 0);
        })->get();
        $i = 0;
        foreach ($shops as $shop) {
            $response = (new Two([]))->merchant($shop->two_merchant_id);
            if ($response->payee_accounts[0]->external_status == 'COMPLETED') {
                $i++;
                $shop->createMeta('two_merchant_status', 1);
            };
        }
        echo "shop active ". $i;
    }
}
