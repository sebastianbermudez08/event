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

        html, body {
            margin: 0;
            padding: 0;
            width: 80mm;
            height: 45mm;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 14px;
        }

        .info {
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .barcode-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .barcode-wrapper .barcode {
            display: flex;
            justify-content: center;
            margin-top: 5px;
        }

        .barcode-wrapper .code {
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="info">
        <strong>{{ strtoupper($inscrito->nombre_completo) }}</strong><br>
        {{ strtoupper($inscrito->ciudad) }}
    </div>

    <div class="barcode-wrapper">
        <div class="barcode">
            {!! DNS1D::getBarcodeHTML('VIS' . $inscrito->id, 'C128', 1.5, 40) !!}
        </div>
        <div class="code">VIS{{ $inscrito->id }}</div>
    </div>
</body>
</html>
