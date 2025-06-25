<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscrito;
use App\Models\Evento;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Milon\Barcode\Facade\DNS1D;
use Barryvdh\DomPDF\Facade\Pdf;





class InscripcionController extends Controller
{
    public function seleccionarTipo()
    {
        return view('inscripcion.seleccionar_tipo');
    }

    public function mostrarFormulario(Request $request)
    {
        $documento = $request->input('documento') ?? null;
        $tipo = $request->input('tipo') ?? 'comprador';

        $evento = Evento::latest()->first();
        if (!$evento) {
            return redirect()->route('inicio')->with('error', 'Actualmente no hay eventos disponibles para inscribirse.');
        }

        if ($tipo === 'visitante') {
            return view('inscripcion.visitante', compact('evento', 'documento'));
        }

        return view('inscripcion.comprador', compact('evento', 'documento'));
    }

    public function mostrarValidar()
    {
        $evento = Evento::latest()->first();

        if (!$evento) {
            return redirect()->route('inicio')->with('error', 'Actualmente no hay eventos disponibles para inscribirse.');
        }

        return view('inscripcion.validar', compact('evento'));
    }

    public function validar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_documento' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $documento = $request->numero_documento;
        $inscrito = Inscrito::where('numero_documento', $documento)->first();

        if ($inscrito) {
            $pdfView = $inscrito->tipo_usuario === 'comprador' 
                ? 'inscripcion.comprobante_comprador' 
                : 'inscripcion.comprobante';

            $pdf = PDF::loadView($pdfView, compact('inscrito'));
            $pdfBase64 = base64_encode($pdf->output());

            return view('inscripcion.registro_exitoso', [
                'inscrito' => $inscrito,
                'pdfBase64' => $pdfBase64
            ]);
        }

        // Si no existe, preguntar tipo de usuario
        return view('inscripcion.seleccionar_tipo', compact('documento'));
    }

    public function registrar(Request $request)
    {
        $evento = Evento::latest()->first();
        if (!$evento) {
            return redirect()->route('inicio')->with('error', 'No hay evento activo para registrar.');
        }

        $tipo = $request->input('tipo_usuario') ?? 'comprador';

        // Reglas comunes
        $rules = [
            'nombre_completo'   => 'required|string|max:255',
            'numero_documento'  => 'required|string|max:50|unique:inscritos',
            'correo'            => 'required|email|unique:inscritos',
            'telefono'          => 'required|string|max:20',
            'fecha_registro'    => 'required|date',
        ];

        if ($tipo === 'visitante') {
            $rules = array_merge($rules, [
                'edad'   => 'required|integer|min:1|max:120',
                'genero' => 'required|in:Masculino,Femenino,Otro',
            ]);
        }

        if ($tipo === 'comprador') {
            $rules = array_merge($rules, [
                'empresa'         => 'required|string|max:255',
                'direccion'       => 'required|string|max:255',
                'ciudad'          => 'required|string|max:255',
                'redes_sociales'  => 'nullable|string|max:255',
                'productos'       => 'nullable|array',
                'segmento_edad'   => 'nullable|array',
            ]);
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $inscrito = new Inscrito();
        $inscrito->evento_id         = $evento->id;
        $inscrito->nombre_completo   = $request->nombre_completo;
        $inscrito->numero_documento  = $request->numero_documento;
        $inscrito->correo            = $request->correo;
        $inscrito->telefono          = $request->telefono;
        $inscrito->fecha_registro    = $request->fecha_registro;
        $inscrito->tipo_usuario      = $tipo;
        $inscrito->comprobante_token = Str::random(40);

        if ($tipo === 'visitante') {
            $inscrito->edad   = $request->edad;
            $inscrito->genero = $request->genero;
        }

        if ($tipo === 'comprador') {
            $inscrito->empresa         = $request->empresa;
            $inscrito->direccion       = $request->direccion;
            $inscrito->ciudad          = $request->ciudad;
            $inscrito->redes_sociales  = $request->redes_sociales;
            $inscrito->productos       = json_encode($request->productos);
            $inscrito->producto_otro   = $request->producto_otro;
            $inscrito->segmento_edad   = json_encode($request->segmento_edad);
            $inscrito->segmento_otro   = $request->segmento_otro;
        }

        $inscrito->save();

        $pdfView = $tipo === 'comprador' 
            ? 'inscripcion.comprobante_comprador' 
            : 'inscripcion.comprobante';

        $pdf = PDF::loadView($pdfView, compact('inscrito'));
        $pdfBase64 = base64_encode($pdf->output());

        return view('inscripcion.registro_exitoso', [
            'inscrito' => $inscrito,
            'pdfBase64' => $pdfBase64
        ]);
    }

    public function verComprobanteAdmin($id)
    {
        $inscrito = Inscrito::findOrFail($id);
        $pdf = PDF::loadView('pdf.inscrito', compact('inscrito'));
        return $pdf->stream('comprobante_admin.pdf');
    }

    public function verComprobanteEscaneado($id)
    {
        $inscrito = Inscrito::find($id);

        if (!$inscrito) {
            return abort(404, 'Inscripción no encontrada.');
        }

        return view('inscripcion.comprobante', compact('inscrito'));
    }
}
