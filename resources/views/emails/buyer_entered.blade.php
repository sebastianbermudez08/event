<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ingreso de Comprador</title>
</head>
<body>
    <h2>📥 Nuevo Ingreso Registrado</h2>

    <p>El comprador <strong>{{ $persona->nombre_completo }}</strong> ha ingresado al evento.</p>

    <ul>
        <li><strong>Documento:</strong> {{ $persona->numero_documento }}</li>
        <li><strong>Empresa:</strong> {{ $persona->empresa ?? 'N/A' }}</li>
        <li><strong>Correo:</strong> {{ $persona->correo }}</li>
        <li><strong>Teléfono:</strong> {{ $persona->telefono }}</li>
        <li><strong>Ciudad:</strong> {{ $persona->ciudad }}</li>
        <li><strong>Hora de ingreso:</strong> {{ \Carbon\Carbon::parse($persona->ingresado_at)->format('Y-m-d H:i:s') }}</li>
    </ul>

    <p>Gracias,</p>
    <p>El sistema de eventos</p>
</body>
</html>
