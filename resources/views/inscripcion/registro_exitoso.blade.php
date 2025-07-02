@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h2 class="mb-4">Registro Exitoso</h2>

    <p class="lead">Gracias por registrarte, <strong>{{ $inscrito->nombre_completo }}</strong>.</p>

    <p>A continuación puedes ver tu comprobante de inscripción. También puedes descargarlo en formato PDF.</p>

    <div class="my-4">
        <iframe 
            src="data:application/pdf;base64,{{ $pdfBase64 }}" 
            width="100%" 
            height="500px" 
            style="border: 1px solid #ccc; border-radius: 8px;"
        ></iframe>
    </div>

    <form method="POST" action="{{ route('descargar.comprobante') }}">
        @csrf
        <input type="hidden" name="pdf" value="{{ $pdfBase64 }}">
        <button type="submit" class="btn btn-success mb-3">
            📥 Descargar Comprobante en PDF
        </button>
    </form>

    <div class="mt-3">
        <form action="{{ route('admin.dashboard') }}" method="GET" style="display:inline;">
            <button type="submit" class="btn btn-primary">📝 Registrar otra persona</button>
        </form>

        <a href="{{ route('inicio') }}" class="btn btn-secondary">
            🏠 Volver al Inicio
        </a>
    </div>
</div>
@endsection
