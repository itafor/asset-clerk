<?php

namespace App\Jobs;

use App\Mail\PortfolioSummaryMail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PortfolioSummaryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $subs;
    public $landlord;
    public $tenant;
    public $assets;
    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         $toEmail = $this->user->email;
        Mail::to($toEmail)->send(new PortfolioSummaryMail($this->user,$this->subs,$this->landlord,$this->tenant,$this->assets));
    }
}
