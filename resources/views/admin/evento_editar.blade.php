@extends('layouts.app')

@section('content')
<div class="container">
    <h4>{{ $evento ? 'Editar Evento' : 'Crear Evento' }}</h4>

    <form method="POST" action="{{ route('admin.evento.guardar') }}" enctype="multipart/form-data">
        @csrf

        @if($evento)
            <input type="hidden" name="id" value="{{ $evento->id }}">
        @endif

        <div class="mb-3">
            <label>Título del Evento</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $evento->titulo ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $evento->descripcion ?? '') }}</textarea>
        </div>

        
        <div class="mb-3">
            <label>Lugar del Evento</label>
            <input type="text" name="lugar" class="form-control" value="{{ old('lugar', $evento->lugar ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Fecha del Evento</label>
            <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $evento->fecha ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Hora del Evento</label>
            <input type="time" name="hora" class="form-control" value="{{ old('hora', $evento->hora ?? '') }}">
        </div>
      

        <div class="mb-3">
            <label>Color de Fondo</label>
            <input type="color" name="color_fondo" class="form-control form-control-color"
                   value="{{ old('color_fondo', $evento->color_fondo ?? '#ffffff') }}">
        </div>

        <div class="mb-3">
            <label>Imagen del Evento</label>
            <input type="file" name="imagen" class="form-control">
            @if($evento && $evento->imagen)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $evento->imagen) }}" alt="Imagen actual" class="img-fluid" style="max-height: 200px;">
                </div>
            @endif
        </div>

        <button class="btn btn-primary">Guardar {{ $evento ? 'Cambios' : 'Evento' }}</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
