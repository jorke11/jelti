<html>
    <head>
        <title>Document</title>
        <style>
            .header{
                background: #00b065;
                color: white;
                border-color: #2a3f54;    
            }

        </style>
    </head>
    <body>
        <p>¡Hola! Feliz día</p>
        <p>Les escribo para solicitar el siguiente pedido para nuestra bodega en {{$city}}</p>
        <strong>Solicitud Compra {!!$consecutive!!}</strong>
        <br>
        <br>
        <table>
            <tr class="header">
                <td>EAN</td>
                <td>Producto</td>
                <td>Embalaje</td>
                <td>Valor Unitario</td>
                <td>Precio x Caja</td>
                <td>Iva</td>
                <td>Pedido Cajas</td>
                <td>Total</td>
            </tr>
            <?php
            $totalCant = 0;
            $totalUnit = 0;
            $totalVUnit = 0;
            $totalUnitsSup = 0;
            $total = 0;
            foreach ($detail as $val) {
                $totalCant += $val->quantity;
                $totalUnitsSup += $val->units_supplier;
                $totalUnit += $val->totalunit;
                $totalVUnit += $val->cost_sf;
                $total += $val->total;
                ?>
                <tr>
                    <td>{!!$val->bar_code!!}</td>
                    <td>{!!$val->producto!!}</td>
                    <td>{{$val->units_supplier}}</td>
                    <td align="center">$ {{number_format($val->cost_sf,2,",",".")}}</td>
                    <td align="center">$ {{number_format($val->priceperbox,2,",",".")}}</td>
                    <td>{{$val->tax}} %</td>
                    <td>{{$val->quantity}}</td>
                    <td align="center">$ {{number_format($val->total,2,",",".")}}</td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="6"><strong>Total</strong></td>
                <td>{!!$totalCant!!}</td>
                <td align="center"><br>$ {{number_format($total,2,",",".")}}</br></td>
            </tr>

        </table>
        <br>
        <table>
            <tr>
                <td>Bodega: {!!$warehouse!!}</td>
            </tr>
            <tr>
                <td>Direccion: {!!$address!!} Recibe {!!$name!!} {!!$last_name!!} - Celular:{!!$phone!!}</td>
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

