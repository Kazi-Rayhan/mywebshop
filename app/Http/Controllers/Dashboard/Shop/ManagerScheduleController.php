<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CreditHistory;
use App\Models\Level;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ManagerScheduleController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            $managers = Auth::user()->shop->users()
                ->personalTrainer()
                ->select(['id', 'name as title'])
                ->get();


            $selectedDate = Carbon::parse(request('date'))->startOfDay();

            $bookings = Booking::select([
                'id',
                'user_id',
                'end_at as end',
                'start_at as start',
                'manager_id as resourceId',
            ])
                ->with('customer')
                ->whereIn('manager_id', $managers->pluck('id'))
                ->whereDate('start_at', $selectedDate)
                ->get();

            return response()->json([
                'managers' => $managers,
                'bookings' => $bookings->each(fn (Booking $booking) => $booking['title'] = $booking->customer->full_name),
            ]);
        }

        return view('dashboard.shop.managers.calander');
    }
    public function update(Request $request, Booking $booking)
    {

        try {

            if ($booking->service_type) {


                $trainer = User::find($request->manager_id);

                $level = Level::where('id', $trainer->level)->first();

                $commission = 0;

                switch ($booking->commission_type) {
                    case 'demo_credits':
                        $commission = $level->demo_session_commission;
                        break;
                    case 'manager_credits':
                        $commission = $level->manager_session_commission;
                        break;
                    case 'admin_credits':
                        $commission = $level->admin_session_commission;
                        break;
                    default:
                        $commission = $level->commission;
                        break;
                }

                $data = [
                    'end_at'        => $request->end_at,
                    'start_at'      => $request->start_at,
                    'manager_id'    => $request->manager_id,
                    'commission' => $commission,
                    'commission_level' => @$level->title,
                    'commission_rate' => @$commission,
                ];
            } else {
                $data = [
                    'end_at'        => $request->end_at,
                    'start_at'      => $request->start_at,
                    'manager_id'    => $request->manager_id,
                ];
            }
            $booking->update($data);

            return response('successfully updated');
        } catch (Exception $e) {
            return response($e->getMessage());
        } catch (Error $e) {

            return response($e->getMessage());
        }
    }
}
