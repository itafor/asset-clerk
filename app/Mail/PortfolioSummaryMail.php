<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PortfolioSummaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subs;
    public $landlord;
    public $tenant;
    public $assets;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$subs,$landlord,$tenant,$assets)
    {
        $this->user = $user;
        $this->subs = $subs;
        $this->landlord = $landlord;
        $this->tenant = $tenant;
        $this->assets = $assets;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->view('emails.portfolio_summary')
        ->subject('Portfolio Summary');
    }
}
