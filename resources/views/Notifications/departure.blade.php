<html>
    <head>
        <title>Document</title>
        <style type="text/css">
            #detail {font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;font-size: 12px;border-collapse: collapse;}

            #detail th {font-size: 13px;font-weight: normal;padding: 8px;background: #00b065;border-top: 4px solid #aabcfe;border-bottom: 1px solid #fff; color: #039;color:white;}

            #detail tbody td {padding: 8px;background: #f9f9f9;border-bottom: 1px solid #fff;color: #669;border-top: 1px solid transparent;}
        </style>
    </head>

    <body>
        <table align="center" width="700" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <tr>
                <td><img src="{!!asset('assets/images/logo.png')!!}" width="100" style="display:block"></td>
                <td>¡Hola! Feliz día</td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td colspan="2">Se generó una peticion por parte de <b>{{$name}} {{$last_name}} <strong>Solicitud {!!$id!!}</strong></td>
            </tr>
        </table>
        <br>
        <table id="detail" align="center" width="700" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <thead>
                <tr>
                    <th>EAN</th>
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
                    <td>{{$val->bar_code}}</td>
                    <td>{{$val->product}}</td>
                    <td>{{$val->quantity}}</td>
                    <td>{{$val->units_sf}}</td>
                    <td>{{$val->units_sf * $val->quantity}}</td>
                    <td>{{$val->valueFormated}}</td>
                    <td>{{$val->totalFormated}}</td>
                </tr>

                @endforeach
                </body>
        </table>
        <table align="center" width="700" align="center" id="main"  border="0" cellspacing="0"cellpadding="0">
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td>Bodega Salida: {!!$warehouse!!}</td>
            </tr>
            <tr>
                <td>Saludos</td>
            </tr>
        </table>
    </body>
</html>

