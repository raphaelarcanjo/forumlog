<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $subject;
    public $body;
    public $name;

    public function __construct($data)
    {
        $this->subject = $data['subject'];
        $this->body    = $data['message'];
        $this->name    = $data['name'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to("raphael.cunha.br@gmail.com", "ForumLog")
                    ->subject($this->subject)
                    ->view('emails.contact_email');
    }
}
