<?php

namespace App\Http\Controllers\Dashboard\Shop;

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
        $orders = Order::with('metas')->where('shop_id', auth()->user()->shop->id)
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
        return view('dashboard.shop.order.index', compact('orders'));
    }


    public function invoice(Order $order)
    {
        $products = $order->products;
        if ($order->shop_id != auth()->user()->shop->id) {
            return abort(404);
        }
        return view('dashboard.shop.order.invoice', compact('order', 'products'));
    }

    public function download(Order $order)
    {
        $products = $order->products;
        if ($order->shop_id != auth()->user()->shop->id) {
            return abort(404);
        }
        $pdf = Pdf::loadView('dashboard.shop.order.invoice-pdf', ['order' => $order, 'products' => $products]);

        // $fileName = 'invoice/order-invoice-' . $order->id;/

        return $pdf->download('order' . $order->id . '.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}