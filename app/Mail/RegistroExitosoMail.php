<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistroExitosoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inscrito;

    public function __construct($inscrito)
    {
        $this->inscrito = $inscrito;
    }

    public function build()
    {
        return $this->subject('Registro exitoso - Comprobante de inscripción')
                    ->view('emails.registro_exitoso');
    }
}
