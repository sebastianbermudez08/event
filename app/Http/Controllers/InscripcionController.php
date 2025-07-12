<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitante;
use App\Models\Comprador;
use App\Models\Evento;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Milon\Barcode\Facades\DNS1D;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\BuyerEntered;
use App\Mail\RegistroExitosoMail;
use Illuminate\Support\Facades\Log;


class InscripcionController extends Controller
{
    public function seleccionarTipo(Request $request)
    {
        $documento = $request->input('documento') ?? '';
        return view('inscripcion.seleccionar_tipo', compact('documento'));
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
        $visitante = Visitante::where('numero_documento', $documento)->first();
        $comprador = Comprador::where('numero_documento', $documento)->first();

        if ($visitante || $comprador) {
            $inscrito = $visitante ?? $comprador;
            $vista = $visitante ? 'pdf.comprobante_visitante' : 'pdf.comprobante_comprador';

            $pdf = PDF::loadView($vista, ['inscrito' => $inscrito]);
            $pdfBase64 = base64_encode($pdf->output());

            return view('inscripcion.registro_exitoso', compact('inscrito', 'pdfBase64'));
        }

        return view('inscripcion.seleccionar_tipo', compact('documento'));
    }

    public function registrar(Request $request)
    {
        $evento = Evento::latest()->first();
        if (!$evento) {
            return redirect()->route('inicio')->with('error', 'No hay evento activo para registrar.');
        }

        $tipo = $request->input('tipo_usuario');

        $commonRules = [
            'nombre_completo'   => 'required|string|max:255',
            'numero_documento'  => 'required|string|max:50|unique:' . ($tipo === 'visitante' ? 'visitantes' : 'compradores') . ',numero_documento',
            'correo'            => 'required|email|unique:' . ($tipo === 'visitante' ? 'visitantes' : 'compradores') . ',correo',
            'telefono'          => 'required|string|max:20',
            'fecha_registro'    => 'required|date',
        ];

        if ($tipo === 'visitante') {
            $rules = array_merge($commonRules, [
                'edad'   => 'required|integer|min:1|max:120',
                'genero' => 'required|in:Masculino,Femenino,Otro',
                'ciudad' => 'required|string|max:100',
            ]);

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

            $inscrito = new Visitante();
            $inscrito->fill($request->only([
                'nombre_completo', 'numero_documento', 'correo', 'telefono', 'fecha_registro', 'edad', 'genero', 'ciudad'
            ]));
        }

        if ($tipo === 'comprador') {
            $rules = array_merge($commonRules, [
                'empresa'         => 'required|string|max:255',
                'direccion'       => 'required|string|max:255',
                'ciudad'          => 'required|string|max:255',
                'productos'       => 'nullable|array',
                'segmento_edad'   => 'nullable|array',
            ]);

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

            $inscrito = new Comprador();
            $inscrito->fill($request->only([
                'nombre_completo', 'numero_documento', 'correo', 'telefono', 'fecha_registro', 'empresa', 'direccion', 'ciudad'
            ]));
            $inscrito->productos = json_encode($request->productos);
            $inscrito->producto_otro = $request->producto_otro;
            $inscrito->segmento_edad = json_encode($request->segmento_edad);
            $inscrito->segmento_otro = $request->segmento_otro;
        }

        $inscrito->evento_id = $evento->id;
        $inscrito->comprobante_token = Str::random(40);
        $inscrito->save();

        $vista = $tipo === 'visitante' ? 'pdf.comprobante_visitante' : 'pdf.comprobante_comprador';

        // Enviar correo con comprobante en PDF
        try {
            Mail::to($inscrito->correo)->send(new RegistroExitosoMail($inscrito, $vista));
        } catch (\Exception $e) {
            Log::error('Error al enviar el correo de registro exitoso: ' . $e->getMessage());
        }

        $pdf = PDF::loadView($vista, ['inscrito' => $inscrito]);
        $pdfBase64 = base64_encode($pdf->output());

        return view('inscripcion.registro_exitoso', compact('inscrito', 'pdfBase64'));
    }

    public function verComprobanteEscaneado($tipo, $id)
    {
        if ($tipo === 'comprador') {
            $inscrito = Comprador::find($id);
            $vista = 'pdf.comprobante_comprador';
        } elseif ($tipo === 'visitante') {
            $inscrito = Visitante::find($id);
            $vista = 'pdf.comprobante_visitante';
        } else {
            return abort(404, 'Tipo no válido.');
        }

        if (!$inscrito) {
            return abort(404, 'Inscripción no encontrada.');
        }

        $pdf = PDF::loadView($vista, ['inscrito' => $inscrito]);
        return $pdf->stream('comprobante.pdf');
    }

    public function entrada(string $code)
    {
        $tipo = strtoupper(substr($code, 0, 3));
        $id = (int) substr($code, 3);

        if ($tipo === 'COM') {
            $persona = Comprador::find($id);
        } elseif ($tipo === 'VIS') {
            $persona = Visitante::find($id);
        } else {
            $persona = null;
        }

        if (!$persona) {
            return view('ingreso.resultado', [
                'status' => 'not_found',
                'message' => 'No se encontró registro con ese código.'
            ]);
        }

        $persona->ingresado_at = now();
        $persona->save();

        if ($tipo === 'COM') {
            Mail::to(config('mail.admin_address'))->send(new BuyerEntered($persona));
        }

        return view('ingreso.resultado', [
            'status' => 'ok',
            'persona' => $persona,
            'message' => '¡Entrada registrada correctamente!'
        ]);
    }

    public function procesarIngreso(Request $request)
    {
        $code = strtoupper($request->input('code'));

        if (!preg_match('/^(COM|VIS)\d+$/', $code)) {
            return redirect()->route('ingreso.index')->with([
                'status' => 'not_found',
                'message' => 'El código ingresado no tiene un formato válido.',
            ]);
        }

        $tipo = substr($code, 0, 3);
        $id = (int) substr($code, 3);

        if ($tipo === 'COM') {
            $persona = Comprador::find($id);
        } else {
            $persona = Visitante::find($id);
        }

        if (!$persona) {
            return redirect()->route('ingreso.index')->with([
                'status' => 'not_found',
                'message' => 'No se encontró registro con ese código.',
            ]);
        }

        $persona->ingresado_at = now();
        $persona->save();

        if ($tipo === 'COM') {
            Mail::to(config('mail.admin_address'))->send(new BuyerEntered($persona));
        }

        return redirect()->route('ingreso.index')->with([
            'status' => 'ok',
            'persona' => $persona,
            'message' => '¡Entrada registrada correctamente!',
        ]);
    }
}
