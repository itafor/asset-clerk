<?php

namespace App\Mail;

use App\TenantRent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RentalUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $rental;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rental)
    {
        $this->rental = $rental;
        $this->landlord = $rental->unit->getProperty()->landlord;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.rental_update')
         ->subject('Renewed Rental Approved')
        ->cc($this->landlord->email, $this->landlord->name());
    }
}