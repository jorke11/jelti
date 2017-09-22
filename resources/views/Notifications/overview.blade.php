<html>
    <head>
        <title>Resumen</title>
        <style type="text/css">
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
            .detailsales th {font-size: 13px;font-weight: normal;padding: 8px;background: #2EFEF7;border-top: 4px solid #aabcfe;border-bottom: 1px solid #fff; color: #039;color:black;}
            .detailsales tbody td {padding: 8px;background: #f9f9f9;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}

            .footer tbody td {padding: 8px;background: white;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
        </style>
    </head>

    <body>
        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <tr>
                <td width='15%'><img src="{!!asset('assets/images/logo.png')!!}" width="45" style="display:block"></td>
                <td width='60%'>¡Hola! Feliz día</td>
                <td><strong></strong><br></td>
            </tr>
            <tr>
                <td></td>
                <td>Reporte de {{$date_report}}</td>
            </tr>

        </table>

        <br>
        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <tr>
                <td colspan="2"><h4>Pedidos Facturados</h4>
                </td>
            </tr>
        </table>
        <table class="detailpend" align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Comercial</th>
                    <th>Cliente</th>
                    <th>Iva 5%</th>
                    <th>Iva 19%</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                </tr>
            </thead>
            <body>
                <?php
                if (isset($arrpend)) {

                    $total = 0;
                    $subtotal = 0;
                    foreach ($arrpend as $val) {
                        $totalnew = 0;
                        $subtotalnew = 0;
                        foreach ($val as $value) {
                            $totalnew += $value->totalnew;
                            $subtotalnew += $value->subtotalnew
                            ?>
                        <tr align="center">
                            <td>{{$value->invoice}}</td>
                            <td>{{$value->responsible}}</td>
                            <td>{{$value->client}}</td>
                            <td>{{number_format($value->tax5,0,".",",")}}</td>
                            <td>{{number_format($value->tax19,0,".",",")}}</td>
                            <td>{{number_format($value->subtotalnew,0,".",",")}}</td>
                            <td>{{number_format($value->totalnew,0,".",",")}}</td>
                        </tr>
                        <?php
                    }
                    $subtotal += $subtotalnew;
                    $total += $totalnew;
                    ?>
                    <tr align="center">
                        <td colspan="5"><b>Total {{$val[0]->responsible}}</b></td>
                        <td><b>$ {{number_format($subtotalnew,0,".",",")}}</b></td>
                        <td><b>$ {{number_format($totalnew,0,".",",")}}</b></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="7"></td>
                </tr>
                <tr>
                    <td colspan="5" align="right" ><b>Total General</b></td>
                    <td  align="center"><b>$ {{number_format($subtotal,0,".",",")}}</b></td>
                    <td  align="center"><b>$ {{number_format($total,0,".",",")}}</b></td>
                </tr>
                <?php
            }
            ?>
    </body>

</table>


<br>
<table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
    <tr>
        <td colspan="2"><h4>Pedidos nuevos</h4>
        </td>
    </tr>
</table>
<table class="detailnew" align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
    <thead>
        <tr>
            <th># pedido</th>
            <th>Comercial</th>
            <th>Cliente</th>
            <th>Iva 5%</th>
            <th>Iva 19%</th>
            <th>Subtotal</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($arrnew)) {
            $total = 0;
            $subtotal = 0;
            foreach ($arrnew as $val) {
                $totalnew = 0;
                $subtotalnew = 0;
                foreach ($val as $value) {
                    $totalnew += $value->totalnew;
                    $subtotalnew += $value->subtotalnew
                    ?>
                    <tr align="center">
                        <td>{{$value->id}}</td>
                        <td>{{$value->responsible}}</td>
                        <td>{{$value->client}}</td>
                        <td>{{number_format($value->tax5new,0,".",",")}}</td>
                        <td>{{number_format($value->tax19new,0,".",",")}}</td>
                        <td>{{number_format($value->subtotalnew,0,".",",")}}</td>
                        <td>{{number_format($value->totalnew,0,".",",")}}</td>
                    </tr>
                    <?php
                }
                $subtotal += $subtotalnew;
                $total += $totalnew;
                ?>
                <tr align="center">
                    <td colspan="5" ><b>Total {{$val[0]->responsible}}</b></td>
                    <td><b>$ {{number_format($subtotalnew,0,".",",")}}</b></td>
                    <td><b>$ {{number_format($totalnew,0,".",",")}}</b></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="7"></td>
            </tr>
            <tr >
                <td colspan="5" align="right"><b>Total General</b></td>
                <td align="center"><b>$ {{number_format($subtotal,0,".",",")}}</b></td>
                <td align="center"><b>$ {{number_format($total,0,".",",")}}</b></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<br>
<table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
    <tr>
        <td colspan="2"><h4>Cartera desde ({{date("Y-m")}}-01) hasta ({{date("Y-m-d")}})</h4></td>
        </td>
    </tr>
</table>
<table class="detailpay" align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
    <thead>
        <tr>
            <th># de Facturas</th>
            <th>Facturado</th>
            <th>Cartera Recuperada</th>
        </tr>
    <tbody>
        <tr align="center">
            <td>{{$briefcase->invoices}}</td>
            <td>{{number_format($briefcase->total,0,".",",")}}</td>
            <td>{{number_format($briefcase->cartera,0,".",",")}}</td>
        </tr>
    </tbody>
</tbody>
</table>
<br>

<table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
    <tr>
        <td colspan="2"><h4>Ventas desde ({{date("Y-m")}}-01) hasta ({{date("Y-m-d")}})</h4></td>
    </tr>
</table>
<br>

<table class="detailsales" align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
    <thead>
        <tr>
            <th># de Facturas</th>
            <th>Iva 5%</th>
            <th>Iva 19%</th>
            <th>Subtotal</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr align="center">
            <td>{{$overview->invoices}}</td>
            <td>{{number_format($overview->tax5,0,".",",")}}</td>
            <td>{{number_format($overview->tax19,0,".",",")}}</td>
            <td>{{number_format($overview->subtotalnumeric,0,".",",")}}</td>
            <td>{{number_format($overview->total,0,".",",")}}</td>
        </tr>
    </tbody>
</table>

</body>
</html>

