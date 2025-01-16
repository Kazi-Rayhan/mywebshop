<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class CompletePendingBookings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Complete pending booking';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        define('PAID', 1);
        define('PENDING', 0);
        define('COMPLETED', 1);
        $currentTime = date('Y-m-d H:i:s');
        echo $currentTime;
        $bookings = Booking::where('payment_status', PAID)->where('status', PENDING)->where('start_at', '<', $currentTime)->get();
        foreach ($bookings as $booking) {
            $booking->status = COMPLETED;
            $booking->save();
        }
        echo 'done';
    }
}
