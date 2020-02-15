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
    public $companyDetail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(RentPayment $payment)
    {
        $this->payment = $payment;
        $this->landlord = $payment->asset->Landlord ? $payment->asset->Landlord : '';
        $this->companyDetail = comany_detail($payment->user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.payment')
        ->from($this->companyDetail ? $this->companyDetail->email :'noreply@assetclerk.com', $this->companyDetail ? $this->companyDetail->name :'Asset Clerk')
        ->subject('Rent Payment Notification')
        ->cc($this->landlord != '' ? $this->landlord->email:'noreply@assetclerk.com', $this->landlord != '' ?  $this->landlord->name() : 'Asset clerk');
    }
}
