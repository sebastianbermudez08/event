<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Inscripción</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 30px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
        }
        .content {
            border: 1px solid #ccc;
            padding: 25px;
            border-radius: 10px;
        }
        .campo {
            margin-bottom: 15px;
        }
        .campo span {
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #777;
        }
        .imagen {
            margin-top: 20px;
            text-align: center;
        }
        .imagen img {
            max-height: 150px;
            max-width: 100%;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Comprobante de Inscripción</h1>
        <p>Gracias por registrarte en nuestro evento</p>
    </div>

    <div class="content">
        <div class="campo"><span>Nombre Completo:</span> {{ $inscrito->nombre_completo }}</div>
        <div class="campo"><span>Número de Documento:</span> {{ $inscrito->numero_documento }}</div>
        <div class="campo"><span>Edad:</span> {{ $inscrito->edad }}</div>
        <div class="campo"><span>Género:</span> {{ $inscrito->genero }}</div>
        <div class="campo"><span>Correo:</span> {{ $inscrito->correo }}</div>
        <div class="campo"><span>Teléfono:</span> {{ $inscrito->telefono }}</div>
        <div class="campo"><span>Profesión:</span> {{ $inscrito->profesion }}</div>
        <div class="campo"><span>Empresa:</span> {{ $inscrito->empresa }}</div>
        <div class="campo"><span>Fecha de Registro:</span> {{ \Carbon\Carbon::parse($inscrito->fecha_registro)->format('d/m/Y') }}</div>

        @if ($inscrito->imagen)
            <div class="imagen">
                <img src="{{ public_path($inscrito->imagen) }}" alt="Imagen del inscrito">
            </div>
        @endif
    </div>

    <div class="footer">
        Este comprobante es generado automáticamente y no requiere firma.
    </div>
</body>
</html>