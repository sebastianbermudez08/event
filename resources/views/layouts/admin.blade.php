<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel de Administración')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin</a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-outline-light">Cerrar sesión</button>
        </form>
    </nav>

    <div class="container my-4">
        @yield('content')
    </div>
</body>
</html>
