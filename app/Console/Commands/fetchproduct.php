<?php

namespace App\Console\Commands;

use App\Apis\FetchProducts;
use App\Models\Shop;
use Illuminate\Console\Command;

class fetchproduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch products from tendenz api';

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
        $shop = Shop::first();
        (new FetchProducts($shop))->fetch(
            [
                'ExpandCategories' => 'true',
            ]
        );
        return 0;
    }
}
