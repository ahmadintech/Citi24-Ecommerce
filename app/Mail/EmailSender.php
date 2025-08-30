<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailSender extends Mailable
{
    use Queueable, SerializesModels;

    // protected $data;
    public $body;
    public $subject;
    public $replyToEmail;

    /**
     * Create a new message instance.
     */
    public function __construct(string $body, string $subject, $replyToEmail)
    {
        $this->body = $body;
        $this->subject = $subject;
        $this->replyToEmail = $replyToEmail;
    }


    public function build()
    {

        $subject =$this->subject;
        $replyToEmail =$this->replyToEmail;
        $body =$this->body;
        return $this
            ->subject($subject)
            ->replyTo($replyToEmail)
            ->view('email.master')
            ->with($body,$subject);
    }

    // /**
    //  * Get the message envelope.
    //  */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Email Sender',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
