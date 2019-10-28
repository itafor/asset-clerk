<?php

namespace App\Jobs;

use App\Mail\RentalCreated;
use App\TenantRent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessRentalCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  public  $rental;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(TenantRent $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
     $toEmail = $this->rental->tenant->email;
         Mail::to($toEmail)->send(new RentalCreated($this->rental));
    }
}
