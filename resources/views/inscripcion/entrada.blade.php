<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Validación de Entrada</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center" style="height:100vh">
  <div class="card text-center p-4 shadow" style="width:360px;">
    @if($status === 'not_found')
      <div class="alert alert-danger">{{ $message }}</div>
    @elseif($status === 'already')
      <div class="alert alert-warning">{{ $message }}</div>
      <h5>{{ $persona->nombre_completo }}</h5>
    @else {{-- ok --}}
      <div class="alert alert-success">{{ $message }}</div>
      <h4>{{ $persona->nombre_completo }}</h4>
      @if($persona instanceof App\Models\Comprador)
        <p><strong>Empresa:</strong> {{ $persona->empresa }}</p>
      @else
        <p><strong>Ciudad:</strong> {{ $persona->ciudad }}</p>
      @endif
    @endif

    <a href="{{ route('inicio') }}" class="btn btn-primary mt-3">Volver al inicio</a>
  </div>
</body>
</html>
