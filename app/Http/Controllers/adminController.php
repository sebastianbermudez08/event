<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Evento;
use App\Models\Inscrito;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // Muestra formulario de login
    public function formLogin()
    {
        return view('admin.login');
    }

    // Procesa el login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas',
        ]);
    }

    // Cierra sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Muestra panel del administrador
    public function dashboard(Request $request)
    {
        // Obtener último evento y contar inscritos
        $evento = Evento::withCount('inscritos')->latest()->first();

        $query = Inscrito::query();

        if ($evento) {
            // Filtrar solo inscritos al evento actual
            $query->where('evento_id', $evento->id);
        }

        // Filtros por correo o documento
        if ($request->filtro_por && $request->valor) {
            if ($request->filtro_por === 'correo') {
                $query->where('correo', 'like', '%' . $request->valor . '%');
            } elseif ($request->filtro_por === 'documento') {
                $query->where('numero_documento', 'like', '%' . $request->valor . '%');
            }
        }

        $inscritos = $query->orderBy('fecha_registro', 'desc')->paginate(10);

        return view('admin.dashboard', compact('evento', 'inscritos'));
    }

    // Formulario para crear o editar evento
    public function formEditarEvento($id)
    {
        $evento = $id == 0 ? null : Evento::findOrFail($id);
        return view('admin.evento_editar', compact('evento'));
    }

    // Guardar evento (crear o actualizar)
    public function guardarEvento(Request $request)
    {
        if ($request->filled('id')) {
            $evento = Evento::findOrFail($request->id);
        } else {
            $evento = new Evento();
        }

        $evento->titulo = $request->titulo;
        $evento->descripcion = $request->descripcion;
        $evento->lugar = $request->lugar;
        $evento->fecha = $request->fecha;
        $evento->hora = $request->hora;

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('eventos', 'public');
            $evento->imagen = $path;
        }

        $evento->color_fondo = $request->color_fondo;
        $evento->save();

        return redirect()->route('admin.dashboard')->with('success', 'Evento guardado correctamente');
    }

    // Eliminar múltiples inscritos
    public function eliminarSeleccionados(Request $request)
    {
        $ids = $request->input('seleccionados', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'No se seleccionó ningún registro para eliminar.');
        }

        Inscrito::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', 'Registros eliminados correctamente.');
    }

    // Generar PDF individual
    public function generarPDF($id)
    {
        $inscrito = Inscrito::findOrFail($id);
        $pdf = Pdf::loadView('admin.pdf.inscrito', compact('inscrito'));
        return $pdf->stream('Inscrito_' . $inscrito->id . '.pdf');
    }
}
