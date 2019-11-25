<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FundWallet extends Mailable
{
    use Queueable, SerializesModels;
    public $walletHistory;
    public $company_logo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($walletHistory)
    {
        $this->walletHistory = $walletHistory;
        $this->company_logo = comany_detail($walletHistory->user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.fund_wallet')
         ->subject($this->walletHistory->transaction_type === 'Deposit' ? 'Wallet funded' : 'Wallet Debited');
        //->cc($this->landlord->email, $this->landlord->name());
    }
}
