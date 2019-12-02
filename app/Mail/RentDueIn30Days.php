<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RentDueIn30Days extends Mailable
{
    use Queueable, SerializesModels;
    
    public $companyDetail;
    public $userDetail;
    public $rentalsDueInNext30Days2;
    public $totalRentsNotPaid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userDetail,$rentalsDueInNext30Days2,$totalRentsNotPaid)
    {
        $this->userDetail = $userDetail;
        $this->rentalsDueInNext30Days2 = $rentalsDueInNext30Days2;
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
        return $this->view('emails.rentalsDue_InNext_30Days')
        ->subject('Due Rentals In Next 30 Days');
    }
}
