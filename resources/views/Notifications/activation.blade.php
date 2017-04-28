<html>
    <head>
        <title>Document</title>
    </head>
    <body>
        <strong>Solicitud Compra {!!$consecutive!!}</strong>
        <table>
            <tr>
                <td>Bodega:</td>
                <td>{!!$warehouse!!}</td>
            </tr>
            <tr>
                <td>Direccion:</td>
                <td>{!!$address!!}</td>
            </tr>
            <tr>
                <td>Contacto:</td>
                <td>{!!$responsible!!}</td>
            </tr>
        </table>
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
    </body>
</html>

