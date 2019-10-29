<?php

namespace App\Jobs;

use App\Mail\RentalCreated;
use App\Mail\sendMailMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RentalCreatedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

public $theRental; 
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
        Mail::to($toEmail)->send(new RentalCreated($this->theRental));
    }
}
