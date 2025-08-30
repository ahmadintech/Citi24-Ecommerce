<?php

namespace App\Helpers;

use App\Mail\EmailSender;
use Illuminate\Support\Facades\Mail;

class EmailHelper
{
    public static function sendEmail($to, $body, $subject, $replyToEmail)
    {
        Mail::to($to)->send(new EmailSender($body, $subject, $replyToEmail));
    }
}
