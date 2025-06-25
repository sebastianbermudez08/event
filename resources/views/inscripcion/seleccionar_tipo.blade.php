@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Seleccione el tipo de inscripción</h2>

    <p>Número de documento: <strong>{{ $documento }}</strong></p>

    <form method="GET" action="{{ route('registro.formulario') }}">
        <input type="hidden" name="documento" value="{{ $documento }}">

        <button type="submit" name="tipo" value="comprador" class="btn btn-primary">
            Soy Comprador
        </button>

        <button type="submit" name="tipo" value="visitante" class="btn btn-secondary">
            Soy Visitante
        </button>
    </form>
</div>
@endsection
