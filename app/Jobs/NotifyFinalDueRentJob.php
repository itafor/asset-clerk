<?php

namespace App\Jobs;

use App\Mail\NotifyFinalDueRent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyFinalDueRentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $theRental; 
    public $defaultRemainingDuration;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($theRental,$defaultRemainingDuration)
    {
        $this->theRental = $theRental;
        $this->defaultRemainingDuration = $defaultRemainingDuration;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         $toEmail = $this->theRental->tenant->email;
        Mail::to($toEmail)->send(new NotifyFinalDueRent($this->theRental, $this->defaultRemainingDuration));

    }
}
