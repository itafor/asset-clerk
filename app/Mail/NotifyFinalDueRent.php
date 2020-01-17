<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyFinalDueRent extends Mailable
{
    use Queueable, SerializesModels;

    public $rental;
    public $landlord;
    public $companyDetail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rental)
    {
        $this->rental = $rental;
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
        return $this->view('emails.notify_final_duerent')
        ->subject('Rent Completely Due Notification')
        ->from($this->companyDetail ? $this->companyDetail->email :'noreply@assetclerk.com', $this->companyDetail ? $this->companyDetail->name :'Asset Clerk')
        ->cc($this->landlord->email, $this->landlord->name());
    }
}
