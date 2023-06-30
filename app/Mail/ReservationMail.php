<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationMail extends Mailable
{
    use Queueable, SerializesModels;
    private $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user= $user;
    }

public function build(){
        $this->from(config('mail.from.adress'),config('mail.from.name'))->
        subject('New reservation')->view('mail.new-reservation',['user'=>$this->user]);
}
}
