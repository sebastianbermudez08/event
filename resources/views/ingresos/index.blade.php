{{-- resources/views/ingreso/index.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2>Módulo de Ingreso</h2>

    <form method="GET" action="{{ route('entrada.scan', ['code' => '']) }}" onsubmit="event.preventDefault(); submitCode();">
        <div class="mb-3">
            <label for="codigo" class="form-label">Escanee el código o ingréselo manualmente:</label>
            <input type="text" id="codigo" class="form-control" autofocus required>
        </div>
        <button type="submit" class="btn btn-primary">Verificar Ingreso</button>
    </form>

    <div id="mensaje" class="mt-4"></div>
</div>

<script>
function submitCode() {
    let codigo = document.getElementById('codigo').value.trim();
    if (codigo !== '') {
        window.location.href = '/entrada/' + codigo;
    }
}
</script>
@endsection
