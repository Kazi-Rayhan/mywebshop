<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class CancelOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:cancel';

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
        $orders = Order::where('payment_status', 0)->where('status', '!=', 3)->get();
        $i = 0;
        $b = 0;
        foreach ($orders as $order) {
            if ($order->shop) {
                $pending_hours = $order->shop->order_pending_hours ?? 60;
                if ($pending_hours && now()->diffInMinutes($order->created_at) >= $pending_hours) {
                    if ($order->products) {
                        foreach ($order->products as $product) {
                            $product->increment('quantity', $product->pivot->quantity);
                        }
                    }
                    $order->status = 3;
                    $order->payment_url = null;
                    $order->payment_id = null;
                    $order->save();

                    $i++;
                }
            } else {
                echo $order->shop_id;
                echo '<br>';
            }
        }
        echo $i . ' Orders canceled';
        echo $b . ' Orders not canceled';
        return Command::SUCCESS;
    }
}
