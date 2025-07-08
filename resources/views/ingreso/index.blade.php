@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2>Módulo de Ingreso</h2>

    @if(session('status') === 'ok')
        <div class="alert alert-success"> 
            {{ session('message') }}
            <br><strong>{{ session('persona')->nombre_completo }}</strong>
        </div>
    @elseif(session('status') === 'already')
        <div class="alert alert-warning">
            {{ session('message') }}
            <br><strong>{{ session('persona')->nombre_completo }}</strong>
        </div>
    @elseif(session('status') === 'not_found')
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('ingreso.process') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">Escanee o escriba el código:</label>
            <input type="text" name="code" id="code" class="form-control" autofocus required>
        </div>
        <button type="submit" class="btn btn-primary">Validar Entrada</button>
    </form>
</div>
@endsection
