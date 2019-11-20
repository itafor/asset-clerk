<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MaintenanceComplaintMail extends Mailable
{
    use Queueable, SerializesModels;

    public $maintenanceComplaint;
    public $status;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($maintenanceComplaint,$status)
    {
        $this->maintenanceComplaint = $maintenanceComplaint;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.maintenance_complaint');
    }
}
