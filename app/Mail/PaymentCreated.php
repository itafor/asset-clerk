<?php

namespace App\Mail;

use App\Payment;
use App\RentPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $landlord;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(RentPayment $payment)
    {
        $this->payment = $payment;
        $this->landlord = $payment->unit->getProperty()->landlord;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.payment')
        ->subject('Payment Invoice')
        ->cc($this->landlord->email, $this->landlord->name());
    }
}
