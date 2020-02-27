<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\TenantRent;

class RentalCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $rental;
    public $companyDetail;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rental)
    {
        $this->rental = $rental;
        $this->landlord = $rental->asset->Landlord ? $rental->asset->Landlord : '';
         $this->companyDetail = comany_detail($rental->user_id);
         $this->user = Userdetails($rental->user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.rental')
        ->from($this->companyDetail ? $this->companyDetail->email :'noreply@assetclerk.com', $this->companyDetail ? $this->companyDetail->name :'Asset Clerk')
        ->subject('New Rental Notification')
         ->cc($this->user ? $this->user->email:'noreply@assetclerk.com', $this->user  ?  $this->user->firstname : 'Asset clerk');
    }
}
