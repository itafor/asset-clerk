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
    public $service_charge;
    public $companyDetail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tenant,$service_charge)
    {
        $this->tenant = $tenant;
        $this->service_charge = $service_charge;
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
