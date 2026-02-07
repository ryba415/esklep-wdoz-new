<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $testMailData;
    public $view;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($testMailData,$view)
    {
        $this->testMailData = $testMailData;
        $this->view = $view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email From AllPHPTricks.com')
                    ->view('emails.'.$this->view);
    }
}
