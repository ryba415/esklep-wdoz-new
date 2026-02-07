<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Mail;

class Email
{
     //use HasApiTokens, HasFactory, Notifiable;

     protected $subject;
     protected $template;
     protected $variables;
     protected $recipients;
     protected $emailVariables;

     private $emailObject;

     function __construct($recipients,$subject,$template,$emailVariables = []) {
         $this->recipients = $recipients;
         $this->subject = $subject;
         $this->template = $template;
         $this->emailVariables = $emailVariables;
     }

    public function send(){
        $data = array('name'=>"Virat Gandhi");


        Mail::send($this->template, $this->emailVariables,
            function($message) {
                $message->to($this->recipients)
                     ->subject($this->subject);
                $message->from('sender@wdoz.pl','sender@wdoz.pl'); 
        });
    }
}

