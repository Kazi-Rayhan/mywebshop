<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Credit;
use App\Models\CreditHistory;
use App\Models\Level;
use App\Models\User;

class Commission
{


    protected CreditHistory $wallet;
    protected Booking $booking;
    protected User $manager;
    protected Level $level;
    protected User $client;

    public function __construct(CreditHistory $credit, Booking $booking)
    {
        $this->wallet = $credit;
        $this->booking = $booking;
        $this->manager = $this->booking->manager;
        $this->level = Level::find($this->manager->level);
        $this->client = $this->booking->customer;
    }

    protected function getCommission()
    {
        switch ($this->wallet->type) {
            case 'demo_credits':

                return $this->level->demo_session_commission;
                break;
            case 'manager_credits':
                return $this->level->manager_session_commission;
                break;
            case 'admin_credits':
                return $this->level->admin_session_commission;
                break;
            default:
                return $this->level->commission;
                break;
        }
    }



    public function give()
    {
        $this->booking->update(
            [
                'package_id' => $this->client->pt_package_id,
                'commission' => $this->getCommission(),
                'commission_level' => $this->level->title,
                'commission_type' => $this->wallet->type
            ]
        );
        return $this;
    }
}
