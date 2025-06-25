<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $evento->titulo ?? 'Título del evento' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --bg-main: #d8d3d3;
            --card-bg: #fbeee5;
            --accent-color: #b49a86;
            --text-color: #000;
            --button-bg: #e6dad1;
            --button-text: #000;
        }

        body {
            background-color: var(--bg-main);
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--bg-main);
        }

        header h1 {
            font-size: 2rem;
            color: var(--text-color);
        }

        .btn-admin {
            background-color: var(--button-bg);
            border: 1px solid var(--text-color);
            color: var(--button-text);
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 8px;
        }

        .main-card {
            margin: 30px auto;
            max-width: 1000px;
            background-color: var(--card-bg);
            border-radius: 30px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.15);
        }

        .event-image {
            max-width: 100%;
            border-radius: 20px;
        }

        .info {
            padding-left: 30px;
        }

        .info h2 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .info p {
            margin: 5px 0;
        }

        .btn-register {
            background-color: var(--button-bg);
            border: 1px solid var(--text-color);
            color: var(--text-color);
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <header class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.login') }}" class="btn-admin">Administrador</a>
        @if($evento)
        <h1 class="mx-auto text-center">{{ $evento->titulo ?? 'Título del evento' }}</h1>
        @endif
    </header>


    <main class="container">
        <div class="main-card row">
            <div class="col-md-6">
                <img src="{{ asset('storage/' . ($evento->imagen ?? 'default.png')) }}" alt="Evento" class="event-image">
            </div>
            <div class="col-md-6 info">
                 @if($evento)
                <h2>Descripción del evento</h2>
                <p><strong>Descripción:</strong> {{ $evento->descripcion ?? 'Sin descripción' }}</p>
                <p><strong>Lugar:</strong> {{ $evento->lugar ?? 'no hay lugar' }}</p>
                <p><strong>Fecha:</strong> {{ $evento->fecha ?? 'No hay fecha' }}</p>
                <p><strong>Hora:</strong> {{ $evento->hora ?? 'No hay hora' }}</p>
                    <a href="{{ route('registro.formValidar') }}" class="btn-register">REGISTRARSE</a>
                @else
                <h2>Evento no disponible</h2>
                <p>Lo sentimos, no hay información disponible sobre el evento en este momento.</p
                @endif
                
            </div>
        </div>
    </main>

    </body>
    </html>