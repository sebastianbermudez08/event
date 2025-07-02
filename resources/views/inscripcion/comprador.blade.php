<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Comprador</title>
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
                <h2 class="text-center mb-4">Registro de Comprador</h2>

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
                    <input type="hidden" name="tipo_usuario" value="comprador">

                    <div class="form-section">
                        <label>Número de Documento</label>
                        <input type="text" name="numero_documento" class="form-control" required>
                    </div>

                    <div class="form-section">
                        <label>Nombre del Representante Legal</label>
                        <input type="text" name="nombre_completo" class="form-control" required>
                    </div>

                    <div class="form-section">
                        <label>Empresa</label>
                        <input type="text" name="empresa" class="form-control" required>
                    </div>

                    <div class="form-section">
                        <label>Dirección</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>

                    <div class="form-section">
                        <label>Ciudad</label>
                        <input type="text" name="ciudad" class="form-control" required>
                    </div>

                    <div class="form-section">
                        <label>País</label>
                        <input type="text" name="pais" class="form-control" required>
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
                        <label>¿Qué tipo de productos desea comprar?</label>
                        @php
                            $productos = [
                                'Confección infantil', 'Calzado infantil', 'Confección juvenil',
                                'Joyería / Bisutería', 'Accesorios', 'Insumos', 'Otro'
                            ];
                        @endphp
                        @foreach ($productos as $producto)
                            <div class="form-check">
                                <input class="form-check-input producto-checkbox" type="checkbox" name="productos[]" value="{{ $producto }}" id="producto_{{ $loop->index }}">
                                <label class="form-check-label" for="producto_{{ $loop->index }}">{{ $producto }}</label>
                            </div>
                        @endforeach
                        <input type="text" name="producto_otro" id="producto_otro" class="form-control mt-2 d-none" placeholder="Otro (especifique)">
                    </div>

                    <div class="form-section">
                        <label>Segmento de edad</label>
                        @php
                            $segmentos = ['0 a 2 años', '5 a 12 años', 'Juvenil', 'Otro'];
                        @endphp
                        @foreach ($segmentos as $segmento)
                            <div class="form-check">
                                <input class="form-check-input segmento-checkbox" type="checkbox" name="segmento_edad[]" value="{{ $segmento }}" id="segmento_{{ $loop->index }}">
                                <label class="form-check-label" for="segmento_{{ $loop->index }}">{{ $segmento }}</label>
                            </div>
                        @endforeach
                        <input type="text" name="segmento_otro" id="segmento_otro" class="form-control mt-2 d-none" placeholder="Otro (especifique)">
                    </div>

                    <div class="form-section">
                        <label>Fecha de Registro</label>
                        <input type="date" name="fecha_registro" class="form-control" value="{{ now()->toDateString() }}" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Registrar Comprador</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Producto - mostrar campo si se selecciona "Otro"
        document.querySelectorAll(".producto-checkbox").forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                const otro = Array.from(document.querySelectorAll(".producto-checkbox"))
                    .some(cb => cb.checked && cb.value === "Otro");
                document.getElementById("producto_otro").classList.toggle("d-none", !otro);
            });
        });

        // Segmento - mostrar campo si se selecciona "Otro"
        document.querySelectorAll(".segmento-checkbox").forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                const otro = Array.from(document.querySelectorAll(".segmento-checkbox"))
                    .some(cb => cb.checked && cb.value === "Otro");
                document.getElementById("segmento_otro").classList.toggle("d-none", !otro);
            });
        });
    });
</script>
</body>
</html>
