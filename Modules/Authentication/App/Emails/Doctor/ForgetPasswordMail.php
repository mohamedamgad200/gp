<?php

namespace Modules\Authentication\App\Emails\Doctor;

use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;
    public $opt;
    private function generateOtp()
    {
        return (new Otp)->generate($this->user->email, NUMERIC, LENGTH, VALIDITY)->token;
    }
    public function __construct($user)
    {
        $this->user = $user;
        $this->opt = $this->generateOtp();
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->view('authentication::auth.forget');
    }
}
