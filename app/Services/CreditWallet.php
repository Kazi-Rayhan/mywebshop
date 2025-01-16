<?php

namespace App\Services;

use App\Models\Credit;
use App\Models\CreditHistory;
use App\Models\Package;
use App\Models\Shop;
use App\Models\User;
use Exception;

/**
 * Class CreditWallet
 *
 * A class that manages credits and credit history for a user in a specific shop.
 *
 * @package App\Services
 */
class CreditWallet
{
    /**
     * @var User $client The user who owns the wallet (client).
     */
    protected User $client;

    /**
     * @var User $trainer The user who acts as the trainer associated with the wallet.
     */
    protected User $trainer;

    /**
     * @var Shop $shop The shop to which the wallet is associated.
     */
    protected Shop $shop;

    /**
     * @var Credit $wallet The Credit model representing the user's wallet.
     */
    protected Credit $wallet;
    /**
     * @var Package $current_package The Credit model representing the user's wallet.
     */
    protected Package $current_package;

    /**
     * CreditWallet constructor.
     *
     * Initializes the CreditWallet object.
     *
     * @param User $client The client/user who owns the wallet.
     * @param User $trainer The trainer associated with the wallet.
     */
    public function __construct(User $client, User $trainer)
    {
        $this->client = $client;
        $this->trainer = $trainer;
        $this->shop = $trainer->getShop();
        $this->current_package = $client->myPackage;

        // Fetch or create the Credit record associated with the client, trainer, and shop.
        $this->wallet = Credit::firstOrNew([
            'shop_id' => $this->shop->id,
            'trainer_id' => $this->trainer->id,
            'user_id' => $this->client->id,
        ]);
    }

    /**
     * Deposit credits to the wallet.
     *
     * This method allows the client to deposit credits to their wallet. The deposited credits will be added to the
     * wallet's total credits and the appropriate credit type based on the provided $type. If the $type is not one of the
     * predefined types ('session_credits', 'subscription_credits', 'admin_credits', 'manager_credits'), the credits will
     * be added to the 'session_credits' type by default.
     *
     * @param int $amount The amount of credits to be deposited.
     * @param string $type The type of credits to be deposited (e.g., 'session_credits', 'subscription_credits').
     * @param int $validity The validity period (in days) for the deposited credits.
     * @throws Exception If the specified $type is invalid.
     */
    public function deposit(int $amount, string $type, int $validity = null)
    {
        // Increment the total credits and history in the wallet.
        $this->wallet->history += $amount;

        // Update the specific credit type and set its expiration date (if applicable).
        switch ($type) {
            case 'session_credits':
                $this->wallet->session_credits += $amount;
                $this->wallet->type = 'session_credits';
                $last_expire_date = $this->wallet->session_credits_expire_at ?? now();
                $this->wallet->session_credits_expire_at = $last_expire_date->addDays($validity);

                if (($this->current_package ?? $this->current_package->split) && $this->client->split == true) {
                    $this->wallet->split = true;

                    if ($this->wallet->remaining_split <= 0) {
                        $this->wallet->remaining_split = $this->current_package->split - 1;
                    }

                    $this->wallet->split_duration =  $amount;
                    $this->wallet->split_price = $this->current_package->getPrice($this->trainer->id, $this->client->split == true);
                    $this->wallet->next_payment_date = now()->addMonth();
                }
                break;
            case 'subscription_credits':
                $this->wallet->subscription_credits += $amount;
                $this->wallet->type = 'subscription_credits';
                $last_expire_date = $this->wallet->subscription_credits_expire_at ?? now();
                $this->wallet->subscription_credits_expire_at = $last_expire_date->addDays($validity);
                break;
            case 'admin_credits':
                $this->wallet->admin_credits += $amount;
                $this->wallet->type = 'admin_credits';

                break;
            case 'manager_credits':
                $this->wallet->manager_credits += $amount;
                $this->wallet->type = 'manager_credits';
                break;
            case 'demo_credits':
                $this->wallet->demo_credits += $amount;
                $this->wallet->type = 'demo_credits';
                break;
            default:
                $this->wallet->session_credits += $amount;
                $this->wallet->type = 'session_credits';
                $last_expire_date = $this->wallet->session_credits_expire_at ?? now();
                $this->wallet->session_credits_expire_at = $last_expire_date->addDays($validity);
                break;
        }

        // Save the updated wallet.
        $this->wallet->save();


        // Create or update the CreditHistory record for the deposit.
        if ($this->wallet->type == 'subscription_credits') {
            $history =  new CreditHistory([
                'credit_id' => $this->wallet->id,
                'user_id' => $this->wallet->user_id,
                'shop_id' => $this->wallet->shop_id,
                'manager_id' => $this->wallet->trainer_id,
                'type' => $this->wallet->type,
            ]);
        } else {
            $history = CreditHistory::firstOrNew([
                'credit_id' => $this->wallet->id,
                'user_id' => $this->wallet->user_id,
                'shop_id' => $this->wallet->shop_id,
                'manager_id' => $this->wallet->trainer_id,
                'type' => $this->wallet->type,
            ]);
        }
        // Set the package ID and price from the client's data (if not already set).
        $history->package_id = $history->package_id ?? $this->client->pt_package_id;
        $history->price = $history->price ?? $this->client->pt_package_price;

        // Increment the credits and history in the CreditHistory record.
        $history->credits += $amount;
        $history->history += $amount;

        // Save the CreditHistory record.
        $history->save();
        return $this->wallet;
    }

