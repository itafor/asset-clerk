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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TenantRent $rental)
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
        return $this->view('emails.rental')
        ->subject('New Rental')
        ->cc($this->landlord->email, $this->landlord->name());
    }
}
