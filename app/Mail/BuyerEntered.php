<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BuyerEntered extends Mailable
{
    use Queueable, SerializesModels;

    public $persona;

    /**
     * Create a new message instance.
     */
    public function __construct($persona)
    {
        $this->persona = $persona;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.buyer_entered') // Asegúrate que esta vista existe
                    ->subject('🚪 Comprador ha ingresado al evento')
                    ->with([
                        'persona' => $this->persona
                    ]);
    }
}
