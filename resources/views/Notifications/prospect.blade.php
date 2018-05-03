<html>
    <head>
        <title>Order</title>
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
                <td width="20%"><img src="{!!asset('assets/images/logo.png')!!}" width="45" style="display:block"></td>
                <td>¡Hola! Feliz día</td>
            </tr>
            <tr>
                <td><br></td>
            </tr>
            <tr>
                <td colspan="2">Registro Nuevo desde pagina web</td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr style="border-spacing: 5px;">
                <td>Tipo </td>
                <td>(<b>{{(isset($type))?$type:''}}</b>)</td>
            </tr>
            <tr style="border-spacing: 5px;">
                <td>Empresa </td>
                <td>(<b>{{(isset($business))?$business:''}}</b>)</td>
            </tr>
            <tr>
                <td>Contacto </td>
                <td>(<b>{{(isset($name))?$name:''}} {{(isset($last_name))?$last_name:''}}</b>)</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>(<b>{{(isset($email))?$email:''}}</b>)</td>
            </tr>
            <tr>
                <td>Telefono</td>
                <td>(<b>{{(isset($phone))?$phone:''}}</b>)</td>
            </tr>

        </table>
    </body>
</html>

