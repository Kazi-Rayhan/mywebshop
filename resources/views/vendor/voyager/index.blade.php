<?php
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;
$today = new DateTime('today');

$products = Product::where('parent_id', null)
    ->when(request()->has('short'), function ($query) {
        $query->whereHas('shop', function ($q) {
            return $q->where('user_name', request()->short);
        });
    })
    ->when(Request()->has('start') || Request()->has('end'), function ($query) {
        $query->whereBetween('created_at', [Request('start'), Request('end')]);
    });
$topProducts = Product::where('parent_id', null)
    ->when(request()->has('short'), function ($query) {
        $query->whereHas('shop', function ($q) {
            return $q->where('user_name', request()->short);
        });
    })
    ->when(Request()->has('start') || Request()->has('end'), function ($query) {
        $query->whereBetween('created_at', [Request('start'), Request('end')]);
    });
$orders = Order::where('status', 1)
    ->when(request()->has('short'), function ($query) {
        $query->whereHas('shop', function ($q) {
            return $q->where('user_name', request()->short);
        });
    })
    ->when(Request()->has('start') || Request()->has('end'), function ($query) {
        $query->whereBetween('created_at', [Request('start'), Request('end')]);
    });
$orders_sold_old = Order::where('status', 1)->when(request()->has('short'), function ($query) {
    $query->whereHas('shop', function ($q) {
        return $q->where('user_name', request()->short);
    });
})->when(Request()->has('start') || Request()->has('end'), function ($query) {
    $query->whereBetween('created_at', [Request('start'), Request('end')]);
});

$shops_old = User::when(request()->has('short'), function ($query) {
    $query->whereHas('shop', function ($q) {
        return $q->where('user_name', request()->short);
    });
})->when(Request()->has('start') || Request()->has('end'), function ($query) {
    $query->whereBetween('created_at', [Request('start'), Request('end')]);
});
$avarageOrderOld = Order::where('status', 1)->when(request()->has('short'), function ($query) {
    $query->whereHas('shop', function ($q) {
        return $q->where('user_name', request()->short);
    });
})->when(Request()->has('start') || Request()->has('end'), function ($query) {
    $query->whereBetween('created_at', [Request('start'), Request('end')]);
});

$products = $products->orderBy('sale_count', 'desc')->paginate('5');
$topProducts = $topProducts->orderBy('view', 'desc')->paginate('5');
$orders = $orders->paginate('5');

$users = User::where('role_id', 2)->count();
$usersToday = User::where('created_at', $today)
    ->where('role_id', 2)
    ->count();

$shops = App\Models\Shop::where('status', 1)
    ->when(Request()->has('start') || Request()->has('end'), function ($query) {
        $query->whereBetween('created_at', [Request('start'), Request('end')]);
    })
    ->count();
$shopsToday = $shops_old
    ->where('created_at', $today)
    ->where('role_id', 3)
    ->count();

$orders_sold = $orders_sold_old->sum('total');
$todaySold = $orders_sold_old->where('created_at', $today)->sum('total');

$totalOrder = $avarageOrderOld->sum('total');

$avarageOrder = $totalOrder / ($avarageOrderOld->count('id') ?: 1);
$avarageToday = $todaySold / ($avarageOrderOld->count('id') ?: 1);

$topUsers = User::join('orders', 'users.id', '=', 'orders.user_id')
    ->select('users.*', DB::raw('sum(orders.total) as total_orders'))
    ->groupBy('users.id')
    ->orderByDesc('total_orders')
    ->take(5)
    ->get();


