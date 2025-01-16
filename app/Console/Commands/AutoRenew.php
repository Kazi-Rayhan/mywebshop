<?php

namespace App\Console\Commands;

use App\Models\Credit;
use App\Models\Package;
use App\Payment\Subscription\SubscriptionQuickPay;
use App\Services\CreditWallet;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AutoRenew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:autorenew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically renews subscriptions and session credits for eligible users';

    protected const LIMIT = 200;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            DB::beginTransaction();

            $this->renewSubscriptionCredits();
            $this->renewSessionCredits();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->error('An error occurred during auto-renewal: ' . $e->getMessage());
            return Command::FAILURE;
        }

        $this->info('Auto-renewal completed successfully.');
        return Command::SUCCESS;
    }

    /**
     * Automatically renew subscriptions for eligible users.
     *
     * Fetches credit records with 'subscription_credits' type that have not expired yet
     * and have a valid subscription with an active status. Renews the subscription and
     * updates the client's package information and credit wallet accordingly.
     *
     * @return void
     */
    private function renewSubscriptionCredits()
    {
        $subscription_credits = Credit::where('type', 'subscription_credits')
            ->where('subscription_credits_expire_at', '>', now())
            ->whereHas('subscription', function ($query) {
                $query->whereNotNull('key')->where('status', 1);
            })
            ->get();

        foreach ($subscription_credits as $credit) {
            if (now()->gt($credit->subscription_credits_expire_at)) {
                $client = $credit->user;
                $order = $credit->subscription->order;

                $this->updateClientPackageInfo($client, $order);

                $fee = $order->total;
                $package = Package::find($client->pt_package_id);
                $trainer = $credit->trainer_id;

                $subscription = $credit->subscription;

                $charge = (new SubscriptionQuickPay($order->shop->api_key, $order))->charge($subscription, $fee);
                if ($charge) {
                    $subscription->paid_at = Carbon::now();
                    $subscription->save();
                    (new CreditWallet($client, $trainer))->deposit($package->duration, 'subscription_credits', $package->validity);
                }
            }
        }
    }

    /**
     * Automatically renew session credits for eligible users.
     *
     * Fetches credit records with 'session_credits' type that have fewer credits than the defined LIMIT
     * and have a valid subscription with an active status. Renews the session credits and updates the
     * client's package information and credit wallet accordingly.
     *
     * @return void
     */
    private function renewSessionCredits()
    {
        $session_credits = Credit::where('type', 'session_credits')
            ->where('session_credits', '<=', $this::LIMIT)
            ->whereHas('subscription', function ($query) {
                $query->whereNotNull('key')->where('status', 1);
            })
            ->get();

        foreach ($session_credits as $credit) {
            $client = $credit->user;
            $trainer = $credit->trainer;
            $order = $credit->subscription->order;

            $this->updateClientPackageInfo($client, $order);

            $fee = $order->total;
            $package = Package::find($client->pt_package_id);
            $subscription = $credit->subscription;

            $charge = (new SubscriptionQuickPay($order->shop->api_key, $order))->charge($subscription, $fee);
            if ($charge) {
                $subscription->paid_at = Carbon::now();
                $subscription->save();
                (new CreditWallet($client, $trainer))->deposit($package->duration, 'session_credits', $package->validity);
            }
        }
    }

    /**
     * Update client's package information based on the order.
     *
     * If the client's package ID or price is not set, this method updates it with
     * the corresponding values from the order.
     *
     * @param \App\Models\User $client The user/client to update.
     * @param \App\Models\Order $order The order used for updating the package info.
     * @return void
     */
    private function updateClientPackageInfo($client, $order)
    {
        if (!$client->pt_package_id) {
            $client->pt_package_id = $order->package;
        }
        if (!$client->pt_package_price) {
            $client->pt_package_price = $order->total;
        }
        $client->save();
    }
}
