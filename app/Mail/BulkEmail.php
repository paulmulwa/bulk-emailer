<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BulkEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;
    public $subject;
    public $message;

    public function __construct($emailData, $subject, $message)
    {
        $this->emailData = $emailData;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function build()
    {
        return $this->subject($this->subject)->view('emails.template')->with([
            'messageContent' => $this->message,
        ]);
    }
}
