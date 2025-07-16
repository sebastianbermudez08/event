<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Evento;
use App\Models\Comprador;
use App\Models\Visitante;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function formLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->rol === 'admin' || $user->rol === 'registros') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->rol === 'ingresos') {
                return redirect()->route('ingreso.index'); // Ruta que crearemos para el módulo de ingreso
            }
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function dashboard(Request $request)
    {
        $evento = Evento::latest()->first();

        $compradores = Comprador::query();
        $visitantes = Visitante::query();

        if ($evento) {
            $compradores->where('evento_id', $evento->id);
            $visitantes->where('evento_id', $evento->id);
        }

        if ($request->filtro_por && $request->valor) {
            if ($request->filtro_por === 'correo') {
                $compradores->where('correo', 'like', '%' . $request->valor . '%');
                $visitantes->where('correo', 'like', '%' . $request->valor . '%');
            } elseif ($request->filtro_por === 'documento') {
                $compradores->where('numero_documento', 'like', '%' . $request->valor . '%');
                $visitantes->where('numero_documento', 'like', '%' . $request->valor . '%');
            }
        }

        $compradores = $compradores->orderBy('fecha_registro', 'desc')->get();
        $visitantes  = $visitantes->orderBy('fecha_registro', 'desc')->get();

        // Contadores
        $totalCompradores = $compradores->count();
        $totalVisitantes  = $visitantes->count();
        $totalInscritos   = $totalCompradores + $totalVisitantes;

        return view('admin.dashboard', compact(
            'evento',
            'compradores',
            'visitantes',
            'totalCompradores',
            'totalVisitantes',
            'totalInscritos'
        ));
    }


    public function formEditarEvento($id)
    {
        $evento = $id == 0 ? null : Evento::findOrFail($id);
        return view('admin.evento_editar', compact('evento'));
    }

    public function guardarEvento(Request $request)
    {
        $evento = $request->filled('id') ? Evento::findOrFail($request->id) : new Evento();

        $evento->titulo = $request->titulo;
        $evento->descripcion = $request->descripcion;
        $evento->lugar = $request->lugar;
        $evento->fecha = $request->fecha;
        $evento->hora = $request->hora;
        $evento->color_fondo = $request->color_fondo;

        if ($request->hasFile('imagen')) {
            $evento->imagen = $request->file('imagen')->store('eventos', 'public');
        }

        $evento->save();

        return redirect()->route('admin.dashboard')->with('success', 'Evento guardado correctamente');
    }

    public function eliminarIndividual($tipo, $id)
{
    if ($tipo === 'comprador') {
        $inscrito = \App\Models\Comprador::find($id);
    } elseif ($tipo === 'visitante') {
        $inscrito = \App\Models\Visitante::find($id);
    } else {
        return redirect()->back()->with('error', 'Tipo no válido.');
    }

    if (!$inscrito) {
        return redirect()->back()->with('error', 'Inscrito no encontrado.');
    }

    $inscrito->delete();
    return redirect()->back()->with('success', ucfirst($tipo) . ' eliminado correctamente.');
}



    public function generarPDF($id)
    {
        // Buscar en ambos modelos
        $inscrito = Comprador::find($id) ?? Visitante::find($id);

        if (!$inscrito) {
            abort(404, 'Registro no encontrado');
        }

        // Usar la vista correcta según el tipo
        $vista = $inscrito instanceof Comprador
            ? 'comprobante_comprador'
            : 'comprobante_visitante';

        $pdf = PDF::loadView($vista, ['inscrito' => $inscrito])
          ->setPaper([0, 0, 170.08, 85.04], 'portrait'); // 60mm x 30mm en puntos (mm × 2.8346)

        return $pdf->stream('Inscrito_' . $inscrito->id . '.pdf');
    }
}
