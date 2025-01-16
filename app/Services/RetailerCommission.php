<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Shop;
use Iziibuy;

class RetailerCommission
{
    /***
     * This class process all the commission related calculations
     * There are theree type of commisssion
     *
     * 1/One time pay out
     * 2/Commission from recurring payments
     * 3/Commission from sales
     *
     * --------------------------------------------
     * One Time Pay Out
     * --------------------------------------------
     * If the commission is one time payout then You have initialize the class with "one_time_pay_out" method which will recive
     * Shop object as it parameter and have to chain it with "pay" methohd
     *
     * Example : RetailerCommission::one_time_pay_out($shop)->pay()
     *
     *---------------------------------------------
     * Commission from recurring payments
     * --------------------------------------------
     * If the commission from recurring payments then You have initialize the class with "commission_from_recurring_payments" method which will recive
     * Shop object as it parameter and have to chain it with "pay" methohd
     *
     * Example : RetailerCommission::commission_from_recurring_payments($shop)->pay()
     *
     *---------------------------------------------
     * Commission from sales
     * --------------------------------------------
     * If the commission from sales then You have initialize the class with "commission_from_sales" method which will recive
     * Order object as it parameter and have to chain it with "pay" methohd
     *
     * Example : RetailerCommission::commission_from_sales($order)->pay()
     */
    protected $shop;
    protected $method;
    protected $order;
    protected $date = null;
    protected $retailer_user;

    public function __construct(?Shop $shop = null, ?string $method = null, ?Order $order = null)
    {
        $this->shop = $shop;
        $this->method = $method;
        $this->order = $order;
        $this->retailer_user = null;

        if ($this->shop && $this->shop->retailer) {
            // If $this->shop is not null and $this->shop->retailer is not null
            $this->retailer_user = $this->shop->retailer;
        } elseif ($this->order && $this->order->shop && $this->order->shop->retailer) {
            // If $this->order is not null, $this->order->shop is not null, and $this->order->shop->retailer is not null
            $this->retailer_user = $this->order->shop->retailer;
        }
    }

    public static function one_time_pay_out($shop)
    {
        return new static($shop, 'one_time_pay_out');
    }

    public static function commission_from_recurring_payments($shop)
    {
        return new static($shop, 'commission_from_recurring_payments');
    }

    public static function commission_from_sales($order)
    {
        return new static(null, 'commission_from_sales', $order);
    }


