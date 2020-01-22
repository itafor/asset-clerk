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
    public $defaultRemainingDuration;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rental,$defaultRemainingDuration)
    {
        $this->rental = $rental;
        $this->defaultRemainingDuration = $defaultRemainingDuration;
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
        ->subject('Due Rentals Notification')
        ->from($this->companyDetail ? $this->companyDetail->email :'noreply@assetclerk.com', $this->companyDetail ? $this->companyDetail->name :'Asset Clerk')
        ->cc($this->landlord->email, $this->landlord->name());
    }
}
