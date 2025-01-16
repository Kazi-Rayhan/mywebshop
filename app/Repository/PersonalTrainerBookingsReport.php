<?php

namespace App\Repository;

use App\Models\Credit;
use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use App\Models\CreditHistory;
use Iziibuy;

class PersonalTrainerBookingsReport
{

    protected Shop $shop;

    protected $managers;
    protected $orders;

    public $report = [];
    public $tables = [];

    public function __construct(Shop $shop, $manager = null)
    {
        $this->shop = $shop;
        if ($manager) {
            $this->managers = User::find($manager->id);
        } else {
            $this->managers = $this->shop->users()
                ->when(request()->filled('manager'), fn ($query) => $query->where('id', request()->manager))
                ->personalTrainer()
                ->get();
        }


        if ($this->managers instanceof \Illuminate\Support\Collection) {
            $ids = $this->managers->pluck('id')->toArray();
        } else {
            $ids = [$this->managers->id];
        }

        $this->orders = Order::where('payment_status', 1)
            ->where('status', 5)
            ->where('type', 1)
            ->whereHas('metas', fn ($query) => $query->where('column_name', 'trainer')->whereIn('column_value', $ids))
            ->get();


        $this->report = [
            'dashboard_total_sale' => Iziibuy::price($this->orders->sum('total')),
            'session_sold' => $this->getHoursSoldResult($this->managers, $this->shop),
            'reslae' => $this->getResalePercentage($this->managers, $this->shop),
            // 'dashboard_customers' => $this->getActiveCustomers($this->managers, $this->shop),
            'completed_hours' => $this->getCompletedHours($this->managers, $this->shop),
            'outstanding-sessions' => $this->getOutstandingSessions($this->managers, $this->shop, $this->orders),
            'sessions_last_week_complete' => $this->getSessionsLastWeekComplete($this->managers, $this->shop),
            'sessions_this_month_complete' => $this->getSessionsThisMonthComplete($this->managers, $this->shop),
            'coverage' => $this->getCoveragePercentage($this->managers),
            'inactive_clients' => $this->getInactiveClients($this->managers, $this->shop),
            'bookings_do_not_show_up' => $this->getBookings($this->managers, $this->shop),
        ];
    }


    private function getHoursSoldResult($manager, $shop)
    {
        if ($manager instanceof \Illuminate\Support\Collection) {
            $ids = $manager->pluck('id')->toArray();
        } else {
            $ids = [$manager->id];
        }
        $credits = Credit::whereIn('trainer_id', $ids)->get();
        $hours_sold_minutes = $credits->sum('history') - ($credits->sum('demo_credits') + $credits->sum('manager_credits') + $credits->sum('admin_credits'));

        $option = $shop->defaultOption;

        if ($option) {
            return  round($hours_sold_minutes / $option->minutes);
        } else {
            return 0;
        }
    }

    private function getResalePercentage($manager, $shop)
    {

        if ($manager instanceof \Illuminate\Support\Collection) {
            $ids = $manager->pluck('id')->toArray();
        } else {
            $ids = [$manager->id];
        }

        $users = User::whereIn('pt_trainer_id',  $ids)
            ->whereHas('credits', function ($query) use ($shop) {
                $query->hasCredits()->where(
                    'shop_id',
                    $shop->id
                );
            })
            ->get();

        if ($users->count() > 0) {

            $user_with_mulitple_orders = (clone $users)->filter(function ($user) {
                return $user->orders()
                    ->where('status', 5)
                    ->where('payment_status', 1)
                    ->where('type', 1)
                    ->count() > 1;
            })->count();

            return [
                'user_with_mulitple_orders' => $user_with_mulitple_orders,
                'resale_percantage' => round(($user_with_mulitple_orders / $users->count()) * 100) . " %",
            ];
        } else {
            return [
                'user_with_mulitple_orders' => 0,
                'resale_percantage' => 0 . " %",
            ];
        }
    }

    private function getActiveCustomers($manager, $shop)
    {

        if ($manager instanceof \Illuminate\Support\Collection) {
            $ids = $manager->pluck('id')->toArray();
        } else {
            $ids = [$manager->id];
        }
        $users = User::whereIn('pt_trainer_id', $ids)->count();



        return  [
            'users' => $users
        ];
    }

