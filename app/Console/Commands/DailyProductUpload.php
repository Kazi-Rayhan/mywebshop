<?php

namespace App\Console\Commands;

use App\Apis\FetchProducts;
use App\Models\Shop;
use Illuminate\Console\Command;

class DailyProductUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily  2 wise product upload check';

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
        $shop = Shop::find(5);
        (new FetchProducts($shop))->fetch(
            [
                'ExpandCategories' => 'true',
                'limit' => 10,
                'ExpandAttributes'=>'true'
            ]
        );

        return 'done';
    }
}
