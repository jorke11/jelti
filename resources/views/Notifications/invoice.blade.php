<html>
    <head>
        <title>Document</title>
    </head>
    <body>
        <p>¡Hola! Feliz día</p>
        <p>Se ha despachado la factura # <b>{{$invoice}}</b></p>
        <strong>Solicitud {!!$consecutive!!}</strong>
        <br>
        <br>

        <table border="1">
            <tr>
                <td>Producto</td>
                <td>Cantidad</td>
                <td>Embalaje</td>
                <td>Total(units)</td>
                <td>Valor Unitario</td>
                <td>Total</td>
            </tr>
            @foreach($detail as $val)
            <tr>
                <td>{{$val->product}}</td>
                <td>{{$val->quantity}}</td>
                <td>{{$val->units_sf}}</td>
                <td>{{$val->units_sf * $val->quantity}}</td>
                <td>{{$val->valueFormated}}</td>
                <td>{{$val->totalFormated}}</td>
            </tr>
            @endforeach
        </table>


        <br>
        <table>
            <tr>
                <td>Bodega Salida: {!!$warehouse!!}</td>
            </tr>
            <tr>

            </tr>
        </table>
        
        <br>

        <table>
            <tr>
                <td>Saludos</td>
            </tr>
        </table>
    </body>
</html>
