<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    protected $table = 'visitantes'; // 👈 nombre real de la tabla
    use HasFactory;

    protected $fillable = [
        'evento_id', 'nombre_completo', 'numero_documento', 'edad',
        'genero', 'correo', 'telefono', 'comprobante_token', 'fecha_registro'
    ];
}
