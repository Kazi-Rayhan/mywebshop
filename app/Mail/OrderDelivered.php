<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderDelivered extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $message;
    public $qrcode;
    public $captured;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $message = null, $captured = false, $qrcode = null)
    {
        $this->order = $order;
        $this->message = $message;
        $this->qrcode = $qrcode;
        $this->captured = $captured;
        $this->locale = app()->getLocale();
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    // public function envelope()
    // {
    //     return new Envelope(
    //         subject: 'Order Confirmed',
    //     );
    // }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function build()
    {
        $subject = __('words.product_delivered_email_subject');
        return $this->bcc(setting('site.email'))
            ->subject($subject . ' #' . $this->order->id)
            ->markdown('emails.orders.delivered');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
