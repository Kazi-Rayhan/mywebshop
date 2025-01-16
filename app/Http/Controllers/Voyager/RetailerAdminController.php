<?php

namespace App\Http\Controllers\Voyager;

use Shop;
use Exception;
use App\Models\User;
use App\Models\Order;
use App\Models\RetailerWithdrawal;

use App\Models\RetailerMeta;
use Illuminate\Http\Request;
use App\Models\RetailerType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationEmail;
use App\Mail\WithdrawlMail;
use App\Models\Shop as ModelsShop;
use Error;

class RetailerAdminController extends Controller
{
    /**
     * This method display create page of Retailer
     *
     * @return void
     */

    public function index()
    {
        $retailers = RetailerMeta::latest()->get();
        return view('auth.retailer.admin.index', compact('retailers'));
    }
    public function report($user)
    {
        $query = User::find($user)->earnings();

        if (request()->filled('filter')) {
            $query = $query->where('method', request()->filter);
        }
        if (request()->filled(['from', 'to'])) {
            $query = $query->whereBetween('created_at', [request()->from, request()->to]);
        }

        $sells = $query->latest()->get();
        

        return view('auth.retailer.admin.report', compact('sells'));
    }
    public function retailerWithdraw(RetailerWithdrawal $data)
    {
        try {
            $data->status = 1;
            $data->update();
            return back()->with([
                'message'    => 'Retailer Apporoved',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            return back()->with([
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }
    public function retailerCancel(RetailerWithdrawal $data)
    {
        try {
            $data->status = 2;
            $data->update();
            return back()->with([
                'message'    => 'Retailer Cancelled',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            return back()->with([
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }
    public function create()
    {
        $types = RetailerType::all();
        return view('auth.retailer.admin.create', compact('types'));
    }



    /**
     * This method store retailer data in database
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        // form validation rules
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
            'type' => 'required|exists:retailer_types,id',
            'retailer' => 'nullable|exists:users,id'
        ]);
        try {
            // //check if payment methods have value when it is not checked
            // if (!isset($request->one_time_pay_out['status']) && !empty($request->one_time_pay_out['value'])) throw new Exception('One time pay out is not checked');
            // if (!isset($request->commission_for_recuuring_payments['status']) && !empty($request->commission_for_recuuring_payments['value'])) throw new Exception('Commission from recurring payment is not checked');
            // if (!isset($request->commission_for_sales['status']) && !empty($request->commission_for_sales['value'])) throw new Exception('Commission from sales is not checked');

            // //check if payment methods do not have value when it is checked
            // if (isset($request->one_time_pay_out['status']) && empty($request->one_time_pay_out['value'])) throw new Exception('One time pay out has no value');
            // if (isset($request->commission_for_recuuring_payments['status']) && empty($request->commission_for_recuuring_payments['value'])) throw new Exception('Commission from recurring payment has no value');
            // if (isset($request->commission_for_sales['status']) && empty($request->commission_for_sales['value'])) throw new Exception('Commission from sales has no value');

            //create retiler user
            $user = User::create([
                'name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 5
            ]);

            //create reatiler metadata

            $user->retailer()->create([
                'parent_id' => $request->retailer,
                'tax' => $request->tax,
                'tax_number' => $request->tax_number,
                'type' => $request->type,
                // 'one_time_pay_out' => $request->one_time_pay_out['value'] ?? null,
                // 'commission_from_sales' => $request->commission_for_sales['value'] ?? null,
                // 'commission_from_recurring_payments' => $request->commission_for_recuuring_payments['value'] ?? null,
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

            return back()->with([
                'message'    => 'Retailer Created',
                'alert-type' => 'success',
            ]);
        } catch (Exception $e) {
            return back()->with([
                'message'    => $e->getMessage(),
                'alert-type' => 'error',
            ]);
        }
    }

    public function withdrawals(User $user = null)
    {

        $withdrawals = RetailerWithdrawal::latest();
        $form = '';
        $to = '';
        if ($user) {
            $form = $user->created_at->format('Y-m-d');
            $to = now()->format('Y-m-d');
        }
        if (request()->filled(['from', 'to'])) {
            $form = request()->from;
            $to = request()->to;
        }



        $withdrawals = RetailerWithdrawal::latest()
            ->when($user, function ($query) use ($user, $form, $to) {

                $query->where('user_id', $user->id);
            })
            ->when(request()->filled(['from', 'to']), function ($query) use ($form, $to) {

                $query->whereBetween('created_at', [$form, $to]);
            });

        $paid = clone $withdrawals;
        $pending = clone $withdrawals;
        $cancled = clone $withdrawals;

        $stats = [
            'paid' => [
                'count' => $paid->where('status', 1)->count(),
                'total' => $paid->where('status', 1)->sum('amount') / 100
            ],
            'pending' => [
                'count' => $pending->where('status', 0)->count(),
                'total' => $pending->where('status', 0)->sum('amount') / 100
            ],
            'canceled' => [
                'count' => $cancled->where('status', 2)->count(),
                'total' => $cancled->where('status', 2)->sum('amount') / 100
            ],
        ];


        $withdrawals =   $withdrawals->when(
            request()->filled('filter'),
            function ($query) {
                switch (request()->filter) {
                    case 0:
                        $query->where('status', 0);
                        break;
                    case 1:
                        $query->where('status', 1);
                        break;
                    case 2:
                        $query->where('status', 2);
                        break;

                    default:
                        $query->where('status', 0);
                        break;
                }
            }
        )->get();




        return view('auth.retailer.admin.withdrawals', compact('user', 'withdrawals', 'stats', 'form', 'to'));
    }

    public function withdrawalsBalance(Request $request, User $user)
    {
        $request->validate([
            'amount' => "required|integer|lt:" . $user->totalBalance(),
            'trnx_id' => "nullable|string|max:50",
            'date' => "required",
        ]);
        $date = now();

        try {
            $withdrawal = $user->withdraw($request->amount);
            $withdrawal->createMetas([
                'trnx_id' => $request->trnx_id,
                'date' => $request->date,
            ]);
            return redirect()->route('admin.retailer.retailer-withdrawals', $user)->with('success', 'Witdrawal request placed');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function transferClients(RetailerMeta $retailerMeta, Request $request)
    {
        $request->validate([
            'transfer_to' => 'required'
        ]);

        ModelsShop::where('retailer_id', $retailerMeta->user_id)->update([
            'retailer_id' => $request->transfer_to
        ]);
        $retailerMeta->isClientTransfered = true;
        $retailerMeta->clientTransferedTo = $request->transfer_to;
        $retailerMeta->save();
        return redirect()->back();
    }
}
