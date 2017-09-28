<html>
    <head>
        <title>Invoice</title>
        <style type="text/css">
            .header {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .detail {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .detail th {font-size: 13px;font-weight: normal;padding: 8px;background: #00b065;border-top: 4px solid #aabcfe;border-bottom: 1px solid #fff; color: #039;color:white;}
            .detail tbody td {padding: 8px;background: #f9f9f9;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
            .footer tbody td {padding: 8px;background: white;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;font-size: 9px}
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
                <td width='60%'><strong>SuperFüds</strong><br>Nit 900703907-7<br>BARRANQUILLA COLOMBIA<br>E-mail: info@superfuds.com.co</td>
                <td><strong>Factura {!!(isset($invoice))?$invoice:0!!}</strong><br> <strong>{{$dispatched}}</strong></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
        </table>
        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0" class="header">
            <tr>
                <td width='15%'><b>Resolución</b></td>
                <td width='60%'>DIAN 18762003299025 del 17/05/2017</td>
            </tr>
            <tr>
                <td width='15%'><b>Numeración Autorizada</b></td>
                <td width='60%'>3001 al 3999 por computador Actividad Economica 4631 Tarifa Ica 4.14 x 1000</td>
            </tr>
        </table>
        <br>
        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0" class="header">
            <tr>
                <td><b>Cliente</b></td>
                <td>{{(isset($client))?$client:''}}</td>
                <td><b>Emisión</b></td>
                <td>{{(isset($dispatched))?$dispatched:''}}</td>
            </tr>
            <tr>
                <td><b>Nit</b></td>
                <td>{{(isset($document))?$document:''}}</td>
                <td><b>Vencimiento</b></td>
                <td>{{(isset($expiration))?$expiration:''}}</td>
            </tr>
            <tr>
                <td><b>Ciudad</b></td>
                <td>{{(isset($city))?$city:''}}</td>
                <td><b>Vendedor</b></td>
                <td>{{(isset($responsible))?$responsible:''}}</td>
            </tr>
            <tr>
                <td><b>Dirección Entrega</b></td>
                <td>{{(isset($address_send))?$address_send:''}}</td>
            </tr>

            <tr>
                <td><b>Dirección Facturación</b></td>
                <td>{{(isset($address_invoice))?$address_invoice:''}}</td>
            </tr>
        </table>
        <br>
        <table class="detail" align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Embalaje</th>
                    <th>Total(units)</th>
                    <th>Valor Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
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
                <tr>
                    <td rowspan="4" colspan="3">Observaciones: {{(isset($observation))?$observation:''}}</td>
                    <td colspan="2"><b>SubTotal</b></td>
                    <td>{{(isset($subtotal))?$subtotal:0}}</td>
                </tr>
                @if($flete>0)
                <tr>
                    <td colspan="2"><b>Flete</b></td>
                    <td>{{"$ " . number_format($flete, 0, ",", ".")}}</td>
                </tr>
                @endif
                @if($tax5!=0)
                <tr>
                    <td colspan="2"><b>Iva 5%</b></td>
                    <td>{{"$ " . number_format($tax5, 0, ",", ".")}}</td>
                </tr>
                @endif
                @if($tax19!=0)
                <tr>
                    <td colspan="2"><b>Iva 19%</b></td>
                    <td>{{"$ " . number_format($tax19, 0, ",", ".")}}</td>
                </tr>
                @endif
                @if($discount>0)
                <tr>
                    <td colspan="2"><b>Descuento</b></td>
                    <td>{{"$ " . number_format($discount, 0, ",", ".")}}</td>
                </tr>
                @endif

                <tr>
                    <td colspan="2"><b>Total</b></td>
                    <td>{{(isset($total))?$total:0}}</td>
                </tr>
            </tbody>
        </table>


        <table class="footer" align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <tr>
                <td>{{(isset($textTotal))?$textTotal:''}}</td>

            </tr>
            <tr>
                <td>La presente Factura se asemeja en todos sus efectos a un Título Valor Art. 1 Ley 1231 de 2008. En caso de mora se causarán intereses a la tasa máxima legal estipulada por la ley, o en el
                    respectivo contrato (conforme al art. 884 del Código de Comercio).</td>
            </tr>
            <tr>
                <td>No somos grandes Contribuyentes, no somos Autorretenedores.
                    <br>Favor hacer transferencia a:
                    <br>Cuenta Bancaria:
                    <br>Bancolombia # 72951229710
                    <br>Corriente a nombre de SuperFuds S.A.S.
                </td>
            </tr>
        </table>
    </body>
</html>

