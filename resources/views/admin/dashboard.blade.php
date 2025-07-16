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

    {{-- TOTAL INSCRITOS --}}
    <div class="alert alert-info">
        <strong>Total de personas inscritas:</strong>
        <span class="badge bg-success">{{ $totalInscritos }}</span>
        &nbsp; ({{ $totalCompradores }} compradores, {{ $totalVisitantes }} visitantes)
    </div>

    {{-- BOTONES --}}
    <div class="mb-4 d-flex flex-wrap gap-2">
        @auth
            @if(Auth::user()->rol === 'admin')
                @if(!$evento)
                    <a href="{{ route('admin.evento.editar', 0) }}" class="btn btn-success">+ Crear Nuevo Evento</a>
                @else
                    <a href="{{ route('admin.evento.editar', $evento->id) }}" class="btn btn-warning">✏️ Editar Evento Actual</a>
                @endif
            @endif

            @if(Auth::user()->rol === 'admin' || Auth::user()->rol === 'registros')
                @if($evento)
                    <a href="{{ route('registro.formulario', ['tipo' => 'comprador']) }}" class="btn btn-primary">🛒 Registrar Comprador</a>
                    <a href="{{ route('registro.formulario', ['tipo' => 'visitante']) }}" class="btn btn-info">🙋 Registrar Visitante</a>
                @endif
            @endif
        @endauth
    </div>

    {{-- FORMULARIO DE FILTRO --}}
    <form method="GET" class="row mb-4">
        <div class="col-md-3">
            <select name="tipo_usuario" id="tipo_usuario" class="form-select" onchange="this.form.submit()">
                <option value="">Seleccionar</option>
                <option value="comprador" {{ request('tipo_usuario') == 'comprador' ? 'selected' : '' }}>Comprador</option>
                <option value="visitante" {{ request('tipo_usuario') == 'visitante' ? 'selected' : '' }}>Visitante</option>
            </select>
        </div>

        @if(request('tipo_usuario'))
            <div class="col-md-3">
                <select name="filtro_por" class="form-select">
                    <option value="">Filtrar por</option>
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
        <h4>Compradores Registrados <span class="badge bg-primary">{{ $totalCompradores }}</span></h4>
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Empresa</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($compradores as $comprador)
                        <tr>
                            <td>{{ $comprador->nombre_completo }}</td>
                            <td>{{ $comprador->empresa }}</td>
                            <td>{{ $comprador->correo }}</td>
                            <td>{{ $comprador->telefono }}</td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('comprobante.ver', ['tipo' => 'comprador', 'id' => $comprador->id]) }}" class="btn btn-sm btn-secondary">📄</a>
                                <form action="{{ route('admin.inscritos.eliminar_individual', ['tipo' => 'comprador', 'id' => $comprador->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar este comprador?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No hay compradores registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    {{-- VISITANTES --}}
    @if(request('tipo_usuario') == 'visitante' || !request('tipo_usuario'))
        <h4 class="mt-5">Visitantes Registrados <span class="badge bg-primary">{{ $totalVisitantes }}</span></h4>
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Género</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visitantes as $visitante)
                        <tr>
                            <td>{{ $visitante->nombre_completo }}</td>
                            <td>{{ $visitante->edad }}</td>
                            <td>{{ $visitante->genero }}</td>
                            <td>{{ $visitante->correo }}</td>
                            <td>{{ $visitante->telefono }}</td>
                            <td class="d-flex gap-1">
                                <a href="{{ route('comprobante.ver', ['tipo' => 'visitante', 'id' => $visitante->id]) }}" class="btn btn-sm btn-secondary">📄</a>
                                <form action="{{ route('admin.inscritos.eliminar_individual', ['tipo' => 'visitante', 'id' => $visitante->id]) }}" method="POST" onsubmit="return confirm('¿Eliminar este visitante?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No hay visitantes registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
