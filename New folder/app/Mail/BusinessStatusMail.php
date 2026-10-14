<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BusinessStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $htmlContent;

    public function __construct($htmlContent)
    {
        $this->htmlContent = $htmlContent;
    }

    public function build()
    {
        return $this->subject('BUSINESS STATUS UPDATE')
            ->html($this->htmlContent);
    }
}
