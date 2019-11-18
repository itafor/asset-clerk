<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ServiceChargePaymentHistory;

class serviceChargePaid extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $serviceChargePayment;
    public $landlord;

    public function __construct($serviceChargePayment)
    {
        $this->serviceChargePayment =  $serviceChargePayment;
        $this->landlord = $serviceChargePayment->getAsset->landlord;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.service_charge_paid')
        ->subject('Service Charge Payment Notification')
        ->cc($this->landlord->email, $this->landlord->name());
    }
}
