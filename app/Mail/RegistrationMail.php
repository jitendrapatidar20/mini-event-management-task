<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $url="";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$url)
    {
        //
        $this->user=$user;
        $this->url=$url;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Confirmation mail from TVETA")->view('emails.registration');
    }
}
