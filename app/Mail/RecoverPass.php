<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecoverPass extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name;
    public $to_address;
    public $from_name;
    public $body;
    public $link;

    public function __construct($data)
    {
        $this->name         = $data['name'];
        $this->to_address   = $data['to_address'];
        $this->from_name    = $data['from_name'];
        $this->body         = $data['body'];
        $this->link         = $data['link'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->to_address, $this->name)
                    ->subject('Recuperação de Senha | ForumLog')
                    ->view('emails.recover_pass_email');
    }
}
