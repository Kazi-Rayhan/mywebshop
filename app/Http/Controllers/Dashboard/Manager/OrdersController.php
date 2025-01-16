<?php

namespace App\Http\Controllers\Dashboard\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        
        if(auth()->user()->view_orders != '1') abort(403);
        $orders = Order::with('metas')->where('shop_id', auth()->user()->getShop()->id)
            ->where(function ($query) {
                $query->when(request()->filled('payment_status'), function ($query) {
                    $query->where('payment_status', request()->payment_status);
                })->when(request()->filled('status') && request()->status != 'all', function ($query) {
                    $query->where('status', request()->status);
                })->when(
                    request()->has('search'),
                    function ($query) {
                        $query->whereHas('metas', function ($q) {

                            $q->whereIn('column_name', ['first_name', 'last_name', 'email', 'phone', 'city', 'address', 'post_code', 'state', 'referral_code'])->where('column_value', 'LIKE', '%' . request()->search . '%');
                        })->orWhere('id', 'LIKE', '%' . request()->search . '%');
                    }
                );
            })
            ->latest()
            ->paginate(20);
        return view('dashboard.manager.order.index', compact('orders'));
    }


    public function invoice(Order $order)
    {
        if(auth()->user()->view_orders != '1') abort(403);
        $products = $order->products;
        if ($order->shop_id !=  auth()->user()->getShop()->id) {
            return abort(404);
        }
        return view('dashboard.manager.order.invoice', compact('order', 'products'));
    }

    public function download(Order $order)
    {
        if(auth()->user()->view_orders != '1') abort(403);
        $products = $order->products;
        if ($order->shop_id !=  auth()->user()->getShop()->id) {
            return abort(404);
        }
        $pdf = Pdf::loadView('dashboard.manager.order.invoice-pdf', ['order' => $order, 'products' => $products]);

        // $fileName = 'invoice/order-invoice-' . $order->id;/

        return $pdf->download('order' . $order->id . '.pdf');
    }
}
