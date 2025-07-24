<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class UserOtpMail extends Mailable
{
    public $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Verify your account')->view('emails.user-otp')->with([
            'otp' => $this->otp
        ]);
    }
}
