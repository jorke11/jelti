<html>
    <head>
        <title>Document</title>
    </head>
    <body>
        <p>¡Hola! Feliz día</p>
        <p>Les escribo para solicitar el siguiente pedido para nuestra bodega en {{$city}}</p>
        <strong>Solicitud Compra {!!$consecutive!!}</strong>
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
                <td>{!!$val->producto!!}</td>
                <td>{{$val->quantity}}</td>
                <td>{{$val->units_supplier}}</td>
                <td>{{$val->totalunit}}</td>
                <td align="center">$ {{number_format($val->cost_sf,2,",",".")}}</td>
                <td align="center">$ {{number_format($val->total,2,",",".")}}</td>
            </tr>
            @endforeach

        </table>
        <br>
        <table>
            <tr>
                <td>Bodega: {!!$warehouse!!}</td>
            </tr>
            <tr>
                <td>Direccion: {!!$address!!} Recibe {!!$name!!} {!!$last_name!!} - Celular:</td>
            </tr>
        </table>
        <br>
        <table>

            <tr>
                <td>Por favor confirmame la recepcion del pedido y fecha de despacho, cualquier detalle adicional no dudes en escribirme.</td>
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

