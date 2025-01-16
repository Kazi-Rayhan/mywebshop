<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Mail\NotificationEmail;
use App\Models\Package;
use App\Models\User;
use App\Services\CreditWallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function index()
    {
        $admin = User::find(auth()->id());
        $shop = $admin->shop;

        if(request('inactive') == 'yes'){
            $users = User::whereHas('credits',function($query) use ($shop){
                $query->where('shop_id',$shop->id)->hasCredits();
            })->whereDoesntHave('appointment', function ($query) use($shop) {
                $query->where('created_at', '>=', Carbon::now()->subDays($shop->inactive_days));
            })->latest()->paginate(10);
        }else{
            $users = User::whereIn('pt_trainer_id',$admin->managers->pluck('id'))->latest()->paginate(10);
        }

        return view('dashboard.shop.client.index', compact('users', 'admin', 'shop'));
    }

    public function addSessions()
    {
        $user = User::find(request('user_id'));
        $vendor = User::find(auth()->id());
        $personalTrainer = $user->perosnalTrainer;
        $shop = $vendor->getShop();
        $client = $user;
        $duration = $shop->defaultoption?->minutes*request('session');
        (new CreditWallet($client, $personalTrainer))->deposit($duration, 'admin_credits');
        return redirect()->back()->with('success', 'session added successfully');
    }
}
