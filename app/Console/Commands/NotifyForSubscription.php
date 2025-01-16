<?php

namespace App\Console\Commands;

use App\Mail\NotificationEmail;
use App\Models\Enterprise;
use App\Models\Shop;
use Error;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use QuickPay\QuickPay;
use Iziibuy;

class NotifyForSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $prevMonth = now()->startOfMonth();
        $shops = Shop::whereBetween(
            'paid_at',
            [$prevMonth->toDateTimeString(), $prevMonth->copy()->endOfMonth()->toDateTimeString()]
        )->where('status', 1)
            ->get();

        $enterprises = Enterprise::where('status', 1)->whereBetween(
            'paid_at',
            [$prevMonth->toDateTimeString(), $prevMonth->copy()->endOfMonth()->toDateTimeString()]
        )->get();
        foreach ($enterprises as $enterprise) {
            try {
                $data = "<p>Dear %s,</p>
                <p>We hope this message finds you well. This is a friendly reminder that your subscription fee <strong>%s</strong> for Enterprise will be charged on the <strong>%s</strong>.</p>
                <p>To ensure uninterrupted access to our services, please ensure that your card balance is sufficient to cover the subscription charge. If you need to update your payment information, you can do so by logging into your account and navigating to the billing section.</p>
                <p>We appreciate your continued support and look forward to serving you.</p>
                <br>
                 <p>Best regards,</p>
                <p>%s <br> %s <br> %s</p>
            ";

                $mail_data = [
                    'subject' => 'Upcoming Subscription Charge Notice',
                    'body' => sprintf($data, $shop->user->full_name, Iziibuy::price($shop->subscriptionFeeFull()), now()->addMonth(1)->startOfMonth()->format('d M,Y'), $shop->user->full_name, $shop->company_name, $shop->contact_email),
                    'button_link' => route('shop.charges.index'),
                    'button_text' => 'Go to billing section',
                    'emails' => [],
                ];
                Mail::to($shop->user->email)->send(new NotificationEmail($mail_data));
            } catch (Exception $e) {
                continue;
            } catch (Error $e) {
                continue;
            }
        }
        foreach ($shops as $shop) {
            try {
                $data = "<p>Dear %s,</p>
            <p>We hope this message finds you well. This is a friendly reminder that your subscription fee <strong>%s</strong> for Shop will be charged on the <strong>%s</strong>.</p>
            <p>To ensure uninterrupted access to our services, please ensure that your card balance is sufficient to cover the subscription charge. If you need to update your payment information, you can do so by logging into your account and navigating to the billing section.</p>
            <p>We appreciate your continued support and look forward to serving you.</p>
            <br>
             <p>Best regards,</p>
            <p>%s <br> %s <br> %s</p>
        ";

                $mail_data = [
                    'subject' => 'Upcoming Subscription Charge Notice',
                    'body' => sprintf($data, $shop->user->full_name, Iziibuy::price($shop->subscriptionFeeFull()), now()->addMonth(1)->startOfMonth()->format('d M,Y'), $shop->user->full_name, $shop->company_name, $shop->contact_email),
                    'button_link' => route('shop.charges.index'),
                    'button_text' => 'Go to billing section',
                    'emails' => [],
                ];
                Mail::to($shop->user->email)->send(new NotificationEmail($mail_data));
            } catch (Exception $e) {
                continue;
            } catch (Error $e) {
                continue;
            }
        }
    }
}
