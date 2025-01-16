<?php

namespace App\Mail;

use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManagerInvoice extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $shop;
    public $amount;
    public $tax;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Shop $shop,$amount,$tax)
    {
        $this->shop = $shop;
        $this->amount = $amount;
        $this->tax = $tax;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->bcc(setting('site.email'))
            ->subject('Invoice for shop '.$this->shop->name)
            ->markdown('emails.manager-invoice');
    }
}
