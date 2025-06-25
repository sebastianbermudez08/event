<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .event-card {
            background-color: {{ $evento->color_fondo ?? '#ffffff' }};
            color: #333;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }
        .event-img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body class="p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Panel de Administración</h2>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-danger">Cerrar sesión</button>
        </form>
    </div>

    {{-- Evento actual --}}
    <div class="event-card">
        @if($evento)
            <h4>Evento Actual</h4>
            <p><strong>Título:</strong> {{ $evento->titulo }}</p>
            <p><strong>Descripción:</strong> {{ $evento->descripcion }}</p>
            <p><strong>Lugar:</strong> {{ $evento->lugar }}</p>
            <p><strong>Fecha:</strong> {{ $evento->fecha }}</p>
            <p><strong>Hora:</strong> {{ $evento->hora }}</p>

            @if($evento->imagen)
                <div>
                    <img src="{{ asset('storage/' . $evento->imagen) }}" alt="Imagen evento" class="event-img">
                </div>
            @endif

            <div class="mt-3">
                <a href="{{ route('admin.evento.editar', $evento->id) }}" class="btn btn-warning">Editar Evento</a>
            </div>
        @else
            <p>No hay evento registrado actualmente.</p>
            <a href="{{ route('admin.evento.editar', 0) }}" class="btn btn-success mt-2">Crear Evento</a>
        @endif
    </div>

    {{-- Lista de inscritos --}}
    <div>
        <h5>Inscritos al Evento</h5>

        @if($evento && count($inscritos) > 0)
            {{-- Filtro --}}
            <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-2 mb-3">
                <div class="col-md-3">
                    <select name="filtro_por" class="form-select">
                        <option value="">Filtrar por: </option>
                        <option value="correo" {{ request('filtro_por') == 'correo' ? 'selected' : '' }}>Correo</option>
                        <option value="documento" {{ request('filtro_por') == 'documento' ? 'selected' : '' }}>Documento</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <input type="text" name="valor" class="form-control" placeholder="Ingrese el valor a buscar" value="{{ request('valor') }}">
                </div>

                <div class="col-md-4 d-flex">
                    <button type="submit" class="btn btn-primary me-2">Buscar</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </form>

            {{-- Tabla --}}
            <form method="POST" action="{{ route('admin.inscritos.eliminar_seleccionados') }}">
                @csrf
                @method('DELETE')

                <div class="mb-3">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar los seleccionados?')">Eliminar</button>
                <a href="{{ route('registro.formValidar') }}" class="btn-register">REGISTRARSE</a>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Correo</th>
                            <th>Fecha</th>
                            <th>PDF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inscritos as $i)
                            <tr>
                                <td><input type="checkbox" name="seleccionados[]" value="{{ $i->id }}"></td>
                                <td>{{ $i->nombre_completo }}</td>
                                <td>{{ $i->numero_documento }}</td>
                                <td>{{ $i->correo }}</td>
                                <td>{{ \Carbon\Carbon::parse($i->fecha_registro)->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.inscrito.pdf', $i->id) }}" target="_blank" class="btn btn-sm btn-outline-primary">Ver PDF</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $inscritos->appends(request()->query())->links() }}
            </form>
        @else
            <p>No hay inscritos para el evento actual.</p>
        @endif
    </div>

    <script>
        document.getElementById('checkAll')?.addEventListener('change', function () {
            document.querySelectorAll('input[name="seleccionados[]"]').forEach(cb => cb.checked = this.checked);
        });
    </script>
</body>
</html>