    private function getCompletedHours($manager, $shop)
    {
        if ($manager instanceof \Illuminate\Support\Collection) {
            $ids = $manager->pluck('id')->toArray();
        } else {
            $ids = [$manager->id];
        }
        $total = Booking::whereIn('manager_id',  $ids)
            ->where('end_at', '<', now())
            ->where('service_type', 1)
            ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, start_at, end_at)'));

        $option = $shop->defaultOption;
        if ($option) {
            return round($total / $option->minutes);
        } else {
            return 0;
        }
    }

    private function getOutstandingSessions($manager, $shop)
    {
        if ($manager instanceof \Illuminate\Support\Collection) {
            $ids = $manager->pluck('id')->toArray();
        } else {
            $ids = [$manager->id];
        }
        $wallet = CreditHistory::whereIn('type', ['session_credits', 'subscription_credits'])->whereIn('manager_id', $ids)->get();

        $paid_remaining_minutes = $wallet->sum('credits');

        $price = $wallet->sum('history') ? $wallet->sum('price') / $wallet->sum('history') : 0;

        $option = $shop->defaultOption;
        if ($option) {
            $outstanding_sessions = round($paid_remaining_minutes / $option->minutes);
        } else {
            $outstanding_sessions = 0;
        }
        return [
            'outstanding_sessions' => $outstanding_sessions,
            'outstanding_sessions_price' => Iziibuy::price($paid_remaining_minutes * $price),
        ];
    }

    private function getSessionsLastWeekComplete($manager, $shop)
    {
        if ($manager instanceof \Illuminate\Support\Collection) {
            $ids = $manager->pluck('id')->toArray();
        } else {
            $ids = [$manager->id];
        }
        $this_week_complete = Booking::whereIn('manager_id', $ids)
            ->where('service_type', 1)
            ->where('status', 1)
            ->whereBetween('end_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, start_at, end_at)'));

        $option = $shop->defaultOption;
        if ($option) {
            return round($this_week_complete / $option->minutes);
        } else {
            return 0;
        }
    }

    private function getSessionsThisMonthComplete($manager, $shop)
    {
        if ($manager instanceof \Illuminate\Support\Collection) {
            $ids = $manager->pluck('id')->toArray();
        } else {
            $ids = [$manager->id];
        }
        $this_month_complete = Booking::whereIn('manager_id', $ids)
            ->where('service_type', 1)
            ->where('status', 1)
            ->whereBetween('end_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, start_at, end_at)'));

        $option = $shop->defaultOption;
        if ($option) {
            return round($this_month_complete / $option->minutes);
        } else {
            return 0;
        }
    }

    private function getCoveragePercentage($manager)
    {
        if ($manager instanceof \Illuminate\Support\Collection) {
            $ids = $manager->pluck('id')->toArray();
        } else {
            $ids = [$manager->id];
        }
        $total = Booking::whereIn('manager_id', $ids)
            ->where('service_type', 1)
            ->where('status', 1)
            ->where('end_at', '<', now())
            ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, start_at, end_at)'));

        $minutes = Credit::whereIn('trainer_id', $ids)->sum('history');

        if ($minutes && $total) {
            return round(($total / $minutes) * 100) . ' %';
        } else {
            return 0 . ' %';
        }
    }

    public function getInactiveClients($manager, $shop)
    {
        if ($manager instanceof \Illuminate\Support\Collection) {
            $ids = $manager->pluck('id')->toArray();
        } else {
            $ids = [$manager->id];
        }
        return User::whereHas('credits', function ($query) use ($manager, $shop, $ids) {
            $query->whereIn('trainer_id', $ids)->where('updated_at', '>=', now()->subDays($shop->inactive_days));
        })->count();
    }
    public function getBookings($manager, $shop)
    {
        if ($manager instanceof \Illuminate\Support\Collection) {
            $ids = $manager->pluck('id')->toArray();
        } else {
            $ids = [$manager->id];
        }
        return Booking::where('shop_id', $shop->id)->whereIn('manager_id', $ids)->where('status', 1)->where('show_up', 0)->count();
    }



    public static function for(Shop $shop, User $manager = null)
    {
        return (new self($shop, $manager))->report;
    }
}
