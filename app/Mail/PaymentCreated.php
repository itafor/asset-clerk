<?php

namespace App\Mail;

use App\Payment;
use App\RentPayment;
use App\TenantRent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $landlord;
    public $companyDetail;
    public $user;
    public $rental;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(RentPayment $payment, TenantRent $rental)
    {
        $this->payment = $payment;
        $this->landlord = $payment->asset->Landlord ? $payment->asset->Landlord : '';
        $this->companyDetail = comany_detail($payment->user_id);
        $this->user = Userdetails($payment->user_id);
        $this->rental = $rental;
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
        ->cc($this->user ? $this->user->email:'noreply@assetclerk.com', $this->user  ?  $this->user->firstname : 'Asset clerk');
    }
}
