<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TemplateMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject="";
    public $description="";
    public $attachment=false;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$description,$attachment=null)
    {
        //
         $this->subject     = $subject;
         $this->description = $description;
         $this->attachment = $attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        if(!$this->attachment)
         return $this->subject($this->subject)->view('emails.mail');
        else
         return $this->subject($this->subject)->view('emails.mail')->attachData($this->attachment , "attachment.pdf");;
    }
}
