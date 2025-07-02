<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body>
    <p>El comprador <strong>{{ $comprador->nombre_completo }}</strong> (ID: {{ $comprador->id }}) ha ingresado.</p>
    <ul>
        <li>Empresa: {{ $comprador->empresa }}</li>
        <li>Ciudad:  {{ $comprador->ciudad }}</li>
        <li>Hora de ingreso: {{ $comprador->ingresado_at }}</li>
    </ul>
</body>
</html>
