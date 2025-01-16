<?php

namespace App\Http\Controllers\Dashboard\Manager;

use App\Http\Controllers\Controller;
use App\Models\Bonus;
use App\Models\Booking;
use App\Models\Credit;
use App\Models\Order;
use App\Models\Package;
use App\Models\Product;
use App\Repository\PersonalTrainerBookingsReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {

        $shop = auth()->user()->getShop();
        if (!$shop->defaultOption) return redirect()->back()->withErrors('Shop do not have default option');

        $manager = auth()->user();

        $orders = Order::where('payment_status', 1)
            ->where('status', 5)
            ->where('type', 1)
            ->whereHas('metas', fn ($query) => $query->where('column_name', 'trainer')->where('column_value', $manager->id))
            ->get();
        $users = Credit::where('trainer_id', auth()->id())
            ->with('user')
            ->orderByRaw('admin_credits + manager_credits + session_credits + subscription_credits')
            ->get();
        $report =  PersonalTrainerBookingsReport::for($shop, $manager);

        $orders =  Order::whereHas('metas', function ($query) {
            $query->where('column_name', 'trainer')->where('column_value', auth()->id());
        })->where('payment_status', 1)->latest()->take(10)->get();




        return view('dashboard.manager.index', compact('orders', 'manager', 'report', 'users'));
    }
    public function products()
    {
        $query = Product::where('shop_id', auth()->user()->getShop()->id);

        if (request()->filled('q')) {

            $query->where('name', 'LIKE', '%' . request()->q . '%')
                ->orWhere('name', 'LIKE', '%' . request()->q . '%');
        };

        $products = $query->paginate(20);
        return view('dashboard.manager.products', compact('products'));
    }


    public function report()
    {
        $user = auth()->user()->id;

        $query = Order::where('referral_code', $user)->where('status', '!=', 0);

        if (request()->filled(['from', 'to'])) {
            $query = $query->whereBetween('created_at', [request()->from, request()->to]);
        }

        $sells = $query->get()->groupBy(function ($data) {
            return $data->created_at->format('Y-m-d');
        })->map(function ($row) {
            return $row->sum('total');
        });
        return view('dashboard.manager.report', compact('sells'));
    }
    public function commissions(Request $request)
    {
        $from =  $request->input('from') ?? now()->startOfMonth();
        $to = $request->input('to') ?? now();

        // $packages = Package::where('packages.shop_id', auth()->user()->getShop()->id)
        //     ->withCount(['bookings' => function ($query) {
        //         $query ->where('end_at', '<',now())
        //         ->where('status',1)
        //         ->where('service_type', 1)->where('manager_id', auth()->id());
        //     }])
        //     ->withSum('bookings', 'commission') // <-- Correction here
        //     ->when($from && $to, function ($query) use ($from, $to) {
        //         // If both "from" and "to" dates are provided, apply the filter
        //         $query->whereHas('bookings', function ($query) use ($from, $to) {
        //             $query->where('start_at', '>=', $from)
        //                 ->where('start_at', '<=', $to);
        //         });
        //     })

        //     ->get();


        $bookings = Booking::where('status', 1)
            ->where('service_type', 1)
            ->when($from && $to, function ($query) use ($from, $to) {
                // If both "from" and "to" dates are provided, apply the filter
                $query->where(function ($query) use ($from, $to) {
                    $query->where('start_at', '>=', $from)
                        ->where('start_at', '<=', $to);
                });
            })
            ->where('manager_id', auth()->id())
            ->selectRaw('commission_type, SUM(commission) as total_commission')
            ->addSelect(\DB::raw('SUM(TIMESTAMPDIFF(MINUTE, start_at, end_at) ) as total_minutes'))
            ->groupBy('commission_type')
            ->get();

        $bonus = Bonus::where('user_id', auth()->id())->when($from && $to, function ($query) use ($from, $to) {
            $query->whereBetween('created_at', [$from, $to]);
        })->sum('amount');

        // Now $bookings will contain the commission type groups and their respective total commissions.


        // Now, $packages will contain the desired result with the sum of commission and filtered bookings based on the "from" and "to" dates.

        return view('dashboard.manager.budget.index', compact('bookings', 'bonus'));
    }


    public function invoice(Order $order)
    {
        $products = $order->products;
        if ($order->shop_id !=  auth()->user()->getShop()->id) {
            return abort(404);
        }
        return view('dashboard.manager.order.invoice', compact('order', 'products'));
    }

    public function download(Order $order)
    {
        $products = $order->products;
        if ($order->shop_id !=  auth()->user()->getShop()->id) {
            return abort(404);
        }
        $pdf = Pdf::loadView('dashboard.manager.order.invoice-pdf', ['order' => $order, 'products' => $products]);

        $fileName = 'invoice/order-invoice-' . $order->id;
        try {
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
