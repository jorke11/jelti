<html>
    <head>
        <title>Pago</title>
        <style type="text/css">
            .detail {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}
            .detail th {font-size: 13px;font-weight: normal;padding: 8px;background: #00b065;border-top: 4px solid #aabcfe;border-bottom: 1px solid #fff; color: #039;color:white;}
            .detail tbody td {padding: 8px;background: #f9f9f9;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
            .footer tbody td {padding: 8px;background: white;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
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
        <table align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <tr>
                <td width='15%'><img src="{!!asset('assets/images/logo.png')!!}" width="45" style="display:block"></td>
                <td width='60%'>¡Hola! Feliz día</td>
                <td><strong></strong><br></td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td colspan="2">Se generó un pago de: (<b>{{(isset($client))?$client:''}}</b>) asociado a:  <b>{{(isset($responsible))?$responsible:''}}</b> 
                </td>
            </tr>
        </table>
        <br>
        <table class="detail" align="center" width="850" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <thead>
                <tr>
                    <th>Factura</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>

                @if(isset($detail))
                @foreach($detail as $val)
                <tr>
                    <td align="center" >{{$val->invoice}}</td>
                    <td align="center">{{number_format($val->value,0,".",",")}}</td>
                </tr>

                @endforeach
                <tr>
                    <td align="center"><b>SubTotal</b></td>
                    <td align="center">{{(isset($subtotal))?$subtotal:0}}</td>
                </tr>
                @endif
                </body>
        </table>
    </body>
</html>

