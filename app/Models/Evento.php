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

    // Relación con los inscritos
    public function inscritos()
    {
        return $this->hasMany(Inscrito::class);
    }
}
