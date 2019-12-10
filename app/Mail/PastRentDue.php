<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PastRentDue extends Mailable
{
    use Queueable, SerializesModels;

    public $companyDetail;
    public $userDetail;
    public $past_due_rents2;
    public $totalRentsNotPaid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userDetail,$past_due_rents2,$totalRentsNotPaid)
    {
        $this->userDetail = $userDetail;
        $this->past_due_rents2 = $past_due_rents2;
        $this->companyDetail = comany_detail($userDetail->id);
        $this->totalRentsNotPaid = $totalRentsNotPaid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.past_due_rents') 
        ->subject('Past Due Rents Notification')
        ->cc('omijeh@digitalwebglobal.com');
    }
}
