<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RentDueIn90Days extends Mailable
{
    use Queueable, SerializesModels;

    public $companyDetail;
    public $userDetail;
    public $rentalsDueInNext90Days2;
    public $totalRentsNotPaid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userDetail,$rentalsDueInNext90Days2,$totalRentsNotPaid)
    {
        $this->userDetail = $userDetail;
        $this->rentalsDueInNext90Days2 = $rentalsDueInNext90Days2;
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
        return $this->view('emails.rentalsDue_InNext_90Days')
         ->from($this->companyDetail ? $this->companyDetail->email :'noreply@assetclerk.com', $this->companyDetail ? $this->companyDetail->name :'Asset Clerk')
        ->subject('Due Rentals In Next 90 Days');
    }
}
