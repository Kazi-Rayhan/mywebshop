<?php

namespace App\Jobs;

use App\Mail\NotificationEmail;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ShopWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;
    protected $shop;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->shop = $user->shop;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $message = $this->user->name . ' ' . $this->user->last_name . ' has created new shop ' . $this->user->shop_name;
        $mail_data = [
            'subject' => 'New shop registered',
            'body' => $message,
            'button_link' => route('voyager.shops.edit', $this->user->shop->id),
            'button_text' => 'View Shop',
            'emails' => [],
        ];

        Mail::to(setting('site.email'))->send(new NotificationEmail($mail_data));
        //send email to shop
        $message = 'Welcome! <br>
         Thank you for signing up with us.<br>
         Your new account has been setup and you can now login to your area using the details below.<br>
         Url For Your Shop: ' . route('shop.home', ['user_name' => $this->user->shop->user_name]) . '<br> Email Address: ' . $this->user->email . ' <br>Password: HIDDEN';
        $mail_data = [
            'subject' => 'Thank you for creating new shop',
            'body' => $message,
            'button_link' => route('shop.home', ['user_name' => $this->user->shop->user_name]),
            'button_text' => 'View Shop',
            'emails' => [],
        ];
        Mail::to($this->user->email)->send(new NotificationEmail($mail_data));
        //send email to quickpay
       
       
    }
}
