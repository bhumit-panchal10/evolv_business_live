<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BusinessCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $Data;
    public $businessId;

    public function __construct($Data, $businessId)
    {
        $this->Data = $Data;
        $this->businessId = $businessId;
    }

    public function build()
    {
        return $this->subject('Business Created')->view('emails.business.created');
    }
}