    public static function pending_commissions($shop)
    {
        return new static($shop, 'pendings_commissions');
    }


    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }


    public function pay()
    {
        if ($this->retailer_user && $this->retailer_user->retailer->status) {
            switch ($this->method) {
                case 'one_time_pay_out':
                    $this->oneTimePayout();
                    break;
                case 'commission_from_recurring_payments':
                    $this->commissionFromRecurringPayments();
                    break;
                case 'commission_from_sales':
                    return $this->commissionFromSales();
                    break;
                case 'pendings_commissions':
                    $this->pendingCommissions();
                    break;
                default:
                    return;
                    break;
            }
        } else {
            return;
        }
    }
    protected function oneTimePayout()
    {
        if ($this->shop->is_demo == true) return;
        if (!$this->shop->has('retailer') || empty($this->retailer_user->retailer->retailerType->one_time_pay_out)) return;
        $amount = $this->retailer_user->retailer->retailerType->one_time_pay_out;


        if ($this->retailer_user->retailer->parent_id != null) {
            $sub_retailer_commission = $this->retailer_user->retailer->retailerType->sub_retailer_one_time_pay_out;
            if (is_numeric($sub_retailer_commission)) {
                $sub_retailer_commission_amount =  $sub_retailer_commission;

                $this->retailer_user->retailer->parent->earn(
                    [
                        'shop' => $this->shop->id,
                        'amount' => abs(($amount - $sub_retailer_commission_amount)),
                        'method' => $this->method,
                        'created_at' => $this->date,
                        'details' => json_encode([
                            'shop' => [
                                'id' => $this->shop->id,
                                'name' => $this->shop->company_name,
                                'user_name' => $this->shop->user_name,
                            ],
                        ])
                    ]
                );
                $amount = $sub_retailer_commission_amount;
            }
        }


        $this->retailer_user->earn(
            [
                'shop' => $this->shop->id,
                'amount' => abs($amount),
                'method' => $this->method,
                'created_at' => $this->date,
                'details' => json_encode([
                    'shop' => [
                        'id' => $this->shop->id,
                        'name' => $this->shop->company_name,
                        'user_name' => $this->shop->user_name,
                    ],
                ])
            ]
        );
    }

    protected function commissionFromRecurringPayments()
    {



        if ($this->shop->is_demo == true) return;
        if ($this->shop->monthly_cost <= 100) return;

        if (!$this->shop->has('retailer') || empty($this->retailer_user->retailer->retailerType->commission_from_recurring_payments)) return;

        $amount = Iziibuy::needToCharge($this->shop->monthly_cost - 100) * ($this->retailer_user->retailer->retailerType->commission_from_recurring_payments / 100);


        if ($this->retailer_user->retailer->parent_id != null) {
            $sub_retailer_commission = $this->retailer_user->retailer->retailerType->sub_retailer_commission_from_recurring_payments;
            if (is_numeric($sub_retailer_commission)) {
                $sub_retailer_commission_amount =  $amount * ($sub_retailer_commission / 100);

                $this->retailer_user->retailer->parent->earn(
                    [
                        'shop' => $this->shop->id,
                        'amount' => abs(($amount - $sub_retailer_commission_amount)),
                        'method' => $this->method,
                        'created_at' => $this->date,
                        'details' => json_encode([
                            'shop' => [
                                'id' => $this->shop->id,
                                'name' => $this->shop->company_name,
                                'user_name' => $this->shop->user_name,
                            ],
                        ])
                    ]
                );
                $amount = $sub_retailer_commission_amount;
            }
        }

        $this->retailer_user->earn(
            [
                'shop' => $this->shop->id,
                'amount' => abs($amount),
                'method' => $this->method,
                'created_at' => $this->date,
                'details' => json_encode([
                    'shop' => [
                        'id' => $this->shop->id,
                        'name' => $this->shop->company_name,
                        'user_name' => $this->shop->user_name,
                    ],
                ])
            ]
        );
    }

    protected function commissionFromSales()
    {
        if ($this->order->shop->is_demo == true) return;
        if (!$this->order->shop->has('retailer') || empty($this->retailer_user->retailer->retailerType->commission_from_sales)) return;

        $amount = (($this->order->subtotal) * 0.007 * ($this->retailer_user->retailer->retailerType->commission_from_sales / 100));

        if ($this->retailer_user->retailer->parent_id != null) {
            $sub_retailer_commission = $this->retailer_user->retailer->retailerType->sub_retailer_commission_from_sales;
            if (is_numeric($sub_retailer_commission)) {
                $sub_retailer_commission_amount =  $amount * ($sub_retailer_commission / 100);
                $this->retailer_user->retailer->parent->earn(
                    [
                        'shop' => $this->order->shop->id,
                        'amount' => ($amount - $sub_retailer_commission_amount),
                        'method' => $this->method,
                        'created_at' => $this->date,
                        'details' => json_encode([
                            'shop' => [
                                'id' => $this->order->shop->id,
                                'name' => $this->order->shop->company_name,
                                'user_name' => $this->order->shop->user_name,
                            ],
                            'order' => [
                                'id' => $this->order->id,
                                'name' => $this->order->first_name . ' ' . $this->order->last_name,
                                'email' => $this->order->email,
                                'subtotal' => $this->order->subtotal,
                                'discount' => $this->order->discount,
                                'shipping_cost' => $this->order->shipping_cost,
                                'tax' => $this->order->tax,
                                'total' => $this->order->total,
                                'user' => $this->order->user ? [
                                    'id' => $this->order->user->id,
                                    'name' => $this->order->user->full_name,
                                    'email' => $this->order->email
                                ] : null
                            ]
                        ])
                    ]
                );
                $amount = $sub_retailer_commission_amount;
            }
        }


        $this->retailer_user->earn(
            [
                'shop' => $this->order->shop->id,
                'amount' => $amount,
                'method' => $this->method,
                'created_at' => $this->date,
                'details' => json_encode([
                    'shop' => [
                        'id' => $this->order->shop->id,
                        'name' => $this->order->shop->company_name,
                        'user_name' => $this->order->shop->user_name,
                    ],
                    'order' => [
                        'id' => $this->order->id,
                        'name' => $this->order->first_name . ' ' . $this->order->last_name,
                        'email' => $this->order->email,
                        'subtotal' => $this->order->subtotal,
                        'discount' => $this->order->discount,
                        'shipping_cost' => $this->order->shipping_cost,
                        'tax' => $this->order->tax,
                        'total' => $this->order->total,
                        'user' => $this->order->user ? [
                            'id' => $this->order->user->id,
                            'name' => $this->order->user->full_name,
                            'email' => $this->order->email
                        ] : null
                    ]
                ])
            ]
        );
    }

    protected function pendingCommissions()
    {

        if ($this->shop->status  == false) return;
        if ($this->shop->is_demo == true) return;
        if (!$this->shop->has('retailer') || empty($this->retailer_user->retailer->retailerType->commission_from_recurring_payments)) return;

        if ($this->shop->previous_retailer) {
            $date = $this->shop->retailer_joined_at;
        } else {
            $date = $this->shop->retailer_joined_at ?? $this->shop->created_at;
            RetailerCommission::one_time_pay_out($this->shop)->pay();
        }

        $cost = $this->shop->charges()->where('created_at', '<=', $date)->sum('amount') / 100;
        $commissionFromRecurringPayment = ($cost) * ($this->retailer_user->retailer->retailerType->commission_from_recurring_payments / 100);

        $this->retailer_user->earn(
            [
                'shop' => $this->shop->id,
                'amount' => abs($commissionFromRecurringPayment),
                'method' => 'commission_from_recurring_payments',
                'created_at' => $this->date ?? now(),
                'details' => json_encode([
                    'shop' => [
                        'id' => $this->shop->id,
                        'name' => $this->shop->company_name,
                        'user_name' => $this->shop->user_name,
                    ],
                ])
            ]
        );
        $orders =  $this->shop->orders()->where('created_at', '<=', $date)->get();
        foreach ($orders as $order) {
            RetailerCommission::commission_from_sales($order)->pay();
        }
    }
}
