<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;//class pour organisation d'email
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationMail extends Mailable
{
    use Queueable//envoyer email au background
    , SerializesModels;//permet laravel de stocker model reserv d'une manier securiser;

    public $reservation;//variable global(utilisation dans view)
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }//object
    
    public function build()
{
    return $this->subject('Confirmation Réservation')//titre d'email
                ->view('emails.reservation');
}
    
     

    

    
}
