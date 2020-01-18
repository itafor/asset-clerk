<?php

namespace App\Jobs;

use App\Mail\DueRentTenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NotifyDueRentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $theRental; 
    //public $renewed_rental; 
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($theRental)
    {
        $this->theRental = $theRental;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toEmail = $this->theRental->tenant->email;
        Mail::to($toEmail)->send(new DueRentTenant($this->theRental));
    }
}
