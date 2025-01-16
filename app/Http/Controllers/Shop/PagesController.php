<?php

namespace App\Http\Controllers\Shop;

use Iziibuy;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Changelog;
use App\Models\Product;
use App\Models\Service;
use App\Models\Shop;
use App\Models\User;
use App\Services\Period;
use App\Models\Slider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{

    public function index($user_name)
    {

        $shop = Iziibuy::getShop();

        $sliders = Slider::where('shop_id', $shop->id)->get();
        $new_products = Product::where('shop_id',$shop->id)->published()->with('shop')->featured()->get();

        $categories = Category::where('shop_id', $shop->id)
            ->whereNull('parent_id')
            ->has('products')
            ->get();


        $category_list =  $this->displayNestedCategories($categories);


        return view('shop.home', compact('new_products', 'sliders','category_list','shop'));
    }
    public function products($user_name)
    {

        $shop = Shop::where('user_name', request()->user_name)->first();



        $search = request()->search;
        $category = request()->category;
        $categories = Category::where('shop_id', $shop->id)
            ->whereNull('parent_id')
            ->has('products')
            ->get();


        $category_list =  $this->displayNestedCategories($categories);




        $products = Product::ownedByThisShop($shop)->published()
            ->with('shop')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('sku', 'LIKE', "%{$search}%")
                        ->orWhere('details', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
                });
            })->when($category, function ($query) use ($category) {
                $query->whereHas('categories', function ($query) use ($category) {
                    $query->where('slug', $category);
                });
            })
            ->whereNull('parent_id')
            ->orderBy('pin', 'desc')
            ->orderBy('order_no', 'asc')
            ->paginate(48);

        return view('shop.products', compact('products', 'categories', 'shop', 'category_list'));
    }

    private function displayNestedCategories($categories)
    {
        $list = '<ul class="list-unstyled components ">';


        foreach ($categories as $category) {
            if (!$category->parent_id) {
                if ($category->childrens->count() > 0) {
                    $list .= $this->childrens($category);
                } else {

                    $list .= '<li><a class="" href="' . route('products', ['user_name' => request('user_name'), 'category' => $category->slug]) . '"><span class="cateogry-link" data-url="' . route('products', ['user_name' => request('user_name'), 'category' => $category->slug]) . '">' . $category->name . '</span></a></li>';
                }
            }
        }
        $list .= '</ul>';

        return $list;
    }
    private function childrens($categories)
    {
        $list = '<ul class="list-unstyled components ml-1">';
        $list .= '<li >';
        if ($categories->slug == request()->category) {
            $list .= '<a href="#pageSubmenu' . $categories->id . '" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle"><span class="cateogry-link active"  data-url="' . route('products', ['user_name' => request('user_name'), 'category' => $categories->slug]) . '">' . $categories->name . '</span></a>';
        } else {
            $list .= '<a href="#pageSubmenu' . $categories->id . '" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><span class="cateogry-link" data-url="' . route('products', ['user_name' => request('user_name'), 'category' => $categories->slug]) . '">' . $categories->name . '</span></a>';
        }
        $list .= ' <ul class="collapse   list-unstyled" id="pageSubmenu' . $categories->id . '">';

        foreach ($categories->childrens as $category) {
            if ($category->childrens->count() > 0) {
                if($category->id != $category->parent_id){
                    $list .= $this->childrens($category);
                }
            } else {
                if ($category->slug == request()->category) {
                    $list .= '<li class="active"  aria-expanded="true"> <a  href="' . route('products', ['user_name' => request('user_name'), 'category' => $category->slug]) . '"><span class="cateogry-link active" data-url="' . route('products', ['user_name' => request('user_name'), 'category' => $category->slug]) . '">' . $category->name . '</span></a></li>';
                } else {
                    $list .= '<li > <a  href="' . route('products', ['user_name' => request('user_name'), 'category' => $category->slug]) . '"><span class="cateogry-link" data-url="' . route('products', ['user_name' => request('user_name'), 'category' => $category->slug]) . '">' . $category->name . '</span></a></li>';
                }
            }
        }
        $list .= '</ul>';
        $list .= '</ul>';

        return $list;
    }

    public function scan()
    {
        return view('scanner');
    }
    public function services($user_name)
    {
        $services = Service::active()
            ->whereRaw('shop_id = (select id from shops where user_name = ?)', [$user_name])
            ->get();

        return view('booking.services', compact('services'));
    }

    public function serviceSingle($user_name, Service $service)
    {
        abort_if(!$service->isActive(), 404);

        return view('booking.service-single', [
            'service' => $service,
        ]);
    }

    public function timeSlot($user_name, Service $service, User $manager)
    {
        abort_if(!$service->isActive(), 404);

        if (request()->wantsJson()) {
            $period = (new Period($service, $manager, request('date')))
                ->getPeriods();

            return response()->json([
                'events' => $period
            ]);
        }

        return view('booking.time-slot', [
            'service' => $service,
            'manager' => $manager,
        ]);
    }

    public function booking($user_name, Booking $booking)
    {

        if ($booking->user_id != auth()->id()) {
            return abort(403, 'You are not allowed');
        }

        return view('booking.show', compact('booking'));
    }


    public function product($user_name, Product $product)
    {
        $shop = Shop::where('user_name', $user_name)->firstOrFail();

        $related_products = Product::inRandomOrder()->where('status', 1)->limit(4)->whereNull('parent_id')->get();
        $categories = Category::all();
        $product->increment('view');

        return view('shop.product', compact('product', 'categories', 'related_products', 'shop'));
    }


    public function changelog()
    {
        $changelogs = Changelog::select(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') date,description,version,type"))
            ->latest()
            ->get()
            ->groupBy(['date']);
        return view('change_log', compact('changelogs'));
    }

    public function  active_kiosk($username)
    {
        $shop = \App\Models\Shop::where('user_name', $username)->first();

        if (request()->pin == $shop->self_checkout_pin) {
            if (Cookie::get('kiosk-' . $username) == 'active') {
                Cookie::queue(Cookie::forget('kiosk-' . $username));
                return back()->with('success', 'Self Checkout deactivated');
            }
            Cookie::queue('kiosk-' . $username, 'active', 60 * 24 * 30);
            return redirect()->back()->with('successKiosk', 'Self Checkout activated');
        }
        return redirect()->back()->withErrors('Wrong pin');
    }
}
