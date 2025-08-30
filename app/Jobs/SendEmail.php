<?php

namespace App\Jobs;

use App\Mail\EmailSender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $subject;
    public $replyToEmail;
    public $userEmail;
    public $body;

    /**
     * Create a new job instance.
     */
    public function __construct(string $userEmail, string $body, string $subject, $replyToEmail)
    {
        $this->userEmail = $userEmail;
        $this->body = $body;
        $this->subject = $subject;
        $this->replyToEmail = $replyToEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $subject = $this->subject;
        $replyToEmail = $this->replyToEmail;
        $body = $this->body;

        Log::info("Subject: " . $subject);
        Log::info("Body: " . $body);

        // Log::info("message");

        Mail::to($this->userEmail)->send(new EmailSender($body, $subject, $replyToEmail));
    }
}
