<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Comprador;

class BuyerEntered extends Mailable
{
    use Queueable, SerializesModels;

    public $comprador;

    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Comprador  $comprador
     */
    public function __construct(Comprador $comprador)
    {
        $this->comprador = $comprador;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('📥 Ingreso de Comprador Registrado')
                    ->view('emails.buyer_entered')
                    ->with(['comprador' => $this->comprador]);
    }

}
