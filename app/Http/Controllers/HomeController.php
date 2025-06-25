<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio con el evento más reciente.
     */
    public function index()
    {
        // Busca el evento más reciente
        $evento = Evento::latest()->first();

        // Retorna la vista 'inicio' pasando los datos del evento
        return view('inicio', compact('evento'));
    }
}
