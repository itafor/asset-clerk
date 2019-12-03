<?php

namespace App\Jobs;

use App\Mail\RentDueIn30Days;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class DueRentInNext30DaysNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userDetail;
    public $rentalsDueInNext30Days2;
    public $totalRentsNotPaid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userDetail,$rentalsDueInNext30Days2,$totalRentsNotPaid)
    {
        $this->userDetail = $userDetail;
        $this->rentalsDueInNext30Days2 = $rentalsDueInNext30Days2;
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
        Mail::to($toEmail)->send(new RentDueIn30Days($this->userDetail,$this->rentalsDueInNext30Days2,$this->totalRentsNotPaid));
    }
}
