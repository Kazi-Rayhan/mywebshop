<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class paymentCapture extends Mailable
{
    use Queueable, SerializesModels;

    public $shop;
    public $viewLink;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($shop, $viewLink)
    {
        $this->shop = $shop;
        $this->viewLink = $viewLink;
    }
    public function build()
    {
        return $this->view('emails.paymentCapture');
    }
    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Details required for Elavon Payment Method',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */


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
