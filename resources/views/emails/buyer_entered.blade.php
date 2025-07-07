<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ingreso de Comprador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }

        .container {
            background: #ffffff;
            border-radius: 6px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 0 auto;
        }

        h2 {
            color: #2c3e50;
        }

        ul {
            padding-left: 20px;
        }

        li {
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Notificación de ingreso</h2>
        <p>El comprador <strong>{{ $comprador->nombre_completo }}</strong> (ID: {{ $comprador->id }}) ha ingresado al evento.</p>

        <ul>
            <li><strong>Empresa:</strong> {{ $comprador->empresa }}</li>
            <li><strong>Ciudad:</strong> {{ $comprador->ciudad }}</li>
            <li><strong>Correo:</strong> {{ $comprador->correo }}</li>
            <li><strong>Teléfono:</strong> {{ $comprador->telefono }}</li>
            <li><strong>Fecha y hora de ingreso:</strong> {{ \Carbon\Carbon::parse($comprador->ingresado_at)->format('d/m/Y H:i') }}</li>
        </ul>

        <div class="footer">
            Este mensaje fue generado automáticamente por el sistema de registro de eventos.
        </div>
    </div>
</body>
</html>
