<?php

namespace App\Jobs;

use App\Mail\PastRentDue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PastDueRentNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userDetail;
    public $past_due_rents2;
    public $totalRentsNotPaid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userDetail,$past_due_rents2,$totalRentsNotPaid)
    {
        $this->userDetail = $userDetail;
        $this->past_due_rents2 = $past_due_rents2;
        $this->totalRentsNotPaid = $totalRentsNotPaid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toEmail = $this->userDetail->email;
        Mail::to($toEmail)->send(new PastRentDue($this->userDetail,$this->past_due_rents2,$this->totalRentsNotPaid));
    }
}
