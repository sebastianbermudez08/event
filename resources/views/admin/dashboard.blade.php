@extends('layouts.admin')

@section('content')
<div class="container mt-5">

    <h2 class="mb-3">
        Panel de Administración - 
        @if($evento)
            {{ $evento->titulo }}
        @else
            Sin Evento Activo
        @endif
    </h2>

    {{-- BOTONES --}}
    <div class="mb-4 d-flex flex-wrap gap-2">
        @if(!$evento)
            <a href="{{ route('admin.evento.editar', 0) }}" class="btn btn-success">
                + Crear Nuevo Evento
            </a>
        @else
            <a href="{{ route('admin.evento.editar', $evento->id) }}" class="btn btn-warning">
                ✏️ Editar Evento Actual
            </a>

            <a href="{{ route('registro.formulario', ['tipo' => 'comprador']) }}" class="btn btn-primary">
                🛒 Registrar Comprador
            </a>

            <a href="{{ route('registro.formulario', ['tipo' => 'visitante']) }}" class="btn btn-info">
                🙋 Registrar Visitante
            </a>
        @endif
    </div>

    {{-- FORMULARIO DE FILTRO --}}
    <form method="GET" class="row mb-4">
        <div class="col-md-3">
            <select name="tipo_usuario" id="tipo_usuario" class="form-select" onchange="this.form.submit()">
                <option value="">-- Seleccionar Tipo --</option>
                <option value="comprador" {{ request('tipo_usuario') == 'comprador' ? 'selected' : '' }}>Comprador</option>
                <option value="visitante" {{ request('tipo_usuario') == 'visitante' ? 'selected' : '' }}>Visitante</option>
            </select>
        </div>

        @if(request('tipo_usuario'))
            <div class="col-md-3">
                <select name="filtro_por" class="form-select">
                    <option value="">-- Filtrar por --</option>
                    <option value="correo" {{ request('filtro_por') == 'correo' ? 'selected' : '' }}>Correo</option>
                    <option value="documento" {{ request('filtro_por') == 'documento' ? 'selected' : '' }}>Documento</option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="valor" class="form-control" placeholder="Buscar..." value="{{ request('valor') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Aplicar Filtro</button>
            </div>
        @endif
    </form>

    {{-- COMPRADORES --}}
    @if(request('tipo_usuario') == 'comprador' || !request('tipo_usuario'))
    <h4>Compradores Registrados</h4>
    <form method="POST" action="{{ route('admin.inscritos.eliminar_seleccionados') }}">
        @csrf
        @method('DELETE')
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" onclick="toggleCheckboxes(this, 'comprador')"></th>
                    <th>Nombre</th>
                    <th>Empresa</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- Aquí recorres $compradores --}}
                @forelse($compradores as $comprador)
                    <tr>
                        <td><input type="checkbox" name="seleccionados_comprador[]" value="{{ $comprador->id }}"></td>
                        <td>{{ $comprador->nombre_completo }}</td>
                        <td>{{ $comprador->empresa }}</td>
                        <td>{{ $comprador->correo }}</td>
                        <td>{{ $comprador->telefono }}</td>
                        <td>
                            <a href="{{ route('comprobante.ver', $comprador->id) }}" target="_blank" class="btn btn-sm btn-secondary">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No hay compradores registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
        <button type="submit" class="btn btn-danger">Eliminar Seleccionados</button>
    </form>
    @endif

    {{-- VISITANTES --}}
    @if(request('tipo_usuario') == 'visitante' || !request('tipo_usuario'))
    <h4 class="mt-5">Visitantes Registrados</h4>
    <form method="POST" action="{{ route('admin.inscritos.eliminar_seleccionados') }}">
        @csrf
        @method('DELETE')
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" onclick="toggleCheckboxes(this, 'visitante')"></th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Género</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                {{-- Aquí recorres $visitantes --}}
                @forelse($visitantes as $visitante)
                    <tr>
                        <td><input type="checkbox" name="seleccionados_visitante[]" value="{{ $visitante->id }}"></td>
                        <td>{{ $visitante->nombre_completo }}</td>
                        <td>{{ $visitante->edad }}</td>
                        <td>{{ $visitante->genero }}</td>
                        <td>{{ $visitante->correo }}</td>
                        <td>{{ $visitante->telefono }}</td>
                        <td>
                            <a href="{{ route('comprobante.ver', $visitante->id) }}" target="_blank" class="btn btn-sm btn-secondary">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">No hay visitantes registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
        <button type="submit" class="btn btn-danger">Eliminar Seleccionados</button>
    </form>
    @endif
</div>

<script>
    function toggleCheckboxes(source, tipo) {
        const checkboxes = document.querySelectorAll(`input[name="seleccionados_${tipo}[]"]`);
        checkboxes.forEach(cb => cb.checked = source.checked);
    }
</script>
@endsection
