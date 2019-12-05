<?php

namespace App\Jobs;

use App\Mail\ServiceChargeInvoiceMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ServiceChargeInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

 public $tenant;
 public $serviceCharge;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tenant,$serviceCharge)
    {
        $this->tenant = $tenant;
        $this->serviceCharge = $serviceCharge;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         $toEmail = $this->tenant->email;
        Mail::to($toEmail)->send(new ServiceChargeInvoiceMail($this->tenant,$this->serviceCharge));
    }
}
