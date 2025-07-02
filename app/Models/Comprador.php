<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprador extends Model
{
    protected $table = 'compradores'; // 👈 nombre real de la tabla
    use HasFactory;

    protected $fillable = [
        'evento_id', 'nombre_completo', 'numero_documento', 'correo',
        'telefono', 'empresa', 'direccion', 'ciudad', 'redes_sociales',
        'productos', 'producto_otro', 'segmento_edad', 'segmento_otro',
        'comprobante_token', 'fecha_registro'
    ];

    protected $casts = [
        'productos' => 'array',
        'segmento_edad' => 'array'
    ];
}
