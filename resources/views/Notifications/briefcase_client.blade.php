<html>
    <head>
        <title>Resumen</title>
        <style type="text/css">
            h4,p{font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif; font-size: 12px}
            .detail {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .detail th {font-size: 13px;font-weight: normal;padding: 8px;background: #00b065;border-top: 4px solid #aabcfe;border-bottom: 1px solid #fff; color: #039;color:white;}
            .detail tbody td {padding: 8px;background: #f9f9f9;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}

            .detailnew {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .detailnew th {font-size: 13px;font-weight: normal;padding: 8px;background: #0080FF;border-top: 4px solid #aabcfe;border-bottom: 1px solid #fff; color: #039;color:white;}
            .detailnew tbody td {padding: 8px;background: #f9f9f9;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}

            .detailpend {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .detailpend th {font-size: 13px;font-weight: normal;padding: 8px;background: #F7BE81;border-top: 4px solid #aabcfe;border-bottom: 1px solid #fff; color: #039;color:white;}
            .detailpend tbody td {padding: 8px;background: #f9f9f9;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}

            .detailpay {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .detailpay th {font-size: 13px;font-weight: normal;padding: 8px;background: #00b065;border-top: 4px solid #aabcfe;border-bottom: 1px solid #fff; color: #039;color:white;}
            .detailpay tbody td {padding: 8px;background: #f9f9f9;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}

            .detailsales {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .detailsales th {font-size: 13px;font-weight: normal;padding: 8px;background: #000 ;border-top: 4px solid #aabcfe;border-bottom: 1px solid #fff; color: #039;color:white;}
            .detailsales tbody td {padding: 8px;background: #f9f9f9;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}

            .footer tbody td {padding: 8px;background: white;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
        </style>
    </head>

    <body>
        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <tr>
                <td width='15%'><img src="{!!asset('assets/images/logo.png')!!}" width="45" style="display:block"></td>
                <td width='60%'><p>¡Hola! Feliz día</p></td>
                <td><strong></strong><br></td>
            </tr>
            <tr>
                <td></td>
                <td><p>A continuación factura vencidas, por favor cancelar lo antes posible</p></td>
            </tr>

        </table>

        <br>
        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <tr>
                <td colspan="2"><h4>Pedidos Facturados</h4>
                </td>
            </tr>
        </table>
        <table class="detailnew" align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Fecha</th>
                    <th>Iva 5%</th>
                    <th>Iva 19%</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <body>
                <?php
                if (isset($detail)) {

                    $total = 0;
                    $subtotal = 0;
                    $tax5 = 0;
                    $tax19 = 0;
                    foreach ($detail as $value) {
                        ?>
                    <tr align="center">
                        <td>{{$value->invoice}}</td>
                        <td>{{$value->dispatched}}</td>
                        <td>{{number_format($value->tax5,0,".",",")}}</td>
                        <td>{{number_format($value->tax19,0,".",",")}}</td>
                        <td>{{number_format($value->subtotalnumeric,0,".",",")}}</td>
                        <td>{{number_format($value->total,0,".",",")}}</td>
                    </tr>
                    <?php
                    $tax5 += $value->tax5;
                    $tax19 += $value->tax19;
                    $subtotal += $value->subtotalnumeric;
                    $total += $value->total;
                }
                ?>
                <tr>
                    <td colspan="6"></td>
                </tr>
                @if($tax5!=0)
                <tr>
                    <td colspan="5" align="right" ><b>Iva 5%</b></td>
                    <td  align="center"><b>$ {{number_format($tax5,0,".",",")}}</b></td>
                </tr>
                @endif
                <tr>
                    <td colspan="5" align="right" ><b>Iva 19%</b></td>
                    <td  align="center"><b>$ {{number_format($tax19,0,".",",")}}</b></td>
                </tr>
                <tr>
                    <td colspan="5" align="right" ><b>Subtotal</b></td>
                    <td  align="center"><b>$ {{number_format($subtotal,0,".",",")}}</b></td>
                </tr>
                <tr>
                    <td colspan="5" align="right" ><b>Total</b></td>
                    <td  align="center"><b>$ {{number_format($total,0,".",",")}}</b></td>
                </tr>
                <?php
            }
            ?>
    </body>

   

</table>
        <br>
 <table align="center" width="850" align="center"  border="0" cellspacing="0"cellpadding="0">
        <tr>
            <td></td>
            <td><p>En caso de que el pago se haya realizado y siga le sigan llegados estas notificaciones, informar a <a href="mailto:info@superfuds.com.co">info@superfuds.com.co</a> para que su caso sea revisado</p></td>
        </tr>

    </table>F
</body>
</html>

