<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprobante Comprador</title>
    <style>
        @page {
            size: 80mm 45mm;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 45mm;
            width: 80mm;
        }

        .barcode {
            margin-top: 5px;
            display: inline-block;
        }

        .info {
            font-size: 14px;
            line-height: 1.2;
        }
    </style>
</head>
<body>

    <div class="info">
        <br> 
        @if (strlen ($inscrito->nombre_completo)<28)
        <br>
        @endif
        <strong>{{ strtoupper($inscrito->nombre_completo) }}</strong><br>
        {{ strtoupper($inscrito->empresa) }}<br>
        {{ strtoupper($inscrito->ciudad) }}<br>
    </div>

    <div class="barcode">
        {!! DNS1D::getBarcodeHTML('COM' . $inscrito->id, 'C128', 1.5, 40) !!}
        <div>COM{{ $inscrito->id }}</div>
    </div>

</body>
</html>
