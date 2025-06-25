<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción Confirmada</title>
    <style>
        body {
            font-family: sans-serif;
            text-align: center;
            padding: 40px;
        }
        .card {
            border: 1px solid #ccc;
            display: inline-block;
            padding: 30px;
            border-radius: 10px;
            background-color: #f8f8f8;
        }
        h2 {
            color: green;
        }
        .info {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>✅ ¡Inscripción Confirmada!</h2>
        <div class="info">
            <p><strong>Nombre:</strong> {{ $inscrito->nombre_completo }}</p>
            <p><strong>Documento:</strong> {{ $inscrito->numero_documento }}</p>
            <p><strong>Tipo:</strong> {{ ucfirst($inscrito->tipo_usuario) }}</p>
        </div>
    </div>
</body>
</html>
