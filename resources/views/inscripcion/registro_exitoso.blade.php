@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h2 class="text-success">¡Registro completado exitosamente!</h2>
    <p>Gracias por inscribirte, {{ $inscrito->nombre_completo }}.</p>

    <p class="mt-4">
        Tu comprobante ha sido generado y se descargará automáticamente. Si no se descarga, puedes usar el siguiente botón:
    </p>

    <a id="descargar" class="btn btn-primary mb-3" download="comprobante_inscripcion.pdf">Descargar Comprobante</a>

    {{-- ✅ Botón para regresar a la página principal --}}
    <div>
        <a href="{{ route('inicio') }}" class="btn btn-secondary">Volver a la Página Principal</a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const enlace = document.getElementById("descargar");
        const pdfBase64 = "{{ $pdfBase64 }}";
        const blob = base64ToBlob(pdfBase64, "application/pdf");
        const url = URL.createObjectURL(blob);

        enlace.href = url;
        enlace.click(); // descarga automática
    });

    function base64ToBlob(base64, mime) {
        const byteChars = atob(base64);
        const byteArrays = [];
        for (let i = 0; i < byteChars.length; i += 512) {
            const slice = byteChars.slice(i, i + 512);
            const byteNumbers = new Array(slice.length);
            for (let j = 0; j < slice.length; j++) {
                byteNumbers[j] = slice.charCodeAt(j);
            }
            const byteArray = new Uint8Array(byteNumbers);
            byteArrays.push(byteArray);
        }
        return new Blob(byteArrays, { type: mime });
    }
</script>
@endsection
