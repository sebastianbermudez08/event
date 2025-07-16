<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante Visitante</title>
    <style>
        @page {
            size: 60mm 30mm; 
            margin: 0;
        }
        body {
            width: 60mm;
            height: 30mm;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 11px; /* Más pequeño */
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .barcode-container {
            display: inline-block;
            margin-top: 2px;
        }
        .code {
            margin-top: 2px;
            font-size: 11px; /* Más pequeño */
            letter-spacing: 1px;
        }
        strong {
            font-size: 11px; /* Más pequeño */
        }
    </style>
</head>
<body>
    <div class="container">
        <div><strong>{{ strtoupper($inscrito->nombre_completo) }}</strong></div>
        <div>{{ strtoupper($inscrito->ciudad) }}</div>
        <div class="barcode-container">
            {!! DNS1D::getBarcodeHTML('VIS' . $inscrito->id, 'C128', 2, 30) !!}
        </div>
        <div class="code">VIS{{ $inscrito->id }}</div>
    </div>
</body>
</html>
