<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Credit;
use App\Models\CreditHistory;
use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use App\Repository\PersonalTrainerBookingsReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Iziibuy;

class PersonalTrainerReportController extends Controller
{

    public function index(Request $request)
    {

        $shop = auth()->user()->getShop();




        $managers = $shop->users()
            ->when($request->filled('manager'), fn ($query) => $query->where('id', $request->manager))
            ->personalTrainer()
            ->get();

        $report = PersonalTrainerBookingsReport::for($shop);
        $report['inactive_client_list'] = $this->getInactiveClientsList($shop, $managers);
        $report['bookings_do_not_show_up_list'] = $this->getBookings($shop, $managers);

        $f = [];
        foreach ($request->report as $col) {
            $f[$col] = $report[$col];
        }
        $data = ['data' => $f];

        $pdf = Pdf::loadView('dashboard.shop.report.pdf.pt_report', $data);

        return $pdf->download('pt_report.pdf');
    }

    public function getBookings($shop, $manager)
    {
        return Booking::where('shop_id', $shop->id)->whereIn('manager_id', $manager->pluck('id'))->where('status', 1)->where('show_up', 0)->get()->map(function ($booking) {
            return [
                'customer' => $booking->customer->full_name,
                'service' => $booking->service->name,
                'appointment' => $booking->start_at->format('H:i A') . ' - ' . $booking->end_at->format('H:i A') . ' ' . $booking->end_at->format('d M,Y')

            ];
        })->toArray();
    }
    public function getInactiveClientsList($shop, $manager)
    {

        if ($manager instanceof \Illuminate\Support\Collection) {
            $ids = $manager->pluck('id')->toArray();
        } else {
            $ids = [$manager->id];
        }
        return User::whereHas('credits', function ($query) use ($ids, $shop) {
            $query->whereIn('trainer_id', $ids)->where('updated_at', '>=', now()->subDays($shop->inactive_days));
        })->get()->map(function ($user) {
            return [
                'name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
            ];
        })->toArray();
    }
}
