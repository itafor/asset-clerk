<?php

namespace App\Jobs;

use App\Mail\RentDueIn90Days;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class DueRentInNext90DaysNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userDetail;
    public $rentalsDueInNext90Days2;
    public $totalRentsNotPaid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userDetail,$rentalsDueInNext90Days2,$totalRentsNotPaid)
    {
        $this->userDetail = $userDetail;
        $this->rentalsDueInNext90Days2 = $rentalsDueInNext90Days2;
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
        Mail::to($toEmail)->send(new RentDueIn90Days($this->userDetail,$this->rentalsDueInNext90Days2,$this->totalRentsNotPaid));
    }
}
