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
    public $companyDetail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($maintenanceComplaint,$status)
    {
        $this->maintenanceComplaint = $maintenanceComplaint;
        $this->status = $status;
        $this->companyDetail = comany_detail($maintenanceComplaint->user_id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.maintenance_complaint') 
        ->from($this->companyDetail ? $this->companyDetail->email :'noreply@assetclerk.com', $this->companyDetail ? $this->companyDetail->name :'Asset Clerk')
        ->subject('Complaint Notification');
    }
}
