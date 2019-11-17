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
     public $landlord;
     public $agent;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rental)
    {
        $this->rental = $rental;
        $this->landlord = $rental->unit->getProperty()->landlord;
        $this->agent = $rental->tenant_agent;
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
        ->cc($this->landlord->email, $this->landlord->name());
    }
}
