<html>
    <head>
        <title>Document</title>
        <style type="text/css">
            .detail {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .detail th {font-size: 13px;font-weight: normal;padding: 8px;background: #00b065;border-top: 4px solid #aabcfe;border-bottom: 1px solid #fff; color: #039;color:white;}
            .detail tbody td {padding: 8px;background: #f9f9f9;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
            .footer tbody td {padding: 8px;background: white;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
            .header tbody td {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse; padding: 8px;background: white;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
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
                <td width='15%'><img src="{!!asset('assets/images/logo.png')!!}" width="45" style="display:block"></td>
                <td width='60%'>¡Hola! Feliz día</td>
                <td><strong>Solicitud {!!(isset($id))?$id:0!!}</strong><br> <strong></strong></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td colspan="2">Les escribo para solicitar el siguiente pedido para nuestra bodega en {{$city}} 
                </td>
            </tr>
            <tr>
                <td><strong>Solicitud Compra {!!$id!!}</strong></td>
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
                    <th>Producto</th>
                    <th>Embalaje</th>
                    <th>Unidades Pedido</th>
                    <th>Precio Unitario</th>
                    <th>Unidades Total</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($detail as $val) {
                    ?>
                    <tr>
                        <td>{!!$val->product!!}</td>
                        <td align="center">{{$val->units_supplier}}</td>
                        <td align="center">{{$val->quantity}}</td>
                        <td align="center">{{$val->totalunits}}</td>
                        <td align="center">$ {{number_format($val->costFormated,2,",",".")}}</td>
                        <td align="right">$ {{number_format($val->total,2,",",".")}}</td>
                    </tr>
                    <?php
                }
                ?>

                <tr align="right">
                    <td colspan="4"</td>
                    <td ><b>SubTotal</b></td>
                    <td >{{(isset($subtotal))?$subtotal:0}}</td>
                </tr>
                @if($tax5!=0)
                <tr align="right">
                    <td colspan="4"</td>
                    <td ><b>Iva 5%</b></td>
                    <td>{{"$ " . number_format($tax5, 0, ",", ".")}}</td>
                </tr>
                @endif
                @if($tax19!=0)
                <tr align="right">
                    <td colspan="4"</td>
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
        </table>

    </body>
</html>

