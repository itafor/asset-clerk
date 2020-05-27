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
    public $companyDetail;

    public function __construct($serviceChargePayment)
    {
        $this->serviceChargePayment =  $serviceChargePayment;
        $this->landlord = $serviceChargePayment->getAsset->landlord ? $serviceChargePayment->getAsset->landlord : '';

        $this->companyDetail = comany_detail($serviceChargePayment->user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.service_charge_paid')
        ->from($this->companyDetail ? $this->companyDetail->email :'noreply@assetclerk.com', $this->companyDetail ? $this->companyDetail->name :'Asset Clerk')
        ->subject('Service Charge Payment Notification')
        ->cc($this->landlord != '' ? $this->landlord->email:'noreply@assetclerk.com', $this->landlord != '' ?  $this->landlord->name() : 'Asset clerk');
    }
}
