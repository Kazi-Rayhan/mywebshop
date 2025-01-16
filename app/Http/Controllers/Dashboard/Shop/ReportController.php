<?php
namespace App\Http\Controllers\Dashboard\Shop;

use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Repository\PersonalTrainerBookingsReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {

        $shop = auth()->user()->getShop();

        $query = Order::where('payment_status', 1)->where('shop_id', $shop->id)->where('status', '!=', 0);

        if (request()->filled('filter')) {
            $query = $query->where('referral_code', request()->filter);
        }
        if (request()->filled(['from', 'to'])) {
            $query = $query->whereBetween('created_at', [request()->from, request()->to]);
        }
        $sells = $query->get()->groupBy(function ($data) {
            return $data->created_at->format('Y-m-d');
        })->map(function ($row) {
            return $row->sum('total');
        });


        return view('dashboard.shop.report.index', compact('sells', 'shop'));
    }
    public function ptReport(Request $request)
    {
        if (!auth()->user()->getShop()->defaultOption) return redirect()->back()->withErrors('Shop do not have default option');
        $allManagers =  auth()->user()->shop->users()->personalTrainer()->get();

        $shop = auth()->user()->getShop();
        $managers = $shop->users()
            ->when($request->filled('manager'), fn ($query) => $query->where('id', $request->manager))
            ->personalTrainer()
            ->get();


        $orders = Order::where('payment_status', 1)
        ->where('status', 5)
        ->where('type', 1)
        ->whereHas('metas', fn ($query) => $query->where('column_name', 'trainer')->whereIn('column_value', $managers->pluck('id')->toArray()))
        ->when($request->filled('from') && $request->filled('to'), fn ($query) =>  $query->whereBetween('created_at', [request()->filled('from'), request()->filled('to')]))
        ->get();

        $report =  PersonalTrainerBookingsReport::for($shop);
        

        return view('dashboard.shop.report.pt_report', compact('allManagers', 'orders', 'managers' ,'report'));
    }
  
    public function clients()
    {
        $managers =  auth()->user()->shop->users()->personalTrainer()->get()->pluck('id')->toArray();
        $users = User::whereHas('metas', function ($query) use ($managers) {
            $query->where('column_name', 'personal_trainner')->whereIn('column_value', $managers);
        })->latest()->paginate(10);
        $shop = auth()->user()->getShop();
        return view('dashboard.shop.report.clients', compact('users', 'shop'));
    }
}
