<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class OrderPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If Order Deliverd, Order Not Deliverd, Shipped then Payment Status 1';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders= Order::whereIn('status',[1,2,4,5])->where('payment_status',0)->get();
        foreach($orders as $order){
            $order->payment_status = 1;
            $order->save();
        }
      
    }
}
