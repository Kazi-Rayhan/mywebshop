<?php

namespace App\Mail;
use App\Models\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class ElavonPaymentDetails extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $shop;
    public $pdf;

    public function __construct($shop, $pdf)
    {
        $this->shop = $shop;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.elavonpaymentdetails')
                    ->subject('Elavon Payment Details')
                    ->attachData($this->pdf->output(), 'Details for Elavon Payment.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
