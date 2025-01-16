<?php

namespace App\Console\Commands;

use App\Models\Shop;
use Illuminate\Console\Command;

class RemoveBotShop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shops:remove';

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
        $botShops = Shop::where('establishment', 0)
        ->where('created_at', '<=', now()->subDay())
        ->get();

        foreach($botShops as $shop){
            $shop->priceGroups()->delete();
            $shop->user->delete();
            $shop->delete();
        }
        return Command::SUCCESS;
    }
}