function money_format($number)
{
    return number_format($number, 0, ',', ' ');
}
?>
@extends('voyager::master')
@section('css')


    <style>
        .widget.widget-tile {
            padding: 24px 20px;
            margin-bottom: 25px;
            display: table;
            table-layout: fixed;
            width: 100%;
        }

        .widget {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 3px;
        }

        .widget.widget-tile .chart {
            width: 85px;
            min-height: 45px;
            padding: 5px 0;
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .widget.widget-tile .data-info {
            display: table-cell;
            text-align: left;
        }

        .widget.widget-tile .data-info .desc {
            font-size: 1.077rem;
            line-height: 18px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .widget.widget-tile .data-info .value {
            font-size: 1.693rem;
            font-weight: 300;
        }

        .widget.widget-tile .chart .icon {
            font-size: 30px;
        }

        .text-white {
            color: #fff
        }

        .font-bolder {
            font-weight: bolder;
        }

        .table-header {
            color: #fff !important;
            margin-left: 30px;
        }

        .voyager .table>thead>tr>th {
            background-color: #7C9DA6 !important;
            color: #fff !important;
            padding: 0 20px;
            font-size: 12px !important;
            border-bottom: 0 !important;
        }

        .voyager .table>tbody>tr>td {
            padding: 10px 20px;
        }

        .table>thead>tr>th {
            vertical-align: middle;
        }

        .table>tbody tr:first-child>td {
            border-top: 0 !important;
        }

        .table>tbody>tr>td {
            color: #fff !important;
        }

        .date-feild {
            margin: 0 10px;
            padding: 4px 10px;
            border: 1px solid #dddddd;
            border-radius: 10px;
            color: #888;
        }
    </style>
@stop
@section('content')
    <div class="" style="margin-left: 30px;">
        @include('voyager::alerts')
        @php
            $enterprise = App\Models\Enterprise::firstOrNew();
        @endphp
        {{-- @if (!$enterprise->subscription_id)
            <div class="row ">
                <div class="card">
                    <div class="card-body">
                        <h1>Subscription @if ($enterprise->status)
                            <span class="badge badge-success">on</span> @else<span class="badge badge-danger">off</span>
                            @endif
                        </h1>
                        <p>
                            {{ __('words.subscription_description_deactive') }}
                        </p>
                        <a href="{{ route('admin.start_subscription') }}" class="btn btn-success">Start Subscription</a>
                    </div>
                </div>
            </div>
        @else
            <div class="row ">
                <div class="card ">
                    <div class="card-body">
                        <h1>Subscription @if ($enterprise->status)
                            <span class="badge badge-success">on</span> @else<span class="badge badge-danger">off</span>
                            @endif
                        </h1>
                        <p>
                            {{ __('words.subscription_description_active') }}
                        </p>
                        <a href="#" disabled class="btn btn-danger">Stop Subscription</a>
                    </div>
                </div>
            </div>
        @endif --}}
        <br>
        <br>
        <div class="row">
            <div class="col-md-4" style="background-color: #333B52; border-radius:10px;padding:0">

                <h3 style="color: #fff !important; padding:0 15px">Sales Dashboard</h3>
                <div style="background-color: #7C9DA6;display:flex;justify-content:space-around; ">
                    <p style=" font-size:18px; font-weight:500;margin-top:7px">Short By :</p>
                    <div class="dropdown">
                        <a href="" style="color:#fff" class="btn  dropdown-toggle" href="#"
                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (request()->has('short'))
                                @php
                                    $shop = App\Models\Shop::where('user_name', request()->short)->first();
                                @endphp
                                {{ @$shop->name ?? 'No Shop' }}
                            @else
                                All Shop
                            @endif <span class="caret"></span>
                        </a>

                        <div style="background-color: #7C9DA6;" class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="" style="margin: 5px 10px; color:#fff; display:block"
                                href="{{ route('voyager.dashboard') }}">All Shop</a>
                            @foreach (App\Models\Shop::all() as $shop)
                                <a class="" style="margin: 5px 10px; color:#fff; display:block"
                                    href="{{ route('voyager.dashboard', ['short' => $shop->user_name]) }}">{{ $shop->name }}
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-3">

            </div>
            <div class="col-md-5" style="color:#888">
                <form action="" method="get">
                    {{-- <a class="btn btn-success" href="{{ route('admin.dashboard.pdf', request()->all()) }}">Download PDF</a> --}}
                    <button type="submit" class="btn btn-info">Short</button>
                    <input class="date-feild" type="date" name="start" id="" required> To <input
                        class="date-feild" type="date" name="end" id="" required>
                </form>

            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="row">
                    <div class="col-12">
                        <div class="widget widget-tile" style="background: #333B52;border-radius:10px">
                            <div class="data-info">
                                <div class=" text-white"
                                    style="font-size: 20px; font-weight:100;letter-spacing:2px; margin-bottom:5px">
                                    Total Sales
                                </div>
                                <div class="value text-center">
                                    <span class="text-white font-bolder"></span>
                                    <span class="text-white font-bolder"
                                        style="font-size: 30px; font-weight:800">{{ money_format($orders_sold) }} </span>
                                </div>
                                <div class="desc text-white " style="font-size:14px;margin-top:10px">
                                    So far today <span style="margin-left:8px">+{{ $todaySold }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="widget widget-tile" style="background: #333B52;border-radius:10px">
                            <div class="data-info">
                                <div class=" text-white"
                                    style="font-size: 20px; font-weight:100;letter-spacing:2px; margin-bottom:5px">
                                    Total Shop
                                </div>
                                <div class="value text-center">
                                    <span class="text-white font-bolder"></span>
                                    <span class="text-white font-bolder"
                                        style="font-size: 30px; font-weight:800;display:block;text-align:center">{{ $shops }}
                                    </span>
                                </div>
                                <div class="desc text-white " style="font-size:14px;margin-top:10px">
                                    So far today <span style="margin-left:8px">+{{ $shopsToday }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="widget widget-tile" style="background: #333B52;border-radius:10px">
                            <div class="data-info">
                                <div class=" text-white"
                                    style="font-size: 20px; font-weight:100;letter-spacing:2px; margin-bottom:5px text-align:center">
                                    Total Customers
                                </div>
                                <div class="value text-center">
                                    <span class="text-white font-bolder"></span>
                                    <span class="text-white font-bolder"
                                        style="font-size: 30px; font-weight:800;text-align:center">{{ $users }}
                                    </span>
                                </div>
                                <div class="desc text-white " style="font-size:14px;margin-top:10px">
                                    So far today <span style="margin-left:8px">+{{ $usersToday }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-12">
                        <div class="widget widget-tile" style="background: #333B52;border-radius:10px">
                            <div class="data-info">
                                <div class=" text-white"
                                    style="font-size: 20px; font-weight:100;letter-spacing:2px; margin-bottom:5px">
                                    Avarage Order
                                </div>
                                <div class="value text-center">
                                    <span class="text-white font-bolder"></span>
                                    <span class="text-white font-bolder"
                                        style="font-size: 30px; font-weight:800; display:block;text-align:center">{{ money_format($avarageOrder) }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9" style="margin: 0 10px;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card" style="background: #333B52;border-radius:10px;padding:0">
                            <div class="">
                                <h3 class="table-header">Latest Orders</h3>
                            </div>

                            <div class="card-body p-0" style="padding: 0;">
                                <div class="table-responsive">
                                    <table class="table ">
                                        <thead class="thead">
                                            <tr>
                                                <th>ID</th>
                                                <th>Price</th>
                                                <th>CREATED AT</th>
                                                <th>INFORMATION</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody">
                                            @foreach ($orders->take(5) as $order)
                                                <tr>
                                                    <td>
                                                        <a class="text-warning"
                                                            href="{{ route('voyager.orders.show', $order->id) }}">
                                                            {{ $order->id }}</a>
                                                    </td>
                                                    <td>{{ $order->total }}</td>
                                                    <td>
                                                        {{ $order->created_at->format('m-d-Y') }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('voyager.orders.show', $order->id) }}"
                                                            style="color: #fff; text-decoration:none">Details</a>
                                                    </td>
                                                </tr>
                                            @endforeach




                                        </tbody>
                                    </table>
                                </div>

                            </div>

                            <div class="card-footer ">
                                <a href="{{ url('admin/orders') }}" class=""
                                    style="text-align: center; display:block ;margin:10px 0;color:#fff">View All Orders</a>
                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a> -->
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card" style="background: #333B52;border-radius:10px;padding:0">
                            <div class="">
                                <h3 class="table-header">Most Sold Products</h3>
                            </div>

                            <div class="card-body p-0" style="padding: 0;">
                                <div class="table-responsive">
                                    <table class="table ">
                                        <thead class="thead">
                                            <tr>
                                                <th>NAME</th>
                                                <th>Price</th>
                                                <th>Sku</th>
                                            </tr>
                                        </thead>
                                        @foreach ($products as $product)
                                            <tbody class="tbody">
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('voyager.products.edit', $product->parent_id ? $product->parent_id : $product->id) }}"
                                                            class="text-warning">{{ Str::limit($product->name, 20, '') }}</a>
                                                    </td>
                                                    <td>{{ $product->price }}</td>
                                                    <td>
                                                        <a href="{{ route('voyager.products.edit', $product->parent_id ? $product->parent_id : $product->id) }}"
                                                            class="text-warning">{{ $product->sku }}</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @endforeach

                                    </table>
                                </div>

                            </div>

                            <div class="card-footer ">
                                <a href="{{ url('admin/products') }}" class=""
                                    style="text-align: center; display:block ;margin:10px 0;color:#fff">View All
                                    Products</a>
                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a> -->
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card" style="background: #333B52;border-radius:10px;padding:0">
                            <div class="">
                                <h3 class="table-header">Top 5 Customer</h3>
                            </div>

                            <div class="card-body p-0" style="padding: 0;">
                                <div class="table-responsive">
                                    <table class="table ">
                                        <thead class="thead">
                                            <tr>
                                                <th>NAME</th>
                                                <th>Total Amount</th>
                                            </tr>
                                        </thead>
                                        @foreach ($topUsers as $user)
                                            <tbody class="tbody">
                                                <tr>
                                                    <td>
                                                        <a class="text-warning"
                                                            href="{{ route('voyager.users.edit', $user->id) }}">{{ $user->name }}</a>
                                                    </td>

                                                    <td>{{ $user->total_orders }}</td>
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div>

                            </div>

                            <div class="card-footer ">
                                <a href="{{ url('admin/users') }}" class=""
                                    style="text-align: center; display:block ;margin:10px 0;color:#fff">View All Users</a>
                                <!-- <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a> -->
                            </div>

                        </div>
                    </div>
                 
                </div>
            </div>
        </div>

    </div>
@stop

@section('javascript')

@stop
