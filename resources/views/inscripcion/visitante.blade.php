<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Visitante</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f8;
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card p-4">
                <h2 class="text-center mb-4">Formulario de Registro - Visitante</h2>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('inscripcion.registrar') }}" method="POST">
                    @csrf

                    <input type="hidden" name="tipo_usuario" value="visitante">

                    <div class="mb-3">
                        <label>Número de Documento</label>
                        <input type="text" name="numero_documento" class="form-control" value="{{ old('numero_documento', $documento) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombre_completo" class="form-control" value="{{ old('nombre_completo') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Edad</label>
                        <input type="number" name="edad" class="form-control" value="{{ old('edad') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Género</label>
                        <select name="genero" class="form-select" required>
                            <option value="">Seleccione</option>
                            <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" value="{{ old('correo') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Fecha de Registro</label>
                        <input type="date" name="fecha_registro" class="form-control" value="{{ old('fecha_registro', now()->toDateString()) }}" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">Registrarme</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