    /**
     * Spend credits from the wallet.
     *
     * This method allows the client to spend credits from their wallet. The method determines the appropriate credit
     * scope ('manager_credits', 'admin_credits', 'subscription_credits', 'session_credits') based on the requested
     * $amount and deducts the spent amount from the specific credit scope. The total credits in the wallet will also be
     * reduced accordingly. If the user does not have enough credits for spending in any scope, an exception is thrown.
     *
     * @param int $amount The amount of credits to be spent.
     * @throws Exception If the user does not have enough credits to spend.
     */
    public function spend($amount)
    {
        // Determine the credit scope for spending.
        $scope = $this->valid_scope($amount);

        // Deduct the spent amount from the specific credit scope and the total credits in the wallet.

        $this->wallet->$scope -= $amount;

        $this->wallet->type = $scope;



        // Save the updated wallet.
        $this->wallet->save();

        if ($scope == 'subscription_credits') {
            $history = CreditHistory::where('credit_id', $this->wallet->id)
                ->where('user_id', $this->wallet->user_id)
                ->where('shop_id', $this->wallet->shop_id)
                ->where('manager_id', $this->trainer->id)
                ->where('package_id', $this->current_package->id)
                ->where('type', $scope)
                ->latest()
                ->first();
        } else {
            // Find the CreditHistory record for the spending.
            $history = CreditHistory::where('credit_id', $this->wallet->id)
                ->where('user_id', $this->wallet->user_id)
                ->where('shop_id', $this->wallet->shop_id)
                ->where('manager_id', $this->trainer->id)
                ->where('package_id', $this->current_package->id)
                ->where('type', $scope)
                ->first();
        }
        if (!$history) {
            $type = $this->wallet->type;
            $history = CreditHistory::firstOrNew([
                'credit_id' => $this->wallet->id,
                'user_id' => $this->wallet->user_id,
                'shop_id' => $this->wallet->shop_id,
                'manager_id' => $this->wallet->trainer_id,
                'type' => $this->wallet->type,
                'package_id' =>  $this->client->pt_package_id,
                'price' =>  $this->client->pt_package_price,
                'credits' => $this->wallet->$type,
                'history' => $this->wallet->history,
            ]);
        }
        // Deduct the spent amount from the CreditHistory record.
        $history->credits -= $amount;

        // Save the updated CreditHistory record.
        $history->save();
        return $history;
    }

    /**
     * Determine the valid credit scope for spending based on the requested amount.
     *
     * This method checks the hierarchy of credit scopes ('manager_credits', 'admin_credits', 'subscription_credits',
     * 'session_credits') and returns the first scope with enough credits to cover the requested $amount. If the user
     * does not have enough credits in any scope, an exception is thrown.
     *
     * @param int $amount The amount of credits to be spent.
     * @return string The valid credit scope for spending ('manager_credits', 'admin_credits', 'subscription_credits',
     * 'session_credits').
     * @throws Exception If the user does not have enough credits to spend.
     */
    private function valid_scope($amount)
    {
        $hierarchy_of_scopes = [
            'demo_credits',
            'manager_credits',
            'admin_credits',
            'subscription_credits',
            'session_credits'
        ];
        foreach ($hierarchy_of_scopes as $scope) {
            if ($amount <= $this->wallet->$scope) {

                return $scope;
            } else {
                continue;
            }
        }
        throw new Exception('You do not have enough credits');
    }

    public function get()
    {
        return $this->wallet;
    }
}
