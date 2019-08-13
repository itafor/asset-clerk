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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TenantRent $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.due_rent_tenant')
        ->subject('Rent Due in 30 Days');
    }
}
