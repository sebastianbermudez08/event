<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante Visitante</title>
    <style>
        @page {
            size: 80mm 45mm;
            margin: 0;
        }

        body {
            width: 80mm;
            height: 45mm;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 14px;
            text-align: center;
        }

        .container {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .barcode-container {
            display: inline-block;
            margin-top: 8px;
        }

        .code {
            margin-top: 4px;
            font-size: 13px;
            letter-spacing: 1px;
        }

        strong {
            font-size: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <br> <br>
        <br> 
        <div><strong>{{ strtoupper($inscrito->nombre_completo) }}</strong></div>
        <div>{{ strtoupper($inscrito->ciudad) }}</div>

        <div class="barcode-container">
            {!! DNS1D::getBarcodeHTML('VIS' . $inscrito->id, 'C128', 2, 40) !!}
        </div>

        <div class="code">VIS{{ $inscrito->id }}</div>
    </div>
</body>
</html>
