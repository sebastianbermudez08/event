<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Inscripción - Comprador</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
        }
        .info {
            margin-top: 20px;
        }
        .info p {
            margin: 5px 0;
        }
        .barcode {
            margin-top: 40px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Comprobante de Inscripción - Comprador</h2>

    <div class="info">
        <p><strong>Nombre:</strong> {{ $inscrito->nombre_completo }}</p>
        <p><strong>Documento:</strong> {{ $inscrito->numero_documento }}</p>
        <p><strong>Correo:</strong> {{ $inscrito->correo }}</p>
        <p><strong>Teléfono:</strong> {{ $inscrito->telefono }}</p>
        <p><strong>Empresa:</strong> {{ $inscrito->empresa }}</p>
        <p><strong>Dirección:</strong> {{ $inscrito->direccion }}</p>
        <p><strong>Ciudad:</strong> {{ $inscrito->ciudad }}</p>

        @if ($inscrito->productos)
            <p><strong>Productos de interés:</strong> 
                {{ implode(', ', json_decode($inscrito->productos, true)) }}
            </p>
        @endif

        @if ($inscrito->segmento_edad)
            <p><strong>Segmento de edad objetivo:</strong> 
                {{ implode(', ', json_decode($inscrito->segmento_edad, true)) }}
            </p>
        @endif

        @if (!empty($inscrito->producto_otro))
            <p><strong>Otro producto:</strong> {{ $inscrito->producto_otro }}</p>
        @endif

        @if (!empty($inscrito->segmento_otro))
            <p><strong>Otro segmento:</strong> {{ $inscrito->segmento_otro }}</p>
        @endif
    </div>

    <div class="barcode">
        <p><strong>ID Inscripción:</strong> {{ $inscrito->id }}</p>
        {!! DNS1D::getBarcodeHTML(strval($inscrito->id), 'C128') !!}
    </div>
</body>
</html>
