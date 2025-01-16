<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $order;
    public $message;
    public $qrcode;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $message = null, $qrcode = null)
    {
        $this->order = $order;
        $this->message = $message;
        $this->qrcode = $qrcode;
        $this->locale = app()->getLocale();
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: __('words.order_placed_email') . '#' . $this->order->id,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */


    public function content()
    {
        return new Content(
            view: 'emails.orders.placed',
        );
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