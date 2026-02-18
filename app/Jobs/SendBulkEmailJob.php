<?php

namespace App\Jobs;

use App\Mail\BulkEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendBulkEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $emailData;
    public $subject;
    public $message;

    public function __construct($emailData, $subject, $message)
    {
        $this->emailData = $emailData;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function handle()
    {
        Mail::to($this->emailData->email)->send(new BulkEmail($this->emailData, $this->subject, $this->message));
    }
}
