<?php

namespace App\Console\Commands;

use App\Models\Bonus as ModelsBonus;
use App\Models\Booking;
use App\Models\User;
use App\Services\Bonus;
use Illuminate\Console\Command;

class CalculateBonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bonus:calculate';

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
        $from = now()->startOfMonth()->subDay();
        $to = now();
        $managers = User::personalTrainer()->get();
        foreach ($managers as $manager) {
            $bookings = Booking::where('status', 1)
                ->where('service_type', 1)
                ->where(function ($query) use ($from, $to) {
                    $query->where('start_at', '>=', $from)
                        ->where('start_at', '<=', $to);
                })
                ->where('manager_id', $manager->id)
                ->selectRaw('commission_type, SUM(commission) as total_commission')
                ->addSelect(\DB::raw('SUM(TIMESTAMPDIFF(MINUTE, start_at, end_at) ) as total_minutes'))
                ->groupBy('commission_type')
                ->get();
             
                if($manager->getShop()->defaultoption && $manager->level()){
                    $bonus = (new Bonus($manager, round($bookings->sum('total_minutes') /  $manager->getShop()->defaultoption->minutes) ))->calculate();
                }else{
                    $bonus = 0;
                }
                ModelsBonus::create([
                    'amount' => $bonus,
                    'user_id' => $manager->id,
                    'type' => 'session_bonus',
                ]);                      
        }
    }
}
