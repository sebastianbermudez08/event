<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Inscripción</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 40px;
            color: #000;
        }

        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }

        .info {
            margin-bottom: 30px;
        }

        .info p {
            font-size: 16px;
            line-height: 1.6;
        }

        .barcode {
            text-align: center;
            margin: 40px 0;
        }

        .acciones {
            text-align: center;
            margin-top: 30px;
        }

        .acciones a {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        /* Ocultar botones al imprimir */
        @media print {
            .acciones {
                display: none;
            }
        }
    </style>
</head>
<body>

    <h2>Comprobante de Inscripción</h2>

    <div class="info">
        <p><strong>Nombre:</strong> {{ $inscrito->nombre_completo }}</p>
        <p><strong>Documento:</strong> {{ $inscrito->numero_documento }}</p>

        @if($inscrito->tipo_usuario === 'visitante')
            <p><strong>Edad:</strong> {{ $inscrito->edad }}</p>
            <p><strong>Género:</strong> {{ $inscrito->genero }}</p>
        @endif

        <p><strong>Correo:</strong> {{ $inscrito->correo }}</p>
        <p><strong>Teléfono:</strong> {{ $inscrito->telefono }}</p>
    </div>

    <div class="barcode">
        <p><strong>ID Inscripción:</strong> {{ $inscrito->id }}</p>
        {!! DNS1D::getBarcodeHTML($inscrito->id, 'C128') !!}
    </div>

    <div class="acciones">
        <a href="{{ route('inicio') }}">Volver al inicio</a>
        <a href="{{ route('registro.validar') }}">Registrar otro</a>
    </div>

</body>
</html>
