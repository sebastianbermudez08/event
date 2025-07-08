@extends('layouts.admin')

@section('content')
<div class="container mt-5 text-center">
    @if($status === 'ok')
        <h3 class="text-success">{{ $message }}</h3>
        <p><strong>{{ $persona->nombre_completo }}</strong></p>
        <p>{{ $persona->numero_documento }}</p>
    @else
        <h3 class="text-danger">{{ $message }}</h3>
    @endif

    <a href="{{ route('ingreso.index') }}" class="btn btn-primary mt-4">Escanear Otro</a>
</div>
@endsection
