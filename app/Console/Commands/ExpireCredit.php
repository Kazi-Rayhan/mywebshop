<?php

namespace App\Console\Commands;

use App\Models\Bonus;
use App\Models\Credit;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ExpireCredit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'credits:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire credits that have passed their expiration dates';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->expireSessionCredits();
        $this->expireSubscriptionCredits();

        $this->info('Credit expiration process completed successfully.');
        return Command::SUCCESS;
    }

    private function expireSessionCredits()
    {
        $expiredSessionCredits = Credit::where('session_credits', '>', 0)->where('session_credits_expire_at', '<=', now()->subDay())
            ->get();
        if ($expiredSessionCredits->isNotEmpty()) {
            $expiredSessionCredits->each(function ($credit) {


                if ($credit->trainer->level()) {
                    $session_rate = $credit->histories()->where('type', 'session_credits')->latest()->first()->rate_per_session();
                    $remaing_credits = $credit->session_credits;

                    $bonus = ($session_rate * $remaing_credits) * ($credit->trainer->level()->expire_session_commission / 100);

                    Bonus::create([
                        'amount' => $bonus,
                        'user_id' => $credit->trainer_id,
                        'type' => 'expire_bonus',
                    ]);
                }
                $credit->session_credits = 0;
                $credit->save();
            });
        }
    }

    private function expireSubscriptionCredits()
    {
        $expiredSubscriptionCredits = Credit::where('subscription_credits', '>', 0)->where('subscription_credits_expire_at', '<=', now()->subDay())
            ->get();

        if ($expiredSubscriptionCredits->isNotEmpty()) {
            $expiredSubscriptionCredits->each(function ($credit) {
                if ($credit->trainer->level()) {
                    $session_rate = $credit->histories()->where('type', 'subscription_credits')->latest()->first()->rate_per_session();
                    $remaing_credits = $credit->session_credits;
                    $bonus = ($session_rate * $remaing_credits) * ($credit->trainer->level()->expire_session_commission / 100);
                    Bonus::create([
                        'amount' => $bonus,
                        'user_id' => $credit->trainer_id,
                        'type' => 'expire_bonus',
                    ]);
                }
                $credit->subscription_credits = 0;
                $credit->save();
            });
        }
    }
}
