<?php

namespace App\Http\Controllers;

use App\Exports\ManagerExport;
use App\Exports\ProductExport;
use App\Http\Resources\ProductResource;
use App\Models\Group;
use App\Models\Shop as ModelsShop;
use App\Models\User;
use Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function manager(User $user)
    {
        if ($user->shop_id != Shop::id()) {
            return abort(403, 'You are not allowed');
        };
        return Excel::download(new ManagerExport($user), $user->name . "'s vcard.csv");
    }
    public function shop_product_export_by_admin(ModelsShop $shop)
    {
        $products = $shop->products;
        
        return Excel::download(new ProductExport(ProductResource::collection($products)), 'imported_product.xlsx');
    }
    
}
