<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RentalRenewed extends Mailable
{
    use Queueable, SerializesModels;

     public $rental;
     public $currentRental;
     public $landlord;
     public $agent;
     public $companyDetail;
     public $theUser;
     public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rental,$theUser,$currentRental)
    {
        $this->rental = $rental;
        $this->currentRental = $currentRental;
        $this->theUser = $theUser;
        $this->landlord = $rental->unit->getProperty()->landlord;
        $this->agent = $rental->tenant_agent;
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
        return $this->view('emails.rental_renewed')
        ->subject('Rental Renewal Notification')
        ->cc($this->user ? $this->user->email:'noreply@assetclerk.com', $this->user  ?  $this->user->firstname : 'Asset clerk');
    }
}
