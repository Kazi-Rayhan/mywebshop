<?php

namespace App\Console\Commands;

use App\Apis\FetchProducts;
use App\Models\Shop;
use Illuminate\Console\Command;

class DailyCategoryUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:check';

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
        $shop = Shop::find(5);
        (new FetchProducts($shop))->feth_category(
            [
                'ExpandCategories' => 'true',
                //'limit' => 1
            ]
        );
        return 'done';
    }
}
