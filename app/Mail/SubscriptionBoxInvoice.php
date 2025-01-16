<?php

namespace App\Mail;

use App\Models\Membership;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscriptionBoxInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Membership $membership,$message)
    {
        $this->order = $membership;
        $this->message = $message;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->bcc($this->order->shop->email)
            ->subject('Faktura for subuscription #'.$this->order->order_id)
            ->markdown('emails.subscription.placed');

    }
}
