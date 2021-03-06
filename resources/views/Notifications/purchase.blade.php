<html>
    <head>
        <title>Document</title>
        <style type="text/css">
            .detail {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .detail th {font-size: 13px;font-weight: normal;padding: 8px;background: #00b065;border-top: 4px solid #aabcfe;border-bottom: 1px solid #fff; color: #039;color:white;}
            .detail tbody td {padding: 8px;background: #f9f9f9;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
            .footer tbody td {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .header tbody td {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 13px;color: #669;border-collapse: collapse; padding: 8px;border-bottom: 1px solid #fff;;border-top: 1px solid transparent;}
            .header th {font-size: 13px;font-weight: normal;padding: 8px;background: #00b065;border-top: 6px solid #000;border-bottom: 1px solid #fff; color: #039;color:white;}
            .header {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
        </style>
    </head>
    <body>
        @if($environment=='local')
        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <tr align='center'>
                <td colspan="7" style="color:red"><h1>Testing Developer</h1></td>
            </tr>
        </table>
        @endif


        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0" class="header">
            <tr>
                <td width='75%'><img src="{!!asset('assets/images/logo.png')!!}" width="45" style="display:block"></td>

                <td><strong>Solicitud Compra {!!(isset($id))?$id:0!!}</strong><br> <strong></strong></td>
            </tr>
            <tr>
                <td>¡Hola! Feliz día</td>
            </tr>
            <tr>
                <td colspan="2">Les escribo para solicitar el siguiente pedido para nuestra bodega en {{$city}} 
                </td>
            </tr>
        </table>

<!--        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0" class="header">
    <tr>
        <td>¡Hola! Feliz día</td>
    </tr>
    <tr>
        <td>Les escribo para solicitar el siguiente pedido para nuestra bodega en {{$city}}</td>
    </tr>
    <tr>
        <td><strong>Solicitud Compra {!!$id!!}</strong></td>
    </tr>
</table>-->
        <br>
        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0" class="detail">
            <thead>
                <tr>
                    <th>EAN</th>
                    <th>Producto</th>
                    <th>Embalaje</th>
                    <th>Pedido</th>
                    <th>Unidades Total</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($detail as $val) {
                    ?>
                    <tr>
                        <td>{{$val->ean}}</td>
                        <td>{{$val->product}}</td>
                        <td align="center">{{$val->units_supplier}}</td>
                        <td align="center">{{$val->quantity}}</td>
                        <td align="center">{{$val->quantity_total}}</td>
                        <td align="center">{{$val->costFormated}}</td>
                        <td align="right">{{$val->totalFormated}}</td>
                    </tr>
                    <?php
                }
                ?>

                <tr align="right">
                    <td colspan="5"</td>
                    <td ><b>SubTotal</b></td>
                    <td>{{"$ " . number_format($subtotal, 0, ",", ".")}}</td>
                </tr>
                @if($tax5!=0)
                <tr align="right">
                    <td colspan="5"</td>
                    <td ><b>Iva 5%</b></td>
                    <td>{{"$ " . number_format($tax5, 0, ",", ".")}}</td>
                </tr>
                @endif
                @if($tax19!=0)
                <tr align="right">
                    <td colspan="5"</td>
                    <td ><b>Iva 19%</b></td>
                    <td >{{"$ " . number_format($tax19, 0, ",", ".")}}</td>
                </tr>
                @endif

                <tr align="right">
                    <td colspan="4"></td>
                    <td><b>Total</b></td>
                    <td>{{"$ " . number_format($total, 0, ",", ".")}}</td>
                </tr>

            </tbody>
        </table>
        <br>

        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0" class="header">
            <thead>
                <tr>
                    <th align="left">OBSERVACIONES: {!!$description!!}</th>
                </tr>

            </thead>
            <tbody>
                <tr>
                    <td>Bodega: {!!$warehouse!!}</td>
                </tr>
                <tr>
                    <td>Direccion: {!!$address!!} Recibe {!!$name!!} {!!$last_name!!} - Celular:{!!$phone!!}</td>
                </tr>
                <tr>
                    <td>Por favor confirmame la recepcion del pedido y fecha de despacho, cualquier detalle adicional no dudes en escribirme.</td>
                </tr>
                <tr>
                    <td>Saludos</td>
                </tr>
            </tbody>

        </table>

    </body>
</html>

