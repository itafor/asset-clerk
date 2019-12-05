<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\TenantRent;

class DueRentTenant extends Mailable
{
    use Queueable, SerializesModels;

    public $rental;
    public $renewed_rental;
    public $landlord;
    public $companyDetail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rental,$renewed_rental)
    {
        $this->rental = $rental;
        $this->renewed_rental = $renewed_rental; 
        $this->landlord = $rental->unit->getProperty()->landlord;
        $this->companyDetail = comany_detail($rental->user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.due_rent_tenant')
        ->subject('Due Rentals Notification')
        ->from($this->companyDetail ? $this->companyDetail->email :'noreply@assetclerk.com', $this->companyDetail ? $this->companyDetail->name :'Asset Clerk')
        ->cc($this->landlord->email, $this->landlord->name());
    }
}
