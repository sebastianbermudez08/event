<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante Comprador</title>
    <style>
        @page {
            size: 60mm 30mm; /* Cambia aquí el tamaño */
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            width: 60mm;
            height: 30mm;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .barcode {
            margin-top: 2px;
            display: inline-block;
        }
        .info {
            font-size: 10px; /* Más pequeño */
            line-height: 1.1;
            margin-bottom: 2px;
        }
        .barcode > div {
            font-size: 10px; /* Más pequeño el texto del código */
        }
    </style>
</head>
<body>
    <div class="info">
        <strong>{{ strtoupper($inscrito->nombre_completo) }}</strong><br>
        {{ strtoupper($inscrito->empresa) }}<br>
        {{ strtoupper($inscrito->ciudad) }}<br>
    </div>
    <div class="barcode">
        {!! DNS1D::getBarcodeHTML('COM' . $inscrito->id, 'C128', 2, 30) !!}
        <div>COM{{ $inscrito->id }}</div>
    </div>
</body>
</html>
