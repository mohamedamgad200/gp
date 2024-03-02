<?php

namespace App\Trait;

use Illuminate\Support\Facades\Mail;

trait CommonFunction {
    public function sendMail($user,$mailable) {
        Mail::to($user->email)->send($mailable);
    }
}