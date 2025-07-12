<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprador ha ingresado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            padding: 20px;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #007bff;
        }
        p {
            line-height: 1.6;
        }
        .footer {
            margin-top: 30px;
            font-size: 13px;
            color: #666;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🔔 Ingreso Registrado</h2>
    <p><strong>El comprador ha ingresado al evento.</strong></p>

    <p><strong>Nombre:</strong> {{ $comprador->nombre_completo }}</p>
    <p><strong>Documento:</strong> {{ $comprador->numero_documento }}</p>
    <p><strong>Correo:</strong> {{ $comprador->correo }}</p>
    <p><strong>Teléfono:</strong> {{ $comprador->telefono }}</p>
    <p><strong>Fecha y Hora de Ingreso:</strong> {{ \Carbon\Carbon::parse($comprador->ingresado_at)->format('d/m/Y H:i') }}</p>

    <div class="footer">
        <p>Este mensaje fue enviado automáticamente por el sistema de eventos.</p>
    </div>
</div>
</body>
</html>
