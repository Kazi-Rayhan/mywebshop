<?php

namespace App\Models\Traits;

use App\Models\RetailerEarning;
use App\Models\RetailerMeta;
use App\Models\RetailerWithdrawal;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait IsRetailer
{

    public function retailerShops()
    {
        return $this->hasMany(Shop::class, 'retailer_id');
    }
    public function earnings()
    {
        return $this->hasMany(RetailerEarning::class, 'user_id');
    }

    public function subRetailers()
    {
        return $this->hasMany(RetailerMeta::class, 'parent_id');
    }

    public function withdrawals()
    {
        return $this->hasMany(RetailerWithdrawal::class, 'user_id');
    }


    public function earn($details)
    {
        $earning = $this->earnings()->create([
            'shop_id' => $details['shop'],
            'amount' => $details['amount'],
            'method' => $details['method']
        ]);

        if (isset($details['details'])) {
            $earning->createMeta('details', $details['details']);
        }
    }

    public function withdraw($amount)
    {
        return $this->withdrawals()->create([
            'amount' => $amount
        ]);
    }

    public function totalWithdrawal()
    {
        return $this->withdrawals()->where('status', 1)->sum('amount') / 100;
    }

    public function totalEarning()
    {
        return ($this->earnings()->where('transaction_type', 'Add')->sum('amount') - $this->earnings()->where('transaction_type', 'Remove')->sum('amount')) / 100;
    }

    public function totalBalance()
    {
        return $this->totalEarning() - $this->totalWithdrawal();
    }

    public function hasBankAccount()
    {
        return !empty($this->retailer->bank_account_number) ? true : false;
    }

    public function retailerBalance(): Attribute
    {
        return Attribute::make(get: fn () => $this->totalBalance());
    }
}
