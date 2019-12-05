<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ServiceChargeInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tenant;
    public $serviceCharge;
    public $companyDetail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tenant,$serviceCharge)
    {
        $this->tenant = $tenant;
        $this->serviceCharge = $serviceCharge;
        $this->companyDetail = comany_detail($tenant->user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.service_charge_invoice')
        ->from($this->companyDetail ? $this->companyDetail->email :'noreply@assetclerk.com', $this->companyDetail ? $this->companyDetail->name :'Asset Clerk')
        ->subject('Service Charge Payment Invoice');
    }
}
