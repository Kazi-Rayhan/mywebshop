<?php

namespace App\Http\Controllers\Dashboard\Retailer;

use App\Http\Controllers\Controller;
use App\Mail\NotificationEmail;
use App\Mail\WithdrawlMail;
use App\Models\RetailerEarning;
use App\Models\RetailerMeta;
use App\Models\RetailerWithdrawal;
use App\Models\User;
use DateTime;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RetailerController extends Controller
{

    public function dashboard()
    {
        return view('dashboard.retailer.user.dashboard');
    }
    public function profile()
    {
        return view('dashboard.retailer.user.profile');
    }

    public function update_profile(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'unique:users,email,' . auth()->id()],
        ]);
        if ($request->password) {
            auth()->user()->update([
                'password' => Hash::make($request->password)
            ]);
        }
        auth()->user()->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);

        RetailerMeta::updateOrCreate(['user_id' => auth()->user()->id,], [
            'bank_account_number' => $request->bank_account_number
        ]);

        return back()->with('success', 'Profile updated successfully');
    }

    public function reports()
    {

        $sells = RetailerEarning::where('user_id', auth()->id())->when(request()->filled('filter'), function ($query) {
            $query->where('method', request()->filter);
        })->when(request()->filled(['from', 'to']), function ($query) {
            $query->whereBetween('created_at', [request()->from, request()->to]);
        })->get()->groupBy(function ($data) {
            return $data->created_at->format('Y-m-d');
        })->map(function ($row) {
            return $row->sum('amount');
        });

        return view('dashboard.retailer.user.reports', compact('sells'));
    }
    public function logEarning()
    {
        $query = User::find(auth()->id())->earnings();

        if (request()->filled('filter')) {
            $query = $query->where('method', request()->filter);
        }
        if (request()->filled(['from', 'to'])) {
            $query = $query->whereBetween('created_at', [request()->from, request()->to]);
        }

        $sells = $query->latest()->paginate(20);
        return view('dashboard.retailer.user.earning-logs', compact('sells'));
    }
    public function withdrawals()
    {

        $query =  User::find(auth()->id())->withdrawals();
        if (request()->filled('filter')) {
            $query = $query->where('status', request()->filter);
        }
        if (request()->filled(['from', 'to'])) {
            $query = $query->whereBetween('created_at', [request()->from, request()->to]);
        }

        $withdrawals = $query->paginate(50);

        return view('dashboard.retailer.user.withdrawals', compact('withdrawals'));
    }
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => "required|integer|lt:" . auth()->user()->totalBalance()
        ]);
        $user = Auth()->user();
        $date = new DateTime('now');

        try {
            $withdrawal = User::find(auth()->id())->withdraw($request->amount);
            Mail::to('billing@iziibuy.com')->send(new WithdrawlMail($user, $withdrawal, 'A new order has been placed'));
            return redirect()->back()->with('success', 'Witdrawal request placed');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function withdrawalDestroy(RetailerWithdrawal $withdrawal)
    {
        try {
            $withdrawal->delete();
            return redirect()->back()->with('success', 'Witdrawal deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function  affiliates(Request $request)
    {
        if (auth()->user()->retailer->parent_id != null && auth()->user()->retailer->type != 4) {
            abort(403, 'You don not have permission');
        }
        $retailers = auth()->user()->subRetailers;
        return view('dashboard.retailer.user.subretailers', compact('retailers'));
    }

    public function createAffiliates()
    {
        if (auth()->user()->retailer->parent_id != null && auth()->user()->retailer->type != 4) {
            abort(403, 'You don not have permission');
        }
        return view('dashboard.retailer.user.subretailer-create');
    }

    public function storeAffiliates(Request $request)
    {
        if (auth()->user()->retailer->parent_id != null && auth()->user()->retailer->type != 4) {
            abort(403, 'You don not have permission');
        }
        // form validation rules
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',

        ]);
        try {

            //create retiler user
            $user = User::create([
                'name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 5
            ]);


            $user->retailer()->create([
                'parent_id' => auth()->id(),
                'tax' => $request->tax,
                'tax_number' => $request->tax_number,
                'type' => auth()->user()->retailer->type,

            ]);
            $mail_data = [
                'subject' => 'A retailer account has been created',
                'body' => 'welcome to iziibuy. A new retailer account has been created.',
                'button_link' => route('login'),
                'button_text' => 'Login',
                'emails' => [],
            ];
            Mail::to($user->email)->send(new NotificationEmail($mail_data));
            // may send email contining account details to retailer user
            // code here .....


            //end

            return redirect()->route('retailer.affiliates')->with('success', 'Retailer Created');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }
}
