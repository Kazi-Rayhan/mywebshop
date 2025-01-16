<?php

namespace App\Models\Traits;

use App\Models\Credit;
use App\Models\CreditHistory;
use App\Models\Shop;
use App\Models\User;

trait Credits
{

    public function credits()
    {
        return $this->hasMany(Credit::class);
    }

    public function getTrainerFromThisShop(Shop $shop)
    {

        return $this->credits->where('shop_id', $shop->id)->first()->trainer ?? null;
    }

    public function getCredit(Shop $shop, User $trainer)
    {
        return $this->credits()->where('shop_id', $shop->id)->where('trainer_id', $trainer->id)->first();
    }

    public function addCredits($shop, $trainer, $credits, $free_credit = 0)
    {
        $data = Credit::firstOrNew(['user_id' => $this->id, 'shop_id' => $shop, 'trainer_id' => $trainer]);
        $data->credits = ($data->credits + $credits);
        $data->history = ($data->history + $credits);
        if ($free_credit > 0) {
            $data->free_credit = $free_credit;
        }
        $data->save();

        $dataH = CreditHistory::firstOrNew([
            'user_id' => $this->id,
            'shop_id' => $shop,
            'manager_id' => $trainer,
            'package_id' => $this->pt_package_id,
            'price' => $this->pt_package_price
        ]);
        $dataH->credits = ($data->credits + $credits);
        $dataH->history = ($data->history + $credits);

        $dataH->save();

        return $data;
    }
    public function subtractCredits($shop, $trainer, $credits)
    {
        $credit = $this->getCredit($shop->id, $trainer);

        $creditH = $this->current_credit($shop->id, $trainer, $credits);
        if ($credit->credits >= $credits) {
            $credit->decrement('credits', $credits);
            $creditH->decrement('credits', $credits);
        } elseif ($credit->free_credit >= $credits) {
            $credit->decrement('free_credit', $credits);
            // $creditH->decrement('credits', $credits);
        } else {
            throw new Exception('Not enough credit');
        }
    }
}
