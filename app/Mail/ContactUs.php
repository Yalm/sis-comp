<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;
    public $message;
    public $to;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message,$from)
    {
        $this->message = $message;
        $this->from = $from;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("$this->from")
                    ->subject('Mensaje de Contáctanos')
                    ->to("$this->to", 'Admin')
                    ->markdown('emails.contact', ['message' => $this->message]);
    }
}
