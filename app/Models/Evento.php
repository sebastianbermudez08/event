<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'lugar',
        'fecha',
        'hora',
        'color_fondo',
        'color_acento',
        'color_texto',
        'imagen'
    ];

    // Relación con visitantes
    public function visitantes()
    {
        return $this->hasMany(Visitante::class);
    }

    // Relación con compradores
    public function compradores()
    {
        return $this->hasMany(Comprador::class);
    }
}
