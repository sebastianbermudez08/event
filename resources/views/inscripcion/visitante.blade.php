<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Visitante</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .form-section {
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4 shadow">
                <h2 class="text-center mb-4">Registro de Visitante</h2>

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

                    <div class="form-section">
                        <label>Número de Documento</label>
                        <input type="text" name="numero_documento" class="form-control" required>
                    </div>

                    <div class="form-section">
                        <label>Nombre Completo</label>
                        <input type="text" name="nombre_completo" class="form-control" required>
                    </div>

                    <div class="form-section">
                        <label>Edad</label>
                        <input type="number" name="edad" class="form-control" required min="1" max="120">
                    </div>

                    <div class="form-section">
                        <label>Género</label>
                        @php
                            $generos = ['Masculino', 'Femenino', 'Otro'];
                        @endphp
                        @foreach ($generos as $genero)
                            <div class="form-check">
                                <input class="form-check-input genero-radio" type="radio" name="genero" value="{{ $genero }}" id="genero_{{ $loop->index }}" required>
                                <label class="form-check-label" for="genero_{{ $loop->index }}">{{ $genero }}</label>
                            </div>
                        @endforeach
                        <input type="text" name="genero_otro" id="genero_otro" class="form-control mt-2 d-none" placeholder="Otro (especifique)">
                    </div>

                    <div class="form-section">
                        <label>Ciudad</label>
                        <input type="text" name="ciudad" class="form-control" required>
                    </div>

                    <div class="form-section">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>

                    <div class="form-section">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>

                    <div class="form-section">
                        <label>Fecha de Registro</label>
                        <input type="date" name="fecha_registro" class="form-control" value="{{ now()->toDateString() }}" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Registrar Visitante</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const radios = document.querySelectorAll(".genero-radio");
        const inputOtro = document.getElementById("genero_otro");

        radios.forEach(radio => {
            radio.addEventListener("change", function () {
                inputOtro.classList.toggle("d-none", this.value !== "Otro");
            });
        });
    });
</script>
</body>
</html>
