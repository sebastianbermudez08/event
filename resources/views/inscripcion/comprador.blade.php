<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Comprador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Número de Documento</label>
                            <input type="text" name="numero_documento" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Nombre del Representante Legal</label>
                            <input type="text" name="nombre_completo" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Empresa</label>
                            <input type="text" name="empresa" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Dirección</label>
                            <input type="text" name="direccion" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Ciudad</label>
                            <input type="text" name="ciudad" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Redes Sociales</label>
                            <input type="text" name="redes_sociales" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>¿Qué tipo de productos desea comprar?</label><br>
                        @php
                            $productos = [
                                'Confección infantil', 'Calzado infantil', 'Confección juvenil',
                                'Joyería / Bisutería', 'Accesorios', 'Insumos', 'Otro'
                            ];
                        @endphp
                        @foreach ($productos as $producto)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="productos[]" value="{{ $producto }}">
                                <label class="form-check-label">{{ $producto }}</label>
                            </div>
                        @endforeach
                        <input type="text" name="producto_otro" class="form-control mt-2" placeholder="Otro (especifique)">
                    </div>

                    <div class="mb-3">
                        <label>Segmento de edad</label><br>
                        @php
                            $segmentos = ['0 a 2 años', '5 a 12 años', 'Juvenil', 'Otro'];
                        @endphp
                        @foreach ($segmentos as $segmento)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="segmento_edad[]" value="{{ $segmento }}">
                                <label class="form-check-label">{{ $segmento }}</label>
                            </div>
                        @endforeach
                        <input type="text" name="segmento_otro" class="form-control mt-2" placeholder="Otro (especifique)">
                    </div>

                    <div class="mb-3">
                        <label>Fecha de Registro</label>
                        <input type="date" name="fecha_registro" class="form-control" value="{{ now()->toDateString() }}" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Registrar Comprador</button>
                    </div>
                </form>

            </div>s
        </div>
    </div>
</div>
</body>
</html>
