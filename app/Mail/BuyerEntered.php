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

    public function __construct(Comprador $comprador)
    {
        $this->comprador = $comprador;
    }

    public function build()
    {
        return $this->subject("Entrada Comprador: {$this->comprador->nombre_completo}")
                    ->view('emails.buyer_entered');
    }
}
